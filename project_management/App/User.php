<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens,  Notifiable;
    // 
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'role',
        'phone_number',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function announcements()
    {
        return $this->hasMany('App\Announcements', 'user_id');
    }
    public function projects()
    {
        return $this->hasMany('App\Projects', 'user_id');
    }
    public function expenses()
    {
        return $this->hasMany('App\Expenses', 'user_id');
    }
    public function project()
    {
        return $this->belongsToMany(Projects::class);
    }
}
