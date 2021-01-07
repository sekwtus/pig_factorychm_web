<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;
use Auth;
use App\wg_sku_weight_data;

class order_marinade extends Controller
{
    public function index(){

        $user = DB::select('SELECT * from users where id_type is not null', []);
        $type_order = DB::select('SELECT * from tb_order_type');
        $customer = DB::select('SELECT * from tb_customer');
        $stock = DB::select("SELECT
                                wg_storage.name_storage,
                                wg_storage.description,
                                wg_storage.type_of_storage,
                                wg_storage.id_storage,
                                wg_storage.max_unit,
                                wg_storage.current_unit
                                FROM
                                wg_storage
                                WHERE
                                wg_storage.type_of_storage = 'คอกขาย'
                                AND wg_storage.description = 'คอกรวม'
                                ");
        
        $order_ref = DB::select("SELECT
                tb_order_overnight.id,
                tb_order_overnight.order_number,
                tb_order_overnight.total_pig,
                tb_order_overnight.current_pig,
                tb_order_overnight.type_request,
                tb_order_overnight.id_user_customer 
            FROM
                tb_order_overnight 
            WHERE
                tb_order_overnight.type_request IN (2,3)
                -- AND tb_order_overnight.current_pig <> 0
        ");

        return view('order.create_order_marinade',compact('user','type_order','customer','stock','order_ref'));
    }

    public function create_order(Request $request){

        $round = ($request->round == '' ? '' : $request->round);
        $order_number = DB::select("CALL CREATE_ORDER_MARINADE('$request->dateCutting','$request->marker','$request->amount','$round','$request->type_normal')");
        $order = $order_number[0]->ORDER_NUMBER;
        // return $order;

        $check_unique = DB::select("SELECT * FROM tb_order_marinade WHERE order_number = '$order'");
        if (count($check_unique) > 0) {
            return redirect()->back() ->with('alert', 'warnning!');
        }
        
        DB::insert('INSERT INTO tb_order_marinade ( order_number, total_pig, note, id_user_customer,id_user_provider,date,type_request,created_at,
            marker,customer_id,`round`,order_ref,type_normal)
            values (?,?,?,?,?,?,?,?,?,?,?,?,?)',
            [$order,$request->amount,$request->note,$request->customer,$request->provider,$request->dateCutting,$request->type_req,now(),
            $request->marker,$request->customer_id,$request->round,$request->order_ref,$request->type_normal]);

        // ตัดหมูออกจาก sale Oder ตามจำนวนที่นำไปแกะให้สาขา
        $request->amount = ($request->amount == '' ? 0 : $request->amount);
        // DB::update("UPDATE tb_order_overnight set current_pig = current_pig - $request->amount WHERE order_number = '$request->order_ref'");
        //      

        $date_plan = substr($request->dateCutting,6,4).'-'.substr($request->dateCutting,3,2).'-'.substr($request->dateCutting,0,2).' 13:00:00';

        DB::insert("INSERT INTO action_number(id_ref_order,lot_number,plan_amount,actual_amount,created_at,department,
            marker,customer,action_type,process_number)
            value('$order',now(),$request->amount,0,'$date_plan',9,
            '$request->marker','$request->customer','$request->type_req','$request->dateCutting'),
            ('$order',now(),$request->amount,0,'$date_plan',10,
            '$request->marker','$request->customer','$request->type_req','$request->dateCutting')" ); // 9 ชั่งออกไป mr  10 mr

        DB::insert("INSERT INTO pd_lot(id_ref_order,lot_number,order_plan_amount,order_actual_amount,
            start_date_process,lot_status,department,process_number,created_at)
            value('$order',now(),$request->amount,0,
            '$date_plan',0,9,'$request->dateCutting',now()),
            ('$order',now(),$request->amount,0,
            '$date_plan',0,10,'$request->dateCutting',now()) ");
            
            // 9 ชั่งออกไป mr  10 mr

        // DB::insert('INSERT INTO tb_product_plan(order_number,note)
        //     values (?,?)',[$order,$request->note]);

        return back();
    }

    public function ajaxOrder(){

        $sql = DB::select("SELECT
            tb_order_marinade.id,
            tb_order_marinade.order_number,
            tb_order_marinade.total_pig,
            tb_order_marinade.weight_range,
            tb_order_marinade.note,
            tb_order_marinade.date,
            tb_order_marinade.id_user_customer,
            tb_order_marinade.id_user_provider,
            tb_order_marinade.id_user_sender,
            tb_order_marinade.id_user_recieve,
            tb_order_marinade.`status`,
            tb_order_marinade.marker,
            tb_order_marinade.round,
            tb_order_marinade.order_ref,
            tb_order_marinade.storage_id,
            customer.fname AS customer,
            provider.fname AS provider,
            sender.fname AS sender,
            recieve.fname AS recieve,
            tb_order_type.order_type,
            wg_storage.name_storage,
            wg_storage.description,
            tb_order_marinade.date_transport
        FROM
        tb_order_marinade
            LEFT JOIN users AS customer ON tb_order_marinade.id_user_customer = customer.id
            LEFT JOIN users AS provider ON tb_order_marinade.id_user_provider = provider.id
            LEFT JOIN users AS sender ON tb_order_marinade.id_user_sender = sender.id
            LEFT JOIN users AS recieve ON tb_order_marinade.id_user_recieve = recieve.id
            LEFT JOIN tb_order_type ON tb_order_marinade.type_request = tb_order_type.id
            LEFT JOIN wg_storage ON tb_order_marinade.storage_id = wg_storage.id_storage 
        WHERE
        tb_order_marinade.type_request <> 4
        ORDER BY
        tb_order_marinade.created_at ASC", []);

        return Datatables::of($sql)->make(true);
    }

    public function order_edit(Request $request){

        $cutting_data = DB::select("SELECT * from tb_order_marinade WHERE order_number = '$request->order_number'");

        // check running order ?
        $weighing = wg_sku_weight_data::where('lot_number', '=', $request->order_number)->limit(1)->get();
        if (!empty($weighing[0]->lot_number)) {
            return redirect()->back()->with('message', 'Order ได้เริ่มการผลิตแล้ว ไม่สามารถแก้ไขได้');
        }

        else {
            
            $round = ($request->round == '' ? '' : $request->round);
            $order_number = DB::select("CALL CREATE_ORDER_MARINADE('$request->dateCutting','$request->marker','$request->amount','$round','$request->type_normal')");
            $order = $order_number[0]->ORDER_NUMBER;
    
            $check_unique = DB::select("SELECT * FROM tb_order_marinade WHERE order_number = '$order'");
            if (count($check_unique) > 0) {
                if ($request->note != $cutting_data[0]->note || $request->order_ref != $cutting_data[0]->order_ref || $request->amount != $cutting_data[0]->total_pig) { 
                    //case อัพเดทแค่note  กับเปลี่ยน order_ref
                    DB::update("UPDATE tb_order_marinade set note = '$request->note' ,order_ref = ? , total_pig = '$request->amount' WHERE order_number = ?" 
                        ,[$request->order_ref,$request->order_number]);
                    DB::update("UPDATE tb_order_overnight set current_pig = current_pig + '".$cutting_data[0]->total_pig."' WHERE order_number = '".$cutting_data[0]->order_ref."' ");
                    DB::update("UPDATE tb_order_overnight set current_pig = current_pig - '$request->amount' WHERE order_number = '$request->order_ref' ");
                    return redirect()->back();
                }
                return redirect()->back() ->with('alert', 'warnning!');
            }
            
            DB::update("UPDATE tb_order_marinade set order_number = ? , total_pig = '$request->amount', note = '$request->note', date = ? ,created_at = ?,
            `round` = '$request->round',`status` = '$request->type_normal',order_ref = ? WHERE  order_number = ?"
            ,[$order,$request->dateCutting,NOW(),$request->order_ref,$request->order_number]);

            if ($request->note != $cutting_data[0]->note || $request->order_ref != $cutting_data[0]->order_ref || $request->amount != $cutting_data[0]->total_pig ) { 
                //case อัพเดทแค่note  กับเปลี่ยน order_ref
                DB::update("UPDATE tb_order_marinade set note = '$request->note' ,order_ref = ? , total_pig = '$request->amount' WHERE order_number = ?" 
                    ,[$request->order_ref,$request->order_number]);
                DB::update("UPDATE tb_order_overnight set current_pig = current_pig + '".$cutting_data[0]->total_pig."' WHERE order_number = '".$cutting_data[0]->order_ref."' ");
                DB::update("UPDATE tb_order_overnight set current_pig = current_pig - '$request->amount' WHERE order_number = '$request->order_ref' ");
            }

            $date_plan = substr($request->datepicker,6,4).'-'.substr($request->datepicker,3,2).'-'.substr($request->datepicker,0,2).' 13:00:00';

            DB::update("UPDATE action_number set id_ref_order = ? , plan_amount = '$request->amount',
            actual_amount = '0' ,created_at = ? WHERE id_ref_order = ?"
            ,[$order,$date_plan,$request->order_number]);

            return redirect()->back();
           
        }


    }

    public function delete_order_marinade(Request $request){
        $weighing = wg_sku_weight_data::where('lot_number', '=', $request->order_number)->limit(1)->get();

        if (!empty($weighing[0]->lot_number)) {
            return 'Order ได้เริ่มการผลิตแล้ว ไม่สามารถลบได้';
        } else {

        #คืนหมุที่จะลบ
        $cutting_data = DB::select("SELECT * from tb_order_marinade WHERE order_number = '$request->order_number'");
        DB::update("UPDATE tb_order_overnight set current_pig = current_pig + '".$cutting_data[0]->total_pig."' WHERE order_number = '".$cutting_data[0]->order_ref."' ");

        DB::delete("DELETE FROM tb_order_marinade WHERE order_number = '$request->order_number' ", []);
        DB::delete("DELETE FROM action_number WHERE id_ref_order = '$request->order_number' ", []);
        DB::delete("DELETE FROM pd_lot WHERE id_ref_order = '$request->order_number' ", []);
        return 'ลบ '.$request->order_number;
        }
    }
}
