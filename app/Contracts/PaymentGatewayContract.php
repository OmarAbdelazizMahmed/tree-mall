<?php

namespace App\Contracts;

interface PaymentGatewayContract
{
    public function charge($user, $confirmationNumber, $request);
}
