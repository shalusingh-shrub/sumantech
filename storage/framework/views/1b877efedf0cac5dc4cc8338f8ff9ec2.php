

<?php $__env->startSection('page-title', 'Edit Publication'); ?>
<?php $__env->startPush('styles'); ?>
<style>
.sidebar-card { border:1px solid #dee2e6; border-radius:10px; padding:20px; margin-bottom:16px; background:#fff; box-shadow:0 2px 8px rgba(0,0,0,0.05); }
.sidebar-card h6 { font-weight:700; margin-bottom:14px; font-size:14px; color:#1a2a6c; border-bottom:2px solid #f0f0f0; padding-bottom:8px; }
.publish-btn { background:linear-gradient(135deg,#1a2a6c,#6b3a1f); color:#fff; border:none; border-radius:8px; width:100%; padding:12px; font-size:15px; font-weight:600; cursor:pointer; }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between mb-4">
    <h5 class="fw-bold"><i class="fas fa-edit me-2 text-warning"></i>Edit Publication</h5>
    <a href="<?php echo e(route('admin.publications.index')); ?>" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Back</a>
</div>
<?php if($errors->any()): ?>
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><p class="mb-0"><i class="fas fa-exclamation-circle me-1"></i><?php echo e($error); ?></p><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php endif; ?>
<form action="<?php echo e(route('admin.publications.update', $publication)); ?>" method="POST" enctype="multipart/form-data">
<?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
<div class="row">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm p-4 mb-3" style="border-radius:10px;">
            <div class="mb-3">
                <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control form-control-lg" value="<?php echo e(old('title', $publication->title)); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Description / Content</label>
                <textarea name="description" id="descriptionEditor" class="form-control" rows="8"><?php echo e(old('description', $publication->description)); ?></textarea>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Issue Number</label>
                    <input type="text" name="issue_number" class="form-control" value="<?php echo e(old('issue_number', $publication->issue_number)); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Published Date</label>
                    <input type="date" name="published_date" class="form-control" value="<?php echo e(old('published_date', $publication->published_date?->format('Y-m-d'))); ?>">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Cover Image</label>
                <?php if($publication->cover_image): ?><img src="<?php echo e($publication->image_url); ?>" class="d-block mb-2 rounded" style="height:80px;"><?php endif; ?>
                <input type="file" name="cover_image" class="form-control" accept="image/*">
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">PDF File</label>
                <?php if($publication->file): ?><div class="mb-2"><a href="<?php echo e(asset('storage/publication_files/'.$publication->file)); ?>" target="_blank" class="btn btn-sm btn-outline-danger"><i class="fas fa-file-pdf me-1"></i>Current PDF</a></div><?php endif; ?>
                <input type="file" name="file" class="form-control" accept=".pdf">
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="sidebar-card">
            <h6><i class="fas fa-paper-plane me-2"></i>Publish</h6>
            <div class="mb-3">
                <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                <select name="category" class="form-select" required>
                    <option value="">-- Select Category --</option>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($key); ?>" <?php echo e(old('category', $publication->category) == $key ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" name="is_active" value="1" <?php echo e($publication->is_active ? 'checked' : ''); ?>>
                <label class="form-check-label">Active</label>
            </div>
            <button type="submit" class="publish-btn"><i class="fas fa-save me-2"></i>Update Publication</button>
        </div>
    </div>
</div>
</form>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
<script>
CKEDITOR.replace('descriptionEditor', { height: 300, removePlugins: 'elementspath' });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ROHIT RAJ\Herd\tob\resources\views/admin/publications/edit.blade.php ENDPATH**/ ?>