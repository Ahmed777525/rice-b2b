<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'company_name' => 'required|string|max:255',
            'commercial_register' => 'required|string|max:50|unique:users',
            'tax_number' => 'nullable|string|max:50',
            'phone' => 'required|string|max:20',
            'branch_id' => 'required|exists:branches,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('validation.name_required'),
            'email.required' => __('validation.email_required'),
            'email.unique' => __('validation.email_unique'),
            'password.required' => __('validation.password_required'),
            'password.min' => __('validation.password_min'),
            'company_name.required' => __('validation.company_name_required'),
            'commercial_register.required' => __('validation.commercial_register_required'),
            'commercial_register.unique' => __('validation.commercial_register_unique'),
            'phone.required' => __('validation.phone_required'),
            'branch_id.required' => __('validation.branch_required'),
        ];
    }
}