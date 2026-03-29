{{-- File: resources/views/admin/awards/certificate_builder.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Certificate Builder')
@push('styles')
<style>
* { box-sizing: border-box; }
.builder-wrap { display:flex; gap:16px; }
.left-panel { width:270px; flex-shrink:0; overflow-y:auto; max-height:90vh; }
.right-panel { flex:1; }
.panel-card { background:#fff; border:1px solid #e0e0e0; border-radius:10px; padding:14px; margin-bottom:12px; box-shadow:0 1px 4px rgba(0,0,0,0.06); }
.panel-card h6 { font-weight:700; font-size:12px; color:#1a2a6c; text-transform:uppercase; letter-spacing:.5px; border-bottom:2px solid #f0f0f0; padding-bottom:7px; margin-bottom:10px; }
.elem-btn { width:100%; text-align:left; padding:8px 11px; border:1px solid #e0e0e0; border-radius:7px; background:#fff; cursor:pointer; font-size:12px; margin-bottom:5px; transition:all .15s; display:flex; align-items:center; gap:8px; }
.elem-btn:hover { background:#f0f4ff; border-color:#007bff; color:#007bff; }
.cert-canvas { position:relative; border:2px dashed #ccc; border-radius:8px; overflow:hidden; background:#eee; cursor:default; }
.cert-canvas img.cert-bg { width:100%; display:block; pointer-events:none; user-select:none; }
.cert-el { position:absolute; cursor:move; padding:2px 5px; border:2px dashed transparent; border-radius:3px; line-height:1.2; white-space:nowrap; user-select:none; }
.cert-el:hover { border-color:rgba(0,123,255,.5); }
.cert-el.active { border-color:#007bff; background:rgba(0,123,255,.1); outline:none; }
.cert-el.type-image { cursor:move; }
.cert-el img.inner-img { display:block; pointer-events:none; }
.prop-row { margin-bottom:9px; }
.prop-row label { font-size:11px; font-weight:600; display:block; margin-bottom:3px; color:#555; }
.save-btn { background:linear-gradient(135deg,#1a2a6c,#6b3a1f); color:#fff; border:none; border-radius:8px; width:100%; padding:11px; font-size:14px; font-weight:600; cursor:pointer; }
.save-btn:hover { opacity:.9; }
.del-btn { background:#dc3545; color:#fff; border:none; border-radius:6px; width:100%; padding:7px; font-size:12px; cursor:pointer; margin-top:6px; }
.layer-list { max-height:120px; overflow-y:auto; }
.layer-item { display:flex; justify-content:space-between; align-items:center; padding:4px 8px; border:1px solid #eee; border-radius:5px; margin-bottom:3px; font-size:11px; cursor:pointer; }
.layer-item.active { background:#e8f0fe; border-color:#007bff; }
.layer-item .del-layer { color:#dc3545; border:none; background:none; cursor:pointer; font-size:11px; }
</style>
@endpush
@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h5 class="fw-bold mb-0"><i class="fas fa-certificate me-2 text-warning"></i>Certificate Builder</h5>
        <small class="text-muted">{{ $award->title }}</small>
    </div>
    <a href="{{ route('admin.awards.participants', $award) }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Back</a>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible py-2"><button type="button" class="btn-close" data-bs-dismiss="alert"></button><i class="fas fa-check-circle me-2"></i>{{ session('success') }}</div>
@endif

@if(!$award->certificate_template)
<div class="alert alert-warning"><i class="fas fa-exclamation-triangle me-2"></i>Pehle certificate template upload karo — <a href="{{ route('admin.awards.edit', $award) }}">Edit Award</a></div>
@else

<div class="builder-wrap">
{{-- ===== LEFT PANEL ===== --}}
<div class="left-panel">

    {{-- Add Elements --}}
    <div class="panel-card">
        <h6><i class="fas fa-plus me-1"></i>Elements Add Karo</h6>
        <button class="elem-btn" onclick="addText('name','Participant Name')"><i class="fas fa-user text-primary fa-fw"></i>Participant Name</button>
        <button class="elem-btn" onclick="addText('cert_number','CERT-2025-0001')"><i class="fas fa-hashtag text-success fa-fw"></i>Certificate Number</button>
        <button class="elem-btn" onclick="addText('date', getTodayDate())"><i class="fas fa-calendar text-warning fa-fw"></i>Date (Auto)</button>
        <button class="elem-btn" onclick="addText('date2', getTodayDate())"><i class="fas fa-calendar-plus text-info fa-fw"></i>Date 2 (Auto)</button>
        <button class="elem-btn" onclick="addText('award_title', @json($award->title))"><i class="fas fa-trophy text-danger fa-fw"></i>Award Title</button>
        <button class="elem-btn" onclick="addText('category','Category')"><i class="fas fa-tag text-info fa-fw"></i>Category</button>
        <button class="elem-btn" onclick="addLabel()"><i class="fas fa-font text-secondary fa-fw"></i>Custom Label</button>
        <button class="elem-btn" onclick="document.getElementById('imgUpload').click()"><i class="fas fa-image text-success fa-fw"></i>Image Add Karo</button>
        <input type="file" id="imgUpload" accept="image/*" style="display:none" onchange="addImage(this)">
    </div>

    {{-- Properties --}}
    <div class="panel-card" id="propCard" style="display:none;">
        <h6><i class="fas fa-sliders-h me-1"></i>Properties</h6>
        <div id="textProps">
            <div class="prop-row">
                <label>Font Size: <span id="fsVal">24</span>px</label>
                <input type="range" id="propFs" min="8" max="80" value="24" class="form-range" oninput="updateProp()">
            </div>
            <div class="prop-row">
                <label>Text Color</label>
                <input type="color" id="propColor" value="#1a2a6c" class="form-control form-control-sm" oninput="updateProp()">
            </div>
            <div class="prop-row">
                <label>Font Weight</label>
                <select id="propFw" class="form-select form-select-sm" onchange="updateProp()">
                    <option value="400">Normal</option>
                    <option value="600">Semi Bold</option>
                    <option value="700" selected>Bold</option>
                    <option value="900">Extra Bold</option>
                </select>
            </div>
            <div class="prop-row">
                <label>Font Style</label>
                <select id="propFi" class="form-select form-select-sm" onchange="updateProp()">
                    <option value="normal" selected>Normal</option>
                    <option value="italic">Italic</option>
                </select>
            </div>
            <div class="prop-row">
                <label>Text Align</label>
                <select id="propAlign" class="form-select form-select-sm" onchange="updateProp()">
                    <option value="left">Left</option>
                    <option value="center" selected>Center</option>
                    <option value="right">Right</option>
                </select>
            </div>
            <div class="prop-row" id="labelTextRow" style="display:none;">
                <label>Label Text</label>
                <input type="text" id="propLabelText" class="form-control form-control-sm" oninput="updateLabelText()">
            </div>
        </div>
        <div id="imageProps" style="display:none;">
            <div class="prop-row">
                <label>Width: <span id="imgWVal">80</span>px</label>
                <input type="range" id="propImgW" min="20" max="400" value="80" class="form-range" oninput="updateProp()">
            </div>
        </div>
        <button class="del-btn" onclick="deleteElem()"><i class="fas fa-trash me-1"></i>Delete Element</button>
    </div>

    {{-- Layers --}}
    <div class="panel-card">
        <h6><i class="fas fa-layer-group me-1"></i>Layers</h6>
        <div class="layer-list" id="layerList"></div>
    </div>

    {{-- Save --}}
    <div class="panel-card">
        <h6><i class="fas fa-save me-1"></i>Save Layout</h6>
        <form action="{{ route('admin.awards.saveCertLayout', $award) }}" method="POST">
            @csrf
            <input type="hidden" name="layout" id="layoutData">
            <button type="submit" class="save-btn" onclick="prepSave()"><i class="fas fa-save me-2"></i>Save Layout</button>
        </form>
        @if($award->cert_layout)
        <div class="text-success small mt-2"><i class="fas fa-check-circle me-1"></i>Layout saved!</div>
        @endif
    </div>

</div>

{{-- ===== RIGHT PANEL ===== --}}
<div class="right-panel">
    <div class="panel-card">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h6 class="mb-0"><i class="fas fa-image me-1"></i>Certificate Preview</h6>
            <small class="text-muted"><i class="fas fa-info-circle me-1"></i>Click element to select, drag to move</small>
        </div>
        <div class="cert-canvas" id="certCanvas">
            <img src="{{ $award->certificate_url }}" id="certBg" class="cert-bg" crossorigin="anonymous" onerror="this.onerror=null;this.style.opacity='.3'">
        </div>
    </div>
</div>
</div>

@endif
@endsection

@push('scripts')
<script>
var elems   = [];
var selIdx  = -1;

function getTodayDate() {
    return new Date().toLocaleDateString('en-IN', {day:'2-digit', month:'long', year:'numeric'});
}

// ── Load saved layout ──────────────────────────────
@if($award->cert_layout)
window.addEventListener('load', function() {
    var saved = @json(json_decode($award->cert_layout, true));
    if (saved && saved.length) {
        setTimeout(function() {
            saved.forEach(function(d) {
                if (d.kind === 'image') restoreImage(d);
                else restoreText(d);
            });
        }, 400);
    }
});
@endif

// ── Add text element ──────────────────────────────
function addText(type, label) {
    var d = { kind:'text', type:type, label:label, x:30, y:40, fs:28, color:'#1a2a6c', fw:'700', fi:'normal', align:'center' };
    restoreText(d);
}

function restoreText(d) {
    var canvas = document.getElementById('certCanvas');
    var div    = document.createElement('div');
    div.className   = 'cert-el type-text';
    div.innerText   = d.label;
    div.style.left  = d.x + '%';
    div.style.top   = d.y + '%';
    div.style.fontSize   = d.fs + 'px';
    div.style.color      = d.color;
    div.style.fontWeight = d.fw;
    div.style.fontStyle  = d.fi || 'normal';
    div.style.textAlign  = d.align;

    var idx = elems.length;
    div.dataset.idx = idx;
    div.addEventListener('click', function(e) { e.stopPropagation(); selectElem(parseInt(this.dataset.idx)); });
    makeDrag(div);
    canvas.appendChild(div);
    elems.push({ el:div, kind:'text', type:d.type, label:d.label, x:d.x, y:d.y, fs:d.fs, color:d.color, fw:d.fw, fi:d.fi||'normal', align:d.align });
    selectElem(idx);
    refreshLayers();
}

// ── Add label ──────────────────────────────────────
function addLabel() {
    var text = prompt('Label text likhiye:', 'Custom Text');
    if (!text) return;
    addText('label', text);
}

// ── Add image ──────────────────────────────────────
function addImage(input) {
    if (!input.files || !input.files[0]) return;
    var reader = new FileReader();
    reader.onload = function(e) {
        var d = { kind:'image', src:e.target.result, x:30, y:40, w:80 };
        restoreImage(d);
    };
    reader.readAsDataURL(input.files[0]);
    input.value = '';
}

function restoreImage(d) {
    var canvas = document.getElementById('certCanvas');
    var div    = document.createElement('div');
    div.className = 'cert-el type-image';
    div.style.left = d.x + '%';
    div.style.top  = d.y + '%';

    var img = document.createElement('img');
    img.className   = 'inner-img';
    img.src         = d.src;
    img.style.width = (d.w || 80) + 'px';
    div.appendChild(img);

    var idx = elems.length;
    div.dataset.idx = idx;
    div.addEventListener('click', function(e) { e.stopPropagation(); selectElem(parseInt(this.dataset.idx)); });
    makeDrag(div);
    canvas.appendChild(div);
    elems.push({ el:div, kind:'image', src:d.src, x:d.x, y:d.y, w:d.w||80 });
    selectElem(idx);
    refreshLayers();
}

// ── Select element ────────────────────────────────
function selectElem(idx) {
    if (selIdx >= 0 && elems[selIdx]) elems[selIdx].el.classList.remove('active');
    selIdx = idx;
    if (idx < 0 || !elems[idx]) { document.getElementById('propCard').style.display='none'; refreshLayers(); return; }
    elems[idx].el.classList.add('active');
    document.getElementById('propCard').style.display = 'block';

    var e = elems[idx];
    if (e.kind === 'image') {
        document.getElementById('textProps').style.display  = 'none';
        document.getElementById('imageProps').style.display = 'block';
        document.getElementById('propImgW').value = e.w;
        document.getElementById('imgWVal').innerText = e.w;
    } else {
        document.getElementById('textProps').style.display  = 'block';
        document.getElementById('imageProps').style.display = 'none';
        document.getElementById('propFs').value    = e.fs;
        document.getElementById('fsVal').innerText = e.fs;
        document.getElementById('propColor').value = e.color;
        document.getElementById('propFw').value    = e.fw;
        document.getElementById('propFi').value    = e.fi || 'normal';
        document.getElementById('propAlign').value = e.align;
        var isLabel = (e.type === 'label');
        document.getElementById('labelTextRow').style.display = isLabel ? 'block' : 'none';
        if (isLabel) document.getElementById('propLabelText').value = e.label;
    }
    refreshLayers();
}

// ── Update properties ─────────────────────────────
function updateProp() {
    if (selIdx < 0 || !elems[selIdx]) return;
    var e = elems[selIdx];
    if (e.kind === 'image') {
        var w = parseInt(document.getElementById('propImgW').value);
        document.getElementById('imgWVal').innerText = w;
        e.el.querySelector('img').style.width = w + 'px';
        e.w = w;
    } else {
        var fs    = parseInt(document.getElementById('propFs').value);
        var color = document.getElementById('propColor').value;
        var fw    = document.getElementById('propFw').value;
        var fi    = document.getElementById('propFi').value;
        var align = document.getElementById('propAlign').value;
        document.getElementById('fsVal').innerText = fs;
        e.el.style.fontSize   = fs + 'px';
        e.el.style.color      = color;
        e.el.style.fontWeight = fw;
        e.el.style.fontStyle  = fi;
        e.el.style.textAlign  = align;
        e.fs = fs; e.color = color; e.fw = fw; e.fi = fi; e.align = align;
    }
}

function updateLabelText() {
    if (selIdx < 0 || !elems[selIdx]) return;
    var text = document.getElementById('propLabelText').value;
    elems[selIdx].el.innerText = text;
    elems[selIdx].label = text;
    refreshLayers();
}

// ── Delete element ────────────────────────────────
function deleteElem() {
    if (selIdx < 0) return;
    elems[selIdx].el.remove();
    elems.splice(selIdx, 1);
    elems.forEach(function(e, i) { e.el.dataset.idx = i; });
    selIdx = -1;
    document.getElementById('propCard').style.display = 'none';
    refreshLayers();
}

// ── Drag ──────────────────────────────────────────
function makeDrag(div) {
    div.addEventListener('mousedown', function(e) {
        if (e.button !== 0) return;
        e.preventDefault();
        var canvas = document.getElementById('certCanvas');
        var cr = canvas.getBoundingClientRect();
        var sx = e.clientX, sy = e.clientY;
        var sl = parseFloat(div.style.left) || 0;
        var st = parseFloat(div.style.top)  || 0;
        var idx = parseInt(div.dataset.idx);

        function mv(e) {
            var nx = Math.max(0, Math.min(95, sl + (e.clientX - sx) / cr.width  * 100));
            var ny = Math.max(0, Math.min(95, st + (e.clientY - sy) / cr.height * 100));
            div.style.left = nx + '%';
            div.style.top  = ny + '%';
            if (elems[idx]) { elems[idx].x = nx; elems[idx].y = ny; }
        }
        function up() {
            document.removeEventListener('mousemove', mv);
            document.removeEventListener('mouseup', up);
        }
        document.addEventListener('mousemove', mv);
        document.addEventListener('mouseup', up);
    });
}

// ── Layers panel ──────────────────────────────────
function refreshLayers() {
    var list = document.getElementById('layerList');
    list.innerHTML = '';
    elems.forEach(function(e, i) {
        var item = document.createElement('div');
        item.className = 'layer-item' + (i === selIdx ? ' active' : '');
        var icon = e.kind === 'image' ? 'fa-image' : 'fa-font';
        var name = e.kind === 'image' ? 'Image' : (e.label || e.type);
        item.innerHTML = '<span onclick="selectElem(' + i + ')"><i class="fas ' + icon + ' me-1"></i>' + name.substring(0, 20) + '</span>'
                       + '<button class="del-layer" onclick="deleteByIdx(' + i + ')"><i class="fas fa-times"></i></button>';
        list.appendChild(item);
    });
}

function deleteByIdx(idx) {
    elems[idx].el.remove();
    elems.splice(idx, 1);
    elems.forEach(function(e, i) { e.el.dataset.idx = i; });
    if (selIdx === idx) {
        selIdx = -1;
        document.getElementById('propCard').style.display = 'none';
    } else if (selIdx > idx) selIdx--;
    refreshLayers();
}

// ── Click outside deselects ───────────────────────
document.addEventListener('click', function(e) {
    if (!e.target.closest('.cert-el') && !e.target.closest('#propCard')) selectElem(-1);
});

// ── Prepare save ──────────────────────────────────
function prepSave() {
    var layout = elems.map(function(e) {
        if (e.kind === 'image') return { kind:'image', src:e.src, x:e.x, y:e.y, w:e.w };
        return { kind:'text', type:e.type, label:e.label, x:e.x, y:e.y, fs:e.fs, color:e.color, fw:e.fw, fi:e.fi, align:e.align };
    });
    document.getElementById('layoutData').value = JSON.stringify(layout);
}
</script>
@endpush


