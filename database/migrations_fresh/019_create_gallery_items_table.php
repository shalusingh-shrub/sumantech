<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('gallery_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gallery_group_id')->constrained('gallery_groups')->onDelete('cascade');
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->string('file_path')->nullable();
            $table->string('video_url')->nullable();
            $table->string('video_file')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('gallery_group_id');
            $table->index('is_active');
        });
    }

    public function down(): void {
        Schema::dropIfExists('gallery_items');
    }
};