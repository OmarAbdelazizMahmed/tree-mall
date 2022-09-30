<?php

namespace App\Services;

use App\Contracts\PaymentGatewayContract;
use Gloudemans\Shoppingcart\Facades\Cart;

class StripPaymentGateway implements PaymentGatewayContract
{
    private $cartItems;

    public function __construct($cartItems)
    {
        $this->cartItems = $cartItems;
    }
    public function charge($user, $confirmationNumber, $request)
    {
        $payment = $user->charge(ceil($request->amount), $request->payment_method_id, [
            'currency' => 'usd',
            'description' => 'Payment from ' . $request->name,
            'receipt_email' => 'fsdjflk@kfjdsk.com',
            'statement_descriptor' => 'The shop store',
            'metadata' => [
                'Confirmation # ' => $confirmationNumber,
                'Item(s)' => $this->cartItems,
                'Total Item(s) Count' => Cart::instance('default')->count(),
            ],

        ]);

        $payment = $payment->asStripePaymentIntent();
    }
}
