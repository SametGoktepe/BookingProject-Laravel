<?php

namespace App\Http\Services\Repositories;

use App\Http\Requests\EmailVerify;
use App\Http\Services\Interfaces\IEmailVerify;
use App\Mail\VerifyEmail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class EmailVerifyRepository implements IEmailVerify
{
    public function verify(EmailVerify $request)
    {
        $validate = Validator::make($request->all(), (new EmailVerify())->rules());

        if ($validate->fails()) {
            return response()->json([
                'message' => $validate->errors()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }

        $emailVerify = DB::table('email_verifies')->where('email', $request->email)->first();

        if (!$emailVerify) {
            return response()->json([
                'message' => 'Email not found',
            ], Response::HTTP_NOT_FOUND);
        }

        if ($emailVerify->token != $request->pin) {
            return response()->json([
                'message' => 'Invalid token',
            ], Response::HTTP_BAD_REQUEST);
        }

        DB::table('email_verifies')->where('email', $request->email)->delete();
        User::where('email', $request->email)->update(['email_verified_at' => Carbon::now()]);

        return response()->json([
            'message' => 'Email verified',
        ], Response::HTTP_OK);
    }

    public function resend()
    {
        $verify = DB::table('email_verifies')->where('email', Auth::user()->email);

        if ($verify->exists()) {
            $verify->delete();
        }

        $token = rand(100000, 999999);
        $verifyPin = DB::table('email_verifies')->insert([
            'email' => Auth::user()->email,
            'token' => $token,
        ]);

        if (!$verifyPin) {
            return response()->json([
                'message' => 'Failed to send verification email',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if ($verifyPin) {
            Mail::to(Auth::user()->email)->send(new VerifyEmail($token));

            return response()->json([
                'message' => 'Verification email sent',
            ], Response::HTTP_OK);
        }
    }
}
