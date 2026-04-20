<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // Table already exists, skip
        if (!Schema::hasTable('course_categories')) {
            Schema::create('course_categories', function (Blueprint $table) {
                $table->id();
                $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
                $table->string('name');
                $table->string('slug')->nullable();
                $table->string('program_name')->nullable();
                $table->string('duration')->nullable();
                $table->decimal('fee', 10, 2)->nullable();
                $table->text('description')->nullable();
                $table->string('image')->nullable();
                $table->boolean('is_active')->default(true);
                $table->integer('sort_order')->default(0);
                $table->timestamps();
            });
        }
    }

    public function down(): void {
        Schema::dropIfExists('course_categories');
    }
};