<?php

namespace App\Livewire;

use App\Models\PassengerType;
use Livewire\Component;

class PassengerTypes extends Component
{
    public $passenger_types, $type, $pricing, $passenger_type_id;
    public $isOpen = false;

    public function render()
    {
        $this->passenger_types = PassengerType::all();
        return view('livewire.passenger-types');
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
        $this->type = '';
        $this->pricing = '';
        $this->passenger_type_id = null;
    }

    public function store()
    {
        $data = $this->validate([
            'type' => 'required|string|max:255|unique:passenger_types,type,' . $this->passenger_type_id,
            'pricing' => 'required|numeric|min:0',
        ]);

        PassengerType::updateOrCreate(['id' => $this->passenger_type_id], $data);

        session()->flash('message', $this->passenger_type_id ? 'Passenger Type Updated Successfully.' : 'Passenger Type Created Successfully.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $passenger_type = PassengerType::findOrFail($id);
        $this->passenger_type_id = $id;
        $this->type = $passenger_type->type;
        $this->pricing = $passenger_type->pricing;
        $this->openModal();
    }

    public function delete($id)
    {
        PassengerType::find($id)->delete();
        session()->flash('message', 'Passenger Type Deleted Successfully.');
    }
}
