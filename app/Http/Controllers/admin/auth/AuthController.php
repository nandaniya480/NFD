<?php

namespace App\Http\Controllers\admin\auth;

use App\Http\Controllers\Controller;
use App\Models\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function login()
    {
        return view('admin.auth.login');
    }

    public function loginVerify(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];
        $messages = [
            'email.email' => 'Please enter a valid email address'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator, 'login')
                ->withInput();
        } else {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'user_type' => '0'])) {
                Session::flash('success', trans('messages.login_successfully'));
                return to_route('dashboard');
            } else {
                Session::flash('error', trans('messages.in_correct_credentials'));
                return to_route('login');
            }
        }
    }

    public function logout()
    {
        Auth::logout();
        Session::flash('success', trans('messages.logout'));
        return to_route('login');
    }

    public function resetPassword($token)
    {   
        $tokenEmail = PasswordReset::getEmailByToken($token);
        return view('admin.auth.reset-password',compact('tokenEmail','token'));
    }
}
