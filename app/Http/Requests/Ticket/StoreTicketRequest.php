<?php

namespace App\Http\Requests\Ticket;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
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
            'ticket_code' => ['required', 'string', 'max:50', 'unique:tickets,ticket_code'],
            'booking_id' => ['required', 'exists:bookings,id'],
            'status' => ['in:valid,used,cancelled'],
            'used_at' => ['nullable', 'date'],
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'status' => $this->status ?? 'valid',
        ]);
    }
}
