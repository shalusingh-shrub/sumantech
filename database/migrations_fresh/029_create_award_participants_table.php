<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('award_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('award_id')->constrained('awards')->onDelete('cascade');
            $table->string('name');
            $table->string('category')->nullable();
            $table->string('class')->nullable();
            $table->string('school')->nullable();
            $table->string('district')->nullable();
            $table->string('state')->nullable();
            $table->string('month')->nullable();
            $table->string('cert_number')->nullable();
            $table->string('photo')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('award_id');
        });
    }

    public function down(): void {
        Schema::dropIfExists('award_participants');
    }
};