<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HotelRoom extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'hotel_rooms';

    protected $fillable = [
        'hotel_id',
        'type_id',
        'price',
        'status',
        'is_available',
        'quantity',
        'room_number',
        'capacity',
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotels::class, 'hotel_id', 'id');
    }

    public function type()
    {
        return $this->belongsTo(RoomTypes::class, 'type_id', 'id');
    }
}
