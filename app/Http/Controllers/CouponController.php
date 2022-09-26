<?php

namespace App\Http\Controllers;

use App\Models\Coupons\Coupon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CouponController extends Controller
{

    public function apply(Request $request)
    {
        $coupon = Coupon::findCoupon($request->coupon_code);

        if (!$coupon) {
            return back()->withErrors(['message' => 'Invalid coupon code']);
        }

        $discount = $coupon->discount(Cart::instance('default')->subtotal());

        session()->put('coupon', [
            'name' => $coupon->code,
            'discount' => $discount,
        ]);


        return back();
    }

    public function remove()
    {
        session()->forget('coupon');

        return back();
    }
}
