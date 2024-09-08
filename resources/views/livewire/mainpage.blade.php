<div style="font-family: 'Times New Roman', Times, serif;">
   @livewire('header')
   <h1 style="font-size: 85px; text-align: center; margin-top: 5%">Наборы для творчества</h1>
   <div id="carouselExampleDark" class="carousel carousel-dark slide mt-5" data-bs-ride="carousel">
      <div class="carousel-indicators" style="bottom: -50px;">
        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" ></button>
        @for ($i = 1; $i < count($categoryList); $i++)
         <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="{{$i}}"></button>
        @endfor        
      </div>
      <div class="carousel-inner">
        <div class="carousel-item active" data-bs-interval="10000">
            <div class="d-flex justify-content-evenly">
               <img src="{{$categoryList[0]->image}}" class="img-fluid d-block w-25" style="height: 400px" alt="{{$categoryList[0]->name}}">
               <div class="d-flex flex-column justify-content-center text-center">
                  <h1 style="font-size: 60px">{{$categoryList[0]->name}}</h1>
                  <p style="font-size: 25px">{{$categoryList[0]->description}}</p>
                  <button class="btn btn-lg btn-outline-success align-self-center" wire:click="ShowProducts({{$categoryList[0]}})">Каталог</button>
               </div>
            </div>         
        </div>
         @for ($i = 1; $i < count($categoryList); $i++)
            <div class="carousel-item" data-bs-interval="4000">
               <div class="d-flex justify-content-evenly">
                  <img src="{{$categoryList[$i]->image}}" class="img-fluid d-block w-25" style="height: 400px; width: 400px" alt="{{$categoryList[$i]->name}}">
                  <div class="d-flex flex-column justify-content-center text-center">
                     <h1 style="font-size: 60px">{{$categoryList[$i]->name}}</h1>
                     <p style="font-size: 25px">{{$categoryList[$i]->description}}</p>
                     <button class="btn btn-lg btn-outline-success align-self-center" wire:click="ShowProducts({{$categoryList[$i]}})">Каталог</button>
                  </div>
               </div>
            </div>        
         @endfor  
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>    
</div>

@livewire('footer')
