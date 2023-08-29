<?php

namespace App\Http\Services\Interfaces;

use App\Http\Requests\EmailVerify;

interface IEmailVerify
{
    public function verify(EmailVerify $request);
    public function resend();
}
