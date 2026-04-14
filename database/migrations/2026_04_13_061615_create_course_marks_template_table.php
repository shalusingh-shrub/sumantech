<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('course_marks_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->nullable()->constrained('courses')->onDelete('cascade');
            $table->string('course_name'); // for custom courses
            $table->json('subjects'); // [{name, max_marks}]
            $table->json('grade_standards'); // [{grade, min%, max%, result}]
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('course_marks_templates');
    }
};