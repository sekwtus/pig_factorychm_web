<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;
use Illuminate\Support\Facades\Hash;
use User;
use Illuminate\Support\Facades\Redirect;
use Auth;


class setting extends Controller
{
    public function getCustomerBusiness(){
        $type_of_business = DB::select('SELECT
                    tb_customer_business.type
                    FROM
                    tb_customer_business
                    GROUP BY
                    tb_customer_business.type
                    ORDER BY
                    tb_customer_business.type ASC');
        return view('setting.customer_business',compact('type_of_business'));
    }

    public function ajaxCustomerBusiness(){
        $customer_business = DB::select('SELECT * FROM tb_customer_business ORDER BY tb_customer_business.type ASC', []);
        return Datatables::of($customer_business)->addIndexColumn()->make(true);
    }

    public function customerBusinessSave(Request $request){
        $request->type == '' ? $type = $request->new_type:$type = $request->type;

        DB::insert('INSERT into tb_customer_business
                    (type,
                    business)
                    values (?,?)',
                    [$type,
                    $request->business]);

        return redirect('setting/customer_business');
    }

    //part of pig
    public function getPartPig(){
        return view('setting.part_of_pig');
    }

    public function standard_group_setting(){
        $standard_group = DB::select("SELECT
                    master_price.id,
                    master_price.standard_group_id,
                    master_price.standard_weight_id,
                    standard_group.group_name,
                    standard_group.price_on_sale,
                    standard_weight.standard_period,
                    standard_weight.standard_price,
                    standard_weight.type,
                    (standard_weight.standard_price + standard_group.price_on_sale) as price
                    FROM
                    master_price
                    LEFT JOIN standard_group ON master_price.standard_group_id = standard_group.id
                    LEFT JOIN standard_weight ON master_price.standard_weight_id = standard_weight.id
                    ");
        return view('setting.standard_group_setting',compact('standard_group'));
    }

    public function setting_user(){
        $type_users = DB::select("SELECT * from type_user ");
        $branch = DB::select("SELECT * from tb_branch ");
        return view('setting.user.add_user', compact('type_users','branch'));
        
    }
    public function show_users(){
        $users = DB::select("SELECT
        users.*,
        type_user.type_name,
        type_user.description
        FROM
        users
        LEFT JOIN type_user ON users.id_type = type_user.id
        ");
        return Datatables::of($users)->make(true);
    }

    public function save_users(Request $request){

        $validate = \Validator::make($request->all(), [
            'name'          => 'unique:users',
        ], [
            'name.unique'  => 'ชื่อผู้ใช้งานซ้ำ กรุณากำหนดใหม่',
        ]);
    
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate->errors())->withInput($request->all());
        }

        // if ($request->hasFile('image')){
        //     $filename = Auth::user()->name .'_'. $request->id .'_'. Carbon::now()->toDateString() .'_' . str_random(8) . '.' . $request->file('image')->getClientOriginalExtension();
        //     $request->file('image')->move(public_path('/file'), $filename);
        //     $picture_user = $filename;
        // }
        // else
        // {
        // $picture_user = null;
        // }

        // return $picture_user;

        DB::insert("INSERT INTO users(name,fname,id_type,phone_number,password,real_password) values(?,?,?,?,?,?)"
         ,[$request->name,$request->fname,$request->user_type_id,$request->tel,hash::make($request->password),$request->password]);
        return back();
    }

    public function edit_users(Request $request){
       
        DB::update("UPDATE users SET name = ?, fname = ?,id_type = ?, phone_number = ? WHERE id = ?"
        ,[$request->name,$request->fname,$request->user_type_id,$request->tel,$request->id]);
         return back();
    }

    public function get_profile(Request $request){
        $profile = DB::select("SELECT * from users WHERE id = '$request->id'");

        return $profile;
    }

    public function update_profile(Request $request){
       
        DB::update("UPDATE users SET name = ?, fname = ?, phone_number = ? ,password = ?, real_password = ? WHERE id = ?"
        ,[$request->name,$request->fname,$request->tel,hash::make($request->password),$request->password,$request->id]);
         return back();
    }


    //shop
    public function setting_shop(Request $request){

        $shop = DB::select("SELECT * from tb_shop");
        return view('setting.shop',compact('shop'));
    }

    public function show_shop(){

        $shop = DB::select("SELECT * FROM tb_shop");
        return Datatables::of($shop)->make(true);
    }

    public function save_shop(Request $request){

        $validate = \Validator::make($request->all(), [
            'shop_code'          => 'unique:tb_shop',
        ], [
            'shop_code.unique'  => 'รหัสร้านค้าซ้ำ กรุณากำหนดใหม่',
        ]);
    
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate->errors())->withInput($request->all());
        }

        // if ($request->hasFile('image')){
        //     $filename = Auth::user()->name .'_'. $request->id .'_'. Carbon::now()->toDateString() .'_' . str_random(8) . '.' . $request->file('image')->getClientOriginalExtension();
        //     $request->file('image')->move(public_path('/file'), $filename);
        //     $picture_user = $filename;
        // }
        // else
        // {
        // $picture_user = null;
        // }

        // return $picture_user;

        DB::insert("INSERT INTO tb_shop(shop_code,shop_name,shop_description,status,created_by,modified_by) values(?,?,?,?,?,?)"
         ,[$request->shop_code,$request->shop_name,$request->shop_description,$request->status,1,1]);
        return back();
    }

    public function edit_shop(Request $request){

        DB::update("UPDATE tb_shop SET shop_code = ?, shop_name = ?,shop_description = ?, status = ? WHERE id = ?"
        ,[$request->shop_code,$request->shop_name,$request->shop_description,$request->status,$request->id]);
         return back();
    }

    public function delete_shop(Request $request){

        DB::delete("DELETE FROM tb_shop WHERE id = ?"
        ,[$request->id]);
         return back();
    }

    //product
    public function setting_product(Request $request){
        
        $product_type = DB::select("SELECT id AS product_type_id, product_type_name FROM tb_product_type");
        $product = DB::select("SELECT * from tb_product");
        return view('setting.product',compact('product', 'product_type'));
    }

    public function show_product(){

        // $product = DB::select("SELECT
        // tb_product.*,
        // tb_product_type.id,
        // tb_product_type.product_type_name
        // FROM
        // tb_product
        // LEFT JOIN tb_product_type ON tb_product.product_type_id = tb_product_type.id
        // ");

        $product = DB::select("SELECT tb_product.id AS id, tb_product.product_code, tb_product.product_name, tb_product.cost, tb_product.price, tb_product.recognize, tb_product.unit, tb_product.note, tb_product.picture, tb_product.status, tb_product_type.id AS product_type_id, tb_product_type.product_type_name FROM tb_product LEFT JOIN tb_product_type ON tb_product.product_type_id = tb_product_type.id");
        

        //$shop = DB::select("SELECT * FROM tb_product");
        return Datatables::of($product)->make(true);
    }

    public function save_product(Request $request){

        $validate = \Validator::make($request->all(), [
            'product_code'          => 'unique:tb_product',
        ], [
            'product_code.unique'  => 'รหัสสินค้าซ้ำ กรุณากำหนดใหม่',
        ]);
    
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate->errors())->withInput($request->all());
        }

        // if ($request->hasFile('image')){
        //     $filename = Auth::user()->name .'_'. $request->id .'_'. Carbon::now()->toDateString() .'_' . str_random(8) . '.' . $request->file('image')->getClientOriginalExtension();
        //     $request->file('image')->move(public_path('/file'), $filename);
        //     $picture_user = $filename;
        // }
        // else
        // {
        // $picture_user = null;
        // }

        // return $picture_user;

        DB::insert("INSERT INTO tb_product(product_code,product_name,product_type_id,cost,price,recognize,unit,note,picture,status) values(?,?,?,?,?,?,?,?,?,?)"
         ,[$request->product_code,$request->product_name,$request->product_type_id,$request->cost,$request->price,$request->recognize,$request->unit,$request->note,$request->picture,$request->status]);
        return back();
    }

    public function edit_product(Request $request){

        DB::update("UPDATE tb_product SET product_code = ?, product_name = ?,product_type_id = ?, cost = ?, price=?, recognize=?,unit=?, note=?, picture=?,status=? WHERE id = ?"
        ,[$request->product_code,$request->product_name,$request->product_type_id,$request->cost,$request->price,$request->recognize,$request->unit,$request->note,$request->picture,$request->status,$request->id]);
        return back();
    }

    public function delete_product(Request $request){

        DB::delete("DELETE FROM tb_product WHERE id = ?"
        ,[$request->id]);
         return back();
    }

    //promotion
    public function setting_promotion(Request $request){
        
        $promotion = DB::SELECT("SELECT
            tb_promotion.id, 
            tb_promotion.promotion_name, 
            tb_promotion.produce_code, 
            tb_promotion.new_code, 
            tb_promotion.min, 
            tb_promotion.max, 
            tb_promotion.start_date, 
            tb_promotion.stop_date, 
            tb_promotion.`group`, 
            tb_promotion.standard_price, 
            tb_promotion.discount_price,
            tb_promotion.standard_price-tb_promotion.discount_price AS total_price,
            DATEDIFF(stop_date, NOW()) AS remain
        FROM
            tb_promotion");
        return view('setting.promotion', compact('promotion'));
    }

    public function setting_promotion_add(Request $request){
        
        DB::TABLE('tb_promotion')
            ->INSERT([
                'promotion_name' => $request['promotion_name'], 
                'produce_code' => $request['produce_code'], 
                'new_code' => $request['new_code'], 
                'min' => $request['min'], 
                'max' => $request['max'], 
                'start_date' => $request['start_date'], 
                'stop_date' => $request['stop_date'], 
                'group' => $request['group'], 
                'standard_price' => $request['standard_price'], 
                'discount_price' => $request['discount_price']
            ]);
        
        return Redirect::to('setting_promotion')->with('message_success', 'เพิ่ม 1 รายการเรียบร้อยแล้ว');
    }

    public function setting_promotion_update(Request $request){
        
        DB::TABLE('tb_promotion')
            ->WHERE('id', $request['id'])
            ->UPDATE([
                'promotion_name' => $request['promotion_name'], 
                'produce_code' => $request['produce_code'], 
                'new_code' => $request['new_code'], 
                'min' => $request['min'], 
                'max' => $request['max'], 
                'start_date' => $request['start_date'], 
                'stop_date' => $request['stop_date'], 
                'group' => $request['group'], 
                'standard_price' => $request['standard_price'], 
                'discount_price' => $request['discount_price']
            ]);
        
        return Redirect::to('setting_promotion')->with('message_success', 'แก้ไข 1 รายการเรียบร้อยแล้ว');
    }

    public function setting_promotion_delete(Request $request){
        
        DB::TABLE('tb_promotion')
            ->WHERE('id', $request['id'])
            ->DELETE();
        
        return Redirect::to('setting_promotion')->with('message_success', 'ลบ 1 รายการเรียบร้อยแล้ว');
    }

    //receipt
    public function setting_receipt(Request $request){
        
        $product_type = DB::select("SELECT id AS product_type_id, product_type_name FROM tb_product_type");
        $product = DB::select("SELECT * from tb_product");
        return view('setting.receipt',compact('product', 'product_type'));
    }

    public function setting_receipt_data(Request $request){
        
        $receipt = DB::select("SELECT
        tb_receipt.id,
        tb_receipt.receipt_no,
        tb_shop.shop_name,
        tb_receipt.receipt_date,
        ( SELECT SUM( tb_receipt_item.amount_price ) FROM tb_receipt_item WHERE tb_receipt.id = tb_receipt_item.receipt_id ) AS sum_value,
        ( SELECT COUNT( id ) FROM tb_receipt_item WHERE tb_receipt.id = tb_receipt_item.receipt_id ) AS CountReceipt 
        FROM
        tb_receipt
        INNER JOIN tb_shop ON tb_receipt.shop_id = tb_shop.id
        INNER JOIN tb_receipt_item ON tb_receipt.id = tb_receipt_item.receipt_id 
        GROUP BY
        tb_receipt.receipt_no
        ");
        return Datatables::of($receipt)->make(true);
    }

    public function receipt_detail($id){
        
        $receipt = DB::select("SELECT
        tb_receipt_item.id,
        tb_product.product_name,
        tb_receipt_item.qty,
        tb_receipt_item.price,
        tb_receipt_item.amount,
        tb_product.picture,
        tb_product.unit,
        tb_shop.shop_name 
        FROM
        tb_receipt_item
        INNER JOIN tb_product ON tb_receipt_item.product_id = tb_product.id
        INNER JOIN tb_receipt ON tb_receipt_item.receipt_id = tb_receipt.id
        INNER JOIN tb_shop ON tb_receipt.shop_id = tb_shop.id 
        WHERE
        tb_receipt_item.receipt_id = $id
        ");

        $shop = DB::SELECT("SELECT
        tb_shop.shop_name
        FROM
        tb_receipt
        INNER JOIN
        tb_shop
        ON tb_receipt.shop_id = tb_shop.id
        WHERE tb_receipt.id = $id
        LIMIT 1
        ");

        return view('setting.receipt_detail',compact('receipt','shop'));
    }


    //shop2
    public function shop_index(){

        $shop = DB::SELECT("SELECT
        tb_shop.id,
        tb_shop.shop_name,
        tb_shop.`status`,
        tb_shop.shop_type_id, 
	    tb_shop.payment_type_id, 
	    tb_shop.shop_code, 
	    tb_shop.marker, 
	    tb_shop.shop_description, 
	    tb_shop.created_by, 
	    tb_shop.modified_date,
        ( SELECT COUNT( id ) FROM tb_product_location WHERE tb_shop.id = tb_product_location.shop_id ) AS CountProduct, 
        ( SELECT COUNT( id ) FROM tb_tr_users_shop WHERE tb_shop.id = tb_tr_users_shop.shop_id ) AS CountCrew
        FROM
        tb_shop");

        $shop_type = DB::SELECT("SELECT
        tb_shop_type.id, 
        tb_shop_type.shop_type_name
        FROM
        tb_shop_type
        ");

        return view('setting.shop2', compact('shop','shop_type'));
    }

    public function shop_add(Request $request){
        
        DB::TABLE('tb_shop')
        ->INSERT([
            'shop_type_id' => $request['shop_type_id'], 
            'payment_type_id' => $request['payment_type_id'], 
            'shop_code' => $request['shop_code'], 
            'marker' => $request['marker'], 
            'shop_name' => $request['shop_name'], 
            'shop_description' => $request['shop_description'], 
            'status' => $request['status'],  
            'created_by' => $request['created_by'], 
            'modified_by' => $request['modified_by'], 
        ]);
        return Redirect::to('setting/shop')->with('message_success', 'เพิ่ม 1 ร้านค้า เรียบร้อยแล้ว');
    }

    public function shop_update(Request $request){
        
        DB::TABLE('tb_shop')
            ->WHERE('id', $request['id'])
            ->UPDATE([
                'shop_type_id' => $request['shop_type_id'], 
                'payment_type_id' => $request['payment_type_id'], 
                'shop_code' => $request['shop_code'], 
                'marker' => $request['marker'], 
                'shop_name' => $request['shop_name'], 
                'shop_description' => $request['shop_description'], 
                'status' => $request['status'],  
                'created_by' => $request['created_by'], 
                'modified_by' => $request['modified_by'],
            ]);
        
        return Redirect::to('setting/shop')->with('message_success', 'แก้ไข 1 ร้านค้า เรียบร้อยแล้ว');
    }

    public function shop_delete(Request $request){
        
        DB::TABLE('tb_shop')
            ->WHERE('id', $request['id'])
            ->DELETE();
        
        return Redirect::to('setting/shop')->with('message_success', 'ลบ 1 ร้านค้า เรียบร้อยแล้ว');
    }

    public function shop_product_index($id){
        
        //ชื่อร้านค้า
        $shop = DB::SELECT("SELECT
        tb_shop.id,
        tb_shop.shop_name
        FROM
        tb_shop
        WHERE tb_shop.id = $id
        ");

        $list_product = DB::SELECT("SELECT
        tb_product.id,
        tb_product.product_name
        FROM
        tb_product
        ");
        
        // รายละเอียด
        $product = DB::SELECT("SELECT
        tb_shop.id, 
        tb_shop.shop_name, 
        tb_product.product_name,
        tb_product.price,
	    tb_product.unit, 
        tb_product_location.id AS product_id,
        tb_product_location.qty, 
        tb_product_location.weight,
        tb_product_location.page
        FROM
        tb_product_location
        INNER JOIN
        tb_shop
        ON tb_product_location.shop_id = tb_shop.id
        INNER JOIN
        tb_product
        ON tb_product_location.product_id = tb_product.id
        WHERE tb_product_location.shop_id = $id
        ");

        return view('setting.shop_product_detail', compact('shop','list_product','product'));
    }

    public function shop_product_add(Request $request){
        
        DB::TABLE('tb_product_location')
        ->INSERT([
            'shop_id' => $request['shop_id'], 
            'product_id' => $request['product_id'], 
            'qty' => $request['qty'], 
            'weight' => $request['weight'], 
            'page' => $request['page'], 
            'status' => $request['status'], 
            'user_created' => $request['user_created'],  
            'modified_by' => $request['modified_by'], 
        ]);
        return Redirect()->back()->with('message_success', 'เพิ่ม 1 สินค้า เรียบร้อยแล้ว');
    }

    public function shop_product_update(Request $request){
        
        DB::TABLE('tb_product_location')
            ->WHERE('id', $request['product_id'])
            ->UPDATE([
                'qty' => $request['qty'],
            ]);

        return Redirect()->back()->with('message_success', 'แก้ไข 1 สินค้า เรียบร้อยแล้ว');

    }

    public function shop_product_delete(Request $request){
        
        DB::TABLE('tb_product_location')
            ->WHERE('id', $request['product_id'])
            ->DELETE();
        return Redirect()->back()->with('message_success', 'ลบ 1 สินค้า เรียบร้อยแล้ว');
    }


    public function shop_crew_index($id){

        $user = DB::SELECT("SELECT
        tb_users.id, 
        tb_users.position_id, 
        tb_users.department_id, 
        tb_users.title, 
        tb_users.users_code, 
        tb_users.users_pass, 
        tb_users.created_by, 
        tb_users.`names`, 
        tb_users.address, 
        tb_users.telephone, 
        tb_users.email, 
        tb_users.remark, 
        tb_users.sex, 
        tb_users.`status`, 
        tb_users.image_string, 
        tb_users.users_login, 
        tb_users.created_date, 
        tb_users.modified_by, 
        tb_users.modified_date
        FROM
        tb_users");
        
        $crew = DB::SELECT("SELECT
        tb_users.id,
        tb_tr_users_shop.shop_id,
        tb_users.`names`,
        tb_users.`status`, 
	    tb_users.image_string 
        FROM
        tb_tr_users_shop
        INNER JOIN tb_users ON tb_tr_users_shop.users_id = tb_users.id
        INNER JOIN tb_shop ON tb_tr_users_shop.shop_id = tb_shop.id
        WHERE tb_shop.id = $id
        ");
    
        return view('setting.shop_crew_detail', compact('user','crew'));
    }

    public function shop_crew_add(Request $request){

        DB::TABLE('tb_users')
        ->INSERT([
            'position_id' => $request['position_id'], 
            'department_id' => $request['department_id'], 
            'users_code' => $request['users_code'], 
            'title' => $request['title'], 
            'users_pass' => $request['users_pass'], 
            'created_by' => $request['created_by'], 
            'names' => $request['names'], 
            'address' => $request['address'], 
            'telephone' => $request['telephone'], 
            'email' => $request['email'], 
            'remark' => $request['remark'], 
            'sex' => $request['sex'], 
            'status' => $request['status'],
            'image_string' => $request['image_string'],
            'users_login' => $request['users_login'],             
            'modified_by' => $request['modified_by'], 
        ]);

        $data = DB::SELECT("SELECT
        tb_users.id
        FROM
        tb_users
        WHERE id=(SELECT max(id) FROM tb_users)
        ");
        //dd($data->id);

        DB::TABLE('tb_tr_users_shop')
        ->INSERT([
            'shop_id' => $request['shop_id'], 
            'users_id' => $data[0]->id, 
            'role' => $request['role'], 
            'status' => $request['status'], 
            'created_by' => $request['created_by'],              
            'modified_by' => $request['modified_by'], 
        ]);


        return Redirect()->back()->with('message_success', 'เพิ่ม 1 พนักงาน เรียบร้อยแล้ว');
    }

    public function shop_crew_update(Request $request){

        DB::TABLE('tb_users')
            ->WHERE('id', $request['id'])
            ->UPDATE([
                'position_id' => $request['position_id'], 
                'department_id' => $request['department_id'], 
                'users_code' => $request['users_code'], 
                'title' => $request['title'], 
                'users_pass' => $request['users_pass'], 
                'created_by' => $request['created_by'], 
                'names' => $request['names'],  
                'address' => $request['address'], 
                'email' => $request['email'],
                'remark' => $request['remark'],
                'sex' => $request['sex'],
                'status' => $request['status'],
                'image_string' => $request['image_string'],
                'users_login' => $request['users_login'],
                'modified_by' => $request['modified_by'],
            ]);
        
            return Redirect()->back()->with('message_success', 'แก้ไข 1 พนักงาน เรียบร้อยแล้ว');
    }

    public function shop_crew_delete(Request $request){

        DB::TABLE('tb_users')
            ->WHERE('id', $request['id'])
            ->DELETE();
        
            return Redirect()->back()->with('message_success', 'แก้ไข 1 พนักงาน เรียบร้อยแล้ว');
    }

    public function debug($order_number){
        $data = DB::select("SELECT
                wg_sku_weight_data.*,
                wg_weight_type.wg_type_name AS weighing_type 
            FROM
                wg_sku_weight_data
                LEFT JOIN wg_weight_type ON wg_sku_weight_data.weighing_type = wg_weight_type.id_wg_type 
            WHERE
                wg_sku_weight_data.lot_number = '$order_number'");
        return view('debug',compact('data','order_number'));
    }

    

    public function menu_permission(){

        $menu_main = DB::select("SELECT user_sub_menu.menu_main
            FROM  user_permission
            LEFT JOIN user_sub_menu ON user_permission.sub_menu_permission = user_sub_menu.id
            WHERE user_permission.user_type_id = ?
            GROUP BY user_sub_menu.menu_main" , [Auth::user()->id_type] 
        );
        
        $menu_parent = DB::select("SELECT  user_sub_menu.menu_parent 
            FROM  user_permission
            LEFT JOIN user_sub_menu ON user_permission.sub_menu_permission = user_sub_menu.id 
            WHERE user_permission.user_type_id = ?
            GROUP BY  user_sub_menu.menu_parent" , [Auth::user()->id_type] 
        );

        $sub_menu = DB::select("SELECT  user_sub_menu.menu_id 
            FROM user_permission
            LEFT JOIN user_sub_menu ON user_permission.sub_menu_permission = user_sub_menu.id 
            WHERE user_permission.user_type_id = ?
            GROUP BY  user_sub_menu.menu_id" , [Auth::user()->id_type] 
        );
        
        return array($menu_main,$menu_parent,$sub_menu);

    }

}
