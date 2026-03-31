<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
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
    //  * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'email' => [
                'required',
                'email',
                'max:150',
                'lowercase',
                Rule::unique('users', 'email'),
            ],
            'password' => [
                'required',
                Password::min(8)->letters()->numbers(),
            ],
            'role_id' => ['nullable', 'exists:roles,id'],
            'phone' => [
                'nullable',
                'string',
                'max:20',
                Rule::unique('users', 'phone'),
            ],
            'avatar' => ['nullable', 'string', 'max:255'],
        ];
    }
}
