<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;
use Auth;

class stock extends Controller
{
 


    public function stock_main(){

        return view('stock.stock_main');
    }
    public static function stock_daily_tt($date){

        $date_format = substr($date,0,2).'/'.substr($date,2,2).'/'.substr($date,4,4);
        $date_format1 = substr($date,2,2).'/'.substr($date,0,2).'/'.substr($date,4,4);

        // 2020-02-20 06:59:55 format
        $date_balance = substr($date,4,4).'-'.substr($date,2,2).'-'.substr($date,0,2).' '.'13:00:00';

        $balance = DB::select("SELECT
            wg_storage_daily.id,
            wg_storage_daily.id_storage,
            wg_storage_daily.name_storage,
            wg_storage_daily.count_unit,
            wg_storage_daily.count_unit_real as balance,
            wg_storage_daily.unit,
            wg_storage_daily.type_of_storage,
            wg_storage_daily.description,
            wg_storage_daily.user_id,
            wg_storage_daily.created_at,
            wg_storage_daily.updated_at,
            wg_storage_daily.zone,
            wg_storage_daily.date_summary,
            wg_storage_daily.weight_summary
            FROM
            wg_storage_daily
            WHERE
            wg_storage_daily.id_storage = '101' AND
            wg_storage_daily.date_summary = DATE_FORMAT(('$date_balance' - INTERVAL 1 DAY),'%d/%m/%Y')
            ORDER BY created_at LIMIT 1
        ");

        $date_stock_recieve = substr($date,4,4).substr($date,2,2).substr($date,0,2);
        
        $stock_recieve = DB::select("SELECT
                wg_stock_log.* ,
	            tb_shop.*
            FROM
                wg_stock_log
                INNER JOIN tb_shop ON wg_stock_log.id_storage = tb_shop.id 
            WHERE
                tb_shop.shop_code = 'PP' 
                AND wg_stock_log.action = 'add'
                AND (
                CONCAT(
                SUBSTRING( wg_stock_log.date_recieve, 7, 4 ),
                SUBSTRING( wg_stock_log.date_recieve, 4, 2 ),
                SUBSTRING( wg_stock_log.date_recieve, 1, 2 ) 
                ) = '$date_stock_recieve'
                ) 
            ORDER BY
                wg_stock_log.id DESC"
        );


        $time = strtotime($date_format1);

        $new_date0 = date('d/m/Y', $time);
        $new_date1 = date('d/m/Y', $time - 86400);
        $new_date2 = date('d/m/Y', $time - 86400 - 86400);
        $new_date3 = date('d/m/Y', $time - 86400 - 86400 - 86400);
        $new_date4 = date('d/m/Y', $time - 86400 - 86400 - 86400 - 86400);
        $new_date5 = date('d/m/Y', $time - 86400 - 86400 - 86400 - 86400 - 86400);
        

        $get_r_order = DB::select("SELECT * FROM tb_order_overnight WHERE tb_order_overnight.date = '$date_format' 
            AND type_request = 3 GROUP BY order_ref"
        );

        $get_ov_order  = DB::select("SELECT
                    tb_order_overnight.order_group,
                    GROUP_CONCAT( tb_order_overnight.order_number SEPARATOR ' , ' ) AS group_order_number,
                    GROUP_CONCAT( tb_order_overnight.total_pig SEPARATOR ' , ' ) AS group_total_pig,
                    GROUP_CONCAT( tb_order_overnight.order_ref SEPARATOR ' , ' ) AS group_order_ref,
                    tb_order_overnight.date,
                    tb_order_overnight.id_user_customer 
                FROM
                    tb_order_overnight 
                WHERE
                    tb_order_overnight.date = '$date_format' 
                    AND tb_order_overnight.type_request = 3 
                GROUP BY
                    tb_order_overnight.order_group"
                
        );
        
        $order_rr = "";
        $order_ov = "";

        foreach ($get_r_order as $key => $value) { 
            $order_rr = $order_rr."'".$value->order_ref."',";
        }
        foreach ($get_ov_order as $key => $value) { 
            $order_ov = $order_ov."'".$value->order_group."',";
        }

        $order_rr = substr($order_rr, 0, -1);
        $order_ov = substr($order_ov, 0, -1);
        $order_rr_show = str_replace("'", "", $order_rr);
        $order_ov_show = str_replace("'", "", $order_ov);
       
        // return  $order_rr;
      
       
        //หมูขุน
        $r_data_list = DB::select("SELECT
                count( wg_sku_weight_data.sku_amount ) AS sum_unit,
                sum( wg_sku_weight_data.sku_weight ) AS sum_weight,
                wg_sku_weight_data.sku_code,
                wg_sku_weight_data.weighing_date,
                wg_sku_weight_data.lot_number,
                DATE_FORMAT( wg_sku_weight_data.weighing_date, '%d/%m/%Y' ) AS weighing_date,
                wg_sku_item.item_name,
                tb_order.id_user_customer,
                tb_order.marker,
                wg_storage.name_storage,
                (select sum(tb_order_overnight.total_pig) from tb_order_overnight where tb_order_overnight.order_ref = lot_number and tb_order_overnight.date = '$new_date0' ) as pig_use,
                (select sum(tb_order_overnight.total_pig) from tb_order_overnight where tb_order_overnight.order_ref = lot_number and tb_order_overnight.date = '$new_date1' ) as pig_use1,
                (select sum(tb_order_overnight.total_pig) from tb_order_overnight where tb_order_overnight.order_ref = lot_number and tb_order_overnight.date = '$new_date2' ) as pig_use2,
                (select sum(tb_order_overnight.total_pig) from tb_order_overnight where tb_order_overnight.order_ref = lot_number and tb_order_overnight.date = '$new_date3' ) as pig_use3,
                (select sum(tb_order_overnight.total_pig) from tb_order_overnight where tb_order_overnight.order_ref = lot_number and tb_order_overnight.date = '$new_date4' ) as pig_use4,
                (select sum(tb_order_overnight.total_pig) from tb_order_overnight where tb_order_overnight.order_ref = lot_number and tb_order_overnight.date = '$new_date5' ) as pig_use5
            FROM
                wg_sku_weight_data
                LEFT JOIN wg_scale ON wg_scale.scale_number = wg_sku_weight_data.scale_number 
                LEFT JOIN wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code
                LEFT JOIN tb_order ON wg_sku_weight_data.lot_number = tb_order.order_number
                LEFT JOIN wg_storage ON tb_order.storage_id = wg_storage.id_storage
            WHERE
                wg_sku_weight_data.lot_number IN ($order_rr) 
                AND wg_scale.department IN ( 1 ) 
            GROUP BY
                wg_sku_weight_data.lot_number
            " ,[]
        );

       
        return  view('stock.stock_daily_tt',compact('r_data_list','order_rr','date_format','balance','stock_recieve'));
    }
    public static function stock_daily_pl($date){
       
        return  view('stock.stock_daily_pl',compact('date'));
    }
    public static function stock_daily_of($date){
        $date_format = substr($date,0,2).'/'.substr($date,2,2).'/'.substr($date,4,4);

        return  view('stock.stock_daily_of',compact('date_format'));
    }

    public function stock_data_of_summay(Request $request){

        $mindate = substr($request->daterangeFilter,6,4).substr($request->daterangeFilter,3,2).substr($request->daterangeFilter,0,2);
        $maxdate = substr($request->daterangeFilter,19,4).substr($request->daterangeFilter,16,2).substr($request->daterangeFilter,13,2);
        
        $dateR =  substr($request->daterangeFilter,0,10);
        $order_ref_R = DB::select("SELECT
            tb_order_offal.order_number,
            tb_order_offal.order_ref,
            tb_order.total_pig 
            FROM
                tb_order_offal
                LEFT JOIN tb_order ON tb_order_offal.order_ref = tb_order.order_number 
            WHERE
                tb_order_offal.date = '$dateR' 
            GROUP BY
                tb_order_offal.order_ref
        ");

        $order_ref_R_str = "'"; 
        $sum_unit_R = 0;
        foreach ($order_ref_R as $key => $value) {
            $order_ref_R_str = $order_ref_R_str . $value->order_ref ."','";
            $sum_unit_R = $sum_unit_R + $value->total_pig ;
        }
        $order_ref_R_str = substr($order_ref_R_str, 0, -2);

        $weight_order_in_head = DB::select("SELECT 
                wg_sku_weight_data.id,
                wg_sku_weight_data.sku_code,
                wg_sku_weight_data.sku_amount,
                Sum( wg_sku_weight_data.sku_weight ) AS sum_weight,
                wg_sku_weight_data.sku_unit,
                wg_sku_weight_data.storage_name,
                wg_sku_weight_data.weighing_date,
                wg_sku_weight_data.scale_number,
                wg_sku_item.item_name,
                wg_sku_item.wg_sku_id,
                wg_scale.department,
                wg_sku.sku_name 
            FROM
                wg_sku_weight_data
                LEFT JOIN wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code
                LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                LEFT JOIN wg_sku ON wg_sku_item.wg_sku_id = wg_sku.id_wg_sku 
            WHERE
                DATE_FORMAT(wg_sku_weight_data.weighing_date,'%d/%m/%Y') = '$dateR' 
                AND wg_scale.department IN ( 4, 5 ) 
                AND wg_sku_weight_data.lot_number IN ($order_ref_R_str)
            GROUP BY
                wg_sku_weight_data.sku_code 
                ");

        $order_ref_OF = DB::select("SELECT
            tb_order_offal.order_number,
            tb_order_offal.order_ref,
            tb_order.total_pig 
            FROM
                tb_order_offal
                LEFT JOIN tb_order ON tb_order_offal.order_ref = tb_order.order_number 
            WHERE
                tb_order_offal.date = '$dateR' 
            GROUP BY
                tb_order_offal.order_number
        ");

        $order_OF_str = "'";
        foreach ($order_ref_OF as $key => $of_value) {
            $order_OF_str = $order_OF_str . $of_value->order_number ."','";
        }
        $order_OF_str = substr($order_OF_str, 0, -2);


        $weight_order_out_OF = DB::select("SELECT 
                wg_sku_weight_data.id,
                wg_sku_weight_data.sku_code,
                wg_sku_weight_data.sku_amount,
                Sum( wg_sku_weight_data.sku_weight ) AS sum_weight,
                wg_sku_weight_data.sku_unit,
                wg_sku_weight_data.storage_name,
                wg_sku_weight_data.weighing_date,
                wg_sku_weight_data.scale_number,
                wg_sku_item.item_name,
                wg_sku_item.wg_sku_id,
                wg_scale.department,
                wg_sku.sku_name 
            FROM
                wg_sku_weight_data
                LEFT JOIN wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code
                LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                LEFT JOIN wg_sku ON wg_sku_item.wg_sku_id = wg_sku.id_wg_sku 
            WHERE
                DATE_FORMAT(wg_sku_weight_data.weighing_date,'%d/%m/%Y') = '$dateR' 
                AND wg_scale.department IN ( 4, 5 ) 
                AND wg_sku_weight_data.lot_number IN ($order_OF_str)
            GROUP BY
                wg_sku_weight_data.sku_code 
        ");

        return array($order_ref_R_str,$order_ref_R,$weight_order_in_head,$sum_unit_R,$order_ref_OF,$weight_order_out_OF);

        $date_range = "AND ( CONCAT(SUBSTRING(wg_stock_log.date_recieve, 7, 4),SUBSTRING(wg_stock_log.date_recieve, 4, 2),SUBSTRING(wg_stock_log.date_recieve, 1, 2)) 
        BETWEEN '".$mindate."' AND '".$maxdate."' )";

        $stock = DB::select("SELECT
                                wg_stock_log.*
                            FROM
                                wg_stock_log
                                INNER JOIN tb_shop ON wg_stock_log.id_storage = tb_shop.id
                            WHERE
                                tb_shop.shop_code = 'PP' AND wg_stock_log.action = 'add'
                                ".$date_range."
                            ORDER BY wg_stock_log.id DESC
        ");

        $date_range2 = "AND ( CONCAT(SUBSTRING(tb_order.date, 7, 4),SUBSTRING(tb_order.date, 4, 2),SUBSTRING(tb_order.date, 1, 2)) 
        BETWEEN '".$mindate."' AND '".$maxdate."' )";

        $order_send2 = DB::select("SELECT
                                    tb_order.id,
                                    tb_order.order_number,
                                    tb_order.total_pig,
                                    tb_order.weight_range,
                                    tb_order.note,
                                    tb_order.date,
                                    tb_order.id_user_customer,
                                    tb_order.`status`,
                                    tb_order.marker,
                                    tb_order.round,
                                    tb_order.storage_id,
                                    tb_order.price,
                                    tb_order_type.order_type,
                                    wg_storage.name_storage,
                                    wg_storage.description,
                                    wg_sku_weight_data.sku_amount,
                                    wg_sku_weight_data.scale_number,
                                    wg_sku_weight_data.count_amount,
                                    wg_sku_weight_data.sum_weight
                                FROM
                                    tb_order
                                    LEFT JOIN tb_order_type ON tb_order.type_request = tb_order_type.id
                                    LEFT JOIN wg_storage ON tb_order.storage_id = wg_storage.id_storage
                                    LEFT JOIN (
                                        SELECT
                                            wg_sku_weight_data.*,
                                            Count( wg_sku_weight_data.sku_amount ) AS count_amount,
                                            SUM( wg_sku_weight_data.sku_weight ) AS sum_weight,
                                            wg_scale.department 
                                        FROM
                                            wg_sku_weight_data
                                            LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number 
                                        WHERE
                                            wg_scale.department = 1 
                                        GROUP BY
                                            wg_sku_weight_data.lot_number
                                    ) AS wg_sku_weight_data ON tb_order.order_number = wg_sku_weight_data.lot_number
                                WHERE tb_order_type.id = 3
                                     ".$date_range2."
                                ORDER BY
                                    tb_order.created_at DESC      
        ");

        $date_range2_del = "AND ( CONCAT(SUBSTRING(wg_stock_log.date_recieve, 7, 4),SUBSTRING(wg_stock_log.date_recieve, 4, 2),SUBSTRING(wg_stock_log.date_recieve, 1, 2)) 
        BETWEEN '".$mindate."' AND '".$maxdate."' )";

        $order_send2_del = DB::select("SELECT
                                    wg_stock_log.bill_number,
                                    wg_stock_log.id_storage,
                                    wg_stock_log.ref_source,
                                    wg_stock_log.total_unit,
                                    wg_stock_log.total_weight,
                                    wg_stock_log.note,
                                    wg_stock_log.action,
                                    wg_stock_log.date_recieve,
                                    wg_stock_log.total_price,
                                    wg_stock_log.unit_price
                                    FROM 
                                    wg_stock_log
                                    WHERE
                                    wg_stock_log.action = 'delete'
                                    ".$date_range2_del
        );


        $date_range3 = "AND ( CONCAT(SUBSTRING(tb_order.date, 7, 4),SUBSTRING(tb_order.date, 4, 2),SUBSTRING(tb_order.date, 1, 2)) 
        BETWEEN '".$mindate."' AND '".$maxdate."' )";

        $order_send3 = DB::select("SELECT
                                    tb_order.id,
                                    tb_order.order_number,
                                    tb_order.total_pig,
                                    tb_order.weight_range,
                                    tb_order.note,
                                    tb_order.date,
                                    tb_order.id_user_customer,
                                    tb_order.`status`,
                                    tb_order.marker,
                                    tb_order.round,
                                    tb_order.storage_id,
                                    tb_order.price,
                                    tb_order_type.order_type,
                                    wg_storage.name_storage,
                                    wg_storage.description,
                                    wg_sku_weight_data.sku_amount,
                                    wg_sku_weight_data.scale_number,
                                    wg_sku_weight_data.count_amount,
                                    wg_sku_weight_data.sum_weight
                                FROM
                                    tb_order
                                    LEFT JOIN tb_order_type ON tb_order.type_request = tb_order_type.id
                                    LEFT JOIN wg_storage ON tb_order.storage_id = wg_storage.id_storage
                                    LEFT JOIN (
                                        SELECT
                                            wg_sku_weight_data.*,
                                            Count( wg_sku_weight_data.sku_amount ) AS count_amount,
                                            SUM( wg_sku_weight_data.sku_weight ) AS sum_weight,
                                            wg_scale.department 
                                        FROM
                                            wg_sku_weight_data
                                            LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number 
                                        WHERE
                                            wg_scale.department = 1 
                                        GROUP BY
                                            wg_sku_weight_data.lot_number
                                    ) AS wg_sku_weight_data ON tb_order.order_number = wg_sku_weight_data.lot_number
                                WHERE tb_order_type.id IN (1,2)
                                     ".$date_range2."
                                ORDER BY
                                    tb_order.created_at DESC      
        ");

        // 2020-02-20 06:59:55 format
        $date_balance = substr($request->daterangeFilter,6,4).'-'.substr($request->daterangeFilter,3,2).'-'.substr($request->daterangeFilter,0,2).' '.'13:00:00';

        $balance = DB::select("SELECT
            wg_storage_daily.id,
            wg_storage_daily.id_storage,
            wg_storage_daily.name_storage,
            wg_storage_daily.count_unit,
            wg_storage_daily.count_unit_real as balance,
            wg_storage_daily.unit,
            wg_storage_daily.type_of_storage,
            wg_storage_daily.description,
            wg_storage_daily.user_id,
            wg_storage_daily.created_at,
            wg_storage_daily.updated_at,
            wg_storage_daily.zone,
            wg_storage_daily.date_summary,
            wg_storage_daily.weight_summary
            FROM
            wg_storage_daily
            WHERE
            wg_storage_daily.id_storage = '101' AND
            wg_storage_daily.date_summary = DATE_FORMAT(('$date_balance' - INTERVAL 1 DAY),'%d/%m/%Y')
            ORDER BY created_at LIMIT 1
        ");

        $mindate_check = substr($request->daterangeFilter,0,2)."/".substr($request->daterangeFilter,3,2)."/".substr($request->daterangeFilter,6,4);
        
        $check_count_stock = DB::select("SELECT
                                            wg_storage_daily.id,
                                            wg_storage_daily.id_storage,
                                            wg_storage_daily.name_storage,
                                            wg_storage_daily.count_unit,
                                            wg_storage_daily.count_unit_real,
                                            wg_storage_daily.unit,
                                            wg_storage_daily.type_of_storage,
                                            wg_storage_daily.description,
                                            wg_storage_daily.user_id,
                                            wg_storage_daily.created_at,
                                            wg_storage_daily.updated_at,
                                            wg_storage_daily.zone,
                                            wg_storage_daily.date_summary,
                                            wg_storage_daily.weight_summary
                                        FROM
                                            wg_storage_daily
                                        WHERE
                                            wg_storage_daily.id_storage = '101' AND
                                            wg_storage_daily.date_summary = '$mindate_check'"
        );

        return array($stock,$order_send2,$order_send3,$balance,$order_send2_del,$check_count_stock);
        return Datatables::of($stock)->addIndexColumn()->make(true);
    }

    public static function stock_daily_ov($date){
       
        return  view('stock.stock_daily_ov',compact('date'));
    }
    public static function stock_daily_cl($date){
       
        return  view('stock.stock_daily_cl',compact('date'));
    }
    public static function stock_daily_mr($date){
       
        return  view('stock.stock_daily_mr',compact('date'));
    }
    public static function stock_daily_dc($date){
       
        return  view('stock.stock_daily_dc',compact('date'));
    }
    // รายงาน stock daily 
    public static function stock_report_daily_all($date){
       
        return  view('stock.stock_all',compact('date'));
        
        $date_format = substr($date,0,2).'/'.substr($date,2,2).'/'.substr($date,4,4);
        $date_format1 = substr($date,2,2).'/'.substr($date,0,2).'/'.substr($date,4,4);

        $time = strtotime($date_format1);

        $new_date0 = date('d/m/Y', $time);
        $new_date1 = date('d/m/Y', $time - 86400);
        $new_date2 = date('d/m/Y', $time - 86400 - 86400);
        $new_date3 = date('d/m/Y', $time - 86400 - 86400 - 86400);
        $new_date4 = date('d/m/Y', $time - 86400 - 86400 - 86400 - 86400);
        $new_date5 = date('d/m/Y', $time - 86400 - 86400 - 86400 - 86400 - 86400);
        

        $get_r_order = DB::select("SELECT * FROM tb_order_overnight WHERE tb_order_overnight.date = '$date_format' 
            AND type_request = 3 GROUP BY order_ref"
        );

       

        $get_ov_order  = DB::select("SELECT
                    tb_order_overnight.order_group,
                    GROUP_CONCAT( tb_order_overnight.order_number SEPARATOR ' , ' ) AS group_order_number,
                    GROUP_CONCAT( tb_order_overnight.total_pig SEPARATOR ' , ' ) AS group_total_pig,
                    GROUP_CONCAT( tb_order_overnight.order_ref SEPARATOR ' , ' ) AS group_order_ref,
                    tb_order_overnight.date,
                    tb_order_overnight.id_user_customer 
                FROM
                    tb_order_overnight 
                WHERE
                    tb_order_overnight.date = '$date_format' 
                    AND tb_order_overnight.type_request = 3 
                GROUP BY
                    tb_order_overnight.order_group"
                
        );
        
        $order_rr = "";
        $order_ov = "";

        foreach ($get_r_order as $key => $value) { 
            $order_rr = $order_rr."'".$value->order_ref."',";
        }
        foreach ($get_ov_order as $key => $value) { 
            $order_ov = $order_ov."'".$value->order_group."',";
        }

        $order_rr = substr($order_rr, 0, -1);
        $order_ov = substr($order_ov, 0, -1);
        $order_rr_show = str_replace("'", "", $order_rr);
        $order_ov_show = str_replace("'", "", $order_ov);
       
        // return  $order_rr;
      
       
        //หมูขุน
        $r_data_list = DB::select("SELECT
                count( wg_sku_weight_data.sku_amount ) AS sum_unit,
                sum( wg_sku_weight_data.sku_weight ) AS sum_weight,
                wg_sku_weight_data.sku_code,
                wg_sku_weight_data.weighing_date,
                wg_sku_weight_data.lot_number,
                DATE_FORMAT( wg_sku_weight_data.weighing_date, '%d/%m/%Y' ) AS weighing_date,
                wg_sku_item.item_name,
                (select sum(tb_order_overnight.total_pig) from tb_order_overnight where tb_order_overnight.order_ref = lot_number and tb_order_overnight.date = '$new_date0' ) as pig_use,
                (select sum(tb_order_overnight.total_pig) from tb_order_overnight where tb_order_overnight.order_ref = lot_number and tb_order_overnight.date = '$new_date1' ) as pig_use1,
                (select sum(tb_order_overnight.total_pig) from tb_order_overnight where tb_order_overnight.order_ref = lot_number and tb_order_overnight.date = '$new_date2' ) as pig_use2,
                (select sum(tb_order_overnight.total_pig) from tb_order_overnight where tb_order_overnight.order_ref = lot_number and tb_order_overnight.date = '$new_date3' ) as pig_use3,
                (select sum(tb_order_overnight.total_pig) from tb_order_overnight where tb_order_overnight.order_ref = lot_number and tb_order_overnight.date = '$new_date4' ) as pig_use4,
                (select sum(tb_order_overnight.total_pig) from tb_order_overnight where tb_order_overnight.order_ref = lot_number and tb_order_overnight.date = '$new_date5' ) as pig_use5
            FROM
                wg_sku_weight_data
                LEFT JOIN wg_scale ON wg_scale.scale_number = wg_sku_weight_data.scale_number 
                LEFT JOIN wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code
            WHERE
                wg_sku_weight_data.lot_number IN ($order_rr) 
                AND wg_scale.department IN ( 1 ) 
            GROUP BY
                wg_sku_weight_data.lot_number
            " ,[]
        );

       //  return $r_data_list;
       // เตรียม order_r เพื่อไปหาน้ำหนักก่อนหน้านี้ 
       $order_list="";
        foreach ($r_data_list as $key => $value) { 
            $order_list = $order_list."'".$value->lot_number."',";
        }
        $order_list = substr($order_list, 0, -1);
       


        //เครื่องใน
        $offal_ref = Db::select("SELECT * from tb_order_offal where order_ref IN ($order_rr) group by order_number");
        $order_of = "";
        foreach ($offal_ref as $key => $value) { 
            $order_of = $order_of."'".$value->order_number."',";
        }
        $order_of = substr($order_of, 0, -1);
        
        $offal_data_list = DB::select("SELECT
                wg_sku_weight_data.sku_code,
                wg_sku_item.item_name,
                wg_sku_weight_data.id,
                wg_sku_weight_data.lot_number,
                sum( wg_sku_weight_data.sku_amount ) AS sum_unit,
                sum( wg_sku_weight_data.sku_weight ) AS sum_weight,
                wg_sku_weight_data.weighing_place,
                wg_sku_weight_data.scale_number,
                wg_sku_weight_data.user_name,
                wg_sku_weight_data.weighing_date,
                wg_sku_weight_data.note,
                wg_sku.sku_name AS sku_type,
                wg_weight_type.wg_type_name,
                wg_scale.location_scale,
                REPLACE ( wg_sku_weight_data.sku_code, ' ', '' ) AS sku_code,
                DATE_FORMAT( wg_sku_weight_data.weighing_date, '%d/%m/%Y' )
            FROM
                wg_sku_weight_data
                LEFT JOIN wg_sku ON wg_sku_weight_data.sku_id = wg_sku.id_wg_sku
                LEFT JOIN wg_weight_type ON wg_sku_weight_data.weighing_type = wg_weight_type.id_wg_type
                LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                RIGHT JOIN ( SELECT * FROM wg_sku_item WHERE wg_sku_item.group_show_report = 2 GROUP BY wg_sku_item.item_code ) AS wg_sku_item ON REPLACE ( wg_sku_weight_data.sku_code, ' ', '' ) = wg_sku_item.item_code 
            WHERE
                wg_sku_weight_data.lot_number IN ( $order_of ) 
                AND wg_scale.department IN ( 5,6 ) 
            GROUP BY
                REPLACE ( wg_sku_weight_data.sku_code, ' ', '' )
                " ,[]
        );

        //07 after overnight 
        $after_ov = DB::select("SELECT
                tb_order_overnight.order_group,
                tb_order_overnight.group_order_number,
                tb_order_overnight.group_total_pig,
                tb_order_overnight.group_order_ref,
                wg_sku_weight_data.lot_number,
                Count( wg_sku_weight_data.sku_amount ) AS sum_unit,
                Sum( wg_sku_weight_data.sku_weight ) AS sum_weight,
                wg_sku_weight_data.sku_code,
                wg_sku_weight_data.weighing_date,
                DATE_FORMAT( wg_sku_weight_data.weighing_date, '%d/%m/%Y' ) AS weighing_date,
                wg_sku_item.item_name 
            FROM
                wg_sku_weight_data
                LEFT JOIN wg_scale ON wg_scale.scale_number = wg_sku_weight_data.scale_number
                LEFT JOIN wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code
                RIGHT JOIN (
            SELECT
                tb_order_overnight.order_group,
                GROUP_CONCAT( tb_order_overnight.order_number SEPARATOR ' , ' ) AS group_order_number,
                GROUP_CONCAT( tb_order_overnight.total_pig SEPARATOR ' , ' ) AS group_total_pig,
                GROUP_CONCAT( tb_order_overnight.order_ref SEPARATOR ' , ' ) AS group_order_ref,
                tb_order_overnight.date,
                tb_order_overnight.id_user_customer 
            FROM
                tb_order_overnight 
            WHERE
                tb_order_overnight.date = '$date_format' 
                AND tb_order_overnight.type_request = 3 
            GROUP BY
                tb_order_overnight.order_group 
                ) AS tb_order_overnight ON wg_sku_weight_data.lot_number = tb_order_overnight.order_group 
            WHERE
                wg_scale.department IN ( 7 ) 
            GROUP BY
                wg_sku_weight_data.lot_number
            ORDER BY tb_order_overnight.group_order_ref
            "
        );
        // หาน้ำหนักก่อนแช่ ตั้งต้น จาก Order R ที่มีจำนวน มากว่า มา ใช้เป็นค่า เฉลี่ยน ต่อตัว  // 

        //ov exit cutting line
        $cutting_ref = Db::select("SELECT * from tb_order_cutting where `date` = '$date_format' AND marker = 'Z' ");

        $order_cl = "";
        $order_ov_cl ="";
        $order_ov_cl2 ="";

        foreach ($cutting_ref as $key => $cutting) { 
            $order_cl = $order_cl."'".$cutting->order_number."',";
        }        
        $order_cl = substr($order_cl, 0, -1);
        if(strlen($order_cl)>0)
        { 
          $order_ov_cl = $order_ov.",".$order_cl;
          $order_ov_cl2 = "(wg_sku_weight_data.lot_number IN ( $order_cl ) 
                            AND  wg_sku_weight_data.weighing_type = 11
                            ) OR
                            (wg_sku_weight_data.lot_number IN ( $order_ov ) 
                            AND wg_sku_weight_data.sku_code IN ('1032') 
                            )";
        }
        else
        {
          $order_ov_cl = $order_ov;
          $order_ov_cl2 = "(wg_sku_weight_data.lot_number IN ( $order_ov ) 
                            AND wg_sku_weight_data.sku_code IN ('1032') 
                            )";

        }
        $ov_data_list = DB::select("SELECT
                wg_sku_weight_data.sku_code,
                wg_sku_item.item_name,
                wg_sku_weight_data.id,
                wg_sku_weight_data.lot_number,
                sum( wg_sku_weight_data.sku_amount ) AS sum_unit,
                sum( wg_sku_weight_data.sku_weight ) AS sum_weight,
                wg_sku_weight_data.weighing_place,
                wg_sku_weight_data.scale_number,
                wg_sku_weight_data.user_name,
                wg_sku_weight_data.weighing_date,
                wg_sku_weight_data.note,
                wg_sku.sku_name AS sku_type,
                wg_sku_weight_data.weighing_type,
                wg_weight_type.wg_type_name,
                wg_scale.location_scale,
                REPLACE ( wg_sku_weight_data.sku_code, ' ', '' ) AS sku_code,
                DATE_FORMAT( wg_sku_weight_data.weighing_date, '%d/%m/%Y' )
            FROM
                wg_sku_weight_data
                LEFT JOIN wg_sku ON wg_sku_weight_data.sku_id = wg_sku.id_wg_sku
                LEFT JOIN wg_weight_type ON wg_sku_weight_data.weighing_type = wg_weight_type.id_wg_type
                LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                RIGHT JOIN ( SELECT * FROM wg_sku_item WHERE wg_sku_item.group_show_report = 1 GROUP BY wg_sku_item.item_code ) AS wg_sku_item ON REPLACE ( wg_sku_weight_data.sku_code, ' ', '' ) = wg_sku_item.item_code 
            WHERE
                wg_sku_weight_data.lot_number IN ( $order_ov_cl ) 
                AND wg_scale.scale_number IN ('KMK12','KMK09','KMK08') 
            GROUP BY
                REPLACE ( wg_sku_weight_data.sku_code, ' ', '' )
                " ,[]
        );


        $sp_data_list = DB::select("SELECT
                wg_sku_weight_data.sku_code,
                wg_sku_item.item_name,
                wg_sku_weight_data.id,
                wg_sku_weight_data.lot_number,
                sum( wg_sku_weight_data.sku_amount ) AS sum_unit,
                sum( wg_sku_weight_data.sku_weight ) AS sum_weight,
                wg_sku_weight_data.weighing_place,
                wg_sku_weight_data.scale_number,
                wg_sku_weight_data.user_name,
                wg_sku_weight_data.weighing_date,
                wg_sku_weight_data.note,
                wg_sku.sku_name AS sku_type,
                wg_sku_weight_data.weighing_type,
                wg_weight_type.wg_type_name,
                wg_scale.location_scale,
                REPLACE ( wg_sku_weight_data.sku_code, ' ', '' ) AS sku_code,
                DATE_FORMAT( wg_sku_weight_data.weighing_date, '%d/%m/%Y' )
            FROM
                wg_sku_weight_data
                LEFT JOIN wg_sku ON wg_sku_weight_data.sku_id = wg_sku.id_wg_sku
                LEFT JOIN wg_weight_type ON wg_sku_weight_data.weighing_type = wg_weight_type.id_wg_type
                LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                RIGHT JOIN ( SELECT * FROM wg_sku_item WHERE wg_sku_item.group_show_report = 1 GROUP BY wg_sku_item.item_code ) AS wg_sku_item ON REPLACE ( wg_sku_weight_data.sku_code, ' ', '' ) = wg_sku_item.item_code 
            WHERE " . $order_ov_cl2 . "
                 AND wg_scale.scale_number IN ('KMK11')                
            GROUP BY
                REPLACE ( wg_sku_weight_data.sku_code, ' ', '' )
                " ,[]
        );


        // return $sp_data_list;
        
        $order_rr_show = str_replace("'", "", $order_rr);
        $order_ov_show = str_replace("'", "", $order_ov);
        $order_cl_show = str_replace("'", "", $order_cl);
        $order_of_show = str_replace("'", "", $order_of);


        // start line เชือด  
        // $date_format1 = substr($date,0,2).'/'.substr($date,2,2).'/'.substr($date,4,4);
        // $get_r_order1 = DB::select("SELECT * from tb_order where `date` =  '$date_format1' AND type_request = 3 ");
        
        $get_r_order1 = DB::select("SELECT * from tb_order where order_number in($order_list)");
       // return $get_r_order1;
        $order_rr1 = "";
        $order_dd1 = "";
        foreach ($get_r_order1 as $key => $value) { 
            $order_rr1 = $order_rr1."'".$value->order_number."',";
            $order_dd1 = $order_dd1."'".$value->order_number." [".$value->date."] ',";
        }
        $order_rr1 = substr($order_rr1, 0, -1);
        $order_rr_show1 = str_replace("'", "", $order_rr1);
        $order_dd1 = substr($order_dd1, 0, -1);
        $order_dd_show1 = str_replace("'", "", $order_dd1);
        

        //หมูขุน
        $r_data_list1 = DB::select("SELECT
            wg_sku_weight_data.lot_number,
            wg_sku_weight_data.sku_id,
            wg_sku_weight_data.sku_code,
            wg_sku_item.item_name,
            Sum(wg_sku_weight_data.sku_amount) AS sum_unit,
            Sum(wg_sku_weight_data.sku_weight) AS sum_weight,
            wg_sku_weight_data.sku_unit,
            wg_sku_weight_data.weighing_type,
            wg_sku_weight_data.scale_number,
            wg_sku_weight_data.user_name,
            wg_sku_weight_data.weighing_ref,
            wg_sku_weight_data.weighing_date,
            wg_scale.department,
            tb_order.id_user_customer
            FROM
            wg_sku_weight_data
            LEFT JOIN wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code
            LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
            LEFT JOIN tb_order ON wg_sku_weight_data.lot_number = tb_order.order_number
            WHERE
            wg_sku_weight_data.lot_number IN ($order_rr1) AND
            wg_scale.department = 1
            GROUP BY
            wg_sku_weight_data.lot_number
            " ,[]
        );

        //เครื่องใน
        $offal_data_list1 = DB::select("SELECT
            wg_sku_weight_data.lot_number,
            wg_sku_weight_data.sku_id,
            wg_sku_weight_data.sku_code,
            wg_sku_item.item_name,
            Sum(wg_sku_weight_data.sku_amount) AS sum_unit,
            Sum(wg_sku_weight_data.sku_weight) AS sum_weight,
            wg_sku_weight_data.sku_unit,
            wg_sku_weight_data.weighing_type,
            wg_sku_weight_data.scale_number,
            wg_sku_weight_data.user_name,
            wg_sku_weight_data.weighing_ref,
            wg_sku_weight_data.weighing_date,
            wg_scale.department
            FROM
            wg_sku_weight_data
            LEFT JOIN wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code
            LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
            WHERE
            wg_sku_weight_data.lot_number IN ($order_rr1)  AND
            wg_scale.department IN (4,5,6)
            GROUP BY
            wg_sku_weight_data.sku_code
            " ,[]
        );

        //ตัดแต่ง
        $ov_data_list1 = DB::select("SELECT
                wg_sku_weight_data.lot_number,
                wg_sku_weight_data.sku_id,
                wg_sku_weight_data.sku_code,
                wg_sku_item.item_name,
                Sum( wg_sku_weight_data.sku_amount ) AS sum_unit,
                Sum( wg_sku_weight_data.sku_weight ) AS sum_weight,
                wg_sku_weight_data.sku_unit,
                wg_sku_weight_data.weighing_type,
                wg_sku_weight_data.scale_number,
                wg_sku_weight_data.user_name,
                wg_sku_weight_data.weighing_ref,
                wg_sku_weight_data.weighing_date,
                wg_scale.department 
            FROM
                wg_sku_weight_data
                LEFT JOIN wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code
                LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number 
            WHERE
                wg_sku_weight_data.lot_number IN ($order_rr1) 
                AND wg_scale.department IN ( 3 ) 
            GROUP BY
                wg_sku_weight_data.sku_code " ,[]
        );

        return  view('stock.stock_all',compact('date_format','order_rr_show','order_ov_show','order_cl_show','order_of_show',
        'r_data_list','offal_data_list','ov_data_list','after_ov','sp_data_list','order_rr_show1','order_dd_show1','r_data_list1','offal_data_list1','ov_data_list1'));
     
    }
    // stock main data 
    public function stock_main_data(){
        $data_stock = DB::select("SELECT
                                    wg_storage.id_storage,
                                    wg_storage.max_unit,
                                    wg_storage.current_unit,
                                    wg_storage.name_storage,
                                    wg_storage.type_of_storage,
                                    wg_storage.description,
                                    wg_storage.unit 
                                FROM
                                    wg_storage 
                                WHERE
                                    wg_storage.type_of_storage = 'คอกขาย' 
                                    AND wg_storage.description = 'คอกรวม'");

        $data_stock_wait_kill = DB::select("SELECT
                                    wg_storage.id_storage,
                                    wg_storage.max_unit,
                                    wg_storage.current_unit,
                                    wg_storage.name_storage,
                                    wg_storage.type_of_storage,
                                    wg_storage.description,
                                    wg_storage.unit 
                                FROM
                                    wg_storage 
                                WHERE
                                    wg_storage.type_of_storage = 'คอกเชือด' 
                                    AND wg_storage.description = 'คอกรวม'");

        $data_stock_ov = DB::select("SELECT
                                    wg_storage.id_storage,
                                    wg_storage.max_unit,
                                    wg_storage.current_unit,
                                    wg_storage.name_storage,
                                    wg_storage.type_of_storage,
                                    wg_storage.description,
                                    wg_storage.unit 
                                    FROM
                                    wg_storage 
                                    WHERE
                                    wg_storage.type_of_storage = 'Overnight' 
                                    AND wg_storage.description = 'Overnight รวม'");
        $entrails = DB::select("SELECT
                                    wg_storage.id_storage,
                                    wg_storage.max_unit,
                                    wg_storage.current_unit,
                                    wg_storage.name_storage,
                                    wg_storage.type_of_storage,
                                    wg_storage.description,
                                    wg_storage.unit 
                                FROM
                                    wg_storage 
                                WHERE
                                    (wg_storage.type_of_storage = 'เครื่องในขาว' 
                                    AND wg_storage.description = 'เครื่องในขาว รวม')
                                    OR 
                                    (wg_storage.type_of_storage = 'เครื่องในแดง + หัว'
                                    AND wg_storage.description = 'เครื่องในแดง + หัว รวม')");

        $data_stock_red = DB::select("SELECT
                                    wg_storage.id_storage,
                                    wg_storage.max_unit,
                                    wg_storage.current_unit,
                                    wg_storage.name_storage,
                                    wg_storage.type_of_storage,
                                    wg_storage.description,
                                    wg_storage.unit 
                                    FROM
                                    wg_storage 
                                    WHERE
                                    wg_storage.type_of_storage = 'เครื่องในแดง + หัว' 
                                    AND wg_storage.description = 'เครื่องในแดง + หัว รวม'");

        $data_stock_load = DB::select("SELECT
                                    wg_storage.id_storage,
                                    wg_storage.max_unit,
                                    wg_storage.current_unit,
                                    wg_storage.name_storage,
                                    wg_storage.type_of_storage,
                                    wg_storage.description,
                                    wg_storage.unit 
                                    FROM
                                    wg_storage 
                                    WHERE
                                    wg_storage.type_of_storage = 'รอโหลด' 
                                    AND wg_storage.description = 'รอโหลด รวม'");

	

        return array($data_stock,$data_stock_wait_kill,$data_stock_ov,$entrails,$data_stock_red,$data_stock_load);
    }

    // pp1 คอก1
    public function stock_data_pp1($stock_name){

        $sum_storage = DB::select("SELECT
            wg_storage_daily.id,
            wg_storage_daily.id_storage,
            wg_storage_daily.name_storage,
            wg_storage_daily.count_unit  as current_unit,
            wg_storage_daily.unit,
            wg_storage_daily.type_of_storage,
            wg_storage_daily.description,
            wg_storage_daily.user_id,
            wg_storage_daily.created_at,
            wg_storage_daily.updated_at,
            wg_storage_daily.zone,
            wg_storage_daily.date_summary,
            wg_storage_daily.weight_summary
            FROM
            wg_storage_daily
            WHERE
            wg_storage_daily.id_storage = '101' AND
            wg_storage_daily.date_summary = DATE_FORMAT((now()- INTERVAL 1 DAY),'%d/%m/%Y')
            ORDER BY created_at LIMIT 1
        ");

        $unit_today = DB::select("SELECT
                                    wg_stock_log.*,
                                    SUM(wg_stock_log.current_unit) as sum_unit_add,
                                    DATE_FORMAT( now( ), '%d/%m/%Y' ) AS date_today,
                                    wg_storage.type_of_storage,
                                    wg_storage.description 
                                FROM
                                    wg_stock_log
                                    LEFT JOIN wg_storage ON wg_stock_log.id_storage = wg_storage.id_storage 
                                WHERE
                                    wg_stock_log.date_recieve = DATE_FORMAT( now( ), '%d/%m/%Y' ) 
                                    AND wg_storage.type_of_storage = '$stock_name'
                                    AND wg_stock_log.action = 'add' ");

        $unit_release = DB::select("SELECT
                                wg_sku_weight_data.id,
                                wg_sku_weight_data.lot_number,
                                SUM(wg_sku_weight_data.sku_amount) sum_release,
                                wg_sku_weight_data.sku_weight,
                                wg_sku_weight_data.sku_unit,
                                wg_scale.process_number
                                FROM
                                wg_sku_weight_data
                                LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                                WHERE
                                DATE_FORMAT(wg_sku_weight_data.weighing_date,'%d/%m/%Y') = DATE_FORMAT(now(),'%d/%m/%Y')
                                AND wg_scale.process_number = 1 ");

        $order7days = DB::select("SELECT
                            tb_order.id,
                            tb_order.order_number,
                            tb_order.total_pig,
                            tb_order.weight_range,
                            tb_order.note,
                            tb_order.date,
                            tb_order.id_user_customer,
                            tb_order.`status`,
                            tb_order.marker,
                            tb_order.round,
                            tb_order.storage_id,
                            tb_order_type.order_type,
                            wg_storage.name_storage,
                            wg_storage.description 
                            FROM
                            tb_order
                            LEFT JOIN tb_order_type ON tb_order.type_request = tb_order_type.id
                            LEFT JOIN wg_storage ON tb_order.storage_id = wg_storage.id_storage 
                            WHERE
                            tb_order.type_request <> 4 
                            AND tb_order.created_at >= current_date - interval '7' day
                            ORDER BY
                            tb_order.created_at DESC");

        $order_process = DB::select("SELECT
                            tb_order.id,
                            tb_order.order_number,
                            sum(tb_order.total_pig) as sum_processing,
                            tb_order.weight_range
                            FROM
                            tb_order
                            WHERE
                            tb_order.type_request <> 4 
                            AND tb_order.date = DATE_FORMAT(now(),'%d/%m/%Y')
                            ORDER BY
                            tb_order.created_at DESC");

        $product = DB::select("SELECT id,order_type as product_name from tb_order_type where `type`= 'รับหมู' ");
        $storage = DB::select("SELECT id,shop_code,shop_name from tb_shop where shop_description = 'โรงงาน' And shop_name = '$stock_name' ");


        return view('stock.stock_data_pp1',compact('stock_name','sum_storage','unit_today','unit_release','order7days','order_process','product','storage'));
    }

    public function show_add_form($stock_name){

        
        $product = DB::select("SELECT id,order_type as product_name from tb_order_type where `type`= 'รับหมู' ");
        $storage = DB::select("SELECT id,shop_code,shop_name from tb_shop where shop_description = 'โรงงาน' And shop_name = '$stock_name' ");


        return view('stock.add_pig',compact('product','storage','stock_name'));
    }

    public function stock_pp1_receive(Request $request){

        $mindate = substr($request->daterangeFilter,6,4).substr($request->daterangeFilter,3,2).substr($request->daterangeFilter,0,2);
        $maxdate = substr($request->daterangeFilter,19,4).substr($request->daterangeFilter,16,2).substr($request->daterangeFilter,13,2);
        
        $date_range = "AND ( CONCAT(SUBSTRING(wg_stock_log.date_recieve, 7, 4),SUBSTRING(wg_stock_log.date_recieve, 4, 2),SUBSTRING(wg_stock_log.date_recieve, 1, 2)) 
        BETWEEN '".$mindate."' AND '".$maxdate."' )";

        $stock = DB::select("SELECT
                                wg_stock_log.*
                            FROM
                                wg_stock_log
                                INNER JOIN tb_shop ON wg_stock_log.id_storage = tb_shop.id
                            WHERE
                                tb_shop.shop_code = 'PP' AND wg_stock_log.action = 'add'
                                ".$date_range."
                            ORDER BY wg_stock_log.id DESC
        ");

        $date_range2 = "AND ( CONCAT(SUBSTRING(tb_order.date, 7, 4),SUBSTRING(tb_order.date, 4, 2),SUBSTRING(tb_order.date, 1, 2)) 
        BETWEEN '".$mindate."' AND '".$maxdate."' )";

        $order_send2 = DB::select("SELECT
                                    tb_order.id,
                                    tb_order.order_number,
                                    tb_order.total_pig,
                                    tb_order.weight_range,
                                    tb_order.note,
                                    tb_order.date,
                                    tb_order.id_user_customer,
                                    tb_order.`status`,
                                    tb_order.marker,
                                    tb_order.round,
                                    tb_order.storage_id,
                                    tb_order.price,
                                    tb_order_type.order_type,
                                    wg_storage.name_storage,
                                    wg_storage.description,
                                    wg_sku_weight_data.sku_amount,
                                    wg_sku_weight_data.scale_number,
                                    wg_sku_weight_data.count_amount,
                                    wg_sku_weight_data.sum_weight
                                FROM
                                    tb_order
                                    LEFT JOIN tb_order_type ON tb_order.type_request = tb_order_type.id
                                    LEFT JOIN wg_storage ON tb_order.storage_id = wg_storage.id_storage
                                    LEFT JOIN (
                                        SELECT
                                            wg_sku_weight_data.*,
                                            Count( wg_sku_weight_data.sku_amount ) AS count_amount,
                                            SUM( wg_sku_weight_data.sku_weight ) AS sum_weight,
                                            wg_scale.department 
                                        FROM
                                            wg_sku_weight_data
                                            LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number 
                                        WHERE
                                            wg_scale.department = 1 
                                        GROUP BY
                                            wg_sku_weight_data.lot_number
                                    ) AS wg_sku_weight_data ON tb_order.order_number = wg_sku_weight_data.lot_number
                                WHERE tb_order_type.id = 3
                                     ".$date_range2."
                                ORDER BY
                                    tb_order.created_at DESC      
        ");

        $date_range2_del = "AND ( CONCAT(SUBSTRING(wg_stock_log.date_recieve, 7, 4),SUBSTRING(wg_stock_log.date_recieve, 4, 2),SUBSTRING(wg_stock_log.date_recieve, 1, 2)) 
        BETWEEN '".$mindate."' AND '".$maxdate."' )";

        $order_send2_del = DB::select("SELECT
                                    wg_stock_log.bill_number,
                                    wg_stock_log.id_storage,
                                    wg_stock_log.ref_source,
                                    wg_stock_log.total_unit,
                                    wg_stock_log.total_weight,
                                    wg_stock_log.note,
                                    wg_stock_log.action,
                                    wg_stock_log.date_recieve,
                                    wg_stock_log.total_price,
                                    wg_stock_log.unit_price
                                    FROM 
                                    wg_stock_log
                                    WHERE
                                    wg_stock_log.action = 'delete'
                                    ".$date_range2_del
        );


        $date_range3 = "AND ( CONCAT(SUBSTRING(tb_order.date, 7, 4),SUBSTRING(tb_order.date, 4, 2),SUBSTRING(tb_order.date, 1, 2)) 
        BETWEEN '".$mindate."' AND '".$maxdate."' )";

        $order_send3 = DB::select("SELECT
                                    tb_order.id,
                                    tb_order.order_number,
                                    tb_order.total_pig,
                                    tb_order.weight_range,
                                    tb_order.note,
                                    tb_order.date,
                                    tb_order.id_user_customer,
                                    tb_order.`status`,
                                    tb_order.marker,
                                    tb_order.round,
                                    tb_order.storage_id,
                                    tb_order.price,
                                    tb_order_type.order_type,
                                    wg_storage.name_storage,
                                    wg_storage.description,
                                    wg_sku_weight_data.sku_amount,
                                    wg_sku_weight_data.scale_number,
                                    wg_sku_weight_data.count_amount,
                                    wg_sku_weight_data.sum_weight
                                FROM
                                    tb_order
                                    LEFT JOIN tb_order_type ON tb_order.type_request = tb_order_type.id
                                    LEFT JOIN wg_storage ON tb_order.storage_id = wg_storage.id_storage
                                    LEFT JOIN (
                                        SELECT
                                            wg_sku_weight_data.*,
                                            Count( wg_sku_weight_data.sku_amount ) AS count_amount,
                                            SUM( wg_sku_weight_data.sku_weight ) AS sum_weight,
                                            wg_scale.department 
                                        FROM
                                            wg_sku_weight_data
                                            LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number 
                                        WHERE
                                            wg_scale.department = 1 
                                        GROUP BY
                                            wg_sku_weight_data.lot_number
                                    ) AS wg_sku_weight_data ON tb_order.order_number = wg_sku_weight_data.lot_number
                                WHERE tb_order_type.id IN (1,2)
                                     ".$date_range2."
                                ORDER BY
                                    tb_order.created_at DESC      
        ");

        // 2020-02-20 06:59:55 format
        $date_balance = substr($request->daterangeFilter,6,4).'-'.substr($request->daterangeFilter,3,2).'-'.substr($request->daterangeFilter,0,2).' '.'13:00:00';

        $balance = DB::select("SELECT
            wg_storage_daily.id,
            wg_storage_daily.id_storage,
            wg_storage_daily.name_storage,
            wg_storage_daily.count_unit,
            wg_storage_daily.count_unit_real as balance,
            wg_storage_daily.unit,
            wg_storage_daily.type_of_storage,
            wg_storage_daily.description,
            wg_storage_daily.user_id,
            wg_storage_daily.created_at,
            wg_storage_daily.updated_at,
            wg_storage_daily.zone,
            wg_storage_daily.date_summary,
            wg_storage_daily.weight_summary
            FROM
            wg_storage_daily
            WHERE
            wg_storage_daily.id_storage = '101' AND
            wg_storage_daily.date_summary = DATE_FORMAT(('$date_balance' - INTERVAL 1 DAY),'%d/%m/%Y')
            ORDER BY created_at LIMIT 1
        ");

        $mindate_check = substr($request->daterangeFilter,0,2)."/".substr($request->daterangeFilter,3,2)."/".substr($request->daterangeFilter,6,4);
        
        $check_count_stock = DB::select("SELECT
                                            wg_storage_daily.id,
                                            wg_storage_daily.id_storage,
                                            wg_storage_daily.name_storage,
                                            wg_storage_daily.count_unit,
                                            wg_storage_daily.count_unit_real,
                                            wg_storage_daily.unit,
                                            wg_storage_daily.type_of_storage,
                                            wg_storage_daily.description,
                                            wg_storage_daily.user_id,
                                            wg_storage_daily.created_at,
                                            wg_storage_daily.updated_at,
                                            wg_storage_daily.zone,
                                            wg_storage_daily.date_summary,
                                            wg_storage_daily.weight_summary
                                        FROM
                                            wg_storage_daily
                                        WHERE
                                            wg_storage_daily.id_storage = '101' AND
                                            wg_storage_daily.date_summary = '$mindate_check'"
        );

        return array($stock,$order_send2,$order_send3,$balance,$order_send2_del,$check_count_stock);
        return Datatables::of($stock)->addIndexColumn()->make(true);
    }
    public function stock_pp1_send(Request $request){

        $mindate = substr($request->orderFilter,6,4).substr($request->orderFilter,3,2).substr($request->orderFilter,0,2);
        $maxdate = substr($request->orderFilter,19,4).substr($request->orderFilter,16,2).substr($request->orderFilter,13,2);
        
        $date_range = "WHERE ( CONCAT(SUBSTRING(tb_order.date, 7, 4),SUBSTRING(tb_order.date, 4, 2),SUBSTRING(tb_order.date, 1, 2)) 
        BETWEEN '".$mindate."' AND '".$maxdate."' )";

        $order_send = DB::select("SELECT
                                    tb_order.id,
                                    tb_order.order_number,
                                    tb_order.total_pig,
                                    tb_order.weight_range,
                                    tb_order.note,
                                    tb_order.date,
                                    tb_order.id_user_customer,
                                    tb_order.`status`,
                                    tb_order.marker,
                                    tb_order.round,
                                    tb_order.storage_id,
                                    tb_order_type.order_type,
                                    wg_storage.name_storage,
                                    wg_storage.description,
                                    wg_sku_weight_data.sku_amount,
                                    wg_sku_weight_data.scale_number,
                                    wg_sku_weight_data.count_amount 
                                FROM
                                    tb_order
                                    LEFT JOIN tb_order_type ON tb_order.type_request = tb_order_type.id
                                    LEFT JOIN wg_storage ON tb_order.storage_id = wg_storage.id_storage
                                    LEFT JOIN (
                                        SELECT
                                            wg_sku_weight_data.*,
                                            Count( wg_sku_weight_data.sku_amount ) AS count_amount,
                                            wg_scale.department 
                                        FROM
                                            wg_sku_weight_data
                                            LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number 
                                        WHERE
                                            wg_scale.department = 1 
                                        GROUP BY
                                            wg_sku_weight_data.lot_number
                                    ) AS wg_sku_weight_data ON tb_order.order_number = wg_sku_weight_data.lot_number ".$date_range." 
                                ORDER BY
                                    tb_order.created_at DESC      
                            ");
        
        return Datatables::of($order_send)->addIndexColumn()->make(true);
    }
    public function pigpen_summary(Request $request){ 
        //  return $request;       

        if($request->id_storage == '101'){
            $check = DB::select("SELECT * FROM wg_storage_daily WHERE wg_storage_daily.date_summary = '$request->date_summary' AND wg_storage_daily.id_storage = '101'");
            if($check != null){
                DB::update("UPDATE wg_storage_daily SET id_storage=?,name_storage=?,count_unit=?,created_at=?,date_summary=?,weight_summary=?,count_unit_real=?,description=?
                 WHERE wg_storage_daily.id=?",['101','PP',$request->count_weight_summary,
                now(),$request->date_summary,$request->count_wegiht_summary_real,$request->count_pig_summary_real,$request->note,$check[0]->id]);
            }else{
                DB::insert("INSERT INTO wg_storage_daily(id_storage,name_storage,count_unit,
                created_at,date_summary,weight_summary,count_unit_real,description) value(?,?,?,?,?,?,?,?)",
                ['101','PP',$request->count_weight_summary,
                now(),$request->date_summary,$request->count_wegiht_summary_real,$request->count_pig_summary_real,$request->note]);
            } 
        }
        if($request->id_storage == '102'){
            $check = DB::select("SELECT * FROM wg_storage_daily WHERE wg_storage_daily.date_summary = '$request->date_summary' AND wg_storage_daily.id_storage = '102'");
            if($check != null){
                DB::update("UPDATE wg_storage_daily SET id_storage=?,name_storage=?,count_unit=?,created_at=?,date_summary=?,weight_summary=?,count_unit_real=?,description=?
                 WHERE wg_storage_daily.id=?",['102','PP2',$request->count_weight_summary,
                now(),$request->date_summary,$request->count_wegiht_summary_real,$request->count_pig_summary_real,$request->note,$check[0]->id]);
            }else{
                DB::insert("INSERT INTO wg_storage_daily(id_storage,name_storage,count_unit,
                created_at,date_summary,weight_summary,count_unit_real,description) value(?,?,?,?,?,?,?,?)",
                ['102','PP2',$request->count_weight_summary,
                now(),$request->date_summary,$request->count_wegiht_summary_real,$request->count_pig_summary_real,$request->note]);
            } 
            // DB::insert("INSERT INTO wg_storage_daily(id_storage,name_storage,count_unit,
            // created_at,date_summary,weight_summary,count_unit_real) value(?,?,?,?,?,?,?)",
            // ['102','PP2',$request->count_pig_summary_real,
            // now(),$request->date_summary,0,$request->count_pig_summary_real]);
        }
        if($request->id_storage == '103'){
            $check = DB::select("SELECT * FROM wg_storage_daily WHERE wg_storage_daily.date_summary = '$request->date_summary' AND wg_storage_daily.id_storage = '103'");
            if($check != null){
                DB::update("UPDATE wg_storage_daily SET id_storage=?,name_storage=?,count_unit=?,created_at=?,date_summary=?,weight_summary=?,count_unit_real=?,description=?
                 WHERE wg_storage_daily.id=?",['103','OV',$request->count_weight_summary,
                now(),$request->date_summary,$request->count_wegiht_summary_real,$request->count_pig_summary_real,$request->note,$check[0]->id]);
            }else{
                DB::insert("INSERT INTO wg_storage_daily(id_storage,name_storage,count_unit,
                created_at,date_summary,weight_summary,count_unit_real,description) value(?,?,?,?,?,?,?,?)",
                ['103','OV',$request->count_weight_summary,
                now(),$request->date_summary,$request->count_wegiht_summary_real,$request->count_pig_summary_real,$request->note]);
            } 
            // DB::insert("INSERT INTO wg_storage_daily(id_storage,name_storage,count_unit,
            // created_at,date_summary,weight_summary,count_unit_real) value(?,?,?,?,?,?,?)",
            // ['103','OV',$request->count_pig_summary_real,
            // now(),$request->date_summary,0,$request->count_pig_summary_real]);
        }
        if($request->id_storage == '104'){
            $check = DB::select("SELECT * FROM wg_storage_daily WHERE wg_storage_daily.date_summary = '$request->date_summary' AND wg_storage_daily.id_storage = '104'");
            if($check != null){
                DB::update("UPDATE wg_storage_daily SET id_storage=?,name_storage=?,count_unit=?,created_at=?,date_summary=?,weight_summary=?,count_unit_real=?,description=?
                 WHERE wg_storage_daily.id=?",['104','เครื่องใน',$request->count_weight_summary,
                now(),$request->date_summary,$request->count_wegiht_summary_real,$request->count_pig_summary_real,$request->note,$check[0]->id]);
            }else{
                DB::insert("INSERT INTO wg_storage_daily(id_storage,name_storage,count_unit,
                created_at,date_summary,weight_summary,count_unit_real,description) value(?,?,?,?,?,?,?,?)",
                ['104','เครื่องใน',$request->count_weight_summary,
                now(),$request->date_summary,$request->count_wegiht_summary_real,$request->count_pig_summary_real,$request->note]);
            } 
            // DB::insert("INSERT INTO wg_storage_daily(id_storage,name_storage,count_unit,
            // created_at,date_summary,weight_summary,count_unit_real) value(?,?,?,?,?,?,?)",
            // ['103','OV',$request->count_pig_summary_real,
            // now(),$request->date_summary,0,$request->count_pig_summary_real]);
        }
        if($request->id_storage == '106'){
            $check = DB::select("SELECT * FROM wg_storage_daily WHERE wg_storage_daily.date_summary = '$request->date_summary' AND wg_storage_daily.id_storage = '106'");
            if($check != null){
                DB::update("UPDATE wg_storage_daily SET id_storage=?,name_storage=?,count_unit=?,created_at=?,date_summary=?,weight_summary=?,count_unit_real=?,description=?
                 WHERE wg_storage_daily.id=?",['106','DC',$request->count_weight_summary,
                now(),$request->date_summary,$request->count_wegiht_summary_real,$request->count_pig_summary_real,$request->note,$check[0]->id]);
            }else{
                DB::insert("INSERT INTO wg_storage_daily(id_storage,name_storage,count_unit,
                created_at,date_summary,weight_summary,count_unit_real,description) value(?,?,?,?,?,?,?,?)",
                ['106','DC',$request->count_weight_summary,
                now(),$request->date_summary,$request->count_wegiht_summary_real,$request->count_pig_summary_real,$request->note]);
            } 
            // DB::insert("INSERT INTO wg_storage_daily(id_storage,name_storage,count_unit,
            // created_at,date_summary,weight_summary,count_unit_real) value(?,?,?,?,?,?,?)",
            // ['103','OV',$request->count_pig_summary_real,
            // now(),$request->date_summary,0,$request->count_pig_summary_real]);
        }

        if($request->id_storage != '101' || $request->id_storage != '102' || $request->id_storage != '103' || $request->id_storage != '104' || $request->id_storage != '106'){
            // return $request; 
            $check = DB::select("SELECT * FROM wg_storage_daily WHERE wg_storage_daily.date_summary = '$request->date_summary' AND wg_storage_daily.id_storage = '$request->id_storage'");
            if($check != null){
                DB::update("UPDATE wg_storage_daily SET id_storage=?,name_storage=?,count_unit=?,created_at=?,date_summary=?,weight_summary=?,count_unit_real=?,description=?
                 WHERE wg_storage_daily.id=?",[$request->id_storage,$request->id_storage,$request->count_weight_summary,
                now(),$request->date_summary,$request->count_wegiht_summary_real,$request->count_pig_summary_real,$request->note,$check[0]->id]);
            }else{
                DB::insert("INSERT INTO wg_storage_daily(id_storage,name_storage,count_unit,
                created_at,date_summary,weight_summary,count_unit_real,description) value(?,?,?,?,?,?,?,?)",
                [$request->id_storage,$request->id_storage,$request->count_weight_summary,
                now(),$request->date_summary,$request->count_wegiht_summary_real,$request->count_pig_summary_real,$request->note]);
            } 
                // return $check;
        }
        
        return back();

    }

    public function stock_data_ov2($stock_name){

        $sum_storage = DB::select("SELECT
            wg_storage_daily.id,
            wg_storage_daily.id_storage,
            wg_storage_daily.name_storage,
            wg_storage_daily.count_unit  as current_unit,
            wg_storage_daily.unit,
            wg_storage_daily.type_of_storage,
            wg_storage_daily.description,
            wg_storage_daily.user_id,
            wg_storage_daily.created_at,
            wg_storage_daily.updated_at,
            wg_storage_daily.zone,
            wg_storage_daily.date_summary,
            wg_storage_daily.weight_summary
            FROM
            wg_storage_daily
            WHERE
            wg_storage_daily.id_storage = '101' AND
            wg_storage_daily.date_summary = DATE_FORMAT((now()- INTERVAL 1 DAY),'%d/%m/%Y')
            ORDER BY created_at LIMIT 1
        ");

        $unit_today = DB::select("SELECT
                                    wg_stock_log.*,
                                    SUM(wg_stock_log.current_unit) as sum_unit_add,
                                    DATE_FORMAT( now( ), '%d/%m/%Y' ) AS date_today,
                                    wg_storage.type_of_storage,
                                    wg_storage.description 
                                FROM
                                    wg_stock_log
                                    LEFT JOIN wg_storage ON wg_stock_log.id_storage = wg_storage.id_storage 
                                WHERE
                                    wg_stock_log.date_recieve = DATE_FORMAT( now( ), '%d/%m/%Y' ) 
                                    AND wg_storage.type_of_storage = '$stock_name'
                                    AND wg_stock_log.action = 'add' ");

        $unit_release = DB::select("SELECT
                                wg_sku_weight_data.id,
                                wg_sku_weight_data.lot_number,
                                SUM(wg_sku_weight_data.sku_amount) sum_release,
                                wg_sku_weight_data.sku_weight,
                                wg_sku_weight_data.sku_unit,
                                wg_scale.process_number
                                FROM
                                wg_sku_weight_data
                                LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                                WHERE
                                DATE_FORMAT(wg_sku_weight_data.weighing_date,'%d/%m/%Y') = DATE_FORMAT(now(),'%d/%m/%Y')
                                AND wg_scale.process_number = 1 ");

        $order7days = DB::select("SELECT
                            tb_order.id,
                            tb_order.order_number,
                            tb_order.total_pig,
                            tb_order.weight_range,
                            tb_order.note,
                            tb_order.date,
                            tb_order.id_user_customer,
                            tb_order.`status`,
                            tb_order.marker,
                            tb_order.round,
                            tb_order.storage_id,
                            tb_order_type.order_type,
                            wg_storage.name_storage,
                            wg_storage.description 
                            FROM
                            tb_order
                            LEFT JOIN tb_order_type ON tb_order.type_request = tb_order_type.id
                            LEFT JOIN wg_storage ON tb_order.storage_id = wg_storage.id_storage 
                            WHERE
                            tb_order.type_request <> 4 
                            AND tb_order.created_at >= current_date - interval '7' day
                            ORDER BY
                            tb_order.created_at DESC");

       $order_process = DB::select("SELECT
                            tb_order.id,
                            tb_order.order_number,
                            sum(tb_order.total_pig) as sum_processing,
                            tb_order.weight_range
                            FROM
                            tb_order
                            WHERE
                            tb_order.type_request <> 4 
                            AND tb_order.date = DATE_FORMAT(now(),'%d/%m/%Y')
                            ORDER BY
                            tb_order.created_at DESC");

        $product = DB::select("SELECT id,order_type as product_name from tb_order_type where `type`= 'รับหมู' ");
        $storage = DB::select("SELECT id,shop_code,shop_name from tb_shop where shop_description = 'โรงงาน' And shop_name = '$stock_name' ");


        return view('stock.stock_data_ov2',compact('stock_name','sum_storage','unit_today','unit_release','order7days','order_process','product','storage'));
    }
    public function stock_ov2_receive(Request $request){
        
        $mindate = substr($request->daterangeFilter,6,4).substr($request->daterangeFilter,3,2).substr($request->daterangeFilter,0,2);
        $maxdate = substr($request->daterangeFilter,19,4).substr($request->daterangeFilter,16,2).substr($request->daterangeFilter,13,2);
        
        $date_range = "WHERE ( CONCAT(SUBSTRING(tb_product_plan.plan_slice , 7, 4),SUBSTRING(tb_product_plan.plan_slice , 4, 2),SUBSTRING(tb_product_plan.plan_slice , 1, 2)) 
        BETWEEN '".$mindate."' AND '".$maxdate."' )";

        $date_range2 = "AND ( CONCAT(SUBSTRING(wg_stock_log.date_recieve, 7, 4),SUBSTRING(wg_stock_log.date_recieve, 4, 2),SUBSTRING(wg_stock_log.date_recieve, 1, 2)) 
        BETWEEN '".$mindate."' AND '".$maxdate."' )";

        $order_receive = DB::select("SELECT
                                tb_order.id,
                                tb_order.order_number,
                                tb_order.total_pig,
                                tb_order.weight_range,
                                tb_order.type_request,
                                tb_order.round,
                                tb_order.note,
                                tb_order.date,
                                tb_order.customer_id,
                                tb_order.id_user_customer,
                                tb_order.marker,
                                tb_order.storage_id,
                                tb_order.check_order,
                                tb_order.id_user_provider,
                                tb_order.id_user_sender,
                                tb_order.id_user_recieve,
                                tb_order.`status`,
                                tb_order.created_at,
                                tb_order.current_lot,
                                tb_order.current_pig,
                                tb_order.price,
                                tb_order.current_offal,
                                tb_product_plan.plan_slice,
                                sum( wg_sku_weight_data.sku_weight ) AS total_weight 
                            FROM
                                tb_order
                                LEFT JOIN tb_product_plan ON tb_order.order_number = tb_product_plan.order_number
                                LEFT JOIN wg_sku_weight_data ON tb_order.order_number = wg_sku_weight_data.lot_number 
                                ".$date_range."
                            GROUP BY
                                tb_order.order_number   
                            ");

            $order_stock_create = DB::select("SELECT
                                wg_stock_log.*
                            FROM
                                wg_stock_log
                                INNER JOIN tb_shop ON wg_stock_log.id_storage = tb_shop.id
                            WHERE
                                tb_shop.shop_code = 'OV'
                                ".$date_range2."
                            ORDER BY wg_stock_log.id DESC");      
                            
            return array($order_stock_create,$order_receive);

            return Datatables::of($order_receive)->addIndexColumn()->make(true);
    }

    // pp2 คอก2
    public function stock_data_pp2($stock_name){
        
        $stock_name == 'คอกเชือด' ? $stock_name_tmp = 'PP' : $stock_name_tmp = $stock_name;

        $stock = DB::select("SELECT
                                wg_sku_weight_data.id,
                                wg_sku_weight_data.lot_number,
                                wg_sku_weight_data.sku_code,
                                Sum( wg_sku_weight_data.sku_amount ) AS sum_sku_amount,
                                Sum( wg_sku_weight_data.sku_weight ) AS sum_sku_weight,
                                wg_sku_weight_data.weighing_type,
                                wg_sku_weight_data.weighing_place,
                                wg_sku_weight_data.scale_number,
                                wg_sku_weight_data.storage_name,
                                wg_sku_weight_data.storage_compartment,
                                wg_sku_weight_data.weighing_ref,
                                wg_sku_weight_data.weighing_date,
                                wg_sku_weight_data.note,
                                wg_sku_weight_data.process_number,
                                wg_sku_item.item_name,
                                tb_order.total_pig,
                                DATE_FORMAT( wg_sku_weight_data.weighing_date, '%d/%m/%Y' ) AS date_,
                                tb_order.type_request 
                            FROM
                                wg_sku_weight_data
                                LEFT JOIN wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code
                                LEFT JOIN tb_order ON wg_sku_weight_data.lot_number = tb_order.order_number 
                            WHERE
                                wg_sku_weight_data.storage_name = '$stock_name_tmp' 
                                AND wg_sku_weight_data.weighing_date >= CURRENT_DATE - INTERVAL '7' DAY 
                                AND tb_order.type_request <> 1 	--   ไม่ใช่หมูขุน
                            GROUP BY
                                wg_sku_weight_data.lot_number");

        $sum_storage = DB::select("SELECT
                                wg_storage.id_storage,
                                wg_storage.name_storage,
                                wg_storage.max_unit,
                                wg_storage.current_unit,
                                wg_storage.unit,
                                wg_storage.type_of_storage,
                                wg_storage.description,
                                wg_storage.user_id,
                                wg_storage.created_at,
                                wg_storage.updated_at,
                                wg_storage.zone
                                FROM
                                wg_storage
                                WHERE wg_storage.description IN ('คอกรวม','คอกรวม','Overnight รวม','เครื่องในขาว รวม','เครื่องในแดง + หัว รวม','รอโหลด รวม')");

        $unit_today = DB::select("SELECT
                                    wg_stock_log.*,
                                    SUM(wg_stock_log.current_unit) as sum_unit_add,
                                    DATE_FORMAT( now( ), '%d/%m/%Y' ) AS date_today,
                                    wg_storage.type_of_storage,
                                    wg_storage.description 
                                FROM
                                    wg_stock_log
                                    LEFT JOIN wg_storage ON wg_stock_log.id_storage = wg_storage.id_storage 
                                WHERE
                                    wg_stock_log.date_recieve = DATE_FORMAT( now( ), '%d/%m/%Y' ) 
                                    AND wg_storage.type_of_storage = '$stock_name'
                                    AND wg_stock_log.action = 'add' ");
        $order_send = DB::select("SELECT
                                tb_order.id,
                                tb_order.order_number,
                                wg_sku_weight_data.sku_amount,
                                wg_sku_weight_data.scale_number,
                                sum( wg_sku_weight_data.count_amount ) AS sum_unit_add 
                            FROM
                                tb_order
                                LEFT JOIN tb_order_type ON tb_order.type_request = tb_order_type.id
                                LEFT JOIN wg_storage ON tb_order.storage_id = wg_storage.id_storage
                                LEFT JOIN (
                            SELECT
                                wg_sku_weight_data.*,
                                Count( wg_sku_weight_data.sku_amount ) AS count_amount,
                                wg_scale.department 
                            FROM
                                wg_sku_weight_data
                                LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number 
                            WHERE
                                wg_scale.department = 1 
                            GROUP BY
                                wg_sku_weight_data.lot_number 
                                ) AS wg_sku_weight_data ON tb_order.order_number = wg_sku_weight_data.lot_number 
                            WHERE
                                tb_order.date = DATE_FORMAT( now( ), '%d/%m/%Y' ) 
                            ORDER BY
                                tb_order.created_at DESC
                        ");

        $unit_release = DB::select("SELECT
                                    wg_sku_weight_data.sku_amount,
                                    wg_sku_weight_data.scale_number,
                                    wg_sku_weight_data.count_amount,
                                    tb_product_plan.plan_slice,
                                    NOW()
                                FROM
                                    tb_order
                                    LEFT JOIN tb_order_type ON tb_order.type_request = tb_order_type.id
                                    LEFT JOIN wg_storage ON tb_order.storage_id = wg_storage.id_storage
                                    LEFT JOIN (
                                SELECT
                                    wg_sku_weight_data.*,
                                    Count( wg_sku_weight_data.sku_amount ) AS count_amount,
                                    wg_scale.department 
                                FROM
                                    wg_sku_weight_data
                                    LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number 
                                WHERE
                                    wg_scale.department = 2 
                                GROUP BY
                                    wg_sku_weight_data.lot_number 
                                    ) AS wg_sku_weight_data ON tb_order.order_number = wg_sku_weight_data.lot_number
                                    LEFT JOIN tb_product_plan ON tb_order.order_number = tb_product_plan.order_number 
                                WHERE
                                    tb_product_plan.plan_slice = DATE_FORMAT(now(),'%d/%m/%Y')"
        );


        $order_release = DB::select("SELECT
                                    wg_sku_weight_data.id,
                                    wg_sku_weight_data.lot_number,
                                    wg_sku_weight_data.sku_code,
                                    Sum(wg_sku_weight_data.sku_amount) AS sum_sku_amount,
                                    Sum(wg_sku_weight_data.sku_weight) AS sum_sku_weight,
                                    wg_sku_weight_data.weighing_type,
                                    wg_sku_weight_data.weighing_place,
                                    wg_sku_weight_data.scale_number,
                                    wg_sku_weight_data.storage_name,
                                    wg_sku_weight_data.storage_compartment,
                                    wg_sku_weight_data.weighing_ref,
                                    wg_sku_weight_data.weighing_date,
                                    wg_sku_weight_data.note,
                                    wg_sku_weight_data.process_number,
                                    wg_sku_item.item_name,
                                    tb_order.total_pig,
                                    DATE_FORMAT( wg_sku_weight_data.weighing_date, '%d/%m/%Y' ) AS date_,
                                    tb_order.type_request,
                                    wg_scale.process_number
                                    FROM
                                    wg_sku_weight_data
                                    LEFT JOIN wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code
                                    LEFT JOIN tb_order ON wg_sku_weight_data.lot_number = tb_order.order_number
                                    LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                                    WHERE
                                    wg_sku_weight_data.weighing_date >= CURRENT_DATE - INTERVAL '7' DAY
                                    AND wg_scale.process_number = 2
                                    GROUP BY
                                    wg_sku_weight_data.lot_number");

            $sum_order_release = 0;
            foreach ($order_release as $key => $release) {
                $sum_order_release =  $sum_order_release + $release->sum_sku_amount;
            }

        $order_process = DB::select("SELECT
        tb_order.id,
        tb_order.order_number,
        Sum(tb_order.total_pig) AS sum_processing,
        tb_order.weight_range,
        tb_product_plan.plan_slice
        FROM
        tb_order
        LEFT JOIN tb_product_plan ON tb_order.order_number = tb_product_plan.order_number
        WHERE
        tb_order.type_request <> 4 AND
        tb_product_plan.plan_slice = DATE_FORMAT( now( ), '%d/%m/%Y' )
        ORDER BY
        tb_order.created_at DESC
        ");

        return view('stock.stock_data_pp2',compact('stock','stock_name','sum_storage','unit_today','unit_release','order_release','order_process','sum_order_release','order_send'));
    }
    public function stock_pp2_receive(Request $request){

        $mindate = substr($request->daterangeFilter,6,4).substr($request->daterangeFilter,3,2).substr($request->daterangeFilter,0,2);
        $maxdate = substr($request->daterangeFilter,19,4).substr($request->daterangeFilter,16,2).substr($request->daterangeFilter,13,2);
        
        $date_range = "AND ( CONCAT(SUBSTRING(tb_order.date, 7, 4),SUBSTRING(tb_order.date, 4, 2),SUBSTRING(tb_order.date, 1, 2)) 
        BETWEEN '".$mindate."' AND '".$maxdate."' )";

        $order_receive = DB::select("SELECT
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
                                        pd_lot.start_date_process,
                                        wg_sku_weight_data.lot_number,
                                        COUNT(wg_sku_weight_data.sku_amount) AS count_amount,
                                        sum(wg_sku_weight_data.sku_weight) AS sum_weight,
                                        tb_order_type.order_type,
                                        wg_weight_type.wg_type_name
                                    FROM
                                        pd_lot
                                        LEFT JOIN tb_order ON pd_lot.id_ref_order = tb_order.order_number 
                                        LEFT JOIN tb_order_type ON tb_order_type.id = tb_order.type_request 
                                        LEFT JOIN wg_sku_weight_data ON pd_lot.id_ref_order = wg_sku_weight_data.lot_number 
                                        LEFT JOIN wg_weight_type ON wg_sku_weight_data.weighing_type = wg_weight_type.id_wg_type
                                    WHERE
                                        pd_lot.department = '2' 
                                        AND tb_order.type_request <> 4 
                                        AND wg_sku_weight_data.scale_number IN ('KMK02','KMK01')
                                        AND  DATE_FORMAT( pd_lot.start_date_process, '%Y%m%d' )BETWEEN '$mindate' AND '$maxdate'
                                    GROUP BY 
                                        pd_lot.id_ref_order
                                    ORDER BY
                                        pd_lot.lot_number ASC");
        $date_range_send = "WHERE ( CONCAT(SUBSTRING(tb_product_plan.plan_slice, 7, 4),SUBSTRING(tb_product_plan.plan_slice, 4, 2),SUBSTRING(tb_product_plan.plan_slice, 1, 2)) 
                            BETWEEN '".$mindate."' AND '".$maxdate."' )";
           
        $order_send = DB::select("SELECT
                                    wg_sku_weight_data.id,
                                    wg_sku_weight_data.lot_number,
                                    wg_sku_weight_data.sku_id,
                                    wg_sku_weight_data.sku_code,
                                    wg_sku_weight_data.sku_amount,
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
                                    COUNT(wg_sku_weight_data.sku_amount) AS count_amount,
                                    Sum(wg_sku_weight_data.sku_weight) AS sum_weight,
                                    tb_order.type_request,
                                    tb_order.id_user_customer,
                                    tb_order_type.order_type,
                                    wg_weight_type.wg_type_name,
                                    wg_sku_item.item_name
                                    FROM
                                    wg_sku_weight_data
                                    LEFT JOIN tb_order ON wg_sku_weight_data.lot_number = tb_order.order_number
                                    LEFT JOIN tb_order_type ON tb_order.type_request = tb_order_type.id
                                    LEFT JOIN wg_weight_type ON wg_sku_weight_data.weighing_type = wg_weight_type.id_wg_type
                                    LEFT JOIN wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code
                                WHERE
                                    wg_sku_weight_data.scale_number IN ('KMK04')
                                    AND (
                                        CONCAT(
                                            SUBSTRING( wg_sku_weight_data.weighing_date, 1, 4 ),
                                            SUBSTRING( wg_sku_weight_data.weighing_date, 6, 2 ),
                                            SUBSTRING( wg_sku_weight_data.weighing_date, 9, 2 ) 
                                        ) BETWEEN '$mindate' 
                                    AND '$maxdate'
                                    )
                                GROUP BY 
                                    wg_sku_weight_data.lot_number
                                ORDER BY
	                                wg_sku_weight_data.lot_number ASC");

        $date_balance = substr($request->daterangeFilter,6,4).'-'.substr($request->daterangeFilter,3,2).'-'.substr($request->daterangeFilter,0,2).' '.'13:00:00';

        $balance = DB::select("SELECT
                                wg_storage_daily.id,
                                wg_storage_daily.id_storage,
                                wg_storage_daily.name_storage,
                                wg_storage_daily.count_unit as balance,
                                wg_storage_daily.unit,
                                wg_storage_daily.type_of_storage,
                                wg_storage_daily.description,
                                wg_storage_daily.user_id,
                                wg_storage_daily.created_at,
                                wg_storage_daily.updated_at,
                                wg_storage_daily.zone,
                                wg_storage_daily.date_summary,
                                wg_storage_daily.weight_summary,
                                wg_storage_daily.count_unit_real,
                                wg_storage_daily.weight_summary
                                FROM
                                wg_storage_daily
                                WHERE
                                wg_storage_daily.id_storage = '102' AND
                                wg_storage_daily.date_summary = DATE_FORMAT(('$date_balance' - INTERVAL 1 DAY),'%d/%m/%Y')
                                ORDER BY created_at LIMIT 1
                            ");

        $waste = DB::select("SELECT
                                wg_sku_weight_data.id,
                                wg_sku_weight_data.lot_number,
                                wg_sku_weight_data.sku_id,
                                wg_sku_weight_data.sku_code,
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
                                wg_sku_weight_data.sku_amount,
                                wg_sku_weight_data.sku_weight,
                                Sum( wg_sku_weight_data.sku_amount ) AS count_amount,
                                Sum( wg_sku_weight_data.sku_weight ) AS sum_weight,
                                wg_sku_item.item_code,
                                wg_sku_item.item_name,
                                wg_sku_item.unit,
                                tb_order_offal.id_user_customer,
                                wg_weight_type.wg_type_name
                            FROM
                                wg_sku_weight_data
                                LEFT JOIN wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code
                                LEFT JOIN tb_order_offal ON wg_sku_weight_data.lot_number = tb_order_offal.order_number 
                                LEFT JOIN wg_weight_type ON wg_sku_weight_data.weighing_type = wg_weight_type.id_wg_type
                            WHERE
                                wg_sku_weight_data.scale_number IN ( 'KMK06') 
                                AND
                                wg_sku_weight_data.weighing_type = 8
                            -- 	AND ( ( wg_sku_weight_data.sku_code NOT LIKE '50%' ) AND ( wg_sku_weight_data.sku_code NOT LIKE '60%' ) ) 
                            -- 	AND ( wg_sku_weight_data.sku_code NOT IN ( 'ซีก', 'ซาก', '0102', '0101') ) 
                                AND (
                                    CONCAT(
                                        SUBSTRING( wg_sku_weight_data.weighing_date, 1, 4 ),
                                        SUBSTRING( wg_sku_weight_data.weighing_date, 6, 2 ),
                                        SUBSTRING( wg_sku_weight_data.weighing_date, 9, 2 ) 
                                    ) BETWEEN '$mindate' 
                                    AND '$maxdate' 
                                ) 
                            GROUP BY
                                wg_sku_weight_data.lot_number 
                            ORDER BY
	                            wg_sku_weight_data.lot_number ASC");

        $mindate_check = substr($request->daterangeFilter,0,2)."/".substr($request->daterangeFilter,3,2)."/".substr($request->daterangeFilter,6,4);
        $check_count_stock = DB::select("SELECT
                                            wg_storage_daily.id,
                                            wg_storage_daily.id_storage,
                                            wg_storage_daily.name_storage,
                                            wg_storage_daily.count_unit,
                                            wg_storage_daily.count_unit_real,
                                            wg_storage_daily.unit,
                                            wg_storage_daily.type_of_storage,
                                            wg_storage_daily.description,
                                            wg_storage_daily.user_id,
                                            wg_storage_daily.created_at,
                                            wg_storage_daily.updated_at,
                                            wg_storage_daily.zone,
                                            wg_storage_daily.date_summary,
                                            wg_storage_daily.weight_summary
                                        FROM
                                            wg_storage_daily
                                        WHERE
                                            wg_storage_daily.id_storage = 102 AND
                                            wg_storage_daily.date_summary = '$mindate_check'");

        $white = DB::select("SELECT
                                    wg_sku_weight_data.id,
                                    wg_sku_weight_data.lot_number,
                                    wg_sku_weight_data.sku_id,
                                    wg_sku_weight_data.sku_code,
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
                                    wg_sku_item.item_code,
                                    wg_sku_item.item_name,
                                    sum(wg_sku_weight_data.sku_amount) AS count_amount,
                                    SUM(wg_sku_weight_data.sku_weight) AS sum_weight,
                                    wg_sku_item.unit,
                                    wg_weight_type.wg_type_name
                                FROM
                                    wg_sku_weight_data
                                    LEFT JOIN wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code
                                    LEFT JOIN wg_weight_type ON wg_sku_weight_data.weighing_type = wg_weight_type.id_wg_type
                                WHERE
                                    wg_sku_weight_data.scale_number IN ('KMK05', 'KMK06') AND
                                    ((wg_sku_weight_data.sku_code LIKE '500%')) AND
                                    (CONCAT(
                                            SUBSTRING( wg_sku_weight_data.weighing_date, 1, 4 ),
                                            SUBSTRING( wg_sku_weight_data.weighing_date, 6, 2 ),
                                            SUBSTRING( wg_sku_weight_data.weighing_date, 9, 2 ) 
                                        ) BETWEEN '$mindate' AND '$maxdate')
                                GROUP BY
                                    wg_sku_weight_data.lot_number
                                ORDER BY
	                                wg_sku_weight_data.lot_number ASC");

             $red = DB::select("SELECT
                                    wg_sku_weight_data.id,
                                    wg_sku_weight_data.lot_number,
                                    wg_sku_weight_data.sku_id,
                                    wg_sku_weight_data.sku_code,
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
                                    wg_sku_item.item_code,
                                    wg_sku_item.item_name,
                                    sum(wg_sku_weight_data.sku_amount) AS count_amount,
                                    SUM(wg_sku_weight_data.sku_weight) AS sum_weight,
                                    wg_sku_item.unit,
                                    wg_weight_type.wg_type_name
                                FROM
                                    wg_sku_weight_data
                                    LEFT JOIN wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code
                                    LEFT JOIN wg_weight_type ON wg_sku_weight_data.weighing_type = wg_weight_type.id_wg_type
                                WHERE
                                    wg_sku_weight_data.scale_number IN ('KMK05', 'KMK06') AND
                                    ( (wg_sku_weight_data.sku_code LIKE '600%') AND wg_sku_weight_data.sku_code NOT LIKE '6002') AND
                                    (CONCAT(
                                            SUBSTRING( wg_sku_weight_data.weighing_date, 1, 4 ),
                                            SUBSTRING( wg_sku_weight_data.weighing_date, 6, 2 ),
                                            SUBSTRING( wg_sku_weight_data.weighing_date, 9, 2 ) 
                                        ) BETWEEN '$mindate' AND '$maxdate')
                                GROUP BY
                                    wg_sku_weight_data.lot_number
                                ORDER BY
	                                wg_sku_weight_data.lot_number ASC");
            
            $heand = DB::select("SELECT
                                    wg_sku_weight_data.id,
                                    wg_sku_weight_data.lot_number,
                                    wg_sku_weight_data.sku_id,
                                    wg_sku_weight_data.sku_code,
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
                                    wg_sku_item.item_code,
                                    wg_sku_item.item_name,
                                    COUNT(wg_sku_weight_data.sku_amount) AS count_amount,
                                    SUM(wg_sku_weight_data.sku_weight) AS sum_weight,
                                    wg_sku_item.unit,
                                    wg_weight_type.wg_type_name
                                FROM
                                    wg_sku_weight_data
                                    LEFT JOIN wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code
                                    LEFT JOIN wg_weight_type ON wg_sku_weight_data.weighing_type = wg_weight_type.id_wg_type
                                WHERE
                                    wg_sku_weight_data.scale_number IN ('KMK05', 'KMK06') AND
                                    ( (wg_sku_weight_data.sku_code LIKE '6002')) AND
                                    (CONCAT(
                                            SUBSTRING( wg_sku_weight_data.weighing_date, 1, 4 ),
                                            SUBSTRING( wg_sku_weight_data.weighing_date, 6, 2 ),
                                            SUBSTRING( wg_sku_weight_data.weighing_date, 9, 2 ) 
                                        ) BETWEEN '$mindate' AND '$maxdate')
                                GROUP BY
                                    wg_sku_weight_data.lot_number
                                ORDER BY
	                                wg_sku_weight_data.lot_number ASC");
        
            

            // 
            $ar1[] = '';
            $ii = count($order_receive) ;
            $jj = count($order_send) ;
            $ll = count($white) ;
            $kk = count($red) ;
            $mm = count($waste) ;
            $nn = count($heand);
            for($i=0 ; $i< $ii ; $i++ ){
                    for($j=0 ; $j< $jj ; $j++ ){
                            if(($order_receive[$i]->order_number == $order_send[$j]->lot_number)){
                                for($l = 0 ; $l< $ll ; $l++){
                                    if( $order_receive[$i]->order_number == $white[$l]->lot_number ){
                                        for($k = 0 ; $k< $kk ; $k++){
                                            if( $order_receive[$i]->order_number == $red[$k]->lot_number ){
                                                for($n = 0 ; $n< $nn ; $n++){
                                                    if( $order_receive[$i]->order_number == $heand[$n]->lot_number ){
                                                        for($m = 0 ; $m< $mm ; $m++){
                                                            if( $order_receive[$i]->order_number == $waste[$m]->lot_number ){

                                                                $ar1[$i] = array('order_number' => $order_receive[$i]->order_number,
                                                                        'id_user_customer' => $order_receive[$i]->id_user_customer,
                                                                        'wg_type_name_in' => $order_receive[$i]->wg_type_name,
                                                                        'wg_type_name_out' => $order_send[$j]->wg_type_name,
                                                                        'count_amount_in' => $order_receive[$i]->count_amount,
                                                                        'count_amount_out' => $order_send[$j]->count_amount,
                                                                        'sum_weight_in' => $order_receive[$i]->sum_weight,
                                                                        'sum_weight_out' =>  $order_send[$j]->sum_weight,
                                                                        'count_amount_w' => $white[$l]->count_amount,
                                                                        'sum_weight_w' => $white[$l]->sum_weight,
                                                                        'count_amount_r' => $red[$k]->count_amount,
                                                                        'sum_weight_r' => $red[$k]->sum_weight,
                                                                        'count_amount_h' => $heand[$n]->count_amount,
                                                                        'sum_weight_h' => $heand[$n]->sum_weight,
                                                                        'count_amount_ws' => $waste[$m]->count_amount,
                                                                        'sum_weight_ws' => $waste[$m]->sum_weight
                                                                        ); 
                                                            }
                                                            else{
                                                                $ar1[$i] = array('order_number' => $order_receive[$i]->order_number,
                                                                        'id_user_customer' => $order_receive[$i]->id_user_customer,
                                                                        'wg_type_name_in' => $order_receive[$i]->wg_type_name,
                                                                        'wg_type_name_out' => $order_send[$j]->wg_type_name,
                                                                        'count_amount_in' => $order_receive[$i]->count_amount,
                                                                        'count_amount_out' => $order_send[$j]->count_amount,
                                                                        'sum_weight_in' => $order_receive[$i]->sum_weight,
                                                                        'sum_weight_out' =>  $order_send[$j]->sum_weight,
                                                                        'count_amount_w' => $white[$l]->count_amount,
                                                                        'sum_weight_w' => $white[$l]->sum_weight,
                                                                        'count_amount_r' => $red[$k]->count_amount,
                                                                        'sum_weight_r' => $red[$k]->sum_weight,
                                                                        'count_amount_h' => $heand[$n]->count_amount,
                                                                        'sum_weight_h' => $heand[$n]->sum_weight,
                                                                        'count_amount_ws' => null,
                                                                        'sum_weight_ws' => null
                                                                        ); 
                                                            }
                                                        }
                                                    }
                                                    else{
                                                        $ar1[$i] = array('order_number' => $order_receive[$i]->order_number,
                                                                        'id_user_customer' => $order_receive[$i]->id_user_customer,
                                                                        'wg_type_name_in' => $order_receive[$i]->wg_type_name,
                                                                        'wg_type_name_out' => $order_send[$j]->wg_type_name,
                                                                        'count_amount_in' => $order_receive[$i]->count_amount,
                                                                        'count_amount_out' => $order_send[$j]->count_amount,
                                                                        'sum_weight_in' => $order_receive[$i]->sum_weight,
                                                                        'sum_weight_out' =>  $order_send[$j]->sum_weight,
                                                                        'count_amount_w' => $white[$l]->count_amount,
                                                                        'sum_weight_w' => $white[$l]->sum_weight,
                                                                        'count_amount_r' => $red[$k]->count_amount,
                                                                        'sum_weight_r' => $red[$k]->sum_weight,
                                                                        'count_amount_h' => null,
                                                                        'sum_weight_h' => null,
                                                                        'count_amount_ws' => null,
                                                                        'sum_weight_ws' => null
                                                                        ); 
                                                    }
                                                }
                                            }
                                            else{
                                                $ar1[$i] = array('order_number' => $order_receive[$i]->order_number,
                                                                        'id_user_customer' => $order_receive[$i]->id_user_customer,
                                                                        'wg_type_name_in' => $order_receive[$i]->wg_type_name,
                                                                        'wg_type_name_out' => $order_send[$j]->wg_type_name,
                                                                        'count_amount_in' => $order_receive[$i]->count_amount,
                                                                        'count_amount_out' => $order_send[$j]->count_amount,
                                                                        'sum_weight_in' => $order_receive[$i]->sum_weight,
                                                                        'sum_weight_out' =>  $order_send[$j]->sum_weight,
                                                                        'count_amount_w' => $white[$l]->count_amount,
                                                                        'sum_weight_w' => $white[$l]->sum_weight,
                                                                        'count_amount_r' => null,
                                                                        'sum_weight_r' => null,
                                                                        'count_amount_h' => null,
                                                                        'sum_weight_h' => null,
                                                                        'count_amount_ws' => null,
                                                                        'sum_weight_ws' => null
                                                                        ); 
                                            }
                                        }       
                                    }
                                    else{
                                        $ar1[$i] = array('order_number' => $order_receive[$i]->order_number,
                                                                        'id_user_customer' => $order_receive[$i]->id_user_customer,
                                                                        'wg_type_name_in' => $order_receive[$i]->wg_type_name,
                                                                        'wg_type_name_out' => $order_send[$j]->wg_type_name,
                                                                        'count_amount_in' => $order_receive[$i]->count_amount,
                                                                        'count_amount_out' => $order_send[$j]->count_amount,
                                                                        'sum_weight_in' => $order_receive[$i]->sum_weight,
                                                                        'sum_weight_out' =>  $order_send[$j]->sum_weight,
                                                                        'count_amount_w' => null,
                                                                        'sum_weight_w' => null,
                                                                        'count_amount_r' => null,
                                                                        'sum_weight_r' => null,
                                                                        'count_amount_h' => null,
                                                                        'sum_weight_h' => null,
                                                                        'count_amount_ws' => null,
                                                                        'sum_weight_ws' => null
                                                                        ); 
                                    }
                                }
                            }
                            else{
                                $ar1[$i] = array('order_number' => $order_receive[$i]->order_number,
                                                'id_user_customer' => $order_receive[$i]->id_user_customer,
                                                'wg_type_name_in' => $order_receive[$i]->wg_type_name,
                                                'sum_weight_in' => $order_receive[$i]->sum_weight,
                                                'count_amount_in' => $order_receive[$i]->count_amount,
                                                'count_amount_out' => null,
                                                'wg_type_name_out' => null,
                                                'sum_weight_out' => null,
                                                'count_amount_w' => null,
                                                'sum_weight_w' => null,
                                                'count_amount_r' => null,
                                                'sum_weight_r' => null,
                                                'count_amount_h' => null,
                                                'sum_weight_h' => null,
                                                'count_amount_ws' => null,
                                                'sum_weight_ws' => null
                                                                        ); 
                            }
                    }  
            }



             return array($order_receive,$order_send,$balance,$check_count_stock,$white,$waste,$ar1,$red,$heand);

             return Datatables::of($order_receive)->addIndexColumn()->make(true);
    }
    public function stock_pp2_send(Request $request){

        $mindate = substr($request->daterangeFilter,6,4).substr($request->daterangeFilter,3,2).substr($request->daterangeFilter,0,2);
        $maxdate = substr($request->daterangeFilter,19,4).substr($request->daterangeFilter,16,2).substr($request->daterangeFilter,13,2);
        
        $date_range_send = "WHERE ( CONCAT(SUBSTRING(tb_product_plan.plan_slice, 7, 4),SUBSTRING(tb_product_plan.plan_slice, 4, 2),SUBSTRING(tb_product_plan.plan_slice, 1, 2)) 
        BETWEEN '".$mindate."' AND '".$maxdate."' )";

        $order_send = DB::select("SELECT
                                    tb_order.id,
                                    tb_order.order_number,
                                    tb_order.total_pig,
                                    tb_order.weight_range,
                                    tb_order.note,
                                    tb_order.date,
                                    tb_order.id_user_customer,
                                    tb_order.`status`,
                                    tb_order.marker,
                                    tb_order.round,
                                    tb_order.storage_id,
                                    tb_order_type.order_type,
                                    wg_storage.name_storage,
                                    wg_storage.description,
                                    wg_sku_weight_data.sku_amount,
                                    wg_sku_weight_data.scale_number,
                                    wg_sku_weight_data.count_amount,
                                    tb_product_plan.plan_slice 
                                FROM
                                    tb_order
                                    LEFT JOIN tb_order_type ON tb_order.type_request = tb_order_type.id
                                    LEFT JOIN wg_storage ON tb_order.storage_id = wg_storage.id_storage
                                    LEFT JOIN (
                                SELECT
                                    wg_sku_weight_data.*,
                                    Count( wg_sku_weight_data.sku_amount ) AS count_amount,
                                    wg_scale.department 
                                FROM
                                    wg_sku_weight_data
                                    LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number 
                                WHERE
                                    wg_scale.department = 2
                                GROUP BY
                                    wg_sku_weight_data.lot_number 
                                    ) AS wg_sku_weight_data ON tb_order.order_number = wg_sku_weight_data.lot_number
                                    LEFT JOIN tb_product_plan ON tb_order.order_number = tb_product_plan.order_number
                                    ".$date_range_send." 
                                ORDER BY
                                    tb_order.created_at DESC      
                            ");
        
        return Datatables::of($order_send)->addIndexColumn()->make(true);
    }
    public function stock_of_pp2_balance(Request $request){
        $mindate = substr($request->daterangeFilter,6,4).substr($request->daterangeFilter,3,2).substr($request->daterangeFilter,0,2);
        $maxdate = substr($request->daterangeFilter,19,4).substr($request->daterangeFilter,16,2).substr($request->daterangeFilter,13,2);
        
        $date_range = "AND ( CONCAT(SUBSTRING(wg_stock.date_recieve, 7, 4),SUBSTRING(wg_stock.date_recieve, 4, 2),SUBSTRING(wg_stock.date_recieve, 1, 2)) 
        BETWEEN '".$mindate."' AND '".$maxdate."' )";

        $stock = DB::select("SELECT
                                        wg_stock.id,
                                        wg_stock.id_storage,
                                        wg_stock.bill_number,
                                        wg_stock.round,
                                        wg_stock.ref_source,
                                        wg_stock.item_code,
                                        wg_stock.total_unit,
                                        wg_stock.date_recieve,
                                        wg_stock.current_unit,
                                        wg_stock.note,
                                        wg_stock.created_at,
                                        wg_stock.updated_at
                                        FROM
                                        wg_stock
                                        WHERE
                                        wg_stock.id_storage = 18
                                        ".$date_range."
        ");
        
        return Datatables::of($stock)->addIndexColumn()->make(true);
    }

    // overnight
    public function stock_data_ov($stock_name){

        $sum_storage = DB::select("SELECT
                                wg_storage.id_storage,
                                wg_storage.name_storage,
                                wg_storage.max_unit,
                                wg_storage.current_unit,
                                wg_storage.unit,
                                wg_storage.type_of_storage,
                                wg_storage.description,
                                wg_storage.user_id,
                                wg_storage.created_at,
                                wg_storage.updated_at,
                                wg_storage.zone
                                FROM
                                wg_storage
                                WHERE wg_storage.description IN ('คอกรวม','คอกรวม','Overnight รวม','เครื่องในขาว รวม','เครื่องในแดง + หัว รวม','รอโหลด รวม')");

        $unit_today = DB::select("SELECT
                                    wg_stock_log.*,
                                    SUM(wg_stock_log.current_unit) as sum_unit_add,
                                    DATE_FORMAT( now( ), '%d/%m/%Y' ) AS date_today,
                                    wg_storage.type_of_storage,
                                    wg_storage.description 
                                FROM
                                    wg_stock_log
                                    LEFT JOIN wg_storage ON wg_stock_log.id_storage = wg_storage.id_storage 
                                WHERE
                                    wg_stock_log.date_recieve = DATE_FORMAT( now( ), '%d/%m/%Y' ) 
                                    AND wg_storage.type_of_storage = '$stock_name'
                                    AND wg_stock_log.action = 'add' ");
        $order_send = DB::select("SELECT
                                        tb_order.id,
                                        tb_order.order_number,
                                        wg_sku_weight_data.sku_amount,
                                        wg_sku_weight_data.scale_number,
                                        sum( wg_sku_weight_data.count_amount ) AS sum_unit_add 
                                    FROM
                                        tb_order
                                        LEFT JOIN tb_order_type ON tb_order.type_request = tb_order_type.id
                                        LEFT JOIN wg_storage ON tb_order.storage_id = wg_storage.id_storage
                                        LEFT JOIN (
                                    SELECT
                                        wg_sku_weight_data.*,
                                        Count( wg_sku_weight_data.sku_amount ) AS count_amount,
                                        wg_scale.department 
                                    FROM
                                        wg_sku_weight_data
                                        LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number 
                                    WHERE
                                        wg_scale.department = 3
                                    GROUP BY
                                        wg_sku_weight_data.lot_number 
                                        ) AS wg_sku_weight_data ON tb_order.order_number = wg_sku_weight_data.lot_number 
                                    WHERE
                                        tb_order.date = DATE_FORMAT( now( ), '%d/%m/%Y' ) 
                                    ORDER BY
                                        tb_order.created_at DESC
                                ");

        $unit_release = DB::select("SELECT
                                    wg_sku_weight_data.sku_amount,
                                    wg_sku_weight_data.scale_number,
                                    wg_sku_weight_data.count_amount,
                                    NOW( ),
                                    tb_order_cutting.date,
                                    tb_order_cutting.order_number,
                                    tb_order_cutting.total_pig
                                    FROM
                                    tb_order_cutting
                                    LEFT JOIN tb_order_type ON tb_order_cutting.type_request = tb_order_type.id
                                    LEFT JOIN wg_storage ON tb_order_cutting.storage_id = wg_storage.id_storage
                                    LEFT JOIN (
                                    SELECT
                                        wg_sku_weight_data.*,
                                        Count( wg_sku_weight_data.sku_amount ) AS count_amount,
                                        wg_scale.department 
                                    FROM
                                        wg_sku_weight_data
                                        LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number 
                                    WHERE
                                        wg_scale.department = 7 
                                    GROUP BY
                                        wg_sku_weight_data.lot_number 
                                        ) AS wg_sku_weight_data ON tb_order_cutting.order_number = wg_sku_weight_data.lot_number
                                    WHERE
                                    tb_order_cutting.date = DATE_FORMAT( now( ), '%d/%m/%Y' )"
        );

        $order_release = DB::select("SELECT
                                    wg_sku_weight_data.id,
                                    wg_sku_weight_data.lot_number,
                                    wg_sku_weight_data.sku_code,
                                    Sum(wg_sku_weight_data.sku_amount) AS sum_sku_amount,
                                    Sum(wg_sku_weight_data.sku_weight) AS sum_sku_weight,
                                    wg_sku_weight_data.weighing_type,
                                    wg_sku_weight_data.weighing_place,
                                    wg_sku_weight_data.scale_number,
                                    wg_sku_weight_data.storage_name,
                                    wg_sku_weight_data.storage_compartment,
                                    wg_sku_weight_data.weighing_ref,
                                    wg_sku_weight_data.weighing_date,
                                    wg_sku_weight_data.note,
                                    wg_sku_weight_data.process_number,
                                    wg_sku_item.item_name,
                                    tb_order.total_pig,
                                    DATE_FORMAT( wg_sku_weight_data.weighing_date, '%d/%m/%Y' ) AS date_,
                                    tb_order.type_request,
                                    wg_scale.process_number
                                    FROM
                                    wg_sku_weight_data
                                    LEFT JOIN wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code
                                    LEFT JOIN tb_order ON wg_sku_weight_data.lot_number = tb_order.order_number
                                    LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                                    WHERE
                                    wg_sku_weight_data.weighing_date >= CURRENT_DATE - INTERVAL '7' DAY
                                    AND wg_scale.process_number = 2
                                    GROUP BY
                                    wg_sku_weight_data.lot_number");

            $sum_order_release = 0;
            foreach ($order_release as $key => $release) {
                $sum_order_release =  $sum_order_release + $release->sum_sku_amount;
            }

        $order_process = DB::select("SELECT
                tb_order.id,
                tb_order.order_number,
                Sum(tb_order.total_pig) AS sum_processing,
                tb_order.weight_range,
                tb_product_plan.plan_slice
                FROM
                tb_order
                LEFT JOIN tb_product_plan ON tb_order.order_number = tb_product_plan.order_number
                WHERE
                tb_order.type_request <> 4 AND
                tb_product_plan.plan_slice = DATE_FORMAT( now( ), '%d/%m/%Y' )
                ORDER BY
                tb_order.created_at DESC
                ");

        return view('stock.stock_data_ov',compact('stock_name','sum_storage','unit_today','unit_release','order_release','order_process','sum_order_release','order_send'));
    }

    public function stock_ov_receive(Request $request){

        $mindate = substr($request->daterangeFilter,6,4).substr($request->daterangeFilter,3,2).substr($request->daterangeFilter,0,2);
        $maxdate = substr($request->daterangeFilter,19,4).substr($request->daterangeFilter,16,2).substr($request->daterangeFilter,13,2);

        $order_receive = DB::select("SELECT
                                        wg_sku_weight_data.id,
                                        wg_sku_weight_data.lot_number,
                                        wg_sku_weight_data.sku_id,
                                        wg_sku_weight_data.sku_code,
                                        wg_sku_weight_data.sku_amount,
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
                                        Count(wg_sku_weight_data.sku_amount) AS count_amount,
                                        Sum(wg_sku_weight_data.sku_weight) AS sum_weight,
                                        tb_order.type_request,
                                        tb_order.id_user_customer,
                                        tb_order_type.order_type,
                                        wg_weight_type.wg_type_name
                                    FROM
                                        wg_sku_weight_data
                                        LEFT JOIN tb_order ON wg_sku_weight_data.lot_number = tb_order.order_number
                                        LEFT JOIN tb_order_type ON tb_order.type_request = tb_order_type.id
                                        LEFT JOIN wg_weight_type ON wg_sku_weight_data.weighing_type = wg_weight_type.id_wg_type
                                    WHERE
                                        wg_sku_weight_data.scale_number IN ('KMK04')
                                        AND
                                        (CONCAT(
                                                    SUBSTRING( wg_sku_weight_data.weighing_date, 1, 4 ),
                                                    SUBSTRING( wg_sku_weight_data.weighing_date, 6, 2 ),
                                                    SUBSTRING( wg_sku_weight_data.weighing_date, 9, 2 ) 
                                                ) BETWEEN '$mindate' AND '$maxdate')
                                    GROUP BY
                                        wg_sku_weight_data.lot_number
                                    ");

        $order_send = DB::select("SELECT
                                    wg_sku_weight_data.id,
                                    wg_sku_weight_data.lot_number,
                                    wg_sku_weight_data.sku_id,
                                    wg_sku_weight_data.sku_code,
                                    wg_sku_weight_data.sku_amount,
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
                                    Count(wg_sku_weight_data.sku_amount) AS count_amount,
                                    Sum(wg_sku_weight_data.sku_weight) AS sum_weight,
                                    tb_order_overnight.id_user_customer,
                                    tb_order_type.order_type,
                                    wg_weight_type.wg_type_name
                                FROM
                                    wg_sku_weight_data
                                    LEFT JOIN tb_order_overnight ON wg_sku_weight_data.lot_number = tb_order_overnight.order_number
                                    LEFT JOIN tb_order_type ON tb_order_overnight.type_request = tb_order_type.id
                                    LEFT JOIN wg_weight_type ON wg_sku_weight_data.weighing_type = wg_weight_type.id_wg_type
                                WHERE
                                    wg_sku_weight_data.scale_number IN ('KMK07') AND
                                    -- wg_sku_weight_data.weighing_type = 1 AND
                                    (CONCAT(
                                                SUBSTRING( wg_sku_weight_data.weighing_date, 1, 4 ),
                                                SUBSTRING( wg_sku_weight_data.weighing_date, 6, 2 ),
                                                SUBSTRING( wg_sku_weight_data.weighing_date, 9, 2 ) 
                                            ) BETWEEN '$mindate' AND '$maxdate')
                                GROUP BY
                                    wg_sku_weight_data.lot_number");

            $date_balance = substr($request->daterangeFilter,6,4).'-'.substr($request->daterangeFilter,3,2).'-'.substr($request->daterangeFilter,0,2).' '.'13:00:00';

            $balance = DB::select("SELECT
                wg_storage_daily.id,
                wg_storage_daily.id_storage,
                wg_storage_daily.name_storage,
                wg_storage_daily.count_unit as balance,
                wg_storage_daily.unit,
                wg_storage_daily.type_of_storage,
                wg_storage_daily.description,
                wg_storage_daily.user_id,
                wg_storage_daily.created_at,
                wg_storage_daily.updated_at,
                wg_storage_daily.zone,
                wg_storage_daily.date_summary,
                wg_storage_daily.weight_summary,
                wg_storage_daily.count_unit_real,
                wg_storage_daily.weight_summary
                FROM
                wg_storage_daily
                WHERE
                wg_storage_daily.id_storage = '103' AND
                wg_storage_daily.date_summary = DATE_FORMAT(('$date_balance' - INTERVAL 1 DAY),'%d/%m/%Y')
                ORDER BY created_at LIMIT 1
            ");

        $mindate_check = substr($request->daterangeFilter,0,2)."/".substr($request->daterangeFilter,3,2)."/".substr($request->daterangeFilter,6,4);
        $check_count_stock = DB::select("SELECT
                                    wg_storage_daily.id,
                                    wg_storage_daily.id_storage,
                                    wg_storage_daily.name_storage,
                                    wg_storage_daily.count_unit,
                                    wg_storage_daily.count_unit_real,
                                    wg_storage_daily.unit,
                                    wg_storage_daily.type_of_storage,
                                    wg_storage_daily.description,
                                    wg_storage_daily.user_id,
                                    wg_storage_daily.created_at,
                                    wg_storage_daily.updated_at,
                                    wg_storage_daily.zone,
                                    wg_storage_daily.date_summary,
                                    wg_storage_daily.weight_summary
                                FROM
                                    wg_storage_daily
                                WHERE
                                    wg_storage_daily.id_storage = 103 AND
                                    wg_storage_daily.date_summary = '$mindate_check'");

            return array($order_receive,$order_send, $balance,$check_count_stock,$mindate_check);

            return Datatables::of($order_receive)->addIndexColumn()->make(true);
    }
    public function stock_ov_send(Request $request){

        $mindate = substr($request->daterangeFilter,6,4).substr($request->daterangeFilter,3,2).substr($request->daterangeFilter,0,2);
        $maxdate = substr($request->daterangeFilter,19,4).substr($request->daterangeFilter,16,2).substr($request->daterangeFilter,13,2);
        
        $date_range_send = "WHERE ( CONCAT(SUBSTRING(tb_order_cutting.date, 7, 4),SUBSTRING(tb_order_cutting.date, 4, 2),SUBSTRING(tb_order_cutting.date, 1, 2)) 
        BETWEEN '".$mindate."' AND '".$maxdate."' )";

        $order_send = DB::select("SELECT
                                    tb_order_cutting.id,
                                    tb_order_cutting.order_number,
                                    tb_order_cutting.total_pig,
                                    tb_order_cutting.weight_range,
                                    tb_order_cutting.note,
                                    tb_order_cutting.date,
                                    tb_order_cutting.id_user_customer,
                                    tb_order_cutting.`status`,
                                    tb_order_cutting.marker,
                                    tb_order_cutting.round,
                                    tb_order_cutting.storage_id,
                                    tb_order_type.order_type,
                                    wg_storage.name_storage,
                                    wg_storage.description,
                                    wg_sku_weight_data.sku_amount,
                                    wg_sku_weight_data.scale_number,
                                    wg_sku_weight_data.count_amount
                                FROM
                                    tb_order_cutting
                                    LEFT JOIN tb_order_type ON tb_order_cutting.type_request = tb_order_type.id
                                    LEFT JOIN wg_storage ON tb_order_cutting.storage_id = wg_storage.id_storage
                                    LEFT JOIN (
                                SELECT
                                    wg_sku_weight_data.*,
                                    Count( wg_sku_weight_data.sku_amount ) AS count_amount,
                                    wg_scale.department 
                                FROM
                                    wg_sku_weight_data
                                    LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number 
                                WHERE
                                    wg_scale.department = 7
                                GROUP BY
                                    wg_sku_weight_data.lot_number 
                                    ) AS wg_sku_weight_data ON tb_order_cutting.order_number = wg_sku_weight_data.lot_number
                                    ".$date_range_send." 
                                ORDER BY
                                    tb_order_cutting.created_at DESC
            ");
        
        return Datatables::of($order_send)->addIndexColumn()->make(true);
    }
    public function stock_of_ov_balance(Request $request){
        $mindate = substr($request->daterangeFilter,6,4).substr($request->daterangeFilter,3,2).substr($request->daterangeFilter,0,2);
        $maxdate = substr($request->daterangeFilter,19,4).substr($request->daterangeFilter,16,2).substr($request->daterangeFilter,13,2);
        
        $date_range = "AND ( CONCAT(SUBSTRING(wg_stock.date_recieve, 7, 4),SUBSTRING(wg_stock.date_recieve, 4, 2),SUBSTRING(wg_stock.date_recieve, 1, 2)) 
        BETWEEN '".$mindate."' AND '".$maxdate."' )";

        $stock = DB::select("SELECT
                                        wg_stock.id,
                                        wg_stock.id_storage,
                                        wg_stock.bill_number,
                                        wg_stock.round,
                                        wg_stock.ref_source,
                                        wg_stock.item_code,
                                        wg_stock.total_unit,
                                        wg_stock.date_recieve,
                                        wg_stock.current_unit,
                                        wg_stock.note,
                                        wg_stock.created_at,
                                        wg_stock.updated_at
                                        FROM
                                        wg_stock
                                        WHERE
                                        wg_stock.id_storage = 24
                                        ".$date_range."
        ");
        
        return Datatables::of($stock)->addIndexColumn()->make(true);
    }
    
    // offal R
    public function stock_data_of_cl($stock_name){
        $sum_storage = DB::select("SELECT
                                wg_storage.id_storage,
                                wg_storage.name_storage,
                                wg_storage.max_unit,
                                wg_storage.current_unit,
                                wg_storage.unit,
                                wg_storage.type_of_storage,
                                wg_storage.description,
                                wg_storage.user_id,
                                wg_storage.created_at,
                                wg_storage.updated_at,
                                wg_storage.zone
                                FROM
                                wg_storage
                                WHERE wg_storage.description IN ('คอกรวม','คอกรวม','Overnight รวม','เครื่องในขาว รวม','เครื่องในแดง + หัว รวม','รอโหลด รวม')");

        $unit_today = DB::select("SELECT
                                    wg_stock_log.*,
                                    SUM(wg_stock_log.current_unit) as sum_unit_add,
                                    DATE_FORMAT( now( ), '%d/%m/%Y' ) AS date_today,
                                    wg_storage.type_of_storage,
                                    wg_storage.description 
                                FROM
                                    wg_stock_log
                                    LEFT JOIN wg_storage ON wg_stock_log.id_storage = wg_storage.id_storage 
                                WHERE
                                    wg_stock_log.date_recieve = DATE_FORMAT( now( ), '%d/%m/%Y' ) 
                                    AND wg_storage.type_of_storage = '$stock_name'
                                    AND wg_stock_log.action = 'add' ");
        
        $order_send = DB::select("SELECT
                                    tb_order_offal.id,
                                    tb_order_offal.order_number,
                                    wg_sku_weight_data.sku_amount,
                                    wg_sku_weight_data.scale_number,
                                    sum( wg_sku_weight_data.count_amount ) AS sum_unit_add 
                                FROM
                                    tb_order_offal
                                    LEFT JOIN tb_order_type ON tb_order_offal.type_request = tb_order_type.id
                                    LEFT JOIN wg_storage ON tb_order_offal.storage_id = wg_storage.id_storage
                                    LEFT JOIN (
                                SELECT
                                    wg_sku_weight_data.*,
                                    Count( wg_sku_weight_data.sku_amount ) AS count_amount,
                                    wg_scale.department 
                                FROM
                                    wg_sku_weight_data
                                    LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number 
                                WHERE
                                    wg_scale.department = 5
                                    AND wg_sku_weight_data.weighing_type = 2
                                GROUP BY
                                    wg_sku_weight_data.lot_number 
                                    ) AS wg_sku_weight_data ON tb_order_offal.order_number = wg_sku_weight_data.lot_number 
                                WHERE
                                    tb_order_offal.date = DATE_FORMAT( now( ), '%d/%m/%Y' ) 
                                ORDER BY
                                    tb_order_offal.created_at DESC
        ");

        $unit_release = DB::select("SELECT
                                wg_sku_weight_data.id,
                                wg_sku_weight_data.lot_number,
                                SUM(wg_sku_weight_data.sku_amount) sum_release,
                                wg_sku_weight_data.sku_weight,
                                wg_sku_weight_data.sku_unit,
                                wg_scale.process_number
                                FROM
                                wg_sku_weight_data
                                LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                                WHERE
                                DATE_FORMAT(wg_sku_weight_data.weighing_date,'%d/%m/%Y') = DATE_FORMAT(now(),'%d/%m/%Y')
                                AND wg_scale.process_number = 1 ");

        $order_release = DB::select("SELECT
                                    wg_sku_weight_data.id,
                                    wg_sku_weight_data.lot_number,
                                    wg_sku_weight_data.sku_code,
                                    Sum(wg_sku_weight_data.sku_amount) AS sum_sku_amount,
                                    Sum(wg_sku_weight_data.sku_weight) AS sum_sku_weight,
                                    wg_sku_weight_data.weighing_type,
                                    wg_sku_weight_data.weighing_place,
                                    wg_sku_weight_data.scale_number,
                                    wg_sku_weight_data.storage_name,
                                    wg_sku_weight_data.storage_compartment,
                                    wg_sku_weight_data.weighing_ref,
                                    wg_sku_weight_data.weighing_date,
                                    wg_sku_weight_data.note,
                                    wg_sku_weight_data.process_number,
                                    wg_sku_item.item_name,
                                    tb_order.total_pig,
                                    DATE_FORMAT( wg_sku_weight_data.weighing_date, '%d/%m/%Y' ) AS date_,
                                    tb_order.type_request,
                                    wg_scale.process_number
                                    FROM
                                    wg_sku_weight_data
                                    LEFT JOIN wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code
                                    LEFT JOIN tb_order ON wg_sku_weight_data.lot_number = tb_order.order_number
                                    LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                                    WHERE
                                    wg_sku_weight_data.weighing_date >= CURRENT_DATE - INTERVAL '7' DAY
                                    AND wg_scale.process_number = 2
                                    GROUP BY
                                    wg_sku_weight_data.lot_number");

            $sum_order_release = 0;
            foreach ($order_release as $key => $release) {
                $sum_order_release =  $sum_order_release + $release->sum_sku_amount;
            }

        $order_process = DB::select("SELECT
                tb_order.id,
                tb_order.order_number,
                Sum(tb_order.total_pig) AS sum_processing,
                tb_order.weight_range,
                tb_product_plan.plan_slice
                FROM
                tb_order
                LEFT JOIN tb_product_plan ON tb_order.order_number = tb_product_plan.order_number
                WHERE
                tb_order.type_request <> 4 AND
                tb_product_plan.plan_slice = DATE_FORMAT( now( ), '%d/%m/%Y' )
                ORDER BY
                tb_order.created_at DESC
                ");

        return view('stock.stock_data_of_cl',compact('stock_name','sum_storage','unit_today','unit_release','order_release','order_process','sum_order_release','order_send'));
    }

    public function stock_cl_receive(Request $request){

        $mindate = substr($request->daterangeFilter,6,4).substr($request->daterangeFilter,3,2).substr($request->daterangeFilter,0,2);
        $maxdate = substr($request->daterangeFilter,19,4).substr($request->daterangeFilter,16,2).substr($request->daterangeFilter,13,2);

        $date_balance = substr($request->daterangeFilter,6,4).'-'.substr($request->daterangeFilter,3,2).'-'.substr($request->daterangeFilter,0,2).' '.'13:00:00';

            $balance = DB::select("SELECT
                wg_storage_daily.id,
                wg_storage_daily.id_storage,
                wg_storage_daily.name_storage,
                wg_storage_daily.count_unit as balance,
                wg_storage_daily.unit,
                wg_storage_daily.type_of_storage,
                wg_storage_daily.description,
                wg_storage_daily.user_id,
                wg_storage_daily.created_at,
                wg_storage_daily.updated_at,
                wg_storage_daily.zone,
                wg_storage_daily.date_summary,
                wg_storage_daily.weight_summary
                FROM
                wg_storage_daily
                WHERE
                wg_storage_daily.id_storage = '105' AND
                wg_storage_daily.date_summary = DATE_FORMAT(('$date_balance' - INTERVAL 1 DAY),'%d/%m/%Y')
                ORDER BY created_at LIMIT 1
            ");


        $order_receive = DB::select("SELECT
                                        wg_sku_weight_data.id,
                                        wg_sku_weight_data.lot_number,
                                        wg_sku_weight_data.sku_id,
                                        wg_sku_weight_data.sku_code,
                                        wg_sku_weight_data.sku_amount,
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
                                        sum(wg_sku_weight_data.sku_amount) AS count_amount,
                                        Sum(wg_sku_weight_data.sku_weight) AS sum_weight,
                                        tb_order_overnight.id_user_customer,
                                        tb_order_type.order_type,
                                        wg_weight_type.wg_type_name,
                                        wg_sku_item.item_name
                                    FROM
                                        wg_sku_weight_data
                                        LEFT JOIN tb_order_overnight ON wg_sku_weight_data.lot_number = tb_order_overnight.order_number
                                        LEFT JOIN tb_order_type ON tb_order_overnight.type_request = tb_order_type.id
                                        LEFT JOIN wg_weight_type ON wg_sku_weight_data.weighing_type = wg_weight_type.id_wg_type
                                        LEFT JOIN wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code
                                        WHERE
                                        wg_sku_weight_data.scale_number IN ('KMK07') AND
                                        wg_sku_weight_data.weighing_type = 2 AND
                                        (CONCAT(
                                                    SUBSTRING( wg_sku_weight_data.weighing_date, 1, 4 ),
                                                    SUBSTRING( wg_sku_weight_data.weighing_date, 6, 2 ),
                                                    SUBSTRING( wg_sku_weight_data.weighing_date, 9, 2 ) 
                                                ) BETWEEN '$mindate' AND '$maxdate')
                                    GROUP BY
                                        wg_sku_weight_data.lot_number");

        $order_send = DB::select("SELECT
                                    wg_sku_weight_data.id,
                                    wg_sku_weight_data.lot_number,
                                    wg_sku_weight_data.sku_id,
                                    wg_sku_weight_data.sku_code,
                                    wg_sku_weight_data.sku_amount,
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
                                    sum(wg_sku_weight_data.sku_amount) AS count_amount,
                                    Sum(wg_sku_weight_data.sku_weight) AS sum_weight,
                                    tb_order_overnight.id_user_customer,
                                    tb_order_type.order_type,
                                    wg_weight_type.wg_type_name,
                                    wg_sku_item.item_name,
                                    wg_sku_item.unit
                                FROM
                                    wg_sku_weight_data
                                    LEFT JOIN tb_order_overnight ON wg_sku_weight_data.lot_number = tb_order_overnight.order_number
                                    LEFT JOIN tb_order_type ON tb_order_overnight.type_request = tb_order_type.id
                                    LEFT JOIN wg_weight_type ON wg_sku_weight_data.weighing_type = wg_weight_type.id_wg_type
                                    LEFT JOIN wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code
                                    WHERE
                                    wg_sku_weight_data.scale_number IN ('KMK12') AND
                                    (CONCAT(
                                                SUBSTRING( wg_sku_weight_data.weighing_date, 1, 4 ),
                                                SUBSTRING( wg_sku_weight_data.weighing_date, 6, 2 ),
                                                SUBSTRING( wg_sku_weight_data.weighing_date, 9, 2 ) 
                                            ) BETWEEN '20200428' AND '20200428')
                                GROUP BY
                                    wg_sku_item.item_code,wg_sku_weight_data.lot_number
                                ORDER BY
                                    wg_sku_weight_data.lot_number");
        
        return array( $balance, $order_receive,$order_send);

    }

    public function stock_of_red_receive(Request $request){

        $mindate = substr($request->daterangeReceive,6,4).substr($request->daterangeReceive,3,2).substr($request->daterangeReceive,0,2);
        $maxdate = substr($request->daterangeReceive,19,4).substr($request->daterangeReceive,16,2).substr($request->daterangeReceive,13,2);
        
        $date_range = "WHERE ( CONCAT(SUBSTRING(tb_order_offal.date, 7, 4),SUBSTRING(tb_order_offal.date, 4, 2),SUBSTRING(tb_order_offal.date, 1, 2)) 
        BETWEEN '".$mindate."' AND '".$maxdate."' )";

        $order_send = DB::select("SELECT
                                    tb_order_offal.id,
                                    tb_order_offal.order_number,
                                    tb_order_offal.total_pig,
                                    tb_order_offal.weight_range,
                                    tb_order_offal.note,
                                    tb_order_offal.date,
                                    tb_order_offal.id_user_customer,
                                    tb_order_offal.`status`,
                                    tb_order_offal.marker,
                                    tb_order_offal.round,
                                    tb_order_offal.storage_id,
                                    tb_order_type.order_type,
                                    wg_storage.name_storage,
                                    wg_storage.description,
                                    wg_sku_weight_data.sku_amount,
                                    wg_sku_weight_data.scale_number,
                                    wg_sku_weight_data.count_amount 
                                FROM
                                    tb_order_offal
                                    LEFT JOIN tb_order_type ON tb_order_offal.type_request = tb_order_type.id
                                    LEFT JOIN wg_storage ON tb_order_offal.storage_id = wg_storage.id_storage
                                    LEFT JOIN (
                                SELECT
                                    wg_sku_weight_data.*,
                                    Count( wg_sku_weight_data.sku_amount ) AS count_amount,
                                    wg_scale.department 
                                FROM
                                    wg_sku_weight_data
                                    LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number 
                                 WHERE
                                    wg_scale.department = 5
                                    AND wg_sku_weight_data.weighing_type = 2
                                GROUP BY
                                    wg_sku_weight_data.lot_number 
                                    ) AS wg_sku_weight_data ON tb_order_offal.order_number = wg_sku_weight_data.lot_number
                                    ".$date_range." 
                                ORDER BY
                                    tb_order_offal.created_at DESC ");
        
        return Datatables::of($order_send)->addIndexColumn()->make(true);
    }
    public function stock_of_red_balance(Request $request){
        $mindate = substr($request->daterangeFilter,6,4).substr($request->daterangeFilter,3,2).substr($request->daterangeFilter,0,2);
        $maxdate = substr($request->daterangeFilter,19,4).substr($request->daterangeFilter,16,2).substr($request->daterangeFilter,13,2);
        
        $date_range = "AND ( CONCAT(SUBSTRING(wg_stock.date_recieve, 7, 4),SUBSTRING(wg_stock.date_recieve, 4, 2),SUBSTRING(wg_stock.date_recieve, 1, 2)) 
        BETWEEN '".$mindate."' AND '".$maxdate."' )";

        $stock = DB::select("SELECT
                            wg_stock.id,
                            wg_stock.id_storage,
                            wg_stock.bill_number,
                            wg_stock.total_unit,
                            wg_stock.current_unit,
                            wg_stock.ref_source,
                            wg_stock.round,
                            wg_stock.date_recieve,
                            wg_stock.note,
                            wg_stock.item_code,
                            wg_stock.created_at,
                            wg_stock.updated_at,
                            wg_storage.name_storage,
                            wg_storage.type_of_storage,
                            wg_storage.description,
                            wg_storage.max_unit,
                            wg_storage.unit 
                        FROM
                            wg_stock
                            INNER JOIN wg_storage ON wg_stock.id_storage = wg_storage.id_storage 
                        WHERE
                            wg_storage.type_of_storage = 'เครื่องในแดง + หัว' 
                            ".$date_range."
                        ORDER BY
                            wg_stock.id DESC
        ");
        return Datatables::of($stock)->addIndexColumn()->make(true);
    }
    public function stock_of_red_send(Request $request){

        $mindate = substr($request->daterangeFilter,6,4).substr($request->daterangeFilter,3,2).substr($request->daterangeFilter,0,2);
        $maxdate = substr($request->daterangeFilter,19,4).substr($request->daterangeFilter,16,2).substr($request->daterangeFilter,13,2);
        
        $date_range = "WHERE ( CONCAT(SUBSTRING(tb_order_offal.date, 7, 4),SUBSTRING(tb_order_offal.date, 4, 2),SUBSTRING(tb_order_offal.date, 1, 2)) 
        BETWEEN '".$mindate."' AND '".$maxdate."' )";

        $order_send = DB::select("SELECT
                                tb_order_offal.id,
                                tb_order_offal.order_number,
                                tb_order_offal.total_pig,
                                tb_order_offal.weight_range,
                                tb_order_offal.note,
                                tb_order_offal.date,
                                tb_order_offal.id_user_customer,
                                wg_sku_weight_data.sku_amount,
                                wg_sku_weight_data.scale_number,
                                wg_sku_weight_data.count_amount,
                                tb_order_transport.order_number as order_transport,
                                tb_order_offal.`status`,
                                tb_order_offal.marker,
                                tb_order_offal.round,
                                tb_order_offal.storage_id,
                                tb_order_type.order_type,
                                wg_storage.name_storage,
                                wg_storage.description
                                FROM
                                tb_order_offal
                                LEFT JOIN tb_order_type ON tb_order_offal.type_request = tb_order_type.id
                                LEFT JOIN wg_storage ON tb_order_offal.storage_id = wg_storage.id_storage
                                LEFT JOIN (
                                SELECT
                                    wg_sku_weight_data.*,
                                    Count( wg_sku_weight_data.sku_amount ) AS count_amount,
                                    wg_scale.department 
                                FROM
                                    wg_sku_weight_data
                                    LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number 
                                WHERE
                                    wg_scale.department = 5 
                                GROUP BY
                                    wg_sku_weight_data.lot_number 
                                    ) AS wg_sku_weight_data ON tb_order_offal.order_number = wg_sku_weight_data.lot_number
                                RIGHT JOIN tb_order_transport ON tb_order_offal.order_number = tb_order_transport.order_offal_number
                                ".$date_range."
                                ORDER BY
                                tb_order_offal.created_at DESC
            ");
        
        return Datatables::of($order_send)->addIndexColumn()->make(true);
    }

 
    public function stock_data_of_white($stock_name){
        $sum_storage = DB::select("SELECT
                                wg_storage.id_storage,
                                wg_storage.name_storage,
                                wg_storage.max_unit,
                                wg_storage.current_unit,
                                wg_storage.unit,
                                wg_storage.type_of_storage,
                                wg_storage.description,
                                wg_storage.user_id,
                                wg_storage.created_at,
                                wg_storage.updated_at,
                                wg_storage.zone
                                FROM
                                wg_storage
                                WHERE wg_storage.description IN ('คอกรวม','คอกรวม','Overnight รวม','เครื่องในขาว รวม','เครื่องในแดง + หัว รวม','รอโหลด รวม')");

        $unit_today = DB::select("SELECT
                                    wg_stock_log.*,
                                    SUM(wg_stock_log.current_unit) as sum_unit_add,
                                    DATE_FORMAT( now( ), '%d/%m/%Y' ) AS date_today,
                                    wg_storage.type_of_storage,
                                    wg_storage.description 
                                FROM
                                    wg_stock_log
                                    LEFT JOIN wg_storage ON wg_stock_log.id_storage = wg_storage.id_storage 
                                WHERE
                                    wg_stock_log.date_recieve = DATE_FORMAT( now( ), '%d/%m/%Y' ) 
                                    AND wg_storage.type_of_storage = '$stock_name'
                                    AND wg_stock_log.action = 'add' ");
        
        $order_send = DB::select("SELECT
                                    tb_order_offal.id,
                                    tb_order_offal.order_number,
                                    wg_sku_weight_data.sku_amount,
                                    wg_sku_weight_data.scale_number,
                                    sum( wg_sku_weight_data.count_amount ) AS sum_unit_add 
                                FROM
                                    tb_order_offal
                                    LEFT JOIN tb_order_type ON tb_order_offal.type_request = tb_order_type.id
                                    LEFT JOIN wg_storage ON tb_order_offal.storage_id = wg_storage.id_storage
                                    LEFT JOIN (
                                SELECT
                                    wg_sku_weight_data.*,
                                    Count( wg_sku_weight_data.sku_amount ) AS count_amount,
                                    wg_scale.department 
                                FROM
                                    wg_sku_weight_data
                                    LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number 
                                WHERE
                                    wg_scale.department = 6
                                    AND wg_sku_weight_data.weighing_type = 2
                                GROUP BY
                                    wg_sku_weight_data.lot_number 
                                    ) AS wg_sku_weight_data ON tb_order_offal.order_number = wg_sku_weight_data.lot_number 
                                WHERE
                                    tb_order_offal.date = DATE_FORMAT( now( ), '%d/%m/%Y' ) 
                                ORDER BY
                                    tb_order_offal.created_at DESC
        ");

        $unit_release = DB::select("SELECT
                                wg_sku_weight_data.id,
                                wg_sku_weight_data.lot_number,
                                SUM(wg_sku_weight_data.sku_amount) sum_release,
                                wg_sku_weight_data.sku_weight,
                                wg_sku_weight_data.sku_unit,
                                wg_scale.process_number
                                FROM
                                wg_sku_weight_data
                                LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                                WHERE
                                DATE_FORMAT(wg_sku_weight_data.weighing_date,'%d/%m/%Y') = DATE_FORMAT(now(),'%d/%m/%Y')
                                AND wg_scale.process_number = 5 ");

        $order_release = DB::select("SELECT
                                    wg_sku_weight_data.id,
                                    wg_sku_weight_data.lot_number,
                                    wg_sku_weight_data.sku_code,
                                    Sum(wg_sku_weight_data.sku_amount) AS sum_sku_amount,
                                    Sum(wg_sku_weight_data.sku_weight) AS sum_sku_weight,
                                    wg_sku_weight_data.weighing_type,
                                    wg_sku_weight_data.weighing_place,
                                    wg_sku_weight_data.scale_number,
                                    wg_sku_weight_data.storage_name,
                                    wg_sku_weight_data.storage_compartment,
                                    wg_sku_weight_data.weighing_ref,
                                    wg_sku_weight_data.weighing_date,
                                    wg_sku_weight_data.note,
                                    wg_sku_weight_data.process_number,
                                    wg_sku_item.item_name,
                                    tb_order.total_pig,
                                    DATE_FORMAT( wg_sku_weight_data.weighing_date, '%d/%m/%Y' ) AS date_,
                                    tb_order.type_request,
                                    wg_scale.process_number
                                    FROM
                                    wg_sku_weight_data
                                    LEFT JOIN wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code
                                    LEFT JOIN tb_order ON wg_sku_weight_data.lot_number = tb_order.order_number
                                    LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                                    WHERE
                                    wg_sku_weight_data.weighing_date >= CURRENT_DATE - INTERVAL '7' DAY
                                    AND wg_scale.process_number = 5
                                    GROUP BY
                                    wg_sku_weight_data.lot_number");

            $sum_order_release = 0;
            foreach ($order_release as $key => $release) {
                $sum_order_release =  $sum_order_release + $release->sum_sku_amount;
            }

        $order_process = DB::select("SELECT
                tb_order.id,
                tb_order.order_number,
                Sum(tb_order.total_pig) AS sum_processing,
                tb_order.weight_range,
                tb_product_plan.plan_slice
                FROM
                tb_order
                LEFT JOIN tb_product_plan ON tb_order.order_number = tb_product_plan.order_number
                WHERE
                tb_order.type_request <> 4 AND
                tb_product_plan.plan_slice = DATE_FORMAT( now( ), '%d/%m/%Y' )
                ORDER BY
                tb_order.created_at DESC
                ");

        return view('stock.entrails',compact('stock_name','sum_storage','unit_today','unit_release','order_release','order_process','sum_order_release','order_send'));
        // return view('stock.stock_data_of_white',compact('stock_name','sum_storage','unit_today','unit_release','order_release','order_process','sum_order_release','order_send'));
    }

    public function entrails_item($stock_name){
        $sum_storage = DB::select("SELECT
                                wg_storage.id_storage,
                                wg_storage.name_storage,
                                wg_storage.max_unit,
                                wg_storage.current_unit,
                                wg_storage.unit,
                                wg_storage.type_of_storage,
                                wg_storage.description,
                                wg_storage.user_id,
                                wg_storage.created_at,
                                wg_storage.updated_at,
                                wg_storage.zone
                                FROM
                                wg_storage
                                WHERE wg_storage.description IN ('คอกรวม','คอกรวม','Overnight รวม','เครื่องในขาว รวม','เครื่องในแดง + หัว รวม','รอโหลด รวม')");

        $unit_today = DB::select("SELECT
                                    wg_stock_log.*,
                                    SUM(wg_stock_log.current_unit) as sum_unit_add,
                                    DATE_FORMAT( now( ), '%d/%m/%Y' ) AS date_today,
                                    wg_storage.type_of_storage,
                                    wg_storage.description 
                                FROM
                                    wg_stock_log
                                    LEFT JOIN wg_storage ON wg_stock_log.id_storage = wg_storage.id_storage 
                                WHERE
                                    wg_stock_log.date_recieve = DATE_FORMAT( now( ), '%d/%m/%Y' ) 
                                    AND wg_storage.type_of_storage = '$stock_name'
                                    AND wg_stock_log.action = 'add' ");
        
        $order_send = DB::select("SELECT
                                    tb_order_offal.id,
                                    tb_order_offal.order_number,
                                    wg_sku_weight_data.sku_amount,
                                    wg_sku_weight_data.scale_number,
                                    sum( wg_sku_weight_data.count_amount ) AS sum_unit_add 
                                FROM
                                    tb_order_offal
                                    LEFT JOIN tb_order_type ON tb_order_offal.type_request = tb_order_type.id
                                    LEFT JOIN wg_storage ON tb_order_offal.storage_id = wg_storage.id_storage
                                    LEFT JOIN (
                                SELECT
                                    wg_sku_weight_data.*,
                                    Count( wg_sku_weight_data.sku_amount ) AS count_amount,
                                    wg_scale.department 
                                FROM
                                    wg_sku_weight_data
                                    LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number 
                                WHERE
                                    wg_scale.department = 6
                                    AND wg_sku_weight_data.weighing_type = 2
                                GROUP BY
                                    wg_sku_weight_data.lot_number 
                                    ) AS wg_sku_weight_data ON tb_order_offal.order_number = wg_sku_weight_data.lot_number 
                                WHERE
                                    tb_order_offal.date = DATE_FORMAT( now( ), '%d/%m/%Y' ) 
                                ORDER BY
                                    tb_order_offal.created_at DESC
        ");

        $unit_release = DB::select("SELECT
                                wg_sku_weight_data.id,
                                wg_sku_weight_data.lot_number,
                                SUM(wg_sku_weight_data.sku_amount) sum_release,
                                wg_sku_weight_data.sku_weight,
                                wg_sku_weight_data.sku_unit,
                                wg_scale.process_number
                                FROM
                                wg_sku_weight_data
                                LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                                WHERE
                                DATE_FORMAT(wg_sku_weight_data.weighing_date,'%d/%m/%Y') = DATE_FORMAT(now(),'%d/%m/%Y')
                                AND wg_scale.process_number = 5 ");

        $order_release = DB::select("SELECT
                                    wg_sku_weight_data.id,
                                    wg_sku_weight_data.lot_number,
                                    wg_sku_weight_data.sku_code,
                                    Sum(wg_sku_weight_data.sku_amount) AS sum_sku_amount,
                                    Sum(wg_sku_weight_data.sku_weight) AS sum_sku_weight,
                                    wg_sku_weight_data.weighing_type,
                                    wg_sku_weight_data.weighing_place,
                                    wg_sku_weight_data.scale_number,
                                    wg_sku_weight_data.storage_name,
                                    wg_sku_weight_data.storage_compartment,
                                    wg_sku_weight_data.weighing_ref,
                                    wg_sku_weight_data.weighing_date,
                                    wg_sku_weight_data.note,
                                    wg_sku_weight_data.process_number,
                                    wg_sku_item.item_name,
                                    tb_order.total_pig,
                                    DATE_FORMAT( wg_sku_weight_data.weighing_date, '%d/%m/%Y' ) AS date_,
                                    tb_order.type_request,
                                    wg_scale.process_number
                                    FROM
                                    wg_sku_weight_data
                                    LEFT JOIN wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code
                                    LEFT JOIN tb_order ON wg_sku_weight_data.lot_number = tb_order.order_number
                                    LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                                    WHERE
                                    wg_sku_weight_data.weighing_date >= CURRENT_DATE - INTERVAL '7' DAY
                                    AND wg_scale.process_number = 5
                                    GROUP BY
                                    wg_sku_weight_data.lot_number");

            $sum_order_release = 0;
            foreach ($order_release as $key => $release) {
                $sum_order_release =  $sum_order_release + $release->sum_sku_amount;
            }

        $order_process = DB::select("SELECT
                tb_order.id,
                tb_order.order_number,
                Sum(tb_order.total_pig) AS sum_processing,
                tb_order.weight_range,
                tb_product_plan.plan_slice
                FROM
                tb_order
                LEFT JOIN tb_product_plan ON tb_order.order_number = tb_product_plan.order_number
                WHERE
                tb_order.type_request <> 4 AND
                tb_product_plan.plan_slice = DATE_FORMAT( now( ), '%d/%m/%Y' )
                ORDER BY
                tb_order.created_at DESC
                ");
        
        $item = DB::select("SELECT * FROM wg_sku_item WHERE wg_sku_item.group_show_report = 2 ORDER BY wg_sku_item.item_code");

        return view('stock.entrails_item',compact('stock_name','sum_storage','unit_today','unit_release','order_release','order_process','sum_order_release','order_send','item'));
        // return view('stock.stock_data_of_white',compact('stock_name','sum_storage','unit_today','unit_release','order_release','order_process','sum_order_release','order_send'));
    }

    public function stock_data_of_dc($stock_name){
        $sum_storage = DB::select("SELECT
                                wg_storage.id_storage,
                                wg_storage.name_storage,
                                wg_storage.max_unit,
                                wg_storage.current_unit,
                                wg_storage.unit,
                                wg_storage.type_of_storage,
                                wg_storage.description,
                                wg_storage.user_id,
                                wg_storage.created_at,
                                wg_storage.updated_at,
                                wg_storage.zone
                                FROM
                                wg_storage
                                WHERE wg_storage.description IN ('คอกรวม','คอกรวม','Overnight รวม','เครื่องในขาว รวม','เครื่องในแดง + หัว รวม','รอโหลด รวม')");

        $unit_today = DB::select("SELECT
                                    wg_stock_log.*,
                                    SUM(wg_stock_log.current_unit) as sum_unit_add,
                                    DATE_FORMAT( now( ), '%d/%m/%Y' ) AS date_today,
                                    wg_storage.type_of_storage,
                                    wg_storage.description 
                                FROM
                                    wg_stock_log
                                    LEFT JOIN wg_storage ON wg_stock_log.id_storage = wg_storage.id_storage 
                                WHERE
                                    wg_stock_log.date_recieve = DATE_FORMAT( now( ), '%d/%m/%Y' ) 
                                    AND wg_storage.type_of_storage = '$stock_name'
                                    AND wg_stock_log.action = 'add' ");
        
        $order_send = DB::select("SELECT
                                    tb_order_offal.id,
                                    tb_order_offal.order_number,
                                    wg_sku_weight_data.sku_amount,
                                    wg_sku_weight_data.scale_number,
                                    sum( wg_sku_weight_data.count_amount ) AS sum_unit_add 
                                FROM
                                    tb_order_offal
                                    LEFT JOIN tb_order_type ON tb_order_offal.type_request = tb_order_type.id
                                    LEFT JOIN wg_storage ON tb_order_offal.storage_id = wg_storage.id_storage
                                    LEFT JOIN (
                                SELECT
                                    wg_sku_weight_data.*,
                                    Count( wg_sku_weight_data.sku_amount ) AS count_amount,
                                    wg_scale.department 
                                FROM
                                    wg_sku_weight_data
                                    LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number 
                                WHERE
                                    wg_scale.department = 6
                                    AND wg_sku_weight_data.weighing_type = 2
                                GROUP BY
                                    wg_sku_weight_data.lot_number 
                                    ) AS wg_sku_weight_data ON tb_order_offal.order_number = wg_sku_weight_data.lot_number 
                                WHERE
                                    tb_order_offal.date = DATE_FORMAT( now( ), '%d/%m/%Y' ) 
                                ORDER BY
                                    tb_order_offal.created_at DESC
        ");

        $unit_release = DB::select("SELECT
                                wg_sku_weight_data.id,
                                wg_sku_weight_data.lot_number,
                                SUM(wg_sku_weight_data.sku_amount) sum_release,
                                wg_sku_weight_data.sku_weight,
                                wg_sku_weight_data.sku_unit,
                                wg_scale.process_number
                                FROM
                                wg_sku_weight_data
                                LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                                WHERE
                                DATE_FORMAT(wg_sku_weight_data.weighing_date,'%d/%m/%Y') = DATE_FORMAT(now(),'%d/%m/%Y')
                                AND wg_scale.process_number = 5 ");

        $order_release = DB::select("SELECT
                                    wg_sku_weight_data.id,
                                    wg_sku_weight_data.lot_number,
                                    wg_sku_weight_data.sku_code,
                                    Sum(wg_sku_weight_data.sku_amount) AS sum_sku_amount,
                                    Sum(wg_sku_weight_data.sku_weight) AS sum_sku_weight,
                                    wg_sku_weight_data.weighing_type,
                                    wg_sku_weight_data.weighing_place,
                                    wg_sku_weight_data.scale_number,
                                    wg_sku_weight_data.storage_name,
                                    wg_sku_weight_data.storage_compartment,
                                    wg_sku_weight_data.weighing_ref,
                                    wg_sku_weight_data.weighing_date,
                                    wg_sku_weight_data.note,
                                    wg_sku_weight_data.process_number,
                                    wg_sku_item.item_name,
                                    tb_order.total_pig,
                                    DATE_FORMAT( wg_sku_weight_data.weighing_date, '%d/%m/%Y' ) AS date_,
                                    tb_order.type_request,
                                    wg_scale.process_number
                                    FROM
                                    wg_sku_weight_data
                                    LEFT JOIN wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code
                                    LEFT JOIN tb_order ON wg_sku_weight_data.lot_number = tb_order.order_number
                                    LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                                    WHERE
                                    wg_sku_weight_data.weighing_date >= CURRENT_DATE - INTERVAL '7' DAY
                                    AND wg_scale.process_number = 5
                                    GROUP BY
                                    wg_sku_weight_data.lot_number");

            $sum_order_release = 0;
            foreach ($order_release as $key => $release) {
                $sum_order_release =  $sum_order_release + $release->sum_sku_amount;
            }

        $order_process = DB::select("SELECT
                tb_order.id,
                tb_order.order_number,
                Sum(tb_order.total_pig) AS sum_processing,
                tb_order.weight_range,
                tb_product_plan.plan_slice
                FROM
                tb_order
                LEFT JOIN tb_product_plan ON tb_order.order_number = tb_product_plan.order_number
                WHERE
                tb_order.type_request <> 4 AND
                tb_product_plan.plan_slice = DATE_FORMAT( now( ), '%d/%m/%Y' )
                ORDER BY
                tb_order.created_at DESC
                ");

        return view('stock.stock_data_of_dc',compact('stock_name','sum_storage','unit_today','unit_release','order_release','order_process','sum_order_release','order_send'));
        // return view('stock.stock_data_of_white',compact('stock_name','sum_storage','unit_today','unit_release','order_release','order_process','sum_order_release','order_send'));
    }

    public function stock_of_dc(Request $request){
        $mindate = substr($request->daterangeFilter,6,4).substr($request->daterangeFilter,3,2).substr($request->daterangeFilter,0,2);
        $maxdate = substr($request->daterangeFilter,19,4).substr($request->daterangeFilter,16,2).substr($request->daterangeFilter,13,2);

        $dc_receive = DB::select("SELECT
                                    wg_sku_weight_data.id,
                                    wg_sku_weight_data.lot_number,
                                    wg_sku_weight_data.sku_id,
                                    wg_sku_weight_data.sku_code,
                                    wg_sku_weight_data.sku_amount,
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
                                    sum( wg_sku_weight_data.sku_amount ) AS count_amount,
                                    Sum( wg_sku_weight_data.sku_weight ) AS sum_weight,
                                    tb_order_overnight.id_user_customer,
                                    tb_order_type.order_type,
                                    wg_weight_type.wg_type_name,
                                    wg_sku_item.item_name,
                                    wg_sku_item.unit 
                                FROM
                                    wg_sku_weight_data
                                    LEFT JOIN tb_order_overnight ON wg_sku_weight_data.lot_number = tb_order_overnight.order_number
                                    LEFT JOIN tb_order_type ON tb_order_overnight.type_request = tb_order_type.id
                                    LEFT JOIN wg_weight_type ON wg_sku_weight_data.weighing_type = wg_weight_type.id_wg_type
                                    LEFT JOIN wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code 
                                WHERE
                                    wg_sku_weight_data.scale_number IN ( 'KMK08', 'KMK09', 'KMK11', 'KMK06', 'KMK10' ) 
                                    AND wg_sku_weight_data.weighing_type = 2 
                                    AND ( wg_sku_weight_data.lot_number LIKE ( 'CL%' ) OR wg_sku_weight_data.lot_number LIKE ( 'OF%' ) ) 
                                    AND (
                                        CONCAT(
                                            SUBSTRING( wg_sku_weight_data.weighing_date, 1, 4 ),
                                            SUBSTRING( wg_sku_weight_data.weighing_date, 6, 2 ),
                                            SUBSTRING( wg_sku_weight_data.weighing_date, 9, 2 ) 
                                        ) BETWEEN '$mindate' 
                                        AND '$maxdate' 
                                    ) 
                                GROUP BY
                                    wg_sku_item.item_code,
                                    wg_sku_weight_data.lot_number 
                                ORDER BY
                                    wg_sku_weight_data.lot_number,
                                    wg_sku_item.item_code ASC");
        
                                    
        $dc_send = DB::select("SELECT
                                    tb_order_transport.order_number,
                                    tb_order_transport.id_user_customer,
                                    tb_order_transport.date_transport,
                                    wg_sku_weight_data.lot_number,
                                    sum( wg_sku_weight_data.sku_amount ) AS count_amount,
                                    Sum( wg_sku_weight_data.sku_weight ) AS sum_weight 
                                FROM
                                    tb_order_transport
                                    LEFT JOIN wg_sku_weight_data ON tb_order_transport.order_cutting_number = wg_sku_weight_data.lot_number 
                                    OR tb_order_transport.order_offal_number = wg_sku_weight_data.lot_number 
                                WHERE
                                    (
                                        CONCAT(
                                            SUBSTRING( tb_order_transport.date_transport, 7, 4 ),
                                            SUBSTRING( tb_order_transport.date_transport, 4, 2 ),
                                            SUBSTRING( tb_order_transport.date_transport, 1, 2 ) 
                                        ) BETWEEN '$mindate' 
                                        AND '$maxdate' 
                                    ) 
                                GROUP BY
                                    wg_sku_weight_data.lot_number 
                                ORDER BY
                                    tb_order_transport.order_number ASC");

        $date_balance = substr($request->daterangeFilter,6,4).'/'.substr($request->daterangeFilter,3,2).'/'.substr($request->daterangeFilter,0,2).' '.'13:00:00';
        $balance = DB::select("SELECT
                                    wg_storage_daily.id,
                                    wg_storage_daily.id_storage,
                                    wg_storage_daily.name_storage,
                                    wg_storage_daily.count_unit as balance,
                                    wg_storage_daily.unit,
                                    wg_storage_daily.type_of_storage,
                                    wg_storage_daily.description,
                                    wg_storage_daily.user_id,
                                    wg_storage_daily.created_at,
                                    wg_storage_daily.updated_at,
                                    wg_storage_daily.zone,
                                    wg_storage_daily.date_summary,
                                    wg_storage_daily.weight_summary
                                FROM
                                    wg_storage_daily
                                WHERE
                                    wg_storage_daily.id_storage = '106' AND
                                    wg_storage_daily.date_summary = DATE_FORMAT(('$date_balance' - INTERVAL 1 DAY),'%d/%m/%Y')
                                ORDER BY created_at LIMIT 1
        ");

        $mindate_check = substr($request->daterangeFilter,0,2)."/".substr($request->daterangeFilter,3,2)."/".substr($request->daterangeFilter,6,4);
        $check_count_stock = DB::select("SELECT
                                            wg_storage_daily.id,
                                            wg_storage_daily.id_storage,
                                            wg_storage_daily.name_storage,
                                            wg_storage_daily.count_unit,
                                            wg_storage_daily.count_unit_real,
                                            wg_storage_daily.unit,
                                            wg_storage_daily.type_of_storage,
                                            wg_storage_daily.description,
                                            wg_storage_daily.user_id,
                                            wg_storage_daily.created_at,
                                            wg_storage_daily.updated_at,
                                            wg_storage_daily.zone,
                                            wg_storage_daily.date_summary,
                                            wg_storage_daily.weight_summary
                                        FROM
                                            wg_storage_daily
                                        WHERE
                                            wg_storage_daily.id_storage = '106' AND
                                            wg_storage_daily.date_summary = '$mindate_check'");

        return array($dc_receive, $dc_send, $balance, $check_count_stock);
    }

    public function stock_of_white_receive(Request $request){

        $mindate = substr($request->daterangeFilter,6,4).substr($request->daterangeFilter,3,2).substr($request->daterangeFilter,0,2);
        $maxdate = substr($request->daterangeFilter,19,4).substr($request->daterangeFilter,16,2).substr($request->daterangeFilter,13,2);
        
        $date_range = "WHERE ( CONCAT(SUBSTRING(tb_order_offal.date, 7, 4),SUBSTRING(tb_order_offal.date, 4, 2),SUBSTRING(tb_order_offal.date, 1, 2)) 
        BETWEEN '".$mindate."' AND '".$maxdate."' )";

        $order_send = DB::select("SELECT
                                    tb_order_offal.id,
                                    tb_order_offal.order_number,
                                    tb_order_offal.total_pig,
                                    tb_order_offal.weight_range,
                                    tb_order_offal.note,
                                    tb_order_offal.date,
                                    tb_order_offal.id_user_customer,
                                    tb_order_offal.`status`,
                                    tb_order_offal.marker,
                                    tb_order_offal.round,
                                    tb_order_offal.storage_id,
                                    tb_order_type.order_type,
                                    wg_storage.name_storage,
                                    wg_storage.description,
                                    wg_sku_weight_data.sku_amount,
                                    wg_sku_weight_data.scale_number,
                                    wg_sku_weight_data.count_amount 
                                FROM
                                    tb_order_offal
                                    LEFT JOIN tb_order_type ON tb_order_offal.type_request = tb_order_type.id
                                    LEFT JOIN wg_storage ON tb_order_offal.storage_id = wg_storage.id_storage
                                    LEFT JOIN (
                                SELECT
                                    wg_sku_weight_data.*,
                                    Count( wg_sku_weight_data.sku_amount ) AS count_amount,
                                    wg_scale.department 
                                FROM
                                    wg_sku_weight_data
                                    LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number 
                                WHERE
                                    wg_scale.department = 6
                                    AND wg_sku_weight_data.weighing_type = 2
                                GROUP BY
                                    wg_sku_weight_data.lot_number 
                                    ) AS wg_sku_weight_data ON tb_order_offal.order_number = wg_sku_weight_data.lot_number
                                    ".$date_range." 
                                ORDER BY
                                    tb_order_offal.created_at DESC
            ");
        return array($order_send);
        return Datatables::of($order_send)->addIndexColumn()->make(true);
    }
    public function stock_of_white_balance(Request $request){
        $mindate = substr($request->daterangeFilter,6,4).substr($request->daterangeFilter,3,2).substr($request->daterangeFilter,0,2);
        $maxdate = substr($request->daterangeFilter,19,4).substr($request->daterangeFilter,16,2).substr($request->daterangeFilter,13,2);
        
        $date_range = "AND ( CONCAT(SUBSTRING(wg_stock.date_recieve, 7, 4),SUBSTRING(wg_stock.date_recieve, 4, 2),SUBSTRING(wg_stock.date_recieve, 1, 2)) 
        BETWEEN '".$mindate."' AND '".$maxdate."' )";

        $stock = DB::select("SELECT
                            wg_stock.id,
                            wg_stock.id_storage,
                            wg_stock.bill_number,
                            wg_stock.total_unit,
                            wg_stock.current_unit,
                            wg_stock.ref_source,
                            wg_stock.round,
                            wg_stock.date_recieve,
                            wg_stock.note,
                            wg_stock.item_code,
                            wg_stock.created_at,
                            wg_stock.updated_at,
                            wg_storage.name_storage,
                            wg_storage.type_of_storage,
                            wg_storage.description,
                            wg_storage.max_unit,
                            wg_storage.unit 
                        FROM
                            wg_stock
                            INNER JOIN wg_storage ON wg_stock.id_storage = wg_storage.id_storage 
                        WHERE
                            wg_storage.type_of_storage = 'เครื่องในขาว' 
                            ".$date_range."
                        ORDER BY
                            wg_stock.id DESC
        ");
        return Datatables::of($stock)->addIndexColumn()->make(true);
    }
    public function stock_of_white_send(Request $request){

        $mindate = substr($request->daterangeFilter,6,4).substr($request->daterangeFilter,3,2).substr($request->daterangeFilter,0,2);
        $maxdate = substr($request->daterangeFilter,19,4).substr($request->daterangeFilter,16,2).substr($request->daterangeFilter,13,2);
        
        $date_range = "WHERE ( CONCAT(SUBSTRING(tb_order_offal.date, 7, 4),SUBSTRING(tb_order_offal.date, 4, 2),SUBSTRING(tb_order_offal.date, 1, 2)) 
        BETWEEN '".$mindate."' AND '".$maxdate."' )";

        $order_send = DB::select("SELECT
                                tb_order_offal.id,
                                tb_order_offal.order_number,
                                tb_order_offal.total_pig,
                                tb_order_offal.weight_range,
                                tb_order_offal.note,
                                tb_order_offal.date,
                                tb_order_offal.id_user_customer,
                                wg_sku_weight_data.sku_amount,
                                wg_sku_weight_data.scale_number,
                                wg_sku_weight_data.count_amount,
                                tb_order_transport.order_number as order_transport,
                                tb_order_offal.`status`,
                                tb_order_offal.marker,
                                tb_order_offal.round,
                                tb_order_offal.storage_id,
                                tb_order_type.order_type,
                                wg_storage.name_storage,
                                wg_storage.description
                                FROM
                                tb_order_offal
                                LEFT JOIN tb_order_type ON tb_order_offal.type_request = tb_order_type.id
                                LEFT JOIN wg_storage ON tb_order_offal.storage_id = wg_storage.id_storage
                                LEFT JOIN (
                                SELECT
                                    wg_sku_weight_data.*,
                                    Count( wg_sku_weight_data.sku_amount ) AS count_amount,
                                    wg_scale.department 
                                FROM
                                    wg_sku_weight_data
                                    LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number 
                                WHERE
                                    wg_scale.department = 6
                                    AND wg_sku_weight_data.weighing_type = 2
                                GROUP BY
                                    wg_sku_weight_data.lot_number 
                                    ) AS wg_sku_weight_data ON tb_order_offal.order_number = wg_sku_weight_data.lot_number
                                RIGHT JOIN tb_order_transport ON tb_order_offal.order_number = tb_order_transport.order_offal_number
                                ".$date_range."
                                ORDER BY
                                tb_order_offal.created_at DESC
            ");
        
        return Datatables::of($order_send)->addIndexColumn()->make(true);
    }
    
    public function stock_of_entrails(Request $request){

        $mindate = substr($request->daterangeFilter,6,4).substr($request->daterangeFilter,3,2).substr($request->daterangeFilter,0,2);
        $maxdate = substr($request->daterangeFilter,19,4).substr($request->daterangeFilter,16,2).substr($request->daterangeFilter,13,2);

        $order_in = DB::select("SELECT
                                    wg_sku_weight_data.id,
                                    wg_sku_weight_data.lot_number,
                                    wg_sku_weight_data.sku_id,
                                    wg_sku_weight_data.sku_code,
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
                                    wg_sku_weight_data.sku_amount,
                                    wg_sku_weight_data.sku_weight,
                                    Sum( wg_sku_weight_data.sku_amount ) AS count_amount,
                                    Sum( wg_sku_weight_data.sku_weight ) AS sum_weight,
                                    wg_sku_item.item_code,
                                    wg_sku_item.item_name,
                                    wg_sku_item.unit,
                                    wg_weight_type.wg_type_name,
                                    tb_order.id_user_customer,
                                    tb_order.type_request 
                                FROM
                                    wg_sku_weight_data
                                    LEFT JOIN wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code
                                    LEFT JOIN tb_order ON wg_sku_weight_data.lot_number = tb_order.order_number 
                                    LEFT JOIN wg_weight_type ON wg_sku_weight_data.weighing_type = wg_weight_type.id_wg_type
                                WHERE
                                    wg_sku_weight_data.scale_number IN ( 'KMK05', 'KMK06' ) 
                                    AND ( ( wg_sku_weight_data.sku_code LIKE '50%' ) OR ( wg_sku_weight_data.sku_code LIKE '60%' ) ) 
                                    AND (
                                        CONCAT(
                                            SUBSTRING( wg_sku_weight_data.weighing_date, 1, 4 ),
                                            SUBSTRING( wg_sku_weight_data.weighing_date, 6, 2 ),
                                            SUBSTRING( wg_sku_weight_data.weighing_date, 9, 2 ) 
                                        ) BETWEEN '$mindate' 
                                        AND '$maxdate' 
                                    ) 
                                GROUP BY
                                    wg_sku_item.item_code,
                                    wg_sku_weight_data.lot_number 
                                ORDER BY
                                    wg_sku_weight_data.lot_number,wg_sku_item.item_code  ASC");
    
            $order_send = DB::select("SELECT
                                        wg_sku_weight_data.id,
                                        wg_sku_weight_data.lot_number,
                                        wg_sku_weight_data.sku_id,
                                        wg_sku_weight_data.sku_code,
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
                                        wg_sku_weight_data.sku_amount,
                                        wg_sku_weight_data.sku_weight,
                                        Sum( wg_sku_weight_data.sku_amount ) AS count_amount,
                                        Sum( wg_sku_weight_data.sku_weight ) AS sum_weight,
                                        wg_sku_item.item_code,
                                        wg_sku_item.item_name,
                                        wg_sku_item.unit,
                                        wg_weight_type.wg_type_name,
                                        tb_order_offal.id_user_customer 
                                    FROM
                                        wg_sku_weight_data
                                        LEFT JOIN wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code AND wg_sku_item.wg_sku_id != '30'
                                        LEFT JOIN tb_order_offal ON wg_sku_weight_data.lot_number = tb_order_offal.order_number 
                                        LEFT JOIN wg_weight_type ON wg_sku_weight_data.weighing_type = wg_weight_type.id_wg_type
                                    WHERE
                                        wg_sku_weight_data.scale_number IN ( 'KMK10', 'KMK06' ) 
                                        AND ( ( wg_sku_weight_data.sku_code NOT LIKE '50%' ) AND ( wg_sku_weight_data.sku_code NOT LIKE '60%' ) ) 
                                        AND ( wg_sku_weight_data.sku_code NOT IN ( 'ซีก', 'ซาก', '0102', '0101' ) ) 
                                        AND wg_sku_weight_data.weighing_type = 2
                                        AND (
                                            CONCAT(
                                                SUBSTRING( wg_sku_weight_data.weighing_date, 1, 4 ),
                                                SUBSTRING( wg_sku_weight_data.weighing_date, 6, 2 ),
                                                SUBSTRING( wg_sku_weight_data.weighing_date, 9, 2 ) 
                                            ) BETWEEN '$mindate' 
                                        AND '$maxdate'  
                                        ) 
                                    GROUP BY
                                        wg_sku_item.item_code,
                                        wg_sku_weight_data.lot_number 
                                    ORDER BY
                                    wg_sku_weight_data.lot_number ASC");
                $date_balance = substr($request->daterangeFilter,6,4).'-'.substr($request->daterangeFilter,3,2).'-'.substr($request->daterangeFilter,0,2).' '.'13:00:00';

                $balance = DB::select("SELECT
                    wg_storage_daily.id,
                    wg_storage_daily.id_storage,
                    wg_storage_daily.name_storage,
                    wg_storage_daily.count_unit as balance,
                    wg_storage_daily.unit,
                    wg_storage_daily.type_of_storage,
                    wg_storage_daily.description,
                    wg_storage_daily.user_id,
                    wg_storage_daily.created_at,
                    wg_storage_daily.updated_at,
                    wg_storage_daily.zone,
                    wg_storage_daily.date_summary,
                    wg_storage_daily.weight_summary
                    FROM
                    wg_storage_daily
                    WHERE
                    wg_storage_daily.id_storage = '104' AND
                    wg_storage_daily.date_summary = DATE_FORMAT(('$date_balance' - INTERVAL 1 DAY),'%d/%m/%Y')
                    ORDER BY created_at LIMIT 1
                ");
         $mindate_check = substr($request->daterangeFilter,0,2)."/".substr($request->daterangeFilter,3,2)."/".substr($request->daterangeFilter,6,4);
         $check_count_stock = DB::select("SELECT
                                     wg_storage_daily.id,
                                     wg_storage_daily.id_storage,
                                     wg_storage_daily.name_storage,
                                     wg_storage_daily.count_unit,
                                     wg_storage_daily.count_unit_real,
                                     wg_storage_daily.unit,
                                     wg_storage_daily.type_of_storage,
                                     wg_storage_daily.description,
                                     wg_storage_daily.user_id,
                                     wg_storage_daily.created_at,
                                     wg_storage_daily.updated_at,
                                     wg_storage_daily.zone,
                                     wg_storage_daily.date_summary,
                                     wg_storage_daily.weight_summary
                                 FROM
                                     wg_storage_daily
                                 WHERE
                                     wg_storage_daily.id_storage = 104 AND
                                     wg_storage_daily.date_summary = '$mindate_check'");          
        
         $transform_b = DB::select("SELECT
                                wg_sku_weight_data.id,
                                wg_sku_weight_data.lot_number,
                                wg_sku_weight_data.sku_id,
                                wg_sku_weight_data.sku_code,
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
                                wg_sku_weight_data.sku_amount,
                                wg_sku_weight_data.sku_weight,
                                Sum( wg_sku_weight_data.sku_amount ) AS count_amount,
                                Sum( wg_sku_weight_data.sku_weight ) AS sum_weight,
                                wg_sku_item.item_code,
                                wg_sku_item.item_name,
                                wg_sku_item.unit,
                                wg_weight_type.wg_type_name,
                                tb_order_offal.id_user_customer 
                            FROM
                                wg_sku_weight_data
                                LEFT JOIN wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code 
                                AND wg_sku_item.wg_sku_id != '30'
                                LEFT JOIN tb_order_offal ON wg_sku_weight_data.lot_number = tb_order_offal.order_number
                                LEFT JOIN wg_weight_type ON wg_sku_weight_data.weighing_type = wg_weight_type.id_wg_type 
                            WHERE
                                wg_sku_weight_data.scale_number IN ( 'KMK10', 'KMK06' ) 
                                AND ( ( wg_sku_weight_data.sku_code NOT LIKE '50%' ) AND ( wg_sku_weight_data.sku_code NOT LIKE '60%' ) ) 
                                AND ( wg_sku_weight_data.sku_code NOT IN ( 'ซีก', 'ซาก', '0102', '0101' ) ) 
                                AND wg_sku_weight_data.weighing_type IN (11)
                                AND (
                                    CONCAT(
                                        SUBSTRING( wg_sku_weight_data.weighing_date, 1, 4 ),
                                        SUBSTRING( wg_sku_weight_data.weighing_date, 6, 2 ),
                                        SUBSTRING( wg_sku_weight_data.weighing_date, 9, 2 ) 
                                    ) BETWEEN '$mindate' 
                                    AND '$maxdate' 
                                ) 
                            GROUP BY
                                wg_sku_item.item_code,
                                wg_sku_weight_data.lot_number 
                            ORDER BY
                                wg_sku_weight_data.lot_number,wg_sku_item.item_code ASC");
            
            $transform_a = DB::select("SELECT
                                            wg_sku_weight_data.id,
                                            wg_sku_weight_data.lot_number,
                                            wg_sku_weight_data.sku_id,
                                            wg_sku_weight_data.sku_code,
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
                                            wg_sku_weight_data.sku_amount,
                                            wg_sku_weight_data.sku_weight,
                                            Sum( wg_sku_weight_data.sku_amount ) AS count_amount,
                                            Sum( wg_sku_weight_data.sku_weight ) AS sum_weight,
                                            wg_sku_item.item_code,
                                            wg_sku_item.item_name,
                                            wg_sku_item.unit,
                                            wg_weight_type.wg_type_name,
                                            tb_order_offal.id_user_customer 
                                        FROM
                                            wg_sku_weight_data
                                            LEFT JOIN wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code 
                                            AND wg_sku_item.wg_sku_id != '30'
                                            LEFT JOIN tb_order_offal ON wg_sku_weight_data.lot_number = tb_order_offal.order_number
                                            LEFT JOIN wg_weight_type ON wg_sku_weight_data.weighing_type = wg_weight_type.id_wg_type 
                                        WHERE
                                            wg_sku_weight_data.scale_number IN ( 'KMK10', 'KMK06' ) 
                                            AND ( ( wg_sku_weight_data.sku_code NOT LIKE '50%' ) AND ( wg_sku_weight_data.sku_code NOT LIKE '60%' ) ) 
                                            AND ( wg_sku_weight_data.sku_code NOT IN ( 'ซีก', 'ซาก', '0102', '0101' ) ) 
                                            AND wg_sku_weight_data.weighing_type IN (12)
                                            AND (
                                                CONCAT(
                                                    SUBSTRING( wg_sku_weight_data.weighing_date, 1, 4 ),
                                                    SUBSTRING( wg_sku_weight_data.weighing_date, 6, 2 ),
                                                    SUBSTRING( wg_sku_weight_data.weighing_date, 9, 2 ) 
                                                ) BETWEEN '$mindate' 
                                                AND '$maxdate' 
                                            ) 
                                        GROUP BY
                                            wg_sku_item.item_code,
                                            wg_sku_weight_data.lot_number 
                                        ORDER BY
                                            wg_sku_weight_data.lot_number,wg_sku_item.item_code ASC");

        return array($order_in,$order_send,$balance, $check_count_stock, $transform_b, $transform_a);
        // return Datatables::of($order_send)->addIndexColumn()->make(true);
    }

    public function stock_of_entrails_item(Request $request){
        // return $request->item;
        $mindate = substr($request->daterangeFilter,6,4).substr($request->daterangeFilter,3,2).substr($request->daterangeFilter,0,2);
        $maxdate = substr($request->daterangeFilter,19,4).substr($request->daterangeFilter,16,2).substr($request->daterangeFilter,13,2);

        $item_in = DB::select("SELECT
                                wg_sku_weight_data.id,
                                wg_sku_weight_data.lot_number,
                                wg_sku_weight_data.sku_id,
                                wg_sku_weight_data.sku_code,
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
                                wg_sku_weight_data.sku_amount,
                                wg_sku_weight_data.sku_weight,
                                Sum( wg_sku_weight_data.sku_amount ) AS count_amount,
                                Sum( wg_sku_weight_data.sku_weight ) AS sum_weight,
                                wg_sku_item.item_code,
                                wg_sku_item.item_name,
                                wg_sku_item.unit,
                                wg_weight_type.wg_type_name,
                                tb_order_offal.id_user_customer 
                            FROM
                                wg_sku_weight_data
                                LEFT JOIN wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code AND wg_sku_item.wg_sku_id != '30'
                                LEFT JOIN tb_order_offal ON wg_sku_weight_data.lot_number = tb_order_offal.order_number 
                                LEFT JOIN wg_weight_type ON wg_sku_weight_data.weighing_type = wg_weight_type.id_wg_type
                            WHERE
                                wg_sku_weight_data.scale_number IN ( 'KMK06', 'KMK10' ) 
                                AND wg_sku_weight_data.sku_code = $request->item
                                AND (
                                    CONCAT(
                                        SUBSTRING( wg_sku_weight_data.weighing_date, 1, 4 ),
                                        SUBSTRING( wg_sku_weight_data.weighing_date, 6, 2 ),
                                        SUBSTRING( wg_sku_weight_data.weighing_date, 9, 2 ) 
                                    ) BETWEEN '$mindate' 
                                AND '$maxdate'  
                                ) 
                            GROUP BY
                                wg_sku_item.item_code,
                                wg_sku_weight_data.lot_number 
                            ORDER BY
                            wg_sku_weight_data.lot_number ASC");

        $item_out = DB::select("SELECT
                                    wg_sku_weight_data.id,
                                    wg_sku_weight_data.lot_number,
                                    wg_sku_weight_data.sku_id,
                                    wg_sku_weight_data.sku_code,
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
                                    wg_sku_weight_data.sku_amount,
                                    wg_sku_weight_data.sku_weight,
                                    Sum( wg_sku_weight_data.sku_amount ) AS count_amount,
                                    Sum( wg_sku_weight_data.sku_weight ) AS sum_weight,
                                    wg_sku_item.item_code,
                                    wg_sku_item.item_name,
                                    wg_sku_item.unit,
                                    wg_weight_type.wg_type_name,
                                    tb_order_offal.id_user_customer 
                                FROM
                                    wg_sku_weight_data
                                    LEFT JOIN wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code AND wg_sku_item.wg_sku_id != '30'
                                    LEFT JOIN tb_order_offal ON wg_sku_weight_data.lot_number = tb_order_offal.order_number 
                                    LEFT JOIN wg_weight_type ON wg_sku_weight_data.weighing_type = wg_weight_type.id_wg_type
                                    WHERE
                                    wg_sku_weight_data.scale_number IN ( 'KMK06', 'KMK10' ) 
                                    AND wg_sku_weight_data.sku_code = $request->item
                                    AND (
                                        CONCAT(
                                            SUBSTRING( wg_sku_weight_data.weighing_date, 1, 4 ),
                                            SUBSTRING( wg_sku_weight_data.weighing_date, 6, 2 ),
                                            SUBSTRING( wg_sku_weight_data.weighing_date, 9, 2 ) 
                                        ) BETWEEN '$mindate' 
                                    AND '$maxdate'  
                                    ) 
                                GROUP BY
                                    wg_sku_item.item_code,
                                    wg_sku_weight_data.lot_number 
                                ORDER BY
                                    wg_sku_weight_data.lot_number ASC");

        $date_balance = substr($request->daterangeFilter,6,4).'/'.substr($request->daterangeFilter,3,2).'/'.substr($request->daterangeFilter,0,2).' '.'13:00:00';
        $balance = DB::select("SELECT
                                    wg_storage_daily.id,
                                    wg_storage_daily.id_storage,
                                    wg_storage_daily.name_storage,
                                    wg_storage_daily.count_unit as balance,
                                    wg_storage_daily.unit,
                                    wg_storage_daily.type_of_storage,
                                    wg_storage_daily.description,
                                    wg_storage_daily.user_id,
                                    wg_storage_daily.created_at,
                                    wg_storage_daily.updated_at,
                                    wg_storage_daily.zone,
                                    wg_storage_daily.date_summary,
                                    wg_storage_daily.weight_summary,
                                    wg_storage_daily.count_unit_real
                                FROM
                                    wg_storage_daily
                                WHERE
                                    wg_storage_daily.id_storage = '$request->item' AND
                                    wg_storage_daily.date_summary = DATE_FORMAT(('$date_balance' - INTERVAL 1 DAY),'%d/%m/%Y')
                                ORDER BY created_at LIMIT 1
        ");

         $mindate_check = substr($request->daterangeFilter,0,2)."/".substr($request->daterangeFilter,3,2)."/".substr($request->daterangeFilter,6,4);
         $check_count_stock = DB::select("SELECT
                                     wg_storage_daily.id,
                                     wg_storage_daily.id_storage,
                                     wg_storage_daily.name_storage,
                                     wg_storage_daily.count_unit,
                                     wg_storage_daily.count_unit_real,
                                     wg_storage_daily.unit,
                                     wg_storage_daily.type_of_storage,
                                     wg_storage_daily.description,
                                     wg_storage_daily.user_id,
                                     wg_storage_daily.created_at,
                                     wg_storage_daily.updated_at,
                                     wg_storage_daily.zone,
                                     wg_storage_daily.date_summary,
                                     wg_storage_daily.weight_summary
                                 FROM
                                     wg_storage_daily
                                 WHERE
                                     wg_storage_daily.id_storage = $request->item AND
                                     wg_storage_daily.date_summary = '$mindate_check'");
          
        if($item_in != null && $item_out != null){
            for($i = 0; $i < count($item_in); $i++){
                for($j = 0; $j < count($item_out); $j++){
                    if($item_in[$i] == $item_out[$j]){
                        $item_sum[$i] = array('lot_number' => $item_in[$i]->lot_number,
                                            'wg_type_name' => $item_in[$i]->wg_type_name,
                                            'id_user_customer' => $item_in[$i]->id_user_customer,
                                            'item_code' => $item_in[$i]->item_code,
                                            'item_name' => $item_in[$i]->item_name,
                                            'storage_name' => $item_in[$i]->storage_name,
                                            'unit' => $item_in[$i]->unit,
                                            'count_amount_in' => $item_in[$i]->count_amount,
                                            'count_amount_out' => $item_out[$j]->count_amount,
                                            'sum_weight_in' => $item_in[$i]->sum_weight,
                                            'sum_weight_out' => $item_out[$j]->sum_weight
                        );
                    }
                }
            }
        }else{
            $item_sum = "";
        }
        
        
        return array($item_in, $item_out, $item_sum, $balance, $mindate_check);
    }
    
    public function stock_data_edit_row(Request $request ){
        // return $request;
        // log

        DB::update("UPDATE wg_stock_log SET wg_stock_log.ref_source=?,wg_stock_log.type_request=?,wg_stock_log.total_unit=?,wg_stock_log.total_weight=?,
                                            wg_stock_log.total_price=?,wg_stock_log.id_storage=?,wg_stock_log.date_recieve=?,wg_stock_log.unit_price=?,wg_stock_log.note=?,
                                            wg_stock_log.receiver=?,wg_stock_log.sender=? WHERE wg_stock_log.bill_number=?",[$request->ref_source
                                            ,$request->type_request,$request->total_unit,$request->total_weight,$request->total_price,$request->id_storage,
                                            $request->date_recieve,$request->unit_price,$request->note,$request->receiver,$request->sender,$request->bill_number_r]);

        return back();
    }

    public function del_row(Request $request){
        DB::select("DELETE FROM wg_stock_log WHERE wg_stock_log.id =  $request->id");
        $msg = "ลบสำเร็จ";
        return response()->json(array('msg'=> $msg), 200);
        // return "ลบสำเร็จ";
    }
    // public function delete_pig_to_fac(Request $request){
    //     DB::select("DELETE FROM tb_order WHERE id = $request->id ");
    //     return 'ลบสำเร็จ';
    // }
    public function stock_data_add(Request $request ){
        // return $request;
        // log
        if($request->type_request == 19){
            DB::insert("INSERT INTO wg_stock_log(id_storage,bill_number,ref_source,
            total_unit,date_recieve,note,item_code,created_at,
            type_request,total_weight,total_price,receiver,sender,`action`,unit_price) 
            value(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
            [$request->id_storage,$request->bill_number,$request->ref_source,
            $request->total_unit,$request->date_recieve,$request->note,'ตัว',now(),
            $request->type_request,$request->total_weight,$request->total_price,$request->receiver,$request->sender,'delete',$request->unit_price]);

            DB::update("UPDATE wg_storage set current_unit = current_unit - $request->total_unit WHERE id_storage = $request->id_storage");
        }else{
            DB::insert("INSERT INTO wg_stock_log(id_storage,bill_number,ref_source,
            total_unit,date_recieve,note,item_code,created_at,
            type_request,total_weight,total_price,receiver,sender,`action`,unit_price) 
            value(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
            [$request->id_storage,$request->bill_number,$request->ref_source,
            $request->total_unit,$request->date_recieve,$request->note,'ตัว',now(),
            $request->type_request,$request->total_weight,$request->total_price,$request->receiver,$request->sender,'add',$request->unit_price]);

            DB::update("UPDATE wg_storage set current_unit = current_unit + $request->total_unit WHERE id_storage = $request->id_storage");
        }
            

        return back();
    }

    public function stock_ov_data_add(Request $request ){

        // DB::insert("INSERT INTO wg_stock(id_storage,bill_number,ref_source,
        // total_unit,date_recieve,note,item_code,created_at,
        // type_request,total_weight,total_price,receiver,sender,unit_price) 
        // value(?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
        // [$request->id_storage,$request->bill_number,$request->ref_source,
        // $request->total_unit,$request->date_recieve,$request->note,'ตัว',now(),
        // $request->type_request,$request->total_weight,$request->total_price,$request->receiver,$request->sender,$request->unit_price]);

        // log
        DB::insert("INSERT INTO wg_stock_log(id_storage,bill_number,ref_source,
        total_unit,date_recieve,note,item_code,created_at, `action`,side_of_pig) 
        value(?,?,?,?,?,?,?,?,?,?)",
        [$request->id_storage,$request->bill_number,$request->ref_source,
        $request->total_unit,$request->date_recieve,$request->note,$request->item_code,now(),'add',$request->total_unit]);

        // update product location
        // DB::update("UPDATE product_location set qty = qty+  = current_unit + $request->total_unit WHERE id_storage = $request->id_storage");

        return back();
    }

    public function get_stock(){
        $stock = DB::select("SELECT
                                wg_stock.*,
                                tb_order.customer_id,
                                tb_order.id_user_customer,
                                tb_order.round,
                                wg_storage.name_storage,
                                wg_storage.max_unit,
                                wg_storage.unit,
                                wg_storage.description 
                            FROM
                                wg_stock
                                LEFT JOIN tb_order ON wg_stock.id_order = tb_order.id
                                LEFT JOIN wg_storage ON wg_stock.id_storage = wg_storage.id_storage
                            WHERE
	                            wg_storage.type_of_storage = 'คอกขาย'");

        return Datatables::of($stock)->addIndexColumn()->make(true);
    }
    public function get_stock_history(){
        $stock = DB::select("SELECT
                                wg_stock_tmp_update.*,
                                tb_order.customer_id,
                                tb_order.id_user_customer,
                                tb_order.round,
                                wg_storage.name_storage,
                                wg_storage.max_unit,
                                wg_storage.unit,
                                wg_storage.description 
                            FROM
                                wg_stock_tmp_update
                                LEFT JOIN tb_order ON wg_stock_tmp_update.id_order = tb_order.id
                                LEFT JOIN wg_storage ON wg_stock_tmp_update.id_storage = wg_storage.id_storage
                            WHERE
                                wg_storage.type_of_storage = 'คอกขาย'
                                ORDER BY wg_stock_tmp_update.id DESC");

        return Datatables::of($stock)->addIndexColumn()->make(true);
    }

    
    public function pig_into_fac(){
        $customer = DB::select('SELECT * from tb_customer');
        $storage = DB::select("SELECT * from wg_storage where wg_storage.type_of_storage = 'คอกขาย'");

        return view('stock.truck_scale',compact('customer','storage'));
    }

    public function checking_recieve_order(Request $request){
        DB::update("UPDATE tb_order set check_order = POW( (check_order - 1), 2) WHERE id = $request->id ");

        $order_data = DB::select("SELECT * from tb_order WHERE tb_order.id = $request->id");

        foreach ($order_data as $key => $data) {
            DB::insert("INSERT into wg_stock(id_storage,id_order,order_number,total_unit,current_unit,created_at) 
            values (?,?,?,?,?,?)"
            , [$data->storage_id,$request->id,$data->order_number,$data->total_pig,$data->total_pig,now()]);
        }
       
        return 'ตรวจสอบการรับสุกรแล้ว';
    }

    public function delete_pig_to_fac(Request $request){
        DB::select("DELETE FROM tb_order WHERE id = $request->id ");
        return 'ลบสำเร็จ';
    }

    public function edit_price(Request $request){
        DB::update("UPDATE tb_order set tb_order.price = $request->price WHERE tb_order.order_number = '$request->order_number' ");
        return 0;
    }

    public function report_overnight($order_number){
        $order_receive = DB::select("SELECT
                wg_sku_weight_data.lot_number,
                wg_sku_weight_data.sku_weight,
                wg_scale.department,
                wg_scale.scale_number 
            FROM
                wg_sku_weight_data
                LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number 
            WHERE
                wg_sku_weight_data.lot_number = '$order_number'
                AND wg_scale.department = 3 ");

        $order_out_ov = DB::select("SELECT
                wg_sku_weight_data.lot_number,
                wg_sku_weight_data.sku_weight,
                tb_order_cutting.id_user_customer,
                wg_sku_weight_data.scale_number,
                wg_scale.department,
                tb_order_cutting.order_ref 
            FROM
                wg_sku_weight_data
                LEFT JOIN tb_order_cutting ON wg_sku_weight_data.lot_number = tb_order_cutting.order_number
                LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number 
            WHERE
                tb_order_cutting.order_ref = '$order_number' 
                AND wg_scale.department = 7");

        $data_order = array($order_receive,$order_out_ov);

        return view("stock.report_overnight",compact('data_order'));
    }

    public function factory_daily_main(){
        $daily = DB::select("SELECT
        tb_product_plan.plan_carcade
        FROM
        tb_product_plan
        WHERE
        tb_product_plan.plan_carcade IS NOT NULL
        AND tb_product_plan.plan_carcade <> ''
        GROUP BY tb_product_plan.plan_carcade");

        return view("stock.report.factory_daily_main",compact("daily"));
    }

    public function factory_daily_customer($date_select){
        $date = substr($date_select ,8,2).'/'.substr($date_select ,5,2).'/'.substr($date_select ,0,4);

        $order_count_customer = DB::select("SELECT
                count(tb_order.order_number) as count
            FROM
                tb_order
            WHERE
                tb_order.type_request = 2
            AND tb_order.date = '$date'"
        );
        $order_count = empty($order_count_customer[0]->count) ? 0 : $order_count_customer[0]->count;
        
        $order_customer_pp = DB::select("SELECT
                tb_order_offal.order_number,
                tb_order_offal.type_request,
                tb_order_offal.id_user_customer,
                tb_order_offal.total_pig,
                tb_order_offal.date,
                tb_order_offal.order_ref,
                sum( wg_sku_weight_data.sku_weight ) AS sum_weight,
                wg_sku_weight_data.scale_number,
                wg_scale.department 
            FROM
                tb_order_offal
                LEFT JOIN tb_order ON tb_order_offal.order_ref = tb_order.order_number
                LEFT JOIN wg_sku_weight_data ON tb_order.order_number = wg_sku_weight_data.lot_number
                LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number 
            WHERE
                tb_order.type_request = 2
                AND tb_order_offal.date = '$date' 
                AND wg_scale.department = 1 
            GROUP BY
                tb_order.order_number
        ");
        
        // เปิดใช้เมื่อแก้ปัญหาไม่กดน้ำหนักชั่งแขวนลูกค้าได้
            // $order_customer_before_ov = DB::select("SELECT
            //         tb_order_offal.order_number,
            //         tb_order_offal.type_request,
            //         tb_order_offal.id_user_customer,
            //         tb_order_offal.total_pig,
            //         tb_order_offal.date,
            //         tb_order_offal.order_ref,
            //         wg_sku_weight_data.sku_code,
            //         sum( wg_sku_weight_data.sku_weight ) AS sum_weight,
            //         count( wg_sku_weight_data.sku_weight ) AS count_weight,
            //         wg_sku_weight_data.scale_number,
            //         wg_scale.department 
            //     FROM
            //         tb_order_offal
            //         LEFT JOIN tb_order ON tb_order_offal.order_ref = tb_order.order_number
            //         LEFT JOIN wg_sku_weight_data ON tb_order_offal.order_number = wg_sku_weight_data.lot_number
            //         LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number 
            //     WHERE
            //         tb_order.type_request = 2 
            //         AND tb_order.date = '$date' 
            //         AND wg_scale.department = 3
            //     GROUP BY
            //         tb_order.order_number       
        // ");
        

        $order_customer_before_ov = DB::select("SELECT
                tb_order_offal.order_number,
                tb_order_offal.type_request,
                tb_order_offal.id_user_customer,
                tb_order_offal.total_pig,
                tb_order_offal.date,
                tb_order_offal.order_ref,
                wg_sku_weight_data.sku_code,
                wg_sku_weight_data.scale_number,
                tb_order.weight_of_side,
                wg_scale.department 
            FROM
                tb_order_offal
                LEFT JOIN tb_order ON tb_order_offal.order_ref = tb_order.order_number
                LEFT JOIN wg_sku_weight_data ON tb_order_offal.order_number = wg_sku_weight_data.lot_number
                LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number 
            WHERE
                tb_order.type_request = 2 
                AND tb_order.date = '$date'
            GROUP BY
                tb_order.order_number  
        ");


        $order_customer_head = DB::select("SELECT
                tb_order_offal.order_number,
                tb_order_offal.type_request,
                tb_order_offal.id_user_customer,
                tb_order_offal.total_pig,
                tb_order_offal.date,
                tb_order_offal.order_ref,
                wg_sku_weight_data.sku_code,
                sum( wg_sku_weight_data.sku_weight ) AS sum_weight,
                count( wg_sku_weight_data.sku_weight ) AS count_weight,
                wg_sku_weight_data.scale_number,
                wg_scale.department 
            FROM
                tb_order_offal
                LEFT JOIN tb_order ON tb_order_offal.order_ref = tb_order.order_number
                LEFT JOIN wg_sku_weight_data ON tb_order_offal.order_number = wg_sku_weight_data.lot_number
                LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number 
            WHERE
                tb_order.type_request = 2 
                AND tb_order.date = '$date'
                AND wg_sku_weight_data.sku_code = '6002' 
            GROUP BY
                tb_order.order_number
        ");

        $order_customer_white = DB::select("SELECT
                tb_order_offal.order_number,
                tb_order_offal.type_request,
                tb_order_offal.id_user_customer,
                tb_order_offal.total_pig,
                tb_order_offal.date,
                tb_order_offal.order_ref,
                wg_sku_weight_data.sku_code,
                sum( wg_sku_weight_data.sku_weight ) AS sum_weight,
                count( wg_sku_weight_data.sku_weight ) AS count_weight,
                wg_sku_weight_data.scale_number,
                wg_scale.department 
            FROM
                tb_order_offal
                LEFT JOIN tb_order ON tb_order_offal.order_ref = tb_order.order_number
                LEFT JOIN wg_sku_weight_data ON tb_order_offal.order_number = wg_sku_weight_data.lot_number
                LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number 
            WHERE
                tb_order.type_request = 2 
                AND tb_order.date = '$date'
                AND wg_sku_weight_data.sku_code = '5001' 
            GROUP BY
                tb_order.order_number
        ");

        $order_customer_red = DB::select("SELECT
                tb_order_offal.order_number,
                tb_order_offal.type_request,
                tb_order_offal.id_user_customer,
                tb_order_offal.total_pig,
                tb_order_offal.date,
                tb_order_offal.order_ref,
                wg_sku_weight_data.sku_code,
                sum( wg_sku_weight_data.sku_weight ) AS sum_weight,
                count( wg_sku_weight_data.sku_weight ) AS count_weight,
                wg_sku_weight_data.scale_number,
                wg_scale.department 
            FROM
                tb_order_offal
                LEFT JOIN tb_order ON tb_order_offal.order_ref = tb_order.order_number
                LEFT JOIN wg_sku_weight_data ON tb_order_offal.order_number = wg_sku_weight_data.lot_number
                LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number 
            WHERE
                tb_order.type_request = 2 
                AND tb_order.date = '$date'
                AND wg_sku_weight_data.sku_code = '6001' 
            GROUP BY
                tb_order.order_number
        ");
        
        $order_customer_after_ov = DB::select("SELECT
                *,
                Sum( tb_order.sku_weight ) AS sum_weight,
                count( tb_order.sku_weight ) AS count_weight 
            FROM
                (
            SELECT
                tb_order_offal.order_number,
                tb_order_offal.type_request,
                tb_order_offal.id_user_customer,
                tb_order_offal.total_pig,
                tb_order_offal.date,
                tb_order_offal.order_ref,
                wg_sku_weight_data.sku_code,
                wg_sku_weight_data.sku_weight,
                wg_sku_weight_data.scale_number,
                wg_scale.department 
            FROM
                tb_order_offal
                LEFT JOIN tb_order ON tb_order_offal.order_ref = tb_order.order_number
                LEFT JOIN wg_sku_weight_data ON tb_order_offal.order_number = wg_sku_weight_data.lot_number
                LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number 
            WHERE
                tb_order.type_request = 2 
                AND tb_order.date = '$date'
                AND wg_sku_weight_data.sku_code = 'ซาก' 
            GROUP BY
                wg_sku_weight_data.sku_weight 
            ORDER BY
                tb_order.order_number 
                ) AS tb_order 
            GROUP BY
                tb_order.order_number
        ");

            $order_cus[0][0] = '';
        for ($i=0; $i < $order_count ; $i++) { 
            $order_cus[$i][0] = '';
            $order_cus[$i][1] = '';
            $order_cus[$i][2] = 0;
            $order_cus[$i][3] = 0;
            $order_cus[$i][4] = 0;
            $order_cus[$i][5] = 0;
            $order_cus[$i][6] = 0;
            $order_cus[$i][7] = 0;
            $order_cus[$i][8] = 0;
            $order_cus[$i][9] = 0;
            $order_cus[$i][10] = 0;
            $order_cus[$i][11] = 0;
            $order_cus[$i][12] = 0;
            $order_cus[$i][13] = 0;
            $order_cus[$i][14] = 0;
            $order_cus[$i][15] = 0;
            $order_cus[$i][16] = 0;
            $order_cus[$i][17] = 0;
            $order_cus[$i][18] = 0;
            $order_cus[$i][19] = 0;
            $order_cus[$i][20] = 0;
        }

        foreach ($order_customer_pp as $key => $pp) {
            $order_cus[$key][0] = $pp->order_number;
            $order_cus[$key][1] = $pp->id_user_customer;
            $order_cus[$key][2] = $pp->total_pig;
            $order_cus[$key][3] = $pp->sum_weight;
        }

        for ($i=0; $i <$order_count ; $i++) { 
            foreach ($order_customer_before_ov as $key => $before_ov) {
                if ($order_cus[$i][0] == $before_ov->order_number) {
                    // $order_cus[$i][4] = $before_ov->sum_weight;
                    $order_cus[$i][4] = $before_ov->weight_of_side;
                    $order_cus[$i][15] = $order_cus[$i][15] + $order_cus[$i][4];
                    $order_cus[$i][5] = ($order_cus[$i][4]/$order_cus[$i][2]);
                }
            }
            foreach ($order_customer_head as $key => $head) {
                if ($order_cus[$i][0] == $head->order_number) {
                    $order_cus[$i][6] = $head->count_weight;
                    $order_cus[$i][7] = $head->sum_weight;
                    $order_cus[$i][15] = $order_cus[$i][15] + $order_cus[$i][7];
                    $order_cus[$i][8] = ($head->sum_weight/$head->count_weight);
                }
            }
            foreach ($order_customer_white as $key => $white) {
                if ($order_cus[$i][0] == $white->order_number) {
                    $order_cus[$i][9] = $white->count_weight;
                    $order_cus[$i][10] = $white->sum_weight;
                    $order_cus[$i][15] = $order_cus[$i][15] + $order_cus[$i][10];
                    $order_cus[$i][11] = ($white->sum_weight/$white->count_weight);
                }
            }
            foreach ($order_customer_red as $key => $red) {
                if ($order_cus[$i][0] == $red->order_number) {
                    $order_cus[$i][12] = $red->count_weight;
                    $order_cus[$i][13] = $red->sum_weight;
                    $order_cus[$i][15] = $order_cus[$i][15] + $order_cus[$i][13];
                    $order_cus[$i][14] = ($red->sum_weight/$red->count_weight);
                }
            }
            foreach ($order_customer_after_ov as $key => $after_ov) {
                if ($order_cus[$i][0] == $after_ov->order_number) {
                    $order_cus[$i][16] = $after_ov->count_weight;
                    $order_cus[$i][17] = $after_ov->sum_weight;
                    $order_cus[$i][18] = $after_ov->sum_weight/$order_cus[$i][2];
                    $order_cus[$i][19] = $order_cus[$i][3] - $after_ov->sum_weight;
                    $order_cus[$i][20] = ($order_cus[$i][3] - $after_ov->sum_weight)/$order_cus[$i][2];
                }
            }
        }
    
        return view("stock.report.factory_daily_customer",compact("order_cus","order_count","date"));
    }

    public function factory_daily_branch($date_select){
        $date = substr($date_select ,8,2).'/'.substr($date_select ,5,2).'/'.substr($date_select ,0,4);

        $order_count_customer = DB::select("SELECT
                count( tb_order_offal.order_number ) AS count 
            FROM
                tb_order_offal
            WHERE
                tb_order_offal.date = '$date'
                AND tb_order_offal.type_request = '3'
        ");

        $order_count = empty($order_count_customer[0]->count) ? 0 : $order_count_customer[0]->count;
        
        $order_ref = DB::select("SELECT
                tb_order_offal.date,
                tb_order_offal.order_ref,
                sum(tb_order_offal.total_pig) as total_pig
                FROM
                tb_order_offal
                WHERE
                tb_order_offal.date = '$date'
                GROUP BY
                tb_order_offal.order_ref 
        ");
        $order_referecne = $order_ref[0]->order_ref;

        $order_receive = DB::select("SELECT
                Sum(wg_sku_weight_data.sku_weight)as sum_weight,
                wg_sku_weight_data.weighing_type,
                wg_sku_weight_data.scale_number,
                wg_sku_weight_data.lot_number as order_ref,
                wg_scale.department
                FROM
                wg_sku_weight_data
                LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                WHERE
                wg_sku_weight_data.lot_number = '$order_referecne'
                AND wg_scale.department = 1
        ");

        $order_receive_before_ov = DB::select("SELECT
                Sum(wg_sku_weight_data.sku_weight)as sum_weight,
                wg_sku_weight_data.weighing_type,
                wg_sku_weight_data.scale_number,
                wg_sku_weight_data.lot_number as order_ref,
                wg_scale.department
                FROM
                wg_sku_weight_data
                LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                WHERE
                wg_sku_weight_data.lot_number = '$order_referecne'
                AND wg_scale.department = 3
        ");

        $order_customer_pp = DB::select("SELECT
                tb_order_offal.order_number,
                tb_order_offal.type_request,
                tb_order_offal.id_user_customer,
                tb_order_offal.total_pig,
                tb_order_offal.date,
                Sum( wg_sku_weight_data.sku_weight ) AS sum_weight,
                wg_sku_weight_data.scale_number,
                wg_scale.department,
                wg_sku_weight_data.weighing_type 
            FROM
                tb_order_offal
                LEFT JOIN wg_sku_weight_data ON tb_order_offal.order_number = wg_sku_weight_data.lot_number
                LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number 
            WHERE
                tb_order_offal.date = '$date'
                AND wg_sku_weight_data.weighing_type = '2' 
            GROUP BY
                tb_order_offal.order_number 
            ORDER BY
                tb_order_offal.id
        ");
        
        $order_customer_head = DB::select("SELECT
                tb_order_offal.order_number,
                tb_order_offal.type_request,
                tb_order_offal.id_user_customer,
                tb_order_offal.total_pig,
                tb_order_offal.date,
                tb_order_offal.order_ref,
                wg_sku_weight_data.sku_code,
                sum( wg_sku_weight_data.sku_weight ) AS sum_weight,
                count( wg_sku_weight_data.sku_weight ) AS count_weight,
                wg_sku_weight_data.scale_number,
                wg_scale.department 
            FROM
                tb_order_offal
                LEFT JOIN tb_order ON tb_order_offal.order_ref = tb_order.order_number
                LEFT JOIN wg_sku_weight_data ON tb_order_offal.order_number = wg_sku_weight_data.lot_number
                LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number 
            WHERE
                tb_order_offal.type_request = 3
                AND tb_order_offal.date = '$date' 
                AND wg_sku_weight_data.sku_code = '6002' 
            GROUP BY
                tb_order_offal.order_number"
        );

        $order_customer_white_receive = DB::select("SELECT
                tb_order_offal.order_number,
                tb_order_offal.type_request,
                tb_order_offal.id_user_customer,
                tb_order_offal.total_pig,
                sum( wg_sku_weight_data.sku_weight ) AS sum_weight,
                tb_order_offal.date,
                wg_scale.department,
                wg_sku_weight_data.sku_code,
                wg_sku_weight_data.weighing_type,
                wg_sku_weight_data.sku_id 
            FROM
                tb_order_offal
                LEFT JOIN wg_sku_weight_data ON tb_order_offal.order_number = wg_sku_weight_data.lot_number
                LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number 
            WHERE
                tb_order_offal.date = '$date'
                AND wg_sku_weight_data.sku_id = 4 -- 4 white offal
                AND wg_sku_weight_data.weighing_type = 1  -- 2ชั่งออก 1เข้า
            GROUP BY
                tb_order_offal.order_number
        ");

        $order_customer_white = DB::select("SELECT
                tb_order_offal.order_number,
                tb_order_offal.type_request,
                tb_order_offal.id_user_customer,
                tb_order_offal.total_pig,
                sum( wg_sku_weight_data.sku_weight ) AS sum_weight,
                tb_order_offal.date,
                wg_scale.department,
                wg_sku_weight_data.sku_code,
                wg_sku_weight_data.weighing_type,
                wg_sku_weight_data.sku_id 
            FROM
                tb_order_offal
                LEFT JOIN wg_sku_weight_data ON tb_order_offal.order_number = wg_sku_weight_data.lot_number
                LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number 
            WHERE
                tb_order_offal.date = '$date'
                AND wg_sku_weight_data.sku_id = 4 -- 4 white offal
                AND wg_sku_weight_data.weighing_type = 2  -- 2ชั่งออก
            GROUP BY
                tb_order_offal.order_number
        ");

        $order_customer_red = DB::select("SELECT
                tb_order_offal.order_number,
                tb_order_offal.type_request,
                tb_order_offal.id_user_customer,
                tb_order_offal.total_pig,
                sum( wg_sku_weight_data.sku_weight ) AS sum_weight,
                tb_order_offal.date,
                wg_scale.department,
                wg_sku_weight_data.sku_code,
                wg_sku_weight_data.weighing_type,
                wg_sku_weight_data.sku_id 
            FROM
                tb_order_offal
                LEFT JOIN wg_sku_weight_data ON tb_order_offal.order_number = wg_sku_weight_data.lot_number
                LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number 
            WHERE
                tb_order_offal.date = '$date'
                AND wg_sku_weight_data.sku_id = 5 -- 5 red offal
                AND wg_sku_weight_data.weighing_type = 2
            GROUP BY
                tb_order_offal.order_number
        ");

        $order_customer_red_receive = DB::select("SELECT
                tb_order_offal.order_number,
                tb_order_offal.type_request,
                tb_order_offal.id_user_customer,
                tb_order_offal.total_pig,
                sum( wg_sku_weight_data.sku_weight ) AS sum_weight,
                tb_order_offal.date,
                wg_scale.department,
                wg_sku_weight_data.sku_code,
                wg_sku_weight_data.weighing_type,
                wg_sku_weight_data.sku_id 
            FROM
                tb_order_offal
                LEFT JOIN wg_sku_weight_data ON tb_order_offal.order_number = wg_sku_weight_data.lot_number
                LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number 
            WHERE
                tb_order_offal.date = '$date'
                AND wg_sku_weight_data.sku_id = 5 -- 5 red offal
                AND wg_sku_weight_data.weighing_type = 1
            GROUP BY
                tb_order_offal.order_number
        ");

        $order_customer_after_ov = DB::select("SELECT
                tb_order.order_number,
                tb_order.type_request,
                tb_order.id_user_customer,
                tb_order.total_pig,
                tb_order.date,
                sum( wg_sku_weight_data.sku_weight ) AS sum_weight,
                wg_sku_weight_data.scale_number,
                wg_scale.department 
            FROM
                tb_order
                LEFT JOIN wg_sku_weight_data ON tb_order.order_number = wg_sku_weight_data.lot_number
                LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number 
            WHERE
                tb_order.type_request = 2 
                AND tb_order.date = '$date' 
                AND wg_scale.department = 7
            GROUP BY
                tb_order.order_number"
        );

            $order_cus[0][0] = '';
        for ($i=0; $i < $order_count ; $i++) { 
            $order_cus[$i][0] = '';
            $order_cus[$i][1] = '';
            $order_cus[$i][2] = 0;
            $order_cus[$i][3] = $order_receive[0]->sum_weight;
            $order_cus[$i][4] = $order_receive_before_ov[0]->sum_weight;
            $order_cus[$i][5] = $order_receive_before_ov[0]->sum_weight/$order_ref[0]->total_pig;
            $order_cus[$i][6] = 0;
            $order_cus[$i][7] = 0;
            $order_cus[$i][8] = 0;
            $order_cus[$i][9] = 0;
            $order_cus[$i][10] = 0;
            $order_cus[$i][11] = 0;
            $order_cus[$i][12] = 0;
            $order_cus[$i][13] = 0;
            $order_cus[$i][14] = 0;
            $order_cus[$i][15] = 'x';
            $order_cus[$i][16] = 'x';
            $order_cus[$i][17] = 0;
            $order_cus[$i][18] = 0;
            $order_cus[$i][19] = 0;
            $order_cus[$i][20] = $order_receive[0]->order_ref;
        }

        foreach ($order_customer_pp as $key => $pp) {
            $order_cus[$key][0] = $pp->order_number;
            $order_cus[$key][1] = $pp->id_user_customer;
            $order_cus[$key][2] = $pp->total_pig;
            $order_cus[$key][9] = $pp->total_pig;
            $order_cus[$key][12] = $pp->total_pig;
        }

        for ($i=0; $i <$order_count ; $i++) { 
            // foreach ($order_customer_before_ov as $key => $before_ov) {
            //     if ($order_cus[$i][0] == $before_ov->order_number) {
            //         $order_cus[$i][4] = $before_ov->sum_weight;
            //         $order_cus[$i][5] = ($order_cus[$i][4]/$order_cus[$i][2]);
            //     }
            // }
            foreach ($order_customer_head as $key => $head) {
                if ($order_cus[$i][0] == $head->order_number) {
                    $order_cus[$i][6] = $head->count_weight;
                    $order_cus[$i][7] = $head->sum_weight;
                    $order_cus[$i][8] = $head->sum_weight;
                    $order_cus[0][17] = $order_cus[0][17] + $order_cus[$i][8];
                }
            }
            foreach ($order_customer_white_receive as $key => $white_receive) {
                if ($order_cus[$i][0] == $white_receive->order_number) {
                    $order_cus[$i][10] = $white_receive->sum_weight;
                }
            }
            foreach ($order_customer_white as $key => $white) {
                if ($order_cus[$i][0] == $white->order_number) {
                    $order_cus[$i][11] = $white->sum_weight;
                    $order_cus[0][17] = $order_cus[0][17] + $order_cus[$i][11];
                }
            }
            foreach ($order_customer_red_receive as $key => $red_receive) {
                if ($order_cus[$i][0] == $red_receive->order_number) {
                    $order_cus[$i][13] = $red_receive->sum_weight;
                }
            }
            foreach ($order_customer_red as $key => $red) {
                if ($order_cus[$i][0] == $red->order_number) {
                    $order_cus[$i][14] = $red->sum_weight;
                    $order_cus[0][17] = $order_cus[0][17] + $order_cus[$i][14];
                }
            }
            // foreach ($order_customer_after_ov as $key => $after_ov) {
            //     if ($order_cus[$i][0] == $after_ov->order_number) {
            //         $order_cus[$i][16] = $after_ov->sum_weight;
            //         $order_cus[$i][17] = $after_ov->sum_weight/$order_cus[$i][2];
            //         $order_cus[$i][18] = $order_cus[$i][3] - $after_ov->sum_weight;
            //         $order_cus[$i][19] = ($order_cus[$i][3] - $after_ov->sum_weight)/$order_cus[$i][2];
            //     }
            // }
        }

        $order_cus[0][17] = $order_cus[0][17] + $order_receive[0]->sum_weight;
        $order_cus[0][18] = $order_cus[0][17]/$order_ref[0]->total_pig;  //ค่าเฉลี่ยชั่งออก
        $order_cus[0][19] = ($order_cus[0][3] - $order_cus[0][17])/$order_ref[0]->total_pig; //หายต่อตัว
    
        return view("stock.report.factory_daily_branch",compact("order_cus","order_count","date"));
    }

    public function factory_daily_trim_branch($date_select){
        $date = substr($date_select ,8,2).'/'.substr($date_select ,5,2).'/'.substr($date_select ,0,4);

        $order_count_customer = DB::select("SELECT
                count( tb_order_cutting.order_number ) AS count 
            FROM
                tb_order_cutting
            WHERE
                tb_order_cutting.date = '$date'
        ");

        $order_count = empty($order_count_customer[0]->count) ? 0 : $order_count_customer[0]->count;
        
        $order_ref = DB::select("SELECT
                tb_order_cutting.date,
                tb_order_cutting.order_ref,
                sum(tb_order_cutting.total_pig) as total_pig
                FROM
                tb_order_cutting
                WHERE
                tb_order_cutting.date = '$date' 
                GROUP BY
                tb_order_cutting.order_ref  
        ");
        $order_referecne = $order_ref[0]->order_ref;

        $order_receive = DB::select("SELECT
                Sum(wg_sku_weight_data.sku_weight)as sum_weight,
                wg_sku_weight_data.weighing_type,
                wg_sku_weight_data.scale_number,
                wg_sku_weight_data.lot_number as order_ref,
                wg_scale.department
                FROM
                wg_sku_weight_data
                LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                WHERE
                wg_sku_weight_data.lot_number = '$order_referecne'
                AND wg_scale.department = 1
        ");

        $order_receive_before_ov = DB::select("SELECT
                Sum(wg_sku_weight_data.sku_weight)as sum_weight,
                wg_sku_weight_data.weighing_type,
                wg_sku_weight_data.scale_number,
                wg_sku_weight_data.lot_number as order_ref,
                wg_scale.department
                FROM
                wg_sku_weight_data
                LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                WHERE
                wg_sku_weight_data.lot_number = '$order_referecne'
                AND wg_scale.department = 3
        ");

        $order_customer_pp = DB::select("SELECT
                tb_order_cutting.order_number,
                tb_order_cutting.type_request,
                tb_order_cutting.id_user_customer,
                tb_order_cutting.total_pig,
                tb_order_cutting.date,
                Sum( wg_sku_weight_data.sku_weight ) AS sum_weight,
                wg_sku_weight_data.scale_number,
                wg_scale.department,
                wg_sku_weight_data.weighing_type 
            FROM
                tb_order_cutting
                LEFT JOIN wg_sku_weight_data ON tb_order_cutting.order_number = wg_sku_weight_data.lot_number
                LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number 
            WHERE
                tb_order_cutting.date = '$date'
            GROUP BY
                tb_order_cutting.order_number 
            ORDER BY
                tb_order_cutting.id
        ");
        
        $order_customer_head = DB::select("SELECT
                tb_order.order_number,
                tb_order.type_request,
                tb_order.id_user_customer,
                tb_order.total_pig,
                tb_order.date,
                Sum( wg_sku_weight_data.sku_weight ) AS sum_weight,
                count( wg_sku_weight_data.sku_weight ) AS count_weight,
                wg_sku_weight_data.scale_number,
                wg_scale.department,
                wg_sku_weight_data.sku_code 
            FROM
                tb_order
                LEFT JOIN wg_sku_weight_data ON tb_order.order_number = wg_sku_weight_data.lot_number
                LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number 
            WHERE
                tb_order.type_request = 2 
                AND tb_order.date = '$date' 
                AND wg_sku_weight_data.sku_code = '1001' 
            GROUP BY
                tb_order.order_number"
        );

        $order_customer_white = DB::select("SELECT
                tb_order_offal.order_number,
                tb_order_offal.type_request,
                tb_order_offal.id_user_customer,
                tb_order_offal.total_pig,
                sum( wg_sku_weight_data.sku_weight ) AS sum_weight,
                tb_order_offal.date,
                wg_scale.department,
                wg_sku_weight_data.sku_code,
                wg_sku_weight_data.weighing_type,
                wg_sku_weight_data.sku_id 
            FROM
                tb_order_offal
                LEFT JOIN wg_sku_weight_data ON tb_order_offal.order_number = wg_sku_weight_data.lot_number
                LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number 
            WHERE
                tb_order_offal.date = '$date'
                AND wg_sku_weight_data.sku_id = 4 -- 4 white offal
                AND wg_sku_weight_data.weighing_type = 2  -- 2ชั่งออก
            GROUP BY
                tb_order_offal.order_number
        ");

        $order_customer_red = DB::select("SELECT
                tb_order_offal.order_number,
                tb_order_offal.type_request,
                tb_order_offal.id_user_customer,
                tb_order_offal.total_pig,
                sum( wg_sku_weight_data.sku_weight ) AS sum_weight,
                tb_order_offal.date,
                wg_scale.department,
                wg_sku_weight_data.sku_code,
                wg_sku_weight_data.weighing_type,
                wg_sku_weight_data.sku_id 
            FROM
                tb_order_offal
                LEFT JOIN wg_sku_weight_data ON tb_order_offal.order_number = wg_sku_weight_data.lot_number
                LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number 
            WHERE
                tb_order_offal.date = '$date'
                AND wg_sku_weight_data.sku_id = 5 -- 5 red offal
                AND wg_sku_weight_data.weighing_type = 2
            GROUP BY
                tb_order_offal.order_number
        ");

        $order_customer_after_ov = DB::select("SELECT
                tb_order.order_number,
                tb_order.type_request,
                tb_order.id_user_customer,
                tb_order.total_pig,
                tb_order.date,
                sum( wg_sku_weight_data.sku_weight ) AS sum_weight,
                wg_sku_weight_data.scale_number,
                wg_scale.department 
            FROM
                tb_order
                LEFT JOIN wg_sku_weight_data ON tb_order.order_number = wg_sku_weight_data.lot_number
                LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number 
            WHERE
                tb_order.type_request = 2 
                AND tb_order.date = '$date' 
                AND wg_scale.department = 7
            GROUP BY
                tb_order.order_number"
        );

            $order_cus[0][0] = '';
        for ($i=0; $i < $order_count ; $i++) { 
            $order_cus[$i][0] = '';
            $order_cus[$i][1] = '';
            $order_cus[$i][2] = 0;
            $order_cus[$i][3] = $order_receive[0]->sum_weight;
            $order_cus[$i][4] = $order_receive_before_ov[0]->sum_weight;
            $order_cus[$i][5] = $order_receive_before_ov[0]->sum_weight/$order_ref[0]->total_pig;
            $order_cus[$i][6] = 0;
            $order_cus[$i][7] = 0;
            $order_cus[$i][8] = 0;
            $order_cus[$i][9] = 0;
            $order_cus[$i][10] = 0;
            $order_cus[$i][11] = 0;
            $order_cus[$i][12] = 0;
            $order_cus[$i][13] = 0;
            $order_cus[$i][14] = 0;
            $order_cus[$i][15] = 'x';
            $order_cus[$i][16] = 'x';
            $order_cus[$i][17] = 0;
            $order_cus[$i][18] = 0;
            $order_cus[$i][19] = 0;
            $order_cus[$i][20] = $order_receive[0]->order_ref;
        }

        foreach ($order_customer_pp as $key => $pp) {
            $order_cus[$key][0] = $pp->order_number;
            $order_cus[$key][1] = $pp->id_user_customer;
            $order_cus[$key][2] = $pp->total_pig;
            $order_cus[$key][6] = $pp->total_pig;
            $order_cus[$key][9] = $pp->total_pig;
            $order_cus[$key][12] = $pp->total_pig;
        }

        for ($i=0; $i <$order_count ; $i++) { 
            // foreach ($order_customer_before_ov as $key => $before_ov) {
            //     if ($order_cus[$i][0] == $before_ov->order_number) {
            //         $order_cus[$i][4] = $before_ov->sum_weight;
            //         $order_cus[$i][5] = ($order_cus[$i][4]/$order_cus[$i][2]);
            //     }
            // }
            foreach ($order_customer_head as $key => $head) {
                if ($order_cus[$i][0] == $head->order_number) {
                    $order_cus[$i][7] = $head->sum_weight;
                    $order_cus[$i][8] = ($head->sum_weight/$head->count_weight);
                    $order_cus[0][17] = $order_cus[0][17] + $order_cus[$i][8];
                }
            }
            foreach ($order_customer_white as $key => $white) {
                if ($order_cus[$i][0] == $white->order_number) {
                    $order_cus[$i][10] = 0;
                    $order_cus[$i][11] = $white->sum_weight;
                    $order_cus[0][17] = $order_cus[0][17] + $order_cus[$i][11];
                }
            }
            foreach ($order_customer_red as $key => $red) {
                if ($order_cus[$i][0] == $red->order_number) {
                    $order_cus[$i][13] = 0;
                    $order_cus[$i][14] = $red->sum_weight;
                    $order_cus[0][17] = $order_cus[0][17] + $order_cus[$i][14];
                }
            }
            // foreach ($order_customer_after_ov as $key => $after_ov) {
            //     if ($order_cus[$i][0] == $after_ov->order_number) {
            //         $order_cus[$i][16] = $after_ov->sum_weight;
            //         $order_cus[$i][17] = $after_ov->sum_weight/$order_cus[$i][2];
            //         $order_cus[$i][18] = $order_cus[$i][3] - $after_ov->sum_weight;
            //         $order_cus[$i][19] = ($order_cus[$i][3] - $after_ov->sum_weight)/$order_cus[$i][2];
            //     }
            // }
        }

        $order_cus[0][17] = $order_cus[0][17] + $order_receive[0]->sum_weight;
        $order_cus[0][18] = $order_cus[0][17]/$order_ref[0]->total_pig;  //ค่าเฉลี่ยชั่งออก
        $order_cus[0][19] = ($order_cus[0][3] - $order_cus[0][17])/$order_ref[0]->total_pig; //หายต่อตัว

        return view("stock.report.factory_daily_trim_branch",compact("order_cus","order_count","date"));
    }

    public function edit_weight_side(Request $request){
        $order_cus = DB::select("SELECT order_ref from tb_order_offal WHERE order_number = '$request->order_number' LIMIT 1");
        $order_number = $order_cus[0]->order_ref;
        DB::update("UPDATE tb_order set tb_order.weight_of_side = $request->weight_ WHERE tb_order.order_number = '$order_number' ");
        return 0;
    }

    public function edit_row(Request $request){
        $data = DB::select("SELECT * FROM wg_stock_log WHERE wg_stock_log.id = $request->id");
        return $data;
    }

    public function get_ref_order(Request $request){
        $mindate = substr($request->daterangeFilter,0,10);
        $maxdate = substr($request->daterangeFilter,13,10);
        $order = DB::select("SELECT
                                `tb_order_transport`.`order_number` AS `tr`,
                                `tb_order_cutting`.`order_number` AS `cl`,
                                `tb_order_offal`.`order_number` AS `of`,
                                `tb_order_overnight`.`order_number` AS `ov`,
                                `tb_order`.`order_number` AS `R`,
                                `tb_order_transport`.`created_at` AS `created_at`,
                                `tb_order_transport`.`date_transport` AS `date_transport` 
                            FROM
                                (
                                    (
                                        (
                                            ( `tb_order_transport` LEFT JOIN `tb_order_cutting` ON ( ( `tb_order_transport`.`order_cutting_number` = `tb_order_cutting`.`order_number` ) ) )
                                            LEFT JOIN `tb_order_offal` ON ( ( `tb_order_transport`.`order_offal_number` = `tb_order_offal`.`order_number` ) ) 
                                        )
                                        LEFT JOIN `tb_order_overnight` ON ( ( `tb_order_cutting`.`order_ref` = `tb_order_overnight`.`order_number` ) ) 
                                    )
                                    LEFT JOIN `tb_order` ON ( ( `tb_order_overnight`.`order_ref` = `tb_order`.`order_number` ) ) 
                                ) 
                            WHERE
                                ( `tb_order_cutting`.`date` BETWEEN '$mindate' AND '$maxdate' ) 
                            ORDER BY
                                `tb_order_transport`.`order_number`");
        return array($order);
    }

    
}
