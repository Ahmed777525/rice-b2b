<?php

return [
    'name_required' => 'The name field is required',
    'email_required' => 'The email field is required',
    'email_unique' => 'The email has already been taken',
    'email_email' => 'The email must be a valid email address',
    'password_required' => 'The password field is required',
    'password_min' => 'The password must be at least 8 characters',
    'password_confirmed' => 'The password confirmation does not match',
    'company_name_required' => 'The company name field is required',
    'commercial_register_required' => 'The commercial register field is required',
    'commercial_register_unique' => 'The commercial register has already been taken',
    'tax_number_required' => 'The tax number field is required',
    'phone_required' => 'The phone field is required',
    'branch_required' => 'The branch field is required',
    'min_quantity_required' => 'Quantity is below minimum order quantity',
    'max_quantity_exceeded' => 'Quantity exceeds maximum order quantity',
    'insufficient_stock' => 'Insufficient stock available',
    'required' => 'The :attribute field is required',
    'string' => 'The :attribute must be a string',
    'max' => [
        'numeric' => 'The :attribute must be less than :max',
        'string' => 'The :attribute must not be greater than :max characters',
    ],
    'min' => [
        'numeric' => 'The :attribute must be at least :min',
        'string' => 'The :attribute must be at least :min characters',
    ],
    'unique' => 'The :attribute has already been taken',
    'exists' => 'The selected :attribute is invalid',
    'email' => 'The :attribute must be a valid email address',
    'confirmed' => 'The :attribute confirmation does not match',
];
