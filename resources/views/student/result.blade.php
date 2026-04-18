@extends('student.layout')
@section('title', 'My Result')
@section('content')
<div class="container py-4">
    <h4 class="fw-bold mb-4" style="color:#1a2a6c;">
        <i class="fas fa-star me-2"></i>My Result
    </h4>

    @forelse($courses as $course)
    @php
        $marks = $course->studentMarks;
        $totalMax = $marks->sum('max_marks');
        $totalObtained = $marks->sum('obtained_marks');
        $percentage = $totalMax > 0 ? round(($totalObtained/$totalMax)*100, 1) : 0;
        $grade = $percentage >= 90 ? 'A+' : ($percentage >= 80 ? 'A' : ($percentage >= 70 ? 'B' : ($percentage >= 60 ? 'C' : ($percentage >= 50 ? 'D' : 'F'))));
        $gradeColor = $percentage >= 80 ? 'success' : ($percentage >= 60 ? 'warning' : 'danger');
    @endphp

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header py-3" style="background:linear-gradient(135deg,#1a2a6c,#2a4a9c);color:#fff;">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">{{ $course->course_name }}</h5>
                <span class="badge bg-{{ $gradeColor }} px-3 py-2" style="font-size:1rem;">
                    Grade: {{ $grade }} | {{ $percentage }}%
                </span>
            </div>
        </div>
        <div class="card-body p-0">
            @if($marks->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background:#f8f9fa;">
                        <tr>
                            <th class="px-3">#</th>
                            <th>Subject</th>
                            <th>Max Marks</th>
                            <th>Obtained</th>
                            <th>Percentage</th>
                            <th>Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($marks as $i => $mark)
                        @php
                            $pct = $mark->max_marks > 0 ? round(($mark->obtained_marks/$mark->max_marks)*100,1) : 0;
                            $g = $pct >= 90 ? 'A+' : ($pct >= 80 ? 'A' : ($pct >= 70 ? 'B' : ($pct >= 60 ? 'C' : ($pct >= 50 ? 'D' : 'F'))));
                        @endphp
                        <tr>
                            <td class="px-3">{{ $i+1 }}</td>
                            <td class="fw-semibold">{{ $mark->subject_name }}</td>
                            <td>{{ $mark->max_marks }}</td>
                            <td>{{ $mark->obtained_marks }}</td>
                            <td>
                                <div class="progress" style="height:8px;width:100px;">
                                    <div class="progress-bar bg-{{ $pct >= 80 ? 'success' : ($pct >= 60 ? 'warning' : 'danger') }}"
                                        style="width:{{ $pct }}%"></div>
                                </div>
                                <small>{{ $pct }}%</small>
                            </td>
                            <td><span class="badge bg-{{ $pct >= 80 ? 'success' : ($pct >= 60 ? 'warning' : 'danger') }}">{{ $g }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot style="background:#f8f9fa;font-weight:700;">
                        <tr>
                            <td colspan="2" class="px-3">Total</td>
                            <td>{{ $totalMax }}</td>
                            <td>{{ $totalObtained }}</td>
                            <td>{{ $percentage }}%</td>
                            <td><span class="badge bg-{{ $gradeColor }}">{{ $grade }}</span></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            @else
            <div class="text-center py-4 text-muted">
                <i class="fas fa-info-circle me-2"></i>Result abhi available nahi hai.
            </div>
            @endif
        </div>
    </div>
    @empty
    <div class="text-center py-5 text-muted">
        <i class="fas fa-book fa-3x mb-3"></i>
        <p>Koi course enrolled nahi hai.</p>
    </div>
    @endforelse
</div>
@endsection



