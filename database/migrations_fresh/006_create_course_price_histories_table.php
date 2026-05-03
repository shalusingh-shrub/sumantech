<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('course_price_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_offering_id')->constrained('course_offerings')->onDelete('cascade');
            $table->decimal('price', 10, 2);
            $table->timestamp('effective_from')->useCurrent();
            $table->timestamp('effective_to')->nullable();
            $table->timestamps();

            $table->index(['course_offering_id', 'effective_to']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('course_price_histories');
    }
};