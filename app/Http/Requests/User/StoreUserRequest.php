<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Validation failed',
            'errors'  => $validator->errors(),
        ], 422));
    }

    public function rules(): array
    {
        return [
            'name' => ['required','string','max:100'],

            'email' => [
                'required',
                'email',
                'max:150',
                'lowercase',
                Rule::unique('users','email'),
            ],

            'password' => [
                'required',
                Password::min(8)->letters()->numbers(),
            ],

            'role_id' => ['required','exists:roles,id'],

            'phone' => [
                'nullable',
                'string',
                'max:20',
                Rule::unique('users','phone'),
            ],

            // ⬇️ TERIMA FILE, BUKAN STRING
            'avatar' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ];
    }
}