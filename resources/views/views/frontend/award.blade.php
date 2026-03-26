{{-- File: resources/views/frontend/award.blade.php --}}
@extends('layouts.frontend')
@section('title', 'Awards - Teachers of Bihar')
@push('styles')
<style>
.award-card { border-radius:12px; overflow:hidden; transition:transform 0.2s; }
.award-card:hover { transform:translateY(-4px); }
.cert-modal .modal-body { background:#f8f9fa; }
.cert-preview { position:relative; display:inline-block; width:100%; }
.cert-preview img { width:100%; border-radius:8px; }
.cert-name-overlay {
    position:absolute;
    top:50%; left:50%;
    transform:translate(-50%,-50%);
    font-size:28px;
    font-weight:700;
    color:#1a2a6c;
    text-align:center;
    width:80%;
    pointer-events:none;
    text-shadow:1px 1px 2px rgba(255,255,255,0.8);
}
</style>
@endpush
@section('content')
<div class="page-banner"><div class="container"><h1>Awards & Recognition</h1></div></div>
<div class="container py-5">
    <div class="row g-4">
        @forelse($awards as $award)
        <div class="col-md-6">
            <div class="card border-0 shadow-sm award-card h-100">
                @if($award->image)
                <img src="{{ $award->image_url }}" class="card-img-top" style="height:220px;object-fit:cover;" onerror="this.onerror=null;this.style.opacity='0.3'">
                @endif
                <div class="card-body p-4">
                    <div class="d-flex align-items-start gap-3">
                        @if(!$award->image)
                        <i class="fas fa-trophy fa-3x" style="color:#ffc107;"></i>
                        @endif
                        <div class="flex-grow-1">
                            <h5 class="fw-bold" style="color:#1a2a6c;">{{ $award->title }}</h5>
                            @if($award->year)
                            <span class="badge bg-primary mb-2">{{ $award->year }}</span>
                            @endif
                            @if($award->description)
                            <p class="mb-3 text-muted">{{ $award->description }}</p>
                            @endif

                            {{-- Certificate Download Button --}}
                            @if($award->has_certificate && $award->certificate_template)
                            <button class="btn btn-sm btn-warning fw-semibold"
                                onclick="openCertModal({{ $award->id }}, '{{ $award->certificate_url }}', '{{ addslashes($award->title) }}')">
                                <i class="fas fa-certificate me-1"></i>Download Certificate
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5 text-muted">
            <i class="fas fa-trophy fa-3x mb-3" style="color:#ffc107;"></i>
            <p>No awards listed yet.</p>
        </div>
        @endforelse
    </div>
</div>

{{-- Certificate Modal --}}
<div class="modal fade" id="certModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content cert-modal">
            <div class="modal-header" style="background:linear-gradient(135deg,#1a2a6c,#6b3a1f);color:#fff;">
                <h5 class="modal-title"><i class="fas fa-certificate me-2"></i>Download Certificate</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Apna Naam Likhiye <span class="text-danger">*</span></label>
                    <input type="text" id="certName" class="form-control form-control-lg"
                           placeholder="Yahan apna naam likhiye..."
                           oninput="updateCertName(this.value)">
                </div>

                {{-- Certificate Preview --}}
                <div class="cert-preview mb-3" id="certPreviewWrap">
                    <img id="certImg" src="" alt="Certificate" style="width:100%;border-radius:8px;">
                    <div class="cert-name-overlay" id="certNameOverlay">Aapka Naam</div>
                </div>

                <div class="text-center">
                    <button class="btn btn-success btn-lg px-5" onclick="downloadCertificate()">
                        <i class="fas fa-download me-2"></i>Download Certificate
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
var currentCertUrl = '';
var currentAwardTitle = '';

function openCertModal(awardId, certUrl, awardTitle) {
    currentCertUrl = certUrl;
    currentAwardTitle = awardTitle;
    document.getElementById('certImg').src = certUrl;
    document.getElementById('certName').value = '';
    document.getElementById('certNameOverlay').innerText = 'Aapka Naam';
    var modal = new bootstrap.Modal(document.getElementById('certModal'));
    modal.show();
}

function updateCertName(name) {
    document.getElementById('certNameOverlay').innerText = name || 'Aapka Naam';
}

function downloadCertificate() {
    var name = document.getElementById('certName').value.trim();
    if (!name) {
        alert('Pehle apna naam likhiye!');
        document.getElementById('certName').focus();
        return;
    }

    var wrap = document.getElementById('certPreviewWrap');
    html2canvas(wrap, { scale: 2, useCORS: true, allowTaint: true }).then(function(canvas) {
        var link = document.createElement('a');
        link.download = 'certificate-' + name.replace(/\s+/g, '-') + '.png';
        link.href = canvas.toDataURL('image/png');
        link.click();
    });
}
</script>
@endpush
