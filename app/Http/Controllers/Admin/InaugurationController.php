<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreInaugurationRequest;
use App\Http\Requests\Admin\UpdateInaugurationRequest;
use App\Models\Inauguration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class InaugurationController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
        ];
    }

    public function index(): View
    {
        $this->authorizeAccess();
        Inauguration::ensureTableExists();

        $inaugurations = Inauguration::query()->latest()->paginate(15);

        return view('admin.inaugurations.index', compact('inaugurations'));
    }

    public function create(): View
    {
        $this->authorizeAccess();
        Inauguration::ensureTableExists();

        return view('admin.inaugurations.create', [
            'routeOptions' => $this->frontRouteOptions(),
        ]);
    }

    public function store(StoreInaugurationRequest $request): RedirectResponse
    {
        $this->authorizeAccess();
        Inauguration::ensureTableExists();

        $data = $request->validated();
        $data['poster_path'] = $request->file('poster')->store('inaugurations', 'public');
        $data['password_hash'] = Hash::make($data['password']);
        $data['added_by'] = auth()->id();
        $data['updated_by'] = auth()->id();

        unset($data['password'], $data['poster']);
        $data = $this->normalizeScopeData($data);

        if ($data['is_enabled']) {
            Inauguration::query()->where('is_enabled', true)->update(['is_enabled' => false]);
        }

        Inauguration::create($data);
        Inauguration::forgetActiveCache();

        return redirect()->route('admin.inaugurations.index')->with('success', 'Inauguration successfully add ho gaya!');
    }

    public function edit(Inauguration $inauguration): View
    {
        $this->authorizeAccess();

        return view('admin.inaugurations.edit', [
            'inauguration' => $inauguration,
            'routeOptions' => $this->frontRouteOptions(),
        ]);
    }

    public function update(UpdateInaugurationRequest $request, Inauguration $inauguration): RedirectResponse
    {
        $this->authorizeAccess();

        $data = $request->validated();
        $data['updated_by'] = auth()->id();

        if ($request->hasFile('poster')) {
            if ($inauguration->poster_path && Storage::disk('public')->exists($inauguration->poster_path)) {
                Storage::disk('public')->delete($inauguration->poster_path);
            }

            $data['poster_path'] = $request->file('poster')->store('inaugurations', 'public');
        }

        if (!empty($data['password'])) {
            $data['password_hash'] = Hash::make($data['password']);
        }

        unset($data['password'], $data['poster']);
        $data = $this->normalizeScopeData($data);

        if ($data['is_enabled']) {
            Inauguration::query()
                ->where('id', '!=', $inauguration->id)
                ->where('is_enabled', true)
                ->update(['is_enabled' => false]);
        }

        $inauguration->update($data);
        Inauguration::forgetActiveCache();

        return redirect()->route('admin.inaugurations.index')->with('success', 'Inauguration successfully update ho gaya!');
    }

    public function destroy(Inauguration $inauguration): RedirectResponse
    {
        $this->authorizeAccess();

        if ($inauguration->poster_path && Storage::disk('public')->exists($inauguration->poster_path)) {
            Storage::disk('public')->delete($inauguration->poster_path);
        }

        $inauguration->delete();
        Inauguration::forgetActiveCache();

        return redirect()->route('admin.inaugurations.index')->with('success', 'Inauguration delete ho gaya!');
    }

    private function authorizeAccess(): void
    {
        $user = auth()->user();

        abort_unless($user && (
            $user->can('manage_inaugurations')
            || $user->hasRole(['super_admin', 'superadmin', 'admin'])
            || $user->role === 'admin'
        ), 403);
    }

    private function normalizeScopeData(array $data): array
    {
        if (($data['scope'] ?? Inauguration::SCOPE_ALL) === Inauguration::SCOPE_ALL) {
            $data['route_names'] = [];
            $data['paths'] = [];
        }

        return $data;
    }

    private function frontRouteOptions(): array
    {
        return collect(Route::getRoutes())
            ->map(function ($route): ?array {
                $name = $route->getName();

                if (!$name || !in_array('GET', $route->methods(), true)) {
                    return null;
                }

                if (str_starts_with($name, 'admin.') || str_starts_with($name, 'portal.') || str_starts_with($name, 'student.')) {
                    return null;
                }

                $uri = '/' . ltrim($route->uri(), '/');

                if (str_starts_with($uri, '/admin') || str_starts_with($uri, '/_') || $uri === '/captcha') {
                    return null;
                }

                return [
                    'name' => $name,
                    'uri' => $uri === '/' ? '/' : rtrim($uri, '/'),
                    'label' => str($name)->replace(['.', '_', '-'], ' ')->headline()->toString(),
                ];
            })
            ->filter()
            ->unique('name')
            ->sortBy('label')
            ->values()
            ->all();
    }
}
