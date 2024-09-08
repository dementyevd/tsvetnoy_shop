<div id="myfooter" class="d-flex flex-column" style="margin-top: 150px;"> 
    <hr/>
    <div class="d-flex justify-content-evenly" >
        <div class="d-flex flex-column">
            <h5 class="mb-4">Товары</h5>
            @foreach ($categorylist as $item)
                <a class="btn text-start" wire:click="ShowProducts({{$item}})">{{$item->name}}</a>
            @endforeach            
        </div>
        <div class="d-flex flex-column">
            <h5 class="mb-4">О компании</h5>
            <a class="btn text-start" href="#">О бренде</a>
            <a class="btn text-start" href="#">Контакты</a>
            <a class="btn text-start" href="#">Новости</a>            
        </div>
        <div class="d-flex flex-column">
            <h5 class="mb-4">Покупателям</h5>
            <a class="btn text-start" href="#">Гарантия</a>
            <a class="btn text-start" href="#">Ответы на вопросы</a>
            <a class="btn text-start" href="#">Отзывы и предложения</a>            
            <a class="btn text-start" href="#">Адреса магазинов</a>
        </div>
    </div>    
</div>
