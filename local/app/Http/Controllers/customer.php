<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;
use App\tb_customer;
use Redirect;

class customer extends Controller
{
    
    public function index()
    {
        return view('customer.customer');
    }

    public function index_creditor()
    {
        return view('customer.customer_creditor_all');
    }

    public function ajaxCustomer(){
        $data_customer = DB::select("SELECT
        tb_customer.id,
        tb_customer.pnoun,
        tb_customer.customer_name,
        tb_customer.shop_name,
        tb_customer.customer_shop_open,
        tb_customer.customer_shop_close,
        tb_customer.customer_shop_day_close,
        tb_customer.customer_shop_time_recieve_product,
        tb_customer.datepick,
        tb_customer.id_card_number,
        tb_customer.address,
        tb_customer.address_M,
        tb_customer.address_Mnumber,
        tb_customer.address_lane,
        tb_customer.address_road,
        tb_customer.address_district,
        tb_customer.address_city,
        tb_customer.province,
        tb_customer.postcode,
        tb_customer.phone_number,
        tb_customer.email,
        tb_customer.facebook,
        tb_customer.line,
        tb_customer.type as customer_type,
        tb_customer.id_purchase_amount,
        tb_customer.purchase_week,
        tb_customer.id_business_type,
        tb_customer.customer_code,
        tb_customer.customer_nickname,
        tb_customer.marker,
        tb_customer_purchase_amount.range_money,
        tb_customer_business.business,
        tb_customer_business.type
        FROM
        tb_customer
        LEFT JOIN tb_customer_purchase_amount ON tb_customer.id_purchase_amount = tb_customer_purchase_amount.id
        LEFT JOIN tb_customer_business ON tb_customer.id_business_type = tb_customer_business.id
        ORDER BY
        tb_customer.id ASC
        ", []);
        return Datatables::of($data_customer)->addIndexColumn()->make(true);
    }
    
    public function ajaxCustomer_creditor(){
        $data_customer = DB::select("SELECT
        tb_customer.id,
        tb_customer.pnoun,
        tb_customer.customer_name,
        tb_customer.shop_name,
        tb_customer.customer_shop_open,
        tb_customer.customer_shop_close,
        tb_customer.customer_shop_day_close,
        tb_customer.customer_shop_time_recieve_product,
        tb_customer.datepick,
        tb_customer.id_card_number,
        tb_customer.address,
        tb_customer.address_M,
        tb_customer.address_Mnumber,
        tb_customer.address_lane,
        tb_customer.address_road,
        tb_customer.address_district,
        tb_customer.address_city,
        tb_customer.province,
        tb_customer.postcode,
        tb_customer.phone_number,
        tb_customer.email,
        tb_customer.facebook,
        tb_customer.line,
        tb_customer.type as customer_type,
        tb_customer.id_purchase_amount,
        tb_customer.purchase_week,
        tb_customer.id_business_type,
        tb_customer.customer_code,
        tb_customer.customer_nickname,
        tb_customer.marker,
        tb_customer_purchase_amount.range_money,
        tb_customer_business.business,
        tb_customer_business.type
        FROM
        tb_customer
        LEFT JOIN tb_customer_purchase_amount ON tb_customer.id_purchase_amount = tb_customer_purchase_amount.id
        LEFT JOIN tb_customer_business ON tb_customer.id_business_type = tb_customer_business.id
        WHERE tb_customer.creditor = '1'
        ORDER BY
        tb_customer.id ASC
        ", []);
        return Datatables::of($data_customer)->addIndexColumn()->make(true);
    }

    public function indexAdd()
    {
        $purchase_amount = DB::select('SELECT * from tb_customer_purchase_amount', []);
        $customer_business = DB::select('SELECT * FROM tb_customer_business ORDER BY tb_customer_business.type ASC', []);
        $customer_type = DB::select('SELECT * from tb_order_type WHERE tb_order_type.type IS NOT NULL');
        $customer_group = DB::select("SELECT * FROM standard_group");

        return view('customer.customer_add', compact('purchase_amount','customer_business','customer_type','customer_group'));
    }
    
    public function indexAdd_creditor()
    {
        $purchase_amount = DB::select('SELECT * from tb_customer_purchase_amount', []);
        $customer_business = DB::select('SELECT * FROM tb_customer_business ORDER BY tb_customer_business.type ASC', []);
        $customer_type = DB::select('SELECT * from tb_order_type WHERE tb_order_type.type IS NOT NULL');
        $customer_group = DB::select("SELECT * FROM standard_group");

        return view('customer.customer_creditor', compact('purchase_amount','customer_business','customer_type','customer_group'));
    }
    

    public function indexAdd_debtor()
    {
        $purchase_amount = DB::select('SELECT * from tb_customer_purchase_amount', []);
        $customer_business = DB::select('SELECT * FROM tb_customer_business ORDER BY tb_customer_business.type ASC', []);
        $customer_type = DB::select('SELECT * from tb_order_type WHERE tb_order_type.type IS NOT NULL');

        return view('customer.customer_add_debtor', compact('purchase_amount','customer_business','customer_type'));
    }
    
    public function saveRegster_creditor(Request $request){
        // return $request;

        $validate = \Validator::make($request->all(), [
            'marker' => 'required|unique:tb_customer',
            'customer_code' => 'required|unique:tb_customer',
           
        ], [
            'marker.unique' => 'อักษรย่อลูกค้า ต้องไม่ซ้ำ',
            'customer_code.unique' => 'รหัสพนักงาน ต้องไม่ซ้ำ',
        ]);
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate->errors())->withInput($request->all());
        }

        DB::insert('INSERT into tb_customer
                    (tb_customer.pnoun,
                    tb_customer.customer_name,
                    tb_customer.shop_name,
                    tb_customer.customer_shop_open,
                    tb_customer.customer_shop_close,
                    tb_customer.customer_shop_day_close,
                    tb_customer.customer_shop_time_recieve_product,
                    tb_customer.datepick,
                    tb_customer.id_card_number,
                    tb_customer.address,
                    tb_customer.address_M,
                    tb_customer.address_Mnumber,
                    tb_customer.address_lane,
                    tb_customer.address_road,
                    tb_customer.address_district,
                    tb_customer.address_city,
                    tb_customer.province,
                    tb_customer.postcode,
                    tb_customer.phone_number,
                    tb_customer.email,
                    tb_customer.facebook,
                    tb_customer.line,
                    tb_customer.id_purchase_amount,
                    tb_customer.purchase_week,
                    tb_customer.customer_code,
                    tb_customer.customer_nickname,
                    tb_customer.marker,
                    tb_customer.type,
                    tb_customer.standard_group_id,
                    tb_customer.fax,
                    tb_customer.address_send,
                    tb_customer.address_M_send,
                    tb_customer.address_Mnumber_send,
                    tb_customer.address_lane_send,
                    tb_customer.address_road_send,
                    tb_customer.address_district_send,
                    tb_customer.address_city_send,
                    tb_customer.province_send,
                    tb_customer.postcode_send,
                    tb_customer.phone_number_send,
                    tb_customer.email_send,
                    tb_customer.facebook_send,
                    tb_customer.line_send,
                    tb_customer.fax_send,
                    vat,
                    tb_customer.creditor)
                    values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?
                    )',
                    [$request->pnoun,
                    $request->customer_name,
                    $request->customer_shop_name,
                    $request->customer_shop_open,
                    $request->customer_shop_close,
                    $request->customer_shop_day_close,
                    $request->customer_shop_time_recieve_product,
                    $request->datepick,
                    $request->id_card_number1,
                    $request->address,
                    $request->address_M,
                    $request->address_Mnumber,
                    $request->address_lane,
                    $request->address_road,
                    $request->address_district,
                    $request->address_city,
                    $request->province,
                    $request->postcode,
                    $request->phone_number,
                    $request->email,
                    $request->facebook,
                    $request->line,
                    $request->purchase,
                    $request->purchase_week,
                    $request->customer_code,
                    $request->customer_nickname,
                    $request->marker,
                    $request->customer_type,
                    $request->customer_group,
                    $request->fax,
                    $request->address_send,
                    $request->address_M_send,
                    $request->address_Mnumber_send,
                    $request->address_lane_send,
                    $request->address_road_send,
                    $request->address_district_send,
                    $request->address_city_send,
                    $request->province_send,
                    $request->postcode_send,
                    $request->phone_number_send,
                    $request->email_send,
                    $request->facebook_send,
                    $request->line_send,
                    $request->fax_send,
                    $request->vat,
                    '1']);


        return redirect('customer/customer_creditor_all');
        // รีเทินหน้ารวม
    }

    public function saveRegster(Request $request){
        // return $request;

        $validate = \Validator::make($request->all(), [
            'marker' => 'required|unique:tb_customer',
            'customer_code' => 'required|unique:tb_customer',
           
        ], [
            'marker.unique' => 'อักษรย่อลูกค้า ต้องไม่ซ้ำ',
            'customer_code.unique' => 'รหัสพนักงาน ต้องไม่ซ้ำ',
        ]);
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate->errors())->withInput($request->all());
        }

        DB::insert('INSERT into tb_customer
                    (tb_customer.pnoun,
                    tb_customer.customer_name,
                    tb_customer.shop_name,
                    tb_customer.customer_shop_open,
                    tb_customer.customer_shop_close,
                    tb_customer.customer_shop_day_close,
                    tb_customer.customer_shop_time_recieve_product,
                    tb_customer.datepick,
                    tb_customer.id_card_number,
                    tb_customer.address,
                    tb_customer.address_M,
                    tb_customer.address_Mnumber,
                    tb_customer.address_lane,
                    tb_customer.address_road,
                    tb_customer.address_district,
                    tb_customer.address_city,
                    tb_customer.province,
                    tb_customer.postcode,
                    tb_customer.phone_number,
                    tb_customer.email,
                    tb_customer.facebook,
                    tb_customer.line,
                    tb_customer.id_purchase_amount,
                    tb_customer.purchase_week,
                    tb_customer.customer_code,
                    tb_customer.customer_nickname,
                    tb_customer.marker,
                    tb_customer.type,
                    tb_customer.standard_group_id,
                    tb_customer.fax,
                    tb_customer.address_send,
                    tb_customer.address_M_send,
                    tb_customer.address_Mnumber_send,
                    tb_customer.address_lane_send,
                    tb_customer.address_road_send,
                    tb_customer.address_district_send,
                    tb_customer.address_city_send,
                    tb_customer.province_send,
                    tb_customer.postcode_send,
                    tb_customer.phone_number_send,
                    tb_customer.email_send,
                    tb_customer.facebook_send,
                    tb_customer.line_send,
                    tb_customer.fax_send,
                    vat,
                    new_customer_code,
                    new_marker)
                    values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?
                    )',
                    [$request->pnoun,
                    $request->customer_name,
                    $request->customer_shop_name,
                    $request->customer_shop_open,
                    $request->customer_shop_close,
                    $request->customer_shop_day_close,
                    $request->customer_shop_time_recieve_product,
                    $request->datepick,
                    $request->id_card_number1,
                    $request->address,
                    $request->address_M,
                    $request->address_Mnumber,
                    $request->address_lane,
                    $request->address_road,
                    $request->address_district,
                    $request->address_city,
                    $request->province,
                    $request->postcode,
                    $request->phone_number,
                    $request->email,
                    $request->facebook,
                    $request->line,
                    $request->purchase,
                    $request->purchase_week,
                    $request->customer_code,
                    $request->customer_nickname,
                    $request->marker,
                    $request->customer_type,
                    $request->customer_group,
                    $request->fax,
                    $request->address_send,
                    $request->address_M_send,
                    $request->address_Mnumber_send,
                    $request->address_lane_send,
                    $request->address_road_send,
                    $request->address_district_send,
                    $request->address_city_send,
                    $request->province_send,
                    $request->postcode_send,
                    $request->phone_number_send,
                    $request->email_send,
                    $request->facebook_send,
                    $request->line_send,
                    $request->fax_send,
                    $request->vat,
                    $request->customer_code,
                    $request->marker]);

        DB::update("INSERT INTO standard_prile_pig_customer(standard_prile_pig_customer.id_customer,
                                                            standard_prile_pig_customer.fattening,
                                                            standard_prile_pig_customer.pig_5,
                                                            standard_prile_pig_customer.pig_egg,
                                                            standard_prile_pig_customer.father,
                                                            standard_prile_pig_customer.mother,
                                                            standard_prile_pig_customer.carcass,
                                                            standard_prile_pig_customer.dead_pig,
                                                            standard_prile_pig_customer.slice,
                                                            standard_prile_pig_customer.trim) 
                                                            VALUES(?,?,?,?,?,?,?,?,?,?)",[$request->customer_code,
                                                            $request->fattening,
                                                            $request->pig_5,
                                                            $request->pig_egg,
                                                            $request->father,
                                                            $request->mother,
                                                            $request->carcass,
                                                            $request->dead_pig,
                                                            $request->slice,
                                                            $request->trim]);

        return redirect('customer/get_all');
    }
    // public function saveRegster(Request $request){
    //     return

    //     $validate = \Validator::make($request->all(), [
    //         'marker' => 'required|unique:tb_customer',
    //         'customer_code' => 'required|unique:tb_customer',
           
    //     ], [
    //         'marker.unique' => 'อักษรย่อลูกค้า ต้องไม่ซ้ำ',
    //         'customer_code.unique' => 'รหัสพนักงาน ต้องไม่ซ้ำ',
    //     ]);
    //     if ($validate->fails()) {
    //         return redirect()->back()->withErrors($validate->errors())->withInput($request->all());
    //     }

    //     DB::insert('INSERT into tb_customer
    //                 (pnoun,
    //                 customer_name,
    //                 shop_name,
    //                 customer_shop_open,
    //                 customer_shop_close,
    //                 customer_shop_day_close,
    //                 customer_shop_time_recieve_product,
    //                 datepick,
    //                 id_card_number,
    //                 address,
    //                 address_M,
    //                 address_Mnumber,
    //                 address_lane,
    //                 address_road,
    //                 address_district,
    //                 address_city,
    //                 province,
    //                 postcode,
    //                 phone_number,
    //                 email,
    //                 facebook,
    //                 line,
    //                 id_purchase_amount,
    //                 purchase_week,
    //                 id_business_type,
    //                 customer_code,
    //                 customer_nickname,
    //                 marker,
    //                 type)
    //                 values (?, ?,?, ?,?, ?,?, ?,?, ?,?, ?,?, ?,?, ?,?,?,?,?,?,?,?,?,?,?,?,?,?
    //                 )',
    //                 [$request->pnoun,
    //                 $request->customer_name,
    //                 $request->customer_shop_name,
    //                 $request->customer_shop_open,
    //                 $request->customer_shop_close,
    //                 $request->customer_shop_day_close,
    //                 $request->customer_shop_time_recieve_product,
    //                 $request->datepick,
    //                 $request->id_card_number1,
    //                 $request->address,
    //                 $request->address_M,
    //                 $request->address_Mnumber,
    //                 $request->address_lane,
    //                 $request->address_road,
    //                 $request->address_district,
    //                 $request->address_city,
    //                 $request->province,
    //                 $request->postcode,
    //                 $request->phone_number,
    //                 $request->email,
    //                 $request->facebook,
    //                 $request->line,
    //                 $request->purchase,
    //                 $request->purchase_week,
    //                 $request->business_type,
    //                 $request->customer_code,
    //                 $request->customer_nickname,
    //                 $request->marker,
    //                 $request->customer_type]);


    //     return redirect('customer/get_all');
    // }

    public function indexEdit($id){
        
        $data_customer = DB::select("SELECT
            tb_customer.id,
            tb_customer.pnoun,
            tb_customer.customer_name,
            tb_customer.shop_name,
            tb_customer.customer_shop_open,
            tb_customer.customer_shop_close,
            tb_customer.customer_shop_day_close,
            tb_customer.customer_shop_time_recieve_product,
            tb_customer.datepick,
            tb_customer.id_card_number,
            tb_customer.address,
            tb_customer.address_M,
            tb_customer.address_Mnumber,
            tb_customer.address_lane,
            tb_customer.address_road,
            tb_customer.address_district,
            tb_customer.address_city,
            tb_customer.province,
            tb_customer.postcode,
            tb_customer.phone_number,
            tb_customer.email,
            tb_customer.facebook,
            tb_customer.line,
            tb_customer.id_purchase_amount,
            tb_customer.purchase_week,
            tb_customer.id_business_type,
            tb_customer.customer_code,
            tb_customer.customer_nickname,
            tb_customer.marker,
            tb_customer.type as customer_type,
            tb_customer_purchase_amount.range_money,
            tb_customer_business.business,
            tb_customer_business.type,
            tb_customer.fax,
            tb_customer.address_send,
            tb_customer.address_M_send,
            tb_customer.address_Mnumber_send,
            tb_customer.address_lane_send,
            tb_customer.address_road_send,
            tb_customer.address_district_send,
            tb_customer.address_city_send,
            tb_customer.province_send,
            tb_customer.postcode_send,
            tb_customer.phone_number_send,
            tb_customer.email_send,
            tb_customer.facebook_send,
            tb_customer.line_send,
            tb_customer.fax_send,
            tb_customer.vat,
            tb_customer.creditor,
            tb_customer.new_customer_code,
            tb_customer.new_marker
        FROM
            tb_customer
            LEFT JOIN tb_customer_purchase_amount ON tb_customer.id_purchase_amount = tb_customer_purchase_amount.id
            LEFT JOIN tb_customer_business ON tb_customer.id_business_type = tb_customer_business.id 
        WHERE
            tb_customer.id = $id
        ORDER BY
            tb_customer.id ASC
        ", []);
        // return $data_customer;
        $purchase_amount = DB::select('SELECT * from tb_customer_purchase_amount', []);
        $customer_business = DB::select('SELECT * FROM tb_customer_business ORDER BY tb_customer_business.type ASC', []);
        $customer_group = DB::select("SELECT * FROM standard_group");
        $customer_type = DB::select('SELECT * from tb_order_type WHERE tb_order_type.type IS NOT NULL');
        $standard_price_customer = DB::select("SELECT * FROM standard_prile_pig_customer WHERE id_customer = ?",[$data_customer[0]->customer_code]);
        
        return view('customer.customerEdit',compact('data_customer','purchase_amount','customer_business','id','customer_type','customer_group','standard_price_customer'));
    }

    public function saveEdit(Request $request){
        // return $request;
        $validate = \Validator::make($request->all(), [
            'marker' => 'required|unique:tb_customer,marker,' . $request->id, 
            'customer_code' => 'required|unique:tb_customer,customer_code,' . $request->id, 
           
        ], [
            'marker.unique' => 'อักษรย่อลูกค้า ต้องไม่ซ้ำ',
            'customer_code.unique' => 'รหัสพนักงาน ต้องไม่ซ้ำ',
        ]);
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate->errors())->withInput($request->all());
        }

        
        DB::insert("UPDATE tb_customer set
                                            pnoun = '$request->pnoun',
                                            customer_name = '$request->customer_name',
                                            shop_name = '$request->customer_shop_name',
                                            customer_shop_open = '$request->customer_shop_open',
                                            customer_shop_close = '$request->customer_shop_close',
                                            customer_shop_day_close = '$request->customer_shop_day_close',
                                            customer_shop_time_recieve_product = '$request->customer_shop_time_recieve_product',
                                            datepick = '$request->datepick',
                                            id_card_number = '$request->id_card_number1',
                                            address = '$request->address',
                                            address_M = '$request->address_M',
                                            address_Mnumber = '$request->address_Mnumber',
                                            address_lane = '$request->address_lane',
                                            address_road = '$request->address_road',
                                            address_district = '$request->address_district',
                                            address_city = '$request->address_city',
                                            province = '$request->province',
                                            postcode = '$request->postcode',
                                            phone_number = '$request->phone_number',
                                            email = '$request->email',
                                            facebook = '$request->facebook',
                                            line = '$request->line',
                                            id_purchase_amount = '$request->purchase',
                                            purchase_week = '$request->purchase_week',
                                            id_business_type = '$request->business_type',
                                            customer_code = '$request->customer_code',
                                            customer_nickname = '$request->customer_nickname',
                                            marker = '$request->marker',
                                            type = '$request->customer_type',
                                            tb_customer.fax = '$request->fax',
                                            tb_customer.address_send = '$request->address_send',
                                            tb_customer.address_M_send = '$request->address_M_send',
                                            tb_customer.address_Mnumber_send = '$request->address_Mnumber_send',
                                            tb_customer.address_lane_send = '$request->address_lane_send',
                                            tb_customer.address_road_send = '$request->address_road_send',
                                            tb_customer.address_district_send = '$request->address_district_send',
                                            tb_customer.address_city_send = '$request->address_city_send',
                                            tb_customer.province_send = '$request->province_send',
                                            tb_customer.postcode_send = '$request->postcode_send',
                                            tb_customer.phone_number_send = '$request->phone_number_send',
                                            tb_customer.email_send = '$request->email_send',
                                            tb_customer.facebook_send = '$request->facebook_send',
                                            tb_customer.line_send = '$request->line_send',
                                            tb_customer.fax_send = '$request->fax_send',
                                            tb_customer.vat = '$request->vat',
                                            tb_customer.new_customer_code = '$request->new_customer_code',
                                            tb_customer.new_marker = '$request->new_marker'
                                            WHERE id = '$request->id'"
                        );
        
        $chack = DB::select("SELECT id_customer FROM standard_prile_pig_customer WHERE id_customer = '$request->customer_code'");
        // return $chack;
        
        if( !empty($chack) ){
            DB::update("UPDATE standard_prile_pig_customer set fattening = '$request->fattening',
                                                                pig_5 = '$request->pig_5',
                                                                pig_egg = '$request->pig_egg',
                                                                father = '$request->father',
                                                                mother = '$request->mother',
                                                                carcass = '$request->carcass',
                                                                dead_pig = '$request->dead_pig',
                                                                slice = '$request->slice',
                                                                standard_prile_pig_customer.trim = '$request->trim'
                                WHERE id_customer = '$request->customer_code'");
        }else{
            DB::insert("INSERT INTO standard_prile_pig_customer(fattening,pig_5,pig_egg,father,mother,carcass,dead_pig,id_customer)VALUES(?,?,?,?,?,?,?,?)
                                                            ",[$request->fattening,$request->pig_5,$request->pig_egg,$request->father,$request->mother,$request->carcass,$request->dead_pig,$request->customer_code]);
        }

        return redirect('customer/get_all');
    }

    public function customer_group(){

       $standard_price_m = DB::select("SELECT * FROM standard_price WHERE standard_price.type = 'm' ORDER BY standard_price.created_at DESC LIMIT 1");
       $standard_price_s = DB::select("SELECT * FROM standard_price WHERE standard_price.type = 's' ORDER BY standard_price.created_at DESC LIMIT 1");
       $standard_price_t = DB::select("SELECT * FROM standard_price WHERE standard_price.type = 't' ORDER BY standard_price.created_at DESC LIMIT 1");

       $standard_price_sx = DB::select("SELECT * FROM standard_price WHERE standard_price.type = 'sx' ORDER BY standard_price.created_at DESC LIMIT 1");
       $standard_price_sxt = DB::select("SELECT * FROM standard_price WHERE standard_price.type = 'sxt' ORDER BY standard_price.created_at DESC LIMIT 1");

       $standard_price_c = DB::select("SELECT * FROM standard_price WHERE standard_price.type = 'c' ORDER BY standard_price.created_at DESC LIMIT 1");
       $standard_price_5 = DB::select("SELECT * FROM standard_price WHERE standard_price.type = '5' ORDER BY standard_price.created_at DESC LIMIT 1");
       $standard_price_f = DB::select("SELECT * FROM standard_price WHERE standard_price.type = 'f' ORDER BY standard_price.created_at DESC LIMIT 1");
       $standard_price_mt = DB::select("SELECT * FROM standard_price WHERE standard_price.type = 'mt' ORDER BY standard_price.created_at DESC LIMIT 1");
       $standard_price_e = DB::select("SELECT * FROM standard_price WHERE standard_price.type = 'e' ORDER BY standard_price.created_at DESC LIMIT 1");
       $standard_price_sc = DB::select("SELECT * FROM standard_price WHERE standard_price.type = 'sc' ORDER BY standard_price.created_at DESC LIMIT 1");
       $standard_price_d = DB::select("SELECT * FROM standard_price WHERE standard_price.type = 'd' ORDER BY standard_price.created_at DESC LIMIT 1");

       $standard_price_com = DB::select("SELECT * FROM standard_price WHERE standard_price.type = 'com' ORDER BY standard_price.created_at DESC LIMIT 1");


       $weight = DB::select("SELECT * FROM standard_weight");

        $customer = DB::select("SELECT
                                    tb_customer.customer_code,
                                    tb_customer.customer_name,
                                    tb_customer.customer_nickname,
                                    standard_prile_pig_customer.fattening,
                                    standard_prile_pig_customer.pig_5,
                                    standard_prile_pig_customer.pig_egg,
                                    standard_prile_pig_customer.father,
                                    standard_prile_pig_customer.mother,
                                    standard_prile_pig_customer.carcass,
                                    standard_prile_pig_customer.dead_pig
                                FROM
                                    standard_prile_pig_customer
                                    INNER JOIN tb_customer ON standard_prile_pig_customer.id_customer = tb_customer.customer_code");

        return view('customer/customer_group',compact('standard_price_m','standard_price_s','standard_price_t','customer','standard_price_c','standard_price_5','standard_price_f',
                    'standard_price_mt','standard_price_e','standard_price_sc','standard_price_d','standard_price_com','standard_price_sx','standard_price_sxt','weight'));
    }

    public function get_standard_group(){
        $get_standard_group = DB::select("SELECT
                                    tb_customer.customer_code,
                                    tb_customer.customer_name,
                                    tb_customer.customer_nickname,
                                    standard_prile_pig_customer.fattening,
                                    standard_prile_pig_customer.pig_5,
                                    standard_prile_pig_customer.pig_egg,
                                    standard_prile_pig_customer.father,
                                    standard_prile_pig_customer.mother,
                                    standard_prile_pig_customer.carcass,
                                    standard_prile_pig_customer.dead_pig,
                                    standard_prile_pig_customer.slice,
                                    standard_prile_pig_customer.trim
                                FROM
                                    standard_prile_pig_customer
                                    INNER JOIN tb_customer ON standard_prile_pig_customer.id_customer = tb_customer.customer_code");

        return Datatables::of($get_standard_group)->addIndexColumn()->make(true);

    }

    public function add_standard_group(Request $request){
        
        for($i=0 ; $i<$request->max ; $i++){
            if(!empty($request->list_group[$i])){
                $price_list =  DB::select("SELECT price_list FROM standard_price_list_group WHERE id = ?",[$request->list_group[$i]]);
                DB::insert("INSERT INTO standard_group(standard_group.group_type, standard_group.group_type_name, standard_group.group_name, standard_group.price_pig_on_sale)
                                        VALUES(?,?,?,?)",[ $request->list_group[$i],$price_list[0]->price_list,$request->name_group,$request->prict_list_group[$i] ]);
            }
        }
        
        return redirect('customer/customer_group');
    }

    public function add_standard_weight(Request $request){

        if( !empty($request->standard_period) && !empty($request->standard_price) ){
            for($i = 0 ; $i < count($request->standard_period) ; $i++){
                DB::insert("INSERT INTO standard_weight(standard_weight.standard_period, standard_weight.standard_price) VALUES(?,?)",[$request->standard_period[$i], $request->standard_price[$i]]);
            }
        }
        
        return redirect('customer/customer_group');
    }

    public function edit_standard_weight(Request $request){

        if( !empty($request->standard_period) && !empty($request->standard_price) ){
            DB::update("UPDATE standard_weight SET standard_weight.standard_period = ?, standard_weight.standard_price = ? WHERE standard_weight.id = ?",[$request->standard_period,$request->standard_price,$request->id]);
            // for($i = 0 ; $i < count($request->standard_period) ; $i++){
            //     DB::insert("INSERT INTO standard_weight(standard_weight.standard_period, standard_weight.standard_price) VALUES(?,?)",[$request->standard_period[$i], $request->standard_price[$i]]);
            // }
        }
        // return $request;
        return redirect('customer/customer_group');
    }

    public function add_type(Request $request){
        if( !empty($request->type) ){
            for($i = 0 ; $i < count($request->type) ; $i++){
                DB::insert("INSERT INTO standard_price_list_group(standard_price_list_group.price_list) VALUES(?)",[$request->type[$i] ]);
            }
        }
        // return $request;
        return redirect('customer/customer_group');
    }

    public function edit_standard_price($id,Request $request){
        // return $id;
        DB::insert("INSERT INTO standard_price(standard_price.standard_price,standard_price.status,standard_price.type,standard_price.created_at) VALUES(?,?,?,?)",[$request->price,'A',$id,now()]);
        return Redirect::back();
    }
}
