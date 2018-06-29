<?php

namespace BrightComponents\Actions;

use BrightComponents\Actions\Commands\ActionMakeCommand;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ActionServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/actions.php' => config_path('actions.php'),
            ]);
        }

        $this->mergeConfigFrom(__DIR__.'/../config/actions.php', 'actions');

        $this->commands([
            ActionMakeCommand::class,
        ]);
    }
}
