<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Services\Repositories\AuthRepository;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected AuthRepository $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function register(RegisterRequest $request)
    {
        return $this->authRepository->register($request);
    }

    public function login(LoginRequest $request)
    {
        return $this->authRepository->login($request);
    }

    public function logout()
    {
        return $this->authRepository->logout();
    }
}
