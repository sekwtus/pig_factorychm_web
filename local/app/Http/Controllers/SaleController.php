<?php

namespace App\Http\Controllers;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\salepig;
use Illuminate\Support\Facades\Input;









class SaleController extends Controller
{
    public function index_sale()
    {
        return view('sale.index_sale');
    }


    //---------------Salepig-------------------
    public function salepig()
    {
        $sql = "SELECT * FROM `live_sale_order` order by id desc";

        $listpig = DB::select($sql,[]);


        return view('sale.salepig',compact('listpig'));
    }

    public function salepig_view($sale_no)
    {
        // dd($sale_no);
        // return $salepig_no;
        $id = $sale_no ;

        $sql = "SELECT *
                FROM live_sale_order_list
                JOIN live_sale_order
                ON live_sale_order_list.sale_no = live_sale_order.sale_no
                WHERE live_sale_order_list.sale_no = '$id'
                ORDER BY live_sale_order_list.list_id DESC
               ";

        $listpig = DB::select($sql,[]);
        // dd($listpig);

        return view('sale.salepig_view',compact('listpig','id'));

    }
    public function salepig_view_search(Request $search,$id)
    {

        if(isset($search->search)){
            $sql = "SELECT *
                    FROM live_sale_order_list
                    JOIN live_sale_order
                    ON live_sale_order_list.sale_no = live_sale_order.sale_no
                    WHERE live_sale_order_list.sale_no = '$id'
                    AND customer_name LIKE '%$search->search%'
                    ORDER BY live_sale_order_list.list_id DESC
                   ";
        $listpig = DB::select($sql,[]);

        if (count ( $listpig ) > 0)
        return view('sale.salepig_view',compact('listpig','id'));
        else
            $check = 1;
        return view('sale.salepig_view',compact('listpig','check','id'));
        }
        else{
            $sql = "SELECT *
                    FROM live_sale_order_list
                    JOIN live_sale_order
                    ON live_sale_order_list.sale_no = live_sale_order.sale_no
                    WHERE live_sale_order_list.sale_no = '$id'
                    ORDER BY live_sale_order_list.list_id DESC
                   ";
            $listpig = DB::select($sql,[]);
        }
        return view('sale.salepig_view',compact('listpig','id'));
    }

    public function show_addsalepig()
    {
        return view('sale.salepig-add');
    }

    public function salepig_add(Request $request)
    {
        $total = 0;

        foreach($request->txtCustomer as $i => $value){

            $sql = "INSERT INTO live_sale_order_list
            (sale_no,customer_name,amount,weight_range,note)
            value   ('{$request->no}',
                     '{$request->txtCustomer[$i]}',
                     '{$request->txtAmount[$i]}',
                     '{$request->txtWeight[$i]}',
                     '{$request->txtNote[$i]}'
                    )";
            DB::select($sql,[]);
            $total = $total + $request->txtAmount[$i];

        }

        $date =now();
        $sql = "INSERT INTO live_sale_order (sale_no,date,total) value ('$request->no','$date','$total')";
        DB::insert($sql,[]);
        return redirect('/salepig');
    }

    public function show_editsalepig($sale_no)
    {

        $no = $sale_no ;

        $sql = "SELECT *
                FROM live_sale_order_list
                JOIN live_sale_order
                ON live_sale_order_list.sale_no = live_sale_order .sale_no
                WHERE live_sale_order_list.sale_no = '$no'
			   ";

        $listpig = DB::select($sql,[]);

        return view('sale.salepig-edit',compact('listpig','no'));
    }


    public function salepig_edit(Request $request)
    {
        // return $request;
        $name = $request->txtCustomer;
        $amount = $request->txtAmount;
        $weight = $request->txtWeight;
        $note = $request->txtNote;
        $no = $request->no;




        foreach ($request->txtCustomer as $id => $val) {
            //  return $id;s
            $sql = "SELECT * FROM live_sale_order_list  WHERE list_id = '$id'";
            $check =  DB::select($sql,[]);
            // return $check;
            if($check != null){
                DB::update("UPDATE live_sale_order_list  SET
                    customer_name = '{$name[$id]}',
                    amount = '{$amount[$id]}',
                    weight_range = '{$weight[$id]}',
                    note = '{$note[$id]}'
                    WHERE list_id = '$id'
                ");

            }else{
                // dd(55);

                DB::insert("INSERT INTO live_sale_order_list (customer_name,weight_range,amount,note,sale_no)
                    VALUES ('{$name[$id]}','{$weight[$id]}','{$amount[$id]}','{$note[$id]}','{$no}')
                ");
            }
        }
        return redirect('salepig')->with('success','แก้ไขข้อมูลใบวางบิลเรียบร้อย');
    }


   public function salepig_del($id)
    {

         DB::delete("DELETE FROM live_sale_order WHERE sale_no = $id",[]);
         DB::delete("DELETE FROM live_sale_order_list WHERE sale_no = $id",[]);
        return redirect('/salepig');
    }


    public function salepig_search(Request $search)
    {
        if(isset($search->search)){
        // $piglist = salepig::where ( 'no', 'LIKE', '%' . $search->search . '%' )->orWhere ( 'date', 'LIKE', '%' . $search->search . '%' )->get ();
        $sql = "SELECT * FROM `live_sale_order`
                WHERE sale_no LIKE '%$search->search%'
                OR date LIKE '%$search->search%'
                ORDER BY id DESC
               ";
        $listpig = DB::select($sql,[]);
        // return $listpig;

        if (count ( $listpig ) > 0)
            return view('sale.salepig',compact('listpig'));
        else
            $check = 1;
        return view('sale.salepig',compact('listpig','check'));
        }
        else{

            $sql = "SELECT * FROM `live_sale_order`
                    ORDER BY id DESC
                   ";
        $listpig = DB::select($sql,[]);
        }
        return view('sale.salepig',compact('listpig'));
    }


    public function deleteDetail(Request $request)
    {
        // return $request;
    DB::delete("DELETE FROM live_sale_order_list WHERE list_id = $request->id",[]);
    return 'ลบข้อมูลเรียบร้อย';
    }

    public function salepig_report(Request $search)
    {

        return view('sale.salepig-report');
    }



















    //---------------Saleslice-------------------



    public function saleslice()
    {
        $sql = "SELECT * FROM `slice_sale_order` order by id desc";

        $listpig = DB::select($sql,[]);


        return view('sale.saleslice',compact('listpig'));

    }

    public function saleslice_view($sale_no)
    {
        // dd($sale_no);

        $id = $sale_no ;

        $sql = "SELECT *
                FROM slice_sale_order_list
                JOIN slice_sale_order
                ON slice_sale_order_list.sale_no = slice_sale_order.sale_no
                WHERE slice_sale_order_list.sale_no = '$id'
                ORDER BY slice_sale_order_list.list_id DESC
               ";

        $listpig = DB::select($sql,[]);
        // dd($listpig);

        return view('sale.saleslice_view',compact('listpig','id'));

    }
    public function saleslice_view_search(Request $search,$id)
    {

        if(isset($search->search)){
            $sql = "SELECT *
                    FROM slice_sale_order_list
                    JOIN slice_sale_order
                    ON slice_sale_order_list.sale_no = slice_sale_order.sale_no
                    WHERE slice_sale_order_list.sale_no = '$id'
                    AND customer_name LIKE '%$search->search%'
                    ORDER BY slice_sale_order_list.list_id DESC
                   ";
        $listpig = DB::select($sql,[]);

        if (count ( $listpig ) > 0)
        return view('sale.saleslice_view',compact('listpig','id'));
        else
            $check = 1;
        return view('sale.saleslice_view',compact('listpig','check','id'));
        }
        else{
            $sql = "SELECT *
                    FROM slice_sale_order_list
                    JOIN slice_sale_order
                    ON slice_sale_order_list.sale_no = slice_sale_order.sale_no
                    WHERE slice_sale_order_list.sale_no = '$id'
                    ORDER BY slice_sale_order_list.list_id DESC
                   ";
            $listpig = DB::select($sql,[]);
        }
        return view('sale.saleslice_view',compact('listpig','id'));
    }

    public function show_addsaleslice()
    {
        return view('sale.saleslice-add');
    }

    public function saleslice_add(Request $request)
    {
        $total = 0;

        foreach($request->txtCustomer as $i => $value){

            $sql = "INSERT INTO slice_sale_order_list
                    (sale_no,customer_name,amount,slice_type,note)
                    value   ('{$request->no}',
                             '{$request->txtCustomer[$i]}',
                             '{$request->txtAmount[$i]}',
                             '{$request->sliceType[$i]}',
                             '{$request->txtNote[$i]}')
                   ";
            DB::select($sql,[]);
            $total = $total + $request->txtAmount[$i];

        }

        $date =now();
        $sql = "INSERT INTO slice_sale_order (sale_no,date,total) value ('$request->no','$date','$total')";
        DB::insert($sql,[]);
        return redirect('/saleslice');
    }

    public function show_editsaleslice($sale_no)
    {

        $no = $sale_no ;

        $sql = "SELECT *
                FROM slice_sale_order_list
                JOIN slice_sale_order
                ON slice_sale_order_list.sale_no = slice_sale_order .sale_no
                WHERE slice_sale_order_list.sale_no = '$no'
			   ";

        $listpig = DB::select($sql,[]);

        return view('sale.saleslice-edit',compact('listpig','no'));
    }


    public function saleslice_edit(Request $request)
    {
        // return $request;
        $name = $request->txtCustomer;
        $amount = $request->txtAmount;
        $type = $request->sliceType;
        $note = $request->txtNote;
        $no = $request->no;


        foreach ($request->txtCustomer as $id => $val) {
            //  return $id;s
            $sql = "SELECT * FROM slice_sale_order_list  WHERE list_id = '$id'";
            $check =  DB::select($sql,[]);
            // return $check;
            if($check != null){
                DB::update("UPDATE slice_sale_order_list  SET
                    customer_name = '{$name[$id]}',
                    amount = '{$amount[$id]}',
                    slice_type = '{$type[$id]}',
                    note = '{$note[$id]}'
                    WHERE list_id = '$id'
                ");

            }else{
                // dd(55);

                DB::insert("INSERT INTO slice_sale_order_list (customer_name,slice_type,amount,note,sale_no)
                    VALUES ('{$name[$id]}','{$type[$id]}','{$amount[$id]}','{$note[$id]}','{$no}')
                ");
            }
        }
        return redirect('saleslice')->with('success','แก้ไขข้อมูลใบวางบิลเรียบร้อย');
    }


   public function saleslice_del($id)
    {

         DB::delete("DELETE FROM slice_sale_order WHERE sale_no = $id",[]);
         DB::delete("DELETE FROM slice_sale_order_list WHERE sale_no = $id",[]);
        return redirect('/saleslice');
    }


    public function saleslice_search(Request $search)
    {
        if(isset($search->search)){
        // $piglist = saleslice::where ( 'no', 'LIKE', '%' . $search->search . '%' )->orWhere ( 'date', 'LIKE', '%' . $search->search . '%' )->get ();
        $sql = "SELECT * FROM `slice_sale_order`
                WHERE sale_no LIKE '%$search->search%'
                OR date LIKE '%$search->search%'
                ORDER BY id DESC
               ";
        $listpig = DB::select($sql,[]);
        // return $listpig;

        if (count ( $listpig ) > 0)
            return view('sale.saleslice',compact('listpig'));
        else
            $check = 1;
        return view('sale.saleslice',compact('listpig','check'));
        }
        else{

            $sql = "SELECT * FROM `slice_sale_order`
                    ORDER BY id DESC
                   ";
        $listpig = DB::select($sql,[]);
        }
        return view('sale.saleslice',compact('listpig'));
    }


    public function deleteDetail1(Request $subsaleslice)
    {
    DB::table('slice_sale_order_list')->where('list_id',$subsaleslice->id)->delete();
    return 'ลบข้อมูลเรียบร้อย';
    }





 //---------------truck-------------------
    public function truck()
    {
            $sql = "SELECT *
            FROM `get_truck`
            order by id desc";
             //order by car.id desc


             $listpig =  DB::select($sql,[]);
            //  return $listpig;
        return view('sale.truck',compact('listpig'));
    }

    public function   show_addtruck()
    {
        return view('sale.truck-add');
    }

    public function   truck_add(Request $data)
    {
        $date = now();

        $sql = "INSERT INTO get_truck
        (get_no,date,customer_name,driver_name,number_plate,bill_id,amount,weight,lot_id,note)
        value (
                '$data->get_no',
                '$date',
                '$data->customer_name',
                '$data->driver_name',
                '$data->number_plate',
                '$data->bill_id',
                '$data->amount',
                '$data->weight',
                '$data->lot_id',
                '$data->note'
              )";
        DB::insert($sql,[]);
        // return $request;

        return redirect('/truck');
    }

    public function truck_search(Request $search)
    {
        if(isset($search->search)){
            $sql = "SELECT *
            FROM `get_truck`
            WHERE get_no like '%$search->search%'
            OR date like '%$search->search%'
            ORDER BY id desc";
            $listpig = DB::select($sql,[]);

        if (count ( $listpig ) > 0){
            return view('sale.truck',compact('listpig'));
        }
        else{
            $check = 1;
        return view('sale.truck',compact('listpig','check'));
        }
    }
        else{
        $sql = "SELECT *
        FROM `get_truck`
        ORDER BY id desc";
        $listpig = DB::select($sql,[]);
        }
        return view('sale.truck',compact('listpig'));
    }
    public function show_edittruck($get_no)
    {
        $no = $get_no;
        $sql = "SELECT *
                FROM get_truck
                WHERE get_no = '$no'
			   ";
        $listpig = DB::select($sql,[]);

        return view('sale.truck-edit',compact('listpig','no'));
    }

    public function truck_edit(Request $request)
    {
        DB::update("UPDATE get_truck  SET
                    customer_name = '{$request->customer_name}',
                    driver_name = '{$request->driver_name}',
                    number_plate = '{$request->number_plate}',
                    bill_id = '{$request->bill_id}',
                    amount = '{$request->amount}',
                    weight = '{$request->weight}',
                    lot_id = '{$request->lot_id}',
                    note = '{$request->note}'
                    WHERE get_no = '$request->get_no'
                ");

        return redirect('/truck');
    }

    public function truck_del($id)
    {
        DB::delete("DELETE FROM get_truck WHERE id = $id",[]);
        return redirect('/truck');
    }

}
