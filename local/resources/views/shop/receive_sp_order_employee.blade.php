@extends('layouts.master')
@section('style')
<style type="text/css">
    .input{
            height: 50%;
            background-color: aqua;
    }
    th{
        padding: 0px;
        font-size: 12px;
    }    
    td{
        padding: 0px;
        font-size: 14px;
    }
    .bodyzoom{
        zoom: 0.9;
    }
</style>

<link rel="stylesheet" href="{{ url('https://cdn.datatables.net/1.10.18/css/dataTables.semanticui.min.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/css/daterangepicker.css')}}">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" />

@endsection
@section('main')
            <div class="col-lg-12 grid-margin">
                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-8 text-left"></div>
                            <div class="col-4 text-right">
                                <a class="btn btn-success" target="_blank"  href="../receive_sp_order_employee_print/{{ $date }}"  style="margin-bottom: 10px;">
                                    <i class="fa fa-print">   พิมพ์</i>
                                </a>
                            </div>
                        </div>
                        
                            <div class="forms-sample form-control" style="height: auto;padding-right: 20px;">
                                
                                    <div class="">
                                        <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;"><h5>ใบ Order การตัดแต่งกระดูก วันที่สั่ง : {{ $date_format }} วันที่ส่ง : {{ $number_of_pig[0]->date_transport }}</h5></div>
                                        <table  class="tbl " width="99%" border="1" id="report_shop">
                                            <thead class="text-center ">
                                                <tr style="background-color:#7dbeff;height: 40px;" >
                                                    <th style="padding: 0px;">รหัสสินค้า</th>
                                                    <th style="padding: 0px;" colspan="2">รายการ</th>
                                                    @foreach ($shop_list as $shop)
                                                        <th style="padding: 0px; width:5%;">{{ $shop->marker }}</th>
                                                    @endforeach
                                                    <th style="padding: 0px;">รวม</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach ($collumn1_code as $item_code)
                                                    @php
                                                        $row_check = 0;
                                                    @endphp

                                                    @foreach ($item_list1 as $item_lists) @php $sum = 0; $exist_unit = 0;@endphp
                                                        @if ($item_code->item_code == $item_lists->item_code)
                                                            <tr style="height: 40px;" >
                                                                @if ($row_check == 0)
                                                                    <td style="padding: 0px;" class="text-center" rowspan="{{ $item_code->count_item }}">{{  $item_code->item_code }} </td>
                                                                    @php $row_check++;  @endphp
                                                                @endif
                                                                <td style="padding: 0px;height: 32px;" >{{ $item_lists->item_name_special }} </td>
                                                                <td style="padding: 0px;height: 32px;" >{{ $item_lists->taiyai_name }}</td>
                                                                
                                                                @foreach ($shop_list as $shop) @php $shop_code = $shop->shop_code; @endphp
                                                                    @foreach ($unit_data as $unit)
                                                                        @if ($unit->item_code2 == $item_lists->item_code2)
                                                                            <td style="padding: 0px;" class="text-center">{{ number_format($unit->$shop_code,0,'.','') }}</td>
                                                                            @php $sum = $sum + number_format($unit->$shop_code,0,'.',''); $exist_unit++; @endphp
                                                                        @endif
                                                                    @endforeach
                                                                @endforeach
                                                                

                                                                @if ($exist_unit == 0)
                                                                    @foreach ($shop_list as $shop) @php $sp_exits = 0; @endphp
                                                                        @foreach ($order_sp_request as $sp_request)
                                                                            @if ($sp_request->order_special_id == $item_lists->order_special_id && $shop->shop_code == $sp_request->shop_code)
                                                                                <td style="padding: 0px;" class="text-center">{{ $sp_request->number_of_item }}</td>
                                                                                @php $sum = $sum + $sp_request->number_of_item; $sp_exits ++; @endphp
                                                                            @endif
                                                                        @endforeach
                                                                            @if($sp_exits == 0)
                                                                                <td style="padding: 0px;" class="text-center">0</td>
                                                                            @endif
                                                                    @endforeach
                                                                @endif

                                                                <td style="padding: 0px;" class="text-center">{{ $sum }}</td>
                                                            </tr>
                                                        @endif
                                                    @endforeach

                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
<hr>
                                    <div class="">
                                        <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;"><h5>ใบ Order การตัดแต่งหน้าขาและขาหลัง วันที่สั่ง : {{ $date_format }} วันที่ส่ง : {{ $number_of_pig[0]->date_transport }}</h5>
                                        </div>
                                        <table  class="tbl " width="99%" border="1" id="report_shop">
                                            <thead class="text-center ">
                                                <tr style="background-color:#7dbeff;height: 40px;" >
                                                    <th style="padding: 0px;">รหัสสินค้า</th>
                                                    <th style="padding: 0px;" colspan="2">รายการ</th>
                                                    @foreach ($shop_list as $shop)
                                                        <th style="padding: 0px; width:5%;">{{ $shop->marker }}</th>
                                                    @endforeach
                                                    <th style="padding: 0px;">รวม</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach ($collumn2_code as $item_code)
                                                    @php
                                                        $row_check = 0;
                                                    @endphp

                                                    @foreach ($item_list2 as $item_lists) @php $sum = 0; $exist_unit = 0;@endphp
                                                        @if ($item_code->item_code == $item_lists->item_code)
                                                            <tr style="height: 40px;" >
                                                                @if ($row_check == 0)
                                                                    <td style="padding: 0px;" class="text-center" rowspan="{{ $item_code->count_item }}">{{  $item_code->item_code }} </td>
                                                                    @php $row_check++;  @endphp
                                                                @endif
                                                                <td style="padding: 0px;height: 32px;" >{{ $item_lists->item_name_special }} </td>
                                                                <td style="padding: 0px;height: 32px;" >{{ $item_lists->taiyai_name }}</td>
                                                                
                                                                @foreach ($shop_list as $shop) @php $shop_code = $shop->shop_code; @endphp
                                                                    @foreach ($unit_data as $unit)
                                                                        @if ($unit->item_code2 == $item_lists->item_code2)
                                                                            <td style="padding: 0px;" class="text-center">{{ number_format($unit->$shop_code,0,'.','') }}</td>
                                                                            @php $sum = $sum + number_format($unit->$shop_code,0,'.',''); $exist_unit++; @endphp
                                                                        @endif
                                                                    @endforeach
                                                                @endforeach
                                                                

                                                                @if ($exist_unit == 0)
                                                                    @foreach ($shop_list as $shop) @php $sp_exits = 0; @endphp
                                                                        @foreach ($order_sp_request as $sp_request)
                                                                            @if ($sp_request->order_special_id == $item_lists->order_special_id && $shop->shop_code == $sp_request->shop_code)
                                                                                <td style="padding: 0px;" class="text-center">{{ $sp_request->number_of_item }}</td>
                                                                                @php $sum = $sum + $sp_request->number_of_item; $sp_exits ++; @endphp
                                                                            @endif
                                                                        @endforeach
                                                                            @if($sp_exits == 0)
                                                                                <td style="padding: 0px;" class="text-center">0</td>
                                                                            @endif
                                                                    @endforeach
                                                                @endif

                                                                <td style="padding: 0px;" class="text-center">{{ $sum }}</td>
                                                            </tr>
                                                        @endif
                                                    @endforeach

                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
<hr>
                                    <div class="">
                                        <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;"><h5>ใบ Order การตัดแต่งหัวสุกร วันที่สั่ง : {{ $date_format }} วันที่ส่ง : {{ $number_of_pig[0]->date_transport }}</h5>
                                        </div>
                                        <table  class="tbl " width="99%" border="1" id="report_shop">
                                            <thead class="text-center ">
                                                <tr style="background-color:#7dbeff;height: 40px;" >
                                                    <th style="padding: 0px;">รหัสสินค้า</th>
                                                    <th style="padding: 0px;" colspan="2">รายการ</th>
                                                    @foreach ($shop_list as $shop)
                                                        <th style="padding: 0px; width:5%;">{{ $shop->marker }}</th>
                                                    @endforeach
                                                    <th style="padding: 0px;">รวม</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach ($collumn3_code as $item_code)
                                                    @php
                                                        $row_check = 0;
                                                    @endphp

                                                    @foreach ($item_list3 as $item_lists) @php $sum = 0; $exist_unit = 0;@endphp
                                                        @if ($item_code->item_code == $item_lists->item_code)
                                                            <tr style="height: 40px;" >
                                                                @if ($row_check == 0)
                                                                    <td style="padding: 0px;" class="text-center" rowspan="{{ $item_code->count_item }}">{{  $item_code->item_code }} </td>
                                                                    @php $row_check++;  @endphp
                                                                @endif
                                                                <td style="padding: 0px;height: 32px;" >{{ $item_lists->item_name_special }} </td>
                                                                <td style="padding: 0px;height: 32px;" >{{ $item_lists->taiyai_name }}</td>
                                                                
                                                                @foreach ($shop_list as $shop) @php $shop_code = $shop->shop_code; @endphp
                                                                    @foreach ($unit_data as $unit)
                                                                        @if ($unit->item_code2 == $item_lists->item_code2)
                                                                            <td style="padding: 0px;" class="text-center">{{ number_format($unit->$shop_code,0,'.','') }}</td>
                                                                            @php $sum = $sum + number_format($unit->$shop_code,0,'.',''); $exist_unit++; @endphp
                                                                        @endif
                                                                    @endforeach
                                                                @endforeach
                                                                

                                                                @if ($exist_unit == 0)
                                                                    @foreach ($shop_list as $shop) @php $sp_exits = 0; @endphp
                                                                        @foreach ($order_sp_request as $sp_request)
                                                                            @if ($sp_request->order_special_id == $item_lists->order_special_id && $shop->shop_code == $sp_request->shop_code)
                                                                                <td style="padding: 0px;" class="text-center">{{ $sp_request->number_of_item }}</td>
                                                                                @php $sum = $sum + $sp_request->number_of_item; $sp_exits ++; @endphp
                                                                            @endif
                                                                        @endforeach
                                                                            @if($sp_exits == 0)
                                                                                <td style="padding: 0px;" class="text-center">0</td>
                                                                            @endif
                                                                    @endforeach
                                                                @endif

                                                                <td style="padding: 0px;" class="text-center">{{ $sum }}</td>
                                                            </tr>
                                                        @endif
                                                    @endforeach

                                                @endforeach
                                                
                                            </tbody>
                                        </table>
                                    </div>
<hr>
                                    <div class="">
                                        <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;"><h5>ใบ Order การตัดแต่งพิเศษของลุงติยะ วันที่สั่ง : {{ $date_format }} วันที่ส่ง : {{ $number_of_pig[0]->date_transport }}</h5>
                                        </div>
                                        <table  class="tbl " width="99%" border="1" id="report_shop">
                                            <thead class="text-center ">
                                                <tr style="background-color:#7dbeff;height: 40px;" >
                                                    <th style="padding: 0px;">รหัสสินค้า</th>
                                                    <th style="padding: 0px;" colspan="2">รายการ</th>
                                                    @foreach ($shop_list as $shop)
                                                        <th style="padding: 0px; width:5%;">{{ $shop->marker }}</th>
                                                    @endforeach
                                                    <th style="padding: 0px;">รวม</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach ($collumn4_code as $item_code)
                                                    @php
                                                        $row_check = 0;
                                                    @endphp

                                                    @foreach ($item_list4 as $item_lists) @php $sum = 0; $exist_unit = 0;@endphp
                                                        @if ($item_code->item_code == $item_lists->item_code)
                                                            <tr style="height: 40px;" >
                                                                @if ($row_check == 0)
                                                                    <td style="padding: 0px;" class="text-center" rowspan="{{ $item_code->count_item }}">{{  $item_code->item_code }} </td>
                                                                    @php $row_check++;  @endphp
                                                                @endif
                                                                <td style="padding: 0px;height: 32px;" >{{ $item_lists->item_name_special }} </td>
                                                                <td style="padding: 0px;height: 32px;" >{{ $item_lists->taiyai_name }}</td>
                                                                
                                                                @foreach ($shop_list as $shop) @php $shop_code = $shop->shop_code; @endphp
                                                                    @foreach ($unit_data as $unit)
                                                                        @if ($unit->item_code2 == $item_lists->item_code2)
                                                                            <td style="padding: 0px;" class="text-center">{{ number_format($unit->$shop_code,0,'.','') }}</td>
                                                                            @php $sum = $sum + number_format($unit->$shop_code,0,'.',''); $exist_unit++; @endphp
                                                                        @endif
                                                                    @endforeach
                                                                @endforeach
                                                                

                                                                @if ($exist_unit == 0)
                                                                    @foreach ($shop_list as $shop) @php $sp_exits = 0; @endphp
                                                                        @foreach ($order_sp_request as $sp_request)
                                                                            @if ($sp_request->order_special_id == $item_lists->order_special_id && $shop->shop_code == $sp_request->shop_code)
                                                                                <td style="padding: 0px;" class="text-center">{{ $sp_request->number_of_item }}</td>
                                                                                @php $sum = $sum + $sp_request->number_of_item; $sp_exits ++; @endphp
                                                                            @endif
                                                                        @endforeach
                                                                            @if($sp_exits == 0)
                                                                                <td style="padding: 0px;" class="text-center">0</td>
                                                                            @endif
                                                                    @endforeach
                                                                @endif

                                                                <td style="padding: 0px;" class="text-center">{{ $sum }}</td>
                                                            </tr>
                                                        @endif
                                                    @endforeach

                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>                                    
<hr>
                                    <div class="">
                                        <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;"><h5>ใบ Order การตัดแต่งสามชั้น วันที่สั่ง : {{ $date_format }} วันที่ส่ง : {{ $number_of_pig[0]->date_transport }}</h5>
                                        </div>
                                        <table  class="tbl " width="99%" border="1" id="report_shop">
                                            <thead class="text-center ">
                                                <tr style="background-color:#7dbeff;height: 40px;" >
                                                    <th style="padding: 0px;">รหัสสินค้า</th>
                                                    <th style="padding: 0px;" colspan="2">รายการ</th>
                                                    @foreach ($shop_list as $shop)
                                                        <th style="padding: 0px; width:5%;">{{ $shop->marker }}</th>
                                                    @endforeach
                                                    <th style="padding: 0px;">รวม</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach ($collumn5_code as $item_code)
                                                    @php
                                                        $row_check = 0;
                                                    @endphp

                                                    @foreach ($item_list5 as $item_lists) @php $sum = 0; $exist_unit = 0;@endphp
                                                        @if ($item_code->item_code == $item_lists->item_code)
                                                            <tr style="height: 40px;" >
                                                                @if ($row_check == 0)
                                                                    <td style="padding: 0px;" class="text-center" rowspan="{{ $item_code->count_item }}">{{  $item_code->item_code }} </td>
                                                                    @php $row_check++;  @endphp
                                                                @endif
                                                                <td style="padding: 0px;height: 32px;" >{{ $item_lists->item_name_special }} </td>
                                                                <td style="padding: 0px;height: 32px;" >{{ $item_lists->taiyai_name }}</td>
                                                                
                                                                @foreach ($shop_list as $shop) @php $shop_code = $shop->shop_code; @endphp
                                                                    @foreach ($unit_data as $unit)
                                                                        @if ($unit->item_code2 == $item_lists->item_code2)
                                                                            <td style="padding: 0px;" class="text-center">{{ number_format($unit->$shop_code,0,'.','') }}</td>
                                                                            @php $sum = $sum + number_format($unit->$shop_code,0,'.',''); $exist_unit++; @endphp
                                                                        @endif
                                                                    @endforeach
                                                                @endforeach
                                                                

                                                                @if ($exist_unit == 0)
                                                                    @foreach ($shop_list as $shop) @php $sp_exits = 0; @endphp
                                                                        @foreach ($order_sp_request as $sp_request)
                                                                            @if ($sp_request->order_special_id == $item_lists->order_special_id && $shop->shop_code == $sp_request->shop_code)
                                                                                <td style="padding: 0px;" class="text-center">{{ $sp_request->number_of_item }}</td>
                                                                                @php $sum = $sum + $sp_request->number_of_item; $sp_exits ++; @endphp
                                                                            @endif
                                                                        @endforeach
                                                                            @if($sp_exits == 0)
                                                                                <td style="padding: 0px;" class="text-center">0</td>
                                                                            @endif
                                                                    @endforeach
                                                                @endif

                                                                <td style="padding: 0px;" class="text-center">{{ $sum }}</td>
                                                            </tr>
                                                        @endif
                                                    @endforeach

                                                @endforeach
                                                
                                            </tbody>
                                        </table>
                                    </div> 
<hr>
                                    <div class="">
                                        <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;"><h5>ใบ Order การตัดแต่งพิเศษ วันที่สั่ง : {{ $date_format }} วันที่ส่ง : {{ $number_of_pig[0]->date_transport }}</h5>
                                        </div>
                                        <table  class="tbl " width="99%" border="1" id="report_shop">
                                            <thead class="text-center ">
                                                <tr style="background-color:#7dbeff;height: 40px;" >
                                                    <th style="padding: 0px;">รหัสสินค้า</th>
                                                    <th style="padding: 0px;" colspan="2">รายการ</th>
                                                    @foreach ($shop_list as $shop)
                                                        <th style="padding: 0px; width:5%;">{{ $shop->marker }}</th>
                                                    @endforeach
                                                    <th style="padding: 0px;">รวม</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach ($collumn6_code as $item_code)
                                                    @php
                                                        $row_check = 0;
                                                    @endphp

                                                    @foreach ($item_list6 as $item_lists) @php $sum = 0; $exist_unit = 0;@endphp
                                                        @if ($item_code->item_code == $item_lists->item_code)
                                                            <tr style="height: 40px;" >
                                                                @if ($row_check == 0)
                                                                    <td style="padding: 0px;" class="text-center" rowspan="{{ $item_code->count_item }}">{{  $item_code->item_code }} </td>
                                                                    @php $row_check++;  @endphp
                                                                @endif
                                                                <td style="padding: 0px;height: 32px;" >{{ $item_lists->item_name_special }} </td>
                                                                <td style="padding: 0px;height: 32px;" >{{ $item_lists->taiyai_name }}</td>
                                                                
                                                                @foreach ($shop_list as $shop) @php $shop_code = $shop->shop_code; @endphp
                                                                    @foreach ($unit_data as $unit)
                                                                        @if ($unit->item_code2 == $item_lists->item_code2)
                                                                            <td style="padding: 0px;" class="text-center">{{ number_format($unit->$shop_code,0,'.','') }}</td>
                                                                            @php $sum = $sum + number_format($unit->$shop_code,0,'.',''); $exist_unit++; @endphp
                                                                        @endif
                                                                    @endforeach
                                                                @endforeach
                                                                

                                                                @if ($exist_unit == 0)
                                                                    @foreach ($shop_list as $shop) @php $sp_exits = 0; @endphp
                                                                        @foreach ($order_sp_request as $sp_request)
                                                                            @if ($sp_request->order_special_id == $item_lists->order_special_id && $shop->shop_code == $sp_request->shop_code)
                                                                                <td style="padding: 0px;" class="text-center">{{ $sp_request->number_of_item }}</td>
                                                                                @php $sum = $sum + $sp_request->number_of_item; $sp_exits ++; @endphp
                                                                            @endif
                                                                        @endforeach
                                                                            @if($sp_exits == 0)
                                                                                <td style="padding: 0px;" class="text-center">0</td>
                                                                            @endif
                                                                    @endforeach
                                                                @endif

                                                                <td style="padding: 0px;" class="text-center">{{ $sum }}</td>
                                                            </tr>
                                                        @endif
                                                    @endforeach

                                                @endforeach
                                                
                                            </tbody>
                                        </table>
                                    </div>                                        
                                   
                            </div>
 
                    </div>
                </div>
            </div>

@endsection

@section('script')
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
        var table = $('#report_shop_unique').DataTable({
            lengthMenu: [[50, -1], [50, "All"]],
            "scrollX": false,
            orderCellsTop: true,
            fixedHeader: true,
            rowReorder: true,
            // processing: true,
            // serverSide: true,
            "order": [],
        });
        table.on( 'order.dt search.dt', function () {
            table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();
</script>


{{-- daterange --}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script>
   
   $('#datepicker1').change(function(){
    var currentDate =$('#datepicker1').val();
    var futureMonth = moment(currentDate,'DD/MM/YYYY').add(1, 'days').format("DD/MM/YYYY");

        $('#datepicker2').val( moment(currentDate,'DD/MM/YYYY').add(1, 'days').format("DD/MM/YYYY") );
        $('#datepicker3').val( moment(currentDate,'DD/MM/YYYY').add(2, 'days').format("DD/MM/YYYY") );
        $('#datepicker4').val( moment(currentDate,'DD/MM/YYYY').add(3, 'days').format("DD/MM/YYYY") );

   });

    $('#datepicker1').daterangepicker({
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-danger',
        cancelClass: 'btn-inverse',
        singleDatePicker: true,
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
    $('#datepicker5').val( $('#datepicker1').val() );

    </script>


@endsection


