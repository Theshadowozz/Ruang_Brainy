<?php

namespace App\Http\Controllers;

use App\Services\PaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class MidtransWebhookController extends Controller
{
    public function __invoke(Request $request, PaymentService $service): JsonResponse
    {
        try {
            $payment = $service->handleNotification($request->all());
        } catch (ValidationException $exception) {
            return response()->json([
                'message' => $exception->validator->errors()->first(),
            ], 422);
        }

        return response()->json([
            'message' => 'Notification processed.',
            'order_id' => $payment->order_id,
            'status' => $payment->status,
        ]);
    }
}
