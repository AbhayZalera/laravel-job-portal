<?php

use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Frontend\AboutUSPageController;
use App\Http\Controllers\Frontend\CandidateDashboardController;
use App\Http\Controllers\Frontend\CandidateEducationController;
use App\Http\Controllers\Frontend\CandidateExperienceController;
use App\Http\Controllers\Frontend\CandidateJobBookmarkController;
use App\Http\Controllers\Frontend\CandidateMyJobController;
use App\Http\Controllers\Frontend\CandidateProfileController;
use App\Http\Controllers\Frontend\CheckoutPageController;
use App\Http\Controllers\Frontend\CompanyDashboardController;
use App\Http\Controllers\Frontend\CompanyOrderController;
use App\Http\Controllers\Frontend\CompanyProfileController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\FrontendBlogPageController;
use App\Http\Controllers\Frontend\FrontendCandidatePageController;
use App\Http\Controllers\Frontend\FrontendCompanyPageController;
use App\Http\Controllers\Frontend\FrontendJobPageController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\jobController;
use App\Http\Controllers\Frontend\LocationController;
use App\Http\Controllers\Frontend\NewsletterController;
use App\Http\Controllers\Frontend\PricingPageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get(
    '/',
    [HomeController::class, 'index']
)->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::get('get-state/{country_id}', [LocationController::class, 'getStates'])->name('get-states');
Route::get('get-cities/{state_id}', [LocationController::class, 'getCities'])->name('get-cities');

//Frontend Global Company Page
Route::get('companies', [FrontendCompanyPageController::class, 'index'])->name('companies.index');
Route::get('companies/{slug}', [FrontendCompanyPageController::class, 'show'])->name('companies.show');

//Frontend Global Canidate Page
Route::get('candidates', [FrontendCandidatePageController::class, 'index'])->name('candidates.index');
Route::get('candidates/{slug}', [FrontendCandidatePageController::class, 'show'])->name('candidates.show');

Route::get('pricing', PricingPageController::class)->name('pricing.index');
Route::get('checkout/{plan_id}', CheckoutPageController::class)->name('checkout.index');

//Find a Job Route
Route::get('jobs', [FrontendJobPageController::class, 'index'])->name('jobs.index');
Route::get('jobs/{slug}', [FrontendJobPageController::class, 'show'])->name('jobs.show');
Route::post('apply-job/{id}', [FrontendJobPageController::class, 'applyJob'])->name('apply.job.store');
Route::get('job-bookmark/{id}', [CandidateJobBookmarkController::class, 'save'])->name('job.bookmark');

//Blogs Routes
Route::get('blogs', [FrontendBlogPageController::class, 'index'])->name('blogs.index');
Route::get('blogs/{slug}', [FrontendBlogPageController::class, 'show'])->name('blogs.show');

//About Us Route
Route::get('about-us', [AboutUSPageController::class, 'index'])->name('about.index'); //Frontend

//Contact Us Route
Route::get('contact', [ContactController::class, 'index'])->name('contact.index'); //Frontend
Route::post('contact', [ContactController::class, 'sendMail'])->name('send-mail'); //Frontend

//Custom Page Route
Route::get('page/{slug}', [HomeController::class, 'customPage'])->name('custom-page'); //Frontend

//Newsletter Route
Route::post('newsletter', [NewsletterController::class, 'store'])->name('newsletter.store');


// Candidate Dashboard Route
Route::group(
    [
        'middleware' => ['auth', 'verified', 'user.role:candidate'],
        'prefix' => 'candidate',
        'as' => 'candidate.'
    ],
    function () {
        Route::get('/dashboard', [CandidateDashboardController::class, 'index'])->name('dashboard');
        Route::get('/profile', [CandidateProfileController::class, 'index'])->name('profile.index');
        Route::post(
            '/profile/basic-info-update',
            [CandidateProfileController::class, 'basicInfoUpdate']
        )->name('profile.basic-info-update');
        Route::post(
            '/profile/profile-info-update',
            [CandidateProfileController::class, 'profileInfoUpdate']
        )->name('profile.profile-info-update');

        Route::resource('experience', CandidateExperienceController::class);

        Route::resource('education', CandidateEducationController::class);

        Route::post(
            '/profile/acoount-info-update',
            [CandidateProfileController::class, 'accountInfoUpdate']
        )->name('profile.account-info-update');

        Route::post(
            '/profile/acoount-email-update',
            [CandidateProfileController::class, 'accountEmailUpdate']
        )->name('profile.account-email-update');

        Route::post(
            '/profile/acoount-password-update',
            [CandidateProfileController::class, 'accountPasswordUpdate']
        )->name('profile.account-password-update');

        Route::get('applied-jobs', [CandidateMyJobController::class, 'index'])->name('applied-jobs.index');
        Route::get('bookmarked-jobs', [CandidateJobBookmarkController::class, 'index'])->name('book-jobs.index');
        Route::delete('bookmarked-jobs/{id}', [CandidateJobBookmarkController::class, 'destroy'])->name('book-jobs.destroy');
    }
);

// Company Route
Route::group(
    [
        'middleware' => ['auth', 'verified', 'user.role:company'],
        'prefix' => 'company',
        'as' => 'company.'
    ],
    function () {
        // Dashboard
        Route::get('/dashboard', [CompanyDashboardController::class, 'index'])->name('dashboard');

        //Company Profile
        Route::get('/profile', [CompanyProfileController::class, 'index'])->name('profile');
        Route::post('/profile/company-info', [CompanyProfileController::class, 'updateCompanyInfo'])->name('profile.company-info');
        Route::post('/profile/founding-info', [CompanyProfileController::class, 'updateFoundingInfo'])->name('profile.founding-info');
        Route::post('/profile/account-info', [CompanyProfileController::class, 'updateAccountInfo'])->name('profile.account-info');
        Route::post('/profile/password-update', [CompanyProfileController::class, 'updatePassword'])->name('profile.password-update');

        //Order Route
        Route::get('orders', [CompanyOrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{id}', [CompanyOrderController::class, 'show'])->name('orders.show');
        Route::get('orders/invoice/{id}', [CompanyOrderController::class, 'invoice'])->name('orders.invoice');

        //Payments Routes
        Route::get('payment/success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
        Route::get('payment/error', [PaymentController::class, 'paymentError'])->name('payment.error');

        //PayPal
        Route::get('paypal/payment', [PaymentController::class, 'payWithPaypal'])->name('paypal.payment');
        Route::get('paypal/success', [PaymentController::class, 'paypalSuccess'])->name('paypal.success');
        Route::get('paypal/cancel', [PaymentController::class, 'paypalCancel'])->name('paypal.cancel');

        //Stripe
        Route::get('stripe/payment', [PaymentController::class, 'payWithStripe'])->name('stripe.payment');
        Route::get('stripe/success', [PaymentController::class, 'stripeSuccess'])->name('stripe.success');
        Route::get('stripe/cancel', [PaymentController::class, 'stripeCancel'])->name('stripe.cancel');

        //RazorPay
        Route::get('razorpay-redirect', [PaymentController::class, 'razorpayRedirect'])->name('razorpay-redirect');
        Route::post('razorpay/payment', [PaymentController::class, 'payWithRazorpay'])->name('razorpay.payment');

        //PhonePay
        // Frontend routes
        Route::get('payment/phonepe', [PaymentController::class, 'payWithPhonepe'])->name('phonepe.payment');
        Route::post('payment/phonepe/callback', [PaymentController::class, 'phonepeCallback'])->name('phonepe.callback');

        //Jobs
        Route::resource('jobs', jobController::class);

        //Application
        Route::get('job-applications/{id}', [jobController::class, 'applications'])->name('job.applications');
        Route::post('approve/{id}', [JobController::class, 'approve'])->name('approve.update');
    }
);
