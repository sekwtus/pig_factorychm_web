<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;
use Auth;
use Redirect;

class recieve extends Controller
{
    public static function index(){
        return view('recieve.truck_scale');
    }

    public static function data_recieve(){
        $data_recieve = DB::select("SELECT
                                    tb_order.*,
                                    wg_storage.name_storage,
                                    tb_customer.customer_name,
                                    tb_customer.customer_nickname,
                                    tb_customer.shop_name,
                                    wg_storage.description
                                    FROM
                                    tb_order
                                    LEFT JOIN tb_customer ON tb_order.customer_id = tb_customer.id
                                    LEFT JOIN wg_storage ON tb_order.storage_id = wg_storage.id_storage
                                    WHERE tb_order.type_request = 4
                                    ORDER BY tb_order.id DESC", []);
        return Datatables::of($data_recieve)->addIndexColumn()->make(true);
    }

    public static function indexPig(){
        return view('recieve.pig_scale');
    }

    public function add_order(Request $request){
        DB::insert("INSERT into wg_stock(order_number,customer_id,`date`,`round`,total_pig,note,created_at,storage_id,check_order,type_request,id_user_customer) 
        values (?,?,?,?,?,?,?,?,?,?,?)"
        , [$recieve,$request->customer,$request->recieve_time,$request->orderTerm,$request->pig_number,$request->note,now(),$request->storage,0,4,$request->customer_name]);
        return 'สำเร็จ';
    }

    // การแสดงน้ำหนัก
    public static function weighing(){
        $wg_scale = DB::select("SELECT * from wg_scale WHERE wg_scale.location_type = 'ร้านค้า' ");
        $wg_scale_shop = DB::select("SELECT * from wg_scale WHERE wg_scale.location_type = 'ร้านค้า' ");
        $wg_weight_type = DB::select("SELECT * from wg_weight_type");
        $wg_sku = DB::select("SELECT * from wg_sku");
        $wg_storage = DB::select("SELECT * from wg_storage");
        $scale = DB::select("SELECT * FROM `wg_scale` WHERE wg_scale.location_type = 'ร้านค้า'");

        return view('recieve.weighing_shop',compact('wg_scale','wg_weight_type','wg_scale_shop','wg_sku','wg_storage','scale'));
    }

    public static function weighing_factory(){
        $wg_scale = DB::select("SELECT * from wg_scale WHERE wg_scale.location_type = 'โรงงาน' ");
        $wg_scale_shop = DB::select("SELECT * from wg_scale WHERE wg_scale.location_type = 'ร้านค้า' ");
        $wg_weight_type = DB::select("SELECT * from wg_weight_type");
        $wg_sku = DB::select("SELECT * from wg_sku");
        $wg_storage = DB::select("SELECT * from wg_storage");

        return view('recieve.weighing_factory',compact('wg_scale','wg_weight_type','wg_scale_shop','wg_sku','wg_storage'));
    }

    public static function weighingTransfer(){
        $wg_scale = DB::select("SELECT * from wg_scale WHERE wg_scale.location_type = 'ร้านค้า' ");
        $wg_scale_shop = DB::select("SELECT * from wg_scale WHERE wg_scale.location_type = 'ร้านค้า' ");
        $wg_weight_type = DB::select("SELECT * from wg_weight_type");
        $wg_sku = DB::select("SELECT * from wg_sku");
        $wg_storage = DB::select("SELECT * from wg_storage");

        return view('recieve.weighing_transfer',compact('wg_scale','wg_weight_type','wg_scale_shop','wg_sku','wg_storage'));
    }

    public static function weighingStock(){
        $wg_scale = DB::select("SELECT * from wg_scale WHERE wg_scale.location_type = 'ร้านค้า' ");
        $wg_scale_shop = DB::select("SELECT * from wg_scale WHERE wg_scale.location_type = 'ร้านค้า' ");
        $wg_weight_type = DB::select("SELECT * from wg_weight_type");
        $wg_sku = DB::select("SELECT * from wg_sku");
        $wg_storage = DB::select("SELECT * from wg_storage");

        return view('recieve.weighing_stock',compact('wg_scale','wg_weight_type','wg_scale_shop','wg_sku','wg_storage'));
    }

    public static function weighing_factory_date_specify(){

        
        $wg_scale = DB::select("SELECT * from wg_scale WHERE wg_scale.location_type = 'โรงงาน' ");
        $wg_scale_shop = DB::select("SELECT * from wg_scale WHERE wg_scale.location_type = 'ร้านค้า' ");
        $wg_weight_type = DB::select("SELECT * from wg_weight_type");
        $wg_sku = DB::select("SELECT * from wg_sku");
        $wg_storage = DB::select("SELECT * from wg_storage");
        
        $scale = DB::select("SELECT * FROM `wg_scale` WHERE wg_scale.location_type = 'โรงงาน'");
        return view('recieve.weighing_factory_date_specify',compact('scale','wg_scale','wg_weight_type','wg_scale_shop','wg_sku','wg_storage'));
    }

    public static function weighing_factory_date_specify_log_delete(){

        
        $wg_scale = DB::select("SELECT * from wg_scale WHERE wg_scale.location_type = 'โรงงาน' ");
        $wg_scale_shop = DB::select("SELECT * from wg_scale WHERE wg_scale.location_type = 'ร้านค้า' ");
        $wg_weight_type = DB::select("SELECT * from wg_weight_type");
        $wg_sku = DB::select("SELECT * from wg_sku");
        $wg_storage = DB::select("SELECT * from wg_storage");
        
        $scale = DB::select("SELECT * FROM `wg_scale` WHERE wg_scale.location_type = 'โรงงาน'");
        return view('recieve.weighing_factory_date_specify_delete',compact('scale','wg_scale','wg_weight_type','wg_scale_shop','wg_sku','wg_storage'));
    }
    //ajax weighing มอง scale_number = user_name

    public static function sku_weight_data_factory(){

        if (Auth::user()->id_type == 1 || Auth::user()->id_type == 3) {
            $data_recieve = DB::select("SELECT
            wg_sku_weight_data.id,
            wg_sku_weight_data.lot_number,
            wg_sku_weight_data.sku_amount,
            wg_sku_weight_data.sku_weight,
            wg_sku_weight_data.weighing_place,
            wg_sku_weight_data.scale_number,
            wg_sku_weight_data.user_name,
            wg_sku_weight_data.weighing_date,
            wg_sku_weight_data.note,
            wg_sku.sku_name AS sku_type,
            wg_weight_type.wg_type_name,
            wg_scale.location_scale,
            REPLACE(wg_sku_weight_data.sku_code, ' ', '') as sku_code,
            wg_sku_item.item_name,
            wg_weight_type.id_wg_type,
            wg_sku.id_wg_sku,
            wg_sku_weight_data.storage_name
            FROM
                wg_sku_weight_data
                LEFT JOIN wg_sku ON wg_sku_weight_data.sku_id = wg_sku.id_wg_sku
                LEFT JOIN wg_weight_type ON wg_sku_weight_data.weighing_type = wg_weight_type.id_wg_type
                LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                LEFT JOIN (SELECT * from wg_sku_item GROUP BY wg_sku_item.item_code)as wg_sku_item ON REPLACE(wg_sku_weight_data.sku_code, ' ', '') = wg_sku_item.item_code 
            WHERE
                wg_scale.location_type = 'โรงงาน' 
                AND wg_sku_weight_data.weighing_date >= CURRENT_DATE - INTERVAL '2' DAY 
            ORDER BY
                wg_sku_weight_data.weighing_date DESC
            ", []);
        }else if (Auth::user()->id_type == 7) {
            $branch_name = Auth::user()->branch_name;
            $data_recieve = DB::select("SELECT
            wg_sku_weight_data.id,
            wg_sku_weight_data.lot_number,
            wg_sku_weight_data.sku_amount,
            wg_sku_weight_data.sku_weight,
            wg_sku_weight_data.weighing_place,
            wg_sku_weight_data.scale_number,
            wg_sku_weight_data.user_name,
            wg_sku_weight_data.weighing_date,
            wg_sku_weight_data.note,
            wg_sku.sku_name AS sku_type,
            wg_weight_type.wg_type_name,
            wg_scale.location_scale,
            REPLACE(wg_sku_weight_data.sku_code, ' ', '') as sku_code,
            wg_sku_item.item_name,
            wg_weight_type.id_wg_type,
            wg_sku.id_wg_sku,
            wg_sku_weight_data.storage_name
            FROM
                wg_sku_weight_data
                LEFT JOIN wg_sku ON wg_sku_weight_data.sku_id = wg_sku.id_wg_sku
                LEFT JOIN wg_weight_type ON wg_sku_weight_data.weighing_type = wg_weight_type.id_wg_type
                LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                LEFT JOIN (SELECT * from wg_sku_item GROUP BY wg_sku_item.item_code)as wg_sku_item ON REPLACE(wg_sku_weight_data.sku_code, ' ', '') = wg_sku_item.item_code 
            WHERE
                wg_scale.location_type = 'โรงงาน'
                AND wg_sku_weight_data.weighing_date >= current_date - interval '7' day
                AND wg_sku_weight_data.scale_number = '$branch_name'
            ORDER BY
                wg_sku_weight_data.weighing_date DESC
            ", []);
        }else if (Auth::user()->id_type == 8) {
                    $data_recieve = DB::select("SELECT
                    wg_sku_weight_data.id,
                    wg_sku_weight_data.lot_number,
                    wg_sku_weight_data.sku_amount,
                    wg_sku_weight_data.sku_weight,
                    wg_sku_weight_data.weighing_place,
                    wg_sku_weight_data.scale_number,
                    wg_sku_weight_data.user_name,
                    wg_sku_weight_data.weighing_date,
                    wg_sku_weight_data.note,
                    wg_sku.sku_name AS sku_type,
                    wg_weight_type.wg_type_name,
                    wg_scale.location_scale,
                    wg_sku_weight_data.sku_code,
                    wg_sku_item.item_name,
                    wg_weight_type.id_wg_type,
                    wg_sku.id_wg_sku,
                    wg_sku_weight_data.storage_name
                FROM
                    wg_sku_weight_data
                    LEFT JOIN wg_sku ON wg_sku_weight_data.sku_id = wg_sku.id_wg_sku
                    LEFT JOIN wg_weight_type ON wg_sku_weight_data.weighing_type = wg_weight_type.id_wg_type
                    LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
            LEFT JOIN (SELECT * from wg_sku_item GROUP BY wg_sku_item.item_code)as wg_sku_item ON REPLACE(wg_sku_weight_data.sku_code, ' ', '') = wg_sku_item.item_code 
                WHERE
                    wg_scale.location_type = 'โรงงาน'
                    AND wg_sku_weight_data.weighing_date >= current_date - interval '15' day
                    AND wg_scale.process_number = 1
                ORDER BY
                    wg_sku_weight_data.weighing_date DESC
                ", []);
        }else if (Auth::user()->id_type == 9) {
            $data_recieve = DB::select("SELECT
                    wg_sku_weight_data.id,
                    wg_sku_weight_data.lot_number,
                    wg_sku_weight_data.sku_amount,
                    wg_sku_weight_data.sku_weight,
                    wg_sku_weight_data.weighing_place,
                    wg_sku_weight_data.scale_number,
                    wg_sku_weight_data.user_name,
                    wg_sku_weight_data.weighing_date,
                    wg_sku_weight_data.note,
                    wg_sku.sku_name AS sku_type,
                    wg_weight_type.wg_type_name,
                    wg_scale.location_scale,
                    wg_sku_weight_data.sku_code,
                    wg_sku_item.item_name,
                    wg_weight_type.id_wg_type,
                    wg_sku.id_wg_sku,
                    wg_sku_weight_data.storage_name
                FROM
                    wg_sku_weight_data
                    LEFT JOIN wg_sku ON wg_sku_weight_data.sku_id = wg_sku.id_wg_sku
                    LEFT JOIN wg_weight_type ON wg_sku_weight_data.weighing_type = wg_weight_type.id_wg_type
                    LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
            LEFT JOIN (SELECT * from wg_sku_item GROUP BY wg_sku_item.item_code)as wg_sku_item ON REPLACE(wg_sku_weight_data.sku_code, ' ', '') = wg_sku_item.item_code 
                WHERE
                    wg_scale.location_type = 'โรงงาน'
                    AND wg_sku_weight_data.weighing_date >= current_date - interval '15' day
                    AND wg_scale.process_number IN (4,5,6)
                ORDER BY
                    wg_sku_weight_data.weighing_date DESC
                ", []);
        }else if (Auth::user()->id_type == 10) {
            $data_recieve = DB::select("SELECT
                    wg_sku_weight_data.id,
                    wg_sku_weight_data.lot_number,
                    wg_sku_weight_data.sku_amount,
                    wg_sku_weight_data.sku_weight,
                    wg_sku_weight_data.weighing_place,
                    wg_sku_weight_data.scale_number,
                    wg_sku_weight_data.user_name,
                    wg_sku_weight_data.weighing_date,
                    wg_sku_weight_data.note,
                    wg_sku.sku_name AS sku_type,
                    wg_weight_type.wg_type_name,
                    wg_scale.location_scale,
                    wg_sku_weight_data.sku_code,
                    wg_sku_item.item_name,
                    wg_weight_type.id_wg_type,
                    wg_sku.id_wg_sku,
                    wg_sku_weight_data.storage_name
                FROM
                    wg_sku_weight_data
                    LEFT JOIN wg_sku ON wg_sku_weight_data.sku_id = wg_sku.id_wg_sku
                    LEFT JOIN wg_weight_type ON wg_sku_weight_data.weighing_type = wg_weight_type.id_wg_type
                    LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
            LEFT JOIN (SELECT * from wg_sku_item GROUP BY wg_sku_item.item_code)as wg_sku_item ON REPLACE(wg_sku_weight_data.sku_code, ' ', '') = wg_sku_item.item_code 
                WHERE
                    wg_scale.location_type = 'โรงงาน'
                    AND wg_sku_weight_data.weighing_date >= current_date - interval '15' day
                    AND wg_scale.process_number IN (7,8)
                ORDER BY
                    wg_sku_weight_data.weighing_date DESC
                ", []);
        }
        return Datatables::of($data_recieve)->addIndexColumn()->make(true);
    }

    public static function sku_weight_data_factory_date_specify(Request $request){

        $filter = '';
        if (!empty($request->scale_number)){
            $filter = $filter . " AND wg_sku_weight_data.scale_number = '$request->scale_number'";
        }
        if (!empty($request->order_number)){
            $order_ = str_replace(",","','",$request->order_number);
            $filter = $filter . " AND wg_sku_weight_data.lot_number IN ('$order_')";
        }
        if (!empty($request->item_code)){
            $code = str_replace(",","','",$request->item_code);
            $filter = $filter . " AND wg_sku_weight_data.sku_code IN ('$code')";
        }
        
        // if (Auth::user()->id_type !== 3) {
            $data_recieve = DB::select("SELECT
                wg_sku_weight_data.id,
                wg_sku_weight_data.lot_number,
                CASE
                WHEN (wg_sku_weight_data.lot_number like 'OV%') THEN
                (select tb_order_overnight.order_ref FROM tb_order_overnight WHERE tb_order_overnight.order_number = wg_sku_weight_data.lot_number)
                WHEN (wg_sku_weight_data.lot_number like 'OF%') THEN
                (select tb_order_offal.order_ref FROM tb_order_offal WHERE tb_order_offal.order_number = wg_sku_weight_data.lot_number)
                WHEN (wg_sku_weight_data.lot_number like 'CL%') THEN
                (select tb_order_cutting.order_ref FROM tb_order_cutting WHERE tb_order_cutting.order_number = wg_sku_weight_data.lot_number)
                END	as order_ref,
                wg_sku_weight_data.sku_amount,
                wg_sku_weight_data.sku_weight,
                wg_sku_weight_data.weighing_place,
                wg_weight_type.id_wg_type,
                wg_sku_weight_data.scale_number,
                wg_sku_weight_data.user_name,
                wg_sku_weight_data.weighing_date,
                wg_sku_weight_data.note,
                wg_sku_weight_data.storage_name,
                wg_sku.sku_name AS sku_type,
                wg_sku.id_wg_sku,
                wg_weight_type.wg_type_name,
                wg_scale.location_scale,
                REPLACE(wg_sku_weight_data.sku_code, ' ', '') as sku_code,
                DATE_FORMAT( wg_sku_weight_data.weighing_date, '%d/%m/%Y' ),
                wg_sku_item.item_name
                FROM
                    wg_sku_weight_data
                    LEFT JOIN wg_sku ON wg_sku_weight_data.sku_id = wg_sku.id_wg_sku
                    LEFT JOIN wg_weight_type ON wg_sku_weight_data.weighing_type = wg_weight_type.id_wg_type
                    LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                    LEFT JOIN (SELECT * from wg_sku_item GROUP BY wg_sku_item.item_code)as wg_sku_item ON REPLACE(wg_sku_weight_data.sku_code, ' ', '') = wg_sku_item.item_code 
                WHERE
                    wg_scale.location_type = 'โรงงาน'
                    AND DATE_FORMAT( wg_sku_weight_data.weighing_date, '%d/%m/%Y' ) = '$request->date'
                    $filter
                ORDER BY
                    wg_sku_weight_data.weighing_date DESC
            ", []);
        // }else if (Auth::user()->id_type == 7) {
            //     $branch_name = Auth::user()->branch_name;
            //     $data_recieve = DB::select("SELECT
            //             wg_sku_weight_data.id,
            //             wg_sku_weight_data.lot_number,
            //             wg_sku_weight_data.sku_amount,
            //             wg_sku_weight_data.sku_weight,
            //             wg_sku_weight_data.weighing_place,
            //             wg_weight_type.id_wg_type,
            //             wg_sku_weight_data.scale_number,
            //             wg_sku_weight_data.user_name,
            //             wg_sku_weight_data.weighing_date,
            //             wg_sku_weight_data.note,
            //             wg_sku_weight_data.storage_name,
            //             wg_sku.sku_name AS sku_type,
            //             wg_sku.id_wg_sku,
            //             wg_weight_type.wg_type_name,
            //             wg_scale.location_scale,
            //             REPLACE(wg_sku_weight_data.sku_code, ' ', '') as sku_code,
            //             DATE_FORMAT( wg_sku_weight_data.weighing_date, '%d/%m/%Y' ),
            //             wg_sku_item.item_name
            //         FROM
            //             wg_sku_weight_data
            //             LEFT JOIN wg_sku ON wg_sku_weight_data.sku_id = wg_sku.id_wg_sku
            //             LEFT JOIN wg_weight_type ON wg_sku_weight_data.weighing_type = wg_weight_type.id_wg_type
            //             LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
            //             LEFT JOIN (SELECT * from wg_sku_item GROUP BY wg_sku_item.item_code)as wg_sku_item ON REPLACE(wg_sku_weight_data.sku_code, ' ', '') = wg_sku_item.item_code 
            //         WHERE
            //             wg_scale.location_type = 'โรงงาน'
            //             AND DATE_FORMAT( wg_sku_weight_data.weighing_date, '%d/%m/%Y' ) = '$request->date'
            //             AND wg_sku_weight_data.scale_number = '$request->scale_number' 
            //             AND wg_sku_weight_data.scale_number = '$branch_name'
            //         ORDER BY
            //             wg_sku_weight_data.weighing_date DESC
            //     ", []);
        // }

        return Datatables::of($data_recieve)->addIndexColumn()->make(true);
    }

    public static function sku_weight_data_factory_date_specify_delete(Request $request){

        $filter = '';
        if (!empty($request->scale_number)){
            $filter = $filter . " AND wg_sku_weight_data.scale_number = '$request->scale_number'";
        }
        if (!empty($request->order_number)){
            $order_ = str_replace(",","','",$request->order_number);
            $filter = $filter . " AND wg_sku_weight_data.lot_number IN ('$order_')";
        }
        if (!empty($request->item_code)){
            $code = str_replace(",","','",$request->item_code);
            $filter = $filter . " AND wg_sku_weight_data.sku_code IN ('$code')";
        }
        
            $data_recieve = DB::select("SELECT
                wg_sku_weight_data.id,
                wg_sku_weight_data.lot_number,
                wg_sku_weight_data.sku_amount,
                wg_sku_weight_data.sku_weight,
                wg_sku_weight_data.weighing_place,
                wg_weight_type.id_wg_type,
                wg_sku_weight_data.scale_number,
                wg_sku_weight_data.user_name,
                wg_sku_weight_data.updated_at as weighing_date,
                wg_sku_weight_data.note,
                wg_sku_weight_data.storage_name,
                wg_sku_weight_data.user_del,
                wg_sku.sku_name AS sku_type,
                wg_sku.id_wg_sku,
                wg_weight_type.wg_type_name,
                wg_scale.location_scale,
                REPLACE(wg_sku_weight_data.sku_code, ' ', '') as sku_code,
                DATE_FORMAT( wg_sku_weight_data.weighing_date, '%d/%m/%Y' ),
                wg_sku_item.item_name
                FROM
                    wg_sku_weight_data_delete as wg_sku_weight_data
                    LEFT JOIN wg_sku ON wg_sku_weight_data.sku_id = wg_sku.id_wg_sku
                    LEFT JOIN wg_weight_type ON wg_sku_weight_data.weighing_type = wg_weight_type.id_wg_type
                    LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                    LEFT JOIN (SELECT * from wg_sku_item GROUP BY wg_sku_item.item_code)as wg_sku_item ON REPLACE(wg_sku_weight_data.sku_code, ' ', '') = wg_sku_item.item_code 
                WHERE
                    wg_scale.location_type = 'โรงงาน'
                    AND DATE_FORMAT( wg_sku_weight_data.updated_at, '%d/%m/%Y' ) = '$request->date'
                    $filter
                ORDER BY
                    wg_sku_weight_data.weighing_date DESC
            ", []);
        return Datatables::of($data_recieve)->addIndexColumn()->make(true);
    }

    public static function sku_weight_data(Request $request){

        $filter = '';
        if (!empty($request->scale_number)){
            $filter = $filter . " AND wg_sku_weight_data.scale_number = '$request->scale_number'";
        }
        if (!empty($request->order_number)){
            $order_ = str_replace(",","','",$request->order_number);
            $filter = $filter . " AND wg_sku_weight_data.lot_number IN ('$order_')";
        }
        if (!empty($request->item_code)){
            $code = str_replace(",","','",$request->item_code);
            $filter = $filter . " AND wg_sku_weight_data.sku_code IN ('$code')";
        }

        if (Auth::user()->id_type == 1 || Auth::user()->id_type == 5 || Auth::user()->id_type == 2) {
            $data_recieve = DB::select("SELECT
                    wg_sku_weight_data.id,
                    wg_sku_weight_data.lot_number,
                    wg_sku_weight_data.sku_amount,
                    wg_sku_weight_data.sku_weight,
                    wg_sku_weight_data.weighing_place,
                    wg_weight_type.id_wg_type,
                    wg_sku_weight_data.scale_number,
                    wg_sku_weight_data.user_name,
                    wg_sku_weight_data.weighing_date,
                    wg_sku_weight_data.note,
                    wg_sku_weight_data.storage_name,
                    wg_sku.sku_name AS sku_type,
                    wg_sku.id_wg_sku,
                    wg_weight_type.wg_type_name,
                    wg_scale.location_scale,
                    REPLACE(wg_sku_weight_data.sku_code, ' ', '') as sku_code,
                    DATE_FORMAT( wg_sku_weight_data.weighing_date, '%d/%m/%Y' ),
                    wg_sku_item.item_name
                FROM
                    wg_sku_weight_data
                    LEFT JOIN wg_sku ON wg_sku_weight_data.sku_id = wg_sku.id_wg_sku
                    LEFT JOIN wg_weight_type ON wg_sku_weight_data.weighing_type = wg_weight_type.id_wg_type
                    LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                    LEFT JOIN (SELECT * from wg_sku_item GROUP BY wg_sku_item.item_code)as wg_sku_item ON REPLACE(wg_sku_weight_data.sku_code, ' ', '') = wg_sku_item.item_code 
                WHERE
                    wg_scale.location_type = 'ร้านค้า'
                    AND DATE_FORMAT( wg_sku_weight_data.weighing_date, '%d/%m/%Y' ) = '$request->date'
                    $filter
                ORDER BY
                    wg_sku_weight_data.weighing_date DESC
            ", []);
        }
        else if (Auth::user()->id_type == 6 || Auth::user()->id_type == 4 ){
            $branch_name = Auth::user()->branch_name;
            $data_recieve = DB::select("SELECT
                    wg_sku_weight_data.id,
                    wg_sku_weight_data.lot_number,
                    wg_sku_weight_data.sku_amount,
                    wg_sku_weight_data.sku_weight,
                    wg_sku_weight_data.weighing_place,
                    wg_weight_type.id_wg_type,
                    wg_sku_weight_data.scale_number,
                    wg_sku_weight_data.user_name,
                    wg_sku_weight_data.weighing_date,
                    wg_sku_weight_data.note,
                    wg_sku_weight_data.storage_name,
                    wg_sku.sku_name AS sku_type,
                    wg_sku.id_wg_sku,
                    wg_weight_type.wg_type_name,
                    wg_scale.location_scale,
                    REPLACE(wg_sku_weight_data.sku_code, ' ', '') as sku_code,
                    DATE_FORMAT( wg_sku_weight_data.weighing_date, '%d/%m/%Y' ),
                    wg_sku_item.item_name
                FROM
                    wg_sku_weight_data
                    LEFT JOIN wg_sku ON wg_sku_weight_data.sku_id = wg_sku.id_wg_sku
                    LEFT JOIN wg_weight_type ON wg_sku_weight_data.weighing_type = wg_weight_type.id_wg_type
                    LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                    LEFT JOIN (SELECT * from wg_sku_item GROUP BY wg_sku_item.item_code)as wg_sku_item ON REPLACE(wg_sku_weight_data.sku_code, ' ', '') = wg_sku_item.item_code 
                WHERE
                    wg_scale.location_type = 'ร้านค้า'
                    AND DATE_FORMAT( wg_sku_weight_data.weighing_date, '%d/%m/%Y' ) = '$request->date'
                    AND wg_sku_weight_data.scale_number = '$branch_name' 
                    $filter
                ORDER BY
                    wg_sku_weight_data.weighing_date DESC
            ", []);
        }

        return Datatables::of($data_recieve)->addIndexColumn()->make(true);
    }
    
    public static function sku_weight_data_transfer(){
        if (Auth::user()->id_type == 1 || Auth::user()->id_type == 5 || Auth::user()->id_type == 2) {
                $data_recieve = DB::select("SELECT
                wg_sku_weight_data.id,
                wg_sku_weight_data.lot_number,
                wg_sku_weight_data.sku_amount,
                wg_sku_weight_data.sku_weight,
                wg_sku_weight_data.weighing_place,
                wg_sku_weight_data.scale_number,
                wg_sku_weight_data.user_name,
                wg_sku_weight_data.weighing_date,
                wg_sku_weight_data.note,
                wg_sku.sku_name AS sku_type,
                wg_weight_type.wg_type_name,
                wg_scale.location_scale,
                REPLACE(wg_sku_weight_data.sku_code, ' ', '') as sku_code,
                wg_sku_item.item_name,
                SUBSTRING_INDEX( REPLACE(wg_sku_weight_data.sku_code, ' ', ''), '-', 1 ) AS item1,
                wg_sku_item1.item_name AS item1_name,
                SUBSTRING_INDEX( REPLACE(wg_sku_weight_data.sku_code, ' ', ''), '-',- 1 ) AS item2,
                wg_sku_item2.item_name AS item2_name,
                wg_weight_type.id_wg_type,
                wg_sku.id_wg_sku,
                wg_sku_weight_data.storage_name  
            FROM
                wg_sku_weight_data
                LEFT JOIN wg_sku ON wg_sku_weight_data.sku_id = wg_sku.id_wg_sku
                LEFT JOIN wg_weight_type ON wg_sku_weight_data.weighing_type = wg_weight_type.id_wg_type
                LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                LEFT JOIN ( SELECT wg_sku_item.item_code, wg_sku_item.item_name, wg_sku_item.unit, wg_sku_item.price FROM wg_sku_item WHERE wg_sku_item.sku_category = 'ร้านค้า' GROUP BY wg_sku_item.item_code ) AS wg_sku_item ON REPLACE(wg_sku_weight_data.sku_code, ' ', '') = wg_sku_item.item_code
                LEFT JOIN ( SELECT wg_sku_item.item_code, wg_sku_item.item_name, wg_sku_item.unit, wg_sku_item.price FROM wg_sku_item WHERE wg_sku_item.sku_category = 'ร้านค้า' GROUP BY wg_sku_item.item_code ) AS wg_sku_item1 ON SUBSTRING_INDEX( REPLACE(wg_sku_weight_data.sku_code, ' ', ''), '-', 1 ) = wg_sku_item1.item_code
                LEFT JOIN ( SELECT wg_sku_item.item_code, wg_sku_item.item_name, wg_sku_item.unit, wg_sku_item.price FROM wg_sku_item WHERE wg_sku_item.sku_category = 'ร้านค้า' GROUP BY wg_sku_item.item_code ) AS wg_sku_item2 ON SUBSTRING_INDEX( REPLACE(wg_sku_weight_data.sku_code, ' ', ''), '-',- 1 ) = wg_sku_item2.item_code 
            WHERE
                wg_scale.location_type = 'ร้านค้า' 
                AND wg_sku_weight_data.weighing_type IN ( 4, 5, 6 ) 
                AND wg_sku_weight_data.weighing_date >= CURRENT_DATE - INTERVAL '30' DAY 
            ORDER BY
                wg_sku_weight_data.weighing_date DESC", []);
        }
        else if (Auth::user()->id_type == 6){
                $branch_name = Auth::user()->branch_name;
                $data_recieve = DB::select("SELECT
                wg_sku_weight_data.id,
                wg_sku_weight_data.lot_number,
                wg_sku_weight_data.sku_amount,
                wg_sku_weight_data.sku_weight,
                wg_sku_weight_data.weighing_place,
                wg_sku_weight_data.scale_number,
                wg_sku_weight_data.user_name,
                wg_sku_weight_data.weighing_date,
                wg_sku_weight_data.note,
                wg_sku.sku_name AS sku_type,
                wg_weight_type.wg_type_name,
                wg_scale.location_scale,
                REPLACE(wg_sku_weight_data.sku_code, ' ', '') as sku_code,
                wg_sku_item.item_name,
                SUBSTRING_INDEX( REPLACE(wg_sku_weight_data.sku_code, ' ', ''), '-', 1 ) AS item1,
                wg_sku_item1.item_name AS item1_name,
                SUBSTRING_INDEX( REPLACE(wg_sku_weight_data.sku_code, ' ', ''), '-',- 1 ) AS item2,
                wg_sku_item2.item_name AS item2_name,
                wg_weight_type.id_wg_type,
                wg_sku.id_wg_sku,
                wg_sku_weight_data.storage_name 
            FROM
                wg_sku_weight_data
                LEFT JOIN wg_sku ON wg_sku_weight_data.sku_id = wg_sku.id_wg_sku
                LEFT JOIN wg_weight_type ON wg_sku_weight_data.weighing_type = wg_weight_type.id_wg_type
                LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                LEFT JOIN ( SELECT wg_sku_item.item_code, wg_sku_item.item_name, wg_sku_item.unit, wg_sku_item.price FROM wg_sku_item WHERE wg_sku_item.sku_category = 'ร้านค้า' GROUP BY wg_sku_item.item_code ) AS wg_sku_item ON REPLACE(wg_sku_weight_data.sku_code, ' ', '') = wg_sku_item.item_code
                LEFT JOIN ( SELECT wg_sku_item.item_code, wg_sku_item.item_name, wg_sku_item.unit, wg_sku_item.price FROM wg_sku_item WHERE wg_sku_item.sku_category = 'ร้านค้า' GROUP BY wg_sku_item.item_code ) AS wg_sku_item1 ON SUBSTRING_INDEX( REPLACE(wg_sku_weight_data.sku_code, ' ', ''), '-', 1 ) = wg_sku_item1.item_code
                LEFT JOIN ( SELECT wg_sku_item.item_code, wg_sku_item.item_name, wg_sku_item.unit, wg_sku_item.price FROM wg_sku_item WHERE wg_sku_item.sku_category = 'ร้านค้า' GROUP BY wg_sku_item.item_code ) AS wg_sku_item2 ON SUBSTRING_INDEX( REPLACE(wg_sku_weight_data.sku_code, ' ', ''), '-',- 1 ) = wg_sku_item2.item_code 
            WHERE
                wg_scale.location_type = 'ร้านค้า' 
                AND wg_sku_weight_data.weighing_type IN ( 4, 5, 6 ) 
                AND wg_sku_weight_data.weighing_date >= CURRENT_DATE - INTERVAL '30' DAY 
                AND wg_sku_weight_data.scale_number = '$branch_name' 
            ORDER BY
                wg_sku_weight_data.weighing_date DESC", []);    
        }

        return Datatables::of($data_recieve)->addIndexColumn()->make(true);
    }

    public static function weighing_stock(){
        if (Auth::user()->id_type == 1 || Auth::user()->id_type == 5 || Auth::user()->id_type == 2 ) {
                $data_recieve = DB::select("SELECT
                wg_sku_weight_data.id,
                wg_sku_weight_data.lot_number,
                wg_sku_weight_data.sku_amount,
                wg_sku_weight_data.sku_weight,
                wg_sku_weight_data.weighing_place,
                wg_sku_weight_data.scale_number,
                wg_sku_weight_data.user_name,
                wg_sku_weight_data.weighing_date,
                wg_sku_weight_data.note,
                wg_sku.sku_name AS sku_type,
                wg_weight_type.wg_type_name,
                wg_scale.location_scale,
                REPLACE(wg_sku_weight_data.sku_code, ' ', '') as sku_code,
                wg_sku_item.item_name,
                SUBSTRING_INDEX( REPLACE(wg_sku_weight_data.sku_code, ' ', ''), '-', 1 ) AS item1,
                wg_sku_item1.item_name AS item1_name,
                SUBSTRING_INDEX( REPLACE(wg_sku_weight_data.sku_code, ' ', ''), '-',- 1 ) AS item2,
                wg_sku_item2.item_name AS item2_name,
                wg_weight_type.id_wg_type,
                wg_sku.id_wg_sku,
                wg_sku_weight_data.storage_name 
            FROM
                wg_sku_weight_data
                LEFT JOIN wg_sku ON wg_sku_weight_data.sku_id = wg_sku.id_wg_sku
                LEFT JOIN wg_weight_type ON wg_sku_weight_data.weighing_type = wg_weight_type.id_wg_type
                LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                LEFT JOIN ( SELECT wg_sku_item.item_code, wg_sku_item.item_name, wg_sku_item.unit, wg_sku_item.price FROM wg_sku_item WHERE wg_sku_item.sku_category = 'ร้านค้า' GROUP BY wg_sku_item.item_code ) AS wg_sku_item ON REPLACE(wg_sku_weight_data.sku_code, ' ', '') = wg_sku_item.item_code
                LEFT JOIN ( SELECT wg_sku_item.item_code, wg_sku_item.item_name, wg_sku_item.unit, wg_sku_item.price FROM wg_sku_item WHERE wg_sku_item.sku_category = 'ร้านค้า' GROUP BY wg_sku_item.item_code ) AS wg_sku_item1 ON SUBSTRING_INDEX( REPLACE(wg_sku_weight_data.sku_code, ' ', ''), '-', 1 ) = wg_sku_item1.item_code
                LEFT JOIN ( SELECT wg_sku_item.item_code, wg_sku_item.item_name, wg_sku_item.unit, wg_sku_item.price FROM wg_sku_item WHERE wg_sku_item.sku_category = 'ร้านค้า' GROUP BY wg_sku_item.item_code ) AS wg_sku_item2 ON SUBSTRING_INDEX( REPLACE(wg_sku_weight_data.sku_code, ' ', ''), '-',- 1 ) = wg_sku_item2.item_code 
            WHERE
                wg_scale.location_type = 'ร้านค้า' 
                AND wg_sku_weight_data.weighing_type IN ( 7 )
                AND wg_sku_weight_data.weighing_date >= CURRENT_DATE - INTERVAL '30' DAY 
            ORDER BY
                wg_sku_weight_data.weighing_date DESC", []);
        }
        else if (Auth::user()->id_type == 6){
                $branch_name = Auth::user()->branch_name;
                $data_recieve = DB::select("SELECT
                wg_sku_weight_data.id,
                wg_sku_weight_data.lot_number,
                wg_sku_weight_data.sku_amount,
                wg_sku_weight_data.sku_weight,
                wg_sku_weight_data.weighing_place,
                wg_sku_weight_data.scale_number,
                wg_sku_weight_data.user_name,
                wg_sku_weight_data.weighing_date,
                wg_sku_weight_data.note,
                wg_sku.sku_name AS sku_type,
                wg_weight_type.wg_type_name,
                wg_scale.location_scale,
                REPLACE(wg_sku_weight_data.sku_code, ' ', '') as sku_code,
                wg_sku_item.item_name,
                SUBSTRING_INDEX( REPLACE(wg_sku_weight_data.sku_code, ' ', ''), '-', 1 ) AS item1,
                wg_sku_item1.item_name AS item1_name,
                SUBSTRING_INDEX( REPLACE(wg_sku_weight_data.sku_code, ' ', ''), '-',- 1 ) AS item2,
                wg_sku_item2.item_name AS item2_name,
                wg_weight_type.id_wg_type,
                wg_sku.id_wg_sku,
                wg_sku_weight_data.storage_name 
            FROM
                wg_sku_weight_data
                LEFT JOIN wg_sku ON wg_sku_weight_data.sku_id = wg_sku.id_wg_sku
                LEFT JOIN wg_weight_type ON wg_sku_weight_data.weighing_type = wg_weight_type.id_wg_type
                LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                LEFT JOIN ( SELECT wg_sku_item.item_code, wg_sku_item.item_name, wg_sku_item.unit, wg_sku_item.price FROM wg_sku_item WHERE wg_sku_item.sku_category = 'ร้านค้า' GROUP BY wg_sku_item.item_code ) AS wg_sku_item ON REPLACE(wg_sku_weight_data.sku_code, ' ', '') = wg_sku_item.item_code
                LEFT JOIN ( SELECT wg_sku_item.item_code, wg_sku_item.item_name, wg_sku_item.unit, wg_sku_item.price FROM wg_sku_item WHERE wg_sku_item.sku_category = 'ร้านค้า' GROUP BY wg_sku_item.item_code ) AS wg_sku_item1 ON SUBSTRING_INDEX( REPLACE(wg_sku_weight_data.sku_code, ' ', ''), '-', 1 ) = wg_sku_item1.item_code
                LEFT JOIN ( SELECT wg_sku_item.item_code, wg_sku_item.item_name, wg_sku_item.unit, wg_sku_item.price FROM wg_sku_item WHERE wg_sku_item.sku_category = 'ร้านค้า' GROUP BY wg_sku_item.item_code ) AS wg_sku_item2 ON SUBSTRING_INDEX( REPLACE(wg_sku_weight_data.sku_code, ' ', ''), '-',- 1 ) = wg_sku_item2.item_code 
            WHERE
                wg_scale.location_type = 'ร้านค้า' 
                AND wg_sku_weight_data.weighing_type IN ( 7 )
                AND wg_sku_weight_data.weighing_date >= CURRENT_DATE - INTERVAL '30' DAY 
                AND wg_sku_weight_data.scale_number = '$branch_name' 
            ORDER BY
                wg_sku_weight_data.weighing_date DESC", []);    
        }

        return Datatables::of($data_recieve)->addIndexColumn()->make(true);
    }

    public function delete_weighing_data(Request $request){
        $data_old = DB::select("SELECT * from wg_sku_weight_data WHERE id = $request->id");

        $user_fname = Auth::user()->fname;
        foreach ($data_old as $key => $old) {
            DB::insert("INSERT into wg_sku_weight_data_delete(lot_number,sku_id,sku_code,sku_amount,sku_weight,weighing_place,
                    scale_number,storage_name,`user_name`,user_del,weighing_date,created_at,weighing_type,updated_at) 
                    values ('$old->lot_number','$old->sku_id','$old->sku_code','$old->sku_amount','$old->sku_weight',
                        '$old->weighing_place','$old->scale_number','$old->storage_name','$old->user_name','$user_fname',
                        '$old->weighing_date','$old->created_at','$old->weighing_type',now())"
            );
        }

        DB::delete("DELETE from wg_sku_weight_data WHERE id = $request->id");
        return 'ลบสำเร็จ';
    }

    public function wg_sku_weigth_add(Request $request){
     
        $_date = substr($request->weighing_date,6,4).'-'.substr($request->weighing_date,3,2).'-'.substr($request->weighing_date,0,2).' '.$request->time.':00';

        DB::insert("INSERT into wg_sku_weight_data(lot_number,sku_id,sku_code,sku_amount,sku_weight,weighing_place,
        scale_number,storage_name,`user_name`,weighing_date,created_at,weighing_type) 
        values (?,?,?,?,?,?,?,?,?,?,?,?)"
        , [$request->order_number, $request->sku_id, $request->sku_code, $request->sku_amount, $request->sku_weight, $request->weighing_place
        , $request->scale_number, $request->storage_name, $request->user_name, $_date, now() ,$request->weighing_type]);
        return Redirect::back()->withErrors(['msg', 'The Message']);
    }

    public function wg_sku_weigth_add_multiple(Request $request){

        $year = substr($request->weighing_date,6,4);
        if (substr($request->weighing_date,6,4) > 2500) {
            $year = substr($request->weighing_date,6,4) - 543;
        }

        $_date = $year.'-'.substr($request->weighing_date,3,2).'-'.substr($request->weighing_date,0,2).' '.$request->time.':00';

        for ($i=0; $i < count($request->sku_code) ; $i++) { 
            DB::insert("INSERT into wg_sku_weight_data(lot_number,sku_id,sku_code,sku_amount,sku_weight,weighing_place,
            scale_number,storage_name,`user_name`,weighing_date,created_at,weighing_type) 
            values (?,?,?,?,?,?,?,?,?,?,?,?)"
            , [$request->order_number, $request->sku_id, $request->sku_code[$i], $request->sku_amount, $request->sku_weight[$i], $request->weighing_place
            , $request->scale_number, $request->storage_name, $request->user_name, $_date, now() ,$request->weighing_type]);
        }

        return Redirect::back()->withErrors(['msg', 'The Message']);
    }

    public function wg_sku_weigth_edit(Request $request){
        $_date = substr($request->weighing_date2,6,4).'-'.substr($request->weighing_date2,3,2).'-'.substr($request->weighing_date2,0,2).' '.$request->time.':00';

        DB::update("UPDATE wg_sku_weight_data SET lot_number = ?,sku_id = ?,sku_code = ?,sku_amount = ?,sku_weight = ?,weighing_place = ?,
        scale_number = ?,storage_name = ?,`user_name` = ?,weighing_date = ?,created_at = ?,weighing_type = ? WHERE id = ?"
          , [$request->order_number, $request->sku_id, $request->sku_code, $request->sku_amount, $request->sku_weight, $request->weighing_place
          , $request->scale_number, $request->storage_name, $request->user_name, $_date, now() ,$request->weighing_type,$request->comfirmAdd]);

        return Redirect::back()->withErrors(['msg', 'The Message']);
    }
    

    public function get_weighing_data(Request $request){
        return DB::select("SELECT
                            wg_sku_weight_data.*,
                            wg_scale.location_scale,
                            wg_weight_type.wg_type_name,
                            wg_sku.sku_name,
                            DATE_FORMAT(wg_sku_weight_data.weighing_date,'%d/%m/%Y') as weighing_date,
                            substr(wg_sku_weight_data.weighing_date,12,8) as time,
                            wg_storage.name_storage
                            FROM
                            wg_sku_weight_data
                            LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                            LEFT JOIN wg_weight_type ON wg_sku_weight_data.weighing_type = wg_weight_type.id_wg_type
                            LEFT JOIN wg_sku ON wg_sku_weight_data.sku_id = wg_sku.id_wg_sku
                            LEFT JOIN wg_storage ON wg_sku_weight_data.storage_name = wg_storage.id_storage
                            WHERE id = $request->id");
    }
}
