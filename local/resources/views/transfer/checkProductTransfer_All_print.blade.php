
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{csrf_token()}}">
  <title>บริษัทมงคลแอนด์ซันส์ฟาร์มจำกัด</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="{{ asset('assets/vendor/iconfonts/mdi/css/materialdesignicons.min.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/iconfonts/puse-icons-feather/feather.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/css/vendor.bundle.base.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/css/vendor.bundle.addons.css')}}">

  <link rel="stylesheet" href="{{ asset('assets/vendor/iconfonts/font-awesome/css/font-awesome.min.css')}}" />
  <link rel="stylesheet" href="{{ asset('assets/css/shared/style.css')}}">
  <!-- endinject -->
  <!-- Layout styles -->
  <link rel="stylesheet" href="{{ asset('assets/css/demo_2/style.css')}}">
  <!-- End Layout styles -->
  <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png')}}" />

  {{-- datatables --}}
  <link rel="stylesheet" href="{{ asset('/assets/css/datatables/jquery.dataTables.min.css') }}" type="text/css" />
  <style>
    .navbar.horizontal-layout .nav-top .navbar-brand-wrapper .navbar-brand img{
      width: 100px;
      height: 100px;
    }
    select.form-control {
      height: 43.5px;
    }

  </style>

<style>
    .ajax-loader {
    visibility: hidden;
    background-color: rgba(255,255,255,0.7);
    position: absolute;
    z-index: +100 !important;
    width: 100%;
    height:100%;
    }

    .ajax-loader img {
    position: relative;
    top:50%;
    left:40%;
    }

</style>
<style type="text/css">
    .input{
            height: 50%;
            background-color: aqua;
    }
    th,td{
        padding: 0px;
    }
    .bodyzoom{
    /* zoom: 0.5; */
}
</style>

</head>

<body>

<div class="col-lg-12 grid-margin bodyzoom">
    <div class="card">
        <div class="card-body">
                    
            <div class="row">
                <div class="col-12">
                <h2 class="text-center">
                    สรุปรายงานการโอน ประจำวันที่ {{$order_pt[0]->date}} 
                </h2>
                </div>
            </div>

            @foreach($order_pt as $out_order)
            <div class="row">
               
                <div class="col-12">
                   
                    <h4 class="text-center">
                        รหัสการโอน <span style="color:red;">{{$out_order->order_number}}</span> {{$out_order->created_at}}
                        <br>
                        จาก {{$out_order->id_user_customer_from}}                          
                        <i class="fa fa-arrow-right" style="font-size: 16px;margin-right: 0px;padding-left: 20px;padding-top: 20px;padding-right: 20px;"></i>
                        {{$out_order->id_user_customer_to}} หมายเหตุ :   {{$out_order->note}}  
                    </h4>
                        <input hidden name="id" value="{{$out_order->id}}"/>
                        <input hidden name="date" value="{{$out_order->date}}"/>
                        <input hidden name="order_number" value="{{$out_order->order_number}}"/>
                        <input hidden name="customer_from" value="{{$out_order->id_user_customer_from}}"/>
                        <input hidden name="customer_to" value="{{$out_order->id_user_customer_to}}"/>
                        <input hidden name="type_req" value="{{$out_order->type_request}}"/>
                        <input hidden name="marker" value="{{$out_order->marker}}"/>
                   
                
                </div>
                <div class="col-12 px-0">

                    <table id="table" class="tbl " width="100%" border="1">
                        <thead>
                            <tr class="bg-secondary text-center">

                            </tr>
                            <tr class="bg-secondary text-center">
                                <th width="40%" style=" padding: 0px;" colspan="3">รายการ</th>
                                <th width="20%" style=" padding: 0px;" colspan="2">ต้นทาง</th>
                                <th width="20" style=" padding: 0px;" colspan="2">ปลายทาง</th>
                                <th width="20%" style=" padding: 0px;background-color:#ffbeba;" colspan="2">ผลต่าง (dift)</th>
                            </tr>
                            <tr>
                                <th class="text-center" style="padding: 0px;">ลำดับ</th>
                                <th class="text-center" style="padding: 0px;">รหัส item </th>
                                <th class="text-center" style="padding: 0px;">ชื่อ item </th>
                                <th class="text-center" style="padding: 0px;">น้ำหนัก</th>
                                <th class="text-center" style="padding: 0px;">จำนวน</th>
                                {{-- <th class="text-center" style="padding: 0px;">% Yiled จาก นน.ขุน</th> --}}
                                <th class="text-center" style="padding: 0px;">น้ำหนัก</th>
                                <th class="text-center" style="padding: 0px;">จำนวน</th>
                                <th class="text-center" style="padding: 0px;background-color:#ffbeba;" >น้ำหนัก</th>
                                <th class="text-center" style="padding: 0px;background-color:#ffbeba;" >จำนวน</th>
                                
                            </tr>
                        </thead>

                        @php
                            $key =0;
                            foreach ($data_main as  $key=> $main) {
                                // if($main->lot_number == $out_order->order_number)
                                // {
                                    $arrData[$key][0] = $main->item_code;
                                    $arrData[$key][1] = $main->item_name;
                                    $arrData[$key][2] = 0;
                                    $arrData[$key][3] = 0;
                                    $arrData[$key][4] = 0;
                                    $arrData[$key][5] = 0;
                                    $arrData[$key][6] = 0;
                                    $arrData[$key][7] = 0;
                                    $arrData[$key][8] = 0;
                                // }
                                
                            }
                            foreach ($data_main as  $m => $main) {
                                if($main->lot_number == $out_order->order_number)
                                  {
                                foreach ($data_before as $b => $before) {
                                if(($before->lot_number == $out_order->order_number ) &&($before->scale_number ==  $out_order->customer_code)&& ($before->item_code == $main->item_code)){
                                        $arrData[$m][3] = $before->sku_weight;
                                        $arrData[$m][4] = $before->sku_amount;
                                        $arrData[$m][8] = $out_order->order_number;
                                  }
                                }
                                }
                            }

                            foreach ($data_main as  $m => $main) {
                                if($main->lot_number == $out_order->order_number)
                                  {
                                foreach ($data_after as $b => $after) {
                                if(($after->lot_number == $out_order->order_number ) &&($after->scale_number ==  $out_order->cus_desc) && ($after->item_code == $main->item_code) ){
                                        $arrData[$m][5] = $after->sku_weight;
                                        $arrData[$m][6] = $after->sku_amount;
                                        $arrData[$m][8] = $out_order->order_number;
                                  }
                                }
                                }
                            }




                            // foreach ($data_main as $m => $main) {
                            //     foreach ($data_before as $b => $before) {
                            //         if ($before->item_code == $main->item_code ){
                            //             $arrData[$m][3] = $before->sku_weight;
                            //             $arrData[$m][4] = $before->sku_amount;
                            //         }
                            //     } 
                            // }

                            // foreach ($data_main as $m => $main) {
                            //     foreach ($data_after as $b => $after) {
                            //         if ($after->item_code == $main->item_code) {
                            //             $arrData[$m][5] = $after->sku_weight;
                            //             $arrData[$m][6] = $after->sku_amount;
                            //         }
                            //     } 
                            // }
                        @endphp
                        <tbody>
                            @php $count = 1; @endphp     
                                          
                            @for ($i = 0; $i < count($data_main); $i++)
                               
                               @if($arrData[$i][8] != '0')
                                <tr>
                                    <td align="center">{{ $count }}</td>
                                    <td align="center">{{ $arrData[$i][0] }}</td>
                                    <td align="center">{{ $arrData[$i][1] }}</td>
                                    @if ($customer_code != '')
                                        @if ($customer_code[0]->id == $order_pt[0]->id_user_sender )
                                            <td align="center">{{ $arrData[$i][3] }}</td>
                                            <td align="center">{{ $arrData[$i][4] }}</td>
                                            <td align="center">{{ $arrData[$i][5] }}</td>
                                            <td align="center">{{ $arrData[$i][6] }}</td>
                                        @else
                                            @if ($arrData[$i][5] != 0 && $arrData[$i][6] != 0 )
                                                <td align="center">{{ $arrData[$i][3] }}</td>
                                                <td align="center">{{ $arrData[$i][4] }}</td>
                                                <td align="center">{{ $arrData[$i][5] }}</td>
                                                <td align="center">{{ $arrData[$i][6] }}</td>
                                            @else
                                                <td>-</td>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>-</td>
                                            @endif
                                        @endif
                                    @else
                                        <td align="center">{{ $arrData[$i][3] }}</td>
                                        <td align="center">{{ $arrData[$i][4] }}</td>
                                        <td align="center">{{ $arrData[$i][5] }}</td>
                                        <td align="center">{{ $arrData[$i][6] }}</td>
                                    @endif
                                    <td align="center">{{ number_format($arrData[$i][3] - $arrData[$i][5],2) }}</td>
                                    <td align="center">{{ number_format($arrData[$i][4] - $arrData[$i][6],2) }}</td>
                                </tr>
                                @php $count=$count+1; @endphp 
                                @endif
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>

            <hr>
        @endforeach


        </div>
    </div>
</div>



<div class="modal fade" id="edit_weight" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="forms-sample form-control" style="height: auto;padding-right: 20px;" id="data_weight">

            </div>
        </div>
    </div>
</div>
<script>
    window.onload = function () {
        window.print();
    }
  </script>
  
  
  </body>
  </html>