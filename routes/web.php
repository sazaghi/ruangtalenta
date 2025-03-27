<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SidebarController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\JobPostController;
use App\Http\Controllers\LamaranController;
use App\Http\Controllers\ForumController;
use App\Models\PostKerja;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route dashboard dengan akses berdasarkan role
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/job', function () { 
        return view('jobsubmit.submit');
    })->name('job.form');

    Route::get('/job/tracking-lamaran', [LamaranController::class, 'tracking'])->name('job.track');

    Route::post('/job', [JobPostController::class, 'store'])->name('postkerja');
    Route::post('/job/{job}/apply', [LamaranController::class, 'store'])->name('job.apply');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('forums', ForumController::class);
    Route::get('forums/{forum}/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('forums/{forum}/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('posts/{post}', [PostController::class, 'show'])->name('posts.show');
    Route::post('posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
});

Route::get('/', function () {
    $jobs = PostKerja::latest()->take(5)->get(); // Ambil 5 pekerjaan terbaru
    return view('welcome', compact('jobs'));
});

// Route untuk Role Management
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/roles', [RoleController::class, 'index']);
});

require __DIR__.'/auth.php';
