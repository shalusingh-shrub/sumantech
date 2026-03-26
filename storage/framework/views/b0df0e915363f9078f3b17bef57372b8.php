

<?php $__env->startSection('title', 'Testimonials - Teachers of Bihar'); ?>
<?php $__env->startSection('content'); ?>
<div class="page-banner"><div class="container"><h1>Testimonials</h1></div></div>
<div class="container py-5">
    <div class="row g-4">
        <?php $__empty_1 = true; $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="col-md-6">
            <div class="testimonial-card h-100">
                <div class="stars mb-2">
                    <?php for($i = 1; $i <= 5; $i++): ?><i class="fas fa-star<?php echo e($i <= $t->rating ? '' : '-half-alt'); ?>" style="color:#ffc107;"></i><?php endfor; ?>
                </div>
                <p class="mb-3">"<?php echo e($t->content); ?>"</p>
                <div class="d-flex align-items-center">
                    <img src="<?php echo e($t->photo_url); ?>" width="50" height="50" class="rounded-circle me-3" onerror="this.onerror=null;this.style.opacity='0.3'">
                    <div>
                        <strong><?php echo e($t->name); ?></strong><br>
                        <small class="text-muted"><?php echo e($t->designation); ?> <?php if($t->organization): ?> - <?php echo e($t->organization); ?><?php endif; ?></small>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-12 text-center py-5 text-muted"><p>No testimonials found.</p></div>
        <?php endif; ?>
    </div>
    <div class="mt-4"><?php echo e($testimonials->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ROHIT RAJ\Herd\tob\resources\views/frontend/testimonials.blade.php ENDPATH**/ ?>