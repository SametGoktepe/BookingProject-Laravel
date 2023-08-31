<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hotels extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'hotels';

    protected $fillable = [
        'name',
        'status',
        'description',
        'address_id',
    ];

    public function hotelAddress()
    {
        return $this->belongsTo(HotelAddress::class, 'address_id', 'id');
    }

    public function images()
    {
        return $this->hasMany(HotelImages::class, 'hotel_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(HotelComment::class, 'hotel_id', 'id');
    }

    public function commentCount()
    {
        return $this->hasMany(HotelComment::class, 'hotel_id', 'id')->count();
    }

    public function ratingAvg()
    {
        return $this->hasMany(HotelComment::class, 'hotel_id', 'id')->avg('rating');
    }

    public function hotelRooms()
    {
        return $this->hasMany(HotelRoom::class, 'hotel_id', 'id');
    }

    public function scopeCity($query, $city_id)
    {
        if ($city_id) {
            return $query->whereHas('hotelAddress', function ($query) use ($city_id) {
                $query->where('city_id', $city_id);
            });
        }
    }

    public function scopeByCountry($query, $country_id)
    {
        if ($country_id) {
            return $query->whereHas('hotelAddress', function ($query) use ($country_id) {
                $query->where('country_id', $country_id);
            });
        }
    }

    public function scopeByName($query, $name)
    {
        if ($name) {
            return $query->where('name', 'like', '%' . $name . '%');
        }
    }

    public function scopeOrderByPrice($query, $order)
    {
        if ($order == 'asc') {
            return $query->whereHas('hotelRooms', function ($query) {
                $query->orderBy('price', 'asc');
            });
        } else {
            return $query->whereHas('hotelRooms', function ($query) {
                $query->orderBy('price', 'desc');
            });
        }
    }
}
