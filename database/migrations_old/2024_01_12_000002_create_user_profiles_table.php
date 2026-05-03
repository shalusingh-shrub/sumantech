<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // Personal
            $table->string('avatar')->nullable();
            $table->string('gender')->nullable();
            $table->date('dob')->nullable();
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('alternate_mobile')->nullable();
            $table->string('state')->default('Bihar');
            $table->string('district')->nullable();
            $table->string('block')->nullable();
            $table->string('pincode')->nullable();
            $table->string('panchayat')->nullable();
            $table->string('village')->nullable();
            $table->text('address')->nullable();
            // Education
            $table->string('highest_education')->nullable();
            $table->string('college')->nullable();
            $table->string('subject')->nullable();
            $table->year('pass_year')->nullable();
            $table->string('designation')->nullable();
            $table->string('department')->nullable();
            $table->string('school')->nullable();
            $table->string('employee_id')->nullable();
            $table->text('bio')->nullable();
            // Social
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('youtube')->nullable();
            $table->timestamps();
        });

        Schema::create('user_achievements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('category')->nullable();
            $table->string('achievement_type')->default('self'); // self, school, district
            $table->text('description')->nullable();
            $table->date('achievement_date')->nullable();
            $table->string('file')->nullable(); // image or pdf
            $table->timestamps();
        });

        Schema::create('user_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('description');
            $table->string('event');
            $table->string('subject')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('user_activities');
        Schema::dropIfExists('user_achievements');
        Schema::dropIfExists('user_profiles');
    }
};
