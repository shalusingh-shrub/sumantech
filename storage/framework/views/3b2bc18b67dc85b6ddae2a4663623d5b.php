

<?php $__env->startSection('page-title', 'Top Flash News'); ?>
<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0"><i class="fas fa-bolt me-2 text-warning"></i>Top Flash News</h5>
    <a href="<?php echo e(route('admin.topflash.create')); ?>" class="btn btn-tob"><i class="fas fa-plus me-2"></i>Add Flash</a>
</div>
<div class="card data-card mb-3">
    <div class="card-body py-3">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-8"><input type="text" name="search" class="form-control" placeholder="Search..." value="<?php echo e(request('search')); ?>"></div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-tob w-100"><i class="fas fa-search me-1"></i>Search</button>
                <a href="<?php echo e(route('admin.topflash.index')); ?>" class="btn btn-outline-secondary w-100"><i class="fas fa-redo"></i></a>
            </div>
        </form>
    </div>
</div>
<div class="card data-card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0 align-middle">
            <thead style="background:#f8f9fa;">
                <tr><th>#</th><th>Title</th><th>Link</th><th>Is New</th><th>Order</th><th>Status</th><th>Created By</th><th>Updated By</th><th>Actions</th></tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $flashes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $flash): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($flashes->firstItem() + $i); ?></td>
                    <td><?php echo e(Str::limit($flash->title, 50)); ?></td>
                    <td><a href="<?php echo e($flash->link); ?>" target="_blank" class="text-truncate d-inline-block" style="max-width:120px;"><?php echo e($flash->link); ?></a></td>
                    <td><?php echo e($flash->is_new ? '✅' : '❌'); ?></td>
                    <td><?php echo e($flash->sort_order); ?></td>
                    <td><span class="badge <?php echo e($flash->is_active ? 'bg-success' : 'bg-secondary'); ?>"><?php echo e($flash->is_active ? 'Active' : 'Inactive'); ?></span></td>
                    <td>
                        <?php if($flash->createdBy ?? false): ?><small class="text-muted"><i class="fas fa-user me-1"></i><?php echo e($flash->createdBy->name); ?></small><br><?php endif; ?>
                        <small class="text-muted"><?php echo e($flash->created_at->format('d M Y')); ?></small>
                    </td>
                    <td>
                        <?php if($flash->updatedBy ?? false): ?><small class="text-info"><i class="fas fa-edit me-1"></i><?php echo e($flash->updatedBy->name); ?></small><br><small class="text-muted"><?php echo e($flash->updated_at->format('d M Y')); ?></small>
                        <?php else: ?><span class="text-muted">-</span><?php endif; ?>
                    </td>
                    <td>
                        <a href="<?php echo e(route('admin.topflash.edit', $flash)); ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                        <form action="<?php echo e(route('admin.topflash.destroy', $flash)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Delete?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="9" class="text-center py-4 text-muted">Koi flash news nahi mila.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="card-footer"><?php echo e($flashes->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ROHIT RAJ\Herd\tob\resources\views/admin/topflash/index.blade.php ENDPATH**/ ?>