<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class tb_tranfrom extends Model
{

    //
    protected $table = 'tb_tranfrom';

    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected function routeNotificationForLine()
    {
        return '9tOVTDo3O6StYjHZJtrkq1PWg75Q0IRdCRSKkpVUwya ';
    }
    
}
