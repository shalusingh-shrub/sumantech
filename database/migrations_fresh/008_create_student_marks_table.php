<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('student_marks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_course_id')->constrained('student_courses')->onDelete('cascade');
            $table->string('subject_name');
            $table->integer('max_marks');
            $table->integer('obtained_marks');
            $table->decimal('percentage', 5, 2)->nullable();
            $table->string('grade')->nullable();
            $table->string('result')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('student_course_id');
        });
    }

    public function down(): void {
        Schema::dropIfExists('student_marks');
    }
};