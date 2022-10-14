<?php

namespace App\Services;

use Gloudemans\Shoppingcart\Facades\Cart;

class CartService
{
    public function setCartValues()
    {
        $cartItems =  Cart::instance('default')->content();
        $cartTaxRate = config('cart.tax');
        $tax = config('cart.tax') / 100;
        $cartSubTotal = floatVal(Cart::instance('default')->subtotal());
        $code = session()->get('coupon')['name'] ?? null;
        $discount = session()->get('coupon')['discount'] ?? null;
        $newSubtotal = ($cartSubTotal - $discount);
        if ($newSubtotal < 0) {
            $newSubtotal = 0;
        }
        $newTax = $newSubtotal * $tax;
        $newTotal = $newSubtotal * (1 + $tax);
        $laterItems = Cart::instance('laterCart')->content();
        $laterCount = Cart::instance('laterCart')->count();

        return collect([
            'cartItems' => $cartItems,
            'cartSubtotal' => ($cartSubTotal),
            'cartTaxRate' => ($cartTaxRate),
            'newTax' => $newTax,
            'code' => $code,
            'discount' => $discount,
            'newSubtotal' => $newSubtotal,
            'newTotal' => $newTotal,
            'laterItems' => $laterItems,
            'laterCount' => $laterCount,
        ]);
    }
}
