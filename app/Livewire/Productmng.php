<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Storage;

class Productmng extends Component
{
    use WithFileUploads;
    public $products, $name, $size, $price, $remains, $category_id, $categorylist, $product_id;
    public $searchName, $searchSize = "0", $searchCategory = "0";

    // #[Validate(['images.*' => 'required|image|max:1024'])]
    public $images = [];

    public function resetFilterFields()
    {
        $this->searchName = '';
        $this->searchSize = '0';
        $this->searchCategory = '0';
    }

    public function resetInputFields()
    {
        $this->name = '';
        $this->size = 0;
        $this->price = '';
        $this->remains = '';
        $this->category_id = 0;
        $this->images = null;
        $this->product_id = null;
    }

    public function edit($id)
    {
        $edited = Product::find($id);
        $this->product_id = $edited->id;
        $this->name = $edited->name;
        $this->size = $edited->size;
        $this->price = $edited->price;
        $this->remains = $edited->remains;
        $this->category_id = $edited->Category->name;
    }

    public function delete($id)
    {
        $deleted = Product::find($id);
        $deletedimages = $deleted->images;
        foreach ($deletedimages as $item) {
            Storage::delete($item->image);
        }
        $deleted->delete();
        session()->flash('message', 'Товар успешно удален');
    }

    public function save()
    {
        $validated = $this->validate([
            'name' => 'required',
            'size' => 'required',
            'price' => 'required',
            'remains' => 'required',
            'category_id' => 'required',
            'images.*' => 'required|image|mimes:jpg,jpeg,png,svg',
        ]);

        $category_id = Category::where('name', $this->category_id)->value('id');
        $validated['category_id'] = $category_id;

        if ($this->product_id == null) {
            $model = Product::create($validated);
            foreach ($this->images as $image) {
                $imageName = time() . "_" . $image->getClientOriginalName();
                $imagepath = $image->storeAs(path: 'images', name: $imageName);
                Image::create(['product_id' => $model->id, 'image' => $imagepath]);
            }
            session()->flash('message', 'Товар успешно добавлен');
        } else {
            $edited = Product::find($this->product_id);
            $deletedimages = $edited->images;
            foreach ($deletedimages as $item) {
                Storage::delete($item->image);
                Image::destroy($item->id);
            }
            foreach ($this->images as $image) {
                $imageName = time() . "_" . $image->getClientOriginalName();
                $imagepath = $image->storeAs(path: 'images', name: $imageName);
                Image::create(['product_id' => $edited->id, 'image' => $imagepath]);
            }
            $edited->update($validated);
            session()->flash('message', 'Товар успешно обновлен');
        }

        $this->resetInputFields();
    }

    public function render()
    {
        $searchName = '%' . $this->searchName . '%';

        if ($this->searchSize == "0") $searchSize = '%%';
        else $searchSize = $this->searchSize;

        if ($this->searchCategory == "0") $searchCategory = '%%';
        else $searchCategory = $this->searchCategory;

        // $this->categorylist = Category::all()->pluck('name');
        $this->categorylist = Category::all();
        $this->products = Product::where('name', 'like', $searchName)
            ->where('size', 'like', $searchSize)
            ->where('category_id', 'like', $searchCategory)
            ->orderBy('name')->get();
        return view('livewire.productmng');
    }
}
