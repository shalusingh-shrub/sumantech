<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInaugurationRequest;
use App\Http\Requests\UpdateInaugurationRequest;
use App\Models\Inauguration;
use App\Support\ActivityLogHelper;
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
            new Middleware('permission:inauguration.view', only: ['index']),
            new Middleware('permission:inauguration.create', only: ['create', 'store']),
            new Middleware('permission:inauguration.edit', only: ['edit', 'update']),
            new Middleware('permission:inauguration.delete', only: ['destroy']),
        ];
    }

    public function index(): View
    {
        $inaugurations = Inauguration::query()->latest()->paginate(15);

        return view('inauguration.index', compact('inaugurations'));
    }

    public function create(): View
    {
        return view('inauguration.create', [
            'routeOptions' => $this->frontRouteOptions(),
        ]);
    }

    public function store(StoreInaugurationRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['poster_path'] = $request->file('poster')->store('inaugurations', 'public');
        $data['password_hash'] = Hash::make($data['password']);
        $data['added_by'] = (int) $request->user()->id;
        $data['updated_by'] = (int) $request->user()->id;
        unset($data['password'], $data['poster']);

        if ($data['is_enabled']) {
            Inauguration::query()->where('is_enabled', true)->update(['is_enabled' => false]);
        }

        $inauguration = Inauguration::create($data);
        Inauguration::forgetActiveCache();

        ActivityLogHelper::created('inauguration', $request->user(), $inauguration, 'Inauguration event created', [
            'title' => $inauguration->title,
            'is_enabled' => $inauguration->is_enabled,
            'scope' => $inauguration->scope,
        ]);

        return redirect()->route('inauguration.index')->with('success', 'Inauguration event created successfully.');
    }

    public function edit(Inauguration $inauguration): View
    {
        return view('inauguration.edit', [
            'inauguration' => $inauguration,
            'routeOptions' => $this->frontRouteOptions(),
        ]);
    }

    public function update(UpdateInaugurationRequest $request, Inauguration $inauguration): RedirectResponse
    {
        $before = $inauguration->only(['title', 'message', 'poster_path', 'is_enabled', 'scope', 'message_position', 'content_align', 'route_names', 'paths']);
        $data = $request->validated();
        $data['updated_by'] = (int) $request->user()->id;

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

        if ($data['is_enabled']) {
            Inauguration::query()
                ->where('id', '!=', $inauguration->id)
                ->where('is_enabled', true)
                ->update(['is_enabled' => false]);
        }

        $inauguration->update($data);
        Inauguration::forgetActiveCache();

        $fresh = $inauguration->fresh();
        ActivityLogHelper::updated(
            'inauguration',
            $request->user(),
            $fresh,
            'Inauguration event updated',
            $before,
            $fresh->only(['title', 'message', 'poster_path', 'is_enabled', 'scope', 'message_position', 'content_align', 'route_names', 'paths'])
        );

        return redirect()->route('inauguration.index')->with('success', 'Inauguration event updated successfully.');
    }

    public function destroy(Inauguration $inauguration): RedirectResponse
    {
        $properties = $inauguration->only(['title', 'poster_path', 'is_enabled', 'scope']);

        if ($inauguration->poster_path && Storage::disk('public')->exists($inauguration->poster_path)) {
            Storage::disk('public')->delete($inauguration->poster_path);
        }

        ActivityLogHelper::deleted('inauguration', request()->user(), $inauguration, 'Inauguration event deleted', $properties);
        $inauguration->delete();
        Inauguration::forgetActiveCache();

        return redirect()->route('inauguration.index')->with('success', 'Inauguration event deleted successfully.');
    }

    private function frontRouteOptions(): array
    {
        return collect(Route::getRoutes())
            ->map(function ($route): ?array {
                $name = $route->getName();

                if (!$name || !str_starts_with($name, 'front.')) {
                    return null;
                }

                $methods = $route->methods();
                if (!in_array('GET', $methods, true)) {
                    return null;
                }

                return [
                    'name' => $name,
                    'uri' => '/' . ltrim($route->uri(), '/'),
                    'label' => str($name)->after('front.')->replace(['.', '_'], ' ')->headline()->toString(),
                ];
            })
            ->filter()
            ->sortBy('label')
            ->values()
            ->all();
    }
}
