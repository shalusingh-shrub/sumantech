<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('course_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->nullable()->constrained('courses')->onDelete('set null');
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('program_name')->nullable();
            $table->string('duration')->nullable();
            $table->decimal('fee', 10, 2)->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('color', 20)->default('#1a2a6c');
            $table->string('icon', 50)->default('fa-book');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('is_active');
            $table->index('sort_order');
        });
    }

    public function down(): void {
        Schema::dropIfExists('course_categories');
    }
};