<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailVerify extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'email_verifies';

    protected $primaryKey = 'email';

    public $incrementing = false;

    protected $fillable = [
        'email',
        'token',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
