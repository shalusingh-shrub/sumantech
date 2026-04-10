@extends('layouts.admin')
@section('title', 'Quiz Results')
@section('content')
<div class="content-area">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h4 class="mb-0 fw-bold" style="color:#1a2a6c;"><i class="fas fa-chart-bar me-2"></i>Results: {{ $quiz->title }}</h4>
    </div>
    <a href="{{ route('admin.quizzes.show', $quiz) }}" class="btn btn-outline-secondary btn-sm">
      <i class="fas fa-arrow-left me-1"></i>Back
    </a>
  </div>

  <div class="card border-0 shadow-sm">
    <div class="card-header py-3"
         style="background:linear-gradient(135deg,#1a2a6c,#2a4a9c);color:#fff;border-radius:8px 8px 0 0;">
      <span class="fw-bold"><i class="fas fa-list me-2"></i>Participant Results</span>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-size:.85rem;">
          <thead>
            <tr style="background:#f8f9fa;border-bottom:2px solid #dee2e6;">
              <th class="py-3 px-3" style="font-size:.78rem;font-weight:700;color:#495057;">#</th>
              <th style="font-size:.78rem;font-weight:700;color:#495057;">Name</th>
              <th style="font-size:.78rem;font-weight:700;color:#495057;">Score</th>
              <th style="font-size:.78rem;font-weight:700;color:#495057;">Correct</th>
              <th style="font-size:.78rem;font-weight:700;color:#495057;">Wrong</th>
              <th style="font-size:.78rem;font-weight:700;color:#495057;">Percentage</th>
              <th style="font-size:.78rem;font-weight:700;color:#495057;">Grade</th>
              <th style="font-size:.78rem;font-weight:700;color:#495057;">Result</th>
              <th style="font-size:.78rem;font-weight:700;color:#495057;">Date</th>
            </tr>
          </thead>
          <tbody>
            @forelse($results as $i => $r)
            <tr>
              <td class="px-3 text-muted">{{ $results->firstItem() + $i }}</td>
              <td>
                <div class="fw-semibold">{{ $r->participant_name }}</div>
                <small class="text-muted">{{ $r->participant_email }}</small>
              </td>
              <td class="fw-bold" style="color:#1a2a6c;">{{ $r->score }}/{{ $r->total_marks }}</td>
              <td><span class="text-success fw-bold">{{ $r->correct }}</span></td>
              <td><span class="text-danger fw-bold">{{ $r->wrong }}</span></td>
              <td>
                <div class="d-flex align-items-center gap-2">
                  <div class="progress flex-grow-1" style="height:6px;width:80px;">
                    <div class="progress-bar bg-{{ $r->percentage >= $quiz->pass_percentage ? 'success':'danger' }}"
                         style="width:{{ $r->percentage }}%"></div>
                  </div>
                  <small>{{ $r->percentage }}%</small>
                </div>
              </td>
              <td><span class="badge bg-primary">{{ $r->grade }}</span></td>
              <td>
                <span class="badge px-2 py-1 rounded-pill"
                      style="font-size:.73rem;background:{{ $r->result=='pass'?'rgba(25,135,84,.12)':'rgba(220,53,69,.12)' }};color:{{ $r->result=='pass'?'#198754':'#dc3545' }};">
                  {{ ucfirst($r->result) }}
                </span>
              </td>
              <td style="font-size:.78rem;color:#6c757d;">{{ $r->created_at->format('d M Y') }}</td>
            </tr>
            @empty
            <tr>
              <td colspan="9" class="text-center py-5 text-muted">
                <i class="fas fa-chart-bar fa-3x mb-3 d-block" style="opacity:.2;"></i>
                Abhi koi result nahi hai.
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