<?php

use App\Http\Controllers\API\Admin\ApiCountryController;
use App\Http\Controllers\API\Admin\ApiJobCategoryController;
use App\Http\Controllers\API\Admin\ApiJobController;
use App\Http\Controllers\API\Admin\ApiOrderController;
use App\Http\Controllers\API\ApiAdminAuthController;
use App\Http\Controllers\API\ApiUserAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Authentication With sanctum
//http://laravel-job-portal.test/api/singup
Route::post('singup', [ApiUserAuthController::class, 'singup']);
//http://laravel-job-portal.test/api/login
Route::post('login', [ApiUserAuthController::class, 'login']);
//http://laravel-job-portal.test/api/login
Route::get('login', [ApiUserAuthController::class, 'login'])->name('login');
//http://laravel-job-portal.test/api/logout
Route::post('logout', [ApiAdminAuthController::class, 'logout']);

//http://laravel-job-portal.test/api/forgot-password
Route::post('forgot-password', [ApiUserAuthController::class, 'forgotPassword']);
//http://laravel-job-portal.test/api/reset-password
Route::post('reset-password', [ApiUserAuthController::class, 'resetPassword']);

Route::group(
    [
        'middleware' => ['auth:sanctum', 'verified', 'user.role:candidate'],
        'prefix' => 'candidate',
        'as' => 'candidate.'
    ],
    function () {}
);

Route::group(
    [
        'middleware' => ['auth:sanctum', 'verified', 'user.role:company'],
        'prefix' => 'company',
        'as' => 'company.'
    ],
    function () {}
);

//Authentication Admin
//http://laravel-job-portal.test/api/admin/singup
Route::post('admin/singup', [ApiAdminAuthController::class, 'singup']);
//http://laravel-job-portal.test/api/admin/login
Route::post('admin/login', [ApiAdminAuthController::class, 'login']);
//http://laravel-job-portal.test/api/admin/login
Route::get('admin/login', [ApiAdminAuthController::class, 'login'])->name('admin.login');

//http://laravel-job-portal.test/api/admin/forgot-password
Route::post('admin/forgot-password', [ApiAdminAuthController::class, 'forgotPassword']);
//http://laravel-job-portal.test/api/admin/reset-password
Route::post('admin/reset-password', [ApiAdminAuthController::class, 'resetPassword']);
//Admin
Route::group(
    ['middleware' => ['auth:sanctum'], 'prefix' => 'admin', 'as' => 'admin.'],
    function () {
        //http://laravel-job-portal.test/api/admin/logout
        Route::post('logout', [ApiAdminAuthController::class, 'logout']);

        //Store Orders Data
        //http://laravel-job-portal.test/api/admin/orders
        Route::prefix('orders')->group(function () {
            Route::get('/', [ApiOrderController::class, 'index']);
            Route::get('/{id}', [ApiOrderController::class, 'show']);
            Route::get('/{id}/invoice', [ApiOrderController::class, 'invoice']);
        });

        //Store JobCategories Data
        //http://laravel-job-portal.test/api/admin/job-categories
        Route::resource('job-categories', ApiJobCategoryController::class);

        //Store Job Post
        //http://laravel-job-portal.test/api/admin/jobs
        Route::resource('jobs', ApiJobController::class);





        //Store Countries
        //http: //laravel-job-portal.test/api/admin/countries
        Route::resource('countries', ApiCountryController::class);
    }
);
