<?php

namespace App\Contracts;

use App\Models\User;

interface PaymentGatewayContract
{
    public function charge(User $user, $confirmationNumber, $request);
}
