<?php


namespace Lenna\Admin;


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Filesystem\Filesystem;
use Lenna\Admin\Console\InstallCommand;
use Lenna\Admin\Console\GenerateViewCommand;
use Lenna\Admin\Http\Middleware\Permission;
use Lenna\Admin\View\Components\Menu as BladeComponentsMenu;
use Lenna\Admin\View\Components\HeaderBreadcrumb as BladeComponentsHeaderBreadcrumb;

class AdminServiceProvider extends ServiceProvider
{

    protected $routeMiddleware = [
        'admin.permission' => Permission::class
    ];

    private $middlewareGroups = [
        'admin' => [
            'admin.permission'
        ]
    ];

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function boot(): void
    {
        $this->registerViews();
        $this->ensureHttps();
        $this->settingRoute();
        $this->registerRouteMiddleware();
        $this->loadViewComponentsAs('lara-adm',[
            BladeComponentsMenu::class,
            BladeComponentsHeaderBreadcrumb::class
        ]);

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/admin.php', 'admin');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['admin'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/admin.php' => config_path('admin.php'),
        ], 'admin.config');

        $this->publishes([
            __DIR__.'/../database/migrations/create_admin_tables.php' => $this->getMigrationFileName('create_admin_tables.php'),
        ], 'migrations');

        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/lenna'),
        ], 'admin.views');

        // Publishing assets.
        $this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/lenna'),
        ], 'admin.views');

        // Publishing the translation files.
        $this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/lenna'),
        ], 'admin.views');

        // Registering package commands.
        $this->commands([
            InstallCommand::class,
            GenerateViewCommand::class
        ]);
    }

    /**
     * 是否强制使用https.
     *
     * @return void
     */
    private function ensureHttps()
    {
        if (config('admin.https')) {
            URL::forceScheme('https');
            $this->app['request']->server->set('HTTPS', true);
        }
    }

    protected function registerViews()
    {
        $this->loadTranslationsFrom(config('admin.lang',__DIR__.'/../resources/lang'), 'lenna-admin');
        $this->loadViewsFrom(config('admin.views',__DIR__ . '/../resources/views'), 'lenna-admin');
    }


    /**
     * setting basic route
     * @return void
     */
    protected function settingRoute()
    {
        RouteLoader::loadRbacRoute();
    }

    /**
     * Register Route Middleware
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function registerRouteMiddleware()
    {
        /** @var \Illuminate\Routing\Router $router */
        $router = $this->app->make('router');

        // register route middleware.
        foreach ($this->routeMiddleware as $key => $middleware) {
            $router->aliasMiddleware($key, $middleware);
        }

        // register middleware group.
        foreach ($this->middlewareGroups as $key => $middleware) {
            $router->middlewareGroup($key, $middleware);
        }
    }

    /**
     * Returns existing migration file if found, else uses the current timestamp.
     * @param $migrationFileName
     * @return string
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function getMigrationFileName($migrationFileName): string
    {
        $timestamp = date('Y_m_d_His');

        /** @var Filesystem $filesystem */
        $filesystem = $this->app->make(Filesystem::class);

        return Collection::make($this->app->databasePath().DIRECTORY_SEPARATOR.'migrations'.DIRECTORY_SEPARATOR)
            ->flatMap(function ($path) use ($filesystem, $migrationFileName) {
                return $filesystem->glob($path.'*_'.$migrationFileName);
            })
            ->push($this->app->databasePath()."/migrations/{$timestamp}_{$migrationFileName}")
            ->first();
    }
}
