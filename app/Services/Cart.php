<?php
/**
 * Created by PhpStorm.
 * User: Obi-Wan
 * Date: 26.08.2020
 * Time: 22:30
 */

namespace App\Services;


use App\CartItem;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class Cart
{
    /**
     * @var Session
     */
    private $session;

    /**
     * @var string
     */
    private $code;

    private $currency = "$";

    private $delivery = 15;


    function __construct(Request $request)
    {
        $this->session = $request->session();

        $this->code = $this->session->get('cart.code');
        if (is_null($this->code)) {
            $this->createNewCart();
        }
    }


    public function code()
    {
        return $this->code;
    }

    public function currency()
    {
        return $this->currency;
    }

    public function delivery()
    {
        return $this->delivery;
    }

    public function setCurrency($currency) {
        $this->currency = $currency;
    }


    /**
     * Сумма стоимостей всех позиций в корзине. Итоговая сумма на чеке.
     *
     * @param bool $with_delivery
     * @return float
     */
    public function total($with_delivery = false)
    {
        /** @var Collection $items */
        $items = CartItem::with([ 'product' => function ($query) { $query->select([ 'id', 'cost' ]); } ])
            ->whereCode($this->code)
            ->get([ 'product_id', 'quantity' ]);

        $total = $items->sum(function ($item) { return $item->quantity * $this->cost($item->product->cost); });

        $this->session->put('cart.total', $total);


        if($with_delivery) {
            $total += $this->cost($this->delivery);
        }

        return $total;
    }


    /**
     * Суммарное количество единиц товара в заказе.
     *
     * @return int
     */
    public function count()
    {
        $count = $this->session->get('cart.count');

        if (is_null($count)) {

            $count = CartItem::where("code",$this->code)->sum('quantity');

            $this->session->put('cart.count', $count);
        }

        return $count;
    }

    public function cost($cost) {
        if($this->currency == "$") {
            return $cost;
        } else {
            // euro
            return $cost*0.84;
        }
    }


    /**
     * Позиции заказа.
     *
     * @param array $columns
     * @param bool  $lock
     *
     * @return Collection
     */
    public function items($columns = [ '*' ], $lock = false)
    {
        if ($lock) {
            return CartItem::with(
                [
                    'product' => function ($query) {
                        $query->lockForUpdate();
                    }
                ]
            )->whereCode($this->code)->latest('created_at')->lockForUpdate()->get($columns);
        }

        return CartItem::with('product')->whereCode($this->code)->latest('created_at')->get($columns);
    }



    public function clear()
    {
        $this->session->remove('cart');
        CartItem::where('code',$this->code)->delete();
        $this->createNewCart();
    }

    /**
     * Изменения количества позиции в заказе. Проверяет наличие на складе. Не проверяет баланс пользователя.
     *
     * @param string|array $condition
     * @param int          $quantity
     *
     * @throws Exception
     */
    public function setQuantity($condition, $quantity)
    {
        if (!is_array($condition)) {
            $condition = [ 'product_id' => $condition ];
        }

        // проверка наличия на складе

        $item = CartItem::with('product')->whereCode($this->code)->where($condition)->first();

        $item->update(compact('quantity'));

        $this->clearCounters();
    }


    /**
     * @param Product $product
     * @param int     $quantity
     *
     * @return array
     * @throws Exception
     */
    public function addItem($product, $quantity = 1)
    {
        if($this->code)
            $item = CartItem::where("code",$this->code)->where("product_id",$product->id)->first();

        if (!empty($item)) {
            $item->increment('quantity', $quantity);

            $this->clearCounters();
            $result = [
                "count" => $this->count(),
                "items" => $this->items(),
                "total" => $this->total(),
                "new_item" => $item,
                "currency" => "$"
            ];

            return $result;
        }

        /** @var CartItem $newItem */
        $newItem = CartItem::create(
            [
                'code' => $this->code,
                'user_id' => \Auth::user()->id ?? NULL,
                'product_id' => $product->id,
                'quantity' => $quantity,
            ]
        );

        $this->clearCounters();

        $result = [
            "count" => $this->count(),
            "items" => $this->items(),
            "total" => $this->total(),
            "new_item" => $newItem,
            "currency" => "$"
        ];

        return $result;
    }


    public function deleteItem(Product $product, $quantity = 1)
    {

        $condition = [ 'product_id' => $product->id ];

        $deleted_item = CartItem::where("code",$this->code)->where($condition)->first();

        if($deleted_item->quantity > 1) {
            $deleted_item->decrement('quantity', $quantity);

            $this->clearCounters();
            $result = [
                "count" => $this->count(),
                "items" => $this->items(),
                "total" => $this->total(),
                "new_item" => $deleted_item,
                "currency" => "$"
            ];

            return $result;

        }

        $deleted_item->delete();

        $this->clearCounters();


        $result = [
            "count" => $this->count(),
            "items" => $this->items(),
            "total" => $this->total(),
            "new_item" => $deleted_item,
            "currency" => "$"
        ];

        return $result;
    }


    private function createNewCart()
    {
        $this->code = Str::random();
        $this->session->put('cart.code', $this->code);
        $this->clearCounters();
    }


    private function clearCounters()
    {
        $this->session->remove('cart.count');
        $this->session->remove('cart.total');
    }
}