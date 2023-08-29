<?php

namespace App\Http\Services\Repositories;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\LoginResource;
use App\Http\Resources\RegisterResource;
use App\Http\Services\Interfaces\IAuth;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class AuthRepository implements IAuth
{
    public function register(RegisterRequest $request)
    {
        $validate = Validator::make($request->all(), (new RegisterRequest())->rules());

        if ($validate->fails()) {
            return response()->json([
                'message' => $validate->errors()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'dob' => $request->dob,
            'age' => Carbon::parse($request->dob)->age,
            'phone' => $request->phone,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => RegisterResource::make($user),
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function login(LoginRequest $request)
    {
        $validate = Validator::make($request->all(), (new LoginRequest())->rules());

        if ($validate->fails()) {
            return response()->json([
                'message' => $validate->errors()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }

        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }

        if (Auth::attempt($credentials)) {
            $user = User::where('email', $request->email)->first();
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'user' => LoginResource::make($user),
                'access_token' => $token,
                'token_type' => 'Bearer',
            ], Response::HTTP_OK);
        }
    }

    public function logout()
    {
        DB::table('personal_access_tokens')->where('tokenable_id', auth()->user()->id)->delete();
        return response()->json([
            'message' => 'Logged out',
        ], Response::HTTP_OK);
    }
}
