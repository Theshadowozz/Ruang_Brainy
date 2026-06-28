<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

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
            'pendingTotal' => $payments->where('status', 'pending')->sum('amount'),
            'paidTotal' => $payments->where('status', 'paid')->sum('amount'),
        ]);
    }

    public function confirm(Payment $payment)
    {
        abort_unless($payment->transaction_code, 422, 'Siswa belum melakukan pembayaran.');

        DB::transaction(function () use ($payment) {
            $payment->update([
                'status' => 'paid',
                'paid_at' => now(),
            ]);

            $payment->registration->update(['status' => 'accepted']);
            $payment->registration->user->update(['is_active' => true]);
        });

        return back()->with('success', 'Pembayaran dikonfirmasi dan akun siswa telah diaktifkan.');
    }

    public function reject(Payment $payment)
    {
        DB::transaction(function () use ($payment) {
            $payment->update(['status' => 'failed']);
            $payment->registration->update(['status' => 'rejected']);
            $payment->registration->user->update(['is_active' => false]);
        });

        return back()->with('success', 'Pembayaran ditolak dan akun siswa tetap nonaktif.');
    }
}
