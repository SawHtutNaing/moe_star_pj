<?php

namespace App\Livewire;

use App\Models\OfferThing;
use App\Models\Passenger;
use App\Models\PassengerType;
use App\Models\Trip;
use Livewire\Component;

class PassengerList extends Component
{
    public $trip;
    public $passenger_name, $passenger_phone, $passenger_nrc, $passenger_type_id, $offer_thing_ids = [], $car_front_cabin = false, $passenger_id;
    public $isOpen = false;
    public $passenger_types, $offer_things;

    public function mount($tripId)
    {
        $this->trip = Trip::with('passengers')->findOrFail($tripId);
        $this->passenger_types = PassengerType::all();
        $this->offer_things = OfferThing::where('is_active', true)->get();
    }

    public function render()
    {
        return view('livewire.passenger-list')->layout('layouts.app');
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

    private function resetInputFields()
    {
        $this->passenger_id = null;
        $this->passenger_name = '';
        $this->passenger_phone = '';
        $this->passenger_nrc = '';
        $this->passenger_type_id = '';
        $this->offer_thing_ids = [];
        $this->car_front_cabin = false;
    }

    public function store()
    {
        $data = $this->validate([
            'passenger_name' => 'required|string|max:255',
            'passenger_phone' => 'required|string|max:255',
            'passenger_nrc' => 'required|string|max:255',
            'passenger_type_id' => 'required|exists:passenger_types,id',
            'offer_thing_ids' => 'nullable|array',
            'offer_thing_ids.*' => 'exists:offer_things,id',
            'car_front_cabin' => 'boolean',
        ]);

        // Validate that only one passenger per trip can have car_front_cabin
        if ($data['car_front_cabin']) {
            $existing = Passenger::where('trip_id', $this->trip->id)
                ->where('car_front_cabin', true)
                ->where('id', '!=', $this->passenger_id)
                ->exists();
            if ($existing) {
                $this->addError('car_front_cabin', 'Only one passenger per trip can be in the front cabin.');
                return;
            }
        }

        $passenger_type = PassengerType::find($data['passenger_type_id']);
        $offer_things = OfferThing::whereIn('id', $data['offer_thing_ids'])->get()->map(function ($item) {
            return ['id' => $item->id, 'name' => $item->name, 'pricing' => $item->pricing];
        })->toArray();

        $data['trip_id'] = $this->trip->id;
        $data['passenger_type'] = $passenger_type->type;
        $data['passenger_type_pricing'] = $passenger_type->pricing;
        $data['offer_things'] = json_encode($offer_things);

        Passenger::updateOrCreate(['id' => $this->passenger_id], $data);

        session()->flash('message', $this->passenger_id ? 'Passenger Updated Successfully.' : 'Passenger Added Successfully.');

        $this->closeModal();
        $this->resetInputFields();
        $this->trip = Trip::with('passengers')->findOrFail($this->trip->id);
    }

    public function edit($id)
    {
        $passenger = Passenger::findOrFail($id);
        $this->passenger_id = $id;
        $this->passenger_name = $passenger->passenger_name;
        $this->passenger_phone = $passenger->passenger_phone;
        $this->passenger_nrc = $passenger->passenger_nrc;
        $this->passenger_type_id = PassengerType::where('type', $passenger->passenger_type)->first()->id;
        $this->offer_thing_ids = collect(json_decode($passenger->offer_things, true))->pluck('id')->toArray();
        $this->car_front_cabin = $passenger->car_front_cabin;
        $this->openModal();
    }

    public function deletePassenger($id)
    {
        Passenger::find($id)->delete();
        $this->trip = Trip::with('passengers')->findOrFail($this->trip->id);
        session()->flash('message', 'Passenger Deleted Successfully.');
    }
}
