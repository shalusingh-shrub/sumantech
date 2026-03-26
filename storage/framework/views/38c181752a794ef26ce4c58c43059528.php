

<?php $__env->startSection('title', 'Dashboard - Admin'); ?>
<?php $__env->startSection('page-title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<!-- Stats -->
<div class="row g-4 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card" style="background:linear-gradient(135deg,#1a2a6c,#2980b9);">
            <div class="d-flex justify-content-between">
                <div>
                    <div class="stat-value"><?php echo e($stats['users']); ?></div>
                    <div class="stat-label">Total Users</div>
                </div>
                <div class="stat-icon"><i class="fas fa-users"></i></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card" style="background:linear-gradient(135deg,#2d8c4e,#27ae60);">
            <div class="d-flex justify-content-between">
                <div>
                    <div class="stat-value"><?php echo e($stats['team_members']); ?></div>
                    <div class="stat-label">Team Members</div>
                </div>
                <div class="stat-icon"><i class="fas fa-user-tie"></i></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card" style="background:linear-gradient(135deg,#c0392b,#e74c3c);">
            <div class="d-flex justify-content-between">
                <div>
                    <div class="stat-value"><?php echo e($stats['news']); ?></div>
                    <div class="stat-label">News & Events</div>
                </div>
                <div class="stat-icon"><i class="fas fa-newspaper"></i></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card" style="background:linear-gradient(135deg,#6b3a1f,#e67e22);">
            <div class="d-flex justify-content-between">
                <div>
                    <div class="stat-value"><?php echo e($stats['publications']); ?></div>
                    <div class="stat-label">Publications</div>
                </div>
                <div class="stat-icon"><i class="fas fa-book"></i></div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm p-3">
            <div class="d-flex align-items-center">
                <div class="p-3 rounded me-3" style="background:#fff3cd;"><i class="fas fa-envelope text-warning fa-lg"></i></div>
                <div>
                    <div class="fw-bold fs-5"><?php echo e($stats['contacts']); ?></div>
                    <small class="text-muted">Unread Contacts</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm p-3">
            <div class="d-flex align-items-center">
                <div class="p-3 rounded me-3" style="background:#d4edda;"><i class="fas fa-inbox text-success fa-lg"></i></div>
                <div>
                    <div class="fw-bold fs-5"><?php echo e($stats['suggestions']); ?></div>
                    <small class="text-muted">Suggestions</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm p-3">
            <div class="d-flex align-items-center">
                <div class="p-3 rounded me-3" style="background:#cce5ff;"><i class="fas fa-comment text-primary fa-lg"></i></div>
                <div>
                    <div class="fw-bold fs-5"><?php echo e($stats['opinions']); ?></div>
                    <small class="text-muted">Pending Opinions</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm p-3">
            <div class="d-flex align-items-center">
                <div class="p-3 rounded me-3" style="background:#f8d7da;"><i class="fas fa-images text-danger fa-lg"></i></div>
                <div>
                    <div class="fw-bold fs-5"><?php echo e($stats['gallery']); ?></div>
                    <small class="text-muted">Gallery Items</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card data-card">
            <div class="card-header">Quick Actions</div>
            <div class="card-body">
                <a href="<?php echo e(route('admin.news.create')); ?>" class="btn btn-sm btn-tob mb-2 w-100"><i class="fas fa-plus me-2"></i>Add News/Event</a>
                <a href="<?php echo e(route('admin.team.create')); ?>" class="btn btn-sm btn-outline-primary mb-2 w-100"><i class="fas fa-user-plus me-2"></i>Add Team Member</a>
                <a href="<?php echo e(route('admin.publications.create')); ?>" class="btn btn-sm btn-outline-success mb-2 w-100"><i class="fas fa-book me-2"></i>Add Publication</a>
                <a href="<?php echo e(route('admin.sliders.create')); ?>" class="btn btn-sm btn-outline-warning w-100"><i class="fas fa-image me-2"></i>Add Slider</a>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card data-card">
            <div class="card-header">Recent Contacts</div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead><tr><th>Name</th><th>Email</th><th>Subject</th><th>Time</th><th></th></tr></thead>
                    <tbody>
                        <?php $__currentLoopData = $recentContacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($contact->name); ?></td>
                            <td><?php echo e($contact->email); ?></td>
                            <td><?php echo e(Str::limit($contact->subject, 30)); ?></td>
                            <td><small><?php echo e($contact->created_at->diffForHumans()); ?></small></td>
                            <td><a href="<?php echo e(route('admin.contacts.show', $contact)); ?>" class="btn btn-xs btn-sm btn-outline-primary" style="font-size:11px;">View</a></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php if($recentContacts->isEmpty()): ?>
                        <tr><td colspan="5" class="text-center text-muted py-3">No contacts yet.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ROHIT RAJ\Herd\tob\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>