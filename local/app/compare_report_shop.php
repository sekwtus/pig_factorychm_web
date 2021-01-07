<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class compare_report_shop extends Model
{
    protected $table = 'compare_report_shop';

    protected $fillable = [
        'item_code', 'total_weight', 'unit' ,'date','shop_name','order_number'
    ];
}
