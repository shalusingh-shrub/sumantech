<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Admin - Teachers of Bihar'); ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --sidebar-width: 260px; --tob-dark: #1a2a6c; --tob-brown: #6b3a1f; }
        body { background: #f4f6f9; }
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, var(--tob-dark), #0d1a4a);
            position: fixed;
            top: 0; left: 0;
            z-index: 1000;
            overflow-y: scroll;
            overflow-x: hidden;
            scrollbar-width: thin;
            scrollbar-color: rgba(255,255,255,0.2) transparent;
        }
        .sidebar .brand {
            background: rgba(0,0,0,0.2);
            padding: 20px 15px;
            color: #fff;
            font-size: 15px;
            font-weight: 700;
        }
        .sidebar .brand small { display: block; font-weight: 300; font-size: 11px; color: rgba(255,255,255,0.7); }
        .sidebar .nav-section { padding: 8px 15px 4px; color: rgba(255,255,255,0.4); font-size: 11px; text-transform: uppercase; letter-spacing: 1px; margin-top: 10px; }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 9px 15px;
            font-size: 13.5px;
            display: flex;
            align-items: center;
            border-left: 3px solid transparent;
            transition: all 0.2s;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            color: #fff;
            background: rgba(255,255,255,0.1);
            border-left-color: #ffd700;
        }
        .sidebar .nav-link i { width: 20px; margin-right: 10px; text-align: center; }
        .main-content { margin-left: var(--sidebar-width); }
        .top-navbar {
            background: #fff;
            border-bottom: 1px solid #e0e0e0;
            padding: 12px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .top-navbar .page-title { font-size: 18px; font-weight: 700; color: var(--tob-dark); margin: 0; }
        .content-area { padding: 25px; }
        .stat-card { border: none; border-radius: 8px; padding: 20px; color: #fff; }
        .stat-card .stat-icon { font-size: 32px; opacity: 0.7; }
        .stat-card .stat-value { font-size: 28px; font-weight: 700; }
        .stat-card .stat-label { font-size: 13px; opacity: 0.9; }
        .data-card { border: none; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.07); }
        .data-card .card-header { background: linear-gradient(135deg, var(--tob-dark), var(--tob-brown)); color: #fff; border-radius: 8px 8px 0 0 !important; font-weight: 600; }
        .btn-tob { background: linear-gradient(135deg, var(--tob-dark), var(--tob-brown)); color: #fff; border: none; }
        .btn-tob:hover { opacity: 0.9; color: #fff; }
        .table th { font-size: 13px; font-weight: 600; background: #f8f9fa; }
        @media (max-width: 768px) { .sidebar { display: none; } .main-content { margin-left: 0; } }
        .sidebar { transition: transform 0.3s ease; }
        .main-content { transition: margin-left 0.3s ease; }
        .sidebar.collapsed { transform: translateX(-100%); }
        .main-content.expanded { margin-left: 0 !important; }
        .toggle-btn { background: none; border: none; font-size: 20px; color: var(--tob-dark); cursor: pointer; padding: 0 10px 0 0; }
        .toggle-btn:hover { color: var(--tob-brown); }
        .sidebar-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); z-index: 999; }
        .sidebar-overlay.active { display: block; }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <div class="brand">
        <div>ToB Admin</div>
        <small>Teachers of Bihar</small>
    </div>

    <div class="nav-section">Main</div>
    <a href="<?php echo e(route('admin.dashboard')); ?>" class="nav-link <?php echo e(request()->is('admin') ? 'active' : ''); ?>">
        <i class="fas fa-tachometer-alt"></i> Dashboard
    </a>
    <a href="<?php echo e(route('home')); ?>" target="_blank" class="nav-link">
        <i class="fas fa-globe"></i> View Website
    </a>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage_sliders')): ?>
    <div class="nav-section">Content</div>
    <a href="<?php echo e(route('admin.sliders.index')); ?>" class="nav-link <?php echo e(request()->is('admin/sliders*') ? 'active' : ''); ?>">
        <i class="fas fa-images"></i> Sliders
    </a>
    <?php endif; ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage_top_flash')): ?>
    <a href="<?php echo e(route('admin.topflash.index')); ?>" class="nav-link <?php echo e(request()->is('admin/topflash*') ? 'active' : ''); ?>">
        <i class="fas fa-bolt"></i> Top Flash
    </a>
    <?php endif; ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage_news')): ?>
    <a href="<?php echo e(route('admin.news.index')); ?>" class="nav-link <?php echo e(request()->is('admin/news*') ? 'active' : ''); ?>">
        <i class="fas fa-newspaper"></i> News & Events
    </a>
    <a href="<?php echo e(route('admin.news-categories.index')); ?>" class="nav-link <?php echo e(request()->is('admin/news-categories*') ? 'active' : ''); ?>">
        <i class="fas fa-tags"></i> News Categories
    </a>
    <?php endif; ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage_publications')): ?>
    <a href="<?php echo e(route('admin.publications.index')); ?>" class="nav-link <?php echo e(request()->is('admin/publications*') ? 'active' : ''); ?>">
        <i class="fas fa-book"></i> Publications
    </a>
    <?php endif; ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage_publications')): ?>
    <div class="nav-section">Magazine</div>
    <a href="<?php echo e(route('admin.magazines.index')); ?>" class="nav-link <?php echo e(request()->is('admin/magazines') || request()->is('admin/magazines/*') ? 'active' : ''); ?>" style="<?php echo e(request()->is('admin/magazines*') ? 'background:rgba(255,215,0,0.15);border-left-color:#ffd700;' : ''); ?>">
        <i class="fas fa-book-open"></i> Magazine
    </a>
    <a href="<?php echo e(route('admin.magazines.categories')); ?>" class="nav-link <?php echo e(request()->is('admin/magazine-categories*') ? 'active' : ''); ?>">
        <i class="fas fa-tags"></i> Mag. Categories
    </a>
    <?php endif; ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage_gallery')): ?>
    <a href="<?php echo e(route('admin.gallery.index')); ?>" class="nav-link <?php echo e(request()->is('admin/gallery*') ? 'active' : ''); ?>">
        <i class="fas fa-photo-video"></i> Gallery
    </a>
    <?php endif; ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage_team')): ?>
    <div class="nav-section">Organization</div>
    <a href="<?php echo e(route('admin.team.index')); ?>" class="nav-link <?php echo e(request()->is('admin/team*') ? 'active' : ''); ?>">
        <i class="fas fa-users"></i> Team Members
    </a>
    <?php endif; ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage_awards')): ?>
    <a href="<?php echo e(route('admin.awards.index')); ?>" class="nav-link <?php echo e(request()->is('admin/awards*') ? 'active' : ''); ?>">
        <i class="fas fa-trophy"></i> Awards
    </a>
    <?php endif; ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage_competitions')): ?>
    <a href="<?php echo e(route('admin.competitions.index')); ?>" class="nav-link <?php echo e(request()->is('admin/competitions*') ? 'active' : ''); ?>">
        <i class="fas fa-medal"></i> Competitions
    </a>
    <?php endif; ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage_testimonials')): ?>
    <a href="<?php echo e(route('admin.testimonials.index')); ?>" class="nav-link <?php echo e(request()->is('admin/testimonials*') ? 'active' : ''); ?>">
        <i class="fas fa-quote-left"></i> Testimonials
    </a>
    <?php endif; ?>

    <div class="nav-section">More Content</div>
    <a href="<?php echo e(route('admin.useful-links.index')); ?>" class="nav-link <?php echo e(request()->is('admin/useful-links*') ? 'active' : ''); ?>">
        <i class="fas fa-link"></i> Useful Links
    </a>
    <a href="<?php echo e(route('admin.good-luck-messages.index')); ?>" class="nav-link <?php echo e(request()->is('admin/good-luck-messages*') ? 'active' : ''); ?>">
        <i class="fas fa-star"></i> Good Luck Messages
    </a>
    <a href="<?php echo e(route('admin.eip-resources.index')); ?>" class="nav-link <?php echo e(request()->is('admin/eip-resources*') ? 'active' : ''); ?>">
        <i class="fas fa-graduation-cap"></i> E-Resources
    </a>
    <a href="<?php echo e(route('admin.quizzes.index')); ?>" class="nav-link <?php echo e(request()->is('admin/quizzes*') ? 'active' : ''); ?>">
        <i class="fas fa-question-circle"></i> Som Quiz
    </a>
    <a href="<?php echo e(route('admin.pages.index')); ?>" class="nav-link <?php echo e(request()->is('admin/pages*') ? 'active' : ''); ?>">
        <i class="fas fa-file-alt"></i> CMS Pages
    </a>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage_contacts')): ?>
    <div class="nav-section">Communications</div>
    <a href="<?php echo e(route('admin.contacts.index')); ?>" class="nav-link <?php echo e(request()->is('admin/contacts*') ? 'active' : ''); ?>">
        <i class="fas fa-envelope"></i> Contacts
    </a>
    <a href="<?php echo e(route('admin.suggestions.index')); ?>" class="nav-link <?php echo e(request()->is('admin/suggestions*') ? 'active' : ''); ?>">
        <i class="fas fa-inbox"></i> Suggestions
    </a>
    <a href="<?php echo e(route('admin.opinions.index')); ?>" class="nav-link <?php echo e(request()->is('admin/opinions*') ? 'active' : ''); ?>">
        <i class="fas fa-comment-dots"></i> Opinions
    </a>
    <?php endif; ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage_users')): ?>
    <div class="nav-section">Administration</div>
    <a href="<?php echo e(route('admin.users.index')); ?>" class="nav-link <?php echo e(request()->is('admin/users*') ? 'active' : ''); ?>">
        <i class="fas fa-user-cog"></i> Users & Roles
    </a>
    <a href="<?php echo e(route('admin.registered-users.index')); ?>" class="nav-link <?php echo e(request()->is('admin/registered-users*') ? 'active' : ''); ?>">
        <i class="fas fa-user-plus"></i> Registered Users
    </a>
    <?php endif; ?>

    <div class="nav-section">Account</div>
    <form method="POST" action="<?php echo e(route('logout')); ?>">
        <?php echo csrf_field(); ?>
        <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start">
            <i class="fas fa-sign-out-alt"></i> Logout
        </button>
    </form>
</div>

<!-- Main Content -->
<div class="main-content">
    <div class="top-navbar">
        <div class="d-flex align-items-center">
            <button class="toggle-btn" id="sidebarToggle"><i class="fas fa-bars"></i></button>
            <h5 class="page-title"><?php echo $__env->yieldContent("page-title", "Dashboard"); ?></h5>
        </div>
        <div class="d-flex align-items-center gap-3">
            <span class="text-muted" style="font-size:13px;"><i class="fas fa-user-circle me-1"></i><?php echo e(auth()->user()->name); ?></span>
            <span class="badge bg-primary" style="font-size:11px;"><?php echo e(auth()->user()->getRoleNames()->first()); ?></span>
        </div>
    </div>

    <div class="content-area">
        <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i><?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>
        <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle me-2"></i><?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <?php echo $__env->yieldContent('content'); ?>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php echo $__env->yieldPushContent("scripts"); ?>
<div class="sidebar-overlay" id="sidebarOverlay"></div>
<script>
document.getElementById("sidebarToggle").addEventListener("click", function() {
    var sidebar = document.querySelector(".sidebar");
    var mainContent = document.querySelector(".main-content");
    var overlay = document.getElementById("sidebarOverlay");
    sidebar.classList.toggle("collapsed");
    mainContent.classList.toggle("expanded");
    overlay.classList.toggle("active");
});
document.getElementById("sidebarOverlay").addEventListener("click", function() {
    document.querySelector(".sidebar").classList.remove("collapsed");
    document.querySelector(".main-content").classList.remove("expanded");
    this.classList.remove("active");
});
</script>
</body>
</html>
<?php /**PATH C:\Users\ROHIT RAJ\Herd\tob\resources\views/layouts/admin.blade.php ENDPATH**/ ?>