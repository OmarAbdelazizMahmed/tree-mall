<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $email = auth()->user() ? ['required', 'string', 'email', 'max:255'] : ['required', 'string', 'email', 'max:255', 'unique:users'];
        return [
            'name' => ['required', 'string','min:3', 'max:255'],
            'email' => $email,
            'name_on_card' => ['required', 'string', 'min:3', 'max:255'],
            'password' => ['sometimes', 'string', 'min:8'],
            'address' => ['required', 'string', 'min:3', 'max:255'],
            'city' => ['required', 'string', 'min:2', 'max:255'],
            'state' => ['required', 'string', 'min:2', 'max:255'],
            'zip_code' => ['required', 'string', 'min:5', 'max:15'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'email.unique' => 'Would you like to login instead?',
        ];
    }
}
