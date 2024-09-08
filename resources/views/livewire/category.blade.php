<div>    
    <form wire:submit.prevent="save">
  
        <div>
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
        </div>
        <h2>Категории товаров</h2>
        <div class="form-group my-3">
            <input type="text" class="form-control" placeholder="Введите название категории" wire:model="name">
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="form-group my-3">
            <input type="text" class="form-control" placeholder="Введите описание категории" wire:model="description">
            @error('description') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <input type="file" class="form-control" wire:model="image">
            @error('image') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
      
        <button type="submit" class="btn btn-primary my-3">Сохранить</button>
    </form>
    
    <table class="table table-bordered mt-5">
        <thead>
            <tr>
                <th>Наименование</th>
                <th>Описание</th>
                <th>Картинка</th>
                <th width="200px">Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $item)
                <tr>
                    <td>{{$item->name}}</td>
                    <td>{{$item->description}}</td>
                    <td><img src="{{url($item->image)}}" alt="{{$item->name}}" class="img-fluid mx-auto d-block" width="100" height="100"></td>
                    <td>
                        <button class="btn btn-warning btn-sm" wire:click="edit({{$item->id}})">Изменить</button>
                        <button class="btn btn-danger btn-sm" wire:click="delete({{$item->id}})">Удалить</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>


