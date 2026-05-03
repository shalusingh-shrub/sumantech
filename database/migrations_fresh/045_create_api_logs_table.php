<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('api_logs', function (Blueprint $table) {
            $table->id();
            $table->string('method', 10);
            $table->string('url', 500);
            $table->string('endpoint');
            $table->string('ip_address', 45);
            $table->string('api_key', 100)->nullable();
            $table->integer('user_id')->nullable();
            $table->text('request_body')->nullable();
            $table->text('query_params')->nullable();
            $table->string('user_agent', 500)->nullable();
            $table->integer('response_status');
            $table->integer('response_time_ms')->nullable();
            $table->boolean('is_suspicious')->default(false);
            $table->text('suspicious_reason')->nullable();
            $table->timestamps();

            $table->index('endpoint');
            $table->index('ip_address');
            $table->index('is_suspicious');
            $table->index('created_at');
        });
    }

    public function down(): void {
        Schema::dropIfExists('api_logs');
    }
};