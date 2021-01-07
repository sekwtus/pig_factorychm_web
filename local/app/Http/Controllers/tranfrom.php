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
use App\alert_tranfrom_send_line;
use App\tb_tranfrom;
use App\wg_sku_weight_data;
class tranfrom extends Controller
{

    public function send_line($id)
    {
        // return $id;

        $tb_tranfrom = tb_tranfrom::where('order_number',$id)->where('status',1)->first();

        // return $tb_tranfrom;

        $tb_tranfrom->notify(new alert_tranfrom_send_line($tb_tranfrom));

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
       
        return view('transfer.tranfrom', compact('user', 'type_order', 'customer', 'stock', 'order_ref','my_shop'));
    }

    public function create_order(Request $request)
    {
        //return $request;
        $order_mnuber = DB::SELECT("CALL NEW_TRANSFER_web('$request->dateOffal','$request->markerA','$request->round')");
        // return $order_mnuber;
        $order = $order_mnuber[0]->ORDER_NUMBER;
        $department = DB::SELECT("SELECT
                                    wg_scale.department,
                                    tb_customer.marker
                                    FROM
                                    wg_scale
                                    INNER JOIN tb_customer ON tb_customer.customer_code = wg_scale.scale_number
                                    WHERE tb_customer.marker = ?",[$request->markerA]);
        // return $department;
        DB::insert("INSERT INTO tb_tranfrom( order_number, note, id_user_customer_from,
                                            id_user_provider,date,type_request,created_at,`status`,id_user_sender,customer_id)
          values (?,?,?,?,?,?,?,'1',?,?)",
            [$order, $request->note, $request->customer_from,
             $request->provider, $request->dateOffal, $request->type_req, now(), $request->customerA, $request->customerA]);

        DB::insert("INSERT INTO action_number(id_ref_order,
                                              lot_number,
                                              plan_amount,
                                              actual_amount,
                                              department,
                                              marker,
                                              action_type,
                                              process_number,
                                              action_status)
                                               value(
                                                   ?,
                                                   now(),
                                                   ?,
                                                   ?,
                                                   ?,
                                                   ?,
                                                   ?,
                                                   date_format(now(),'%Y/%m/%d'),
                                                   ?
                                                   )"
                                                , [
                                                    $order, 
                                                    '0', 
                                                    '0',
                                                    $department[0]->department,
                                                    $request->markerA,
                                                    3,
                                                    '1'
                                                    ]);

        return back();
    }

    public function product_transfer_table()
    {

        $my_shop = '';
        if (Auth::user()->id_type == 6) {
            $customer_code  = DB::select("SELECT * from tb_customer WHERE customer_code = ? ",[Auth::user()->branch_name]);
            $my_shop = 'AND tb_tranfrom.id_user_sender = '.$customer_code[0]->id.' OR tb_tranfrom.id_user_recieve = '.$customer_code[0]->id ;
        }

        $sql = DB::select("SELECT
            tb_tranfrom.id,
            tb_tranfrom.order_number,
            tb_tranfrom.total_pig,
            tb_tranfrom.weight_range,
            tb_tranfrom.note,
            tb_tranfrom.date,
            tb_tranfrom.id_user_customer_from,
            tb_tranfrom.id_user_customer_to,
            tb_tranfrom.id_user_provider,
            tb_tranfrom.id_user_sender,
            tb_tranfrom.id_user_recieve,
            tb_tranfrom.`status`,
            tb_tranfrom.marker,
            tb_tranfrom.round,
            tb_tranfrom.storage_id,
            customer.fname AS customer,
            tb_customer.customer_code,
            provider.fname AS provider,
            sender.fname AS sender,
            recieve.fname AS recieve,
            tb_order_type.order_type,
            wg_storage.name_storage,
            wg_storage.description,
            tb_tranfrom.date_transport
        FROM
        tb_tranfrom
            LEFT JOIN users AS customer ON tb_tranfrom.id_user_customer_from = customer.id
            LEFT JOIN users AS provider ON tb_tranfrom.id_user_provider = provider.id
            LEFT JOIN users AS sender ON tb_tranfrom.id_user_sender = sender.id
            LEFT JOIN users AS recieve ON tb_tranfrom.id_user_recieve = recieve.id
            LEFT JOIN tb_order_type ON tb_tranfrom.type_request = tb_order_type.id
            LEFT JOIN wg_storage ON tb_tranfrom.storage_id = wg_storage.id_storage
            LEFT JOIN tb_customer ON tb_tranfrom.customer_id = tb_customer.id
        WHERE
        tb_tranfrom.type_request <> 4
            $my_shop
        ORDER BY
        tb_tranfrom.created_at ASC", []);

        return Datatables::of($sql)->make(true);
    }

    public function approve_tranfrom($id){

        DB::update("UPDATE tb_tranfrom set `status` = '2' where order_number = '$id' ");
        DB::update("UPDATE action_number set `action_status` = '0' where id_ref_order = '$id' ");

        return 'อนุมัติสำเร็จ';
    }

    public function no_approve_tranfrom($id){

        DB::update("UPDATE tb_tranfrom set `status` = '3' where order_number = '$id' ");
        DB::update("UPDATE action_number set `action_status` = '1' where id_ref_order = '$id' ");

        return 'ไม่อนุมัติสำเร็จ';
    }

    public function order_delete(Request $request)
    {

        $weighing = wg_sku_weight_data::where('lot_number', '=', $request->order_number)->limit(1)->get();

        if (!empty($weighing[0]->lot_number)) {
            return 'Order ได้เริ่มการผลิตแล้ว ไม่สามารถลบได้';
        } else {

        DB::delete("DELETE FROM tb_tranfrom WHERE order_number = '$request->order_number' ", []);
        DB::delete("DELETE FROM action_number WHERE id_ref_order = '$request->order_number' ", []);
        // DB::delete("DELETE FROM pd_lot WHERE id_ref_order = '$request->order_number' ", []);

            return 'ลบ '.$request->order_number;
        }
    }

  
}
