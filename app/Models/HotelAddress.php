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
        'address',
        'hotel_id',
        'default',
    ];

    public function hotel()
    {
        return $this->hasOne(Hotels::class);
    }
}
