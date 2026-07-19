<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('type')->default('initial')->after('registration_id');
            $table->decimal('subtotal', 10, 2)->default(0)->after('type');
            $table->decimal('admin_fee', 10, 2)->default(0)->after('subtotal');
            $table->string('order_id')->nullable()->unique()->after('transaction_code');
            $table->string('access_token')->nullable()->unique()->after('order_id');
            $table->string('snap_token')->nullable()->after('access_token');
            $table->timestamp('snap_token_created_at')->nullable()->after('snap_token');
            $table->string('midtrans_transaction_id')->nullable()->index()->after('snap_token_created_at');
            $table->string('midtrans_status')->nullable()->after('midtrans_transaction_id');
            $table->string('midtrans_status_code')->nullable()->after('midtrans_status');
            $table->string('midtrans_fraud_status')->nullable()->after('midtrans_status_code');
            $table->json('midtrans_payload')->nullable()->after('midtrans_fraud_status');
            $table->timestamp('expires_at')->nullable()->after('midtrans_payload');
            $table->timestamp('refunded_at')->nullable()->after('expires_at');
            $table->string('refund_id')->nullable()->after('refunded_at');
            $table->decimal('refund_amount', 10, 2)->nullable()->after('refund_id');
            $table->timestamp('refund_requested_at')->nullable()->after('refund_amount');
            $table->text('refund_note')->nullable()->after('refund_requested_at');
        });

        Schema::table('registrations', function (Blueprint $table) {
            $table->timestamp('access_starts_at')->nullable()->after('status');
            $table->timestamp('access_ends_at')->nullable()->after('access_starts_at');
            $table->timestamp('seat_reserved_until')->nullable()->after('access_ends_at');
        });

        DB::table('classes')->orderBy('id')->each(function ($course) {
            $price = match (strtolower((string) $course->level)) {
                'beginner' => 350000,
                'intermediate' => 375000,
                'advance' => 400000,
                default => null,
            };

            if ($price !== null) {
                DB::table('classes')->where('id', $course->id)->update(['price' => $price]);
            }
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropUnique(['order_id']);
            $table->dropUnique(['access_token']);
            $table->dropIndex(['midtrans_transaction_id']);
            $table->dropColumn([
                'type', 'subtotal', 'admin_fee', 'order_id', 'access_token', 'snap_token',
                'snap_token_created_at', 'midtrans_transaction_id', 'midtrans_status',
                'midtrans_status_code', 'midtrans_fraud_status', 'midtrans_payload',
                'expires_at', 'refunded_at', 'refund_id', 'refund_amount', 'refund_requested_at', 'refund_note',
            ]);
        });

        Schema::table('registrations', function (Blueprint $table) {
            $table->dropColumn(['access_starts_at', 'access_ends_at', 'seat_reserved_until']);
        });
    }
};
