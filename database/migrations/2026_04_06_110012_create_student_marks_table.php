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
            $table->integer('max_marks')->default(100);
            $table->integer('obtained_marks')->default(0);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('student_marks');
    }
};