<?php

namespace App\Http\Controllers\admin\auth;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Session;

use App\Helpers\MailHelper;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use App\Models\PasswordReset;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    /* Forgot Password View */
    public function forgotPassword()
    {
        $data['pageTitle'] = 'Admin Forgot Password';
        return view('admin.auth.forgot-password', $data);
    }

    /* Verify Email */
    public function verifyEmail(Request $request)
    {
        $rules = [
            'email' => 'required|email',
        ];
        $messages = [
            'email.email' => 'Please enter a valid email address'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator, 'forgotpassword')
                ->withInput();
        } else {
            $user = User::getUserByEmail($request->email);
            if ($user) {
                $token = Str::random(64);

                PasswordReset::create([
                    'email' => $request->email,
                    'token' => $token
                ]);
                try {
                    $emailTemplate = EmailTemplate::getFogotEmailTemplate();
                    $html = $emailTemplate->html;
                    $link = route('reset.password', $token);
                    $html = str_replace('{{LINK}}', $link, $html);

                    MailHelper::mail_send($token, $request, $emailTemplate->subject, $html);
                    Session::flash('success', trans('messages.mail_send_successfully'));
                    return redirect()->back();
                } catch (Exception $e) {
                    return back()->withError($e->getMessage());
                }
            } else {
                Session::flash('error', trans('messages.email_not_exits'));
                return redirect()->back();
            }
        }
    }

    public function resetPassword(Request $request)
    {
        $updatePassword = PasswordReset::getEmailByToken($request->token);
        if ($updatePassword && $updatePassword != null) {
            $adminPassword = User::where('email', $updatePassword->email)->first();
                User::where('email', $updatePassword->email)
                    ->update(['password' => Hash::make($request->password)]);
                PasswordReset::where(['email' => $updatePassword->email])->delete();
                return redirect()->back();
        } else {
            Session::flash('error', 'Invalid token');
            return to_route('');
        }
    }
}
