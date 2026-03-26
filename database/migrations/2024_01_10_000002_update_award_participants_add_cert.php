<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('award_participants', function (Blueprint $table) {
            if (!Schema::hasColumn('award_participants', 'cert_number')) {
                $table->string('cert_number')->nullable()->after('month');
            }
        });
        // Add cert_layout to awards table
        Schema::table('awards', function (Blueprint $table) {
            if (!Schema::hasColumn('awards', 'cert_layout')) {
                $table->text('cert_layout')->nullable();
            }
        });
    }
    public function down(): void {}
};
