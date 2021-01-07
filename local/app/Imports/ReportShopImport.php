<?php

namespace App\Imports;

use App\shop_sales_report;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ReportShopImport implements ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
            $excel_date = $row['date_today'];

            if (is_numeric($excel_date)) {
                $unix_date = ($excel_date - 25569) * 86400;
                $excel_date = 25569 + ($unix_date / 86400);
                $unix_date = ($excel_date - 25569) * 86400;
                $excel_date = gmdate("m/d/Y", $unix_date);
            } else {
                $excel_date = $row['date_today'];
            }
            
            

        return new shop_sales_report([
            'item_code'      => $row['item_code'],
            'item_name'      => $row['item_name'], 
            'unit'           => $row['unit'], 
            'weight_number'  => $row['weight_number'],
            'total_price'    => $row['total_price'], 
            'shop_name'      => $row['shop_name'],
            'date_today'     => $excel_date,
            'price_unit' => number_format((float)($row['total_price']/$row['weight_number']), 2, '.', ''),
        ]);
    }
}
