<?php
   
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use App\Imports\ReportShopImport;
use App\Imports\ReportCompareImport;
use App\Imports\ReportCompareImportShop;
use App\Imports\ReportPurchaseImport;
use Maatwebsite\Excel\Facades\Excel;
use DB;
  
class controllerReportShopImport extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function importExportView()
    {
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

       return view('bill.importExcel',compact('report_shop_today'));
    }

    public function importCompare(){
        $report_factory = DB::select("SELECT
                                        compare_report.order_number,
                                        compare_report.shop_name,
                                        compare_report.date,
                                        compare_report.created_at 
                                    FROM
                                        compare_report 
                                    GROUP BY
                                        compare_report.order_number,
                                        compare_report.shop_name,
                                        compare_report.date 
                                    ORDER BY
                                        compare_report.date DESC,
                                        compare_report.created_at");  
        $transport_order = DB::select("SELECT
                    tb_order_transport.order_number,
                    SUBSTR( tb_order_transport.id_user_customer,5,20) AS shop_name,
                    CONCAT(
                    SUBSTR( tb_order_transport.date_transport, 4, 2 ),'/',
                    SUBSTR( tb_order_transport.date_transport, 1, 2 ),'/',
                    SUBSTR( tb_order_transport.date_transport, 7, 4 )
                    ) AS date,
                    CONCAT(
                    SUBSTR( tb_order_transport.date_transport, 7, 4 ),
                    SUBSTR( tb_order_transport.date_transport, 4, 2 ),
                    SUBSTR( tb_order_transport.date_transport, 1, 2 ) 
                    ) 
                FROM
                    tb_order_transport 
                WHERE
                    CONCAT(
                    SUBSTR( tb_order_transport.date_transport, 7, 4 ),
                    SUBSTR( tb_order_transport.date_transport, 4, 2 ),
                    SUBSTR( tb_order_transport.date_transport, 1, 2 ) 
                    ) > 20200127
                GROUP BY
                    tb_order_transport.order_number
        ");

        $report_factory = array($report_factory,$transport_order);

       return view('report.importExcel',compact('report_factory'));
    }

    public function importCompare_daily(){
        $report_factory = DB::select("SELECT
                                        compare_report.order_number,
                                        compare_report.shop_name,
                                        compare_report.date,
                                        compare_report.created_at 
                                    FROM
                                        compare_report 
                                    GROUP BY
                                        compare_report.order_number,
                                        compare_report.shop_name,
                                        compare_report.date 
                                    ORDER BY
                                        compare_report.date DESC,
                                        compare_report.created_at");  
        $transport_order = DB::select("SELECT
                    tb_order_transport.order_number,
                    SUBSTR( tb_order_transport.id_user_customer,5,20) AS shop_name,
                    CONCAT(
                    SUBSTR( tb_order_transport.date_transport, 4, 2 ),'/',
                    SUBSTR( tb_order_transport.date_transport, 1, 2 ),'/',
                    SUBSTR( tb_order_transport.date_transport, 7, 4 )
                    ) AS date,
                    CONCAT(
                    SUBSTR( tb_order_transport.date_transport, 7, 4 ),
                    SUBSTR( tb_order_transport.date_transport, 4, 2 ),
                    SUBSTR( tb_order_transport.date_transport, 1, 2 ) 
                    ) 
                FROM
                    tb_order_transport 
                WHERE
                    CONCAT(
                    SUBSTR( tb_order_transport.date_transport, 7, 4 ),
                    SUBSTR( tb_order_transport.date_transport, 4, 2 ),
                    SUBSTR( tb_order_transport.date_transport, 1, 2 ) 
                    ) > 20200127
                GROUP BY date
        ");

        $report_factory = array($report_factory,$transport_order);

       return view('report.compare_fac_shop_daily',compact('report_factory'));
    }

    public function importShopPurchase()
    {
       $report_purchase_today = DB::select("SELECT
                                        shop_purchase_report.id,
                                        shop_purchase_report.id_shop,
                                        GROUP_CONCAT( DISTINCT ( shop_purchase_report.shop_name ) SEPARATOR ' / ' ) AS shop_name,
                                        shop_purchase_report.item_code,
                                        shop_purchase_report.item_name,
                                        shop_purchase_report.date_source,
                                        shop_purchase_report.date_destination,
                                        shop_purchase_report.created_at,
                                        shop_purchase_report.updated_at 
                                    FROM
                                        shop_purchase_report 
                                    GROUP BY
                                        shop_purchase_report.date_source,
                                        shop_purchase_report.date_destination
                                    ORDER BY
                                        shop_purchase_report.date_source DESC,
                                        shop_purchase_report.date_destination DESC");  

       return view('bill.importShopPurchase',compact('report_purchase_today'));
    }

    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function export() 
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
   
    /**
    * @return \Illuminate\Support\Collection
    */
    public function import() 
    {
        Excel::import(new ReportShopImport,request()->file('file'), 'UTF-8');
           
        return back();
    }

    public function importExcelPurchase() 
    {
        Excel::import(new ReportPurchaseImport,request()->file('file'), 'UTF-8');
           
        return back();
    }

    public function importExcelCompare() 
    {
        Excel::import(new ReportCompareImport,request()->file('file'), 'UTF-8');
           
        return back();
    }
    public function importExcelCompareShop() 
    {
        Excel::import(new ReportCompareImportShop,request()->file('file'), 'UTF-8');
           
        return back();
    }
    

    public function report_shop_level1($id) 
    {
        $find_unique = DB::select("SELECT
                            shop_sales_report.id,
                            shop_sales_report.id_shop,
                            shop_sales_report.shop_name,
                            shop_sales_report.item_code,
                            shop_sales_report.item_name,
                            shop_sales_report.date_today,
                            shop_sales_report.created_at,
                            shop_sales_report.updated_at 
                        FROM
                            shop_sales_report
                        WHERE shop_sales_report.id = '$id'");
        
        $date_request = $find_unique[0]->date_today;

        $shop_sales_report = DB::select("SELECT
                            shop_sales_report.id,
                            shop_sales_report.id_shop,
                            shop_sales_report.shop_name,
                            shop_sales_report.item_code,
                            shop_sales_report.item_name,
                            sum( shop_sales_report.weight_number ) AS weight_number,
                            shop_sales_report.unit,
                            sum( shop_sales_report.total_price ) AS total_price,
                            shop_sales_report.price_unit,
                            shop_sales_report.date_today,
                            shop_sales_report.created_at,
                            shop_sales_report.updated_at,
                            wg_sku_item.wg_sku_id_type_shop,
                            wg_sku.sku_name,
                            wg_sku.sku_group 
                        FROM
                            shop_sales_report
                            LEFT JOIN wg_sku_item ON shop_sales_report.item_code = wg_sku_item.item_code
                            LEFT JOIN wg_sku ON wg_sku_item.wg_sku_id_type_shop = wg_sku.id_wg_sku 
                        WHERE
                            shop_sales_report.date_today = '$date_request'	
                            AND (wg_sku_item.wg_sku_id <> 30
                            OR wg_sku_item.wg_sku_id IS NULL)
                        GROUP BY
                            shop_sales_report.item_code 
                        ORDER BY
                            shop_sales_report.item_code ASC");

        $sum_weight_number = DB::select("SELECT
                    SUM(shop_sales_report.weight_number) as sum_weight_number
                    FROM
                    shop_sales_report
                    LEFT JOIN wg_sku_item ON shop_sales_report.item_code = wg_sku_item.item_code
                    LEFT JOIN wg_sku ON wg_sku_item.wg_sku_id_type_shop = wg_sku.id_wg_sku
                    WHERE
                    shop_sales_report.date_today = '$date_request'
                    AND (wg_sku_item.wg_sku_id <> 30
                    OR wg_sku_item.wg_sku_id IS NULL)
                    AND wg_sku.sku_group = 'สินค้า(หมู)'");
        
        $summary_report_shop = DB::select("SELECT
                    wg_sku.sku_name,
                    wg_sku.sku_group,
                    wg_sku_item.item_code,
                    wg_sku_item.item_name,
                    SUM(shop_sales_report.weight_number) as sum_weight_number,
                    SUM(shop_sales_report.total_price) as sum_total_price,
                    shop_sales_report.unit,
                    shop_sales_report.price_unit,
                    shop_sales_report.date_today,
                    shop_sales_report.shop_name
                    FROM
                    wg_sku
                    LEFT JOIN wg_sku_item ON wg_sku_item.wg_sku_id_type_shop = wg_sku.id_wg_sku
                    LEFT JOIN shop_sales_report ON shop_sales_report.item_code = wg_sku_item.item_code
                    WHERE
                    wg_sku.sku_group = 'สินค้า(หมู)'
                    AND shop_sales_report.date_today = '$date_request'
                    AND (wg_sku_item.wg_sku_id <> 30
                    OR wg_sku_item.wg_sku_id IS NULL)
                    GROUP BY
                    wg_sku.sku_name
                    ORDER BY
                    wg_sku.id_wg_sku ASC
                    ");

        //query เพื่อไปแยกสาขา
        $find_shop = DB::select("SELECT
                            shop_sales_report.id,
                            shop_sales_report.id_shop,
                            shop_sales_report.shop_name,
                            shop_sales_report.item_code,
                            shop_sales_report.item_name,
                            shop_sales_report.date_today,
                            shop_sales_report.created_at,
                            shop_sales_report.updated_at 
                        FROM
                            shop_sales_report
                        WHERE shop_sales_report.date_today = '$date_request'
                        GROUP BY
                            shop_sales_report.date_today,
                            shop_sales_report.shop_name");


        $sum_weight_number = floatval($sum_weight_number[0]->sum_weight_number);

        return view('shop.report_shop_level1',compact('sum_weight_number','shop_sales_report','summary_report_shop','find_shop','id'));
    }

    public function report_purchase($id)
    {
        $find_unique = DB::select("SELECT
        shop_purchase_report.* 
        FROM
            shop_purchase_report
        WHERE shop_purchase_report.id = '$id'");

        $date_source = $find_unique[0]->date_source;
        $date_destination = $find_unique[0]->date_destination;
        $shop = $find_unique[0]->shop_name;

        $shop_sales_report = DB::select("SELECT
                shop_purchase_report.id,
                shop_purchase_report.id_shop,
                shop_purchase_report.shop_name,
                shop_purchase_report.item_code,
                shop_purchase_report.item_name,
                shop_purchase_report.weight_number,
                shop_purchase_report.unit,
                shop_purchase_report.total_price,
                shop_purchase_report.price_unit,
                shop_purchase_report.date_source,
                shop_purchase_report.date_destination,
                shop_purchase_report.created_at,
                shop_purchase_report.updated_at,
                wg_sku_item.wg_sku_id_type_shop,
                wg_sku.sku_name,
                wg_sku.sku_group
                FROM
                shop_purchase_report
                LEFT JOIN wg_sku_item ON shop_purchase_report.item_code = wg_sku_item.item_code
                LEFT JOIN wg_sku ON wg_sku_item.wg_sku_id_type_shop = wg_sku.id_wg_sku
                WHERE
                shop_purchase_report.date_source = '$date_source'
                AND shop_purchase_report.date_destination = '$date_destination'
                AND shop_purchase_report.shop_name = '$shop'
                ORDER BY shop_purchase_report.item_code ASC");

        $sum_weight_number = DB::select("SELECT
                SUM(shop_purchase_report.weight_number) as sum_weight_number
                FROM
                shop_purchase_report
                LEFT JOIN wg_sku_item ON shop_purchase_report.item_code = wg_sku_item.item_code
                LEFT JOIN wg_sku ON wg_sku_item.wg_sku_id_type_shop = wg_sku.id_wg_sku
                WHERE
                shop_purchase_report.date_source = '$date_source'
                AND shop_purchase_report.date_destination = '$date_destination'
                AND shop_purchase_report.shop_name = '$shop'
                AND wg_sku.sku_group = 'สินค้า(หมู)'");

        $summary_report_shop = DB::select("SELECT
                wg_sku.sku_name,
                wg_sku.sku_group,
                wg_sku_item.item_code,
                wg_sku_item.item_name,
                SUM(shop_purchase_report.weight_number) as sum_weight_number,
                SUM(shop_purchase_report.total_price) as sum_total_price,
                shop_purchase_report.unit,
                shop_purchase_report.price_unit,
                shop_purchase_report.date_source,
                shop_purchase_report.shop_name
                FROM
                wg_sku
                LEFT JOIN wg_sku_item ON wg_sku_item.wg_sku_id_type_shop = wg_sku.id_wg_sku
                LEFT JOIN shop_purchase_report ON shop_purchase_report.item_code = wg_sku_item.item_code
                WHERE
                wg_sku.sku_group = 'สินค้า(หมู)'
                AND shop_purchase_report.date_source = '$date_source'
                AND shop_purchase_report.date_destination = '$date_destination'
                AND shop_purchase_report.shop_name = '$shop'
                GROUP BY
                wg_sku.sku_name
                ORDER BY
                wg_sku.id_wg_sku ASC
                ");

        $sum_weight_number = floatval($sum_weight_number[0]->sum_weight_number);

        return view('shop.report_purchase',compact('sum_weight_number','shop_sales_report','summary_report_shop','shop'));
    }

    public function report_shop_level2($shop, $id)
    {
        $find_unique = DB::select("SELECT
        shop_sales_report.id,
        shop_sales_report.id_shop,
        shop_sales_report.shop_name,
        shop_sales_report.item_code,
        shop_sales_report.item_name,
        shop_sales_report.date_today,
        shop_sales_report.created_at,
        shop_sales_report.updated_at 
        FROM
            shop_sales_report
        WHERE shop_sales_report.id = '$id'");

        $date_request = $find_unique[0]->date_today;

        $shop_sales_report = DB::select("SELECT
                shop_sales_report.id,
                shop_sales_report.id_shop,
                shop_sales_report.shop_name,
                shop_sales_report.item_code,
                shop_sales_report.item_name,
                shop_sales_report.weight_number,
                shop_sales_report.unit,
                shop_sales_report.total_price,
                shop_sales_report.price_unit,
                shop_sales_report.date_today,
                shop_sales_report.created_at,
                shop_sales_report.updated_at,
                wg_sku_item.wg_sku_id_type_shop,
                wg_sku.sku_name,
                wg_sku.sku_group
                FROM
                shop_sales_report
                LEFT JOIN wg_sku_item ON shop_sales_report.item_code = wg_sku_item.item_code
                LEFT JOIN wg_sku ON wg_sku_item.wg_sku_id_type_shop = wg_sku.id_wg_sku
                WHERE
                shop_sales_report.date_today = '$date_request'
                AND shop_sales_report.shop_name = '$shop'
                ORDER BY shop_sales_report.item_code ASC");

        $sum_weight_number = DB::select("SELECT
                SUM(shop_sales_report.weight_number) as sum_weight_number
                FROM
                shop_sales_report
                LEFT JOIN wg_sku_item ON shop_sales_report.item_code = wg_sku_item.item_code
                LEFT JOIN wg_sku ON wg_sku_item.wg_sku_id_type_shop = wg_sku.id_wg_sku
                WHERE
                shop_sales_report.date_today = '$date_request'
                AND shop_sales_report.shop_name = '$shop'
                AND wg_sku.sku_group = 'สินค้า(หมู)'");

        $summary_report_shop = DB::select("SELECT
                wg_sku.sku_name,
                wg_sku.sku_group,
                wg_sku_item.item_code,
                wg_sku_item.item_name,
                SUM(shop_sales_report.weight_number) as sum_weight_number,
                SUM(shop_sales_report.total_price) as sum_total_price,
                shop_sales_report.unit,
                shop_sales_report.price_unit,
                shop_sales_report.date_today,
                shop_sales_report.shop_name
                FROM
                wg_sku
                LEFT JOIN wg_sku_item ON wg_sku_item.wg_sku_id_type_shop = wg_sku.id_wg_sku
                LEFT JOIN shop_sales_report ON shop_sales_report.item_code = wg_sku_item.item_code
                WHERE
                wg_sku.sku_group = 'สินค้า(หมู)'
                AND shop_sales_report.date_today = '$date_request'
                AND shop_sales_report.shop_name = '$shop'
                GROUP BY
                wg_sku.sku_name
                ORDER BY
                wg_sku.id_wg_sku ASC
                ");

        $sum_weight_number = floatval($sum_weight_number[0]->sum_weight_number);

        return view('shop.report_shop_level2',compact('sum_weight_number','shop_sales_report','summary_report_shop','shop'));
    }
    
    public function delete_import(Request $request){
        
        DB::delete("DELETE from shop_sales_report WHERE shop_name = '$request->shop_name' AND date_today = '$request->date_today' ");
        
        return 'ลบสำเร็จ';
    }
    public function delete_importCompare(Request $request){
        
        DB::delete("DELETE from compare_report WHERE order_number = '$request->order_number'");
        DB::delete("DELETE from compare_report_shop WHERE order_number = '$request->order_number'");
        
        return 'ลบสำเร็จ';
    }
    public function delete_report_purchase(Request $request){
        
        DB::delete("DELETE from shop_purchase_report WHERE shop_name = '$request->shop_name' AND date_source = '$request->date_source' AND date_destination = '$request->date_destination' ");
        
        return 'ลบสำเร็จ';
    }
    
}