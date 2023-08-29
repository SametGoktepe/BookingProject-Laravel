<?php

namespace App\Http\Services\Interfaces;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;

interface IAuth
{
    public function register(RegisterRequest $request);
    public function login(LoginRequest $request);
    public function logout();
}
