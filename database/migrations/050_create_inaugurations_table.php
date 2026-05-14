<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('inaugurations')) {
            Schema::create('inaugurations', function (Blueprint $table) {
                $table->id();
                $table->string('title')->nullable();
                $table->text('message');
                $table->string('poster_path');
                $table->string('password_hash');
                $table->boolean('is_enabled')->default(false);
                $table->string('scope')->default('all');
                $table->string('message_position')->default('middle');
                $table->string('content_align')->default('center');
                $table->json('route_names')->nullable();
                $table->json('paths')->nullable();
                $table->unsignedBigInteger('added_by')->nullable();
                $table->unsignedBigInteger('updated_by')->nullable();
                $table->timestamps();
            });
        }

        $this->seedPermission();
    }

    public function down(): void
    {
        Schema::dropIfExists('inaugurations');
    }

    private function seedPermission(): void
    {
        if (!Schema::hasTable('permissions')) {
            return;
        }

        if (class_exists(\Spatie\Permission\PermissionRegistrar::class)) {
            app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        }

        $permissionId = DB::table('permissions')->where('name', 'manage_inaugurations')->value('id');

        if (!$permissionId) {
            $permissionId = DB::table('permissions')->insertGetId([
                'name' => 'manage_inaugurations',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        if (!Schema::hasTable('roles') || !Schema::hasTable('role_has_permissions')) {
            return;
        }

        DB::table('roles')
            ->whereIn('name', ['super_admin', 'admin'])
            ->pluck('id')
            ->each(function ($roleId) use ($permissionId) {
                $exists = DB::table('role_has_permissions')
                    ->where('permission_id', $permissionId)
                    ->where('role_id', $roleId)
                    ->exists();

                if (!$exists) {
                    DB::table('role_has_permissions')->insert([
                        'permission_id' => $permissionId,
                        'role_id' => $roleId,
                    ]);
                }
            });

        if (class_exists(\Spatie\Permission\PermissionRegistrar::class)) {
            app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        }
    }
};
