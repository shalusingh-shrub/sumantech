

<?php $__env->startSection('title', 'Image Gallery - Teachers of Bihar'); ?>
<?php $__env->startSection('content'); ?>
<div class="page-banner">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h1>Image Gallery</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Home</a></li>
                    <li class="breadcrumb-item active">Image Gallery</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="container py-5">
    <div class="row g-3">
        <?php $__empty_1 = true; $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card border-0 shadow-sm overflow-hidden" style="cursor:pointer;" onclick="showImage('<?php echo e($img->image_url); ?>', '<?php echo e($img->title); ?>')">
                <img src="<?php echo e($img->image_url); ?>" alt="<?php echo e($img->title); ?>" class="img-fluid" style="height:180px;object-fit:cover;" onerror="this.onerror=null;this.style.opacity='0.3'">
                <div class="card-footer bg-light p-2 text-center"><small><?php echo e($img->title); ?></small></div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-12 text-center py-5 text-muted"><i class="fas fa-images fa-3x mb-3"></i><p>No images available.</p></div>
        <?php endif; ?>
    </div>
    <div class="mt-4"><?php echo e($images->links()); ?></div>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center p-0">
                <img id="modalImage" src="" class="img-fluid w-100">
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
function showImage(url, title) {
    document.getElementById('modalImage').src = url;
    document.getElementById('imageTitle').textContent = title;
    new bootstrap.Modal(document.getElementById('imageModal')).show();
}
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ROHIT RAJ\Herd\tob\resources\views/frontend/gallery/image.blade.php ENDPATH**/ ?>