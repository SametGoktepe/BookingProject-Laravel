<?php

namespace App\Http\Services\Repositories;

use App\Http\Services\Interfaces\IPassword;
use App\Http\Requests\ForgotPassword;
use App\Http\Requests\PasswordUpdateRequest;
use App\Http\Requests\VerfiyPin;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordRepository implements IPassword
{
    public function forgotPassword(ForgotPassword $request)
    {
        $validated = Validator::make($request->all(), (new ForgotPassword)->rules());

        if ($validated->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validated->errors()->first()
            ], Response::HTTP_BAD_REQUEST);
        }

        $verify = User::where('email', $request->email)->exists();

        if ($verify) {
            $verify2 = DB::table('password_reset_tokens')->where('email', $request->email);

            if ($verify2->exists()) {
                $verify2->delete();
            }

            $token = rand(100000, 999999);
            $passwordReset = DB::table('password_reset_tokens')->insert([
                'email' => $request->email,
                'token' => $token,
                'created_at' => now()
            ]);

            if ($passwordReset) {
                Mail::to($request->email)->send(new \App\Mail\ResetPassword($token));

                return response()->json([
                    'status' => true,
                    'message' => 'Reset password code has been sent to your email'
                ], Response::HTTP_OK);
            }
        }

        return response()->json([
            'status' => false,
            'message' => 'Email not found'
        ], Response::HTTP_NOT_FOUND);
    }
    public function verifyPin(VerfiyPin $request)
    {
        $validated = Validator::make($request->all(), (new VerfiyPin)->rules());

        if ($validated->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validated->errors()->first()
            ], Response::HTTP_BAD_REQUEST);
        }

        $check = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token);

        if ($check->exists()) {
            $diff = Carbon::now()->diffInMinutes($check->first()->created_at);

            if ($diff > 5) {
                return response()->json([
                    'status' => false,
                    'message' => 'Token expired'
                ], Response::HTTP_BAD_REQUEST);
            }

            $check->delete();

            return response()->json([
                'status' => true,
                'message' => 'Token verified'
            ], Response::HTTP_OK);
        }

        return response()->json([
            'status' => false,
            'message' => 'Token not found'
        ], Response::HTTP_NOT_FOUND);
    }
    public function resetPassword(PasswordUpdateRequest $request)
    {
        $validated = Validator::make($request->all(), (new PasswordUpdateRequest)->rules());

        if ($validated->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validated->errors()->first()
            ], Response::HTTP_BAD_REQUEST);
        }

        $user = User::where('email', $request->email);
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Password updated'
        ], Response::HTTP_OK);
    }
}
