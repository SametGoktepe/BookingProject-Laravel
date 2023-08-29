<?php

namespace App\Http\Services\Repositories;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\LoginResource;
use App\Http\Resources\RegisterResource;
use App\Http\Services\Interfaces\IAuth;
use App\Mail\VerifyEmail;
use App\Models\EmailVerify;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use PharIo\Manifest\Email;

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

        if ($user) {
            $verify2 = EmailVerify::where('email', $request->email);

            if ($verify2->exists()) {
                $verify2->delete();
            }

            $pin = rand(100000, 999999);
            EmailVerify::create([
                'email' => $request->email,
                'token' => $pin,
            ]);

            Mail::to($request->email)->send(new VerifyEmail($pin));
        }

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
