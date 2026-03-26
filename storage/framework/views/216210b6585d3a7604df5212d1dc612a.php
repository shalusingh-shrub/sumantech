

<?php $__env->startSection('page-title', 'Edit Award'); ?>
<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between mb-4">
    <h5 class="fw-bold"><i class="fas fa-edit me-2 text-warning"></i>Edit Award</h5>
    <a href="<?php echo e(route('admin.awards.index')); ?>" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Back</a>
</div>

<?php if($errors->any()): ?>
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><p class="mb-0"><i class="fas fa-exclamation-circle me-1"></i><?php echo e($error); ?></p><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php endif; ?>

<form action="<?php echo e(route('admin.awards.update', $award)); ?>" method="POST" enctype="multipart/form-data">
<?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
<div class="row">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm p-4 mb-3" style="border-radius:10px;">
            <div class="row">
                <div class="col-md-8 mb-3">
                    <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control form-control-lg <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('title', $award->title)); ?>" required>
                    <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold">Year</label>
                    <input type="number" name="year" class="form-control form-control-lg" value="<?php echo e(old('year', $award->year)); ?>" min="2000" max="2099">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Description</label>
                <textarea name="description" id="descriptionEditor" class="form-control" rows="6"><?php echo e(old("description", $award->description)); ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Award Image</label>
                <?php if($award->image): ?>
                    <img src="<?php echo e($award->image_url); ?>" class="d-block mb-2 rounded" style="height:80px;" onerror="this.onerror=null;this.style.opacity='0.3'">
                <?php endif; ?>
                <input type="file" name="image" class="form-control" accept="image/*">
                <small class="text-muted">Naya image upload karo ya khali chhodo</small>
            </div>
        </div>

        
        <div class="card border-0 shadow-sm p-4" style="border-radius:10px; border-left:4px solid #ffc107 !important;">
            <h6 class="fw-bold mb-3"><i class="fas fa-certificate me-2 text-warning"></i>Certificate Template</h6>
            <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" name="has_certificate" value="1" id="hasCert" <?php echo e($award->has_certificate ? 'checked' : ''); ?>>
                <label class="form-check-label fw-semibold" for="hasCert">Is Certificate Available?</label>
            </div>
            <div id="certUploadSection" style="<?php echo e($award->has_certificate ? '' : 'display:none;'); ?>">
                <?php if($award->certificate_template): ?>
                    <div class="mb-2">
                        <small class="text-success"><i class="fas fa-check-circle me-1"></i>Certificate uploaded</small>
                        <img src="<?php echo e($award->certificate_url); ?>" class="d-block mt-1 rounded" style="max-height:120px;" onerror="this.onerror=null;this.style.opacity='0.3'">
                    </div>
                <?php endif; ?>
                <label class="form-label fw-semibold">Upload New Certificate Template</label>
                <input type="file" name="certificate_template" class="form-control" accept="image/*">
                <small class="text-muted"><i class="fas fa-info-circle me-1 text-primary"></i>Naya upload karo ya khali chhodo</small>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-4" style="border-radius:10px;">
            <h6 class="fw-bold mb-3"><i class="fas fa-paper-plane me-2"></i>Publish</h6>
            <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" name="is_active" value="1" <?php echo e($award->is_active ? 'checked' : ''); ?>>
                <label class="form-check-label">Active</label>
            </div>
            <button type="submit" class="btn btn-tob w-100" style="padding:12px;font-size:15px;font-weight:600;">
                <i class="fas fa-save me-2"></i>Update Award
            </button>
            <?php if($award->has_certificate && $award->certificate_template): ?>
            <a href="<?php echo e(route('admin.awards.certificateBuilder', $award)); ?>" class="btn btn-warning w-100 mt-2" style="padding:11px;font-weight:600;">
                <i class="fas fa-certificate me-2"></i>Certificate Elements Builder
            </a>
            <?php endif; ?>
        </div>
    </div>
</div>
</form>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
document.getElementById('hasCert').addEventListener('change', function() {
    document.getElementById('certUploadSection').style.display = this.checked ? 'block' : 'none';
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
<script>CKEDITOR.replace('descriptionEditor', { height: 250, removePlugins: 'elementspath' });</script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ROHIT RAJ\Herd\tob\resources\views/admin/awards/edit.blade.php ENDPATH**/ ?>