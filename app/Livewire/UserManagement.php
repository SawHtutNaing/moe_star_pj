<?php
namespace App\Livewire;
use Livewire\Component;
use App\Models\User;

class UserManagement extends Component
{
    public $users;

    // protected $listeners = [
    //     'userUpdated' => '$refresh',
    // ];

    public function mount()
    {
        $this->users = User::all();
        if(auth()->user()->role != 'admin'){
            return redirect()->route('dashboard');
        }

    }

    public function toggleStatus(User $user)
    {
        $user->status = !$user->status;
        $user->save();
        $this->users = User::all();
    }

    public function render()
    {
        return view('livewire.user-management');
    }
}
