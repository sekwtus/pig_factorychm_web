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
    }    
    td{
        padding: 0px;
        font-size: 14px;
    }
    .bodyzoom{
        zoom: 0.9;
    }
    @media print {
        p { page-break-after: always; }
    }
</style>

<link rel="stylesheet" href="{{ url('https://cdn.datatables.net/1.10.18/css/dataTables.semanticui.min.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/css/daterangepicker.css')}}">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" />



</head>

<body>

    @php $xx = 0; @endphp
                                
    @foreach ($shop_list as $key => $shop)
        @php $shop_code_1 = $shop->shop_code;$xx++;
            $arrkey = array(1011,1034,1051,1050,1100,1102,1104,1108,1109,1075);
        @endphp
        <p>
            {{-- if9  --}}
            <div class="">
                <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;"><h5>ใบแกะ</h5>
                    <table  class="tbl " width="100%" border="1" id="report_shop">
                        <thead class="text-center ">
                        <tr>
                            <th style="padding: 0px; height:26px; background-color:#ffffc4;color:black;" colspan="2">วันที่สั่ง {{ $date_format }}</th>
                            <th style="padding: 0px; height:26px; background-color:#ffffc4;color:black;" colspan="4">สาขา {{ $shop->shop_name }}</th>
                            <th style="padding: 0px; height:26px; background-color:#ffffc4;color:black;" colspan="2">วันที่ส่ง  {{ $sp_order1[0]->date_transport }}</th>
                        </tr>
                        </thead>
                    </table>
                </div>
                
                <div class="row">

                    <div class="col-6">
                        <table  class="tbl " width="99%" border="1" id="report_shop">
                            <thead class="text-center ">
                                <tr style="background-color:#7dbeff;height: 40px;" >
                                    <th style="padding: 0px;">รหัสสินค้า</th>
                                    <th style="padding: 0px;">รายการ</th>
                                    <th style="padding: 0px;">จำนวนชิ้น</th>
                                    <th style="padding: 0px;">จำนวนถุง</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($collumn1_code as $item_code)
                                    @php
                                        $row_check = 0; 
                                    @endphp

                                    @foreach ($item_list1 as $item_lists1)
                                    @php 
                                        $null_check = 0; 
                                    @endphp
                                        @if ($item_code->item_code == $item_lists1->item_code)
                                            <tr>
                                                @if ($row_check == 0)
                                                    <td style="padding: 0px;" class="text-center" rowspan="{{ $item_code->count_item }}">{{  $item_code->item_code }}</td>
                                                    @php $row_check++; @endphp
                                                @endif
                                                <td style="padding: 0px;height: 32px;" >{{ $item_lists1->item_name_special }} </td>

                                                
                                                @foreach ($sp_order1 as $order1) 
                                                    @if ($order1->shop_code == $shop->shop_code && $order1->order_special_id == $item_lists1->order_special_id )
                                                        <td style="padding: 0px;" class="text-center">{{  number_format($order1->number_of_item,0,'.','' ) }}</td>
                                                        <td style="padding: 0px;" class="text-center">{{ number_format($order1->number_of_item/$item_lists1->number_unit,1,'.','' )  }}</td>
                                                        @php
                                                            $null_check++; 
                                                        @endphp
                                                    @endif
                                                @endforeach

                                                @foreach ($final_weight as $final_weights)  @php $check = 0;  @endphp
                                                    @if ($final_weights->item_code2 == $item_lists1->item_code2)
                                                    
                                                        @if ($item_lists1->number_unit != 0) 
                                                            <td style="padding: 0px;" class="text-center">{{ number_format($final_weights->$shop_code_1,0,'.','' ) }}</td>
                                                            <td style="padding: 0px;" class="text-center">{{ number_format($final_weights->$shop_code_1/$item_lists1->number_unit,1,'.','') }}</td>
                                                            @php $check++; $null_check++; @endphp
                                                        @endif

                                                    @endif
                                                @endforeach
                                                
                                                @if ($null_check == 0 &&  in_array($item_lists1->item_code, $arrkey) )
                                                    <td style="padding: 0px; background-color:#909090;" class="text-center"></td>
                                                    <td style="padding: 0px; background-color:#909090;" class="text-center"></td>
                                                @elseif($null_check == 0)
                                                    <td style="padding: 0px;" class="text-center">0</td>
                                                    <td style="padding: 0px;" class="text-center">0.0</td>
                                                @endif
                                                    
                                            </tr>
                                        @endif
                                    @endforeach

                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="col-6">
                        <table  class="tbl " width="99%" border="1" id="report_shop">
                            <thead class="text-center ">
                                <tr style="background-color:#7dbeff;height: 40px;" >
                                    <th style="padding: 0px;">รหัสสินค้า</th>
                                    <th style="padding: 0px;">รายการ</th>
                                    <th style="padding: 0px;">จำนวนชิ้น</th>
                                    <th style="padding: 0px;">จำนวนถุง</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($collumn1_code as $item_code)
                                    @php
                                        $row_check = 0;
                                    @endphp

                                    @foreach ($item_list2 as $item_lists2)
                                    @php 
                                        $null_check2 = 0; 
                                    @endphp
                                        @if ($item_code->item_code == $item_lists2->item_code)
                                            <tr>
                                                @if ($row_check == 0)
                                                    <td style="padding: 0px;" class="text-center" rowspan="{{ $item_code->count_item }}">{{  $item_code->item_code }}</td>
                                                    @php $row_check++; @endphp
                                                @endif
                                                <td style="padding: 0px;;height: 32px;" >{{ $item_lists2->item_name_special }}</td>
                                                
                                                @foreach ($sp_order1 as $order2)
                                                    @if ($order2->shop_code == $shop->shop_code && $order2->order_special_id == $item_lists2->order_special_id)
                                                        <td style="padding: 0px;" class="text-center">{{ number_format($order2->number_of_item,0,'.','' )*$item_lists2->number_item_in_package }}</td> {{-- *$item_lists2->number_item_in_package debug จำนวนหมูที่orderเป็นถุงแล้วต้องมาแยกว่าในถุงมีกี่ชิ้น จากปกติ orderเป็นชิน --}}
                                                        <td style="padding: 0px;" class="text-center">{{ number_format(($item_lists2->number_unit == 0 ? 0 : ($order2->number_of_item*$item_lists2->number_item_in_package)/$item_lists2->number_unit),1,'.','' ) }}</td>
                                                        @php 
                                                            $null_check2++; 
                                                        @endphp
                                                    @endif
                                                @endforeach

                                                @foreach ($final_weight as $final_weights)  @php $check = 0;  @endphp
                                                    @if ($final_weights->item_code2 == $item_lists2->item_code2)
                                                    
                                                        @if ($item_lists2->number_unit != 0) 
                                                            <td style="padding: 0px;" class="text-center">{{ number_format($final_weights->$shop_code_1,0,'.','' ) }}</td>
                                                            <td style="padding: 0px;" class="text-center">{{ number_format($final_weights->$shop_code_1/$item_lists2->number_unit,1,'.','') }}</td>
                                                            @php $check++; $null_check2++; @endphp
                                                        @endif
                                                    @endif
                                                @endforeach

                                                @if ($null_check2 == 0  &&  in_array($item_lists2->item_code, $arrkey))
                                                    <td style="padding: 0px; background-color:#909090;" class="text-center"></td>
                                                    <td style="padding: 0px; background-color:#909090;" class="text-center"></td>
                                                @elseif($null_check2 == 0)
                                                    <td style="padding: 0px;" class="text-center">0</td>
                                                    <td style="padding: 0px;" class="text-center">0.0</td>
                                                @endif

                                            </tr>
                                        @endif
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </p>
    @endforeach

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
    window.onload = function () {
        window.print();
    }
</script>

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

</body>
</html>

