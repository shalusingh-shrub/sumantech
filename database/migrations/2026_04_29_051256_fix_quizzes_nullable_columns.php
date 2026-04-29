<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {

        // quiz_name nullable karo
        Schema::table('quizzes', function (Blueprint $table) {
            $table->string('quiz_name')->nullable()->default(null)->change();
            $table->integer('quiz_taken')->default(0)->change();
            $table->integer('quiz_views')->default(0)->change();
            $table->integer('total_views')->default(0)->change();
            $table->integer('total_attempts')->default(0)->change();
        });

        // Existing records mein quiz_name update karo
        DB::table('quizzes')
            ->whereNull('quiz_name')
            ->orWhere('quiz_name', '')
            ->update(['quiz_name' => DB::raw('title')]);
    }

    public function down(): void {}
};