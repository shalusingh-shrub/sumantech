{{-- File: resources/views/admin/magazines/categories.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Magazine Categories')
@section('content')
<div class="d-flex justify-content-between mb-4">
    <h5 class="fw-bold"><i class="fas fa-tags me-2 text-warning"></i>Magazine Categories</h5>
    <a href="{{ route('admin.magazines.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Back to Magazines</a>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm" style="border-radius:10px;">
            <div class="card-header" style="background:linear-gradient(135deg,#1a2a6c,#6b3a1f);color:#fff;border-radius:10px 10px 0 0;">
                <i class="fas fa-plus me-2"></i>Add New Category
            </div>
            <div class="card-body p-4">
                @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
                @if($errors->any())<div class="alert alert-danger">@foreach($errors->all() as $e)<p class="mb-0">{{ $e }}</p>@endforeach</div>@endif
                <form action="{{ route('admin.magazines.storeCategory') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Category Name *</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. दैनिक ज्ञानकोश" value="{{ old('name') }}" required>
                    </div>
                    <button type="submit" class="btn btn-tob w-100"><i class="fas fa-save me-2"></i>Add Category</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card border-0 shadow-sm" style="border-radius:10px;">
            <div class="card-header" style="background:linear-gradient(135deg,#1a2a6c,#6b3a1f);color:#fff;border-radius:10px 10px 0 0;">
                <i class="fas fa-list me-2"></i>All Categories ({{ $categories->count() }})
            </div>
            <div class="card-body p-0">
                @if($categories->isEmpty())
                    <div class="text-center text-muted p-4">Koi category nahi. Upar se add karo!</div>
                @else
                <table class="table table-hover mb-0 align-middle">
                    <thead><tr><th>#</th><th>Name</th><th>Slug</th><th>Magazines</th><th>Action</th></tr></thead>
                    <tbody>
                        @foreach($categories as $i => $cat)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td><strong>{{ $cat->name }}</strong></td>
                            <td><code>{{ $cat->slug }}</code></td>
                            <td><span class="badge bg-primary">{{ $cat->magazines_count }}</span></td>
                            <td>
                                <form action="{{ route('admin.magazines.destroyCategory', $cat) }}" method="POST" onsubmit="return confirm('Delete karna chahte ho?')">
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





