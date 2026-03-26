<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('competition_participants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('competition_id');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('school')->nullable();
            $table->string('district')->nullable();
            $table->string('category')->nullable();
            $table->string('submission_file')->nullable();
            $table->string('status')->default('pending'); // pending, approved, winner, rejected
            $table->text('remarks')->nullable();
            $table->timestamps();
            $table->foreign('competition_id')->references('id')->on('competitions')->onDelete('cascade');
        });
    }
    public function down(): void { Schema::dropIfExists('competition_participants'); }
};
