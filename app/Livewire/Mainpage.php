<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;

class Mainpage extends Component
{
    public $categoryList;

    public function ShowProducts(Category $category)
    {
        $this->redirectRoute('productlist', ['category' => $category]);        
    }

    public function render()
    {
        $this->categoryList = Category::all();
        return view('livewire.mainpage');
    }
}
