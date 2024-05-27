<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'phone_no',
        'email',
    ];

    protected $casts = [
        'created_at'=>'datetime',
        'updated_at'=>'datetime'
    ];
}
