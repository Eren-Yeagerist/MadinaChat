<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Notification;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function ($view) {
            if (auth()->check()) {
                $notifications = Notification::where('recipient', auth()->user()->id)
                                ->where('status', 0)
                                ->get();
                $view->with('numNotifications', $notifications);
            }
        });
    }
}
