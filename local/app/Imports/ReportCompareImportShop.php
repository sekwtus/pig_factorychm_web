<?php

namespace App\Imports;

use App\compare_report_shop;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ReportCompareImportShop implements ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
            $excel_date = $row['date'];
            if (is_numeric($excel_date)) {
                $unix_date = ($excel_date - 25569) * 86400;
                $excel_date = 25569 + ($unix_date / 86400);
                $unix_date = ($excel_date - 25569) * 86400;
                $excel_date = gmdate("m/d/Y", $unix_date);
            } else {
                $excel_date = $row['date'];
            }

        return new compare_report_shop([
            'item_code'      => $row['item_code'],
            'total_weight'   => number_format($row['total_weight'], 2, '.', ''), 
            'unit'           => $row['unit'], 
            'date'     => $excel_date,
            'shop_name' => $row['shop_name'],
            'order_number' => $row['order_number'],
        ]);
    }
}
