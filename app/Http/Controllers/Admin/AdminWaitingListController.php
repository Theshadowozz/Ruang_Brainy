<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Registration;
use App\Models\WaitingList;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminWaitingListController extends Controller
{
    public function __invoke()
    {
        return view('admin.waitinglist', [
            'waitingLists' => WaitingList::query()
                ->with(['user', 'schedule.courseClass', 'user.registrations.latestPayment'])
                ->orderBy('schedule_id')
                ->orderBy('queue_number')
                ->get(),
        ]);
    }

    public function promote(WaitingList $waitingList, PaymentService $service)
    {
        $service->promoteWaitingList($waitingList);

        return back()->with('success', 'Siswa dipromosikan ke kelas dan masa akses satu bulan dimulai.');
    }

    public function recordRefund(Request $request, WaitingList $waitingList)
    {
        $validated = $request->validate([
            'refund_id' => ['required', 'string', 'max:255'],
            'refund_note' => ['nullable', 'string', 'max:1000'],
        ]);

        DB::transaction(function () use ($waitingList, $validated) {
            $waitingList = WaitingList::query()->lockForUpdate()->findOrFail($waitingList->id);
            $registration = Registration::query()
                ->where('user_id', $waitingList->user_id)
                ->where('schedule_id', $waitingList->schedule_id)
                ->lockForUpdate()
                ->firstOrFail();
            $payment = $registration->payments()
                ->where('status', Payment::STATUS_PAID)
                ->latest('paid_at')
                ->lockForUpdate()
                ->firstOrFail();

            abort_unless($waitingList->status === WaitingList::STATUS_WAITING, 422, 'Antrean ini tidak dapat direfund.');

            $payment->update([
                'status' => Payment::STATUS_CANCELLED,
                'refund_id' => $validated['refund_id'],
                'refund_amount' => $payment->amount,
                'refund_requested_at' => now(),
                'refunded_at' => now(),
                'refund_note' => $validated['refund_note'] ?? null,
            ]);
            $waitingList->update(['status' => WaitingList::STATUS_CANCELLED]);
            $registration->update(['status' => Registration::STATUS_REJECTED]);

            $hasAccepted = $registration->user->registrations()
                ->where('status', Registration::STATUS_ACCEPTED)
                ->exists();
            $registration->user->update(['is_active' => $hasAccepted]);
        });

        return back()->with('success', 'Refund manual dicatat. Pastikan refund sudah selesai di Midtrans Dashboard.');
    }
}
