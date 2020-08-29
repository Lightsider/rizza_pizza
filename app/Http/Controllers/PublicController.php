<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use App\Services\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class PublicController extends Controller
{
    public function __construct()
    {
        $this->middleware('cart');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = Product::all();

        return view('index', [
            "products" => $products
        ]);
    }

    public function thankYou(Request $request) {
        if(!session()->has('order_id')) return redirect()->route('index');
        return view('thank_you');
    }

    public function formOrder(Request $request) {
        return view('form_order');
    }

    public function saveOrder(Request $request) {
        $input = array(
            'address' => request()->get('address'),
            'fullname' => request()->get('fullname'),
            'additional_information' => request()->get('additional_information'),
        );

        $rules = array(
            'address' => 'string|required|min:3|max:255',
            'fullname' => 'string|required|min:3|max:255',
            'additional_information' => 'string|nullable',
        );

        $validator = \Validator::make($input, $rules);

        if($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            $order = Order::create([
                'address' => request()->get('address'),
                'fullname' => request()->get('fullname'),
                'additional_information' => request()->get('additional_information'),
                'user_id' => \Auth::user()->id ?? null,
            ]);

            $cart = new Cart($request);
            $items = $cart->items();
            foreach ($items as $item) {
                $item->code = '';
                $item->order_id = $order->id;
                $item->save();
            }

            $cart->clear();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with("message", "Error with sending order, try again later");
        }
        DB::commit();

        return redirect()->route('thankYou')->with("order_id", $order->id);

    }

    public function setCurrency(Request $request, $raw_currency) {

        if (in_array($raw_currency, Config::get('app.currencies'))) {
            $currency = $raw_currency;
        }
        else $currency = env('CURRENCY');

        $request->session()->put("currency",$currency);

        return redirect()->back()->withCookies([cookie()->forever('currency',$currency)]);
    }
}
