<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('magazines', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('magazine_category_id')->nullable()->constrained('magazine_categories')->onDelete('set null');
            $table->string('image')->nullable();
            $table->string('file')->nullable();
            $table->date('magazine_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->text('description')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

            $table->index('is_active');
        });
    }

    public function down(): void {
        Schema::dropIfExists('magazines');
    }
};