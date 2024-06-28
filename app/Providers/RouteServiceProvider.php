<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/espacio';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::middleware('web', 'auth')
                ->prefix('espacio')
                ->group(base_path('routes/espacio.php'));

            Route::middleware('web', 'auth')
                ->prefix('accesos')
                ->group(base_path('routes/accesos.php'));

            Route::middleware('web', 'auth')
                ->prefix('personal')
                ->group(base_path('routes/personal.php'));

            Route::middleware('web', 'auth')
                ->prefix('legajo')
                ->group(base_path('routes/legajo.php'));

            Route::middleware('web', 'auth')
                ->prefix('vacaciones')
                ->group(base_path('routes/vacaciones.php'));

            Route::middleware('web', 'auth')
                ->prefix('licencias')
                ->group(base_path('routes/licencias.php'));

            Route::middleware('web', 'auth')
                ->prefix('logistica')
                ->group(base_path('routes/logistica.php'));

            Route::middleware('web', 'auth')
                ->prefix('bincautados')
                ->group(base_path('routes/bincautados.php'));

            Route::middleware('web', 'auth')
                ->prefix('informatica')
                ->group(base_path('routes/informatica.php'));
        });
    }
}
