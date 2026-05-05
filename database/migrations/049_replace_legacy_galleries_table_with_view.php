<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('gallery_groups') || ! Schema::hasTable('gallery_items')) {
            return;
        }

        $legacyTable = DB::selectOne(
            "SELECT TABLE_TYPE AS table_type
             FROM information_schema.TABLES
             WHERE TABLE_SCHEMA = DATABASE()
               AND TABLE_NAME = 'galleries'"
        );

        if ($legacyTable && strtoupper($legacyTable->table_type) === 'BASE TABLE') {
            DB::table('galleries')->orderBy('id')->get()->each(function ($gallery) {
                $category = $gallery->category ?: 'general';
                $type = $gallery->type === 'image' ? 'image' : 'video';
                $slug = Str::slug($category) ?: 'general';

                $groupId = DB::table('gallery_groups')->where('slug', $slug)->value('id');

                if (! $groupId) {
                    $groupId = DB::table('gallery_groups')->insertGetId([
                        'name' => ucwords(str_replace(['-', '_'], ' ', $category)),
                        'slug' => $slug,
                        'type' => $type,
                        'is_active' => (bool) ($gallery->is_active ?? true),
                        'created_at' => $gallery->created_at ?? now(),
                        'updated_at' => $gallery->updated_at ?? now(),
                    ]);
                }

                $exists = DB::table('gallery_items')
                    ->where('gallery_group_id', $groupId)
                    ->where('title', $gallery->title)
                    ->exists();

                if (! $exists) {
                    DB::table('gallery_items')->insert([
                        'gallery_group_id' => $groupId,
                        'title' => $gallery->title,
                        'slug' => Str::slug($gallery->title ?: 'gallery-item') . '-' . uniqid(),
                        'file_path' => $gallery->image ? 'gallery/' . $gallery->image : null,
                        'video_url' => $gallery->video_url ?? null,
                        'sort_order' => 0,
                        'is_active' => (bool) ($gallery->is_active ?? true),
                        'created_at' => $gallery->created_at ?? now(),
                        'updated_at' => $gallery->updated_at ?? now(),
                    ]);
                }
            });

            Schema::drop('galleries');
        }

        DB::statement('DROP VIEW IF EXISTS galleries');
        DB::statement("
            CREATE VIEW galleries AS
            SELECT
                gi.id,
                gi.title,
                CASE
                    WHEN gi.file_path LIKE 'gallery/%' THEN SUBSTRING(gi.file_path, 9)
                    ELSE gi.file_path
                END AS image,
                gi.video_url,
                CASE
                    WHEN gg.type = 'video' AND gi.file_path IS NOT NULL THEN 'media'
                    ELSE gg.type
                END AS type,
                gg.slug AS category,
                gi.is_active,
                NULL AS created_by,
                NULL AS updated_by,
                gi.created_at,
                gi.updated_at
            FROM gallery_items gi
            INNER JOIN gallery_groups gg ON gg.id = gi.gallery_group_id
        ");
    }

    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS galleries');
    }
};
