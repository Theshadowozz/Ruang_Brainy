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
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('language', ['Inggris', 'Jepang', 'Korea']);
            $table->enum('level', ['Beginner', 'Intermediate', 'Advance']);
            
            $table->foreignId('tutor_id')
                ->constrained('tutors')
                ->onDelete('cascade');

            $table->decimal('price', 10, 2);
            $table->text('description');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
