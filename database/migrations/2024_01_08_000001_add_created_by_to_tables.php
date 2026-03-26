<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        $tables = ['sliders', 'top_flashes', 'news_events', 'publications', 'magazines', 'galleries', 'team_members', 'useful_links', 'good_luck_messages', 'eip_resources', 'quizzes', 'pages', 'testimonials'];
        foreach ($tables as $table) {
            if (Schema::hasTable($table) && !Schema::hasColumn($table, 'created_by')) {
                Schema::table($table, function (Blueprint $t) {
                    $t->unsignedBigInteger('created_by')->nullable();
                    $t->unsignedBigInteger('updated_by')->nullable();
                });
            }
        }
    }
    public function down(): void {}
};
