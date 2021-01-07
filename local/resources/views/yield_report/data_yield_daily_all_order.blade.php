@extends('layouts.master')
@section('style')

<link rel="stylesheet" href="{{ url('https://cdn.datatables.net/1.10.18/css/dataTables.semanticui.min.css') }}" type="text/css" />
{{-- <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" /> --}}
<link rel="stylesheet" href="{{ asset('assets/css/daterangepicker.css')}}">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" />

<style>
    body{
        zoom:0.8;
    }
</style>
@endsection

@section('main')
<div class="row">
    <div class="col-md-5 col-lg-6 grid-margin stretch-card">
        <div class="card">
        <div class="card-header header-sm d-flex justify-content-between align-items-center">
            <h2 class="text-center">น้ำหนักเชือด</h2>
        </div>
        <div class="card-body">
            <div class="table-responsive">
            {{-- <table class="table tb1"> --}}
                <table id="tbl-1" class="tb1 " width="100%" border="1">
                    <thead>
                        <tr class=" text-center bg-secondary"  style="background-color:#93c9ff; height:46px;" >
                            <th width="60%" style=" padding: 0px;" colspan="6">รายงานเชือด order : <a target="blank_" href="../summary_weighing_receive/{{ $order_rr_show1 }}">{{ $order_rr_show1 }}</a></th>
                        </tr>
                        
                        <tr style="background-color:#ffff93; height:32px;">
                            <td class="text-center" style="padding: 0px; "colspan="6" ><b> น้ำหนักก่อนเชือด [01,02] : {{ $order_rr_show1 }}</b></td>
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
                        @foreach ($r_data_list1 as $r_list)
                        <tr style="background-color:#ffffe6;">
                            <td class="text-center" style="padding: 0px;">{{ $r_list->lot_number }}</td>
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
        
                        @foreach ($offal_data_list1 as $offal_list)
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
                            <td class="text-center" style="padding: 0px;"colspan="6" ><b> สรุปแยกน้ำหนักเครื่องใน,หัว [05,06]</b></td>
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
                            <td class="text-center" style="padding: 0px;"colspan="6" ><b>น้ำหนักรับเข้า overnight [04] :</b></td>
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
                        @foreach ($ov_data_list1 as $ov_list)
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
        </div>
    </div>

    <div class="col-md-5 col-lg-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-header header-sm d-flex justify-content-between align-items-center">
                <h2 class="text-center" >น้ำหนักตัดแต่ง</h2>
            </div>
        <div class="card-body"> 
            <table id="tbl-1" class="tbl " width="100%" border="1">
                <thead>
                    <tr class=" text-center bg-secondary" style="background-color:#93c9ff; height:45px;" >
                        <th width="100%" style=" padding: 0px;" colspan="7">รายงานน้ำหนักการผลิตวันที่ : {{ $date_format }} </th>
                    </tr>
                    <tr class="text-center" style="background-color:#ffffc4;height:32px;" >
                        <th width="48%" style=" padding: 0px;" colspan="7"> น้ำหนักหมูรับเข้ายกมา</th>
                    </tr>
                    <tr style="background-color:#ffffc4;height:32px;" hidden >
                        <th class="text-center" style="padding: 0px;" colspan="2">order</th>
                        <th class="text-center" style="padding: 0px;">จำนวน (ตัว)</th>
                        <th class="text-center" style="padding: 0px;">น้ำหนัก (กก.)</th>
                        <th class="text-center" style="padding: 0px;">เฉลี่ย (กก./ตัว)</th>
                    </tr>
                </thead>



            <tbody>
                {{-- R --}}
                    @php
                        // ! variable !
                        $sum_r_weight=0;
                        $sum_r_unit=0;
                        $avg_r_weight=0;
                    @endphp
                    <tr style="background-color:#ffffc4;">
                        <td class="text-center" style="padding: 0px;" colspan="4"><b> order</b></td>
                        <td class="text-center" style="padding: 0px;"><b>จำนวน (ตัว)</b></td>
                        <td class="text-center" style="padding: 0px;"><b>น้ำหนัก (กก.)</b></td>
                        <td class="text-center" style="padding: 0px;"><b>เฉลี่ย (กก./ตัว)</b></td>
                        <td hidden>1</td>
                    </tr>
                    @foreach ($r_data_list as $r_list)
                        <tr style="background-color:#fffff4;">
                            <td class="text-center" style="padding: 0px;" colspan="4"><a target="blank_" href="../summary_weighing_receive/{{ $r_list->lot_number }}">{{ $r_list->lot_number }}</a></td>
                            <td class="text-center" style="padding: 0px;">{{ $r_list->sum_unit }}</td>
                            <td class="text-center" style="padding: 0px;">{{ $r_list->sum_weight }}</td>
                            <td class="text-center" style="padding: 0px;">{{ number_format($r_list->sum_weight/$r_list->sum_unit,2,'.','') }}</td>
                                @php
                                    $sum_r_weight =  $sum_r_weight +  $r_list->sum_weight ;
                                    $sum_r_unit   =  $sum_r_unit +    $r_list->sum_unit   ;
                                @endphp
                            <td hidden></td>
                        </tr>
                    @endforeach
                    <tr style="background-color:#ffffc4;">
                        <td class="text-center" style="padding: 0px;" colspan="4"><b>สรุปรวมยกมา</b></td>
                        <td class="text-center" style="padding: 0px;"> {{ $sum_r_unit }}</td>
                        <td class="text-center" style="padding: 0px;">{{ $sum_r_weight }}</td>
                        <td class="text-center" style="padding: 0px;">
                            <span style="color: red;"><b>{{ number_format($sum_r_weight/$sum_r_unit,2,'.','') }} </b></span>
                        </td>
                        <td hidden></td>
                        @php
                            $avg_r_weight = number_format($sum_r_weight/$sum_r_unit,2,'.','');
                        @endphp
                    </tr>
                {{-- end R --}}

                {{-- ov --}}
                    @php
                        // ! variable !
                        $sum_ov_weight=0;
                        $sum_ov_unit=0;
                        $num_for_yeild=0;
                    @endphp
                    <tr class="text-center" style="background-color:#e0ffc4;height:32px;" >
                        <td width="48%" style=" padding: 0px;" colspan="7"><b>ซากหลังแช่</b></td>
                        <td width="48%" style=" padding: 0px;" hidden ></td>
                        <td width="48%" style=" padding: 0px;" hidden ></td>
                        <td width="48%" style=" padding: 0px;" hidden ></td>
                        <td width="48%" style=" padding: 0px;" hidden ></td>
                    </tr>
                    <tr style="background-color:#e0ffc4;height:32px;">
                        <td class="text-center" style="padding: 0px;" colspan="4" ><b>order</b></td>
                        <td class="text-center" style="padding: 0px;"><b>จำนวน(ตัว)</b></td>
                        <td class="text-center" style="padding: 0px;"><b>น้ำหนัก</b></td>
                        <td class="text-center" style="padding: 0px;"><b>เฉลี่ย</b></td>
                        <td hidden></td>
                    </tr>
                    @foreach ($after_ov as $af_ov)  
                        <tr style="background-color:#eeffdf;height:32px;">
                            <td class="text-center" style="padding: 0px;" colspan="4"  
                                title="{{ $af_ov->group_order_ref }} &#xA; {{ $af_ov->group_order_number }}  &#xA; {{ $af_ov->group_total_pig }}">
                                <a target="blank_" href="../debug/{{ $af_ov->lot_number }}">{{ $af_ov->lot_number }}</a>
                            </td>
                            <td class="text-center" style="padding: 0px;" title="{{ $af_ov->group_total_pig }}">{{ $af_ov->sum_unit/2 }}</td>
                            <td class="text-center" style="padding: 0px;">{{ $af_ov->sum_weight }}</td>                       
                            <td class="text-center" style="padding: 0px;">{{ number_format($af_ov->sum_weight/($af_ov->sum_unit/2),2,'.','') }}</td>
                            <td hidden></td>
                            @php
                                $sum_ov_weight =  $sum_ov_weight +  $af_ov->sum_weight ;
                                $sum_ov_unit   =  $sum_ov_unit + ($af_ov->sum_unit/2)   ;
                            @endphp
                        </tr>
                    @endforeach

                    <tr style="background-color:#e0ffc4;">
                        <td class="text-center" style="padding: 0px;" colspan="4"><b>สรุปตัดแต่งทั้งหมด</b></td>
                        <td class="text-center" style="padding: 0px;">
                            <span style="color: red;"><b> {{ $sum_ov_unit }} </b></span>
                        </td>
                        <td class="text-center" style="padding: 0px;">{{ $sum_ov_weight }}</td>
                        <td class="text-center" style="padding: 0px;">{{ number_format($sum_ov_weight/$sum_ov_unit,2,'.','') }} </td>
                        <td hidden></td>

                        @php
                            $num_for_yeild = number_format($sum_ov_unit*$avg_r_weight,2,'.','');
                        @endphp

                    </tr>
                {{-- end ov --}}

                {{-- --  start หาค่าเฉลี่ย นำหนักหมู -- --}}
                <tr style="background-color:hsl(120, 93%, 49%);">
                    <td class="text-center" style="padding: 0px;" colspan="4"><b>1. สรุปการคิดน้ำหนักเฉลี่ยเพื่อการตัดแต่งทั้งหมด</b></td>
                    <td class="text-center" style="padding: 0px;">
                        <span style="color: rgb(17, 0, 255);"><b> {{ $sum_ov_unit }} </b></span>
                        X
                        <span style="color: rgb(0, 47, 255);"><b> {{ number_format($sum_r_weight/$sum_r_unit,2,'.','') }} </b></span>
                        
                    </td>
                    <td class="text-center" style="padding: 0px;">{{ number_format( $sum_ov_unit * ($sum_r_weight/$sum_r_unit),2,'.','') }}</td>
                    <td class="text-center" style="padding: 0px;">{{ number_format(($sum_ov_unit * ($sum_r_weight/$sum_r_unit))/$sum_ov_unit,2,'.','') }} </td>
                    <td hidden></td>

                    @php
                        $num_for_yeild = number_format($sum_ov_unit*$avg_r_weight,2,'.','');
                    @endphp

                </tr>

                {{-- cutting /ov --}}
                        @php
                            // ! variable !
                            $sum_cl_weight=0;
                            $sum_cl_unit=0;
                        @endphp
                        <tr class="text-center" style="background-color:#fee2c5;height:32px;" >
                            <td width="48%" style=" padding: 0px;" colspan="7"><b>ชิ้นส่วนหลังแกะ</b></td>
                            <td width="48%" style=" padding: 0px;" hidden ></td>
                            <td width="48%" style=" padding: 0px;" hidden ></td>
                            <td width="48%" style=" padding: 0px;" hidden ></td>
                            <td width="48%" style=" padding: 0px;" hidden ></td>
                        </tr>
                        <!--
                        <tr class="text-center" style="background-color:#fee2c5;height:32px;" >
                            <td width="48%" style=" padding: 0px;" colspan="7">
                                <b>
                                    @php
                                    $order_ov_show_ = explode(",",$order_ov_show); 
                                    $order_cl_show_ = explode(",",$order_cl_show); 
                                    @endphp
                                    
                                    @foreach ( $order_ov_show_ as $value)
                                    <a target="blank_" href="../debug/{{  $value }}">{{  $value }}</a>
                                    @endforeach
                                    <br>
                                    @foreach ( $order_cl_show_ as $value)
                                    <a target="blank_" href="../debug/{{  $value }}">{{  $value }}</a> 
                                    @endforeach
                                
                                

                                </b>
                        </td>
                        </tr>
                    -->
                        <tr style="background-color:#fee2c5;height:32px;">
                            <td class="text-center" style="padding: 0px;"colspan="2"><b>รหัส Item</b></td>
                            <td class="text-center" style="padding: 0px;"colspan="2"><b>ชื่อ item</b></td>
                            <td class="text-center" style="padding: 0px;"><b>จำนวน(ชิ้น)</b></td>
                            <td class="text-center" style="padding: 0px;"><b>น้ำหนัก</b></td>
                            <td class="text-center" style="padding: 0px;"><b>%</b></td>
                        </tr>
                        @foreach ($ov_data_list as $af_cl)  
                            <tr style="background-color:#fff2e6;height:32px;">
                                <td class="text-center" style="padding: 0px;"colspan="2">{{ $af_cl->sku_code }}</td>
                                <td class="text-center" style="padding: 0px;"colspan="2">{{ $af_cl->item_name }}</td>
                                <td class="text-center" style="padding: 0px;">{{ $af_cl->sum_unit }}</td>
                                <td class="text-center" style="padding: 0px;">{{ $af_cl->sum_weight }}</td>                       
                                <td class="text-center" style="padding: 0px;">{{ number_format( ($af_cl->sum_weight/$num_for_yeild)*100,2,'.','') }} %</td>
                                @php
                                    $sum_cl_weight =  $sum_cl_weight +  $af_cl->sum_weight ;
                                    $sum_cl_unit   =  $sum_cl_unit + $af_cl->sum_unit ;
                                @endphp
                            </tr>
                        @endforeach
                        @foreach ($sp_data_list as $af_cl)  
                            <tr style="background-color:#fff2e6;height:32px;">
                                <td class="text-center" style="padding: 0px;"colspan="2">{{ $af_cl->sku_code }}</td>
                                <td class="text-center" style="padding: 0px;"colspan="2">{{ $af_cl->item_name }}</td>
                                <td class="text-center" style="padding: 0px;">{{ $af_cl->sum_unit }}</td>
                                <td class="text-center" style="padding: 0px;">{{ $af_cl->sum_weight }}</td>                       
                                <td class="text-center" style="padding: 0px;">{{ number_format( ($af_cl->sum_weight/$num_for_yeild)*100,2,'.','') }} %</td>
                                @php
                                    $sum_cl_weight =  $sum_cl_weight +  $af_cl->sum_weight ;
                                    $sum_cl_unit   =  $sum_cl_unit + $af_cl->sum_unit ;
                                @endphp
                            </tr>
                        @endforeach
        
                        <tr style="background-color:#fee2c5;">
                            <td class="text-center" style="padding: 0px;" colspan="4"><b>สรุปชิ้นส่วนทั้งหมด</b></td>
                            <td class="text-center" style="padding: 0px;">{{ $sum_cl_unit }}</td>
                            <td class="text-center" style="padding: 0px;">{{ $sum_cl_weight }}</td>
                            <td class="text-center" style="padding: 0px;">{{ number_format( ($sum_cl_weight/$num_for_yeild)*100,2,'.','') }} %</td>
                            <td hidden></td>
                        </tr>
                    {{-- end cutting /ov --}}

                {{-- of --}}
                    @php
                        // ! variable !
                        $sum_of_weight=0;
                        $sum_of_unit=0;
                    @endphp
                    <tr class="text-center" style="background-color:#c4cbff;height:32px;" >
                        <td width="48%" style=" padding: 0px;" colspan="7"><b>เครื่องในหลังแกะ</b></td>
                        <td width="48%" style=" padding: 0px;" hidden ></td>
                        <td width="48%" style=" padding: 0px;" hidden ></td>
                        <td width="48%" style=" padding: 0px;" hidden ></td>
                        <td width="48%" style=" padding: 0px;" hidden ></td>
                        <td width="48%" style=" padding: 0px;" hidden ></td>
                    </tr>
                    <!--
                    <tr class="text-center" style="background-color:#fee2c5;height:32px;" >
                        <td width="48%" style=" padding: 0px;" colspan="7">
                            <b>
                                @php
                                    $order_of_show_ = explode(",",$order_of_show); 
                                    
                                    @endphp
                                    
                                    @foreach ( $order_of_show_ as $value)
                                    <a target="blank_" href="../debug/{{  $value }}">{{  $value }}</a>
                                    @endforeach
                            
                            

                            </b>
                    </td>
                    </tr>
                -->
                    <tr style="background-color:#c4cbff;height:32px;">
                        <td class="text-center" style="padding: 0px;"><b>รหัส Item</b></td>
                        <td class="text-center" style="padding: 0px;"><b>ชื่อ item</b></td>
                        <td class="text-center" style="padding: 0px;"><b>จำนวน(ชิ้น)</b></td>
                        <td class="text-center" style="padding: 0px;"><b>น้ำหนัก</b></td>
                        <td class="text-center" style="padding: 0px;"><b>เฉลี่ยต่อตัว</b></td>
                        <td class="text-center" style="padding: 0px;"><b>น้ำหนักต่อ {{ $sum_ov_unit }} ตัว</b></td>
                        <td class="text-center" style="padding: 0px;"><b>%</b></td>
                    </tr>
                    @foreach ($offal_data_list as $af_of)  
                        <tr style="background-color:#dfe3ff;height:32px;">
                            <td class="text-center" style="padding: 0px;">{{ $af_of->sku_code }}</td>
                            <td class="text-center" style="padding: 0px;">{{ $af_of->item_name }}</td>
                            <td class="text-center" style="padding: 0px;">{{ $af_of->sum_unit }}</td>
                            <td class="text-center" style="padding: 0px;">{{ $af_of->sum_weight }}</td>                       
                            <td class="text-center" style="padding: 0px;">{{ number_format($af_of->sum_weight/$sum_r_unit,2,'.','') }}</td>                       
                            <td class="text-center" style="padding: 0px;">{{ number_format($af_of->sum_weight/$sum_r_unit*$sum_ov_unit,2,'.','') }}</td>                       
                            <td class="text-center" style="padding: 0px;">{{ number_format( ( ($af_of->sum_weight/$sum_r_unit*$sum_ov_unit) / $num_for_yeild)*100,2,'.','') }} %</td>
                            @php
                                $sum_of_weight =  $sum_of_weight +  $af_of->sum_weight ;
                                $sum_of_unit   =  $sum_of_unit + $af_of->sum_unit ;
                            @endphp
                        </tr>
                    @endforeach

                    <tr style="background-color:#c4cbff;">
                        <td class="text-center" style="padding: 0px;" colspan="2"><b>สรุปเครื่องในทั้งหมด</b></td>
                        <td class="text-center" style="padding: 0px;">{{ $sum_of_unit }}</td>
                        <td class="text-center" style="padding: 0px;">{{ $sum_of_weight }}</td>
                        <td class="text-center" style="padding: 0px;">{{ number_format($sum_of_weight/$sum_r_unit,2,'.','') }}</td>
                        <td class="text-center" style="padding: 0px;">{{ number_format($sum_of_weight/$sum_r_unit*$sum_ov_unit,2,'.','') }}</td>
                        <td class="text-center" style="padding: 0px;">{{ number_format( (($sum_of_weight/$sum_r_unit*$sum_ov_unit)/$num_for_yeild)*100,2,'.','') }} %</td>
                        <td hidden></td>
                    </tr>
                {{-- of --}}


                    <tr class="text-center" style="background-color:#04f841;height:32px;" >
                        <td width="48%" style=" padding: 0px;" colspan="7"><b>ส่วนสรุป</b></td>
                        <td width="48%" style=" padding: 0px;" hidden ></td>
                        <td width="48%" style=" padding: 0px;" hidden ></td>
                        <td width="48%" style=" padding: 0px;" hidden ></td>
                        <td width="48%" style=" padding: 0px;" hidden ></td>
                    </tr>
                    <tr style="background-color:#04f841;">
                        <td class="text-center" style="padding: 0px;" colspan="2"><b>รายการ</b></td>
                        <td class="text-center" style="padding: 0px;"><b>ตัว<b></td>
                        <td class="text-center" style="padding: 0px;"><b>ก่อนเชื่อด<b></td>
                        <td class="text-center" style="padding: 0px;"><b>หลังเชือด(เครื่องใน+แกะ)<b></td>
                        <td class="text-center" style="padding: 0px;"><b>ผลต่างน้ำหนัก<b></td>
                        <td class="text-center" style="padding: 0px;"><b> % <b></td>
                    </tr>
            
                    <tr style="background-color:#b0f8c2;">
                        <td class="text-center" style="padding: 0px;" colspan="2">ผลการสรุปทั้งหมด</td>
                        <td class="text-center" style="padding: 0px;">{{ $sum_ov_unit }} </td>
                        <td class="text-center" style="padding: 0px;">{{ number_format( $sum_ov_unit * ($sum_r_weight/$sum_r_unit),2,'.','') }}</td>
                        <td class="text-center" style="padding: 0px;">{{ $sum_cl_weight+$sum_of_weight }}</td>
                        <td class="text-center" style="padding: 0px;">{{ number_format((($sum_ov_unit * ($sum_r_weight/$sum_r_unit))- ($sum_cl_weight+$sum_of_weight)),2,'.',',') }}</td>
                        <td class="text-center" style="padding: 0px;">{{ number_format( ($sum_cl_weight/$num_for_yeild)*100,2,'.','') + number_format( (($sum_of_weight/$sum_r_unit*$sum_ov_unit)/$num_for_yeild)*100,2,'.','') }} % <br>
                            <span style="color: red;"><b>   {{ number_format((100 - ( (($sum_cl_weight/$num_for_yeild)*100) +  ((($sum_of_weight/$sum_r_unit*$sum_ov_unit)/$num_for_yeild)*100))),2,'.',',') }} %Loss </b></span>
                            </td>
                        {{-- {{ number_format($sum_of_weight/$sum_r_unit*$sum_ov_unit,2,'.','') }}</td>
                        {{ number_format( (($sum_of_weight/$sum_r_unit*$sum_ov_unit)/$num_for_yeild)*100,2,'.','') }} %</td> --}}

                    </tr>
            
                    
            </tbody>
                
            </table>

        </div>
        </div>
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
        var table = $('#tbl-1').DataTable({
            lengthMenu: [[-1], ["All"]],
            "scrollX": false,
            orderCellsTop: true,
            fixedHeader: true,
            "ordering": false,
            // rowReorder: true,
            dom: 'Brt',
            // "order": [[ 1, "desc" ]],
            buttons: [
                'excel','copy','print'
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