<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    protected $fillable = ['class_name'];

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'class_id');
    }
}
