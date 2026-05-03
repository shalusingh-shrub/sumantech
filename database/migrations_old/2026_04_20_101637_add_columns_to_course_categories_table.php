<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('course_categories', function (Blueprint $table) {
            $table->foreignId('course_id')->nullable()->after('id')->constrained('courses')->onDelete('cascade');
            $table->string('program_name')->nullable()->after('name');
            $table->string('duration')->nullable()->after('program_name');
            $table->decimal('fee', 10, 2)->nullable()->after('duration');
        });
    }

    public function down(): void {
        Schema::table('course_categories', function (Blueprint $table) {
            $table->dropForeign(['course_id']);
            $table->dropColumn(['course_id', 'program_name', 'duration', 'fee']);
        });
    }
};