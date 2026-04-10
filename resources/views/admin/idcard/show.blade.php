@extends('layouts.admin')
@section('title', 'ID Card - {{ $student->name }}')
@section('content')
<div class="content-area">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold" style="color:#1a2a6c;">
            <i class="fas fa-id-card me-2"></i>Student ID Card
        </h4>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.idcard.pdf', $student) }}" class="btn btn-danger fw-bold">
                <i class="fas fa-file-pdf me-2"></i>Download PDF
            </a>
            <a href="{{ route('admin.registration.show', $student) }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>Back
            </a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            {{-- ID Card Preview --}}
            <div class="row g-4">
                {{-- FRONT --}}
                <div class="col-md-6">
                    <p class="text-center fw-bold text-muted mb-2">FRONT</p>
                    <div style="width:100%;aspect-ratio:2/3;border-radius:16px;overflow:hidden;box-shadow:0 10px 40px rgba(0,0,0,.2);position:relative;background:#fff;">
                        {{-- Top Wave --}}
                        <div style="background:linear-gradient(135deg,#0B1F3A,#1557B0);height:35%;position:relative;overflow:hidden;">
                            <div style="position:absolute;bottom:-30px;left:0;right:0;">
                                <svg viewBox="0 0 400 60" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0,30 C100,60 300,0 400,30 L400,60 L0,60 Z" fill="#fff"/>
                                </svg>
                            </div>
                            {{-- Logo --}}
                            <div class="text-center pt-3">
                                <img src="{{ asset('images/logo.png') }}" height="45" alt="Suman Tech"
                                    style="filter:brightness(10);">
                            </div>
                        </div>

                        {{-- Photo --}}
                        <div style="position:absolute;top:22%;left:50%;transform:translateX(-50%);z-index:10;">
                            <div style="width:90px;height:90px;border-radius:16px;border:4px solid #1557B0;overflow:hidden;background:#f0f0f0;box-shadow:0 4px 15px rgba(0,0,0,.2);">
                                @if($student->image)
                                <img src="{{ asset('storage/'.$student->image) }}"
                                    style="width:100%;height:100%;object-fit:cover;">
                                @else
                                <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:#e0e0e0;">
                                    <i class="fas fa-user" style="font-size:2rem;color:#aaa;"></i>
                                </div>
                                @endif
                            </div>
                        </div>

                        {{-- Details --}}
                        <div style="padding:60px 20px 20px;text-align:center;">
                            <h5 style="color:#0B1F3A;font-weight:900;font-size:1.1rem;margin-bottom:4px;">
                                {{ strtoupper($student->name) }}
                            </h5>
                            <p style="color:#1557B0;font-size:.8rem;font-weight:600;margin-bottom:15px;">
                                {{ $student->courses->first()->course_name ?? 'Student' }}
                            </p>

                            <div style="background:#f8f9fa;border-radius:10px;padding:10px;margin:0 10px;text-align:left;">
                                <div style="font-size:.72rem;color:#666;margin-bottom:6px;">
                                    <strong style="color:#0B1F3A;">Reg ID :</strong>
                                    {{ $student->registration_number }}
                                </div>
                                <div style="font-size:.72rem;color:#666;margin-bottom:6px;">
                                    <strong style="color:#0B1F3A;">Father :</strong>
                                    {{ $student->father_name }}
                                </div>
                                <div style="font-size:.72rem;color:#666;margin-bottom:6px;">
                                    <strong style="color:#0B1F3A;">DOB :</strong>
                                    {{ \Carbon\Carbon::parse($student->date_of_birth)->format('d M Y') }}
                                </div>
                                <div style="font-size:.72rem;color:#666;">
                                    <strong style="color:#0B1F3A;">Mobile :</strong>
                                    {{ $student->mobile }}
                                </div>
                            </div>
                        </div>

                        {{-- Bottom Wave --}}
                        <div style="position:absolute;bottom:0;left:0;right:0;">
                            <svg viewBox="0 0 400 60" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0,30 C100,0 300,60 400,30 L400,60 L0,60 Z" fill="#1557B0"/>
                                <path d="M0,40 C100,10 300,70 400,40 L400,60 L0,60 Z" fill="#0B1F3A" opacity=".5"/>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- BACK --}}
                <div class="col-md-6">
                    <p class="text-center fw-bold text-muted mb-2">BACK</p>
                    <div style="width:100%;aspect-ratio:2/3;border-radius:16px;overflow:hidden;box-shadow:0 10px 40px rgba(0,0,0,.2);position:relative;background:#fff;">
                        {{-- Top Wave --}}
                        <div style="background:linear-gradient(135deg,#1557B0,#0B1F3A);height:20%;position:relative;overflow:hidden;">
                            <div style="position:absolute;bottom:-20px;left:0;right:0;">
                                <svg viewBox="0 0 400 40" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0,20 C100,40 300,0 400,20 L400,40 L0,40 Z" fill="#fff"/>
                                </svg>
                            </div>
                            <div class="text-center pt-2">
                                <span style="color:#F0A500;font-weight:900;font-size:.9rem;letter-spacing:.1em;">SUMAN TECH</span>
                            </div>
                        </div>

                        {{-- Back Content --}}
                        <div style="padding:30px 20px 20px;text-align:center;">
                            <h6 style="color:#0B1F3A;font-weight:900;margin-bottom:15px;">Suman Tech</h6>
                            <div style="text-align:left;font-size:.72rem;color:#555;line-height:1.8;">
                                <div><strong>📍</strong> Muzaffarpur, Bihar</div>
                                <div><strong>📞</strong> +91 89207 79218</div>
                                <div><strong>✉️</strong> thesumantech@gmail.com</div>
                                <div><strong>🌐</strong> sumantech.test</div>
                            </div>

                            <hr style="margin:15px 0;">

                            <div style="background:#fff3cd;border-radius:10px;padding:10px;font-size:.68rem;color:#856404;text-align:left;line-height:1.6;">
                                <strong>Note:</strong> Students must carry their ID card at all times within institute premises for security and verification.
                            </div>

                            <hr style="margin:15px 0;">

                            <div style="font-size:.68rem;color:#666;">
                                <strong style="color:#0B1F3A;">Emergency Contact</strong><br>
                                +91 89207 79218
                            </div>
                        </div>

                        {{-- Bottom Wave --}}
                        <div style="position:absolute;bottom:0;left:0;right:0;">
                            <svg viewBox="0 0 400 60" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0,30 C100,0 300,60 400,30 L400,60 L0,60 Z" fill="#1557B0"/>
                                <path d="M0,40 C100,10 300,70 400,40 L400,60 L0,60 Z" fill="#0B1F3A" opacity=".5"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection