

<?php $__env->startSection('title', 'Awards - Teachers of Bihar'); ?>
<?php $__env->startPush('styles'); ?>
<style>
.award-card { border-radius:12px; overflow:hidden; transition:transform 0.2s, box-shadow 0.2s; cursor:pointer; }
.award-card:hover { transform:translateY(-5px); box-shadow:0 10px 30px rgba(0,0,0,0.15) !important; }
.award-card img { width:100%; height:220px; object-fit:cover; }
.award-title { color:#dc3545; font-weight:700; font-size:16px; padding:12px; }
.page-heading { color:#dc3545; font-weight:700; font-size:28px; text-align:center; margin-bottom:30px; }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
<div class="page-banner">
    <div class="container">
        <h1>Award</h1>
        <nav><ol class="breadcrumb mb-0"><li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Home</a></li><li class="breadcrumb-item active">Award</li></ol></nav>
    </div>
</div>
<div class="container py-5">
    <h2 class="page-heading">Teacher of Bihar Award/Certificate</h2>
    <div class="row g-4">
        <?php $__empty_1 = true; $__currentLoopData = $awards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $award): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="col-md-4 col-sm-6">
            <a href="<?php echo e(route('award.show', $award->slug)); ?>" class="text-decoration-none">
                <div class="card border-0 shadow-sm award-card">
                    <?php if($award->image): ?>
                        <img src="<?php echo e($award->image_url); ?>" alt="<?php echo e($award->title); ?>" onerror="this.onerror=null;this.style.opacity='0.3'">
                    <?php else: ?>
                        <div style="height:220px;background:linear-gradient(135deg,#1a2a6c,#6b3a1f);display:flex;align-items:center;justify-content:center;">
                            <i class="fas fa-trophy fa-4x text-warning"></i>
                        </div>
                    <?php endif; ?>
                    <div class="award-title"><?php echo e($award->title); ?></div>
                </div>
            </a>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-12 text-center py-5 text-muted">
            <i class="fas fa-trophy fa-3x mb-3 text-warning"></i>
            <p>No awards listed yet.</p>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ROHIT RAJ\Herd\tob\resources\views/frontend/award.blade.php ENDPATH**/ ?>