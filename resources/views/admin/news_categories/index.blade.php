{{-- File: resources/views/admin/news_categories/index.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'News Categories')
@section('content')
<div class="row">
    {{-- Add New Category --}}
    <div class="col-md-4">
        <div class="card data-card mb-4">
            <div class="card-header"><i class="fas fa-plus me-2"></i>Add New Category</div>
            <div class="card-body p-4">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $error)<p class="mb-0">{{ $error }}</p>@endforeach
                    </div>
                @endif
                <form action="{{ route('admin.news-categories.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Category Name *</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Edu Docs, Science, Events" value="{{ old('name') }}" required>
                    </div>
                    <button type="submit" class="btn btn-tob w-100"><i class="fas fa-save me-2"></i>Add Category</button>
                </form>
            </div>
        </div>
    </div>

    {{-- Category List --}}
    <div class="col-md-8">
        <div class="card data-card">
            <div class="card-header"><i class="fas fa-list me-2"></i>All Categories ({{ $categories->count() }})</div>
            <div class="card-body p-0">
                @if($categories->isEmpty())
                    <div class="text-center text-muted p-4">Koi category nahi hai. Upar se add karo!</div>
                @else
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Category Name</th>
                            <th>Slug</th>
                            <th>News Count</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $i => $cat)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td><strong>{{ $cat->name }}</strong></td>
                            <td><code>{{ $cat->slug }}</code></td>
                            <td><span class="badge bg-primary">{{ $cat->newsEvents()->count() }}</span></td>
                            <td>
                                <form action="{{ route('admin.news-categories.destroy', $cat) }}" method="POST" onsubmit="return confirm('Delete karna chahte ho?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection


