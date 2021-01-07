<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use DataTables;
use DB;
use Auth;
use App\wg_sku_weight_data;
use App\mkf_line_alert;
use App\tb_transfer_product;
use App\User;
use App\alert_tranfer_send_line;
use App\alert_user_send_line;



class transfer extends Controller
{
    public function product_transfer_index()
    {
        $user = DB::select('SELECT * from users where id_type is not null', []);
        $type_order = DB::select('SELECT * from tb_order_type');
        $customer = DB::select('SELECT * from tb_customer WHERE type = "สาขา" ');
        $my_shop = DB::select("SELECT * from tb_customer WHERE customer_code = ?",[Auth::user()->branch_name]);
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
                tb_order.id,
                tb_order.order_number,
                tb_order.total_pig,
                tb_order.current_pig,
                tb_order.current_offal,
                tb_order.type_request,
                tb_order.id_user_customer
                FROM
                tb_order
                WHERE
                tb_order.type_request IN (2,3)
                AND tb_order.current_offal <> 0
        "); 
       
        return view('transfer.product_transfer', compact('user', 'type_order', 'customer', 'stock', 'order_ref','my_shop'));
    }

    public function send_line($id)
    {
        

        $tb_transfer_product = tb_transfer_product::where('order_number',$id)->where('status',1)->first();

        

        $tb_transfer_product->notify(new alert_tranfer_send_line($tb_transfer_product));

        return "ส่งข้อมูลสำเร็จ";
 
    }


    public function product_transfer_index_all()
    {
        $user = DB::select('SELECT * from users where id_type is not null', []);
        $type_order = DB::select('SELECT * from tb_order_type');
        $customer = DB::select('SELECT * from tb_customer WHERE type = "สาขา" ');
        $my_shop = DB::select("SELECT * from tb_customer WHERE customer_code = ?",[Auth::user()->branch_name]);
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
                tb_order.id,
                tb_order.order_number,
                tb_order.total_pig,
                tb_order.current_pig,
                tb_order.current_offal,
                tb_order.type_request,
                tb_order.id_user_customer
                FROM
                tb_order
                WHERE
                tb_order.type_request IN (2,3)
                AND tb_order.current_offal <> 0
        ");
        
        $customer_code = '';
        if (Auth::user()->id_type == 6) {
            $customer_code  = DB::select("SELECT * from tb_customer WHERE customer_code = ? ",[Auth::user()->branch_name]);
        }

        return view('transfer.product_transfer_all', compact('user', 'type_order', 'customer', 'stock', 'order_ref','my_shop','customer_code'));
    }

    public function product_transfer_report_all($date)
    {
       

        $order_number = DB::select("SELECT
                action_number.id_ref_order,
                action_number.department,
	            wg_scale.location_scale 
                FROM
        action_number
        LEFT JOIN wg_scale ON action_number.department = wg_scale.department
        INNER JOIN tb_transfer_product ON action_number.id_ref_order = tb_transfer_product.order_number
        WHERE
        tb_transfer_product.STATUS = 2  
                AND DATE_FORMAT( action_number.created_at, '%d%m%Y' ) = '$date'

            GROUP BY action_number.id_ref_order
            ORDER BY action_number.department asc"
        );


      
        
        $row_span = DB::select("SELECT
                *,
                count(wg_sku_weight_data.lot_number) as sum_row
            FROM
                `wg_sku_weight_data` 
            WHERE
                lot_number IN (
                            SELECT
                            action_number.id_ref_order
                            FROM
                            action_number
                            LEFT JOIN wg_scale ON action_number.department = wg_scale.department
                            INNER JOIN tb_transfer_product ON action_number.id_ref_order = tb_transfer_product.order_number
                            WHERE
                            tb_transfer_product.STATUS = 2  AND
                            DATE_FORMAT( action_number.created_at, '%d%m%Y' ) = '$date'
                            GROUP BY action_number.id_ref_order
                )
            AND wg_sku_weight_data.weighing_type IN (4,5) 
                GROUP BY wg_sku_weight_data.lot_number
                ,wg_sku_weight_data.weighing_type
        ");
        
       

        $all_row = 0;
        foreach ($row_span as $key => $row_) {
            $all_row = $all_row + $row_->sum_row;
        }
        
        $data_transform_before = DB::select("SELECT * , wg_sku_item.item_name   
            FROM `wg_sku_weight_data` 
            LEFT JOIN wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code
            WHERE lot_number IN (SELECT
                                action_number.id_ref_order
                                FROM
                                action_number
                                LEFT JOIN wg_scale ON action_number.department = wg_scale.department
                                INNER JOIN tb_transfer_product ON action_number.id_ref_order = tb_transfer_product.order_number
                                WHERE
                                tb_transfer_product.STATUS = 2  AND
                                DATE_FORMAT( action_number.created_at, '%d%m%Y' ) = '$date'
                                GROUP BY action_number.id_ref_order
                            )
            AND wg_sku_weight_data.weighing_type = 5
            ORDER BY lot_number");
      
        $data_transform_after = DB::select("SELECT * , wg_sku_item.item_name   
            FROM `wg_sku_weight_data` 
            LEFT JOIN wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code
            WHERE lot_number IN (SELECT
                                action_number.id_ref_order
                                FROM
                                action_number
                                LEFT JOIN wg_scale ON action_number.department = wg_scale.department
                                INNER JOIN tb_transfer_product ON action_number.id_ref_order = tb_transfer_product.order_number
                                WHERE
                                tb_transfer_product.STATUS = 2  AND
                                DATE_FORMAT( action_number.created_at, '%d%m%Y' ) = '$date'
                                GROUP BY action_number.id_ref_order
                                )
            AND wg_sku_weight_data.weighing_type = 1
            ORDER BY lot_number");
        //   dd( $data_transform_after);
        // return $arr_after_code;
        
        return view('transfer.product_transfer_report_all',compact('date','order_number','row_span',
        'data_transform_before','data_transform_after','all_row'));
    }


    public function product_transfer_table()
    {

        $my_shop = '';
        if (Auth::user()->id_type == 6) {
            $customer_code  = DB::select("SELECT * from tb_customer WHERE customer_code = ? ",[Auth::user()->branch_name]);
            $my_shop = 'AND tb_transfer_product.id_user_sender = '.$customer_code[0]->id.' OR tb_transfer_product.id_user_recieve = '.$customer_code[0]->id ;
        }

        $sql = DB::select("SELECT
            tb_transfer_product.id,
            tb_transfer_product.order_number,
            tb_transfer_product.total_pig,
            tb_transfer_product.weight_range,
            tb_transfer_product.note,
            tb_transfer_product.date,
            tb_transfer_product.id_user_customer_from,
            tb_transfer_product.id_user_customer_to,
            tb_transfer_product.id_user_provider,
            tb_transfer_product.id_user_sender,
            tb_transfer_product.id_user_recieve,
            tb_transfer_product.`status`,
            tb_transfer_product.marker,
            tb_transfer_product.round,
            tb_transfer_product.storage_id,
            customer.fname AS customer,
            provider.fname AS provider,
            sender.fname AS sender,
            recieve.fname AS recieve,
            tb_order_type.order_type,
            wg_storage.name_storage,
            wg_storage.description,
            tb_transfer_product.date_transport
        FROM
            tb_transfer_product
            LEFT JOIN users AS customer ON tb_transfer_product.id_user_customer_from = customer.id
            LEFT JOIN users AS provider ON tb_transfer_product.id_user_provider = provider.id
            LEFT JOIN users AS sender ON tb_transfer_product.id_user_sender = sender.id
            LEFT JOIN users AS recieve ON tb_transfer_product.id_user_recieve = recieve.id
            LEFT JOIN tb_order_type ON tb_transfer_product.type_request = tb_order_type.id
            LEFT JOIN wg_storage ON tb_transfer_product.storage_id = wg_storage.id_storage
        WHERE
            tb_transfer_product.type_request <> 4
            $my_shop
        ORDER BY
            tb_transfer_product.created_at ASC", []);

        return Datatables::of($sql)->make(true);
    }

    public function create_order(Request $request)
    {
        
        $round = ($request->round == '' ? 'A' : $request->round);
        $round = 'A';
        $order_number = DB::select("CALL CREATE_ORDER_PRODUCTION_TANSFER('$request->dateOffal','$request->markerA','$request->markerB','$round')" );
        $order = $order_number[0]->ORDER_NUMBER;

        $marker = $request->markerA . '-' . $request->markerB;


        DB::insert("INSERT INTO tb_transfer_product( order_number, marker, note, id_user_customer_from,id_user_customer_to,
        id_user_provider,date,type_request,created_at,`status`,id_user_sender,id_user_recieve,truck_number)
          values (?,?,?,?,?,?,?,?,?,'1',?,?,?)",
            [$order, $marker, $request->note, $request->customer_from, $request->customer_to,
             $request->provider, $request->dateOffal, $request->type_req, now(), $request->customerA, $request->customerB,$request->vehicle]);

        $date_plan = substr($request->dateOffal, 6, 4) . '-' . substr($request->dateOffal, 3, 2) . '-' . substr($request->dateOffal, 0, 2) . ' 13:00:00';

        //เลข department
        $department_from = DB::SELECT("SELECT
            tb_customer.department
            FROM
            tb_customer
            WHERE
            tb_customer.customer_name = '$request->customer_from'
            LIMIT 1
        ");

        $department_to = DB::SELECT("SELECT
            tb_customer.department
            FROM
            tb_customer
            WHERE
            tb_customer.customer_name = '$request->customer_to'
            LIMIT 1
        ");

        $department_from = $department_from[0]->department;
        $department_to = $department_to[0]->department;
        $marker = $request->markerA . '-' . $request->markerB;

        //temporary amount
        $amount = 0;

        // ย้ายไปบันทึกหลังจากกดยืนยัน
        DB::insert("INSERT INTO action_number(id_ref_order,plan_amount,actual_amount,created_at,department,
                  marker,customer,action_type,process_number,lot_number)
                  value('$order','$amount',0,'$date_plan','$department_from',
                  '$marker','$request->customer','$request->type_req','$request->dateOffal',now())"); //บันทึก 2 รอบ สาขาต้นทาง และ สาขาปลายทาง

        return back();
    }

    public function confirm_order(Request $request){
        
        
            # code...
            
            //ย้ายไปบันทึกหลังจากกดยืนยัน
            $date_plan = substr($request->date, 6, 4) . '-' . substr($request->date, 3, 2) . '-' . substr($request->date, 0, 2) . ' 13:00:00';

            //เลข department
            $department_from = DB::SELECT("SELECT
                tb_customer.department
                FROM
                tb_customer
                WHERE
                tb_customer.customer_name = '$request->customer_from'
                LIMIT 1
            ");

            $department_to = DB::SELECT("SELECT
                tb_customer.department
                FROM
                tb_customer
                WHERE
                tb_customer.customer_name = '$request->customer_to'
                LIMIT 1
            ");

            $department_from = $department_from[0]->department;
            $department_to = $department_to[0]->department;
            $marker = $request->markerA . '-' . $request->markerB;
            //temporary amount
            $amount = 0;
            //dd($request->all());
            DB::update("UPDATE tb_transfer_product set `status` = '$request->status_btn' where order_number = '$request->order_number' ");
        
        if ($request->status_btn == 2 ) {
            DB::insert("INSERT INTO action_number(id_ref_order,plan_amount,actual_amount,created_at,department,
                    marker,customer,action_type,process_number,lot_number)
                    value('$request->order_number','$amount',0,'$date_plan','$department_to',
                    '$request->marker','$request->customer_to','$request->type_req','$request->date',now())"); //บันทึก 2 รอบ สาขาต้นทาง และ สาขาปลายทาง
            return Redirect::to('order/product_transfer')->with('message_success', 'ยืนยันใบโอนสินค้า เรียบร้อยแล้ว');
        }else{
            return Redirect::to('order/product_transfer')->with('message_success', 'ไม่อนุมัติการโอน');
        }
       
    }

    public function order_edit($id)
    {

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
                tb_order.id,
                tb_order.order_number,
                tb_order.total_pig,
                tb_order.current_pig,
                tb_order.current_offal,
                tb_order.type_request,
                tb_order.id_user_customer
                FROM
                tb_order
                WHERE
                tb_order.type_request IN (2,3)
                AND tb_order.current_offal <> 0
        ");
        $data = DB::select("SELECT
            tb_transfer_product.id,
            tb_transfer_product.type_request AS req_type,
            tb_transfer_product.order_number,
            tb_transfer_product.total_pig,
            tb_transfer_product.weight_range,
            tb_transfer_product.note,
            tb_transfer_product.date,
            tb_transfer_product.id_user_customer_from,
            tb_transfer_product.id_user_customer_to,
            tb_transfer_product.id_user_provider,
            tb_transfer_product.id_user_sender,
            tb_transfer_product.id_user_recieve,
            tb_transfer_product.`status`,
            tb_transfer_product.marker,
            tb_transfer_product.round,
            tb_transfer_product.storage_id,
            tb_transfer_product.order_ref,
            customer.fname AS customer,
            provider.fname AS provider,
            sender.fname AS sender,
            recieve.fname AS recieve,
            tb_order_type.order_type,
            wg_storage.name_storage,
            wg_storage.description,
            tb_transfer_product.date_transport
        FROM
            tb_transfer_product
            LEFT JOIN users AS customer ON tb_transfer_product.id_user_customer_from = customer.id
            LEFT JOIN users AS provider ON tb_transfer_product.id_user_provider = provider.id
            LEFT JOIN users AS sender ON tb_transfer_product.id_user_sender = sender.id
            LEFT JOIN users AS recieve ON tb_transfer_product.id_user_recieve = recieve.id
            LEFT JOIN tb_order_type ON tb_transfer_product.type_request = tb_order_type.id
            LEFT JOIN wg_storage ON tb_transfer_product.storage_id = wg_storage.id_storage
        WHERE
          tb_transfer_product.id = $id
        ORDER BY
            tb_transfer_product.created_at ASC", []);

        //return back();
        return view('order.edit_product_transfer', compact('user', 'type_order', 'customer', 'stock', 'order_ref','data'));
    }

    public function order_on_delete($id)
    {

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
                tb_order.id,
                tb_order.order_number,
                tb_order.total_pig,
                tb_order.current_pig,
                tb_order.current_offal,
                tb_order.type_request,
                tb_order.id_user_customer
                FROM
                tb_order
                WHERE
                tb_order.type_request IN (2,3)
                AND tb_order.current_offal <> 0
        ");
        $data = DB::select("SELECT
            tb_transfer_product.id,
            tb_transfer_product.type_request AS req_type,
            tb_transfer_product.order_number,
            tb_transfer_product.total_pig,
            tb_transfer_product.weight_range,
            tb_transfer_product.note,
            tb_transfer_product.date,
            tb_transfer_product.id_user_customer_from,
            tb_transfer_product.id_user_customer_to,
            tb_transfer_product.id_user_provider,
            tb_transfer_product.id_user_sender,
            tb_transfer_product.id_user_recieve,
            tb_transfer_product.`status`,
            tb_transfer_product.marker,
            tb_transfer_product.round,
            tb_transfer_product.storage_id,
            tb_transfer_product.order_ref,
            customer.fname AS customer,
            provider.fname AS provider,
            sender.fname AS sender,
            recieve.fname AS recieve,
            tb_order_type.order_type,
            wg_storage.name_storage,
            wg_storage.description,
            tb_transfer_product.date_transport
        FROM
            tb_transfer_product
            LEFT JOIN users AS customer ON tb_transfer_product.id_user_customer_from = customer.id
            LEFT JOIN users AS provider ON tb_transfer_product.id_user_provider = provider.id
            LEFT JOIN users AS sender ON tb_transfer_product.id_user_sender = sender.id
            LEFT JOIN users AS recieve ON tb_transfer_product.id_user_recieve = recieve.id
            LEFT JOIN tb_order_type ON tb_transfer_product.type_request = tb_order_type.id
            LEFT JOIN wg_storage ON tb_transfer_product.storage_id = wg_storage.id_storage
        WHERE
          tb_transfer_product.id = $id
        ORDER BY
            tb_transfer_product.created_at ASC", []);

        //return back();
        return view('order.delete_product_transfer', compact('user', 'type_order', 'customer', 'stock', 'order_ref','data'));
    }

    public function order_update(Request $request)
    {

      $round = ($request->round == '' ? '' : $request->round);
      $order_number = DB::select("CALL CREATE_ORDER_PRODUCTION_TANSFER('$request->dateOffal','$request->markerA','$request->markerB','$request->type_normal')");
      $order = $order_number[0]->ORDER_NUMBER;
      //dd($request->all());

      DB::TABLE('tb_transfer_product')
          ->WHERE('id', $request['id'])
          ->UPDATE([
                'order_number' => $order,
                'type_request' => $request['type_request'],
                'id_user_customer_from' => $request['customer_from'],
                'id_user_customer_to' => $request['customer_to'],
                'date' => $request['dateOffal'],
                'id_user_provider' => $request['id_user_provider'],
                'note' => $request['note'],
                'order_ref' => $request['order_ref']
            ]);

        return back();
        //return view('order.product_transfer')->with('message_success', 'แก้ไข 1 ใบโอนสินค้า เรียบร้อยแล้ว');
    }

    public function order_delete(Request $request)
    {

        $weighing = wg_sku_weight_data::where('lot_number', '=', $request->order_number)->limit(1)->get();

        if (!empty($weighing[0]->lot_number)) {
            return 'Order ได้เริ่มการผลิตแล้ว ไม่สามารถลบได้';
        } else {

        DB::delete("DELETE FROM tb_transfer_product WHERE order_number = '$request->order_number' ", []);
        DB::delete("DELETE FROM action_number WHERE id_ref_order = '$request->order_number' ", []);
        DB::delete("DELETE FROM pd_lot WHERE id_ref_order = '$request->order_number' ", []);

            return 'ลบ '.$request->order_number;
        }
    }
    // report 
    public function report_transfer_all($date)
    {
        $order_pt = DB::select("SELECT
            tb_transfer_product.id,
            tb_transfer_product.date,
            tb_transfer_product.order_number,
            tb_transfer_product.id_user_customer_from,
            tb_transfer_product.id_user_customer_to,
            tb_transfer_product.id_user_sender,
            tb_transfer_product.id_user_recieve,
            tb_transfer_product.type_request,
            tb_transfer_product.marker,
            tb_transfer_product.status,
            tb_customer.customer_code,
            tb_customer2.customer_code AS cus_desc ,
            tb_transfer_product.note,
            tb_transfer_product.created_at
        FROM
            tb_transfer_product
            LEFT JOIN tb_customer ON tb_transfer_product.id_user_customer_from = tb_customer.customer_name
            LEFT JOIN tb_customer AS tb_customer2 ON tb_transfer_product.id_user_customer_to = tb_customer2.customer_name 
        WHERE
        tb_transfer_product.order_number IN (
                            SELECT
                            action_number.id_ref_order
                            FROM
                            action_number
                            LEFT JOIN wg_scale ON action_number.department = wg_scale.department
                            INNER JOIN tb_transfer_product ON action_number.id_ref_order = tb_transfer_product.order_number
                            WHERE
                            tb_transfer_product.STATUS = 2  AND
                            DATE_FORMAT( action_number.created_at, '%d%m%Y' ) = '$date'
                            GROUP BY action_number.id_ref_order
                )
            ORDER BY tb_transfer_product.created_at
        ");
        // dd($order_pt);
        $scale_source = '';
        $scale_desc = '';
        foreach ($order_pt as $key => $value) {
            $scale_source = $value->customer_code;
            $scale_desc = $value->cus_desc;
        }

        $data_main = DB::select("SELECT
            wg_sku_weight_data.lot_number,
            wg_sku_weight_data.sku_weight,
            wg_sku_weight_data.sku_amount,
            wg_sku_weight_data.weighing_ref,
            wg_sku_weight_data.weighing_date,
            wg_sku_weight_data.note,
            wg_sku_weight_data.user_name,
            wg_sku_item.item_name,
            wg_sku_item.price,
            wg_sku_weight_data.id,
            wg_sku_item.item_code,
            wg_sku_weight_data.scale_number
            
            FROM
            wg_sku_weight_data
            LEFT JOIN wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code 
            WHERE
            wg_sku_weight_data.lot_number IN (
                            SELECT
                            action_number.id_ref_order
                            FROM
                            action_number
                            LEFT JOIN wg_scale ON action_number.department = wg_scale.department
                            INNER JOIN tb_transfer_product ON action_number.id_ref_order = tb_transfer_product.order_number
                            WHERE
                            tb_transfer_product.STATUS = 2  AND
                            DATE_FORMAT( action_number.created_at, '%d%m%Y' ) = '$date'
                            GROUP BY action_number.id_ref_order
                )
            
                GROUP BY wg_sku_weight_data.lot_number,wg_sku_item.item_code
            ORDER BY  wg_sku_weight_data.lot_number , wg_sku_weight_data.scale_number, wg_sku_item.item_code 
        ");
        //   dd($data_main);
        $data_before = DB::select("SELECT
            wg_sku_weight_data.lot_number,
            wg_sku_weight_data.sku_weight,
            wg_sku_weight_data.sku_amount,
            wg_sku_weight_data.weighing_ref,
            wg_sku_weight_data.weighing_date,
            wg_sku_weight_data.note,
            wg_sku_weight_data.user_name,
            wg_sku_item.item_name,
            wg_sku_item.price,
            wg_sku_weight_data.id,
            wg_sku_item.item_code,
            wg_sku_weight_data.scale_number

            FROM
            wg_sku_weight_data
            LEFT JOIN wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code 
            WHERE
            wg_sku_weight_data.lot_number IN (
                            SELECT
                            action_number.id_ref_order
                            FROM
                            action_number
                            LEFT JOIN wg_scale ON action_number.department = wg_scale.department
                            INNER JOIN tb_transfer_product ON action_number.id_ref_order = tb_transfer_product.order_number
                            WHERE
                            tb_transfer_product.STATUS = 2  AND
                            DATE_FORMAT( action_number.created_at, '%d%m%Y' ) = '$date'
                            GROUP BY action_number.id_ref_order
                )
            -- AND wg_sku_weight_data.scale_number = '$scale_source'
            -- GROUP BY wg_sku_item.item_code
            ORDER BY wg_sku_weight_data.lot_number , wg_sku_weight_data.scale_number, wg_sku_item.item_code 
        ");

        //  dd($data_before);
        $data_after = DB::select("SELECT
            wg_sku_weight_data.lot_number,
            wg_sku_weight_data.sku_weight,
            wg_sku_weight_data.sku_amount,
            wg_sku_weight_data.weighing_ref,
            wg_sku_weight_data.weighing_date,
            wg_sku_weight_data.note,
            wg_sku_weight_data.user_name,
            wg_sku_item.item_name,
            wg_sku_item.price,
            wg_sku_weight_data.id,
            wg_sku_item.item_code,
            wg_sku_weight_data.scale_number
            FROM
            wg_sku_weight_data
            LEFT JOIN wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code 
            WHERE
            wg_sku_weight_data.lot_number IN (
                            SELECT
                            action_number.id_ref_order
                            FROM
                            action_number
                            LEFT JOIN wg_scale ON action_number.department = wg_scale.department
                            INNER JOIN tb_transfer_product ON action_number.id_ref_order = tb_transfer_product.order_number
                            WHERE
                            tb_transfer_product.STATUS = 2  AND
                            DATE_FORMAT( action_number.created_at, '%d%m%Y' ) = '$date'
                            GROUP BY action_number.id_ref_order
                )
            -- AND wg_sku_weight_data.scale_number IN ('$scale_desc' )
            -- GROUP BY wg_sku_item.item_code
            ORDER BY  wg_sku_weight_data.lot_number , wg_sku_weight_data.scale_number, wg_sku_item.item_code 
        ");
        //  dd($data_after);
        $customer_code = '';
        if (Auth::user()->id_type == 6) {
            $customer_code  = DB::select("SELECT * from tb_customer WHERE customer_code = ? ",[Auth::user()->branch_name]);
        }


        return view('report.checkProductTransfer_All', compact('data_before','data_after','order_pt','data_main','customer_code'));
    }
    // report _print
        // report 
        public function report_transfer_all_print($date)
        {
            $order_pt = DB::select("SELECT
            tb_transfer_product.id,
            tb_transfer_product.date,
            tb_transfer_product.order_number,
            tb_transfer_product.id_user_customer_from,
            tb_transfer_product.id_user_customer_to,
            tb_transfer_product.id_user_sender,
            tb_transfer_product.id_user_recieve,
            tb_transfer_product.type_request,
            tb_transfer_product.marker,
            tb_transfer_product.status,
            tb_customer.customer_code,
            tb_customer2.customer_code AS cus_desc ,
            tb_transfer_product.note,
            tb_transfer_product.created_at
        FROM
            tb_transfer_product
            LEFT JOIN tb_customer ON tb_transfer_product.id_user_customer_from = tb_customer.customer_name
            LEFT JOIN tb_customer AS tb_customer2 ON tb_transfer_product.id_user_customer_to = tb_customer2.customer_name 
        WHERE
        tb_transfer_product.order_number IN (
                            SELECT
                            action_number.id_ref_order
                            FROM
                            action_number
                            LEFT JOIN wg_scale ON action_number.department = wg_scale.department
                            INNER JOIN tb_transfer_product ON action_number.id_ref_order = tb_transfer_product.order_number
                            WHERE
                            tb_transfer_product.STATUS = 2  AND
                            DATE_FORMAT( action_number.created_at, '%d%m%Y' ) = '$date'
                            GROUP BY action_number.id_ref_order
                )
            ORDER BY tb_transfer_product.created_at
        ");
        // dd($order_pt);
        $scale_source = '';
        $scale_desc = '';
        foreach ($order_pt as $key => $value) {
            $scale_source = $value->customer_code;
            $scale_desc = $value->cus_desc;
        }

        $data_main = DB::select("SELECT
            wg_sku_weight_data.lot_number,
            wg_sku_weight_data.sku_weight,
            wg_sku_weight_data.sku_amount,
            wg_sku_weight_data.weighing_ref,
            wg_sku_weight_data.weighing_date,
            wg_sku_weight_data.note,
            wg_sku_weight_data.user_name,
            wg_sku_item.item_name,
            wg_sku_item.price,
            wg_sku_weight_data.id,
            wg_sku_item.item_code,
            wg_sku_weight_data.scale_number
            
            FROM
            wg_sku_weight_data
            LEFT JOIN wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code 
            WHERE
            wg_sku_weight_data.lot_number IN (
                            SELECT
                            action_number.id_ref_order
                            FROM
                            action_number
                            LEFT JOIN wg_scale ON action_number.department = wg_scale.department
                            INNER JOIN tb_transfer_product ON action_number.id_ref_order = tb_transfer_product.order_number
                            WHERE
                            tb_transfer_product.STATUS = 2  AND
                            DATE_FORMAT( action_number.created_at, '%d%m%Y' ) = '$date'
                            GROUP BY action_number.id_ref_order
                )
            
                GROUP BY wg_sku_weight_data.lot_number,wg_sku_item.item_code
            ORDER BY  wg_sku_weight_data.lot_number , wg_sku_weight_data.scale_number, wg_sku_item.item_code 
        ");
        //   dd($data_main);
        $data_before = DB::select("SELECT
            wg_sku_weight_data.lot_number,
            wg_sku_weight_data.sku_weight,
            wg_sku_weight_data.sku_amount,
            wg_sku_weight_data.weighing_ref,
            wg_sku_weight_data.weighing_date,
            wg_sku_weight_data.note,
            wg_sku_weight_data.user_name,
            wg_sku_item.item_name,
            wg_sku_item.price,
            wg_sku_weight_data.id,
            wg_sku_item.item_code,
            wg_sku_weight_data.scale_number

            FROM
            wg_sku_weight_data
            LEFT JOIN wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code 
            WHERE
            wg_sku_weight_data.lot_number IN (
                            SELECT
                            action_number.id_ref_order
                            FROM
                            action_number
                            LEFT JOIN wg_scale ON action_number.department = wg_scale.department
                            INNER JOIN tb_transfer_product ON action_number.id_ref_order = tb_transfer_product.order_number
                            WHERE
                            tb_transfer_product.STATUS = 2  AND
                            DATE_FORMAT( action_number.created_at, '%d%m%Y' ) = '$date'
                            GROUP BY action_number.id_ref_order
                )
            -- AND wg_sku_weight_data.scale_number = '$scale_source'
            -- GROUP BY wg_sku_item.item_code
            ORDER BY wg_sku_weight_data.lot_number , wg_sku_weight_data.scale_number, wg_sku_item.item_code 
        ");

        // dd($data_before);
        $data_after = DB::select("SELECT
            wg_sku_weight_data.lot_number,
            wg_sku_weight_data.sku_weight,
            wg_sku_weight_data.sku_amount,
            wg_sku_weight_data.weighing_ref,
            wg_sku_weight_data.weighing_date,
            wg_sku_weight_data.note,
            wg_sku_weight_data.user_name,
            wg_sku_item.item_name,
            wg_sku_item.price,
            wg_sku_weight_data.id,
            wg_sku_item.item_code,
            wg_sku_weight_data.scale_number
            FROM
            wg_sku_weight_data
            LEFT JOIN wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code 
            WHERE
            wg_sku_weight_data.lot_number IN (
                            SELECT
                            action_number.id_ref_order
                            FROM
                            action_number
                            LEFT JOIN wg_scale ON action_number.department = wg_scale.department
                            INNER JOIN tb_transfer_product ON action_number.id_ref_order = tb_transfer_product.order_number
                            WHERE
                            tb_transfer_product.STATUS = 2  AND
                            DATE_FORMAT( action_number.created_at, '%d%m%Y' ) = '$date'
                            GROUP BY action_number.id_ref_order
                )
            -- AND wg_sku_weight_data.scale_number IN ('$scale_desc' )
            -- GROUP BY wg_sku_item.item_code
            ORDER BY  wg_sku_weight_data.lot_number , wg_sku_weight_data.scale_number, wg_sku_item.item_code 
        ");
        //  dd($data_after);
        $customer_code = '';
        if (Auth::user()->id_type == 6) {
            $customer_code  = DB::select("SELECT * from tb_customer WHERE customer_code = ? ",[Auth::user()->branch_name]);
        }
            return view('transfer.checkProductTransfer_All_print', compact('data_before','data_after','order_pt','data_main','customer_code'));
        }
    
    // check
    public function report_transfer($order)
    {
        $order_pt = DB::select("SELECT
            tb_transfer_product.id,
            tb_transfer_product.date,
            tb_transfer_product.order_number,
            tb_transfer_product.id_user_customer_from,
            tb_transfer_product.id_user_customer_to,
            tb_transfer_product.id_user_sender,
            tb_transfer_product.id_user_recieve,
            tb_transfer_product.type_request,
            tb_transfer_product.marker,
            tb_transfer_product.status,
            tb_customer.customer_code,
            tb_customer2.customer_code AS cus_desc ,
            tb_transfer_product.note
        FROM
            tb_transfer_product
            LEFT JOIN tb_customer ON tb_transfer_product.id_user_customer_from = tb_customer.customer_name
            LEFT JOIN tb_customer AS tb_customer2 ON tb_transfer_product.id_user_customer_to = tb_customer2.customer_name 
        WHERE
            tb_transfer_product.order_number = '$order'
        ");
        $scale_source = '';
        $scale_desc = '';
        foreach ($order_pt as $key => $value) {
            $scale_source = $value->customer_code;
            $scale_desc = $value->cus_desc;
        }

        $data_main = DB::select("SELECT
            wg_sku_weight_data.lot_number,
            sum(wg_sku_weight_data.sku_weight) as sku_weight ,
            wg_sku_weight_data.weighing_ref,
            wg_sku_weight_data.weighing_date,
            wg_sku_weight_data.note,
            wg_sku_weight_data.user_name,
            wg_sku_item.item_name,
            wg_sku_item.price,
            wg_sku_weight_data.id,
            wg_sku_item.item_code,
            count(wg_sku_weight_data.sku_amount)  as sku_amount
            FROM
            wg_sku_weight_data
            LEFT JOIN wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code 
            WHERE
            wg_sku_weight_data.lot_number = '$order'
            GROUP BY wg_sku_item.item_code
        ");

        $data_before = DB::select("SELECT
            wg_sku_weight_data.lot_number,
            sum(wg_sku_weight_data.sku_weight) as sku_weight ,
            wg_sku_weight_data.weighing_ref,
            wg_sku_weight_data.weighing_date,
            wg_sku_weight_data.note,
            wg_sku_weight_data.user_name,
            wg_sku_item.item_name,
            wg_sku_item.price,
            wg_sku_weight_data.id,
            wg_sku_item.item_code,
            sum(wg_sku_weight_data.sku_amount)  as sku_amount
            FROM
            wg_sku_weight_data
            LEFT JOIN wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code 
            WHERE
            wg_sku_weight_data.lot_number = '$order'
            AND wg_sku_weight_data.scale_number = '$scale_source'
            AND wg_sku_item.sku_category = 'ร้านค้า'
            GROUP BY wg_sku_item.item_code
        ");
  
        $data_after = DB::select("SELECT
            wg_sku_weight_data.lot_number,
            sum(wg_sku_weight_data.sku_weight) as sku_weight ,
            wg_sku_weight_data.weighing_ref,
            wg_sku_weight_data.weighing_date,
            wg_sku_weight_data.note,
            wg_sku_weight_data.user_name,
            wg_sku_item.item_name,
            wg_sku_item.price,
            wg_sku_weight_data.id,
            wg_sku_item.item_code,
            sum(wg_sku_weight_data.sku_amount)  as sku_amount
            FROM
            wg_sku_weight_data
            LEFT JOIN wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code 
            WHERE
            wg_sku_weight_data.lot_number = '$order'
            AND wg_sku_weight_data.scale_number = '$scale_desc'
            AND wg_sku_item.sku_category = 'ร้านค้า'
            GROUP BY wg_sku_item.item_code
        ");
        $customer_code = '';
        if (Auth::user()->id_type == 6) {
            $customer_code  = DB::select("SELECT * from tb_customer WHERE customer_code = ? ",[Auth::user()->branch_name]);
        }

        return view('report.checkProductTransfer', compact('data_before','data_after','order','order_pt','data_main','customer_code'));
    }

    public function report_transfer_print($order)
    {
        $order_pt = DB::select("SELECT
            tb_transfer_product.id,
            tb_transfer_product.date,
            tb_transfer_product.order_number,
            tb_transfer_product.id_user_customer_from,
            tb_transfer_product.id_user_customer_to,
            tb_transfer_product.type_request,
            tb_transfer_product.marker,
            tb_transfer_product.status,
            tb_customer.customer_code,
            tb_customer2.customer_code AS cus_desc 
        FROM
            tb_transfer_product
            LEFT JOIN tb_customer ON tb_transfer_product.id_user_customer_from = tb_customer.customer_name
            LEFT JOIN tb_customer AS tb_customer2 ON tb_transfer_product.id_user_customer_to = tb_customer2.customer_name 
        WHERE
            tb_transfer_product.order_number = '$order'
        ");
        $scale_source = '';
        $scale_desc = '';
        foreach ($order_pt as $key => $value) {
            $scale_source = $value->customer_code;
            $scale_desc = $value->cus_desc;
        }

        $data_main = DB::select("SELECT
            wg_sku_weight_data.lot_number,
            sum(wg_sku_weight_data.sku_weight) as sku_weight ,
            wg_sku_weight_data.weighing_ref,
            wg_sku_weight_data.weighing_date,
            wg_sku_weight_data.note,
            wg_sku_weight_data.user_name,
            wg_sku_item.item_name,
            wg_sku_item.price,
            wg_sku_weight_data.id,
            wg_sku_item.item_code,
            count(wg_sku_weight_data.sku_amount)  as sku_amount
            FROM
            wg_sku_weight_data
            LEFT JOIN wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code 
            WHERE
            wg_sku_weight_data.lot_number = '$order'
            GROUP BY wg_sku_item.item_code
        ");
        $data_before = DB::select("SELECT
            wg_sku_weight_data.lot_number,
            sum(wg_sku_weight_data.sku_weight) as sku_weight ,
            wg_sku_weight_data.weighing_ref,
            wg_sku_weight_data.weighing_date,
            wg_sku_weight_data.note,
            wg_sku_weight_data.user_name,
            wg_sku_item.item_name,
            wg_sku_item.price,
            wg_sku_weight_data.id,
            wg_sku_item.item_code,
            count(wg_sku_weight_data.sku_amount)  as sku_amount
            FROM
            wg_sku_weight_data
            LEFT JOIN wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code 
            WHERE
            wg_sku_weight_data.lot_number = '$order'
            AND wg_sku_weight_data.scale_number = '$scale_source'
            GROUP BY wg_sku_item.item_code
        ");

        
        $data_after = DB::select("SELECT
            wg_sku_weight_data.lot_number,
            sum(wg_sku_weight_data.sku_weight) as sku_weight ,
            wg_sku_weight_data.weighing_ref,
            wg_sku_weight_data.weighing_date,
            wg_sku_weight_data.note,
            wg_sku_weight_data.user_name,
            wg_sku_item.item_name,
            wg_sku_item.price,
            wg_sku_weight_data.id,
            wg_sku_item.item_code,
            count(wg_sku_weight_data.sku_amount)  as sku_amount
            FROM
            wg_sku_weight_data
            LEFT JOIN wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code 
            WHERE
            wg_sku_weight_data.lot_number = '$order'
            AND wg_sku_weight_data.scale_number = '$scale_desc'
            GROUP BY wg_sku_item.item_code
        ");

        return view('transfer.checkProductTransfer_print', compact('data_before','data_after','order','order_pt','data_main'));
    }
    
}
