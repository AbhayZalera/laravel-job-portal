<?php

use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Admin\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Admin\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Admin\Auth\NewPasswordController;
use App\Http\Controllers\Admin\Auth\PasswordController;
use App\Http\Controllers\Admin\Auth\PasswordResetLinkController;
use App\Http\Controllers\Admin\Auth\RegisteredUserController;
use App\Http\Controllers\Admin\Auth\VerifyEmailController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\ClearDatabaseController;
use App\Http\Controllers\Admin\CounterController;
use App\Http\Controllers\Admin\CountreController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\CustomPageBuilderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FooterController;
use App\Http\Controllers\Admin\HeroController;
use App\Http\Controllers\Admin\IndustryTypeController;
use App\Http\Controllers\Admin\JobController;
use App\Http\Controllers\Admin\JobExperienceController;
use App\Http\Controllers\Admin\JobLocationController;
use App\Http\Controllers\Admin\JobRoleController;
use App\Http\Controllers\Admin\JobTypeController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\LearnMoreController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\MenuBuilderController;
use App\Http\Controllers\Admin\NewsletterController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\OrganizationTypeController;
use App\Http\Controllers\Admin\PaymentSettingController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\PlaneController;
use App\Http\Controllers\Admin\ProfessionController;
use App\Http\Controllers\Admin\ProfileUpdateController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\Admin\RoleUserController;
use App\Http\Controllers\Admin\SalaryTypeController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Admin\SocialIconController;
use App\Http\Controllers\Admin\StateController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\WhyChooseUsController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\JobCategoryController;
use App\Models\JobExperience;
use App\Models\WhyChooseUs;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['guest:admin'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::group(['middleware' => ['auth:admin'], 'prefix' => 'admin', 'as' => 'admin.'], function () {

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');


    /** Profile update routes */
    Route::get('profile', [ProfileUpdateController::class, 'index'])->name('profile.index');
    Route::post('profile', [ProfileUpdateController::class, 'update'])->name('profile.update');
    Route::post('profile-password', [ProfileUpdateController::class, 'passwordUpdate'])->name('profile-password.update');

    //Dashboard Route
    // Route::get('dashboard', function () {
    //     return view('admin.dashboard.index');
    // })->name('dashboard');
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Industry Type Route
    Route::resource('industry-type', IndustryTypeController::class);

    //Organization Type Route
    Route::resource('organization-type', OrganizationTypeController::class);

    //Countries
    Route::resource('countries', CountryController::class);

    //States
    Route::resource('states', StateController::class);

    //City
    Route::resource('cities', CityController::class);

    Route::get('get-states/{country_id}', [LocationController::class, 'getStateOfCountry'])
        ->name('get_states');
    //language Routes
    Route::resource('languages', LanguageController::class);

    //profession Routes
    Route::resource('profession', ProfessionController::class);

    //Skills Routes
    Route::resource('skill', SkillController::class);

    //Planes Routes
    Route::resource('plans', PlanController::class);

    //Order Route
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('orders/invoice/{id}', [OrderController::class, 'invoice'])->name('orders.invoice');

    //Job Category Route
    Route::resource('job-categories', JobCategoryController::class);

    //Education Route
    Route::resource('educations', EducationController::class);

    //JobType Route
    Route::resource('job-type', JobTypeController::class);

    //Job Salary Route
    Route::resource('salary-type', SalaryTypeController::class);

    //tag Route
    Route::resource('tag', TagController::class);

    //Job Role Route
    Route::resource('job-roles', JobRoleController::class);

    //Job Experience Route
    Route::resource('job-experiences', JobExperienceController::class);

    //Job Route
    Route::post('job-status/{id}', [JobController::class, 'changeStatus'])->name('job-status.update');
    Route::resource('jobs', JobController::class);

    //Payment Settings Route
    Route::get('payment-settings', [PaymentSettingController::class, 'index'])->name('payment-settings.index');
    Route::post('paypal-settings', [PaymentSettingController::class, 'updatePaypalSetting'])->name('paypal-settings.update');
    Route::post('stripe-settings', [PaymentSettingController::class, 'updateStripeSetting'])->name('stripe-settings.update');
    Route::post('razorpay-settings', [PaymentSettingController::class, 'updateRazorpaySetting'])->name('razorpay-settings.update');

    //Site Settings Route
    Route::get('site-settings', [SiteSettingController::class, 'index'])->name('site-settings.index');
    Route::post('general-settings', [SiteSettingController::class, 'updateGeneralSetting'])->name('general-settings.update');
    Route::post('logo-settings', [SiteSettingController::class, 'updateLogoSetting'])->name('logo-settings.update');

    //Blogs
    Route::resource('blogs', BlogController::class);

    //Hero
    Route::resource('hero', HeroController::class);

    //WhyChooseUs
    Route::resource('why-choose-us', WhyChooseUsController::class);

    //Learn More
    Route::resource('learn-more', LearnMoreController::class);

    //Counter Section
    Route::resource('counter', CounterController::class);

    //Job Location
    Route::resource('job-location', JobLocationController::class);

    //Reviews Sections
    Route::resource('reviews', ReviewController::class);

    //About Sections
    Route::resource('about-us', AboutController::class);

    //Custom Page Builder
    Route::resource('page-builder', CustomPageBuilderController::class);

    //Newsletter Route
    Route::get('newsletter', [NewsletterController::class, 'index'])->name('newsletter.index');
    Route::delete('newsletter/{id}', [NewsletterController::class, 'destroy'])->name('newsletter.destroy');
    Route::post('newsletter', [NewsletterController::class, 'sendMail'])->name('newsletter-send-mail');

    //Menu Builder
    Route::resource('menu-builder', MenuBuilderController::class);

    //Footer
    Route::resource('footer', FooterController::class);

    //Social Icon
    Route::resource('social-icon', SocialIconController::class);

    //Clear Database
    Route::get('clear-database', [ClearDatabaseController::class, 'index'])->name('clear-database.index');
    Route::post('clear-database', [ClearDatabaseController::class, 'clearDatabase'])->name('clear-database');

    //Role Permission
    Route::resource('role', RolePermissionController::class);

    //Role User
    Route::resource('role-user', RoleUserController::class);
});
