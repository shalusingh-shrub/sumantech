<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('news_events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('short_description')->nullable();
            $table->text('excerpt')->nullable();
            $table->longText('content')->nullable();
            $table->string('image')->nullable();
            $table->string('category');
            $table->foreignId('news_category_id')->nullable()->constrained('news_categories')->onDelete('set null');
            $table->date('event_date')->nullable();
            $table->boolean('is_published')->default(false);
            $table->boolean('pin_to_home')->default(false);
            $table->date('publish_date')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

            $table->index('slug');
            $table->index('is_published');
            $table->index('pin_to_home');
        });
    }

    public function down(): void {
        Schema::dropIfExists('news_events');
    }
};