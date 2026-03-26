

<?php $__env->startSection('title', $award->title . ' - Teachers of Bihar'); ?>
<?php $__env->startPush('styles'); ?>
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
<?php $__env->stopPush(); ?>
<?php $layout = $award->cert_layout ? json_decode($award->cert_layout, true) : []; ?>
<?php $__env->startSection('content'); ?>
<div class="container py-4">
<nav><ol class="breadcrumb">
<li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Home</a></li>
<li class="breadcrumb-item"><a href="<?php echo e(route('award')); ?>">Award</a></li>
<li class="breadcrumb-item active"><?php echo e($award->title); ?></li>
</ol></nav>
</div>
<div class="container pb-5">
<h2 class="award-title-main mb-2"><?php echo e($award->title); ?></h2>
<?php if($award->description): ?>
<p class="text-center text-muted mb-4"><?php echo e(strip_tags($award->description)); ?></p>
<?php endif; ?>
<?php if($participants->count() > 0): ?>
<div class="row g-4 mt-2">
<?php $__currentLoopData = $participants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="col-md-3 col-sm-6">
<div class="card border-0 shadow-sm participant-card">
<?php if($p->photo): ?>
<img src="<?php echo e($p->photo_url); ?>" alt="<?php echo e($p->name); ?>" onerror="this.onerror=null;this.style.opacity='0.3'">
<?php else: ?>
<div style="height:200px;background:#f8f9fa;display:flex;align-items:center;justify-content:center;"><i class="fas fa-user fa-3x text-muted"></i></div>
<?php endif; ?>
<div class="card-body p-3">
<?php if($p->month): ?><div class="month-badge mb-1"><?php echo e($p->month); ?></div><?php endif; ?>
<?php if($p->category): ?><div class="category-badge mb-1"><?php echo e($p->category); ?></div><?php endif; ?>
<div class="participant-name"><?php echo e($p->name); ?></div>
<?php if($p->class): ?><div class="text-muted" style="font-size:14px;"><?php echo e($p->class); ?></div><?php endif; ?>
<?php if($p->school): ?><div class="text-muted" style="font-size:13px;"><?php echo e($p->school); ?></div><?php endif; ?>
<?php if($p->district): ?><div class="text-muted" style="font-size:13px;"><?php echo e($p->district); ?></div><?php endif; ?>
<?php if($award->has_certificate && $award->certificate_template): ?>
<button class="dl-btn mt-3" data-name="<?php echo e($p->name); ?>" data-cert="<?php echo e($p->cert_number ?? ''); ?>" data-month="<?php echo e($p->month ?? ''); ?>" data-category="<?php echo e($p->category ?? ''); ?>" onclick="downloadCert(this)">
<i class="fas fa-download me-1"></i> Download Certificate
</button>
<?php endif; ?>
</div>
</div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php if($participants->hasPages()): ?>
<div class="mt-4 d-flex justify-content-center"><?php echo e($participants->links()); ?></div>
<?php endif; ?>
<?php else: ?>
<div class="text-center py-5 text-muted"><i class="fas fa-users fa-3x mb-3"></i><p>No participants listed yet.</p></div>
<?php endif; ?>
</div>
<div id="certCanvas"></div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
var CL=<?php echo json_encode($layout, 15, 512) ?>;
var CB="<?php echo e($award->certificate_url ?? ''); ?>";
var AT=<?php echo json_encode($award->title, 15, 512) ?>;
function downloadCert(btn){
var name=btn.getAttribute('data-name');
var certNo=btn.getAttribute('data-cert');
var category=btn.getAttribute('data-category');
btn.disabled=true;btn.innerHTML='<i class="fas fa-spinner fa-spin me-1"></i> Generating...';
var today=new Date().toLocaleDateString('en-IN',{day:'2-digit',month:'long',year:'numeric'});
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
if(CL&&CL.length>0){CL.forEach(function(el){var d=document.createElement('div');d.style.cssText='position:absolute;white-space:nowrap;line-height:1.2;left:'+(el.x||0)+'%;top:'+(el.y||0)+'%;';if(el.kind==='image'){var i=document.createElement('img');i.src=el.src;i.style.cssText='width:'+(el.w||80)+'px;display:block;';d.appendChild(i);}else{var t=(el.type==='label')?(el.label||''):(v[el.type]||'');d.innerText=t;d.style.fontSize=(el.fs||24)+'px';d.style.color=el.color||'#1a2a6c';d.style.fontWeight=el.fw||'700';d.style.fontStyle=el.fi||'normal';d.style.textAlign=el.align||'center';}wrap.appendChild(d);});}
canvas.appendChild(wrap);
setTimeout(function(){html2canvas(wrap,{scale:2,useCORS:true,allowTaint:true,logging:false,backgroundColor:'#ffffff',width:800}).then(function(c){var a=document.createElement('a');a.download='certificate-'+name.replace(/\s+/g,'-')+'.png';a.href=c.toDataURL('image/png');document.body.appendChild(a);a.click();document.body.removeChild(a);btn.disabled=false;btn.innerHTML='<i class="fas fa-download me-1"></i> Download Certificate';canvas.innerHTML='';}).catch(function(){btn.disabled=false;btn.innerHTML='<i class="fas fa-download me-1"></i> Download Certificate';});},500);};
bg.onerror=function(){btn.disabled=false;btn.innerHTML='<i class="fas fa-download me-1"></i> Download Certificate';alert('Certificate image load nahi ho rahi. Admin se check karwao.');};
wrap.appendChild(bg);bg.src=CB;}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ROHIT RAJ\Herd\tob\resources\views/frontend/award_show.blade.php ENDPATH**/ ?>