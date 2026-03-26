


<?php $__env->startSection('title', 'Teachers of Bihar - The Change Makers'); ?>

<?php $__env->startSection('content'); ?>

<!-- Hero Slider -->
<section class="hero-slider">
    <div class="owl-carousel owl-theme" id="heroCarousel">
        <?php $__empty_1 = true; $__currentLoopData = $sliders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="item position-relative">
            <img src="<?php echo e($slider->image_url); ?>" alt="<?php echo e($slider->title); ?>" class="w-100" style="max-height:480px;object-fit:cover;" onerror="this.onerror=null;this.style.opacity='0.3'">
            <?php if($slider->title || $slider->link): ?>
            <div class="slide-caption">
                <?php if($slider->title): ?><h5 class="mb-1 hindi-text" style="color:#fff;"><?php echo e($slider->title); ?></h5><?php endif; ?>
                <?php if($slider->link): ?><a href="<?php echo e($slider->link); ?>">Click Here To Read</a><?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        
        <?php endif; ?>
    </div>
</section>

<!-- About Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-7">
                <div class="section-title">Welcome to Teachers of Bihar</div>
                <p>Teachers of Bihar (ToB) is a voluntary organization of government school teachers of Bihar. It was established with the aim to improve the quality of education in Bihar and to empower teachers with resources, training, and community support.</p>
                <p class="hindi-text">हम बिहार के सरकारी विद्यालय के शिक्षकों का एक स्वैच्छिक संगठन हैं जो शिक्षा की गुणवत्ता में सुधार के लिए कार्यरत हैं।</p>
                <a href="<?php echo e(route('about')); ?>" class="btn btn-success me-2">Learn More</a>
                <a href="<?php echo e(route('team')); ?>" class="btn btn-outline-primary">Our Team</a>
            </div>
            <div class="col-md-5 mt-4 mt-md-0">
                <div class="row g-3">
                    <div class="col-6">
                        <div class="p-3 bg-white rounded shadow-sm text-center">
                            <i class="fas fa-chalkboard-teacher fa-2x text-success mb-2"></i>
                            <h5 class="mb-0 fw-bold">5000+</h5>
                            <small class="text-muted">Active Teachers</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 bg-white rounded shadow-sm text-center">
                            <i class="fas fa-book fa-2x text-primary mb-2"></i>
                            <h5 class="mb-0 fw-bold">50+</h5>
                            <small class="text-muted">Publications</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 bg-white rounded shadow-sm text-center">
                            <i class="fas fa-map-marker-alt fa-2x text-danger mb-2"></i>
                            <h5 class="mb-0 fw-bold">38</h5>
                            <small class="text-muted">Districts</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 bg-white rounded shadow-sm text-center">
                            <i class="fas fa-award fa-2x text-warning mb-2"></i>
                            <h5 class="mb-0 fw-bold">10+</h5>
                            <small class="text-muted">Awards</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our Ideas Section -->
<section class="py-5">
    <div class="container">
        <div class="section-title">Our Ideas</div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="mb-3"><i class="fas fa-school fa-3x text-success"></i></div>
                        <h5 class="fw-bold">Bagless Saturday</h5>
                        <p class="text-muted">Every Saturday students come to school without bags, engaging in fun, activity-based learning.</p>
                        <a href="<?php echo e(route('bagless-saturday')); ?>" class="btn btn-outline-success btn-sm">Know More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="mb-3"><i class="fas fa-comments fa-3x text-primary"></i></div>
                        <h5 class="fw-bold">Let's Talk</h5>
                        <p class="text-muted">An interactive program where teachers and students discuss topics related to education and life.</p>
                        <a href="<?php echo e(route('lets-talk')); ?>" class="btn btn-outline-primary btn-sm">Know More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="mb-3"><i class="fas fa-headphones fa-3x text-danger"></i></div>
                        <h5 class="fw-bold hindi-text">शिक्षा श्रुति</h5>
                        <p class="text-muted">Audio-based educational content and podcast for teachers and students in Bihar.</p>
                        <a href="<?php echo e(route('shiksha-shriti')); ?>" class="btn btn-outline-danger btn-sm">Know More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Latest News & Events -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="section-title mb-0">Latest News & Events</div>
            <a href="<?php echo e(route('news-events')); ?>" class="btn btn-sm btn-outline-primary">View All</a>
        </div>
        <div class="row g-4">
            <?php $__empty_1 = true; $__currentLoopData = $latestNews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col-md-4">
                <div class="card news-card">
                    <img src="<?php echo e($item->image_url); ?>" alt="<?php echo e($item->title); ?>" class="card-img-top" style="height:180px;object-fit:cover;" onerror="this.onerror=null;this.style.opacity='0.3'">
                    <div class="card-body">
                        <span class="badge <?php echo e($item->category === 'event' ? 'bg-warning text-dark' : 'bg-success'); ?> mb-2"><?php echo e(ucfirst($item->category)); ?></span>
                        <h6 class="card-title fw-bold"><?php echo e(Str::limit($item->title, 70)); ?></h6>
                        <p class="card-text text-muted small"><?php echo e(Str::limit($item->short_description, 100)); ?></p>
                        <a href="<?php echo e(route('news.show', $item->slug)); ?>" class="btn btn-sm btn-outline-primary">Read More</a>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-12 text-center text-muted">No news available.</div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Latest Publications -->
<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="section-title mb-0">Latest Publications</div>
            <a href="<?php echo e(route('emagazine')); ?>" class="btn btn-sm btn-outline-primary">View All</a>
        </div>
        <div class="row g-3">
            <?php $__empty_1 = true; $__currentLoopData = $latestPublications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col-6 col-md-3">
                <div class="card pub-card">
                    <img src="<?php echo e($pub->image_url); ?>" alt="<?php echo e($pub->title); ?>" class="card-img-top" style="height:180px;object-fit:cover;" onerror="this.onerror=null;this.style.opacity='0.3'">
                    <div class="card-body p-2">
                        <p class="mb-1 small fw-bold hindi-text"><?php echo e(Str::limit($pub->title, 40)); ?></p>
                        <small class="text-muted">Issue: <?php echo e($pub->issue_number ?? 'N/A'); ?></small>
                        <br>
                        <a href="<?php echo e(route('publication.show', $pub->slug)); ?>" class="btn btn-sm btn-success mt-2 w-100">View</a>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-12 text-center text-muted">No publications available.</div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Testimonials -->
<?php if($testimonials->count() > 0): ?>
<section class="py-5 bg-light">
    <div class="container">
        <div class="section-title">What Teachers Say</div>
        <div class="row g-4">
            <?php $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testimonial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-4">
                <div class="testimonial-card h-100">
                    <div class="stars mb-2">
                        <?php for($i = 1; $i <= 5; $i++): ?>
                            <i class="fas fa-star<?php echo e($i <= $testimonial->rating ? '' : '-o'); ?>"></i>
                        <?php endfor; ?>
                    </div>
                    <p class="mb-3">"<?php echo e($testimonial->content); ?>"</p>
                    <div class="d-flex align-items-center">
                        <img src="<?php echo e($testimonial->photo_url); ?>" alt="<?php echo e($testimonial->name); ?>" width="45" height="45" class="rounded-circle me-3" onerror="this.onerror=null;this.style.opacity='0.3'">
                        <div>
                            <strong><?php echo e($testimonial->name); ?></strong><br>
                            <small class="text-muted"><?php echo e($testimonial->designation); ?> - <?php echo e($testimonial->organization); ?></small>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <div class="text-center mt-4">
            <a href="<?php echo e(route('testimonials')); ?>" class="btn btn-outline-success">View All Testimonials</a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Project Shikshak Sathi Banner -->
<section class="py-4" style="background:linear-gradient(135deg,#1a2a6c,#6b3a1f);color:#fff;">
    <div class="container text-center">
        <h3 class="mb-2">Project Shikshak Sathi</h3>
        <p class="mb-3">A mentorship program connecting experienced and new teachers for professional growth.</p>
        <a href="<?php echo e(route('project-shikshak-sathi')); ?>" class="btn btn-warning btn-lg">Know More</a>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
$(document).ready(function() {
    $('#heroCarousel').owlCarousel({
        items: 1,
        loop: true,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        nav: true,
        dots: true,
        navText: ['<i class="fas fa-chevron-left"></i>', '<i class="fas fa-chevron-right"></i>'],
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ROHIT RAJ\Herd\tob\resources\views/frontend/home.blade.php ENDPATH**/ ?>