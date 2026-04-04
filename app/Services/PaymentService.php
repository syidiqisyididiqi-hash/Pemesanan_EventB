<?php

namespace App\Services;

use App\Models\Payment;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

class PaymentService
{
    public function createPayment(array $data): Payment
    {
        $allowed = Arr::only($data, [
            'payment_code',
            'booking_id',
            'amount',
            'payment_method',
        ]);

        return Payment::create($allowed)
            ->load(['booking', 'booking.user', 'booking.event']);
    }

    public function updatePayment(Payment $payment, array $data): Payment
    {
        $allowed = Arr::only($data, [
            'payment_method',
            'status',
        ]);

        if (array_key_exists('status', $allowed)) {
            if ($allowed['status'] === 'paid') {
                $allowed['payment_date'] = Carbon::now();
            } else {
                $allowed['payment_date'] = null;
            }
        }

        $payment->update($allowed);

        return $payment->load(['booking', 'booking.user', 'booking.event']);
    }

    public function deletePayment(Payment $payment): bool
    {
        return $payment->delete();
    }

    public function listPayments(int $perPage = 10)
    {
        return Payment::with(['booking', 'booking.user', 'booking.event'])
            ->latest()
            ->paginate($perPage);
    }

    public function findPaymentOrFail(int $id): Payment
    {
        return Payment::with(['booking', 'booking.user', 'booking.event'])->findOrFail($id);
    }
}