<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(
            ['public/*', 'auth/*', 'gd_test/*', '/*'], 'App\Http\ViewComposers\PublicComposer'
            );
        
        view()->composer(
            ['client/*'], 'App\Http\ViewComposers\ClientComposer'
            );
                
        view()->composer('auth/login', function ($view) {
            $data = array('page_heading_content' => 'Log in to your account');
            $view->with('data', $data);
        });
            
            view()->composer('auth/logout', function ($view) {
                $data = array('page_heading_content' => 'Logout');
                $view->with('data', $data);
            });
                
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
