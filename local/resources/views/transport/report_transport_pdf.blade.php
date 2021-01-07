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
    zoom: 0.5;
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
                        <div class="row"> 
                            <div class="col-12 px-0">
                                {{ Form::open(['method' => 'post' , 'url' => '/report_transport/check']) }}   
                                    <table id="tbl-3" class="tbl" width="100%" border="1">
                                        <thead>
                                            <tr class="bg-secondary text-center align-bottom" style=" height: 70px;" ><th colspan="10" style=" padding: 0px;"><h4> รายงานตรวจสอบน้ำหนักชิ้นส่วนสุกรในกระบวนการผลิต
                                                <span style="color:red;">{{ $select_cutting_number[0]->id_user_customer =='' ? '' : $select_cutting_number[0]->id_user_customer }}</span>
                                                วันที่ <span style="color:red;">{{ $select_cutting_number[0]->date_transport == '' ? '' : substr($select_cutting_number[0]->date_transport,0,2).'/'.substr($select_cutting_number[0]->date_transport,3,2).'/'.substr($select_cutting_number[0]->date_transport,6,4) }} </span>
                                                เลขที่บิล <span style="color:red;">{{ $select_cutting_number[0]->order_number }}
                                                    <input type="text" hidden name="tr_number" value="{{ $select_cutting_number[0]->order_number }}">
                                                </span> </h4></th>
                                                <th colspan="3">เวลาโหลด .....................</th>
                                                <th colspan="3">อุณหภูมิรถ .....................</th>
                                                <th colspan="4">ทะเบียนรถ ..................................</th>
                                                <th colspan="4">ชื่อคนขับ .................................................</th>
                                            </tr>
                                            <tr class="bg-secondary">
                                                <th class="text-center" style="padding: 0px;">No.</th>
                                                <th class="text-center" style="padding: 0px;">ชื่อ item </th>
                                                <th class="text-center" style="padding: 0px;">1</th>
                                                <th class="text-center" style="padding: 0px;">2</th>
                                                <th class="text-center" style="padding: 0px;">3</th>
                                                <th class="text-center" style="padding: 0px;">4</th>
                                                <th class="text-center" style="padding: 0px;">5</th>
                                                <th class="text-center" style="padding: 0px;">6</th>
                                                <th class="text-center" style="padding: 0px;">7</th>
                                                <th class="text-center" style="padding: 0px;">8</th>
                                                <th class="text-center" style="padding: 0px;">9</th>
                                                <th class="text-center" style="padding: 0px;">10</th>
                                                <th class="text-center" style="padding: 0px;">11</th>
                                                <th class="text-center" style="padding: 0px;">12</th>
                                                <th class="text-center" style="padding: 0px;">13</th>
                                                <th class="text-center" style="padding: 0px;">14</th>
                                                <th class="text-center" style="padding: 0px;">15</th>
                                                <th class="text-center" style="padding: 0px;">16</th>
                                                <th class="text-center" style="padding: 0px;">17</th>
                                                <th class="text-center" style="padding: 0px;">18</th>
                                                <th class="text-center" style="padding: 0px;">19</th>
                                                <th class="text-center" style="padding: 0px;">20</th>
                                                <th class="text-center" style="padding: 0px;">น้ำหนัก</th>
                                                <th class="text-center" style="padding: 0px;">จำนวน</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- ตัดแต่ง --}}
                                            @php $sum_weight = 0;
                                                    $sum_unit   = 0;
                                            @endphp
                                            @foreach ($select_item_main as $result)
                                                @php
                                                    $span = (int)($result->count_unit/20);
                                                    if ( ($result->count_unit % 20) != 0 || $result->count_unit == 0) {
                                                        $span = $span +1;
                                                    }
                                                @endphp
                                                <tr style="background-color:#ffffaa;">
                                                        <td class="text-center bg-secondary" style="padding: 0px;width: 80px;" rowspan="{{ $span }}">{{ $result->item_code }}</td>
                                                        <td class="text-center" style="padding: 0px;width: 200px;" rowspan="{{ $span }}">{{ $result->item_name }}</td>
                                                            @php $i = 20; @endphp
                                                            @foreach ($select_weight_in_order as $in_order)
                                                                    @if (str_replace(' ', '', $in_order->sku_code) == $result->item_code && $i > 0 )
                                                                        <td class="text-center" style="padding: 0px; width: 50px;">{{ $in_order->sku_weight }}</td>
                                                                        @php $i = $i-1; @endphp
                                                                    @endif
                                                            @endforeach
                                                            @for ($j= 0; $j < $i; $j++)
                                                                <td class="text-center" style="padding: 0px; width: 50px;"></td>  
                                                            @endfor
                                                        <td class="text-center" style="padding: 0px; width: 80px;" rowspan="{{ $span }}">{{ ($result->sum_weight != 0 ? $result->sum_weight : 0) }}
                                                        @php
                                                            $sum_weight = $sum_weight + ($result->sum_weight != 0 ? $result->sum_weight : 0);
                                                        @endphp</td>
                                                        <td class="text-center" style="padding: 0px; width: 80px;" rowspan="{{ $span }}">{{ $result->count_unit }}
                                                        @php
                                                            $sum_unit = $sum_unit + $result->count_unit;
                                                        @endphp</td>
                                                </tr>
            
                                                @for ($row = 1; $row < $span; $row++)
                                                <tr style="background-color:#ffffaa;">
                                                    <td hidden class="text-center bg-secondary" style="padding: 0px;"></td>
                                                    <td hidden class="text-center" style="padding: 0px;"></td>
                                                        @php $i = 20*($row+1); @endphp
                                                        @foreach ($select_weight_in_order as $in_order)
            
                                                            @if (str_replace(' ', '', $in_order->sku_code) == $result->item_code && $i >= 20 )
                                                                @php $i = $i-1;@endphp
                                                            @endif
            
                                                            @if(str_replace(' ', '', $in_order->sku_code) == $result->item_code && $i >= 0 && $i < 20)
                                                                <td class="text-center" style="padding: 0px; width: 50px;">{{ $in_order->sku_weight }}</td>
                                                                @php $i = $i-1; @endphp
                                                            @endif
                                                                
                                                        @endforeach
                                                        @for ($j= 0; $j < $i+1; $j++)
                                                            <td class="text-center" style="padding: 0px; width: 50px;"></td>  
                                                        @endfor
                                                    <td hidden class="text-center" style="padding: 0px;"></td>
                                                    <td hidden class="text-center" style="padding: 0px;"></td>
                                                    <td hidden class="text-center" style="padding: 0px;"></td>
                                                </tr>
                                                @endfor
                                            @endforeach
                                            {{-- สรุปรวม ตัดแต่ง--}}
                                            <tr style="background-color:#e6e600;">
                                                <td class="text-center" style="padding: 0px;" ></td>
                                                <td class="text-center" style="padding: 0px;" ><b> รวม ตัดแต่ง </b></td>
            
                                                <td class="text-center" style="padding: 0px;" ></td>
                                                <td class="text-center" style="padding: 0px;" ></td>
                                                <td class="text-center" style="padding: 0px;" ></td>
                                                <td class="text-center" style="padding: 0px;" ></td>
                                                <td class="text-center" style="padding: 0px;" ></td>
                                                <td class="text-center" style="padding: 0px;" ></td>
                                                <td class="text-center" style="padding: 0px;" ></td>
                                                <td class="text-center" style="padding: 0px;" ></td>
                                                <td class="text-center" style="padding: 0px;" ></td>
                                                <td class="text-center" style="padding: 0px;" ></td>
            
                                                <td class="text-center" style="padding: 0px;" ></td>
                                                <td class="text-center" style="padding: 0px;" ></td>
                                                <td class="text-center" style="padding: 0px;" ></td>
                                                <td class="text-center" style="padding: 0px;" ></td>
                                                <td class="text-center" style="padding: 0px;" ></td>
                                                <td class="text-center" style="padding: 0px;" ></td>
                                                <td class="text-center" style="padding: 0px;" ></td>
                                                <td class="text-center" style="padding: 0px;" ></td>
                                                <td class="text-center" style="padding: 0px;" ></td>
                                                <td class="text-center" style="padding: 0px;" ><b> รวม </b></td>
                                                
                                                <td class="text-center" style="padding: 0px;" ><b>{{ $sum_weight }}</b></td>
                                                <td class="text-center" style="padding: 0px;" ><b>{{ $sum_unit }}</b></td>
                                            </tr>

    {{-- ------------------------------------------------------------------------------------- --}}

                                        {{-- เครื่องใน --}}
                                        @php 
                                            $sum_weight_offal = 0;
                                            $sum_unit_offal   = 0;
                                        @endphp
                                        @foreach ($select_item_offal_main as $result)
                                            @php
                                                $span = (int)($result->count_unit/20);
                                                if ( ($result->count_unit % 20) != 0 || $result->count_unit == 0) {
                                                    $span = $span +1;
                                                }
                                            @endphp
                                            <tr  style="background-color:#ccffe6;">
                                                    <td class="text-center bg-secondary" style="padding: 0px;width: 80px;" rowspan="{{ $span }}">{{ $result->item_code }}</td>
                                                    <td class="text-center" style="padding: 0px;width: 200px;" rowspan="{{ $span }}">{{ $result->item_name }}</td>
                                                        @php $i = 20; @endphp
                                                        @foreach ($select_weight_in_order_offal as $in_order)
                                                                @if (str_replace(' ', '', $in_order->sku_code) == $result->item_code && $i > 0 )
                                                                    <td class="text-center" style="padding: 0px; width: 50px;">{{ $in_order->sku_weight }}</td>
                                                                    @php $i = $i-1; @endphp
                                                                @endif
                                                        @endforeach
                                                        @for ($j= 0; $j < $i; $j++)
                                                            <td class="text-center" style="padding: 0px; width: 50px;"></td>  
                                                        @endfor
                                                    <td class="text-center" style="padding: 0px; width: 80px;" rowspan="{{ $span }}">{{ ($result->sum_weight != 0 ? $result->sum_weight : 0) }}
                                                    @php
                                                        $sum_weight_offal = $sum_weight_offal + ($result->sum_weight != 0 ? $result->sum_weight : 0);
                                                    @endphp</td>
                                                    <td class="text-center" style="padding: 0px; width: 80px;" rowspan="{{ $span }}">{{ $result->count_unit }}
                                                    @php
                                                        $sum_unit_offal = $sum_unit_offal + $result->count_unit;
                                                    @endphp</td>
                                            </tr>

                                            @for ($row = 1; $row < $span; $row++)
                                            <tr style="background-color:#ccffe6;">
                                                <td hidden class="text-center bg-secondary" style="padding: 0px;"></td>
                                                <td hidden class="text-center" style="padding: 0px;"></td>
                                                    @php $i = 20*($row+1); @endphp
                                                    @foreach ($select_weight_in_order_offal as $in_order)

                                                        @if (str_replace(' ', '', $in_order->sku_code) == $result->item_code && $i >= 20 )
                                                            @php $i = $i-1;@endphp
                                                        @endif

                                                        @if(str_replace(' ', '', $in_order->sku_code) == $result->item_code && $i >= 0 && $i < 20)
                                                            <td class="text-center" style="padding: 0px; width: 50px;">{{ $in_order->sku_weight }}</td>
                                                            @php $i = $i-1; @endphp
                                                        @endif
                                                            
                                                    @endforeach
                                                    @for ($j= 0; $j < $i+1; $j++)
                                                        <td class="text-center" style="padding: 0px; width: 50px;"></td>  
                                                    @endfor
                                                <td hidden class="text-center" style="padding: 0px;"></td>
                                                <td hidden class="text-center" style="padding: 0px;"></td>
                                            </tr>
                                            @endfor
                                        @endforeach
                                        {{-- รวมเครื่องใน --}}
                                        <tr style="background-color:#00ff80;">
                                            <td class="text-center" style="padding: 0px;" ></td>
                                            <td class="text-center" style="padding: 0px;" ><b>รวม เครื่องใน</b></td>

                                            <td class="text-center" style="padding: 0px;" ></td>
                                            <td class="text-center" style="padding: 0px;" ></td>
                                            <td class="text-center" style="padding: 0px;" ></td>
                                            <td class="text-center" style="padding: 0px;" ></td>
                                            <td class="text-center" style="padding: 0px;" ></td>
                                            <td class="text-center" style="padding: 0px;" ></td>
                                            <td class="text-center" style="padding: 0px;" ></td>
                                            <td class="text-center" style="padding: 0px;" ></td>
                                            <td class="text-center" style="padding: 0px;" ></td>
                                            <td class="text-center" style="padding: 0px;" ></td>

                                            <td class="text-center" style="padding: 0px;" ></td>
                                            <td class="text-center" style="padding: 0px;" ></td>
                                            <td class="text-center" style="padding: 0px;" ></td>
                                            <td class="text-center" style="padding: 0px;" ></td>
                                            <td class="text-center" style="padding: 0px;" ></td>
                                            <td class="text-center" style="padding: 0px;" ></td>
                                            <td class="text-center" style="padding: 0px;" ></td>
                                            <td class="text-center" style="padding: 0px;" ></td>
                                            <td class="text-center" style="padding: 0px;" ></td>
                                            <td class="text-center" style="padding: 0px;" ></td>
                                            
                                            <td class="text-center" style="padding: 0px;" ><b>{{ $sum_weight_offal }}</b></td>
                                            <td class="text-center" style="padding: 0px;" ><b>{{ $sum_unit_offal }}</b></td>
                                        </tr>

                                        {{-- สรุปรวมทั้งหมด --}}
                                        <tr style="background-color:#ff847d;">
                                            <td class="text-center" style="padding: 0px;height: 25px;" ></td>
                                            <td class="text-center" style="padding: 0px;" >รวมทั้งหมด</td>
        
                                            <td class="text-center" style="padding: 0px;" ></td>
                                            <td class="text-center" style="padding: 0px;" ></td>
                                            <td class="text-center" style="padding: 0px;" ></td>
                                            <td class="text-center" style="padding: 0px;" ></td>
                                            <td class="text-center" style="padding: 0px;" ></td>
                                            <td class="text-center" style="padding: 0px;" ></td>
                                            <td class="text-center" style="padding: 0px;" ></td>
                                            <td class="text-center" style="padding: 0px;" ></td>
                                            <td class="text-center" style="padding: 0px;" ></td>
                                            <td class="text-center" style="padding: 0px;" ></td>
        
                                            <td class="text-center" style="padding: 0px;" ></td>
                                            <td class="text-center" style="padding: 0px;" ></td>
                                            <td class="text-center" style="padding: 0px;" ></td>
                                            <td class="text-center" style="padding: 0px;" ></td>
                                            <td class="text-center" style="padding: 0px;" ></td>
                                            <td class="text-center" style="padding: 0px;" ></td>
                                            <td class="text-center" style="padding: 0px;" ></td>
                                            <td class="text-center" style="padding: 0px;" ></td>
                                            <td class="text-center" style="padding: 0px;" ></td>
                                            <td class="text-center" style="padding: 0px;" ><b>  </b></td>
                                            
                                            <td class="text-center" style="padding: 0px;" ><b>{{ $sum_weight + $sum_weight_offal }}</b></td>
                                            <td class="text-center" style="padding: 0px;" ><b>{{ $sum_unit + $sum_unit_offal}}</b></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center"></td>
                                            <td class="text-center" colspan="4">น้ำหนักชิ้นส่วนรวมทั้งหมด  {{ $sum_weight + $sum_weight_offal }} KG <br> จำนวนตะกร้าที่ใช้ {{ $sum_unit + $sum_unit_offal}} ใบ </td>
                                            <td class="text-center"></td>
                                            <td class="text-center" colspan="5">สรุปจำนวนถุงเทียบกับรายงาน</td>
                                            <td class="text-center"></td>
                                            <td class="text-center" colspan="5">สรุปจำนวนที่นับได้ก่อนออกจากโรงงานเทียบกับโหลด</td>
                                            <td class="text-center"></td>
                                            <td class="text-center" colspan="6">สรุปจำนวนที่นับเมื่อถึงร้านเทียบกับก่อนออกจากโรงงาน</td>
                                            <td class="text-center" hidden></td>
                                            <td class="text-center" hidden></td>
                                            <td class="text-center" hidden></td>
                                            <td class="text-center" hidden></td>
                                            <td class="text-center" hidden></td>
                                            <td class="text-center" hidden></td>
                                            <td class="text-center" hidden></td>
                                            <td class="text-center" hidden></td>
                                            <td class="text-center" hidden></td>
                                            <td class="text-center" hidden></td>
                                            <td class="text-center" hidden></td>
                                            <td class="text-center" hidden></td>
                                            <td class="text-center" hidden></td>
                                            <td class="text-center" hidden></td>
                                            <td class="text-center" hidden></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center"></td>
                                            <td class="text-center align-bottom" colspan="4" style=" height: 100px;">.........................................<b style=" padding: 50px;"></b>...............................................</td>
                                            <td class="text-center"></td>
                                            <td class="text-center align-bottom" colspan="5" style=" height: 100px;" >........................................</td>
                                            <td class="text-center"></td>
                                            <td class="text-center align-bottom" colspan="5" style=" height: 100px;">........................................</td>
                                            <td class="text-center"></td>
                                            <td class="text-center align-bottom" colspan="6" style=" height: 100px;" >........................................</td>
                                            <td class="text-center" hidden></td>
                                            <td class="text-center" hidden></td>
                                            <td class="text-center" hidden></td>
                                            <td class="text-center" hidden></td>
                                            <td class="text-center" hidden></td>
                                            <td class="text-center" hidden></td>
                                            <td class="text-center" hidden></td>
                                            <td class="text-center" hidden></td>
                                            <td class="text-center" hidden></td>
                                            <td class="text-center" hidden></td>
                                            <td class="text-center" hidden></td>
                                            <td class="text-center" hidden></td>
                                            <td class="text-center" hidden></td>
                                            <td class="text-center" hidden></td>
                                            <td class="text-center" hidden></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center"></td>
                                            <td class="text-center" colspan="4">ผู้รายงาน<b style=" padding: 50px;"></b>ผู้ตรวจสอบ</td>
                                            <td class="text-center"></td>
                                            <td class="text-center" colspan="5">หัวหน้าส่วนโหลดสินค้า</td>
                                            <td class="text-center"></td>
                                            <td class="text-center" colspan="5">พนักงานขนส่ง</td>
                                            <td class="text-center"></td>
                                            <td class="text-center" colspan="6">หน./รอง หน.ร้าน</td>
                                            <td class="text-center" hidden></td>
                                            <td class="text-center" hidden></td>
                                            <td class="text-center" hidden></td>
                                            <td class="text-center" hidden></td>
                                            <td class="text-center" hidden></td>
                                            <td class="text-center" hidden></td>
                                            <td class="text-center" hidden></td>
                                            <td class="text-center" hidden></td>
                                            <td class="text-center" hidden></td>
                                            <td class="text-center" hidden></td>
                                            <td class="text-center" hidden></td>
                                            <td class="text-center" hidden></td>
                                            <td class="text-center" hidden></td>
                                            <td class="text-center" hidden></td>
                                            <td class="text-center" hidden></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>

  <script src="{{ asset('assets/vendor/js/vendor.bundle.base.js')}}"></script>
  <script src="{{ asset('assets/vendor/js/vendor.bundle.addons.js')}}"></script>

  <script src="{{ asset('assets/js/demo_2/dashboard.js')}}"></script>
  <script src="{{ asset('assets/js/demo_2/script.js')}}"></script>

  <script src="{{ asset('assets/js/shared/off-canvas.js')}}"></script>
  <script src="{{ asset('assets/js/shared/hoverable-collapse.js')}}"></script>
  <script src="{{ asset('assets/js/shared/misc.js')}}"></script>
  <script src="{{ asset('assets/js/shared/settings.js')}}"></script>
  <script src="{{ asset('assets/js/shared/todolist.js')}}"></script>
  <script src="{{ asset('assets/js/shared/widgets.js')}}"></script>
  <script src="{{ asset('assets/js/shared/form-validation.js')}}"></script>
  <script src="{{ asset('assets/js/shared/bt-maxLength.js')}}"></script>
  <script src="{{ asset('assets/js/shared/formpickers.js')}}"></script>
  {{--  <script src="{{ asset('assets/js/shared/form-addons.js')}}"></script>  --}}
  <script src="{{ asset('assets/js/shared/x-editable.js')}}"></script>
  <script src="{{ asset('assets/js/shared/dropify.js')}}"></script>
  <script src="{{ asset('assets/js/shared/dropzone.js')}}"></script>
  <script src="{{ asset('assets/js/shared/jquery-file-upload.js')}}"></script>
  <script src="{{ asset('assets/js/shared/form-repeater.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.29.2/sweetalert2.all.js"></script>
  
<script>
    window.onload = function () {
        window.print();
    }
</script>


</body>
</html>