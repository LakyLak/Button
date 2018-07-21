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

    public function login(Request $request)
    {
        // $this->validate($request, [
            // 'email' => 'required|email|unique:users',
            // 'password' => 'required|min:4'
        // ]);
        
        if ($request->isMethod('POST')) {
            $data = $request->input();
            // $data = $request;
            // Log::info('data: ' . print_r($request['email'], true));
            // return redirect('/admin/dashboard');
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

    public function logout()
    {
        Session::flush();
        return redirect('/admin')->with('flash_success_message', 'You were log out');
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function account_settings()
    {
        return view('admin.account_settings');
    }

    // public function check_password(Request $request)
    // {
    //     $data = $request->all();
    //     $current_password = $data['current_pwd'];
    //     $check_password = User::where(['admin' => 1])->first();
    //     if(Hash::check($current_password, $check_password)) {
    //         echo 'true'; die;
    //     } else {
    //         echo 'false'; die;
    //     }   
    // }

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
            // echo "<pre>"; print_r($data); die;
            
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
