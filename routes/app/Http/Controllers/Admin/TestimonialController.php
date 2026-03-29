<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTestimonialRequest;
use App\Http\Requests\Admin\UpdateTestimonialRequest;
use App\Models\Testimonial;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class TestimonialController extends Controller implements HasMiddleware
{
    public static function middleware(): array {
        return [new Middleware('auth'), new Middleware('permission:manage_testimonials')];
    }

    public function index() {
        $query = Testimonial::with('createdBy', 'updatedBy')->latest();
        if (request('search')) $query->where('name', 'like', '%' . request('search') . '%');
        return view('admin.testimonials.index', ['testimonials' => $query->paginate(20)->withQueryString()]);
    }

    public function create() { return view('admin.testimonials.create'); }

    public function store(StoreTestimonialRequest $request) {
        $data = $request->except(['photo', '_token']);
        $data['is_active']  = $request->boolean('is_active');
        $data['created_by'] = auth()->id();
        if ($request->hasFile('photo')) { $path = $request->file('photo')->store('testimonials', 'public'); $data['photo'] = basename($path); }
        Testimonial::create($data);
        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial successfully added!');
    }

    public function edit(Testimonial $testimonial) { return view('admin.testimonials.edit', compact('testimonial')); }

    public function update(UpdateTestimonialRequest $request, Testimonial $testimonial) {
        $data = $request->except(['photo', '_token', '_method']);
        $data['is_active']  = $request->boolean('is_active');
        $data['updated_by'] = auth()->id();
        if ($request->hasFile('photo')) { $path = $request->file('photo')->store('testimonials', 'public'); $data['photo'] = basename($path); }
        $testimonial->update($data);
        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial successfully updated!');
    }

    public function destroy(Testimonial $testimonial) {
        $testimonial->delete();
        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial deleted!');
    }
}
