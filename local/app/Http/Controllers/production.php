<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class production extends Controller
{
    public function index(){
        $department = DB::select('SELECT * FROM tb_department', []);
        // return $department;
        $current_lot = DB::select('SELECT * FROM pd_lot where lot_status = 1');

        $id_ref_order = "";
        $order_plan_amount = "";
        $lotnumber = "";
        if($current_lot != null && $current_lot != ""){
            $id_ref_order = $current_lot[0]->id_ref_order;
            $order_plan_amount = $current_lot[0]->order_plan_amount;
            $lotnumber = $current_lot[0]->lot_number;
        }
       

        return view('product.production_process' , compact('department','lotnumber','id_ref_order','order_plan_amount'));
    }

    public function inOrder(){
        $department = DB::select('SELECT * FROM tb_department', []);
        // return $department;
        return view('product.in_order' , compact('department'));
    }

}
