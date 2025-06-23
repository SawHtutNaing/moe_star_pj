<?php

namespace App\Livewire;

use App\Models\Driver;
use Livewire\Component;

class Drivers extends Component
{
    public $drivers, $name, $nrc_number, $driver_id;
    public $isOpen = false;

    public function render()
    {
        $this->drivers = Driver::all();
        return view('livewire.drivers');
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
        $this->nrc_number = '';
        $this->driver_id = null;
    }

    public function store()
    {
        $data = $this->validate([
            'name' => 'required|string|max:255',
            'nrc_number' => 'required|string|max:255',
        ]);

        Driver::updateOrCreate(['id' => $this->driver_id], $data);

        session()->flash('message', $this->driver_id ? 'Driver Updated Successfully.' : 'Driver Created Successfully.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $driver = Driver::findOrFail($id);
        $this->driver_id = $id;
        $this->name = $driver->name;
        $this->nrc_number = $driver->nrc_number;
        $this->openModal();
    }

    public function delete($id)
    {
        Driver::find($id)->delete();
        session()->flash('message', 'Driver Deleted Successfully.');
    }
}
