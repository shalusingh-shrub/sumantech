<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('award_participants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('award_id');
            $table->string('name');
            $table->string('category')->nullable();    // Drawing, Model Making, Poem writing
            $table->string('class')->nullable();       // Class VIII, Class IV
            $table->string('school')->nullable();
            $table->string('district')->nullable();
            $table->string('state')->nullable();
            $table->string('month')->nullable();       // Feb 2025, Mar 2025
            $table->string('photo')->nullable();       // participant photo
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->foreign('award_id')->references('id')->on('awards')->onDelete('cascade');
        });
    }
    public function down(): void { Schema::dropIfExists('award_participants'); }
};
