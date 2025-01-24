<?php

namespace App\Livewire;

use App\Models\Cart as ModelsCart;
use App\Models\Order;
use App\Models\Orderline;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class Cart extends Component
{
    public $products;
    public $totalsum;

    public function Decrease(ModelsCart $cart)
    {
        if ($cart->quantity > 0) {
            $cart->update(['quantity' => $cart->quantity - 1]);
            $this->CalcSum();
        }
    }

    public function Increase(ModelsCart $cart)
    {
        $cart->update(['quantity' => $cart->quantity + 1]);
        $this->CalcSum();
    }

    public function Delete(ModelsCart $cart)
    {
        ModelsCart::destroy($cart->id);
        $this->CalcSum();
    }

    public function MakeOrder()
    {
        if (count($this->products) > 0) {
            foreach ($this->products as $item) {
                if ($item->quantity > $item->Product->remains) {
                    session()->flash('message', 'Товара "' . $item->Product->name . '" недостаточно для оформления заказа');
                    return;
                }
            }

            $newOrder = Order::Create([
                'user_id' => Auth::user()->id,
                'orderdate' => Carbon::now(),
                'totalsum' => $this->totalsum
            ]);

            foreach ($this->products as $item) {
                Orderline::Create([
                    'order_id' => $newOrder->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity
                ]);
            }

            $arr = [];
            foreach ($this->products as $item) {
                $item->Product->update(['remains' => $item->Product->remains - 1]);
                $arr[] = array(
                    "quantity" => floatval($item->quantity),
                    "price" => floatval($item->Product->price * 100),
                    "discount" => 0,
                    "vat" => 0,
                    "assortment" => array(
                        "meta" => array(
                            "href" => "https://api.moysklad.ru/api/remap/1.2/entity/product/" . $item->Product->external_id,
                            "type" => "product",
                            "mediaType" => "application/json"
                        )
                    ),
                    "reserve" => floatval($item->quantity)
                );
                ModelsCart::destroy($item->id);
            }

            $str = array(
                "organization" => array(
                    "meta" => array(
                        "href" => "https://api.moysklad.ru/api/remap/1.2/entity/organization/22d032c0-da65-11ef-0a80-026500118280",
                        "type" => "organization",
                        "mediaType" => "application/json"
                    )
                ),
                "code" => strval($newOrder->id),
                "moment" => $newOrder->orderdate->format('Y-m-d H:i:s'),
                "applicable" => false,
                "vatEnabled" => false,
                "agent" => array(
                    "meta" => array(
                        "href" => "https://api.moysklad.ru/api/remap/1.2/entity/counterparty/239300c1-da65-11ef-0a80-0265001182ae",
                        "type" => "counterparty",
                        "mediaType" => "application/json"
                    )
                ),
                "state" => array(
                    "meta" => array(
                        "href" => "https://api.moysklad.ru/api/remap/1.2/entity/customerorder/metadata/states/239dc849-da65-11ef-0a80-0265001182c4",
                        "type" => "state",
                        "mediaType" => "application/json"
                    )
                ),
                "positions" => $arr
            );
            $response = $this->CreateCustomerOrder($str);
            //session()->flash('message', $response);

            $this->redirectRoute('myOrders');
        } else {
            session()->flash('message', 'Корзина пуста!');
        }
    }

    public function getToken()
    {
        $response = Http::withBasicAuth('admin@dementyevd', 'P@$$worD3085')->withHeader('Accept-Encoding', 'gzip')->accept('application/json;charset=utf-8')->post('https://api.moysklad.ru/api/remap/1.2/security/token');
        return $response;
    }

    public function CreateCustomerOrder($jsonStr)
    {
        $tok = json_decode($this->getToken());
        $response = Http::withToken($tok->access_token)->withHeader('Accept-Encoding', 'gzip')->accept('application/json;charset=utf-8')->post('https://api.moysklad.ru/api/remap/1.2/entity/customerorder', $jsonStr);
        return $response;
    }

    public function CalcSum()
    {
        $this->totalsum = 0;
        $products = ModelsCart::where('user_id', Auth::user()->id)->get();
        foreach ($products as $cartitem) {
            $this->totalsum += ($cartitem->quantity * $cartitem->Product->price);
        }
    }

    public function render()
    {
        $this->CalcSum();
        $this->products = ModelsCart::where('user_id', Auth::user()->id)->get();
        return view('livewire.cart');
    }
}
