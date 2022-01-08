<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function generateToken()
    {
        $this->api_token = Str::random(32);
        $this->save();
        return $this->api_token;
    }

    public function clearToken()
    {
        $this->api_token = null;
        $this->save();
    }

    public function sessions()
    {
        return $this->hasMany(Session::class);
    }
}
