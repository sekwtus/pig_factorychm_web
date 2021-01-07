<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;
use Auth;
use App\wg_sku_weight_data;
use Redirect;

class order_transport extends Controller
{
    public function index(){
        $id =4;
        $current_lot = DB::select("SELECT * FROM `pd_lot_master` WHERE 
                                    DATE_FORMAT(pd_lot_master.created_at,'%d/%m/%Y') =  DATE_FORMAT(NOW(),'%d/%m/%Y') 
                                    ORDER BY pd_lot_master.created_at DESC LIMIT 1", []);
        $lot_number = null;
        foreach ($current_lot as $key => $current) {
            $lot_number = $current->lot_number;
        }

        $department = DB::select('SELECT * FROM tb_department', []);
       
        return view('order.order_plan_transport' , compact('department','lot_number','id'));
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
            tb_order_cutting.storage_id,
            customer.fname AS customer,
            provider.fname AS provider,
            sender.fname AS sender,
            recieve.fname AS recieve,
            tb_order_type.order_type,
            wg_storage.name_storage,
            wg_storage.description,
            tb_order_cutting.date_transport,
            tb_order_cutting.current_offal_order
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
            AND tb_order_cutting.current_offal_order IS NULL
        ORDER BY
            tb_order_cutting.created_at DESC", []);

        return Datatables::of($sql)->make(true);
    }

    public function set_order_transport(Request $request){
        
        $order_cutting = DB::select("SELECT * from tb_order_cutting WHERE order_number = '$request->order_cutting_number'");
        $order_offal = DB::select("SELECT * from tb_order_offal WHERE order_number = '$request->order_offal_number'");
        
        $number_offal = ($request->order_offal_number == '-' ? $number_offal = '-' : $number_offal = $order_offal[0]->order_number );
        $marker_offal = ( empty($order_offal[0]->marker) ? $marker_offal = '' : $marker_offal = $order_offal[0]->marker );
        $type_nm = ( empty($order_cutting[0]->type_normal) ? $type_nm = '' : $type_nm = 'X' );

        if (($order_cutting[0]->marker == $marker_offal) || $number_offal == '-' ){
            foreach ($order_cutting as $key => $_cutting) {
                # code...
                $date_transport = $_cutting->date_transport;
                $marker = $_cutting->marker;
                $total_pig = $_cutting->total_pig;

                $round = ($_cutting->round == '' ? '' : $_cutting->round);
                $order_transport_number = DB::select("CALL CREATE_ORDER_TRANSPORT('$date_transport','$marker','','$round','$type_nm')");
                $order = $order_transport_number[0]->ORDER_NUMBER;

                DB::insert('INSERT INTO tb_order_transport(order_number,total_pig,id_user_customer,date_transport,type_request,created_at,
                    marker,customer_id,`round`,order_cutting_number,order_offal_number)
                    values (?,?,?,?,?,?,?,?,?,?,?)',
                    [$order,$total_pig,$_cutting->id_user_customer,$date_transport,$_cutting->type_request,now(),
                    $marker,$_cutting->customer_id,$round,$request->order_cutting_number,$number_offal]);

                $date_plan = substr($date_transport,6,4).'-'.substr($date_transport,3,2).'-'.substr($date_transport,0,2).' 13:00:00';

                // ค้นหาร้าน เพื่อให้ตาชั่งขึ้นorder
                    $customer = DB::select("SELECT department FROM tb_customer WHERE tb_customer.id = '$_cutting->customer_id'");
                    $customer_depart = '';
                    foreach ($customer as $key => $cust) {
                        $customer_depart = $cust->department;
                    }

                DB::insert("INSERT INTO action_number(id_ref_order,lot_number,plan_amount,actual_amount,created_at,department,
                    marker,customer,action_type,process_number)
                    value('$order',now(),'$total_pig',0,'$date_plan','$customer_depart',
                    '$marker','$_cutting->id_user_customer','$_cutting->type_request','$date_transport')" );// shop department 

                DB::insert("INSERT INTO pd_lot(id_ref_order,lot_number,order_plan_amount,order_actual_amount,
                    start_date_process,lot_status,department,process_number,created_at)
                    value('$order',now(),'$total_pig',0,
                    '$date_plan',0,'$customer_depart','$date_transport',now())");// shop department 

                    // update ที่ผูกอยู่ปัจจุบัน
                DB::update("UPDATE tb_order_cutting set current_offal_order = '$number_offal' WHERE order_number = '$request->order_cutting_number'");
                DB::update("UPDATE tb_order_offal set current_cutting_order = '$request->order_cutting_number' WHERE order_number = '$number_offal'");

                //สร้างเช็คใบส่งของ
                DB::insert("INSERT INTO tb_report_transport_check(order_number,item_code)
                            SELECT
                                '$order',
                                wg_sku_item.item_code
                            FROM
                                wg_sku_item 
                            WHERE
                                wg_sku_item.wg_sku_id IN ( 3, 4, 5, 7, 6, 9 ) 
                            GROUP BY
                                wg_sku_item.item_code 
                            ORDER BY
                                wg_sku_item.item_code ASC");
            }
        return back();

        }else {
            return redirect()->back()->with('message', 'Order ผิดพลาด สาขาต่างกัน');
        }
        
        
    }

    public function ajaxOrderOffal(){

        $sql = DB::select("SELECT
            tb_order_offal.id,
            tb_order_offal.order_number,
            tb_order_offal.total_pig,
            tb_order_offal.weight_range,
            tb_order_offal.note,
            tb_order_offal.date,
            tb_order_offal.id_user_customer,
            tb_order_offal.id_user_provider,
            tb_order_offal.id_user_sender,
            tb_order_offal.id_user_recieve,
            tb_order_offal.`status`,
            tb_order_offal.marker,
            tb_order_offal.round,
            tb_order_offal.storage_id,
            customer.fname AS customer,
            provider.fname AS provider,
            sender.fname AS sender,
            recieve.fname AS recieve,
            tb_order_type.order_type,
            wg_storage.name_storage,
            wg_storage.description,
            tb_order_offal.date_transport,
            tb_order_offal.current_cutting_order
        FROM
            tb_order_offal
            LEFT JOIN users AS customer ON tb_order_offal.id_user_customer = customer.id
            LEFT JOIN users AS provider ON tb_order_offal.id_user_provider = provider.id
            LEFT JOIN users AS sender ON tb_order_offal.id_user_sender = sender.id
            LEFT JOIN users AS recieve ON tb_order_offal.id_user_recieve = recieve.id
            LEFT JOIN tb_order_type ON tb_order_offal.type_request = tb_order_type.id
            LEFT JOIN wg_storage ON tb_order_offal.storage_id = wg_storage.id_storage 
        WHERE
            tb_order_offal.type_request <> 4
            AND tb_order_offal.current_cutting_order IS NULL
        ORDER BY
            tb_order_offal.created_at DESC", []);

        return Datatables::of($sql)->make(true);
    }

    public function get_ajax_inLot(){
        $order_lot = DB::select("SELECT
                tb_order_transport.id,
                tb_order_transport.order_number,
                tb_order_transport.total_pig,
                tb_order_transport.weight_range,
                tb_order_transport.note,
                tb_order_transport.id_user_customer,
                tb_order_transport.id_user_provider,
                tb_order_transport.id_user_sender,
                tb_order_transport.id_user_recieve,
                tb_order_transport.`status`,
                tb_order_transport.marker,
                tb_order_transport.round,
                tb_order_transport.date_transport AS date_picker,
                GROUP_CONCAT(tb_order_transport.order_cutting_number SEPARATOR ' + \n') as order_cutting_number,
                GROUP_CONCAT(tb_order_transport.order_offal_number SEPARATOR ' + \n') as order_offal_number
            FROM
                tb_order_transport
                GROUP BY tb_order_transport.order_number
        ");
        return Datatables::of($order_lot)->addIndexColumn()->make(true);
    }

    public function get_ajax_inLot2(){
        // กรณีtrมีclมากกว่า 1 of มากกว่า 1 
        $order_lot = DB::select("SELECT
                tb_order_transport.id,
                tb_order_transport.order_number,
                tb_order_transport.total_pig,
                tb_order_transport.weight_range,
                tb_order_transport.note,
                tb_order_transport.id_user_customer,
                tb_order_transport.id_user_provider,
                tb_order_transport.id_user_sender,
                tb_order_transport.id_user_recieve,
                tb_order_transport.`status`,
                tb_order_transport.marker,
                tb_order_transport.round,
                tb_order_transport.date_transport AS date_picker,
                GROUP_CONCAT(tb_order_transport.order_cutting_number SEPARATOR ' + ') as order_cutting_number,
                GROUP_CONCAT(tb_order_transport.order_offal_number SEPARATOR ' + ') as order_offal_number
            FROM
                tb_order_transport
                GROUP BY tb_order_transport.order_number
            ");
        return Datatables::of($order_lot)->addIndexColumn()->make(true);
    }

    public function delete_transportOrder_from_lot(Request $request){
        DB::delete("DELETE FROM action_number WHERE id_ref_order = '$request->order_number' ", []);
        DB::delete("DELETE FROM pd_lot WHERE id_ref_order = '$request->order_number' ", []);
        DB::delete("DELETE FROM tb_order_transport WHERE order_number = '$request->order_number' ", []);
        DB::delete("DELETE FROM tb_report_transport_check WHERE order_number = '$request->order_number' ", []);
        
        // update ที่ผูกอยู่ปัจจุบัน
        DB::update("UPDATE tb_order_cutting set current_offal_order = NULL WHERE order_number = '$request->order_cutting_number'");
        DB::update("UPDATE tb_order_offal set current_cutting_order = NULL WHERE order_number = '$request->order_offal_number'");

        return 'ยกเลิกสำเร็จ';
    }
  
    public function create_order_transport(){
        $order_cutting_ref = DB::select("SELECT * FROM `tb_order_cutting` WHERE order_tr_ref is NULL");
        $order_offal_ref = DB::select("SELECT * FROM `tb_order_offal` WHERE order_tr_ref is NULL");
  
        return view('order.create_order_transport',compact('order_cutting_ref','order_offal_ref'));
    }

    public function order_transport_save(Request $request){

        $order_transport_number = DB::select("CALL CREATE_ORDER_TRANSPORT('$request->dateTransport','$request->marker','','$request->round','')");
        $order = $order_transport_number[0]->ORDER_NUMBER;

        $check_unique = DB::select("SELECT * FROM tb_order_transport WHERE order_number = '$order'");
        if (count($check_unique) > 0) {
            return redirect()->back() ->with('alert', 'warnning!');
        }
        
        $date_transport = $request->dateTransport;
        $marker = $request->marker;
        $date_plan = substr($date_transport,6,4).'-'.substr($date_transport,3,2).'-'.substr($date_transport,0,2).' 13:00:00';

        for ($i=0; $i < max(count($request->cutting_order),count($request->offal_order)) ; $i++) { 
              $cutting_or = (empty($request->cutting_order[$i]) ? null : $request->cutting_order[$i]);
              $offal_or = (empty($request->offal_order[$i]) ? null : $request->offal_order[$i]);
              DB::insert('INSERT INTO tb_order_transport(order_number,id_user_customer,date_transport,type_request,created_at,
                    marker,customer_id,`round`,order_cutting_number,order_offal_number,note)
                    values (?,?,?,?,?,?,?,?,?,?,?)',
                    [$order,$request->customer,$request->dateTransport,$request->type_req,now(),
                    $request->marker,$request->customer_id,$request->round,$cutting_or,$offal_or,$request->note]
                );

                // update ที่ผูกอยู่ปัจจุบัน
                DB::update("UPDATE tb_order_cutting set order_tr_ref = '$order' WHERE order_number = '$cutting_or'");
                DB::update("UPDATE tb_order_offal set order_tr_ref = '$order' WHERE order_number = '$offal_or'");            
        }

        // ค้นหาร้าน เพื่อให้ตาชั่งขึ้น order
        $customer = DB::select("SELECT department FROM tb_customer WHERE tb_customer.id = '$request->customer_id'");
        $customer_depart = '';
        foreach ($customer as $key => $cust) {
            $customer_depart = $cust->department;
        }

        DB::insert("INSERT INTO action_number(id_ref_order,lot_number,plan_amount,actual_amount,created_at,department,
            marker,customer,action_type,process_number)
            value('$order',now(),0,0,'$date_plan','$customer_depart',
            '$marker','$request->customer','$request->type_re','$date_transport')" );// shop department 

        DB::insert("INSERT INTO pd_lot(id_ref_order,lot_number,order_plan_amount,order_actual_amount,
            start_date_process,lot_status,department,process_number,created_at)
            value('$order',now(),0,0,
            '$date_plan',0,'$customer_depart','$date_transport',now())");// shop department 
        
        //สร้างเช็คใบส่งของ
        DB::insert("INSERT INTO tb_report_transport_check(order_number,item_code)
            SELECT
                '$order',
                wg_sku_item.item_code
            FROM
                wg_sku_item 
            WHERE
                wg_sku_item.wg_sku_id IN ( 3, 4, 5, 7, 6, 9 ) 
            GROUP BY
                wg_sku_item.item_code 
            ORDER BY
                wg_sku_item.item_code ASC"
        );

        return back();
    }

    public function delete_order_tr(Request $request){

        DB::update("UPDATE tb_order_cutting set order_tr_ref = NULL WHERE order_tr_ref = '$request->order_number'");
        DB::update("UPDATE tb_order_offal set order_tr_ref = NULL  WHERE order_tr_ref = '$request->order_number'");

        DB::delete("DELETE from tb_order_transport WHERE order_number = '$request->order_number' ");
        DB::delete("DELETE from action_number WHERE id_ref_order = '$request->order_number' ");
        DB::delete("DELETE from pd_lot WHERE id_ref_order = '$request->order_number' ");
        DB::delete("DELETE from tb_report_transport_check WHERE order_number = '$request->order_number' ");
  
        return 'ลบ '.$request->order_number;
    }

    public function tr_edit(Request $request){
        $order_transport_number = DB::select("CALL CREATE_ORDER_TRANSPORT('$request->dateTransport','$request->marker','','$request->round','')");
        $order = $order_transport_number[0]->ORDER_NUMBER;

        $check_unique = DB::select("SELECT * FROM tb_order_transport WHERE order_number = '$order'");
        if (count($check_unique) > 0) {
            return redirect()->back() ->with('alert', 'warnning!');
        }

        DB::update("UPDATE tb_order_transport set order_number = '$order',date_transport = '$request->dateTransport',
                    note = '$request->note' , `round` = '$request->round'  WHERE order_number = '$request->order_number'");

        DB::update("UPDATE tb_order_cutting set order_tr_ref = '$order' WHERE order_tr_ref = '$request->order_number'");
        DB::update("UPDATE tb_order_offal set order_tr_ref = '$order'  WHERE order_tr_ref = '$request->order_number'");
        
        DB::update("UPDATE action_number set id_ref_order = '$order'  WHERE id_ref_order = '$request->order_number'");
        DB::update("UPDATE pd_lot set id_ref_order = '$order'  WHERE id_ref_order = '$request->order_number'");
        DB::update("UPDATE tb_report_transport_check set order_number = '$order'  WHERE order_number = '$request->order_number'");
  
        return back();
    }

    public function ended_tr_order(Request $request){

        $user_name = Auth::user()->fname;
        DB::update("UPDATE tb_order_transport set ended_order = 1 , time_ended = now() , user_ended = '$user_name'  WHERE order_number = '$request->order'");
  
        return 'ปิด order '.$request->order;
    }
    
    
    
}