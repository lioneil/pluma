<?php

namespace Pluma\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckIfInstalled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        try {
            // First, check if can connect to database
            DB::connection()->getPdo();

            // Then, check if .install is deleted
            if (file_exists(base_path('.install'))) {
                return redirect('/');
            }
        } catch (\PDOException $e) {
            return redirect('/');
        } catch (\InvalidArgumentException $e) {
            return redirect('/');
        }

        return $next($request);
    }
}
