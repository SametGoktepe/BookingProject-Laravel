<?php

namespace App\Providers;

use App\Http\Services\Interfaces\IAuth;
use App\Http\Services\Interfaces\IEmailVerify;
use App\Http\Services\Interfaces\IPassword;
use App\Http\Services\Interfaces\IUser;
use App\Http\Services\Repositories\AuthRepository;
use App\Http\Services\Repositories\EmailVerifyRepository;
use App\Http\Services\Repositories\ForgotPasswordRepository;
use App\Http\Services\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */

    public function register(): void
    {
        $this->app->bind(
            IAuth::class,
            AuthRepository::class,
            IPassword::class,
            ForgotPasswordRepository::class,
            IEmailVerify::class,
            EmailVerifyRepository::class,
            IUser::class,
            UserRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
