<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    public function index()
    {
        $cartItems =  Cart::instance('default')->content();
        $cartTexRate = config('cart.tax');
        $tax = config('cart.tax') / 100;
        $cartSubTotal = floatVal(Cart::instance('default')->subtotal());
        $cartTax = $cartSubTotal * $tax;
        $newTotal = Cart::instance('default')->total();
        $laterItems = Cart::instance('laterCart')->content();
        $laterCount = Cart::instance('laterCart')->count();
        return Inertia::render('Cart/Index',
            [
                'cartItems' => $cartItems,
                'cartSubtotal' => ($cartSubTotal),
                'cartTexRate' => floatVal($cartTexRate),
                'cartTax' => floatVal($cartTax),
                'newTotal' => floatVal($newTotal),
                'laterItems' => $laterItems,
                'laterCount' => $laterCount,
            ]
        );
    }

    public function add(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'name' => 'required|string',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'image' => 'required|string',
            'slug' => 'required|string',
            'details' => 'required|string',
            'code' => 'required|string',
            'total_quantity' => 'required|integer',
        ]);

        $cart = Cart::instance('default')->add($request->id, $request->name, $request->quantity, $request->price, 0,
        [
            'totalQty' => $request->total_quantity,'code' => $request->code,
            'image' => $request->image, 'slug' => $request->slug,
            'details' => $request->details,
        ])->associate('App\Models\Product');

        return redirect()->route('cart.index');
    }

    public function remove($id)
    {
        Cart::instance('default')->remove($id);
        return back();
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer',
        ]);

        Cart::instance('default')->update($id, $request->quantity);
        return back();
    }

}
