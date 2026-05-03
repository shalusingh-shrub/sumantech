<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('student_courses', function (Blueprint $table) {
            if (!Schema::hasColumn('student_courses', 'course_name')) {
                $table->string('course_name')->nullable()->after('user_id');
            }
            if (!Schema::hasColumn('student_courses', 'course_duration')) {
                $table->string('course_duration')->nullable()->after('course_name');
            }
        });
    }

    public function down(): void {
        Schema::table('student_courses', function (Blueprint $table) {
            if (Schema::hasColumn('student_courses', 'course_name')) {
                $table->dropColumn('course_name');
            }
            if (Schema::hasColumn('student_courses', 'course_duration')) {
                $table->dropColumn('course_duration');
            }
        });
    }
};