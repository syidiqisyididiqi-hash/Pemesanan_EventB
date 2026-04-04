<?php

namespace App\Http\Requests\Image;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreImageRequest extends FormRequest
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
            'image_path' => ['required', 'string'],
            'imageable_id' => ['required', 'integer'],
            'imageable_type' => ['required', 'string'],
        ];
    }
}
