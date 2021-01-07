<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class send extends Controller
{
    public static function index(){
        return view('send.send_truck_scale');
    }
    public static function indexPig(){
        return view('send.send_pig_scale');
    }
}
