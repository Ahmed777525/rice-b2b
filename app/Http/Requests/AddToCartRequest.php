<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddToCartRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => __('validation.product_required'),
            'product_id.exists' => __('validation.product_invalid'),
            'quantity.required' => __('validation.quantity_required'),
            'quantity.min' => __('validation.quantity_min'),
        ];
    }
}