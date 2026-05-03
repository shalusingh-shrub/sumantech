<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('user_achievements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->string('category')->nullable();
            $table->string('achievement_type');
            $table->text('description')->nullable();
            $table->date('achievement_date')->nullable();
            $table->string('file')->nullable();
            $table->timestamps();

            $table->index('user_id');
        });
    }

    public function down(): void {
        Schema::dropIfExists('user_achievements');
    }
};