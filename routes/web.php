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
use App\Http\Controllers\BioController;

use App\Models\PostKerja;


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

    Route::get('/candidate', [JobPostController::class, 'candidate'])->name('job.candidate');

    Route::get('tracking-lamaran', [LamaranController::class, 'tracking'])->name('job.tracking');

    Route::post('/job', [JobPostController::class, 'store'])->name('job.store');
    Route::post('/job/{job}/apply', [LamaranController::class, 'store'])->name('job.apply');
    Route::get('/job/{id}/edit', [JobPostController::class, 'edit'])->name('job.edit');
    Route::put('/job/{id}', [JobPostController::class, 'update'])->name('job.update');
    Route::delete('/job/{id}', [JobPostController::class, 'destroy'])->name('job.destroy');

    Route::post('/interview/store', [InterviewController::class, 'store'])->name('interview.store');
    Route::post('/interview/{id}/note', [InterviewController::class, 'storeNote'])->name('interview.storeNote');
    Route::put('/interview/{id}/note', [InterviewController::class, 'updateNote'])->name('interview.update.note');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/profile', [BioController::class, 'store'])->name('bio.store');

    Route::resource('forums', ForumController::class);

    Route::get('/calendar', [InterviewController::class, 'showCalendar'])->name('calendar');
});

// routes/web.php
Route::get('/match/{job_id}/{user_id}', [App\Http\Controllers\RecommendationController::class, 'match']);

// Route untuk Role Management
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/roles', [RoleController::class, 'index']);
});

Route::middleware(['auth', 'role:perusahaan'])->group(function () {
    Route::post('/test/send', [TestController::class, 'send'])->name('test.send');
    Route::post('/application/reject', [LamaranController::class, 'reject'])->name('application.reject');
});

require __DIR__.'/auth.php';
