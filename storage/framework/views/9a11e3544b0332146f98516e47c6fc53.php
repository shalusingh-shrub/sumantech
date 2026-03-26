


<?php $__env->startSection('title', 'Our Team - Teachers of Bihar'); ?>

<?php $__env->startSection('content'); ?>

<!-- Page Banner -->
<div class="page-banner">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h1>Our Team</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo e(route('about')); ?>">About Us</a></li>
                    <li class="breadcrumb-item active">Our Team</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="container py-5">

    <!-- FOUNDER -->
    <?php if($founders->count() > 0): ?>
    <div class="text-center mb-4">
        <h2 class="section-title-bar d-inline-block px-5"><strong>FOUNDER</strong></h2>
    </div>
    <div class="row g-4 justify-content-center mb-5">
        <?php $__currentLoopData = $founders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-md-3">
            <div class="card team-card" onclick="showMemberDetail(<?php echo e($member->id); ?>)">
                <img src="<?php echo e($member->photo_url); ?>" alt="<?php echo e($member->name); ?>" class="team-photo" onerror="this.onerror=null;this.style.opacity='0.3'">
                <div class="team-name"><?php echo e($member->name); ?></div>
                <div class="team-designation"><?php echo e($member->designation); ?></div>
                <div class="team-dept"><?php echo e($member->department); ?></div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php endif; ?>

    <!-- CO-FOUNDER -->
    <?php if($coFounders->count() > 0): ?>
    <div class="text-center mb-4">
        <h2 class="section-title-bar d-inline-block px-5"><strong>CO-FOUNDER</strong></h2>
    </div>
    <div class="row g-4 justify-content-center mb-5">
        <?php $__currentLoopData = $coFounders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-md-3">
            <div class="card team-card" onclick="showMemberDetail(<?php echo e($member->id); ?>)">
                <img src="<?php echo e($member->photo_url); ?>" alt="<?php echo e($member->name); ?>" class="team-photo" onerror="this.onerror=null;this.style.opacity='0.3'">
                <div class="team-name"><?php echo e($member->name); ?></div>
                <div class="team-designation"><?php echo e($member->designation); ?></div>
                <div class="team-dept"><?php echo e($member->department); ?></div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php endif; ?>

    <!-- ADVISORS -->
    <?php if($advisors->count() > 0): ?>
    <div class="text-center mb-4">
        <h2 class="section-title-bar d-inline-block px-5"><strong>ADVISORS</strong></h2>
    </div>
    <div class="row g-4 justify-content-center mb-5">
        <?php $__currentLoopData = $advisors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-md-3">
            <div class="card team-card" onclick="showMemberDetail(<?php echo e($member->id); ?>)">
                <img src="<?php echo e($member->photo_url); ?>" alt="<?php echo e($member->name); ?>" class="team-photo" onerror="this.onerror=null;this.style.opacity='0.3'">
                <div class="team-name"><?php echo e($member->name); ?></div>
                <div class="team-designation"><?php echo e($member->designation); ?></div>
                <div class="team-dept"><?php echo e($member->department); ?></div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php endif; ?>

    <!-- CORE TEAM -->
    <?php if($coreTeam->count() > 0): ?>
    <div class="text-center mb-4">
        <h2 class="section-title-bar d-inline-block px-5"><strong>CORE TEAM</strong></h2>
    </div>
    <div class="row g-4 justify-content-center mb-5">
        <?php $__currentLoopData = $coreTeam; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-md-3 col-sm-4 col-6">
            <div class="card team-card" onclick="showMemberDetail(<?php echo e($member->id); ?>)">
                <img src="<?php echo e($member->photo_url); ?>" alt="<?php echo e($member->name); ?>" class="team-photo" onerror="this.onerror=null;this.style.opacity='0.3'">
                <div class="team-name"><?php echo e($member->name); ?></div>
                <div class="team-designation"><?php echo e($member->designation); ?></div>
                <div class="team-dept"><?php echo e($member->department); ?></div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php endif; ?>

    <!-- LECTURERS -->
    <?php if($lecturers->count() > 0): ?>
    <div class="text-center mb-4">
        <h2 class="section-title-bar d-inline-block px-5"><strong>LECTURERS</strong></h2>
    </div>
    <div class="row g-4 justify-content-center mb-5">
        <?php $__currentLoopData = $lecturers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-md-2 col-sm-3 col-4">
            <div class="card team-card p-3" onclick="showMemberDetail(<?php echo e($member->id); ?>)">
                <img src="<?php echo e($member->photo_url); ?>" alt="<?php echo e($member->name); ?>" class="team-photo" style="width:90px;height:90px;" onerror="this.onerror=null;this.style.opacity='0.3'">
                <div class="team-name" style="font-size:14px;"><?php echo e($member->name); ?></div>
                <div class="team-designation" style="font-size:12px;"><?php echo e($member->designation); ?></div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php endif; ?>

    <!-- MEMBERS -->
    <?php if($members->count() > 0): ?>
    <div class="text-center mb-4">
        <h2 class="section-title-bar d-inline-block px-5"><strong>MEMBERS</strong></h2>
    </div>
    <div class="row g-4 justify-content-center mb-5">
        <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-md-2 col-sm-3 col-4">
            <div class="card team-card p-3" onclick="showMemberDetail(<?php echo e($member->id); ?>)">
                <img src="<?php echo e($member->photo_url); ?>" alt="<?php echo e($member->name); ?>" class="team-photo" style="width:90px;height:90px;" onerror="this.onerror=null;this.style.opacity='0.3'">
                <div class="team-name" style="font-size:14px;"><?php echo e($member->name); ?></div>
                <div class="team-designation" style="font-size:12px;"><?php echo e($member->designation); ?></div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php endif; ?>

    <?php if($founders->count() === 0 && $coFounders->count() === 0 && $coreTeam->count() === 0 && $members->count() === 0): ?>
    <div class="text-center py-5 text-muted">
        <i class="fas fa-users fa-3x mb-3"></i>
        <p>No team members found. Add members from the admin panel.</p>
    </div>
    <?php endif; ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ROHIT RAJ\Herd\tob\resources\views/frontend/team.blade.php ENDPATH**/ ?>