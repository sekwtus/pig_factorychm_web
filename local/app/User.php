<?php

namespace App;


use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'name', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];


    protected function routeNotificationForLine()
    {
        return 'vqiliiOaVAyBZ77evjORQ5ByGJHdA9CGuIBhU79RYD0';
    }
    
    
}
