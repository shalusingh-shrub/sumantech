{{-- File: resources/views/frontend/award_show.blade.php --}}
@extends('layouts.frontend')
@section('title', $award->title . ' - Suman Tech')
@push('styles')
<style>
.participant-card{border-radius:10px;overflow:hidden;transition:transform 0.2s;}
.participant-card:hover{transform:translateY(-3px);}
.participant-card img{width:100%;height:200px;object-fit:cover;}
.month-badge{color:#dc3545;font-weight:700;font-size:16px;}
.category-badge{color:#dc3545;font-weight:600;font-size:13px;}
.participant-name{font-weight:700;font-size:18px;}
.award-title-main{color:#dc3545;font-weight:700;text-align:center;}
.dl-btn{background:#007bff;color:#fff;border:none;padding:10px 20px;border-radius:6px;width:100%;font-weight:600;cursor:pointer;font-size:14px;}
.dl-btn:hover{background:#0056b3;}
.dl-btn:disabled{background:#6c757d;cursor:not-allowed;}
#certCanvas{position:fixed;left:-9999px;top:-9999px;}
</style>
@endpush
@php $layout = $award->cert_layout ? json_decode($award->cert_layout, true) : []; @endphp
@section('content')
<div class="container py-4">
<nav><ol class="breadcrumb">
<li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('award') }}">Award</a></li>
<li class="breadcrumb-item active">{{ $award->title }}</li>
</ol></nav>
</div>
<div class="container pb-5">
<h2 class="award-title-main mb-2">{{ $award->title }}</h2>
@if($award->description)
<p class="text-center text-muted mb-4">{{ strip_tags($award->description) }}</p>
@endif
@if($participants->count() > 0)
<div class="row g-4 mt-2">
@foreach($participants as $p)
<div class="col-md-3 col-sm-6">
<div class="card border-0 shadow-sm participant-card">
@if($p->photo)
<img src="{{ $p->photo_url }}" alt="{{ $p->name }}" onerror="this.onerror=null;this.style.opacity='0.3'">
@else
<div style="height:200px;background:#f8f9fa;display:flex;align-items:center;justify-content:center;"><i class="fas fa-user fa-3x text-muted"></i></div>
@endif
<div class="card-body p-3">
@if($p->month)<div class="month-badge mb-1">{{ $p->month }}</div>@endif
@if($p->category)<div class="category-badge mb-1">{{ $p->category }}</div>@endif
<div class="participant-name">{{ $p->name }}</div>
@if($p->class)<div class="text-muted" style="font-size:14px;">{{ $p->class }}</div>@endif
@if($p->school)<div class="text-muted" style="font-size:13px;">{{ $p->school }}</div>@endif
@if($p->district)<div class="text-muted" style="font-size:13px;">{{ $p->district }}</div>@endif
@if($award->has_certificate && $award->certificate_template)
<button class="dl-btn mt-3" data-name="{{ $p->name }}" data-cert="{{ $p->cert_number ?? '' }}" data-month="{{ $p->month ?? '' }}" data-category="{{ $p->category ?? '' }}" onclick="downloadCert(this)">
<i class="fas fa-download me-1"></i> Download Certificate
</button>
@endif
</div>
</div>
</div>
@endforeach
</div>
@if($participants->hasPages())
<div class="mt-4 d-flex justify-content-center">{{ $participants->links() }}</div>
@endif
@else
<div class="text-center py-5 text-muted"><i class="fas fa-users fa-3x mb-3"></i><p>No participants listed yet.</p></div>
@endif
</div>
<div id="certCanvas"></div>
@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
var CL=@json($layout);
var CB="{{ $award->certificate_url ?? '' }}";
var AT=@json($award->title);
function downloadCert(btn){
var name=btn.getAttribute('data-name');
var certNo=btn.getAttribute('data-cert');
var category=btn.getAttribute('data-category');
btn.disabled=true;btn.innerHTML='<i class="fas fa-spinner fa-spin me-1"></i> Generating...';
var today=new Date().toLocaleDateString('en-IN',{day:'2-digit',month:'long',year:'numeric'})
        .catch(error => {
            console.error(error);
        });
var cn=certNo||('CERT-'+new Date().getFullYear()+'-'+String(Math.floor(Math.random()*9999)+1).padStart(4,'0'));
var v={name:name,cert_number:cn,date:today,date2:today,award_title:AT,category:category||'',label:''};
var canvas=document.getElementById('certCanvas');
canvas.innerHTML='';
var wrap=document.createElement('div');
wrap.style.cssText='position:relative;display:inline-block;width:800px;';
var bg=new Image();
bg.crossOrigin='anonymous';
bg.style.cssText='width:800px;display:block;';
bg.onload=function(){
if(CL&&CL.length>0){CL.forEach(function(el){var d=document.createElement('div');d.style.cssText='position:absolute;white-space:nowrap;line-height:1.2;left:'+(el.x||0)+'%;top:'+(el.y||0)+'%;';if(el.kind==='image'){var i=document.createElement('img');i.src=el.src;i.style.cssText='width:'+(el.w||80)+'px;display:block;';d.appendChild(i);}else{var t=(el.type==='label')?(el.label||''):(v[el.type]||'');d.innerText=t;d.style.fontSize=(el.fs||24)+'px';d.style.color=el.color||'#1a2a6c';d.style.fontWeight=el.fw||'700';d.style.fontStyle=el.fi||'normal';d.style.textAlign=el.align||'center';}wrap.appendChild(d);})
        .catch(error => {
            console.error(error);
        });}
canvas.appendChild(wrap);
setTimeout(function(){html2canvas(wrap,{scale:2,useCORS:true,allowTaint:true,logging:false,backgroundColor:'#ffffff',width:800}).then(function(c){var a=document.createElement('a');a.download='certificate-'+name.replace(/\s+/g,'-')+'.png';a.href=c.toDataURL('image/png');document.body.appendChild(a);a.click();document.body.removeChild(a);btn.disabled=false;btn.innerHTML='<i class="fas fa-download me-1"></i> Download Certificate';canvas.innerHTML='';}).catch(function(){btn.disabled=false;btn.innerHTML='<i class="fas fa-download me-1"></i> Download Certificate';})
        .catch(error => {
            console.error(error);
        });},500);};
bg.onerror=function(){btn.disabled=false;btn.innerHTML='<i class="fas fa-download me-1"></i> Download Certificate';alert('Certificate image load nahi ho rahi. Admin se check karwao.');};
wrap.appendChild(bg);bg.src=CB;}
</script>
@endpush





