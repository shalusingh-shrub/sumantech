<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // new_student, new_contact, new_opinion, invoice_due
            $table->string('title');
            $table->text('message');
            $table->string('icon')->default('fas fa-bell');
            $table->string('color')->default('#1a2a6c');
            $table->string('url')->nullable();
            $table->boolean('is_read')->default(false);
            $table->unsignedBigInteger('user_id')->nullable(); // admin ko
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('notifications');
    }
};