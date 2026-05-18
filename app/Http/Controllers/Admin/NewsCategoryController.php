<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class NewsCategoryController extends Controller implements HasMiddleware
{
    public static function middleware(): array {
        return [
            new Middleware('auth'),
            new Middleware('permission:manage_news'),
        ];
    }

    public function index() {
        $categories = NewsCategory::latest()->get();
        return view('admin.news_categories.index', compact('categories'));
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:100|unique:news_categories,name',
        ], [
            'name.required' => 'Category name is required.',
            'name.unique'   => 'This category already exists.',
            'name.max'      => 'Category name cannot exceed 100 characters.',
        ]);

        NewsCategory::create([
            'name'      => $request->name,
            'slug'      => Str::slug($request->name),
            'is_active' => true,
        ]);

        return redirect()->back()->with('success', 'Category add ho gayi!');
    }

    public function destroy(NewsCategory $newsCategory) {
        $newsCategory->delete();
        return redirect()->back()->with('success', 'Category delete ho gayi!');
    }
}
