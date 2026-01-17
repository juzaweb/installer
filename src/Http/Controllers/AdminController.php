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
 * Date: 6/13/2021
 * Time: 12:50 PM
 */

namespace Juzaweb\Installer\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Juzaweb\Modules\Admin\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        return view('installer::admin');
    }

    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:150',
            'email' => 'required|email|max:150',
            'password' => 'required|max:32|min:8|confirmed',
            'password_confirmation' => 'required|max:32|min:8',
        ], [], [
            'name' => trans('juzaweb::app.name'),
            'email' => trans('juzaweb::app.email'),
            'password' => trans('juzaweb::app.password'),
            'password_confirmation' => trans('juzaweb::app.confirm_password')
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('installer.admin')
                ->withInput()
                ->withErrors($validator->errors());
        }

        DB::transaction(
            function () use ($request) {
                $model = new User();
                $model->fill($request->all());
                $model->password = Hash::make($request->post('password'));
                $model->is_super_admin = 1;
                $model->save();
            }
        );

        return redirect()->route('installer.final')
            ->with(['message' => trans('installer::message.final.finished')]);
    }
}