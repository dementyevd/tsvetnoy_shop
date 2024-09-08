<?php

namespace App\Livewire;

use App\Models\Category as ModelsCategory;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Category extends Component
{
    use WithFileUploads;
    public $name, $image, $description, $categories, $category_id;

    private function resetInputFields()
    {
        $this->name = '';
        $this->image = '';
        $this->description = '';
        $this->category_id = null;
    }

    public function save()
    {
        $validated = $this->validate([
            'name' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpg,jpeg,png,svg|max:2048',
        ]);
        $imageName = time() . "_" . $this->image->getClientOriginalName();
        $validated['image'] = $this->image->storeAs(path: 'images', name: $imageName);

        if ($this->category_id == null) {
            ModelsCategory::create($validated);
            session()->flash('message', 'Категория успешно добавлена');
        } else {
            $edited = ModelsCategory::find($this->category_id);
            Storage::delete($edited->image);
            $edited->update($validated);
            session()->flash('message', 'Категория успешно обновлена');
        }

        $this->resetInputFields();
    }

    public function edit($id)
    {
        $edited = ModelsCategory::find($id);
        $this->category_id = $edited->id;
        $this->name = $edited->name;
        $this->description = $edited->description;
    }

    public function delete($id)
    {
        $deleted = ModelsCategory::find($id);
        Storage::delete($deleted->image);
        if ($deleted->Products) {
            foreach ($deleted->Products as $item) {
                foreach ($item->Images as $itemImage) {
                    Storage::delete($itemImage->image);
                }
            }
        }
        $deleted->delete();
        session()->flash('message', 'Категория успешно удалена');
    }

    public function render()
    {
        $this->categories = ModelsCategory::all();
        return view('livewire.category');
    }
}
