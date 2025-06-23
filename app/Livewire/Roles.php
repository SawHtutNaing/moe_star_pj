<?php

namespace App\Livewire;

use App\Models\Role;
use Livewire\Component;

class Roles extends Component
{
    public $roles, $name, $role_id;
    public $isOpen = false;

    public function render()
    {
        $this->roles = Role::all();
        return view('livewire.roles');
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
        $this->role_id = null;
    }

    public function store()
    {
        $data = $this->validate([
            'name' => 'required|string|max:255',
        ]);

        Role::updateOrCreate(['id' => $this->role_id], $data);

        session()->flash('message', $this->role_id ? 'Role Updated Successfully.' : 'Role Created Successfully.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $this->role_id = $id;
        $this->name = $role->name;
        $this->openModal();
    }

    public function delete($id)
    {
        Role::find($id)->delete();
        session()->flash('message', 'Role Deleted Successfully.');
    }
}
