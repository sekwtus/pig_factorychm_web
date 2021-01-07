<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class shop_sales_report extends Model
{
    protected $table = 'shop_sales_report';

    protected $fillable = [
        'item_code', 'item_name', 'unit', 'weight_number' , 'total_price','shop_name','date_today','price_unit'
    ];
}
