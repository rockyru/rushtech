<?php

namespace App\Http\Requests;

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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',   
            'role' => 'required', 'exists:roles,name',
        ];
    }
}
