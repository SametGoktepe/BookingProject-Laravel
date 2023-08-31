<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPassword;
use App\Http\Requests\PasswordUpdateRequest;
use App\Http\Requests\VerfiyPin;
use App\Http\Services\Repositories\ForgotPasswordRepository;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    protected ForgotPasswordRepository $forgotPasswordRepository;

    public function __construct(ForgotPasswordRepository $forgotPasswordRepository)
    {
        $this->forgotPasswordRepository = $forgotPasswordRepository;
    }

    public function forgotPassword(ForgotPassword $request)
    {
        return $this->forgotPasswordRepository->forgotPassword($request);
    }

    public function verifyPin(VerfiyPin $request)
    {
        return $this->forgotPasswordRepository->verifyPin($request);
    }

    public function resetPassword(PasswordUpdateRequest $request)
    {
        return $this->forgotPasswordRepository->resetPassword($request);
    }
}
