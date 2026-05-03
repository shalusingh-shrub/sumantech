<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('student_courses', function (Blueprint $table) {
            $table->decimal('overall_percentage', 5, 1)->nullable()->after('end_date');
        });
    }
    public function down(): void {
        Schema::table('student_courses', function (Blueprint $table) {
            $table->dropColumn('overall_percentage');
        });
    }
};