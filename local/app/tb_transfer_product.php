<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class tb_transfer_product extends Model
{

    //
    protected $table = 'tb_transfer_product';

    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected function routeNotificationForLine()
    {
        return 'vqiliiOaVAyBZ77evjORQ5ByGJHdA9CGuIBhU79RYD0';
    }
    
}
