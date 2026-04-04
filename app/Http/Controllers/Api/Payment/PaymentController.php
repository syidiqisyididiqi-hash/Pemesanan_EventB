<?php

namespace App\Http\Controllers\Api\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\StorePaymentRequest;
use App\Http\Requests\Payment\UpdatePaymentRequest;
use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Http\JsonResponse;

class PaymentController extends Controller
{
    protected PaymentService $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'message' => 'Daftar pembayaran',
            'data' => $this->paymentService->listPayments()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentRequest $request)
    {
        $payment = $this->paymentService->createPayment($request->validated());

        return response()->json([
            'message' => 'Pembayaran berhasil dibuat',
            'data' => $payment
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment): JsonResponse
    {
        $payment->load(['booking', 'booking.user', 'booking.event']);

        return response()->json([
            'message' => 'Pembayaran ditemukan',
            'data' => $payment
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentRequest $request, Payment $payment): JsonResponse
    {
        $payment = $this->paymentService->updatePayment($payment, $request->validated());

        return response()->json([
            'message' => 'Pembayaran berhasil diperbarui',
            'data' => $payment
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment): JsonResponse
    {
        $this->paymentService->deletePayment($payment);

        return response()->json(null, 204);
    }
}
