<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/juzaweb/cms
 * @license    MIT
 */

namespace Juzaweb\Installer\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Juzaweb\Installer\Helpers\Intaller;

class Installed
{
    public function handle($request, Closure $next)
    {
        dd('a');
        if (!Intaller::alreadyInstalled()) {
            if (strpos(Route::currentRouteName(), 'installer.') === false) {
                return redirect()->route('installer.welcome');
            }
        }

        return $next($request);
    }
}