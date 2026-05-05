<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('quiz_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained('quizzes')->onDelete('cascade');
            $table->string('participant_name')->nullable();
            $table->string('participant_email')->nullable();
            $table->string('participant_phone')->nullable();
            $table->string('participant_school')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->integer('total_questions');
            $table->integer('attempted')->default(0);
            $table->integer('correct')->default(0);
            $table->integer('wrong')->default(0);
            $table->integer('score')->default(0);
            $table->integer('total_marks')->default(0);
            $table->decimal('percentage', 5, 2)->default(0);
            $table->string('grade')->nullable();
            $table->string('certificate_number')->unique()->nullable();
            $table->timestamp('certificate_downloaded_at')->nullable();
            $table->enum('result', ['pass', 'fail'])->default('fail');
            $table->integer('time_taken')->default(0);
            $table->json('answers')->nullable();
            $table->string('ip_address')->nullable();
            $table->timestamps();

            $table->index('quiz_id');
            $table->index('participant_email');
            $table->index('certificate_number');
        });
    }

    public function down(): void {
        Schema::dropIfExists('quiz_results');
    }
};