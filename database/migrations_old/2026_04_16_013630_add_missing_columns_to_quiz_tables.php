<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {

        // Quizzes table mein columns add karo
        Schema::table('quizzes', function (Blueprint $table) {
            $table->string('slug')->unique()->nullable()->after('title');
            $table->string('certificate_title')->nullable()->after('description');
            $table->text('certificate_message')->nullable()->after('certificate_title');
        });

        // Quiz results mein columns add karo
        Schema::table('quiz_results', function (Blueprint $table) {
            $table->string('participant_school')->nullable()->after('participant_phone');
            $table->string('certificate_number')->unique()->nullable()->after('grade');
            $table->timestamp('certificate_downloaded_at')->nullable()->after('certificate_number');
        });
    }

    public function down(): void {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->dropColumn(['slug', 'certificate_title', 'certificate_message']);
        });
        Schema::table('quiz_results', function (Blueprint $table) {
            $table->dropColumn(['participant_school', 'certificate_number', 'certificate_downloaded_at']);
        });
    }
};