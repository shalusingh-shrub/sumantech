<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('competitions', function (Blueprint $table) {
            $table->text('event_selection_category')->nullable()->after('registration_link');
            $table->text('participation_category')->nullable()->after('event_selection_category');
            $table->string('winner_certificate')->nullable()->after('participation_category');
            $table->string('participation_certificate')->nullable()->after('winner_certificate');
            $table->string('audience_certificate')->nullable()->after('participation_certificate');
            $table->boolean('is_participation_cert_allow')->default(false)->after('audience_certificate');
            $table->boolean('is_auto_gen_certificate')->default(false)->after('is_participation_cert_allow');
        });
    }
    public function down(): void {
        Schema::table('competitions', function (Blueprint $table) {
            $table->dropColumn(['event_selection_category', 'participation_category', 'winner_certificate', 'participation_certificate', 'audience_certificate', 'is_participation_cert_allow', 'is_auto_gen_certificate']);
        });
    }
};
