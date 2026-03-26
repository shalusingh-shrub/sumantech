

<?php $__env->startSection('title', 'Competition - Teachers of Bihar'); ?>
<?php $__env->startSection('content'); ?>
<div class="page-banner"><div class="container"><h1>Competition</h1></div></div>
<div class="container py-5">
    <div class="row g-4">
        <?php $__empty_1 = true; $__currentLoopData = $competitions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius:10px; overflow:hidden;">

                
                <?php if($comp->image): ?>
                <img src="<?php echo e($comp->image_url); ?>" class="card-img-top" style="height:220px; object-fit:cover;" onerror="this.style.display='none'">
                <?php endif; ?>

                <div class="card-body p-4">
                    
                    <h5 class="fw-bold mb-3" style="color:#1a2a6c;"><?php echo e($comp->title); ?></h5>

                    
                    <?php if($comp->start_date): ?>
                    <p class="mb-1 text-muted" style="font-size:14px;">
                        <i class="fas fa-calendar-alt me-1 text-primary"></i>
                        <strong>Start Date:</strong> <?php echo e($comp->start_date->format('d M Y, H:i:s')); ?>

                    </p>
                    <?php endif; ?>

                    <?php if($comp->end_date): ?>
                    <p class="mb-3 text-muted" style="font-size:14px;">
                        <i class="fas fa-calendar-check me-1 text-danger"></i>
                        <strong>End Date:</strong> <?php echo e($comp->end_date->format('d M Y, H:i:s')); ?>

                    </p>
                    <?php endif; ?>

                    
                    <div class="d-flex flex-wrap gap-2 mt-3">

                        
                        <a href="<?php echo e(route('competition.show', $comp->slug)); ?>"
                           class="btn btn-sm"
                           style="background:#17a2b8; color:#fff; border-radius:6px; padding:8px 16px;">
                            View Details
                        </a>

                        
                        <a href="<?php echo e(route('competition.show', $comp->slug)); ?>#submissions"
                           class="btn btn-sm"
                           style="background:#17a2b8; color:#fff; border-radius:6px; padding:8px 16px;">
                            View Submission
                        </a>

                        
                        <?php if($comp->end_date && $comp->end_date->isFuture()): ?>
                            <?php if($comp->registration_link): ?>
                            <a href="<?php echo e($comp->registration_link); ?>" target="_blank"
                               class="btn btn-sm w-100"
                               style="background:#28a745; color:#fff; border-radius:6px; padding:8px 16px;">
                                <i class="fas fa-user-plus me-1"></i>Participate Now
                            </a>
                            <?php endif; ?>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-12 text-center py-5 text-muted">
            <i class="fas fa-medal fa-3x mb-3 text-muted"></i>
            <p>No competitions announced yet.</p>
        </div>
        <?php endif; ?>
    </div>

    
    <?php if($competitions->hasPages()): ?>
    <div class="mt-4 d-flex justify-content-center">
        <?php echo e($competitions->links()); ?>

    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ROHIT RAJ\Herd\tob\resources\views/frontend/competition.blade.php ENDPATH**/ ?>