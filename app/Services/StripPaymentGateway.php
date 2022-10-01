<?php

namespace App\Services;

use App\Contracts\PaymentGatewayContract;
use App\Models\User;
use Gloudemans\Shoppingcart\Facades\Cart;

class StripPaymentGateway implements PaymentGatewayContract
{
    private $cartItems;

    public function __construct($cartItems)
    {
        $this->cartItems = $cartItems;
    }


    public function charge(User $user, $confirmationNumber, $request)
    {
        if (session()->has('coupon')) {
            $discountValue = session()->get('coupon')['discount'] / 100;
            $discountCode = session()->get('coupon')['name'];
        } else {
            $discountValue = 0;
            $discountCode = 'No Coupon';
        }
        $payment = $user->charge(ceil($request->amount), $request->payment_method_id, [
            'currency' => 'usd',
            'receipt_email' => $request->email,
            'statement_descriptor' => 'Tree Mall',
            'description' => 'You bought my swag!',
            'metadata' => [
                'Confirmation # ' => $confirmationNumber,
                'Item(s)' => $this->cartItems,
                'Total Item(s) Count' => Cart::instance('default')->count(),
                'Discount' => $discountCode. ': -$'.$discountValue.' off',
            ],
        ]);

        $payment = $payment->asStripePaymentIntent();
    }
}
