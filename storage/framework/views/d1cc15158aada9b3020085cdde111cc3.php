

<?php $__env->startSection('page-title', 'Awards'); ?>
<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0"><i class="fas fa-trophy me-2 text-warning"></i>Awards</h5>
    <a href="<?php echo e(route('admin.awards.create')); ?>" class="btn btn-tob"><i class="fas fa-plus me-2"></i>Add Award</a>
</div>
<div class="card data-card mb-3">
    <div class="card-body py-3">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-9"><input type="text" name="search" class="form-control" placeholder="Search by title..." value="<?php echo e(request('search')); ?>"></div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-tob w-100"><i class="fas fa-search me-1"></i>Search</button>
                <a href="<?php echo e(route('admin.awards.index')); ?>" class="btn btn-outline-secondary w-100"><i class="fas fa-redo"></i></a>
            </div>
        </form>
    </div>
</div>
<div class="card data-card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0 align-middle">
            <thead style="background:#f8f9fa;">
                <tr><th>#</th><th>Image</th><th>Title</th><th>Year</th><th>Certificate</th><th>Participants</th><th>Status</th><th>Created By</th><th>Actions</th></tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $awards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $award): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($awards->firstItem() + $i); ?></td>
                    <td>
                        <?php if($award->image): ?>
                            <img src="<?php echo e($award->image_url); ?>" width="60" height="60" class="rounded" style="object-fit:cover;" onerror="this.onerror=null;this.style.opacity='0.3'">
                        <?php else: ?>
                            <div style="width:60px;height:60px;background:linear-gradient(135deg,#1a2a6c,#6b3a1f);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                                <i class="fas fa-trophy text-warning fa-lg"></i>
                            </div>
                        <?php endif; ?>
                    </td>
                    <td><strong><?php echo e(Str::limit($award->title, 40)); ?></strong></td>
                    <td><span class="badge bg-primary"><?php echo e($award->year ?? '-'); ?></span></td>
                    <td>
                        <?php if($award->has_certificate && $award->certificate_template): ?>
                            <span class="badge bg-success"><i class="fas fa-certificate me-1"></i>Available</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">None</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?php echo e(route('admin.awards.participants', $award)); ?>" class="badge bg-info text-white text-decoration-none">
                            <?php echo e($award->participants()->count()); ?> Participants
                        </a>
                    </td>
                    <td><span class="badge <?php echo e($award->is_active ? 'bg-success' : 'bg-secondary'); ?>"><?php echo e($award->is_active ? 'Active' : 'Inactive'); ?></span></td>
                    <td>
                        <?php if($award->createdBy ?? false): ?><small class="text-muted"><i class="fas fa-user me-1"></i><?php echo e($award->createdBy->name); ?></small><br><?php endif; ?>
                        <small class="text-muted"><?php echo e($award->created_at->format('d M Y')); ?></small>
                    </td>
                    <td>
                        <div class="d-flex flex-column gap-1">
                            <div class="d-flex gap-1">
                                <a href="<?php echo e(route('admin.awards.edit', $award)); ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                <form action="<?php echo e(route('admin.awards.destroy', $award)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Delete?')">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                            <a href="<?php echo e(route('admin.awards.participants', $award)); ?>" class="btn btn-sm btn-info text-white py-1" style="font-size:11px;">
                                <i class="fas fa-users me-1"></i>Participants
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="9" class="text-center py-4 text-muted">Koi award nahi mila.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="card-footer d-flex justify-content-between">
        <small class="text-muted">Total: <?php echo e($awards->total()); ?> awards</small>
        <?php echo e($awards->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ROHIT RAJ\Herd\tob\resources\views/admin/awards/index.blade.php ENDPATH**/ ?>