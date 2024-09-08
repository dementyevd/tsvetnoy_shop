<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;

class Footer extends Component
{
    public $categorylist;

    public function ShowProducts(Category $category)
    {
        $this->redirectRoute('productlist', ['category' => $category]);        
    }

    public function render()
    {
        $this->categorylist = Category::all();
        return view('livewire.footer');
    }
}
