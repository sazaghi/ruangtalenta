<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Lamaran;
use App\Models\PostKerja;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
{
    View::composer('*', function ($view) {
        $notifications = [];

        if (Auth::check()) {
            $user = Auth::user();

            if ($user->hasRole('perusahaan')) {
                $jobIds = PostKerja::where('user_id', $user->id)->pluck('id');
                $notifications = Lamaran::with('postKerja')
                    ->whereIn('post_kerjas_id', $jobIds)
                    ->latest()
                    ->take(5)
                    ->get();
            } elseif ($user->hasRole('pencarikerja')) {
                $notifications = Lamaran::with('postKerja')
                    ->where('user_id', $user->id)
                    ->whereNotNull('status')
                    ->latest()
                    ->take(5)
                    ->get();
            }
        }

        $view->with('notifications', $notifications);
    });
}       
}
