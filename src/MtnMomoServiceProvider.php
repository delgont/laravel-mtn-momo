<?php

namespace Delgont\MtnMomo;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

use Delgont\MtnMomo\Concerns\RegistersCommands;

class MtnMomoServiceProvider extends ServiceProvider
{
    use RegistersCommands;
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerCommands();
    }

    
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/momo.php' => config_path('momo.php')
        ], 'mtn-momo-config');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

  
}
