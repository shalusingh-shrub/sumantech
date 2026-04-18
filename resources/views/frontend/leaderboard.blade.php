@extends('layouts.frontend')
@section('title', 'Leaderboard — Suman Tech')
@section('content')

<section style="background:linear-gradient(135deg,#0B1F3A,#1557B0);padding:60px 0 40px;">
    <div class="container">
        <div class="text-center mb-5">
            <h2 style="color:#F0A500;font-family:'Playfair Display',serif;font-weight:900;font-size:2.5rem;">
                <i class="fas fa-trophy me-2"></i>Leaderboard
            </h2>
            <p style="color:rgba(255,255,255,.7);">Top performers of Suman Tech Quiz</p>
        </div>

        {{-- Stats --}}
        <div class="row g-3 mb-5">
            <div class="col-6 col-md-3">
                <div class="text-center p-3 rounded-3" style="background:rgba(255,255,255,.1);">
                    <div style="font-size:2rem;font-weight:900;color:#F0A500;">{{ $stats['total_attempts'] }}</div>
                    <div style="color:rgba(255,255,255,.7);font-size:.85rem;">Total Attempts</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="text-center p-3 rounded-3" style="background:rgba(255,255,255,.1);">
                    <div style="font-size:2rem;font-weight:900;color:#28a745;">{{ $stats['total_pass'] }}</div>
                    <div style="color:rgba(255,255,255,.7);font-size:.85rem;">Total Pass</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="text-center p-3 rounded-3" style="background:rgba(255,255,255,.1);">
                    <div style="font-size:2rem;font-weight:900;color:#17a2b8;">{{ $stats['avg_percentage'] }}%</div>
                    <div style="color:rgba(255,255,255,.7);font-size:.85rem;">Avg Score</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="text-center p-3 rounded-3" style="background:rgba(255,255,255,.1);">
                    <div style="font-size:2rem;font-weight:900;color:#F0A500;">{{ $stats['top_score'] }}%</div>
                    <div style="color:rgba(255,255,255,.7);font-size:.85rem;">Top Score</div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5" style="background:#f8f9fa;">
    <div class="container">

        {{-- Top 3 --}}
        @if($topScorers->count() > 0)
        <div class="text-center mb-5">
            <h4 class="fw-bold" style="color:#1a2a6c;">🏆 Top Scorers</h4>
        </div>

        <div class="row justify-content-center mb-5">
            {{-- 2nd place --}}
            @if($topScorers->count() >= 2)
            <div class="col-md-3 text-center" style="margin-top:40px;">
                <div class="card border-0 shadow" style="border-radius:20px;border-top:4px solid #C0C0C0!important;">
                    <div class="card-body py-4">
                        <div style="font-size:3rem;">🥈</div>
                        <div style="width:70px;height:70px;background:linear-gradient(135deg,#C0C0C0,#A0A0A0);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:10px auto;font-size:1.5rem;color:#fff;font-weight:900;">
                            {{ strtoupper(substr($topScorers[1]->participant_name, 0, 1)) }}
                        </div>
                        <h6 class="fw-bold">{{ $topScorers[1]->participant_name }}</h6>
                        <div style="font-size:1.5rem;font-weight:900;color:#C0C0C0;">{{ $topScorers[1]->best_percentage }}%</div>
                        <small class="text-muted">{{ $topScorers[1]->total_attempts }} attempts</small>
                    </div>
                </div>
            </div>
            @endif

            {{-- 1st place --}}
            <div class="col-md-3 text-center">
                <div class="card border-0 shadow-lg" style="border-radius:20px;border-top:4px solid #F0A500!important;">
                    <div class="card-body py-4">
                        <div style="font-size:3rem;">🥇</div>
                        <div style="width:80px;height:80px;background:linear-gradient(135deg,#F0A500,#E8950A);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:10px auto;font-size:1.8rem;color:#fff;font-weight:900;">
                            {{ strtoupper(substr($topScorers[0]->participant_name, 0, 1)) }}
                        </div>
                        <h5 class="fw-bold">{{ $topScorers[0]->participant_name }}</h5>
                        <div style="font-size:2rem;font-weight:900;color:#F0A500;">{{ $topScorers[0]->best_percentage }}%</div>
                        <small class="text-muted">{{ $topScorers[0]->total_attempts }} attempts</small>
                    </div>
                </div>
            </div>

            {{-- 3rd place --}}
            @if($topScorers->count() >= 3)
            <div class="col-md-3 text-center" style="margin-top:60px;">
                <div class="card border-0 shadow" style="border-radius:20px;border-top:4px solid #CD7F32!important;">
                    <div class="card-body py-4">
                        <div style="font-size:3rem;">🥉</div>
                        <div style="width:60px;height:60px;background:linear-gradient(135deg,#CD7F32,#A0522D);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:10px auto;font-size:1.3rem;color:#fff;font-weight:900;">
                            {{ strtoupper(substr($topScorers[2]->participant_name, 0, 1)) }}
                        </div>
                        <h6 class="fw-bold">{{ $topScorers[2]->participant_name }}</h6>
                        <div style="font-size:1.3rem;font-weight:900;color:#CD7F32;">{{ $topScorers[2]->best_percentage }}%</div>
                        <small class="text-muted">{{ $topScorers[2]->total_attempts }} attempts</small>
                    </div>
                </div>
            </div>
            @endif
        </div>

        {{-- Full leaderboard table --}}
        <div class="card border-0 shadow-sm mb-5">
            <div class="card-header py-3" style="background:linear-gradient(135deg,#1a2a6c,#2a4a9c);color:#fff;border-radius:8px 8px 0 0;">
                <h5 class="mb-0 fw-bold"><i class="fas fa-list me-2"></i>Overall Rankings</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead style="background:#f8f9fa;">
                            <tr>
                                <th class="px-3">Rank</th>
                                <th>Name</th>
                                <th>Best Score</th>
                                <th>Attempts</th>
                                <th>Pass</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topScorers as $i => $scorer)
                            <tr style="{{ $i < 3 ? 'background:'.($i==0?'rgba(240,165,0,.08)':($i==1?'rgba(192,192,192,.08)':'rgba(205,127,50,.08)')) : '' }}">
                                <td class="px-3 fw-bold">
                                    @if($i == 0) 🥇
                                    @elseif($i == 1) 🥈
                                    @elseif($i == 2) 🥉
                                    @else <span class="text-muted">{{ $i + 1 }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div style="width:35px;height:35px;background:linear-gradient(135deg,#1a2a6c,#2a4a9c);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:.85rem;">
                                            {{ strtoupper(substr($scorer->participant_name, 0, 1)) }}
                                        </div>
                                        <span class="fw-semibold">{{ $scorer->participant_name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="fw-bold" style="color:{{ $scorer->best_percentage >= 80 ? '#198754' : ($scorer->best_percentage >= 60 ? '#F0A500' : '#dc3545') }};">
                                        {{ $scorer->best_percentage }}%
                                    </span>
                                </td>
                                <td>{{ $scorer->total_attempts }}</td>
                                <td>
                                    <span class="badge bg-success">{{ $scorer->total_pass }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif

        {{-- Quiz wise filter --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header py-3" style="background:linear-gradient(135deg,#1a2a6c,#2a4a9c);color:#fff;border-radius:8px 8px 0 0;">
                <h5 class="mb-0 fw-bold"><i class="fas fa-filter me-2"></i>Quiz Wise Leaderboard</h5>
            </div>
            <div class="card-body">
                <form method="GET" class="row g-2 mb-4">
                    <div class="col-md-6">
                        <select name="quiz_id" class="form-select" onchange="this.form.submit()">
                            <option value="">-- Select Quiz --</option>
                            @foreach($quizzes as $quiz)
                            <option value="{{ $quiz->id }}" {{ $selectedQuiz == $quiz->id ? 'selected' : '' }}>
                                {{ $quiz->title ?? $quiz->quiz_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </form>

                @if($quizLeaderboard && $quizLeaderboard->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead style="background:#f8f9fa;">
                            <tr>
                                <th>Rank</th>
                                <th>Name</th>
                                <th>Score</th>
                                <th>Correct</th>
                                <th>Wrong</th>
                                <th>Time</th>
                                <th>Result</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($quizLeaderboard as $i => $r)
                            <tr>
                                <td class="fw-bold">
                                    @if($i==0) 🥇 @elseif($i==1) 🥈 @elseif($i==2) 🥉
                                    @else {{ $i+1 }} @endif
                                </td>
                                <td class="fw-semibold">{{ $r->participant_name }}</td>
                                <td class="fw-bold" style="color:#1557B0;">{{ $r->percentage }}%</td>
                                <td class="text-success">✅ {{ $r->correct }}</td>
                                <td class="text-danger">❌ {{ $r->wrong }}</td>
                                <td>{{ gmdate('i:s', $r->time_taken) }}</td>
                                <td>
                                    <span class="badge bg-{{ $r->result == 'pass' ? 'success' : 'danger' }}">
                                        {{ ucfirst($r->result) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @elseif($selectedQuiz)
                <div class="text-center py-4 text-muted">
                    <i class="fas fa-info-circle me-2"></i>Is quiz ka koi result nahi hai abhi.
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection