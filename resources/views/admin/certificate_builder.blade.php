{{-- File: resources/views/admin/certificate_builder.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Certificate Builder')
@push('styles')
<style>
.builder-wrap { display:flex; gap:16px; height:calc(100vh - 180px); }
.left-panel { width:260px; flex-shrink:0; overflow-y:auto; }
.right-panel { flex:1; overflow:hidden; }
.cert-stage {
    position:relative;
    display:inline-block;
    width:100%;
    border:2px dashed #dee2e6;
    border-radius:8px;
    overflow:hidden;
    background:#f0f0f0;
}
.cert-stage img { width:100%; display:block; pointer-events:none; }
.cert-elem {
    position:absolute;
    cursor:move;
    user-select:none;
    white-space:nowrap;
    padding:2px 4px;
    border:2px dashed transparent;
    border-radius:3px;
    line-height:1.2;
}
.cert-elem:hover { border-color:rgba(0,123,255,0.5); }
.cert-elem.active { border-color:#007bff; outline:none; }
.elem-card {
    display:flex; align-items:center; gap:10px;
    padding:10px 12px;
    border:1px solid #e0e0e0;
    border-radius:8px;
    background:#fff;
    margin-bottom:8px;
    cursor:pointer;
    transition:all 0.15s;
    font-size:13px;
}
.elem-card:hover { border-color:#007bff; background:#f0f4ff; }
.elem-card i { width:18px; text-align:center; }
.prop-box { background:#f8f9fa; border-radius:8px; padding:12px; }
.prop-box label { font-size:12px; font-weight:600; margin-bottom:3px; display:block; color:#555; }
.save-btn { background:linear-gradient(135deg,#1a2a6c,#6b3a1f); color:#fff; border:none; border-radius:8px; width:100%; padding:11px; font-weight:600; cursor:pointer; }
.save-btn:hover { opacity:0.9; }
.cert-tag { display:inline-block; background:#e8f4fd; color:#1a6a9a; border-radius:4px; padding:1px 6px; font-size:11px; margin-left:4px; }
</style>
@endpush
@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h5 class="fw-bold mb-0"><i class="fas fa-certificate me-2 text-warning"></i>Certificate Builder</h5>
        <small class="text-muted">{{ $model->title }} &nbsp;|&nbsp; Drag elements to position them on certificate</small>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ $backRoute }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Back</a>
    </div>
</div>

@if(session('success'))<div class="alert alert-success py-2">{{ session('success') }}</div>@endif
@if(!$certUrl)<div class="alert alert-warning py-2"><i class="fas fa-exclamation-triangle me-2"></i>Pehle certificate template upload karo — <a href="{{ $editRoute }}">Edit karo</a></div>@endif

<div class="builder-wrap">
    {{-- LEFT --}}
    <div class="left-panel">
        {{-- Elements --}}
        <div class="card border-0 shadow-sm p-3 mb-3">
            <div class="fw-bold mb-2" style="font-size:13px;color:#1a2a6c;"><i class="fas fa-plus-circle me-1"></i>ADD ELEMENTS</div>
            <div class="elem-card" onclick="addElem('name','Participant Name')">
                <i class="fas fa-user text-primary"></i> Participant Name
            </div>
            <div class="elem-card" onclick="addElem('cert_number','CERT-2025-001')">
                <i class="fas fa-hashtag text-success"></i> Certificate Number
            </div>
            <div class="elem-card" onclick="addElem('date','{{ date('d M Y') }}')">
                <i class="fas fa-calendar text-warning"></i> Date
            </div>
            <div class="elem-card" onclick="addElem('title','{{ addslashes($model->title) }}')">
                <i class="fas fa-trophy text-danger"></i> Award/Competition Title
            </div>
            <div class="elem-card" onclick="addElem('category','Category')">
                <i class="fas fa-tag text-info"></i> Category
            </div>
            <div class="elem-card" onclick="addElem('school','School Name')">
                <i class="fas fa-school" style="color:#6f42c1"></i> School
            </div>
        </div>

        {{-- Properties --}}
        <div class="card border-0 shadow-sm p-3 mb-3" id="propPanel" style="display:none;">
            <div class="fw-bold mb-2" style="font-size:13px;color:#1a2a6c;"><i class="fas fa-sliders-h me-1"></i>PROPERTIES</div>
            <div class="prop-box">
                <div class="mb-2">
                    <label>Font Size: <span id="fsVal">24</span>px</label>
                    <input type="range" id="fs" min="8" max="72" value="24" class="form-range" oninput="applyProp()">
                </div>
                <div class="mb-2">
                    <label>Color</label>
                    <input type="color" id="fc" value="#1a2a6c" class="form-control form-control-sm" oninput="applyProp()">
                </div>
                <div class="mb-2">
                    <label>Font Weight</label>
                    <select id="fw" class="form-select form-select-sm" onchange="applyProp()">
                        <option value="400">Normal</option>
                        <option value="600">Semi Bold</option>
                        <option value="700" selected>Bold</option>
                        <option value="900">Extra Bold</option>
                    </select>
                </div>
                <div class="mb-2">
                    <label>Font Style</label>
                    <select id="fi" class="form-select form-select-sm" onchange="applyProp()">
                        <option value="normal" selected>Normal</option>
                        <option value="italic">Italic</option>
                    </select>
                </div>
                <div class="mb-2">
                    <label>Align</label>
                    <div class="btn-group w-100">
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="setAlign('left')"><i class="fas fa-align-left"></i></button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="setAlign('center')"><i class="fas fa-align-center"></i></button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="setAlign('right')"><i class="fas fa-align-right"></i></button>
                    </div>
                </div>
                <button class="btn btn-danger btn-sm w-100 mt-1" onclick="deleteElem()">
                    <i class="fas fa-trash me-1"></i>Delete Element
                </button>
            </div>
        </div>

        {{-- Save --}}
        <div class="card border-0 shadow-sm p-3">
            <div class="fw-bold mb-2" style="font-size:13px;color:#1a2a6c;"><i class="fas fa-save me-1"></i>SAVE LAYOUT</div>
            <p style="font-size:12px;color:#666;">Layout save hone ke baad, har naye participant ka certificate auto-generate hoga.</p>
            <form action="{{ $saveRoute }}" method="POST">
                @csrf
                <input type="hidden" name="layout" id="layoutJson">
                <button type="submit" class="save-btn" onclick="prepSave()">
                    <i class="fas fa-save me-2"></i>Save Certificate Layout
                </button>
            </form>
            @if($model->cert_layout)
            <div class="mt-2 p-2 bg-success bg-opacity-10 rounded text-success" style="font-size:12px;">
                <i class="fas fa-check-circle me-1"></i>Layout already saved! Participants ko update karo.
            </div>
            @endif
        </div>
    </div>

    {{-- RIGHT: Canvas --}}
    <div class="right-panel">
        <div class="card border-0 shadow-sm h-100" style="overflow:auto;">
            <div class="card-body">
                @if($certUrl)
                <div class="cert-stage" id="stage">
                    <img src="{{ $certUrl }}" id="certBg" alt="Certificate">
                    {{-- Elements rendered here --}}
                </div>
                @else
                <div class="d-flex align-items-center justify-content-center h-100 text-muted">
                    <div class="text-center">
                        <i class="fas fa-image fa-4x mb-3"></i>
                        <p>Certificate template upload karo pehle</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
var elems = [];
var activeEl = null;
var activeIdx = -1;

// Load saved layout
@if($model->cert_layout)
var saved = {!! $model->cert_layout !!};
window.addEventListener('load', () => setTimeout(() => saved.forEach(d => renderElem(d)), 400));
@endif

function addElem(type, defaultText) {
    renderElem({ type, text: defaultText, x: 30, y: 40, fs: 24, fc: '#1a2a6c', fw: '700', fi: 'normal', align: 'center' });
}

function renderElem(d) {
    var stage = document.getElementById('stage');
    var div = document.createElement('div');
    div.className = 'cert-elem';
    div.dataset.type = d.type;
    div.innerText = d.text;
    div.style.cssText = `left:${d.x}%;top:${d.y}%;font-size:${d.fs}px;color:${d.fc};font-weight:${d.fw};font-style:${d.fi||'normal'};text-align:${d.align||'left'};transform:translateX(-50%);`;

    var idx = elems.length;
    elems.push({ el: div, d });

    div.addEventListener('click', e => { e.stopPropagation(); selectEl(div, idx); });
    makeDrag(div, idx);
    stage.appendChild(div);
    selectEl(div, idx);
}

function selectEl(el, idx) {
    if(activeEl) activeEl.classList.remove('active');
    activeEl = el; activeIdx = idx;
    el.classList.add('active');
    document.getElementById('propPanel').style.display = 'block';
    var d = elems[idx].d;
    document.getElementById('fs').value = d.fs;
    document.getElementById('fsVal').innerText = d.fs;
    document.getElementById('fc').value = d.fc;
    document.getElementById('fw').value = d.fw;
    document.getElementById('fi').value = d.fi || 'normal';
}

function applyProp() {
    if(!activeEl || activeIdx < 0) return;
    var fs = document.getElementById('fs').value;
    var fc = document.getElementById('fc').value;
    var fw = document.getElementById('fw').value;
    var fi = document.getElementById('fi').value;
    document.getElementById('fsVal').innerText = fs;
    activeEl.style.fontSize = fs + 'px';
    activeEl.style.color = fc;
    activeEl.style.fontWeight = fw;
    activeEl.style.fontStyle = fi;
    elems[activeIdx].d.fs = parseInt(fs);
    elems[activeIdx].d.fc = fc;
    elems[activeIdx].d.fw = fw;
    elems[activeIdx].d.fi = fi;
}

function setAlign(a) {
    if(!activeEl) return;
    activeEl.style.textAlign = a;
    elems[activeIdx].d.align = a;
}

function deleteElem() {
    if(!activeEl) return;
    activeEl.remove();
    elems.splice(activeIdx, 1);
    activeEl = null; activeIdx = -1;
    document.getElementById('propPanel').style.display = 'none';
}

function makeDrag(el, idx) {
    el.addEventListener('mousedown', function(e) {
        e.preventDefault();
        var stage = document.getElementById('stage');
        var sr = stage.getBoundingClientRect();
        var sx = e.clientX, sy = e.clientY;
        var sl = parseFloat(el.style.left)||0, st = parseFloat(el.style.top)||0;
        function mv(e) {
            var nx = Math.max(0, Math.min(95, sl + ((e.clientX-sx)/sr.width*100)));
            var ny = Math.max(0, Math.min(95, st + ((e.clientY-sy)/sr.height*100)));
            el.style.left = nx+'%'; el.style.top = ny+'%';
            if(elems[idx]) { elems[idx].d.x = nx; elems[idx].d.y = ny; }
        }
        function up() { document.removeEventListener('mousemove', mv); document.removeEventListener('mouseup', up); }
        document.addEventListener('mousemove', mv);
        document.addEventListener('mouseup', up);
    });
}

document.addEventListener('click', () => {
    if(activeEl) activeEl.classList.remove('active');
    activeEl = null; activeIdx = -1;
});

function prepSave() {
    var layout = elems.map(e => e.d);
    document.getElementById('layoutJson').value = JSON.stringify(layout);
}
</script>
@endpush


