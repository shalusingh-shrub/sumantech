

<?php $__env->startSection('page-title', 'Add Gallery Item'); ?>
<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between mb-4">
    <h5>Add Gallery Item</h5>
    <a href="<?php echo e(route('admin.gallery.index')); ?>" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i>Back</a>
</div>
<div class="card data-card">
    <div class="card-body p-4">
        <form action="<?php echo e(route('admin.gallery.store')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Title *</label>
                    <input type="text" name="title" class="form-control" value="<?php echo e(old('title')); ?>" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label fw-semibold">Type *</label>
                    <select name="type" class="form-select" id="typeSelect" onchange="toggleFields()">
                        <option value="image">Image</option>
                        <option value="video">Video</option>
                        <option value="media">Media</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label fw-semibold">Category</label>
                    <input type="text" name="category" class="form-control" value="<?php echo e(old('category')); ?>" placeholder="e.g. events">
                </div>
            </div>
            <div id="imageField" class="mb-3">
                <label class="form-label fw-semibold">Image File</label>
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>
            <div id="videoField" class="mb-3" style="display:none;">
                <label class="form-label fw-semibold">Video URL (YouTube etc.)</label>
                <input type="url" name="video_url" class="form-control" value="<?php echo e(old('video_url')); ?>" placeholder="https://www.youtube.com/watch?v=...">
            </div>
            <div class="form-check mb-3">
                <input type="checkbox" name="is_active" class="form-check-input" value="1" checked>
                <label class="form-check-label">Active</label>
            </div>
            <button type="submit" class="btn btn-tob px-4"><i class="fas fa-save me-2"></i>Save</button>
        </form>
    </div>
</div>
<?php $__env->startPush('scripts'); ?>
<script>
function toggleFields() {
    const type = document.getElementById('typeSelect').value;
    document.getElementById('imageField').style.display = type !== 'video' ? 'block' : 'none';
    document.getElementById('videoField').style.display = type === 'video' ? 'block' : 'none';
}
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ROHIT RAJ\Herd\tob\resources\views/admin/gallery/create.blade.php ENDPATH**/ ?>