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
  <link rel="stylesheet" href="{{ url('https://cdn.datatables.net/1.10.18/css/dataTables.semanticui.min.css') }}" type="text/css" />
{{-- <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" /> --}}
<link rel="stylesheet" href="{{ asset('assets/css/daterangepicker.css')}}">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" />
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
    zoom: 1;
}
</style>

</head>

<body>
    
    <div class="container-scroller" id="test">
        <div class="container-fluid ">
            <div class="content-wrapper">
                <div class="col-lg-12 grid-margin bodyzoom">
                    <div class="card">
                    <div class="card-body">
                        {{-- <h2 class="text-center" style="margin-bottom: 0px;height: 0px;">รายงานตรวจสอบน้ำหนักชิ้นส่วนสุกรในกระบวนการผลิต <span style="color:red;">
                            สาขา {{ $select_order_result[0]->shop_name=='' ? '' : $select_order_result[0]->shop_name }}</span></h2><br><br> --}}
                            <div class="row">
                                    <div class="col-12 px-0">
                                        
                                    <table id="tbl-3" class="tbl " width="100%" border="1">
                                        <thead>
                                            <tr class="bg-secondary text-center" ><th colspan="11" style=" padding: 0px;"><h3> รายงานเปรียบเทียบน้ำหนักชิ้นส่วนสุกร โรงงาน-ร้านค้า 
                                                <span style="color:red;">{{ $shop_name=='' ? '' : $shop_name }}
                                                ประจำวันที่ {{ $date == '' ? '' : substr($date,3,2).'/'.substr($date,0,2).'/'.substr($date,6,4) }} </span> &nbsp;
                                                {{-- |  น้ำหนักหมูขุน <a data-toggle="modal" data-target="#edit_weight" href="#" 
                                                onclick="edit_weight_side('{{ $order_tr }}','{{ $weight_recieve }}')">
                                                {{ $weight_recieve }} </a>   --}}
                                            </h3></th>
                                            </tr>
                                            <tr class="bg-secondary text-center">
                                                <th width="60%" style=" padding: 0px;" colspan="6">น้ำหนักชิ้นส่วน (โรงงาน)</th>
                                                <th width="20%" style=" padding: 0px;" colspan="2">น้ำหนักชิ้นส่วน (ร้านค้า)</th>
                                                <th width="20%" style=" padding: 0px;" colspan="3">ผลต่าง (dift)</th>
                                            </tr>
                                            <tr>
                                                <th class="text-center" style="padding: 0px;">No.</th>
                                                <th class="text-center" style="padding: 0px;">รหัส item </th>
                                                <th class="text-center" style="padding: 0px;">ชื่อ item </th>
                                                <th class="text-center" style="padding: 0px;">น้ำหนัก(โรงงาน)</th>
                                                <th class="text-center" style="padding: 0px;">จำนวน(โรงงาน)</th>
                                                {{-- <th class="text-center" style="padding: 0px;">% Yiled จาก นน.ขุน</th> --}}
                                                <th class="text-center" style="padding: 0px;">น้ำหนัก(ร้านค้า)</th>
                                                <th class="text-center" style="padding: 0px;">จำนวน(ร้านค้า)</th>
                                                <th class="text-center" style="padding: 0px;background-color:#ffbeba;">น้ำหนัก(dift)</th>
                                                <th class="text-center" style="padding: 0px;background-color:#ffbeba;">จำนวน(dift)</th>
                                                <th class="text-center" style="padding: 0px;background-color:#ffbeba;">% สูญเสีย (LOSS)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $sum_weight_factory = 0;
                                                $sum_unit_factory = 0; 
                                                $sum_yiled_factory =0;
                                                $count = 1;
                                                $total_=100;
                                            @endphp 
                                            @php $sum_weight_shop = 0;
                                                $sum_unit_shop = 0; 
                                                $sum_yiled_shop =0;
                                                $count = 1;
                                                // $sum_weight_factory != 0 ? $sum_weight_factory = $sum_weight_factory : $sum_weight_factory = 1;
                                            @endphp 
                                            @php $sum_weight_dift = 0;
                                                $sum_unit_dift = 0; 
                                                $sum_yiled_dift =0;
                                                $count = 1;
                                            @endphp
    
    
                                            @foreach ($select_order_result as $result)
                                                @php
                                                    $tmp_weight = $result->total_weight;
                                                    $tmp_unit = $result->unit;
                                                    $chk_weight = 0;
                                                    $chk_unit = 0;
                                                    $chk_percent = 0;
                                                @endphp
                                                {{-- check not exist --}}
                                                @foreach ($select_shop_result as $result2)
                                                @if ($result2->item_code == $result->item_code)
                                                    @php
                                                        $chk_weight = $chk_weight + number_format( (float)($result2->total_weight)-($tmp_weight), 2, '.', '');
                                                        $chk_unit = $chk_unit + ($result2->unit - $tmp_unit);
                                                        $chk_percent = $chk_percent + ($result2->unit - $tmp_unit);
                                                    @endphp
                                                @endif
                                                @endforeach
    
                                                @if ($chk_weight == 0 && $chk_unit == 0 && $chk_percent == 0)
                                                    <tr style="background-color:#ffffaa;" hidden>   
                                                @else
                                                    <tr style="background-color:#ffffaa;">  
                                                @endif
                                                    <td class="text-center" style="padding: 0px;">{{ $count++ }}</td>
                                                    <td class="text-center" style="padding: 0px;">{{ $result->item_code }}</td>
                                                    <td class="text-center" style="padding: 0px;">{{ $result->item_name }}</td>
                                                    <td class="text-center" style="padding: 0px;">{{ empty($result->total_weight) ? 0 : $result->total_weight }}
                                                        @php
                                                            $sum_weight_factory = $sum_weight_factory + $result->total_weight;
                                                        @endphp
                                                    </td>
                                                    <td class="text-center" style="padding: 0px;">{{ empty($result->unit) ? 0 : $result->unit }}
                                                        @php
                                                            $sum_unit_factory = $sum_unit_factory + $result->unit;
                                                        @endphp
                                                    </td>
    
                                                    {{-- dift --}}
                                                    {{-- <td class="text-center" style="padding: 0px;">{{ ($weight_recieve == 0 ? 0 : number_format( ($result->total_weight/$weight_recieve)*100 ,2 )  ) }} %
                                                    @php
                                                        $sum_yiled_factory = $sum_yiled_factory + ($weight_recieve == 0 ? 0 : number_format( ($result->total_weight/$weight_recieve)*100 ,2 )  )
                                                    @endphp
                                                    </td> --}}
    
    
                                                {{-- shop --}}  @php $chk_exist = true; @endphp
                                                @foreach ($select_shop_result as $result2)
                                                    @if ($result2->item_code == $result->item_code)
                                                    <td class="text-center" style="padding: 0px;">{{ empty($result2->total_weight) ? 0 : $result2->total_weight }}
                                                        @php
                                                            $sum_weight_shop = $sum_weight_shop + $result2->total_weight;
                                                        @endphp
                                                    </td>
                                                    <td class="text-center" style="padding: 0px;">{{ empty($result2->unit) ? 0 : $result2->unit }}
                                                        @php
                                                            $sum_unit_shop = $sum_unit_shop + $result2->unit;
                                                        @endphp
                                                    </td>
                                                    
                                                    {{-- compare --}}
                                                    <td class="text-center" style="padding: 0px;background-color:#ffbeba;">{{ number_format( (float)($result2->total_weight)-($result->total_weight), 2, '.', '') }}
                                                        @php
                                                            $sum_weight_dift = $sum_weight_dift + number_format( (float)($result2->total_weight)-($result->total_weight), 2, '.', '');
                                                        @endphp
                                                    </td>
                                                    <td class="text-center" style="padding: 0px;background-color:#ffbeba;">
                                                        @if ($result2->unit - $result->unit != 0)
                                                            <b style="color:#f8181e;">{{ $result2->unit - $result->unit }}</b>
                                                        @else
                                                            {{ $result2->unit - $result->unit }}
                                                        @endif
    
                                                        @php
                                                            $sum_unit_dift = $sum_unit_dift + ($result2->unit - $result->unit);
                                                        @endphp
                                                    </td>
                                                    <td class="text-center" style="padding: 0px;background-color:#ffbeba;">{{ ($sum_total_weight_factory == 0 ? 0 : number_format( ($result2->total_weight/$sum_total_weight_factory)*100 ,2 )  ) }} %
                                                    @php
                                                        $sum_yiled_dift = $sum_yiled_dift + ($sum_total_weight_factory == 0 ? 0 : number_format( ($result2->total_weight/$sum_total_weight_factory)*100 ,2 )  );
                                                        $chk_exist = false;
                                                    @endphp
                                                    </td>
                                                    @endif
                                                @endforeach
    
                                                    @if ($chk_exist)
                                                        <td ></td>
                                                        <td ></td>
                                                        <td ></td>
                                                        <td ></td>
                                                        <td ></td>
                                                    @endif
                                                </tr>
                                            @endforeach
    
                                            @foreach ($select_order_result_of as $result) 
                                                @php
                                                    $tmp_weight = 0;
                                                    $tmp_unit = 0;
                                                    $chk_weight = 0;
                                                    $chk_unit = 0;
                                                    $chk_percent = 0;
                                                @endphp
    
                                                {{-- item_code เดียวกัน รวม นน กัน --}}
                                                @foreach ($select_order_same as $cl_weight)
                                                    @php
                                                        if ($cl_weight->item_code == $result->item_code){
                                                            $tmp_weight = $tmp_weight + ($cl_weight->total_weight+$result->total_weight);
                                                            $tmp_unit = $tmp_unit + ($cl_weight->unit+$result->unit);
                                                        }elseif($tmp_weight == 0){
                                                            $tmp_weight =$result->total_weight;
                                                            $tmp_unit = $result->unit;
                                                        }
                                                        
                                                    @endphp
                                                @endforeach
    
                                                {{-- check not exist --}}
                                                @foreach ($select_shop_result as $result2)
                                                    @if ($result2->item_code == $result->item_code)
                                                        @php
                                                            $chk_weight = $chk_weight + number_format( (float)($result2->total_weight)-($tmp_weight), 2, '.', '');
                                                            $chk_unit = $chk_unit + ($result2->unit - $tmp_unit);
                                                            $chk_percent = $chk_percent + number_format( ($result2->total_weight/$sum_total_weight_factory)*100 ,2 );
                                                        @endphp
                                                    @endif
                                                @endforeach
    
                                                @if ($chk_weight == 0 && $chk_unit == 0 && $chk_percent == 0)
                                                    <tr style="background-color:#ff8000;" hidden>   
                                                @else
                                                    <tr style="background-color:#ccffe6;">   
                                                @endif
                                                    <td class="text-center" style="padding: 0px;">{{ $count++ }}</td>
                                                    <td class="text-center" style="padding: 0px;">{{ $result->item_code }}</td>
                                                    <td class="text-center" style="padding: 0px;">{{ $result->item_name }}</td>
                                                    <td class="text-center" style="padding: 0px;">{{ empty($tmp_weight) ? 0 : $tmp_weight }}
                                                        @php
                                                            $sum_weight_factory = $sum_weight_factory + $tmp_weight;
                                                        @endphp
                                                    </td>
                                                    <td class="text-center" style="padding: 0px;">{{ empty($tmp_unit) ? 0 : $tmp_unit }}
                                                        @php
                                                            $sum_unit_factory = $sum_unit_factory + $tmp_unit;
                                                        @endphp
                                                    </td>
    
                                                    {{-- dift --}}
                                                    {{-- <td class="text-center" style="padding: 0px;">{{ ($weight_recieve == 0 ? 0 : number_format( ($result->total_weight/$weight_recieve)*100 ,2 )  ) }} %
                                                    @php
                                                        $sum_yiled_factory = $sum_yiled_factory + ($weight_recieve == 0 ? 0 : number_format( ($result->total_weight/$weight_recieve)*100 ,2 )  )
                                                    @endphp
                                                    </td> --}}
    
    
                                                {{-- shop --}} @php $chk_exist = true; @endphp
                                                @foreach ($select_shop_result as $result2) 
                                                    @if ($result2->item_code == $result->item_code)
                                                    <td class="text-center" style="padding: 0px;">{{ empty($result2->total_weight) ? 0 : $result2->total_weight }}
                                                        @php
                                                            $sum_weight_shop = $sum_weight_shop + $result2->total_weight;
                                                        @endphp
                                                    </td>
                                                    <td class="text-center" style="padding: 0px;">{{ empty($result2->unit) ? 0 : $result2->unit }}
                                                        @php
                                                            $sum_unit_shop = $sum_unit_shop + $result2->unit;
                                                        @endphp
                                                    </td>
                                                    
                                                    {{-- compare --}}
                                                    <td class="text-center" style="padding: 0px;background-color:#ffbeba;">{{ number_format( (float)($result2->total_weight)-($tmp_weight), 2, '.', '') }}
                                                        @php
                                                            $sum_weight_dift = $sum_weight_dift + number_format( (float)($result2->total_weight)-($tmp_weight), 2, '.', '');
                                                        @endphp
                                                    </td>
                                                    <td class="text-center" style="padding: 0px;background-color:#ffbeba;">
                                                        @if ($result2->unit - $tmp_unit != 0)
                                                            <b style="color:#f8181e;">{{ $result2->unit - $tmp_unit }}</b>
                                                        @else
                                                            {{ $result2->unit - $tmp_unit }}
                                                        @endif
    
                                                        @php
                                                            $sum_unit_dift = $sum_unit_dift + ($result2->unit - $tmp_unit);
                                                        @endphp
                                                    </td>
                                                    <td class="text-center" style="padding: 0px;background-color:#ffbeba;">{{ ($sum_total_weight_factory == 0 ? 0 : number_format( ($result2->total_weight/$sum_total_weight_factory)*100 ,2 )  ) }} %
                                                    @php
                                                        $sum_yiled_dift = $sum_yiled_dift + ($sum_total_weight_factory == 0 ? 0 : number_format( ($result2->total_weight/$sum_total_weight_factory)*100 ,2 )  );
                                                        $chk_exist = false;
                                                    @endphp
                                                    </td>
                                                    @endif
                                                @endforeach
    
                                                
                                                    @if ($chk_exist)
                                                        <td ></td>
                                                        <td ></td>
                                                        <td ></td>
                                                        <td ></td>
                                                        <td ></td>
                                                    @endif
                                                </tr>
                                            @endforeach
    
                                            @foreach ($select_order_result_transform as $result)
                                                @php
                                                    $tmp_weight = $result->total_weight;
                                                    $tmp_unit = $result->unit;
                                                    $chk_weight = 0;
                                                    $chk_unit = 0;
                                                    $chk_percent = 0;
                                                @endphp
                                                {{-- check not exist --}}
                                                @foreach ($select_shop_result_transform as $result2)
                                                @if ($result2->item_code == $result->item_code)
                                                    @php
                                                        $chk_weight = $chk_weight + number_format( (float)($result2->total_weight)-($tmp_weight), 2, '.', '');
                                                        $chk_unit = $chk_unit + ($result2->unit - $tmp_unit);
                                                        $chk_percent = $chk_percent + ($result2->unit - $tmp_unit);
                                                    @endphp
                                                @endif
                                                @endforeach
    
                                                @if ($chk_weight == 0 && $chk_unit == 0 && $chk_percent == 0)
                                                    <tr style="background-color:#ff8cff;" hidden>   
                                                @else
                                                    <tr style="background-color:#ff8cff;">  
                                                @endif
                                                    <td class="text-center" style="padding: 0px;">{{ $count++ }}</td>
                                                    <td class="text-center" style="padding: 0px;">{{ $result->item_code }}</td>
                                                    <td class="text-center" style="padding: 0px;">{{ $result->item_name }}</td>
                                                    <td class="text-center" style="padding: 0px;">{{ empty($result->total_weight) ? 0 : $result->total_weight }}
                                                        @php
                                                            $sum_weight_factory = $sum_weight_factory + $result->total_weight;
                                                        @endphp
                                                    </td>
                                                    <td class="text-center" style="padding: 0px;">{{ empty($result->unit) ? 0 : $result->unit }}
                                                        @php
                                                            $sum_unit_factory = $sum_unit_factory + $result->unit;
                                                        @endphp
                                                    </td>
    
                                                {{-- shop --}} @php $chk_exist = true; @endphp
                                                @foreach ($select_shop_result_transform as $result2) 
                                                    @if ($result2->item_code == $result->item_code)
                                                    <td class="text-center" style="padding: 0px;">{{ empty($result2->total_weight) ? 0 : $result2->total_weight }}
                                                        @php
                                                            $sum_weight_shop = $sum_weight_shop + $result2->total_weight;
                                                        @endphp
                                                    </td>
                                                    <td class="text-center" style="padding: 0px;">{{ empty($result2->unit) ? 0 : $result2->unit }}
                                                        @php
                                                            $sum_unit_shop = $sum_unit_shop + $result2->unit;
                                                        @endphp
                                                    </td>
                                                    
                                                    {{-- compare --}}
                                                    <td class="text-center" style="padding: 0px;background-color:#ffbeba;">{{ number_format( (float)($result2->total_weight)-($result->total_weight), 2, '.', '') }}
                                                        @php
                                                            $sum_weight_dift = $sum_weight_dift + number_format( (float)($result2->total_weight)-($result->total_weight), 2, '.', '');
                                                        @endphp
                                                    </td>
                                                    <td class="text-center" style="padding: 0px;background-color:#ffbeba;">
                                                        @if ($result2->unit - $result->unit != 0)
                                                            <b style="color:#f8181e;">{{ $result2->unit - $result->unit }}</b>
                                                        @else
                                                            {{ $result2->unit - $result->unit }}
                                                        @endif
    
                                                        @php
                                                            $sum_unit_dift = $sum_unit_dift + ($result2->unit - $result->unit);
                                                        @endphp
                                                    </td>
                                                    <td class="text-center" style="padding: 0px;background-color:#ffbeba;">{{ ($sum_total_weight_factory == 0 ? 0 : number_format( ($result2->total_weight/$sum_total_weight_factory)*100 ,2 )  ) }} %
                                                    @php
                                                        $sum_yiled_dift = $sum_yiled_dift + ($sum_total_weight_factory == 0 ? 0 : number_format( ($result2->total_weight/$sum_total_weight_factory)*100 ,2 )  );
                                                        $chk_exist = false;
                                                    @endphp
                                                    </td>
                                                    @endif
                                                @endforeach
    
                                                    @if ($chk_exist)
                                                        <td ></td>
                                                        <td ></td>
                                                        <td ></td>
                                                        <td ></td>
                                                        <td ></td>
                                                    @endif
    
                                                </tr>
                                            @endforeach
        
                                            {{-- สรุปรวม --}}
                                                <tr style="background-color:#ffbeba;">
                                                    <td class="text-center" style="padding: 0px;" ></td>
                                                    <td class="text-center" style="padding: 0px;" ></td>
                                                    <td class="text-center" style="padding: 0px;" ></td>
                                                    <td class="text-center" style="padding: 0px;" ><b>{{ $sum_weight_factory }}</b></td>
                                                    <td class="text-center" style="padding: 0px;" ><b>{{ $sum_unit_factory }}</b></td>
    
                                                    
                                                    <td class="text-center" style="padding: 0px;" ><b>{{ $sum_weight_shop }}</b></td>
                                                    <td class="text-center" style="padding: 0px;" ><b>{{ $sum_unit_shop }}</b></td>
    
                                                    
                                                    <td class="text-center" style="padding: 0px;"><b>{{ number_format( $sum_weight_dift, 2, '.', '') }}</b></td>
                                                    <td class="text-center" style="padding: 0px;" ><b>{{ $sum_unit_dift }}</b></td>
                                                    <td class="text-center" style="padding: 0px;" ><b>{{ $sum_yiled_dift }} %</b></td>
    
    
                                                </tr>
                                        </tbody>
                                    </table>
                                    </div>
                                </div>

                        <hr>
                            

                        
                        </div>
                    </div>
                </div>
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

    {{-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script> --}}
    <script src="{{ asset('https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js') }}"></script>
    <script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js') }}"></script>
    <script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js') }}"></script>
    <script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js') }}"></script>

    <script>
            var table = $('#tbl-3').DataTable({
                lengthMenu: [[200, -1], [200, "All"]],
                "scrollX": false,
                orderCellsTop: true,
                fixedHeader: true,
                rowReorder: true,
                dom: 'lBfrtip',
                buttons: [
                    // 'excel',
                    {
                        extend: 'excel',
                        messageTop: " รายงานเปรียบเทียบน้ำหนักชิ้นส่วนสุกร โรงงาน-ร้านค้า {{ $shop_name=='' ? '' : $shop_name }}\
                            ประจำวันที่ {{ $date=='' ? '' : substr($date,3,2).'/'.substr($date,0,2).'/'.substr($date,6,4) }}",
                        customize: function( xlsx ) {
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];
                            $('row c[r^="H"]', sheet).each( function () {
                                    $(this).attr( 's', '12' );
                            });
                            $('row c[r^="I"]', sheet).each( function () {
                                    $(this).attr( 's', '12' );
                            });
                        },
                    },
                    //  'pdf', 'print'
                ],
                customize: function(xlsx) {
                    var sheet = xlsx.xl.worksheets['Sheet1.xml'];
                    $('row c*', sheet).attr( 's', '25' );
                },
                // processing: true,
                // serverSide: true,
                "order": [],
            });
    </script>

    {{-- daterange --}}
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <script>
            $('#daterange').daterangepicker({
                buttonClasses: ['btn', 'btn-sm'],
                applyClass: 'btn-danger',
                cancelClass: 'btn-inverse',
                todayBtn: true,
                language: 'th',
                thaiyear: true,
                locale: {
                    format: 'DD/MM/YYYY',
                    daysOfWeek : [
                                    "อา.",
                                    "จ.",
                                    "อ.",
                                    "พ.",
                                    "พฤ.",
                                    "ศ.",
                                    "ส."
                                ],
                    monthNames : [
                                    "มกราคม",
                                    "กุมภาพันธ์",
                                    "มีนาคม",
                                    "เมษายน",
                                    "พฤษภาคม",
                                    "มิถุนายน",
                                    "กรกฎาคม",
                                    "สิงหาคม",
                                    "กันยายน",
                                    "ตุลาคม",
                                    "พฤศจิกายน",
                                    "ธันวาคม"
                                ],
                    firstDay : 0
                }
            });
        </script>

    <script>
        function edit_weight_side(order_number,weight){
            var sign = "'";
            $('#data_weight').html('<div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;">น้ำหนักหมูขุน '+order_number+'</div\
                <div class="row" style="margin-bottom: 10px;">\
                    <div class="col-md-12 pr-md-0">\
                        <input type="text" class="form-control form-control-sm" id="weight_" name="weight_"  value="'+weight+'" required>\
                    </div>\
                </div>\
                <div class="text-center" style="padding-top: 10px;">\
                    <button type="submit" class="btn btn-success mr-2" id="comfirmAdd" onclick="save_weight('+sign+order_number+sign+')" name="order_number" value="'+order_number+'">ยืนยัน</button>\
                </div>');
        }

    
    </script>

    <script type="text/javascript">
        function save_weight(order_number){
            var weight_ = $("#weight_").val();
            
            $('#edit_weight').modal('hide');
            
            $.ajax({
                type: 'GET',
                dataType: 'JSON',
                url: '{{ url('compare/edit_weight_recieve') }}',
                data: {order_number:order_number,weight_:weight_},
                beforeSend: function(){
                    $('.ajax-loader').css("visibility", "visible");
                },
                success: function (msg) {
                    if (msg === 0) {
                        alert('แก้ไขสำเร็จ');
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("Status: " + textStatus); alert("Error: " + errorThrown);
                },
                complete: function(){
                    location.reload();
                },
            });
        }
    </script>

<script>
    window.onload = function () {
        window.print();
    }
</script>

</body>
</html>

