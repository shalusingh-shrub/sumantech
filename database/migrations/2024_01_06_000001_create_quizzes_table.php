<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('category')->nullable();
            $table->string('thumbnail')->nullable();
            $table->integer('time_limit')->default(0)->comment('minutes, 0=unlimited');
            $table->integer('pass_percentage')->default(50);
            $table->boolean('randomize_questions')->default(false);
            $table->boolean('randomize_options')->default(false);
            $table->boolean('show_result')->default(true);
            $table->boolean('allow_retake')->default(true);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->enum('status', ['active','inactive','draft'])->default('active');
            $table->integer('total_views')->default(0);
            $table->integer('total_attempts')->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('quizzes');
    }
};