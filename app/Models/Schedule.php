<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',       
        'room_id',     
        'class_id',      
        'subject',     
        'day',          
        'start_time',   
        'end_time',      
        'academic_year', 
        'semester',      
        'is_active',     
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function room()
    {
        return $this->belongsTo(Rooms::class);
    }
    public function class()
    {
        return $this->belongsTo(Classes::class);
    }
}
