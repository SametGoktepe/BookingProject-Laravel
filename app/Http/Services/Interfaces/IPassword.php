<?php

namespace App\Http\Services\Interfaces;

use App\Http\Requests\ForgotPassword;
use App\Http\Requests\PasswordUpdateRequest;
use App\Http\Requests\VerfiyPin;

interface IPassword
{
    public function forgotPassword(ForgotPassword $request);
    public function verifyPin(VerfiyPin $request);
    public function resetPassword(PasswordUpdateRequest $request);
}
