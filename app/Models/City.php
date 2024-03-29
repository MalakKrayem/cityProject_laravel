<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;



    //City hasMany users

    public function users()
    {
        return $this->hasMany(User::class, "city_id", "id");
    }

    public function getActiveStatusAttribute()
    {
        return $this->active ? "Active" : "Inactive";
    }
}
