<?php

namespace App\Livewire;

use App\Models\CarGate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class CarGates extends Component
{
    use WithFileUploads;

    public $car_gates, $name, $image, $car_gate_id;
    public $isOpen = false;

    public function render()
    {
        $this->car_gates = CarGate::all();
        return view('livewire.car-gates');
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
        $this->name = '';
        $this->image = null;
        $this->car_gate_id = null;
    }

    public function store()
    {
        $data = $this->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($this->image) {
            $data['image'] = $this->image->store('car_gates', 'public');
        }

        CarGate::updateOrCreate(['id' => $this->car_gate_id], $data);

        session()->flash('message', $this->car_gate_id ? 'Car Gate Updated Successfully.' : 'Car Gate Created Successfully.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $car_gate = CarGate::findOrFail($id);
        $this->car_gate_id = $id;
        $this->name = $car_gate->name;
        $this->openModal();
    }

    public function delete($id)
    {
        $car_gate = CarGate::find($id);
        if ($car_gate->image) {
            Storage::disk('public')->delete($car_gate->image);
        }
        $car_gate->delete();
        session()->flash('message', 'Car Gate Deleted Successfully.');
    }
}
