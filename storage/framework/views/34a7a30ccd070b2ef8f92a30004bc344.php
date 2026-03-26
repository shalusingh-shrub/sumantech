

<?php $__env->startSection('page-title', 'Edit Gallery Item'); ?>
<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between mb-4">
    <h5>Edit Gallery Item</h5>
    <a href="<?php echo e(route('admin.gallery.index')); ?>" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i>Back</a>
</div>
<div class="card data-card">
    <div class="card-body p-4">
        <form action="<?php echo e(route('admin.gallery.update', $gallery)); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Title *</label>
                    <input type="text" name="title" class="form-control" value="<?php echo e(old('title', $gallery->title)); ?>" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label fw-semibold">Type *</label>
                    <select name="type" class="form-select">
                        <option value="image" <?php echo e($gallery->type==='image' ? 'selected' : ''); ?>>Image</option>
                        <option value="video" <?php echo e($gallery->type==='video' ? 'selected' : ''); ?>>Video</option>
                        <option value="media" <?php echo e($gallery->type==='media' ? 'selected' : ''); ?>>Media</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label fw-semibold">Category</label>
                    <input type="text" name="category" class="form-control" value="<?php echo e(old('category', $gallery->category)); ?>">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Image</label>
                <?php if($gallery->image): ?><img src="<?php echo e($gallery->image_url); ?>" height="60" class="d-block mb-1 rounded" onerror="this.style.display='none'"><?php endif; ?>
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Video URL</label>
                <input type="url" name="video_url" class="form-control" value="<?php echo e(old('video_url', $gallery->video_url)); ?>">
            </div>
            <div class="form-check mb-3">
                <input type="checkbox" name="is_active" class="form-check-input" value="1" <?php echo e($gallery->is_active ? 'checked' : ''); ?>>
                <label class="form-check-label">Active</label>
            </div>
            <button type="submit" class="btn btn-tob px-4"><i class="fas fa-save me-2"></i>Update</button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ROHIT RAJ\Herd\tob\resources\views/admin/gallery/edit.blade.php ENDPATH**/ ?>