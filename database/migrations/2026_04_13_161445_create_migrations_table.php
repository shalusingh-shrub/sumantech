<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
<<<<<<<< HEAD:database/migrations/2026_04_14_123110_add_slug_to_courses_table.php
        Schema::table('courses', function (Blueprint $table) {
            //
========
        if (Schema::hasTable('migrations')) {
            return;
        }

        Schema::create('migrations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('migration');
            $table->integer('batch');
>>>>>>>> main:database/migrations/2026_04_13_161445_create_migrations_table.php
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
<<<<<<<< HEAD:database/migrations/2026_04_14_123110_add_slug_to_courses_table.php
        Schema::table('courses', function (Blueprint $table) {
            //
        });
========
        Schema::dropIfExists('migrations');
>>>>>>>> main:database/migrations/2026_04_13_161445_create_migrations_table.php
    }
};
