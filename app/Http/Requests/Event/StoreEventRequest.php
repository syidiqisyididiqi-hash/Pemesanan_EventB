<?php

namespace App\Http\Requests\Event;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

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
            'slug' => ['nullable', 'string', 'max:170', 'alpha_dash', 'unique:events,slug'],
            'event_at' => ['required', 'date', 'after:now'],
            'location' => ['required', 'string', 'max:150'],
            'quota' => ['required', 'integer', 'min:1', 'max:100000'],
            'price' => ['required', 'numeric', 'min:0', 'max:99999999'],
            'status' => ['nullable', Rule::in(['draft', 'published', 'cancelled'])],
            'category_id' => ['required', 'exists:categories,id'],
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
