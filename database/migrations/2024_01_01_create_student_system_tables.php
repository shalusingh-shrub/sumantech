<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('registration_number')->unique();
            $table->date('registration_date');
            $table->string('name');
            $table->string('father_name');
            $table->date('date_of_birth');
            $table->string('email')->nullable();
            $table->string('mobile')->unique();
            $table->string('whatsapp')->nullable();
            $table->text('address');
            $table->string('image')->nullable();
            $table->string('aadhaar_number')->nullable();
            $table->string('aadhaar_card')->nullable();
            $table->enum('gender', ['male', 'female', 'other']);
            $table->string('password');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });

        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('duration');
            $table->decimal('fee', 10, 2);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('student_courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->date('start_date');
            $table->date('end_date');
            $table->date('reg_date');
            $table->string('certificate_id')->nullable()->unique();
            $table->date('certificate_issue_date')->nullable();
            $table->string('certificate_image')->nullable();
            $table->string('marks')->nullable();
            $table->text('tally_details')->nullable();
            $table->date('certificate_receiving_date')->nullable();
            $table->boolean('regenerate_certificate')->default(false);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('cert_status', ['active', 'inactive'])->default('inactive');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_courses');
        Schema::dropIfExists('courses');
        Schema::dropIfExists('students');
    }
};
