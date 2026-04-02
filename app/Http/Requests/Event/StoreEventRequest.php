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
                'unique:events,slug',
            ],

            'event_at' => [
                'required',
                'date',
                'after:now',
            ],

            'location' => ['required', 'string', 'max:150'],

            'quota' => ['required', 'integer', 'min:1'],

            'price' => ['required', 'numeric', 'min:0'],

            'status' => [
                'sometimes',
                Rule::in(['draft', 'published', 'cancelled']),
            ],

            'category_id' => [
                'required',
                'integer',
                'exists:categories,id',
            ],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'title' => trim($this->title ?? ''),
            'location' => trim($this->location ?? ''),
            'slug' => $this->input('slug')
                ? strtolower($this->input('slug'))
                : null,
        ]);
    }
}
