<?php

namespace App\Livewire;

use App\Models\CarGate;
use App\Models\Driver;
use App\Models\Car;
use App\Models\Trip;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Component;

class Trips extends Component
{
    public $trips, $start_time, $start_car_gate, $end_gate, $driver_id, $car_id, $fee_for_driver, $car_oil_pricing, $fee_for_bridge_pass, $fee_for_gate_pass, $deductions = [], $trip_id;
    public $isOpen = false, $isDeductionModalOpen = false;
    public $deduction_reason, $deduction_amount;
    public $car_gates, $drivers, $cars;

    public function mount()
    {
        $this->car_gates = CarGate::all();
        $this->drivers = Driver::all();
        $this->cars = Car::all();
    }

    public function render()
    {
        $this->trips = Trip::with('passengers', 'driver', 'car')->get();
        return view('livewire.trips');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function openDeductionModal()
    {
        $this->deduction_reason = '';
        $this->deduction_amount = '';
        $this->isDeductionModalOpen = true;
    }

    public function closeDeductionModal()
    {
        $this->isDeductionModalOpen = false;
    }

    private function resetInputFields()
    {
        $this->start_time = '';
        $this->start_car_gate = '';
        $this->end_gate = '';
        $this->driver_id = '';
        $this->car_id = '';
        $this->fee_for_driver = '';
        $this->car_oil_pricing = '';
        $this->fee_for_bridge_pass = '';
        $this->fee_for_gate_pass = '';
        $this->deductions = [];
        $this->trip_id = null;
    }

    public function addDeduction()
    {
        $this->validate([
            'deduction_reason' => 'required|string|max:255',
            'deduction_amount' => 'required|numeric|min:0',
        ]);

        $this->deductions[] = [
            'reason' => mb_convert_encoding($this->deduction_reason, 'UTF-8', 'auto'),
            'amount' => $this->deduction_amount,
        ];

        $this->closeDeductionModal();
    }

    public function removeDeduction($index)
    {
        unset($this->deductions[$index]);
        $this->deductions = array_values($this->deductions);
    }

    public function store()
    {
        $data = $this->validate([
            'start_time' => 'required|date',
            'start_car_gate' => 'required|string|max:255',
            'end_gate' => 'required|string|max:255',
            'driver_id' => 'required|exists:drivers,id',
            'car_id' => 'required|exists:cars,id',
            'fee_for_driver' => 'required|numeric|min:0',
            'car_oil_pricing' => 'required|numeric|min:0',
            'fee_for_bridge_pass' => 'required|numeric|min:0',
            'fee_for_gate_pass' => 'required|numeric|min:0',
            'deductions' => 'nullable|array',
            'deductions.*.reason' => 'required|string|max:255',
            'deductions.*.amount' => 'required|numeric|min:0',
        ]);

        // Sanitize text inputs to prevent UTF-8 errors
        $data['start_car_gate'] = mb_convert_encoding($data['start_car_gate'], 'UTF-8', 'auto');
        $data['end_gate'] = mb_convert_encoding($data['end_gate'], 'UTF-8', 'auto');
        $data['deductions'] = array_map(function ($deduction) {
            $deduction['reason'] = mb_convert_encoding($deduction['reason'], 'UTF-8', 'auto');
            return $deduction;
        }, $data['deductions'] ?? []);
        $data['deductions'] = $data['deductions'];

        Trip::updateOrCreate(['id' => $this->trip_id], $data);

        session()->flash('message', $this->trip_id ? 'Trip Updated Successfully.' : 'Trip Created Successfully.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $trip = Trip::findOrFail($id);
        $this->trip_id = $id;
        $this->start_time = $trip->start_time->format('Y-m-d\TH:i');
        $this->start_car_gate = $trip->start_car_gate;
        $this->end_gate = $trip->end_gate;
        $this->driver_id = $trip->driver_id;
        $this->car_id = $trip->car_id;
        $this->fee_for_driver = $trip->fee_for_driver;
        $this->car_oil_pricing = $trip->car_oil_pricing;
        $this->fee_for_bridge_pass = $trip->fee_for_bridge_pass;
        $this->fee_for_gate_pass = $trip->fee_for_gate_pass;
        $this->deductions = $trip->deductions;
        $this->openModal();
    }

    public function delete($id)
    {
        Trip::find($id)->delete();
        session()->flash('message', 'Trip Deleted Successfully.');
    }

    public function exportVoucher($id)
    {
        $trip = Trip::with(['passengers', 'driver', 'car'])->findOrFail($id);

        // Sanitize text fields to prevent UTF-8 errors
        $trip->start_car_gate = mb_convert_encoding($trip->start_car_gate, 'UTF-8', 'auto');
        $trip->end_gate = mb_convert_encoding($trip->end_gate, 'UTF-8', 'auto');
        $deductions = $trip->deductions;
        $trip->deductions = array_map(function ($deduction) {
            $deduction['reason'] = mb_convert_encoding($deduction['reason'], 'UTF-8', 'auto');
            return $deduction;
        }, $deductions);

    $pdf = Pdf::loadView('vouchers.trip-voucher', compact('trip'));
      return response()->streamDownload(function () use ($pdf) {
        echo $pdf->stream();
    }, 'voucher_trip_' . $trip->id . '.pdf');

    }
}
