@extends('layouts.frontend')
@section('title', 'Certificate Verify — Suman Tech')
@section('content')

<section style="background:linear-gradient(135deg,#0B1F3A,#1557B0);padding:60px 0;min-height:100vh;">
    <div class="container">
        <div class="text-center mb-5">
            <h2 style="color:#F0A500;font-family:'Playfair Display',serif;font-weight:900;font-size:2.5rem;">
                <i class="fas fa-certificate me-2"></i>Certificate Verification
            </h2>
            <p style="color:rgba(255,255,255,.7);">Enter your Certificate ID to verify your certificate</p>
        </div>

        {{-- Search Form --}}
        <div class="row justify-content-center mb-5">
            <div class="col-md-6">
                <div class="card border-0 shadow-lg" style="border-radius:20px;">
                    <div class="card-body p-4">
                        @if($errors->any())
                        <div class="alert alert-danger">
                            {{ $errors->first() }}
                        </div>
                        @endif
                        <form method="POST" action="{{ route('certificate.verify') }}">
                            @csrf
                            <label class="form-label fw-bold" style="color:#0B1F3A;">Certificate ID</label>
                            <div class="input-group">
                                <input type="text" name="certificate_id" class="form-control form-control-lg"
                                    placeholder="e.g. ST-2204325654"
                                    value="{{ old('certificate_id') }}" required>
                                <button type="submit" class="btn btn-warning fw-bold px-4">
                                    <i class="fas fa-search me-1"></i> Verify
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Certificate Result --}}
        @if(session('cert'))
        @php $cert = session('cert'); $student = $cert->student; @endphp
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow-lg" style="border-radius:20px;overflow:hidden;">
                    {{-- Header --}}
                    <div style="background:linear-gradient(135deg,#0B1F3A,#1557B0);padding:30px;text-align:center;">
                        <img src="{{ asset('images/logo.png') }}" height="60" alt="Suman Tech">
                        <h4 style="color:#F0A500;margin-top:10px;font-family:'Playfair Display',serif;">Suman Tech</h4>
                        <p style="color:rgba(255,255,255,.7);font-size:.85rem;">Making You Future Ready</p>
                    </div>

                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            {{-- Photo --}}
                            <div class="col-md-3 text-center mb-3">
                                @if($student->image)
                                <img src="{{ asset('storage/'.$student->image) }}"
                                    class="rounded-circle border border-4"
                                    style="width:120px;height:120px;object-fit:cover;border-color:#F0A500!important;"
                                    alt="{{ $student->name }}">
                                @else
                                <div style="width:120px;height:120px;background:#f0f0f0;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto;">
                                    <i class="fas fa-user" style="font-size:3rem;color:#ccc;"></i>
                                </div>
                                @endif
                            </div>

                            {{-- Details --}}
                            <div class="col-md-9">
                                <div class="alert alert-success mb-3">
                                    <i class="fas fa-check-circle me-2"></i>
                                    <strong>Certificate Verified Successfully!</strong>
                                </div>
                                <table class="table table-bordered">
                                    <tr>
                                        <td class="fw-bold" style="width:40%;background:#f8f9fa;">
                                            <i class="fas fa-id-card me-2 text-primary"></i>Student ID
                                        </td>
                                        <td style="color:#1557B0;font-weight:600;">{{ $student->registration_number }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold" style="background:#f8f9fa;">
                                            <i class="fas fa-certificate me-2 text-warning"></i>Certificate No.
                                        </td>
                                        <td style="color:#1557B0;font-weight:600;">{{ $cert->certificate_id }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold" style="background:#f8f9fa;">
                                            <i class="fas fa-user me-2 text-primary"></i>Name
                                        </td>
                                        <td>{{ strtoupper($student->name) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold" style="background:#f8f9fa;">
                                            <i class="fas fa-users me-2 text-primary"></i>Father Name
                                        </td>
                                        <td>{{ strtoupper($student->father_name) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold" style="background:#f8f9fa;">
                                            <i class="fas fa-calendar me-2 text-primary"></i>D.O.B
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($student->date_of_birth)->format('d M, Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold" style="background:#f8f9fa;">
                                            <i class="fas fa-book me-2 text-primary"></i>Course
                                        </td>
                                        <td>{{ $cert->course_name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold" style="background:#f8f9fa;">
                                            <i class="fas fa-star me-2 text-warning"></i>Total Marks
                                        </td>
                                        <td style="color:green;font-weight:700;">{{ $cert->marks ?? 'N/A' }}%</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold" style="background:#f8f9fa;">
                                            <i class="fas fa-calendar-check me-2 text-primary"></i>Issue Date
                                        </td>
                                        <td>{{ $cert->certificate_issue_date ? \Carbon\Carbon::parse($cert->certificate_issue_date)->format('d M, Y') : 'N/A' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- Footer --}}
                    <div style="background:#f8f9fa;padding:15px;text-align:center;">
                        <span class="badge bg-success px-3 py-2" style="font-size:.9rem;">
                            <i class="fas fa-shield-alt me-1"></i> Verified & Authentic Certificate
                        </span>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>
@endsection



