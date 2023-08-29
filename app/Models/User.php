<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role_id',
        'address_id',
        'avatar',
        'dob',
        'age',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function address()
    {
        return $this->hasOne(Address::class);
    }


    public function scopeFilterByStatus($query, $status)
    {
        return $query->when($status, function ($query, $status) {
            return $query->where('status', $status);
        });
    }

    public function scopeFilterByRole($query, $role)
    {
        return $query->when($role, function ($query, $role) {
            return $query->where('role_id', $role);
        });
    }

    public function scopeFilterByKeyword($query, $keyword)
    {
        return $query->when($keyword, function ($query, $keyword) {
            return $query->where('name', 'LIKE', "%$keyword%")
                ->orWhere('email', 'LIKE', "%$keyword%")
                ->orWhere('phone', 'LIKE', "%$keyword%");
        });
    }
}
