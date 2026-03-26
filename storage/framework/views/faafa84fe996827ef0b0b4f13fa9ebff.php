

<?php $__env->startSection('title', ($page->title ?? 'Page') . ' - Teachers of Bihar'); ?>
<?php $__env->startSection('content'); ?>
<div class="page-banner">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h1><?php echo e($page->title ?? 'Page'); ?></h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Home</a></li>
                    <li class="breadcrumb-item active"><?php echo e($page->title ?? 'Page'); ?></li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="container py-5">
    <?php if($page): ?>
        <?php echo $page->content; ?>

    <?php else: ?>
        <div class="text-center py-5">
            <h3>Page content coming soon...</h3>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ROHIT RAJ\Herd\tob\resources\views/frontend/page.blade.php ENDPATH**/ ?>