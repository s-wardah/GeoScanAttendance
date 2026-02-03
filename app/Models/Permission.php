<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    // Tambahkan baris ini
    protected $fillable = [
        'user_id',
        'date',
        'type',
        'reason',
        'attachment',
        'status',
    ];

    // Relasi ke User (biar gampang panggil nama gurunya nanti)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}