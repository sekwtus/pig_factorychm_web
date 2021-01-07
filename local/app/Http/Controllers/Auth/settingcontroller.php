<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\DBbill;
use App\DBbillshow;
use App\DBcustomer;
use Illuminate\Http\Request;

class Settingcontroller extends Controller
{
    public function setting_customer()
    {
        $listcustomer = DBcustomer::all();
           return view('setting.setting_customer',compact('listcustomer'));
    }

    public function setting_customer_show($Customer_ID)
    {
        $sql = "SELECT * FROM Setting_Customer WHERE Customer_ID = '$Customer_ID'";
        $Cus_ID = DB::select($sql,[]);
       // return compact('Cus_ID');
    }



    
    public function setting_customer_add(Request $data)
    {
        {
           
            $sql = "INSERT INTO Setting_Customer 
            (Customer_Name,Customer_Address,Customer_Tag,Customer_ContactNumber,Customer_ContactPerson,Customer_SalepersonName) 
                 value   ('{$data->name}',
                             '{$data->address}',
                             '{$data->tag}',
                             '{$data->tel}',
                             '{$data->contact}',
                             '{$data->salename}')
                   ";
            DB::insert($sql,[]);
            return redirect('/setting_customer');
        }
    }

    public function setting_customer_data()
    {
        $listcustomer = DBcustomer::all();
           return view('setting.setting_customer_add',compact('listcustomer'));
    }

    public function setting()
    {
        
           return view('setting.setting');
    }
}

