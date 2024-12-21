<div>
    <form wire:submit.prevent="save">
  
        <div>
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
        </div>
        <div class="my-3">
            <button class="btn btn-primary" wire:click.prevent="getRemains">Загрузить остатки</button>
        </div>
        <h2>Список товаров</h2>
        <div class="form-group my-3">
            <input type="text" class="form-control" placeholder="Введите название товара" wire:model="name">
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="form-group my-3">
            <select class="form-control" wire:model="category_id">
                <option selected hidden value="0">Выберите категорию товара</option>
                @foreach ($categorylist as $item)
                    <option value="{{$item->name}}">{{$item->name}}</option>
                @endforeach
            </select>
            @error('category_id') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <input type="file" class="form-control" wire:model="images" multiple>
            @error('images') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="form-group my-3">
            <select class="form-control" wire:model="size">
                <option selected hidden value="0">Выберите размер</option>
                <option value="20x30">20x30</option>
                <option value="30x40">30x40</option>
                <option value="40x50">40x50</option>
                <option value="50x65">50x65</option>
                <option value="Другое">Другое</option>
            </select>
            @error('size') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="form-group my-3">
            <input type="number" step="0.1" class="form-control" placeholder="Укажите цену" wire:model="price">
            @error('price') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="form-group my-3">
            <input type="number" class="form-control" placeholder="Укажите остаток" wire:model="remains">
            @error('remains') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="form-group my-3">
            <input type="text" class="form-control" placeholder="Укажите GUID из МойСклад" wire:model="external_id">
            @error('external_id') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
      
        <div class="d-flex">
            <button type="submit" class="btn btn-primary my-3">Сохранить</button>
            <button class="btn btn-danger m-3" wire:click.prevent="resetInputFields">Отмена</button>
        </div>
        
    </form>
    
    <h4>Поиск товаров:</h4>
    <div class="d-flex">
        <input type="text" class="form-control me-2" placeholder="наименование содержит..." wire:model.live="searchName">
        <select class="form-control me-2" wire:model.live="searchSize">
            <option selected hidden value="0">размер...</option>
            <option value="20x30">20x30</option>
            <option value="30x40">30x40</option>
            <option value="40x50">40x50</option>
            <option value="50x65">50x65</option>
            <option value="Другое">Другое</option>
        </select>
        <select class="form-control me-2" wire:model.live="searchCategory">
            <option selected hidden value="0">Категория...</option>
            @foreach ($categorylist as $item)
                <option value="{{$item->id}}">{{$item->name}}</option>
            @endforeach
        </select>
        <button class="btn btn-warning" wire:click.prevent="resetFilterFields">Сброс</button>
    </div>

    <table class="table table-bordered mt-5">
        <thead>
            <tr>
                <th>Наименование</th>
                <th>Категория</th>
                <th>Картинки</th>
                <th>Размер</th>
                <th>Цена</th>
                <th>Остаток</th>
                <th width="200px">Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $item)
                <tr>
                    <td>{{$item->name}}</td>
                    <td>{{$item->Category->name}}</td>
                    <td>
                        <div id="carouselExampleIndicators{{$item->id}}" class="carousel carousel-dark slide" data-bs-ride="carousel"> 
                            <div class="carousel-inner">                                
                                <div class="carousel-item active">  
                                    <img src="{{$item->Images->first()->toArray()['image']}}" class="d-block img-fluid mx-auto" width="100" height="100">
                                </div>                                
                                @for ($i = 1; $i < count($item->Images); $i++)
                                    <div class="carousel-item">
                                        <img src="{{$item->Images[$i]->toArray()['image']}}" class="d-block img-fluid mx-auto" width="100" height="100" >
                                    </div> 
                                @endfor                               
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators{{$item->id}}" data-bs-slide="prev">
                              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                              <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators{{$item->id}}" data-bs-slide="next">
                              <span class="carousel-control-next-icon" aria-hidden="true"></span>
                              <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </td>
                    <td>{{$item->size}}</td>
                    <td>{{$item->price}}</td>
                    <td>{{$item->remains}}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" wire:click="edit({{$item->id}})">Изменить</button>
                        <button class="btn btn-danger btn-sm" wire:click="delete({{$item->id}})">Удалить</button>
                    </td>
                </tr>
            @endforeach            
        </tbody>
    </table>
</div>
