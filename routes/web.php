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
