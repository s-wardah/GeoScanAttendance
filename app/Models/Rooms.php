<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rooms extends Model
{
    protected $fillable = ['room_name', 'latitude', 'longitude', 'radius', 'qr_content'];
}
