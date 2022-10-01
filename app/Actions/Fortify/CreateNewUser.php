<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string','min:3', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
            'address' => ['required', 'string', 'min:3', 'max:255'],
            'city' => ['required', 'string', 'min:2', 'max:255'],
            'state' => ['required', 'string', 'min:2', 'max:255'],
            'zip_code' => ['required', 'string', 'min:5', 'max:15'],
        ])->validate();

        $user =  User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        $user->billingDetails()->create([
            'address' => $input['address'],
            'city' => $input['city'],
            'state' => $input['state'],
            'zip_code' => $input['zip_code'],
        ]);

        return $user;
    }
}
