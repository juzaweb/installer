<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzawebcms/juzawebcms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/juzawebcms/juzawebcms
 * @license    MIT
 *
 * Created by JUZAWEB.
 * Date: 6/12/2021
 * Time: 6:20 PM
*/

namespace Juzaweb\Installer\Helpers;


class Intaller
{
    /**
     * If application is already installed.
     *
     * @return bool
     */
    public static function alreadyInstalled()
    {
        return file_exists(static::installedPath());
    }

    public static function installedPath()
    {
        return storage_path('app/installed');
    }
}