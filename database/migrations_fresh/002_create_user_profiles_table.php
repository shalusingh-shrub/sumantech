<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('registration_number')->nullable()->unique();
            $table->date('registration_date')->nullable();
            $table->string('avatar')->nullable();
            $table->string('image')->nullable();
            $table->string('aadhaar_number')->nullable();
            $table->string('aadhaar_card')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->string('gender')->nullable();
            $table->date('dob')->nullable();
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('mobile', 20)->nullable();
            $table->string('whatsapp', 20)->nullable();
            $table->string('alternate_mobile')->nullable();
            $table->string('state')->nullable();
            $table->string('district')->nullable();
            $table->string('block')->nullable();
            $table->string('pincode')->nullable();
            $table->string('panchayat')->nullable();
            $table->string('village')->nullable();
            $table->text('address')->nullable();
            $table->string('highest_education')->nullable();
            $table->string('college')->nullable();
            $table->string('subject')->nullable();
            $table->year('pass_year')->nullable();
            $table->string('designation')->nullable();
            $table->string('department')->nullable();
            $table->string('school')->nullable();
            $table->string('class')->nullable();
            $table->string('employee_id')->nullable();
            $table->text('bio')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('youtube')->nullable();
            $table->timestamps();

            $table->index('registration_number');
            $table->index('status');
        });
    }

    public function down(): void {
        Schema::dropIfExists('user_profiles');
    }
};