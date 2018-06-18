<?php

namespace User\Providers;

use Faker\Factory as FakerFactory;
use Faker\Generator as FakerGenerator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Pluma\Support\Auth\AuthServiceProvider;
use User\Models\User;
use User\Policies\UserPolicy;

class UserServiceProvider extends AuthServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class => UserPolicy::class,
    ];

    /**
     * Array of observable models.
     *
     * @var array
     */
    protected $observables = [
        [\User\Models\User::class, '\User\Observers\UserObserver'],
        [\User\Models\Detail::class, '\User\Observers\DetailObserver'],
    ];

    /**
     * The provider class names.
     *
     * @var array
     */
    protected $providers = [
        PasswordServiceProvider::class,
    ];

    /**
     * Boot the service.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        $this->bootBladeDirectives();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        parent::register();

        $this->registerEloquentFactory();
    }

    /**
     * Registers additional Blade Directives in the context of this module.
     *
     * @return void
     */
    protected function bootBladeDirectives()
    {
        Blade::directive('user', function ($expression) {
            return "<?php if (user()->id === $expression) : ?>";
        });

        Blade::directive('enduser', function () {
            return "<?php endif; ?>";
        });

        Blade::directive('owned', function ($expression) {
            return "<?php if (user()->id === $expression) : ?>";
        });

        Blade::directive('endowned', function () {
            return "<?php endif; ?>";
        });
    }

    /**
     * Register the Eloquent factory instance in the container.
     *
     * @return void
     */
    protected function registerEloquentFactory()
    {
        $factoryPath = get_module('user').'/'.$this->app->databasePath('factories');

        $this->app->singleton(FakerGenerator::class, function ($app) {
            return FakerFactory::create($app['config']->get('database.faker_locale', 'en_US'));
        });

        $this->app->singleton(EloquentFactory::class, function ($app) {
            return EloquentFactory::construct(
                $app->make(FakerGenerator::class), $factoryPath
            );
        });
    }
}
