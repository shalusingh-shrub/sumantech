<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('competitions', function (Blueprint $table) {
            $table->date('start_date')->nullable()->after('description');
            $table->date('end_date')->nullable()->after('start_date');
            $table->date('result_date')->nullable()->after('end_date');
            $table->string('registration_link')->nullable()->after('result_date');
            $table->unsignedBigInteger('created_by')->nullable()->after('is_active');
            $table->unsignedBigInteger('updated_by')->nullable()->after('created_by');
        });
    }
    public function down(): void {
        Schema::table('competitions', function (Blueprint $table) {
            $table->dropColumn(['start_date', 'end_date', 'result_date', 'registration_link', 'created_by', 'updated_by']);
        });
    }
};
