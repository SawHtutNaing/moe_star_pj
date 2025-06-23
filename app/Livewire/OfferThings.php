<?php

namespace App\Livewire;

use App\Models\OfferThing;
use Livewire\Component;

class OfferThings extends Component
{
    public $offer_things, $name, $pricing, $is_active = false, $offer_thing_id;
    public $isOpen = false;

    public function render()
    {
        $this->offer_things = OfferThing::all();
        return view('livewire.offer-things');
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
        $this->pricing = '';
        $this->is_active = false;
        $this->offer_thing_id = null;
    }

    public function store()
    {
        $data = $this->validate([
            'name' => 'required|string|max:255',
            'pricing' => 'required|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        OfferThing::updateOrCreate(['id' => $this->offer_thing_id], $data);

        session()->flash('message', $this->offer_thing_id ? 'Offer Thing Updated Successfully.' : 'Offer Thing Created Successfully.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $offer_thing = OfferThing::findOrFail($id);
        $this->offer_thing_id = $id;
        $this->name = $offer_thing->name;
        $this->pricing = $offer_thing->pricing;
        $this->is_active = $offer_thing->is_active;
        $this->openModal();
    }

    public function delete($id)
    {
        OfferThing::find($id)->delete();
        session()->flash('message', 'Offer Thing Deleted Successfully.');
    }
}
