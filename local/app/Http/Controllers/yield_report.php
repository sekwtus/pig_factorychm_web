<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class yield_report extends Controller
{

    public static function main($date){
        $date_format = substr($date,0,2).'/'.substr($date,2,2).'/'.substr($date,4,4);

        $ov_list = DB::select("SELECT *  from tb_order_overnight where tb_order_overnight.date = '$date_format'");
  
        return  view('yield_report.main',compact('ov_list'));
    }

    public function slice_main(){
        return  view('yield_report.slice.slice_main');
    }

    public function slice($date){
        
        $date_format = substr($date,0,2).'/'.substr($date,2,2).'/'.substr($date,4,4);
        
        $get_r_order = DB::select("SELECT * from tb_order where `date` =  '$date_format' AND type_request = 3 ");
       
        // ถ้าไม่พบข้อมูล r ก็ไม่ทำงานต่อ 
        if(empty($get_r_order ))
           return  view('errors.common_errors',['error_code' => 'OR']);

        $order_rr = "";
        foreach ($get_r_order as $key => $value) { 
            $order_rr = $order_rr."'".$value->order_number."',";
        }
        $order_rr = substr($order_rr, 0, -1);
        $order_rr_show = str_replace("'", "", $order_rr);
        
        //หมูขุน
        $r_data_list = DB::select("SELECT
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
            wg_sku_weight_data.lot_number IN ($order_rr) AND
            wg_scale.department = 1
            GROUP BY
            wg_sku_weight_data.lot_number
            " ,[]
        );

        //เครื่องใน
        $offal_data_list = DB::select("SELECT
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
            wg_sku_weight_data.lot_number IN ($order_rr)  AND
            wg_scale.department IN (4,5,6)
            GROUP BY
            wg_sku_weight_data.sku_code
            " ,[]
        );

        if(empty($offal_data_list ))
        return  view('errors.common_errors',['error_code' => 'OF']);


        //ตัดแต่ง
        $ov_data_list = DB::select("SELECT
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
                wg_sku_weight_data.lot_number IN ($order_rr) 
                AND wg_scale.department IN ( 3 ) 
            GROUP BY
                wg_sku_weight_data.sku_code " ,[]
        );
        if(empty($ov_data_list ))
        return  view('errors.common_errors',['error_code' => 'CL']);
        
        return  view('yield_report.slice.slice',compact('order_rr_show','r_data_list','offal_data_list','ov_data_list'));
    }

    public function slice_order_main($date){
        
        
        $date_format = substr($date,0,2).'/'.substr($date,2,2).'/'.substr($date,4,4);
        $get_r_order = DB::select("SELECT * from tb_order where `date` =  '$date_format' AND type_request = 3 ");

        if(empty($get_r_order ))
        return  view('errors.common_errors',['error_code' => 'OR']);

        $order_rr = "";
        foreach ($get_r_order as $key => $value) { 
            $order_rr = $order_rr."'".$value->order_number."',";
        }
        $order_rr = substr($order_rr, 0, -1);
        $order_rr_show = str_replace("'", "", $order_rr);
        
        //หมูขุน
        $r_data_list = DB::select("SELECT
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
            wg_sku_weight_data.lot_number IN ($order_rr) AND
            wg_scale.department = 1
            GROUP BY
            wg_sku_weight_data.lot_number
            " ,[]
        );

       
        // ถ้าไม่พบข้อมูล r ก็ไม่ทำงานต่อ 
      
     
        
   
        return  view('yield_report.slice.slice_order_main',compact('order_rr_show','r_data_list'));
    }

    
    public static function data_ov($order){

        $ov_main = DB::select("SELECT * from tb_order_overnight where tb_order_overnight.order_ref = '$order' ");

        $order_ov = "";
        foreach ($ov_main as $key => $value) { 
            $order_ov = $order_ov."'".$value->order_number."',";
        }
        $order_ov = substr($order_ov, 0, -1);
        $order_r =  $order;
        
        //หมูขุน
        $r_data_list = DB::select("SELECT
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
            wg_sku_weight_data.lot_number = '$order_r' AND
            wg_scale.department = 1
            GROUP BY
            wg_sku_weight_data.lot_number
            " 
        );

        //เครื่องใน
        $offal_data_list = DB::select("SELECT
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
            wg_sku_weight_data.lot_number = ? AND
            wg_scale.department IN (4,5,6)
            GROUP BY
            wg_sku_weight_data.sku_code
            " ,[$order_r]
        );

        //ตัดแต่ง
        $ov_data_list = DB::select("SELECT
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
                wg_sku_weight_data.lot_number IN ($order_ov)
                AND wg_sku_weight_data.weighing_type IN (1,2)
                AND wg_scale.department IN ( 8, 9 ) 
            GROUP BY
                wg_sku_weight_data.sku_code" ,[]
        );
        
        return  view('yield_report.data_yield',compact('ov_data_list','order_r','r_data_list','offal_data_list','order_ov'));
    }
    // -------------- รายการ Order number ทั้งหมด  ----------------------
    public static function yield_report_data_daily_all_order($order_number){

        $get_r_order = DB::select("SELECT * FROM tb_order_overnight WHERE order_ref = '$order_number'");

        if(empty($get_r_order ))
        return  view('errors.common_errors',['error_code' => 'OR']);
      
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
                    tb_order_overnight.order_ref = '$order_number' 
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
       
        //หมูขุน
        $r_data_list = DB::select("SELECT
                count( wg_sku_weight_data.sku_amount ) AS sum_unit,
                sum( wg_sku_weight_data.sku_weight ) AS sum_weight,
                wg_sku_weight_data.sku_code,
                wg_sku_weight_data.weighing_date,
                wg_sku_weight_data.lot_number,
                DATE_FORMAT( wg_sku_weight_data.weighing_date, '%d/%m/%Y' ) AS weighing_date,
                wg_sku_item.item_name
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
        
       // เตรียม order_r เพื่อไปหาน้ำหนักก่อนหน้านี้ 
       $order_list="";
        foreach ($r_data_list as $key => $value) { 
            $order_list = $order_list."'".$value->lot_number."',";
        }
        $order_list = substr($order_list, 0, -1);
       


        //เครื่องใน
        $offal_ref = Db::select("SELECT * from tb_order_offal where order_ref IN ($order_rr) group by order_number");
       

        if(empty($offal_ref ))
        return  view('errors.common_errors',['error_code' => 'OF']);

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
                tb_order_overnight.order_ref = '$order_number' 
                AND tb_order_overnight.type_request = 3 
            GROUP BY
                tb_order_overnight.order_group 
                ) AS tb_order_overnight ON wg_sku_weight_data.lot_number = tb_order_overnight.order_group 
            WHERE
                wg_scale.department IN ( 7 ) 
            GROUP BY
                wg_sku_weight_data.lot_number
            "
        );
        // หาน้ำหนักก่อนแช่ ตั้งต้น จาก Order R ที่มีจำนวน มากว่า มา ใช้เป็นค่า เฉลี่ยน ต่อตัว  // 
      
        // เอา OV มาหา CUt
        $find_ov = "";
        foreach ($after_ov as $key => $value) { 
            $find_ov = $find_ov."'".$value->order_group."',";
        }
        $find_ov = substr($find_ov, 0, -1);

       
        //ov exit cutting line
        $cutting_ref = Db::select("SELECT * from tb_order_cutting where  `order_ref` IN($find_ov) AND marker = 'Z' ");
        

        if(empty($cutting_ref ))
        return  view('errors.common_errors',['error_code' => 'CL']);

        $order_cl = "";
        foreach ($cutting_ref as $key => $cutting) { 
            $order_cl = $order_cl."'".$cutting->order_number."',";
        }
        $order_cl = substr($order_cl, 0, -1);
        
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
                wg_sku_weight_data.lot_number IN ( $order_ov,$order_cl ) 
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
                wg_sku_weight_data.lot_number IN ( $order_ov,$order_cl ) 
                AND wg_sku_weight_data.sku_code IN ('1032') 
            GROUP BY
                REPLACE ( wg_sku_weight_data.sku_code, ' ', '' )
                " ,[]
        );
        
        $order_rr_show = str_replace("'", "", $order_rr);
        $order_ov_show = str_replace("'", "", $order_ov);
        $order_cl_show = str_replace("'", "", $order_cl);
        $order_of_show = str_replace("'", "", $order_of);


        // start line เชือด  
        // $date_format1 = substr($date,0,2).'/'.substr($date,2,2).'/'.substr($date,4,4);
        // $get_r_order1 = DB::select("SELECT * from tb_order where `date` =  '$date_format1' AND type_request = 3 ");
        
        $get_r_order1 = DB::select("SELECT * from tb_order where order_number = '$order_number'");
       
        $order_rr1 = "";
        $date_format;
        foreach ($get_r_order1 as $key => $value) { 
            $order_rr1 = $order_rr1."'".$value->order_number."',";
            $date_format = $value->date;
        }
       
        $order_rr1 = substr($order_rr1, 0, -1);
        $order_rr_show1 = str_replace("'", "", $order_rr1);
        

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

      
        
        return  view('yield_report.data_yield_daily_all_order',compact('date_format','order_rr_show','order_ov_show','order_cl_show','order_of_show',
        'r_data_list','offal_data_list','ov_data_list','after_ov','sp_data_list','order_rr_show1','r_data_list1','offal_data_list1','ov_data_list1'));
     
    }

    // 
    // 
    // -------------- รวมการติดตั้งและการเชื่อในวันนั้นด้วย -----------------------------------------
    public static function yield_report_data_daily_all($date){
       

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
                sum( wg_sku_weight_data.sku_amount ) AS sum_unit,
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

       // after_ov
       if(empty($after_ov ))
       return  view('errors.common_errors',['error_code' => 'ไม่พบ OV']);

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


        return  view('yield_report.data_yield_daily_all',compact('date_format','order_rr_show','order_ov_show','order_cl_show','order_of_show',
        'r_data_list','offal_data_list','ov_data_list','after_ov','sp_data_list','order_rr_show1','order_dd_show1','r_data_list1','offal_data_list1','ov_data_list1'));
     
    }

    public static function yield_report_data_daily($date){
        
        $date_format = substr($date,0,2).'/'.substr($date,2,2).'/'.substr($date,4,4);
        $get_r_order  = DB::select("SELECT * FROM tb_order_overnight WHERE tb_order_overnight.date = '$date_format' 
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
       
        //หมูขุน
        $r_data_list = DB::select("SELECT
                count( wg_sku_weight_data.sku_amount ) AS sum_unit,
                sum( wg_sku_weight_data.sku_weight ) AS sum_weight,
                wg_sku_weight_data.sku_code,
                wg_sku_weight_data.weighing_date,
                wg_sku_weight_data.lot_number,
                DATE_FORMAT( wg_sku_weight_data.weighing_date, '%d/%m/%Y' ) AS weighing_date,
                wg_sku_item.item_name
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
            "
        );
        // หาน้ำหนักก่อนแช่ ตั้งต้น จาก Order R ที่มีจำนวน มากว่า มา ใช้เป็นค่า เฉลี่ยน ต่อตัว  // 




        //ov exit cutting line
        $cutting_ref = Db::select("SELECT * from tb_order_cutting where `date` = '$date_format' AND marker = 'Z' ");
        $order_cl = "";
        foreach ($cutting_ref as $key => $cutting) { 
            $order_cl = $order_cl."'".$cutting->order_number."',";
        }
        $order_cl = substr($order_cl, 0, -1);
        
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
                wg_sku_weight_data.lot_number IN ( $order_ov,$order_cl ) 
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
                wg_sku_weight_data.lot_number IN ( $order_ov,$order_cl ) 
                AND wg_sku_weight_data.sku_code IN ('1032') 
            GROUP BY
                REPLACE ( wg_sku_weight_data.sku_code, ' ', '' )
                " ,[]
        );
        
        $order_rr_show = str_replace("'", "", $order_rr);
        $order_ov_show = str_replace("'", "", $order_ov);
        $order_cl_show = str_replace("'", "", $order_cl);
        $order_of_show = str_replace("'", "", $order_of);

        return  view('yield_report.data_yield_daily',compact('date_format','order_rr_show','order_ov_show','order_cl_show','order_of_show',
        'r_data_list','offal_data_list','ov_data_list','after_ov','sp_data_list'));
    }

}
