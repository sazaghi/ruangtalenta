<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SidebarController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\JobPostController;
use App\Http\Controllers\LamaranController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\InterviewController;
use App\Http\Controllers\BioController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserUploadController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\WorkExperienceController;
use App\Http\Controllers\Auth\RegisteredUserController;

use App\Models\PostKerja;


use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $jobs = PostKerja::latest()->take(3)->get();
    $categories = \App\Models\Category::all();
    $categoryImages = [
        asset('images/Category1.png'),
        asset('images/Category2.png'),
        asset('images/Category3.png'),
        asset('images/Category4.png'),
        asset('images/Category5.png'),
        asset('images/Category6.png'),
    ];
    return view('welcome', compact('jobs', 'categories', 'categoryImages'));
})->name('home');

Route::get('/register-perusahaan', [RegisteredUserController::class, 'perusahaanregister'])->name('register.perusahaan');

// Route dashboard dengan akses berdasarkan role
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/job-applicants/{id}', [DashboardController::class, 'getJobApplicants']);

    Route::get('/chart-data/{job}', [DashboardController::class, 'getChartData']);

    Route::get('/job', [JobPostController::class, 'index'])->name('job.index');
    Route::get('/alljob', [JobPostController::class, 'show'])->name('job.show');
    Route::get('/filterjob', [JobPostController::class, 'filtering'])->name('job.filtering');
    Route::get('/alljob/{id}', [JobPostController::class, 'detail'])->name('job.detail');

    Route::get('/candidate', [JobPostController::class, 'candidate'])->name('job.candidate');

    Route::get('tracking-lamaran', [LamaranController::class, 'tracking'])->name('job.tracking');
    Route::post('/lamaran/finalize/{id}', [LamaranController::class, 'finalize'])->name('lamaran.finalize');

    Route::post('/job', [JobPostController::class, 'store'])->name('job.store');
    Route::post('/job/{job}/apply', [LamaranController::class, 'store'])->name('job.apply');
    Route::get('/job/{id}/edit', [JobPostController::class, 'edit'])->name('job.edit');
    Route::put('/job/{id}', [JobPostController::class, 'update'])->name('job.update');
    Route::delete('/job/{id}', [JobPostController::class, 'destroy'])->name('job.destroy');

    Route::post('/shortlist', [LamaranController::class, 'shortlistApplicants'])->name('shortlist.run');

    Route::post('/interview/store', [InterviewController::class, 'store'])->name('interview.store');
    Route::post('/interview/{id}/note', [InterviewController::class, 'storeNote'])->name('interview.storeNote');
    Route::put('/interview/{id}/note', [InterviewController::class, 'updateNote'])->name('interview.update.note');
    Route::post('/interview/{id}/finalize', [InterviewController::class, 'finalizeResult'])->name('interview.finalize');

    Route::get('/setting', [ProfileController::class, 'settingEdit'])->name('setting.edit');
    Route::patch('/setting', [ProfileController::class, 'settingUpdate'])->name('setting.update');
    Route::delete('/setting', [ProfileController::class, 'destroy'])->name('setting.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::post('/profile', [BioController::class, 'store'])->name('bio.store');

    Route::post('/educations', [EducationController::class, 'store'])->name('educations.store');
    Route::delete('/educations/{id}', [EducationController::class, 'destroy'])->name('educations.destroy');

    Route::post('/work-experiences', [WorkExperienceController::class, 'store'])->name('work-experiences.store');
    Route::delete('/work-experiences/{id}', [WorkExperienceController::class, 'destroy'])->name('work-experiences.destroy');


    Route::post('/bio/education', [BioController::class, 'storeEducation'])->name('bio.education.store');

    Route::get('/calendar', [InterviewController::class, 'showCalendar'])->name('calendar');
    Route::get('/userCalendar', [InterviewController::class, 'userShowCalendar'])->name('calendar.user');

    // Forum Routes
    Route::get('/forums', [PostController::class, 'index'])->name('post.index');
    Route::post('/forums', [PostController::class, 'store'])->name('post.store');
    Route::get('/forums/{id}', [PostController::class, 'show'])->name('post.show');
    Route::post('/forum/{parent_id}/reply', [PostController::class, 'reply'])->name('post.reply');

    Route::get('/uploads', [UserUploadController::class, 'index'])->name('user_uploads.index');
    Route::post('/uploads', [UserUploadController::class, 'store'])->name('user_uploads.store');
    Route::delete('/uploads/{upload}', [UserUploadController::class, 'destroy'])->name('user_uploads.destroy');

});

// routes/web.php
Route::get('/match/{job_id}/{user_id}', [App\Http\Controllers\RecommendationController::class, 'match']);
Route::get('/rekomendasi-kursus/{job_id}', [App\Http\Controllers\RecommendationController::class, 'rekomendasi']);
Route::get('/rekomendasi-kursus2/{job_id}', [App\Http\Controllers\RecommendationController::class, 'rekomendasi2']);

// Route untuk Role Management
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/roles', [RoleController::class, 'index']);
});


require __DIR__.'/auth.php';
