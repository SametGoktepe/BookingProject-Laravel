<?php

namespace App\Http\Services\Repositories;

use App\Http\Requests\PasswordUpdateRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Services\Interfaces\IUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class UserRepository implements IUser
{
    public function me()
    {
        $user = Auth::user();
        if ($user) {
            return response()->json([
                'success' => true,
                'data' => $user
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], Response::HTTP_NOT_FOUND);
        }
    }

    public function show($user_id)
    {
    }

    public function update(ProfileUpdateRequest $request, $user_id)
    {
    }

    public function destroy($user_id)
    {
    }

    public function passwordReset(PasswordUpdateRequest $request)
    {
    }
}
