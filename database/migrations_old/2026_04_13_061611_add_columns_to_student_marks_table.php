<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('student_marks', function (Blueprint $table) {
            $table->string('grade')->nullable()->after('obtained_marks');
            $table->string('result')->nullable()->after('grade'); // Pass/Fail/1st/2nd
            $table->text('notes')->nullable()->after('result');
        });
    }
    public function down(): void {
        Schema::table('student_marks', function (Blueprint $table) {
            $table->dropColumn(['grade', 'result', 'notes']);
        });
    }
};