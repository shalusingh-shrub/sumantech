<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('user_course_enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('course_offering_id')->constrained('course_offerings')->onDelete('cascade');
            $table->decimal('price_locked', 10, 2);
            $table->foreignId('price_source_id')->constrained('course_price_histories')->onDelete('restrict');
            $table->unsignedInteger('duration_value');
            $table->enum('duration_unit', ['days', 'weeks', 'months', 'years'])->default('months');
            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->timestamp('enrolled_at')->useCurrent();
            $table->timestamps();

            $table->index('user_id');
            $table->index('course_offering_id');
        });
    }

    public function down(): void {
        Schema::dropIfExists('user_course_enrollments');
    }
};