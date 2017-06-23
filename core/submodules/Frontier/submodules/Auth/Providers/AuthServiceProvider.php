<?php

namespace Auth\Providers;

use Auth\Middleware\RedirectToDashboardIfAuthenticated;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The app's router instance.
     *
     * @var Illuminate\Routing\Router
     */
    protected $router;

    /**
     * Boot the service.
     *
     * @return void
     */
    public function boot()
    {
        $this->bootRouter();
    }

    /**
     * Boot the router instance.
     *
     * @return void
     */
    public function bootRouter()
    {
        $this->router = $this->app['router'];

        // $this->router->middleware('auth.admin', AuthenticateAdmin::class);
        // $this->router->middleware('roles', CheckRole::class);
        $this->router->middleware('auth.guest', RedirectToDashboardIfAuthenticated::class);
    }
}
