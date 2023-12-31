<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\EmailVerify;
use App\Http\Requests\PasswordUpdateRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Services\Repositories\EmailVerifyRepository;
use App\Http\Services\Repositories\UserRepository;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected UserRepository $userRepository;
    protected EmailVerifyRepository $emailVerifyRepository;

    public function __construct(UserRepository $userRepository, EmailVerifyRepository $emailVerifyRepository)
    {
        $this->userRepository = $userRepository;
        $this->emailVerifyRepository = $emailVerifyRepository;
    }

    public function me()
    {
        return $this->userRepository->me();
    }

    public function show($user_id)
    {
        return $this->userRepository->show($user_id);
    }

    public function update(ProfileUpdateRequest $request, $user_id)
    {
        return $this->userRepository->update($request, $user_id);
    }

    public function destroy($user_id)
    {
        return $this->userRepository->destroy($user_id);
    }

    public function updatePassword(PasswordUpdateRequest $request, $user_id)
    {
        return $this->userRepository->updatePassword($request, $user_id);
    }

    public function addAddress(AddressRequest $request)
    {
        return $this->userRepository->addressAdd($request);
    }

    public function updateAddress(AddressRequest $request, $user_id, $address_id)
    {
        return $this->userRepository->addressUpdate($request, $user_id, $address_id);
    }

    public function verifyEmail(EmailVerify $request)
    {
        return $this->emailVerifyRepository->verify($request);
    }

    public function resendEmail()
    {
        return $this->emailVerifyRepository->resend();
    }
}
