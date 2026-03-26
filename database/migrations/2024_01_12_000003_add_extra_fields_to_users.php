<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'user_type')) {
                $table->enum('user_type', ['teacher','student','other'])->default('other')->after('phone');
            }
            if (!Schema::hasColumn('users', 'district')) {
                $table->string('district')->nullable()->after('user_type');
            }
            if (!Schema::hasColumn('users', 'school')) {
                $table->string('school')->nullable()->after('district');
            }
            if (!Schema::hasColumn('users', 'class')) {
                $table->string('class')->nullable()->after('school');
            }
            if (!Schema::hasColumn('users', 'can_access_admin')) {
                $table->boolean('can_access_admin')->default(false)->after('is_active');
            }
        });
    }
    public function down(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['user_type','district','school','class','can_access_admin']);
        });
    }
};
