<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            if (!Schema::hasColumn('courses', 'badge_label')) {
                $table->string('badge_label')->nullable()->after('course_level');
            }

            if (!Schema::hasColumn('courses', 'icon_class')) {
                $table->string('icon_class')->nullable()->after('badge_label');
            }

            if (!Schema::hasColumn('courses', 'card_color')) {
                $table->string('card_color', 20)->nullable()->after('icon_class');
            }
        });
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            if (Schema::hasColumn('courses', 'card_color')) {
                $table->dropColumn('card_color');
            }

            if (Schema::hasColumn('courses', 'icon_class')) {
                $table->dropColumn('icon_class');
            }

            if (Schema::hasColumn('courses', 'badge_label')) {
                $table->dropColumn('badge_label');
            }
        });
    }
};
