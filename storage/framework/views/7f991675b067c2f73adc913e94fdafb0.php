

<?php $__env->startSection('title', 'News & Events - Teachers of Bihar'); ?>
<?php $__env->startSection('content'); ?>
<div class="page-banner">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h1>News & Events</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Home</a></li>
                    <li class="breadcrumb-item active">News & Events</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="container py-5">
    <div class="row g-4">
        <?php $__empty_1 = true; $__currentLoopData = $news; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="col-md-4">
            <div class="card news-card h-100">
                <img src="<?php echo e($item->image_url); ?>" alt="<?php echo e($item->title); ?>" class="card-img-top" style="height:200px;object-fit:cover;" onerror="this.onerror=null;this.style.opacity='0.3'">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="badge <?php echo e($item->category === 'event' ? 'bg-warning text-dark' : 'bg-success'); ?>"><?php echo e(ucfirst($item->category)); ?></span>
                        <?php if($item->event_date): ?><small class="text-muted"><?php echo e($item->event_date->format('d M Y')); ?></small><?php endif; ?>
                    </div>
                    <h6 class="card-title fw-bold"><?php echo e($item->title); ?></h6>
                    <p class="card-text text-muted small"><?php echo e(Str::limit($item->short_description, 120)); ?></p>
                    <a href="<?php echo e(route('news.show', $item->slug)); ?>" class="btn btn-sm btn-outline-primary">Read More <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
                <div class="card-footer bg-transparent text-muted" style="font-size:12px;">
                    <i class="fas fa-clock me-1"></i><?php echo e($item->created_at->diffForHumans()); ?>

                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-12 text-center py-5 text-muted">
            <i class="fas fa-newspaper fa-3x mb-3"></i>
            <p>No news or events found.</p>
        </div>
        <?php endif; ?>
    </div>
    <div class="mt-4"><?php echo e($news->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ROHIT RAJ\Herd\tob\resources\views/frontend/news/index.blade.php ENDPATH**/ ?>