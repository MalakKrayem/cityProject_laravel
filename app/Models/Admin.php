<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Crypt;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasFactory, HasRoles;
    protected $fillable = [
        'name',
        'email',
        'password',
        'provider',
        'provider_id',
        'provider_token',
    ];
    protected $hidden = [
        'password',
        'remember_token',
        "created_at",
        "updated_at",
        "email_verified_at",
        //"provider_token",
    ];
    
    public function setProviderTokenAttribute($value)
    {
        $this->attributes['provider_token'] = Crypt::encrypt($value);
    }

    public function getTokenProviderAttribute($value)
    {
        return Crypt::decrypt($value);
    }
}
