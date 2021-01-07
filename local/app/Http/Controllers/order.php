<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;
use Auth;
use App\wg_sku_weight_data;

class order extends Controller
{
    public function index(){

        $user = DB::select('SELECT * from users where id_type is not null', []);
        $type_order = DB::select('SELECT * from tb_order_type where `type` <> "รับหมู" ');
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
        $type_order_bill = DB::select("SELECT * from type_order_bill ORDER BY id");

        $standard_weight = DB::select('SELECT * FROM standard_weight');

        $standard_pricr_list_group = DB::select('SELECT * FROM standard_price_list_group');

        return view('order.create_order',compact('user','type_order','customer','stock','standard_weight','type_order_bill','standard_pricr_list_group'));
    }

    public function ajaxOrder(){

            $sql = DB::select("SELECT
            tb_order.id,
            tb_order.order_number,
            tb_order.total_pig,
            tb_order.weight_range,
            tb_order.note,
            tb_order.date,
            tb_order.id_user_customer,
            tb_order.id_user_provider,
            tb_order.id_user_sender,
            tb_order.id_user_recieve,
            tb_order.`status`,
            tb_order.marker,
            tb_order.round,
            tb_order.storage_id,
            customer.fname AS customer,
            provider.fname AS provider,
            sender.fname AS sender,
            recieve.fname AS recieve,
            tb_order_type.order_type,
            wg_storage.name_storage,
            wg_storage.description,
            type_order_bill.type_name,
            tb_order.customer_id,
            tb_order.status_bill,
            tb_order.do_number
        FROM
            tb_order
            LEFT JOIN users AS customer ON tb_order.id_user_customer = customer.id
            LEFT JOIN users AS provider ON tb_order.id_user_provider = provider.id
            LEFT JOIN users AS sender ON tb_order.id_user_sender = sender.id
            LEFT JOIN users AS recieve ON tb_order.id_user_recieve = recieve.id
            LEFT JOIN tb_order_type ON tb_order.type_request = tb_order_type.id
            LEFT JOIN wg_storage ON tb_order.storage_id = wg_storage.id_storage 
            LEFT JOIN type_order_bill ON tb_order.id_type_order_bill = type_order_bill.id
        WHERE
            tb_order.type_request <> 4  and  tb_order.created_at BETWEEN NOW() - INTERVAL 30 DAY AND NOW()
        ORDER BY
            tb_order.created_at DESC", []);

        return Datatables::of($sql)->make(true);
    }

    public function ajaxOrder_type_branch(){

            $sql = DB::select("SELECT * 
                    ,tb_order_type.order_type
                FROM `tb_order_overnight` 
                LEFT JOIN tb_order_type ON tb_order_overnight.type_request = tb_order_type.id
                WHERE tb_order_overnight.type_request IN (3) GROUP BY date ORDER BY tb_order_overnight.id DESC", []
            );
           

        return Datatables::of($sql)->make(true);
    }   

    public function ajaxOrderToday(Request $request){
        
        if ($request->department == 1) {
            $sql = DB::select("SELECT
                tb_order.id,
                tb_order.order_number,
                tb_order.total_pig,
                tb_order.weight_range,
                tb_order.note,
                tb_order.id_user_customer,
                tb_order.id_user_provider,
                tb_order.id_user_sender,
                tb_order.id_user_recieve,
                tb_order.`status`,
                tb_order.marker,
                customer.fname AS customer,
                provider.fname AS provider,
                sender.fname AS sender,
                recieve.fname AS recieve,
                tb_order_type.order_type,
                tb_product_plan.plan_recieve as `date`,
                tb_product_plan.plan_slice,
                tb_product_plan.plan_carcade,
                tb_product_plan.plan_offal,
                tb_product_plan.plan_overnight,
                tb_product_plan.plan_trim,
                tb_product_plan.plan_sending,
                tb_order.round
                FROM
                tb_order
                LEFT JOIN users AS customer ON tb_order.id_user_customer = customer.id
                LEFT JOIN users AS provider ON tb_order.id_user_provider = provider.id
                LEFT JOIN users AS sender ON tb_order.id_user_sender = sender.id
                LEFT JOIN users AS recieve ON tb_order.id_user_recieve = recieve.id
                LEFT JOIN tb_order_type ON tb_order.type_request = tb_order_type.id
                LEFT JOIN tb_product_plan ON tb_order.order_number = tb_product_plan.order_number
                WHERE
                tb_order.order_number NOT IN (( SELECT id_ref_order FROM pd_lot WHERE pd_lot.department = '$request->department' ))
                AND tb_order.type_request <> 4
                ORDER BY
                tb_order.created_at DESC", []
            );
        }

        if ($request->department == 2) {
            $sql = DB::select("SELECT
                tb_order.id,
                tb_order.order_number,
                tb_order.total_pig,
                tb_order.weight_range,
                tb_order.note,
                tb_order.id_user_customer,
                tb_order.id_user_provider,
                tb_order.id_user_sender,
                tb_order.id_user_recieve,
                tb_order.`status`,
                tb_order.marker,
                customer.fname AS customer,
                provider.fname AS provider,
                sender.fname AS sender,
                recieve.fname AS recieve,
                tb_order_type.order_type,
                tb_product_plan.plan_recieve,
                tb_product_plan.plan_slice as `date`,
                tb_product_plan.plan_carcade,
                tb_product_plan.plan_offal,
                tb_product_plan.plan_overnight,
                tb_product_plan.plan_trim,
                tb_product_plan.plan_sending,
                tb_order.round
                FROM
                tb_order
                LEFT JOIN users AS customer ON tb_order.id_user_customer = customer.id
                LEFT JOIN users AS provider ON tb_order.id_user_provider = provider.id
                LEFT JOIN users AS sender ON tb_order.id_user_sender = sender.id
                LEFT JOIN users AS recieve ON tb_order.id_user_recieve = recieve.id
                LEFT JOIN tb_order_type ON tb_order.type_request = tb_order_type.id
                LEFT JOIN tb_product_plan ON tb_order.order_number = tb_product_plan.order_number
                WHERE
                tb_order.order_number NOT IN (( SELECT id_ref_order FROM pd_lot WHERE pd_lot.department = '$request->department' ))
                AND tb_order.type_request <> 4
                ORDER BY
                tb_order.created_at DESC", []
            );
        }

        if ($request->department == 3) {
            $sql = DB::select("SELECT
                tb_order.id,
                tb_order.order_number,
                tb_order.total_pig,
                tb_order.weight_range,
                tb_order.note,
                tb_order.id_user_customer,
                tb_order.id_user_provider,
                tb_order.id_user_sender,
                tb_order.id_user_recieve,
                tb_order.`status`,
                tb_order.marker,
                customer.fname AS customer,
                provider.fname AS provider,
                sender.fname AS sender,
                recieve.fname AS recieve,
                tb_order_type.order_type,
                tb_product_plan.plan_recieve,
                tb_product_plan.plan_slice,
                tb_product_plan.plan_carcade,
                tb_product_plan.plan_offal,
                tb_product_plan.plan_overnight,
                tb_product_plan.plan_trim as `date`,
                tb_product_plan.plan_sending,
                tb_order.round
                FROM
                tb_order
                LEFT JOIN users AS customer ON tb_order.id_user_customer = customer.id
                LEFT JOIN users AS provider ON tb_order.id_user_provider = provider.id
                LEFT JOIN users AS sender ON tb_order.id_user_sender = sender.id
                LEFT JOIN users AS recieve ON tb_order.id_user_recieve = recieve.id
                LEFT JOIN tb_order_type ON tb_order.type_request = tb_order_type.id
                LEFT JOIN tb_product_plan ON tb_order.order_number = tb_product_plan.order_number
                WHERE
                tb_order.order_number NOT IN (( SELECT id_ref_order FROM pd_lot WHERE pd_lot.department = '$request->department' ))
                AND tb_order.type_request <> 4
                ORDER BY
                tb_order.created_at DESC", []
            );
        }
        
        if ($request->department == 4) {
            $sql = DB::select("SELECT
                tb_order.id,
                tb_order.order_number,
                tb_order.total_pig,
                tb_order.weight_range,
                tb_order.note,
                tb_order.id_user_customer,
                tb_order.id_user_provider,
                tb_order.id_user_sender,
                tb_order.id_user_recieve,
                tb_order.`status`,
                tb_order.marker,
                customer.fname AS customer,
                provider.fname AS provider,
                sender.fname AS sender,
                recieve.fname AS recieve,
                tb_order_type.order_type,
                tb_product_plan.plan_recieve,
                tb_product_plan.plan_slice,
                tb_product_plan.plan_carcade,
                tb_product_plan.plan_offal,
                tb_product_plan.plan_overnight,
                tb_product_plan.plan_trim,
                tb_product_plan.plan_sending as `date`,
                tb_order.round
                FROM
                tb_order
                LEFT JOIN users AS customer ON tb_order.id_user_customer = customer.id
                LEFT JOIN users AS provider ON tb_order.id_user_provider = provider.id
                LEFT JOIN users AS sender ON tb_order.id_user_sender = sender.id
                LEFT JOIN users AS recieve ON tb_order.id_user_recieve = recieve.id
                LEFT JOIN tb_order_type ON tb_order.type_request = tb_order_type.id
                LEFT JOIN tb_product_plan ON tb_order.order_number = tb_product_plan.order_number
                WHERE
                tb_order.order_number NOT IN (( SELECT id_ref_order FROM pd_lot WHERE pd_lot.department = '$request->department' ))
                AND tb_order.type_request <> 4
                ORDER BY
                tb_order.created_at DESC", []
            );
        }

        return Datatables::of($sql)->make(true);
    }

    public function ajaxSavePlan(Request $request){

        DB::insert("UPDATE tb_product_plan set plan_recieve = '$request->plan_recieve', plan_slice = '$request->plan_slice',
                 plan_carcade = '$request->plan_carcade',plan_offal = '$request->plan_offal', plan_overnight = '$request->plan_overnight', 
                 plan_trim = '$request->plan_trim', plan_sending = '$request->plan_sending', note = '$request->note'
                WHERE order_number = '$request->order_number'",[]);

        return 'สำเร็จ';
    }

    public function createOrder(Request $request){

        if ($request->type_req == 2) {
            $order_number = DB::select("CALL CREATE_ORDER_P('$request->datepicker','$request->marker','$request->amount','$request->round')");
            $order = $order_number[0]->ORDER_NUMBER;

            $check_unique = DB::select("SELECT * FROM tb_order WHERE order_number = '$order'");
            if (count($check_unique) > 0) {
                return '1';
            } 


        }else{
            $num = '000';
            if (strlen($request->amount) == 1 ) {
                $num = '00'.$request->amount;
            }elseif (strlen($request->amount) == 2) {
                $num = '0'.$request->amount;
            }else {
                $num = $request->amount;
            }
            $order_number = DB::select("CALL CREATE_ORDER('$request->datepicker','$request->marker','$num','$request->round','$request->status')");
            $order = $order_number[0]->ORDER_NUMBER;

            $check_unique = DB::select("SELECT * FROM tb_order WHERE order_number = '$order'");
            if (count($check_unique) > 0) {
                return '1';
            } 
        }
        
        DB::insert('INSERT INTO tb_order
            ( order_number, total_pig, weight_range, note, id_user_customer,
            id_user_provider, id_user_sender, id_user_recieve ,date,type_request,created_at,
            status,marker,customer_id,`round`,storage_id,current_pig,current_offal,id_type_order_bill,type_pig)
            values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',
            [$order,$request->amount,$request->weight_range,$request->note,
            $request->customer,1,$request->sender,$request->recieve,$request->datepicker,$request->type_req,now(),
            0,$request->marker,$request->customer_id,$request->round,$request->stock,$request->amount,$request->amount,$request->type_order_bill,$request->type_pig]);

        DB::insert('INSERT INTO tb_product_plan(order_number,note,plan_recieve)
            values (?,?,?)',[$order,$request->note,$request->datepicker]);

        // 3 = หมูสาขา เพิ่มเลขorder ในตาชั่งทันที ตามวันที่ระบุ  1 = ตาชั่งรับหมู
        // if ($request->type_req == 3 ){
            $date_plan = substr($request->datepicker,6,4).'-'.substr($request->datepicker,3,2).'-'.substr($request->datepicker,0,2).' 13:00:00';
            DB::insert("INSERT INTO action_number(id_ref_order,plan_amount,actual_amount,created_at,department,
            marker,customer,action_type,process_number)
            value('$order','$request->amount',0,'$date_plan',1,
            '$request->marker','$request->customer','$request->type_req','$request->datepicker')" );

            DB::insert("INSERT INTO pd_lot(id_ref_order,lot_number,order_plan_amount,order_actual_amount,
            start_date_process,lot_status,department,process_number,created_at)
            value('$order',now(),$request->amount,0,
            '$date_plan',0,1,'$request->datepicker',now()) ");
        // }

        
        return 'เลข ORDER คือ :'.$order;
    }

    public function indexPlan(){
        return view('order.order_plan');
    } 

    public function ajaxPlan(){
        $sql = DB::select('SELECT
        tb_order.id,
        tb_order.order_number,
        tb_order.total_pig,
        tb_order.weight_range,
        tb_order.marker,
        tb_order.round,
        tb_product_plan.plan_recieve,
        tb_product_plan.plan_slice,
        tb_product_plan.plan_carcade,
        tb_product_plan.plan_offal,
        tb_product_plan.plan_overnight,
        tb_product_plan.plan_trim,
        tb_product_plan.plan_sending,
        tb_order.note,
        tb_order.id_user_customer,
        tb_order_type.order_type 
        FROM
        tb_order
        LEFT JOIN tb_product_plan ON tb_product_plan.order_number = tb_order.order_number
        LEFT JOIN tb_order_type ON tb_order.type_request = tb_order_type.id 
        WHERE tb_order.type_request <> 4
        ORDER BY tb_order.created_at DESC', []);

        return Datatables::of($sql)->make(true);
    }

    public function getPlan(Request $request){
        return  $sql = DB::select("SELECT
        tb_order.id,
        tb_order.order_number,
        tb_order.total_pig,
        tb_order.weight_range,
        tb_order.marker,
        tb_product_plan.plan_recieve,
        tb_product_plan.plan_slice,
        tb_product_plan.plan_carcade,
        tb_product_plan.plan_offal,
        tb_product_plan.plan_overnight,
        tb_product_plan.plan_trim,
        tb_product_plan.plan_sending,
        tb_product_plan.note,
        tb_order.id_user_customer,
        tb_order_type.order_type 
        FROM
        tb_order
        LEFT JOIN tb_product_plan ON tb_product_plan.order_number = tb_order.order_number
        LEFT JOIN tb_order_type ON tb_order.type_request = tb_order_type.id
        WHERE tb_order.order_number = '$request->order_number'
        AND tb_order.type_request <> 4
        ORDER BY tb_order.created_at DESC", []);
    }

    public function plan_daily($id){
        $current_lot = DB::select("SELECT * FROM `pd_lot_master` WHERE 
                                    DATE_FORMAT(pd_lot_master.created_at,'%d/%m/%Y') =  DATE_FORMAT(NOW(),'%d/%m/%Y') 
                                    ORDER BY pd_lot_master.created_at DESC LIMIT 1", []);
        $lot_number = null;
        foreach ($current_lot as $key => $current) {
            $lot_number = $current->lot_number;
        }

        $department = DB::select('SELECT * FROM tb_department', []);
       
        return view('order.order_plan_daily' , compact('department','lot_number','id'));
    }

    public function plan_cutting($id){
        $current_lot = DB::select("SELECT * FROM `pd_lot_master` WHERE 
                                    DATE_FORMAT(pd_lot_master.created_at,'%d/%m/%Y') =  DATE_FORMAT(NOW(),'%d/%m/%Y') 
                                    ORDER BY pd_lot_master.created_at DESC LIMIT 1", []);
        $lot_number = null;
        foreach ($current_lot as $key => $current) {
            $lot_number = $current->lot_number;
        }

        $department = DB::select('SELECT * FROM tb_department', []);
        $customer = DB::select('SELECT * from tb_customer');

        $stock_over_night = DB::select('SELECT
                            wg_sku_weight_data.id,
                            wg_sku_weight_data.lot_number,
                            wg_sku_weight_data.sku_id,
                            wg_sku_weight_data.sku_code,
                            SUM(wg_sku_weight_data.sku_amount) as sku_amount,
                            wg_sku_weight_data.sku_weight,
                            wg_sku_weight_data.sku_unit,
                            wg_sku_weight_data.weighing_type,
                            wg_sku_weight_data.weighing_place,
                            wg_sku_weight_data.scale_number,
                            wg_sku_weight_data.storage_name,
                            wg_sku_weight_data.storage_compartment,
                            wg_sku_weight_data.user_name,
                            wg_sku_weight_data.weighing_ref,
                            wg_sku_weight_data.weighing_date,
                            wg_sku_weight_data.note,
                            wg_sku_weight_data.created_at,
                            wg_sku_weight_data.updated_at,
                            wg_sku_weight_data.process_number,
                            wg_scale.department,
                            wg_scale.process_number
                            FROM
                            wg_sku_weight_data
                            LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                            WHERE
                            wg_scale.process_number = 3
                            GROUP BY
                            wg_sku_weight_data.lot_number
                            ORDER BY 
                            wg_sku_weight_data.weighing_date DESC
                            LIMIT 20
        ');
       
        return view('order.order_plan_cutting' , compact('department','lot_number','id','customer','stock_over_night'));
    }

    public function order_cutting_create(Request $request){
        $order_number = DB::select("CALL CREATE_ORDER_CUTTING('$request->datepicker')");
        $order = $order_number[0]->ORDER_NUMBER;
        
        // DB::insert('INSERT INTO tb_order
        //     ( order_number, total_pig, weight_range, note, id_user_customer,
        //     id_user_provider, id_user_sender, id_user_recieve ,date,type_request,created_at,
        //     status,marker,customer_id,`round`,storage_id)
        //     values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',
        //     [$order,$request->amount,$request->weight_range,$request->note,
        //     $request->customer,1,$request->sender,$request->recieve,$request->datepicker,$request->type_req,now(),
        //     0,$request->marker,$request->customer_id,$request->round,$request->stock]);

        // DB::insert('INSERT INTO tb_product_plan(order_number,note)
        //     values (?,?)',[$order,$request->note]);

        return 'เลข ORDER คือ :'.$order;
    }
    
    public function ajaxLot(Request $request){
        $order_plan_amount = $request->total_pig;
        $ref_order = $request->order_number;
      
        $select_cureent_lot = DB::select("SELECT
                                        pd_lot.* , tb_order.* FROM
                                        pd_lot LEFT JOIN tb_order ON pd_lot.id_ref_order = tb_order.order_number
                                        WHERE
                                        pd_lot.lot_status = 1 AND pd_lot.id_ref_order = '$ref_order'");

        if($select_cureent_lot != null && $select_cureent_lot != ""){
            return $select_cureent_lot;
        }

        return $sql = DB::select("SELECT tb_order.*
                                FROM tb_order
                                WHERE tb_order.order_number = '$ref_order'
                                AND tb_order.type_request <> 4", []);
    }
    
    public function ajaxWeighing(Request $request){
        $lot_number = $request->lot_number;
        return $sql = DB::select("SELECT * FROM
                                wg_sku_weight_data
                                WHERE
                                wg_sku_weight_data.lot_number = '$lot_number'
                                ORDER BY
                                wg_sku_weight_data.id ASC", []);
    }

    public function start_stop_create_lot(Request $request){
        $order_plan_amount = $request->total_pig;
        $ref_order = $request->order_number;
        return $lot_number = DB::select("CALL NEW_LOT('$order_plan_amount','$ref_order')");

        // DB::update("UPDATE tb_order set status = 1 where id = '$ref_order'");
    }

    public function indexLot(){
        return view('order.order_lot');
    }

    public function create_lot(){
        
        $lot_number = DB::select("CALL CREATE_LOT()");
        $lot = $lot_number[0]->LOT_NUMBER;
            DB::insert("INSERT INTO pd_lot_master(lot_number,lot_status,`user_id`,created_at)
            value('$lot',0,?,now())" , [Auth::user()->id]);
        return $lot;
    }
    
    public function addOrder_to_lot(Request $request){
        $order = DB::select("SELECT tb_order.*,tb_product_plan.*
                             FROM tb_order
                             LEFT JOIN tb_product_plan ON tb_order.order_number = tb_product_plan.order_number
                             WHERE tb_order.order_number = '$request->order_number'");
        
        $department_id = DB::select("SELECT * FROM `tb_department` WHERE tb_department.id = '$request->id' ");
      
        $date_plan = now();
        foreach($order as $order_){
            $process = '';
            foreach ($department_id as $_id) {
                $process_number = DB::select("CALL CREATE_PROCESS_NUMBER('$_id->sign','$order_->marker',$request->total_pig,'$request->lot')");
                $process = $process_number[0]->LOT_NUMBER;

                if ($request->id == 1) {
                    $date_plan = substr($order_->plan_recieve,6,4).'-'.substr($order_->plan_recieve,3,2).'-'.substr($order_->plan_recieve,0,2).' 13:00:00';
                } elseif ($request->id == 2) {
                    $date_plan = substr($order_->plan_slice,6,4).'-'.substr($order_->plan_slice,3,2).'-'.substr($order_->plan_slice,0,2).' 13:00:00';
                } elseif ($request->id == 3) {
                    $date_plan = substr($order_->plan_trim,6,4).'-'.substr($order_->plan_trim,3,2).'-'.substr($order_->plan_trim,0,2).' 13:00:00';
                } elseif ($request->id == 4) {
                    $date_plan = substr($order_->plan_sending,6,4).'-'.substr($order_->plan_sending,3,2).'-'.substr($order_->plan_sending,0,2).' 13:00:00';
                }
            }
            
            DB::insert("INSERT INTO pd_lot(id_ref_order,lot_number,order_plan_amount,order_actual_amount,
                        start_date_process,lot_status,department,process_number,created_at)
                        value('$order_->order_number',now(),$request->total_pig,0,'$date_plan',0,2,'$process',now())
                        ,('$order_->order_number',now(),$request->total_pig,0,'$date_plan',0,3,'$process',now())
                        ,('$order_->order_number',now(),$request->total_pig,0,'$date_plan',0,4,'$process',now())
                        ,('$order_->order_number',now(),$request->total_pig,0,'$date_plan',0,5,'$process',now())
                        ,('$order_->order_number',now(),$request->total_pig,0,'$date_plan',0,6,'$process',now())  
                        ");

            DB::insert("INSERT INTO action_number(id_ref_order,lot_number,plan_amount,actual_amount,created_at,department,
                        marker,customer,action_type,process_number)
                        value('$order_->order_number',now(),$request->total_pig,0,'$date_plan',2,
                        '$order_->marker','$order_->id_user_customer','$order_->type_request','$process'),
                        ('$order_->order_number',now(),$request->total_pig,0,'$date_plan',3,
                        '$order_->marker','$order_->id_user_customer','$order_->type_request','$process')
                        ,('$order_->order_number',now(),$request->total_pig,0,'$date_plan',4,
                        '$order_->marker','$order_->id_user_customer','$order_->type_request','$process'),
                        ('$order_->order_number',now(),$request->total_pig,0,'$date_plan',5,
                        '$order_->marker','$order_->id_user_customer','$order_->type_request','$process'),
                        ('$order_->order_number',now(),$request->total_pig,0,'$date_plan',6,
                        '$order_->marker','$order_->id_user_customer','$order_->type_request','$process')
                        " );

            DB::insert("INSERT INTO wg_stock_log(id_storage,bill_number,ref_source,
                        total_unit,date_recieve,note,item_code,created_at,
                        type_request,`action`,side_of_pig) 
                        value(?,?,?,?,?,?,?,?,?,?,?)",
                        ['102',$order_->order_number,'PP',
                        $request->total_pig,$order_->plan_slice,$order_->note,'ซีก',now(),
                        $order_->type_request,'add_from_r',$request->total_pig]);



            DB::update("UPDATE tb_order set current_lot = now() WHERE id = '$order_->id' ");


            //เช็คว่าสร้างไปหรือยัง ต่อวัน กรณีR >1
                $check_order_exist = DB::select("SELECT * FROM tb_order_offal 
                WHERE date = '$order_->plan_slice' AND check_order = 'AUTO' ");

            if (empty($check_order_exist[0]->id) && $request->marker == 'X') {/* กรณีหมูรวม */
                // สร้าง OF ของทุกสาขา
                $shop = DB::select("SELECT
                    wg_scale.*,
                    tb_customer.marker,
                    tb_customer.customer_name,
                    tb_customer.id as customer_id
                    FROM
                    wg_scale
                    LEFT JOIN tb_customer ON wg_scale.scale_number = tb_customer.customer_code
                    WHERE
                    wg_scale.location_type = 'ร้านค้า' AND wg_scale.department IS NOT NULL
                ");

                foreach ($shop as $key => $shop_) {
                    $order_number = DB::select("CALL CREATE_ORDER_OFFAL('$order_->plan_slice','$shop_->marker','','$order_->round','')");
                    $order = $order_number[0]->ORDER_NUMBER;
                    
                    DB::insert('INSERT INTO tb_order_offal( order_number, note, id_user_customer,id_user_provider,date,type_request,created_at,
                    marker,customer_id,`round`,order_ref,check_order)
                    values (?,?,?,?,?,?,?,?,?,?,?,?)',
                    [$order,$order_->note,$shop_->customer_name,$order_->id_user_provider,$order_->plan_slice,$order_->type_request,now(),
                    $shop_->marker,$shop_->customer_id,$order_->round,$order_->order_number,'AUTO']);
            
                    $date_plan = substr($order_->plan_slice,6,4).'-'.substr($order_->plan_slice,3,2).'-'.substr($order_->plan_slice,0,2).' 13:00:00';
            
                    DB::insert("INSERT INTO action_number(id_ref_order,lot_number,plan_amount,actual_amount,created_at,department,
                        marker,customer,action_type,process_number)
                        value('$order',now(),$order_->total_pig,0,'$date_plan',4,
                        '$shop_->marker','$shop_->customer_name','$order_->type_request','$order_->plan_slice'),
                        ('$order',now(),$order_->total_pig,0,'$date_plan',5,
                        '$order_->marker','$shop_->customer_name','$order_->type_request','$order_->plan_slice'),
                        ('$order',now(),$order_->total_pig,0,'$date_plan',6,
                        '$shop_->marker','$shop_->customer_name','$order_->type_request','$order_->plan_slice')" );// 5 6 เครื่องใน
                    DB::insert("INSERT INTO pd_lot(id_ref_order,lot_number,order_plan_amount,order_actual_amount,
                        start_date_process,lot_status,department,process_number,created_at)
                        value('$order',now(),$order_->total_pig,0,
                        '$date_plan',0,8,'$order_->plan_slice',now()) ");
                }
            }

        }




        
        return 'success';
    }

    public function get_ajax_inLot(Request $request){
        $order_lot = DB::select("SELECT
                                pd_lot.id,
                                pd_lot.id_ref_order,
                                pd_lot.lot_number,
                                tb_order.id,
                                tb_order.order_number,
                                tb_order.total_pig,
                                tb_order.weight_range,
                                tb_order.note,
                                tb_order.date,
                                tb_order.id_user_customer,
                                tb_order.id_user_provider,
                                tb_order.id_user_sender,
                                tb_order.id_user_recieve,
                                tb_order.`status`,
                                tb_order.marker,
                                tb_order.round,
                                pd_lot.process_number,
                                DATE_FORMAT( pd_lot.start_date_process, '%d/%m/%Y' ) AS date_picker,
                                pd_lot.start_date_process
                                FROM
                                pd_lot
                                LEFT JOIN tb_order ON pd_lot.id_ref_order = tb_order.order_number
                                WHERE
                                pd_lot.department = '2' AND
                                tb_order.type_request <> 4
                                ORDER BY
                                pd_lot.id ASC
            ");
        return Datatables::of($order_lot)->addIndexColumn()->make(true);
    }
    
    public function order_edit(Request $request){

        $data_order = DB::select("SELECT * from tb_order WHERE order_number = '$request->order_number'");

        $weighing = wg_sku_weight_data::where('lot_number', '=', $request->order_number)->limit(1)->get();
        if (!empty($weighing[0]->lot_number)) {
            return redirect()->back()->with('message', 'Order ได้เริ่มการผลิตแล้ว ไม่สามารถแก้ไขได้');
        } else {
             $check_order = substr($request->datepicker,8,2).substr($request->datepicker,3,2).substr($request->datepicker,0,2);
            if (substr($request->order_number,1,6) != $check_order || substr($request->order_number, -1) != $request->round || $data_order[0]->total_pig != $request->amount) {
                
                if ($request->type_req == 2) {
                    $order_number = DB::select("CALL CREATE_ORDER_P('$request->datepicker','$request->marker','$request->amount','$request->round')");
                    $order = $order_number[0]->ORDER_NUMBER;
        
                    $check_unique = DB::select("SELECT * FROM tb_order WHERE order_number = '$order'");
                    if (count($check_unique) > 0) {
                        return redirect()->back() ->with('alert', 'warnning!');
                    } 
        
        
                }else{
                    $num = '000';
                    if (strlen($request->amount) == 1 ) {
                        $num = '00'.$request->amount;
                    }elseif (strlen($request->amount) == 2) {
                        $num = '0'.$request->amount;
                    }else {
                        $num = $request->amount;
                    }
                    $order_number = DB::select("CALL CREATE_ORDER('$request->datepicker','$request->marker','$num','$request->round','$request->status')");
                    $order = $order_number[0]->ORDER_NUMBER;
        
                    $check_unique = DB::select("SELECT * FROM tb_order WHERE order_number = '$order'");
                    if (count($check_unique) > 0) {
                        return redirect()->back() ->with('alert', 'warnning!');
                    } 
                }

                DB::update("UPDATE tb_order set total_pig='$request->amount',type_request='$request->type_req',`date`='$request->datepicker',
                id_user_customer='$request->customer',marker='$request->marker',weight_range='$request->weight_range'
                ,note='$request->note',order_number='$order' ,`round`='$request->round' , current_pig ='$request->amount',current_offal ='$request->amount',id_type_order_bill='$request->type_bill'
                Where order_number='$request->order_number' ");
 
                DB::update("UPDATE tb_product_plan set order_number = '$order', plan_recieve ='$request->datepicker'
                Where order_number='$request->order_number' ");

                // 3 = หมูสาขา เพิ่มเลขorder ในตาชั่งทันที ตามวันที่ระบุ  1 = ตาชั่งรับหมู
                // if ($request->type_req == 3 ){
                   
                    DB::delete("DELETE FROM pd_lot Where id_ref_order='$request->order_number'");
                    DB::delete("DELETE FROM action_number Where id_ref_order='$request->order_number'");

                    $date_plan = substr($request->datepicker,6,4).'-'.substr($request->datepicker,3,2).'-'.substr($request->datepicker,0,2).' 13:00:00';
                    DB::insert("INSERT INTO action_number(id_ref_order,plan_amount,actual_amount,created_at,department,
                    marker,customer,action_type,process_number)
                    value('$order','$request->amount',0,'$date_plan',1,
                    '$request->marker','$request->customer','$request->type_req','$request->datepicker')" );

                    DB::insert("INSERT INTO pd_lot(id_ref_order,lot_number,order_plan_amount,order_actual_amount,
                    start_date_process,lot_status,department,process_number,created_at)
                    value('$order',now(),$request->amount,0,
                    '$request->datepicker',0,1,'$date_plan',now()) ");
                // }
                
                return Redirect('order/create');
            }else {
                DB::update("UPDATE tb_order set total_pig='$request->amount',type_request='$request->type_req',`date`='$request->datepicker',
                id_user_customer='$request->customer',marker='$request->marker',weight_range='$request->weight_range',note='$request->note',
                `round`='$request->round',current_pig ='$request->amount',current_offal ='$request->amount',id_type_order_bill='$request->type_bill'
                Where order_number='$request->order_number' ");

                // 3 = หมูสาขา เพิ่มเลขorder ในตาชั่งทันที ตามวันที่ระบุ  1 = ตาชั่งรับหมู
                // if ($request->type_req == 3 ){
                    DB::delete("DELETE FROM pd_lot Where id_ref_order='$request->order_number'");
                    DB::delete("DELETE FROM action_number Where id_ref_order='$request->order_number'");

                    $date_plan = substr($request->datepicker,6,4).'-'.substr($request->datepicker,3,2).'-'.substr($request->datepicker,0,2).' 13:00:00';
                    DB::insert("INSERT INTO action_number(id_ref_order,plan_amount,actual_amount,created_at,department,
                    marker,customer,action_type,process_number)
                    value('$request->order_number','$request->amount',0,'$date_plan',1,
                    '$request->marker','$request->customer','$request->type_req','$request->datepicker')" );

                    DB::insert("INSERT INTO pd_lot(id_ref_order,lot_number,order_plan_amount,order_actual_amount,
                    start_date_process,lot_status,department,process_number,created_at)
                    value('$request->order_number',now(),$request->amount,0,
                    '$date_plan',0,1,'$request->datepicker',now()) ");
                // }
                
                return Redirect('order/create');
            }
        }


    }

    public function delete_order(Request $request){

        $weighing = wg_sku_weight_data::where('lot_number', '=', $request->order_number)->limit(1)->get();

        if (!empty($weighing[0]->lot_number)) {
            return 'Order ได้เริ่มการผลิตแล้ว ไม่สามารถลบได้';
        } else {

        DB::delete("DELETE FROM tb_order WHERE order_number = '$request->order_number' ", []);
        DB::delete("DELETE FROM action_number WHERE id_ref_order = '$request->order_number' ", []);
        DB::delete("DELETE FROM pd_lot WHERE id_ref_order = '$request->order_number' ", []);

        return 'ลบ '.$request->order_number;
        }
    }

    public function delete_order_bill(Request $request){

        DB::delete("DELETE FROM acc_mk_dom WHERE ref = '$request->order_number' ", []);
        DB::delete("DELETE FROM acc_cmk_dom WHERE ref = '$request->order_number' ", []);
        DB::delete("DELETE FROM acc_mk_dol WHERE ref = '$request->order_number' ", []);
        DB::delete("DELETE FROM acc_kmk_ivl WHERE ref = '$request->order_number' ", []);
        DB::UPDATE("UPDATE tb_order SET status_bill = ? , do_number = ?  WHERE order_number = ?",["0","",$request->order_number]);
       

        return 'ลบ '.$request->order_number;
        
    }

    public function ajax_type_order(){
        $type_order = DB::select('SELECT * FROM `tb_order_type` WHERE tb_order_type.id != 12');
        $type_bill = DB::select('SELECT * FROM type_order_bill');
        return array($type_order,$type_bill);
    }
    
    public function deleteOrder_from_lot(Request $request){
        DB::delete("DELETE FROM action_number WHERE id_ref_order = '$request->order_number' ", []);
        DB::delete("DELETE FROM pd_lot WHERE id_ref_order = '$request->order_number' ", []);
        DB::delete("DELETE FROM wg_stock_log WHERE bill_number = '$request->order_number' ", []);
        return 'ลบสำเร็จ';
    }

    public function getMarkerCustomer(Request $request){
       $data = DB::select("SELECT * FROM `tb_customer` where shop_name = '$request->customer' OR tb_customer.customer_name = '$request->customer'");
       return $data;
    }

    //getMaker ต้นทาง จากสร้างรายการใบโอนสินค้า
    public function getMarkerCustomer_from(Request $request){
        $data = DB::select("SELECT * FROM `tb_customer` where shop_name = '$request->customer_from' OR tb_customer.customer_name = '$request->customer_from'");
        return $data;
     }
    //getMarker ปลายทาง จากสร้างรายการใบโอนสินค้า
    public function getMarkerCustomer_to(Request $request){
        $data = DB::select("SELECT * FROM `tb_customer` where shop_name = '$request->customer_to' OR tb_customer.customer_name = '$request->customer_to'");
        return $data;
     }

    public function getCustomer(Request $request){
        $data = DB::select("SELECT * FROM `tb_customer`");
        return $data;
    }
  

    public function number_of_pig(){
        
        $shop_list = DB::select("SELECT * FROM `tb_shop` WHERE shop_type_id = 2 order by id");
       
        $list_number_of_pig = DB::select("SELECT * from tb_sale_order_numer_pig WHERE  tb_sale_order_numer_pig.created_at BETWEEN NOW() - INTERVAL 30 DAY AND NOW()");
      
        $group_list_number_of_pig = DB::select("SELECT * from tb_sale_order_numer_pig WHERE  tb_sale_order_numer_pig.created_at BETWEEN NOW() - INTERVAL 30 DAY AND NOW() GROUP BY date_order" );
       
        return view("order.number_of_pig",compact('shop_list','list_number_of_pig','group_list_number_of_pig'));
    }
    public function save_pig_number(Request $request){
        
        $check_exist = DB::select("SELECT * From tb_sale_order_numer_pig WHERE date_order = '$request->datepicker1' ");
        if (empty($check_exist)) {
            for ($i=0; $i < count($request->number_of_pig); $i++) { 
                DB::insert("INSERT into tb_sale_order_numer_pig(`number`,shop_code,date_order,date_transport,created_at) 
                values('".$request->number_of_pig[$i]."','".$request->shop[$i]."','".$request->datepicker1."','".$request->datepicker5."',NOW() ) ");
            }
        } else {
            for ($i=0; $i < count($request->number_of_pig); $i++) { 
                DB::insert("UPDATE tb_sale_order_numer_pig set `number` = '".$request->number_of_pig[$i]."'
                   WHERE  shop_code = '".$request->shop[$i]."' AND date_order = '$request->datepicker1' "); 
            }
        }
        return back();
    }


}