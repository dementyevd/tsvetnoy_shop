<?php

namespace App\Livewire;

use App\Models\Cart as ModelsCart;
use App\Models\Order;
use App\Models\Orderline;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Cart extends Component
{
    public $products;
    public $totalsum;

    public function Decrease(ModelsCart $cart)
    {
        if ($cart->quantity > 0) {
            $cart->update(['quantity' => $cart->quantity - 1]);
            $this->CalcSum();
        }
    }

    public function Increase(ModelsCart $cart)
    {
        $cart->update(['quantity' => $cart->quantity + 1]);
        $this->CalcSum();
    }

    public function Delete(ModelsCart $cart)
    {
        ModelsCart::destroy($cart->id);
        $this->CalcSum();
    }

    public function MakeOrder()
    {
        if (count($this->products) > 0) {
            foreach ($this->products as $item) {
                if ($item->quantity > $item->Product->remains) {
                    session()->flash('message', 'Товара "' . $item->Product->name . '" недостаточно для оформления заказа');
                    return;
                }
            }

            $newOrder = Order::Create([
                'user_id' => Auth::user()->id,
                'orderdate' => Carbon::now(),
                'totalsum' => $this->totalsum
            ]);

            foreach ($this->products as $item) {
                Orderline::Create([
                    'order_id' => $newOrder->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity
                ]);
            }

            foreach ($this->products as $item) {
                $item->Product->update(['remains' => $item->Product->remains - 1]);
                ModelsCart::destroy($item->id);
            }

            $this->redirectRoute('myOrders');
        } else {
            session()->flash('message', 'Корзина пуста!');
        }
    }

    public function CalcSum()
    {
        $this->totalsum = 0;
        $products = ModelsCart::where('user_id', Auth::user()->id)->get();
        foreach ($products as $cartitem) {
            $this->totalsum += ($cartitem->quantity * $cartitem->Product->price);
        }
    }

    public function render()
    {
        $this->CalcSum();
        $this->products = ModelsCart::where('user_id', Auth::user()->id)->get();
        return view('livewire.cart');
    }
}
