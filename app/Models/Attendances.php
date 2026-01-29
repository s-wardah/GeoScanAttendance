<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendances extends Model
{
    use HasFactory;

    // Gabungkan semua kolom yang boleh diisi di sini
    protected $fillable = [
        'user_id',
        'schedule_id',
        'room_id',
        'lat_captured',
        'long_captured',
        'distance_from_target',
        'status',
        'check_in_time'
    ];

    protected $casts = [
        'check_in_time' => "datetime",
    ];

    // Nama fungsi relasi sebaiknya tunggal (room) karena belongsTo (satu)
    public function room() {
        return $this->belongsTo(Rooms::class, 'room_id');
    }

    public function schedule() {
        return $this->belongsTo(Schedule::class, 'schedule_id');
    }
}