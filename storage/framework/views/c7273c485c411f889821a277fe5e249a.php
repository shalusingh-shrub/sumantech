

<?php $__env->startSection('title', 'About Us - Teachers of Bihar'); ?>
<?php $__env->startSection('content'); ?>
<div class="page-banner">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h1>About Teachers of Bihar</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Home</a></li>
                    <li class="breadcrumb-item active">About Us</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="container py-5">
    <div class="row">
        <div class="col-md-8">
            <h2 class="section-title">About Teachers of Bihar (ToB)</h2>
            <p>Teachers of Bihar (ToB) is a voluntary organization of government school teachers of Bihar. It was established in 2016 with the aim to improve the quality of education in Bihar and to empower teachers with resources, training, and community support.</p>
            <p>ToB works with teachers to enhance their professional skills, share best practices, and create innovative teaching materials. The organization has been instrumental in bringing positive changes in Bihar's education system.</p>
            <h4 class="mt-4 mb-3" style="color:#1a2a6c;">Our Mission</h4>
            <p>To empower teachers with resources, training and community support to deliver quality education to every child in Bihar.</p>
            <h4 class="mt-4 mb-3" style="color:#1a2a6c;">Our Vision</h4>
            <p>A Bihar where every child has access to quality education delivered by motivated and skilled teachers.</p>
            <h4 class="mt-4 mb-3" style="color:#1a2a6c;">Our Values</h4>
            <ul>
                <li>Dedication to quality education</li>
                <li>Collaboration and community building</li>
                <li>Innovation in teaching practices</li>
                <li>Empowerment of teachers</li>
                <li>Inclusive education for all</li>
            </ul>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-4 mb-4">
                <h5 style="color:#1a2a6c;">Quick Facts</h5>
                <ul class="list-unstyled">
                    <li class="py-2 border-bottom"><i class="fas fa-calendar me-2 text-success"></i>Founded: 2016</li>
                    <li class="py-2 border-bottom"><i class="fas fa-users me-2 text-primary"></i>Members: 5000+</li>
                    <li class="py-2 border-bottom"><i class="fas fa-map-marker-alt me-2 text-danger"></i>Districts: 38</li>
                    <li class="py-2 border-bottom"><i class="fas fa-book me-2 text-warning"></i>Publications: 50+</li>
                    <li class="py-2"><i class="fas fa-award me-2 text-info"></i>Awards: 10+</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ROHIT RAJ\Herd\tob\resources\views/frontend/about.blade.php ENDPATH**/ ?>