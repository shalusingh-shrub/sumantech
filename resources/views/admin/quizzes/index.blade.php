@extends('layouts.admin')
@section('title', 'Quizzes')
@section('content')
<div class="content-area">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h4 class="mb-0 fw-bold" style="color:#1a2a6c;">
        <i class="fas fa-question-circle me-2"></i>Quiz Management
      </h4>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 mt-1" style="font-size:13px;">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
          <li class="breadcrumb-item active">Quizzes</li>
        </ol>
      </nav>
    </div>
    <a href="{{ route('admin.quizzes.create') }}" class="btn btn-warning fw-bold px-4">
      <i class="fas fa-plus me-2"></i>Create Quiz
    </a>
  </div>

  @if(session('success'))
  <div class="alert alert-success alert-dismissible fade show shadow-sm">
    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
  @endif

  <div class="card border-0 shadow-sm">
    <div class="card-header py-3 d-flex justify-content-between align-items-center"
         style="background:linear-gradient(135deg,#1a2a6c,#2a4a9c);color:#fff;border-radius:8px 8px 0 0;">
      <span class="fw-bold fs-6"><i class="fas fa-list me-2"></i>All Quizzes</span>
      <span class="badge bg-warning text-dark">{{ $quizzes->total() }} quizzes</span>
    </div>
    <div class="card-body">
      <form method="GET" class="row g-2 mb-4 align-items-end">
        <div class="col-md-4">
          <label class="form-label small fw-semibold text-muted mb-1">Search</label>
          <div class="input-group">
            <span class="input-group-text bg-light border-end-0">
              <i class="fas fa-search text-muted" style="font-size:.8rem;"></i>
            </span>
            <input type="text" name="search" class="form-control border-start-0 ps-0"
                   placeholder="Quiz title, category..."
                   value="{{ request('search') }}" style="font-size:.88rem;">
          </div>
        </div>
        <div class="col-md-2">
          <label class="form-label small fw-semibold text-muted mb-1">Status</label>
          <select name="status" class="form-select" style="font-size:.88rem;">
            <option value="">All</option>
            <option value="active"   {{ request('status')=='active'   ?'selected':'' }}>Active</option>
            <option value="inactive" {{ request('status')=='inactive' ?'selected':'' }}>Inactive</option>
            <option value="draft"    {{ request('status')=='draft'    ?'selected':'' }}>Draft</option>
          </select>
        </div>
        <div class="col-md-2">
          <label class="form-label small fw-semibold text-muted mb-1">Per Page</label>
          <select name="per_page" class="form-select" style="font-size:.88rem;">
            @foreach([10,25,50] as $n)
            <option value="{{ $n }}" {{ request('per_page',10)==$n ?'selected':'' }}>{{ $n }} records</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-2">
          <button type="submit" class="btn btn-primary w-100">
            <i class="fas fa-search me-1"></i>Search
          </button>
        </div>
        @if(request()->hasAny(['search','status']))
        <div class="col-md-2">
          <a href="{{ route('admin.quizzes.index') }}" class="btn btn-outline-secondary w-100">
            <i class="fas fa-times me-1"></i>Clear
          </a>
        </div>
        @endif
      </form>

      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-size:.85rem;">
          <thead>
            <tr style="background:#f8f9fa;border-bottom:2px solid #dee2e6;">
              <th class="py-3 px-3" style="font-size:.78rem;font-weight:700;color:#495057;">S.No</th>
              <th style="font-size:.78rem;font-weight:700;color:#495057;">Title</th>
              <th style="font-size:.78rem;font-weight:700;color:#495057;">Category</th>
              <th style="font-size:.78rem;font-weight:700;color:#495057;">Questions</th>
              <th style="font-size:.78rem;font-weight:700;color:#495057;">Timer</th>
              <th style="font-size:.78rem;font-weight:700;color:#495057;">Attempts</th>
              <th style="font-size:.78rem;font-weight:700;color:#495057;">Status</th>
              <th style="font-size:.78rem;font-weight:700;color:#495057;">Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse($quizzes as $i => $quiz)
            <tr>
              <td class="px-3 text-muted">{{ $quizzes->firstItem() + $i }}</td>
              <td>
                <div class="fw-semibold" style="color:#1a2a6c;">{{ $quiz->title }}</div>
                <small class="text-muted">Pass: {{ $quiz->pass_percentage }}%</small>
              </td>
              <td><span class="badge bg-light text-dark border">{{ $quiz->category ?? 'General' }}</span></td>
              <td><span class="fw-bold" style="color:#1a2a6c;">{{ $quiz->questions_count }}</span></td>
              <td>
                @if($quiz->time_limit > 0)
                  <span class="text-warning fw-bold"><i class="fas fa-clock me-1"></i>{{ $quiz->time_limit }} min</span>
                @else
                  <span class="text-muted">No limit</span>
                @endif
              </td>
              <td><span class="badge bg-info text-dark">{{ $quiz->results_count }}</span></td>
              <td>
                @php $colors = ['active'=>'rgba(25,135,84,.12)','inactive'=>'rgba(220,53,69,.12)','draft'=>'rgba(255,193,7,.2)']; $tcolors = ['active'=>'#198754','inactive'=>'#dc3545','draft'=>'#856404']; @endphp
                <span class="badge px-2 py-1 rounded-pill"
                      style="font-size:.73rem;background:{{ $colors[$quiz->status] }};color:{{ $tcolors[$quiz->status] }};">
                  {{ ucfirst($quiz->status) }}
                </span>
              </td>
              <td>
                <div class="d-flex gap-1">
                  <a href="{{ route('admin.quizzes.show', $quiz) }}"
                     class="btn btn-sm btn-outline-primary" style="padding:4px 8px;" title="Manage">
                    <i class="fas fa-cog" style="font-size:.75rem;"></i>
                  </a>
                  <a href="{{ route('admin.quizzes.edit', $quiz) }}"
                     class="btn btn-sm btn-outline-success" style="padding:4px 8px;" title="Edit">
                    <i class="fas fa-edit" style="font-size:.75rem;"></i>
                  </a>
                  <a href="{{ route('admin.quizzes.results', $quiz) }}"
                     class="btn btn-sm btn-outline-info" style="padding:4px 8px;" title="Results">
                    <i class="fas fa-chart-bar" style="font-size:.75rem;"></i>
                  </a>
                  <form action="{{ route('admin.quizzes.destroy', $quiz) }}"
                        method="POST" class="d-inline" onsubmit="return confirm('Delete quiz?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger" style="padding:4px 8px;">
                      <i class="fas fa-trash" style="font-size:.75rem;"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="8" class="text-center py-5 text-muted">
                <i class="fas fa-question-circle fa-3x mb-3 d-block" style="opacity:.2;"></i>
                No quizzes found.
                <br>
                <a href="{{ route('admin.quizzes.create') }}" class="btn btn-sm btn-primary mt-2">
                  <i class="fas fa-plus me-1"></i>Create First Quiz
                </a>
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
        <div class="text-muted" style="font-size:.83rem;">
          Showing {{ $quizzes->firstItem() ?? 0 }} to {{ $quizzes->lastItem() ?? 0 }}
          of {{ $quizzes->total() }} entries
        </div>
        <nav>
          <ul class="pagination pagination-sm mb-0" style="gap:3px;">
            <li class="page-item {{ $quizzes->onFirstPage() ? 'disabled':'' }}">
              <a class="page-link rounded" href="{{ $quizzes->previousPageUrl() }}"
                 style="font-size:.78rem;padding:4px 10px;color:#1a2a6c;border-color:#dee2e6;">
                <i class="fas fa-chevron-left" style="font-size:.7rem;"></i>
              </a>
            </li>
            @foreach($quizzes->getUrlRange(1, $quizzes->lastPage()) as $page => $url)
            <li class="page-item {{ $page == $quizzes->currentPage() ? 'active':'' }}">
              <a class="page-link rounded" href="{{ $url }}"
                 style="font-size:.78rem;padding:4px 10px;{{ $page == $quizzes->currentPage() ? 'background:#1a2a6c;border-color:#1a2a6c;color:#fff;':'color:#1a2a6c;border-color:#dee2e6;' }}">
                {{ $page }}
              </a>
            </li>
            @endforeach
            <li class="page-item {{ !$quizzes->hasMorePages() ? 'disabled':'' }}">
              <a class="page-link rounded" href="{{ $quizzes->nextPageUrl() }}"
                 style="font-size:.78rem;padding:4px 10px;color:#1a2a6c;border-color:#dee2e6;">
                <i class="fas fa-chevron-right" style="font-size:.7rem;"></i>
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </div>
  </div>
</div>
@endsection