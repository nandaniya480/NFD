<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailTemplate extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'email_templates';

    const FORGOT_EMAIl_TEMPLATE = '1';
    const OTP_EMAIl_TEMPLATE = 'otp';

    public static function getFogotEmailTemplate()
    {
        return EmailTemplate::where('id', self::FORGOT_EMAIl_TEMPLATE)->first();
    }

    public static function getOtpTemplate()
    {
        return EmailTemplate::where('mail_for', self::OTP_EMAIl_TEMPLATE)->first();
    }
}
