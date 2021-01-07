<?php

namespace App\Http\Controllers;

use DB;

class MapRealTimeController extends Controller
{
    public function get_factory()
    {
        $scales_kmk01 = DB::select("SELECT
       tb_users.id,
       tb_users.users_code,
       tb_users.`names`,
       tb_users.scale_user,
       tb_users.scale_login_date,
       tb_users.scale_logout_date
       FROM
       tb_users
       WHERE
       tb_users.scale_user = 'KMK01'
       ");
        //    dd($scales);
        $scales_kmk02 = DB::select("SELECT
       tb_users.id,
       tb_users.users_code,
       tb_users.`names`,
       tb_users.scale_user,
       tb_users.scale_login_date,
       tb_users.scale_logout_date
       FROM
       tb_users
       WHERE
       tb_users.scale_user = 'KMK02'
       ");

        $scales_kmk03 = DB::select("SELECT
        tb_users.id,
        tb_users.users_code,
        tb_users.`names`,
        tb_users.scale_user,
        tb_users.scale_login_date,
        tb_users.scale_logout_date
        FROM
        tb_users
        WHERE
        tb_users.scale_user = 'KMK03'
        ");

        $scales_kmk04 = DB::select("SELECT
        tb_users.id,
        tb_users.users_code,
        tb_users.`names`,
        tb_users.scale_user,
        tb_users.scale_login_date,
        tb_users.scale_logout_date
        FROM
        tb_users
        WHERE
        tb_users.scale_user = 'KMK04'
        ");

        $scales_kmk05 = DB::select("SELECT
        tb_users.id,
        tb_users.users_code,
        tb_users.`names`,
        tb_users.scale_user,
        tb_users.scale_login_date,
        tb_users.scale_logout_date
        FROM
        tb_users
        WHERE
        tb_users.scale_user = 'KMK05'
        ");

        $scales_kmk06 = DB::select("SELECT
        tb_users.id,
        tb_users.users_code,
        tb_users.`names`,
        tb_users.scale_user,
        tb_users.scale_login_date,
        tb_users.scale_logout_date
        FROM
        tb_users
        WHERE
        tb_users.scale_user = 'KMK06'
        ");

        $scales_kmk07 = DB::select("SELECT
        tb_users.id,
        tb_users.users_code,
        tb_users.`names`,
        tb_users.scale_user,
        tb_users.scale_login_date,
        tb_users.scale_logout_date
        FROM
        tb_users
        WHERE
        tb_users.scale_user = 'KMK07'
        ");
        $scales_kmk08 = DB::select("SELECT
        tb_users.id,
        tb_users.users_code,
        tb_users.`names`,
        tb_users.scale_user,
        tb_users.scale_login_date,
        tb_users.scale_logout_date
        FROM
        tb_users
        WHERE
        tb_users.scale_user = 'KMK08'
        ");
        $scales_kmk09 = DB::select("SELECT
        tb_users.id,
        tb_users.users_code,
        tb_users.`names`,
        tb_users.scale_user,
        tb_users.scale_login_date,
        tb_users.scale_logout_date
        FROM
        tb_users
        WHERE
        tb_users.scale_user = 'KMK09'
        ");
        $scales_kmk10 = DB::select("SELECT
        tb_users.id,
        tb_users.users_code,
        tb_users.`names`,
        tb_users.scale_user,
        tb_users.scale_login_date,
        tb_users.scale_logout_date
        FROM
        tb_users
        WHERE
        tb_users.scale_user = 'KMK10'
        ");
        $scales_kmk11 = DB::select("SELECT
        tb_users.id,
        tb_users.users_code,
        tb_users.`names`,
        tb_users.scale_user,
        tb_users.scale_login_date,
        tb_users.scale_logout_date
        FROM
        tb_users
        WHERE
        tb_users.scale_user = 'KMK11'
        ");
        $scales_kmk12 = DB::select("SELECT
        tb_users.id,
        tb_users.users_code,
        tb_users.`names`,
        tb_users.scale_user,
        tb_users.scale_login_date,
        tb_users.scale_logout_date
        FROM
        tb_users
        WHERE
        tb_users.scale_user = 'KMK12'
        ");
        $scales_kmk13 = DB::select("SELECT
        tb_users.id,
        tb_users.users_code,
        tb_users.`names`,
        tb_users.scale_user,
        tb_users.scale_login_date,
        tb_users.scale_logout_date
        FROM
        tb_users
        WHERE
        tb_users.scale_user = 'KMK13'
        ");

        $result = DB::select("SELECT
      MINUTE(MAX(wg_sku_weight_data.created_at)) - MINUTE(NOW()) as date_diff,
      wg_sku_weight_data.scale_number,
      wg_sku_weight_data.user_name,
      MAX(wg_sku_weight_data.created_at)
      FROM wg_sku_weight_data
      WHERE scale_number IN ('KMK01','KMK02','KMK03', 'KMK04', 'KMK05', 'KMK06', 'KMK07', 'KMK08','KMK09', 'KMK10', 'KMK11', 'KMK12' , 'KMK13')
      GROUP BY wg_sku_weight_data.scale_number");

        return view('map_realtime.factory_monitor', compact('result', 'scales_kmk01', 'scales_kmk02', 'scales_kmk03', 'scales_kmk04', 'scales_kmk05', 'scales_kmk06', 'scales_kmk07', 'scales_kmk08', 'scales_kmk09', 'scales_kmk10', 'scales_kmk11', 'scales_kmk11', 'scales_kmk12', 'scales_kmk13'));
    }

    public function getScale()
    {
        $scales = DB::select("SELECT wg_.id_scale,TIMESTAMPDIFF(MINUTE,wgdata_1.created_at,CURDATE()) AS min_diff,wgdata_1.lot_number,wg_.scale_number,wgdata_1.storage_name,wgdata_1.user_name,wgdata_1.created_at FROM wg_scale wg_ LEFT JOIN (
                              SELECT max(wgdata_.id) AS id_,wgdata_.scale_number FROM wg_sku_weight_data wgdata_ GROUP BY wgdata_.scale_number) AS wgdata_2 ON wgdata_2.scale_number=wg_.scale_number LEFT JOIN (
                              SELECT wgdata_.id,wgdata_.lot_number,wgdata_.scale_number,wgdata_.storage_name,wgdata_.user_name,wgdata_.created_at FROM wg_sku_weight_data wgdata_ ORDER BY wgdata_.created_at DESC) AS wgdata_1 ON wgdata_1.id=wgdata_2.id_ WHERE wg_.scale_number IN ('KMK01','KMK02','KMK03','KMK04','KMK05','KMK06','KMK07','KMK08','KMK09','KMK10','KMK11','KMK12') GROUP BY wg_.scale_number");

        return response()->json($scales);
    }
}
