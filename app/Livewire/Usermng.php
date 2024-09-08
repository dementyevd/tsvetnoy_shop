<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class Usermng extends Component
{
    public $users, $name, $password, $role;

    public function delete($id)
    {
        $deleted = User::find($id);       
        $deleted->delete();
        session()->flash('message', 'Пользователь успешно удален');
    }

    public function render()
    {
        $this->users=User::all();
        return view('livewire.usermng');
    }
}
