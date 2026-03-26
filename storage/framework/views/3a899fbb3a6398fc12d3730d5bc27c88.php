

<?php $__env->startSection('title', $item->title . ' - Teachers of Bihar'); ?>
<?php $__env->startSection('content'); ?>
<div class="page-banner">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h1 style="font-size:22px;"><?php echo e(Str::limit($item->title, 60)); ?></h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo e(route('news-events')); ?>">News & Events</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="container py-5">
    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <?php if($item->image): ?>
                <img src="<?php echo e($item->image_url); ?>" alt="<?php echo e($item->title); ?>" class="card-img-top" style="max-height:400px;object-fit:cover;" onerror="this.style.display='none'">
                <?php endif; ?>
                <div class="card-body p-4">
                    <div class="d-flex gap-2 mb-3">
                        <span class="badge <?php echo e($item->category === 'event' ? 'bg-warning text-dark' : 'bg-success'); ?>"><?php echo e(ucfirst($item->category)); ?></span>
                        <?php if($item->event_date): ?><span class="badge bg-light text-dark"><i class="fas fa-calendar me-1"></i><?php echo e($item->event_date->format('d M Y')); ?></span><?php endif; ?>
                        <span class="text-muted" style="font-size:12px;"><i class="fas fa-clock me-1"></i><?php echo e($item->created_at->diffForHumans()); ?></span>
                    </div>
                    <h2 class="mb-3"><?php echo e($item->title); ?></h2>
                    <div class="content-body"><?php echo $item->content; ?></div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mt-4 mt-md-0">
            <h5 class="section-title">Related News</h5>
            <?php $__currentLoopData = $related; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="card border-0 shadow-sm mb-3">
                <div class="row g-0">
                    <div class="col-4">
                        <img src="<?php echo e($rel->image_url); ?>" alt="<?php echo e($rel->title); ?>" class="img-fluid rounded-start" style="height:80px;object-fit:cover;" onerror="this.onerror=null;this.style.opacity='0.3'">
                    </div>
                    <div class="col-8">
                        <div class="card-body p-2">
                            <p class="card-text small fw-bold"><?php echo e(Str::limit($rel->title, 55)); ?></p>
                            <a href="<?php echo e(route('news.show', $rel->slug)); ?>" class="btn btn-sm btn-link p-0">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ROHIT RAJ\Herd\tob\resources\views/frontend/news/show.blade.php ENDPATH**/ ?>