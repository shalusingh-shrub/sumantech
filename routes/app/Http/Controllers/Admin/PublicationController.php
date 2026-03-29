<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePublicationRequest;
use App\Http\Requests\Admin\UpdatePublicationRequest;
use App\Models\Publication;
use Illuminate\Support\Str;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PublicationController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
            new Middleware('permission:manage_publications'),
        ];
    }

    private function getCategories()
    {
        return [
            'science_corner' => 'विज्ञान कार्नर',
            'tlm'            => 'TLM',
            'anusandhaanam'  => 'अनुसंधानम्',
            'abhimat'        => 'अभिमत',
            'emagazine'      => 'ई-मैगजीन',
            'karmana'        => 'कर्मणा',
            'balman'         => 'बाल मन',
            'suvichar'       => 'सुविचार',
            'eresources'     => 'e-Resources',
            'balmanch'       => 'बालमंच',
            'shabdkosh'      => 'शिक्षा शब्दकोष',
            'gyandrishti'    => 'ज्ञान दृष्टि',
            'other'          => 'Other',
        ];
    }

    public function index()
    {
        $query = Publication::with('createdBy', 'updatedBy')->latest();

        if (request('search')) {
            $query->where('title', 'like', '%' . request('search') . '%');
        }
        if (request('category')) {
            $query->where('category', request('category'));
        }

        $publications = $query->paginate(20)->withQueryString();
        $categories   = $this->getCategories();
        return view('admin.publications.index', compact('publications', 'categories'));
    }

    public function create()
    {
        $categories = $this->getCategories();
        return view('admin.publications.create', compact('categories'));
    }

    public function store(StorePublicationRequest $request)
    {
        $data = $request->except(['cover_image', 'file', '_token']);
        $data['slug']       = Str::slug($request->title) . '-' . time();
        $data['is_active']  = $request->boolean('is_active');
        $data['created_by'] = auth()->id();

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('publications', 'public');
            $data['cover_image'] = basename($path);
        }
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('publication_files', 'public');
            $data['file'] = basename($path);
        }

        Publication::create($data);
        return redirect()->route('admin.publications.index')->with('success', 'Publication successfully add ho gayi!');
    }

    public function edit(Publication $publication)
    {
        $categories = $this->getCategories();
        return view('admin.publications.edit', compact('publication', 'categories'));
    }

    public function update(UpdatePublicationRequest $request, Publication $publication)
    {
        $data = $request->except(['cover_image', 'file', '_token', '_method']);
        $data['is_active']  = $request->boolean('is_active');
        $data['updated_by'] = auth()->id();

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('publications', 'public');
            $data['cover_image'] = basename($path);
        }
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('publication_files', 'public');
            $data['file'] = basename($path);
        }

        $publication->update($data);
        return redirect()->route('admin.publications.index')->with('success', 'Publication successfully update ho gayi!');
    }

    public function destroy(Publication $publication)
    {
        $publication->delete();
        return redirect()->route('admin.publications.index')->with('success', 'Publication delete ho gayi!');
    }
}
