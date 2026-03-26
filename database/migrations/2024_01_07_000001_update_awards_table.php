<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('awards', function (Blueprint $table) {
            $table->string('certificate_template')->nullable()->after('image');
            $table->boolean('has_certificate')->default(false)->after('certificate_template');
            $table->unsignedBigInteger('created_by')->nullable()->after('is_active');
            $table->unsignedBigInteger('updated_by')->nullable()->after('created_by');
        });
    }
    public function down(): void {
        Schema::table('awards', function (Blueprint $table) {
            $table->dropColumn(['certificate_template', 'has_certificate', 'created_by', 'updated_by']);
        });
    }
};
