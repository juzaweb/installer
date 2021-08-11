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
 * Date: 6/13/2021
 * Time: 12:50 PM
 */

Route::group([
    'prefix' => 'install',
    'as' => 'installer::',
    'namespace' => 'Juzaweb\Installer\Http\Controllers',
    'middleware' => ['web', 'install']], function ()
{
    Route::get('/', [
        'as' => 'welcome',
        'uses' => 'WelcomeController@welcome',
    ]);

    Route::get('environment', [
        'as' => 'environmentWizard',
        'uses' => 'EnvironmentController@environment',
    ]);

    Route::post('environment', [
        'as' => 'environmentSaveWizard',
        'uses' => 'EnvironmentController@saveWizard',
    ]);

    Route::get('requirements', [
        'as' => 'requirements',
        'uses' => 'RequirementsController@requirements',
    ]);

    Route::get('permissions', [
        'as' => 'permissions',
        'uses' => 'PermissionsController@permissions',
    ]);

    Route::get('database', [
        'as' => 'database',
        'uses' => 'DatabaseController@database',
    ]);

    Route::get('admin', [
        'as' => 'admin',
        'uses' => 'AdminController@index',
    ]);

    Route::post('admin', [
        'as' => 'admin.save',
        'uses' => 'AdminController@save',
    ]);

    Route::get('final', [
        'as' => 'final',
        'uses' => 'FinalController@finish',
    ]);
});
