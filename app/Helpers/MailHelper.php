<?php


namespace App\Helpers;

use Illuminate\Support\Facades\Mail;
use Exception;


class MailHelper
{
    public static function mail_send($token, $request,$subject, $html)
    {
        try {
            Mail::send('admin.email-template.forgot-password', ['token' => $token, 'emailtemplate' => $html], function ($message) use ($request,$subject) {
                $message->to($request->email);
                $message->subject($subject);
            });
            return  '1';
        } catch (Exception $e) {
            return $e;
        }
    }
}
