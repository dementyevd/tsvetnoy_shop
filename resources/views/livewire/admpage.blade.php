<div>
    @can('admin-show', Auth::user())
        <h3 class="text-center my-3">Панель администратора</h3>
        <div class="container d-flex align-items-start">    
            <div class="btn-group-vertical me-4" role="group" aria-label="Basic radio toggle button group">
                <input type="radio" value="category" class="btn-check" name="btnradio" id="btnradio1" wire:model.live="choice">
                <label class="btn btn-outline-primary" for="btnradio1">Категории</label>
            
                <input type="radio" value="product" class="btn-check" name="btnradio" id="btnradio2" wire:model.live="choice">
                <label class="btn btn-outline-primary" for="btnradio2">Товары</label>
            
                <input type="radio" value="user" class="btn-check" name="btnradio" id="btnradio3" wire:model.live="choice">
                <label class="btn btn-outline-primary" for="btnradio3">Пользователи</label>
            </div>   
       
            <div class="col-md-10">        
                @switch($choice)
                    @case('category')
                        @livewire('category')
                        @break
                    @case('product')
                        @livewire('productmng')
                        @break
                    @case('user')
                        @livewire('usermng')
                        @break
                    @default                
                        @break
                @endswitch
                
            </div>
        </div>
    @else
        <div>
            <h3 class="text-center">Доступ запрещен</h3>
        </div>
    @endcan
</div>


