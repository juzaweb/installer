<?php
/**
 * MYMO CMS - Free Laravel CMS
 *
 * @package    juzawebcms/juzawebcms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/juzawebcms/juzawebcms
 * @license    MIT
 *
 * Created by The Anh.
 * Date: 6/12/2021
 * Time: 5:58 PM
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
        if (!Intaller::alreadyInstalled()) {
            if (strpos(Route::currentRouteName(), 'installer::') === false) {
                return redirect()->route('installer::welcome');
            }
        }

        return $next($request);
    }
}