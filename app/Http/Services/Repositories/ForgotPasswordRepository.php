<?php

namespace App\Http\Services\Repositories;

use App\Http\Services\Interfaces\IPassword;
use App\Http\Requests\ForgotPassword;
use App\Http\Requests\PasswordUpdateRequest;
use App\Http\Requests\VerfiyPin;


class ForgotPasswordRepository implements IPassword
{
    public function forgotPassword(ForgotPassword $request)
    {
    }
    public function verifyPin(VerfiyPin $request)
    {
    }
    public function resetPassword(PasswordUpdateRequest $request)
    {
    }
    public function resend(ForgotPassword $request)
    {
    }
}
