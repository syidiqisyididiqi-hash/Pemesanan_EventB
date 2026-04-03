<?php

namespace App\Http\Requests\Booking;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBookingRequest extends FormRequest
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
        $this->route('booking');

        return [
            'user_id' => ['sometimes', 'exists:user,id'],
            'event_id' => ['sometimes', 'exists:event,id'],
            'booking_date' => ['sometimes', 'date'],
            'status' => [
                'sometimes',
                'in:pending, paid, cancelled'
            ]
        ];
    }
}
