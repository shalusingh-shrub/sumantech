<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('course_marks_templates', function (Blueprint $table) {
            $table->id();
            $table->string('template_id')->unique()->nullable();
            $table->foreignId('course_id')->nullable()->constrained('courses')->onDelete('set null');
            $table->string('course_name');
            $table->json('subjects');
            $table->json('grade_standards');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('course_id');
        });
    }

    public function down(): void {
        Schema::dropIfExists('course_marks_templates');
    }
};