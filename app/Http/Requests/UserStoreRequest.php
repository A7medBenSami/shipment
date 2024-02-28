<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255', 'string'],
            'email' => ['required', 'unique:users,email', 'email'],
            'password' => ['required'],
            'phone' => ['required', 'unique:users,phone', 'max:255', 'string'],
            'gender' => ['required', 'in:male,female,other'],
            'image' => ['nullable', 'image', 'max:1024'],
            'otp' => ['required', 'unique:users,otp', 'max:255', 'string'],
            'isVerified' => ['required', 'numeric'],
            'roles' => 'array',
        ];
    }
}