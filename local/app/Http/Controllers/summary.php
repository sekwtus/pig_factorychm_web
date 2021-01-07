<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Redirect;
use DataTables;

class summary extends Controller
{
    public function summary_weighing_receive($order_number){

        // 01 02
        $select_in_R = DB::select("SELECT
                                    wg_sku_weight_data.id,
                                    wg_sku_weight_data.lot_number,
                                    wg_sku_weight_data.sku_amount,
                                    wg_sku_weight_data.sku_weight,
                                    wg_sku_weight_data.scale_number,
                                    wg_sku_weight_data.weighing_date,
                                    wg_sku_weight_data.sku_code,
                                    wg_sku_item.item_name,
                                    wg_scale.department,
                                    wg_scale.process_number ,
                                    wg_sku_weight_data.note
                                FROM
                                    wg_sku_weight_data
                                    LEFT JOIN wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code
                                    LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number 
                                WHERE
                                    wg_sku_weight_data.lot_number = '$order_number' 
                                    AND wg_scale.process_number = '1' 
                                ORDER BY
                                    -- wg_sku_weight_data.sku_code
                                    wg_sku_weight_data.weighing_date ASC"
        );

        // 03
        $select_in_K = DB::select("SELECT
                                    wg_sku_weight_data.lot_number,
                                    wg_sku_weight_data.sku_amount,
                                    wg_sku_weight_data.sku_weight,
                                    wg_sku_weight_data.scale_number,
                                    wg_sku_weight_data.weighing_date,
                                    wg_sku_weight_data.sku_code,
                                    wg_sku_item.item_name,
                                    wg_scale.department,
                                    wg_scale.process_number 
                                FROM
                                    wg_sku_weight_data
                                    LEFT JOIN wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code
                                    LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number 
                                WHERE
                                    wg_sku_weight_data.lot_number = '$order_number' 
                                    AND wg_scale.process_number = '2' 
                                ORDER BY
                                    wg_sku_weight_data.sku_code"
        );

        // 04
        $select_in_before_ov = DB::select("SELECT
                                    wg_sku_weight_data.id,
                                    wg_sku_weight_data.lot_number,
                                    wg_sku_weight_data.sku_amount,
                                    wg_sku_weight_data.sku_weight,
                                    wg_sku_weight_data.scale_number,
                                    wg_sku_weight_data.weighing_date,
                                    wg_sku_weight_data.sku_code,
                                    wg_sku_item.item_name,
                                    wg_scale.department,
                                    wg_scale.process_number 
                                FROM
                                    wg_sku_weight_data
                                    LEFT JOIN wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code
                                    LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number 
                                WHERE
                                    wg_sku_weight_data.lot_number = '$order_number' 
                                    AND wg_scale.process_number = '3' 
                                ORDER BY
                                    wg_sku_weight_data.sku_code"
        );

        //05
        $select_in_W_receive = DB::select("SELECT
                wg_sku_weight_data.lot_number,
                wg_sku_weight_data.sku_amount,
                wg_sku_weight_data.sku_weight,
                wg_sku_weight_data.scale_number,
                wg_sku_weight_data.weighing_date,
                wg_sku_weight_data.sku_code,
                wg_sku_item.item_name,
                wg_scale.department,
                wg_scale.process_number,
                tb_order_offal.date,
                wg_sku_weight_data.weighing_type 
            FROM
                wg_sku_weight_data
                LEFT JOIN wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code
                LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                LEFT JOIN tb_order_offal ON tb_order_offal.order_number = wg_sku_weight_data.lot_number 
            WHERE
                wg_sku_weight_data.lot_number = '$order_number' 
                AND wg_scale.process_number IN ( 4, 6 )
                AND weighing_type IN (1,2)
            ORDER BY
                wg_sku_weight_data.sku_code ASC"
        );

        $select_in_R_receive = DB::select("SELECT
                wg_sku_weight_data.lot_number,
                wg_sku_weight_data.sku_amount,
                wg_sku_weight_data.sku_weight,
                wg_sku_weight_data.scale_number,
                wg_sku_weight_data.weighing_date,
                wg_sku_weight_data.sku_code,
                wg_sku_item.item_name,
                wg_scale.department,
                wg_scale.process_number,
                tb_order_offal.date,
                wg_sku_weight_data.weighing_type 
            FROM
                wg_sku_weight_data
                LEFT JOIN wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code
                LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                LEFT JOIN tb_order_offal ON tb_order_offal.order_number = wg_sku_weight_data.lot_number 
            WHERE
                wg_sku_weight_data.lot_number = '$order_number' 
                AND wg_scale.process_number IN ( 5 )
                AND weighing_type IN (1,2)
            ORDER BY
                wg_sku_weight_data.sku_code ASC"
        );
        
        $count = DB::select("SELECT
                               count(wg_sku_weight_data.lot_number) AS count_pig
                            FROM
                                wg_sku_weight_data
                                LEFT JOIN wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code
                                LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number 
                            WHERE
                                wg_sku_weight_data.lot_number = '$order_number' 
                                AND wg_scale.process_number = '1' 
                            ORDER BY
                                -- wg_sku_weight_data.sku_code
                                wg_sku_weight_data.weighing_date DESC");

        $wg_scale = DB::select("SELECT * from wg_scale WHERE wg_scale.department = '1' OR wg_scale.department = '2' ");
        $wg_scale_shop = DB::select("SELECT * from wg_scale WHERE wg_scale.location_type = 'ร้านค้า' ");
        $wg_weight_type = DB::select("SELECT * from wg_weight_type");
        $wg_sku = DB::select("SELECT * from wg_sku");
        $wg_storage = DB::select("SELECT * from wg_storage");
        
        return view('report.summary_weighing_receive',compact('select_in_R','select_in_K','select_in_before_ov','select_in_W_receive','select_in_R_receive','order_number',
                                                        'count','wg_scale','wg_scale_shop','wg_weight_type','wg_sku','wg_storage'));
    }

    public function summary_weighing_offal($order_number){

        $order_ref = DB::select("SELECT * FROM tb_order_offal WHERE order_number = '$order_number'");
        $ref_x  = $order_ref[0]->order_ref;
        $date_receive = $order_ref[0]->date;
        //05
        $select_in_W_send = DB::select("SELECT
                                    wg_sku_weight_data.lot_number,
                                    wg_sku_weight_data.sku_amount,
                                    wg_sku_weight_data.sku_weight,
                                    wg_sku_weight_data.scale_number,
                                    wg_sku_weight_data.weighing_date,
                                    wg_sku_weight_data.sku_code,
                                    wg_sku_item.item_name,
                                    wg_scale.department,
                                    wg_scale.process_number,
                                    tb_order_offal.date
                                FROM
                                    wg_sku_weight_data
                                    LEFT JOIN wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code
                                    LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                                    LEFT JOIN tb_order_offal ON tb_order_offal.order_number = wg_sku_weight_data.lot_number
                                WHERE
                                    wg_sku_weight_data.lot_number = '$order_number' 
                                    AND wg_scale.process_number = '6' 
                                    AND wg_sku_item.wg_sku_id <> 30
                                ORDER BY
                                    wg_sku_weight_data.sku_code"
        );

        $select_in_R_send = DB::select("SELECT
                                    wg_sku_weight_data.lot_number,
                                    wg_sku_weight_data.sku_amount,
                                    wg_sku_weight_data.sku_weight,
                                    wg_sku_weight_data.scale_number,
                                    wg_sku_weight_data.weighing_date,
                                    wg_sku_weight_data.sku_code,
                                    wg_sku_item.item_name,
                                    wg_scale.department,
                                    wg_scale.process_number,
                                    wg_sku_weight_data.weighing_type ,
                                    tb_order_offal.date
                                FROM
                                    wg_sku_weight_data
                                    LEFT JOIN wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code
                                    LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number 
                                    LEFT JOIN tb_order_offal ON tb_order_offal.order_number = wg_sku_weight_data.lot_number
                                WHERE
                                    wg_sku_weight_data.lot_number = '$order_number' 
                                    AND wg_scale.process_number = '5' 
                                    AND wg_sku_weight_data.weighing_type IN (2,12)
                                    AND wg_sku_item.wg_sku_id <> 30
                                ORDER BY
                                    wg_sku_weight_data.sku_code ASC"
        );

        $select_in_W_receive = DB::select("SELECT
                wg_sku_weight_data.lot_number,
                wg_sku_weight_data.sku_amount,
                wg_sku_weight_data.sku_weight,
                wg_sku_weight_data.scale_number,
                wg_sku_weight_data.weighing_date,
                wg_sku_weight_data.sku_code,
                wg_sku_item.item_name,
                wg_scale.department,
                wg_scale.process_number,
                tb_order_offal.date,
                wg_sku_weight_data.weighing_type 
            FROM
                wg_sku_weight_data
                LEFT JOIN wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code
                LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                LEFT JOIN tb_order_offal ON tb_order_offal.order_number = wg_sku_weight_data.lot_number 
            WHERE
                wg_sku_weight_data.lot_number = '$ref_x' 
                AND wg_scale.process_number IN ( 4, 6 )
                AND weighing_type IN (1,2)
                AND wg_sku_item.wg_sku_id <> 30
            ORDER BY
                wg_sku_weight_data.sku_code ASC"
        );

        $select_in_R_receive = DB::select("SELECT
                wg_sku_weight_data.lot_number,
                wg_sku_weight_data.sku_amount,
                wg_sku_weight_data.sku_weight,
                wg_sku_weight_data.scale_number,
                wg_sku_weight_data.weighing_date,
                wg_sku_weight_data.sku_code,
                wg_sku_item.item_name,
                wg_scale.department,
                wg_scale.process_number,
                tb_order_offal.date,
                wg_sku_weight_data.weighing_type 
            FROM
                wg_sku_weight_data
                LEFT JOIN wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code
                LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                LEFT JOIN tb_order_offal ON tb_order_offal.order_number = wg_sku_weight_data.lot_number 
            WHERE
                wg_sku_weight_data.lot_number = '$ref_x' 
                AND wg_scale.process_number IN ( 5 )
                AND weighing_type IN (1,2)
                AND wg_sku_item.wg_sku_id <> 30
            ORDER BY
                wg_sku_weight_data.sku_code ASC"
        );
        
        
        return view('report.summary_weighing_offal',compact('select_in_W_send','select_in_R_send','order_number','select_in_W_receive','select_in_R_receive','date_receive'));
    }

    public function summary_weighing_cutting($order_number){
        //07
        $select_in_after_ov = DB::select("SELECT
                                    wg_sku_weight_data.lot_number,
                                    wg_sku_weight_data.sku_amount,
                                    wg_sku_weight_data.sku_weight,
                                    wg_sku_weight_data.scale_number,
                                    wg_sku_weight_data.weighing_date,
                                    wg_sku_weight_data.sku_code,
                                    wg_sku_item.item_name,
                                    wg_scale.department,
                                    wg_scale.process_number 
                                FROM
                                    wg_sku_weight_data
                                    LEFT JOIN wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code
                                    LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number 
                                WHERE
                                    wg_sku_weight_data.lot_number = '$order_number' 
                                    AND wg_scale.process_number = '7' 
                                ORDER BY
                                    wg_sku_weight_data.sku_code"
        );

        //08 09
        $select_in_cutting = DB::select("SELECT
                                    wg_sku_weight_data.lot_number,
                                    wg_sku_weight_data.sku_amount,
                                    wg_sku_weight_data.sku_weight,
                                    wg_sku_weight_data.scale_number,
                                    wg_sku_weight_data.weighing_date,
                                    wg_sku_weight_data.sku_code,
                                    wg_sku_item.item_name,
                                    wg_scale.department,
                                    wg_scale.process_number,
                                    wg_sku_weight_data.weighing_type 
                                FROM
                                    wg_sku_weight_data
                                    LEFT JOIN wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code
                                    LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number 
                                WHERE
                                    wg_sku_weight_data.lot_number = '$order_number' 
                                    AND wg_scale.process_number = '8' 
                                    AND wg_sku_weight_data.weighing_type = '2' 
                                ORDER BY
                                    wg_sku_weight_data.sku_code ASC"
        );
        
        
        return view('report.summary_weighing_cutting',compact('select_in_after_ov','select_in_cutting','order_number'));
    }

    ///////////////// เพิ่มหมู กรณี หมูขึ้นชั่งไม่ได้
    public function wg_sku_weigth_add_multiple(Request $request){

        $year = substr($request->weighing_date,6,4);
        if (substr($request->weighing_date,6,4) > 2500) {
            $year = substr($request->weighing_date,6,4) - 543;
        }

        $_date = $year.'-'.substr($request->weighing_date,3,2).'-'.substr($request->weighing_date,0,2).' '.$request->time.':00';


        for ($i=0; $i < count($request->sku_code) ; $i++) { 
            DB::insert("INSERT into wg_sku_weight_data(lot_number,sku_id,sku_code,sku_amount,sku_weight,weighing_place,
            scale_number,storage_name,`user_name`,weighing_date,created_at,weighing_type,note) 
            values (?,?,?,?,?,?,?,?,?,?,?,?,?)"
            , [$request->order_number, $request->sku_id, $request->sku_code[$i], $request->sku_amount, $request->sku_weight[$i], $request->weighing_place
            , $request->scale_number, $request->storage_name, $request->user_name, $_date, now() ,$request->weighing_type,'M']);
        }

        return Redirect::back()->withErrors(['msg', 'The Message']);
    }
}