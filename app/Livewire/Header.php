<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Cart;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class Header extends Component
{
    public $quantity;
    public $visibility = false;
    public $categorylist;

    #[On('cart-created')]
    public function CalcQuantity()
    {
        if (Auth::check()) {
            $this->quantity = Cart::where('user_id', Auth::user()->id)->sum('quantity');
            if ($this->quantity > 0)
                $this->visibility = true;
        }
    }

    public function ShowProducts(Category $category)
    {
        $this->redirectRoute('productlist', ['category' => $category]);        
    }

    public function render()
    {
        $this->CalcQuantity();
        $this->categorylist = Category::all();
        return view('livewire.header');
    }
}
