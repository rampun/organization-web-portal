<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CommitteeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\NoticeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuggestionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;

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

Route::middleware('auth:api')->group(function () {

    Route::post('suggestion/create', [SuggestionController::class, 'create']);

    // Members
    Route::get('/members', [UserController::class, 'list']);
    Route::get('/member/{id}', [UserController::class, 'detail']);
    Route::post('/member/search/', [UserController::class, 'search']);





    // Update password
    Route::post('/profile/changePassword', [ProfileController::class, 'changePassword']);

    // User log out
    Route::get('/logout', [UserController::class, 'logout']);
});

// User Login
Route::post('/login', [UserController::class, 'login']);


// Activities
Route::get('/activities', [ActivityController::class, 'list']);
Route::get('/activity/{id}', [ActivityController::class, 'detail']);

// Committee
Route::get('/committees', [CommitteeController::class, 'list']);
Route::get('/committee/{id}', [CommitteeController::class, 'detail']);

// Department
Route::get('/departments', [DepartmentController::class, 'list']);

// Department
Route::get('/downloads', [DownloadController::class, 'list']);
Route::get('/download/{id}', [DownloadController::class, 'detail']);

// Department
Route::get('/events', [EventController::class, 'list']);
Route::get('/event/{id}', [EventController::class, 'detail']);

// Notice
Route::get('/notices', [NoticeController::class, 'list']);
Route::get('/notice/{id}', [NoticeController::class, 'detail']);
