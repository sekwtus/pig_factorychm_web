<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Illuminate\Http\Request;

class shop extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public static function index(){
        return view('shop.recieve_pig');
    }

    public function add_order(Request $request){
        return 'เพิ่มข้อมูลสำเร็จ';
    }

    public static function index_scale($id){
        return view('shop.scale');
    }

    public static function special_order($date){
    
        $branch_name = auth::user()->branch_name;
        $date_format  = substr($date,0,2).'/'.substr($date,2,2).'/'.substr($date,4,4);

        $data_request = DB::select("SELECT
                tb_shop_request_sp_order.* 
            FROM
                tb_shop_request_sp_order 
            WHERE
                date_request = '$date_format' 
                AND shop_code = '$branch_name'
                AND item_code IS NOT NULL
            order by tb_shop_request_sp_order.item_code");

        $list_number_of_pig = DB::select("SELECT * from tb_sale_order_numer_pig WHERE date_order = '$date_format' and shop_code = '$branch_name' ");

        $list_special = DB::select("SELECT * from tb_order_special WHERE item_code IS NOT NULL order by tb_order_special.item_code");

        return view('shop.special_order', compact('list_special','data_request','date_format','branch_name','list_number_of_pig'));
    }

    public static function special_order_admin($date,$shop_code){
    
        $branch_name = $shop_code;
        $date_format  = substr($date,0,2).'/'.substr($date,2,2).'/'.substr($date,4,4);

        $data_request = DB::select("SELECT
                tb_shop_request_sp_order.* 
            FROM
                tb_shop_request_sp_order 
            WHERE
                date_request = '$date_format' 
                AND shop_code = '$branch_name'
                AND item_code IS NOT NULL
            order by tb_shop_request_sp_order.item_code");

        $list_number_of_pig = DB::select("SELECT * from tb_sale_order_numer_pig WHERE date_order = '$date_format' and shop_code = '$branch_name' ");


        $list_special = DB::select("SELECT * from tb_order_special WHERE item_code IS NOT NULL order by tb_order_special.item_code");
        return view('shop.special_order', compact('list_special','data_request','date_format','branch_name','list_number_of_pig'));
    }

    public function special_order_request(Request $request){
        // return $request;
        $branch_name = $request->shop_name;
        $date_format  = $request->datepicker1;

        $data_request = DB::select("SELECT
            tb_shop_request_sp_order.* 
        FROM
            tb_shop_request_sp_order 
        WHERE
            date_request = '$date_format' 
            AND shop_code = '$branch_name'");
        
        if (empty($data_request)) { //ถ้า ไม่มี insert new !! elseมีdataของrequest แต่ละวัน ให้update --
            $insert = "";
            for ($i=0; $i < count($request->item_code); $i++) { 
                $insert = $insert . "('".$request->sp_id[$i]."','".$request->item_code[$i]."','".$request->item_name[$i]."','".$request->item_special[$i].
                "','".$request->number_of_item[$i]."','".$request->shop_name."','".$request->requester."','".$request->datepicker1."','".$request->datepicker2.
                "','".$request->datepicker3."','".$request->datepicker4."','".$request->datepicker5."','".$request->datepicker5."','".$request->note[$i]."','".$request->shop_name."','".$request->number_of_pig."'),";
            }
                
             $insert  = substr_replace($insert ,"", -1);
            DB::insert("INSERT INTO tb_shop_request_sp_order(order_special_id,item_code,item_name,item_special,number_of_item,shop_name,requester_name,date_request,date_receive,
            date_trim,date_cutting,date_transport,created_at,note,shop_code,number_of_pig) value $insert ");
        } else {
            for ($x=0; $x < count($request->item_code); $x++) { 
                DB::update("UPDATE tb_shop_request_sp_order set number_of_item = '".$request->number_of_item[$x]."', requester_name = '".$request->requester."', number_of_pig = '".$request->number_of_pig."' ,note = '".$request->note[$x]."'
                    WHERE order_special_id = ' ".$request->sp_id[$x]." ' AND shop_code = '$branch_name' AND date_request = '$date_format' ");
            }
        }

        return back();
    }

    public static function receive_sp_order_1($date){

        $date_format  = substr($date,0,2).'/'.substr($date,2,2).'/'.substr($date,4,4);
        
        $report_order = DB::select("SELECT * from tb_shop_request_report");

        //for row span
        $count_group =DB::select("SELECT
                tb_shop_request_report.`group`,
                Count( tb_shop_request_report.`group` ) AS count_group,
                tb_shop_request_group.group_name,
                tb_order_special.unit 
            FROM
                tb_shop_request_report
                LEFT JOIN tb_shop_request_group ON tb_shop_request_report.`group` = tb_shop_request_group.id
                LEFT JOIN tb_order_special ON tb_shop_request_group.id = tb_order_special.id 
            GROUP BY
                tb_shop_request_report.`group` 
            ORDER BY
                tb_shop_request_group.id ASC
        ");

        $order_sp_request =DB::select("SELECT * FROM `tb_shop_request_sp_order` WHERE date_request = '$date_format' ");

        $shop_list = DB::select("SELECT * FROM `tb_shop` WHERE shop_type_id = 2");

        $request_detail = DB::select("SELECT sum( tb_sale_order_numer_pig.number ) AS sum_number_of_pig from tb_sale_order_numer_pig WHERE date_order = '$date_format' ");


        $final_weight = DB::select("SELECT
            tb_shop_request_sp_order.id,
            tb_shop_request_sp_order.order_special_id,
            tb_shop_request_report.item_code AS item_code_main,
            tb_shop_request_report.item_name,
            sum( tb_shop_request_sp_order.number_of_item*tb_shop_request_report.base_yeild ) AS sum_number_of_item,
            tb_shop_request_report.base_yeild,
            tb_shop_request_report.item_code2
        FROM
            tb_shop_request_sp_order
            LEFT JOIN tb_shop_request_report ON tb_shop_request_sp_order.order_special_id = tb_shop_request_report.`group`
        WHERE tb_shop_request_sp_order.date_request = '$date_format' 
        GROUP BY
            tb_shop_request_report.item_code2
        ");


        // return $item_group;
        return view('factory.receive_sp_order_1',compact('report_order','count_group','order_sp_request','shop_list','request_detail','final_weight','date_format','date'));
    }
    
    public static function receive_sp_order_1_print($date){

        $date_format  = substr($date,0,2).'/'.substr($date,2,2).'/'.substr($date,4,4);
        
        $report_order = DB::select("SELECT * from tb_shop_request_report  WHERE show_offal_print = 1");

        //for row span
        $count_group =DB::select("SELECT
                tb_shop_request_report.`group`,
                Count( tb_shop_request_report.`group` ) AS count_group,
                tb_shop_request_group.group_name,
                tb_order_special.unit 
            FROM
                tb_shop_request_report
                LEFT JOIN tb_shop_request_group ON tb_shop_request_report.`group` = tb_shop_request_group.id
                LEFT JOIN tb_order_special ON tb_shop_request_group.id = tb_order_special.id 
            WHERE show_offal_print = 1
            GROUP BY
                tb_shop_request_report.`group` 
            ORDER BY
                tb_shop_request_group.id ASC
        ");

        $order_sp_request =DB::select("SELECT * FROM `tb_shop_request_sp_order` WHERE date_request = '$date_format' ");

        $shop_list = DB::select("SELECT * FROM `tb_shop` WHERE shop_type_id = 2");

        $request_detail = DB::select("SELECT sum( tb_sale_order_numer_pig.number ) AS sum_number_of_pig from tb_sale_order_numer_pig WHERE date_order = '$date_format' ");


        $final_weight = DB::select("SELECT
            tb_shop_request_sp_order.id,
            tb_shop_request_sp_order.order_special_id,
            tb_shop_request_report.item_code AS item_code_main,
            tb_shop_request_report.item_name,
            sum( tb_shop_request_sp_order.number_of_item*tb_shop_request_report.base_yeild ) AS sum_number_of_item,
            tb_shop_request_report.base_yeild,
            tb_shop_request_report.item_code2
        FROM
            tb_shop_request_sp_order
            LEFT JOIN tb_shop_request_report ON tb_shop_request_sp_order.order_special_id = tb_shop_request_report.`group`
        WHERE tb_shop_request_sp_order.date_request = '$date_format' 
        GROUP BY
            tb_shop_request_report.item_code2
        ");


        // return $item_group;
        return view('factory.receive_sp_order_1_print',compact('report_order','count_group','order_sp_request','shop_list','request_detail','final_weight','date_format'));
    }

    public static function receive_sp_order_1_print_all($date){

        $date_format  = substr($date,0,2).'/'.substr($date,2,2).'/'.substr($date,4,4);
        
        $report_order = DB::select("SELECT * from tb_shop_request_report");

        //for row span
        $count_group =DB::select("SELECT
                tb_shop_request_report.`group`,
                Count( tb_shop_request_report.`group` ) AS count_group,
                tb_shop_request_group.group_name,
                tb_order_special.unit 
            FROM
                tb_shop_request_report
                LEFT JOIN tb_shop_request_group ON tb_shop_request_report.`group` = tb_shop_request_group.id
                LEFT JOIN tb_order_special ON tb_shop_request_group.id = tb_order_special.id 
            GROUP BY
                tb_shop_request_report.`group` 
            ORDER BY
                tb_shop_request_group.id ASC
        ");

        $order_sp_request =DB::select("SELECT * FROM `tb_shop_request_sp_order` WHERE date_request = '$date_format' ");

        $shop_list = DB::select("SELECT * FROM `tb_shop` WHERE shop_type_id = 2");

        $request_detail = DB::select("SELECT sum( tb_sale_order_numer_pig.number ) AS sum_number_of_pig from tb_sale_order_numer_pig WHERE date_order = '$date_format' ");


        $final_weight = DB::select("SELECT
            tb_shop_request_sp_order.id,
            tb_shop_request_sp_order.order_special_id,
            tb_shop_request_report.item_code AS item_code_main,
            tb_shop_request_report.item_name,
            sum( tb_shop_request_sp_order.number_of_item*tb_shop_request_report.base_yeild ) AS sum_number_of_item,
            tb_shop_request_report.base_yeild,
            tb_shop_request_report.item_code2
        FROM
            tb_shop_request_sp_order
            LEFT JOIN tb_shop_request_report ON tb_shop_request_sp_order.order_special_id = tb_shop_request_report.`group`
        WHERE tb_shop_request_sp_order.date_request = '$date_format' 
        GROUP BY
            tb_shop_request_report.item_code2
        ");


        // return $item_group;
        return view('factory.receive_sp_order_1_print_all',compact('report_order','count_group','order_sp_request','shop_list','request_detail','final_weight','date_format','date'));
    }

    public function daily_sales($date){

        $date_format_shop  = substr($date,2,2).'/'.substr($date,0,2).'/'.substr($date,4,4);
        $yesterday = date('m/d/Y',strtotime($date_format_shop . "-1 days"));
        $date_show  = substr($yesterday,3,2).'/'.substr($yesterday,0,2).'/'.substr($yesterday,6,4);


        $shop_list = DB::select("SELECT * FROM `tb_shop` WHERE shop_type_id = 2");
        $item_list = DB::select("SELECT * FROM tb_shop_daily_sales");
        $weight_daily = DB::select("SELECT
            tb_shop_daily_sales.id,
            tb_shop_daily_sales.item_code,
            tb_shop_daily_sales.item_name,
            tb_shop_daily_sales.weight,
            shop_sales_report.weight_number,
            shop_sales_report.date_today,
            shop_sales_report.shop_name,
            tb_shop.marker 
        FROM
            tb_shop_daily_sales
            LEFT JOIN shop_sales_report ON tb_shop_daily_sales.item_code = shop_sales_report.item_code
            LEFT JOIN tb_shop ON shop_sales_report.shop_name = tb_shop.shop_description 
        WHERE
            shop_sales_report.date_today = '$yesterday'");

            

        return view('shop.daily_sales', compact('shop_list','item_list','weight_daily','date_show'));
    }
    
    public static function receive_sp_order_2($date){
        $date_format  = substr($date,0,2).'/'.substr($date,2,2).'/'.substr($date,4,4);
        $date_format_shop  = substr($date,2,2).'/'.substr($date,0,2).'/'.substr($date,4,4);

        // return $date_format_shop;
        $yesterday = date('m/d/Y',strtotime($date_format_shop . "-1 days"));

        $number_of_pig = DB::select("SELECT sum( tb_sale_order_numer_pig.number ) AS sum_number_of_pig from tb_sale_order_numer_pig WHERE date_order = '$date_format' ");

        $sum_number_of_pig = 0;
        foreach ($number_of_pig as $key => $number) {
            $sum_number_of_pig = $sum_number_of_pig + $number->sum_number_of_pig;
        }


        $shop_list = DB::select("SELECT * FROM `tb_shop` WHERE shop_type_id = 2");
        $item_group_main = DB::select("SELECT * FROM `tb_shop_main_group` WHERE `group` = 1");
        $item_group_main2 = DB::select("SELECT * FROM `tb_shop_main_group` WHERE `group` = 2");
        $item_group_main3 = DB::select("SELECT * FROM `tb_shop_main_group` WHERE `group` = 3");
        $item_group_main4 = DB::select("SELECT * FROM `tb_shop_main_group` WHERE `group` = 4");

        $shop_request_list = DB::select("SELECT
                tb_shop_request_sp_order.*,
                tb_order_special.group_main,
                tb_order_special.item_code2,
                tb_order_special.item_name as main_name,
                tb_order_special.item_special  as description_item,
	            tb_order_special.yield_per_one
            FROM
                tb_shop_request_sp_order
                LEFT JOIN tb_order_special ON tb_shop_request_sp_order.order_special_id = tb_order_special.id 
            WHERE
                group_main IS NOT NULL 
                AND tb_shop_request_sp_order.date_request = '$date_format'
            GROUP BY tb_shop_request_sp_order.order_special_id");

        $shop_request_data = DB::select("SELECT
            tb_shop_request_sp_order.*,
            tb_order_special.group_main,
            tb_order_special.item_name as main_name,
            tb_order_special.item_special  as description_item
            FROM
            tb_shop_request_sp_order
            LEFT JOIN tb_order_special ON tb_shop_request_sp_order.order_special_id = tb_order_special.id 
            WHERE
            group_main IS NOT NULL
            AND tb_shop_request_sp_order.date_request = '$date_format'"
        );

        
        $group_row_span = DB::select("SELECT
                tb_shop_main_group.id,
                tb_shop_main_group.item_code,
                count( tb_order_special.group_main  ) AS count_row 
            FROM
                tb_shop_main_group
                LEFT JOIN tb_order_special ON tb_shop_main_group.id = tb_order_special.group_main 
                WHERE `group` = 1
            GROUP BY
                tb_shop_main_group.id
        ");
        $group_row_span2 = DB::select("SELECT
                tb_shop_main_group.id,
                tb_shop_main_group.item_code,
                count( tb_order_special.group_main  ) AS count_row 
            FROM
                tb_shop_main_group
                LEFT JOIN tb_order_special ON tb_shop_main_group.id = tb_order_special.group_main 
                WHERE `group` = 2
            GROUP BY
                tb_shop_main_group.id
        ");
        $group_row_span3 = DB::select("SELECT
                tb_shop_main_group.id,
                tb_shop_main_group.item_code,
                count( tb_order_special.group_main  ) AS count_row 
            FROM
                tb_shop_main_group
                LEFT JOIN tb_order_special ON tb_shop_main_group.id = tb_order_special.group_main 
                WHERE `group` = 3
            GROUP BY
                tb_shop_main_group.id
        ");
        $group_row_span4 = DB::select("SELECT
                tb_shop_main_group.id,
                tb_shop_main_group.item_code,
                count( tb_order_special.group_main  ) AS count_row 
            FROM
                tb_shop_main_group
                LEFT JOIN tb_order_special ON tb_shop_main_group.id = tb_order_special.group_main 
                WHERE `group` = 4
            GROUP BY
                tb_shop_main_group.id
        ");

        $final_weight = DB::select("SELECT
            tb_shop_request_sp_order.id,
            tb_shop_request_sp_order.order_special_id,
            tb_shop_request_report.item_code AS item_code_main,
            tb_shop_request_report.item_name,
            sum( tb_shop_request_sp_order.number_of_item ) AS sum_number_of_item,
            tb_shop_request_report.base_yeild 
            FROM
            tb_shop_request_sp_order
            LEFT JOIN tb_shop_request_report ON tb_shop_request_sp_order.order_special_id = tb_shop_request_report.`group` 
            WHERE 
            tb_shop_request_sp_order.date_request = '$date_format'
            GROUP BY
            tb_shop_request_report.item_code
        ");

        $sp_summary_weight = DB::select("SELECT * FROM `tb_shop_sp_summay_weight` WHERE date_order = '$date_format'");

        $weight_daily = DB::select("SELECT
            tb_shop_daily_sales.id,
            tb_shop_daily_sales.item_code,
            tb_shop_daily_sales.item_name,
            tb_shop_daily_sales.weight,
            shop_sales_report.weight_number,
            shop_sales_report.date_today,
            shop_sales_report.shop_name,
            tb_shop.marker 
            FROM
            tb_shop_daily_sales
            LEFT JOIN shop_sales_report ON tb_shop_daily_sales.item_code = shop_sales_report.item_code
            LEFT JOIN tb_shop ON shop_sales_report.shop_name = tb_shop.shop_description 
            WHERE
            shop_sales_report.date_today = '$yesterday'"
        );

        $shop_request_data_group = DB::select("SELECT
                sum( tb_shop_request_sp_order.number_of_item ) AS sum_number_of_item,
                tb_order_special.group_main,
                tb_order_special.item_name AS main_name,
                tb_shop_request_sp_order.*,
                tb_order_special.item_special AS description_item 
            FROM
                tb_shop_request_sp_order
                LEFT JOIN tb_order_special ON tb_shop_request_sp_order.order_special_id = tb_order_special.id 
            WHERE
                tb_order_special.group_main IS NOT NULL 
                AND tb_shop_request_sp_order.date_request = '$date_format'
                AND tb_shop_request_sp_order.item_code <> '1075'
            GROUP BY
                tb_order_special.group_main,
                tb_shop_request_sp_order.shop_code"
        );

        $base_percent = DB::select("SELECT * FROM `tb_shop_base_percent` WHERE tb_shop_base_percent.date_order = '$date_format'  ORDER BY id");
        if (empty($base_percent)) {
            $date_tmp  =DB::select("SELECT *
                                    FROM `tb_shop_base_percent`
                                    WHERE 
                                    CONCAT( SUBSTR(date_order,7,4),SUBSTR(date_order,4,2),SUBSTR(date_order,1,2) )
                                    < CONCAT( SUBSTR('$date',5,4),SUBSTR('$date',3,2),SUBSTR('$date',1,2) ) 
                                    ORDER BY id DESC LIMIT 1");

            $base_percent = DB::select("SELECT * FROM `tb_shop_base_percent`  WHERE tb_shop_base_percent.date_order = '".$date_tmp[0]->date_order."'  ORDER BY id");
        }


        $shop_request_fill = DB::select("SELECT * from tb_shop_request_fill WHERE date_request = '$date_format' ");

        $sum_number2 = DB::select("SELECT
            sum( number_of_item ) AS sum_code1075 
        FROM
            tb_shop_request_sp_order 
        WHERE
            tb_shop_request_sp_order.date_request = '$date_format' 
            AND tb_shop_request_sp_order.item_code = '1075'");

        $sum_code1075 = ($sum_number2[0]->sum_code1075 == null ? 0 : $sum_number2[0]->sum_code1075);

        $data_group4 = DB::select("SELECT * FROM `tb_shop_sp_summary_unit` WHERE date_today = '$date_format' AND item_code2 IN (4098,4099)");
        // dd($data_group4);
        
        return view('factory.receive_sp_order_2', compact('shop_list','item_group_main','shop_request_list','group_row_span','sum_number_of_pig','final_weight',
                    'shop_request_data','weight_daily','shop_request_data_group','date_format','date','shop_request_fill','base_percent','sp_summary_weight',
                    'item_group_main2','group_row_span2','item_group_main3','group_row_span3','item_group_main4','group_row_span4','sum_code1075','date','data_group4'));
    }
    public static function receive_sp_order_2_print($date){
        $date_format  = substr($date,0,2).'/'.substr($date,2,2).'/'.substr($date,4,4);
        $date_format_shop  = substr($date,2,2).'/'.substr($date,0,2).'/'.substr($date,4,4);

        // return $date_format_shop;
        $yesterday = date('m/d/Y',strtotime($date_format_shop . "-1 days"));

        $number_of_pig = DB::select("SELECT sum( tb_sale_order_numer_pig.number ) AS sum_number_of_pig from tb_sale_order_numer_pig WHERE date_order = '$date_format' ");

        $sum_number_of_pig = 0;
        foreach ($number_of_pig as $key => $number) {
            $sum_number_of_pig = $sum_number_of_pig + $number->sum_number_of_pig;
        }


        $shop_list = DB::select("SELECT * FROM `tb_shop` WHERE shop_type_id = 2");
        $item_group_main = DB::select("SELECT * FROM `tb_shop_main_group` WHERE `group` = 1  and show_offal_print = 1");
        $item_group_main2 = DB::select("SELECT * FROM `tb_shop_main_group` WHERE `group` = 2 and show_offal_print = 1");
        $item_group_main3 = DB::select("SELECT * FROM `tb_shop_main_group` WHERE `group` = 3 and show_offal_print = 1");

        $shop_request_list = DB::select("SELECT
                tb_shop_request_sp_order.*,
                tb_order_special.group_main,
                tb_order_special.item_code2,
                tb_order_special.item_name as main_name,
                tb_order_special.item_special  as description_item,
	            tb_order_special.yield_per_one
            FROM
                tb_shop_request_sp_order
                LEFT JOIN tb_order_special ON tb_shop_request_sp_order.order_special_id = tb_order_special.id 
            WHERE
                group_main IS NOT NULL 
                AND tb_shop_request_sp_order.date_request = '$date_format'
            GROUP BY tb_shop_request_sp_order.order_special_id");

        $shop_request_data = DB::select("SELECT
            tb_shop_request_sp_order.*,
            tb_order_special.group_main,
            tb_order_special.item_name as main_name,
            tb_order_special.item_special  as description_item
            FROM
            tb_shop_request_sp_order
            LEFT JOIN tb_order_special ON tb_shop_request_sp_order.order_special_id = tb_order_special.id 
            WHERE
            group_main IS NOT NULL
            AND tb_shop_request_sp_order.date_request = '$date_format'"
        );

        
        $group_row_span = DB::select("SELECT
                tb_shop_main_group.id,
                tb_shop_main_group.item_code,
                count( tb_order_special.group_main  ) AS count_row 
            FROM
                tb_shop_main_group
                LEFT JOIN tb_order_special ON tb_shop_main_group.id = tb_order_special.group_main 
                WHERE `group` = 1 and show_offal_print = 1
            GROUP BY
                tb_shop_main_group.id
        ");
        $group_row_span2 = DB::select("SELECT
                tb_shop_main_group.id,
                tb_shop_main_group.item_code,
                count( tb_order_special.group_main  ) AS count_row 
            FROM
                tb_shop_main_group
                LEFT JOIN tb_order_special ON tb_shop_main_group.id = tb_order_special.group_main 
                WHERE `group` = 2 and show_offal_print = 1
            GROUP BY
                tb_shop_main_group.id
        ");
        $group_row_span3 = DB::select("SELECT
                tb_shop_main_group.id,
                tb_shop_main_group.item_code,
                count( tb_order_special.group_main  ) AS count_row 
            FROM
                tb_shop_main_group
                LEFT JOIN tb_order_special ON tb_shop_main_group.id = tb_order_special.group_main 
                WHERE `group` = 3 and show_offal_print = 1
            GROUP BY
                tb_shop_main_group.id
        ");

        $final_weight = DB::select("SELECT
            tb_shop_request_sp_order.id,
            tb_shop_request_sp_order.order_special_id,
            tb_shop_request_report.item_code AS item_code_main,
            tb_shop_request_report.item_name,
            sum( tb_shop_request_sp_order.number_of_item ) AS sum_number_of_item,
            tb_shop_request_report.base_yeild 
            FROM
            tb_shop_request_sp_order
            LEFT JOIN tb_shop_request_report ON tb_shop_request_sp_order.order_special_id = tb_shop_request_report.`group` 
            WHERE 
            tb_shop_request_sp_order.date_request = '$date_format'
            GROUP BY
            tb_shop_request_report.item_code
        ");

        $sp_summary_weight = DB::select("SELECT * FROM `tb_shop_sp_summay_weight` WHERE date_order = '$date_format'");

        $weight_daily = DB::select("SELECT
            tb_shop_daily_sales.id,
            tb_shop_daily_sales.item_code,
            tb_shop_daily_sales.item_name,
            tb_shop_daily_sales.weight,
            shop_sales_report.weight_number,
            shop_sales_report.date_today,
            shop_sales_report.shop_name,
            tb_shop.marker 
            FROM
            tb_shop_daily_sales
            LEFT JOIN shop_sales_report ON tb_shop_daily_sales.item_code = shop_sales_report.item_code
            LEFT JOIN tb_shop ON shop_sales_report.shop_name = tb_shop.shop_description 
            WHERE
            shop_sales_report.date_today = '$yesterday'"
        );

        $shop_request_data_group = DB::select("SELECT
                sum( tb_shop_request_sp_order.number_of_item ) AS sum_number_of_item,
                tb_order_special.group_main,
                tb_order_special.item_name AS main_name,
                tb_shop_request_sp_order.*,
                tb_order_special.item_special AS description_item 
            FROM
                tb_shop_request_sp_order
                LEFT JOIN tb_order_special ON tb_shop_request_sp_order.order_special_id = tb_order_special.id 
            WHERE
                tb_order_special.group_main IS NOT NULL 
                AND tb_shop_request_sp_order.date_request = '$date_format'
                AND tb_shop_request_sp_order.item_code <> '1075'
            GROUP BY
                tb_order_special.group_main,
                tb_shop_request_sp_order.shop_code"
        );

        $base_percent = DB::select("SELECT * FROM `tb_shop_base_percent` WHERE tb_shop_base_percent.date_order = '$date_format'  ORDER BY id");
        if (empty($base_percent)) {
            $date_tmp  =DB::select("SELECT *
                                    FROM `tb_shop_base_percent`
                                    WHERE 
                                    CONCAT( SUBSTR(date_order,7,4),SUBSTR(date_order,4,2),SUBSTR(date_order,1,2) )
                                    < CONCAT( SUBSTR('$date',5,4),SUBSTR('$date',3,2),SUBSTR('$date',1,2) ) 
                                    ORDER BY id DESC LIMIT 1");

            $base_percent = DB::select("SELECT * FROM `tb_shop_base_percent`  WHERE tb_shop_base_percent.date_order = '".$date_tmp[0]->date_order."'  ORDER BY id");
        }


        $shop_request_fill = DB::select("SELECT * from tb_shop_request_fill WHERE date_request = '$date_format' ");

        $sum_number2 = DB::select("SELECT
            sum( number_of_item ) AS sum_code1075 
        FROM
            tb_shop_request_sp_order 
        WHERE
            tb_shop_request_sp_order.date_request = '$date_format' 
            AND tb_shop_request_sp_order.item_code = '1075'");

        $sum_code1075 = ($sum_number2[0]->sum_code1075 == null ? 0 : $sum_number2[0]->sum_code1075);

        $data_group4 = DB::select("SELECT * FROM `tb_shop_sp_summary_unit` WHERE date_today = '$date_format' AND item_code2 IN (4098,4099)");

        
        return view('factory.receive_sp_order_2_print', compact('shop_list','item_group_main','shop_request_list','group_row_span','sum_number_of_pig','final_weight',
                    'shop_request_data','weight_daily','shop_request_data_group','date_format','date','shop_request_fill','base_percent','sp_summary_weight',
                    'item_group_main2','group_row_span2','item_group_main3','group_row_span3','sum_code1075','data_group4'));
    }
    public static function receive_sp_order_2_print_all($date){
        $date_format  = substr($date,0,2).'/'.substr($date,2,2).'/'.substr($date,4,4);
        $date_format_shop  = substr($date,2,2).'/'.substr($date,0,2).'/'.substr($date,4,4);

        // return $date_format_shop;
        $yesterday = date('m/d/Y',strtotime($date_format_shop . "-1 days"));

        $number_of_pig = DB::select("SELECT sum( tb_sale_order_numer_pig.number ) AS sum_number_of_pig from tb_sale_order_numer_pig WHERE date_order = '$date_format' ");

        $sum_number_of_pig = 0;
        foreach ($number_of_pig as $key => $number) {
            $sum_number_of_pig = $sum_number_of_pig + $number->sum_number_of_pig;
        }


        $shop_list = DB::select("SELECT * FROM `tb_shop` WHERE shop_type_id = 2");
        $item_group_main = DB::select("SELECT * FROM `tb_shop_main_group` WHERE `group` = 1");
        $item_group_main2 = DB::select("SELECT * FROM `tb_shop_main_group` WHERE `group` = 2");
        $item_group_main3 = DB::select("SELECT * FROM `tb_shop_main_group` WHERE `group` = 3");
        $item_group_main4 = DB::select("SELECT * FROM `tb_shop_main_group` WHERE `group` = 4");
        // dd($item_group_main4);
        $shop_request_list = DB::select("SELECT
                tb_shop_request_sp_order.*,
                tb_order_special.group_main,
                tb_order_special.item_code2,
                tb_order_special.item_name as main_name,
                tb_order_special.item_special  as description_item,
	            tb_order_special.yield_per_one
            FROM
                tb_shop_request_sp_order
                LEFT JOIN tb_order_special ON tb_shop_request_sp_order.order_special_id = tb_order_special.id 
            WHERE
                group_main IS NOT NULL 
                AND tb_shop_request_sp_order.date_request = '$date_format'
            GROUP BY tb_shop_request_sp_order.order_special_id");

        $shop_request_data = DB::select("SELECT
            tb_shop_request_sp_order.*,
            tb_order_special.group_main,
            tb_order_special.item_name as main_name,
            tb_order_special.item_special  as description_item
            FROM
            tb_shop_request_sp_order
            LEFT JOIN tb_order_special ON tb_shop_request_sp_order.order_special_id = tb_order_special.id 
            WHERE
            group_main IS NOT NULL
            AND tb_shop_request_sp_order.date_request = '$date_format'"
        );

        
        $group_row_span = DB::select("SELECT
                tb_shop_main_group.id,
                tb_shop_main_group.item_code,
                count( tb_order_special.group_main  ) AS count_row 
            FROM
                tb_shop_main_group
                LEFT JOIN tb_order_special ON tb_shop_main_group.id = tb_order_special.group_main 
                WHERE `group` = 1
            GROUP BY
                tb_shop_main_group.id
        ");
        $group_row_span2 = DB::select("SELECT
                tb_shop_main_group.id,
                tb_shop_main_group.item_code,
                count( tb_order_special.group_main  ) AS count_row 
            FROM
                tb_shop_main_group
                LEFT JOIN tb_order_special ON tb_shop_main_group.id = tb_order_special.group_main 
                WHERE `group` = 2
            GROUP BY
                tb_shop_main_group.id
        ");
        $group_row_span3 = DB::select("SELECT
                tb_shop_main_group.id,
                tb_shop_main_group.item_code,
                count( tb_order_special.group_main  ) AS count_row 
            FROM
                tb_shop_main_group
                LEFT JOIN tb_order_special ON tb_shop_main_group.id = tb_order_special.group_main 
                WHERE `group` = 3
            GROUP BY
                tb_shop_main_group.id
        ");
        $group_row_span4 = DB::select("SELECT
                tb_shop_main_group.id,
                tb_shop_main_group.item_code,
                count( tb_order_special.group_main  ) AS count_row 
            FROM
                tb_shop_main_group
                LEFT JOIN tb_order_special ON tb_shop_main_group.id = tb_order_special.group_main 
                WHERE `group` = 4
            GROUP BY
                tb_shop_main_group.id
        ");

        $final_weight = DB::select("SELECT
            tb_shop_request_sp_order.id,
            tb_shop_request_sp_order.order_special_id,
            tb_shop_request_report.item_code AS item_code_main,
            tb_shop_request_report.item_name,
            sum( tb_shop_request_sp_order.number_of_item ) AS sum_number_of_item,
            tb_shop_request_report.base_yeild 
            FROM
            tb_shop_request_sp_order
            LEFT JOIN tb_shop_request_report ON tb_shop_request_sp_order.order_special_id = tb_shop_request_report.`group` 
            WHERE 
            tb_shop_request_sp_order.date_request = '$date_format'
            GROUP BY
            tb_shop_request_report.item_code
        ");

        $sp_summary_weight = DB::select("SELECT * FROM `tb_shop_sp_summay_weight` WHERE date_order = '$date_format'");

        $weight_daily = DB::select("SELECT
            tb_shop_daily_sales.id,
            tb_shop_daily_sales.item_code,
            tb_shop_daily_sales.item_name,
            tb_shop_daily_sales.weight,
            shop_sales_report.weight_number,
            shop_sales_report.date_today,
            shop_sales_report.shop_name,
            tb_shop.marker 
            FROM
            tb_shop_daily_sales
            LEFT JOIN shop_sales_report ON tb_shop_daily_sales.item_code = shop_sales_report.item_code
            LEFT JOIN tb_shop ON shop_sales_report.shop_name = tb_shop.shop_description 
            WHERE
            shop_sales_report.date_today = '$yesterday'"
        );

        $shop_request_data_group = DB::select("SELECT
                sum( tb_shop_request_sp_order.number_of_item ) AS sum_number_of_item,
                tb_order_special.group_main,
                tb_order_special.item_name AS main_name,
                tb_shop_request_sp_order.*,
                tb_order_special.item_special AS description_item 
            FROM
                tb_shop_request_sp_order
                LEFT JOIN tb_order_special ON tb_shop_request_sp_order.order_special_id = tb_order_special.id 
            WHERE
                tb_order_special.group_main IS NOT NULL 
                AND tb_shop_request_sp_order.date_request = '$date_format'
                AND tb_shop_request_sp_order.item_code <> '1075'
            GROUP BY
                tb_order_special.group_main,
                tb_shop_request_sp_order.shop_code"
        );

        $base_percent = DB::select("SELECT * FROM `tb_shop_base_percent` WHERE tb_shop_base_percent.date_order = '$date_format'  ORDER BY id");
        if (empty($base_percent)) {
            $date_tmp  =DB::select("SELECT *
                                    FROM `tb_shop_base_percent`
                                    WHERE 
                                    CONCAT( SUBSTR(date_order,7,4),SUBSTR(date_order,4,2),SUBSTR(date_order,1,2) )
                                    < CONCAT( SUBSTR('$date',5,4),SUBSTR('$date',3,2),SUBSTR('$date',1,2) ) 
                                    ORDER BY id DESC LIMIT 1");

            $base_percent = DB::select("SELECT * FROM `tb_shop_base_percent`  WHERE tb_shop_base_percent.date_order = '".$date_tmp[0]->date_order."'  ORDER BY id");
        }


        $shop_request_fill = DB::select("SELECT * from tb_shop_request_fill WHERE date_request = '$date_format' ");

        $sum_number2 = DB::select("SELECT
            sum( number_of_item ) AS sum_code1075 
        FROM
            tb_shop_request_sp_order 
        WHERE
            tb_shop_request_sp_order.date_request = '$date_format' 
            AND tb_shop_request_sp_order.item_code = '1075'");

        $sum_code1075 = ($sum_number2[0]->sum_code1075 == null ? 0 : $sum_number2[0]->sum_code1075);
        
        $data_group4 = DB::select("SELECT * FROM `tb_shop_sp_summary_unit` WHERE date_today = '$date_format' AND item_code2 IN (4098,4099)");

        return view('factory.receive_sp_order_2_print_all', compact('shop_list','item_group_main','shop_request_list','group_row_span','sum_number_of_pig','final_weight',
                    'shop_request_data','weight_daily','shop_request_data_group','date_format','date','shop_request_fill','base_percent','sp_summary_weight',
                    'item_group_main2','group_row_span2','item_group_main3','item_group_main4','group_row_span4','group_row_span3','sum_code1075','date','data_group4'));
    }
    

    public function daily_sales_all(){
       $report_shop_today = DB::select("SELECT
                                    shop_sales_report.id,
                                    shop_sales_report.id_shop,
                                    GROUP_CONCAT( DISTINCT ( shop_sales_report.shop_name ) SEPARATOR ' / ' ) AS shop_name,
                                    shop_sales_report.item_code,
                                    shop_sales_report.item_name,
                                    shop_sales_report.date_today,
                                    shop_sales_report.created_at,
                                    shop_sales_report.updated_at 
                                FROM
                                    shop_sales_report 
                                GROUP BY
                                    shop_sales_report.date_today
                                ORDER BY
                                    shop_sales_report.date_today DESC");  

       return view('shop.daily_sales_all',compact('report_shop_today'));
    }

    public function receive_sp_order_2_fill(Request $request){

       //  dd($request);

        //percent
        if ($request->save_percent == 1) {
            
            $shop_code = '';
            for ($i=0; $i < count(array_keys($request->percent)) ; $i++) { 
                $shop_code = $shop_code.','.array_keys($request->percent)[$i];
            }
            $detail_data = DB::select("SELECT * FROM `tb_shop_base_percent` WHERE date_order = '28/03/2020' ORDER BY id");
            $check_exist = DB::select("SELECT * FROM `tb_shop_base_percent` WHERE date_order = '$request->datepicker1' ORDER BY id");

            $tmp_id = '';
            $dup ='';
            if (!empty($check_exist)) {
                $tmp_id = ",id";
                $dup = "ON DUPLICATE KEY UPDATE item_code2=VALUES(item_code2),
                date_order=VALUES(date_order),
                item_code=VALUES(item_code),
                id_main_group=VALUES(id_main_group),
                item_name=VALUES(item_name),
                id=VALUES(id),
                MK01=VALUES(MK01), 
                MK02=VALUES(MK02), 
                MK03=VALUES(MK03), 
                MK04=VALUES(MK04), 
                MK05=VALUES(MK05),
                MK06=VALUES(MK06), 
                MK07=VALUES(MK07),
                MK08=VALUES(MK08), 
                MK09=VALUES(MK09), 
                MK10=VALUES(MK10), 
                MK11=VALUES(MK11), 
                MK12=VALUES(MK12), 
                MK13=VALUES(MK13), 
                MK14=VALUES(MK14),
                MK15=VALUES(MK15),
                MK16=VALUES(MK16),
                MK17=VALUES(MK17),
                MK18=VALUES(MK18),
                MK19=VALUES(MK19);";
            }

            $insert = '';
            for ($code=0; $code < count( array_keys($request->percent['MK01']) ) ; $code++) {
                $insert = $insert .'("';
                $insert = $insert.array_keys($request->percent['MK01'])[$code].'","'.$request->datepicker1.'","'.$request->datepicker4.'","'.$detail_data[$code]->item_code.'","'
                .$detail_data[$code]->id_main_group.'","'.$detail_data[$code]->item_name.'",'; #1002

                if (!empty($check_exist)) {
                    $insert = $insert.$check_exist[$code]->id.',';
                }

                for ($i=0; $i < count(array_keys($request->percent)) ; $i++) { 
                    $insert = $insert.'"'.$request->percent[array_keys($request->percent)[$i]][array_keys($request->percent['MK01'])[$code]].'",';
                }
                $insert = rtrim($insert, ',');
                $insert = $insert.'),';
            }


            $insert= "INSERT INTO tb_shop_base_percent(item_code2,date_order,date_cutting,item_code,id_main_group,item_name".$tmp_id."$shop_code) values".rtrim($insert, ',').$dup;
            DB::insert($insert);
           
            
        } else {

            DB::delete("DELETE from tb_shop_sp_summary_unit WHERE date_today = '$request->datepicker1' ");
            $shop_code = '';
            for ($i=0; $i < count(array_keys($request->number_item)) ; $i++) { 
                $shop_code = $shop_code.','.array_keys($request->number_item)[$i];
            }
            $shop_code = substr($shop_code, 1);

            $insert = '';
            for ($code=0; $code < count( array_keys($request->number_item['MK01']) ) ; $code++) { 
                $insert = $insert .'("';
                $insert = $insert.array_keys($request->number_item['MK01'])[$code].'","'.$request->datepicker1.'",'; #1002

                for ($i=0; $i < count(array_keys($request->number_item)) ; $i++) { 
                    $insert = $insert.$request->number_item[array_keys($request->number_item)[$i] /* MK01-12 */][array_keys($request->number_item['MK01'])[$code]].',';
                }
                $insert = rtrim($insert, ',');
                $insert = $insert.'),';
            }

            $insert= "INSERT INTO tb_shop_sp_summary_unit(item_code2,date_today,$shop_code) values".rtrim($insert, ',');
            DB::insert($insert);
            

            $check_exist = DB::select("SELECT * from tb_shop_request_fill WHERE date_request = '$request->datepicker1' ");

            if (empty($check_exist)) {
                for ($i=0; $i < count($request->item_code_fill); $i++) {
                    DB::insert("INSERT INTO tb_shop_request_fill(item_code,`weight`,date_request,created_at)
                        VALUES('".$request->item_code_fill[$i]."','".$request->item_number_fill[$i]."','".$request->datepicker1."',now() )");
                         
                }
            } else {
                for ($i=0; $i < count($request->item_code_fill); $i++) {
                    DB::insert("UPDATE tb_shop_request_fill set `weight` = '".$request->item_number_fill[$i]."'
                        WHERE item_code = '".$request->item_code_fill[$i]."' AND date_request = '".$request->datepicker1."' ");
                        
                }
            }

            # code...
        }
            return back();
    }

    public function receive_sp_order_cutting($date){
        
        $date_format  = substr($date,0,2).'/'.substr($date,2,2).'/'.substr($date,4,4);

        $shop_list = DB::select("SELECT * FROM `tb_shop` WHERE shop_type_id = 2");
        $collumn1_code = DB::select("SELECT
                tb_shop_sp_order_cutting.id,
                count( tb_shop_sp_order_cutting.item_code ) as count_item,
                tb_shop_sp_order_cutting.item_code 
            FROM
                tb_shop_sp_order_cutting 
            WHERE report_type = 'ใบแกะ'
            GROUP BY
                tb_shop_sp_order_cutting.item_code");

        $item_list1 = DB::select("SELECT
                tb_shop_sp_order_cutting.*
            FROM
                tb_shop_sp_order_cutting
            WHERE id <= 41
            AND report_type = 'ใบแกะ'");

        $item_list2 = DB::select("SELECT
                tb_shop_sp_order_cutting.*
            FROM
                tb_shop_sp_order_cutting
            WHERE id > 41
            AND report_type = 'ใบแกะ'");

        $sp_order1 = DB::select("SELECT
                * 
            FROM
                `tb_shop_request_sp_order` 
            WHERE
                date_request = '$date_format'");

        $final_weight = DB::select("SELECT * FROM `tb_shop_sp_summary_unit` 
            WHERE date_today = '".$date_format."'
        ");

        $number_of_pig = DB::select("SELECT
        tb_shop_request_sp_order.number_of_pig
        FROM
        tb_shop_request_sp_order 
        WHERE
        tb_shop_request_sp_order.date_request = '$date_format'
        GROUP BY
        shop_code");


        $sum_number_of_pig = 0;
        foreach ($number_of_pig as $key => $number) {
        $sum_number_of_pig = $sum_number_of_pig + $number->number_of_pig;
        }

        $percent_shop = DB::select("SELECT * from tb_shop_base_percent");

        $shop_request_data_group = DB::select("SELECT
            sum( tb_shop_request_sp_order.number_of_item ) AS sum_number_of_item,
            tb_order_special.group_main,
            tb_order_special.item_name AS main_name,
            tb_shop_request_sp_order.*,
            tb_order_special.item_special AS description_item 
        FROM
            tb_shop_request_sp_order
            LEFT JOIN tb_order_special ON tb_shop_request_sp_order.order_special_id = tb_order_special.id 
        WHERE
            tb_order_special.group_main IS NOT NULL 
            AND tb_shop_request_sp_order.date_cutting = '$date_format'
        GROUP BY
            tb_order_special.group_main,
            tb_shop_request_sp_order.shop_code");

        return view('factory.receive_sp_order_cutting', compact('collumn1_code','shop_list','date_format','item_list1',
        'item_list2','sp_order1','final_weight','sum_number_of_pig','percent_shop','shop_request_data_group','date'));

    }

    public function receive_sp_order_cutting_print($date){
        
        $date_format  = substr($date,0,2).'/'.substr($date,2,2).'/'.substr($date,4,4);

        $shop_list = DB::select("SELECT * FROM `tb_shop` WHERE shop_type_id = 2");
        $collumn1_code = DB::select("SELECT
                tb_shop_sp_order_cutting.id,
                count( tb_shop_sp_order_cutting.item_code ) as count_item,
                tb_shop_sp_order_cutting.item_code 
            FROM
                tb_shop_sp_order_cutting 
            WHERE report_type = 'ใบแกะ'
            GROUP BY
                tb_shop_sp_order_cutting.item_code");

        $item_list1 = DB::select("SELECT
                tb_shop_sp_order_cutting.*
            FROM
                tb_shop_sp_order_cutting
            WHERE id <= 41
            AND report_type = 'ใบแกะ'");

        $item_list2 = DB::select("SELECT
                tb_shop_sp_order_cutting.*
            FROM
                tb_shop_sp_order_cutting
            WHERE id > 41
            AND report_type = 'ใบแกะ'");

        $sp_order1 = DB::select("SELECT
                * 
            FROM
                `tb_shop_request_sp_order` 
            WHERE
                date_request = '$date_format'");

        $final_weight = DB::select("SELECT * FROM `tb_shop_sp_summary_unit` 
            WHERE date_today = '".$date_format."'
        ");

        $number_of_pig = DB::select("SELECT
        tb_shop_request_sp_order.number_of_pig
        FROM
        tb_shop_request_sp_order 
        WHERE
        tb_shop_request_sp_order.date_request = '$date_format'
        GROUP BY
        shop_code");


        $sum_number_of_pig = 0;
        foreach ($number_of_pig as $key => $number) {
        $sum_number_of_pig = $sum_number_of_pig + $number->number_of_pig;
        }

        $percent_shop = DB::select("SELECT * from tb_shop_base_percent");

        $shop_request_data_group = DB::select("SELECT
            sum( tb_shop_request_sp_order.number_of_item ) AS sum_number_of_item,
            tb_order_special.group_main,
            tb_order_special.item_name AS main_name,
            tb_shop_request_sp_order.*,
            tb_order_special.item_special AS description_item 
        FROM
            tb_shop_request_sp_order
            LEFT JOIN tb_order_special ON tb_shop_request_sp_order.order_special_id = tb_order_special.id 
        WHERE
            tb_order_special.group_main IS NOT NULL 
            AND tb_shop_request_sp_order.date_cutting = '$date_format'
        GROUP BY
            tb_order_special.group_main,
            tb_shop_request_sp_order.shop_code");

        return view('factory.receive_sp_order_cutting_print', compact('collumn1_code','shop_list','date_format','item_list1',
        'item_list2','sp_order1','final_weight','sum_number_of_pig','percent_shop','shop_request_data_group','date'));

    }

    public function receive_sp_order_employee($date){
        $date_format  = substr($date,0,2).'/'.substr($date,2,2).'/'.substr($date,4,4);

        $shop_list = DB::select("SELECT * FROM `tb_shop` WHERE shop_type_id = 2");
        
        $collumn1_code = DB::select("SELECT
                tb_shop_sp_order_cutting.id,
                count( tb_shop_sp_order_cutting.item_code ) as count_item,
                tb_shop_sp_order_cutting.item_code 
            FROM
                tb_shop_sp_order_cutting 
            WHERE group_employee_report = 1
            GROUP BY
                tb_shop_sp_order_cutting.item_code");

        $item_list1 = DB::select("SELECT
                tb_shop_sp_order_cutting.*
            FROM
                tb_shop_sp_order_cutting
            WHERE group_employee_report = 1"
        );

        $collumn2_code = DB::select("SELECT
                tb_shop_sp_order_cutting.id,
                count( tb_shop_sp_order_cutting.item_code ) as count_item,
                tb_shop_sp_order_cutting.item_code 
            FROM
                tb_shop_sp_order_cutting 
            WHERE group_employee_report = 2
            GROUP BY
                tb_shop_sp_order_cutting.item_code");

        $item_list2 = DB::select("SELECT
                tb_shop_sp_order_cutting.*
            FROM
                tb_shop_sp_order_cutting
            WHERE group_employee_report = 2"
        );

        $collumn3_code = DB::select("SELECT
                tb_shop_sp_order_cutting.id,
                count( tb_shop_sp_order_cutting.item_code ) as count_item,
                tb_shop_sp_order_cutting.item_code 
            FROM
                tb_shop_sp_order_cutting 
            WHERE group_employee_report = 3
            AND report_cutting3_yield IS NULL
            GROUP BY
                tb_shop_sp_order_cutting.item_code");

        $item_list3 = DB::select("SELECT
                tb_shop_sp_order_cutting.*
            FROM
                tb_shop_sp_order_cutting
            WHERE group_employee_report = 3
            AND report_cutting3_yield IS NULL"
        );

        $collumn4_code = DB::select("SELECT
                tb_shop_sp_order_cutting.id,
                count( tb_shop_sp_order_cutting.item_code ) as count_item,
                tb_shop_sp_order_cutting.item_code 
            FROM
                tb_shop_sp_order_cutting 
            WHERE group_employee_report = 4
            GROUP BY
                tb_shop_sp_order_cutting.item_code");

        $item_list4 = DB::select("SELECT
                tb_shop_sp_order_cutting.*
            FROM
                tb_shop_sp_order_cutting
            WHERE group_employee_report = 4
            AND report_cutting3_yield IS NULL"
        );

        $collumn5_code = DB::select("SELECT
                tb_shop_sp_order_cutting.id,
                count( tb_shop_sp_order_cutting.item_code ) as count_item,
                tb_shop_sp_order_cutting.item_code 
            FROM
                tb_shop_sp_order_cutting 
            WHERE group_employee_report = 5
            GROUP BY
                tb_shop_sp_order_cutting.item_code");

        $item_list5 = DB::select("SELECT
                tb_shop_sp_order_cutting.*
            FROM
                tb_shop_sp_order_cutting
            WHERE group_employee_report = 5
            AND report_cutting3_yield IS NULL"
        );

        $collumn6_code = DB::select("SELECT
                tb_shop_sp_order_cutting.id,
                count( tb_shop_sp_order_cutting.item_code ) as count_item,
                tb_shop_sp_order_cutting.item_code 
            FROM
                tb_shop_sp_order_cutting 
            WHERE group_employee_report = 6
            GROUP BY
                tb_shop_sp_order_cutting.item_code");

        $item_list6 = DB::select("SELECT
                tb_shop_sp_order_cutting.*
            FROM
                tb_shop_sp_order_cutting
            WHERE group_employee_report = 6"
        );

        $final_weight = DB::select("SELECT
            tb_shop_sp_summay_weight.id,
            tb_shop_sp_summay_weight.item_code,
            tb_shop_sp_summay_weight.item_code2,
            tb_shop_sp_summay_weight.item_name,
            tb_shop_sp_summay_weight.weight_total,
            tb_shop_sp_summay_weight.date_today,
            tb_shop_base_percent.*,
            tb_shop_main_group.yield_main,
            tb_shop_main_group.yield_per_one
            FROM
            tb_shop_sp_summay_weight
            LEFT JOIN tb_shop_base_percent ON tb_shop_sp_summay_weight.item_code2 = tb_shop_base_percent.item_code2
            LEFT JOIN tb_shop_main_group ON tb_shop_sp_summay_weight.item_code2 = tb_shop_main_group.item_code2
            WHERE date_today = '$date_format'
        ");

        $number_of_pig = DB::select("SELECT
            tb_shop_request_sp_order.number_of_pig,
            tb_shop_request_sp_order.date_transport
            FROM
            tb_shop_request_sp_order 
            WHERE
            tb_shop_request_sp_order.date_request = '$date_format'
            GROUP BY
            shop_code");

        $order_sp_request = DB::select("SELECT
                tb_shop_request_sp_order.* 
            FROM
                tb_shop_request_sp_order 
            WHERE
                tb_shop_request_sp_order.date_request = '$date_format' "
        );


        $sum_number_of_pig = 0;
        foreach ($number_of_pig as $key => $number) {
        $sum_number_of_pig = $sum_number_of_pig + $number->number_of_pig;
        }

        $percent_shop = DB::select("SELECT * from tb_shop_base_percent");

        $unit_data = DB::select("SELECT * FROM `tb_shop_sp_summary_unit` WHERE date_today = '$date_format'");

        
        return view('shop.receive_sp_order_employee', compact('collumn1_code','collumn2_code','collumn3_code','collumn4_code','collumn5_code','collumn6_code','shop_list','date_format','item_list1',
        'item_list2','item_list3','item_list4','item_list5','item_list6','final_weight','sum_number_of_pig','percent_shop','unit_data','order_sp_request','date','number_of_pig'));

    }

    public function receive_sp_order_employee_print($date){
        $date_format  = substr($date,0,2).'/'.substr($date,2,2).'/'.substr($date,4,4);

        $shop_list = DB::select("SELECT * FROM `tb_shop` WHERE shop_type_id = 2");
        
        $collumn1_code = DB::select("SELECT
                tb_shop_sp_order_cutting.id,
                count( tb_shop_sp_order_cutting.item_code ) as count_item,
                tb_shop_sp_order_cutting.item_code 
            FROM
                tb_shop_sp_order_cutting 
            WHERE group_employee_report = 1
            GROUP BY
                tb_shop_sp_order_cutting.item_code");

        $item_list1 = DB::select("SELECT
                tb_shop_sp_order_cutting.*
            FROM
                tb_shop_sp_order_cutting
            WHERE group_employee_report = 1"
        );

        $collumn2_code = DB::select("SELECT
                tb_shop_sp_order_cutting.id,
                count( tb_shop_sp_order_cutting.item_code ) as count_item,
                tb_shop_sp_order_cutting.item_code 
            FROM
                tb_shop_sp_order_cutting 
            WHERE group_employee_report = 2
            GROUP BY
                tb_shop_sp_order_cutting.item_code");

        $item_list2 = DB::select("SELECT
                tb_shop_sp_order_cutting.*
            FROM
                tb_shop_sp_order_cutting
            WHERE group_employee_report = 2"
        );

        $collumn3_code = DB::select("SELECT
                tb_shop_sp_order_cutting.id,
                count( tb_shop_sp_order_cutting.item_code ) as count_item,
                tb_shop_sp_order_cutting.item_code 
            FROM
                tb_shop_sp_order_cutting 
            WHERE group_employee_report = 3
            AND report_cutting3_yield IS NULL
            GROUP BY
                tb_shop_sp_order_cutting.item_code");

        $item_list3 = DB::select("SELECT
                tb_shop_sp_order_cutting.*
            FROM
                tb_shop_sp_order_cutting
            WHERE group_employee_report = 3
            AND report_cutting3_yield IS NULL"
        );

        $collumn4_code = DB::select("SELECT
                tb_shop_sp_order_cutting.id,
                count( tb_shop_sp_order_cutting.item_code ) as count_item,
                tb_shop_sp_order_cutting.item_code 
            FROM
                tb_shop_sp_order_cutting 
            WHERE group_employee_report = 4
            GROUP BY
                tb_shop_sp_order_cutting.item_code");

        $item_list4 = DB::select("SELECT
                tb_shop_sp_order_cutting.*
            FROM
                tb_shop_sp_order_cutting
            WHERE group_employee_report = 4
            AND report_cutting3_yield IS NULL"
        );

        $collumn5_code = DB::select("SELECT
                tb_shop_sp_order_cutting.id,
                count( tb_shop_sp_order_cutting.item_code ) as count_item,
                tb_shop_sp_order_cutting.item_code 
            FROM
                tb_shop_sp_order_cutting 
            WHERE group_employee_report = 5
            GROUP BY
                tb_shop_sp_order_cutting.item_code");

        $item_list5 = DB::select("SELECT
                tb_shop_sp_order_cutting.*
            FROM
                tb_shop_sp_order_cutting
            WHERE group_employee_report = 5
            AND report_cutting3_yield IS NULL"
        );

        $collumn6_code = DB::select("SELECT
                tb_shop_sp_order_cutting.id,
                count( tb_shop_sp_order_cutting.item_code ) as count_item,
                tb_shop_sp_order_cutting.item_code 
            FROM
                tb_shop_sp_order_cutting 
            WHERE group_employee_report = 6
            GROUP BY
                tb_shop_sp_order_cutting.item_code");

        $item_list6 = DB::select("SELECT
                tb_shop_sp_order_cutting.*
            FROM
                tb_shop_sp_order_cutting
            WHERE group_employee_report = 6"
        );

        $final_weight = DB::select("SELECT
            tb_shop_sp_summay_weight.id,
            tb_shop_sp_summay_weight.item_code,
            tb_shop_sp_summay_weight.item_code2,
            tb_shop_sp_summay_weight.item_name,
            tb_shop_sp_summay_weight.weight_total,
            tb_shop_sp_summay_weight.date_today,
            tb_shop_base_percent.*,
            tb_shop_main_group.yield_main,
            tb_shop_main_group.yield_per_one
            FROM
            tb_shop_sp_summay_weight
            LEFT JOIN tb_shop_base_percent ON tb_shop_sp_summay_weight.item_code2 = tb_shop_base_percent.item_code2
            LEFT JOIN tb_shop_main_group ON tb_shop_sp_summay_weight.item_code2 = tb_shop_main_group.item_code2
            WHERE date_today = '$date_format'
        ");

        $number_of_pig = DB::select("SELECT
            tb_shop_request_sp_order.number_of_pig,
            tb_shop_request_sp_order.date_transport
            FROM
            tb_shop_request_sp_order 
            WHERE
            tb_shop_request_sp_order.date_request = '$date_format'
            GROUP BY
            shop_code");

        $order_sp_request = DB::select("SELECT
                tb_shop_request_sp_order.* 
            FROM
                tb_shop_request_sp_order 
            WHERE
                tb_shop_request_sp_order.date_request = '$date_format' "
        );


        $sum_number_of_pig = 0;
        foreach ($number_of_pig as $key => $number) {
        $sum_number_of_pig = $sum_number_of_pig + $number->number_of_pig;
        }

        $percent_shop = DB::select("SELECT * from tb_shop_base_percent");

        $unit_data = DB::select("SELECT * FROM `tb_shop_sp_summary_unit` WHERE date_today = '$date_format'");


        
        return view('shop.receive_sp_order_employee_print', compact('collumn1_code','collumn2_code','collumn3_code','collumn4_code','collumn5_code','collumn6_code','shop_list','date_format','item_list1',
        'item_list2','item_list3','item_list4','item_list5','item_list6','final_weight','sum_number_of_pig','percent_shop','unit_data','order_sp_request','date','number_of_pig'));

    }

    public function sp_summary_weight(Request $request){
        // return $request;       
        $check_exist = DB::select("SELECT * from tb_shop_sp_summay_weight WHERE date_order = '$request->datepicker1'");

        if (empty($check_exist)) {
            for ($i=0; $i <count($request->item_code); $i++) { 
                DB::insert("INSERT INTO tb_shop_sp_summay_weight(item_code,item_code2,item_name,weight_total,date_today,date_order) 
                value('".$request->item_code[$i]."',
                '".$request->item_code2[$i]."',
                '".$request->item_name[$i]."',
                '".$request->weight_total[$i]."',
                '".$request->datepicker4."',
                '".$request->datepicker1."')");
            }
        } else {
            for ($j=0; $j <count($request->item_code); $j++) { 
                DB::update("UPDATE tb_shop_sp_summay_weight set 
                weight_total = '".$request->weight_total[$j]."'
                WHERE 
                item_code2 = '".$request->item_code2[$j]."' AND
                date_today = '".$request->datepicker4."' AND
                date_order = '".$request->datepicker1."'");
            }
        }
        
        return back();

    }

    public function average_percent($date){

        //  $date = NOW();
        $date_format_shop  = substr($date,0,2).'/'.substr($date,2,2).'/'.substr($date,4,4);
        //  return $yesterday = date('m/d/Y',strtotime($date_format_shop . "-1 days"));
        //  $date_show  = substr($yesterday,3,2).'/'.substr($yesterday,0,2).'/'.substr($yesterday,6,4);

        $shop_list = DB::select("SELECT * FROM `tb_shop` WHERE shop_type_id = 2");

        $shop_base_percent = DB::select("SELECT * FROM `tb_shop_base_percent` WHERE tb_shop_base_percent.date_order = '$date_format_shop'  ORDER BY id");
        if (empty($shop_base_percent)) {
            $date_tmp  =DB::select("SELECT * FROM `tb_shop_base_percent` ORDER BY id DESC");
            $shop_base_percent = DB::select("SELECT * FROM `tb_shop_base_percent`  WHERE tb_shop_base_percent.date_order = '".$date_tmp[0]->date_order."'  ORDER BY id");
       }

        return view('shop.average_percent', compact('shop_base_percent','shop_list','date_format_shop'));
    }

    public function average_percent_save(Request $request){
        // return $request;
        $shop_code = '';
        for ($i=0; $i < count(array_keys($request->percent)) ; $i++) { 
            $shop_code = $shop_code.','.array_keys($request->percent)[$i];
        }
        $detail_data = DB::select("SELECT * FROM `tb_shop_base_percent` WHERE date_order = '28/03/2020' ORDER BY id");
        $check_exist = DB::select("SELECT * FROM `tb_shop_base_percent` WHERE date_order = '$request->datepicker1' ORDER BY id");

        $tmp_id = '';
        $dup ='';
        if (!empty($check_exist)) {
            $tmp_id = ",id";
            $dup = "ON DUPLICATE KEY UPDATE item_code2=VALUES(item_code2),
            date_order=VALUES(date_order),
            item_code=VALUES(item_code),
            id_main_group=VALUES(id_main_group),
            item_name=VALUES(item_name),
            id=VALUES(id),
            MK01=VALUES(MK01), 
            MK02=VALUES(MK02), 
            MK03=VALUES(MK03), 
            MK04=VALUES(MK04), 
            MK05=VALUES(MK05),
            MK06=VALUES(MK06), 
            MK07=VALUES(MK07),
            MK08=VALUES(MK08), 
            MK09=VALUES(MK09), 
            MK10=VALUES(MK10), 
            MK11=VALUES(MK11), 
            MK12=VALUES(MK12), 
            MK13=VALUES(MK13), 
            MK14=VALUES(MK14),
            MK15=VALUES(MK15),
            MK15=VALUES(MK16),
            MK16=VALUES(MK17),
            MK18=VALUES(MK18),
            MK19=VALUES(MK19);";
        }

        $insert = '';
        for ($code=0; $code < count( array_keys($request->percent['MK01']) ) ; $code++) {
            $insert = $insert .'("';
            $insert = $insert.array_keys($request->percent['MK01'])[$code].'","'.$request->datepicker1.'","'.$request->datepicker4.'","'.$detail_data[$code]->item_code.'","'
            .$detail_data[$code]->id_main_group.'","'.$detail_data[$code]->item_name.'",'; #1002

            if (!empty($check_exist)) {
                $insert = $insert.$check_exist[$code]->id.',';
            }
           

            for ($i=0; $i < count(array_keys($request->percent)) ; $i++) { 
                $insert = $insert.'"'.$request->percent[array_keys($request->percent)[$i]][array_keys($request->percent['MK01'])[$code]].'",';
            }
            $insert = rtrim($insert, ',');
            $insert = $insert.'),';
        }


        $insert= "INSERT INTO tb_shop_base_percent(item_code2,date_order,date_cutting,item_code,id_main_group,item_name".$tmp_id."$shop_code) values".rtrim($insert, ',').$dup;
        DB::insert($insert);

        return back();
    }

    public function shop_request_all(){
        $report_shop_today = DB::select("SELECT
                                     shop_sales_report.id,
                                     shop_sales_report.id_shop,
                                     GROUP_CONCAT( DISTINCT ( shop_sales_report.shop_name ) SEPARATOR ' / ' ) AS shop_name,
                                     shop_sales_report.item_code,
                                     shop_sales_report.item_name,
                                     shop_sales_report.date_today,
                                     shop_sales_report.created_at,
                                     shop_sales_report.updated_at 
                                 FROM
                                     shop_sales_report 
                                 GROUP BY
                                     shop_sales_report.date_today
                                 ORDER BY
                                     shop_sales_report.date_today DESC"); 
        $shop_list = DB::select("SELECT * FROM `tb_shop` WHERE shop_type_id = 2  order by id");

       $data_request = DB::select("SELECT
            tb_shop_request_sp_order.* 
        FROM
            tb_shop_request_sp_order
        GROUP BY shop_code , date_request
        ORDER BY
            tb_shop_request_sp_order.date_request");
 
        return view('shop.shop_request_all',compact('report_shop_today','shop_list','data_request'));
    }
    

}



