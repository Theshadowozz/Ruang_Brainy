<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;

class AdminPaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::query()
            ->with(['registration.user', 'registration.schedule.courseClass'])
            ->latest()
            ->get();

        return view('admin.payments', [
            'payments' => $payments,
            'pendingTotal' => $payments->where('status', Payment::STATUS_PENDING)->sum('amount'),
            'paidTotal' => $payments->where('status', Payment::STATUS_PAID)->sum('amount'),
            'refundedTotal' => $payments->whereNotNull('refunded_at')->sum(fn (Payment $payment) => $payment->refund_amount ?? $payment->amount),
        ]);
    }
}
