<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('user_type', ['teacher', 'student', 'other'])->default('other')->after('phone');
            $table->string('district')->nullable()->after('user_type');
            $table->string('school')->nullable()->after('district');
            $table->string('class')->nullable()->after('school'); // for students
        });
    }
    public function down(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['user_type', 'district', 'school', 'class']);
        });
    }
};
