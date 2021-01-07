<?php

namespace App\Http\Controllers;

//use Illuminate\Support\Facades\DB;
use App\DBreportshow;
use Illuminate\Http\Request;
use DB;

class ReportController extends Controller
{
    public function getreport()
    {
        $listreport = DBreportshow::all();
        //return var_dump($listbill);
        // return $listsurvey;
       //return $listbill ;
       return view('report.reportmain',compact('listreport'));
    }
    public function getaddsaleL()
    {
        //$listreport = DBreportshow::all();
        //return var_dump($listbill);
        // return $listsurvey;
       //return $listbill ;
       return view('report.reportmainBreed-add');
    }
    // public function printreprintL()
    // {
    //     $listreport = DBreportshow::all();
    //     //return var_dump($listbill);
    //     // return $listsurvey;
    //    //return $listbill ;
    //    return view('report.ReportsaleL');
    // }
    public function printreprintsaleL()
    {

        //return var_dump($listbill);
        // return $listsurvey;
       //return $listbill ;
       return view('report.ReportpigsaleL');
    }
    public function getreportbillL()
    {
        $listreport = DBreportshow::all();
        //return var_dump($listbill);
        // return $listsurvey;
       //return $listbill ;
       return view('report.reportmainbillL',compact('listreport'));
    }
    public function printreprintbillL()
    {

        //return var_dump($listbill);
        // return $listsurvey;
       //return $listbill ;
       return view('report.ReportpigbillL');
    }
    public function getreportbillRe()
    {
        $listreport = DBreportshow::all();
        //return var_dump($listbill);
        // return $listsurvey;
       //return $listbill ;
       return view('report.reportmainreceivebill',compact('listreport'));
    }
    public function printreprintbillRe()
    {

        //return var_dump($listbill);
        // return $listsurvey;
       //return $listbill ;
       return view('report.ReportpigbillRe');
    }

    public function getReportserviceS()
    {
        $listreport = DBreportshow::all();
        //return var_dump($listbill);
        // return $listsurvey;
       //return $listbill ;
       return view('report.reportmainLservice',compact('listreport'));
    }
    public function printReportserviceS()
    {

        //return var_dump($listbill);
        // return $listsurvey;
       //return $listbill ;
       return view('report.ReportpigLservice');
    }

    public function getReportserviceBilling()
    {
        $listreport = DBreportshow::all();
        //return var_dump($listbill);
        // return $listsurvey;
       //return $listbill ;
       return view('report.reportmainLserviceBilling',compact('listreport'));
    }
    public function printReportserviceBilling()
    {

        //return var_dump($listbill);
        // return $listsurvey;
       //return $listbill ;
       return view('report.ReportpigLserviceBilling');
    }
    public function getReportserviceBillRe()
    {
        $listreport = DBreportshow::all();
        //return var_dump($listbill);
        // return $listsurvey;
       //return $listbill ;
       return view('report.reportmainLserviceBillRe',compact('listreport'));
    }
    public function printReportserviceBillRe()
    {

        //return var_dump($listbill);
        // return $listsurvey;
       //return $listbill ;
       return view('report.ReportpigLserviceBillRe');
    }
    public function getReportBillcarcassSent()
    {
        $listreport = DBreportshow::all();
        //return var_dump($listbill);
        // return $listsurvey;
       //return $listbill ;
       return view('report.reportmainLBillcarcassSent',compact('listreport'));
    }
    public function printReportBillcarcassSent()
    {

        //return var_dump($listbill);
        // return $listsurvey;
       //return $listbill ;
       return view('report.ReportpigLBillcarcassSent');
    }
    public function getReportBillcarcassBilling()
    {
        $listreport = DBreportshow::all();
        //return var_dump($listbill);
        // return $listsurvey;
       //return $listbill ;
       return view('report.reportmainLBillcarcassBilling',compact('listreport'));
    }
    public function printReportBillcarcassBilling()
    {

        //return var_dump($listbill);
        // return $listsurvey;
       //return $listbill ;
       return view('report.ReportpigLBillcarcassBilling');
    }
    public function getReportBillcarcassRe()
    {
        $listreport = DBreportshow::all();
        //return var_dump($listbill);
        // return $listsurvey;
       //return $listbill ;
       return view('report.reportmainLBillcarcassRe',compact('listreport'));
    }
    public function printReportBillcarcassRe()
    {

        //return var_dump($listbill);
        // return $listsurvey;
       //return $listbill ;
       return view('report.ReportpigLBillcarcassRe');
    }
    public function index_report()
    {
        return view('report.index_report');
    }

    public function Report_addBreed(Request $request)
    {
        //$total = 0;

        foreach($request->txtDetial as $i => $value){

            //$date =now();
            //$sql = "INSERT INTO ACC_ListDetail_Nochrage_Delivery1 (Book_No,No_) value ('$request->book','$request->no')";
           // DB::insert($sql,[]);
            $sql = "INSERT INTO ACC_ListDetail_Nochrage_Delivery1
            (Book_No,No_,list_gender,weight,price,Amont)
            value   ('$request->book',
                     '$request->no',
                     '{$request->txtDetial[$i]}',
                     '{$request->txtweight[$i]}',
                     '{$request->txtPrice[$i]}',
                     '{$request->txtAmount[$i]}'
                    )";
           // DB::select($sql,[]);
            // $total = $total + $request->txtAmount[$i];
            DB::insert($sql,[]);
            //echo $sql;

        }



        return redirect('/Report');
    }
    public function show_Reportbilldeli($Book_No,$NNo)
    {

        $Bno = $Book_No ;
        $Nno = $NNo;
        // echo $Bno ;
        // echo $no;


        $sql = " SELECT * ".
                " FROM ACC_ListDetail_Nochrage_Delivery1 ".
               " WHERE Book_No = $Bno and No_ = '".$Nno."'";

        // echo $sql;
        $listbillL = DB::select($sql,[]);
        // dd($listbillL);
         return view('report.report-editbillL',compact('listbillL','Bno','Nno'));
    }

    public function Report_edit(Request $request,$Book_No,$No)
    {
        // return $request;
        $Detial = $request->txtDetial;
        $weight = $request->txtweight;
        $Price = $request->txtPrice;
        $Amount = $request->txtAmount;
        //$no = $request->no;


        foreach ($request->txtDetial as $id => $val) {

            //  return $id;s
            // $sql = "SELECT * FROM ACC_ListDetail_Nochrage_Delivery1  WHERE Book_No = $Book_No and No_ = '".$No."' and id = $id ";
            // $check =  DB::select($sql,[]);
            // //return $check;
            // if($check != null){
                //$ListID  = $request->$id;

                DB::update("UPDATE ACC_ListDetail_Nochrage_Delivery1 SET
                    list_gender = '{$Detial[$id]}',
                    weight = '{$weight[$id]}',
                    price = '{$Price[$id]}',
                    Amont = '{$Amount[$id]}'
                    WHERE  id = '$id'
                ");


            // }else{
            //     // dd(55);

            //     DB::insert("INSERT INTO ACC_ListDetail_Nochrage_Delivery1 (list_gender,weight,price,Amont)
            //         VALUES ('{$Detial[$id]}','{$weight[$id]}','{$Price[$id]}','{$Amount[$id]}')
            //     ");
            // }
            //
        }
        return redirect('/Report')->with('success','แก้ไขข้อมูลใบวางบิลเรียบร้อย');
        //return redirect('salepig')->with('success','แก้ไขข้อมูลใบวางบิลเรียบร้อย');
    //dd($listbillL);
    //return view('report.report-editbillL',compact('listbillL'));
    }

}
