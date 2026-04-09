<?php

namespace App\Http\Requests\Event;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class UpdateEventRequest extends FormRequest
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
        $eventId = $this->route('event')->id ?? $this->route('event');

        return [
            'title' => ['sometimes', 'string', 'max:150'],
            'description' => ['sometimes', 'string'],
            'slug' => [
                'sometimes',
                'string',
                'max:170',
                'alpha_dash',
                Rule::unique('events', 'slug')->ignore($eventId),
            ],
            'event_at' => ['sometimes', 'date', 'after:now'],
            'location' => ['sometimes', 'string', 'max:150'],
            'quota' => ['sometimes', 'integer', 'min:1', 'max:100000'],
            'price' => ['sometimes', 'numeric', 'min:0', 'max:99999999'],
            'status' => ['sometimes', Rule::in(['draft', 'published', 'cancelled'])],
            'category_id' => ['sometimes', 'exists:categories,id'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'title' => trim($this->title ?? ''),
            'description' => trim($this->description ?? ''),
            'location' => trim($this->location ?? ''),
            'slug' => Str::slug($this->slug ?? $this->title),
        ]);
    }
}
