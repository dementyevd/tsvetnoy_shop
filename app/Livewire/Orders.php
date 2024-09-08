<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Orders extends Component
{
    public $myOrders;
    public function render()
    {
        $this->myOrders = Order::where('user_id', Auth::user()->id)->orderBy('orderdate', 'desc')->get();
        return view('livewire.orders');
    }
}
