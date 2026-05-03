<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->string('title')->nullable()->after('id');
            $table->string('category')->nullable()->after('title');
            $table->string('thumbnail')->nullable()->after('category');
            $table->integer('time_limit')->default(0)->after('thumbnail');
            $table->integer('pass_percentage')->default(50)->after('time_limit');
            $table->boolean('randomize_questions')->default(false)->after('pass_percentage');
            $table->boolean('randomize_options')->default(false)->after('randomize_questions');
            $table->boolean('show_result')->default(true)->after('randomize_options');
            $table->boolean('allow_retake')->default(true)->after('show_result');
            $table->date('start_date')->nullable()->after('allow_retake');
            $table->date('end_date')->nullable()->after('start_date');
            $table->enum('status', ['active','inactive','draft'])->default('active')->after('end_date');
            $table->integer('total_views')->default(0)->after('status');
            $table->integer('total_attempts')->default(0)->after('total_views');
        });
    }

    public function down(): void {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->dropColumn([
                'title','category','thumbnail','time_limit','pass_percentage',
                'randomize_questions','randomize_options','show_result','allow_retake',
                'start_date','end_date','status','total_views','total_attempts'
            ]);
        });
    }
};