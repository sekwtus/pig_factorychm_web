<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\product;

class ProductController extends Controller
{
    public function product()
    {
        $product = product::product();
        // return $product;
        return view('product.product', compact('product'));
    }

    public function product_add_main()
    {
        $product_list = product::product_list();
        // return $product;
        return view('product.product_add_main',compact('product_list'));
    }

    public function product_view_order($product_no)
    {
        // return $product_no;
        $sql = "SELECT time_in,customer_name,amount,product_type,note 
        FROM product_list JOIN product ON product_list.product_no = product.product_no WHERE product_list.product_no = '{$product_no}'";

        $product_list = DB::select($sql,[]);;
        return view('product.product_view_order',compact('product_list'));
    }

    public function product_add(Request $request)
    {
        // return($request);
        $sql = "INSERT INTO product(product_no) value ('$request->no')"; 
        DB::insert($sql,[]);

        foreach($request->txtCustomer as $i => $value){
            // echo $request->txtCustomer[$i]."<br>";
            $sql = "INSERT INTO product_list(product_no,customer_name,amount,product_type,note) 
            value ('{$request->no}','{$request->txtCustomer[$i]}','{$request->txtAmount[$i]}','{$request->ddlType[$i]}','{$request->txtNote[$i]}')";
            DB::select($sql,[]);
            // value "(".$request->txtCustomer[$i].",".$request->txtAmount[$i].",".$request->ddlType[$i].
            // ",".$request->txtNote[$i].")";
        }
        return redirect('product');
    }

    
    public function product_del($product_no)
    {
        // return $product_no;
        DB::delete("DELETE FROM product WHERE product_no = '$product_no'", []);
        DB::delete("DELETE FROM product_list WHERE product_no = '$product_no'", []);
        return redirect('/product');
    }

    public function show_product_edit($product_no)
    {
        // return $product_no;
        $sql = "SELECT * 
                FROM product_list 
                JOIN product 
                ON product_list.product_no = product.product_no 
                WHERE product_list.product_no = '$product_no'
			   ";
        
        $product_list = DB::select($sql,[]);
        
        return view('product.product_edit',compact('product_list','product_no'));     
        
    }
    
    public function product_edit(Request $request)
    {
        // return $product_no;
        $name = $request->txtCustomer; 
        $amount = $request->txtAmount; 
        $product_type = $request->ddlType; 
        $note = $request->txtNote; 
        $no = $request->no;
        
         
        foreach ($request->txtCustomer as $id => $val) {
            //  return $id;s
            $sql = "SELECT * FROM product_list  WHERE list_id = '$id'";
            $check =  DB::select($sql,[]);
            // return $check;
            if($check != null){
                DB::update("UPDATE product_list  SET 
                    customer_name = '{$name[$id]}', 
                    amount = '{$amount[$id]}',
                    product_type = '{$product_type[$id]}',
                    note = '{$note[$id]}' 
                    WHERE list_id = '$id'
                ");
                
            }else{

                DB::insert("INSERT INTO product_list (product_no,customer_name,amount,product_type,note)
                    VALUES ('{$no}','{$name[$id]}','{$amount[$id]}','{$product_type[$id]}','{$note[$id]}') 
                ");
            }
        }
        return redirect('product')->with('success','แก้ไขข้อมูลใบวางบิลเรียบร้อย');
       
    }

    public function deleteDetail(Request $request)
    {
        // return $request;
    DB::delete("DELETE FROM product_list WHERE list_id = $request->id",[]);
    return 'ลบข้อมูลเรียบร้อย';
    }

    public function product_report()
    {
        
        return view('product.product_report');
    }


    
    public function index_product()
    {
        return view('product.index_product');
    }
}
