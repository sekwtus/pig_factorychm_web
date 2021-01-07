<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Support\Facades\Auth;
use DB;

class stock extends Model
{
    //
    protected $table = 'take_live';
    
    
    public static function take_live(){
        $sql = "SELECT * FROM `take_live`";
        return DB::select($sql,[]);
    }

    public static function take_slice(){
        $sql = "SELECT * FROM `take_slice`";
        return DB::select($sql,[]);
    }

    public static function take_entrail(){
        $sql = "SELECT * FROM `take_entrail`";
        return DB::select($sql,[]);
    }

    public static function take_carcase(){
        $sql = "SELECT * FROM `take_carcase`";
        return DB::select($sql,[]);
    }

    public static function receipt_entrail(){
        $sql = "SELECT * FROM `receipt_entrail`";
        return DB::select($sql,[]);
    }

    public static function receipt_carcase(){
        $sql = "SELECT * FROM `receipt_carcase`";
        return DB::select($sql,[]);
    }

    public static function load_entrail(){
        $sql = "SELECT * FROM `load_entrail`";
        return DB::select($sql,[]);
    }

    public static function load_carcase(){
        $sql = "SELECT * FROM `load_carcase`";
        return DB::select($sql,[]);
    }
}