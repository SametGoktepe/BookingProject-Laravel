<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{
    use HasFactory;

    protected $table = 'cities';

    public function states()
    {
        return $this->belongsTo(States::class);
    }

    public function countries()
    {
        return $this->belongsTo(Countries::class);
    }
}
