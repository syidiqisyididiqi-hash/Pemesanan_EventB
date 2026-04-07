<?php

namespace App\Http\Requests\Category;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class StoreCategoryRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('categories', 'name'),
            ],
            'slug' => [
                'string',
                'max:120',
                'alpha_dash',
                Rule::unique('categories', 'slug'),
            ],
            'description' => [
                'nullable',
                'string',
                'max:200',
            ],
        ];
    }

    protected function prepareForValidation(): void
    {
        $slugSource = $this->has('slug')
            ? $this->slug
            : $this->name;

        $this->merge([
            'slug' => Str::slug($slugSource),
        ]);
    }
}
