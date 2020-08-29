<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Http\Requests\PasswordRequest;
use App\Order;
use App\Services\Cart;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\View\View
     */
    public function edit(Request $request)
    {
        $cart = new Cart($request);
        $orders = Order::where("user_id",\Auth::user()->id)->get();
        foreach ($orders as $key => $order) {
            $orders[$key]["total"] = 0;
            foreach($order->cart_items as $key_item => $item)
                $orders[$key]["total"] += ($item->quantity * $item->product->cost);
            $orders[$key]["total"] += $cart->delivery();
            $orders[$key]["total"] = $cart->cost($orders[$key]["total"]);
        }
        return view('profile.edit',[
            "orders" => $orders
        ]);
    }

    /**
     * Update the profile
     *
     * @param  \App\Http\Requests\ProfileRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileRequest $request)
    {
        auth()->user()->update($request->all());

        return back()->withStatus(__('Profile successfully updated.'));
    }

    /**
     * Change the password
     *
     * @param  \App\Http\Requests\PasswordRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function password(PasswordRequest $request)
    {
        auth()->user()->update(['password' => Hash::make($request->get('password'))]);

        return back()->withStatusPassword(__('Password successfully updated.'));
    }
}
