<?php

namespace App\Http\Services\Interfaces;

use App\Http\Requests\PasswordUpdateRequest;
use App\Http\Requests\ProfileUpdateRequest;

interface IUser
{
    public function me();
    public function show($user_id);
    public function update(ProfileUpdateRequest $request, $user_id);
    public function destroy($user_id);
    public function passwordReset(PasswordUpdateRequest $request);
}
