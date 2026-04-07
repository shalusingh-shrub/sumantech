<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Students soft delete
        Schema::table('students', function (Blueprint $table) {
            $table->softDeletes();
        });

        // Invoices soft delete
        Schema::table('invoices', function (Blueprint $table) {
            $table->softDeletes();
        });

        // Invoice payments soft delete
        Schema::table('invoice_payments', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('invoice_payments', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
