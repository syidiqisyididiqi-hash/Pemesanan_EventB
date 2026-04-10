<?php

namespace App\Services;

use App\Models\Payment;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class PaymentService
{
    public function createPayment(array $data): Payment
    {
        $allowed = Arr::only($data, [
            'booking_id',
            'amount',
            'payment_method',
        ]);

        $allowed['payment_code'] = $this->generatePaymentCode();
        $allowed['status'] = 'unpaid';
        $allowed['payment_date'] = null;

        return Payment::create($allowed)
            ->load(['booking.user', 'booking.event']);
    }

    public function updatePayment(Payment $payment, array $data): Payment
    {
        $allowed = Arr::only($data, [
            'booking_id',
            'amount',
            'payment_method',
            'status',
        ]);

        if ($payment->status === 'paid' && isset($allowed['status']) && $allowed['status'] !== 'paid') {
            abort(400, 'Paid payment cannot be modified.');
        }

        $payment->fill($allowed);

        if (isset($allowed['status'])) {
            if ($allowed['status'] === 'paid') {
                $payment->payment_date = Carbon::now();
            } else {
                $payment->payment_date = null;
            }
        }

        $payment->save();

        return $payment->load(['booking.user', 'booking.event']);
    }

    public function deletePayment(Payment $payment): bool
    {
        return $payment->delete();
    }

    public function listPayments(int $perPage = 10)
    {
        return Payment::with(['booking.user', 'booking.event'])
            ->latest()
            ->paginate($perPage);
    }

    public function findPaymentOrFail(int $id): Payment
    {
        return Payment::with(['booking.user', 'booking.event'])
            ->findOrFail($id);
    }

    private function generatePaymentCode(): string
    {
        do {
            $code = 'PAY-' . strtoupper(Str::random(8));
        } while (Payment::where('payment_code', $code)->exists());

        return $code;
    }
}