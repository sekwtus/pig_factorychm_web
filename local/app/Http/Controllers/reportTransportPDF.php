<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use DB;

class reportTransportPDF extends Controller
{
    public function create_pdf1($order_number){

        $select_cutting_number = DB::select("SELECT
        tb_order_transport.*,
        tb_customer.customer_code
        FROM
        tb_order_transport
        LEFT JOIN tb_customer ON tb_order_transport.id_user_customer = tb_customer.customer_name
        WHERE order_number = '$order_number'");

      $cutting_number = $select_cutting_number[0]->order_cutting_number;
      $offal_number = $select_cutting_number[0]->order_offal_number;
      $location_scale = $select_cutting_number[0]->customer_code;
      $date_transport = $select_cutting_number[0]->date_transport;

        // น้ำหนักจากโรงงาน
         $select_item_main = DB::select("SELECT
            wg_sku_item.item_code,
            wg_sku_item.item_name,
            count( wg_sku_weight_data.sku_amount ) AS count_unit,
            sum( wg_sku_weight_data.sku_weight ) AS sum_weight 
          FROM
            wg_sku_item
            LEFT JOIN ( SELECT wg_sku_weight_data.* FROM wg_sku_weight_data 
                          WHERE wg_sku_weight_data.lot_number IN ('$cutting_number')
                          AND wg_sku_weight_data.weighing_type IN (2) )
            AS wg_sku_weight_data ON wg_sku_item.item_code = REPLACE(wg_sku_weight_data.sku_code, ' ', '') 
          WHERE
            wg_sku_item.wg_sku_id IN (3, 7, 6, 9,30 ) 
          GROUP BY
            wg_sku_item.item_code 
          ORDER BY
            wg_sku_item.item_code ASC");

           // น้ำหนักจากโรงงาน เครื่องใน
        $select_item_offal_main = DB::select("SELECT
            wg_sku_item.item_code,
            wg_sku_item.item_name,
            count( wg_sku_weight_data.sku_amount ) AS count_unit,
            sum( wg_sku_weight_data.sku_weight ) AS sum_weight 
            FROM
            wg_sku_item
            LEFT JOIN ( SELECT wg_sku_weight_data.* FROM wg_sku_weight_data 
                        WHERE wg_sku_weight_data.lot_number IN ('$offal_number')
                        AND wg_sku_weight_data.weighing_type IN (2) )
            AS wg_sku_weight_data ON wg_sku_item.item_code = REPLACE(wg_sku_weight_data.sku_code, ' ', '') 
            WHERE
            wg_sku_item.wg_sku_id IN (4,5) 
            GROUP BY
            wg_sku_item.item_code 
            ORDER BY
            wg_sku_item.item_code ASC");

        // นับจำนวน เพื่อวนเมื่อเกิน10
        $rowspan_count_item = DB::select("SELECT
                    COUNT( wg_sku_weight_data.id ) AS count_id,
                    REPLACE(wg_sku_weight_data.sku_code, ' ', '')
                  FROM
                    wg_sku_weight_data
                    LEFT JOIN wg_sku_item ON REPLACE(wg_sku_weight_data.sku_code, ' ', '') = wg_sku_item.item_code 
                  WHERE
                    wg_sku_weight_data.lot_number IN ('$cutting_number','$offal_number')
                    AND wg_sku_weight_data.weighing_type IN (2) 
                  GROUP BY
                    REPLACE(wg_sku_weight_data.sku_code, ' ', '')");
                                 
        $select_weight_in_order = DB::select("SELECT
            wg_sku_weight_data.*
          FROM
            wg_sku_weight_data
            LEFT JOIN wg_sku_item ON REPLACE(wg_sku_weight_data.sku_code, ' ', '') = wg_sku_item.item_code 
          WHERE
            wg_sku_weight_data.lot_number IN ('$cutting_number')
            AND wg_sku_weight_data.weighing_type IN (2)
            AND wg_sku_item.wg_sku_id IN (3, 7, 6, 9,30 ) 
                  ");

        $select_weight_in_order_offal = DB::select("SELECT
            wg_sku_weight_data.*
            FROM
            wg_sku_weight_data
            LEFT JOIN wg_sku_item ON REPLACE(wg_sku_weight_data.sku_code, ' ', '') = wg_sku_item.item_code 
            WHERE
            wg_sku_weight_data.lot_number IN ('$offal_number')
            AND wg_sku_weight_data.weighing_type IN (2)
              AND wg_sku_item.wg_sku_id IN ( 4,5 ) 
            ");

        // โอนออก
        $select_weight_transfer = DB::select("SELECT
                    wg_sku_weight_data.*,
                    wg_sku_item.item_name,
                    wg_sku_item.item_code
                  FROM
                    wg_sku_weight_data
                    LEFT JOIN wg_sku_item ON REPLACE(wg_sku_weight_data.sku_code, ' ', '') = wg_sku_item.item_code 
                  WHERE
                    wg_sku_weight_data.lot_number IN ('$cutting_number','$offal_number')
                    AND wg_sku_weight_data.weighing_type = 5
                  ");

        $select_weight_transfer_group = DB::select("SELECT
                    wg_sku_item.item_name,
                    wg_sku_item.item_code,
                    Count( wg_sku_weight_data.sku_amount ) AS count_unit,
                    Sum( wg_sku_weight_data.sku_weight ) AS sum_weight,
                    wg_sku_weight_data.*,
                    wg_scale.location_scale 
                  FROM
                    wg_sku_weight_data
                    LEFT JOIN wg_sku_item ON REPLACE(wg_sku_weight_data.sku_code, ' ', '') = wg_sku_item.item_code
                    LEFT JOIN wg_scale ON wg_sku_weight_data.weighing_place = wg_scale.scale_number 
                  WHERE
                    wg_sku_weight_data.lot_number IN ('$cutting_number','$offal_number')
                    AND wg_sku_weight_data.weighing_type = 5
                  GROUP BY wg_sku_item.item_code
                  ,wg_sku_weight_data.weighing_place
                  ORDER BY wg_sku_weight_data.weighing_place ASC
                  ");
                  

              
              $order_recieve_number = DB::select("SELECT * from tb_order_cutting WHERE order_number = '$cutting_number' ");
              $order_recieve = $order_recieve_number[0]->order_ref;

              return view('transport.report_transport_pdf',compact('select_item_main','select_weight_in_order','rowspan_count_item','select_cutting_number',
              'select_weight_transfer','select_weight_transfer_group','cutting_number','offal_number','order_recieve','select_item_offal_main','select_weight_in_order_offal'));

    }

    public function create_pdf($order_number){

      $select_cutting_number = DB::select("SELECT
        tb_order_transport.*,
        tb_customer.customer_code
        FROM
        tb_order_transport
        LEFT JOIN tb_customer ON tb_order_transport.id_user_customer = tb_customer.customer_name
        WHERE order_number = '$order_number'"
      );

      $offal_number = "'-'";
      $cutting_number = "'-'";
      foreach ($select_cutting_number as $key => $value) {
        $offal_number = $offal_number .",'". $value->order_offal_number."'";

        $cutting_number = $cutting_number .",'". $value->order_cutting_number."'";
      }

      $location_scale = $select_cutting_number[0]->customer_code;
      $date_transport = $select_cutting_number[0]->date_transport;


      // ใช้หลังวันที่22/04/2020
      if (substr($date_transport,6,4).substr($date_transport,3,2).substr($date_transport,0,2) > 20200422) {
          return $this->create_pdf2($order_number);
      }

      if ( substr($date_transport,6,4).substr($date_transport,3,2).substr($date_transport,0,2) > 20200327 ) {
                      // น้ำหนักจากโรงงาน ตัดแต่ง 

            $select_item_main = DB::select("SELECT
                      wg_sku_item.item_code,
                      wg_sku_item.item_name,
                      count( wg_sku_weight_data.sku_amount ) AS count_unit,
                      sum( wg_sku_weight_data.sku_weight ) AS sum_weight 
                    FROM
                      wg_sku_item
                      LEFT JOIN ( SELECT wg_sku_weight_data.* FROM wg_sku_weight_data 
                                    WHERE wg_sku_weight_data.lot_number IN ($cutting_number)
                                    AND wg_sku_weight_data.weighing_type IN (2,12) )
                      AS wg_sku_weight_data ON wg_sku_item.item_code = REPLACE(wg_sku_weight_data.sku_code, ' ', '') 
                    WHERE
                      wg_sku_item.wg_sku_id IN (3, 7, 6, 9, 30 ) 
                    GROUP BY
                      wg_sku_item.item_code 
                    ORDER BY
                      wg_sku_item.item_code ASC");
              


              // น้ำหนักจากโรงงาน เครื่องใน
              $select_item_offal_main = DB::select("SELECT
                    wg_sku_item.item_code,
                    wg_sku_item.item_name,
                    count( wg_sku_weight_data.sku_amount ) AS count_unit,
                    sum( wg_sku_weight_data.sku_weight ) AS sum_weight 
                    FROM
                    wg_sku_item
                    LEFT JOIN ( SELECT wg_sku_weight_data.* FROM wg_sku_weight_data 
                                WHERE wg_sku_weight_data.lot_number IN ($offal_number)
                                AND wg_sku_weight_data.weighing_type IN (2,12) )
                    AS wg_sku_weight_data ON wg_sku_item.item_code = REPLACE(wg_sku_weight_data.sku_code, ' ', '') 
                    WHERE
                    wg_sku_item.wg_sku_id IN (4,5) 
                    GROUP BY
                    wg_sku_item.item_code 
                    ORDER BY
                    wg_sku_item.item_code ASC");


              // นับจำนวน เพื่อวนเมื่อเกิน10
              $rowspan_count_item = DB::select("SELECT
                          COUNT( wg_sku_weight_data.id ) AS count_id,
                          REPLACE(wg_sku_weight_data.sku_code, ' ', '')
                        FROM
                          wg_sku_weight_data
                          LEFT JOIN wg_sku_item ON REPLACE(wg_sku_weight_data.sku_code, ' ', '') = wg_sku_item.item_code 
                        WHERE
                          wg_sku_weight_data.lot_number IN ($cutting_number,$offal_number)
                          AND wg_sku_weight_data.weighing_type IN (2,12) 
                        GROUP BY
                          REPLACE(wg_sku_weight_data.sku_code, ' ', '')");

                                                  
              $select_weight_in_order = DB::select("SELECT
                          wg_sku_weight_data.*
                        FROM
                          wg_sku_weight_data
                          LEFT JOIN wg_sku_item ON REPLACE(wg_sku_weight_data.sku_code, ' ', '') = wg_sku_item.item_code 
                        WHERE
                          wg_sku_weight_data.lot_number IN ($cutting_number)
                          AND wg_sku_weight_data.weighing_type IN (2,12)
                          AND wg_sku_item.wg_sku_id IN (3, 7, 6, 9,30 ) 
                        ");

              $select_weight_in_order_offal = DB::select("SELECT
                        wg_sku_weight_data.*
                        FROM
                        wg_sku_weight_data
                        LEFT JOIN wg_sku_item ON REPLACE(wg_sku_weight_data.sku_code, ' ', '') = wg_sku_item.item_code 
                        WHERE
                        wg_sku_weight_data.lot_number IN ($offal_number)
                        AND wg_sku_weight_data.weighing_type IN (2,12)
                          AND wg_sku_item.wg_sku_id IN ( 4,5 ) 
                        ");
      }else{
        // น้ำหนักจากโรงงาน ตัดแต่ง 

            $select_item_main = DB::select("SELECT
              wg_sku_item.item_code,
              wg_sku_item.item_name,
              count( wg_sku_weight_data.sku_amount ) AS count_unit,
              sum( wg_sku_weight_data.sku_weight ) AS sum_weight 
            FROM
              wg_sku_item
              LEFT JOIN ( SELECT wg_sku_weight_data.* FROM wg_sku_weight_data 
                            WHERE wg_sku_weight_data.lot_number IN ('$cutting_number')
                            AND wg_sku_weight_data.weighing_type IN (2) )
              AS wg_sku_weight_data ON wg_sku_item.item_code = REPLACE(wg_sku_weight_data.sku_code, ' ', '') 
            WHERE
              wg_sku_item.wg_sku_id IN (3, 7, 6, 9, 30 ) 
            GROUP BY
              wg_sku_item.item_code 
            ORDER BY
              wg_sku_item.item_code ASC");



        // น้ำหนักจากโรงงาน เครื่องใน
          $select_item_offal_main = DB::select("SELECT
            wg_sku_item.item_code,
            wg_sku_item.item_name,
            count( wg_sku_weight_data.sku_amount ) AS count_unit,
            sum( wg_sku_weight_data.sku_weight ) AS sum_weight 
            FROM
            wg_sku_item
            LEFT JOIN ( SELECT wg_sku_weight_data.* FROM wg_sku_weight_data 
                        WHERE wg_sku_weight_data.lot_number IN ('$offal_number')
                        AND wg_sku_weight_data.weighing_type IN (2) )
            AS wg_sku_weight_data ON wg_sku_item.item_code = REPLACE(wg_sku_weight_data.sku_code, ' ', '') 
            WHERE
            wg_sku_item.wg_sku_id IN (4,5) 
            GROUP BY
            wg_sku_item.item_code 
            ORDER BY
            wg_sku_item.item_code ASC");


        // นับจำนวน เพื่อวนเมื่อเกิน10
          $rowspan_count_item = DB::select("SELECT
              COUNT( wg_sku_weight_data.id ) AS count_id,
              REPLACE(wg_sku_weight_data.sku_code, ' ', '')
            FROM
              wg_sku_weight_data
              LEFT JOIN wg_sku_item ON REPLACE(wg_sku_weight_data.sku_code, ' ', '') = wg_sku_item.item_code 
            WHERE
              wg_sku_weight_data.lot_number IN ('$cutting_number','$offal_number')
              AND wg_sku_weight_data.weighing_type IN (2) 
            GROUP BY
              REPLACE(wg_sku_weight_data.sku_code, ' ', '')");

                                      
          $select_weight_in_order = DB::select("SELECT
                wg_sku_weight_data.*
              FROM
                wg_sku_weight_data
                LEFT JOIN wg_sku_item ON REPLACE(wg_sku_weight_data.sku_code, ' ', '') = wg_sku_item.item_code 
              WHERE
                wg_sku_weight_data.lot_number IN ('$cutting_number')
                AND wg_sku_weight_data.weighing_type IN (2)
                AND wg_sku_item.wg_sku_id IN (3, 7, 6, 9,30 ) 
              ");

          $select_weight_in_order_offal = DB::select("SELECT
            wg_sku_weight_data.*
            FROM
            wg_sku_weight_data
            LEFT JOIN wg_sku_item ON REPLACE(wg_sku_weight_data.sku_code, ' ', '') = wg_sku_item.item_code 
            WHERE
            wg_sku_weight_data.lot_number IN ('$offal_number')
            AND wg_sku_weight_data.weighing_type IN (2)
              AND wg_sku_item.wg_sku_id IN ( 4,5 ) 
            ");
      }
                            
        $report_transport_check = DB::select("SELECT * FROM `tb_report_transport_check` WHERE order_number = '$order_number'");

        // master เพิ่ม แก้ไขรายการน้ำหนัก
        $wg_scale = DB::select("SELECT * from wg_scale WHERE wg_scale.location_type = 'โรงงาน' ");
        $wg_scale_shop = DB::select("SELECT * from wg_scale WHERE wg_scale.location_type = 'ร้านค้า' ");
        $wg_weight_type = DB::select("SELECT * from wg_weight_type");
        $wg_sku = DB::select("SELECT * from wg_sku");
        $wg_storage = DB::select("SELECT * from wg_storage");
              
        $order_recieve_number = DB::select("SELECT * from tb_order_cutting WHERE order_number IN ($cutting_number) ");
        $order_recieve = $order_recieve_number[0]->order_ref;


        return view('transport.report_transport_pdf',compact('select_item_main','select_weight_in_order','rowspan_count_item','select_cutting_number',
              'cutting_number','offal_number','order_recieve','select_item_offal_main','select_weight_in_order_offal'));
    }

    public function create_pdf2($order_number){

      $select_cutting_number = DB::select("SELECT
        tb_order_transport.*,
        tb_customer.customer_code
        FROM
        tb_order_transport
        LEFT JOIN tb_customer ON tb_order_transport.id_user_customer = tb_customer.customer_name
        WHERE order_number = '$order_number'"
      );

      $offal_number = "'-'";
      $cutting_number = "'-'";
      foreach ($select_cutting_number as $key => $value) {
        $offal_number = $offal_number .",'". $value->order_offal_number."'";

        $cutting_number = $cutting_number .",'". $value->order_cutting_number."'";
      }

      $location_scale = $select_cutting_number[0]->customer_code;
      $date_transport = $select_cutting_number[0]->date_transport;

      if ( substr($date_transport,6,4).substr($date_transport,3,2).substr($date_transport,0,2) > 20200327 ) {
            
            // น้ำหนักจากโรงงาน ตัดแต่ง 
            $select_item_main = DB::select("SELECT
                      wg_sku_item.item_code,
                      wg_sku_item.item_name,
                      count( wg_sku_weight_data.sku_amount ) AS count_unit,
                      sum( wg_sku_weight_data.sku_weight ) AS sum_weight 
                    FROM
                      wg_sku_item
                      LEFT JOIN ( SELECT wg_sku_weight_data.* FROM wg_sku_weight_data 
                                    WHERE wg_sku_weight_data.lot_number IN ($cutting_number)
                                    AND wg_sku_weight_data.weighing_type IN (2,12) )
                      AS wg_sku_weight_data ON wg_sku_item.item_code = REPLACE(wg_sku_weight_data.sku_code, ' ', '') 
                    WHERE
                      wg_sku_item.group_show_report IN (1) 
                    GROUP BY
                      wg_sku_item.item_code 
                    ORDER BY
                      wg_sku_item.item_code ASC"
            );
            // น้ำหนักจากโรงงาน เครื่องใน
            $select_item_offal_main = DB::select("SELECT
                  wg_sku_item.item_code,
                  wg_sku_item.item_name,
                  count( wg_sku_weight_data.sku_amount ) AS count_unit,
                  sum( wg_sku_weight_data.sku_weight ) AS sum_weight 
                  FROM
                  wg_sku_item
                  LEFT JOIN ( SELECT wg_sku_weight_data.* FROM wg_sku_weight_data 
                              WHERE wg_sku_weight_data.lot_number IN ($offal_number)
                              AND wg_sku_weight_data.weighing_type IN (2,12) )
                  AS wg_sku_weight_data ON wg_sku_item.item_code = REPLACE(wg_sku_weight_data.sku_code, ' ', '') 
                  WHERE
                  wg_sku_item.group_show_report IN (2) 
                  GROUP BY
                  wg_sku_item.item_code 
                  ORDER BY
                  wg_sku_item.item_code ASC"
            );
            // น้ำหนักจากโรงงาน แปรสภาพ
            $select_item_tf_main = DB::select("SELECT
                  wg_sku_item.item_code,
                  wg_sku_item.item_name,
                  count( wg_sku_weight_data.sku_amount ) AS count_unit,
                  sum( wg_sku_weight_data.sku_weight ) AS sum_weight 
                  FROM
                  wg_sku_item
                  LEFT JOIN ( SELECT wg_sku_weight_data.* FROM wg_sku_weight_data 
                              WHERE wg_sku_weight_data.lot_number IN ($cutting_number,$offal_number)
                              AND wg_sku_weight_data.weighing_type IN (2,12) )
                  AS wg_sku_weight_data ON wg_sku_item.item_code = REPLACE(wg_sku_weight_data.sku_code, ' ', '') 
                  WHERE
                  wg_sku_item.group_show_report IN (3) 
                  GROUP BY
                  wg_sku_item.item_code 
                  ORDER BY
                  wg_sku_item.item_code ASC"
            );
            // น้ำหนักจากโรงงาน หััวชุด
            $select_item_head_main = DB::select("SELECT
                  wg_sku_item.item_code,
                  wg_sku_item.item_name,
                  count( wg_sku_weight_data.sku_amount ) AS count_unit,
                  sum( wg_sku_weight_data.sku_weight ) AS sum_weight 
                  FROM
                  wg_sku_item
                  LEFT JOIN ( SELECT wg_sku_weight_data.* FROM wg_sku_weight_data 
                              WHERE wg_sku_weight_data.lot_number IN ($cutting_number,$offal_number)
                              AND wg_sku_weight_data.weighing_type IN (2,12) )
                  AS wg_sku_weight_data ON wg_sku_item.item_code = REPLACE(wg_sku_weight_data.sku_code, ' ', '') 
                  WHERE
                  wg_sku_item.group_show_report IN (4) 
                  GROUP BY
                  wg_sku_item.item_code 
                  ORDER BY
                  wg_sku_item.item_code ASC"
            );

            // นับจำนวน เพื่อวนเมื่อเกิน10
            $rowspan_count_item = DB::select("SELECT
                        COUNT( wg_sku_weight_data.id ) AS count_id,
                        REPLACE(wg_sku_weight_data.sku_code, ' ', '')
                      FROM
                        wg_sku_weight_data
                        LEFT JOIN wg_sku_item ON REPLACE(wg_sku_weight_data.sku_code, ' ', '') = wg_sku_item.item_code 
                      WHERE
                        wg_sku_weight_data.lot_number IN ($cutting_number,$offal_number)
                        AND wg_sku_weight_data.weighing_type IN (2,12) 
                      GROUP BY
                        REPLACE(wg_sku_weight_data.sku_code, ' ', '')"
            );                                                
            $select_weight_in_order = DB::select("SELECT
                        wg_sku_weight_data.*
                      FROM
                        wg_sku_weight_data
                        LEFT JOIN wg_sku_item ON REPLACE(wg_sku_weight_data.sku_code, ' ', '') = wg_sku_item.item_code 
                      WHERE
                        wg_sku_weight_data.lot_number IN ($cutting_number)
                        AND wg_sku_weight_data.weighing_type IN (2,12)
                        AND wg_sku_item.group_show_report IN (1) 
            ");
            $select_weight_in_order_offal = DB::select("SELECT
                      wg_sku_weight_data.*
                      FROM
                      wg_sku_weight_data
                      LEFT JOIN wg_sku_item ON REPLACE(wg_sku_weight_data.sku_code, ' ', '') = wg_sku_item.item_code 
                      WHERE
                      wg_sku_weight_data.lot_number IN ($offal_number)
                      AND wg_sku_weight_data.weighing_type IN (2,12)
                      AND wg_sku_item.group_show_report IN (2) 
            ");
            $select_weight_in_order_tf = DB::select("SELECT
                      wg_sku_weight_data.*
                      FROM
                      wg_sku_weight_data
                      LEFT JOIN wg_sku_item ON REPLACE(wg_sku_weight_data.sku_code, ' ', '') = wg_sku_item.item_code 
                      WHERE
                      wg_sku_weight_data.lot_number IN ($cutting_number,$offal_number)
                      AND wg_sku_weight_data.weighing_type IN (2,12)
                      AND wg_sku_item.group_show_report IN (3) 
            ");
            $select_weight_in_order_head = DB::select("SELECT
                      wg_sku_weight_data.*
                      FROM
                      wg_sku_weight_data
                      LEFT JOIN wg_sku_item ON REPLACE(wg_sku_weight_data.sku_code, ' ', '') = wg_sku_item.item_code 
                      WHERE
                      wg_sku_weight_data.lot_number IN ($cutting_number,$offal_number)
                      AND wg_sku_weight_data.weighing_type IN (2,12)
                      AND wg_sku_item.group_show_report IN (4) 
            ");

      }else{
        // น้ำหนักจากโรงงาน ตัดแต่ง 

            $select_item_main = DB::select("SELECT
              wg_sku_item.item_code,
              wg_sku_item.item_name,
              count( wg_sku_weight_data.sku_amount ) AS count_unit,
              sum( wg_sku_weight_data.sku_weight ) AS sum_weight 
            FROM
              wg_sku_item
              LEFT JOIN ( SELECT wg_sku_weight_data.* FROM wg_sku_weight_data 
                            WHERE wg_sku_weight_data.lot_number IN ('$cutting_number')
                            AND wg_sku_weight_data.weighing_type IN (2) )
              AS wg_sku_weight_data ON wg_sku_item.item_code = REPLACE(wg_sku_weight_data.sku_code, ' ', '') 
            WHERE
              wg_sku_item.wg_sku_id IN (3, 7, 6, 9, 30 ) 
            GROUP BY
              wg_sku_item.item_code 
            ORDER BY
              wg_sku_item.item_code ASC");



        // น้ำหนักจากโรงงาน เครื่องใน
          $select_item_offal_main = DB::select("SELECT
            wg_sku_item.item_code,
            wg_sku_item.item_name,
            count( wg_sku_weight_data.sku_amount ) AS count_unit,
            sum( wg_sku_weight_data.sku_weight ) AS sum_weight 
            FROM
            wg_sku_item
            LEFT JOIN ( SELECT wg_sku_weight_data.* FROM wg_sku_weight_data 
                        WHERE wg_sku_weight_data.lot_number IN ('$offal_number')
                        AND wg_sku_weight_data.weighing_type IN (2) )
            AS wg_sku_weight_data ON wg_sku_item.item_code = REPLACE(wg_sku_weight_data.sku_code, ' ', '') 
            WHERE
            wg_sku_item.wg_sku_id IN (4,5) 
            GROUP BY
            wg_sku_item.item_code 
            ORDER BY
            wg_sku_item.item_code ASC");


        // นับจำนวน เพื่อวนเมื่อเกิน10
          $rowspan_count_item = DB::select("SELECT
              COUNT( wg_sku_weight_data.id ) AS count_id,
              REPLACE(wg_sku_weight_data.sku_code, ' ', '')
            FROM
              wg_sku_weight_data
              LEFT JOIN wg_sku_item ON REPLACE(wg_sku_weight_data.sku_code, ' ', '') = wg_sku_item.item_code 
            WHERE
              wg_sku_weight_data.lot_number IN ('$cutting_number','$offal_number')
              AND wg_sku_weight_data.weighing_type IN (2) 
            GROUP BY
              REPLACE(wg_sku_weight_data.sku_code, ' ', '')");

                                      
          $select_weight_in_order = DB::select("SELECT
                wg_sku_weight_data.*
              FROM
                wg_sku_weight_data
                LEFT JOIN wg_sku_item ON REPLACE(wg_sku_weight_data.sku_code, ' ', '') = wg_sku_item.item_code 
              WHERE
                wg_sku_weight_data.lot_number IN ('$cutting_number')
                AND wg_sku_weight_data.weighing_type IN (2)
                AND wg_sku_item.wg_sku_id IN (3, 7, 6, 9,30 ) 
              ");

          $select_weight_in_order_offal = DB::select("SELECT
            wg_sku_weight_data.*
            FROM
            wg_sku_weight_data
            LEFT JOIN wg_sku_item ON REPLACE(wg_sku_weight_data.sku_code, ' ', '') = wg_sku_item.item_code 
            WHERE
            wg_sku_weight_data.lot_number IN ('$offal_number')
            AND wg_sku_weight_data.weighing_type IN (2)
              AND wg_sku_item.wg_sku_id IN ( 4,5 ) 
            ");
      }
                            
        $report_transport_check = DB::select("SELECT * FROM `tb_report_transport_check` WHERE order_number = '$order_number'");

        // master เพิ่ม แก้ไขรายการน้ำหนัก
        $wg_scale = DB::select("SELECT * from wg_scale WHERE wg_scale.location_type = 'โรงงาน' ");
        $wg_scale_shop = DB::select("SELECT * from wg_scale WHERE wg_scale.location_type = 'ร้านค้า' ");
        $wg_weight_type = DB::select("SELECT * from wg_weight_type");
        $wg_sku = DB::select("SELECT * from wg_sku");
        $wg_storage = DB::select("SELECT * from wg_storage");
              
        $order_recieve_number = DB::select("SELECT * from tb_order_cutting WHERE order_number IN ($cutting_number) ");
        $order_recieve = $order_recieve_number[0]->order_ref;


        return view('transport.new_transport.report_transport_pdf',compact('select_item_main','select_weight_in_order','rowspan_count_item','select_cutting_number','report_transport_check',
        'wg_scale','wg_scale_shop','wg_weight_type','wg_sku','wg_storage','cutting_number',
        'offal_number','order_recieve','select_item_offal_main','select_weight_in_order_offal',
        'select_item_tf_main','select_item_head_main','select_weight_in_order_tf','select_weight_in_order_head'));
    }
 
    public function create_pdf_load($order_number){

      $select_cutting_number = DB::select("SELECT
        tb_order_transport.*,
        tb_customer.customer_code
        FROM
        tb_order_transport
        LEFT JOIN tb_customer ON tb_order_transport.id_user_customer = tb_customer.customer_name
        WHERE order_number = '$order_number'"
      );

      $offal_number = "'-'";
      $cutting_number = "'-'";
      foreach ($select_cutting_number as $key => $value) {
        $offal_number = $offal_number .",'". $value->order_offal_number."'";

        $cutting_number = $cutting_number .",'". $value->order_cutting_number."'";
      }

      $location_scale = $select_cutting_number[0]->customer_code;
      $date_transport = $select_cutting_number[0]->date_transport;

      if ( substr($date_transport,6,4).substr($date_transport,3,2).substr($date_transport,0,2) > 20200327 ) {
            
            // น้ำหนักจากโรงงาน ตัดแต่ง 
            $select_item_main = DB::select("SELECT
                      wg_sku_item.item_code,
                      wg_sku_item.item_name,
                      count( wg_sku_weight_data.sku_amount ) AS count_unit,
                      sum( wg_sku_weight_data.sku_weight ) AS sum_weight 
                    FROM
                      wg_sku_item
                      LEFT JOIN ( SELECT wg_sku_weight_data.* FROM wg_sku_weight_data 
                                    WHERE wg_sku_weight_data.lot_number IN ($cutting_number)
                                    AND wg_sku_weight_data.weighing_type IN (2,12) )
                      AS wg_sku_weight_data ON wg_sku_item.item_code = REPLACE(wg_sku_weight_data.sku_code, ' ', '') 
                    WHERE
                      wg_sku_item.group_show_report IN (1) 
                    GROUP BY
                      wg_sku_item.item_code 
                    ORDER BY
                      wg_sku_item.item_code ASC"
            );
            // น้ำหนักจากโรงงาน เครื่องใน
            $select_item_offal_main = DB::select("SELECT
                  wg_sku_item.item_code,
                  wg_sku_item.item_name,
                  count( wg_sku_weight_data.sku_amount ) AS count_unit,
                  sum( wg_sku_weight_data.sku_weight ) AS sum_weight 
                  FROM
                  wg_sku_item
                  LEFT JOIN ( SELECT wg_sku_weight_data.* FROM wg_sku_weight_data 
                              WHERE wg_sku_weight_data.lot_number IN ($offal_number)
                              AND wg_sku_weight_data.weighing_type IN (2,12) )
                  AS wg_sku_weight_data ON wg_sku_item.item_code = REPLACE(wg_sku_weight_data.sku_code, ' ', '') 
                  WHERE
                  wg_sku_item.group_show_report IN (2) 
                  GROUP BY
                  wg_sku_item.item_code 
                  ORDER BY
                  wg_sku_item.item_code ASC"
            );
            // น้ำหนักจากโรงงาน แปรสภาพ
            $select_item_tf_main = DB::select("SELECT
                  wg_sku_item.item_code,
                  wg_sku_item.item_name,
                  count( wg_sku_weight_data.sku_amount ) AS count_unit,
                  sum( wg_sku_weight_data.sku_weight ) AS sum_weight 
                  FROM
                  wg_sku_item
                  LEFT JOIN ( SELECT wg_sku_weight_data.* FROM wg_sku_weight_data 
                              WHERE wg_sku_weight_data.lot_number IN ($cutting_number,$offal_number)
                              AND wg_sku_weight_data.weighing_type IN (2,12) )
                  AS wg_sku_weight_data ON wg_sku_item.item_code = REPLACE(wg_sku_weight_data.sku_code, ' ', '') 
                  WHERE
                  wg_sku_item.group_show_report IN (3) 
                  GROUP BY
                  wg_sku_item.item_code 
                  ORDER BY
                  wg_sku_item.item_code ASC"
            );
            // น้ำหนักจากโรงงาน หััวชุด
            $select_item_head_main = DB::select("SELECT
                  wg_sku_item.item_code,
                  wg_sku_item.item_name,
                  count( wg_sku_weight_data.sku_amount ) AS count_unit,
                  sum( wg_sku_weight_data.sku_weight ) AS sum_weight 
                  FROM
                  wg_sku_item
                  LEFT JOIN ( SELECT wg_sku_weight_data.* FROM wg_sku_weight_data 
                              WHERE wg_sku_weight_data.lot_number IN ($cutting_number,$offal_number)
                              AND wg_sku_weight_data.weighing_type IN (2,12) )
                  AS wg_sku_weight_data ON wg_sku_item.item_code = REPLACE(wg_sku_weight_data.sku_code, ' ', '') 
                  WHERE
                  wg_sku_item.group_show_report IN (4) 
                  GROUP BY
                  wg_sku_item.item_code 
                  ORDER BY
                  wg_sku_item.item_code ASC"
            );

            // นับจำนวน เพื่อวนเมื่อเกิน10
            $rowspan_count_item = DB::select("SELECT
                        COUNT( wg_sku_weight_data.id ) AS count_id,
                        REPLACE(wg_sku_weight_data.sku_code, ' ', '')
                      FROM
                        wg_sku_weight_data
                        LEFT JOIN wg_sku_item ON REPLACE(wg_sku_weight_data.sku_code, ' ', '') = wg_sku_item.item_code 
                      WHERE
                        wg_sku_weight_data.lot_number IN ($cutting_number,$offal_number)
                        AND wg_sku_weight_data.weighing_type IN (2,12) 
                      GROUP BY
                        REPLACE(wg_sku_weight_data.sku_code, ' ', '')"
            );                                                
            $select_weight_in_order = DB::select("SELECT
                        wg_sku_weight_data.*
                      FROM
                        wg_sku_weight_data
                        LEFT JOIN wg_sku_item ON REPLACE(wg_sku_weight_data.sku_code, ' ', '') = wg_sku_item.item_code 
                      WHERE
                        wg_sku_weight_data.lot_number IN ($cutting_number)
                        AND wg_sku_weight_data.weighing_type IN (2,12)
                        AND wg_sku_item.group_show_report IN (1) 
            ");
            $select_weight_in_order_offal = DB::select("SELECT
                      wg_sku_weight_data.*
                      FROM
                      wg_sku_weight_data
                      LEFT JOIN wg_sku_item ON REPLACE(wg_sku_weight_data.sku_code, ' ', '') = wg_sku_item.item_code 
                      WHERE
                      wg_sku_weight_data.lot_number IN ($offal_number)
                      AND wg_sku_weight_data.weighing_type IN (2,12)
                      AND wg_sku_item.group_show_report IN (2) 
            ");
            $select_weight_in_order_tf = DB::select("SELECT
                      wg_sku_weight_data.*
                      FROM
                      wg_sku_weight_data
                      LEFT JOIN wg_sku_item ON REPLACE(wg_sku_weight_data.sku_code, ' ', '') = wg_sku_item.item_code 
                      WHERE
                      wg_sku_weight_data.lot_number IN ($cutting_number,$offal_number)
                      AND wg_sku_weight_data.weighing_type IN (2,12)
                      AND wg_sku_item.group_show_report IN (3) 
            ");
            $select_weight_in_order_head = DB::select("SELECT
                      wg_sku_weight_data.*
                      FROM
                      wg_sku_weight_data
                      LEFT JOIN wg_sku_item ON REPLACE(wg_sku_weight_data.sku_code, ' ', '') = wg_sku_item.item_code 
                      WHERE
                      wg_sku_weight_data.lot_number IN ($cutting_number,$offal_number)
                      AND wg_sku_weight_data.weighing_type IN (2,12)
                      AND wg_sku_item.group_show_report IN (4) 
            ");

      }else{
        // น้ำหนักจากโรงงาน ตัดแต่ง 

            $select_item_main = DB::select("SELECT
              wg_sku_item.item_code,
              wg_sku_item.item_name,
              count( wg_sku_weight_data.sku_amount ) AS count_unit,
              sum( wg_sku_weight_data.sku_weight ) AS sum_weight 
            FROM
              wg_sku_item
              LEFT JOIN ( SELECT wg_sku_weight_data.* FROM wg_sku_weight_data 
                            WHERE wg_sku_weight_data.lot_number IN ('$cutting_number')
                            AND wg_sku_weight_data.weighing_type IN (2) )
              AS wg_sku_weight_data ON wg_sku_item.item_code = REPLACE(wg_sku_weight_data.sku_code, ' ', '') 
            WHERE
              wg_sku_item.wg_sku_id IN (3, 7, 6, 9, 30 ) 
            GROUP BY
              wg_sku_item.item_code 
            ORDER BY
              wg_sku_item.item_code ASC");



        // น้ำหนักจากโรงงาน เครื่องใน
          $select_item_offal_main = DB::select("SELECT
            wg_sku_item.item_code,
            wg_sku_item.item_name,
            count( wg_sku_weight_data.sku_amount ) AS count_unit,
            sum( wg_sku_weight_data.sku_weight ) AS sum_weight 
            FROM
            wg_sku_item
            LEFT JOIN ( SELECT wg_sku_weight_data.* FROM wg_sku_weight_data 
                        WHERE wg_sku_weight_data.lot_number IN ('$offal_number')
                        AND wg_sku_weight_data.weighing_type IN (2) )
            AS wg_sku_weight_data ON wg_sku_item.item_code = REPLACE(wg_sku_weight_data.sku_code, ' ', '') 
            WHERE
            wg_sku_item.wg_sku_id IN (4,5) 
            GROUP BY
            wg_sku_item.item_code 
            ORDER BY
            wg_sku_item.item_code ASC");


        // นับจำนวน เพื่อวนเมื่อเกิน10
          $rowspan_count_item = DB::select("SELECT
              COUNT( wg_sku_weight_data.id ) AS count_id,
              REPLACE(wg_sku_weight_data.sku_code, ' ', '')
            FROM
              wg_sku_weight_data
              LEFT JOIN wg_sku_item ON REPLACE(wg_sku_weight_data.sku_code, ' ', '') = wg_sku_item.item_code 
            WHERE
              wg_sku_weight_data.lot_number IN ('$cutting_number','$offal_number')
              AND wg_sku_weight_data.weighing_type IN (2) 
            GROUP BY
              REPLACE(wg_sku_weight_data.sku_code, ' ', '')");

                                      
          $select_weight_in_order = DB::select("SELECT
                wg_sku_weight_data.*
              FROM
                wg_sku_weight_data
                LEFT JOIN wg_sku_item ON REPLACE(wg_sku_weight_data.sku_code, ' ', '') = wg_sku_item.item_code 
              WHERE
                wg_sku_weight_data.lot_number IN ('$cutting_number')
                AND wg_sku_weight_data.weighing_type IN (2)
                AND wg_sku_item.wg_sku_id IN (3, 7, 6, 9,30 ) 
              ");

          $select_weight_in_order_offal = DB::select("SELECT
            wg_sku_weight_data.*
            FROM
            wg_sku_weight_data
            LEFT JOIN wg_sku_item ON REPLACE(wg_sku_weight_data.sku_code, ' ', '') = wg_sku_item.item_code 
            WHERE
            wg_sku_weight_data.lot_number IN ('$offal_number')
            AND wg_sku_weight_data.weighing_type IN (2)
              AND wg_sku_item.wg_sku_id IN ( 4,5 ) 
            ");
      }
                            
        $report_transport_check = DB::select("SELECT * FROM `tb_report_transport_check` WHERE order_number = '$order_number'");

        // master เพิ่ม แก้ไขรายการน้ำหนัก
        $wg_scale = DB::select("SELECT * from wg_scale WHERE wg_scale.location_type = 'โรงงาน' ");
        $wg_scale_shop = DB::select("SELECT * from wg_scale WHERE wg_scale.location_type = 'ร้านค้า' ");
        $wg_weight_type = DB::select("SELECT * from wg_weight_type");
        $wg_sku = DB::select("SELECT * from wg_sku");
        $wg_storage = DB::select("SELECT * from wg_storage");
              
        $order_recieve_number = DB::select("SELECT * from tb_order_cutting WHERE order_number IN ($cutting_number) ");
        $order_recieve = $order_recieve_number[0]->order_ref;


        return view('transport.new_transport.report_transport_pdf_load',compact('select_item_main','select_weight_in_order','rowspan_count_item','select_cutting_number','report_transport_check',
        'wg_scale','wg_scale_shop','wg_weight_type','wg_sku','wg_storage','cutting_number',
        'offal_number','order_recieve','select_item_offal_main','select_weight_in_order_offal',
        'select_item_tf_main','select_item_head_main','select_weight_in_order_tf','select_weight_in_order_head'));
    }
}
