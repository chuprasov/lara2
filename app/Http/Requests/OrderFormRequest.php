<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class OrderFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer.first_name' => ['required'],
            'customer.last_name' => ['required'],
            'customer.email' => ['required', 'email'],
            'customer.phone' => ['required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10'],
            'customer.city' => ['sometimes'],
            'customer.address' => ['sometimes'],
            'customer.create_account' => ['bool'],
            'password' => request()->boolean('create_account')
                ? ['required', 'confirmed', Password::defaults()]
                : ['sometimes'],
            'delivery_type_id' => ['required', 'exists:delivery_types.id'],
            'payment_method_id' => ['required', 'exists:payment_methods.id'],
        ];
    }
}
