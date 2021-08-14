<?php

namespace Juzaweb\Installer\Http\Middleware;

use Closure;
use Juzaweb\Installer\Helpers\Intaller;

class CanInstall
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\RedirectResponse|mixed
     */
    public function handle($request, Closure $next)
    {
        if (Intaller::alreadyInstalled()) {
            return redirect()->home();
        }

        return $next($request);
    }
}
