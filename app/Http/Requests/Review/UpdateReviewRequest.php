<?php

namespace App\Http\Requests\Review;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateReviewRequest extends FormRequest
{
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
        $reviewId = $this->route('review')->id;

        return [
            'event_id' => [
                'sometimes',
                'exists:events,id',
                Rule::unique('reviews')
                    ->where(fn($query) => $query->where('user_id', $this->user()->id))
                    ->ignore($reviewId),
            ],
            'rating' => ['sometimes', 'integer', 'between:1,5'],
            'comment' => ['sometimes', 'string'],
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Validation failed',
            'errors' => $validator->errors(),
        ], 422));
    }
}
