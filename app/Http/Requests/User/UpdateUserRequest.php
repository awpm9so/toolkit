<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => 'required|numeric|exists:users',
            'name' => 'string||max:255',
            'email' => 'string|email|max:255|unique:users',
            'password' => 'string|min:8',
            'date_of_birth' => 'date|nullable',
            'address' => 'string|nullable',
            'phone' => 'string|nullable',
        ];
    }
}
