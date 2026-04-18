@extends('layouts.admin')
@section('title', 'Certificate Builder')

@push('styles')
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }

.builder-layout {
    display: flex;
    height: calc(100vh - 100px);
    gap: 0;
    border: 1px solid #dee2e6;
    border-radius: 10px;
    overflow: hidden;
    background: #fff;
}

/* LEFT PANEL */
.left-panel {
    width: 260px;
    min-width: 260px;
    background: #fff;
    border-right: 1px solid #dee2e6;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
}
.panel-section {
    padding: 12px;
    border-bottom: 1px solid #f0f0f0;
}
.panel-title {
    font-size: .72rem;
    font-weight: 800;
    letter-spacing: .1em;
    text-transform: uppercase;
    color: #1a2a6c;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 6px;
}
.el-btn {
    width: 100%;
    text-align: left;
    background: #f8f9fa;
    border: 1.5px solid #e9ecef;
    border-radius: 8px;
    padding: 8px 12px;
    font-size: .82rem;
    cursor: pointer;
    margin-bottom: 5px;
    display: flex;
    align-items: center;
    gap: 8px;
    color: #333;
    transition: all .18s;
}
.el-btn:hover { background: #e8f0fe; border-color: #1a2a6c; color: #1a2a6c; }

.prop-label { font-size: .73rem; font-weight: 600; color: #555; margin-bottom: 3px; display: block; }
.prop-input { width: 100%; padding: 5px 8px; border: 1px solid #dee2e6; border-radius: 6px; font-size: .82rem; margin-bottom: 8px; }
.prop-range { width: 100%; margin-bottom: 8px; }
.color-swatches { display: flex; gap: 5px; flex-wrap: wrap; margin-bottom: 8px; }
.swatch {
    width: 24px; height: 24px; border-radius: 5px; cursor: pointer;
    border: 2px solid transparent; transition: border .15s;
}
.swatch.active, .swatch:hover { border-color: #333; }
.btn-del { width: 100%; background: #dc3545; color: #fff; border: none; border-radius: 7px; padding: 8px; font-size: .82rem; cursor: pointer; margin-top: 4px; }
.btn-del:hover { background: #c82333; }

/* RIGHT PANEL */
.right-panel {
    flex: 1;
    display: flex;
    flex-direction: column;
    background: #f0f2f5;
    overflow: hidden;
}
.canvas-header {
    background: #fff;
    border-bottom: 1px solid #dee2e6;
    padding: 8px 16px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 8px;
}
.canvas-scroll {
    flex: 1;
    overflow: auto;
    padding: 20px;
    display: flex;
    align-items: flex-start;
    justify-content: center;
}

/* CERTIFICATE */
#certCanvas {
    position: relative;
    width: 800px;
    height: 560px;
    flex-shrink: 0;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0,0,0,.3);
    background: linear-gradient(135deg, #0B1F3A 0%, #1a3a6c 100%);
}
.cert-border1 {
    position: absolute; inset: 8px;
    border: 4px solid #F0A500;
    border-radius: 8px;
    pointer-events: none; z-index: 2;
}
.cert-border2 {
    position: absolute; inset: 16px;
    border: 1px solid rgba(240,165,0,.3);
    border-radius: 5px;
    pointer-events: none; z-index: 2;
}
.cert-deco {
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 60px;
    background: rgba(240,165,0,.08);
    border-top: 1px solid rgba(240,165,0,.2);
    pointer-events: none; z-index: 1;
}

/* DRAGGABLE ELEMENTS */
.cert-el {
    position: absolute;
    cursor: move;
    user-select: none;
    z-index: 10;
    padding: 3px 5px;
    border: 2px dashed transparent;
    border-radius: 4px;
    transition: border-color .15s;
    white-space: nowrap;
    line-height: 1.2;
}
.cert-el:hover { border-color: rgba(100,149,237,.6); }
.cert-el.selected { border-color: #4285f4 !important; }
.resize-h {
    position: absolute; bottom: -5px; right: -5px;
    width: 10px; height: 10px;
    background: #4285f4; border-radius: 50%;
    cursor: se-resize; display: none; z-index: 20;
}
.cert-el.selected .resize-h { display: block; }

.bg-swatches { display: flex; gap: 6px; flex-wrap: wrap; }
.bg-sw {
    width: 36px; height: 24px; border-radius: 5px; cursor: pointer;
    border: 2px solid transparent;
}
.bg-sw:hover, .bg-sw.active { border-color: #1a2a6c; }
</style>
@endpush

@section('content')
<div style="padding:12px 16px;">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0 fw-bold" style="color:#1a2a6c;">
                <i class="fas fa-certificate me-2" style="color:#F0A500;"></i>Certificate Builder
            </h4>
            <small class="text-muted">{{ $student->name }} — {{ $course->course_name }}</small>
        </div>
        <a href="{{ route('admin.registration.edit-course', [$student, $course]) }}"
           class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i>Back
        </a>
    </div>

    <div class="builder-layout">

        <!-- LEFT PANEL -->
        <div class="left-panel">

            <div class="panel-section">
                <div class="panel-title"><i class="fas fa-plus-circle" style="color:#F0A500;"></i> Elements</div>
                <button class="el-btn" onclick="addEl('name')"><i class="fas fa-user" style="color:#1a2a6c;width:16px;"></i> Participant Name</button>
                <button class="el-btn" onclick="addEl('certno')"><i class="fas fa-hashtag" style="color:#F0A500;width:16px;"></i> Certificate Number</button>
                <button class="el-btn" onclick="addEl('date1')"><i class="fas fa-calendar" style="color:#28a745;width:16px;"></i> Date (Auto)</button>
                <button class="el-btn" onclick="addEl('course')"><i class="fas fa-book" style="color:#dc3545;width:16px;"></i> Course Name</button>
                <button class="el-btn" onclick="addEl('duration')"><i class="fas fa-clock" style="color:#6f42c1;width:16px;"></i> Duration</button>
                <button class="el-btn" onclick="addEl('marks')"><i class="fas fa-star" style="color:#ffc107;width:16px;"></i> Marks</button>
                <button class="el-btn" onclick="addEl('father')"><i class="fas fa-user-friends" style="color:#17a2b8;width:16px;"></i> Father's Name</button>
                <button class="el-btn" onclick="addEl('institute')"><i class="fas fa-university" style="color:#1a2a6c;width:16px;"></i> Institute Name</button>
                <button class="el-btn" onclick="addEl('custom')"><i class="fas fa-font" style="color:#6c757d;width:16px;"></i> Custom Label</button>
                <button class="el-btn" onclick="addEl('sign')"><i class="fas fa-signature" style="color:#333;width:16px;"></i> Authorised Signature</button>
                <button class="el-btn" onclick="document.getElementById('imgUp').click()"><i class="fas fa-image" style="color:#28a745;width:16px;"></i> Image Add Karo</button>
                <input type="file" id="imgUp" accept="image/*" style="display:none;" onchange="addImgEl(this)">
            </div>

            <div class="panel-section">
                <div class="panel-title"><i class="fas fa-fill-drip" style="color:#6f42c1;"></i> Background</div>
                <div class="bg-swatches mb-2">
                    <div class="bg-sw active" style="background:linear-gradient(135deg,#0B1F3A,#1a3a6c);" onclick="setBg(this,'linear-gradient(135deg,#0B1F3A,#1a3a6c)')"></div>
                    <div class="bg-sw" style="background:linear-gradient(135deg,#0d3320,#1a6c3a);" onclick="setBg(this,'linear-gradient(135deg,#0d3320,#1a6c3a)')"></div>
                    <div class="bg-sw" style="background:linear-gradient(135deg,#3d0000,#9c2626);" onclick="setBg(this,'linear-gradient(135deg,#3d0000,#9c2626)')"></div>
                    <div class="bg-sw" style="background:linear-gradient(135deg,#1a006b,#6b1a6b);" onclick="setBg(this,'linear-gradient(135deg,#1a006b,#6b1a6b)')"></div>
                    <div class="bg-sw" style="background:#fff;border:1px solid #ccc;" onclick="setBg(this,'#fff')"></div>
                    <div class="bg-sw" style="background:linear-gradient(135deg,#f5f0e8,#e8d9c0);" onclick="setBg(this,'linear-gradient(135deg,#f5f0e8,#e8d9c0)')"></div>
                </div>
                <span class="prop-label">BG Image Upload:</span>
                <input type="file" accept="image/*" class="prop-input" style="font-size:.76rem;" onchange="setBgImg(this)">
            </div>

            <div class="panel-section" id="propsPanel" style="display:none;">
                <div class="panel-title"><i class="fas fa-sliders-h" style="color:#1a2a6c;"></i> Properties</div>

                <span class="prop-label">Text Edit:</span>
                <input type="text" class="prop-input" id="pText" oninput="upd('text',this.value)">

                <span class="prop-label">Font Size: <b id="pSzVal">20</b>px</span>
                <input type="range" class="prop-range" id="pSz" min="8" max="80" value="20"
                       oninput="pSzVal.textContent=this.value;upd('size',this.value)">

                <span class="prop-label">Font Weight:</span>
                <select class="prop-input" id="pWt" onchange="upd('weight',this.value)">
                    <option value="normal">Normal</option>
                    <option value="600">Semi Bold</option>
                    <option value="bold">Bold</option>
                    <option value="900">Black</option>
                </select>

                <span class="prop-label">Font Style:</span>
                <select class="prop-input" id="pFont" onchange="upd('font',this.value)">
                    <option value="Georgia,serif">Georgia (Classic)</option>
                    <option value="'Times New Roman',serif">Times New Roman</option>
                    <option value="Arial,sans-serif">Arial</option>
                    <option value="Verdana,sans-serif">Verdana</option>
                    <option value="'Courier New',monospace">Courier New</option>
                </select>

                <span class="prop-label">Color:</span>
                <div class="color-swatches">
                    <div class="swatch active" style="background:#FFD166;" onclick="upd('color','#FFD166');setAC(this)"></div>
                    <div class="swatch" style="background:#ffffff;" onclick="upd('color','#ffffff');setAC(this)"></div>
                    <div class="swatch" style="background:#F0A500;" onclick="upd('color','#F0A500');setAC(this)"></div>
                    <div class="swatch" style="background:#1a2a6c;" onclick="upd('color','#1a2a6c');setAC(this)"></div>
                    <div class="swatch" style="background:#28a745;" onclick="upd('color','#28a745');setAC(this)"></div>
                    <div class="swatch" style="background:#dc3545;" onclick="upd('color','#dc3545');setAC(this)"></div>
                    <div class="swatch" style="background:#333;" onclick="upd('color','#333');setAC(this)"></div>
                    <input type="color" value="#FFD166" title="Custom color"
                           style="width:24px;height:24px;border:none;padding:0;cursor:pointer;border-radius:5px;"
                           oninput="upd('color',this.value)">
                </div>

                <span class="prop-label">Text Align:</span>
                <div class="d-flex gap-2 mb-2">
                    <button onclick="upd('align','left')"   style="flex:1;padding:4px;font-size:.78rem;border:1px solid #dee2e6;border-radius:5px;cursor:pointer;">Left</button>
                    <button onclick="upd('align','center')" style="flex:1;padding:4px;font-size:.78rem;border:1px solid #dee2e6;border-radius:5px;cursor:pointer;">Center</button>
                    <button onclick="upd('align','right')"  style="flex:1;padding:4px;font-size:.78rem;border:1px solid #dee2e6;border-radius:5px;cursor:pointer;">Right</button>
                </div>

                <span class="prop-label">Width: <b id="pWVal">auto</b></span>
                <input type="range" class="prop-range" id="pW" min="50" max="800" value="300"
                       oninput="pWVal.textContent=this.value+'px';upd('width',this.value)">

                <button class="btn-del" onclick="delSel()"><i class="fas fa-trash me-1"></i>Delete Element</button>
            </div>

        </div>

        <!-- RIGHT PANEL -->
        <div class="right-panel">
            <div class="canvas-header">
                <div style="font-size:.88rem;font-weight:700;color:#1a2a6c;">
                    <i class="fas fa-image me-1"></i> Certificate Preview
                    <small class="text-muted fw-normal ms-2" style="font-size:.75rem;">Click element to select, drag to move</small>
                </div>
                <div class="d-flex gap-2 flex-wrap">
                    <button onclick="downloadPNG()" class="btn btn-sm btn-primary">
                        <i class="fas fa-download me-1"></i>Download Certificate
                    </button>
                    <button onclick="downloadPDF()" class="btn btn-sm btn-danger">
                        <i class="fas fa-file-pdf me-1"></i>Download PDF
                    </button>
                </div>
            </div>

            <div class="canvas-scroll">
                <div id="certCanvas">
                    <div class="cert-border1"></div>
                    <div class="cert-border2"></div>
                    <div class="cert-deco"></div>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<script>
const SD = {
    name:     "{{ addslashes($student->name) }}",
    father:   "{{ addslashes($student->father_name) }}",
    certId:   "{{ $course->certificate_id ?? 'ST-XXXXXXXXXX' }}",
    course:   "{{ addslashes($course->course_name) }}",
    duration: "{{ $course->course_duration ?? 'N/A' }}",
    marks:    "{{ $course->marks ?? 'N/A' }}",
    date:     "{{ $course->certificate_issue_date ? \Carbon\Carbon::parse($course->certificate_issue_date)->format('d M Y') : date('d M Y') }}",
};

const cv   = document.getElementById('certCanvas');
let sel    = null;
let elIdx  = 0;
let dragOX = 0, dragOY = 0;

function addEl(type) {
    const el = document.createElement('div');
    el.className = 'cert-el';
    el.id = 'e' + (++elIdx);
    el.dataset.type = type;

    let txt = '', css = 'color:#FFD166;font-family:Georgia,serif;font-weight:bold;';
    switch(type) {
        case 'name':      txt = SD.name.toUpperCase(); css += 'font-size:28px;'; break;
        case 'certno':    txt = SD.certId; css += 'font-size:13px;color:rgba(255,255,255,.75);'; break;
        case 'date1':     txt = SD.date; css += 'font-size:13px;color:rgba(255,255,255,.75);'; break;
        case 'course':    txt = SD.course; css += 'font-size:20px;color:#F0A500;'; break;
        case 'duration':  txt = 'Duration: ' + SD.duration; css += 'font-size:13px;color:rgba(255,255,255,.7);'; break;
        case 'marks':     txt = 'Marks: ' + SD.marks; css += 'font-size:13px;color:rgba(255,255,255,.7);'; break;
        case 'father':    txt = 'S/O, D/O: ' + SD.father; css += 'font-size:13px;color:rgba(255,255,255,.75);'; break;
        case 'institute': txt = 'SUMAN TECH'; css += 'font-size:26px;'; break;
        case 'sign':      txt = 'Authorised Signature'; css += 'font-size:12px;color:rgba(255,255,255,.5);'; break;
        case 'custom':    txt = 'Custom Text — Edit karo'; css += 'font-size:16px;'; break;
    }

    el.setAttribute('style', css + 'left:80px;top:' + (40 + elIdx * 28) + 'px;position:absolute;');
    el.dataset.text = txt;
    el.textContent = txt;

    const rh = document.createElement('div');
    rh.className = 'resize-h';
    el.appendChild(rh);

    makeDraggable(el);
    cv.appendChild(el);
    selectEl(el);
}

function addImgEl(input) {
    if (!input.files[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
        const el = document.createElement('div');
        el.className = 'cert-el';
        el.id = 'e' + (++elIdx);
        el.dataset.type = 'img';
        el.style.cssText = 'position:absolute;left:80px;top:80px;width:120px;height:90px;';
        el.innerHTML = '<img src="' + e.target.result + '" style="width:100%;height:100%;object-fit:contain;">';
        const rh = document.createElement('div'); rh.className = 'resize-h'; el.appendChild(rh);
        makeDraggable(el);
        cv.appendChild(el);
        selectEl(el);
    };
    reader.readAsDataURL(input.files[0]);
}

function makeDraggable(el) {
    el.addEventListener('mousedown', e => {
        if (e.target.classList.contains('resize-h')) return;
        e.preventDefault();
        selectEl(el);
        const cr = cv.getBoundingClientRect();
        const er = el.getBoundingClientRect();
        dragOX = e.clientX - er.left;
        dragOY = e.clientY - er.top;
        let moving = true;

        const mm = e2 => {
            if (!moving) return;
            const r = cv.getBoundingClientRect();
            let x = e2.clientX - r.left - dragOX;
            let y = e2.clientY - r.top  - dragOY;
            x = Math.max(0, Math.min(x, cv.offsetWidth  - el.offsetWidth));
            y = Math.max(0, Math.min(y, cv.offsetHeight - el.offsetHeight));
            el.style.left = x + 'px';
            el.style.top  = y + 'px';
        };
        const mu = () => { moving = false; document.removeEventListener('mousemove', mm); document.removeEventListener('mouseup', mu); };
        document.addEventListener('mousemove', mm);
        document.addEventListener('mouseup',   mu);
    })
        .catch(error => {
            console.error(error);
        });
    el.addEventListener('click', e => { e.stopPropagation(); selectEl(el); })
        .catch(error => {
            console.error(error);
        });
}

function selectEl(el) {
    if (sel) sel.classList.remove('selected');
    sel = el;
    el.classList.add('selected');
    document.getElementById('propsPanel').style.display = 'block';

    const txt = el.dataset.type !== 'img' ? (el.childNodes[0]?.textContent || '') : '';
    document.getElementById('pText').value   = txt;
    document.getElementById('pSz').value     = parseInt(el.style.fontSize) || 16;
    document.getElementById('pSzVal').textContent = parseInt(el.style.fontSize) || 16;
    document.getElementById('pWt').value     = el.style.fontWeight || 'normal';
    document.getElementById('pW').value      = parseInt(el.style.width) || 300;
    document.getElementById('pWVal').textContent = el.style.width || 'auto';
}

function upd(prop, val) {
    if (!sel) return;
    if (prop === 'text' && sel.dataset.type !== 'img') {
        sel.childNodes[0].textContent = val;
    } else if (prop === 'size')   sel.style.fontSize   = val + 'px';
    else if (prop === 'weight')   sel.style.fontWeight = val;
    else if (prop === 'font')     sel.style.fontFamily = val;
    else if (prop === 'color')    sel.style.color      = val;
    else if (prop === 'align')    sel.style.textAlign  = val;
    else if (prop === 'width')    sel.style.width      = val + 'px';
}

function delSel() {
    if (!sel) return;
    sel.remove(); sel = null;
    document.getElementById('propsPanel').style.display = 'none';
}

function setAC(el) {
    document.querySelectorAll('.swatch').forEach(s => s.classList.remove('active'));
    el.classList.add('active');
}

function setBg(el, bg) {
    cv.style.background = bg;
    cv.style.backgroundImage = '';
    document.querySelectorAll('.bg-sw').forEach(s => s.classList.remove('active'));
    el.classList.add('active');
}

function setBgImg(input) {
    if (!input.files[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
        cv.style.backgroundImage = 'url(' + e.target.result + ')';
        cv.style.backgroundSize  = 'cover';
        cv.style.backgroundPosition = 'center';
    };
    reader.readAsDataURL(input.files[0]);
}

cv.addEventListener('click', e => {
    if (e.target === cv || e.target.classList.contains('cert-border1') || e.target.classList.contains('cert-border2') || e.target.classList.contains('cert-deco')) {
        if (sel) sel.classList.remove('selected');
        sel = null;
        document.getElementById('propsPanel').style.display = 'none';
    }
})
        .catch(error => {
            console.error(error);
        });

async function downloadPNG() {
    if (sel) sel.classList.remove('selected');
    document.querySelectorAll('.resize-h').forEach(r => r.style.display = 'none');
    const c2 = await html2canvas(cv, { scale: 2, useCORS: true, backgroundColor: null })
        .catch(error => {
            console.error(error);
        });
    const a = document.createElement('a');
    a.download = 'Certificate_' + SD.certId + '.png';
    a.href = c2.toDataURL('image/png');
    a.click();
    document.querySelectorAll('.resize-h').forEach(r => r.style.display = '');
    if (sel) sel.classList.add('selected');
}

async function downloadPDF() {
    if (sel) sel.classList.remove('selected');
    document.querySelectorAll('.resize-h').forEach(r => r.style.display = 'none');
    const c2 = await html2canvas(cv, { scale: 2, useCORS: true, backgroundColor: null })
        .catch(error => {
            console.error(error);
        });
    const img = c2.toDataURL('image/png');
    const { jsPDF } = window.jspdf;
    const pdf = new jsPDF({ orientation: 'landscape', unit: 'px', format: [cv.offsetWidth, cv.offsetHeight] })
        .catch(error => {
            console.error(error);
        });
    pdf.addImage(img, 'PNG', 0, 0, cv.offsetWidth, cv.offsetHeight);
    pdf.save('Certificate_' + SD.certId + '.pdf');
    document.querySelectorAll('.resize-h').forEach(r => r.style.display = '');
    if (sel) sel.classList.add('selected');
}

// Default certificate load
window.addEventListener('load', () => {
    const defaults = [
        { type:'i', txt:'SUMAN TECH',                         css:'color:#FFD166;font-size:26px;font-weight:900;font-family:Georgia,serif;left:270px;top:38px;' },
        { type:'i', txt:'Making You Future Ready | Muzaffarpur, Bihar', css:'color:rgba(255,255,255,.6);font-size:11px;font-family:Arial,sans-serif;left:265px;top:72px;' },
        { type:'i', txt:'CERTIFICATE OF COMPLETION',          css:'color:#F0A500;font-size:18px;font-weight:900;font-family:Georgia,serif;letter-spacing:2px;left:240px;top:108px;' },
        { type:'i', txt:'This is to certify that',            css:'color:rgba(255,255,255,.8);font-size:13px;font-family:Georgia,serif;left:320px;top:152px;' },
        { type:'i', txt:SD.name.toUpperCase(),                css:'color:#FFD166;font-size:30px;font-weight:900;font-family:Georgia,serif;left:240px;top:172px;' },
        { type:'i', txt:'S/O, D/O: ' + SD.father,            css:'color:rgba(255,255,255,.75);font-size:13px;font-family:Arial,sans-serif;left:300px;top:216px;' },
        { type:'i', txt:'has successfully completed the course', css:'color:rgba(255,255,255,.75);font-size:12px;font-family:Arial,sans-serif;left:286px;top:240px;' },
        { type:'i', txt:SD.course,                            css:'color:#F0A500;font-size:20px;font-weight:bold;font-family:Georgia,serif;left:250px;top:264px;' },
        { type:'i', txt:'Duration: ' + SD.duration + '  |  Marks: ' + SD.marks, css:'color:rgba(255,255,255,.7);font-size:12px;font-family:Arial,sans-serif;left:290px;top:302px;' },
        { type:'i', txt:'Certificate No: ' + SD.certId,      css:'color:rgba(255,255,255,.7);font-size:12px;font-family:Arial,sans-serif;left:300px;top:322px;' },
        { type:'i', txt:'Issue Date: ' + SD.date,            css:'color:rgba(255,255,255,.7);font-size:12px;font-family:Arial,sans-serif;left:314px;top:342px;' },
        { type:'i', txt:'Authorised Signature',               css:'color:rgba(255,255,255,.45);font-size:11px;font-family:Arial,sans-serif;left:330px;top:420px;' },
    ];

    defaults.forEach(d => {
        const el = document.createElement('div');
        el.className = 'cert-el';
        el.id = 'e' + (++elIdx);
        el.dataset.type = d.type;
        el.textContent = d.txt;
        el.style.cssText = 'position:absolute;' + d.css;
        const rh = document.createElement('div'); rh.className = 'resize-h'; el.appendChild(rh);
        makeDraggable(el);
        cv.appendChild(el);
    })
        .catch(error => {
            console.error(error);
        });
})
        .catch(error => {
            console.error(error);
        });
</script>
@endsection



