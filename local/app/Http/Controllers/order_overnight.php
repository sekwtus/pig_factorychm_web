<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;
use Auth;
use App\wg_sku_weight_data;

class order_overnight extends Controller
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
                wg_stock_log.id,
                wg_stock_log.id_storage,
                wg_stock_log.bill_number as order_number,
                wg_stock_log.round,
                wg_stock_log.ref_source,
                wg_stock_log.side_of_pig,
                tb_order.date
            FROM
                wg_stock_log 
                LEFT JOIN tb_order ON wg_stock_log.bill_number = tb_order.order_number
            WHERE
                wg_stock_log.id_storage = 102 
                AND wg_stock_log.side_of_pig <> 0
                AND tb_order.make_show_order = 1
            order by  tb_order.created_at desc   
        ");
        

        return view('order.create_order_overnight',compact('user','type_order','customer','stock','order_ref'));
    }

    public function check_stock_overnight(){
        return $order_ref = DB::select("SELECT
                wg_stock_log.id,
                wg_stock_log.id_storage,
                wg_stock_log.bill_number as order_number,
                wg_stock_log.round,
                wg_stock_log.ref_source,
                wg_stock_log.side_of_pig
            FROM
                wg_stock_log 
            WHERE
                wg_stock_log.id_storage = 102 
                AND wg_stock_log.side_of_pig <> 0
        ");
    }

    public function create_order(Request $request){

        $sum_amount = 0;
        for ($i=0; $i < count($request->amount) ; $i++) { 
            $sum_amount = $sum_amount + $request->amount[$i];
        }
        
        $round = ($request->round == '' ? '' : $request->round);
        $order_number_g = DB::select("CALL CREATE_ORDER_OVERNIGHT('$request->dateOV','$request->marker','$sum_amount','$round')");
        $order_group = $order_number_g[0]->ORDER_NUMBER;

        $check_unique = DB::select("SELECT * FROM tb_order_overnight WHERE order_group = '$order_group'");
        if (count($check_unique) > 0) {
            return redirect()->back() ->with('alert', 'warnning!');
        }

         // loop add group
        for ($i=0; $i < count($request->order_ref) ; $i++) { 
            $amount_pig = $request->amount[$i];
            $round = ($request->round == '' ? '' : $request->round);
            $order_number = DB::select("CALL CREATE_ORDER_OVERNIGHT('$request->dateOV','$request->marker','$amount_pig','$round')");
            $order = $order_number[0]->ORDER_NUMBER;
            
   

            DB::insert('INSERT INTO tb_order_overnight( order_group, order_number, total_pig, note, id_user_customer,id_user_provider,date,type_request,created_at,
            marker,customer_id,`round`,order_ref,current_pig)
            values (?,?,?,?,?,?,?,?,?,?,?,?,?,?)',
            [$order_group,$order,$amount_pig,$request->note,$request->customer,$request->provider,$request->dateOV,$request->type_req,now(),
            $request->marker,$request->customer_id,$request->round,$request->order_ref[$i],$amount_pig]);

            // ตัดหมูออกจาก sale Oder ตามจำนวนที่นำไปแกะให้สาขา
            DB::update("UPDATE wg_stock_log set wg_stock_log.side_of_pig = wg_stock_log.side_of_pig - $amount_pig WHERE bill_number = '".$request->order_ref[$i]."'");
            

        }
        // loop add group


        //auto scale
        $date_plan = substr($request->dateOV,6,4).'-'.substr($request->dateOV,3,2).'-'.substr($request->dateOV,0,2).' 13:00:00';

        DB::insert("INSERT INTO action_number(id_ref_order,plan_amount,actual_amount,created_at,department,
                    marker,customer,action_type,process_number)
                    value('$order_group','$sum_amount',0,'$date_plan',7,
                    '$request->marker','$request->customer','$request->type_req','$request->dateOV')
                    ,('$order_group','$sum_amount',0,'$date_plan',9,
                    '$request->marker','$request->customer','$request->type_req','$request->dateOV')" );

        DB::insert("INSERT INTO pd_lot(id_ref_order,lot_number,order_plan_amount,order_actual_amount,
                    start_date_process,lot_status,department,process_number,created_at)
                    value('$order_group',now(),$sum_amount,0,
                    '$date_plan',0,7,'$request->dateOV',now()),
                    ('$order_group',now(),$sum_amount,0,
                    '$date_plan',0,9,'$request->dateOV',now())");
        //auto scale

        
         //auto update cutting line
        $check_order_exist = DB::select("SELECT * FROM tb_order_cutting 
        WHERE date = '$request->dateOV'");
                   
        if (empty($check_order_exist[0]->id) && $request->type_req == '3') {
            // สร้าง CL ของทุกสาขา
            $shop = DB::select("SELECT
                    wg_scale.*,
                    tb_customer.marker,
                    tb_customer.customer_name,
                    tb_customer.id as customer_id
                    FROM
                    wg_scale
                    LEFT JOIN tb_customer ON wg_scale.scale_number = tb_customer.customer_code
                    WHERE
                    wg_scale.location_type = 'ร้านค้า'
                    AND wg_scale.department IS NOT NULL ");

            // ตัดหมูออกจาก OV ตามจำนวนที่นำไปแกะให้สาขา
            DB::update("UPDATE tb_order_overnight set current_pig = current_pig - $sum_amount WHERE order_number = '$order_group'");

            foreach ($shop as $key => $shop_) {
                $order_number = DB::select("CALL CREATE_ORDER_CUTTING('$request->dateOV','$shop_->marker','','$request->round','')");
                $orderCl = $order_number[0]->ORDER_NUMBER;
                
                DB::insert('INSERT INTO tb_order_cutting ( order_number, total_pig, note, id_user_customer,id_user_provider,date,type_request,created_at,
                    marker,customer_id,`round`,date_transport,order_ref,check_order)
                    values (?,?,?,?,?,?,?,?,?,?,?,?,?,?)',
                    [$orderCl,$sum_amount,$request->note,$shop_->customer_name,$request->provider,$request->dateOV,$request->type_req,now(),
                    $shop_->marker,$shop_->customer_id,$request->round,$request->dateTransport,$order_group,'AUTO']);        
                    
                $date_plan = substr($request->dateOV,6,4).'-'.substr($request->dateOV,3,2).'-'.substr($request->dateOV,0,2).' 13:00:00';

                DB::insert("INSERT INTO action_number(id_ref_order,lot_number,plan_amount,actual_amount,created_at,department,
                    marker,customer,action_type,process_number)
                    value('$orderCl',now(),$sum_amount,0,'$date_plan',8,
                    '$shop_->marker','$shop_->customer_name','$request->type_req','$request->dateOV'),
                    ('$orderCl',now(),$sum_amount,0,'$date_plan',9,
                    '$shop_->marker','$shop_->customer_name','$request->type_req','$request->dateOV')" );// 8 เครื่องตัดแต่ง  7 ออก ov
            }
        }

        return back();
    }

    public function ajaxOrder(){

        $sql = DB::select("SELECT
            tb_order_overnight.id,
            tb_order_overnight.order_group,
            tb_order_overnight.order_number,
            tb_order_overnight.total_pig,
            tb_order_overnight.weight_range,
            tb_order_overnight.note,
            tb_order_overnight.date,
            tb_order_overnight.id_user_customer,
            tb_order_overnight.id_user_provider,
            tb_order_overnight.id_user_sender,
            tb_order_overnight.id_user_recieve,
            tb_order_overnight.`status`,
            tb_order_overnight.marker,
            tb_order_overnight.round,
            tb_order_overnight.storage_id,
            tb_order_overnight.order_ref,
            customer.fname AS customer,
            provider.fname AS provider,
            sender.fname AS sender,
            recieve.fname AS recieve,
            tb_order_type.order_type,
            wg_storage.name_storage,
            wg_storage.description,
            tb_order_overnight.date_transport
        FROM
            tb_order_overnight
            LEFT JOIN users AS customer ON tb_order_overnight.id_user_customer = customer.id
            LEFT JOIN users AS provider ON tb_order_overnight.id_user_provider = provider.id
            LEFT JOIN users AS sender ON tb_order_overnight.id_user_sender = sender.id
            LEFT JOIN users AS recieve ON tb_order_overnight.id_user_recieve = recieve.id
            LEFT JOIN tb_order_type ON tb_order_overnight.type_request = tb_order_type.id
            LEFT JOIN wg_storage ON tb_order_overnight.storage_id = wg_storage.id_storage 
        WHERE
            tb_order_overnight.type_request <> 4
        ORDER BY
            tb_order_overnight.created_at ASC", []);

        return Datatables::of($sql)->make(true);
    }
    
    public function delete_order_ov(Request $request){
        $weighing = wg_sku_weight_data::where('lot_number', '=', $request->order_group)->limit(1)->get();

        if (!empty($weighing[0]->lot_number)) {
            return 'Order ได้เริ่มการผลิตแล้ว ไม่สามารถลบได้';
        } else {

        #คืนหมุที่จะลบ
        $ov_data = DB::select("SELECT * from tb_order_overnight WHERE order_group = '$request->order_group'");
        foreach ($ov_data as $key => $ov) {
            DB::update("UPDATE wg_stock_log set side_of_pig = side_of_pig + '".$ov->total_pig."' WHERE bill_number = '".$ov->order_ref."' ");
        }

        DB::delete("DELETE FROM tb_order_overnight WHERE order_group = '$request->order_group' ", []);
        DB::delete("DELETE FROM action_number WHERE id_ref_order = '$request->order_group' ", []);
        return 'ลบ '.$request->order_group;
        }
    }

    public function ajaxOrderCuttingToday(Request $request){
        
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
                                tb_order_offal.date_transport
                            FROM
                                tb_order_offal
                                LEFT JOIN users AS customer ON tb_order_offal.id_user_customer = customer.id
                                LEFT JOIN users AS provider ON tb_order_offal.id_user_provider = provider.id
                                LEFT JOIN users AS sender ON tb_order_offal.id_user_sender = sender.id
                                LEFT JOIN users AS recieve ON tb_order_offal.id_user_recieve = recieve.id
                                LEFT JOIN tb_order_type ON tb_order_offal.type_request = tb_order_type.id
                                LEFT JOIN wg_storage ON tb_order_offal.storage_id = wg_storage.id_storage 
                            WHERE
                                tb_order_offal.order_number NOT IN (( SELECT id_ref_order FROM pd_lot WHERE pd_lot.department = '$request->department' ))
                                AND tb_order_offal.type_request <> 4
                            ORDER BY
                                tb_order_offal.created_at DESC", []
            );
        return Datatables::of($sql)->make(true);
    }
    
    public function addOrderCutting_to_lot(Request $request){

            $order = DB::select("SELECT tb_order_offal.* FROM tb_order_offal
                                WHERE tb_order_offal.order_number = '$request->order_number'");
            
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
    
                DB::update("UPDATE tb_order_offal set current_lot = '$request->lot' WHERE id = '$order_->id' ");
    

                    //เพิ่มคิวจัดส่ง จะเพิ่มคิวรับออเดอร์ให้หน้าร้านด้วย โดยค้นหา department ของหน้าร้าน
                    //เพิ่มในline เครื่องในด้วย
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
                                pd_lot.process_number,
                                DATE_FORMAT( pd_lot.start_date_process , '%d/%m/%Y') as date_picker
                                FROM
                                pd_lot
                                LEFT JOIN tb_order_offal ON pd_lot.id_ref_order = tb_order_offal.order_number
                                WHERE
                                pd_lot.lot_number = '$request->lot'
                                AND 
                                pd_lot.department = '$request->department'
                                AND tb_order_offal.type_request <> 4
                                ORDER BY pd_lot.id
                                ");
        return Datatables::of($order_lot)->addIndexColumn()->make(true);
    }

    public function order_edit(Request $request){

        $ov_data = DB::select("SELECT * from tb_order_overnight WHERE order_group = '$request->order_group'");
        $total_pig= 0;
        foreach ($ov_data as $key => $ov_datas) {
            $total_pig =  $total_pig + $ov_datas->total_pig;
        }

        // check running order ?
        $weighing = wg_sku_weight_data::where('lot_number', '=', $request->order_group)->limit(1)->get();
        if (!empty($weighing[0]->lot_number)) {
            return redirect()->back()->with('message', 'Order ได้เริ่มการผลิตแล้ว ไม่สามารถแก้ไขได้');
        }
        else {
             
            $round = ($request->round == '' ? '' : $request->round);
            $order_group = DB::select("CALL CREATE_ORDER_OVERNIGHT('$request->dateOV','$request->marker','$total_pig','$round')");
            $order = $order_group[0]->ORDER_NUMBER;
    
            $check_unique = DB::select("SELECT * FROM tb_order_overnight WHERE order_group = '$order'");
            if (count($check_unique) > 0) {
                return redirect()->back() ->with('alert', 'warnning!');
            }

            DB::update("UPDATE tb_order_overnight set order_group = '$order' ,date = '$request->dateOV' ,created_at = NOW(),
            `round` = '$request->round' WHERE  order_group = '$request->order_group' " ,[]);

            $date_plan = substr($request->datepicker,6,4).'-'.substr($request->datepicker,3,2).'-'.substr($request->datepicker,0,2).' 13:00:00';

            DB::update("UPDATE action_number set id_ref_order = ? , plan_amount = '$total_pig',
            actual_amount = '0' ,created_at = ? WHERE id_ref_order = ?"
            ,[$order,$date_plan,$request->order_group]);

            return redirect()->back();
           
        }


    }
}