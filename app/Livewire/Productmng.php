<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class Productmng extends Component
{
    use WithFileUploads;
    public $products, $name, $size, $price, $remains, $category_id, $categorylist, $product_id, $external_id;
    public $searchName, $searchSize = "0", $searchCategory = "0";

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
        $this->external_id = null;
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
        $this->external_id = $edited->external_id;
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
            'external_id' => 'required',
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

    public function getRemains()
    {
        $tok = json_decode($this->getToken());
        $stocks = json_decode($this->getStock($tok->access_token));
        if (count($stocks->rows) == 0) {
            foreach (Product::all() as $product) {
                $product->remains = 0;
                $product->save();
            }
        } else {
            foreach ($stocks->rows as $row) {
                $product = Product::where('external_id', $row->product_id)->get();
                $product->remains = $row->stock;
                $product->save();
            }
        }
        session()->flash('message', 'Остатки обновлены!');
    }

    public function getToken()
    {
        $response = Http::withBasicAuth('dementevamv@shalom', 'MVDementeva2020')->withHeader('Accept-Encoding', 'gzip')->accept('application/json;charset=utf-8')->post('https://api.moysklad.ru/api/remap/1.2/security/token');
        return $response;
    }

    public function getStock($token)
    {
        $response = Http::withToken($token)->withHeader('Accept-Encoding', 'gzip')->accept('application/json;charset=utf-8')->get('https://api.moysklad.ru/api/remap/1.2/report/stock/bystore');
        return $response;
    }

    public function render()
    {
        $searchName = '%' . $this->searchName . '%';

        if ($this->searchSize == "0") $searchSize = '%%';
        else $searchSize = $this->searchSize;

        if ($this->searchCategory == "0") $searchCategory = '%%';
        else $searchCategory = $this->searchCategory;

        $this->categorylist = Category::all();
        $this->products = Product::where('name', 'like', $searchName)
            ->where('size', 'like', $searchSize)
            ->where('category_id', 'like', $searchCategory)
            ->orderBy('name')->get();
        return view('livewire.productmng');
    }
}
