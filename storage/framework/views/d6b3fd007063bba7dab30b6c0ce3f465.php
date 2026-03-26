

<?php $__env->startSection('title', $comp->title . ' - Teachers of Bihar'); ?>
<?php $__env->startSection('content'); ?>
<div class="page-banner"><div class="container"><h1>Competition</h1></div></div>
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo e(route('competition')); ?>">Competition</a></li>
            <li class="breadcrumb-item active"><?php echo e(Str::limit($comp->title, 40)); ?></li>
        </ol>
    </nav>

    <div class="row g-4">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm p-4" style="border-radius:10px;">
                <?php if($comp->image): ?>
                <img src="<?php echo e($comp->image_url); ?>" class="img-fluid rounded mb-4" style="max-height:400px; width:100%; object-fit:cover;">
                <?php endif; ?>

                <h3 class="fw-bold mb-3" style="color:#1a2a6c;"><?php echo e($comp->title); ?></h3>

                <?php if($comp->description): ?>
                <p class="text-muted"><?php echo e($comp->description); ?></p>
                <?php endif; ?>

                
                <div id="submissions" class="mt-4 p-3 bg-light rounded">
                    <h5 class="fw-bold"><i class="fas fa-users me-2"></i>Submissions</h5>
                    <p class="text-muted mb-0">Koi submission nahi mili abhi tak.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-4" style="border-radius:10px;">
                <h6 class="fw-bold mb-3"><i class="fas fa-info-circle me-2"></i>Competition Details</h6>

                <?php if($comp->start_date): ?>
                <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                    <span class="text-muted">Start Date</span>
                    <strong><?php echo e($comp->start_date->format('d M Y')); ?></strong>
                </div>
                <?php endif; ?>

                <?php if($comp->end_date): ?>
                <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                    <span class="text-muted">End Date</span>
                    <strong><?php echo e($comp->end_date->format('d M Y')); ?></strong>
                </div>
                <?php endif; ?>

                <?php if($comp->result_date): ?>
                <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                    <span class="text-muted">Result Date</span>
                    <strong><?php echo e($comp->result_date->format('d M Y')); ?></strong>
                </div>
                <?php endif; ?>

                <div class="d-flex justify-content-between mb-3 pb-2 border-bottom">
                    <span class="text-muted">Status</span>
                    <?php if($comp->end_date && $comp->end_date->isFuture()): ?>
                        <span class="badge bg-success">Open</span>
                    <?php else: ?>
                        <span class="badge bg-danger">Closed</span>
                    <?php endif; ?>
                </div>

                
                <?php if($comp->end_date && $comp->end_date->isFuture() && $comp->registration_link): ?>
                <a href="<?php echo e($comp->registration_link); ?>" target="_blank"
                   class="btn w-100 mb-2"
                   style="background:#28a745; color:#fff; border-radius:6px; padding:10px;">
                    <i class="fas fa-user-plus me-2"></i>Participate Now
                </a>
                <?php endif; ?>

                <a href="<?php echo e(route('competition')); ?>" class="btn btn-outline-secondary w-100">
                    <i class="fas fa-arrow-left me-2"></i>Back to Competitions
                </a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ROHIT RAJ\Herd\tob\resources\views/frontend/competition_show.blade.php ENDPATH**/ ?>