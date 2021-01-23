<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CommitteeController;
use App\Http\Controllers\SuggestionController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('portal.landing');
// });

Route::get('/home', function () {
    return redirect()->route('member.list');
})->middleware('auth');


// Admin routes
Route::group(['middleware' => ['auth','admin']], function (){
    
    Route::get('/', function () {return view('portal.dashboard');});

    // User Routes
    Route::any('/members', [UserController::class, 'list'])->name('member.list');
    Route::get('/member/create', [UserController::class, 'create'])->name('member.create');
    Route::post('/member/create', [UserController::class, 'store'])->name('member.store');
    Route::get('/member/detail/{id}', [UserController::class, 'detail'])->name('member.detail');
    Route::get('/member/update/{id}', [UserController::class, 'update'])->name('member.update');
    Route::post('/member/update/child', [UserController::class, 'addChild'])->name('member.addChild');
    Route::post('/member/update', [UserController::class, 'storeUpdate'])->name('member.storeUpdate');
    Route::get('/member/delete/{id}', [UserController::class, 'delete'])->name('member.delete');

    // Event Routes
    Route::any('/events/{status}', [EventController::class, 'list'])->name('event.list');
    Route::get('/event/create', [EventController::class, 'create'])->name('event.create');
    Route::post('/event/create', [EventController::class, 'store'])->name('event.store');
    Route::get('/event/update/{id}', [EventController::class, 'update'])->name('event.update');
    Route::post('/event/update', [EventController::class, 'updateEvent'])->name('event.updateEvent');
    Route::get('/event/detail/{id}', [EventController::class, 'detail'])->name('event.detail');
    Route::get('/event/delete/{id}', [EventController::class, 'delete'])->name('event.delete');
    Route::get('/event/restore/{id}', [EventController::class, 'restore'])->name('event.restore');
    Route::get('/event/permanentlyDelete/{id}', [EventController::class, 'permanentlyDelete'])->name('event.permanentlyDelete');

    // Activities Routes
    Route::any('/activities/{status}', [ActivityController::class, 'list'])->name('activity.list');
    Route::get('/activity/create', [ActivityController::class, 'create'])->name('activity.create');
    Route::post('/activity/create', [ActivityController::class, 'store'])->name('activity.store');
    Route::get('/activity/update/{id}', [ActivityController::class, 'update'])->name('activity.update');
    Route::post('/activity/update', [ActivityController::class, 'updateActivity'])->name('activity.updateActivity');
    Route::get('/activity/detail/{id}', [ActivityController::class, 'detail'])->name('activity.detail');
    Route::get('/activity/delete/{id}', [ActivityController::class, 'delete'])->name('activity.delete');
    Route::get('/activity/restore/{id}', [ActivityController::class, 'restore'])->name('activity.restore');
    Route::get('/activity/permanentlyDelete/{id}', [ActivityController::class, 'permanentlyDelete'])->name('activity.permanentlyDelete');

    // Notice Routes
    Route::any('/notices/{status}', [NoticeController::class, 'list'])->name('notice.list');
    Route::get('/notice/create', [NoticeController::class, 'create'])->name('notice.create');
    Route::post('/notice/create', [NoticeController::class, 'store'])->name('notice.store');
    Route::get('/notice/update/{id}', [NoticeController::class, 'update'])->name('notice.update');
    Route::post('/notice/update', [NoticeController::class, 'updateNotice'])->name('notice.updateNotice');
    Route::get('/notice/detail/{id}', [NoticeController::class, 'detail'])->name('notice.detail');
    Route::get('/notice/delete/{id}', [NoticeController::class, 'delete'])->name('notice.delete');
    Route::get('/notice/restore/{id}', [NoticeController::class, 'restore'])->name('notice.restore');
    Route::get('/notice/permanentlyDelete/{id}', [NoticeController::class, 'permanentlyDelete'])->name('notice.permanentlyDelete');

    // Committee Routes
    Route::any('/committees/{status}', [CommitteeController::class, 'list'])->name('committee.list');
    Route::get('/committee/create', [CommitteeController::class, 'create'])->name('committee.create');
    Route::post('/committee/create', [CommitteeController::class, 'store'])->name('committee.store');
    Route::get('/committee/update/{id}', [CommitteeController::class, 'update'])->name('committee.update');
    Route::post('/committee/update', [CommitteeController::class, 'updateCommittee'])->name('committee.updateCommittee');
    Route::get('/committee/detail/{id}', [CommitteeController::class, 'detail'])->name('committee.detail');
    Route::get('/committee/delete/{id}', [CommitteeController::class, 'delete'])->name('committee.delete');
    Route::get('/committee/restore/{id}', [CommitteeController::class, 'restore'])->name('committee.restore');
    Route::get('/committee/permanentlyDelete/{id}', [CommitteeController::class, 'permanentlyDelete'])->name('committee.permanentlyDelete');

    // Download Routes
    Route::any('/downloads/{status}', [DownloadController::class, 'list'])->name('download.list');
    Route::get('/download/create', [DownloadController::class, 'create'])->name('download.create');
    Route::post('/download/create', [DownloadController::class, 'store'])->name('download.store');
    Route::get('/download/update/{id}', [DownloadController::class, 'update'])->name('download.update');
    Route::post('/download/update', [DownloadController::class, 'updateDownload'])->name('download.updateDownload');
    Route::get('/download/detail/{id}', [DownloadController::class, 'detail'])->name('download.detail');
    Route::get('/download/delete/{id}', [DownloadController::class, 'delete'])->name('download.delete');
    Route::get('/download/restore/{id}', [DownloadController::class, 'restore'])->name('download.restore');
    Route::get('/download/permanentlyDelete/{id}', [DownloadController::class, 'permanentlyDelete'])->name('download.permanentlyDelete');

    // Department Routes
    Route::any('/departments/{status}', [DepartmentController::class, 'list'])->name('department.list');
    Route::get('/department/create', [DepartmentController::class, 'create'])->name('department.create');
    Route::post('/department/create', [DepartmentController::class, 'store'])->name('department.store');
    Route::get('/department/update/{id}', [DepartmentController::class, 'update'])->name('department.update');
    Route::post('/department/update', [DepartmentController::class, 'updateDepartment'])->name('department.updateDepartment');
    Route::get('/department/detail/{id}', [DepartmentController::class, 'detail'])->name('department.detail');
    Route::get('/department/delete/{id}', [DepartmentController::class, 'delete'])->name('department.delete');
    Route::get('/department/restore/{id}', [DepartmentController::class, 'restore'])->name('department.restore');
    Route::get('/department/permanentlyDelete/{id}', [DepartmentController::class, 'permanentlyDelete'])->name('department.permanentlyDelete');

    // Suggestion routes
    Route::any('/suggestions', [SuggestionController::class, 'list'])->name('suggestion.list');
    Route::get('/suggestion/markRead/{id}/{action}', [SuggestionController::class, 'markReadUnread'])->name('suggestion.markReadUnread');
});

// Member routes
Route::group(['middleware' => ['auth','admin']], function (){

});

Route::post('/member/search', [UserController::class, 'search'])->name('member.search');

Route::get('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::post('/profile/changePassword', [ProfileController::class, 'changePassword'])->name('profile.changePassword');

// // Committee routes
// Route::any('/committees', [CommitteeController::class, 'list'])->name('committee.list');

Route::get('/unauthorized', function () {
    return view('unauthorized');
});