<?php

namespace App\Providers;

use App\Models\Footer;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        try {
            $footer = Footer::latest()->first();
            View::share('footerContent', $footer ? $footer : 'Default Footer Content');
        } catch (\Illuminate\Database\QueryException $e) {
            // Log the error and provide fallback content
            \Log::error('Error fetching footer: ' . $e->getMessage());
            View::share('footerContent', 'Default Footer Content');
        }
    }
}
