<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSliderRequest;
use App\Http\Requests\Admin\UpdateSliderRequest;
use App\Models\Slider;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class SliderController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
            new Middleware('permission:manage_sliders'),
        ];
    }

    public function index()
    {
        $query = Slider::with('createdBy', 'updatedBy')->orderBy('sort_order');

        if (request('search')) {
            $query->where('title', 'like', '%' . request('search') . '%');
        }

        $sliders = $query->paginate(20)->withQueryString();
        return view('admin.sliders.index', compact('sliders'));
    }

    public function create() { return view('admin.sliders.create'); }

    public function store(StoreSliderRequest $request)
    {
        $data = $request->except(['image', '_token']);
        $data['is_active']   = $request->boolean('is_active');
        $data['created_by']  = auth()->id();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('sliders', 'public');
            $data['image'] = basename($path);
        }

        Slider::create($data);
        return redirect()->route('admin.sliders.index')->with('success', 'Slider successfully add ho gaya!');
    }

    public function edit(Slider $slider) { return view('admin.sliders.edit', compact('slider')); }

    public function update(UpdateSliderRequest $request, Slider $slider)
    {
        $data = $request->except(['image', '_token', '_method']);
        $data['is_active']   = $request->boolean('is_active');
        $data['updated_by']  = auth()->id();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('sliders', 'public');
            $data['image'] = basename($path);
        }

        $slider->update($data);
        return redirect()->route('admin.sliders.index')->with('success', 'Slider successfully update ho gaya!');
    }

    public function destroy(Slider $slider)
    {
        $slider->delete();
        return redirect()->route('admin.sliders.index')->with('success', 'Slider delete ho gaya!');
    }
}
