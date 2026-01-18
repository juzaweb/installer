<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/juzaweb/cms
 * @license    MIT
 *
 * Created by JUZAWEB.
 * Date: 6/19/2021
 * Time: 11:22 AM
 */

namespace Juzaweb\Installer\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Juzaweb\Installer\Helpers\DatabaseManager;
use Juzaweb\Installer\Helpers\FinalInstallManager;
use Juzaweb\Installer\Helpers\InstalledFileManager;
use Juzaweb\Modules\Core\Models\User;

class InstallCommand extends Command
{
    protected $signature = 'juzaweb:install';

    protected array $user;

    public function handle(
        DatabaseManager $databaseManager,
        InstalledFileManager $fileManager,
        FinalInstallManager $finalInstall
    ) {
        $this->info('Juzaweb CMS Installtion');
        $this->info('-- Database Install');
        $databaseManager->run();
        $this->info('-- Publish assets');
        $finalInstall->runFinal();
        $this->info('-- Create user admin');
        $this->createAdminUser();
        $this->info('-- Update installed');
        $fileManager->update();
        $this->info('Juzaweb CMS Install Successfully !!!');
    }

    protected function createAdminUser(): void
    {
        $this->user['name'] = $this->ask('Full Name?');
        $this->user['email'] = $this->ask('Email?');
        $this->user['password'] = $this->ask('Password?');

        $validator = Validator::make($this->user, [
            'name' => 'required|max:150',
            'email' => 'required|email|max:150',
            'password' => 'required|max:32|min:6'
        ], [], [
            'name' => trans('juzaweb::app.name'),
            'email' => trans('juzaweb::app.email'),
            'password' => trans('juzaweb::app.password')
        ]);

        if ($validator->fails()) {
            $this->error($validator->errors()->messages()[0]);
            $this->createAdminUser();
        }

        DB::transaction(
            function () {
                $model = new User();
                $model->fill($this->user);
                $model->password = Hash::make($this->user['password']);
                $model->is_super_admin = 1;
                $model->save();
            }
        );
    }
}