

<?php $__env->startSection('page-title', 'Publications'); ?>
<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0"><i class="fas fa-book me-2 text-primary"></i>Publications</h5>
    <a href="<?php echo e(route('admin.publications.create')); ?>" class="btn btn-tob"><i class="fas fa-plus me-2"></i>Add Publication</a>
</div>
<div class="card data-card mb-3">
    <div class="card-body py-3">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-5"><input type="text" name="search" class="form-control" placeholder="Search..." value="<?php echo e(request('search')); ?>"></div>
            <div class="col-md-4">
                <select name="category" class="form-select">
                    <option value="">All Categories</option>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($key); ?>" <?php echo e(request('category') == $key ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-tob w-100"><i class="fas fa-search me-1"></i>Filter</button>
                <a href="<?php echo e(route('admin.publications.index')); ?>" class="btn btn-outline-secondary w-100"><i class="fas fa-redo"></i></a>
            </div>
        </form>
    </div>
</div>
<div class="card data-card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0 align-middle">
            <thead style="background:#f8f9fa;">
                <tr><th>#</th><th>Cover</th><th>Title</th><th>Category</th><th>Issue</th><th>Status</th><th>Created By</th><th>Updated By</th><th>Actions</th></tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $publications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $pub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($publications->firstItem() + $i); ?></td>
                    <td><img src="<?php echo e($pub->image_url); ?>" height="50" class="rounded" onerror="this.onerror=null;this.style.opacity='0.3'"></td>
                    <td><?php echo e(Str::limit($pub->title, 40)); ?></td>
                    <td><span class="badge bg-primary bg-opacity-10 text-primary"><?php echo e(str_replace('_', ' ', ucfirst($pub->category))); ?></span></td>
                    <td><?php echo e($pub->issue_number ?? '-'); ?></td>
                    <td><span class="badge <?php echo e($pub->is_active ? 'bg-success' : 'bg-secondary'); ?>"><?php echo e($pub->is_active ? 'Active' : 'Inactive'); ?></span></td>
                    <td>
                        <?php if($pub->createdBy ?? false): ?><small class="text-muted"><i class="fas fa-user me-1"></i><?php echo e($pub->createdBy->name); ?></small><br><?php endif; ?>
                        <small class="text-muted"><?php echo e($pub->created_at->format('d M Y')); ?></small>
                    </td>
                    <td>
                        <?php if($pub->updatedBy ?? false): ?><small class="text-info"><i class="fas fa-edit me-1"></i><?php echo e($pub->updatedBy->name); ?></small><br><small class="text-muted"><?php echo e($pub->updated_at->format('d M Y')); ?></small>
                        <?php else: ?><span class="text-muted">-</span><?php endif; ?>
                    </td>
                    <td>
                        <a href="<?php echo e(route('admin.publications.edit', $pub)); ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                        <form action="<?php echo e(route('admin.publications.destroy', $pub)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Delete?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="9" class="text-center py-4 text-muted">Koi publication nahi mili.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="card-footer"><?php echo e($publications->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ROHIT RAJ\Herd\tob\resources\views/admin/publications/index.blade.php ENDPATH**/ ?>