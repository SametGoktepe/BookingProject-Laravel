<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HotelAddress extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'hotel_addresses';

    protected $fillable = [
        'city_id',
        'country_id',
        'state_id',
        'address',
        'hotel_id',
        'default',
    ];

    public function hotel()
    {
        return $this->hasOne(Hotels::class);
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
