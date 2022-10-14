<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $cartValues = $this->cartService->setCartValues();

        return Inertia::render('Cart/Index',
           $cartValues->toArray()
        );
    }

    public function add(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'name' => 'required|string',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'main_image' => 'required|string',
            'slug' => 'required|string',
            'details' => 'required|string',
            'code' => 'required|string',
            'total_quantity' => 'required|integer',
        ]);

        $cart = Cart::instance('default')->add($request->id, $request->name, $request->quantity, $request->price, 0,
        [
            'totalQty' => $request->total_quantity,'code' => $request->code,
            'main_image' => $request->main_image, 'slug' => $request->slug,
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
