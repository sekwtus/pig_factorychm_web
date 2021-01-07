@extends('layouts.master')
@section('style')

<link rel="stylesheet" href="{{ url('https://cdn.datatables.net/1.10.18/css/dataTables.semanticui.min.css') }}" type="text/css" />
{{-- <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" /> --}}
<link rel="stylesheet" href="{{ asset('assets/css/daterangepicker.css')}}">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" />

@endsection

@section('main')

<div class="card bg-light">
    <div class="card-body"> 
        <table id="tbl-1" class="tbl " width="100%" border="1">
            <thead>
                <tr class=" text-center bg-secondary"  style="background-color:#93c9ff; height:46px;" >
                    <th width="60%" style=" padding: 0px;" colspan="6">รายงานเชือด order : {{ $order_rr_show }}</th>
                </tr>
                
                <tr style="background-color:#ffff93; height:32px;">
                    <td class="text-center" style="padding: 0px; "colspan="6" ><b> น้ำหนักก่อนเชือด [01,02] : {{ $order_rr_show }}</b></td>
                </tr>
                <tr style="background-color:#ffff93; height:32px;">
                    <th class="text-center" style="padding: 0px;">รหัส order</th>
                    <th class="text-center" style="padding: 0px;">ลูกค้า/สาขา</th>
                    <th class="text-center" style="padding: 0px;">น้ำหนัก (กก.)</th>
                    <th class="text-center" style="padding: 0px;">จำนวน (ตัว)</th>
                    <th class="text-center" style="padding: 0px;">เฉลี่ย (กก./ตัว)</th>
                    <th class="text-center" style="padding: 0px;">หมายเหตุ</th>
                </tr>
            </thead>
            <tbody>

                @php
                   $recieve_weight = 0; 
                   $sum_unit_r = 0;  
                   @endphp
                {{-- r --}}
                @foreach ($r_data_list as $r_list)
                <tr style="background-color:#ffffe6;">
                    <td class="text-center" style="padding: 0px;">
                        <a target="blank_" href="../summary_weighing_receive/ {{ $r_list->lot_number }}"> {{ $r_list->lot_number }}</a>
                        </td>
                    <td class="text-center" style="padding: 0px;">{{ $r_list->id_user_customer }}</td>
                    <td class="text-center" style="padding: 0px;">{{ $r_list->sum_weight }}</td>
                    <td class="text-center" style="padding: 0px;">{{ $r_list->sum_unit }}</td>
                    <td class="text-center" style="padding: 0px;">{{ number_format($r_list->sum_weight/$r_list->sum_unit,2,'.','') }}</td>
                    @php
                        $recieve_weight = $recieve_weight + $r_list->sum_weight ;       
                        $sum_unit_r = $sum_unit_r + $r_list->sum_unit;
                    @endphp
                    <td class="text-center" style="padding: 0px;"></td>
                </tr>   
                @endforeach
                <tr style="background-color:#ffff93;">
                    <td class="text-center" style="padding: 0px;" ><b> รวม</b></td>
                    <td class="text-center" style="padding: 0px;" ></td>
                    <td class="text-center" style="padding: 0px;" >{{ $recieve_weight }}</td>
                    <td class="text-center" style="padding: 0px;" >{{ $sum_unit_r }}</td>
                    <td class="text-center" style="padding: 0px;" >{{ number_format($recieve_weight/$sum_unit_r,2,'.','') }}</td>
                    <td class="text-center" style="padding: 0px;"></td>
                </tr>


                {{-- of --}}
                <tr style="background-color:#8cffc6; height:32px;">
                    <td class="text-center" style="padding: 0px;"colspan="6" ><b> น้ำหนักเครื่องในหลังเชือด [05,06]: {{ $order_rr_show }}</b></td>
                    <td class="text-center" style="padding: 0px;" hidden></td>
                    <td class="text-center" style="padding: 0px;" hidden></td>
                    <td class="text-center" style="padding: 0px;" hidden></td>
                    <td class="text-center" style="padding: 0px;" hidden></td>
                </tr>
                <tr style="background-color:#8cffc6; height:32px;">
                    <th class="text-center" style="padding: 0px;">รหัส item</th>
                    <th class="text-center" style="padding: 0px;">ชื่อ item</th>
                    <th class="text-center" style="padding: 0px;">น้ำหนัก (กก.)</th>
                    <th class="text-center" style="padding: 0px;">จำนวน (ชิ้น)</th>
                    <th class="text-center" style="padding: 0px;">เฉลี่ย</th>
                    <th class="text-center" style="padding: 0px;">หมายเหตุ</th>
                </tr>

                @php   
                $sum_percent_of =0;
                $sum_weight_of = 0;
                $sum_unit_of = 0;  
                //---- สำหรัับ สรุปเครื่องใน 
                $sum_head =0;
                $sum_red =0;
                $sum_white =0;
                
                $p_head =0;
                $p_red =0;
                $p_white =0;
               
                @endphp

                @foreach ($offal_data_list as $offal_list)
                 @if(!empty($offal_list->sku_code))
                    <tr style="background-color:#d9ffec;">
                        <td class="text-center" style="padding: 0px;">{{ $offal_list->sku_code }}</td>
                        <td class="text-center" style="padding: 0px;">{{ $offal_list->item_name }}</td>
                        <td class="text-center" style="padding: 0px;">{{ $offal_list->sum_weight }}</td>
                        <td class="text-center" style="padding: 0px;">{{ $offal_list->sum_unit }}</td>
                        <td class="text-center" style="padding: 0px;">{{ number_format( ($offal_list->sum_weight*100)/$recieve_weight,2,'.','') }} %</td>
                        <td class="text-center" style="padding: 0px;">
                        @php
                        //    echo  $offal_list->sku_code;
                        // -- for sumaty of -------
                        if($offal_list->sku_code == '6002')
                            {
                                $sum_head += $offal_list->sum_weight;
                                $p_head += ($offal_list->sum_weight*100)/$recieve_weight;
                                echo '<p style="color:#1100ff;">หัว</p>';
                                
                            
                            }
                            if(($offal_list->sku_code=='1020')||($offal_list->sku_code=='5002')||($offal_list->sku_code=='6001')) 
                            {   
                                $sum_red += $offal_list->sum_weight; 
                                $p_red += ($offal_list->sum_weight*100)/$recieve_weight;
                                echo '<p style="color:red;">เครื่องในแดง</p>';
                                
                            }
                            if(
                                ($offal_list->sku_code=='1109')||
                                ($offal_list->sku_code=='5003')||($offal_list->sku_code=='5004')||
                                ($offal_list->sku_code=='5005')||($offal_list->sku_code=='5006')||($offal_list->sku_code=='5007')
                            ) 
                            {
                                $sum_white += $offal_list->sum_weight; 
                                $p_white += ($offal_list->sum_weight*100)/$recieve_weight;
                                echo '<p style="color:#5900ff;">เครื่องในขาว</p>';
                                
                            } 
                            if(
                            
                                ($offal_list->sku_code=='7001')||($offal_list->sku_code=='7002')||
                                ($offal_list->sku_code=='7009')||($offal_list->sku_code=='7010')||($offal_list->sku_code=='7013')||
                                ($offal_list->sku_code=='7017')|| ($offal_list->sku_code=='7019')
                            ) 
                            {
                                
                                echo '<p style="color:#140a27;">ของเสีย</p>';
                                
                            } 
                            if(
                            
                                ($offal_list->sku_code=='-')
                            ) 
                            {
                                
                                echo '<p style="color:#140a27;">ไม่ทราบรหัส</p>';
                                
                            } 
                    
                            $sum_percent_of = $sum_percent_of + number_format( ($offal_list->sum_weight*100)/$recieve_weight,2,'.',''); 
                            $sum_weight_of = $sum_weight_of + $offal_list->sum_weight;
                            $sum_unit_of = $sum_unit_of + $offal_list->sum_unit;
                            

                        @endphp
                        </td>
                    </tr>
                 @endif
                @endforeach

                <tr style="background-color:#8cffc6;">
                    <td class="text-center" style="padding: 0px;" ><b> รวม</b></td>
                    <td class="text-center" style="padding: 0px;" ></td>
                    <td class="text-center" style="padding: 0px;" >{{ $sum_weight_of }}</td>
                    <td class="text-center" style="padding: 0px;" >{{ $sum_unit_of }}</td>
                    <td class="text-center" style="padding: 0px;" >{{ $sum_percent_of }} %</td>
                    <td class="text-center" style="padding: 0px;">-</td>
                </tr>



                {{--sum of --}}
                <tr style="background-color:#f0f33d; height:32px;">
                    <td class="text-center" style="padding: 0px;"colspan="6" ><b> สรุปแยกน้ำหนักเครื่องใน,หัว [05,06]: {{ $order_rr_show }}</b></td>
                    <td class="text-center" style="padding: 0px;" hidden></td>
                    <td class="text-center" style="padding: 0px;" hidden></td>
                    <td class="text-center" style="padding: 0px;" hidden></td>
                    <td class="text-center" style="padding: 0px;" hidden></td>
                </tr>
                <tr style="background-color:#f2fcc5; height:32px;">
                    <th class="text-center" style="padding: 0px;">รหัส item</th>
                    <th class="text-center" style="padding: 0px;">ชื่อ item</th>
                    <th class="text-center" style="padding: 0px;">น้ำหนัก (กก.)</th>
                    <th class="text-center" style="padding: 0px;">จำนวน (ชิ้น)</th>
                    <th class="text-center" style="padding: 0px;">เฉลี่ย</th>
                    <th class="text-center" style="padding: 0px;">นน.เฉลี่ย/ตัว</th>
                </tr>


                {{-- หัว --}}
                <tr style="background-color:#f2fcc5;">
                    <td class="text-center" style="padding: 0px;"> - </td>
                    <td class="text-center" style="padding: 0px;">หัว</td>
                    <td class="text-center" style="padding: 0px;">{{ $sum_head }}</td>
                    <td class="text-center" style="padding: 0px;"></td>
                    <td class="text-center" style="padding: 0px;">{{ number_format($p_head,2,'.',',') }} %</td>
                    <td class="text-center" style="padding: 0px;">{{  number_format($sum_head/$sum_unit_r,2,'.',',')}}</td>
                </tr>
                {{-- เคร่ื่องในแดง --}}
                <tr style="background-color:#f2fcc5;">
                    <td class="text-center" style="padding: 0px;"> - </td>
                    <td class="text-center" style="padding: 0px;">เครื่องในแดง</td>
                    <td class="text-center" style="padding: 0px;">{{ $sum_red }}</td>
                    <td class="text-center" style="padding: 0px;"></td>
                    <td class="text-center" style="padding: 0px;">{{ number_format($p_red,2,'.',',') }} %</td>
                    <td class="text-center" style="padding: 0px;">{{ number_format($sum_red/$sum_unit_r,2,'.',',') }}</td>
                </tr>
                {{-- เคร่ื่องในขาว --}}
                <tr style="background-color:#f2fcc5;">
                    <td class="text-center" style="padding: 0px;"> - </td>
                    <td class="text-center" style="padding: 0px;">เครื่องในขาว</td>
                    <td class="text-center" style="padding: 0px;">{{ $sum_white }}</td>
                    <td class="text-center" style="padding: 0px;"></td>
                    <td class="text-center" style="padding: 0px;">{{ number_format($p_white,2,'.',',') }} %</td>
                    <td class="text-center" style="padding: 0px;">{{ number_format($sum_white/$sum_unit_r,2,'.',',')}}</td>
                </tr>                                

                <tr style="background-color:#f2fcc5;">
                    <td class="text-center" style="padding: 0px;" ><b> รวม</b></td>
                    <td class="text-center" style="padding: 0px;" ></td>
                    <td class="text-center" style="padding: 0px;" >{{ $sum_head+$sum_red+$sum_white}}</td>
                    <td class="text-center" style="padding: 0px;" ></td>
                    <td class="text-center" style="padding: 0px;" >{{ number_format($p_head+$p_red+$p_white,2,'.',',') }} %</td>
                    <td class="text-center" style="padding: 0px;"> {{ number_format((($sum_head+$sum_red+$sum_white)/$sum_unit_r),2,'.',',')}} </td>
                </tr>
                

                {{-- ov --}}
                <tr style="background-color:#ffcaff; height:32px;">
                    <td class="text-center" style="padding: 0px;"colspan="6" ><b>น้ำหนักรับเข้า overnight [04] : {{ $order_rr_show }}</b></td>
                    <td class="text-center" style="padding: 0px;" hidden></td>
                    <td class="text-center" style="padding: 0px;" hidden></td>
                    <td class="text-center" style="padding: 0px;" hidden></td>
                    <td class="text-center" style="padding: 0px;" hidden></td>
                </tr>
                <tr style="background-color:#ffcaff; height:32px;">
                    <th class="text-center" style="padding: 0px;">รหัส item</th>
                    <th class="text-center" style="padding: 0px;">ชื่อ item</th>
                    <th class="text-center" style="padding: 0px;">น้ำหนัก (กก.)</th>
                    <th class="text-center" style="padding: 0px;">จำนวน (ชิ้น)</th>
                    <th class="text-center" style="padding: 0px;">เฉลี่ย</th>
                    <th class="text-center" style="padding: 0px;">นน.เฉลี่ย/ตัว</th>
                </tr>

                @php    
                        $sum_percent =0;
                        $sum_weight = 0;
                        $sum_unit = 0;  
                @endphp
                @foreach ($ov_data_list as $ov_list)
                <tr style="background-color:#fff2ff;">
                    <td class="text-center" style="padding: 0px;">{{ $ov_list->sku_code }}</td>
                    <td class="text-center" style="padding: 0px;">{{ $ov_list->item_name }}</td>
                    <td class="text-center" style="padding: 0px;">{{ $ov_list->sum_weight }}</td>
                    <td class="text-center" style="padding: 0px;">{{ $ov_list->sum_unit }}</td>
                    <td class="text-center" style="padding: 0px;">{{ number_format( ($ov_list->sum_weight*100)/$recieve_weight,2,'.','') }} %</td>
                    @php 
                        $sum_percent = $sum_percent +  (($ov_list->sum_weight*100)/$recieve_weight);
                        $sum_weight = $sum_weight + $ov_list->sum_weight;
                        $sum_unit = $sum_unit + $ov_list->sum_unit;
                    @endphp
                    <th class="text-center" style="padding: 0px;">{{ number_format((( $ov_list->sum_weight)/$sum_unit_r),2,'.',',')}}</th>
                </tr>
                @endforeach
                <tr style="background-color:#ffcaff;">
                    <td class="text-center" style="padding: 0px;" ><b> รวม</b></td>
                    <td class="text-center" style="padding: 0px;" ></td>
                    <td class="text-center" style="padding: 0px;" >{{ $sum_weight }}</td>
                    <td class="text-center" style="padding: 0px;" >{{ $sum_unit }}</td>
                    <td class="text-center" style="padding: 0px;" >{{ number_format($sum_percent,2,'.',',') }} %</td>
                    <td class="text-center" style="padding: 0px;" >{{ number_format((( $ov_list->sum_weight)/$sum_unit_r),2,'.',',')}}</td>
                </tr>

                <tr style="background-color:#ff8c8c;">
                    <th class="text-center" style="padding: 0px;"></th>
                    <th class="text-center" style="padding: 0px;">รวม</th>
                    <th class="text-center" style="padding: 0px;">{{ $sum_weight + $sum_weight_of    }}</th>
                    <th class="text-center" style="padding: 0px;"></th>
                    <th class="text-center" style="padding: 0px;">{{number_format(($sum_percent +  $sum_percent_of),2,'.',',') }} %</th>
                    <th class="text-center" style="padding: 0px;"></th>
                </tr>


            </tbody>
        </table>
    </div>
</div>

@endsection
@section('script')
<script src="{{ asset('https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js') }}"></script>
<script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js') }}"></script>
<script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js') }}"></script>

<script>
    function deleteRecord(order_number){
        if(confirm('ต้องการลบ : '+order_number+' ?')){
            $.ajax({
                type: 'GET',
                url: '{{ url('delete_importCompare') }}',
                data: {order_number:order_number},
                success: function (msg) {
                    alert(msg);
                    location.reload();
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("Status: " + textStatus); alert("Error: " + errorThrown);
                }
            });
        }
    }
</script>
<script>
        var table = $('#tbl-1s').DataTable({
            lengthMenu: [[-1], ["All"]],
            "scrollX": false,
            orderCellsTop: true,
            fixedHeader: true,
            // rowReorder: true,
            dom: 'Brt',
            // "order": [[ 1, "desc" ]],
            buttons: [
                'excel',
                //  'pdf', 'print'
            ],
            // processing: true,
            // serverSide: true,
        });
        // table.on( 'order.dt search.dt', function () {
        //     table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
        //         cell.innerHTML = i+1;
        //     } );
        // } ).draw();
</script>

@endsection