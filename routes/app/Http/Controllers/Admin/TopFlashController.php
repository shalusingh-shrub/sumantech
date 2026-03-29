<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTopFlashRequest;
use App\Http\Requests\Admin\UpdateTopFlashRequest;
use App\Models\TopFlash;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class TopFlashController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
            new Middleware('permission:manage_top_flash'),
        ];
    }

    public function index()
    {
        $query = TopFlash::with('createdBy', 'updatedBy')->orderBy('sort_order');

        if (request('search')) {
            $query->where('title', 'like', '%' . request('search') . '%');
        }

        $flashes = $query->paginate(20)->withQueryString();
        return view('admin.topflash.index', compact('flashes'));
    }

    public function create() { return view('admin.topflash.create'); }

    public function store(StoreTopFlashRequest $request)
    {
        $data = $request->all();
        $data['is_new']     = $request->boolean('is_new');
        $data['is_active']  = $request->boolean('is_active');
        $data['created_by'] = auth()->id();

        TopFlash::create($data);
        return redirect()->route('admin.topflash.index')->with('success', 'Flash news successfully add ho gaya!');
    }

    public function edit(TopFlash $topflash) { return view('admin.topflash.edit', compact('topflash')); }

    public function update(UpdateTopFlashRequest $request, TopFlash $topflash)
    {
        $data = $request->except(['_token', '_method']);
        $data['is_new']     = $request->boolean('is_new');
        $data['is_active']  = $request->boolean('is_active');
        $data['updated_by'] = auth()->id();

        $topflash->update($data);
        return redirect()->route('admin.topflash.index')->with('success', 'Flash news successfully update ho gaya!');
    }

    public function destroy(TopFlash $topflash)
    {
        $topflash->delete();
        return redirect()->route('admin.topflash.index')->with('success', 'Flash news delete ho gaya!');
    }
}
