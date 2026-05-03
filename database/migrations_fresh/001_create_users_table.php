<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role', ['admin', 'student', 'teacher'])->default('student');
            $table->enum('user_type', ['teacher', 'student', 'other'])->default('other');
            $table->string('phone')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('can_access_admin')->default(false);
            $table->string('api_token', 80)->unique()->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->index('role');
            $table->index('user_type');
            $table->index('is_active');
        });
    }

    public function down(): void {
        Schema::dropIfExists('users');
    }
};