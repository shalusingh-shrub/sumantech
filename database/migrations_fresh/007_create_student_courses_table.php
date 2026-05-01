<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('student_courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('course_id')->nullable()->constrained('courses')->onDelete('set null');
            $table->string('course_name')->nullable();
            $table->string('course_duration')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->decimal('discount', 10, 2)->default(0);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->decimal('overall_percentage', 5, 1)->nullable();
            $table->date('reg_date')->nullable();
            $table->string('certificate_id')->unique()->nullable();
            $table->date('certificate_issue_date')->nullable();
            $table->string('certificate_image')->nullable();
            $table->string('marks')->nullable();
            $table->text('tally_details')->nullable();
            $table->date('certificate_receiving_date')->nullable();
            $table->boolean('regenerate_certificate')->default(false);
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->enum('cert_status', ['Active', 'Inactive', 'Pending'])->default('Pending');
            $table->timestamps();

            $table->index('user_id');
            $table->index('course_id');
            $table->index('status');
        });
    }

    public function down(): void {
        Schema::dropIfExists('student_courses');
    }
};