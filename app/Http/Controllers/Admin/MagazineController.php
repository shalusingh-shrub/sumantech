<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreMagazineRequest;
use App\Http\Requests\Admin\UpdateMagazineRequest;
use App\Models\Magazine;
use App\Models\MagazineCategory;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Str;

class MagazineController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
            new Middleware('permission:manage_publications'),
        ];
    }

    public function index()
    {
        $query = Magazine::with('category', 'createdBy', 'updatedBy')->latest();

        if (request('search')) {
            $query->where('title', 'like', '%' . request('search') . '%');
        }
        if (request('category')) {
            $query->where('magazine_category_id', request('category'));
        }

        $magazines  = $query->paginate(15)->withQueryString();
        $categories = MagazineCategory::where('is_active', true)->orderBy('name')->get();
        return view('admin.magazines.index', compact('magazines', 'categories'));
    }

    public function create()
    {
        $categories = MagazineCategory::where('is_active', true)->orderBy('name')->get();
        return view('admin.magazines.create', compact('categories'));
    }

    public function store(StoreMagazineRequest $request)
    {
        $data = $request->except(['image', 'file', '_token']);
        $data['is_active']  = $request->boolean('is_active');
        $data['created_by'] = auth()->id();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('magazines', 'public');
            $data['image'] = basename($path);
        }
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('magazines/files', 'public');
            $data['file'] = basename($path);
        }

        Magazine::create($data);
        return redirect()->route('admin.magazines.index')->with('success', 'Magazine successfully add ho gayi!');
    }

    public function show(Magazine $magazine) { return view('admin.magazines.show', compact('magazine')); }

    public function edit(Magazine $magazine)
    {
        $categories = MagazineCategory::where('is_active', true)->orderBy('name')->get();
        return view('admin.magazines.edit', compact('magazine', 'categories'));
    }

    public function update(UpdateMagazineRequest $request, Magazine $magazine)
    {
        $data = $request->except(['image', 'file', '_token', '_method']);
        $data['is_active']  = $request->boolean('is_active');
        $data['updated_by'] = auth()->id();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('magazines', 'public');
            $data['image'] = basename($path);
        }
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('magazines/files', 'public');
            $data['file'] = basename($path);
        }

        $magazine->update($data);
        return redirect()->route('admin.magazines.index')->with('success', 'Magazine successfully update ho gayi!');
    }

    public function destroy(Magazine $magazine)
    {
        $magazine->delete();
        return redirect()->route('admin.magazines.index')->with('success', 'Magazine delete ho gayi!');
    }

    public function categories()
    {
        $categories = MagazineCategory::withCount('magazines')->latest()->get();
        return view('admin.magazines.categories', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate(['name' => ['required', 'string', 'max:100', 'unique:magazine_categories,name']], [
            'name.required' => 'Category name zaroori hai.',
            'name.unique'   => 'Ye category pehle se exist karti hai.',
            'name.max'      => 'Category name 100 characters se zyada nahi ho sakta.',
        ]);

        MagazineCategory::create(['name' => $request->name, 'slug' => Str::slug($request->name), 'is_active' => true]);
        return redirect()->back()->with('success', 'Category add ho gayi!');
    }

    public function destroyCategory(MagazineCategory $category)
    {
        $category->delete();
        return redirect()->back()->with('success', 'Category delete ho gayi!');
    }
}
