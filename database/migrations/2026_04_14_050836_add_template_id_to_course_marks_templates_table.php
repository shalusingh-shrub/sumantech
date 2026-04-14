<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('course_marks_templates', function (Blueprint $table) {
            $table->string('template_id')->unique()->nullable()->after('id');
        });
    }
    public function down(): void {
        Schema::table('course_marks_templates', function (Blueprint $table) {
            $table->dropColumn('template_id');
        });
    }
};