<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class compare_report extends Model
{
    protected $table = 'compare_report';

    protected $fillable = [
        'item_code', 'total_weight', 'unit', 'weight_number' ,'date','shop_name','order_number'
    ];
}
