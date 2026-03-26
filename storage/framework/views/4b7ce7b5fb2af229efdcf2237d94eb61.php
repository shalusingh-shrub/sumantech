

<?php $__env->startSection('page-title', 'Team Members'); ?>
<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0"><i class="fas fa-users me-2 text-primary"></i>Team Members</h5>
    <a href="<?php echo e(route('admin.team.create')); ?>" class="btn btn-tob"><i class="fas fa-plus me-2"></i>Add Member</a>
</div>
<div class="card data-card mb-3">
    <div class="card-body py-3">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-6"><input type="text" name="search" class="form-control" placeholder="Search by name..." value="<?php echo e(request('search')); ?>"></div>
            <div class="col-md-3">
                <select name="role_type" class="form-select">
                    <option value="">All Roles</option>
                    <option value="founder" <?php echo e(request('role_type') == 'founder' ? 'selected' : ''); ?>>Founder</option>
                    <option value="co_founder" <?php echo e(request('role_type') == 'co_founder' ? 'selected' : ''); ?>>Co Founder</option>
                    <option value="advisor" <?php echo e(request('role_type') == 'advisor' ? 'selected' : ''); ?>>Advisor</option>
                    <option value="core_team" <?php echo e(request('role_type') == 'core_team' ? 'selected' : ''); ?>>Core Team</option>
                    <option value="member" <?php echo e(request('role_type') == 'member' ? 'selected' : ''); ?>>Member</option>
                    <option value="lecturer" <?php echo e(request('role_type') == 'lecturer' ? 'selected' : ''); ?>>Lecturer</option>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-tob w-100"><i class="fas fa-search me-1"></i>Filter</button>
                <a href="<?php echo e(route('admin.team.index')); ?>" class="btn btn-outline-secondary w-100"><i class="fas fa-redo"></i></a>
            </div>
        </form>
    </div>
</div>
<div class="card data-card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0 align-middle">
            <thead style="background:#f8f9fa;">
                <tr><th>#</th><th>Photo</th><th>Name</th><th>Designation</th><th>Role</th><th>Status</th><th>Created By</th><th>Updated By</th><th>Actions</th></tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($members->firstItem() + $i); ?></td>
                    <td><img src="<?php echo e($member->photo_url); ?>" width="45" height="45" class="rounded-circle" onerror="this.onerror=null;this.style.opacity='0.3'"></td>
                    <td><strong><?php echo e($member->name); ?></strong></td>
                    <td><?php echo e($member->designation ?? '-'); ?></td>
                    <td><span class="badge bg-secondary"><?php echo e(str_replace('_', ' ', ucfirst($member->role_type))); ?></span></td>
                    <td>
                        <form action="<?php echo e(route('admin.team.toggle-status', $member)); ?>" method="POST" class="d-inline">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="badge <?php echo e($member->is_active ? 'bg-success' : 'bg-danger'); ?> border-0" style="cursor:pointer;">
                                <?php echo e($member->is_active ? 'Active' : 'Inactive'); ?>

                            </button>
                        </form>
                    </td>
                    <td>
                        <?php if($member->createdBy ?? false): ?><small class="text-muted"><i class="fas fa-user me-1"></i><?php echo e($member->createdBy->name); ?></small><br><?php endif; ?>
                        <small class="text-muted"><?php echo e($member->created_at->format('d M Y')); ?></small>
                    </td>
                    <td>
                        <?php if($member->updatedBy ?? false): ?><small class="text-info"><i class="fas fa-edit me-1"></i><?php echo e($member->updatedBy->name); ?></small><br><small class="text-muted"><?php echo e($member->updated_at->format('d M Y')); ?></small>
                        <?php else: ?><span class="text-muted">-</span><?php endif; ?>
                    </td>
                    <td>
                        <a href="<?php echo e(route('admin.team.edit', $member)); ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                        <form action="<?php echo e(route('admin.team.destroy', $member)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Delete?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="9" class="text-center py-4 text-muted">Koi team member nahi mila.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="card-footer"><?php echo e($members->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ROHIT RAJ\Herd\tob\resources\views/admin/team/index.blade.php ENDPATH**/ ?>