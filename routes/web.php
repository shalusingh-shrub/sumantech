<?php
// File: routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TeamMemberController;
use App\Http\Controllers\Admin\NewsEventController;
use App\Http\Controllers\Admin\NewsCategoryController;
use App\Http\Controllers\Admin\MagazineController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\PublicationController as AdminPublicationController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\TopFlashController;
use App\Http\Controllers\Admin\AwardController;
use App\Http\Controllers\Admin\CompetitionController;
use App\Http\Controllers\Admin\OpinionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\UsefulLinkController;
use App\Http\Controllers\Admin\GoodLuckMessageController;
use App\Http\Controllers\Admin\EipResourceController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\QuizController;

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/courses', [App\Http\Controllers\HomeController::class, 'courses'])->name('courses');
Route::get('/courses/{id}', [App\Http\Controllers\HomeController::class, 'courseShow'])->name('course.show');
Route::get('/about-us', [HomeController::class, 'about'])->name('about');
Route::get('/team', [HomeController::class, 'team'])->name('team');
Route::get('/team/member/{id}', [HomeController::class, 'teamMemberDetail'])->name('team.member.detail');

// Ideas
Route::get('/bagless-saturday', [HomeController::class, 'baglessSaturday'])->name('bagless-saturday');
Route::get('/lets-talk', [HomeController::class, 'letsTalk'])->name('lets-talk');
Route::get('/shiksha-shriti', [HomeController::class, 'shiksaShruti'])->name('shiksha-shriti');
Route::get('/podcast', [HomeController::class, 'podcast'])->name('podcast');

// Publications
Route::get('/science-corner', [PublicationController::class, 'scienceCorner'])->name('science-corner');
Route::get('/tlm', [PublicationController::class, 'tlm'])->name('tlm');
Route::get('/anusandhaanam', [PublicationController::class, 'anusandhaanam'])->name('anusandhaanam');
Route::get('/abhimat', [PublicationController::class, 'abhimat'])->name('abhimat');
Route::get('/emagazine', [PublicationController::class, 'emagazine'])->name('emagazine');
Route::get('/karmana', [PublicationController::class, 'karmana'])->name('karmana');
Route::get('/balman', [PublicationController::class, 'balman'])->name('balman');
Route::get('/suvichar', [PublicationController::class, 'suvichar'])->name('suvichar');
Route::get('/eresources', [PublicationController::class, 'eresources'])->name('eresources');
Route::get('/publication/{slug}', [PublicationController::class, 'show'])->name('publication.show');

// News & Events
Route::get('/news-events', [NewsController::class, 'index'])->name('news-events');
Route::get('/news-events/{slug}', [NewsController::class, 'show'])->name('news.show');

// Gallery
Route::get('/image-gallery', [GalleryController::class, 'imageGallery'])->name('image-gallery');
Route::get('/video-gallery', [GalleryController::class, 'videoGallery'])->name('video-gallery');
Route::get('/image-gallery/media', [GalleryController::class, 'media'])->name('media');

// Other pages
Route::get('/project-shikshak-sathi', [HomeController::class, 'projectShikshakSathi'])->name('project-shikshak-sathi');
Route::get('/eip', [HomeController::class, 'eip'])->name('eip');
Route::get('/competition', [HomeController::class, 'competition'])->name('competition');
Route::get('/competition/{slug}', [HomeController::class, 'competitionShow'])->name('competition.show');
Route::get('/award', [HomeController::class, 'award'])->name('award');
Route::get('/award/{slug}', [HomeController::class, 'awardShow'])->name('award.show');
Route::get('/testimonials', [HomeController::class, 'testimonials'])->name('testimonials');

// Contact
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/complaint-suggestion', [ContactController::class, 'suggestionBox'])->name('suggestion-box');
Route::post('/complaint-suggestion', [ContactController::class, 'suggestionStore'])->name('suggestion.store');

// Your Opinion
Route::get('/youropinionmatters', [HomeController::class, 'yourOpinion'])->name('your-opinion');
Route::post('/youropinionmatters', [HomeController::class, 'yourOpinionStore'])->name('opinion.store');

// Auth Routes
require __DIR__.'/auth.php';

// Captcha
Route::get('captcha', [App\Http\Controllers\CaptchaController::class, 'image'])->name('captcha.image');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Team Management
    Route::resource('team', TeamMemberController::class);
    Route::post('team/{team}/toggle-status', [TeamMemberController::class, 'toggleStatus'])->name('team.toggle-status');

    // News & Events Management
    Route::resource('news', NewsEventController::class);
    Route::resource('news-categories', NewsCategoryController::class)->only(['index','store','destroy']);

    // Slider Management
    Route::resource('sliders', SliderController::class);

    // Publications Management
    Route::resource('publications', AdminPublicationController::class);

    // Magazine Management
    Route::resource('magazines', MagazineController::class);
    Route::get('magazine-categories', [MagazineController::class, 'categories'])->name('magazines.categories');
    Route::post('magazine-categories', [MagazineController::class, 'storeCategory'])->name('magazines.storeCategory');
    Route::delete('magazine-categories/{category}', [MagazineController::class, 'destroyCategory'])->name('magazines.destroyCategory');

    // Gallery Management
    Route::resource('gallery', AdminGalleryController::class);

    // Top Flash Management
    Route::resource('topflash', TopFlashController::class);

    // Awards Management
    Route::resource('awards', AwardController::class);
    Route::get('awards/{award}/participants', [AwardController::class, 'participants'])->name('awards.participants');
    Route::post('awards/{award}/participants', [AwardController::class, 'storeParticipant'])->name('awards.storeParticipant');
    Route::delete('awards/participants/{participant}', [AwardController::class, 'destroyParticipant'])->name('awards.destroyParticipant');
    Route::get('awards/{award}/certificate-builder', [AwardController::class, 'certificateBuilder'])->name('awards.certificateBuilder');
    Route::post('awards/{award}/save-cert-layout', [AwardController::class, 'saveCertLayout'])->name('awards.saveCertLayout');

    // Competitions Management
    Route::resource('competitions', CompetitionController::class);
    Route::get('competitions/{competition}/participants', [CompetitionController::class, 'participants'])->name('competitions.participants');
    Route::patch('competitions/participant/{participant}', [CompetitionController::class, 'updateParticipant'])->name('competitions.participant.update');

    // Contacts
    Route::get('contacts', [AdminContactController::class, 'index'])->name('contacts.index');
    Route::get('contacts/{contact}', [AdminContactController::class, 'show'])->name('contacts.show');
    Route::delete('contacts/{contact}', [AdminContactController::class, 'destroy'])->name('contacts.destroy');

    // Suggestions
    Route::get('suggestions', [AdminContactController::class, 'suggestions'])->name('suggestions.index');
    Route::get('suggestions/{suggestion}', [AdminContactController::class, 'showSuggestion'])->name('suggestions.show');

    // Opinions
    Route::get('opinions', [OpinionController::class, 'index'])->name('opinions.index');
    Route::post('opinions/{opinion}/approve', [OpinionController::class, 'approve'])->name('opinions.approve');
    Route::delete('opinions/{opinion}', [OpinionController::class, 'destroy'])->name('opinions.destroy');

    // Testimonials Management
    Route::resource('testimonials', TestimonialController::class);

    // Useful Links
    Route::resource('useful-links', UsefulLinkController::class);

    // Good Luck Messages
    Route::resource('good-luck-messages', GoodLuckMessageController::class);

    // E-Resources
    Route::resource('eip-resources', EipResourceController::class);

    // CMS Pages
    Route::resource('pages', PageController::class);

    // Som Quiz
    Route::resource('quizzes', QuizController::class);

    // Users & Roles Management
    Route::resource('users', UserController::class);
     // ── Registration Module ──
    Route::prefix('registration')->name('registration.')->group(function () {
            Route::get('/',                               [\App\Http\Controllers\Admin\RegistrationController::class, 'index'])        ->name('index');
            Route::get('/create',                         [\App\Http\Controllers\Admin\RegistrationController::class, 'create'])       ->name('create');
            Route::post('/',                              [\App\Http\Controllers\Admin\RegistrationController::class, 'store'])        ->name('store');
            Route::get('/{student}',                      [\App\Http\Controllers\Admin\RegistrationController::class, 'show'])         ->name('show');
            Route::get('/{student}/edit',                 [\App\Http\Controllers\Admin\RegistrationController::class, 'edit'])         ->name('edit');
            Route::put('/{student}',                      [\App\Http\Controllers\Admin\RegistrationController::class, 'update'])       ->name('update');
            Route::delete('/{student}',                   [\App\Http\Controllers\Admin\RegistrationController::class, 'destroy'])      ->name('destroy');
            Route::get('/{student}/add-course',           [\App\Http\Controllers\Admin\RegistrationController::class, 'addCourseForm'])->name('add-course');
            Route::post('/{student}/add-course',          [\App\Http\Controllers\Admin\RegistrationController::class, 'storeCourse'])  ->name('store-course');
            Route::get('/{student}/course/{course}/edit', [\App\Http\Controllers\Admin\RegistrationController::class, 'editCourse'])   ->name('edit-course');
            Route::put('/{student}/course/{course}',      [\App\Http\Controllers\Admin\RegistrationController::class, 'updateCourse']) ->name('update-course');
            Route::get('/{student}/course/{course}/certificate-builder', [\App\Http\Controllers\Admin\RegistrationController::class, 'certificateBuilder'])->name('certificate-builder');
});



    // Registered Users (Sign Up List)
    Route::get('registered-users', [App\Http\Controllers\Admin\RegisteredUserController::class, 'index'])->name('registered-users.index');
    Route::patch('registered-users/{user}/toggle', [App\Http\Controllers\Admin\RegisteredUserController::class, 'toggleStatus'])->name('registered-users.toggle');
    Route::delete('registered-users/{user}', [App\Http\Controllers\Admin\RegisteredUserController::class, 'destroy'])->name('registered-users.destroy');
    Route::patch('registered-users/{user}/admin-access', [App\Http\Controllers\Admin\RegisteredUserController::class, 'toggleAdminAccess'])->name('registered-users.admin-access');
});

// User Portal Routes
Route::middleware('auth')->prefix('portal')->name('portal.')->group(function () {
    Route::get('/', [App\Http\Controllers\Portal\PortalController::class, 'overview'])->name('overview');
    Route::get('/personal', [App\Http\Controllers\Portal\PortalController::class, 'personal'])->name('personal');
    Route::post('/personal', [App\Http\Controllers\Portal\PortalController::class, 'savePersonal'])->name('personal.save');
    Route::get('/education', [App\Http\Controllers\Portal\PortalController::class, 'education'])->name('education');
    Route::post('/education', [App\Http\Controllers\Portal\PortalController::class, 'saveEducation'])->name('education.save');
    Route::get('/achievements', [App\Http\Controllers\Portal\PortalController::class, 'achievements'])->name('achievements');
    Route::post('/achievements', [App\Http\Controllers\Portal\PortalController::class, 'storeAchievement'])->name('achievements.store');
    Route::delete('/achievements/{achievement}', [App\Http\Controllers\Portal\PortalController::class, 'deleteAchievement'])->name('achievements.delete');
    Route::get('/security', [App\Http\Controllers\Portal\PortalController::class, 'security'])->name('security');
    Route::post('/security', [App\Http\Controllers\Portal\PortalController::class, 'changePassword'])->name('security.save');
    Route::get('/activity', [App\Http\Controllers\Portal\PortalController::class, 'activity'])->name('activity');
});
// Fee Management
Route::get('/admin/fees', [App\Http\Controllers\Admin\FeeController::class, 'index'])->name('admin.fees.index')->middleware('auth');
Route::post('/admin/fees', [App\Http\Controllers\Admin\FeeController::class, 'store'])->name('admin.fees.store')->middleware('auth');
Route::delete('/admin/fees/{fee}', [App\Http\Controllers\Admin\FeeController::class, 'destroy'])->name('admin.fees.destroy')->middleware('auth');
Route::post('/admin/fees/{fee}/mark-paid', [App\Http\Controllers\Admin\FeeController::class, 'markPaid'])->name('admin.fees.markPaid')->middleware('auth');
Route::get('/admin/fees/categories', [App\Http\Controllers\Admin\FeeController::class, 'categories'])->name('admin.fees.categories')->middleware('auth');
Route::post('/admin/fees/categories', [App\Http\Controllers\Admin\FeeController::class, 'storeCategory'])->name('admin.fees.categories.store')->middleware('auth');
Route::delete('/admin/fees/categories/{category}', [App\Http\Controllers\Admin\FeeController::class, 'destroyCategory'])->name('admin.fees.categories.destroy')->middleware('auth');
// Student Registration System
Route::get('/admin/students', [App\Http\Controllers\Admin\StudentController::class, 'index'])->name('admin.students.index')->middleware('auth');
Route::get('/admin/students/create', [App\Http\Controllers\Admin\StudentController::class, 'create'])->name('admin.students.create')->middleware('auth');
Route::post('/admin/students', [App\Http\Controllers\Admin\StudentController::class, 'store'])->name('admin.students.store')->middleware('auth');
Route::get('/admin/students/{student}', [App\Http\Controllers\Admin\StudentController::class, 'show'])->name('admin.students.show')->middleware('auth');
Route::get('/admin/students/{student}/edit', [App\Http\Controllers\Admin\StudentController::class, 'edit'])->name('admin.students.edit')->middleware('auth');
Route::put('/admin/students/{student}', [App\Http\Controllers\Admin\StudentController::class, 'update'])->name('admin.students.update')->middleware('auth');
Route::delete('/admin/students/{student}', [App\Http\Controllers\Admin\StudentController::class, 'destroy'])->name('admin.students.destroy')->middleware('auth');
Route::get('/admin/students/{student}/toggle', [App\Http\Controllers\Admin\StudentController::class, 'toggleStatus'])->name('admin.students.toggleStatus')->middleware('auth');
Route::post('/admin/students/{student}/add-course', [App\Http\Controllers\Admin\StudentController::class, 'addCourse'])->name('admin.students.addCourse')->middleware('auth');
Route::get('/admin/student-courses/{studentCourse}/certificate', [App\Http\Controllers\Admin\StudentController::class, 'certificate'])->name('admin.students.certificate')->middleware('auth');
Route::put('/admin/student-courses/{studentCourse}/certificate', [App\Http\Controllers\Admin\StudentController::class, 'updateCertificate'])->name('admin.students.updateCertificate')->middleware('auth');

// Course Management
Route::get('/admin/courses', [App\Http\Controllers\Admin\CourseController::class, 'index'])->name('admin.courses.index')->middleware('auth');
Route::get('/admin/courses/create', [App\Http\Controllers\Admin\CourseController::class, 'create'])->name('admin.courses.create')->middleware('auth');
Route::post('/admin/courses', [App\Http\Controllers\Admin\CourseController::class, 'store'])->name('admin.courses.store')->middleware('auth');
Route::get('/admin/courses/{course}/edit', [App\Http\Controllers\Admin\CourseController::class, 'edit'])->name('admin.courses.edit')->middleware('auth');
Route::put('/admin/courses/{course}', [App\Http\Controllers\Admin\CourseController::class, 'update'])->name('admin.courses.update')->middleware('auth');
Route::delete('/admin/courses/{course}', [App\Http\Controllers\Admin\CourseController::class, 'destroy'])->name('admin.courses.destroy')->middleware('auth');
Route::get('/admin/visitor-logs', [App\Http\Controllers\Admin\VisitorLogController::class, 'index'])->name('admin.visitor-logs.index')->middleware('auth');
Route::delete('/admin/visitor-logs/clear-all', [App\Http\Controllers\Admin\VisitorLogController::class, 'clearAll'])->name('admin.visitor-logs.clearAll')->middleware('auth');
Route::delete('/admin/visitor-logs/{visitorLog}', [App\Http\Controllers\Admin\VisitorLogController::class, 'destroy'])->name('admin.visitor-logs.destroy')->middleware('auth');

// Invoice System
Route::get('/admin/students/{student}/invoices', [App\Http\Controllers\Admin\InvoiceController::class, 'index'])->name('admin.invoices.index')->middleware('auth');
Route::post('/admin/students/{student}/invoices', [App\Http\Controllers\Admin\InvoiceController::class, 'store'])->name('admin.invoices.store')->middleware('auth');
Route::get('/admin/students/{student}/invoices/{invoice}', [App\Http\Controllers\Admin\InvoiceController::class, 'show'])->name('admin.invoices.show')->middleware('auth');
Route::get('/admin/students/{student}/invoices/{invoice}/print', [App\Http\Controllers\Admin\InvoiceController::class, 'print'])->name('admin.invoices.print')->middleware('auth');
Route::post('/admin/invoices/{invoice}/payment', [App\Http\Controllers\Admin\InvoiceController::class, 'addPayment'])->name('admin.invoices.addPayment')->middleware('auth');
Route::delete('/admin/students/{student}/invoices/{invoice}', [App\Http\Controllers\Admin\InvoiceController::class, 'destroy'])->name('admin.invoices.destroy')->middleware('auth');
// Invoice Payment
Route::post('/admin/invoices/{invoice}/payment', [\App\Http\Controllers\Admin\InvoiceController::class, 'addPayment'])->name('admin.invoices.addPayment')->middleware('auth');
// Invoice System
Route::get('/admin/students/{student}/invoices', [App\Http\Controllers\Admin\InvoiceController::class, 'index'])->name('admin.invoices.index')->middleware('auth');
Route::post('/admin/students/{student}/invoices', [App\Http\Controllers\Admin\InvoiceController::class, 'store'])->name('admin.invoices.store')->middleware('auth');
Route::get('/admin/students/{student}/invoices/{invoice}', [App\Http\Controllers\Admin\InvoiceController::class, 'show'])->name('admin.invoices.show')->middleware('auth');
Route::get('/admin/students/{student}/invoices/{invoice}/edit', [App\Http\Controllers\Admin\InvoiceController::class, 'edit'])->name('admin.invoices.edit')->middleware('auth');
Route::put('/admin/students/{student}/invoices/{invoice}', [App\Http\Controllers\Admin\InvoiceController::class, 'update'])->name('admin.invoices.update')->middleware('auth');
Route::get('/admin/students/{student}/invoices/{invoice}/print', [App\Http\Controllers\Admin\InvoiceController::class, 'print'])->name('admin.invoices.print')->middleware('auth');
Route::post('/admin/invoices/{invoice}/payment', [App\Http\Controllers\Admin\InvoiceController::class, 'addPayment'])->name('admin.invoices.addPayment')->middleware('auth');
Route::get('/admin/invoices/{invoice}/payment/{payment}/edit', [App\Http\Controllers\Admin\InvoiceController::class, 'editPayment'])->name('admin.invoices.editPayment')->middleware('auth');
Route::put('/admin/invoices/{invoice}/payment/{payment}', [App\Http\Controllers\Admin\InvoiceController::class, 'updatePayment'])->name('admin.invoices.updatePayment')->middleware('auth');
Route::delete('/admin/invoices/{invoice}/payment/{payment}', [App\Http\Controllers\Admin\InvoiceController::class, 'destroyPayment'])->name('admin.invoices.destroyPayment')->middleware('auth');
Route::delete('/admin/students/{student}/invoices/{invoice}', [App\Http\Controllers\Admin\InvoiceController::class, 'destroy'])->name('admin.invoices.destroy')->middleware('auth');
// Student Portal
Route::get('/student/login', [App\Http\Controllers\Student\StudentAuthController::class, 'loginForm'])->name('student.login');
Route::post('/student/login', [App\Http\Controllers\Student\StudentAuthController::class, 'login'])->name('student.login.post');
Route::post('/student/logout', [App\Http\Controllers\Student\StudentAuthController::class, 'logout'])->name('student.logout');

Route::prefix('student')->middleware('student.auth')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Student\StudentPortalController::class, 'dashboard'])->name('student.dashboard');
    Route::get('/profile', [App\Http\Controllers\Student\StudentPortalController::class, 'profile'])->name('student.profile');
    Route::get('/courses', [App\Http\Controllers\Student\StudentPortalController::class, 'courses'])->name('student.courses');
    Route::get('/invoices', [App\Http\Controllers\Student\StudentPortalController::class, 'invoices'])->name('student.invoices');
    Route::get('/invoices/{invoice}', [App\Http\Controllers\Student\StudentPortalController::class, 'invoiceDetail'])->name('student.invoice.detail');
    Route::get('/invoices/{invoice}/print', [App\Http\Controllers\Student\StudentPortalController::class, 'invoicePrint'])->name('student.invoice.print');
    Route::get('/result', [App\Http\Controllers\Student\StudentPortalController::class, 'result'])->name('student.result');
});
// Certificate Verify
Route::get('/certificate', function() {
    return view('frontend.certificate');
})->name('certificate');
Route::post('/certificate/verify', [App\Http\Controllers\CertificateController::class, 'verify'])->name('certificate.verify');
// Teachers
Route::resource('admin/teachers', App\Http\Controllers\Admin\TeacherController::class)->names('admin.teachers')->middleware('auth');
// Student Marks
Route::get('/admin/students/{student}/courses/{studentCourse}/marks', [App\Http\Controllers\Admin\StudentMarksController::class, 'index'])->name('admin.marks.index')->middleware('auth');
Route::post('/admin/students/{student}/courses/{studentCourse}/marks', [App\Http\Controllers\Admin\StudentMarksController::class, 'store'])->name('admin.marks.store')->middleware('auth');
Route::post('/admin/students/{student}/courses/{studentCourse}/marks', [App\Http\Controllers\Admin\StudentMarksController::class, 'store'])->name('admin.marks.store')->middleware('auth');
// Quiz Public Routes
Route::get('/quizzes', [App\Http\Controllers\QuizController::class, 'index'])->name('quizzes.index');
Route::get('/quizzes/{quiz}', [App\Http\Controllers\QuizController::class, 'show'])->name('quiz.show');
Route::post('/quizzes/{quiz}/submit', [App\Http\Controllers\QuizController::class, 'submit'])->name('quiz.submit');
Route::get('/quiz/result/{result}', [App\Http\Controllers\QuizController::class, 'result'])->name('quiz.result');

// Quiz Admin Routes
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::resource('quizzes', App\Http\Controllers\Admin\QuizController::class)->names('admin.quizzes');
    Route::post('quizzes/{quiz}/questions', [App\Http\Controllers\Admin\QuizController::class, 'storeQuestion'])->name('admin.quizzes.storeQuestion');
    Route::delete('quizzes/{quiz}/questions/{question}', [App\Http\Controllers\Admin\QuizController::class, 'destroyQuestion'])->name('admin.quizzes.destroyQuestion');
    Route::get('quizzes/{quiz}/results', [App\Http\Controllers\Admin\QuizController::class, 'results'])->name('admin.quizzes.results');
});
// Leaderboard
Route::get('/leaderboard', [App\Http\Controllers\LeaderboardController::class, 'index'])->name('leaderboard');
// Student ID Card
Route::get('/admin/students/{student}/id-card', [App\Http\Controllers\Admin\IdCardController::class, 'show'])->name('admin.idcard.show')->middleware('auth');
Route::get('/admin/students/{student}/id-card/pdf', [App\Http\Controllers\Admin\IdCardController::class, 'downloadPdf'])->name('admin.idcard.pdf')->middleware('auth');
// Notifications
Route::get('admin/notifications', [\App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('admin.notifications.index')->middleware('auth');
Route::post('admin/notifications/read-all', [\App\Http\Controllers\Admin\NotificationController::class, 'markAllRead'])->name('admin.notifications.readAll')->middleware('auth');
Route::get('admin/notifications/unread', [\App\Http\Controllers\Admin\NotificationController::class, 'getUnread'])->name('admin.notifications.unread')->middleware('auth');
Route::post('admin/notifications/{notification}/read', [\App\Http\Controllers\Admin\NotificationController::class, 'markRead'])->name('admin.notifications.read')->middleware('auth');
Route::delete('admin/notifications/{notification}', [\App\Http\Controllers\Admin\NotificationController::class, 'destroy'])->name('admin.notifications.destroy')->middleware('auth');
 
// Course Marks Templates
Route::get('admin/marks/templates', [\App\Http\Controllers\Admin\CourseMarksTemplateController::class, 'index'])->name('admin.marks.templates.index')->middleware('auth');
Route::get('admin/marks/templates/create', [\App\Http\Controllers\Admin\CourseMarksTemplateController::class, 'create'])->name('admin.marks.templates.create')->middleware('auth');
Route::post('admin/marks/templates', [\App\Http\Controllers\Admin\CourseMarksTemplateController::class, 'store'])->name('admin.marks.templates.store')->middleware('auth');
Route::get('admin/marks/templates/{template}/edit', [\App\Http\Controllers\Admin\CourseMarksTemplateController::class, 'edit'])->name('admin.marks.templates.edit')->middleware('auth');
Route::put('admin/marks/templates/{template}', [\App\Http\Controllers\Admin\CourseMarksTemplateController::class, 'update'])->name('admin.marks.templates.update')->middleware('auth');
Route::delete('admin/marks/templates/{template}', [\App\Http\Controllers\Admin\CourseMarksTemplateController::class, 'destroy'])->name('admin.marks.templates.destroy')->middleware('auth');
// Course Categories
Route::resource('admin/course-categories', App\Http\Controllers\Admin\CourseCategoryController::class)->names('admin.course-categories')->middleware('auth');
Route::resource('admin/course-categories', App\Http\Controllers\Admin\CourseCategoryController::class)->names('admin.course-categories')->middleware('auth');