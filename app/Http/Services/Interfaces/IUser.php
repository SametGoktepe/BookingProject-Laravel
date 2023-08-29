<?php

namespace App\Http\Services\Interfaces;

use App\Http\Requests\AddressRequest;
use App\Http\Requests\PasswordUpdateRequest;
use App\Http\Requests\ProfileUpdateRequest;

interface IUser
{
    public function me();
    public function show($user_id);
    public function update(ProfileUpdateRequest $request, $user_id);
    public function destroy($user_id);
    public function updatePassword(PasswordUpdateRequest $request, $user_id);
    public function addressAdd(AddressRequest $request);
    public function addressUpdate(AddressRequest $request, $user_id, $address_id);
}
