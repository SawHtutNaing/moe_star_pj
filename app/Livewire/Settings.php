<?php

namespace App\Livewire;

use App\Models\Setting;
use Livewire\Component;

class Settings extends Component
{
    public $settings, $name, $value, $setting_id;
    public $isOpen = false;

    public function render()
    {
        $this->settings = Setting::all();
        return view('livewire.settings');
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
        $this->value = '';
        $this->setting_id = null;
    }

    public function store()
    {
        $data = $this->validate([
            'name' => 'required|string|max:255|unique:settings,name,' . $this->setting_id,
            'value' => 'required|string|max:255',
        ]);

        Setting::updateOrCreate(['id' => $this->setting_id], $data);

        session()->flash('message', $this->setting_id ? 'Setting Updated Successfully.' : 'Setting Created Successfully.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $setting = Setting::findOrFail($id);
        $this->setting_id = $id;
        $this->name = $setting->name;
        $this->value = $setting->value;
        $this->openModal();
    }

    public function delete($id)
    {
        Setting::find($id)->delete();
        session()->flash('message', 'Setting Deleted Successfully.');
    }
}
