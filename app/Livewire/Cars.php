<?php

namespace App\Livewire;

use App\Models\Car;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Cars extends Component
{
    use WithFileUploads;

    public $cars, $name, $image, $car_id;
    public $isOpen = false;

    public function render()
    {
        $this->cars = Car::all();
        return view('livewire.cars');
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
        $this->car_id = null;
    }

    public function store()
    {
        $data = $this->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($this->image) {
            $data['image'] = $this->image->store('cars', 'public');
        }

        Car::updateOrCreate(['id' => $this->car_id], $data);

        session()->flash('message', $this->car_id ? 'Car Updated Successfully.' : 'Car Created Successfully.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $car = Car::findOrFail($id);
        $this->car_id = $id;
        $this->name = $car->name;
        $this->openModal();
    }

    public function delete($id)
    {
        $car = Car::find($id);
        if ($car->image) {
            Storage::disk('public')->delete($car->image);
        }
        $car->delete();
        session()->flash('message', 'Car Deleted Successfully.');
    }
}
