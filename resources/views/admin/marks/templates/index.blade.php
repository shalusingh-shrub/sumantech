@extends('layouts.admin')
@section('title', 'Marks Templates')
@section('content')
<div class="content-area">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h4 class="mb-0 fw-bold" style="color:#1a2a6c;">
        <i class="fas fa-star me-2"></i>Course Marks Templates
      </h4>
      <small class="text-muted">Course-wise marks format set karo</small>
    </div>
    <a href="{{ route('admin.marks.templates.create') }}" class="btn btn-warning fw-bold px-4">
      <i class="fas fa-plus me-2"></i>Create Template
    </a>
  </div>

  @if(session('success'))
  <div class="alert alert-success alert-dismissible fade show">
    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
  @endif

  <div class="card border-0 shadow-sm">
    <div class="card-header py-3"
         style="background:linear-gradient(135deg,#1a2a6c,#2a4a9c);color:#fff;border-radius:8px 8px 0 0;">
      <span class="fw-bold"><i class="fas fa-list me-2"></i>All Templates</span>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-size:.88rem;">
          <thead>
            <tr style="background:#f8f9fa;border-bottom:2px solid #dee2e6;">
              <th class="py-3 px-3">#</th>
              <th>Template ID</th>
              <th>Course Name</th>
              <th>Subjects</th>
              <th>Total Marks</th>
              <th>Grade Standards</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse($templates as $i => $t)
            <tr>
              <td class="px-3 text-muted">{{ $i+1 }}</td>
              <td><span class="badge" style="background:#1a2a6c;font-size:.75rem;">{{ $t->template_id ?? 'N/A' }}</span></td>
              <td class="fw-semibold" style="color:#1a2a6c;">{{ $t->course_name }}</td>
              <td>
                @foreach(is_array($t->subjects) ? $t->subjects : json_decode($t->subjects, true) ?? [] as $s)
                <span class="badge bg-light text-dark border me-1" style="font-size:.72rem;">{{ $s['name'] }}</span>
                @endforeach
              </td>
              <td class="fw-bold" style="color:#1a2a6c;">{{ $t->total_max_marks }}</td>
              <td>
                @foreach(is_array($t->grade_standards) ? $t->grade_standards : (json_decode($t->grade_standards, true) ?? []) as $g)
                <span class="badge me-1" style="background:#1a2a6c;font-size:.7rem;">
                  {{ $g['grade'] }}: {{ $g['min'] }}-{{ $g['max'] }}%
                </span>
                @endforeach
              </td>
              <td>
                <div class="d-flex gap-1">
                  <a href="{{ route('admin.marks.templates.edit', $t) }}"
                     class="btn btn-sm btn-outline-success" style="padding:4px 8px;">
                    <i class="fas fa-edit" style="font-size:.75rem;"></i>
                  </a>
                  <form action="{{ route('admin.marks.templates.destroy', $t) }}"
                        method="POST" class="d-inline" onsubmit="return confirm('Delete?')">
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
              <td colspan="6" class="text-center py-5 text-muted">
                <i class="fas fa-star fa-3x mb-3 d-block" style="opacity:.2;"></i>
                Koi template nahi — pehle create karo!
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection



