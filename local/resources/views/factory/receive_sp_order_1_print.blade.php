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
  <style type="text/css">
    .input{
            height: 50%;
            background-color: aqua;
    }
    th{
        padding: 0px;
        font-size: 12px;
        text-align: center;
    }    
    td{
        padding: 0px;
        font-size: 13px;
        text-align: center;
    }
    .bodyzoom{
        zoom: 0.9;
    }
    @media print {
        p { page-break-after: always; }
    }
    .outer{
    overflow-y: auto;
    height:550px;
    }

    .outer table{
        width: 100%;
        table-layout: fixed; 
        border : 1px solid black;
        border-spacing: 1px;
    }

    .outer table th {
        top:0;
        border : 1px solid black;
        position: sticky;
    }

    @page { size: landscape; }
</style>

<link rel="stylesheet" href="{{ url('https://cdn.datatables.net/1.10.18/css/dataTables.semanticui.min.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/css/daterangepicker.css')}}">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.1.6/css/fixedHeader.dataTables.min.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" />

</head>

<body>

<div class="">
    <table  class="tbl table-hover" width="100%" border="1" id="report_shop">
        <thead class="text-center ">
        <tr style="background-color:#7dbeff" >
            <th style="padding: 0px; background-color:#7dbeff" width="2%" rowspan="3">ท่อน</th>
            <th style="padding: 0px; background-color:#7dbeff" width="3%" rowspan="3">รหัส</th>
            <th style="padding: 0px; background-color:#7dbeff" width="3%" rowspan="3">รายการ</th>
            <th style="padding: 0px; background-color:#7dbeff" width="3%" rowspan="3">Yiledชิ้นส่วน /ท่อน (กก.)</th>

            @foreach ($shop_list as $shop)
                <th style="padding: 0px; background-color:#7dbeff" colspan="0" width="{{ 50/count($shop_list) }}%;" >{{ $shop->shop_description }} </th>
            @endforeach

            <th style="padding: 0px; background-color:#7dbeff" width="5%" rowspan="3">น้ำหนักรวม (กก.)</th>
            <th style="padding: 0px; background-color:#7dbeff" width="5%" rowspan="3">Yiled/ตัว (กก.)</th>
            <th style="padding: 0px; background-color:#7dbeff" width="5%" rowspan="3">Yiled ทั้งหมด (กก.)</th>
            <th style="padding: 0px; background-color:#7dbeff" width="5%" rowspan="3">น้ำหนักรวมคงเหลือ (กก.)</th>
        </tr>

        </thead>
        <tbody>
            @php
                $group_list = 0;
            @endphp
            
            @foreach ($report_order as $key => $list_item)
            <tr >
                @if ( $group_list != $list_item->group)
                    @foreach ($count_group as $count_groups)
                        @if ($list_item->group == $count_groups->group)
                            <tr style="background-color:#edfd80;">
                                <td colspan="4" rowspan="2">{{ $count_groups->group_name }}</td>
                                @foreach ($shop_list as $shop)
                                    <td colspan="0"> {{ $shop->marker }} </td>
                                @endforeach
                                <td colspan="0">รวม</td>
                                <td colspan="3"></td>
                            </tr>
                            <tr style="background-color:#edfd80;">
                                {{-- เช็คสาขาที่มีข้อมูลrequestมา --}}
                                @for ($i = 0; $i < count($shop_list); $i++)
                                    @php
                                        $check_exist_data[$i] = 0;
                                        $shops[$i] = $shop_list[$i]->shop_code;
                                    @endphp
                                @endfor
                                @php
                                    $sum_req_branch = 0;
                                @endphp
                            
                                @foreach ($order_sp_request as $sp_request)
                                    @if ($list_item->group == $sp_request->order_special_id)

                                        @foreach ($shop_list as $key => $shop)
                                            @if ($sp_request->shop_code == $shop->shop_code)
                                                @php
                                                    $check_exist_data[$key] = $sp_request->number_of_item;
                                                @endphp
                                                {{-- <th colspan="0">จำนวน <input type="text" style="width: 24px;" value="{{ $sp_request->number_of_item }}"/>{{ $sp_request->shop_code }}ท่อน</th>
                                            @else
                                                <th colspan="0">จำนวน <input type="text" style="width: 24px;" value="0"/>ท่อน</th> --}}
                                            @endif  
                                        @endforeach 

                                    @endif
                                @endforeach
                                @for ($i = 0; $i < count($shop_list); $i++)
                                    <td colspan="0"> จำนวน 
                                        {{-- <input type="text" class="form-control center" style="width: 20px;padding: 0px;border-width: 0px;height: 20px;" readonly value="{{ $check_exist_data[$i] }}" /> --}}
                                        <b style="font-size:13px;">{{ $check_exist_data[$i] }}</b>
                                        {{ $count_groups->unit }}</td>
                                    @php
                                        $sum_req_branch =  $sum_req_branch + $check_exist_data[$i];
                                    @endphp
                                @endfor
                                <td colspan="0">{{ $sum_req_branch }}</td>
                                <td colspan="3"></td>
                            </tr>
                            <td style="padding: 0px;" class="text-center" rowspan="{{ $count_groups->count_group }}">{{ $list_item->group }}</td>
                        @endif
                    @endforeach
                    @php
                        $group_list = $list_item->group;
                    @endphp 
                @endif
                <td style="padding: 0px; height: 20px;">{{ $list_item->item_code }}</td>
                <td style="padding: 0px;" >{{ $list_item->item_name }}</td>
                <td style="padding: 0px;" >{{ $list_item->base_yeild }}</td>
                
                @for ($i = 0; $i < count($shop_list); $i++)
                    @php
                        $check_exist_data2[$i] = 0;
                        $shops2[$i] = $shop_list[$i]->shop_code;
                    @endphp
                @endfor
                @php
                    $sum_req_branch2 = 0.0;
                @endphp

                {{-- เก็บค่าน้ำหนักyeilld*จำนวนที่ร้านสั่ง --}}
                @foreach ($order_sp_request as $sp_request)
                @if ($list_item->group == $sp_request->order_special_id)

                    @foreach ($shop_list as $key => $shop)
                        @if ($sp_request->shop_code == $shop->shop_code)
                            @php
                            $check_exist_data2[$key] = floatval($sp_request->number_of_item);
                            @endphp
                        @endif
                    @endforeach

                @endif
                @endforeach 

                @for ($i = 0; $i < count($shop_list); $i++)
                    <td style="padding: 0px;" >{{ floatval($check_exist_data2[$i])*floatval($list_item->base_yeild) }}</td>
                    @php
                        $sum_req_branch2 =  $sum_req_branch2 + floatval($check_exist_data2[$i])*floatval($list_item->base_yeild);
                    @endphp
                @endfor

                <td style="padding: 0px;">{{ $sum_req_branch2  }}</td>
            @if ($list_item->yeild_per_one != 0 )

                <td style="padding: 0px;">{{ number_format( $list_item->yeild_per_one , 2, '.', '') }}</td>
                <td style="padding: 0px;">{{ number_format( $list_item->yeild_per_one*floatval($request_detail[0]->sum_number_of_pig) , 2, '.', '') }}</td>
                @foreach ($final_weight as $final_weights)
                    @if ($list_item->item_code2 == $final_weights->item_code2)
                        <td style="padding: 0px;  background-color:#80ff80; ">

                            <input type="text" name="weight_total[]" value="{{ number_format( ( $list_item->yeild_per_one*floatval($request_detail[0]->sum_number_of_pig) ) - 
                                ( $final_weights->sum_number_of_item)  , 3, '.', '')}}" hidden/>
                            <input type="text" name="item_code[]" value="{{ $list_item->item_code }}" hidden/>
                            <input type="text" name="item_code2[]" value="{{ $list_item->item_code2 }}" hidden/>
                            <input type="text" name="item_name[]" value="{{ $list_item->item_name }}" hidden/>

                            {{ number_format( 
                                ( $list_item->yeild_per_one*floatval($request_detail[0]->sum_number_of_pig) ) - 
                            ( $final_weights->sum_number_of_item )  , 3, '.', '')}}
                        </td>
                    @endif
                @endforeach

            @else
                <td style="padding: 0px; background-color:#464646;" ></td>   
                <td style="padding: 0px; background-color:#464646;"></td>
                <td style="padding: 0px; background-color:#464646;"></td>
            @endif
            </tr>
            @endforeach
    

        </tbody>
    </table>
</div>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
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
        $('#datepicker5').val( moment(currentDate,'DD/MM/YYYY').add(4, 'days').format("DD/MM/YYYY") );

    });

    $('#datepicker1').daterangepicker({
        startDate: moment('{{ $date_format }}','DD/MM/YYYY'),
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

</script>
<script>
    window.onload = function () {
        window.print();
    }
</script>
</body>
</html>
