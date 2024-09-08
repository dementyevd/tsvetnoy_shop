<div>
    @livewire('header')
    <div class="d-flex justify-content-center">
        @if(session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
    </div>
    <h1 class="mt-4" style="font-size: 60px; text-align: center">{{$category->name}}</h1>
    
    <div class="container col-10 d-flex">
        <input type="text" class="form-control me-2" placeholder="наименование содержит..." wire:model.live="searchName">
        <select class="form-control me-2" wire:model.live="searchSize">
            <option selected hidden value="0">размер...</option>
            <option value="20x30">20x30</option>
            <option value="30x40">30x40</option>
            <option value="40x50">40x50</option>
            <option value="50x65">50x65</option>
            <option value="Другое">Другое</option>
        </select>
        
        <button class="btn btn-warning" wire:click.prevent="resetFilterFields">Сброс</button>
    </div>

    <div class="container d-flex flex-wrap justify-content-evenly">
        @foreach ($products as $item)
        <div class="card m-4" style="width: 18rem;">
            <img src="/{{$item->Images->first()->toArray()['image']}}" class="card-img-top" alt="{{$item->image}}">
            <div class="card-body d-flex flex-column justify-content-center">
                <h5 class="card-title text-center fw-bold">{{$item->name}}</h5> 
                @if ($item->remains>0)
                    <p class="text-center">Остаток: {{$item->remains}} шт.</p> 
                @else
                    <p class="text-center" style="color: red">Нет в наличии</p>                
                @endif  
                @can('user-show', Auth::user())  
                    <button class="btn btn-success mx-auto" wire:click="AddToCart({{$item}})">В корзину</button>                    
                @endcan
            </div>
        </div>        
        @endforeach
    </div>
    
   
</div>
