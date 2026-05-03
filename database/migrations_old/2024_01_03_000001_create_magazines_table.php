<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('magazine_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('magazines', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('magazine_category_id')->nullable();
            $table->string('image')->nullable();
            $table->string('file')->nullable();
            $table->date('magazine_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->text('description')->nullable();
            $table->timestamps();
            $table->foreign('magazine_category_id')->references('id')->on('magazine_categories')->onDelete('set null');
        });
    }
    public function down(): void {
        Schema::dropIfExists('magazines');
        Schema::dropIfExists('magazine_categories');
    }
};
