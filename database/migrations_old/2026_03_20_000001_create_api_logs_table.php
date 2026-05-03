<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('api_logs', function (Blueprint $table) {
            $table->id();
            $table->string('method', 10);          // GET, POST, etc.
            $table->string('url', 500);             // Full URL
            $table->string('endpoint', 255);        // /api/news
            $table->string('ip_address', 45);       // IPv4 / IPv6
            $table->string('api_key', 100)->nullable(); // Which API key used
            $table->integer('user_id')->nullable(); // Logged in user (agar hai)
            $table->text('request_body')->nullable(); // POST body
            $table->text('query_params')->nullable(); // GET params
            $table->string('user_agent', 500)->nullable(); // Browser/App info
            $table->integer('response_status')->default(200); // HTTP status code
            $table->integer('response_time_ms')->nullable(); // Response time
            $table->boolean('is_suspicious')->default(false); // Security alert
            $table->text('suspicious_reason')->nullable(); // Why suspicious
            $table->timestamps();

            // Indexes for fast searching
            $table->index('ip_address');
            $table->index('endpoint');
            $table->index('created_at');
            $table->index('is_suspicious');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('api_logs');
    }
};
