<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
* { margin:0; padding:0; box-sizing:border-box; }
body { font-family: DejaVu Sans, sans-serif; }
.page { width:283.46pt; height:425.2pt; position:relative; overflow:hidden; background:#fff; }
.top-bg { background:linear-gradient(135deg,#0B1F3A,#1557B0); height:140pt; position:relative; }
.logo-area { text-align:center; padding-top:15pt; }
.logo-area img { height:40pt; }
.wave-top { position:absolute; bottom:0; left:0; right:0; }
.photo-wrap { text-align:center; margin-top:-45pt; position:relative; z-index:10; }
.photo-wrap img { width:80pt; height:80pt; border-radius:10pt; border:3pt solid #1557B0; object-fit:cover; }
.name { text-align:center; margin-top:8pt; font-size:14pt; font-weight:bold; color:#0B1F3A; }
.course { text-align:center; font-size:9pt; color:#1557B0; font-weight:bold; margin-bottom:10pt; }
.details { margin:0 15pt; background:#f8f9fa; border-radius:8pt; padding:8pt; }
.detail-row { font-size:8pt; color:#444; margin-bottom:5pt; }
.detail-row strong { color:#0B1F3A; }
.bottom-wave { position:absolute; bottom:0; left:0; right:0; }

/* Back */
.back-top { background:linear-gradient(135deg,#1557B0,#0B1F3A); height:60pt; position:relative; }
.back-title { text-align:center; padding-top:15pt; color:#F0A500; font-weight:bold; font-size:11pt; letter-spacing:2pt; }
.back-content { padding:30pt 15pt 15pt; }
.back-info { font-size:8pt; color:#555; line-height:2; }
.note-box { background:#fff3cd; border-radius:6pt; padding:8pt; font-size:7pt; color:#856404; line-height:1.6; margin:10pt 0; }
.emergency { text-align:center; font-size:8pt; color:#444; margin-top:8pt; }
</style>
</head>
<body>

{{-- FRONT --}}
<div class="page">
    <div class="top-bg">
        <div class="logo-area">
            <img src="{{ public_path('images/logo.png') }}" alt="Suman Tech">
            <div style="color:#F0A500;font-weight:bold;font-size:9pt;margin-top:5pt;letter-spacing:1pt;">SUMAN TECH</div>
            <div style="color:rgba(255,255,255,.7);font-size:7pt;">Making You Future Ready</div>
        </div>
        <svg style="position:absolute;bottom:0;left:0;width:100%;" viewBox="0 0 400 40" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,20 C100,40 300,0 400,20 L400,40 L0,40 Z" fill="#fff"/>
        </svg>
    </div>

    <div class="photo-wrap">
        @if($student->image && file_exists(storage_path('app/public/'.$student->image)))
        <img src="{{ storage_path('app/public/'.$student->image) }}" alt="{{ $student->name }}">
        @else
        <div style="width:80pt;height:80pt;border-radius:10pt;border:3pt solid #1557B0;background:#e0e0e0;display:inline-block;"></div>
        @endif
    </div>

    <div class="name">{{ strtoupper($student->name) }}</div>
    <div class="course">{{ $student->courses->first()->course_name ?? 'Student' }}</div>

    <div class="details">
        <div class="detail-row"><strong>Reg ID :</strong> {{ $student->registration_number }}</div>
        <div class="detail-row"><strong>Father :</strong> {{ $student->father_name }}</div>
        <div class="detail-row"><strong>DOB :</strong> {{ \Carbon\Carbon::parse($student->date_of_birth)->format('d M Y') }}</div>
        <div class="detail-row"><strong>Mobile :</strong> {{ $student->mobile }}</div>
        <div class="detail-row"><strong>Valid :</strong> {{ now()->format('Y') }} — {{ now()->addYear()->format('Y') }}</div>
    </div>

    <svg style="position:absolute;bottom:0;left:0;width:100%;" viewBox="0 0 400 50" xmlns="http://www.w3.org/2000/svg">
        <path d="M0,25 C100,0 300,50 400,25 L400,50 L0,50 Z" fill="#1557B0"/>
        <path d="M0,35 C100,10 300,60 400,35 L400,50 L0,50 Z" fill="#0B1F3A" opacity=".5"/>
    </svg>
</div>

<div style="page-break-after:always;"></div>

{{-- BACK --}}
<div class="page">
    <div class="back-top">
        <div class="back-title">SUMAN TECH</div>
        <svg style="position:absolute;bottom:0;left:0;width:100%;" viewBox="0 0 400 30" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,15 C100,30 300,0 400,15 L400,30 L0,30 Z" fill="#fff"/>
        </svg>
    </div>

    <div class="back-content">
        <div style="text-align:center;font-weight:bold;color:#0B1F3A;font-size:11pt;margin-bottom:10pt;">Suman Tech</div>

        <div class="back-info">
            📍 Muzaffarpur, Bihar<br>
            📞 +91 89207 79218<br>
            ✉ thesumantech@gmail.com<br>
            🌐 sumantech.in
        </div>

        <div class="note-box">
            <strong>Note:</strong> Students must carry their ID card at all times within institute premises for security and verification purposes.
        </div>

        <div class="emergency">
            <strong style="color:#0B1F3A;">Emergency Contact</strong><br>
            +91 89207 79218
        </div>
    </div>

    <svg style="position:absolute;bottom:0;left:0;width:100%;" viewBox="0 0 400 50" xmlns="http://www.w3.org/2000/svg">
        <path d="M0,25 C100,0 300,50 400,25 L400,50 L0,50 Z" fill="#1557B0"/>
        <path d="M0,35 C100,10 300,60 400,35 L400,50 L0,50 Z" fill="#0B1F3A" opacity=".5"/>
    </svg>
</div>

</body>
</html>