<?php

namespace App\Livewire;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Productlist extends Component
{
    public Category $category;
    public $products;
    public $searchName, $searchSize = "0";


    public function resetFilterFields()
    {
        $this->searchName = '';
        $this->searchSize = '0';
    }

    public function AddToCart(Product $product)
    {
        $edited = Cart::where('user_id', Auth::user()->id)->where('product_id', $product->id);
        $quantity = $edited->value('quantity');
        if ($quantity > 0) {
            $quantity += 1;
            $edited->update(['quantity' => $quantity]);
        } else {
            Cart::Create([
                'user_id' => Auth()->user()->id,
                'product_id' => $product->id,
                'quantity' => 1
            ]);
        }
        session()->flash('message', 'Товар "' . $product->name . '" добавлен в корзину');
        $this->dispatch('cart-created');
    }

    public function mount($category = null)
    {
        $this->category = $category;
    }
    public function render()
    {
        $searchName = '%' . $this->searchName . '%';
        if ($this->searchSize == "0") $searchSize = '%%';
        else $searchSize = $this->searchSize;


        $this->products = Product::where('category_id', $this->category->id)->
                                    where('name', 'like', $searchName)->
                                    where('size', 'like', $searchSize)->orderBy('name')->get();
        return view('livewire.productlist');
    }
}
