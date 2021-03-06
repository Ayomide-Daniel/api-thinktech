<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::prefix('v1')->group(function () {
    Route::middleware('auth:sanctum')->get('/user', [App\Http\Controllers\AuthenticationController::class, 'getUser']);

    // Auth::routes();
    Route::post('/register', [App\Http\Controllers\AuthenticationController::class, 'register']);
    Route::post('/login', [App\Http\Controllers\AuthenticationController::class, 'login']);

    // Article route
    Route::prefix('articles')->group(function () {
        Route::get('trending', [App\Http\Controllers\ArticleController::class, 'trending']);
        Route::post('upload-image', [App\Http\Controllers\ArticleController::class, 'uploadImage']);
        Route::post('upload-img', [App\Http\Controllers\ArticleController::class, 'uploadImg'])->name('upload_img');
        Route::get('author', [App\Http\Controllers\ArticleController::class, 'byAuthor']);       
    });
    Route::resource('articles', ArticleController::class);

    Route::middleware(['auth:sanctum', 'verify.author'])->prefix('author')->group(function () {
        Route::get('analytics-stats', [AuthorController::class, 'analyticStats']);
        Route::post('update-profile', [AuthorController::class, 'updateProfile']);
    });

    Route::prefix('analytics')->group(function () {
        Route::post('update-views', [AnalyticsController::class, 'updateViews']);
        Route::post('update-visits', [AnalyticsController::class, 'updateVisits']);
    });

    Route::prefix('admin')->group(function () {
        // Route::get('analytics-stats', [AdminController::class, 'analyticsS'] 'AdminController@analyticsStats');
    });
});
