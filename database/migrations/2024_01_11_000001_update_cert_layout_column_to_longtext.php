<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCertLayoutColumnToLongtext extends Migration
{
    public function up()
    {
        Schema::table('awards', function (Blueprint $table) {
            $table->longText('cert_layout')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('awards', function (Blueprint $table) {
            $table->text('cert_layout')->nullable()->change();
        });
    }
}
