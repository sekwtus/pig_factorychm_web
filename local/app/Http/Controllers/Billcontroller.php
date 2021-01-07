<?php

namespace App\Http\Controllers;
//use Illuminate\Support\Facades\DB;
use App\DBbill;
use App\DBbillshow;
use Illuminate\Http\Request;
use DB;
use Redirect;
use DataTables;
use Auth;

class Billcontroller extends Controller
{
    public function getbill()
    {
        $listbill = DBbillshow::all();
        //return var_dump($listbill);
        // return $listsurvey;
       //return $listbill ;
       return view('bill.bill',compact('listbill'));
    }
    public function updatebill(Request $request,$id)
    {
        // $sql = "UPDATE Bill SET Name = '$request->name',".
        // "Licenseplate = '$request->car',IDP = '$request->IDP',totalweigth = '$request->totalweigth',factory = '$request->R4',billNo = '$request->billno',carweigth = '$request->carweigth',Lot = '$request->lot' WHERE ID = $id";
        // return DB::update($sql);
        DBbill::updateedit($request,$id);
        return redirect('/bill');
        
    }
    public function addbill()
    {
        return view('bill.bill-add');
    }
    
    public function insertbill(Request $request)
    {
        DBbill::insertbill($request);

        return redirect('/bill');
    }
    public function deletebill($id)
    {
        DB::delete("DELETE FROM Bill WHERE ID = $id",[]);

        return redirect('/bill');
    }

    public function bill_iv(){
        $date = substr(now(),8,2).'/'.substr(now(),5,2).'/'.substr(now(),0,4);

        $oder = DB::SELECT("SELECT
                                tb_order.id,
                                tb_order.order_number,
                                tb_order.date,
                                tb_order.id_user_customer
                            FROM
                                tb_order
                                LEFT JOIN users AS customer ON tb_order.id_user_customer = customer.id
                                LEFT JOIN users AS provider ON tb_order.id_user_provider = provider.id
                                LEFT JOIN users AS sender ON tb_order.id_user_sender = sender.id
                                LEFT JOIN users AS recieve ON tb_order.id_user_recieve = recieve.id
                                LEFT JOIN tb_order_type ON tb_order.type_request = tb_order_type.id
                                LEFT JOIN wg_storage ON tb_order.storage_id = wg_storage.id_storage
                            WHERE
                                tb_order.type_request <> 4 
                                AND ( tb_order.date = '$date' ) 
                                -- AND ( tb_order.date = '01/04/2020' ) 
                            GROUP BY
                                tb_order.order_number 
                            ORDER BY
                                tb_order.created_at DESC");
        
        $customer = DB::SELECT("SELECT  * FROM tb_customer ");
                             
        return view('bill.bill_do', compact('oder', 'customer'));
    }

    
    public function get_order_bill_iv(Request $request){
        // return $request->id;
        $order = DB::SELECT("SELECT
                            acc_mk_dom.id,
                            acc_mk_dom.ivm_id,
                            acc_mk_dom.customer_name,
                            acc_mk_dom.ref
                            FROM
                            acc_mk_dom
                            WHERE
                            acc_mk_dom.status_bill IS NULL
                            AND acc_mk_dom.customer_id = '$request->id'");
        return $order;
    }

    public function get_order_bill(Request $request){
        $order = DB::SELECT("SELECT
                                tb_order.id,
                                tb_order.order_number,
                                tb_order.date,
                                tb_order.id_user_customer
                            FROM
                                tb_order
                                LEFT JOIN users AS customer ON tb_order.id_user_customer = customer.id
                                LEFT JOIN users AS provider ON tb_order.id_user_provider = provider.id
                                LEFT JOIN users AS sender ON tb_order.id_user_sender = sender.id
                                LEFT JOIN users AS recieve ON tb_order.id_user_recieve = recieve.id
                                LEFT JOIN tb_order_type ON tb_order.type_request = tb_order_type.id
                                LEFT JOIN wg_storage ON tb_order.storage_id = wg_storage.id_storage
                            WHERE
                                tb_order.type_request <> 4 
                                AND tb_order.status_bill IS NULL
                                AND ( tb_order.date = '$request->date' ) 
                                AND ( tb_order.customer_id =  $request->id)
                                -- AND ( tb_order.date = '01/04/2020' ) 
                            GROUP BY
                                tb_order.order_number 
                            ORDER BY
                                tb_order.created_at DESC");
        return $order;
    }

    // public function create_bill(Request $request){

    // }

    public function create_bill(Request $request){
        // return $request;
        $m = substr($request->date,3,2);
        
        $id = DB::SELECT("SELECT * FROM tb_run_number_bill WHERE tb_run_number_bill.type = 'p' AND DATE_FORMAT(tb_run_number_bill.created_at,'%m') = '$m'  ORDER BY tb_run_number_bill.created_at DESC  LIMIT 1");
        $id_s = DB::SELECT("SELECT * FROM tb_run_number_bill WHERE tb_run_number_bill.type = 's' AND DATE_FORMAT(tb_run_number_bill.created_at,'%m') = '$m' ORDER BY tb_run_number_bill.created_at DESC  LIMIT 1");
        $id_t = DB::SELECT("SELECT * FROM tb_run_number_bill WHERE tb_run_number_bill.type = 't' AND DATE_FORMAT(tb_run_number_bill.created_at,'%m') = '$m' ORDER BY tb_run_number_bill.created_at DESC  LIMIT 1");
        if($id == null){ 
            $bill_number = DB::SELECT("CALL CREATE_NUMBER_BILL_PIG(?,?)",[$request->date, 0]);
            // DB::INSERT("INSERT INTO tb_run_number_bill(tb_run_number_bill.number, tb_run_number_bill.run_number, tb_run_number_bill.type, tb_run_number_bill.created_at)
            //                                     VALUES(1,?,'p',now())",[$bill_number[0]->BILL_NUMBER]); 
        }else{
            $bill_number = DB::SELECT("CALL CREATE_NUMBER_BILL_PIG(?,?)",[$request->date, $id[0]->number]); 
            // DB::INSERT("INSERT INTO tb_run_number_bill(tb_run_number_bill.number, tb_run_number_bill.run_number, tb_run_number_bill.type, tb_run_number_bill.created_at)
            //                                     VALUES(?,?,'p',now())",[$bill_number[0]->number,$bill_number[0]->BILL_NUMBER]); 
        }

       
        if($id_s == null){ 
            $bill_number_s = DB::SELECT("CALL CREATE_NUMBER_BILL_SLICE(?,?)",[$request->date, 0]);
            // DB::INSERT("INSERT INTO tb_run_number_bill(tb_run_number_bill.number, tb_run_number_bill.run_number, tb_run_number_bill.type, tb_run_number_bill.created_at)
            //                                     VALUES(1,?,'p',now())",[$bill_number[0]->BILL_NUMBER]); 
        }else{
            $bill_number_s = DB::SELECT("CALL CREATE_NUMBER_BILL_SLICE(?,?)",[$request->date, $id_s[0]->number]); 
            // DB::INSERT("INSERT INTO tb_run_number_bill(tb_run_number_bill.number, tb_run_number_bill.run_number, tb_run_number_bill.type, tb_run_number_bill.created_at)
            //                                     VALUES(?,?,'p',now())",[$bill_number[0]->number,$bill_number[0]->BILL_NUMBER]); 
        }

        if($id_t == null){ 
            $bill_number_t = DB::SELECT("CALL CREATE_NUMBER_BILL_TRIM(?,?)",[$request->date, 0]);
            // DB::INSERT("INSERT INTO tb_run_number_bill(tb_run_number_bill.number, tb_run_number_bill.run_number, tb_run_number_bill.type, tb_run_number_bill.created_at)
            //                                     VALUES(1,?,'p',now())",[$bill_number[0]->BILL_NUMBER]); 
        }else{
            $bill_number_t = DB::SELECT("CALL CREATE_NUMBER_BILL_TRIM(?,?)",[$request->date, $id_t[0]->number]); 
            // DB::INSERT("INSERT INTO tb_run_number_bill(tb_run_number_bill.number, tb_run_number_bill.run_number, tb_run_number_bill.type, tb_run_number_bill.created_at)
            //                                     VALUES(?,?,'p',now())",[$bill_number[0]->number,$bill_number[0]->BILL_NUMBER]); 
        }
        // return $bill_number_t ;
        $customer = DB::SELECT("SELECT * FROM tb_customer WHERE tb_customer.id = '$request->customer'");

        $slice_price_total = 0;
        $cutting_price_total = 0;
        $deposit_price_total = 0;
        
        $customer_address = $customer[0]->address.' เลขที่'.$customer[0]->address_M.' ม.'.$customer[0]->address_Mnumber.' ซอย '.$customer[0]->address_lane.' ถนน '.$customer[0]->address_road.' ต.'.
                            $customer[0]->address_district.' อ.'.$customer[0]->address_city.' '.$customer[0]->province.' '.$customer[0]->postcode;
        
        $standard_price_m = DB::select("SELECT standard_price FROM standard_price WHERE standard_price.type = 'm' ORDER BY created_at DESC LIMIT 1 ");
        $standard_price_s = DB::select("SELECT standard_price FROM standard_price WHERE standard_price.type = 's' ORDER BY created_at DESC LIMIT 1 ");
        $standard_price_t = DB::select("SELECT standard_price FROM standard_price WHERE standard_price.type = 't' ORDER BY created_at DESC LIMIT 1 ");
        $standard_price_c = DB::select("SELECT standard_price FROM standard_price WHERE standard_price.type = 'c' ORDER BY created_at DESC LIMIT 1 ");
        $standard_price_5 = DB::select("SELECT standard_price FROM standard_price WHERE standard_price.type = '5' ORDER BY created_at DESC LIMIT 1 ");
        $standard_price_f = DB::select("SELECT standard_price FROM standard_price WHERE standard_price.type = 'f' ORDER BY created_at DESC LIMIT 1 ");
        $standard_price_mt = DB::select("SELECT standard_price FROM standard_price WHERE standard_price.type = 'mt' ORDER BY created_at DESC LIMIT 1 ");
        $standard_price_sc = DB::select("SELECT standard_price FROM standard_price WHERE standard_price.type = 'sc' ORDER BY created_at DESC LIMIT 1 ");
        $standard_price_d = DB::select("SELECT standard_price FROM standard_price WHERE standard_price.type = 'd' ORDER BY created_at DESC LIMIT 1 ");
        $standard_price_e = DB::select("SELECT standard_price FROM standard_price WHERE standard_price.type = 'e' ORDER BY created_at DESC LIMIT 1 ");
        
        $price_carcass = $standard_price_m[0]->standard_price+$standard_price_c[0]->standard_price ;
        // return $standard_price_m[0]->standard_price;
        $total_price = 0;
        for( $i= 0 ; $i<count($request->order) ; $i++){
            
            $R = $request->order[$i];

            $type_pig = DB::select("SELECT
                                        tb_order.type_pig,
                                        standard_price_list_group.id,
                                        standard_price_list_group.price_list
                                    FROM
                                        tb_order
                                        INNER JOIN standard_price_list_group ON tb_order.type_pig = standard_price_list_group.id
                                    WHERE tb_order.order_number = ?",[$R]);
            $price_pig = DB::select("SELECT * FROM standard_prile_pig_customer WHERE standard_prile_pig_customer.id_customer = ?",[$customer[0]->customer_code]);
            // return $price_pig;

            $data[] = DB::select("SELECT
                                        wg_sku_weight_data.lot_number,
                                        wg_sku_weight_data.sku_code,
                                        wg_sku_weight_data.sku_amount AS sum_amount,
                                        wg_sku_weight_data.sku_weight AS sum_weight,
                                        -- sum(wg_sku_weight_data.sku_amount) AS sum_amount,
                                        -- sum(wg_sku_weight_data.sku_weight) AS sum_weight,
                                        wg_sku_weight_data.scale_number,
                                        wg_sku_weight_data.weighing_date,
                                        tb_order.weight_range,
                                        wg_sku_item.item_name,
                                        tb_order.slice,
                                        tb_order.cutting,
                                        tb_order.deposit,
                                        standard_weight.id AS weighing_id
                                    FROM
                                        wg_sku_weight_data
                                        LEFT JOIN wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code
                                        LEFT JOIN tb_order ON wg_sku_weight_data.lot_number = tb_order.order_number
                                        LEFT JOIN standard_weight ON tb_order.weight_range = standard_weight.standard_period
                                    WHERE
                                        wg_sku_weight_data.lot_number = '$R'
                                        AND wg_sku_weight_data.scale_number IN ('KMK01', 'KMK02')");
            $weight_range = DB::select("SELECT
                                            standard_weight.id,
                                            standard_weight.standard_period,
                                            standard_weight.standard_price_m,
                                            standard_weight.type,
                                            standard_weight.standard_price_5,
                                            standard_weight.standard_price_e,
                                            standard_weight.standard_price_f,
                                            standard_weight.standard_price_mt,
                                            standard_weight.standard_price_sc,
                                            standard_weight.standard_price_d,
                                            type_order_bill.type_name,
                                            type_order_bill.pig_life1,
                                            type_order_bill.pig_carcass1,
                                            type_order_bill.pig_slice1,
                                            type_order_bill.pig_trim1,
                                            type_order_bill.pig_life2,
                                            type_order_bill.pig_carcass2,
                                            type_order_bill.pig_slice2,
                                            type_order_bill.pig_trim2
                                        FROM
                                            tb_order
                                            LEFT JOIN standard_weight ON tb_order.weight_range = standard_weight.standard_period
                                            LEFT JOIN type_order_bill ON tb_order.id_type_order_bill = type_order_bill.id
                                        WHERE
                                            tb_order.order_number = '$R' ");
            
            $weight_range_rel = DB::select("SELECT standard_weight.standard_period,standard_weight.min ,standard_weight.max FROM standard_weight");

            $pig = 0;
            $slice = 0;
            $trim = 0;
            $carcass = 0;
            $wg = 0;
            for($j = 0 ; $j < count($data[$i]) ; $j++ ){

                for( $k = 0 ; $k < count($weight_range_rel) ; $k++){
                    if( ($data[$i][$j]->sum_weight >= $weight_range_rel[$k]->min) && ($data[$i][$j]->sum_weight <= $weight_range_rel[$k]->max) ){
                        $wg = $weight_range_rel[$k]->standard_period;
                    }
                }

                if($weight_range[0]->pig_life1 == 1){
                    $detail = '';
                    $price_kg = 0;
                    $pig++;
                    $price_carcass = $price_carcass + $price_pig[0]->carcass;
                    if($type_pig[0]->price_list == 'สุกรขุน'){
                        $price_kg = $price_pig[0]->fattening + $standard_price_m[0]->standard_price+$weight_range[0]->standard_price_m;
                        $detail = 'ค่าสุกรขุน นน. '.$wg.' กก.';
                    }
                    if($type_pig[0]->price_list == 'สุกร5เล็บ'){
                        $price_kg = $price_pig[0]->pig_5+$standard_price_5[0]->standard_price+$weight_range[0]->standard_price_5;
                        $detail = 'ค่าสุกร5เล็บ นน. '.$wg.' กก.';
                    }
                    if($type_pig[0]->price_list == 'สุกรไข่'){
                        $price_kg = $price_pig[0]->pig_egg+$standard_price_e[0]->standard_price+$weight_range[0]->standard_price_e;
                        $detail = 'ค่าสุกรไข่ นน. '.$wg.' กก.';
                    }
                    if($type_pig[0]->price_list == 'พ่อพันธุ์'){
                        $price_kg = $price_pig[0]->father+$standard_price_f[0]->standard_price+$weight_range[0]->standard_price_f;
                        $detail = 'ค่าพ่อพันธุ์ นน. '.$wg.' กก.';
                    }
                    if($type_pig[0]->price_list == 'แม่พันธุ์'){
                        $price_kg = $price_pig[0]->mother+$standard_price_mt[0]->standard_price+$weight_range[0]->standard_price_mt;
                        $detail = 'ค่าแม่พันธุ์ นน. '.$wg.' กก.';
                    }
                    if($type_pig[0]->price_list == 'หมูซาก'){
                        $price_kg = $price_pig[0]->carcass+$standard_price_c[0]->standard_price+$weight_range[0]->standard_price_sc;
                        $detail = 'ค่าหมูซาก นน. '.$wg.' กก.';
                    }
                    if($type_pig[0]->price_list == 'หมูตาย'){
                        $price_kg = $price_pig[0]->dead_pig+$standard_price_d[0]->standard_price+$weight_range[0]->standard_price_d;
                        $detail = 'ค่าหมูตาย นน. '.$wg.' กก.';
                    }
                    DB::INSERT("INSERT INTO acc_mk_dol(acc_mk_dol.ivm_id, acc_mk_dol.detail, acc_mk_dol.quantity, acc_mk_dol.amount, acc_mk_dol.unit, 
                                                acc_mk_dol.prict_unit, acc_mk_dol.ref,acc_mk_dol.slice,acc_mk_dol.cutting,acc_mk_dol.deposit,acc_mk_dol.weight_total,acc_mk_dol.status) 
                                                VALUES(?,?,?,?,?,?,?,?,?,?,?,'p')",[$bill_number[0]->BILL_NUMBER, $detail, $data[$i][$j]->sum_amount, ($data[$i][$j]->sum_weight * $price_kg),
                                                                       'Kg.',   $price_kg, $R, $slice_price_total,  $cutting_price_total, $deposit_price_total, $data[$i][$j]->sum_weight]);
                                                                       $total_price = $total_price+($data[$i][$j]->sum_weight * $price_kg);
                }
                if($weight_range[0]->pig_life2 == 1){
                    $detail = '';
                    $price_kg = 0;
                    $pig++;
                    $price_carcass = $price_carcass + $price_pig[0]->carcass;
                    if($type_pig[0]->price_list == 'สุกรขุน'){
                        $price_kg = $price_pig[0]->fattening + $standard_price_m[0]->standard_price+$weight_range[0]->standard_price_m;
                        $detail = 'ค่าสุกรขุน นน. '.$wg.' กก.';
                    }
                    if($type_pig[0]->price_list == 'สุกร5เล็บ'){
                        $price_kg = $price_pig[0]->pig_5+$standard_price_5[0]->standard_price+$weight_range[0]->standard_price_5;
                        $detail = 'ค่าสุกร5เล็บ นน. '.$wg.' กก.';
                    }
                    if($type_pig[0]->price_list == 'สุกรไข่'){
                        $price_kg = $price_pig[0]->pig_egg+$standard_price_e[0]->standard_price+$weight_range[0]->standard_price_e;
                        $detail = 'ค่าสุกรไข่ นน. '.$wg.' กก.';
                    }
                    if($type_pig[0]->price_list == 'พ่อพันธุ์'){
                        $price_kg = $price_pig[0]->father+$standard_price_f[0]->standard_price+$weight_range[0]->standard_price_f;
                        $detail = 'ค่าพ่อพันธุ์ นน. '.$wg.' กก.';
                    }
                    if($type_pig[0]->price_list == 'แม่พันธุ์'){
                        $price_kg = $price_pig[0]->mother+$standard_price_mt[0]->standard_price+$weight_range[0]->standard_price_mt;
                        $detail = 'ค่าแม่พันธุ์ นน. '.$wg.' กก.';
                    }
                    if($type_pig[0]->price_list == 'หมูซาก'){
                        $price_kg = $price_pig[0]->carcass+$standard_price_c[0]->standard_price+$weight_range[0]->standard_price_sc;
                        $detail = 'ค่าหมูซาก นน. '.$wg.' กก.';
                    }
                    if($type_pig[0]->price_list == 'หมูตาย'){
                        $price_kg = $price_pig[0]->dead_pig+$standard_price_d[0]->standard_price+$weight_range[0]->standard_price_d;
                        $detail = 'ค่าหมูตาย นน. '.$wg.' กก.';
                    }
                    DB::INSERT("INSERT INTO acc_kmk_ivl(acc_kmk_ivl.ivm_id, acc_kmk_ivl.detail, acc_kmk_ivl.quantity, acc_kmk_ivl.amount, acc_kmk_ivl.unit, 
                                                acc_kmk_ivl.prict_unit, acc_kmk_ivl.ref,acc_kmk_ivl.slice,acc_kmk_ivl.cutting,acc_kmk_ivl.deposit,acc_kmk_ivl.weight_total,acc_kmk_ivl.status) 
                                                VALUES(?,?,?,?,?,?,?,?,?,?,?,'p')",[$bill_number[0]->BILL_NUMBER, $detail, $data[$i][$j]->sum_amount, ($data[$i][$j]->sum_weight * $price_kg),
                                                                       'Kg.',   $price_kg, $R, $slice_price_total,  $cutting_price_total, $deposit_price_total, $data[$i][$j]->sum_weight]);
                                                                       $total_price = $total_price+($data[$i][$j]->sum_weight * $price_kg);
                }
                if($weight_range[0]->pig_carcass1 == 1){
                    $detail = '';
                    $carcass++;
                    $detail = 'ค่าซาก นน. '.$data[$i][$j]->sum_weight.' กก.';
                    $price_kg = $price_pig[0]->carcass+$standard_price_sc[0]->standard_price+$weight_range[0]->standard_price_sc;
                    DB::INSERT("INSERT INTO acc_mk_dol(acc_mk_dol.ivm_id, acc_mk_dol.detail, acc_mk_dol.quantity, acc_mk_dol.amount, acc_mk_dol.unit, 
                    acc_mk_dol.prict_unit, acc_mk_dol.ref,acc_mk_dol.slice,acc_mk_dol.cutting,acc_mk_dol.deposit,acc_mk_dol.weight_total,acc_mk_dol.status) 
                    VALUES(?,?,?,?,?,?,?,?,?,?,?,'sc')",[$bill_number[0]->BILL_NUMBER, $detail, $data[$i][$j]->sum_amount, ($data[$i][$j]->sum_weight * $price_kg),
                                           'Kg.',   $price_kg, $R, $slice_price_total,  $cutting_price_total, $deposit_price_total, $data[$i][$j]->sum_weight]);
                                           $total_price = $total_price+($data[$i][$j]->sum_weight * $price_kg);
                }
                if($weight_range[0]->pig_carcass2 == 1){
                    $detail = '';
                    $carcass++;
                    $detail = 'ค่าซาก นน. '.$data[$i][$j]->sum_weight.' กก.';
                    $price_kg = $price_pig[0]->carcass+$standard_price_sc[0]->standard_price+$weight_range[0]->standard_price_sc;
                    DB::INSERT("INSERT INTO acc_kmk_ivl(acc_kmk_ivl.ivm_id, acc_kmk_ivl.detail, acc_kmk_ivl.quantity, acc_kmk_ivl.amount, acc_kmk_ivl.unit, 
                    acc_kmk_ivl.prict_unit, acc_kmk_ivl.ref,acc_kmk_ivl.slice,acc_kmk_ivl.cutting,acc_kmk_ivl.deposit,acc_kmk_ivl.weight_total,acc_kmk_ivl.status) 
                    VALUES(?,?,?,?,?,?,?,?,?,?,?,'sc')",[$bill_number[0]->BILL_NUMBER, $detail, $data[$i][$j]->sum_weight, ($data[$i][$j]->sum_weight * $price_kg),
                                           'Kg.',   $price_kg, $R, $slice_price_total,  $cutting_price_total, $deposit_price_total, $data[$i][$j]->sum_weight]);
                                           $total_price = $total_price+($data[$i][$j]->sum_weight * $price_kg);
                }
                if($weight_range[0]->pig_slice1 == 1){
                    $detail = '';
                    $slice++;
                    $detail = 'ค่าเชือด นน. '.$wg.' กก.';
                    $price_kg = $price_pig[0]->slice+$standard_price_s[0]->standard_price;
                    DB::INSERT("INSERT INTO acc_mk_dol(acc_mk_dol.ivm_id, acc_mk_dol.detail, acc_mk_dol.quantity, acc_mk_dol.amount, acc_mk_dol.unit, 
                    acc_mk_dol.prict_unit, acc_mk_dol.ref,acc_mk_dol.slice,acc_mk_dol.cutting,acc_mk_dol.deposit,acc_mk_dol.weight_total,acc_mk_dol.status) 
                    VALUES(?,?,?,?,?,?,?,?,?,?,?,'s')",[$bill_number_s[0]->BILL_NUMBER, $detail, $data[$i][$j]->sum_amount, ($data[$i][$j]->sum_amount * $price_kg),
                                           'Kg.',   $price_kg, $R, $slice_price_total,  $cutting_price_total, $deposit_price_total, $data[$i][$j]->sum_weight]);
                                           $total_price = $total_price+($data[$i][$j]->sum_amount * $price_kg);
                }
                if($weight_range[0]->pig_slice2 == 1){
                    $detail = '';
                    $slice++;
                    $detail = 'ค่าเชือด นน. '.$wg.' กก.';
                    $price_kg = $price_pig[0]->slice+$standard_price_s[0]->standard_price;
                    DB::INSERT("INSERT INTO acc_kmk_ivl(acc_kmk_ivl.ivm_id, acc_kmk_ivl.detail, acc_kmk_ivl.quantity, acc_kmk_ivl.amount, acc_kmk_ivl.unit, 
                    acc_kmk_ivl.prict_unit, acc_kmk_ivl.ref,acc_kmk_ivl.slice,acc_kmk_ivl.cutting,acc_kmk_ivl.deposit,acc_kmk_ivl.weight_total,acc_kmk_ivl.status) 
                    VALUES(?,?,?,?,?,?,?,?,?,?,?,'s')",[$bill_number_s[0]->BILL_NUMBER, $detail, $data[$i][$j]->sum_amount, ($data[$i][$j]->sum_amount * $price_kg),
                                           'Kg.',   $price_kg, $R, $slice_price_total,  $cutting_price_total, $deposit_price_total, $data[$i][$j]->sum_weight]);
                                           $total_price = $total_price+($data[$i][$j]->sum_amount * $price_kg);
                }
                if($weight_range[0]->pig_trim1 == 1){
                    $detail = '';
                    $trim++;
                    $detail = 'ค่าตัดแต่ง นน. '.$wg.' กก.';
                    $price_kg = $price_pig[0]->trim+$standard_price_t[0]->standard_price;
                    DB::INSERT("INSERT INTO acc_mk_dol(acc_mk_dol.ivm_id, acc_mk_dol.detail, acc_mk_dol.quantity, acc_mk_dol.amount, acc_mk_dol.unit, 
                    acc_mk_dol.prict_unit, acc_mk_dol.ref,acc_mk_dol.slice,acc_mk_dol.cutting,acc_mk_dol.deposit,acc_mk_dol.weight_total,acc_mk_dol.status) 
                    VALUES(?,?,?,?,?,?,?,?,?,?,?,'t')",[$bill_number_t[0]->BILL_NUMBER, $detail, $data[$i][$j]->sum_amount, ($data[$i][$j]->sum_amount * $price_kg),
                                           'Kg.',   $price_kg, $R, $slice_price_total,  $cutting_price_total, $deposit_price_total, $data[$i][$j]->sum_weight]);
                                           $total_price = $total_price+($data[$i][$j]->sum_amount * $price_kg);
                }
                if($weight_range[0]->pig_trim2 == 1){
                    $detail = '';
                    $trim++;
                    $detail = 'ค่าตัดแต่ง นน. '.$wg.' กก.';
                    $price_kg = $price_pig[0]->trim+$standard_price_t[0]->standard_price;
                    DB::INSERT("INSERT INTO acc_kmk_ivl(acc_kmk_ivl.ivm_id, acc_kmk_ivl.detail, acc_kmk_ivl.quantity, acc_kmk_ivl.amount, acc_kmk_ivl.unit, 
                    acc_kmk_ivl.prict_unit, acc_kmk_ivl.ref,acc_kmk_ivl.slice,acc_kmk_ivl.cutting,acc_kmk_ivl.deposit,acc_kmk_ivl.weight_total,acc_kmk_ivl.status) 
                    VALUES(?,?,?,?,?,?,?,?,?,?,?,'t')",[$bill_number_t[0]->BILL_NUMBER, $detail, $data[$i][$j]->sum_amount, ($data[$i][$j]->sum_amount * $price_kg),
                                           'Kg.',   $price_kg, $R, $slice_price_total,  $cutting_price_total, $deposit_price_total, $data[$i][$j]->sum_weight]);
                                           $total_price = $total_price+($data[$i][$j]->sum_amount * $price_kg);
                }
                /////////////////////////////////////////////////////////////////

                
            }
        }
        if($pig > 0){
            DB::INSERT("INSERT INTO acc_mk_dom(acc_mk_dom.ivm_id, acc_mk_dom.date_bill, acc_mk_dom.customer_id, acc_mk_dom.customer_name,
                        acc_mk_dom.customer_adress, acc_mk_dom.customer_phone, acc_mk_dom.date_payment,acc_mk_dom.sub_total,acc_mk_dom.ref,acc_mk_dom.type)
                VALUES(?,?,?,?,?,?,?,?,?,?)",[$bill_number[0]->BILL_NUMBER, $request->date, $customer[0]->customer_code, $customer[0]->customer_name, 
                                        $customer_address, $customer[0]->phone_number, $request->date_payment, $total_price, $R, 'p']);
            DB::INSERT("INSERT INTO tb_run_number_bill(tb_run_number_bill.number, tb_run_number_bill.run_number, tb_run_number_bill.type, tb_run_number_bill.created_at)
                                                VALUES(?,?,'p',now())",[$bill_number[0]->number,$bill_number[0]->BILL_NUMBER]); 
        }
        if($carcass > 0){
            // DB::INSERT("INSERT INTO acc_mk_dom(acc_mk_dom.ivm_id, acc_mk_dom.date_bill, acc_mk_dom.customer_id, acc_mk_dom.customer_name,
            //             acc_mk_dom.customer_adress, acc_mk_dom.customer_phone, acc_mk_dom.date_payment,acc_mk_dom.sub_total,acc_mk_dom.ref)
            //     VALUES(?,?,?,?,?,?,?,?,?)",[$bill_number[0]->BILL_NUMBER, $request->date, $customer[0]->customer_code, $customer[0]->customer_name, 
            //                             $customer_address, $customer[0]->phone_number, $request->date_payment, $total_price, $R]);
        } 
        if($slice > 0){
            DB::INSERT("INSERT INTO acc_mk_dom(acc_mk_dom.ivm_id, acc_mk_dom.date_bill, acc_mk_dom.customer_id, acc_mk_dom.customer_name,
                        acc_mk_dom.customer_adress, acc_mk_dom.customer_phone, acc_mk_dom.date_payment,acc_mk_dom.sub_total,acc_mk_dom.ref,acc_mk_dom.type)
                VALUES(?,?,?,?,?,?,?,?,?,?)",[$bill_number_s[0]->BILL_NUMBER, $request->date, $customer[0]->customer_code, $customer[0]->customer_name, 
                                        $customer_address, $customer[0]->phone_number, $request->date_payment, $total_price, $R, 's']);
            DB::INSERT("INSERT INTO tb_run_number_bill(tb_run_number_bill.number, tb_run_number_bill.run_number, tb_run_number_bill.type, tb_run_number_bill.created_at)
                                                VALUES(?,?,'s',now())",[$bill_number_s[0]->number, $bill_number_s[0]->BILL_NUMBER]); 
        }
        if($trim > 0){
            DB::INSERT("INSERT INTO acc_mk_dom(acc_mk_dom.ivm_id, acc_mk_dom.date_bill, acc_mk_dom.customer_id, acc_mk_dom.customer_name,
                        acc_mk_dom.customer_adress, acc_mk_dom.customer_phone, acc_mk_dom.date_payment,acc_mk_dom.sub_total,acc_mk_dom.ref,acc_mk_dom.type)
                VALUES(?,?,?,?,?,?,?,?,?,?)",[$bill_number_t[0]->BILL_NUMBER, $request->date, $customer[0]->customer_code, $customer[0]->customer_name, 
                                        $customer_address, $customer[0]->phone_number, $request->date_payment, $total_price, $R, 't']);
            DB::INSERT("INSERT INTO tb_run_number_bill(tb_run_number_bill.number, tb_run_number_bill.run_number, tb_run_number_bill.type, tb_run_number_bill.created_at)
                                                VALUES(?,?,'t',now())",[$bill_number_t[0]->number, $bill_number_t[0]->BILL_NUMBER]); 
        }

        DB::UPDATE("UPDATE tb_order SET status_bill=?,do_number=? WHERE order_number = ?",["1",$bill_number, $R ]);
        // return $wg;
        // DB::INSERT("INSERT INTO acc_mk_dom(acc_mk_dom.ivm_id, acc_mk_dom.date_bill, acc_mk_dom.customer_id, acc_mk_dom.customer_name,
        //                         acc_mk_dom.customer_adress, acc_mk_dom.customer_phone, acc_mk_dom.date_payment,acc_mk_dom.sub_total,acc_mk_dom.ref)
        //                 VALUES(?,?,?,?,?,?,?,?,?)",[$bill_number[0]->BILL_NUMBER, $request->date, $customer[0]->customer_code, $customer[0]->customer_name, 
        //                                         $customer_address, $customer[0]->phone_number, $request->date_payment, $total_price, $R]);
        // return $price ;
        return Redirect::back();
    }

    public function create_bill_order(Request $request){
        // return $request;
        $m = substr($request->date,3,2);
        
        $id = DB::SELECT("SELECT * FROM tb_run_number_bill WHERE tb_run_number_bill.type = 'p' AND DATE_FORMAT(tb_run_number_bill.created_at,'%m') = '$m'  ORDER BY tb_run_number_bill.created_at DESC  LIMIT 1");
        $id_s = DB::SELECT("SELECT * FROM tb_run_number_bill WHERE tb_run_number_bill.type = 's' AND DATE_FORMAT(tb_run_number_bill.created_at,'%m') = '$m' ORDER BY tb_run_number_bill.created_at DESC  LIMIT 1");
        $id_t = DB::SELECT("SELECT * FROM tb_run_number_bill WHERE tb_run_number_bill.type = 't' AND DATE_FORMAT(tb_run_number_bill.created_at,'%m') = '$m' ORDER BY tb_run_number_bill.created_at DESC  LIMIT 1");

        if($id == null){ 
            $bill_number = DB::SELECT("CALL CREATE_NUMBER_BILL_PIG(?,?)",[$request->date, 0]);
            // DB::INSERT("INSERT INTO tb_run_number_bill(tb_run_number_bill.number, tb_run_number_bill.run_number, tb_run_number_bill.type, tb_run_number_bill.created_at)
            //                                     VALUES(1,?,'p',now())",[$bill_number[0]->BILL_NUMBER]); 
        }else{
            $bill_number = DB::SELECT("CALL CREATE_NUMBER_BILL_PIG(?,?)",[$request->date, $id[0]->number]); 
            // DB::INSERT("INSERT INTO tb_run_number_bill(tb_run_number_bill.number, tb_run_number_bill.run_number, tb_run_number_bill.type, tb_run_number_bill.created_at)
            //                                     VALUES(?,?,'p',now())",[$bill_number[0]->number,$bill_number[0]->BILL_NUMBER]); 
        }

        if($id_s == null){ 
            $bill_number_s = DB::SELECT("CALL CREATE_NUMBER_BILL_SLICE(?,?)",[$request->date, 0]);
            // DB::INSERT("INSERT INTO tb_run_number_bill(tb_run_number_bill.number, tb_run_number_bill.run_number, tb_run_number_bill.type, tb_run_number_bill.created_at)
            //                                     VALUES(1,?,'p',now())",[$bill_number[0]->BILL_NUMBER]); 
        }else{
            $bill_number_s = DB::SELECT("CALL CREATE_NUMBER_BILL_SLICE(?,?)",[$request->date, $id_s[0]->number]); 
            // DB::INSERT("INSERT INTO tb_run_number_bill(tb_run_number_bill.number, tb_run_number_bill.run_number, tb_run_number_bill.type, tb_run_number_bill.created_at)
            //                                     VALUES(?,?,'p',now())",[$bill_number[0]->number,$bill_number[0]->BILL_NUMBER]); 
        }

        if($id_t == null){ 
            $bill_number_t = DB::SELECT("CALL CREATE_NUMBER_BILL_TRIM(?,?)",[$request->date, 0]);
            // DB::INSERT("INSERT INTO tb_run_number_bill(tb_run_number_bill.number, tb_run_number_bill.run_number, tb_run_number_bill.type, tb_run_number_bill.created_at)
            //                                     VALUES(1,?,'p',now())",[$bill_number[0]->BILL_NUMBER]); 
        }else{
            $bill_number_t = DB::SELECT("CALL CREATE_NUMBER_BILL_TRIM(?,?)",[$request->date, $id_t[0]->number]); 
            // DB::INSERT("INSERT INTO tb_run_number_bill(tb_run_number_bill.number, tb_run_number_bill.run_number, tb_run_number_bill.type, tb_run_number_bill.created_at)
            //                                     VALUES(?,?,'p',now())",[$bill_number[0]->number,$bill_number[0]->BILL_NUMBER]); 
        }
        // return $bill_number_t ;
        $customer = DB::SELECT("SELECT * FROM tb_customer WHERE tb_customer.id = '$request->customer'");

        $slice_price_total = 0;
        $cutting_price_total = 0;
        $deposit_price_total = 0;
        
        $customer_address = $customer[0]->address.' เลขที่'.$customer[0]->address_M.' ม.'.$customer[0]->address_Mnumber.' ซอย '.$customer[0]->address_lane.' ถนน '.$customer[0]->address_road.' ต.'.
                            $customer[0]->address_district.' อ.'.$customer[0]->address_city.' '.$customer[0]->province.' '.$customer[0]->postcode;
        
        $standard_price_m = DB::select("SELECT standard_price FROM standard_price WHERE standard_price.type = 'm' ORDER BY created_at DESC LIMIT 1 ");
        $standard_price_s = DB::select("SELECT standard_price FROM standard_price WHERE standard_price.type = 's' ORDER BY created_at DESC LIMIT 1 ");
        $standard_price_t = DB::select("SELECT standard_price FROM standard_price WHERE standard_price.type = 't' ORDER BY created_at DESC LIMIT 1 ");
        $standard_price_c = DB::select("SELECT standard_price FROM standard_price WHERE standard_price.type = 'c' ORDER BY created_at DESC LIMIT 1 ");
        $standard_price_5 = DB::select("SELECT standard_price FROM standard_price WHERE standard_price.type = '5' ORDER BY created_at DESC LIMIT 1 ");
        $standard_price_f = DB::select("SELECT standard_price FROM standard_price WHERE standard_price.type = 'f' ORDER BY created_at DESC LIMIT 1 ");
        $standard_price_mt = DB::select("SELECT standard_price FROM standard_price WHERE standard_price.type = 'mt' ORDER BY created_at DESC LIMIT 1 ");
        $standard_price_sc = DB::select("SELECT standard_price FROM standard_price WHERE standard_price.type = 'sc' ORDER BY created_at DESC LIMIT 1 ");
        $standard_price_d = DB::select("SELECT standard_price FROM standard_price WHERE standard_price.type = 'd' ORDER BY created_at DESC LIMIT 1 ");
        $standard_price_e = DB::select("SELECT standard_price FROM standard_price WHERE standard_price.type = 'e' ORDER BY created_at DESC LIMIT 1 ");

        $standard_price_sx = DB::select("SELECT standard_price FROM standard_price WHERE standard_price.type = 'sx' ORDER BY created_at DESC LIMIT 1 ");
        $standard_price_sxt = DB::select("SELECT standard_price FROM standard_price WHERE standard_price.type = 'sxt' ORDER BY created_at DESC LIMIT 1 ");

        $standard_price_com = DB::select("SELECT standard_price FROM standard_price WHERE standard_price.type = 'com' ORDER BY created_at DESC LIMIT 1 ");
        
        $price_carcass = $standard_price_m[0]->standard_price+$standard_price_c[0]->standard_price ;
        // return $standard_price_m[0]->standard_price;
        $total_price = 0;
        for( $i= 0 ; $i<count($request->order) ; $i++){
            
            $R = $request->order[$i];

            $type_pig = DB::select("SELECT
                                        tb_order.type_pig,
                                        standard_price_list_group.id,
                                        standard_price_list_group.price_list
                                    FROM
                                        tb_order
                                        INNER JOIN standard_price_list_group ON tb_order.type_pig = standard_price_list_group.id
                                    WHERE tb_order.order_number = ?",[$R]);
            $price_pig = DB::select("SELECT * FROM standard_prile_pig_customer WHERE standard_prile_pig_customer.id_customer = ?",[$customer[0]->customer_code]);
            // return $price_pig;


            $weight_range = DB::select("SELECT
                                            standard_weight.id,
                                            standard_weight.standard_period,
                                            standard_weight.standard_price_m,
                                            standard_weight.type,
                                            standard_weight.standard_price_5,
                                            standard_weight.standard_price_e,
                                            standard_weight.standard_price_f,
                                            standard_weight.standard_price_mt,
                                            standard_weight.standard_price_sc,
                                            standard_weight.standard_price_d,
                                            type_order_bill.type_name,
                                            type_order_bill.pig_life1,
                                            type_order_bill.pig_carcass1,
                                            type_order_bill.pig_slice1,
                                            type_order_bill.pig_trim1,
                                            type_order_bill.pig_life2,
                                            type_order_bill.pig_carcass2,
                                            type_order_bill.pig_slice2,
                                            type_order_bill.pig_trim2,
                                            type_order_bill.pig_shipping
                                        FROM
                                            tb_order
                                            LEFT JOIN standard_weight ON tb_order.weight_range = standard_weight.standard_period
                                            LEFT JOIN type_order_bill ON tb_order.id_type_order_bill = type_order_bill.id
                                        WHERE
                                            tb_order.order_number = '$R' ");
            
            $weight_range_rel = DB::select("SELECT standard_weight.standard_period,standard_weight.min ,standard_weight.max FROM standard_weight");

            $pig = 0;
            $slice = 0;
            $trim = 0;
            $carcass = 0;
            $slice_x = 0;
            $trim_x = 0;
            $carcass_x = 0;
            $wg = 0;

            if(($weight_range[0]->pig_carcass1 == 1)||($weight_range[0]->pig_carcass2 == 1)){
                $data[] = DB::select("SELECT
                                    wg_sku_weight_data.lot_number,
                                    wg_sku_weight_data.sku_code,
                                    wg_sku_weight_data.sku_amount AS sum_amount,
                                    wg_sku_weight_data.sku_weight AS sum_weight,
                                    -- sum(wg_sku_weight_data.sku_amount) AS sum_amount,
                                    -- sum(wg_sku_weight_data.sku_weight) AS sum_weight,
                                    wg_sku_weight_data.scale_number,
                                    wg_sku_weight_data.weighing_date,
                                    tb_order.weight_range,
                                    wg_sku_item.item_name,
                                    tb_order.slice,
                                    tb_order.cutting,
                                    tb_order.deposit,
                                    standard_weight.id AS weighing_id
                                FROM
                                    wg_sku_weight_data
                                    LEFT JOIN wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code
                                    LEFT JOIN tb_order ON wg_sku_weight_data.lot_number = tb_order.order_number
                                    LEFT JOIN standard_weight ON tb_order.weight_range = standard_weight.standard_period
                                WHERE
                                
                                    wg_sku_weight_data.lot_number = (SELECT order_number FROM tb_order_overnight WHERE order_ref = '$R')
                                    AND wg_sku_weight_data.scale_number IN ('KMK12')");
                                

                for($j = 0 ; $j < count($data[$i]) ; $j++ ){

                    // ค่าซากตัวเอง
                    if($weight_range[0]->pig_carcass1 == 1){
                        $price_kg = 0;
                        $detail = '';
                        $carcass++;
                        $detail = 'ค่าซาก';
                        $price_kg = $price_pig[0]->carcass+$standard_price_sc[0]->standard_price+$weight_range[0]->standard_price_sc;
                        $amout = (float)($data[$i][$j]->sum_weight * $price_kg);
                        DB::INSERT("INSERT INTO acc_mk_dol(acc_mk_dol.ivm_id, acc_mk_dol.detail, acc_mk_dol.quantity, acc_mk_dol.amount, acc_mk_dol.unit, 
                        acc_mk_dol.prict_unit, acc_mk_dol.ref,acc_mk_dol.slice,acc_mk_dol.cutting,acc_mk_dol.deposit,acc_mk_dol.weight_total,acc_mk_dol.status) 
                        VALUES(?,?,?,?,?,?,?,?,?,?,?,'sc')",[$bill_number[0]->BILL_NUMBER, $detail, $data[$i][$j]->sum_amount, $amout,
                                            'Kg.',   $price_kg, $R, $slice_price_total,  $cutting_price_total, $deposit_price_total, $data[$i][$j]->sum_weight]);
                                            $total_price = $total_price+($data[$i][$j]->sum_weight * $price_kg);
                    }
                    // ค่าซากจากที่่อื่น
                    if($weight_range[0]->pig_carcass2 == 1){
                        $price_kg = 0;
                        $detail = '';
                        $carcass_x++;
                        $detail = 'ค่าซากที่อื่น';
                        $price_kg = $price_pig[0]->carcass+$standard_price_sc[0]->standard_price+$weight_range[0]->standard_price_sc;
                        DB::INSERT("INSERT INTO acc_mk_dol(acc_mk_dol.ivm_id, acc_mk_dol.detail, acc_mk_dol.quantity, acc_mk_dol.amount, acc_mk_dol.unit, 
                        acc_mk_dol.prict_unit, acc_mk_dol.ref,acc_mk_dol.slice,acc_mk_dol.cutting,acc_mk_dol.deposit,acc_mk_dol.weight_total,acc_mk_dol.status) 
                        VALUES(?,?,?,?,?,?,?,?,?,?,?,'scx')",[$bill_number[0]->BILL_NUMBER, $detail, $data[$i][$j]->sum_amount, ($data[$i][$j]->sum_weight * $price_kg),
                                            'Kg.',   $price_kg, $R, $slice_price_total,  $cutting_price_total, $deposit_price_total, $data[$i][$j]->sum_weight]);
                                            $total_price = $total_price+($data[$i][$j]->sum_weight * $price_kg);
                    }

                }//end for
            }else{

                $data[] = DB::select("SELECT
                                wg_sku_weight_data.lot_number,
                                wg_sku_weight_data.sku_code,
                                wg_sku_weight_data.sku_amount AS sum_amount,
                                wg_sku_weight_data.sku_weight AS sum_weight,
                                -- sum(wg_sku_weight_data.sku_amount) AS sum_amount,
                                -- sum(wg_sku_weight_data.sku_weight) AS sum_weight,
                                wg_sku_weight_data.scale_number,
                                wg_sku_weight_data.weighing_date,
                                tb_order.weight_range,
                                wg_sku_item.item_name,
                                tb_order.slice,
                                tb_order.cutting,
                                tb_order.deposit,
                                standard_weight.id AS weighing_id
                            FROM
                                wg_sku_weight_data
                                LEFT JOIN wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code
                                LEFT JOIN tb_order ON wg_sku_weight_data.lot_number = tb_order.order_number
                                LEFT JOIN standard_weight ON tb_order.weight_range = standard_weight.standard_period
                            WHERE
                                wg_sku_weight_data.lot_number = '$R'
                                AND wg_sku_weight_data.scale_number IN ('KMK01', 'KMK02')");

            for($j = 0 ; $j < count($data[$i]) ; $j++ ){

                for( $k = 0 ; $k < count($weight_range_rel) ; $k++){
                    if( ($data[$i][$j]->sum_weight >= $weight_range_rel[$k]->min) && ($data[$i][$j]->sum_weight <= $weight_range_rel[$k]->max) ){
                        $wg = $weight_range_rel[$k]->standard_period;
                    }
                }

                if($weight_range[0]->pig_life1 == 1){
                    $detail = '';
                    $price_kg = 0;
                    $pig++;
                    $price_carcass = $price_carcass + $price_pig[0]->carcass;
                    if($type_pig[0]->price_list == 'สุกรขุน'){
                        $price_kg = $price_pig[0]->fattening + $standard_price_m[0]->standard_price+$weight_range[0]->standard_price_m;
                        $detail = 'ค่าสุกรขุน นน. '.$wg.' กก.';
                    }
                    if($type_pig[0]->price_list == 'สุกร5เล็บ'){
                        $price_kg = $price_pig[0]->pig_5+$standard_price_5[0]->standard_price+$weight_range[0]->standard_price_5;
                        $detail = 'ค่าสุกร5เล็บ นน. '.$wg.' กก.';
                    }
                    if($type_pig[0]->price_list == 'สุกรไข่'){
                        $price_kg = $price_pig[0]->pig_egg+$standard_price_e[0]->standard_price+$weight_range[0]->standard_price_e;
                        $detail = 'ค่าสุกรไข่ นน. '.$wg.' กก.';
                    }
                    if($type_pig[0]->price_list == 'พ่อพันธุ์'){
                        $price_kg = $price_pig[0]->father+$standard_price_f[0]->standard_price+$weight_range[0]->standard_price_f;
                        $detail = 'ค่าพ่อพันธุ์ นน. '.$wg.' กก.';
                    }
                    if($type_pig[0]->price_list == 'แม่พันธุ์'){
                        $price_kg = $price_pig[0]->mother+$standard_price_mt[0]->standard_price+$weight_range[0]->standard_price_mt;
                        $detail = 'ค่าแม่พันธุ์ นน. '.$wg.' กก.';
                    }
                    if($type_pig[0]->price_list == 'หมูซาก'){
                        $price_kg = $price_pig[0]->carcass+$standard_price_c[0]->standard_price+$weight_range[0]->standard_price_sc;
                        $detail = 'ค่าหมูซาก นน. '.$wg.' กก.';
                    }
                    if($type_pig[0]->price_list == 'หมูตาย'){
                        $price_kg = $price_pig[0]->dead_pig+$standard_price_d[0]->standard_price+$weight_range[0]->standard_price_d;
                        $detail = 'ค่าหมูตาย นน. '.$wg.' กก.';
                    }
                    DB::INSERT("INSERT INTO acc_mk_dol(acc_mk_dol.ivm_id, acc_mk_dol.detail, acc_mk_dol.quantity, acc_mk_dol.amount, acc_mk_dol.unit, 
                                                acc_mk_dol.prict_unit, acc_mk_dol.price_com ,acc_mk_dol.ref,acc_mk_dol.slice,acc_mk_dol.cutting,acc_mk_dol.deposit,acc_mk_dol.weight_total,acc_mk_dol.status) 
                                                VALUES(?,?,?,?,?,?,?,?,?,?,?,?,'p')",[$bill_number[0]->BILL_NUMBER, $detail, $data[$i][$j]->sum_amount, ($data[$i][$j]->sum_weight * $price_kg),
                                                                       'Kg.',   $price_kg,$standard_price_com[0]->standard_price ,$R, $slice_price_total,  $cutting_price_total, $deposit_price_total, $data[$i][$j]->sum_weight]);
                                                                       $total_price = $total_price+($data[$i][$j]->sum_weight * $price_kg);
                }
                if($weight_range[0]->pig_life2 == 1){
                    $detail = '';
                    $price_kg = 0;
                    $pig++;
                    $price_carcass = $price_carcass + $price_pig[0]->carcass;
                    if($type_pig[0]->price_list == 'สุกรขุน'){
                        $price_kg = $price_pig[0]->fattening + $standard_price_m[0]->standard_price+$weight_range[0]->standard_price_m;
                        $detail = 'ค่าสุกรขุน นน. '.$wg.' กก.';
                    }
                    if($type_pig[0]->price_list == 'สุกร5เล็บ'){
                        $price_kg = $price_pig[0]->pig_5+$standard_price_5[0]->standard_price+$weight_range[0]->standard_price_5;
                        $detail = 'ค่าสุกร5เล็บ นน. '.$wg.' กก.';
                    }
                    if($type_pig[0]->price_list == 'สุกรไข่'){
                        $price_kg = $price_pig[0]->pig_egg+$standard_price_e[0]->standard_price+$weight_range[0]->standard_price_e;
                        $detail = 'ค่าสุกรไข่ นน. '.$wg.' กก.';
                    }
                    if($type_pig[0]->price_list == 'พ่อพันธุ์'){
                        $price_kg = $price_pig[0]->father+$standard_price_f[0]->standard_price+$weight_range[0]->standard_price_f;
                        $detail = 'ค่าพ่อพันธุ์ นน. '.$wg.' กก.';
                    }
                    if($type_pig[0]->price_list == 'แม่พันธุ์'){
                        $price_kg = $price_pig[0]->mother+$standard_price_mt[0]->standard_price+$weight_range[0]->standard_price_mt;
                        $detail = 'ค่าแม่พันธุ์ นน. '.$wg.' กก.';
                    }
                    if($type_pig[0]->price_list == 'หมูซาก'){
                        $price_kg = $price_pig[0]->carcass+$standard_price_c[0]->standard_price+$weight_range[0]->standard_price_sc;
                        $detail = 'ค่าหมูซาก นน. '.$wg.' กก.';
                    }
                    if($type_pig[0]->price_list == 'หมูตาย'){
                        $price_kg = $price_pig[0]->dead_pig+$standard_price_d[0]->standard_price+$weight_range[0]->standard_price_d;
                        $detail = 'ค่าหมูตาย นน. '.$wg.' กก.';
                    }
                    DB::INSERT("INSERT INTO acc_kmk_ivl(acc_kmk_ivl.ivm_id, acc_kmk_ivl.detail, acc_kmk_ivl.quantity, acc_kmk_ivl.amount, acc_kmk_ivl.unit, 
                                                acc_kmk_ivl.prict_unit, acc_mk_dol.price_com, acc_kmk_ivl.ref,acc_kmk_ivl.slice,acc_kmk_ivl.cutting,acc_kmk_ivl.deposit,acc_kmk_ivl.weight_total,acc_kmk_ivl.status) 
                                                VALUES(?,?,?,?,?,?,?,?,?,?,?,'p')",[$bill_number[0]->BILL_NUMBER, $detail, $data[$i][$j]->sum_amount, ($data[$i][$j]->sum_weight * $price_kg),
                                                                       'Kg.',   $price_kg, $standard_price_com[0]->standard_price, $R, $slice_price_total,  $cutting_price_total, $deposit_price_total, $data[$i][$j]->sum_weight]);
                                                                       $total_price = $total_price+($data[$i][$j]->sum_weight * $price_kg);
                }
               
                // เชื่อดเอง
                if($weight_range[0]->pig_slice1 == 1){
                    $price_kg = 0;
                    $detail = '';
                    $slice++;
                    $detail = 'ค่าเชือด';
                    $price_kg = $price_pig[0]->slice+$standard_price_s[0]->standard_price;
                    DB::INSERT("INSERT INTO acc_mk_dol(acc_mk_dol.ivm_id, acc_mk_dol.detail, acc_mk_dol.quantity, acc_mk_dol.amount, acc_mk_dol.unit, 
                    acc_mk_dol.prict_unit, acc_mk_dol.ref,acc_mk_dol.slice,acc_mk_dol.cutting,acc_mk_dol.deposit,acc_mk_dol.weight_total,acc_mk_dol.status) 
                    VALUES(?,?,?,?,?,?,?,?,?,?,?,'s')",[$bill_number_s[0]->BILL_NUMBER, $detail, $data[$i][$j]->sum_amount, ($data[$i][$j]->sum_amount * $price_kg),
                                           'Kg.',   $price_kg, $R, $slice_price_total,  $cutting_price_total, $deposit_price_total, $data[$i][$j]->sum_weight]);
                                           $total_price = $total_price+($data[$i][$j]->sum_amount * $price_kg);
                }
                // เชื่อดที่อื่น
                if($weight_range[0]->pig_slice2 == 1){
                    $price_kg = 0;
                    $price_tr = 0;
                    $detail = '';
                    $slice_x++;
                    $detail = 'ค่าเชือดที่อื่น';
                    $price_kg = $price_pig[0]->slice+$standard_price_sx[0]->standard_price;
                    if($weight_range[0]->pig_shipping == 1)
                        $price_tr = $price_pig[0]->slice+$standard_price_sxt[0]->standard_price;
                    else
                        $price_tr = '0';

                    DB::INSERT("INSERT INTO acc_mk_dol(acc_mk_dol.ivm_id, acc_mk_dol.detail, acc_mk_dol.quantity, acc_mk_dol.amount, acc_mk_dol.unit, 
                    acc_mk_dol.prict_unit, acc_mk_dol.ref,acc_mk_dol.slice,acc_mk_dol.cutting,acc_mk_dol.deposit,acc_mk_dol.weight_total,acc_mk_dol.status,acc_mk_dol.price_tr) 
                    VALUES(?,?,?,?,?,?,?,?,?,?,?,'sx',?)",[$bill_number_s[0]->BILL_NUMBER, $detail, $data[$i][$j]->sum_amount, ($data[$i][$j]->sum_amount * $price_kg),
                                           'Kg.',   $price_kg, $R, $slice_price_total,  $cutting_price_total, $deposit_price_total, $data[$i][$j]->sum_weight,$price_tr]);
                                           $total_price = $total_price+($data[$i][$j]->sum_amount * $price_kg);
                }

                // ตัดแต่งเอง
                if($weight_range[0]->pig_trim1 == 1){
                    $price_kg = 0;
                    $detail = '';
                    $trim++;
                    $detail = 'ค่าตัดแต่ง';
                    $price_kg = $price_pig[0]->trim+$standard_price_t[0]->standard_price;
                    DB::INSERT("INSERT INTO acc_mk_dol(acc_mk_dol.ivm_id, acc_mk_dol.detail, acc_mk_dol.quantity, acc_mk_dol.amount, acc_mk_dol.unit, 
                    acc_mk_dol.prict_unit, acc_mk_dol.ref,acc_mk_dol.slice,acc_mk_dol.cutting,acc_mk_dol.deposit,acc_mk_dol.weight_total,acc_mk_dol.status) 
                    VALUES(?,?,?,?,?,?,?,?,?,?,?,'t')",[$bill_number_t[0]->BILL_NUMBER, $detail, $data[$i][$j]->sum_amount, ($data[$i][$j]->sum_amount * $price_kg),
                                           'Kg.',   $price_kg, $R, $slice_price_total,  $cutting_price_total, $deposit_price_total, $data[$i][$j]->sum_weight]);
                                           $total_price = $total_price+($data[$i][$j]->sum_amount * $price_kg);
                }
                // ตัดแต่งที่อื่น 
                if($weight_range[0]->pig_trim2 == 1){
                    $price_kg = 0;
                    $detail = '';
                    $trim_x++;
                    $detail = 'ค่าตัดแต่งที่อื่น';
                    $price_kg = $price_pig[0]->trim+$standard_price_t[0]->standard_price;
                    DB::INSERT("INSERT INTO acc_mk_dol(acc_mk_dol.ivm_id, acc_mk_dol.detail, acc_mk_dol.quantity, acc_mk_dol.amount, acc_mk_dol.unit, 
                    acc_mk_dol.prict_unit, acc_mk_dol.ref,acc_mk_dol.slice,acc_mk_dol.cutting,acc_mk_dol.deposit,acc_mk_dol.weight_total,acc_mk_dol.status) 
                    VALUES(?,?,?,?,?,?,?,?,?,?,?,'tx')",[$bill_number_t[0]->BILL_NUMBER, $detail, $data[$i][$j]->sum_amount, ($data[$i][$j]->sum_amount * $price_kg),
                                           'Kg.',   $price_kg, $R, $slice_price_total,  $cutting_price_total, $deposit_price_total, $data[$i][$j]->sum_weight]);
                                           $total_price = $total_price+($data[$i][$j]->sum_amount * $price_kg);
                }
                /////////////////////////////////////////////////////////////////

                
            }
          } // end for else ซาก
        } // end for order
        $l = 0;
        if($pig > 0){
            DB::INSERT("INSERT INTO acc_mk_dom(acc_mk_dom.ivm_id, acc_mk_dom.date_bill, acc_mk_dom.customer_id, acc_mk_dom.customer_name,
                        acc_mk_dom.customer_adress, acc_mk_dom.customer_phone, acc_mk_dom.date_payment,acc_mk_dom.sub_total,acc_mk_dom.ref,acc_mk_dom.type)
                VALUES(?,?,?,?,?,?,?,?,?,?)",[$bill_number[0]->BILL_NUMBER, $request->date, $customer[0]->customer_code, $customer[0]->customer_name, 
                                        $customer_address, $customer[0]->phone_number, $request->date_payment, $total_price, $R, 'p']);
            DB::INSERT("INSERT INTO tb_run_number_bill(tb_run_number_bill.number, tb_run_number_bill.run_number, tb_run_number_bill.type, tb_run_number_bill.created_at)
                                                VALUES(?,?,'p',now())",[$bill_number[0]->number,$bill_number[0]->BILL_NUMBER]); 
            $order_create[$l++] = array("id" => $bill_number[0]->BILL_NUMBER, "type" => "p");
        }
        if($carcass > 0){

            DB::INSERT("INSERT INTO acc_mk_dom(acc_mk_dom.ivm_id, acc_mk_dom.date_bill, acc_mk_dom.customer_id, acc_mk_dom.customer_name,
                        acc_mk_dom.customer_adress, acc_mk_dom.customer_phone, acc_mk_dom.date_payment,acc_mk_dom.sub_total,acc_mk_dom.ref,acc_mk_dom.type)
                        VALUES(?,?,?,?,?,?,?,?,?,?)",[$bill_number[0]->BILL_NUMBER, $request->date, $customer[0]->customer_code, $customer[0]->customer_name, 
                                                      $customer_address, $customer[0]->phone_number, $request->date_payment, $total_price, $R, 'p']);
            DB::INSERT("INSERT INTO tb_run_number_bill(tb_run_number_bill.number, tb_run_number_bill.run_number, tb_run_number_bill.type, tb_run_number_bill.created_at)
                        VALUES(?,?,'p',now())",[$bill_number[0]->number,$bill_number[0]->BILL_NUMBER]); 

// $order_create[$l++] = array("id" => $bill_number[0]->BILL_NUMBER, "type" => "p");
//             DB::INSERT("INSERT INTO acc_mk_dom(acc_mk_dom.ivm_id, acc_mk_dom.date_bill, acc_mk_dom.customer_id, acc_mk_dom.customer_name,
//                         acc_mk_dom.customer_adress, acc_mk_dom.customer_phone, acc_mk_dom.date_payment,acc_mk_dom.sub_total,acc_mk_dom.ref)
//                 VALUES(?,?,?,?,?,?,?,?,?)",[$bill_number[0]->BILL_NUMBER, $request->date, $customer[0]->customer_code, $customer[0]->customer_name, 
//                                         $customer_address, $customer[0]->phone_number, $request->date_payment, $total_price, $R]);

            $order_create[$l++] = array("id" => $bill_number[0]->BILL_NUMBER, "type" => "p");
        } 
        if($slice > 0){
            DB::INSERT("INSERT INTO acc_cmk_dom(acc_cmk_dom.ivm_id, acc_cmk_dom.date_bill, acc_cmk_dom.customer_id, acc_cmk_dom.customer_name,
                        acc_cmk_dom.customer_adress, acc_cmk_dom.customer_phone, acc_cmk_dom.date_payment,acc_cmk_dom.sub_total,acc_cmk_dom.ref,acc_cmk_dom.type)
                VALUES(?,?,?,?,?,?,?,?,?,?)",[$bill_number_s[0]->BILL_NUMBER, $request->date, $customer[0]->customer_code, $customer[0]->customer_name, 
                                        $customer_address, $customer[0]->phone_number, $request->date_payment, $total_price, $R, 's']);
            DB::INSERT("INSERT INTO tb_run_number_bill(tb_run_number_bill.number, tb_run_number_bill.run_number, tb_run_number_bill.type, tb_run_number_bill.created_at)
                                                VALUES(?,?,'s',now())",[$bill_number_s[0]->number, $bill_number_s[0]->BILL_NUMBER]); 
            $order_create[$l++] = array("id" => $bill_number_s[0]->BILL_NUMBER, "type" => "s");
        }
        if($trim > 0){
            DB::INSERT("INSERT INTO acc_cmk_dom(acc_cmk_dom.ivm_id, acc_cmk_dom.date_bill, acc_cmk_dom.customer_id, acc_cmk_dom.customer_name,
                        acc_cmk_dom.customer_adress, acc_cmk_dom.customer_phone, acc_cmk_dom.date_payment,acc_cmk_dom.sub_total,acc_cmk_dom.ref,acc_cmk_dom.type)
                VALUES(?,?,?,?,?,?,?,?,?,?)",[$bill_number_t[0]->BILL_NUMBER, $request->date, $customer[0]->customer_code, $customer[0]->customer_name, 
                                        $customer_address, $customer[0]->phone_number, $request->date_payment, $total_price, $R, 't']);
            DB::INSERT("INSERT INTO tb_run_number_bill(tb_run_number_bill.number, tb_run_number_bill.run_number, tb_run_number_bill.type, tb_run_number_bill.created_at)
                                                VALUES(?,?,'t',now())",[$bill_number_t[0]->number, $bill_number_t[0]->BILL_NUMBER]); 
            $order_create[$l++] = array("id" => $bill_number_t[0]->BILL_NUMBER, "type" => "t");
        }

        DB::UPDATE("UPDATE tb_order SET status_bill=? , do_number = ? WHERE order_number = ?",["1",$bill_number[0]->BILL_NUMBER, $R]);
        // return $wg;
        // DB::INSERT("INSERT INTO acc_mk_dom(acc_mk_dom.ivm_id, acc_mk_dom.date_bill, acc_mk_dom.customer_id, acc_mk_dom.customer_name,
        //                         acc_mk_dom.customer_adress, acc_mk_dom.customer_phone, acc_mk_dom.date_payment,acc_mk_dom.sub_total,acc_mk_dom.ref)
        //                 VALUES(?,?,?,?,?,?,?,?,?)",[$bill_number[0]->BILL_NUMBER, $request->date, $customer[0]->customer_code, $customer[0]->customer_name, 
        //                                         $customer_address, $customer[0]->phone_number, $request->date_payment, $total_price, $R]);
        // return $order_create ;
        return $R ;
    }

    public function create_bill_iv(Request $request){
        $m = substr($request->date,3,2);
        // return $request;
        $id = DB::SELECT("SELECT * FROM tb_run_number_bill WHERE tb_run_number_bill.type = 'iv' AND DATE_FORMAT(tb_run_number_bill.created_at,'%m') = '$m' ORDER BY tb_run_number_bill.created_at DESC  LIMIT 1");
        if($id == null){ 
            $bill_number = DB::SELECT("CALL CREATE_NUMBER_BILL_IV(?,?)",[$request->date, 0]);
            // DB::INSERT("INSERT INTO tb_run_number_bill(tb_run_number_bill.number, tb_run_number_bill.run_number, tb_run_number_bill.type, tb_run_number_bill.created_at)
            //                                     VALUES(1,?,'p',now())",[$bill_number[0]->BILL_NUMBER]); 
        }else{
            $bill_number = DB::SELECT("CALL CREATE_NUMBER_BILL_IV(?,?)",[$request->date, $id[0]->number]); 
            // DB::INSERT("INSERT INTO tb_run_number_bill(tb_run_number_bill.number, tb_run_number_bill.run_number, tb_run_number_bill.type, tb_run_number_bill.created_at)
            //                                     VALUES(?,?,'p',now())",[$bill_number[0]->number,$bill_number[0]->BILL_NUMBER]); 
        }

        $customer = DB::SELECT("SELECT * FROM tb_customer WHERE tb_customer.customer_code = '$request->customer'");
        $customer_address = $customer[0]->address.' เลขที่'.$customer[0]->address_M.' ม.'.$customer[0]->address_Mnumber.' ซอย '.$customer[0]->address_lane.' ถนน '.$customer[0]->address_road.' ต.'.
                            $customer[0]->address_district.' อ.'.$customer[0]->address_city.' '.$customer[0]->province.' '.$customer[0]->postcode;
        $total_price = 0;
        for( $i = 0 ; $i < count($request->order) ; $i++ ){
            $detail = "";
            $detail_do[] = DB::SELECT("SELECT
                                        acc_mk_dol.ivm_id,
                                        acc_mk_dol.detail,
                                        Sum(acc_mk_dol.quantity) AS quantity,
                                        acc_mk_dol.unit,
                                        Sum(acc_mk_dol.amount) AS amount,
                                        acc_mk_dol.prict_unit,
                                        acc_mk_dol.ref,
                                        Sum(acc_mk_dol.weight_total) AS weight_total,
                                        acc_mk_dom.date_bill,
                                        acc_mk_dom.type,
                                        acc_mk_dom.sub_total
                                        FROM
                                        acc_mk_dol
                                        LEFT JOIN acc_mk_dom ON acc_mk_dol.ivm_id = acc_mk_dom.ivm_id
                                        WHERE
                                        acc_mk_dol.ivm_id = ?
                                        GROUP BY
                                        acc_mk_dol.ivm_id",[$request->order[$i]]);
            if($detail_do[$i][0]->type == 'p'){
                $detail = "ค่าขายสุกร";
            }
            if($detail_do[$i][0]->type == 's'){
                $detail = "ค่าเชือดสุกร";
            }
            if($detail_do[$i][0]->type == 't'){
                $detail = "ค่าตัดแต่งสุกร";
            }
            DB::insert("INSERT INTO acc_mk_ivl(acc_mk_ivl.rc_id, acc_mk_ivl.date, acc_mk_ivl.detail, acc_mk_ivl.price, acc_mk_ivl.date_pay, acc_mk_ivl.rcl_id) 
                                    VALUES(?, ?, ?, ?, ?, ?)",[$bill_number[0]->BILL_NUMBER, $request->date, $detail, $detail_do[$i][0]->sub_total, $request->date_payment, $detail_do[$i][0]->ivm_id]);
            $total_price = $total_price+$detail_do[$i][0]->sub_total;

            DB::update("UPDATE acc_mk_dom SET status_bill = ? WHERE ivM_id = ?",["1", $request->order[$i]]);
        }
        DB::insert("INSERT INTO acc_mk_iv(acc_mk_iv.bill_id, acc_mk_iv.customer_code, acc_mk_iv.customer_name, acc_mk_iv.customer_address, acc_mk_iv.total_price, acc_mk_iv.date) 
                                    VALUES(?, ?, ?, ?, ?, ?)",[$bill_number[0]->BILL_NUMBER, $customer[0]->customer_code, $customer[0]->customer_name, $customer_address, $total_price, $request->date]);
        DB::INSERT("INSERT INTO tb_run_number_bill(tb_run_number_bill.number, tb_run_number_bill.run_number, tb_run_number_bill.type, tb_run_number_bill.created_at)
        VALUES(?,?,'iv',now())",[$bill_number[0]->number, $bill_number[0]->BILL_NUMBER]);
        
        return Redirect::back();
    }

    public function get_ajax_bill(){

        $invoice = DB::SELECT("SELECT acc_mk_dom.*,
                                    type_order_bill.*
                                FROM
                                acc_mk_dom
                                    LEFT JOIN acc_mk_dol ON acc_mk_dom.ivm_id = acc_mk_dol.ivm_id
                                    LEFT JOIN tb_order ON acc_mk_dol.ref = tb_order.order_number
                                    LEFT JOIN type_order_bill ON tb_order.id_type_order_bill = type_order_bill.id
                                -- WHERE
                                --     acc_mk_dom.status != 'c'
                                GROUP BY
                                    acc_mk_dom.ivm_id
                                ORDER BY
                                    acc_mk_dom.date_bill DESC");

        return Datatables::of($invoice)->addIndexColumn()->make(true);
    }

    public function get_ajax_bill_iv(){

        $invoice = DB::SELECT("SELECT
                                acc_mk_iv.id,
                                acc_mk_iv.bill_id,
                                acc_mk_iv.customer_code,
                                acc_mk_iv.customer_name,
                                acc_mk_iv.customer_address,
                                acc_mk_iv.total_price,
                                acc_mk_iv.date,
                                acc_mk_iv.pay,
                                acc_mk_iv.date_pay
                                FROM
                                acc_mk_iv");

        return Datatables::of($invoice)->addIndexColumn()->make(true);
    }

    public function bill_detail($id,$bill){
        if($bill == 1){
            $iv_mail = DB::SELECT("SELECT * FROM acc_mk_dom WHERE acc_mk_dom.ivm_id = '$id'");
            $iv_list = DB::SELECT("SELECT * FROM acc_mk_dol WHERE acc_mk_dol.ivm_id = '$id' ORDER BY detail");

            return view('bill.bill_detail', compact('iv_mail', 'iv_list'));
        }else{
            $iv_mail = DB::SELECT("SELECT * FROM acc_mk_dom WHERE acc_mk_dom.ivm_id = '$id'");
            $iv_list = DB::SELECT("SELECT * FROM acc_kmk_ivl WHERE acc_kmk_ivl.ivm_id = '$id' ORDER BY detail");

            return view('bill.bill_detail_cm', compact('iv_mail', 'iv_list'));
        }
        
    }
    public function bill_detail_rvm($id){
        // return $id;
        $rv_mail = DB::SELECT("SELECT * FROM acc_mk_rvm WHERE acc_mk_rvm.rvm_id = '$id'");
        $rv_list = DB::SELECT("SELECT * FROM acc_mk_rvl WHERE acc_mk_rvl.rvm_id = '$id'");
        
        return view('bill.bill_detail_rv', compact('rv_mail', 'rv_list'));
    }

    

    public function bill_detail_p($id,$bill){
        // return $id;
            $iv_mail = DB::SELECT("SELECT * FROM acc_mk_dom WHERE acc_mk_dom.ivm_id = '$id'");
            $iv_list = DB::SELECT("SELECT
                                    acc_mk_dol.id,
                                    acc_mk_dol.ivm_id,
                                    acc_mk_dol.ivl_id,
                                    acc_mk_dol.detail,
                                    sum(acc_mk_dol.quantity) AS quantity,
                                    acc_mk_dol.unit,
                                    sum(acc_mk_dol.amount) AS amount,
                                    acc_mk_dol.prict_unit,
                                    acc_mk_dol.price_com,
                                    acc_mk_dol.ref,
                                    acc_mk_dol.slice,
                                    acc_mk_dol.cutting,
                                    acc_mk_dol.deposit,
                                    sum(acc_mk_dol.weight_total) AS weight_total,
                                    acc_mk_dol.`status`,
                                    acc_mk_dol.pay
                                    FROM
                                    acc_mk_dol
                                    WHERE
                                    acc_mk_dol.`status` = '$bill' AND
                                    acc_mk_dol.ivm_id = '$id'
                                    GROUP BY
                                    acc_mk_dol.detail
                                    ORDER BY
                                    acc_mk_dol.id
                                    ");
            
            $iv_list_detail = DB::SELECT("SELECT
                                        acc_mk_dol.detail,
                                        acc_mk_dol.quantity,
                                        acc_mk_dol.unit,
                                        acc_mk_dol.weight_total
                                        FROM
                                        acc_mk_dol
                                        WHERE
                                        acc_mk_dol.ivm_id = '$id'
                                        ORDER BY
                                        acc_mk_dol.weight_total ASC");
        
            $wg_range = DB::select("SELECT * FROM standard_weight");

            return view('bill.bill_detail_p', compact('iv_mail', 'iv_list', 'iv_list_detail', 'wg_range'));
            
    }

    public function bill_detail_p_order($id){
        
            $standard_price_com = DB::select("SELECT standard_price FROM standard_price WHERE standard_price.type = 'com' ORDER BY created_at DESC LIMIT 1 ");          
           
            $iv_mail = DB::SELECT("SELECT * FROM acc_mk_dom WHERE acc_mk_dom.ref = '$id'");

            $iv_list = DB::SELECT("SELECT
                                    acc_mk_dol.id,
                                    acc_mk_dol.ivm_id,
                                    acc_mk_dol.ivl_id,
                                    acc_mk_dol.detail,
                                    sum(acc_mk_dol.quantity) AS quantity,
                                    acc_mk_dol.unit,
                                    sum(acc_mk_dol.amount) AS amount,
                                    acc_mk_dol.prict_unit,
                                    acc_mk_dol.price_tr,
                                    acc_mk_dol.price_com,
                                    acc_mk_dol.ref,
                                    acc_mk_dol.slice,
                                    acc_mk_dol.cutting,
                                    acc_mk_dol.deposit,
                                    sum(acc_mk_dol.weight_total) AS weight_total,
                                    acc_mk_dol.`status`,
                                    acc_mk_dol.pay
                                    FROM
                                    acc_mk_dol
                                    WHERE
                                    acc_mk_dol.ref = '$id'
                                    and 
                                    acc_mk_dol.status = 'p'
                                    GROUP BY
                                    acc_mk_dol.detail
                                    ORDER BY
                                    acc_mk_dol.weight_total
                                    "); 

            $iv_list_sc = DB::SELECT("SELECT
                                    acc_mk_dol.id,
                                    acc_mk_dol.ivm_id,
                                    acc_mk_dol.ivl_id,
                                    acc_mk_dol.detail,
                                    sum(acc_mk_dol.quantity) AS quantity,
                                    acc_mk_dol.unit,
                                    sum(acc_mk_dol.amount) AS amount,
                                    acc_mk_dol.prict_unit,
                                    acc_mk_dol.price_tr,
                                    acc_mk_dol.price_com,
                                    acc_mk_dol.ref,
                                    acc_mk_dol.slice,
                                    acc_mk_dol.cutting,
                                    acc_mk_dol.deposit,
                                    sum(acc_mk_dol.weight_total) AS weight_total,
                                    acc_mk_dol.`status`,
                                    acc_mk_dol.pay
                                    FROM
                                    acc_mk_dol
                                    WHERE
                                    acc_mk_dol.ref = '$id'
                                    and 
                                    acc_mk_dol.status = 'sc'
                                    GROUP BY
                                    acc_mk_dol.detail
                                    ORDER BY
                                    acc_mk_dol.weight_total
                                    "); 
            
            $iv_list_s = DB::SELECT("SELECT
                                    acc_mk_dol.id,
                                    acc_mk_dol.ivm_id,
                                    acc_mk_dol.ivl_id,
                                    acc_mk_dol.detail,
                                    sum(acc_mk_dol.quantity) AS quantity,
                                    acc_mk_dol.unit,
                                    sum(acc_mk_dol.amount) AS amount,
                                    acc_mk_dol.prict_unit,
                                    acc_mk_dol.price_tr,
                                    acc_mk_dol.price_com,
                                    acc_mk_dol.ref,
                                    acc_mk_dol.slice,
                                    acc_mk_dol.cutting,
                                    acc_mk_dol.deposit,
                                    sum(acc_mk_dol.weight_total) AS weight_total,
                                    acc_mk_dol.`status`,
                                    acc_mk_dol.pay
                                    FROM
                                    acc_mk_dol
                                    WHERE
                                    acc_mk_dol.ref = '$id'
                                    and 
                                    acc_mk_dol.status = 's'
                                    GROUP BY
                                    acc_mk_dol.ref
                                    ORDER BY
                                    acc_mk_dol.ref
                                    ");                   
             $iv_list_sx = DB::SELECT("SELECT
                                acc_mk_dol.id,
                                acc_mk_dol.ivm_id,
                                acc_mk_dol.ivl_id,
                                acc_mk_dol.detail,
                                sum(acc_mk_dol.quantity) AS quantity,
                                acc_mk_dol.unit,
                                sum(acc_mk_dol.amount) AS amount,
                                acc_mk_dol.prict_unit,
                                acc_mk_dol.price_tr,
                                acc_mk_dol.price_com,
                                acc_mk_dol.ref,
                                acc_mk_dol.slice,
                                acc_mk_dol.cutting,
                                acc_mk_dol.deposit,
                                sum(acc_mk_dol.weight_total) AS weight_total,
                                acc_mk_dol.`status`,
                                acc_mk_dol.pay
                                FROM
                                acc_mk_dol
                                WHERE
                                acc_mk_dol.ref = '$id'
                                and 
                                acc_mk_dol.status = 'sx'
                                GROUP BY
                                acc_mk_dol.ref
                                ORDER BY
                                acc_mk_dol.ref
                                ");             

            $iv_list_t = DB::SELECT("SELECT
                                    acc_mk_dol.id,
                                    acc_mk_dol.ivm_id,
                                    acc_mk_dol.ivl_id,
                                    acc_mk_dol.detail,
                                    sum(acc_mk_dol.quantity) AS quantity,
                                    acc_mk_dol.unit,
                                    sum(acc_mk_dol.amount) AS amount,
                                    acc_mk_dol.prict_unit,
                                    acc_mk_dol.price_tr,
                                    acc_mk_dol.price_com,
                                    acc_mk_dol.ref,
                                    acc_mk_dol.slice,
                                    acc_mk_dol.cutting,
                                    acc_mk_dol.deposit,
                                    sum(acc_mk_dol.weight_total) AS weight_total,
                                    acc_mk_dol.`status`,
                                    acc_mk_dol.pay
                                    FROM
                                    acc_mk_dol
                                    WHERE
                                    acc_mk_dol.ref = '$id'
                                    and 
                                    acc_mk_dol.status = 't'
                                    GROUP BY
                                    acc_mk_dol.ref
                                    ORDER BY
                                    acc_mk_dol.ref
                                    ");
           
           $iv_list_detail = DB::SELECT("SELECT
                                        acc_mk_dol.detail,
                                        acc_mk_dol.quantity,
                                        acc_mk_dol.unit,
                                        acc_mk_dol.weight_total
                                        FROM
                                        acc_mk_dol
                                        WHERE
                                        acc_mk_dol.ivm_id = ?
                                        ORDER BY
                                        acc_mk_dol.id ASC",[$iv_mail[0]->ivm_id]);

            
        
            $wg_range = DB::select("SELECT * FROM standard_weight");

            return view('bill.bill_detail_p_order', compact('iv_mail', 'iv_list','iv_list_sc', 'iv_list_s','iv_list_sx','iv_list_t','iv_list_detail', 'standard_price_com','wg_range'));
            
    }

    public function bill_detail_p_print($id,$bill){
        // return $id;
            $iv_mail = DB::SELECT("SELECT * FROM acc_mk_dom WHERE acc_mk_dom.ivm_id = '$id'");
            $iv_list = DB::SELECT("SELECT
                                    acc_mk_dol.id,
                                    acc_mk_dol.ivm_id,
                                    acc_mk_dol.ivl_id,
                                    acc_mk_dol.detail,
                                    sum(acc_mk_dol.quantity) AS quantity,
                                    acc_mk_dol.unit,
                                    sum(acc_mk_dol.amount) AS amount,
                                    acc_mk_dol.prict_unit,
                                    acc_mk_dol.prict_tr,
                                    acc_mk_dol.ref,
                                    acc_mk_dol.slice,
                                    acc_mk_dol.cutting,
                                    acc_mk_dol.deposit,
                                    sum(acc_mk_dol.weight_total) AS weight_total,
                                    acc_mk_dol.`status`,
                                    acc_mk_dol.pay
                                    FROM
                                    acc_mk_dol
                                    WHERE
                                    acc_mk_dol.`status` = '$bill' AND
                                    acc_mk_dol.ivm_id = '$id'
                                    GROUP BY
                                    acc_mk_dol.detail
                                    ORDER BY
                                    acc_mk_dol.id
                                    ");
            
            $iv_list_detail = DB::SELECT("SELECT
                                        acc_mk_dol.detail,
                                        acc_mk_dol.quantity,
                                        acc_mk_dol.unit,
                                        acc_mk_dol.weight_total
                                        FROM
                                        acc_mk_dol
                                        WHERE
                                        acc_mk_dol.ivm_id = '$id'
                                        ORDER BY
                                        acc_mk_dol.weight_total ASC");

            $wg_range = DB::select("SELECT * FROM standard_weight");

            return view('bill.bill_detail_p_print', compact('iv_mail', 'iv_list', 'iv_list_detail', 'wg_range'));
        
        
    }

    public function bill_detail_rc($id,$bill){
        // return $id;
            $date = substr(now(),8,2)."/".substr(now(),5,2)."/".substr(now(),0,4);
            $m = substr(now(),5,2);
            $number_rc = DB::SELECT("SELECT * FROM tb_run_number_bill WHERE tb_run_number_bill.type = 'rc' AND DATE_FORMAT(tb_run_number_bill.created_at,'%m') = '$m' ORDER BY tb_run_number_bill.created_at DESC  LIMIT 1");
            // return $number_rc;
            if($number_rc == null){ 
                $bill_number = DB::SELECT("CALL CREATE_NUMBER_BILL_RECEIPT(?,?)",[$date, 0]);
                // DB::INSERT("INSERT INTO tb_run_number_bill(tb_run_number_bill.number, tb_run_number_bill.run_number, tb_run_number_bill.type, tb_run_number_bill.created_at)
                //                                     VALUES(1,?,'p',now())",[$bill_number[0]->BILL_NUMBER]); 
            }else{
                $bill_number = DB::SELECT("CALL CREATE_NUMBER_BILL_RECEIPT(?,?)",[$date, $number_rc[0]->number]); 
                // DB::INSERT("INSERT INTO tb_run_number_bill(tb_run_number_bill.number, tb_run_number_bill.run_number, tb_run_number_bill.type, tb_run_number_bill.created_at)
                //                                     VALUES(?,?,'p',now())",[$bill_number[0]->number,$bill_number[0]->BILL_NUMBER]); 
            }
            $iv_mail = DB::SELECT("SELECT * FROM acc_mk_iv WHERE acc_mk_iv.bill_id = '$id'");
            $rc_ilst = DB::select("SELECT * FROM acc_mk_ivl WHERE acc_mk_ivl.rc_id = '$id'");

            // return $iv_mail;
            // return $bill_number;
            $rm = dB::SELECT("SELECT bill_id FROM acc_mk_rc WHERE iv_id = '$id'");
            // return $rm;
            if($rm == null){
                for($i = 0 ; $i < count($rc_ilst) ; $i++ ){
                    DB::INSERT("INSERT INTO acc_mk_rcl(sm_id, date, detail, price,sml_id) 
                                        VALUES(?, ?, ?, ?, ?)",[$bill_number[0]->BILL_NUMBER, $date, $rc_ilst[$i]->detail, $rc_ilst[$i]->price, $rc_ilst[$i]->rc_id]);
                }
                DB::INSERT("INSERT INTO acc_mk_rc(bill_id, customer_code, customer_name, customer_address, total_price, date, iv_id)
                                        VALUES(?,?,?,?,?,?,?)",[$bill_number[0]->BILL_NUMBER, $iv_mail[0]->customer_code, $iv_mail[0]->customer_name, $iv_mail[0]->customer_address, $iv_mail[0]->total_price, $date, $iv_mail[0]->bill_id]);

                DB::INSERT("INSERT INTO tb_run_number_bill(tb_run_number_bill.number, tb_run_number_bill.run_number, tb_run_number_bill.type, tb_run_number_bill.created_at)
                                                    VALUES(?,?,'rc',now())",[$bill_number[0]->number,$bill_number[0]->BILL_NUMBER]);
            }
            
            // return now();
            return view('bill.bill_detail_rc', compact('iv_mail','rc_ilst'));
        
    }

    public function bill_detail_re($id,$bill){
        // return $id;
            $iv_mail = DB::SELECT("SELECT * FROM acc_mk_rc WHERE acc_mk_rc.bill_id = '$id'");
            $rc_ilst = DB::select("SELECT * FROM acc_mk_rcl WHERE acc_mk_rcl.sm_id = '$id'");
            
            return view('bill.bill_detail_re', compact('iv_mail','rc_ilst'));
        
        
    }

    public function bill_detail_s($id,$bill){
        if($bill == 1){
            $iv_mail = DB::SELECT("SELECT * FROM acc_mk_dom WHERE acc_mk_dom.ivm_id = '$id'");
            $iv_list = DB::SELECT("SELECT * FROM acc_mk_dol WHERE  acc_mk_dol.status = 's' AND acc_mk_dol.ivm_id = '$id'");

            return view('bill.bill_detail_s', compact('iv_mail', 'iv_list'));
        }else{
            $iv_mail = DB::SELECT("SELECT * FROM acc_mk_dom WHERE acc_mk_dom.ivm_id = '$id'");
            $iv_list = DB::SELECT("SELECT * FROM acc_kmk_ivl WHERE  acc_kmk_ivl.status = 's' AND acc_kmk_ivl.ivm_id = '$id'");

            return view('bill.bill_detail_s_cm', compact('iv_mail', 'iv_list'));
        }
        
    }

    public function bill_detail_t($id,$bill){
        if($bill == 1){
            $iv_mail = DB::SELECT("SELECT * FROM acc_mk_dom WHERE acc_mk_dom.ivm_id = '$id'");
            $iv_list = DB::SELECT("SELECT * FROM acc_mk_dol WHERE  acc_mk_dol.status = 't' AND acc_mk_dol.ivm_id = '$id'");

            return view('bill.bill_detail_t', compact('iv_mail', 'iv_list'));
        }else{
            $iv_mail = DB::SELECT("SELECT * FROM acc_mk_dom WHERE acc_mk_dom.ivm_id = '$id'");
            $iv_list = DB::SELECT("SELECT * FROM acc_kmk_ivl WHERE  acc_kmk_ivl.status = 't' AND acc_kmk_ivl.ivm_id = '$id'");

            return view('bill.bill_detail_t_cm', compact('iv_mail', 'iv_list'));
        }
        
    }

    public function bill_detail_c($id){

        $iv_mail = DB::SELECT("SELECT * FROM acc_mk_dom WHERE acc_mk_dom.ivm_id = '$id'");
        $iv_list = DB::SELECT("SELECT * FROM acc_mk_dol WHERE acc_mk_dol.ivm_id = '$id'");
        $order_r = DB::SELECT("SELECT tb_order_overnight.order_number FROM tb_order_overnight INNER JOIN tb_order ON tb_order_overnight.order_ref = tb_order.order_number
                                WHERE
                                tb_order.order_number = ?",[$iv_list[0]->ref]);

        $detail = DB::SELECT("SELECT
                                wg_sku_weight_data.lot_number,
                                wg_sku_weight_data.sku_code,
                                wg_sku_weight_data.sku_amount,
                                wg_sku_weight_data.sku_weight,
                            -- 	sum( wg_sku_weight_data.sku_amount ) AS sum_amount,
                            -- 	sum( wg_sku_weight_data.sku_weight ) AS sum_weight,
                                wg_sku_weight_data.scale_number,
                                wg_sku_weight_data.weighing_date,
                                tb_order.weight_range,
                                wg_sku_item.item_name,
                                tb_order.slice,
                                tb_order.cutting,
                                tb_order.deposit,
                                standard_weight.id AS weighing_id,
                                standard_price_list_group.price_list  
                            FROM
                                wg_sku_weight_data
                                LEFT JOIN wg_sku_item ON wg_sku_weight_data.sku_code = wg_sku_item.item_code
                                LEFT JOIN tb_order ON wg_sku_weight_data.lot_number = tb_order.order_number
                                LEFT JOIN standard_weight ON tb_order.weight_range = standard_weight.standard_period 
                                LEFT JOIN standard_price_list_group ON tb_order.type_pig = standard_price_list_group.id
                            WHERE
                                wg_sku_weight_data.lot_number = ? 
                                AND wg_sku_weight_data.scale_number IN ( 'KMK12' ) ",[$order_r[0]->order_number]);
        // return $detail;

        return view('bill.bill_detail_c', compact('iv_mail', 'iv_list', 'detail'));
    }

    public function bill_ivs(){
        $date = substr(now(),8,2).'/'.substr(now(),5,2).'/'.substr(now(),0,4);

        $oder = DB::SELECT("SELECT
                                tb_order.id,
                                tb_order.order_number,
                                tb_order.date,
                                tb_order.id_user_customer
                            FROM
                                tb_order
                                LEFT JOIN users AS customer ON tb_order.id_user_customer = customer.id
                                LEFT JOIN users AS provider ON tb_order.id_user_provider = provider.id
                                LEFT JOIN users AS sender ON tb_order.id_user_sender = sender.id
                                LEFT JOIN users AS recieve ON tb_order.id_user_recieve = recieve.id
                                LEFT JOIN tb_order_type ON tb_order.type_request = tb_order_type.id
                                LEFT JOIN wg_storage ON tb_order.storage_id = wg_storage.id_storage
                            WHERE
                                tb_order.type_request <> 4 
                                AND ( tb_order.date = '$date' ) 
                                -- AND ( tb_order.date = '01/04/2020' ) 
                            GROUP BY
                                tb_order.order_number 
                            ORDER BY
                                tb_order.created_at DESC");
        
        $customer = DB::SELECT("SELECT  * FROM tb_customer ");
                             
        return view('bill.bill_iv', compact('oder', 'customer'));
    }

    public function create_bill_sum(Request $request){
        // return  $request ;
        $customer = DB::SELECT("SELECT
                                    tb_customer.customer_code,
                                    tb_customer.id,
                                    tb_customer.customer_name
                                FROM
                                    tb_customer
                                WHERE
                                    tb_customer.id =  $request->customer");
        
        // $ivm
        $total = 0;
        for ($i=0; $i < count($request->order) ; $i++) { 
            $detail[] = DB::select("SELECT * FROM acc_mk_dom WHERE acc_mk_dom.ivm_id = ?",[$request->order[$i]]);
            $total = $total + $detail[$i][0]->sub_total;
        }    
        // return $total;
        DB::INSERT("INSERT INTO acc_mk_ivs(acc_mk_ivs.ivs_id,acc_mk_ivs.customer_id,acc_mk_ivs.customer_name,acc_mk_ivs.date,acc_mk_ivs.amount) 
        VALUES(?,?,?,?,?)",[$request->bill_number, $customer[0]->customer_code, $customer[0]->customer_name, $request->date, $total]);
        

        for ($i=0; $i < count($request->order) ; $i++) { 
            // $detail[] = DB::select("SELECT * FROM acc_mk_dom WHERE acc_mk_dom.ivm_id = ?",[$request->order[$i]]);
            DB::update("UPDATE acc_mk_dom SET acc_mk_dom.ivs_id=? WHERE acc_mk_dom.ivm_id = ?",[$request->bill_number, $request->order[$i]]);
        }        

        return Redirect::back();
    }

    public function get_ajax_bill_sum(){
        $invoice_sum = DB::SELECT("SELECT * FROM acc_mk_ivs");

        return Datatables::of($invoice_sum)->addIndexColumn()->make(true);
    }
    public function receipt_rvm(){
        // $invoice_sum = DB::SELECT("SELECT
        //                                 acc_mk_rc.*,
        //                                 pay_monney_bill.monney
        //                             FROM
        //                                 acc_mk_rc
        //                                 LEFT JOIN pay_monney_bill ON ( SELECT sum( pay_monney_bill.monney ) AS monney FROM pay_monney_bill WHERE pay_monney_bill.rc_id = acc_mk_rc.bill_id GROUP BY pay_monney_bill.rc_id ) ");

        $invoice_sum = DB::SELECT("SELECT
                                    acc_mk_rc.*,
                                    ( SELECT sum( pay_monney_bill.monney )  FROM pay_monney_bill WHERE pay_monney_bill.rc_id = acc_mk_rc.bill_id ) AS monney
                                FROM
                                    acc_mk_rc 
                                GROUP BY
                                    acc_mk_rc.bill_id");


        return Datatables::of($invoice_sum)->addIndexColumn()->make(true);
    }

    public function get_receipt_fully(){
        
        // $invoice_sum = DB::SELECT("SELECT
        //                                 acc_mk_iv.bill_id AS iv_id,
        //                                 acc_mk_iv.customer_code,
        //                                 acc_mk_iv.customer_name,
        //                                 acc_mk_iv.customer_address,
        //                                 Sum(acc_mk_iv.total_price) AS total_price,
        //                                 acc_mk_iv.date,
        //                                 acc_mk_rc.bill_id AS rc_id,
        //                                 Sum(acc_mk_rc.pay) AS pay,
        //                                 (   SELECT
        //                                     sum(pay_monney_bill.monney)
        //                                     FROM
        //                                     pay_monney_bill
        //                                     WHERE
        //                                     pay_monney_bill.type_pay = 'cash'
        //                                     AND pay_monney_bill.rc_id = acc_mk_rc.bill_id) AS cash,
        //                                 (   SELECT
        //                                     sum(pay_monney_bill.monney)
        //                                     FROM
        //                                     pay_monney_bill
        //                                     WHERE
        //                                     pay_monney_bill.type_pay = 'transfer'
        //                                     AND pay_monney_bill.rc_id = acc_mk_rc.bill_id) AS transfer
        //                             FROM
        //                                 acc_mk_iv
        //                                 LEFT JOIN acc_mk_rc ON acc_mk_iv.bill_id = acc_mk_rc.iv_id
        //                             -- WHERE
        //                                 -- acc_mk_iv.date = '13/07/2020'
        //                                 GROUP BY
        //                                 acc_mk_iv.customer_code
        //                             ");
         $invoice_sum = DB::SELECT("SELECT
                                        acc_mk_rc.id,
                                        acc_mk_rc.bill_id,
                                        acc_mk_rc.customer_code,
                                        acc_mk_rc.customer_name,
                                        acc_mk_rc.customer_address,
                                        acc_mk_rc.total_price,
                                        acc_mk_rc.date,
                                        acc_mk_rc.pay,
                                        acc_mk_rc.date_pay,
                                        acc_mk_rc.`status`,
                                        acc_mk_rc.iv_id,
                                        -- Sum( acc_mk_rc.pay ) AS pay,
                                        ( SELECT sum( pay_monney_bill.monney ) FROM pay_monney_bill WHERE pay_monney_bill.type_pay = 'cash' AND pay_monney_bill.rc_id = acc_mk_rc.bill_id ) AS cash,
                                        ( SELECT sum( pay_monney_bill.monney ) FROM pay_monney_bill WHERE pay_monney_bill.type_pay = 'transfer' AND pay_monney_bill.rc_id = acc_mk_rc.bill_id ) AS transfer 
                                    FROM
                                        acc_mk_rc
                                    WHERE
                                        acc_mk_rc.`status` = 2
                                    ");


        return Datatables::of($invoice_sum)->addIndexColumn()->make(true);
    }
    
    

    public function bill_detail_sum($id){

        $detail_ivs = DB::SELECT("SELECT * FROM acc_mk_ivs WHERE acc_mk_ivs.ivs_id = '$id'");
        $ivs_list = DB::SELECT("SELECT * FROM acc_mk_dom WHERE acc_mk_dom.ivs_id = '$id'");
        // return $ivs_kise;
        return view("bill.bill_detail_sum", compact('detail_ivs', 'ivs_list'));
    }

    public function bill_detail_sum_p($id){

        $iv_mail = DB::SELECT("SELECT * FROM acc_mk_dom WHERE acc_mk_dom.ivm_id = '$id'");
        $iv_list = DB::SELECT("SELECT * FROM acc_mk_dol WHERE acc_mk_dol.ivm_id = '$id' ORDER BY detail");
        // return $ivs_kise;
        return view("bill.receipt_p", compact('iv_mail', 'iv_list'));
    }

    public function receipt(){
        $date = substr(now(),8,2).'/'.substr(now(),5,2).'/'.substr(now(),0,4);

        $order = DB::SELECT("SELECT
                                acc_mk_dom.id,
                                acc_mk_dom.ivm_id,
                                acc_mk_dom.company_name,
                                acc_mk_dom.company_address,
                                acc_mk_dom.company_phon,
                                acc_mk_dom.company_fax,
                                acc_mk_dom.identification_number,
                                acc_mk_dom.date_rm,
                                acc_mk_dom.date_bill,
                                acc_mk_dom.customer_id,
                                acc_mk_dom.customer_name,
                                acc_mk_dom.customer_adress,
                                acc_mk_dom.customer_phone,
                                acc_mk_dom.sub_total,
                                acc_mk_dom.vat,
                                acc_mk_dom.net_total,
                                acc_mk_dom.pay_type,
                                acc_mk_dom.bank,
                                acc_mk_dom.bank_branch,
                                acc_mk_dom.check_number,
                                acc_mk_dom.date_check,
                                acc_mk_dom.bill_collector,
                                acc_mk_dom.date_bill_collector,
                                acc_mk_dom.name_signager,
                                acc_mk_dom.signager,
                                acc_mk_dom.date_signager,
                                acc_mk_dom.date_payment,
                                acc_mk_dom.partial_payment,
                                acc_mk_dom.return_product,
                                acc_mk_dom.overdue
                            FROM
                                acc_mk_dom
        ");
        
        $customer = DB::SELECT("SELECT  * FROM tb_customer ");
                             
        return view('bill.receipt', compact('order', 'customer'));
    }

    public function receipt_fully(){
        $date = substr(now(),8,2).'/'.substr(now(),5,2).'/'.substr(now(),0,4);

        $order = DB::SELECT("SELECT
                                acc_mk_dom.id,
                                acc_mk_dom.ivm_id,
                                acc_mk_dom.company_name,
                                acc_mk_dom.company_address,
                                acc_mk_dom.company_phon,
                                acc_mk_dom.company_fax,
                                acc_mk_dom.identification_number,
                                acc_mk_dom.date_rm,
                                acc_mk_dom.date_bill,
                                acc_mk_dom.customer_id,
                                acc_mk_dom.customer_name,
                                acc_mk_dom.customer_adress,
                                acc_mk_dom.customer_phone,
                                acc_mk_dom.sub_total,
                                acc_mk_dom.vat,
                                acc_mk_dom.net_total,
                                acc_mk_dom.pay_type,
                                acc_mk_dom.bank,
                                acc_mk_dom.bank_branch,
                                acc_mk_dom.check_number,
                                acc_mk_dom.date_check,
                                acc_mk_dom.bill_collector,
                                acc_mk_dom.date_bill_collector,
                                acc_mk_dom.name_signager,
                                acc_mk_dom.signager,
                                acc_mk_dom.date_signager,
                                acc_mk_dom.date_payment,
                                acc_mk_dom.partial_payment,
                                acc_mk_dom.return_product,
                                acc_mk_dom.overdue
                            FROM
                                acc_mk_dom
        ");
        
        $customer = DB::SELECT("SELECT  * FROM tb_customer ");
                             
        return view('bill.receipt_fully', compact('order', 'customer'));
    }

    
    
    public function receipt_create(Request $request){
        // return $request ;
    //    return count($request->order);
    $customer = DB::SELECT("SELECT
                                *
                            FROM
                                tb_customer
                            WHERE
                                tb_customer.id =  $request->customer");
    $customer_address = $customer[0]->address.' เลขที่'.$customer[0]->address_M.' ม.'.$customer[0]->address_Mnumber.' ซอย '.$customer[0]->address_lane.' ถนน '.$customer[0]->address_road.' ต.'.
    $customer[0]->address_district.' อ.'.$customer[0]->address_city.' '.$customer[0]->province.' '.$customer[0]->postcode;
    // return $customer_address;
    $total_price = 0;
    
        for($i = 0 ; $i < count($request->order) ; $i++){
            $detail = '';
            $ivs_list[] = DB::SELECT("SELECT
                                        acc_mk_dom.id,
                                        acc_mk_dom.ivs_id,
                                        acc_mk_dom.ivm_id,
                                        acc_mk_dom.company_name,
                                        acc_mk_dom.company_address,
                                        acc_mk_dom.company_phon,
                                        acc_mk_dom.company_fax,
                                        acc_mk_dom.identification_number,
                                        acc_mk_dom.date_rm,
                                        acc_mk_dom.date_bill,
                                        acc_mk_dom.customer_id,
                                        acc_mk_dom.customer_name,
                                        acc_mk_dom.customer_adress,
                                        acc_mk_dom.customer_phone,
                                        acc_mk_dom.sub_total,
                                        acc_mk_dom.vat,
                                        acc_mk_dom.net_total,
                                        acc_mk_dom.pay_type,
                                        acc_mk_dom.bank,
                                        acc_mk_dom.bank_branch,
                                        acc_mk_dom.check_number,
                                        acc_mk_dom.date_check,
                                        acc_mk_dom.bill_collector,
                                        acc_mk_dom.date_bill_collector,
                                        acc_mk_dom.name_signager,
                                        acc_mk_dom.signager,
                                        acc_mk_dom.date_signager,
                                        acc_mk_dom.date_payment,
                                        acc_mk_dom.partial_payment,
                                        acc_mk_dom.return_product,
                                        acc_mk_dom.overdue,
                                        sum(acc_mk_dol.deposit) AS deposit,
                                        sum(acc_mk_dol.cutting) AS cutting,
                                        sum(acc_mk_dol.slice) AS slice,
                                        GROUP_CONCAT(acc_mk_dol.detail) AS detail
                                    FROM
                                        acc_mk_dom
                                        INNER JOIN acc_mk_dol ON acc_mk_dom.ivm_id = acc_mk_dol.ivm_id
                                    WHERE
                                        acc_mk_dom.ivm_id = ?
                                    GROUP BY
                                        acc_mk_dom.ivm_id",[$request->order[$i]]);
            $detail = $detail. $ivs_list[$i][0]->detail;
            if($ivs_list[$i][0]->slice > 0){
                $detail = $detail.',ค่าเชื่อด';
            }
            if($ivs_list[$i][0]->cutting > 0){
                $detail = $detail.',ค่าตัดแต่ง';
            }
            if($ivs_list[$i][0]->deposit > 0){
                $detail = $detail.',ค่าฝาก';
            }
            DB::INSERT("INSERT INTO acc_mk_rvl(acc_mk_rvl.rvm_id, acc_mk_rvl.rvl_id, acc_mk_rvl.amount, acc_mk_rvl.date, acc_mk_rvl.detail) 
                                                VALUES(?, ?, ?, ?, ?)",[$request->bill_number, $ivs_list[$i][0]->ivm_id, $ivs_list[$i][0]->sub_total, $request->date, $detail]);
            $total_price = $total_price + $ivs_list[$i][0]->sub_total ;
        }
        DB::INSERT("INSERT INTO acc_mk_rvm(acc_mk_rvm.rvm_id, acc_mk_rvm.date_bill, acc_mk_rvm.customer_id, acc_mk_rvm.customer_name,
                                                    acc_mk_rvm.customer_adress, acc_mk_rvm.customer_phone, acc_mk_rvm.date_payment,acc_mk_rvm.sub_total)
                                            VALUES(?,?,?,?,?,?,?,?)",[$request->bill_number, $request->date, $customer[0]->customer_code, $customer[0]->customer_name, 
                                                                    $customer_address, $customer[0]->phone_number, $request->date_payment,  $total_price]);
            // return $detail;
         return Redirect::back();
    }

    public function add_detall($id, Request $request){
        $widht = $request->widht ;
        $unit = $request->unit ;
        if($request->widht == null){
            $widht = 1;
        }
        if($request->unit == null){
            $unit = 1;
        }
        // return $request;
        if($request->bill == 1){
            if($id == 'p'){
                DB::INSERT("INSERT INTO acc_mk_dol(ivm_id, ref, detail, weight_total, quantity, prict_unit,unit,status,amount)
                                        VALUES(?,?,?,?,?,?,?,?,?)",
                                        [$request->id_ivl,$request->code_item,$request->detall_item,$request->widht,$request->unit,$request->price,'Kg.','p',($widht*$request->price)]);  
            }
            if($id == 's'){
                DB::INSERT("INSERT INTO acc_mk_dol(ivm_id, ref, detail, weight_total, quantity, prict_unit,unit,status,amount)
                                        VALUES(?,?,?,?,?,?,?,?,?)",
                                        [$request->id_ivl,$request->code_item,$request->detall_item,$request->widht,$request->unit,$request->price,'Kg.','s',($unit*$request->price)]);
            }
            if($id == 't'){
                DB::INSERT("INSERT INTO acc_mk_dol(ivm_id, ref, detail, weight_total, quantity, prict_unit,unit,status,amount)
                                        VALUES(?,?,?,?,?,?,?,?,?)",
                                        [$request->id_ivl,$request->code_item,$request->detall_item,$request->widht,$request->unit,$request->price,'Kg.','t',($unit*$request->price)]);
            }
        }else{
            if($id == 'p'){
                DB::INSERT("INSERT INTO acc_kmk_ivl(ivm_id, ref, detail, weight_total, quantity, prict_unit,unit,status,amount)
                                        VALUES(?,?,?,?,?,?,?,?,?)",
                                        [$request->id_ivl,$request->code_item,$request->detall_item,$request->widht,$request->unit,$request->price,'Kg.','p',($widht*$request->price)]);  
            }
            if($id == 's'){
                DB::INSERT("INSERT INTO acc_kmk_ivl(ivm_id, ref, detail, weight_total, quantity, prict_unit,unit,status,amount)
                                        VALUES(?,?,?,?,?,?,?,?,?)",
                                        [$request->id_ivl,$request->code_item,$request->detall_item,$request->widht,$request->unit,$request->price,'Kg.','s',($unit*$request->price)]);
            }
            if($id == 't'){
                DB::INSERT("INSERT INTO acc_kmk_ivl(ivm_id, ref, detail, weight_total, quantity, prict_unit,unit,status,amount)
                                        VALUES(?,?,?,?,?,?,?,?,?)",
                                        [$request->id_ivl,$request->code_item,$request->detall_item,$request->widht,$request->unit,$request->price,'Kg.','t',($unit*$request->price)]);
            }
        }
        

        return Redirect::back();
    }

    public function bill_pay(Request $request){
        // return $request;
        $date = substr(now(),8,2).'/'.substr(now(),5,2).'/'.substr(now(),0,4);
        $pay_ = DB::SELECT("SELECT pay,total_price FROM acc_mk_rc WHERE bill_id = '$request->ivm'");
        
        // return $pay_history;
        // return $pay_[0]->total_price;
        if($pay_[0]->pay == null){
            $pay = 0;
        }else{
            $pay = $pay_[0]->pay;
        }
        
        DB::UPDATE("UPDATE acc_mk_rc SET pay=($pay+$request->pay),date_pay=now() WHERE bill_id = '$request->ivm'");
        DB::INSERT("INSERT INTO pay_monney_bill(rc_id, monney, date, user, type_pay) VALUES(?,?,?,?,?)",[$request->ivm, $request->pay, $date, Auth::user()->name, $request->type_pay]);

        $pay_history = DB::SELECT("SELECT sum(monney) AS monney FROM pay_monney_bill WHERE rc_id = '$request->ivm' GROUP BY rc_id ");
        if($pay_[0]->total_price == $pay_history[0]->monney){
            DB::UPDATE("UPDATE acc_mk_rc SET acc_mk_rc.status=2 WHERE bill_id = '$request->ivm'");
        }
        
        return Redirect::back();
    }

    public function bill_cancel(Request $request){
        DB::SELECT("UPDATE acc_mk_dom SET status = 'c' WHERE ivm_id = '$request->ivm'");

        return 'ยกเลิกสำเร็จ';
    }

    public function report_sales(){ 
        $date = substr(now(),8,2).'/'.substr(now(),5,2).'/'.substr(now(),0,4);

        $order = DB::SELECT("SELECT
                                acc_mk_dom.id,
                                acc_mk_dom.ivm_id,
                                acc_mk_dom.company_name,
                                acc_mk_dom.company_address,
                                acc_mk_dom.company_phon,
                                acc_mk_dom.company_fax,
                                acc_mk_dom.identification_number,
                                acc_mk_dom.date_rm,
                                acc_mk_dom.date_bill,
                                acc_mk_dom.customer_id,
                                acc_mk_dom.customer_name,
                                acc_mk_dom.customer_adress,
                                acc_mk_dom.customer_phone,
                                acc_mk_dom.sub_total,
                                acc_mk_dom.vat,
                                acc_mk_dom.net_total,
                                acc_mk_dom.pay_type,
                                acc_mk_dom.bank,
                                acc_mk_dom.bank_branch,
                                acc_mk_dom.check_number,
                                acc_mk_dom.date_check,
                                acc_mk_dom.bill_collector,
                                acc_mk_dom.date_bill_collector,
                                acc_mk_dom.name_signager,
                                acc_mk_dom.signager,
                                acc_mk_dom.date_signager,
                                acc_mk_dom.date_payment,
                                acc_mk_dom.partial_payment,
                                acc_mk_dom.return_product,
                                acc_mk_dom.overdue
                            FROM
                                acc_mk_dom
        ");
        
        $customer = DB::SELECT("SELECT  * FROM tb_customer ");
                             
        return view('bill.report_sales', compact('order', 'customer'));
    }

}
