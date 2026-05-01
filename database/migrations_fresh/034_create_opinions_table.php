<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('opinions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('district')->nullable();
            $table->string('school')->nullable();
            $table->text('opinion');
            $table->boolean('is_approved')->default(false);
            $table->timestamps();

            $table->index('is_approved');
        });
    }

    public function down(): void {
        Schema::dropIfExists('opinions');
    }
};