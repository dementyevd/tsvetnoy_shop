<div>
    @livewire('header')
    <div class="container col-md-8 mt-4 d-flex flex-column">
        <h3 class="fw-bold mt-2">История заказов</h3>
        <div>
            <div class="accordion" id="accordionOrder">
                @foreach ($myOrders as $order)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading{{$loop->index}}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$loop->index}}" aria-expanded="false" aria-controls="collapse{{$loop->index}}">
                                Заказ от {{$order->orderdate}} на сумму<strong>{{$order->totalsum}} руб.</strong>
                            </button>
                        </h2>
                        <div id="collapse{{$loop->index}}" class="accordion-collapse collapse" aria-labelledby="heading{{$loop->index}}" data-bs-parent="#accordionOrder">
                            <div class="accordion-body d-flex flex-column">
                                @foreach ($order->Orderlines as $orderline)
                                    <div class="d-flex align-items-center mt-4">
                                        <img src="/{{$orderline->Product->Images->first()->toArray()['image']}}" style="width: 10%">
                                        <div class="d-flex flex-column justify-content-center">
                                            <p class="mx-3 fs-3">{{$orderline->Product->name}}</p>
                                            <p class="mx-3 fs-5">{{$orderline->Product->Category->name}}</p>
                                        </div>
                                        <p class="ms-auto">{{$orderline->quantity}} шт.</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                  </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
