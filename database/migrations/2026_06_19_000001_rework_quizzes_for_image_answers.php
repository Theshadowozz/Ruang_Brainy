<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->string('image_path')->nullable()->after('title');
            $table->string('week_label')->nullable()->after('image_path');
            $table->text('description')->nullable()->after('week_label');
            $table->timestamp('published_at')->nullable()->after('description');
        });

        Schema::table('quiz_results', function (Blueprint $table) {
            $table->text('answer_text')->nullable()->after('quiz_id');
            $table->timestamp('answered_at')->nullable()->after('answer_text');
        });

        Schema::dropIfExists('quiz_questions');
    }

    public function down(): void
    {
        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained('quizzes')->cascadeOnDelete();
            $table->text('question');
            $table->string('option_a', 255);
            $table->string('option_b', 255);
            $table->string('option_c', 255);
            $table->string('option_d', 255);
            $table->enum('correct_answer', ['a', 'b', 'c', 'd']);
            $table->timestamps();
        });

        Schema::table('quiz_results', function (Blueprint $table) {
            $table->dropColumn(['answer_text', 'answered_at']);
        });

        Schema::table('quizzes', function (Blueprint $table) {
            $table->dropColumn(['image_path', 'week_label', 'description', 'published_at']);
        });
    }
};
