<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Inauguration extends Model
{
    public const SCOPE_ALL = 'all';
    public const SCOPE_SELECTED = 'selected';

    protected $fillable = [
        'title',
        'message',
        'poster_path',
        'password_hash',
        'is_enabled',
        'scope',
        'message_position',
        'content_align',
        'route_names',
        'paths',
        'added_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'is_enabled' => 'boolean',
            'route_names' => 'array',
            'paths' => 'array',
        ];
    }

    public static function activeForRequest(Request $request): ?self
    {
        if (!Schema::hasTable('inaugurations')) {
            static::ensureTableExists();
        }

        $event = Cache::rememberForever('inauguration.active', function () {
            return static::query()->where('is_enabled', true)->latest('id')->first();
        });

        if (!$event || !$event->matchesRequest($request)) {
            return null;
        }

        if ($request->session()->get(static::sessionKey($event->id)) === true) {
            return null;
        }

        return $event;
    }

    public static function forgetActiveCache(): void
    {
        Cache::forget('inauguration.active');
    }

    public static function ensureTableExists(): void
    {
        if (Schema::hasTable('inaugurations')) {
            return;
        }

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

    public static function sessionKey(int $id): string
    {
        return 'inauguration_verified_' . $id;
    }

    public function posterUrl(): string
    {
        if ($this->id && $this->poster_path && Storage::disk('public')->exists($this->poster_path)) {
            return route('inauguration.poster', $this);
        }

        return asset('images/slider-placeholder.jpg');
    }

    public function matchesRequest(Request $request): bool
    {
        if ($this->scope === self::SCOPE_ALL) {
            return true;
        }

        $routeName = $request->route()?->getName();
        if ($routeName && in_array($routeName, $this->route_names ?? [], true)) {
            return true;
        }

        $path = trim($request->path(), '/');
        $path = $path === '' ? '/' : '/' . $path;

        foreach ($this->paths ?? [] as $candidate) {
            if ($this->pathMatches($path, (string) $candidate)) {
                return true;
            }
        }

        return false;
    }

    private function pathMatches(string $path, string $candidate): bool
    {
        $candidate = trim($candidate);

        if ($candidate === '') {
            return false;
        }

        $candidate = '/' . trim($candidate, '/');
        $candidate = $candidate === '//' ? '/' : $candidate;

        return Str::endsWith($candidate, '*')
            ? Str::startsWith($path, rtrim($candidate, '*'))
            : $path === $candidate;
    }
}
