<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'shipping_address' => 'required|string|max:500',
            'shipping_city' => 'nullable|string|max:100',
            'shipping_phone' => 'nullable|string|max:20',
            'notes' => 'nullable|string|max:1000',
'payment_method' => 'required|in:bank_transfer,visa,mada,paypal,cod',
        ];
    }

    public function messages(): array
    {
        return [
            'shipping_address.required' => __('validation.shipping_address_required'),
            'payment_method.required' => __('validation.payment_method_required'),
            'payment_method.in' => __('validation.payment_method_invalid'),
        ];
    }
}