<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class Inauguration extends Model
{
    public const SCOPE_ALL = 'all';
    public const SCOPE_SELECTED = 'selected';
    public const POSITION_TOP = 'top';
    public const POSITION_MIDDLE = 'middle';
    public const POSITION_BOTTOM = 'bottom';
    public const ALIGN_LEFT = 'left';
    public const ALIGN_CENTER = 'center';
    public const ALIGN_RIGHT = 'right';

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
        $event = Cache::rememberForever('inauguration.active', static function (): ?self {
            return static::query()
                ->where('is_enabled', true)
                ->latest('id')
                ->first();
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

    public static function sessionKey(int $id): string
    {
        return 'inauguration_verified_' . $id;
    }

    public function posterUrl(): string
    {
        return asset('storage/' . ltrim($this->poster_path, '/'));
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
        if ($candidate === '//') {
            $candidate = '/';
        }

        return Str::endsWith($candidate, '*')
            ? Str::startsWith($path, rtrim($candidate, '*'))
            : $path === $candidate;
    }
}
