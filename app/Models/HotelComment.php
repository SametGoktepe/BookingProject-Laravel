<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HotelComment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'hotel_comments';

    protected $fillable = [
        'hotel_id',
        'user_id',
        'comment',
        'rating',
    ];

    public function hotels()
    {
        return $this->belongsTo(Hotels::class);
    }

    public function users()
    {
        return $this->belongsTo(Users::class);
    }
}
