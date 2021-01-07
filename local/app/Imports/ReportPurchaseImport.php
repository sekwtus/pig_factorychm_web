<?php

namespace App\Imports;

use App\shop_purchase_report;
use Maatwebsite\Excel\Concerns\ToModel;
// use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ReportPurchaseImport implements ToModel
// , WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
            $date_source = $row[12];
            $date_destination = $row[13];

            if (is_numeric($date_source)) {
                $unix_date = ($date_source - 25569) * 86400;
                $date_source = 25569 + ($unix_date / 86400);
                $unix_date = ($date_source - 25569) * 86400;
                $date_source = gmdate("m/d/Y", $unix_date);
            } else {
                $date_source = $row[12];
            }

            if (is_numeric($date_destination)) {
                $unix_date = ($date_destination - 25569) * 86400;
                $date_destination = 25569 + ($unix_date / 86400);
                $unix_date = ($date_destination - 25569) * 86400;
                $date_destination = gmdate("m/d/Y", $unix_date);
            } else {
                $date_destination = $row[13];
            }
            
            
            if (is_numeric($row[0])) {
                return new shop_purchase_report([
                    'item_code'      => $row[0],
                    'item_name'      => $row[1], 
                    'unit'           => $row[2], 
                    'weight_number'  => $row[3],
                    'total_price'    => $row[6], 
                    'shop_name'      => $row[11],
                    'date_source'     => $date_source,
                    'date_destination'     => $date_destination,
                    'price_unit' => number_format((float)($row[6]/$row[3]), 2, '.', ''),
                ]);
            }
    }
}
