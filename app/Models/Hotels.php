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

    public function address()
    {
        return $this->belongsTo(HotelAddresses::class, 'address_id', 'id');
    }

    public function images()
    {
        return $this->hasMany(HotelImages::class, 'hotel_id', 'id');
    }
}
