<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('student_marks', function (Blueprint $table) {
            if (!Schema::hasColumn('student_marks', 'percentage')) {
                $table->decimal('percentage', 5, 2)->nullable()->after('obtained_marks');
            }
        });
    }

    public function down(): void {
        Schema::table('student_marks', function (Blueprint $table) {
            if (Schema::hasColumn('student_marks', 'percentage')) {
                $table->dropColumn('percentage');
            }
        });
    }
};