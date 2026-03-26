

<?php $__env->startSection('title', 'EIP - Education Innovation Program'); ?>
<?php $__env->startSection('content'); ?>
<div class="page-banner"><div class="container"><h1>Education Innovation Program (EIP)</h1></div></div>
<div class="container py-5">
    <p class="lead mb-4">EIP is our flagship program encouraging innovative teaching practices in Bihar government schools.</p>
    <div class="row g-4">
        <?php $__empty_1 = true; $__currentLoopData = $resources; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $resource): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <?php if($resource->image): ?><img src="<?php echo e($resource->image_url); ?>" class="card-img-top" style="height:180px;object-fit:cover;" onerror="this.style.display='none'"><?php endif; ?>
                <div class="card-body">
                    <h6 class="fw-bold"><?php echo e($resource->title); ?></h6>
                    <p class="text-muted small"><?php echo e(Str::limit($resource->description, 100)); ?></p>
                    <?php if($resource->link): ?><a href="<?php echo e($resource->link); ?>" target="_blank" class="btn btn-sm btn-outline-primary">View Resource</a><?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-12 text-center py-5 text-muted"><p>EIP resources coming soon.</p></div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ROHIT RAJ\Herd\tob\resources\views/frontend/eip.blade.php ENDPATH**/ ?>