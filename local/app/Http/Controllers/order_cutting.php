<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;
use Auth;
use App\wg_sku_weight_data;

class order_cutting extends Controller
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
                AND tb_order_overnight.current_pig <> 0
        ");

        return view('order.create_order_cutting',compact('user','type_order','customer','stock','order_ref'));
    }

    public function create_order(Request $request){

        $round = ($request->round == '' ? '' : $request->round);
        $order_number = DB::select("CALL CREATE_ORDER_CUTTING('$request->dateCutting','$request->marker','$request->amount','$round','$request->type_normal')");
        $order = $order_number[0]->ORDER_NUMBER;

        $check_unique = DB::select("SELECT * FROM tb_order_cutting WHERE order_number = '$order'");
        if (count($check_unique) > 0) {
            return redirect()->back() ->with('alert', 'warnning!');
        }
        
        DB::insert('INSERT INTO tb_order_cutting ( order_number, total_pig, note, id_user_customer,id_user_provider,date,type_request,created_at,
            marker,customer_id,`round`,order_ref,type_normal)
            values (?,?,?,?,?,?,?,?,?,?,?,?,?)',
            [$order,$request->amount,$request->note,$request->customer,$request->provider,$request->dateCutting,$request->type_req,now(),
            $request->marker,$request->customer_id,$request->round,$request->order_ref,$request->type_normal]);

        // ตัดหมูออกจาก sale Oder ตามจำนวนที่นำไปแกะให้สาขา
        $request->amount = ($request->amount == '' ? 0 : $request->amount);
        DB::update("UPDATE tb_order_overnight set current_pig = current_pig - $request->amount WHERE order_number = '$request->order_ref'");
        //      

        $date_plan = substr($request->dateCutting,6,4).'-'.substr($request->dateCutting,3,2).'-'.substr($request->dateCutting,0,2).' 13:00:00';

        DB::insert("INSERT INTO action_number(id_ref_order,lot_number,plan_amount,actual_amount,created_at,department,
            marker,customer,action_type,process_number)
            value('$order',now(),$request->amount,0,'$date_plan',7,
            '$request->marker','$request->customer','$request->type_req','$request->dateCutting'),
            ('$order',now(),$request->amount,0,'$date_plan',8,
            '$request->marker','$request->customer','$request->type_req','$request->dateCutting'),
            ('$order',now(),$request->amount,0,'$date_plan',9,
            '$request->marker','$request->customer','$request->type_req','$request->dateCutting')" );// 8 เครื่องตัดแต่ง  7 ออก ov

        DB::insert("INSERT INTO pd_lot(id_ref_order,lot_number,order_plan_amount,order_actual_amount,
            start_date_process,lot_status,department,process_number,created_at)
            value('$order',now(),$request->amount,0,
            '$date_plan',0,7,'$request->dateCutting',now()),
            ('$order',now(),$request->amount,0,
            '$date_plan',0,8,'$request->dateCutting',now()) ");
            
            // 8 เครื่องตัดแต่ง 7 ออก ov

        // DB::insert('INSERT INTO tb_product_plan(order_number,note)
        //     values (?,?)',[$order,$request->note]);

        return back();
    }

    public function ajaxOrder(){

        $sql = DB::select("SELECT
            tb_order_cutting.id,
            tb_order_cutting.order_number,
            tb_order_cutting.total_pig,
            tb_order_cutting.weight_range,
            tb_order_cutting.note,
            tb_order_cutting.date,
            tb_order_cutting.id_user_customer,
            tb_order_cutting.id_user_provider,
            tb_order_cutting.id_user_sender,
            tb_order_cutting.id_user_recieve,
            tb_order_cutting.`status`,
            tb_order_cutting.marker,
            tb_order_cutting.round,
            tb_order_cutting.order_ref,
            tb_order_cutting.storage_id,
            customer.fname AS customer,
            provider.fname AS provider,
            sender.fname AS sender,
            recieve.fname AS recieve,
            tb_order_type.order_type,
            wg_storage.name_storage,
            wg_storage.description,
            tb_order_cutting.date_transport
        FROM
            tb_order_cutting
            LEFT JOIN users AS customer ON tb_order_cutting.id_user_customer = customer.id
            LEFT JOIN users AS provider ON tb_order_cutting.id_user_provider = provider.id
            LEFT JOIN users AS sender ON tb_order_cutting.id_user_sender = sender.id
            LEFT JOIN users AS recieve ON tb_order_cutting.id_user_recieve = recieve.id
            LEFT JOIN tb_order_type ON tb_order_cutting.type_request = tb_order_type.id
            LEFT JOIN wg_storage ON tb_order_cutting.storage_id = wg_storage.id_storage 
        WHERE
            tb_order_cutting.type_request <> 4
        ORDER BY
            tb_order_cutting.created_at ASC", []);

        return Datatables::of($sql)->make(true);
    }
    
    public function delete_order_cutting(Request $request){
        $weighing = wg_sku_weight_data::where('lot_number', '=', $request->order_number)->limit(1)->get();

        if (!empty($weighing[0]->lot_number)) {
            return 'Order ได้เริ่มการผลิตแล้ว ไม่สามารถลบได้';
        } else {

        #คืนหมุที่จะลบ
        $cutting_data = DB::select("SELECT * from tb_order_cutting WHERE order_number = '$request->order_number'");
        DB::update("UPDATE tb_order_overnight set current_pig = current_pig + '".$cutting_data[0]->total_pig."' WHERE order_number = '".$cutting_data[0]->order_ref."' ");

        DB::delete("DELETE FROM tb_order_cutting WHERE order_number = '$request->order_number' ", []);
        DB::delete("DELETE FROM action_number WHERE id_ref_order = '$request->order_number' ", []);
        DB::delete("DELETE FROM pd_lot WHERE id_ref_order = '$request->order_number' ", []);
        return 'ลบ '.$request->order_number;
        }
    }

    public function ajaxOrderCuttingToday(Request $request){
        
            $sql = DB::select("SELECT
                                tb_order_cutting.id,
                                tb_order_cutting.order_number,
                                tb_order_cutting.total_pig,
                                tb_order_cutting.weight_range,
                                tb_order_cutting.note,
                                tb_order_cutting.date,
                                tb_order_cutting.id_user_customer,
                                tb_order_cutting.id_user_provider,
                                tb_order_cutting.id_user_sender,
                                tb_order_cutting.id_user_recieve,
                                tb_order_cutting.`status`,
                                tb_order_cutting.marker,
                                tb_order_cutting.round,
                                tb_order_cutting.storage_id,
                                customer.fname AS customer,
                                provider.fname AS provider,
                                sender.fname AS sender,
                                recieve.fname AS recieve,
                                tb_order_type.order_type,
                                wg_storage.name_storage,
                                wg_storage.description,
                                tb_order_cutting.date_transport
                            FROM
                                tb_order_cutting
                                LEFT JOIN users AS customer ON tb_order_cutting.id_user_customer = customer.id
                                LEFT JOIN users AS provider ON tb_order_cutting.id_user_provider = provider.id
                                LEFT JOIN users AS sender ON tb_order_cutting.id_user_sender = sender.id
                                LEFT JOIN users AS recieve ON tb_order_cutting.id_user_recieve = recieve.id
                                LEFT JOIN tb_order_type ON tb_order_cutting.type_request = tb_order_type.id
                                LEFT JOIN wg_storage ON tb_order_cutting.storage_id = wg_storage.id_storage 
                            WHERE
                                tb_order_cutting.order_number NOT IN (( SELECT id_ref_order FROM pd_lot WHERE pd_lot.department = '$request->department' ))
                                AND tb_order_cutting.type_request <> 4
                            ORDER BY
                                tb_order_cutting.created_at DESC", []
            );
        return Datatables::of($sql)->make(true);
    }
    
    public function addOrderCutting_to_lot(Request $request){

            $order = DB::select("SELECT tb_order_cutting.* FROM tb_order_cutting
                                WHERE tb_order_cutting.order_number = '$request->order_number'");
            
            $department_id = DB::select("SELECT * FROM `tb_department` WHERE tb_department.id = '$request->id' ");
          
            $date_plan = now();
            foreach($order as $order_){
                $process = '';

                foreach ($department_id as $_id) {
                    $process_number = DB::select("CALL CREATE_PROCESS_NUMBER('$_id->sign','$order_->marker',$request->total_pig,'$request->lot')");
                    $process = $process_number[0]->LOT_NUMBER;
                    $date_plan = substr($order_->date,6,4).'-'.substr($order_->date,3,2).'-'.substr($order_->date,0,2).' 13:00:00';          
                }
    
                DB::insert("INSERT INTO pd_lot(id_ref_order,lot_number,order_plan_amount,order_actual_amount,
                            start_date_process,lot_status,department,process_number,created_at)
                            value('$order_->order_number','$request->lot',$request->total_pig,
                            0,now(),0,$request->id,'$process',now()),
                            ('$order_->order_number','$request->lot',$request->total_pig,
                            0,now(),0,4,'$process',now()) ");// 4 เครื่องตัดแต่ง
    
                DB::insert("INSERT INTO action_number(id_ref_order,lot_number,plan_amount,actual_amount,created_at,department,
                            marker,customer,action_type,process_number)
                            value('$order_->order_number','$request->lot',$request->total_pig,0,'$date_plan',$request->id,
                            '$order_->marker','$order_->id_user_customer','$order_->type_request','$process'),
                            ('$order_->order_number','$request->lot',$request->total_pig,0,'$date_plan',4,
                            '$order_->marker','$order_->id_user_customer','$order_->type_request','$process')" );// 4 เครื่องตัดแต่ง
    
                DB::update("UPDATE tb_order_cutting set current_lot = '$request->lot' WHERE id = '$order_->id' ");
    

                    //เพิ่มคิวจัดส่ง ให้เลือก order ที่จะส่งเอง
                    
                    $customer = DB::select("SELECT department FROM tb_customer WHERE tb_customer.shop_name = '$order_->id_user_customer'");
                    $customer_depart = '';
                    foreach ($customer as $key => $cust) {
                        $customer_depart = $cust->department;
                    }
    
                    if ($customer_depart != '') {
                        DB::insert("INSERT INTO pd_lot(id_ref_order,lot_number,order_plan_amount,order_actual_amount,
                        start_date_process,lot_status,department,process_number,created_at)
                        value('$order_->order_number','$request->lot',$request->total_pig,
                        0,now(),0,$customer_depart,'$process',now()) ");
        
                        DB::insert("INSERT INTO action_number(id_ref_order,lot_number,plan_amount,actual_amount,created_at,department,
                        marker,customer,action_type,process_number)
                        value('$order_->order_number','$request->lot',$request->total_pig,0,'$date_plan',$customer_depart,
                        '$order_->marker','$order_->id_user_customer','$order_->type_request','$process')" );
                    }

                
            }
            
            return 'success';
        
    }

    public function get_ajax_inLot(Request $request){
        $order_lot = DB::select("SELECT
                                pd_lot.id,
                                pd_lot.id_ref_order,
                                pd_lot.lot_number,
                                tb_order_cutting.id,
                                tb_order_cutting.order_number,
                                tb_order_cutting.total_pig,
                                tb_order_cutting.weight_range,
                                tb_order_cutting.note,
                                tb_order_cutting.date,
                                tb_order_cutting.id_user_customer,
                                tb_order_cutting.id_user_provider,
                                tb_order_cutting.id_user_sender,
                                tb_order_cutting.id_user_recieve,
                                tb_order_cutting.`status`,
                                tb_order_cutting.marker,
                                tb_order_cutting.round,
                                pd_lot.process_number,
                                DATE_FORMAT( pd_lot.start_date_process , '%d/%m/%Y') as date_picker
                                FROM
                                pd_lot
                                LEFT JOIN tb_order_cutting ON pd_lot.id_ref_order = tb_order_cutting.order_number
                                WHERE
                                pd_lot.lot_number = '$request->lot'
                                AND 
                                pd_lot.department = '$request->department'
                                AND tb_order_cutting.type_request <> 4
                                ORDER BY pd_lot.id
                                ");
        return Datatables::of($order_lot)->addIndexColumn()->make(true);
    }

    public function order_edit(Request $request){

        $cutting_data = DB::select("SELECT * from tb_order_cutting WHERE order_number = '$request->order_number'");

        // check running order ?
        $weighing = wg_sku_weight_data::where('lot_number', '=', $request->order_number)->limit(1)->get();
        if (!empty($weighing[0]->lot_number)) {
            return redirect()->back()->with('message', 'Order ได้เริ่มการผลิตแล้ว ไม่สามารถแก้ไขได้');
        }

        else {
            
            $round = ($request->round == '' ? '' : $request->round);
            $order_number = DB::select("CALL CREATE_ORDER_CUTTING('$request->dateCutting','$request->marker','$request->amount','$round','$request->type_normal')");
            $order = $order_number[0]->ORDER_NUMBER;
    
            $check_unique = DB::select("SELECT * FROM tb_order_cutting WHERE order_number = '$order'");
            if (count($check_unique) > 0) {
                if ($request->note != $cutting_data[0]->note || $request->order_ref != $cutting_data[0]->order_ref || $request->amount != $cutting_data[0]->total_pig) { 
                    //case อัพเดทแค่note  กับเปลี่ยน order_ref
                    DB::update("UPDATE tb_order_cutting set note = '$request->note' ,order_ref = ? , total_pig = '$request->amount' WHERE order_number = ?" 
                        ,[$request->order_ref,$request->order_number]);
                    DB::update("UPDATE tb_order_overnight set current_pig = current_pig + '".$cutting_data[0]->total_pig."' WHERE order_number = '".$cutting_data[0]->order_ref."' ");
                    DB::update("UPDATE tb_order_overnight set current_pig = current_pig - '$request->amount' WHERE order_number = '$request->order_ref' ");
                    return redirect()->back();
                }
                return redirect()->back() ->with('alert', 'warnning!');
            }
            
            DB::update("UPDATE tb_order_cutting set order_number = ? , total_pig = '$request->amount', note = '$request->note', date = ? ,created_at = ?,
            `round` = '$request->round',`status` = '$request->type_normal',order_ref = ? WHERE  order_number = ?"
            ,[$order,$request->dateCutting,NOW(),$request->order_ref,$request->order_number]);

            if ($request->note != $cutting_data[0]->note || $request->order_ref != $cutting_data[0]->order_ref || $request->amount != $cutting_data[0]->total_pig ) { 
                //case อัพเดทแค่note  กับเปลี่ยน order_ref
                DB::update("UPDATE tb_order_cutting set note = '$request->note' ,order_ref = ? , total_pig = '$request->amount' WHERE order_number = ?" 
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
}