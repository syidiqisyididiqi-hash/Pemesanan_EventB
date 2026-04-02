<?php

namespace App\Http\Requests\Event;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        $eventId = $this->route('event')->id;

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

            'event_at' => [
                'sometimes',
                'date',
                'after:now',
            ],

            'location' => ['sometimes', 'string', 'max:150'],

            'quota' => [
                'sometimes',
                'integer',
                'min:1',
            ],

            'price' => [
                'sometimes',
                'numeric',
                'min:0',
            ],

            'status' => [
                'sometimes',
                Rule::in(['draft', 'published', 'cancelled']),
            ],

            'category_id' => [
                'sometimes',
                'exists:categories,id',
            ],

            'organizer_id' => [
                'sometimes',
                'exists:users,id',
            ],
        ];
    }
}
