

<?php $__env->startSection('page-title', 'Edit News'); ?>
<?php $__env->startPush('styles'); ?>
<style>
    .sidebar-card { border: 1px solid #dee2e6; border-radius: 8px; padding: 20px; margin-bottom: 16px; }
    .sidebar-card h6 { font-weight: 700; margin-bottom: 14px; font-size: 15px; }
    .publish-btn { background: #2d8c4e; color: #fff; border: none; border-radius: 6px; width: 100%; padding: 10px; font-size: 15px; font-weight: 600; cursor: pointer; }
    .publish-btn:hover { background: #256e3e; }
    .slug-hint { font-size: 12px; color: #888; margin-top: 4px; }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between mb-4">
    <h5 class="fw-bold">Edit News</h5>
    <a href="<?php echo e(route('admin.news.index')); ?>" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-2"></i>Back</a>
</div>
<?php if($errors->any()): ?>
<div class="alert alert-danger"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><p class="mb-0"><?php echo e($error); ?></p><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></div>
<?php endif; ?>
<form action="<?php echo e(route('admin.news.update', $news)); ?>" method="POST" enctype="multipart/form-data">
    <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm p-4 mb-3">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" id="titleInput" class="form-control" placeholder="Enter title" value="<?php echo e(old('title', $news->title)); ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Slug</label>
                    <input type="text" name="slug" id="slugInput" class="form-control" value="<?php echo e(old('slug', $news->slug)); ?>">
                    <div class="form-check mt-1">
                        <input type="checkbox" name="auto_slug" id="autoSlug" class="form-check-input" value="1">
                        <label for="autoSlug" class="form-check-label" style="font-size:13px;">Auto-generate slug from title (you can uncheck for manual slug)</label>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Category</label>
                    <div class="input-group">
                        <select name="news_category_id" class="form-select">
                            <option value="">-- Select Category --</option>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($cat->id); ?>" <?php echo e(old('news_category_id', $news->news_category_id) == $cat->id ? 'selected' : ''); ?>>
                                    <?php echo e($cat->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <a href="<?php echo e(route('admin.news-categories.index')); ?>" class="btn btn-outline-secondary" title="Manage Categories" target="_blank">
                            <i class="fas fa-cog"></i> Manage
                        </a>
                    </div>
                    <small class="text-muted">Nayi category banana ho toh <a href="<?php echo e(route('admin.news-categories.index')); ?>" target="_blank">yahan click karo</a></small>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Content <span class="text-danger">*</span></label>
                    <textarea name="content" id="contentEditor"><?php echo e(old('content', $news->content)); ?></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Excerpt</label>
                    <textarea name="excerpt" class="form-control" rows="3"><?php echo e(old('excerpt', $news->excerpt)); ?></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Meta Title</label>
                    <input type="text" name="meta_title" class="form-control" value="<?php echo e(old('meta_title', $news->meta_title)); ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Meta Description</label>
                    <textarea name="meta_description" class="form-control" rows="3"><?php echo e(old('meta_description', $news->meta_description)); ?></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Meta Keywords</label>
                    <input type="text" name="meta_keywords" class="form-control" value="<?php echo e(old('meta_keywords', $news->meta_keywords)); ?>">
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="sidebar-card">
                <h6>Publish</h6>
                <label class="form-label fw-semibold mb-1">Status</label>
                <div class="d-flex gap-3 mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="statusActive" value="active" <?php echo e($news->is_published ? 'checked' : ''); ?>>
                        <label class="form-check-label" for="statusActive">Active</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="statusInactive" value="inactive" <?php echo e(!$news->is_published ? 'checked' : ''); ?>>
                        <label class="form-check-label" for="statusInactive">Inactive</label>
                    </div>
                </div>
                <label class="form-label fw-semibold mb-1">Publish Date</label>
                <input type="date" name="publish_date" class="form-control mb-3" value="<?php echo e(old('publish_date', $news->publish_date?->format('Y-m-d') ?? date('Y-m-d'))); ?>">
                <button type="submit" class="publish-btn">Update</button>
            </div>
            <div class="sidebar-card">
                <h6>News Type</h6>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="radio" name="news_type" id="typeNews" value="news" <?php echo e($news->category === 'news' ? 'checked' : ''); ?>>
                    <label class="form-check-label" for="typeNews">News</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="news_type" id="typeEvent" value="event" <?php echo e($news->category === 'event' ? 'checked' : ''); ?>>
                    <label class="form-check-label" for="typeEvent">Event</label>
                </div>
                <div id="eventDateWrap" class="mt-3" style="<?php echo e($news->category === 'event' ? '' : 'display:none;'); ?>">
                    <label class="form-label fw-semibold">Event Date</label>
                    <input type="date" name="event_date" class="form-control" value="<?php echo e(old('event_date', $news->event_date?->format('Y-m-d'))); ?>">
                </div>
            </div>
            <div class="sidebar-card">
                <h6>Pin to Home</h6>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="radio" name="pin_to_home" id="pinYes" value="yes" <?php echo e($news->pin_to_home ? 'checked' : ''); ?>>
                    <label class="form-check-label" for="pinYes">Yes</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="pin_to_home" id="pinNo" value="no" <?php echo e(!$news->pin_to_home ? 'checked' : ''); ?>>
                    <label class="form-check-label" for="pinNo">No</label>
                </div>
            </div>
            <div class="sidebar-card">
                <h6>Featured Image</h6>
                <?php if($news->image): ?>
                    <img src="<?php echo e($news->image_url); ?>" class="img-fluid rounded mb-2" style="max-height:120px;" onerror="this.style.display='none'">
                <?php endif; ?>
                <input type="file" name="image" class="form-control mb-2" accept="image/*" id="imageInput">
                <small class="text-muted">Recommended size: 800x400 px (JPG/PNG/WebP)</small>
                <img id="imagePreview" src="" class="img-fluid rounded mt-2" style="display:none; max-height:150px;">
            </div>
        </div>
    </div>
</form>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
<script>
CKEDITOR.replace('contentEditor', {
    height: 350,
    toolbar: [
        { name: 'document', items: ['Source'] },
        { name: 'clipboard', items: ['Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo'] },
        { name: 'basicstyles', items: ['Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat'] },
        { name: 'paragraph', items: ['NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'] },
        { name: 'links', items: ['Link','Unlink'] },
        { name: 'insert', items: ['Image','Table','HorizontalRule','SpecialChar'] },
        { name: 'styles', items: ['Styles','Format','Font','FontSize'] },
        { name: 'colors', items: ['TextColor','BGColor'] },
        { name: 'tools', items: ['Maximize'] }
    ],
    filebrowserUploadUrl: '',
    removePlugins: 'exportpdf'
});

document.getElementById('titleInput').addEventListener('keyup', function() {
    if (document.getElementById('autoSlug').checked) {
        var slug = this.value.toLowerCase().replace(/[^a-z0-9\s-]/g,'').replace(/\s+/g,'-').replace(/-+/g,'-');
        document.getElementById('slugInput').value = slug;
    }
});
document.querySelectorAll('input[name="news_type"]').forEach(function(el) {
    el.addEventListener('change', function() {
        document.getElementById('eventDateWrap').style.display = this.value === 'event' ? 'block' : 'none';
    });
});
document.getElementById('imageInput').addEventListener('change', function() {
    var file = this.files[0];
    if (file) {
        var reader = new FileReader();
        reader.onload = function(e) {
            var preview = document.getElementById('imagePreview');
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ROHIT RAJ\Herd\tob\resources\views/admin/news/edit.blade.php ENDPATH**/ ?>