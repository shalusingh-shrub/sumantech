<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('courses', function (Blueprint $table) {
            $table->json('syllabus')->nullable()->after('highlights');
            $table->string('course_level')->nullable()->after('syllabus');
            $table->text('career_opportunities')->nullable()->after('course_level');
            $table->text('eligibility')->nullable()->after('career_opportunities');
        });
    }

    public function down(): void {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn(['syllabus', 'course_level', 'career_opportunities', 'eligibility']);
        });
    }
};