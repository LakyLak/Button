<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use Auth;
use Session;


class AdminController extends Controller
{

    public function login(Request $request)
    {
        Log::debug('general login');

        // $this->validate($request, [
        //     'email' => 'required|email|unique:users',
        //     'first_name' => 'required|max:24',
        //     'last_name' => 'required|max:24',
        //     'password' => 'required|min:4'
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
}
