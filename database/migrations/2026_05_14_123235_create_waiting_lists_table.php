<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('waiting_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->foreignId('schedule_id')
                ->constrained('schedules')
                ->onDelete('cascade');
            
            $table->string('full_name');
            $table->string('phone_number', 13);
            $table->string('address');

            $table->integer('queue_number');
            $table->enum('status', [
                'waiting',
                'offered',
                'accepted',
                'expired',
                'cancelled'
            ])->default('waiting');

            $table->timestamps();

            $table->unique(['user_id', 'schedule_id']);
            $table->unique(['schedule_id', 'queue_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waiting_lists');
    }
};
