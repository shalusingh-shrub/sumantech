<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('awards', function (Blueprint $table) {
            if (!Schema::hasColumn('awards', 'cert_layout')) {
                $table->text('cert_layout')->nullable()->after('certificate_template');
            }
        });
        Schema::table('competitions', function (Blueprint $table) {
            if (!Schema::hasColumn('competitions', 'cert_layout')) {
                $table->text('cert_layout')->nullable()->after('audience_certificate');
            }
        });
        // Add cert_number to participants
        Schema::table('award_participants', function (Blueprint $table) {
            if (!Schema::hasColumn('award_participants', 'cert_number')) {
                $table->string('cert_number')->nullable()->after('photo');
                $table->string('generated_certificate')->nullable()->after('cert_number');
            }
        });
        Schema::table('competition_participants', function (Blueprint $table) {
            if (!Schema::hasColumn('competition_participants', 'cert_number')) {
                $table->string('cert_number')->nullable()->after('submission_file');
                $table->string('generated_certificate')->nullable()->after('cert_number');
            }
        });
    }
    public function down(): void {}
};
