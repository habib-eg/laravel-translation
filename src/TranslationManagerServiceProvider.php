<?php

namespace Habib\TranslationManager;


use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

/**
 * Class TranslationManagerServiceProvider
 *
 * @package Habib\TranslationManager
 */
class TranslationManagerServiceProvider extends ServiceProvider
{

    /**
     * @var string
     */
    protected $path = __DIR__ . "/../resources/";

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishResources();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        $this->loadViewsFrom("{$this->path}views", 'translation_manager');
        $this->mergeConfigFrom("{$this->path}config/translation_manager.php", 'translation_manager');
        Route::mixin(new RouterTranslationManager());
    }

    /**
     * publish resources files
     *
     * @return $this
     */
    protected function publishResources()
    {
        $this->publishes([
            "{$this->path}views" => resource_path('views/vendor/new_translation_manager'),
        ], 'views translation');

        $this->publishes([
            "{$this->path}assets" => public_path('vendor/translation_manager'),
        ], 'assets');

        $this->publishes([
            "{$this->path}config/translation_manager.php" => config_path('translation_manager.php'),
        ], 'config');

        return $this;
    }

}
