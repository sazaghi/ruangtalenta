<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SidebarController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\JobPostController;
use App\Http\Controllers\LamaranController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\InterviewController;
use App\Http\Controllers\NotificationController;
use App\Models\PostKerja;
use App\Http\Controllers\PortofolioController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\CourseController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $jobs = PostKerja::latest()->take(5)->get(); // Ambil 5 pekerjaan terbaru
    return view('welcome', compact('jobs'));
})->name('home');

// Route dashboard dengan akses berdasarkan role
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/job-applicants/{id}', [DashboardController::class, 'getJobApplicants']);

    Route::get('/chart-data/{job}', [DashboardController::class, 'getChartData']);

    Route::get('/job', [JobPostController::class, 'index'])->name('job.index');
    Route::get('/alljob', [JobPostController::class, 'show'])->name('job.show');
    Route::get('/filterjob', [JobPostController::class, 'alljob'])->name('job.alljob');

    Route::get('tracking-lamaran', [LamaranController::class, 'tracking'])->name('job.tracking');

    Route::post('/job', [JobPostController::class, 'store'])->name('job.store');
    Route::post('/job/{job}/apply', [LamaranController::class, 'store'])->name('job.apply');
    Route::get('/job/{id}/edit', [JobPostController::class, 'edit'])->name('job.edit');
    Route::put('/job/{id}', [JobPostController::class, 'update'])->name('job.update');
    Route::delete('/job/{id}', [JobPostController::class, 'destroy'])->name('job.destroy');




    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('forums', ForumController::class);

    Route::post('/interview/schedule', [InterviewController::class, 'schedule'])->name('interview.schedule');


    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');

    Route::get('/portfolio', [PortofolioController::class, 'index'])->name('portfolio');
    Route::post('/cv-upload', [PortofolioController::class, 'uploadCV'])->name('cv.upload');
    Route::post('/education-store', [PortofolioController::class, 'storeEducation'])->name('education.store');

    Route::get('/save-candidates', function () {
        return view('savecandidate');
    });


    Route::get('/posting-lowongan', function () {
        return view('posting-lowongan');
    })->name('posting.lowongan');


    Route::get('/newuserprofile', function () {
        return view('newuserprofile');
    });

});

// Route untuk Role Management
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/roles', [RoleController::class, 'index']);
});

Route::get('/jadwal', [JadwalController::class, 'index']);

Route::get('/test-notification', [DashboardController::class, 'sendNotification'])->name('test.notification')->middleware('auth');

Route::get('/navbar', function() {
    return view('newsidebarpencarikerja');
});



require __DIR__.'/auth.php';
