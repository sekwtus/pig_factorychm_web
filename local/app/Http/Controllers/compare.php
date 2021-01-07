<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;

class compare extends Controller
{
    public function factoryToShopIndex($id){
        $lot_and_order = DB::select("SELECT
                                    pd_lot.lot_number,
                                    pd_lot.id_ref_order
                                    FROM
                                    pd_lot
                                    WHERE
                                    pd_lot.id = $id");

        $ref_order = $lot_and_order[0]->id_ref_order;

        $select_process_number = DB::select("SELECT
                                    pd_lot.process_number,
                                    pd_lot.lot_number,
                                    pd_lot.id_ref_order,
                                    DATE_FORMAT(pd_lot.start_date_process,'%d/%m/%Y') AS start_date_process,
                                    pd_lot.department
                                    FROM
                                    pd_lot
                                    WHERE
                                    pd_lot.id_ref_order = '$ref_order'
                                    ORDER BY department",[]);

        $select_in_R = "";
        $select_in_K = "";
        $select_in_CT = "";
        $select_in_TS = "";

        foreach ($select_process_number as $process_number) {
            if ($process_number->department == 1) {
                $select_in_R = DB::select("SELECT
                                    wg_sku_weight_data.lot_number,
                                    wg_sku_weight_data.sku_amount,
                                    wg_sku_weight_data.sku_weight,
                                    wg_sku_weight_data.scale_number,
                                    DATE_FORMAT(wg_sku_weight_data.weighing_date,'%d/%m/%Y') as date_
                                    FROM
                                    wg_sku_weight_data
                                    WHERE
                                    wg_sku_weight_data.lot_number = '$process_number->process_number' 
                                    AND DATE_FORMAT(wg_sku_weight_data.weighing_date,'%d/%m/%Y')  = '$process_number->start_date_process'");
            }
            if ($process_number->department == 2) {
                $select_in_K = DB::select("SELECT
                                    wg_sku_weight_data.lot_number,
                                    wg_sku_weight_data.sku_amount,
                                    wg_sku_weight_data.sku_weight,
                                    wg_sku_weight_data.scale_number,
                                    DATE_FORMAT(wg_sku_weight_data.weighing_date,'%d/%m/%Y') as date_
                                    FROM
                                    wg_sku_weight_data
                                    WHERE
                                    wg_sku_weight_data.lot_number = '$process_number->process_number' 
                                    AND DATE_FORMAT(wg_sku_weight_data.weighing_date,'%d/%m/%Y')  = '$process_number->start_date_process'");
            }
            if ($process_number->department == 3) {
                $select_in_CT = DB::select("SELECT
                                    wg_sku_weight_data.lot_number,
                                    wg_sku_weight_data.sku_amount,
                                    wg_sku_weight_data.sku_weight,
                                    wg_sku_weight_data.scale_number,
                                    DATE_FORMAT(wg_sku_weight_data.weighing_date,'%d/%m/%Y') as date_
                                    FROM
                                    wg_sku_weight_data
                                    WHERE
                                    wg_sku_weight_data.lot_number = '$process_number->process_number' 
                                    AND DATE_FORMAT(wg_sku_weight_data.weighing_date,'%d/%m/%Y')  = '$process_number->start_date_process'");
            }
            if ($process_number->department == 4) {
                $select_in_TS = DB::select("SELECT
                                    wg_sku_weight_data.lot_number,
                                    wg_sku_weight_data.sku_amount,
                                    wg_sku_weight_data.sku_weight,
                                    wg_sku_weight_data.scale_number,
                                    DATE_FORMAT(wg_sku_weight_data.weighing_date,'%d/%m/%Y') as date_
                                    FROM
                                    wg_sku_weight_data
                                    WHERE
                                    wg_sku_weight_data.lot_number = '$process_number->process_number' 
                                    AND DATE_FORMAT(wg_sku_weight_data.weighing_date,'%d/%m/%Y')  = '$process_number->start_date_process'");
            }
        }
        
        return view('report.compareFacAndShop',compact('select_in_R','select_in_K','select_in_CT','select_in_TS','ref_order'));
    }

    public function selectLot(){
        $sql = DB::select("SELECT
                            pd_lot.id,
                            pd_lot.lot_number,
                            pd_lot.id_ref_order,
                            pd_lot.process_number,
                            tb_department.department_name,
                            pd_lot.order_plan_amount,
                            pd_lot.order_actual_amount,
                            DATE_FORMAT( pd_lot.start_date_process, '%d/%m/%Y' ) ,
                            pd_lot.end_date_process,
                            pd_lot.lot_status,
                            pd_lot.note,
                            pd_lot.user_id,
                            tb_order.total_pig,
                            tb_order.type_request,
                            tb_order.id_user_customer,
                            tb_order.round,
                            tb_order_type.order_type,
                            tb_customer.type,
                            tb_customer.department,
                            tb_product_plan.plan_sending AS start_date_process
                            FROM
                            pd_lot
                            LEFT JOIN tb_department ON pd_lot.department = tb_department.id
                            LEFT JOIN tb_order ON pd_lot.id_ref_order = tb_order.order_number
                            LEFT JOIN tb_order_type ON tb_order.type_request = tb_order_type.id
                            LEFT JOIN tb_customer ON tb_order.id_user_customer = tb_customer.shop_name
                            LEFT JOIN tb_product_plan ON tb_order.order_number = tb_product_plan.order_number
                            WHERE
                            tb_customer.type = 'สาขา'
                            GROUP BY
                            pd_lot.id_ref_order
                            ORDER BY
                            pd_lot.id_ref_order ASC");  
        return Datatables::of($sql)->make(true);
    }

    public function checkOrderResult($id){

        $ref_order = $id;
        
        $total_weight_in_order = DB::select("SELECT
                    Sum(wg_sku_weight_data.sku_weight) AS sum_weight,
                    count(wg_sku_weight_data.sku_weight) AS count_weight,
                    wg_sku_weight_data.scale_number,
                    wg_scale.department,
                    wg_sku_weight_data.lot_number,
                    tb_order.total_pig,
                    tb_order.id_user_customer,
                    tb_order.date, 
                    tb_order.weight_range,
                    tb_product_plan.plan_sending
                    FROM
                    wg_sku_weight_data
                    LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                    LEFT JOIN tb_order ON wg_sku_weight_data.lot_number = tb_order.order_number
                    LEFT JOIN tb_product_plan ON tb_order.order_number = tb_product_plan.order_number
                    WHERE
                    wg_sku_weight_data.lot_number = '$ref_order' AND
                    wg_scale.department = '1' ");


        // น้ำหนักจากโรงงาน
        $select_order_result = DB::select("SELECT
                                            wg_sku_item.item_code,
                                            wg_sku_item.item_name,
                                            Sum( wg_sku_weight_data.sku_amount ) AS sum_unit,
                                            Sum( wg_sku_weight_data.sku_weight ) AS sum_weight,
                                            wg_sku_weight_data.*,
                                            wg_sku_item.id,
                                            wg_sku_item.sku_category,
                                            wg_sku_item.wg_sku_id,
                                            wg_sku_item.unit,
                                            wg_sku_item.barcode,
                                            wg_sku_item.price,
                                            wg_sku_item.member_price,
                                            wg_sku_item.note,
                                            wg_sku_item.created_at,
                                            wg_sku_item.updated_at 
                                        FROM
                                            wg_sku_item
                                            LEFT JOIN (
                                        SELECT
                                            wg_sku_weight_data.*,
                                            wg_sku_weight_data.scale_number AS scale_num
                                        FROM
                                            wg_sku_weight_data
                                            LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number 
                                        WHERE
                                            wg_sku_weight_data.lot_number = '$ref_order'
                                            AND wg_sku_weight_data.weighing_type = 2
                                            AND wg_scale.scale_number IN ( 'KMK05', 'KMK06', 'KMK08', 'KMK09', 'KMK10', 'KMK11' ) 
                                            ) AS wg_sku_weight_data ON wg_sku_item.item_code = wg_sku_weight_data.sku_code 
                                        WHERE
                                            wg_sku_item.wg_sku_id IN ( 3, 4, 5, 7,6 ) 
                                        GROUP BY
                                            wg_sku_item.item_code 
                                        ORDER BY
                                            wg_sku_item.item_code ASC");
                                            
        $select_order_result_transform = DB::select("SELECT
                                            wg_sku_item.item_code,
                                            wg_sku_item.item_name,
                                            Sum( wg_sku_weight_data.sku_amount ) AS sum_unit,
                                            Sum( wg_sku_weight_data.sku_weight ) AS sum_weight,
                                            wg_sku_weight_data.*,
                                            wg_sku_item.id,
                                            wg_sku_item.sku_category,
                                            wg_sku_item.wg_sku_id,
                                            wg_sku_item.unit,
                                            wg_sku_item.barcode,
                                            wg_sku_item.price,
                                            wg_sku_item.member_price,
                                            wg_sku_item.note,
                                            wg_sku_item.created_at,
                                            wg_sku_item.updated_at 
                                        FROM
                                            wg_sku_item
                                            LEFT JOIN (
                                        SELECT
                                            wg_sku_weight_data.*,
                                            wg_sku_weight_data.scale_number AS scale_num
                                        FROM
                                            wg_sku_weight_data
                                            LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number 
                                        WHERE
                                            wg_sku_weight_data.lot_number = '$ref_order'
                                            AND wg_sku_weight_data.weighing_type = 2
                                            AND wg_scale.scale_number IN ( 'KMK05', 'KMK06', 'KMK08', 'KMK09', 'KMK10','KMK11'  ) 
                                            ) AS wg_sku_weight_data ON wg_sku_item.item_code = wg_sku_weight_data.sku_code 
                                        WHERE
                                            wg_sku_item.wg_sku_id IN ( 9 ) 
                                        GROUP BY
                                            wg_sku_item.item_code 
                                        ORDER BY
                                            wg_sku_item.item_code ASC");
        // น้ำหนักถึงร้านค้า
        $select_shop_result = DB::select("SELECT
                                            wg_sku_item.item_code,
                                            wg_sku_item.item_name,
                                            Sum( wg_sku_weight_data.sku_amount ) AS sum_unit,
                                            Sum( wg_sku_weight_data.sku_weight ) AS sum_weight,
                                            wg_sku_weight_data.*,
                                            wg_sku_item.id,
                                            wg_sku_item.sku_category,
                                            wg_sku_item.wg_sku_id,
                                            wg_sku_item.unit,
                                            wg_sku_item.barcode,
                                            wg_sku_item.price,
                                            wg_sku_item.member_price,
                                            wg_sku_item.note,
                                            wg_sku_item.created_at,
                                            wg_sku_item.updated_at 
                                        FROM
                                            wg_sku_item
                                            LEFT JOIN (
                                        SELECT
                                            wg_sku_weight_data.*,
                                            wg_sku_weight_data.scale_number AS scale_num 
                                        FROM
                                            wg_sku_weight_data
                                            LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number 
                                        WHERE
                                            wg_sku_weight_data.lot_number = '$ref_order'
                                            AND wg_sku_weight_data.weighing_type <> 3 
                                            AND wg_scale.location_type = 'ร้านค้า' 
                                            ) AS wg_sku_weight_data ON wg_sku_item.item_code = wg_sku_weight_data.sku_code 
                                        WHERE
                                            wg_sku_item.wg_sku_id IN ( 3, 4, 5, 7 ) 
                                        GROUP BY
                                            wg_sku_item.item_code 
                                        ORDER BY
                                            wg_sku_item.item_code ASC");
            $select_shop_result_transform = DB::select("SELECT
                                            wg_sku_item.item_code,
                                            wg_sku_item.item_name,
                                            Sum( wg_sku_weight_data.sku_amount ) AS sum_unit,
                                            Sum( wg_sku_weight_data.sku_weight ) AS sum_weight,
                                            wg_sku_weight_data.*,
                                            wg_sku_item.id,
                                            wg_sku_item.sku_category,
                                            wg_sku_item.wg_sku_id,
                                            wg_sku_item.unit,
                                            wg_sku_item.barcode,
                                            wg_sku_item.price,
                                            wg_sku_item.member_price,
                                            wg_sku_item.note,
                                            wg_sku_item.created_at,
                                            wg_sku_item.updated_at 
                                        FROM
                                            wg_sku_item
                                            LEFT JOIN (
                                        SELECT
                                            wg_sku_weight_data.*,
                                            wg_sku_weight_data.scale_number AS scale_num 
                                        FROM
                                            wg_sku_weight_data
                                            LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number 
                                        WHERE
                                            wg_sku_weight_data.lot_number = '$ref_order'
                                            AND wg_sku_weight_data.weighing_type <> 3 
                                            AND wg_scale.location_type = 'ร้านค้า' 
                                            ) AS wg_sku_weight_data ON wg_sku_item.item_code = wg_sku_weight_data.sku_code 
                                        WHERE
                                            wg_sku_item.wg_sku_id IN ( 9 ) 
                                        GROUP BY
                                            wg_sku_item.item_code 
                                        ORDER BY
                                            wg_sku_item.item_code ASC");


        return view('report.checkOrderResult',compact('select_order_result','select_shop_result','select_order_result_transform','select_shop_result_transform','total_weight_in_order'));
    }

    public function checkOrderResultImportcompare($id){

        $ref_order = $id;
        
        $total_weight_in_order = DB::select("SELECT
                    Sum(wg_sku_weight_data.sku_weight) AS sum_weight,
                    count(wg_sku_weight_data.sku_weight) AS count_weight,
                    wg_sku_weight_data.scale_number,
                    wg_scale.department,
                    wg_sku_weight_data.lot_number,
                    tb_order.total_pig,
                    tb_order.id_user_customer,
                    tb_order.date, 
                    tb_order.weight_range,
                    tb_product_plan.plan_sending
                    FROM
                    wg_sku_weight_data
                    LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                    LEFT JOIN tb_order ON wg_sku_weight_data.lot_number = tb_order.order_number
                    LEFT JOIN tb_product_plan ON tb_order.order_number = tb_product_plan.order_number
                    WHERE
                    wg_sku_weight_data.lot_number = '$ref_order' AND
                    wg_scale.department = '1' "
        );

        $order_transport = DB::select("SELECT
        tb_order_transport.*,
        tb_customer.customer_code
        FROM
        tb_order_transport
        LEFT JOIN tb_customer ON tb_order_transport.id_user_customer = tb_customer.customer_name
        WHERE order_number = '$ref_order'");
            
        $order_tr =  $order_transport[0]->order_number;
        
        $order_of = "'-'";
        $order_cl = "'-'";
        foreach ($order_transport as $key => $value) {
          $order_of = $order_of .",'". $value->order_offal_number."'";
  
          $order_cl = $order_cl .",'". $value->order_cutting_number."'";
        }

        
        $shop_name = $order_transport[0]->id_user_customer;
        $weight_recieve = $order_transport[0]->weight_recieve;
        $date =  substr($order_transport[0]->date_transport ,3,2).'/'.substr($order_transport[0]->date_transport ,0,2).'/'.substr($order_transport[0]->date_transport ,6,4);

        if (substr($date,6,4).substr($date,0,2).substr($date,3,2) > 20200422) {
            return $this->checkOrderResultImportcompare2($id);
        }

        if ( substr($date,6,4).substr($date,0,2).substr($date,3,2) > 20200327 ) {
            // น้ำหนักจากโรงงาน
            $select_order_result = DB::select("SELECT
                                wg_sku_item.item_code,
                                wg_sku_item.item_name,
                                compare_report.total_weight,
                                compare_report.date,
                                compare_report.unit,
                                compare_report.shop_name,
                                wg_sku_item.id,
                                wg_sku_item.sku_category,
                                wg_sku_item.wg_sku_id,
                                wg_sku_item.unit as unit_name,
                                wg_sku_item.barcode,
                                wg_sku_item.price,
                                wg_sku_item.member_price,
                                wg_sku_item.note,
                                wg_sku_item.created_at,
                                wg_sku_item.updated_at 
                            FROM
                                wg_sku_item
                                LEFT JOIN (
                            SELECT
                            cast(Sum(wg_sku_weight_data.sku_weight) as decimal(10,2)) AS total_weight,
                            Count(wg_sku_weight_data.sku_code) AS unit,
                            wg_sku_weight_data.lot_number,
                            wg_sku_weight_data.scale_number,
                            REPLACE(wg_sku_weight_data.sku_code, ' ', '') AS item_code,
                            '$shop_name' as shop_name,
                            '$ref_order' as order_number,
                            '$date ' as date
                            FROM
                            wg_sku_weight_data
                            LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                            WHERE 
                            wg_sku_weight_data.lot_number IN ($order_cl)
                            AND wg_scale.department IN (8,9)
                            AND wg_sku_weight_data.weighing_type IN (2)
                            GROUP BY
                            REPLACE(wg_sku_weight_data.sku_code, ' ', '')
                                ) AS compare_report ON wg_sku_item.item_code = REPLACE(compare_report.item_code, ' ', '')
                            WHERE
                                wg_sku_item.wg_sku_id IN (3, 7, 6, 9) 
                                -- AND compare_report.total_weight <> 0
                            GROUP BY
                                wg_sku_item.item_code 
                            ORDER BY
                                wg_sku_item.item_code ASC"
            );
            $select_order_result_of = DB::select("SELECT
                                wg_sku_item.item_code,
                                wg_sku_item.item_name,
                                compare_report.total_weight,
                                compare_report.date,
                                compare_report.unit,
                                compare_report.shop_name,
                                wg_sku_item.id,
                                wg_sku_item.sku_category,
                                wg_sku_item.wg_sku_id,
                                wg_sku_item.unit as unit_name,
                                wg_sku_item.barcode,
                                wg_sku_item.price,
                                wg_sku_item.member_price,
                                wg_sku_item.note,
                                wg_sku_item.created_at,
                                wg_sku_item.updated_at 
                            FROM
                                wg_sku_item
                                LEFT JOIN (
                            SELECT
                            cast(Sum(wg_sku_weight_data.sku_weight) as decimal(10,2)) AS total_weight,
                            Count(wg_sku_weight_data.sku_code) AS unit,
                            wg_sku_weight_data.lot_number,
                            wg_sku_weight_data.scale_number,
                            REPLACE(wg_sku_weight_data.sku_code, ' ', '') AS item_code,
                            '$shop_name' as shop_name,
                            '$ref_order' as order_number,
                            '$date ' as date
                            FROM
                            wg_sku_weight_data
                            LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                            WHERE 
                            wg_sku_weight_data.lot_number IN ($order_of)
                            AND wg_scale.department IN (4,5,6)
                            AND wg_sku_weight_data.weighing_type IN (2)
                            GROUP BY
                            REPLACE(wg_sku_weight_data.sku_code, ' ', '')
                                ) AS compare_report ON wg_sku_item.item_code = REPLACE(compare_report.item_code, ' ', '')
                            WHERE
                                wg_sku_item.wg_sku_id IN (4, 5) 
                                -- AND compare_report.total_weight <> 0
                            GROUP BY
                                wg_sku_item.item_code 
                            ORDER BY
                                wg_sku_item.item_code ASC"
            );
            #itemcode ที่ใช้ทั้งคู่
            $select_order_same = DB::select("SELECT
                    wg_sku_item.item_code,
                    wg_sku_item.item_name,
                    compare_report.total_weight,
                    compare_report.date,
                    compare_report.unit,
                    compare_report.shop_name,
                    wg_sku_item.id,
                    wg_sku_item.sku_category,
                    wg_sku_item.wg_sku_id,
                    wg_sku_item.unit as unit_name,
                    wg_sku_item.barcode,
                    wg_sku_item.price,
                    wg_sku_item.member_price,
                    wg_sku_item.note,
                    wg_sku_item.created_at,
                    wg_sku_item.updated_at 
                FROM
                    wg_sku_item
                    LEFT JOIN (
                SELECT
                cast(Sum(wg_sku_weight_data.sku_weight) as decimal(10,2)) AS total_weight,
                Count(wg_sku_weight_data.sku_code) AS unit,
                wg_sku_weight_data.lot_number,
                wg_sku_weight_data.scale_number,
                REPLACE(wg_sku_weight_data.sku_code, ' ', '') AS item_code,
                '$shop_name' as shop_name,
                '$ref_order' as order_number,
                '$date ' as date
                FROM
                wg_sku_weight_data
                LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                WHERE 
                wg_sku_weight_data.lot_number IN ($order_cl)
                AND wg_scale.department IN (8,9)
                AND wg_sku_weight_data.weighing_type IN (2)
                GROUP BY
                REPLACE(wg_sku_weight_data.sku_code, ' ', '')
                    ) AS compare_report ON wg_sku_item.item_code = REPLACE(compare_report.item_code, ' ', '')
                WHERE
                    wg_sku_item.wg_sku_id IN (30) 
                GROUP BY
                    wg_sku_item.item_code 
                ORDER BY
                    wg_sku_item.item_code ASC"
            );
            $select_order_result_transform = DB::select("SELECT
                                wg_sku_item.item_code,
                                wg_sku_item.item_name,
                                compare_report.total_weight,
                                compare_report.date,
                                compare_report.unit,
                                compare_report.shop_name,
                                wg_sku_item.id,
                                wg_sku_item.sku_category,
                                wg_sku_item.wg_sku_id,
                                wg_sku_item.unit as unit_name,
                                wg_sku_item.barcode,
                                wg_sku_item.price,
                                wg_sku_item.member_price,
                                wg_sku_item.note,
                                wg_sku_item.created_at,
                                wg_sku_item.updated_at 
                            FROM
                                wg_sku_item
                                LEFT JOIN (
                            SELECT
                            cast(Sum(wg_sku_weight_data.sku_weight) as decimal(10,2)) AS total_weight,
                            Count(wg_sku_weight_data.sku_code) AS unit,
                            wg_sku_weight_data.lot_number,
                            wg_sku_weight_data.scale_number,
                            REPLACE(wg_sku_weight_data.sku_code, ' ', '') AS item_code,
                            '$shop_name' as shop_name,
                            '$ref_order' as order_number,
                            '$date ' as date
                            FROM
                            wg_sku_weight_data
                            LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                            WHERE 
                            wg_sku_weight_data.lot_number IN ($order_cl,$order_of)
                                AND wg_scale.department IN ( 4, 5, 6, 8, 9 )
                                AND wg_sku_weight_data.weighing_type IN ( 12 ) 
                            GROUP BY
                                REPLACE ( wg_sku_weight_data.sku_code, ' ', '' )
                                ) AS compare_report ON wg_sku_item.item_code = REPLACE ( compare_report.item_code, ' ', '' )
                            WHERE
                                compare_report.total_weight <> 0
                            GROUP BY
                                wg_sku_item.item_code
                            ORDER BY
                                wg_sku_item.item_code ASC "
            );
        }else{
            // น้ำหนักจากโรงงาน
            $select_order_result = DB::select("SELECT
                                wg_sku_item.item_code,
                                wg_sku_item.item_name,
                                compare_report.total_weight,
                                compare_report.date,
                                compare_report.unit,
                                compare_report.shop_name,
                                wg_sku_item.id,
                                wg_sku_item.sku_category,
                                wg_sku_item.wg_sku_id,
                                wg_sku_item.unit as unit_name,
                                wg_sku_item.barcode,
                                wg_sku_item.price,
                                wg_sku_item.member_price,
                                wg_sku_item.note,
                                wg_sku_item.created_at,
                                wg_sku_item.updated_at 
                            FROM
                                wg_sku_item
                                LEFT JOIN (
                            SELECT
                            cast(Sum(wg_sku_weight_data.sku_weight) as decimal(10,2)) AS total_weight,
                            Count(wg_sku_weight_data.sku_code) AS unit,
                            wg_sku_weight_data.lot_number,
                            wg_sku_weight_data.scale_number,
                            REPLACE(wg_sku_weight_data.sku_code, ' ', '') AS item_code,
                            '$shop_name' as shop_name,
                            '$ref_order' as order_number,
                            '$date ' as date
                            FROM
                            wg_sku_weight_data
                            LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                            WHERE 
                            wg_sku_weight_data.lot_number IN ($order_cl)
                            AND wg_scale.department IN (8,9)
                            AND wg_sku_weight_data.weighing_type IN (2)
                            GROUP BY
                            REPLACE(wg_sku_weight_data.sku_code, ' ', '')
                                ) AS compare_report ON wg_sku_item.item_code = REPLACE(compare_report.item_code, ' ', '')
                            WHERE
                                wg_sku_item.wg_sku_id IN (3, 7, 6, 9) 
                            GROUP BY
                                wg_sku_item.item_code 
                            ORDER BY
                                wg_sku_item.item_code ASC"
            );
            $select_order_result_of = DB::select("SELECT
                                wg_sku_item.item_code,
                                wg_sku_item.item_name,
                                compare_report.total_weight,
                                compare_report.date,
                                compare_report.unit,
                                compare_report.shop_name,
                                wg_sku_item.id,
                                wg_sku_item.sku_category,
                                wg_sku_item.wg_sku_id,
                                wg_sku_item.unit as unit_name,
                                wg_sku_item.barcode,
                                wg_sku_item.price,
                                wg_sku_item.member_price,
                                wg_sku_item.note,
                                wg_sku_item.created_at,
                                wg_sku_item.updated_at 
                            FROM
                                wg_sku_item
                                LEFT JOIN (
                            SELECT
                            cast(Sum(wg_sku_weight_data.sku_weight) as decimal(10,2)) AS total_weight,
                            Count(wg_sku_weight_data.sku_code) AS unit,
                            wg_sku_weight_data.lot_number,
                            wg_sku_weight_data.scale_number,
                            REPLACE(wg_sku_weight_data.sku_code, ' ', '') AS item_code,
                            '$shop_name' as shop_name,
                            '$ref_order' as order_number,
                            '$date ' as date
                            FROM
                            wg_sku_weight_data
                            LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                            WHERE 
                            wg_sku_weight_data.lot_number IN ($order_of)
                            AND wg_scale.department IN (4,5,6)
                            AND wg_sku_weight_data.weighing_type IN (2)
                            GROUP BY
                            REPLACE(wg_sku_weight_data.sku_code, ' ', '')
                                ) AS compare_report ON wg_sku_item.item_code = REPLACE(compare_report.item_code, ' ', '')
                            WHERE
                                wg_sku_item.wg_sku_id IN (4, 5) 
                            GROUP BY
                                wg_sku_item.item_code 
                            ORDER BY
                                wg_sku_item.item_code ASC"
            );
            #itemcode ที่ใช้ทั้งคู่
            $select_order_same = DB::select("SELECT
                    wg_sku_item.item_code,
                    wg_sku_item.item_name,
                    compare_report.total_weight,
                    compare_report.date,
                    compare_report.unit,
                    compare_report.shop_name,
                    wg_sku_item.id,
                    wg_sku_item.sku_category,
                    wg_sku_item.wg_sku_id,
                    wg_sku_item.unit as unit_name,
                    wg_sku_item.barcode,
                    wg_sku_item.price,
                    wg_sku_item.member_price,
                    wg_sku_item.note,
                    wg_sku_item.created_at,
                    wg_sku_item.updated_at 
                FROM
                    wg_sku_item
                    LEFT JOIN (
                SELECT
                cast(Sum(wg_sku_weight_data.sku_weight) as decimal(10,2)) AS total_weight,
                Count(wg_sku_weight_data.sku_code) AS unit,
                wg_sku_weight_data.lot_number,
                wg_sku_weight_data.scale_number,
                REPLACE(wg_sku_weight_data.sku_code, ' ', '') AS item_code,
                '$shop_name' as shop_name,
                '$ref_order' as order_number,
                '$date ' as date
                FROM
                wg_sku_weight_data
                LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                WHERE 
                wg_sku_weight_data.lot_number IN ($order_cl)
                AND wg_scale.department IN (8,9)
                AND wg_sku_weight_data.weighing_type IN (2)
                GROUP BY
                REPLACE(wg_sku_weight_data.sku_code, ' ', '')
                    ) AS compare_report ON wg_sku_item.item_code = REPLACE(compare_report.item_code, ' ', '')
                WHERE
                    wg_sku_item.wg_sku_id IN (30) 
                GROUP BY
                    wg_sku_item.item_code 
                ORDER BY
                    wg_sku_item.item_code ASC"
            );

            $select_order_result_transform = DB::select("SELECT
                                wg_sku_item.item_code,
                                wg_sku_item.item_name,
                                compare_report.total_weight,
                                compare_report.date,
                                compare_report.unit,
                                compare_report.shop_name,
                                wg_sku_item.id,
                                wg_sku_item.sku_category,
                                wg_sku_item.wg_sku_id,
                                wg_sku_item.unit as unit_name,
                                wg_sku_item.barcode,
                                wg_sku_item.price,
                                wg_sku_item.member_price,
                                wg_sku_item.note,
                                wg_sku_item.created_at,
                                wg_sku_item.updated_at 
                            FROM
                                wg_sku_item
                                LEFT JOIN (
                            SELECT
                            cast(Sum(wg_sku_weight_data.sku_weight) as decimal(10,2)) AS total_weight,
                            Count(wg_sku_weight_data.sku_code) AS unit,
                            wg_sku_weight_data.lot_number,
                            wg_sku_weight_data.scale_number,
                            REPLACE(wg_sku_weight_data.sku_code, ' ', '') AS item_code,
                            '$shop_name' as shop_name,
                            '$ref_order' as order_number,
                            '$date ' as date
                            FROM
                            wg_sku_weight_data
                            LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                            WHERE 
                            wg_sku_weight_data.lot_number IN ($order_cl,$order_of)
                                AND wg_scale.department IN ( 4, 5, 6, 8, 9 )
                                AND wg_sku_weight_data.weighing_type IN ( 12 ) 
                            GROUP BY
                                REPLACE ( wg_sku_weight_data.sku_code, ' ', '' )
                                ) AS compare_report ON wg_sku_item.item_code = REPLACE ( compare_report.item_code, ' ', '' )
                            WHERE
                                compare_report.total_weight <> 0
                            GROUP BY
                                wg_sku_item.item_code
                            ORDER BY
                                wg_sku_item.item_code ASC "
            );
        }

        // น้ำหนักตัดแต่งทั้งหมด
        $sum_total_weight_factory = 0;
        foreach ($select_order_result as $key => $value) {
            $sum_total_weight_factory = $sum_total_weight_factory + $value->total_weight;
        }
        foreach ($select_order_result_of as $key => $value) {
            $sum_total_weight_factory = $sum_total_weight_factory + $value->total_weight;
        }
        foreach ($select_order_same as $key => $value) {
            $sum_total_weight_factory = $sum_total_weight_factory + $value->total_weight;
        }



        $item_tf = "'0000'";
        foreach ($select_order_result_transform as $key => $result_transform) {
            $item_tf = $item_tf . ",'$result_transform->item_code'";
        }

        // น้ำหนักถึงร้านค้า
        $select_shop_result = DB::select("SELECT
                                            wg_sku_item.item_code,
                                            wg_sku_item.item_name,
                                            SUM(compare_report_shop.total_weight) as total_weight,
                                            SUM(compare_report_shop.unit) as unit,
                                            wg_sku_item.id,
                                            wg_sku_item.sku_category,
                                            wg_sku_item.wg_sku_id,
                                            wg_sku_item.unit as unit_name,
                                            wg_sku_item.barcode,
                                            wg_sku_item.price,
                                            wg_sku_item.member_price,
                                            wg_sku_item.note,
                                            wg_sku_item.created_at,
                                            wg_sku_item.updated_at 
                                        FROM
                                            wg_sku_item
                                            LEFT JOIN (
                                        SELECT
                                        compare_report_shop.*
                                        FROM
                                        compare_report_shop
                                        WHERE compare_report_shop.order_number = '$ref_order'
                                            ) AS compare_report_shop ON wg_sku_item.item_code = REPLACE(compare_report_shop.item_code , ' ', '')
                                        WHERE
                                            wg_sku_item.wg_sku_id IN ( 3, 4, 5, 7, 6 ,9) 
                                            AND wg_sku_item.item_code NOT IN ($item_tf)
                                        GROUP BY
                                            wg_sku_item.item_code 
                                        ORDER BY
                                            wg_sku_item.item_code ASC"
        );

        $select_shop_result_transform = DB::select("SELECT
                                            wg_sku_item.item_code,
                                            wg_sku_item.item_name,
                                            SUM(compare_report_shop.total_weight) as total_weight,
                                            SUM(compare_report_shop.unit) as unit,
                                            wg_sku_item.id,
                                            wg_sku_item.sku_category,
                                            wg_sku_item.wg_sku_id,
                                            wg_sku_item.unit as unit_name,
                                            wg_sku_item.barcode,
                                            wg_sku_item.price,
                                            wg_sku_item.member_price,
                                            wg_sku_item.note,
                                            wg_sku_item.created_at,
                                            wg_sku_item.updated_at 
                                        FROM
                                            wg_sku_item
                                            LEFT JOIN (
                                        SELECT
                                        compare_report_shop.*
                                        FROM
                                        compare_report_shop
                                        WHERE compare_report_shop.order_number = '$ref_order'
                                            ) AS compare_report_shop ON wg_sku_item.item_code = REPLACE(compare_report_shop.item_code , ' ', '')
                                        WHERE
                                            wg_sku_item.wg_sku_id IN ( 3, 4, 5, 7, 6 ,9) 
                                            AND wg_sku_item.item_code IN ($item_tf)
                                        GROUP BY
                                            wg_sku_item.item_code 
                                        ORDER BY
                                            wg_sku_item.item_code ASC"
        );

        return view('report.checkOrderResultCompare',compact('select_order_result','select_shop_result','select_order_result_transform','select_shop_result_transform','total_weight_in_order'
        ,'shop_name','date' , 'weight_recieve','order_tr','sum_total_weight_factory','select_order_result_of','select_order_same','ref_order'));
    }

    // ใช้หลังวันที่23/04/2020
    public function checkOrderResultImportcompare2($id){

        $ref_order = $id;
        
        $total_weight_in_order = DB::select("SELECT
                    Sum(wg_sku_weight_data.sku_weight) AS sum_weight,
                    count(wg_sku_weight_data.sku_weight) AS count_weight,
                    wg_sku_weight_data.scale_number,
                    wg_scale.department,
                    wg_sku_weight_data.lot_number,
                    tb_order.total_pig,
                    tb_order.id_user_customer,
                    tb_order.date, 
                    tb_order.weight_range,
                    tb_product_plan.plan_sending
                    FROM
                    wg_sku_weight_data
                    LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                    LEFT JOIN tb_order ON wg_sku_weight_data.lot_number = tb_order.order_number
                    LEFT JOIN tb_product_plan ON tb_order.order_number = tb_product_plan.order_number
                    WHERE
                    wg_sku_weight_data.lot_number = '$ref_order' AND
                    wg_scale.department = '1' "
        );

        $order_transport = DB::select("SELECT
            tb_order_transport.*,
            tb_customer.customer_code
            FROM
            tb_order_transport
            LEFT JOIN tb_customer ON tb_order_transport.id_user_customer = tb_customer.customer_name
            WHERE order_number = '$ref_order'"
        );
            
        $order_tr =  $order_transport[0]->order_number;
        
        $order_of = "'-'";
        $order_cl = "'-'";
        foreach ($order_transport as $key => $value) {
          $order_of = $order_of .",'". $value->order_offal_number."'";
  
          $order_cl = $order_cl .",'". $value->order_cutting_number."'";
        }


        $shop_name = $order_transport[0]->id_user_customer;
        $weight_recieve = $order_transport[0]->weight_recieve;
        $date =  substr($order_transport[0]->date_transport ,3,2).'/'.substr($order_transport[0]->date_transport ,0,2).'/'.substr($order_transport[0]->date_transport ,6,4);

        if ( substr($date,6,4).substr($date,0,2).substr($date,3,2) > 20200327 ) {
            // น้ำหนักจากโรงงาน
            $select_order_result = DB::select("SELECT
                                wg_sku_item.item_code,
                                wg_sku_item.item_name,
                                compare_report.total_weight,
                                compare_report.date,
                                compare_report.unit,
                                compare_report.shop_name,
                                wg_sku_item.id,
                                wg_sku_item.sku_category,
                                wg_sku_item.wg_sku_id,
                                wg_sku_item.unit as unit_name,
                                wg_sku_item.barcode,
                                wg_sku_item.price,
                                wg_sku_item.member_price,
                                wg_sku_item.note,
                                wg_sku_item.created_at,
                                wg_sku_item.updated_at 
                            FROM
                                wg_sku_item
                                LEFT JOIN (
                            SELECT
                            cast(Sum(wg_sku_weight_data.sku_weight) as decimal(10,2)) AS total_weight,
                            Count(wg_sku_weight_data.sku_code) AS unit,
                            wg_sku_weight_data.lot_number,
                            wg_sku_weight_data.scale_number,
                            REPLACE(wg_sku_weight_data.sku_code, ' ', '') AS item_code,
                            '$shop_name' as shop_name,
                            '$ref_order' as order_number,
                            '$date ' as date
                            FROM
                            wg_sku_weight_data
                            LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                            WHERE 
                            wg_sku_weight_data.lot_number IN ($order_cl)
                            AND wg_scale.department IN (8,9)
                            AND wg_sku_weight_data.weighing_type IN (2,12)
                            GROUP BY
                            REPLACE(wg_sku_weight_data.sku_code, ' ', '')
                                ) AS compare_report ON wg_sku_item.item_code = REPLACE(compare_report.item_code, ' ', '')
                            WHERE                      
                                wg_sku_item.group_show_report IN (1) 
                                AND wg_sku_item.wg_sku_id NOT IN ('30')
                            GROUP BY
                                wg_sku_item.item_code 
                            ORDER BY
                                wg_sku_item.item_code ASC"
            );
            $select_order_result_of = DB::select("SELECT
                                wg_sku_item.item_code,
                                wg_sku_item.item_name,
                                compare_report.total_weight,
                                compare_report.date,
                                compare_report.unit,
                                compare_report.shop_name,
                                wg_sku_item.id,
                                wg_sku_item.sku_category,
                                wg_sku_item.wg_sku_id,
                                wg_sku_item.unit as unit_name,
                                wg_sku_item.barcode,
                                wg_sku_item.price,
                                wg_sku_item.member_price,
                                wg_sku_item.note,
                                wg_sku_item.created_at,
                                wg_sku_item.updated_at 
                            FROM
                                wg_sku_item
                                LEFT JOIN (
                            SELECT
                            cast(Sum(wg_sku_weight_data.sku_weight) as decimal(10,2)) AS total_weight,
                            Count(wg_sku_weight_data.sku_code) AS unit,
                            wg_sku_weight_data.lot_number,
                            wg_sku_weight_data.scale_number,
                            REPLACE(wg_sku_weight_data.sku_code, ' ', '') AS item_code,
                            '$shop_name' as shop_name,
                            '$ref_order' as order_number,
                            '$date ' as date
                            FROM
                            wg_sku_weight_data
                            LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                            WHERE 
                            wg_sku_weight_data.lot_number IN ($order_of)
                            AND wg_scale.department IN (4,5,6)
                            AND wg_sku_weight_data.weighing_type IN (2,12)
                            GROUP BY
                            REPLACE(wg_sku_weight_data.sku_code, ' ', '')
                                ) AS compare_report ON wg_sku_item.item_code = REPLACE(compare_report.item_code, ' ', '')
                            WHERE
                                wg_sku_item.group_show_report IN (2) 
                                AND wg_sku_item.item_code NOT IN ('1011','1109')
                            GROUP BY
                                wg_sku_item.item_code 
                            ORDER BY
                                wg_sku_item.item_code ASC"
            );
            $select_order_result_transform = DB::select("SELECT
                                wg_sku_item.item_code,
                                wg_sku_item.item_name,
                                compare_report.total_weight,
                                compare_report.date,
                                compare_report.unit,
                                compare_report.shop_name,
                                wg_sku_item.id,
                                wg_sku_item.sku_category,
                                wg_sku_item.wg_sku_id,
                                wg_sku_item.unit as unit_name,
                                wg_sku_item.barcode,
                                wg_sku_item.price,
                                wg_sku_item.member_price,
                                wg_sku_item.note,
                                wg_sku_item.created_at,
                                wg_sku_item.updated_at 
                            FROM
                                wg_sku_item
                                LEFT JOIN (
                            SELECT
                            cast(Sum(wg_sku_weight_data.sku_weight) as decimal(10,2)) AS total_weight,
                            Count(wg_sku_weight_data.sku_code) AS unit,
                            wg_sku_weight_data.lot_number,
                            wg_sku_weight_data.scale_number,
                            REPLACE(wg_sku_weight_data.sku_code, ' ', '') AS item_code,
                            '$shop_name' as shop_name,
                            '$ref_order' as order_number,
                            '$date ' as date
                            FROM
                            wg_sku_weight_data
                            LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                            WHERE 
                            wg_sku_weight_data.lot_number IN ($order_cl,$order_of)
                                AND wg_scale.department IN ( 4, 5, 6, 8, 9 )
                                AND wg_sku_weight_data.weighing_type IN (2, 12 ) 
                            GROUP BY
                                REPLACE ( wg_sku_weight_data.sku_code, ' ', '' )
                                ) AS compare_report ON wg_sku_item.item_code = REPLACE ( compare_report.item_code, ' ', '' )
                            WHERE
                                 wg_sku_item.group_show_report IN (3) 
                            GROUP BY
                                wg_sku_item.item_code
                            ORDER BY
                                wg_sku_item.item_code ASC "
            );
            $select_order_result_head = DB::select("SELECT
                                wg_sku_item.item_code,
                                wg_sku_item.item_name,
                                compare_report.total_weight,
                                compare_report.date,
                                compare_report.unit,
                                compare_report.shop_name,
                                wg_sku_item.id,
                                wg_sku_item.sku_category,
                                wg_sku_item.wg_sku_id,
                                wg_sku_item.unit as unit_name,
                                wg_sku_item.barcode,
                                wg_sku_item.price,
                                wg_sku_item.member_price,
                                wg_sku_item.note,
                                wg_sku_item.created_at,
                                wg_sku_item.updated_at 
                            FROM
                                wg_sku_item
                                LEFT JOIN (
                            SELECT
                            cast(Sum(wg_sku_weight_data.sku_weight) as decimal(10,2)) AS total_weight,
                            Count(wg_sku_weight_data.sku_code) AS unit,
                            wg_sku_weight_data.lot_number,
                            wg_sku_weight_data.scale_number,
                            REPLACE(wg_sku_weight_data.sku_code, ' ', '') AS item_code,
                            '$shop_name' as shop_name,
                            '$ref_order' as order_number,
                            '$date ' as date
                            FROM
                            wg_sku_weight_data
                            LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                            WHERE 
                            wg_sku_weight_data.lot_number IN ($order_of,$order_cl)
                            AND wg_scale.department IN ( 4, 5, 6, 8, 9 )
                            AND wg_sku_weight_data.weighing_type IN (2,12)
                            GROUP BY
                            REPLACE(wg_sku_weight_data.sku_code, ' ', '')
                                ) AS compare_report ON wg_sku_item.item_code = REPLACE(compare_report.item_code, ' ', '')
                            WHERE
                                wg_sku_item.group_show_report IN (4) 
                            GROUP BY
                                wg_sku_item.item_code 
                            ORDER BY
                                wg_sku_item.item_code ASC"
            );
            #itemcode ที่ใช้ทั้งคู่
            $select_order_same = DB::select("SELECT
                    wg_sku_item.item_code,
                    wg_sku_item.item_name,
                    compare_report.total_weight,
                    compare_report.date,
                    compare_report.unit,
                    compare_report.shop_name,
                    wg_sku_item.id,
                    wg_sku_item.sku_category,
                    wg_sku_item.wg_sku_id,
                    wg_sku_item.unit AS unit_name,
                    wg_sku_item.barcode,
                    wg_sku_item.price,
                    wg_sku_item.member_price,
                    wg_sku_item.note,
                    wg_sku_item.created_at,
                    wg_sku_item.updated_at 
                FROM
                    wg_sku_item
                    LEFT JOIN (
                SELECT
                    cast( Sum( wg_sku_weight_data.sku_weight ) AS DECIMAL ( 10, 2 ) ) AS total_weight,
                    Count( wg_sku_weight_data.sku_code ) AS unit,
                    wg_sku_weight_data.lot_number,
                    wg_sku_weight_data.scale_number,
                    REPLACE ( wg_sku_weight_data.sku_code, ' ', '' ) AS item_code,
                    '$shop_name' AS shop_name,
                    '$ref_order' AS order_number,
                    '$date ' AS date 
                FROM
                    wg_sku_weight_data
                    LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number 
                WHERE
                    wg_sku_weight_data.lot_number IN ($order_of,$order_cl)
                    AND wg_scale.department IN ( 4, 5, 6, 8, 9 ) 
                    AND wg_sku_weight_data.weighing_type IN ( 2,12 ) 
                GROUP BY
                    REPLACE ( wg_sku_weight_data.sku_code, ' ', '' ) 
                    ) AS compare_report ON wg_sku_item.item_code = REPLACE ( compare_report.item_code, ' ', '' ) 
                WHERE
                    wg_sku_item.wg_sku_id IN ( 30 ) 
                GROUP BY
                    wg_sku_item.item_code 
                ORDER BY
                    wg_sku_item.item_code ASC"
            );

        }else{
            // น้ำหนักจากโรงงาน
            $select_order_result = DB::select("SELECT
                                wg_sku_item.item_code,
                                wg_sku_item.item_name,
                                compare_report.total_weight,
                                compare_report.date,
                                compare_report.unit,
                                compare_report.shop_name,
                                wg_sku_item.id,
                                wg_sku_item.sku_category,
                                wg_sku_item.wg_sku_id,
                                wg_sku_item.unit as unit_name,
                                wg_sku_item.barcode,
                                wg_sku_item.price,
                                wg_sku_item.member_price,
                                wg_sku_item.note,
                                wg_sku_item.created_at,
                                wg_sku_item.updated_at 
                            FROM
                                wg_sku_item
                                LEFT JOIN (
                            SELECT
                            cast(Sum(wg_sku_weight_data.sku_weight) as decimal(10,2)) AS total_weight,
                            Count(wg_sku_weight_data.sku_code) AS unit,
                            wg_sku_weight_data.lot_number,
                            wg_sku_weight_data.scale_number,
                            REPLACE(wg_sku_weight_data.sku_code, ' ', '') AS item_code,
                            '$shop_name' as shop_name,
                            '$ref_order' as order_number,
                            '$date ' as date
                            FROM
                            wg_sku_weight_data
                            LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                            WHERE 
                            wg_sku_weight_data.lot_number IN ($order_cl)
                            AND wg_scale.department IN (8,9)
                            AND wg_sku_weight_data.weighing_type IN (2)
                            GROUP BY
                            REPLACE(wg_sku_weight_data.sku_code, ' ', '')
                                ) AS compare_report ON wg_sku_item.item_code = REPLACE(compare_report.item_code, ' ', '')
                            WHERE
                                wg_sku_item.wg_sku_id IN (3, 7, 6, 9) 
                            GROUP BY
                                wg_sku_item.item_code 
                            ORDER BY
                                wg_sku_item.item_code ASC"
            );
            $select_order_result_of = DB::select("SELECT
                                wg_sku_item.item_code,
                                wg_sku_item.item_name,
                                compare_report.total_weight,
                                compare_report.date,
                                compare_report.unit,
                                compare_report.shop_name,
                                wg_sku_item.id,
                                wg_sku_item.sku_category,
                                wg_sku_item.wg_sku_id,
                                wg_sku_item.unit as unit_name,
                                wg_sku_item.barcode,
                                wg_sku_item.price,
                                wg_sku_item.member_price,
                                wg_sku_item.note,
                                wg_sku_item.created_at,
                                wg_sku_item.updated_at 
                            FROM
                                wg_sku_item
                                LEFT JOIN (
                            SELECT
                            cast(Sum(wg_sku_weight_data.sku_weight) as decimal(10,2)) AS total_weight,
                            Count(wg_sku_weight_data.sku_code) AS unit,
                            wg_sku_weight_data.lot_number,
                            wg_sku_weight_data.scale_number,
                            REPLACE(wg_sku_weight_data.sku_code, ' ', '') AS item_code,
                            '$shop_name' as shop_name,
                            '$ref_order' as order_number,
                            '$date ' as date
                            FROM
                            wg_sku_weight_data
                            LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                            WHERE 
                            wg_sku_weight_data.lot_number IN ($order_of)
                            AND wg_scale.department IN (4,5,6)
                            AND wg_sku_weight_data.weighing_type IN (2)
                            GROUP BY
                            REPLACE(wg_sku_weight_data.sku_code, ' ', '')
                                ) AS compare_report ON wg_sku_item.item_code = REPLACE(compare_report.item_code, ' ', '')
                            WHERE
                                wg_sku_item.wg_sku_id IN (4, 5) 
                            GROUP BY
                                wg_sku_item.item_code 
                            ORDER BY
                                wg_sku_item.item_code ASC"
            );
            #itemcode ที่ใช้ทั้งคู่
            $select_order_same = DB::select("SELECT
                    wg_sku_item.item_code,
                    wg_sku_item.item_name,
                    compare_report.total_weight,
                    compare_report.date,
                    compare_report.unit,
                    compare_report.shop_name,
                    wg_sku_item.id,
                    wg_sku_item.sku_category,
                    wg_sku_item.wg_sku_id,
                    wg_sku_item.unit as unit_name,
                    wg_sku_item.barcode,
                    wg_sku_item.price,
                    wg_sku_item.member_price,
                    wg_sku_item.note,
                    wg_sku_item.created_at,
                    wg_sku_item.updated_at 
                FROM
                    wg_sku_item
                    LEFT JOIN (
                SELECT
                cast(Sum(wg_sku_weight_data.sku_weight) as decimal(10,2)) AS total_weight,
                Count(wg_sku_weight_data.sku_code) AS unit,
                wg_sku_weight_data.lot_number,
                wg_sku_weight_data.scale_number,
                REPLACE(wg_sku_weight_data.sku_code, ' ', '') AS item_code,
                '$shop_name' as shop_name,
                '$ref_order' as order_number,
                '$date ' as date
                FROM
                wg_sku_weight_data
                LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                WHERE 
                wg_sku_weight_data.lot_number IN ($order_cl)
                AND wg_scale.department IN (8,9)
                AND wg_sku_weight_data.weighing_type IN (2)
                GROUP BY
                REPLACE(wg_sku_weight_data.sku_code, ' ', '')
                    ) AS compare_report ON wg_sku_item.item_code = REPLACE(compare_report.item_code, ' ', '')
                WHERE
                    wg_sku_item.wg_sku_id IN (30) 
                GROUP BY
                    wg_sku_item.item_code 
                ORDER BY
                    wg_sku_item.item_code ASC"
            );

            $select_order_result_transform = DB::select("SELECT
                                wg_sku_item.item_code,
                                wg_sku_item.item_name,
                                compare_report.total_weight,
                                compare_report.date,
                                compare_report.unit,
                                compare_report.shop_name,
                                wg_sku_item.id,
                                wg_sku_item.sku_category,
                                wg_sku_item.wg_sku_id,
                                wg_sku_item.unit as unit_name,
                                wg_sku_item.barcode,
                                wg_sku_item.price,
                                wg_sku_item.member_price,
                                wg_sku_item.note,
                                wg_sku_item.created_at,
                                wg_sku_item.updated_at 
                            FROM
                                wg_sku_item
                                LEFT JOIN (
                            SELECT
                            cast(Sum(wg_sku_weight_data.sku_weight) as decimal(10,2)) AS total_weight,
                            Count(wg_sku_weight_data.sku_code) AS unit,
                            wg_sku_weight_data.lot_number,
                            wg_sku_weight_data.scale_number,
                            REPLACE(wg_sku_weight_data.sku_code, ' ', '') AS item_code,
                            '$shop_name' as shop_name,
                            '$ref_order' as order_number,
                            '$date ' as date
                            FROM
                            wg_sku_weight_data
                            LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                            WHERE 
                            wg_sku_weight_data.lot_number IN ($order_cl,$order_of)
                                AND wg_scale.department IN ( 4, 5, 6, 8, 9 )
                                AND wg_sku_weight_data.weighing_type IN ( 12 ) 
                            GROUP BY
                                REPLACE ( wg_sku_weight_data.sku_code, ' ', '' )
                                ) AS compare_report ON wg_sku_item.item_code = REPLACE ( compare_report.item_code, ' ', '' )
                            WHERE
                                compare_report.total_weight <> 0
                            GROUP BY
                                wg_sku_item.item_code
                            ORDER BY
                                wg_sku_item.item_code ASC "
            );
        }

        // น้ำหนักตัดแต่งทั้งหมด
        $sum_total_weight_factory = 0;
        foreach ($select_order_result as $key => $value) {
            $sum_total_weight_factory = $sum_total_weight_factory + $value->total_weight;
        }
        foreach ($select_order_result_of as $key => $value) {
            $sum_total_weight_factory = $sum_total_weight_factory + $value->total_weight;
        }
        foreach ($select_order_result_transform as $key => $value) {
            $sum_total_weight_factory = $sum_total_weight_factory + $value->total_weight;
        }
        foreach ($select_order_result_head as $key => $value) {
            $sum_total_weight_factory = $sum_total_weight_factory + $value->total_weight;
        }
        foreach ($select_order_same as $key => $value) {
            $sum_total_weight_factory = $sum_total_weight_factory + $value->total_weight;
        }
        

        $item_tf = "'0000'";
        foreach ($select_order_result_transform as $key => $result_transform) {
            $item_tf = $item_tf . ",'$result_transform->item_code'";
        }


        if (substr($date,6,4).substr($date,0,2).substr($date,3,2) > 20200505) {
            $sql_weight = "SELECT
                wg_sku_weight_data.id,
                wg_sku_weight_data.sku_code as item_code,
                wg_sku_weight_data.sku_weight as total_weight,
                wg_sku_weight_data.sku_amount as unit,
                wg_sku_weight_data.scale_number as shop_name,
                wg_sku_weight_data.lot_number as order_number,
                DATE_FORMAT(wg_sku_weight_data.weighing_date,'%d/%m/%Y') as date,
                wg_sku_weight_data.created_at,
                wg_sku_weight_data.updated_at
                FROM
                wg_sku_weight_data
                WHERE
                wg_sku_weight_data.lot_number = '$ref_order'
                AND wg_sku_weight_data.weighing_type = 1
                ";
        }else{
            $sql_weight = "SELECT
                compare_report_shop.*
                FROM
                compare_report_shop
                WHERE compare_report_shop.order_number = '$ref_order'
                -- AND wg_sku_weight_data.weighing_type = 1";
        }
       

        // น้ำหนักถึงร้านค้า
        $select_shop_result = DB::select("SELECT
                                            wg_sku_item.item_code,
                                            wg_sku_item.item_name,
                                            SUM(compare_report_shop.total_weight) as total_weight,
                                            SUM(compare_report_shop.unit) as unit,
                                            wg_sku_item.id,
                                            wg_sku_item.sku_category,
                                            wg_sku_item.wg_sku_id,
                                            wg_sku_item.unit as unit_name,
                                            wg_sku_item.barcode,
                                            wg_sku_item.price,
                                            wg_sku_item.member_price,
                                            wg_sku_item.note,
                                            wg_sku_item.created_at,
                                            wg_sku_item.updated_at 
                                        FROM
                                            wg_sku_item
                                            LEFT JOIN (
                                                $sql_weight
                                            ) AS compare_report_shop ON wg_sku_item.item_code = REPLACE(compare_report_shop.item_code , ' ', '')
                                        WHERE
                                            wg_sku_item.group_show_report IN (1,2,3,4) 
                                            AND wg_sku_item.wg_sku_id NOT IN ('30')
                                        GROUP BY
                                            wg_sku_item.item_code 
                                        ORDER BY
                                            wg_sku_item.item_code ASC"
        );

        return view('report.new_compare.checkOrderResultCompare',compact('select_order_result','select_shop_result','select_order_result_transform','total_weight_in_order'
        ,'shop_name','date' , 'weight_recieve','order_tr','sum_total_weight_factory','select_order_result_of','ref_order','select_order_result_head',
        'select_order_same'));
    }

    public function checkOrderResultImportcompareprint($id){

        $ref_order = $id;
        
        $total_weight_in_order = DB::select("SELECT
                    Sum(wg_sku_weight_data.sku_weight) AS sum_weight,
                    count(wg_sku_weight_data.sku_weight) AS count_weight,
                    wg_sku_weight_data.scale_number,
                    wg_scale.department,
                    wg_sku_weight_data.lot_number,
                    tb_order.total_pig,
                    tb_order.id_user_customer,
                    tb_order.date, 
                    tb_order.weight_range,
                    tb_product_plan.plan_sending
                    FROM
                    wg_sku_weight_data
                    LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                    LEFT JOIN tb_order ON wg_sku_weight_data.lot_number = tb_order.order_number
                    LEFT JOIN tb_product_plan ON tb_order.order_number = tb_product_plan.order_number
                    WHERE
                    wg_sku_weight_data.lot_number = '$ref_order' AND
                    wg_scale.department = '1' "
        );

        $order_transport = DB::select("SELECT
        tb_order_transport.*,
        tb_customer.customer_code
        FROM
        tb_order_transport
        LEFT JOIN tb_customer ON tb_order_transport.id_user_customer = tb_customer.customer_name
        WHERE order_number = '$ref_order'");
            
        $order_tr =  $order_transport[0]->order_number;
        
        $order_of = "'-'";
        $order_cl = "'-'";
        foreach ($order_transport as $key => $value) {
          $order_of = $order_of .",'". $value->order_offal_number."'";
  
          $order_cl = $order_cl .",'". $value->order_cutting_number."'";
        }

        
        $shop_name = $order_transport[0]->id_user_customer;
        $weight_recieve = $order_transport[0]->weight_recieve;
        $date =  substr($order_transport[0]->date_transport ,3,2).'/'.substr($order_transport[0]->date_transport ,0,2).'/'.substr($order_transport[0]->date_transport ,6,4);


        if (substr($date,6,4).substr($date,0,2).substr($date,3,2) > 20200422) {
            return $this->checkOrderResultImportcompareprint2($id);
        }

        if ( substr($date,6,4).substr($date,0,2).substr($date,3,2) > 20200327 ) {
            // น้ำหนักจากโรงงาน
            $select_order_result = DB::select("SELECT
                                wg_sku_item.item_code,
                                wg_sku_item.item_name,
                                compare_report.total_weight,
                                compare_report.date,
                                compare_report.unit,
                                compare_report.shop_name,
                                wg_sku_item.id,
                                wg_sku_item.sku_category,
                                wg_sku_item.wg_sku_id,
                                wg_sku_item.unit as unit_name,
                                wg_sku_item.barcode,
                                wg_sku_item.price,
                                wg_sku_item.member_price,
                                wg_sku_item.note,
                                wg_sku_item.created_at,
                                wg_sku_item.updated_at 
                            FROM
                                wg_sku_item
                                LEFT JOIN (
                            SELECT
                            cast(Sum(wg_sku_weight_data.sku_weight) as decimal(10,2)) AS total_weight,
                            Count(wg_sku_weight_data.sku_code) AS unit,
                            wg_sku_weight_data.lot_number,
                            wg_sku_weight_data.scale_number,
                            REPLACE(wg_sku_weight_data.sku_code, ' ', '') AS item_code,
                            '$shop_name' as shop_name,
                            '$ref_order' as order_number,
                            '$date ' as date
                            FROM
                            wg_sku_weight_data
                            LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                            WHERE 
                            wg_sku_weight_data.lot_number IN ($order_cl)
                            AND wg_scale.department IN (8,9)
                            AND wg_sku_weight_data.weighing_type IN (2)
                            GROUP BY
                            REPLACE(wg_sku_weight_data.sku_code, ' ', '')
                                ) AS compare_report ON wg_sku_item.item_code = REPLACE(compare_report.item_code, ' ', '')
                            WHERE
                                wg_sku_item.wg_sku_id IN (3, 7, 6, 9) 
                                -- AND compare_report.total_weight <> 0
                            GROUP BY
                                wg_sku_item.item_code 
                            ORDER BY
                                wg_sku_item.item_code ASC"
            );
            $select_order_result_of = DB::select("SELECT
                                wg_sku_item.item_code,
                                wg_sku_item.item_name,
                                compare_report.total_weight,
                                compare_report.date,
                                compare_report.unit,
                                compare_report.shop_name,
                                wg_sku_item.id,
                                wg_sku_item.sku_category,
                                wg_sku_item.wg_sku_id,
                                wg_sku_item.unit as unit_name,
                                wg_sku_item.barcode,
                                wg_sku_item.price,
                                wg_sku_item.member_price,
                                wg_sku_item.note,
                                wg_sku_item.created_at,
                                wg_sku_item.updated_at 
                            FROM
                                wg_sku_item
                                LEFT JOIN (
                            SELECT
                            cast(Sum(wg_sku_weight_data.sku_weight) as decimal(10,2)) AS total_weight,
                            Count(wg_sku_weight_data.sku_code) AS unit,
                            wg_sku_weight_data.lot_number,
                            wg_sku_weight_data.scale_number,
                            REPLACE(wg_sku_weight_data.sku_code, ' ', '') AS item_code,
                            '$shop_name' as shop_name,
                            '$ref_order' as order_number,
                            '$date ' as date
                            FROM
                            wg_sku_weight_data
                            LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                            WHERE 
                            wg_sku_weight_data.lot_number IN ($order_of)
                            AND wg_scale.department IN (4,5,6)
                            AND wg_sku_weight_data.weighing_type IN (2)
                            GROUP BY
                            REPLACE(wg_sku_weight_data.sku_code, ' ', '')
                                ) AS compare_report ON wg_sku_item.item_code = REPLACE(compare_report.item_code, ' ', '')
                            WHERE
                                wg_sku_item.wg_sku_id IN (4, 5) 
                                -- AND compare_report.total_weight <> 0
                            GROUP BY
                                wg_sku_item.item_code 
                            ORDER BY
                                wg_sku_item.item_code ASC"
            );
            #itemcode ที่ใช้ทั้งคู่
            $select_order_same = DB::select("SELECT
                    wg_sku_item.item_code,
                    wg_sku_item.item_name,
                    compare_report.total_weight,
                    compare_report.date,
                    compare_report.unit,
                    compare_report.shop_name,
                    wg_sku_item.id,
                    wg_sku_item.sku_category,
                    wg_sku_item.wg_sku_id,
                    wg_sku_item.unit as unit_name,
                    wg_sku_item.barcode,
                    wg_sku_item.price,
                    wg_sku_item.member_price,
                    wg_sku_item.note,
                    wg_sku_item.created_at,
                    wg_sku_item.updated_at 
                FROM
                    wg_sku_item
                    LEFT JOIN (
                SELECT
                cast(Sum(wg_sku_weight_data.sku_weight) as decimal(10,2)) AS total_weight,
                Count(wg_sku_weight_data.sku_code) AS unit,
                wg_sku_weight_data.lot_number,
                wg_sku_weight_data.scale_number,
                REPLACE(wg_sku_weight_data.sku_code, ' ', '') AS item_code,
                '$shop_name' as shop_name,
                '$ref_order' as order_number,
                '$date ' as date
                FROM
                wg_sku_weight_data
                LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                WHERE 
                wg_sku_weight_data.lot_number IN ($order_cl)
                AND wg_scale.department IN (8,9)
                AND wg_sku_weight_data.weighing_type IN (2)
                GROUP BY
                REPLACE(wg_sku_weight_data.sku_code, ' ', '')
                    ) AS compare_report ON wg_sku_item.item_code = REPLACE(compare_report.item_code, ' ', '')
                WHERE
                    wg_sku_item.wg_sku_id IN (30) 
                GROUP BY
                    wg_sku_item.item_code 
                ORDER BY
                    wg_sku_item.item_code ASC"
            );

            $select_order_result_transform = DB::select("SELECT
                                wg_sku_item.item_code,
                                wg_sku_item.item_name,
                                compare_report.total_weight,
                                compare_report.date,
                                compare_report.unit,
                                compare_report.shop_name,
                                wg_sku_item.id,
                                wg_sku_item.sku_category,
                                wg_sku_item.wg_sku_id,
                                wg_sku_item.unit as unit_name,
                                wg_sku_item.barcode,
                                wg_sku_item.price,
                                wg_sku_item.member_price,
                                wg_sku_item.note,
                                wg_sku_item.created_at,
                                wg_sku_item.updated_at 
                            FROM
                                wg_sku_item
                                LEFT JOIN (
                            SELECT
                            cast(Sum(wg_sku_weight_data.sku_weight) as decimal(10,2)) AS total_weight,
                            Count(wg_sku_weight_data.sku_code) AS unit,
                            wg_sku_weight_data.lot_number,
                            wg_sku_weight_data.scale_number,
                            REPLACE(wg_sku_weight_data.sku_code, ' ', '') AS item_code,
                            '$shop_name' as shop_name,
                            '$ref_order' as order_number,
                            '$date ' as date
                            FROM
                            wg_sku_weight_data
                            LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                            WHERE 
                            wg_sku_weight_data.lot_number IN ($order_cl,$order_of)
                                AND wg_scale.department IN ( 4, 5, 6, 8, 9 )
                                AND wg_sku_weight_data.weighing_type IN ( 12 ) 
                            GROUP BY
                                REPLACE ( wg_sku_weight_data.sku_code, ' ', '' )
                                ) AS compare_report ON wg_sku_item.item_code = REPLACE ( compare_report.item_code, ' ', '' )
                            WHERE
                                compare_report.total_weight <> 0
                            GROUP BY
                                wg_sku_item.item_code
                            ORDER BY
                                wg_sku_item.item_code ASC "
            );

        }else{
            // น้ำหนักจากโรงงาน
            $select_order_result = DB::select("SELECT
                                wg_sku_item.item_code,
                                wg_sku_item.item_name,
                                compare_report.total_weight,
                                compare_report.date,
                                compare_report.unit,
                                compare_report.shop_name,
                                wg_sku_item.id,
                                wg_sku_item.sku_category,
                                wg_sku_item.wg_sku_id,
                                wg_sku_item.unit as unit_name,
                                wg_sku_item.barcode,
                                wg_sku_item.price,
                                wg_sku_item.member_price,
                                wg_sku_item.note,
                                wg_sku_item.created_at,
                                wg_sku_item.updated_at 
                            FROM
                                wg_sku_item
                                LEFT JOIN (
                            SELECT
                            cast(Sum(wg_sku_weight_data.sku_weight) as decimal(10,2)) AS total_weight,
                            Count(wg_sku_weight_data.sku_code) AS unit,
                            wg_sku_weight_data.lot_number,
                            wg_sku_weight_data.scale_number,
                            REPLACE(wg_sku_weight_data.sku_code, ' ', '') AS item_code,
                            '$shop_name' as shop_name,
                            '$ref_order' as order_number,
                            '$date ' as date
                            FROM
                            wg_sku_weight_data
                            LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                            WHERE 
                            wg_sku_weight_data.lot_number IN ($order_cl)
                            AND wg_scale.department IN (8,9)
                            AND wg_sku_weight_data.weighing_type IN (2)
                            GROUP BY
                            REPLACE(wg_sku_weight_data.sku_code, ' ', '')
                                ) AS compare_report ON wg_sku_item.item_code = REPLACE(compare_report.item_code, ' ', '')
                            WHERE
                                wg_sku_item.wg_sku_id IN (3, 7, 6, 9) 
                            GROUP BY
                                wg_sku_item.item_code 
                            ORDER BY
                                wg_sku_item.item_code ASC"
            );
            $select_order_result_of = DB::select("SELECT
                                wg_sku_item.item_code,
                                wg_sku_item.item_name,
                                compare_report.total_weight,
                                compare_report.date,
                                compare_report.unit,
                                compare_report.shop_name,
                                wg_sku_item.id,
                                wg_sku_item.sku_category,
                                wg_sku_item.wg_sku_id,
                                wg_sku_item.unit as unit_name,
                                wg_sku_item.barcode,
                                wg_sku_item.price,
                                wg_sku_item.member_price,
                                wg_sku_item.note,
                                wg_sku_item.created_at,
                                wg_sku_item.updated_at 
                            FROM
                                wg_sku_item
                                LEFT JOIN (
                            SELECT
                            cast(Sum(wg_sku_weight_data.sku_weight) as decimal(10,2)) AS total_weight,
                            Count(wg_sku_weight_data.sku_code) AS unit,
                            wg_sku_weight_data.lot_number,
                            wg_sku_weight_data.scale_number,
                            REPLACE(wg_sku_weight_data.sku_code, ' ', '') AS item_code,
                            '$shop_name' as shop_name,
                            '$ref_order' as order_number,
                            '$date ' as date
                            FROM
                            wg_sku_weight_data
                            LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                            WHERE 
                            wg_sku_weight_data.lot_number IN ($order_of)
                            AND wg_scale.department IN (4,5,6)
                            AND wg_sku_weight_data.weighing_type IN (2)
                            GROUP BY
                            REPLACE(wg_sku_weight_data.sku_code, ' ', '')
                                ) AS compare_report ON wg_sku_item.item_code = REPLACE(compare_report.item_code, ' ', '')
                            WHERE
                                wg_sku_item.wg_sku_id IN (4, 5) 
                            GROUP BY
                                wg_sku_item.item_code 
                            ORDER BY
                                wg_sku_item.item_code ASC"
            );
            #itemcode ที่ใช้ทั้งคู่
            $select_order_same = DB::select("SELECT
                    wg_sku_item.item_code,
                    wg_sku_item.item_name,
                    compare_report.total_weight,
                    compare_report.date,
                    compare_report.unit,
                    compare_report.shop_name,
                    wg_sku_item.id,
                    wg_sku_item.sku_category,
                    wg_sku_item.wg_sku_id,
                    wg_sku_item.unit as unit_name,
                    wg_sku_item.barcode,
                    wg_sku_item.price,
                    wg_sku_item.member_price,
                    wg_sku_item.note,
                    wg_sku_item.created_at,
                    wg_sku_item.updated_at 
                FROM
                    wg_sku_item
                    LEFT JOIN (
                SELECT
                cast(Sum(wg_sku_weight_data.sku_weight) as decimal(10,2)) AS total_weight,
                Count(wg_sku_weight_data.sku_code) AS unit,
                wg_sku_weight_data.lot_number,
                wg_sku_weight_data.scale_number,
                REPLACE(wg_sku_weight_data.sku_code, ' ', '') AS item_code,
                '$shop_name' as shop_name,
                '$ref_order' as order_number,
                '$date ' as date
                FROM
                wg_sku_weight_data
                LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                WHERE 
                wg_sku_weight_data.lot_number IN ($order_cl)
                AND wg_scale.department IN (8,9)
                AND wg_sku_weight_data.weighing_type IN (2)
                GROUP BY
                REPLACE(wg_sku_weight_data.sku_code, ' ', '')
                    ) AS compare_report ON wg_sku_item.item_code = REPLACE(compare_report.item_code, ' ', '')
                WHERE
                    wg_sku_item.wg_sku_id IN (30) 
                GROUP BY
                    wg_sku_item.item_code 
                ORDER BY
                    wg_sku_item.item_code ASC"
            );

            $select_order_result_transform = DB::select("SELECT
                                wg_sku_item.item_code,
                                wg_sku_item.item_name,
                                compare_report.total_weight,
                                compare_report.date,
                                compare_report.unit,
                                compare_report.shop_name,
                                wg_sku_item.id,
                                wg_sku_item.sku_category,
                                wg_sku_item.wg_sku_id,
                                wg_sku_item.unit as unit_name,
                                wg_sku_item.barcode,
                                wg_sku_item.price,
                                wg_sku_item.member_price,
                                wg_sku_item.note,
                                wg_sku_item.created_at,
                                wg_sku_item.updated_at 
                            FROM
                                wg_sku_item
                                LEFT JOIN (
                            SELECT
                            cast(Sum(wg_sku_weight_data.sku_weight) as decimal(10,2)) AS total_weight,
                            Count(wg_sku_weight_data.sku_code) AS unit,
                            wg_sku_weight_data.lot_number,
                            wg_sku_weight_data.scale_number,
                            REPLACE(wg_sku_weight_data.sku_code, ' ', '') AS item_code,
                            '$shop_name' as shop_name,
                            '$ref_order' as order_number,
                            '$date ' as date
                            FROM
                            wg_sku_weight_data
                            LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                            WHERE 
                            wg_sku_weight_data.lot_number IN ($order_cl,$order_of)
                                AND wg_scale.department IN ( 4, 5, 6, 8, 9 )
                                AND wg_sku_weight_data.weighing_type IN ( 12 ) 
                            GROUP BY
                                REPLACE ( wg_sku_weight_data.sku_code, ' ', '' )
                                ) AS compare_report ON wg_sku_item.item_code = REPLACE ( compare_report.item_code, ' ', '' )
                            WHERE
                                compare_report.total_weight <> 0
                            GROUP BY
                                wg_sku_item.item_code
                            ORDER BY
                                wg_sku_item.item_code ASC "
            );
        }

        // น้ำหนักตัดแต่งทั้งหมด
        $sum_total_weight_factory = 0;
        foreach ($select_order_result as $key => $value) {
            $sum_total_weight_factory = $sum_total_weight_factory + $value->total_weight;
        }
        foreach ($select_order_result_of as $key => $value) {
            $sum_total_weight_factory = $sum_total_weight_factory + $value->total_weight;
        }
        foreach ($select_order_same as $key => $value) {
            $sum_total_weight_factory = $sum_total_weight_factory + $value->total_weight;
        }


        
        $item_tf = "'0000'";
        foreach ($select_order_result_transform as $key => $result_transform) {
            $item_tf = $item_tf . ",'$result_transform->item_code'";
        }

        // น้ำหนักถึงร้านค้า
        $select_shop_result = DB::select("SELECT
                                            wg_sku_item.item_code,
                                            wg_sku_item.item_name,
                                            SUM(compare_report_shop.total_weight) as total_weight,
                                            SUM(compare_report_shop.unit) as unit,
                                            wg_sku_item.id,
                                            wg_sku_item.sku_category,
                                            wg_sku_item.wg_sku_id,
                                            wg_sku_item.unit as unit_name,
                                            wg_sku_item.barcode,
                                            wg_sku_item.price,
                                            wg_sku_item.member_price,
                                            wg_sku_item.note,
                                            wg_sku_item.created_at,
                                            wg_sku_item.updated_at 
                                        FROM
                                            wg_sku_item
                                            LEFT JOIN (
                                        SELECT
                                        compare_report_shop.*
                                        FROM
                                        compare_report_shop
                                        WHERE compare_report_shop.order_number = '$ref_order'
                                            ) AS compare_report_shop ON wg_sku_item.item_code = REPLACE(compare_report_shop.item_code , ' ', '')
                                        WHERE
                                            wg_sku_item.wg_sku_id IN ( 3, 4, 5, 7, 6 ,9) 
                                            AND wg_sku_item.item_code NOT IN ($item_tf)
                                        GROUP BY
                                            wg_sku_item.item_code 
                                        ORDER BY
                                            wg_sku_item.item_code ASC"
        );

        $select_shop_result_transform = DB::select("SELECT
                                            wg_sku_item.item_code,
                                            wg_sku_item.item_name,
                                            SUM(compare_report_shop.total_weight) as total_weight,
                                            SUM(compare_report_shop.unit) as unit,
                                            wg_sku_item.id,
                                            wg_sku_item.sku_category,
                                            wg_sku_item.wg_sku_id,
                                            wg_sku_item.unit as unit_name,
                                            wg_sku_item.barcode,
                                            wg_sku_item.price,
                                            wg_sku_item.member_price,
                                            wg_sku_item.note,
                                            wg_sku_item.created_at,
                                            wg_sku_item.updated_at 
                                        FROM
                                            wg_sku_item
                                            LEFT JOIN (
                                        SELECT
                                        compare_report_shop.*
                                        FROM
                                        compare_report_shop
                                        WHERE compare_report_shop.order_number = '$ref_order'
                                            ) AS compare_report_shop ON wg_sku_item.item_code = REPLACE(compare_report_shop.item_code , ' ', '')
                                        WHERE
                                            wg_sku_item.wg_sku_id IN ( 3, 4, 5, 7, 6 ,9) 
                                            AND wg_sku_item.item_code IN ($item_tf)
                                        GROUP BY
                                            wg_sku_item.item_code 
                                        ORDER BY
                                            wg_sku_item.item_code ASC"
        );



        return view('report.checkOrderResultCompareprint',compact('select_order_result','select_shop_result','select_order_result_transform','select_shop_result_transform','total_weight_in_order'
        ,'shop_name','date' , 'weight_recieve','order_tr','sum_total_weight_factory','select_order_result_of','select_order_same'));
    }

    public function checkOrderResultImportcompareprint2($id){


        $ref_order = $id;
        
        $total_weight_in_order = DB::select("SELECT
                    Sum(wg_sku_weight_data.sku_weight) AS sum_weight,
                    count(wg_sku_weight_data.sku_weight) AS count_weight,
                    wg_sku_weight_data.scale_number,
                    wg_scale.department,
                    wg_sku_weight_data.lot_number,
                    tb_order.total_pig,
                    tb_order.id_user_customer,
                    tb_order.date, 
                    tb_order.weight_range,
                    tb_product_plan.plan_sending
                    FROM
                    wg_sku_weight_data
                    LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                    LEFT JOIN tb_order ON wg_sku_weight_data.lot_number = tb_order.order_number
                    LEFT JOIN tb_product_plan ON tb_order.order_number = tb_product_plan.order_number
                    WHERE
                    wg_sku_weight_data.lot_number = '$ref_order' AND
                    wg_scale.department = '1' "
        );

        $order_transport = DB::select("SELECT
        tb_order_transport.*,
        tb_customer.customer_code
        FROM
        tb_order_transport
        LEFT JOIN tb_customer ON tb_order_transport.id_user_customer = tb_customer.customer_name
        WHERE order_number = '$ref_order'");
            
        $order_tr =  $order_transport[0]->order_number;
        
        $order_of = "'-'";
        $order_cl = "'-'";
        foreach ($order_transport as $key => $value) {
          $order_of = $order_of .",'". $value->order_offal_number."'";
  
          $order_cl = $order_cl .",'". $value->order_cutting_number."'";
        }


        $shop_name = $order_transport[0]->id_user_customer;
        $weight_recieve = $order_transport[0]->weight_recieve;
        $date =  substr($order_transport[0]->date_transport ,3,2).'/'.substr($order_transport[0]->date_transport ,0,2).'/'.substr($order_transport[0]->date_transport ,6,4);

        if ( substr($date,6,4).substr($date,0,2).substr($date,3,2) > 20200327 ) {
            // น้ำหนักจากโรงงาน
            $select_order_result = DB::select("SELECT
                                wg_sku_item.item_code,
                                wg_sku_item.item_name,
                                compare_report.total_weight,
                                compare_report.date,
                                compare_report.unit,
                                compare_report.shop_name,
                                wg_sku_item.id,
                                wg_sku_item.sku_category,
                                wg_sku_item.wg_sku_id,
                                wg_sku_item.unit as unit_name,
                                wg_sku_item.barcode,
                                wg_sku_item.price,
                                wg_sku_item.member_price,
                                wg_sku_item.note,
                                wg_sku_item.created_at,
                                wg_sku_item.updated_at 
                            FROM
                                wg_sku_item
                                LEFT JOIN (
                            SELECT
                            cast(Sum(wg_sku_weight_data.sku_weight) as decimal(10,2)) AS total_weight,
                            Count(wg_sku_weight_data.sku_code) AS unit,
                            wg_sku_weight_data.lot_number,
                            wg_sku_weight_data.scale_number,
                            REPLACE(wg_sku_weight_data.sku_code, ' ', '') AS item_code,
                            '$shop_name' as shop_name,
                            '$ref_order' as order_number,
                            '$date ' as date
                            FROM
                            wg_sku_weight_data
                            LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                            WHERE 
                            wg_sku_weight_data.lot_number IN ($order_cl)
                            AND wg_scale.department IN (8,9)
                            AND wg_sku_weight_data.weighing_type IN (2,12)
                            GROUP BY
                            REPLACE(wg_sku_weight_data.sku_code, ' ', '')
                                ) AS compare_report ON wg_sku_item.item_code = REPLACE(compare_report.item_code, ' ', '')
                            WHERE                      
                                wg_sku_item.group_show_report IN (1) 
                                AND wg_sku_item.wg_sku_id NOT IN ('30')
                            GROUP BY
                                wg_sku_item.item_code 
                            ORDER BY
                                wg_sku_item.item_code ASC"
            );
            $select_order_result_of = DB::select("SELECT
                                wg_sku_item.item_code,
                                wg_sku_item.item_name,
                                compare_report.total_weight,
                                compare_report.date,
                                compare_report.unit,
                                compare_report.shop_name,
                                wg_sku_item.id,
                                wg_sku_item.sku_category,
                                wg_sku_item.wg_sku_id,
                                wg_sku_item.unit as unit_name,
                                wg_sku_item.barcode,
                                wg_sku_item.price,
                                wg_sku_item.member_price,
                                wg_sku_item.note,
                                wg_sku_item.created_at,
                                wg_sku_item.updated_at 
                            FROM
                                wg_sku_item
                                LEFT JOIN (
                            SELECT
                            cast(Sum(wg_sku_weight_data.sku_weight) as decimal(10,2)) AS total_weight,
                            Count(wg_sku_weight_data.sku_code) AS unit,
                            wg_sku_weight_data.lot_number,
                            wg_sku_weight_data.scale_number,
                            REPLACE(wg_sku_weight_data.sku_code, ' ', '') AS item_code,
                            '$shop_name' as shop_name,
                            '$ref_order' as order_number,
                            '$date ' as date
                            FROM
                            wg_sku_weight_data
                            LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                            WHERE 
                            wg_sku_weight_data.lot_number IN ($order_of)
                            AND wg_scale.department IN (4,5,6)
                            AND wg_sku_weight_data.weighing_type IN (2,12)
                            GROUP BY
                            REPLACE(wg_sku_weight_data.sku_code, ' ', '')
                                ) AS compare_report ON wg_sku_item.item_code = REPLACE(compare_report.item_code, ' ', '')
                            WHERE
                                wg_sku_item.group_show_report IN (2) 
                                AND wg_sku_item.item_code NOT IN ('1011','1109')
                            GROUP BY
                                wg_sku_item.item_code 
                            ORDER BY
                                wg_sku_item.item_code ASC"
            );
            $select_order_result_transform = DB::select("SELECT
                                wg_sku_item.item_code,
                                wg_sku_item.item_name,
                                compare_report.total_weight,
                                compare_report.date,
                                compare_report.unit,
                                compare_report.shop_name,
                                wg_sku_item.id,
                                wg_sku_item.sku_category,
                                wg_sku_item.wg_sku_id,
                                wg_sku_item.unit as unit_name,
                                wg_sku_item.barcode,
                                wg_sku_item.price,
                                wg_sku_item.member_price,
                                wg_sku_item.note,
                                wg_sku_item.created_at,
                                wg_sku_item.updated_at 
                            FROM
                                wg_sku_item
                                LEFT JOIN (
                            SELECT
                            cast(Sum(wg_sku_weight_data.sku_weight) as decimal(10,2)) AS total_weight,
                            Count(wg_sku_weight_data.sku_code) AS unit,
                            wg_sku_weight_data.lot_number,
                            wg_sku_weight_data.scale_number,
                            REPLACE(wg_sku_weight_data.sku_code, ' ', '') AS item_code,
                            '$shop_name' as shop_name,
                            '$ref_order' as order_number,
                            '$date ' as date
                            FROM
                            wg_sku_weight_data
                            LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                            WHERE 
                            wg_sku_weight_data.lot_number IN ($order_cl,$order_of)
                                AND wg_scale.department IN ( 4, 5, 6, 8, 9 )
                                AND wg_sku_weight_data.weighing_type IN (2, 12 ) 
                            GROUP BY
                                REPLACE ( wg_sku_weight_data.sku_code, ' ', '' )
                                ) AS compare_report ON wg_sku_item.item_code = REPLACE ( compare_report.item_code, ' ', '' )
                            WHERE
                                 wg_sku_item.group_show_report IN (3) 
                            GROUP BY
                                wg_sku_item.item_code
                            ORDER BY
                                wg_sku_item.item_code ASC "
            );
            $select_order_result_head = DB::select("SELECT
                                wg_sku_item.item_code,
                                wg_sku_item.item_name,
                                compare_report.total_weight,
                                compare_report.date,
                                compare_report.unit,
                                compare_report.shop_name,
                                wg_sku_item.id,
                                wg_sku_item.sku_category,
                                wg_sku_item.wg_sku_id,
                                wg_sku_item.unit as unit_name,
                                wg_sku_item.barcode,
                                wg_sku_item.price,
                                wg_sku_item.member_price,
                                wg_sku_item.note,
                                wg_sku_item.created_at,
                                wg_sku_item.updated_at 
                            FROM
                                wg_sku_item
                                LEFT JOIN (
                            SELECT
                            cast(Sum(wg_sku_weight_data.sku_weight) as decimal(10,2)) AS total_weight,
                            Count(wg_sku_weight_data.sku_code) AS unit,
                            wg_sku_weight_data.lot_number,
                            wg_sku_weight_data.scale_number,
                            REPLACE(wg_sku_weight_data.sku_code, ' ', '') AS item_code,
                            '$shop_name' as shop_name,
                            '$ref_order' as order_number,
                            '$date ' as date
                            FROM
                            wg_sku_weight_data
                            LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                            WHERE 
                            wg_sku_weight_data.lot_number IN ($order_of,$order_cl)
                            AND wg_scale.department IN ( 4, 5, 6, 8, 9 )
                            AND wg_sku_weight_data.weighing_type IN (2,12)
                            GROUP BY
                            REPLACE(wg_sku_weight_data.sku_code, ' ', '')
                                ) AS compare_report ON wg_sku_item.item_code = REPLACE(compare_report.item_code, ' ', '')
                            WHERE
                                wg_sku_item.group_show_report IN (4) 
                            GROUP BY
                                wg_sku_item.item_code 
                            ORDER BY
                                wg_sku_item.item_code ASC"
            );
            #itemcode ที่ใช้ทั้งคู่
            $select_order_same = DB::select("SELECT
                    wg_sku_item.item_code,
                    wg_sku_item.item_name,
                    compare_report.total_weight,
                    compare_report.date,
                    compare_report.unit,
                    compare_report.shop_name,
                    wg_sku_item.id,
                    wg_sku_item.sku_category,
                    wg_sku_item.wg_sku_id,
                    wg_sku_item.unit AS unit_name,
                    wg_sku_item.barcode,
                    wg_sku_item.price,
                    wg_sku_item.member_price,
                    wg_sku_item.note,
                    wg_sku_item.created_at,
                    wg_sku_item.updated_at 
                FROM
                    wg_sku_item
                    LEFT JOIN (
                SELECT
                    cast( Sum( wg_sku_weight_data.sku_weight ) AS DECIMAL ( 10, 2 ) ) AS total_weight,
                    Count( wg_sku_weight_data.sku_code ) AS unit,
                    wg_sku_weight_data.lot_number,
                    wg_sku_weight_data.scale_number,
                    REPLACE ( wg_sku_weight_data.sku_code, ' ', '' ) AS item_code,
                    '$shop_name' AS shop_name,
                    '$ref_order' AS order_number,
                    '$date ' AS date 
                FROM
                    wg_sku_weight_data
                    LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number 
                WHERE
                    wg_sku_weight_data.lot_number IN ($order_of,$order_cl)
                    AND wg_scale.department IN ( 4, 5, 6, 8, 9 ) 
                    AND wg_sku_weight_data.weighing_type IN ( 2,12 ) 
                GROUP BY
                    REPLACE ( wg_sku_weight_data.sku_code, ' ', '' ) 
                    ) AS compare_report ON wg_sku_item.item_code = REPLACE ( compare_report.item_code, ' ', '' ) 
                WHERE
                    wg_sku_item.wg_sku_id IN ( 30 ) 
                GROUP BY
                    wg_sku_item.item_code 
                ORDER BY
                    wg_sku_item.item_code ASC"
            );

        }else{
            // น้ำหนักจากโรงงาน
            $select_order_result = DB::select("SELECT
                                wg_sku_item.item_code,
                                wg_sku_item.item_name,
                                compare_report.total_weight,
                                compare_report.date,
                                compare_report.unit,
                                compare_report.shop_name,
                                wg_sku_item.id,
                                wg_sku_item.sku_category,
                                wg_sku_item.wg_sku_id,
                                wg_sku_item.unit as unit_name,
                                wg_sku_item.barcode,
                                wg_sku_item.price,
                                wg_sku_item.member_price,
                                wg_sku_item.note,
                                wg_sku_item.created_at,
                                wg_sku_item.updated_at 
                            FROM
                                wg_sku_item
                                LEFT JOIN (
                            SELECT
                            cast(Sum(wg_sku_weight_data.sku_weight) as decimal(10,2)) AS total_weight,
                            Count(wg_sku_weight_data.sku_code) AS unit,
                            wg_sku_weight_data.lot_number,
                            wg_sku_weight_data.scale_number,
                            REPLACE(wg_sku_weight_data.sku_code, ' ', '') AS item_code,
                            '$shop_name' as shop_name,
                            '$ref_order' as order_number,
                            '$date ' as date
                            FROM
                            wg_sku_weight_data
                            LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                            WHERE 
                            wg_sku_weight_data.lot_number IN ($order_cl)
                            AND wg_scale.department IN (8,9)
                            AND wg_sku_weight_data.weighing_type IN (2)
                            GROUP BY
                            REPLACE(wg_sku_weight_data.sku_code, ' ', '')
                                ) AS compare_report ON wg_sku_item.item_code = REPLACE(compare_report.item_code, ' ', '')
                            WHERE
                                wg_sku_item.wg_sku_id IN (3, 7, 6, 9) 
                            GROUP BY
                                wg_sku_item.item_code 
                            ORDER BY
                                wg_sku_item.item_code ASC"
            );
            $select_order_result_of = DB::select("SELECT
                                wg_sku_item.item_code,
                                wg_sku_item.item_name,
                                compare_report.total_weight,
                                compare_report.date,
                                compare_report.unit,
                                compare_report.shop_name,
                                wg_sku_item.id,
                                wg_sku_item.sku_category,
                                wg_sku_item.wg_sku_id,
                                wg_sku_item.unit as unit_name,
                                wg_sku_item.barcode,
                                wg_sku_item.price,
                                wg_sku_item.member_price,
                                wg_sku_item.note,
                                wg_sku_item.created_at,
                                wg_sku_item.updated_at 
                            FROM
                                wg_sku_item
                                LEFT JOIN (
                            SELECT
                            cast(Sum(wg_sku_weight_data.sku_weight) as decimal(10,2)) AS total_weight,
                            Count(wg_sku_weight_data.sku_code) AS unit,
                            wg_sku_weight_data.lot_number,
                            wg_sku_weight_data.scale_number,
                            REPLACE(wg_sku_weight_data.sku_code, ' ', '') AS item_code,
                            '$shop_name' as shop_name,
                            '$ref_order' as order_number,
                            '$date ' as date
                            FROM
                            wg_sku_weight_data
                            LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                            WHERE 
                            wg_sku_weight_data.lot_number IN ($order_of)
                            AND wg_scale.department IN (4,5,6)
                            AND wg_sku_weight_data.weighing_type IN (2)
                            GROUP BY
                            REPLACE(wg_sku_weight_data.sku_code, ' ', '')
                                ) AS compare_report ON wg_sku_item.item_code = REPLACE(compare_report.item_code, ' ', '')
                            WHERE
                                wg_sku_item.wg_sku_id IN (4, 5) 
                            GROUP BY
                                wg_sku_item.item_code 
                            ORDER BY
                                wg_sku_item.item_code ASC"
            );
            #itemcode ที่ใช้ทั้งคู่
            $select_order_same = DB::select("SELECT
                    wg_sku_item.item_code,
                    wg_sku_item.item_name,
                    compare_report.total_weight,
                    compare_report.date,
                    compare_report.unit,
                    compare_report.shop_name,
                    wg_sku_item.id,
                    wg_sku_item.sku_category,
                    wg_sku_item.wg_sku_id,
                    wg_sku_item.unit as unit_name,
                    wg_sku_item.barcode,
                    wg_sku_item.price,
                    wg_sku_item.member_price,
                    wg_sku_item.note,
                    wg_sku_item.created_at,
                    wg_sku_item.updated_at 
                FROM
                    wg_sku_item
                    LEFT JOIN (
                SELECT
                cast(Sum(wg_sku_weight_data.sku_weight) as decimal(10,2)) AS total_weight,
                Count(wg_sku_weight_data.sku_code) AS unit,
                wg_sku_weight_data.lot_number,
                wg_sku_weight_data.scale_number,
                REPLACE(wg_sku_weight_data.sku_code, ' ', '') AS item_code,
                '$shop_name' as shop_name,
                '$ref_order' as order_number,
                '$date ' as date
                FROM
                wg_sku_weight_data
                LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                WHERE 
                wg_sku_weight_data.lot_number IN ($order_cl)
                AND wg_scale.department IN (8,9)
                AND wg_sku_weight_data.weighing_type IN (2)
                GROUP BY
                REPLACE(wg_sku_weight_data.sku_code, ' ', '')
                    ) AS compare_report ON wg_sku_item.item_code = REPLACE(compare_report.item_code, ' ', '')
                WHERE
                    wg_sku_item.wg_sku_id IN (30) 
                GROUP BY
                    wg_sku_item.item_code 
                ORDER BY
                    wg_sku_item.item_code ASC"
            );

            $select_order_result_transform = DB::select("SELECT
                                wg_sku_item.item_code,
                                wg_sku_item.item_name,
                                compare_report.total_weight,
                                compare_report.date,
                                compare_report.unit,
                                compare_report.shop_name,
                                wg_sku_item.id,
                                wg_sku_item.sku_category,
                                wg_sku_item.wg_sku_id,
                                wg_sku_item.unit as unit_name,
                                wg_sku_item.barcode,
                                wg_sku_item.price,
                                wg_sku_item.member_price,
                                wg_sku_item.note,
                                wg_sku_item.created_at,
                                wg_sku_item.updated_at 
                            FROM
                                wg_sku_item
                                LEFT JOIN (
                            SELECT
                            cast(Sum(wg_sku_weight_data.sku_weight) as decimal(10,2)) AS total_weight,
                            Count(wg_sku_weight_data.sku_code) AS unit,
                            wg_sku_weight_data.lot_number,
                            wg_sku_weight_data.scale_number,
                            REPLACE(wg_sku_weight_data.sku_code, ' ', '') AS item_code,
                            '$shop_name' as shop_name,
                            '$ref_order' as order_number,
                            '$date ' as date
                            FROM
                            wg_sku_weight_data
                            LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                            WHERE 
                            wg_sku_weight_data.lot_number IN ($order_cl,$order_of)
                                AND wg_scale.department IN ( 4, 5, 6, 8, 9 )
                                AND wg_sku_weight_data.weighing_type IN ( 12 ) 
                            GROUP BY
                                REPLACE ( wg_sku_weight_data.sku_code, ' ', '' )
                                ) AS compare_report ON wg_sku_item.item_code = REPLACE ( compare_report.item_code, ' ', '' )
                            WHERE
                                compare_report.total_weight <> 0
                            GROUP BY
                                wg_sku_item.item_code
                            ORDER BY
                                wg_sku_item.item_code ASC "
            );
        }

        // น้ำหนักตัดแต่งทั้งหมด
        $sum_total_weight_factory = 0;
        foreach ($select_order_result as $key => $value) {
            $sum_total_weight_factory = $sum_total_weight_factory + $value->total_weight;
        }
        foreach ($select_order_result_of as $key => $value) {
            $sum_total_weight_factory = $sum_total_weight_factory + $value->total_weight;
        }
        foreach ($select_order_result_transform as $key => $value) {
            $sum_total_weight_factory = $sum_total_weight_factory + $value->total_weight;
        }
        foreach ($select_order_result_head as $key => $value) {
            $sum_total_weight_factory = $sum_total_weight_factory + $value->total_weight;
        }
        foreach ($select_order_same as $key => $value) {
            $sum_total_weight_factory = $sum_total_weight_factory + $value->total_weight;
        }
        

        $item_tf = "'0000'";
        foreach ($select_order_result_transform as $key => $result_transform) {
            $item_tf = $item_tf . ",'$result_transform->item_code'";
        }

        if (substr($date,6,4).substr($date,0,2).substr($date,3,2) > 20200505) {
            $sql_weight = "SELECT
                wg_sku_weight_data.id,
                wg_sku_weight_data.sku_code as item_code,
                wg_sku_weight_data.sku_weight as total_weight,
                wg_sku_weight_data.sku_amount as unit,
                wg_sku_weight_data.scale_number as shop_name,
                wg_sku_weight_data.lot_number as order_number,
                DATE_FORMAT(wg_sku_weight_data.weighing_date,'%d/%m/%Y') as date,
                wg_sku_weight_data.created_at,
                wg_sku_weight_data.updated_at
                FROM
                wg_sku_weight_data
                WHERE
                wg_sku_weight_data.lot_number = '$ref_order'
                AND wg_sku_weight_data.weighing_type = 1";
        }else{
            $sql_weight = "SELECT
                compare_report_shop.*
                FROM
                compare_report_shop
                WHERE compare_report_shop.order_number = '$ref_order'
                -- AND wg_sku_weight_data.weighing_type = 1";
        }   

        // น้ำหนักถึงร้านค้า
        $select_shop_result = DB::select("SELECT
                                            wg_sku_item.item_code,
                                            wg_sku_item.item_name,
                                            SUM(compare_report_shop.total_weight) as total_weight,
                                            SUM(compare_report_shop.unit) as unit,
                                            wg_sku_item.id,
                                            wg_sku_item.sku_category,
                                            wg_sku_item.wg_sku_id,
                                            wg_sku_item.unit as unit_name,
                                            wg_sku_item.barcode,
                                            wg_sku_item.price,
                                            wg_sku_item.member_price,
                                            wg_sku_item.note,
                                            wg_sku_item.created_at,
                                            wg_sku_item.updated_at 
                                        FROM
                                            wg_sku_item
                                            LEFT JOIN (
                                                $sql_weight
                                            ) AS compare_report_shop ON wg_sku_item.item_code = REPLACE(compare_report_shop.item_code , ' ', '')
                                        WHERE
                                            wg_sku_item.group_show_report IN (1,2,3,4) 
                                            AND wg_sku_item.wg_sku_id NOT IN ('30')
                                        GROUP BY
                                            wg_sku_item.item_code 
                                        ORDER BY
                                            wg_sku_item.item_code ASC"
        );

        return view('report.new_compare.checkOrderResultCompareprint',compact('select_order_result','select_shop_result','select_order_result_transform','total_weight_in_order'
        ,'shop_name','date' , 'weight_recieve','order_tr','sum_total_weight_factory','select_order_result_of','ref_order','select_order_result_head',
        'select_order_same'));
    }
    
    public function edit_weight_recieve(Request $request){
        // return $request;
        DB::update("UPDATE tb_order_transport set tb_order_transport.weight_recieve = $request->weight_ WHERE tb_order_transport.order_number = '$request->order_number' ");
        return 0;
    }

    public function daily_ResultImportcompare($date){

        $date_format = substr($date,0,2).'/'.substr($date,2,2).'/'.substr($date,4,4);
        $order_transport = DB::select("SELECT
                tb_order_transport.order_number,
                tb_order_transport.order_cutting_number,
                tb_order_transport.order_offal_number,
                tb_order_transport.date_transport,
                tb_order_transport.id_user_customer,
                tb_order_transport.weight_recieve 
            FROM
                tb_order_transport 
            WHERE
                tb_order_transport.date_transport = '$date_format'"
        );
            
        $ref_order = 'test';

        $order_tr = "'0'";
        $order_cl = "'0'";
        $order_of = "'0'";
        foreach ($order_transport as $key => $result_transport) {
            $order_tr = $order_tr . ",'".$result_transport->order_number. "'";
            $order_cl = $order_cl . ",'".$result_transport->order_cutting_number. "'";
            $order_of = $order_of . ",'".$result_transport->order_offal_number. "'";
        }

        $shop_name = '';
        $weight_recieve = $order_transport[0]->weight_recieve;

        if ( substr($date,4,4).substr($date,2,2).substr($date,0,2) > 20200127 ) {
            // น้ำหนักจากโรงงาน
            $select_order_result = DB::select("SELECT
                                wg_sku_item.item_code,
                                wg_sku_item.item_name,
                                compare_report.total_weight,
                                compare_report.date,
                                compare_report.unit,
                                compare_report.shop_name,
                                wg_sku_item.id,
                                wg_sku_item.sku_category,
                                wg_sku_item.wg_sku_id,
                                wg_sku_item.unit as unit_name,
                                wg_sku_item.barcode,
                                wg_sku_item.price,
                                wg_sku_item.member_price,
                                wg_sku_item.note,
                                wg_sku_item.created_at,
                                wg_sku_item.updated_at 
                            FROM
                                wg_sku_item
                                LEFT JOIN (
                            SELECT
                            cast(Sum(wg_sku_weight_data.sku_weight) as decimal(10,2)) AS total_weight,
                            Count(wg_sku_weight_data.sku_code) AS unit,
                            wg_sku_weight_data.lot_number,
                            wg_sku_weight_data.scale_number,
                            REPLACE(wg_sku_weight_data.sku_code, ' ', '') AS item_code,
                            '$shop_name' as shop_name,
                            '$ref_order' as order_number,
                            '$date ' as date
                            FROM
                            wg_sku_weight_data
                            LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                            WHERE 
                            wg_sku_weight_data.lot_number IN ($order_cl)
                            AND wg_scale.department IN (8,9)
                            AND wg_sku_weight_data.weighing_type IN (2)
                            GROUP BY
                            REPLACE(wg_sku_weight_data.sku_code, ' ', '')
                                ) AS compare_report ON wg_sku_item.item_code = REPLACE(compare_report.item_code, ' ', '')
                            WHERE
                                wg_sku_item.wg_sku_id IN (3, 7, 6, 9) 
                                -- AND compare_report.total_weight <> 0
                            GROUP BY
                                wg_sku_item.item_code 
                            ORDER BY
                                wg_sku_item.item_code ASC"
            );
            $select_order_result_of = DB::select("SELECT
                                wg_sku_item.item_code,
                                wg_sku_item.item_name,
                                compare_report.total_weight,
                                compare_report.date,
                                compare_report.unit,
                                compare_report.shop_name,
                                wg_sku_item.id,
                                wg_sku_item.sku_category,
                                wg_sku_item.wg_sku_id,
                                wg_sku_item.unit as unit_name,
                                wg_sku_item.barcode,
                                wg_sku_item.price,
                                wg_sku_item.member_price,
                                wg_sku_item.note,
                                wg_sku_item.created_at,
                                wg_sku_item.updated_at 
                            FROM
                                wg_sku_item
                                LEFT JOIN (
                            SELECT
                            cast(Sum(wg_sku_weight_data.sku_weight) as decimal(10,2)) AS total_weight,
                            Count(wg_sku_weight_data.sku_code) AS unit,
                            wg_sku_weight_data.lot_number,
                            wg_sku_weight_data.scale_number,
                            REPLACE(wg_sku_weight_data.sku_code, ' ', '') AS item_code,
                            '$shop_name' as shop_name,
                            '$ref_order' as order_number,
                            '$date ' as date
                            FROM
                            wg_sku_weight_data
                            LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                            WHERE 
                            wg_sku_weight_data.lot_number IN ($order_of)
                            AND wg_scale.department IN (4,5,6)
                            AND wg_sku_weight_data.weighing_type IN (2)
                            GROUP BY
                            REPLACE(wg_sku_weight_data.sku_code, ' ', '')
                                ) AS compare_report ON wg_sku_item.item_code = REPLACE(compare_report.item_code, ' ', '')
                            WHERE
                                wg_sku_item.wg_sku_id IN (4, 5) 
                                -- AND compare_report.total_weight <> 0
                            GROUP BY
                                wg_sku_item.item_code 
                            ORDER BY
                                wg_sku_item.item_code ASC"
            );
            #itemcode ที่ใช้ทั้งคู่
            $select_order_same = DB::select("SELECT
                    wg_sku_item.item_code,
                    wg_sku_item.item_name,
                    compare_report.total_weight,
                    compare_report.date,
                    compare_report.unit,
                    compare_report.shop_name,
                    wg_sku_item.id,
                    wg_sku_item.sku_category,
                    wg_sku_item.wg_sku_id,
                    wg_sku_item.unit as unit_name,
                    wg_sku_item.barcode,
                    wg_sku_item.price,
                    wg_sku_item.member_price,
                    wg_sku_item.note,
                    wg_sku_item.created_at,
                    wg_sku_item.updated_at 
                FROM
                    wg_sku_item
                    LEFT JOIN (
                SELECT
                cast(Sum(wg_sku_weight_data.sku_weight) as decimal(10,2)) AS total_weight,
                Count(wg_sku_weight_data.sku_code) AS unit,
                wg_sku_weight_data.lot_number,
                wg_sku_weight_data.scale_number,
                REPLACE(wg_sku_weight_data.sku_code, ' ', '') AS item_code,
                '$shop_name' as shop_name,
                '$ref_order' as order_number,
                '$date ' as date
                FROM
                wg_sku_weight_data
                LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                WHERE 
                wg_sku_weight_data.lot_number IN ($order_cl)
                AND wg_scale.department IN (8,9)
                AND wg_sku_weight_data.weighing_type IN (2)
                GROUP BY
                REPLACE(wg_sku_weight_data.sku_code, ' ', '')
                    ) AS compare_report ON wg_sku_item.item_code = REPLACE(compare_report.item_code, ' ', '')
                WHERE
                    wg_sku_item.wg_sku_id IN (30) 
                GROUP BY
                    wg_sku_item.item_code 
                ORDER BY
                    wg_sku_item.item_code ASC"
            );
            $select_order_result_transform = DB::select("SELECT
                                wg_sku_item.item_code,
                                wg_sku_item.item_name,
                                compare_report.total_weight,
                                compare_report.date,
                                compare_report.unit,
                                compare_report.shop_name,
                                wg_sku_item.id,
                                wg_sku_item.sku_category,
                                wg_sku_item.wg_sku_id,
                                wg_sku_item.unit as unit_name,
                                wg_sku_item.barcode,
                                wg_sku_item.price,
                                wg_sku_item.member_price,
                                wg_sku_item.note,
                                wg_sku_item.created_at,
                                wg_sku_item.updated_at 
                            FROM
                                wg_sku_item
                                LEFT JOIN (
                            SELECT
                            cast(Sum(wg_sku_weight_data.sku_weight) as decimal(10,2)) AS total_weight,
                            Count(wg_sku_weight_data.sku_code) AS unit,
                            wg_sku_weight_data.lot_number,
                            wg_sku_weight_data.scale_number,
                            REPLACE(wg_sku_weight_data.sku_code, ' ', '') AS item_code,
                            '$shop_name' as shop_name,
                            '$ref_order' as order_number,
                            '$date ' as date
                            FROM
                            wg_sku_weight_data
                            LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                            WHERE 
                            wg_sku_weight_data.lot_number IN ($order_cl,$order_of)
                                AND wg_scale.department IN ( 4, 5, 6, 8, 9 )
                                AND wg_sku_weight_data.weighing_type IN ( 12 ) 
                            GROUP BY
                                REPLACE ( wg_sku_weight_data.sku_code, ' ', '' )
                                ) AS compare_report ON wg_sku_item.item_code = REPLACE ( compare_report.item_code, ' ', '' )
                            WHERE
                                compare_report.total_weight <> 0
                            GROUP BY
                                wg_sku_item.item_code
                            ORDER BY
                                wg_sku_item.item_code ASC "
            );

        }else{
            // น้ำหนักจากโรงงาน
            $select_order_result = DB::select("SELECT
                                wg_sku_item.item_code,
                                wg_sku_item.item_name,
                                compare_report.total_weight,
                                compare_report.date,
                                compare_report.unit,
                                compare_report.shop_name,
                                wg_sku_item.id,
                                wg_sku_item.sku_category,
                                wg_sku_item.wg_sku_id,
                                wg_sku_item.unit as unit_name,
                                wg_sku_item.barcode,
                                wg_sku_item.price,
                                wg_sku_item.member_price,
                                wg_sku_item.note,
                                wg_sku_item.created_at,
                                wg_sku_item.updated_at 
                            FROM
                                wg_sku_item
                                LEFT JOIN (
                            SELECT
                            cast(Sum(wg_sku_weight_data.sku_weight) as decimal(10,2)) AS total_weight,
                            Count(wg_sku_weight_data.sku_code) AS unit,
                            wg_sku_weight_data.lot_number,
                            wg_sku_weight_data.scale_number,
                            REPLACE(wg_sku_weight_data.sku_code, ' ', '') AS item_code,
                            '$shop_name' as shop_name,
                            '$ref_order' as order_number,
                            '$date ' as date
                            FROM
                            wg_sku_weight_data
                            LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                            WHERE 
                            wg_sku_weight_data.lot_number IN ('$order_cl')
                            AND wg_scale.department IN (8,9)
                            AND wg_sku_weight_data.weighing_type IN (2)
                            GROUP BY
                            REPLACE(wg_sku_weight_data.sku_code, ' ', '')
                                ) AS compare_report ON wg_sku_item.item_code = REPLACE(compare_report.item_code, ' ', '')
                            WHERE
                                wg_sku_item.wg_sku_id IN (3, 7, 6, 9) 
                            GROUP BY
                                wg_sku_item.item_code 
                            ORDER BY
                                wg_sku_item.item_code ASC"
            );
            $select_order_result_of = DB::select("SELECT
                                wg_sku_item.item_code,
                                wg_sku_item.item_name,
                                compare_report.total_weight,
                                compare_report.date,
                                compare_report.unit,
                                compare_report.shop_name,
                                wg_sku_item.id,
                                wg_sku_item.sku_category,
                                wg_sku_item.wg_sku_id,
                                wg_sku_item.unit as unit_name,
                                wg_sku_item.barcode,
                                wg_sku_item.price,
                                wg_sku_item.member_price,
                                wg_sku_item.note,
                                wg_sku_item.created_at,
                                wg_sku_item.updated_at 
                            FROM
                                wg_sku_item
                                LEFT JOIN (
                            SELECT
                            cast(Sum(wg_sku_weight_data.sku_weight) as decimal(10,2)) AS total_weight,
                            Count(wg_sku_weight_data.sku_code) AS unit,
                            wg_sku_weight_data.lot_number,
                            wg_sku_weight_data.scale_number,
                            REPLACE(wg_sku_weight_data.sku_code, ' ', '') AS item_code,
                            '$shop_name' as shop_name,
                            '$ref_order' as order_number,
                            '$date ' as date
                            FROM
                            wg_sku_weight_data
                            LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                            WHERE 
                            wg_sku_weight_data.lot_number IN ('$order_of')
                            AND wg_scale.department IN (4,5,6)
                            AND wg_sku_weight_data.weighing_type IN (2)
                            GROUP BY
                            REPLACE(wg_sku_weight_data.sku_code, ' ', '')
                                ) AS compare_report ON wg_sku_item.item_code = REPLACE(compare_report.item_code, ' ', '')
                            WHERE
                                wg_sku_item.wg_sku_id IN (4, 5) 
                            GROUP BY
                                wg_sku_item.item_code 
                            ORDER BY
                                wg_sku_item.item_code ASC"
            );
            #itemcode ที่ใช้ทั้งคู่
            $select_order_same = DB::select("SELECT
                    wg_sku_item.item_code,
                    wg_sku_item.item_name,
                    compare_report.total_weight,
                    compare_report.date,
                    compare_report.unit,
                    compare_report.shop_name,
                    wg_sku_item.id,
                    wg_sku_item.sku_category,
                    wg_sku_item.wg_sku_id,
                    wg_sku_item.unit as unit_name,
                    wg_sku_item.barcode,
                    wg_sku_item.price,
                    wg_sku_item.member_price,
                    wg_sku_item.note,
                    wg_sku_item.created_at,
                    wg_sku_item.updated_at 
                FROM
                    wg_sku_item
                    LEFT JOIN (
                SELECT
                cast(Sum(wg_sku_weight_data.sku_weight) as decimal(10,2)) AS total_weight,
                Count(wg_sku_weight_data.sku_code) AS unit,
                wg_sku_weight_data.lot_number,
                wg_sku_weight_data.scale_number,
                REPLACE(wg_sku_weight_data.sku_code, ' ', '') AS item_code,
                '$shop_name' as shop_name,
                '$ref_order' as order_number,
                '$date ' as date
                FROM
                wg_sku_weight_data
                LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                WHERE 
                wg_sku_weight_data.lot_number IN ('$order_cl')
                AND wg_scale.department IN (8,9)
                AND wg_sku_weight_data.weighing_type IN (2)
                GROUP BY
                REPLACE(wg_sku_weight_data.sku_code, ' ', '')
                    ) AS compare_report ON wg_sku_item.item_code = REPLACE(compare_report.item_code, ' ', '')
                WHERE
                    wg_sku_item.wg_sku_id IN (30) 
                GROUP BY
                    wg_sku_item.item_code 
                ORDER BY
                    wg_sku_item.item_code ASC"
            );

            $select_order_result_transform = DB::select("SELECT
                                wg_sku_item.item_code,
                                wg_sku_item.item_name,
                                compare_report.total_weight,
                                compare_report.date,
                                compare_report.unit,
                                compare_report.shop_name,
                                wg_sku_item.id,
                                wg_sku_item.sku_category,
                                wg_sku_item.wg_sku_id,
                                wg_sku_item.unit as unit_name,
                                wg_sku_item.barcode,
                                wg_sku_item.price,
                                wg_sku_item.member_price,
                                wg_sku_item.note,
                                wg_sku_item.created_at,
                                wg_sku_item.updated_at 
                            FROM
                                wg_sku_item
                                LEFT JOIN (
                            SELECT
                            cast(Sum(wg_sku_weight_data.sku_weight) as decimal(10,2)) AS total_weight,
                            Count(wg_sku_weight_data.sku_code) AS unit,
                            wg_sku_weight_data.lot_number,
                            wg_sku_weight_data.scale_number,
                            REPLACE(wg_sku_weight_data.sku_code, ' ', '') AS item_code,
                            '$shop_name' as shop_name,
                            '$ref_order' as order_number,
                            '$date ' as date
                            FROM
                            wg_sku_weight_data
                            LEFT JOIN wg_scale ON wg_sku_weight_data.scale_number = wg_scale.scale_number
                            WHERE 
                            wg_sku_weight_data.lot_number IN ('$order_cl','$order_of')
                                AND wg_scale.department IN ( 4, 5, 6, 8, 9 )
                                AND wg_sku_weight_data.weighing_type IN ( 12 ) 
                            GROUP BY
                                REPLACE ( wg_sku_weight_data.sku_code, ' ', '' )
                                ) AS compare_report ON wg_sku_item.item_code = REPLACE ( compare_report.item_code, ' ', '' )
                            WHERE
                                compare_report.total_weight <> 0
                            GROUP BY
                                wg_sku_item.item_code
                            ORDER BY
                                wg_sku_item.item_code ASC "
            );
        }

        // น้ำหนักตัดแต่งทั้งหมด
        $sum_total_weight_factory = 0;
        foreach ($select_order_result as $key => $value) {
            $sum_total_weight_factory = $sum_total_weight_factory + $value->total_weight;
        }
        foreach ($select_order_result_of as $key => $value) {
            $sum_total_weight_factory = $sum_total_weight_factory + $value->total_weight;
        }
        foreach ($select_order_same as $key => $value) {
            $sum_total_weight_factory = $sum_total_weight_factory + $value->total_weight;
        }



        $item_tf = "'0000'";
        foreach ($select_order_result_transform as $key => $result_transform) {
            $item_tf = $item_tf . ",'$result_transform->item_code'";
        }

        // น้ำหนักถึงร้านค้า
        $select_shop_result = DB::select("SELECT
                                            wg_sku_item.item_code,
                                            wg_sku_item.item_name,
                                            SUM(compare_report_shop.total_weight) as total_weight,
                                            SUM(compare_report_shop.unit) as unit,
                                            wg_sku_item.id,
                                            wg_sku_item.sku_category,
                                            wg_sku_item.wg_sku_id,
                                            wg_sku_item.unit as unit_name,
                                            wg_sku_item.barcode,
                                            wg_sku_item.price,
                                            wg_sku_item.member_price,
                                            wg_sku_item.note,
                                            wg_sku_item.created_at,
                                            wg_sku_item.updated_at 
                                        FROM
                                            wg_sku_item
                                            LEFT JOIN (
                                        SELECT
                                        compare_report_shop.*
                                        FROM
                                        compare_report_shop
                                        WHERE compare_report_shop.order_number IN ($order_tr)
                                            ) AS compare_report_shop ON wg_sku_item.item_code = REPLACE(compare_report_shop.item_code , ' ', '')
                                        WHERE
                                            wg_sku_item.wg_sku_id IN ( 3, 4, 5, 7, 6 ,9) 
                                            AND wg_sku_item.item_code NOT IN ($item_tf)
                                        GROUP BY
                                            wg_sku_item.item_code 
                                        ORDER BY
                                            wg_sku_item.item_code ASC"
        );

        $select_shop_result_transform = DB::select("SELECT
                                            wg_sku_item.item_code,
                                            wg_sku_item.item_name,
                                            SUM(compare_report_shop.total_weight) as total_weight,
                                            SUM(compare_report_shop.unit) as unit,
                                            wg_sku_item.id,
                                            wg_sku_item.sku_category,
                                            wg_sku_item.wg_sku_id,
                                            wg_sku_item.unit as unit_name,
                                            wg_sku_item.barcode,
                                            wg_sku_item.price,
                                            wg_sku_item.member_price,
                                            wg_sku_item.note,
                                            wg_sku_item.created_at,
                                            wg_sku_item.updated_at 
                                        FROM
                                            wg_sku_item
                                            LEFT JOIN (
                                        SELECT
                                        compare_report_shop.*
                                        FROM
                                        compare_report_shop
                                        WHERE compare_report_shop.order_number IN ($order_tr)
                                            ) AS compare_report_shop ON wg_sku_item.item_code = REPLACE(compare_report_shop.item_code , ' ', '')
                                        WHERE
                                            wg_sku_item.wg_sku_id IN ( 3, 4, 5, 7, 6 ,9) 
                                            AND wg_sku_item.item_code IN ($item_tf)
                                        GROUP BY
                                            wg_sku_item.item_code 
                                        ORDER BY
                                            wg_sku_item.item_code ASC"
        );

        return view('report.compare_fac_shop_daily_report',compact('select_order_result','select_shop_result','select_order_result_transform','select_shop_result_transform'
        ,'shop_name','date' , 'weight_recieve','order_tr','sum_total_weight_factory','select_order_result_of','select_order_same'));
    }
}
