<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inaugurations', function (Blueprint $table) {
            $table->string('message_position')->default('middle')->after('scope');
            $table->string('content_align')->default('center')->after('message_position');
        });
    }

    public function down(): void
    {
        Schema::table('inaugurations', function (Blueprint $table) {
            $table->dropColumn(['message_position', 'content_align']);
        });
    }
};
