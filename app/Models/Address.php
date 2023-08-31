<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'addresses';

    protected $fillable = [
        'user_id',
        'city_id',
        'country_id',
        'state_id',
        'address',
        'default',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function city()
    {
        return $this->belongsTo(Cities::class, 'city_id', 'id');
    }

    public function country()
    {
        return $this->belongsTo(Countries::class, 'country_id', 'id');
    }

    public function state()
    {
        return $this->belongsTo(States::class, 'state_id', 'id');
    }
}
