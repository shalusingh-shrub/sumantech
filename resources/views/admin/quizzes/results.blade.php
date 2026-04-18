@extends('layouts.admin')
@section('title', 'Quiz Results')
@section('content')
<div class="content-area">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h4 class="mb-0 fw-bold" style="color:#1a2a6c;">
        <i class="fas fa-users me-2"></i>Results — {{ $quiz->title }}
      </h4>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 mt-1" style="font-size:13px;">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('admin.quizzes.index') }}">Quizzes</a></li>
          <li class="breadcrumb-item"><a href="{{ route('admin.quizzes.show', $quiz) }}">Manage</a></li>
          <li class="breadcrumb-item active">Results</li>
        </ol>
      </nav>
    </div>
    <a href="{{ route('admin.quizzes.show', $quiz) }}" class="btn btn-sm btn-outline-secondary">
      <i class="fas fa-arrow-left me-1"></i>Back
    </a>
  </div>

  <div class="card border-0 shadow-sm" style="border-radius:12px;">
    <div class="card-header py-3" style="background:linear-gradient(135deg,#1a2a6c,#2a4a9c);color:#fff;border-radius:12px 12px 0 0;">
      <span class="fw-bold"><i class="fas fa-certificate me-2"></i>All Results & Certificates ({{ $results->total() }})</span>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead style="background:#f8f9fa;font-size:.82rem;">
            <tr>
              <th class="px-3">#</th>
              <th>Student</th>
              <th>School</th>
              <th>Score</th>
              <th>Result</th>
              <th>Certificate No</th>
              <th>Date</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody style="font-size:.85rem;">
            @forelse($results as $i => $r)
            <tr>
              <td class="px-3">{{ $results->firstItem() + $i }}</td>
              <td>
                <div class="fw-semibold">{{ $r->participant_name }}</div>
                <div class="text-muted" style="font-size:.78rem;">{{ $r->participant_email }}</div>
                <div class="text-muted" style="font-size:.78rem;">{{ $r->participant_phone }}</div>
              </td>
              <td>{{ $r->participant_school ?? '—' }}</td>
              <td>
                <div class="fw-bold" style="color:#1a2a6c;">{{ $r->percentage }}%</div>
                <div class="text-muted" style="font-size:.75rem;">{{ $r->score }}/{{ $r->total_marks }}</div>
              </td>
              <td>
                @if($r->result == 'pass')
                  <span class="badge bg-success">Pass</span>
                @else
                  <span class="badge bg-danger">Fail</span>
                @endif
                <span class="badge bg-secondary ms-1">{{ $r->grade }}</span>
              </td>
              <td>
                <code style="font-size:.78rem;">{{ $r->certificate_number }}</code>
                @if($r->certificate_downloaded_at)
                <div class="text-success" style="font-size:.72rem;">
                  <i class="fas fa-download me-1"></i>Downloaded
                </div>
                @endif
              </td>
              <td style="font-size:.78rem;">{{ $r->created_at->format('d M Y') }}<br>{{ $r->created_at->format('h:i A') }}</td>
              <td>
                <a href="{{ route('quiz.certificate', $r->id) }}" target="_blank"
                   class="btn btn-sm btn-outline-success" title="View Certificate">
                  <i class="fas fa-certificate"></i>
                </a>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="8" class="text-center py-5 text-muted">Koi result nahi abhi tak.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      @if($results->hasPages())
      <div class="px-3 py-2">{{ $results->links() }}</div>
      @endif
    </div>
  </div>
</div>
@endsection



