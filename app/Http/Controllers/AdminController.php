<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use Auth;
use Session;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Rules\CheckPassword;
class AdminController extends Controller
{
    // public function login()
    // {
    //     return User::create([
    //         'name' => 'admin',
    //         'email' => 'admin@admin.com',
    //         'password' => bcrypt('123456'),
    //     ]);
    // }

    
    public function login(Request $request)
    {
        if ($request->isMethod('POST')) {
            $data = $request->input();

            if (Auth::attempt(['email' => $data['email'], 'password' => $data['password'], 'admin' => 1 ])) {
                Log::info('success');
                return redirect('/admin/dashboard');
            } else {
                Log::info('failure');
                return redirect('/admin')->with('flash_error_message', 'Invalid Username or Password');
            }
        }
        
        return view('admin.admin_login');
    }
    
    public function register(Request $request)
    {
        Log::info("enters register");
        
        if ($request->isMethod('post')) {
            $data = $request->all();

            Log::info("enters post before validation");
    
            $rules = [
                'new_pwd' => 'required|min:4',
                'confirm_pwd' => 'required|min:4|same:new_pwd',
            ];
    
            $validator = Validator::make($data, $rules, $messages = [])
                ->setAttributeNames([
                    'new_pwd' => 'Password',
                    'confirm_pwd' => 'Confirm Password'
                ]);
    
            if ($validator->fails()) {
                Log::info("validator failed");
                return back()->withInput()->withErrors($validator->messages());
            } else {
                Log::info('success');
                // User::create([
                //     'name' => $data['name'],
                //     'email' => $data['email'],
                //     'password' => bcrypt($data['new_pwd']),
                //     'admin' => 1
                // ]);

                $user = new User;

                $user->name = $data['name'];
                $user->email = $data['email'];
                $user->password = bcrypt($data['new_pwd']);
                // TODO treba zabezpečiť registraciu a povoliť len od admina
                $user->admin = 1;

                $user->save();

                Auth::login($user);
                return redirect('/admin/dashboard')->with('flash_success_message', 'User has been registered');
            } 
        }

        return view('admin.admin_register');
    }

    public function logout()
    {
        Session::flush();
        return redirect('/admin')->with('flash_success_message', 'You were log out');
    }

    public function dashboard()
    {
        return view('admin.dashboard.dashboard');
    }

    public function account_settings()
    {
        return view('admin.dashboard.account_settings');
    }

    public function update_password(Request $request)
    {
        $data = $request->all();

        $user = User::where(['email' => Auth::user()->email])->first();
        $rules = [
            'current_pwd' => ['required', 'min:4', new CheckPassword($user->password)],
            'new_pwd' => 'required|min:4',
            'confirm_pwd' => 'required|min:4|same:new_pwd',
        ];

        $messages = [
            'confirm_pwd.same' => ' Confirm Password should match the Password',
        ];
        $validator = Validator::make($data, $rules, $messages)
            ->setAttributeNames([
                'current_pwd' => 'Current Password',
                'new_pwd' => 'New Password',
                'confirm_pwd' => 'Confirm Password'
            ]);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator->messages());
        }

        if ($request->isMethod('POST')) {
            if (Hash::check($data['current_pwd'], $user->password)) {
                $password = bcrypt($data['new_pwd']);
                $user->update(['password' => $password]);
                return redirect('/admin/account_settings')->with('flash_success_message', 'The password was not changed successfully');
            } else {
                return redirect('/admin/account_settings')->with('flash_error_message', 'The password change failed');
            }
        }
    }
}
