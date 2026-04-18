@extends('layouts.admin')

@section('title', 'Fee Categories - Suman Tech')

@section('content')
<div class="container-fluid py-4">

  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold" style="color:#0f2044;">📂 Fee Categories</h2>
    <a href="{{ route('admin.fees.index') }}" class="btn btn-outline-secondary">← Back to Fees</a>
  </div>

  <div class="row g-4">

    {{-- Add Category Form --}}
    <div class="col-md-4">
      <div class="card border-0 shadow-sm">
        <div class="card-header fw-bold" style="background:#0f2044;color:white;">➕ Add Category</div>
        <div class="card-body">
          <form method="POST" action="{{ route('admin.fees.categories.store') }}">
            @csrf
            <div class="mb-3">
              <label class="form-label fw-bold">Category Name *</label>
              <input type="text" name="name" class="form-control" required placeholder="e.g. Monthly Fee">
            </div>
            <div class="mb-3">
              <label class="form-label fw-bold">Default Amount (₹) *</label>
              <input type="number" name="amount" step="0.01" class="form-control" required placeholder="0.00">
            </div>
            <div class="mb-3">
              <label class="form-label">Description</label>
              <textarea name="description" class="form-control" rows="2"></textarea>
            </div>
            <button type="submit" class="btn btn-warning fw-bold w-100">Add Category</button>
          </form>
        </div>
      </div>
    </div>

    {{-- Categories List --}}
    <div class="col-md-8">
      <div class="card border-0 shadow-sm">
        <div class="card-header fw-bold" style="background:#0f2044;color:white;">📋 All Categories</div>
        <div class="card-body p-0">
          <table class="table table-hover mb-0">
            <thead class="table-light">
              <tr>
                <th class="px-3">Name</th>
                <th>Default Amount</th>
                <th>Description</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @forelse($categories as $cat)
              <tr>
                <td class="px-3 fw-bold">{{ $cat->name }}</td>
                <td class="text-success fw-bold">₹{{ number_format($cat->amount, 2) }}</td>
                <td class="text-muted small">{{ $cat->description ?? '-' }}</td>
                <td>
                  <form method="POST" action="{{ route('admin.fees.categories.destroy', $cat) }}" onsubmit="return confirm('Delete category?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger">🗑 Delete</button>
                  </form>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="4" class="text-center py-4 text-muted">No categories yet. Add one!</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection



