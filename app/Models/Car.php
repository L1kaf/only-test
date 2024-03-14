<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = ['model', 'comfort_category', 'driver_id'];

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'car_user')->withTimestamps()->withPivot('start_time', 'end_time');
    }
}
