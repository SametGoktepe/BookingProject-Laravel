<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoomTypes extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'room_types';

    protected $fillable = [
        'name',
    ];
}
