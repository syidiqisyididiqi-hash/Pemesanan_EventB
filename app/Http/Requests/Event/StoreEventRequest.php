<?php

namespace App\Http\Requests\Event;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEventRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:150'],

            'description' => ['required', 'string'],

            'slug' => [
                'required',
                'string',
                'max:170',
                'alpha_dash',
                'unique:events,slug'
            ],

            'evnet_at' => [
                'required',
                'date',
                'after:now'
            ],

            'location' => ['required', 'string', 'max:150'],

            'quota' => [
                'required',
                'integer',
                'min:1',
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'status' => [
                'required',
                Rule::in(['draft', 'published', 'cancelled']),
            ],

            'category_id' => [
                'required',
                'exists:categories,id',
            ],

            'organizer_id' => [
                'required',
                'exists:users,id',
            ],
        ];
    }
}
