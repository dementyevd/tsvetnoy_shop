<div > 
    <div class="d-flex justify-content-center">
        @if(session()->has('message'))
            <div class="alert alert-danger">
                {{ session('message') }}
            </div>
        @endif
    </div>  
    <div class="container col-md-8 mt-4 border border-3 rounded-3 d-flex flex-column">         
        <h3 class="fw-bold mt-2">Ваш заказ</h3>    
        <div>
            @foreach ($products as $item)
                <div class="mt-3">
                    <hr class="mt-4"/>
                    <div class="d-flex align-items-center">
                        <img src="/{{$item->Product->Images->first()->toArray()['image']}}" style="width: 10%">
                        <div class="d-flex flex-column justify-content-center">
                            <p class="mx-3 fs-3">{{$item->Product->name}}</p>
                            <p class="mx-3 fs-5">{{$item->Product->Category->name}}</p>
                        </div>
                        <div class="d-flex align-items-center ms-auto">
                            <button class="btn btn-outline-warning m-2" wire:click="Decrease({{$item}})">-</button>
                            <p class="fs-4">{{$item->quantity}}</p>
                            <button class="btn btn-outline-success m-2" wire:click="Increase({{$item}})">+</button>
                        </div>
                        <p class="fs-4 mx-3">{{$item->Product->price*$item->quantity}} руб.</p>
                        <button class="btn btn-danger m-2" wire:click="Delete({{$item}})">x</button>
                    </div>                
                </div>            
            @endforeach
        </div>
        <hr />
        <div class="d-flex">
            <h3 class="fw-bold ms-auto">Итого:</h3>
            <h3 class="fw-bold ms-5">{{$totalsum}} руб.</h3>
        </div>  
        <div class="d-flex justify-content-center my-3">
           <button class="btn btn-success mx-2" wire:click="MakeOrder">Оформить</button>
           <a href="/" class="btn btn-secondary mx-2">На главную</a>
        </div>  
    </div>
    

</div>
