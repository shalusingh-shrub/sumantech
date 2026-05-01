<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('course_offerings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->unsignedInteger('duration_value');
            $table->enum('duration_unit', ['days', 'weeks', 'months', 'years'])->default('months');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('course_id');
            $table->index('is_active');
        });
    }

    public function down(): void {
        Schema::dropIfExists('course_offerings');
    }
};