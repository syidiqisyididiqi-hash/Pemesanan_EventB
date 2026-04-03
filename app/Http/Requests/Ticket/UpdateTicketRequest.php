<?php

namespace App\Http\Requests\Ticket;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTicketRequest extends FormRequest
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
        $ticketId = $this->route('ticket')->id;

        return [
            'ticket_code' => [
                'sometimes',
                'string',
                'max:50',
                Rule::unique('tickets', 'ticket_code')->ignore($ticketId),
            ],
            'booking_id' => ['sometimes', 'exists:bookings,id'],
            'status' => ['sometimes', 'in:valid,used,cancelled'],
            'used_at' => ['nullable', 'date'],
        ];
    }
}
