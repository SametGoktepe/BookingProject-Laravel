<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Http\Services\Interfaces\IAuth;
use App\Http\Services\Repositories\AuthRepository;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
        $this->app->bind(IAuth::class, AuthRepository::class);
    }
}
