<div id="myHeader">
    <hr/>
    <ul class="nav justify-content-evenly">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/">Главная</a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Товары</a>
            <ul class="dropdown-menu">
              @foreach ($categorylist as $item)
                <li><a class="dropdown-item btn" wire:click="ShowProducts({{$item}})">{{$item->name}}</a></li>
              @endforeach              
            </ul>
          </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Покупателям</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Гарантия</a></li>
              <li><a class="dropdown-item" href="#">Ответы на вопросы</a></li>
              <li><a class="dropdown-item" href="#">Отзывы и предложения</a></li>
              <li><a class="dropdown-item" href="#">Адреса магазинов</a></li>             
            </ul>
        </li>      
        <li class="nav-item">            
            <a class="nav-link" href="#">Где купить?</a>  
        </li>  
        @can('user-show', Auth::user())
            <li class="nav-item">            
                <a class="nav-link" href="/orders">Мои заказы</a>  
            </li> 
            <li class="nav-item">            
                <a class="nav-link" href="/cart">
                  Корзина
                  <span class="badge rounded-pill bg-danger" style="visibility: {{$visibility ? "visible": "hidden"}}">                    
                    {{$quantity}}
                  </span>
                </a>  
            </li> 
        @endcan
      </ul>
      <hr/>
</div>
