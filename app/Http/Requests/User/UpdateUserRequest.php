<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'name' => 'sometimes|string|max:100',
            'email' => [
                'sometimes',
                'email',
                'max:150',
                'lowercase',
                Rule::unique('users', 'email')->ignore($this->user),
            ],
            'password' => 'sometimes|string|min:8',
            'role_id' => 'sometimes|exists:roles,id',
            'phone' => [
                'sometimes',
                'nullable',
                'string',
                'max:20',
                Rule::unique('users', 'phone')->ignore($this->user),
            ],
            'avatar' => 'sometimes|string|max:255',
        ];
    }
}
