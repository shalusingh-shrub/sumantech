

<?php $__env->startSection('page-title', 'News & Events'); ?>
<?php $__env->startSection('content'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0"><i class="fas fa-newspaper me-2 text-primary"></i>News & Events</h5>
    <a href="<?php echo e(route('admin.news.create')); ?>" class="btn btn-tob"><i class="fas fa-plus me-2"></i>Add News/Event</a>
</div>

<div class="card data-card mb-3">
    <div class="card-body py-3">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-5">
                <label class="form-label fw-semibold mb-1">Search</label>
                <input type="text" name="search" class="form-control" placeholder="Title ya slug se search karein..." value="<?php echo e(request('search')); ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold mb-1">Type</label>
                <select name="type" class="form-select">
                    <option value="">All</option>
                    <option value="news" <?php echo e(request('type') == 'news' ? 'selected' : ''); ?>>News</option>
                    <option value="event" <?php echo e(request('type') == 'event' ? 'selected' : ''); ?>>Event</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold mb-1">Status</label>
                <select name="status" class="form-select">
                    <option value="">All</option>
                    <option value="1" <?php echo e(request('status') == '1' ? 'selected' : ''); ?>>Published</option>
                    <option value="0" <?php echo e(request('status') == '0' ? 'selected' : ''); ?>>Draft</option>
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-tob w-100"><i class="fas fa-search me-1"></i>Filter</button>
                <a href="<?php echo e(route('admin.news.index')); ?>" class="btn btn-outline-secondary w-100"><i class="fas fa-redo"></i></a>
            </div>
        </form>
    </div>
</div>

<div class="card data-card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0 align-middle">
            <thead style="background:#f8f9fa;">
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Created By</th>
                    <th>Updated By</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $news; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($news->firstItem() + $i); ?></td>
                    <td>
                        <strong><?php echo e(Str::limit($item->title, 50)); ?></strong><br>
                        <small class="text-muted"><?php echo e(Str::limit($item->slug, 40)); ?></small>
                    </td>
                    <td><span class="badge <?php echo e($item->category === 'event' ? 'bg-warning text-dark' : 'bg-success'); ?>"><?php echo e(ucfirst($item->category)); ?></span></td>
                    <td><span class="badge <?php echo e($item->is_published ? 'bg-success' : 'bg-secondary'); ?>"><?php echo e($item->is_published ? 'Published' : 'Draft'); ?></span></td>
                    <td>
                        <?php if($item->createdBy ?? false): ?>
                            <small class="text-muted"><i class="fas fa-user me-1"></i><?php echo e($item->createdBy->name); ?></small><br>
                        <?php endif; ?>
                        <small class="text-muted"><?php echo e($item->created_at->format('d M Y')); ?></small>
                    </td>
                    <td>
                        <?php if($item->updatedBy ?? false): ?>
                            <small class="text-info"><i class="fas fa-edit me-1"></i><?php echo e($item->updatedBy->name); ?></small><br>
                            <small class="text-muted"><?php echo e($item->updated_at->format('d M Y')); ?></small>
                        <?php else: ?>
                            <span class="text-muted">-</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?php echo e(route('admin.news.edit', $item)); ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                        <form action="<?php echo e(route('admin.news.destroy', $item)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Delete karna chahte ho?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="7" class="text-center py-4 text-muted">Koi news/event nahi mila.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="card-footer"><?php echo e($news->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ROHIT RAJ\Herd\tob\resources\views/admin/news/index.blade.php ENDPATH**/ ?>