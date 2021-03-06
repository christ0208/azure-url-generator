<?php

namespace Xtrics\AzureUrlGenerator;

use Illuminate\Support\ServiceProvider;

class GeneratorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/azure_basic.php' => config_path('azure_basic.php'),
        ]);
    }
}