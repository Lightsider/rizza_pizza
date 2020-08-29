<?php

namespace App\Http\Controllers;

use App\CartItem;
use App\Product;
use App\Services\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * @param Request $request
     */
    public function view(Request $request) {
        return view('cart');
    }



    /********************************* requests **************************************************/

    /**
     * Show the application dashboard.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function addCart(Request $request)
    {
        $cart = new Cart($request);
        $item = Product::find($request->get('product_id'));
        if(!empty($item)) {
            $data = $cart->addItem($item,1,$request);
            return response()->json(["message" => __("Product added to cart"),"data" => $data]);
        }
        return response()->setStatusCode(404)->json(["message" => "Product not found"]);

    }


    /**
     * Show the application dashboard.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function removeCart(Request $request)
    {
        $cart = new Cart($request);
        $item = Product::find($request->get('product_id'));
        if(!empty($item)) {
            $data = $cart->deleteItem($item,1,$request);
            return response()->json(["message" => __("Product remove from cart"),"data" => $data]);
        }
        return response()->setStatusCode(404)->json(["message" => "Product not found"]);

    }
}
