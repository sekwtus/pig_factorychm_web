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
use App\User;
use App\tb_transfer_to_factory;
use App\alert_tranfer_to_fac_send_line;

class transfer_to_fac extends Controller
{

    public function send_line($id)
    {
        

        $tb_transfer_to_factory = tb_transfer_to_factory::where('order_number',$id)->where('status',1)->first();
        // return $tb_transfer_to_factory;
        

        $tb_transfer_to_factory->notify(new alert_tranfer_to_fac_send_line($tb_transfer_to_factory));

        return "ส่งข้อมูลสำเร็จ";
 
    }

    public function transfer_index()
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
       
        return view('transfer.transfer_to_fac', compact('user', 'type_order', 'customer', 'stock', 'order_ref','my_shop'));
    }

    public function create_order(Request $request)
    {
        // return $request;
        $round = ($request->round == '' ? 'A' : $request->round);
        $round = 'A';
        $order_number = DB::select("CALL CREATE_ORDER_TANSFER_TO_FAC('$request->dateOffal','$request->markerA','$request->round')" );
        
        $order = $order_number[0]->ORDER_NUMBER;

        $marker = $request->markerA . '-' . $request->markerB;


        DB::insert("INSERT INTO tb_transfer_to_factory( order_number, marker, note, id_user_customer_from,id_user_customer_to,
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
        return $order_number;
        // ย้ายไปบันทึกหลังจากกดยืนยัน
        // DB::insert("INSERT INTO action_number(id_ref_order,plan_amount,actual_amount,created_at,department,
        //           marker,customer,action_type,process_number,lot_number)
        //           value('$order','$amount',0,'$date_plan','$department_from',
        //           '$marker','$request->customer','$request->type_req','$request->dateOffal',now())"); //บันทึก 2 รอบ สาขาต้นทาง และ สาขาปลายทาง

        // return back();
    }

    public function product_transfer_table()
    {

        
        $my_shop = '';
        if (Auth::user()->id_type == 6) {
            $customer_code  = DB::select("SELECT * from tb_customer WHERE customer_code = ? ",[Auth::user()->branch_name]);
            $my_shop = 'AND tb_transfer_product.id_user_sender = '.$customer_code[0]->id.' OR tb_transfer_product.id_user_recieve = '.$customer_code[0]->id ;
        }
        
        // if (Auth::user()->id_type == 1)
        // {
        //     $customer_code
        //     $my_shop;
        // }
        // return Auth::user()->id_type;

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
            tb_transfer_to_factory
            LEFT JOIN users AS customer ON tb_transfer_product.id_user_customer_from = customer.id
            LEFT JOIN users AS provider ON tb_transfer_product.id_user_provider = provider.id
            LEFT JOIN users AS sender ON tb_transfer_product.id_user_sender = sender.id
            LEFT JOIN users AS recieve ON tb_transfer_product.id_user_recieve = recieve.id
            LEFT JOIN tb_order_type ON tb_transfer_product.type_request = tb_order_type.id
            LEFT JOIN wg_storage ON tb_transfer_product.storage_id = wg_storage.id_storage
        WHERE
            tb_transfer_to_factory.type_request <> 4
            $my_shop
        ORDER BY
            tb_transfer_to_factory.created_at ASC", []);

        return Datatables::of($sql)->make(true);
    }

  
}
