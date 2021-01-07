<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;
Use Auth;

class transform extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function transform_main(){
        return view('report.transform_main');
    }

    public function shop_transform_main(){
        return view('transform.shop_transform_main');
    }

    public function report_transform($order_number){

        $data_transform_before = DB::select("SELECT
                wg_sku_weight_data.*,
                wg_sku_item.item_name 
            FROM
                wg_sku_weight_data
                LEFT JOIN wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code 
            WHERE
                wg_sku_weight_data.lot_number = '$order_number' 
                AND wg_sku_weight_data.weighing_type = '11'
            ORDER BY
                wg_sku_weight_data.scale_number ASC,
                wg_sku_weight_data.weighing_date ASC"
        );

        $data_transform_after = DB::select("SELECT
                wg_sku_weight_data.*,
                wg_sku_item.item_name
            FROM
                wg_sku_weight_data
                LEFT JOIN wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code 
            WHERE
                wg_sku_weight_data.lot_number = '$order_number' 
                AND wg_sku_weight_data.weighing_type = '12'
            ORDER BY
                wg_sku_weight_data.scale_number ASC,
                wg_sku_weight_data.weighing_date ASC"
        );


        $data_transform = array($data_transform_before,$data_transform_after);

        return view('report.report_transform',compact('data_transform'));
    }
    
    public function transform_compare($date,$mk){
        $shop_name = Auth::user()->name;
        $shop_name = $mk;

        $shop = DB::select("SELECT * from tb_shop WHERE shop_code = '$mk'");
        $shop_name2 = $shop[0]->shop_name;
        
        $order_number = DB::select("SELECT
                action_number.id_ref_order 
            FROM
                action_number
                LEFT JOIN wg_scale ON action_number.department = wg_scale.department 
            WHERE
                DATE_FORMAT( action_number.process_number, '%d%m%Y' ) = '$date' 
                AND wg_scale.scale_number = '$shop_name' 
            GROUP BY
                id_ref_order");
        
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
            WHERE
                DATE_FORMAT( action_number.process_number, '%d%m%Y' ) = '$date' 
                AND wg_scale.scale_number = '$shop_name' 
            GROUP BY
                id_ref_order 
                )
            AND wg_sku_weight_data.weighing_type IN (11,12) 
                GROUP BY wg_sku_weight_data.lot_number
                ,wg_sku_weight_data.weighing_type
        ");

        $all_row = 0;
        foreach ($row_span as $key => $row_) {
            $all_row = $all_row + $row_->sum_row;
        }

        $data_transform_before = DB::select("SELECT * , wg_sku_item.item_name   
            FROM `wg_sku_weight_data` 
            LEFT JOIN (SELECT * from wg_sku_item GROUP BY wg_sku_item.item_code)as wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code
            WHERE lot_number IN (SELECT
                action_number.id_ref_order 
            FROM
                action_number
                LEFT JOIN wg_scale ON action_number.department = wg_scale.department 
            WHERE
                DATE_FORMAT( action_number.process_number, '%d%m%Y' ) = '$date' 
                AND wg_scale.scale_number = '$shop_name' 
            GROUP BY
                id_ref_order)
            AND wg_sku_weight_data.weighing_type = 11
            ORDER BY
            wg_sku_weight_data.lot_number ASC,
            wg_sku_weight_data.id ASC");

        $data_transform_after = DB::select("SELECT * , wg_sku_item.item_name   
            FROM `wg_sku_weight_data` 
            LEFT JOIN (SELECT * from wg_sku_item GROUP BY wg_sku_item.item_code)as wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code
            WHERE lot_number IN (SELECT
                action_number.id_ref_order 
            FROM
                action_number
                LEFT JOIN wg_scale ON action_number.department = wg_scale.department 
            WHERE
                DATE_FORMAT( action_number.process_number, '%d%m%Y' ) = '$date' 
                AND wg_scale.scale_number = '$shop_name' 
            GROUP BY
                id_ref_order)
            AND wg_sku_weight_data.weighing_type = 12
            ORDER BY
                wg_sku_weight_data.lot_number ASC,
                wg_sku_weight_data.id ASC");

        // return $arr_after_code;
        
        return view('transform.transform_compare',compact('shop_name','date','order_number','row_span','data_transform_before','data_transform_after',
        'all_row','shop_name2'));
    }

    public function get_data_shop_tranform_main(){ 
        $order_lot = DB::select("SELECT
            action_number.id_ref_order,
            action_number.department,
            DATE_FORMAT( action_number.process_number, '%d%m%Y' ) AS date,
            DATE_FORMAT( action_number.process_number, '%d/%m/%Y' ) AS date_format,
            wg_scale.location_scale,
            wg_scale.scale_number 
        FROM
            action_number
            LEFT JOIN wg_scale ON action_number.department = wg_scale.department 
        -- WHERE
            -- action_number.action_status = 1 
        GROUP BY
            DATE_FORMAT( action_number.process_number, '%d/%m/%Y' ),
            wg_scale.location_scale");


        return Datatables::of($order_lot)->addIndexColumn()->make(true);
    }

    public function transform_compare_all($date){
        
        $order_number = DB::select("SELECT
                action_number.id_ref_order,
                action_number.department,
	            wg_scale.location_scale 
            FROM
                action_number
                LEFT JOIN wg_scale ON action_number.department = wg_scale.department 
            WHERE
                --  action_number.action_status = 1
                -- AND 
                
                DATE_FORMAT( action_number.process_number, '%d%m%Y' ) = '$date'
            GROUP BY
                id_ref_order
            ORDER BY action_number.department asc"
        );
      
        $row_span = DB::select("SELECT
                *
                ,
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
            WHERE
                -- action_number.action_status = 1 
                -- AND 
                DATE_FORMAT( action_number.process_number, '%d%m%Y' ) = '$date'
            GROUP BY
                id_ref_order 
                )
            AND wg_sku_weight_data.weighing_type IN (11,12) 
                GROUP BY wg_sku_weight_data.lot_number
                ,wg_sku_weight_data.weighing_type
                ORDER BY lot_number ,  wg_sku_weight_data.weighing_type
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
            WHERE
                -- action_number.action_status = 1 
                -- AND 
                DATE_FORMAT( action_number.process_number, '%d%m%Y' ) = '$date'
            GROUP BY
                id_ref_order)
            AND wg_sku_weight_data.weighing_type = 11
            GROUP BY wg_sku_weight_data.id	
            ORDER BY lot_number,wg_sku_weight_data.id");

       

        $data_transform_after = DB::select("SELECT * , wg_sku_item.item_name   
            FROM `wg_sku_weight_data` 
            LEFT JOIN wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code
            WHERE lot_number IN (SELECT
                action_number.id_ref_order 
            FROM
                action_number
                LEFT JOIN wg_scale ON action_number.department = wg_scale.department 
            WHERE
                -- action_number.action_status = 1 
                -- AND 
                DATE_FORMAT( action_number.process_number, '%d%m%Y' ) = '$date'
            GROUP BY
                id_ref_order)
            AND wg_sku_weight_data.weighing_type = 12
            GROUP BY wg_sku_weight_data.id	
            ORDER BY lot_number,wg_sku_weight_data.id");

        // return $arr_after_code;
        // return $order_number;
        
        return view('transform.transform_compare_all',compact('date','order_number','row_span',
        'data_transform_before','data_transform_after','all_row'));
    }


}