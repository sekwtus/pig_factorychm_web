<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class shop_purchase_report extends Model
{
    protected $table = 'shop_purchase_report';

    protected $fillable = [
        'item_code', 'item_name', 'unit', 'weight_number' , 'total_price','shop_name','date_source','date_destination','price_unit'
    ];
}
