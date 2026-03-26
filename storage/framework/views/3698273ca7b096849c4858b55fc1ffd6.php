

<?php $__env->startSection('page-title', 'Award Participants'); ?>
<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-0"><i class="fas fa-users me-2 text-warning"></i>Participants</h5>
        <small class="text-muted"><?php echo e($award->title); ?></small>
    </div>
    <div class="d-flex gap-2">
        <a href="<?php echo e(route('admin.awards.certificateBuilder', $award)); ?>" class="btn btn-warning btn-sm">
            <i class="fas fa-certificate me-1"></i>Certificate Builder
        </a>
        <a href="<?php echo e(route('admin.awards.edit', $award)); ?>" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Back</a>
    </div>
</div>

<?php if(session('success')): ?><div class="alert alert-success alert-dismissible"><button type="button" class="btn-close" data-bs-dismiss="alert"></button><?php echo e(session('success')); ?></div><?php endif; ?>

<?php if($award->cert_layout): ?>
<div class="alert alert-success py-2 mb-3">
    <i class="fas fa-check-circle me-2"></i>Certificate layout ready! Naye participants ka certificate auto-generate hoga.
    <a href="<?php echo e(route('admin.awards.certificateBuilder', $award)); ?>" class="ms-2">Edit Layout</a>
</div>
<?php else: ?>
<div class="alert alert-warning py-2 mb-3">
    <i class="fas fa-exclamation-triangle me-2"></i>Certificate layout set nahi hai!
    <a href="<?php echo e(route('admin.awards.certificateBuilder', $award)); ?>" class="btn btn-sm btn-warning ms-2">Setup Certificate Builder</a>
</div>
<?php endif; ?>

<div class="row">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-4" style="border-radius:10px;">
            <h6 class="fw-bold mb-3"><i class="fas fa-user-plus me-2"></i>Add Participant</h6>
            <form action="<?php echo e(route('admin.awards.storeParticipant', $award)); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="mb-2"><label class="form-label fw-semibold small">Name *</label>
                    <input type="text" name="name" class="form-control form-control-sm" required></div>
                <div class="mb-2"><label class="form-label fw-semibold small">Category</label>
                    <input type="text" name="category" class="form-control form-control-sm" placeholder="Drawing, Model Making..."></div>
                <div class="mb-2"><label class="form-label fw-semibold small">Class</label>
                    <input type="text" name="class" class="form-control form-control-sm" placeholder="Class VIII"></div>
                <div class="mb-2"><label class="form-label fw-semibold small">School</label>
                    <input type="text" name="school" class="form-control form-control-sm"></div>
                <div class="mb-2"><label class="form-label fw-semibold small">District</label>
                    <input type="text" name="district" class="form-control form-control-sm"></div>
                <div class="mb-2"><label class="form-label fw-semibold small">Month</label>
                    <input type="text" name="month" class="form-control form-control-sm" placeholder="Feb 2025"></div>
                <div class="mb-3"><label class="form-label fw-semibold small">Photo</label>
                    <input type="file" name="photo" class="form-control form-control-sm" accept="image/*"></div>
                <button type="submit" class="btn btn-tob w-100"><i class="fas fa-save me-2"></i>Add Participant</button>
            </form>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card data-card">
            <div class="card-body p-0">
                <table class="table table-hover mb-0 align-middle">
                    <thead style="background:#f8f9fa;">
                        <tr><th>#</th><th>Photo</th><th>Name</th><th>Category</th><th>Month</th><th>Cert No.</th><th>Actions</th></tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $participants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($participants->firstItem() + $i); ?></td>
                            <td><img src="<?php echo e($p->photo_url); ?>" width="45" height="45" class="rounded-circle" onerror="this.onerror=null;this.style.opacity='0.3'"></td>
                            <td><strong><?php echo e($p->name); ?></strong><br><small class="text-muted"><?php echo e($p->school); ?></small></td>
                            <td><span class="badge bg-warning text-dark"><?php echo e($p->category ?? '-'); ?></span></td>
                            <td><?php echo e($p->month ?? '-'); ?></td>
                            <td>
                                <?php if($p->cert_number): ?>
                                    <code style="font-size:11px;"><?php echo e($p->cert_number); ?></code>
                                <?php else: ?> <span class="text-muted">-</span> <?php endif; ?>
                            </td>
                            <td>
                                <?php if($award->cert_layout && $award->certificate_template): ?>
                                <a href="#" onclick="previewCert('<?php echo e($p->name); ?>','<?php echo e($p->cert_number); ?>','<?php echo e($p->month); ?>','<?php echo e($award->certificate_url); ?>',<?php echo e($award->cert_layout); ?>)"
                                   class="btn btn-sm btn-info text-white me-1">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <?php endif; ?>
                                <form action="<?php echo e(route('admin.awards.destroyParticipant', $p)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Delete?')">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="7" class="text-center py-4 text-muted">Koi participant nahi.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer"><?php echo e($participants->links()); ?></div>
        </div>
    </div>
</div>


<div class="modal fade" id="certModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background:linear-gradient(135deg,#1a2a6c,#6b3a1f);color:#fff;">
                <h5 class="modal-title"><i class="fas fa-certificate me-2"></i>Certificate Preview</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center p-4">
                <div id="certPreview" style="position:relative;display:inline-block;width:100%;"></div>
                <button class="btn btn-success btn-lg mt-3 px-5" onclick="downloadCert()">
                    <i class="fas fa-download me-2"></i>Download Certificate
                </button>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
var currentName = '';
function previewCert(name, certNo, month, certUrl, layout) {
    currentName = name;
    var wrap = document.getElementById('certPreview');
    wrap.innerHTML = '';

    var img = document.createElement('img');
    img.src = certUrl;
    img.style.cssText = 'width:100%;border-radius:8px;display:block;';
    wrap.appendChild(img);

    var today = new Date().toLocaleDateString('en-IN', {day:'2-digit',month:'long',year:'numeric'});

    layout.forEach(function(el) {
        var div = document.createElement('div');
        div.style.cssText = `position:absolute;left:${el.x}%;top:${el.y}%;font-size:${el.fs}px;color:${el.fc};font-weight:${el.fw};font-style:${el.fi||'normal'};text-align:${el.align||'center'};transform:translateX(-50%);white-space:nowrap;`;
        var texts = { name: name, cert_number: certNo || 'AWD-2025-0001', date: today, title: '<?php echo e(addslashes($award->title)); ?>', category: 'Award', school: '' };
        div.innerText = texts[el.type] || el.text;
        wrap.appendChild(div);
    });

    new bootstrap.Modal(document.getElementById('certModal')).show();
}

function downloadCert() {
    var wrap = document.getElementById('certPreview');
    html2canvas(wrap, {scale:2, useCORS:true, allowTaint:true}).then(function(canvas) {
        var a = document.createElement('a');
        a.download = 'certificate-' + currentName.replace(/\s+/g,'-') + '.png';
        a.href = canvas.toDataURL('image/png');
        a.click();
    });
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ROHIT RAJ\Herd\tob\resources\views/admin/awards/participants.blade.php ENDPATH**/ ?>