<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class tb_transfer_to_factory extends Model
{

    //
    protected $table = 'tb_transfer_to_factory';

    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected function routeNotificationForLine()
    {
        return 'Yx4ToXpVHy663qgyW5uw7j2FswCh5mM6mKwFnNsapoj';
    }
    
}
