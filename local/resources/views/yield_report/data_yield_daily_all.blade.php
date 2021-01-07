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
            <h1 class="card-title">น้ำหนักเชือด</h1>
        </div>
        <div class="card-body">
            <div class="table-responsive">
            {{-- <table class="table tb1"> --}}
                <table id="tbl-1" class="tb1 " width="100%" border="1">
                    <thead>
                        <tr class=" text-center bg-secondary"  style="background-color:#93c9ff; height:46px;" >
                            <th width="60%" style=" padding: 0px;" colspan="6">รายงานเชือด order : {{ $order_rr_show1 }} </th>
                        </tr>
                        
                        <tr style="background-color:#ffff93; height:32px;">
                            <td class="text-center" style="padding: 0px; "colspan="6" ><b> น้ำหนักก่อนเชือด [01,02] : {{ $order_rr_show1 }}</b></td>
                        </tr>
                        <tr style="background-color:#ffff93; height:32px;">
                            <th class="text-center" style="padding: 0px;">รหัส order</th>
                            <th class="text-center" style="padding: 0px;">ลูกค้า/สาขา</th>
                            <th class="text-center" style="padding: 0px;">จำนวน (ตัว)</th>
                            <th class="text-center" style="padding: 0px;">น้ำหนัก (กก.)</th>
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
                            <td class="text-center" style="padding: 0px;">
                                <a target="_blank" href="../summary_weighing_receive/{{ $r_list->lot_number }}">{{ $r_list->lot_number }}</a>
                            </td>
                            <td class="text-center" style="padding: 0px;">{{ $r_list->id_user_customer }}</td>
                            <td class="text-center" style="padding: 0px;">{{ $r_list->sum_unit }}</td>
                            <td class="text-center" style="padding: 0px;">{{ number_format($r_list->sum_weight,2,'.',',') }}</td>
                            
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
                            
                            <td class="text-center" style="padding: 0px;" >{{ $sum_unit_r }}</td>
                            <td class="text-center" style="padding: 0px;" >{{ number_format($recieve_weight,2,'.',',') }}</td>
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
                            <th class="text-center" style="padding: 0px;">จำนวน (ชิ้น)</th>
                            <th class="text-center" style="padding: 0px;">น้ำหนัก (กก.)</th>
                            
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
                                    <td class="text-center" style="padding: 0px;">{{ $offal_list->sum_unit }}</td>
                                    <td class="text-center" style="padding: 0px;">{{ number_format($offal_list->sum_weight,2,'.',',') }}</td>
                                    
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
                                        if(
                                            ($offal_list->sku_code=='1020')||($offal_list->sku_code=='5002')||($offal_list->sku_code=='6001')||($offal_list->sku_code=='1018')||
                                            ($offal_list->sku_code=='1028')||($offal_list->sku_code=='1011')||($offal_list->sku_code=='1029')
                                        ) 
                                        {   
                                            $sum_red += $offal_list->sum_weight; 
                                            $p_red += ($offal_list->sum_weight*100)/$recieve_weight;
                                            echo '<p style="color:red;">เครื่องในแดง</p>';
                                            
                                        }
                                        if(
                                            ($offal_list->sku_code=='1109')||($offal_list->sku_code=='5008')||
                                            ($offal_list->sku_code=='5003')||($offal_list->sku_code=='5004')||($offal_list->sku_code=='5001')||
                                            ($offal_list->sku_code=='5005')||($offal_list->sku_code=='5006')||($offal_list->sku_code=='5007')
                                        ) 
                                        {
                                            $sum_white += $offal_list->sum_weight; 
                                            $p_white += ($offal_list->sum_weight*100)/$recieve_weight;
                                            echo '<p style="color:#5900ff;">เครื่องในขาว</p>';
                                            
                                        } 
                                        if(
                                        
                                            ($offal_list->sku_code=='7001')||($offal_list->sku_code=='7002')||($offal_list->sku_code=='7004')||
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
                            <td class="text-center" style="padding: 0px;" >{{ number_format($sum_unit_of,2,'.',',') }}</td>
                            <td class="text-center" style="padding: 0px;" >{{ number_format($sum_weight_of,2,'.',',') }}</td>
                           
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
                            <th class="text-center" style="padding: 0px;">จำนวน (ชิ้น)</th>
                            <th class="text-center" style="padding: 0px;">น้ำหนัก (กก.)</th>
                           
                            <th class="text-center" style="padding: 0px;">เฉลี่ย</th>
                            <th class="text-center" style="padding: 0px;">นน.เฉลี่ย/ตัว</th>
                        </tr>
        
        
                        {{-- หัว --}}
                        <tr style="background-color:#f2fcc5;">
                            <td class="text-center" style="padding: 0px;"> - </td>
                            <td class="text-center" style="padding: 0px;">หัว</td>
                            
                            <td class="text-center" style="padding: 0px;"></td>
                            <td class="text-center" style="padding: 0px;">{{ number_format($sum_head,2,'.',',') }}</td>
                            <td class="text-center" style="padding: 0px;">{{ number_format($p_head,2,'.',',') }} %</td>
                            <td class="text-center" style="padding: 0px;">{{ number_format($sum_head/$sum_unit_r,2,'.',',')}}</td>
                        </tr>
                        {{-- เคร่ื่องในแดง --}}
                        <tr style="background-color:#f2fcc5;">
                            <td class="text-center" style="padding: 0px;"> - </td>
                            <td class="text-center" style="padding: 0px;">เครื่องในแดง</td>
                           
                            <td class="text-center" style="padding: 0px;"></td>
                            <td class="text-center" style="padding: 0px;">{{ number_format($sum_red,2,'.',',') }}</td>
                            <td class="text-center" style="padding: 0px;">{{ number_format($p_red,2,'.',',') }} %</td>
                            <td class="text-center" style="padding: 0px;">{{ number_format($sum_red/$sum_unit_r,2,'.',',') }}</td>
                        </tr>
                        {{-- เคร่ื่องในขาว --}}
                        <tr style="background-color:#f2fcc5;">
                            <td class="text-center" style="padding: 0px;"> - </td>
                            <td class="text-center" style="padding: 0px;">เครื่องในขาว</td>
                            
                            <td class="text-center" style="padding: 0px;"></td>
                            <td class="text-center" style="padding: 0px;">{{ number_format($sum_white,2,'.',',') }}</td>
                            <td class="text-center" style="padding: 0px;">{{ number_format($p_white,2,'.',',') }} %</td>
                            <td class="text-center" style="padding: 0px;">{{ number_format($sum_white/$sum_unit_r,2,'.',',')}}</td>
                        </tr>                                
        
                        <tr style="background-color:#f2fcc5;">
                            <td class="text-center" style="padding: 0px;" ><b> รวม</b></td>
                            <td class="text-center" style="padding: 0px;" ></td>
                            
                            <td class="text-center" style="padding: 0px;" ></td>
                            <td class="text-center" style="padding: 0px;" >{{ number_format($sum_head+$sum_red+$sum_white,2,'.',',')}}</td>
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
                            <th class="text-center" style="padding: 0px;">จำนวน (ชิ้น)</th>
                            <th class="text-center" style="padding: 0px;">น้ำหนัก (กก.)</th>
                           
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
                            <td class="text-center" style="padding: 0px;">{{ number_format($ov_list->sum_unit,2,'.',',') }}</td>
                            <td class="text-center" style="padding: 0px;">{{ number_format($ov_list->sum_weight,2,'.',',') }}</td>
                           
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
                            <td class="text-center" style="padding: 0px;" >{{ $sum_unit }}</td>
                            <td class="text-center" style="padding: 0px;" >{{ number_format($sum_weight,2,'.',',') }}</td>
                            
                            <td class="text-center" style="padding: 0px;" >{{ number_format($sum_percent,2,'.',',') }} %</td>
                            <td class="text-center" style="padding: 0px;" >{{ number_format((( $ov_list->sum_weight)/$sum_unit_r),2,'.',',')}}</td>
                        </tr>
        
                        <tr style="background-color:#ff8c8c;">
                            <th class="text-center" style="padding: 0px;">รวม</th>
                            <th class="text-center" style="padding: 0px;"></th>
                           
                            <th class="text-center" style="padding: 0px;"></th>
                            <th class="text-center" style="padding: 0px;">{{ number_format($sum_weight + $sum_weight_of,2,'.',',')    }}</th>
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
                <h4 class="card-title">น้ำหนักตัดแต่ง</h4>
            </div>
        <div class="card-body"> 
            <table id="tbl-1" class="tbl " width="100%" border="1">
                <thead>
                    <tr class=" text-center bg-secondary" style="background-color:#93c9ff; height:45px;" >
                        <th width="100%" style=" padding: 0px;" colspan="10">รายงานน้ำหนักการผลิตวันที่ : {{ $date_format }} </th>
                    </tr>
                    <tr class="text-center" style="background-color:#ffffc4;height:32px;" >
                        <th width="48%" style=" padding: 0px;" colspan="10"> น้ำหนักหมูรับเข้ายกมา</th>
                    </tr>
                    <tr style="background-color:#ffffc4;height:32px;" hidden >
                        <th class="text-center" style="padding: 0px;" colspan="2">order</th>
                        <th class="text-center" style="padding: 0px;">จำนวน (ตัว)</th>
                        <th class="text-center" style="padding: 0px;">น้ำหนัก (กก.)</th>
                        <th class="text-center" style="padding: 0px;">เฉลี่ย (กก./ตัว)</th>
                        <th class="text-center" style="padding: 0px;">หมายเหตุ</th>
                        <th class="text-center" style="padding: 0px;">หมายเหตุ</th>
                        <th class="text-center" style="padding: 0px;">หมายเหตุ</th>
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
                        <td class="text-center" style="padding: 0px;"><b>ยกมา</b></td>  
                        <td class="text-center" style="padding: 0px;"><b>ใช้ไป</b></td>
                        <td class="text-center" style="padding: 0px;"><b>คงเหลือ</b></td>                 
                        
                        
                        
                    </tr>
                    @foreach ($r_data_list as $r_list)
                        <tr style="background-color:#fffff4;">
                            <td class="text-center" style="padding: 0px;" colspan="4"><a target="_blank" href="../summary_weighing_receive/{{ $r_list->lot_number }}">{{ $r_list->lot_number }}</a></td>
                            <td class="text-center" style="padding: 0px;">{{ $r_list->sum_unit }}</td>
                            <td class="text-center" style="padding: 0px;">{{ number_format($r_list->sum_weight,2,'.',',') }}</td>
                            <td class="text-center" style="padding: 0px;">{{ number_format($r_list->sum_weight/$r_list->sum_unit,2,'.','') }}</td>
                                @php
                                    $sum_r_weight =  $sum_r_weight +  $r_list->sum_weight ;
                                    $sum_r_unit   =  $sum_r_unit +    $r_list->sum_unit   ;
                                    $pig_use_all  =  $r_list->pig_use1+$r_list->pig_use2+$r_list->pig_use3+$r_list->pig_use4+$r_list->pig_use5;  
                                @endphp
                            <td class="text-center" style="padding: 0px;">{{ $r_list->sum_unit - $pig_use_all }}</td>
                            <td class="text-center" style="padding: 0px;">{{ $r_list->pig_use }}</td>
                            <td class="text-center" style="padding: 0px;">{{ ($r_list->sum_unit - $pig_use_all) - $r_list->pig_use }}</td>
                            
                        </tr>
                    @endforeach
                    <tr style="background-color:#ffffc4;">
                        <td class="text-center" style="padding: 0px;" colspan="4"><b>สรุปรวมยกมา</b></td>
                        <td class="text-center" style="padding: 0px;"> {{ $sum_r_unit }}</td>
                        <td class="text-center" style="padding: 0px;">{{ number_format($sum_r_weight,2,'.',',') }}</td>
                        <td class="text-center" style="padding: 0px;">
                            {{ number_format($sum_r_weight/$sum_r_unit,2,'.','') }} 
                        </td>
                        <td hidden></td>
                        @php
                            $avg_r_weight = number_format($sum_r_weight/$sum_r_unit,2,'.','');
                        @endphp
                        <td class="text-center" style="padding: 0px;" colspan="3" >ค่าเฉลี่ยนน้ำหนักต่อต่อจากการเชือด</td>
                        <td hidden >-</td>
                        <td hidden >-</td>
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
                        <td width="48%" style=" padding: 0px;" colspan="10"><b>ซากหลังแช่</b></td>
                        <td width="48%" style=" padding: 0px;" hidden ></td>
                        <td width="48%" style=" padding: 0px;" hidden ></td>
                        <td width="48%" style=" padding: 0px;" hidden ></td>
                        <td width="48%" style=" padding: 0px;" hidden ></td>
                    </tr>
                    <tr style="background-color:#e0ffc4;height:32px;">
                        <td class="text-center" style="padding: 0px;" colspan="2" ><b>order</b></td>
                        <td class="text-center" style="padding: 0px;" colspan="2" ><b>OV</b></td>                     
                        <td class="text-center" style="padding: 0px;"><b>จำนวน(ตัว)</b></td>
                        <td class="text-center" style="padding: 0px;"><b>น้ำหนัก</b></td>
                        <td class="text-center" style="padding: 0px;"><b>เฉลี่ย</b></td>
                        <td class="text-center" style="padding: 0px;" ><b>ใช้ไป</b></td>
                        <td class="text-center" style="padding: 0px;" ><b>น้ำหนัก</b></td>
                        <td class="text-center" style="padding: 0px;" ><b>เฉลี่ย</b></td>
                    </tr>
                    @php
                        $ov_weight_avg = 0;
                        $sum_ov_unit_r = 0;
                        $sum_ov_weight_r = 0;
                    @endphp
                    @foreach ($after_ov as $af_ov)  
                       
                        <tr style="background-color:#eeffdf;height:32px;">
                            <td class="text-center" style="padding: 0px;" colspan="2">
                                @php
                                     $exp_order_ref =  explode(",",$af_ov->group_order_ref);
                                     $exp_total_pig =  explode(",",$af_ov->group_total_pig);
                                @endphp
                                @foreach ($r_data_list as $r_list)
                                     @php
                                                                 
                                    foreach ($exp_order_ref as $key => $value)
                                    {
                                        // echo "r_lat[".$r_list->lot_number.",".$value.",<br>".$key.",".$exp_total_pig[$key]."]<br>";
                                        if( trim($value) == $r_list->lot_number)
                                        {
                                           echo $r_list->lot_number."(".floatval($exp_total_pig[$key]).")<br>";
                                        }
                                    }
                                    @endphp
  
                               @endforeach

                            </td>
                            <td class="text-center" style="padding: 0px;" colspan="2"  
                                title="{{ $af_ov->group_order_ref }} &#xA; {{ $af_ov->group_order_number }}  &#xA; {{ $af_ov->group_total_pig }}">
                                <a target="_blank" href="../debug/{{ $af_ov->lot_number }}">{{ $af_ov->lot_number }}</a>
                            </td>

                            <td class="text-center" style="padding: 0px;" title="{{ $af_ov->group_total_pig }}">{{ $af_ov->sum_unit/2 }}</td>
                            <td class="text-center" style="padding: 0px;">{{ number_format($af_ov->sum_weight,2,'.',',') }}</td>                       
                            <td class="text-center" style="padding: 0px;">{{ number_format($af_ov->sum_weight/($af_ov->sum_unit/2),2,'.','') }}</td>
                            <td class="text-center" style="padding: 0px;">
                                
                               
                                @php
                                    $sum_total_pig =0;
                                    $exp_total_pig =  explode(",",$af_ov->group_total_pig);
                                    foreach ($exp_total_pig as $value)
                                    {
                                      $sum_total_pig += floatval($value);  
                                    }
                                @endphp
                                 {{  $sum_total_pig }}
                            </td>
                            <td class="text-center" style="padding: 0px;">
                                @php
                                    
                                    $exp_order_ref =  explode(",",$af_ov->group_order_ref);
                                    $exp_total_pig =  explode(",",$af_ov->group_total_pig);
                                    
                                    $sum_total_pig2 = 0;
                                    $ov_weight_avg = 0;
                                    $chk_ref = 0;

                                foreach($r_data_list as $r_list)
                                 {
                                   
                                        // echo "r_lat".$r_list->lot_number."\n";

                                        foreach ($exp_order_ref as $key => $value)
                                        {
                                            // echo "r_lat[".$r_list->lot_number.",".$value.",<br>".$key.",".$exp_total_pig[$key]."]<br>";
                                            if( trim($value) == $r_list->lot_number)
                                             {
                                                $chk_ref = 1;
                                                // echo "OK-".$key."<br>";
                                                $sum_total_pig2 += floatval($exp_total_pig[$key]) * ($r_list->sum_weight/$r_list->sum_unit);
                                                $sum_ov_weight_r += ( floatval($exp_total_pig[$key]) * ($r_list->sum_weight/$r_list->sum_unit));
                                             }
                                        }

                                    }
                                
                                 if($chk_ref == 1)
                                 {
                                   echo number_format($sum_total_pig2,2,'.',',');  
                                   $ov_weight_avg = $sum_total_pig2/ $sum_total_pig;
                                   $chk_ref = 0;  
                                 }
                                 
                                @endphp
                            </td>
                            <td class="text-center" style="padding: 0px;">
                                {{ number_format($ov_weight_avg,2,'.',',') }}
                           

                             </td>
                             @php
                            
                             $sum_ov_weight =  $sum_ov_weight +  $af_ov->sum_weight;
                             $sum_ov_unit   =  $sum_ov_unit + ($af_ov->sum_unit/2);
                             $exp_total_pig =  explode(",",$af_ov->group_total_pig);
                             foreach ($exp_total_pig as $value)
                             {
                                 $sum_ov_unit_r += floatval($value);  
                                 //echo $value.",";

                             }
                            @endphp
                        </tr>
                        
                    @endforeach

                    <tr style="background-color:#e0ffc4;">
                        <td class="text-center" style="padding: 0px;" colspan="4">สรุปตัดแต่งทั้งหมด</td>
                        <td class="text-center" style="padding: 0px;">
                             {{ $sum_ov_unit }}
                        </td>
                        <td class="text-center" style="padding: 0px;">{{ $sum_ov_weight }}</td>
                        @if($sum_ov_unit > 0)
                          <td class="text-center" style="padding: 0px;">{{ number_format($sum_ov_weight/$sum_ov_unit,2,'.','') }} </td>
                        @else
                          <td class="text-center" style="padding: 0px;">0 </td>
                        @endif
                        <td class="text-center" style="padding: 0px;">{{ $sum_ov_unit_r }}</td>
                        <td class="text-center" style="padding: 0px;" >{{ number_format($sum_ov_weight_r,2,'.',',') }}</td>
                        @if($sum_ov_unit > 0)
                        <td class="text-center" style="padding: 0px;" ><span style="color: red;"><b> {{ number_format($sum_ov_weight_r/$sum_ov_unit_r,2,'.',',') }} </b></span></td>
                        @else
                        <td class="text-center" style="padding: 0px;" ><span style="color: red;"><b> 0 </b></span></td>
                        @endif
                        @php
                            $num_for_yeild = number_format($sum_ov_unit*$avg_r_weight,2,'.','');
                        @endphp

                    </tr>
                {{-- end ov --}}

                <tr class="text-center" style="background-color:#09f330;height:32px;" >
                    <td width="48%" style=" padding: 0px;" colspan="10"><b>สรุปการคิดน้ำหนักเฉลี่ยเพื่อการตัดแต่งทั้งหมด</b></td>
                    <td width="48%" style=" padding: 0px;" hidden ></td>
                    <td width="48%" style=" padding: 0px;" hidden ></td>
                    <td width="48%" style=" padding: 0px;" hidden ></td>
                    <td width="48%" style=" padding: 0px;" hidden ></td>
                </tr>
                {{-- --  start หาค่าเฉลี่ย นำหนักหมู -- --}}
                <tr style="background-color:hsl(120, 59%, 82%);">
                    <td class="text-center" style="padding: 0px;" colspan="4"><b>จำนวนหมูขุน(จำนวนเบิกซาก x น้ำหนักเฉลี่ยนจาก Order เชือด) </b></td>
                    <td class="text-center" style="padding: 0px;">
                        <span style="color: rgb(17, 0, 255);"><b> {{ $sum_ov_unit }} </b></span>
                    </td>
                    @if(@sum_ov_unit_r>0)
                    <td class="text-center" style="padding: 0px;">{{ number_format( $sum_ov_unit * ($sum_ov_weight_r/$sum_ov_unit_r),2,'.',',') }}</td>

                    <td class="text-center" style="padding: 0px;">{{ number_format( $sum_ov_weight_r/$sum_ov_unit_r ,2,'.',',') }} </td>
                    <td class="text-center" style="padding: 0px;" colspan="3" > คิดจากน้ำหลักเฉลี่ยน 
                        <span style="color: rgb(17, 0, 255);"><b> {{ $sum_ov_unit }} </b></span>
                        X
                        <span style="color: rgb(255, 0, 0);"><b> {{ number_format($sum_ov_weight_r/$sum_ov_unit_r,2,'.','') }} </b></span>
                    </td>
                    @else
                    <td class="text-center" style="padding: 0px;">0</td>

                    <td class="text-center" style="padding: 0px;">0</td>
                    <td class="text-center" style="padding: 0px;" colspan="3" > คิดจากน้ำหลักเฉลี่ยน 
                        <span style="color: rgb(17, 0, 255);"><b> {{ $sum_ov_unit }} </b></span>
                        X
                        <span style="color: rgb(255, 0, 0);"><b>0</b></span>
                    </td>
                    @endif
                    <td hidden >-</td>
                    <td hidden >-</td>

                    @php
                       
                       if($sum_ov_unit_r>0){
                            $num_for_yeild = $sum_ov_unit * ($sum_ov_weight_r/$sum_ov_unit_r);
                       }else {
                        $num_for_yeild = 0; 
                       }

                    @endphp

                </tr>

                {{-- cutting /ov --}}
                        @php
                            // ! variable !
                            $sum_cl_weight=0;
                            $sum_cl_unit=0;
                        @endphp
                        <tr class="text-center" style="background-color:#fee2c5;height:32px;" >
                            <td width="48%" style=" padding: 0px;" colspan="10"><b>ชิ้นส่วนหลังแกะ</b></td>
                            <td width="48%" style=" padding: 0px;" hidden ></td>
                            <td width="48%" style=" padding: 0px;" hidden ></td>
                            <td width="48%" style=" padding: 0px;" hidden ></td>
                            <td width="48%" style=" padding: 0px;" hidden ></td>
                        </tr>
                        
                        <tr class="text-center" style="background-color:#fff2e6;height:32px;" >
                            <td width="20%" style=" padding: 0px;" colspan="10">
                                
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
                                    <br>
                                     ['KMK08', 'KMK09','KMK11','KMK12']
                                

                                
                        </td>
                        </tr>
                    
                        <tr style="background-color:#fee2c5;height:32px;">
                            <td class="text-center" style="padding: 0px;"colspan="2"><b>รหัส Item</b></td>
                            <td class="text-center" style="padding: 0px;"colspan="2"><b>ชื่อ item</b></td>
                            <td class="text-center" style="padding: 0px;"><b>จำนวน(ชิ้น)</b></td>
                            <td class="text-center" style="padding: 0px;"><b>น้ำหนัก</b></td>
                            <td class="text-center" style="padding: 0px;"><b>%</b></td>
                            <td class="text-center" style="padding: 0px;"><b>ประเภท</b></td>
                            <td class="text-center" style="padding: 0px;"><b>กลุ่ม</b></td>
                            <td class="text-center" style="padding: 0px;"><b>หมายเหตุ</b></td>
                        </tr>
                        @php
                            // ประกาศ ตัวแปร เก็บ น้ำหนักกลุ่ม 
                            $G1=0; 
                            $G2=0;
                            $G3=0;
                            $G4=0;
                            $G5=0;
                            $G6=0;
                            $G7=0;
                            $G8=0;
                            $G9=0;
                            $G10=0;

                            $GU1=0; 
                            $GU2=0;
                            $GU3=0;
                            $GU4=0;
                            $GU5=0;
                            $GU6=0;
                            $GU7=0;
                            $GU8=0;
                            $GU9=0;
                            $GU10=0;

                            $H_W = 0;
                            $H_U = 0;
                            // น้ำหนักยกตัว
                            $sum_body_unit = 0;
                            $sum_body_weight = 0;

                        @endphp
                        @foreach ($ov_data_list as $af_cl)  
                            <tr style="background-color:#fff2e6;height:32px;">
                                <td class="text-center" style="padding: 0px;"colspan="2">{{ $af_cl->sku_code }}</td>
                                <td class="text-center" style="padding: 0px;"colspan="2">{{ $af_cl->item_name }}</td>
                                <td class="text-center" style="padding: 0px;">{{ $af_cl->sum_unit }}</td>
                                <td class="text-center" style="padding: 0px;">{{ $af_cl->sum_weight }}</td>                       
                                <td class="text-center" style="padding: 0px;">{{ number_format( ($af_cl->sum_weight/$num_for_yeild)*100,2,'.','') }} %</td>
                                <td class="text-center" style="padding: 0px;">
                                    @php
                                        if(
                                            ($af_cl->sku_code == '1001')||($af_cl->sku_code == '1037')||($af_cl->sku_code == '1038')||
                                            ($af_cl->sku_code == '1039')||($af_cl->sku_code == '1041')||($af_cl->sku_code == '1042')||
                                            ($af_cl->sku_code == '1070')
                                            )
                                        {
                                           
                                            echo '<p style="color:#1f1cf1;">หัว</p>';
                                            $H_W+=$af_cl->sum_weight;
                                            $H_U+=$af_cl->sum_unit;
                                        
                                        }
                                    @endphp
                                </td>
                                <td class="text-center" style="padding: 0px;">
                                    @php
                                    //    echo  $offal_list->sku_code;
                                    // -- for sumaty of -------
                                        if(
                                            ($af_cl->sku_code == '1002')||($af_cl->sku_code == '1003')||($af_cl->sku_code == '1004')||
                                            ($af_cl->sku_code == '1005')||($af_cl->sku_code == '1008')||($af_cl->sku_code == '1009')||
                                            ($af_cl->sku_code == '1010')||($af_cl->sku_code == '1012')||($af_cl->sku_code == '1048')||
                                            ($af_cl->sku_code == '1079')
                                            )
                                        {
                                           
                                            echo '<p style="color:#ff0000;">กลุ่ม 1. เนื้อแดง</p>';
                                            $G1+=$af_cl->sum_weight;
                                            $GU1+=$af_cl->sum_unit;
                                        
                                        }
                                        elseif ( ($af_cl->sku_code == '1015')) {
                                            # code...
                                            echo '<p style="color:#1100ff;">กลุ่ม 2. หนัง</p>';
                                            $G2+=$af_cl->sum_weight;
                                            $GU2+=$af_cl->sum_unit;
                                        }
                                        elseif ( 
                                            ($af_cl->sku_code == '1011')||($af_cl->sku_code == '1018')||($af_cl->sku_code == '1019')||
                                            ($af_cl->sku_code == '1020')||($af_cl->sku_code == '1021')||($af_cl->sku_code == '1022')||
                                            ($af_cl->sku_code == '1023')||($af_cl->sku_code == '1024')||($af_cl->sku_code == '1025')||
                                            ($af_cl->sku_code == '1026')||($af_cl->sku_code == '1027')||($af_cl->sku_code == '1028')||
                                            ($af_cl->sku_code == '1029')||
                                            ($af_cl->sku_code == '1030')||($af_cl->sku_code == '1045')||($af_cl->sku_code == '1046')||
                                            ($af_cl->sku_code == '1109')||($af_cl->sku_code == '1049')||($af_cl->sku_code == '1124')
                                            ) {
                                            # code...
                                            echo '<p style="color:#1100ff;">กลุ่ม 3. เครื่องในขาว+แดง</p>';
                                            $G3+=$af_cl->sum_weight;
                                            $GU3+=$af_cl->sum_unit;
                                        }
                                        elseif ( 
                                            ($af_cl->sku_code == '1006')||($af_cl->sku_code == '1007')||($af_cl->sku_code == '1016')||
                                            ($af_cl->sku_code == '1017')||($af_cl->sku_code == '1035')||($af_cl->sku_code == '1036')||
                                            ($af_cl->sku_code == '1056')||($af_cl->sku_code == '1064')||($af_cl->sku_code == '1067')||
                                            ($af_cl->sku_code == '1080')||($af_cl->sku_code == '1092')||($af_cl->sku_code == '1095')||
                                            ($af_cl->sku_code == '1097')||($af_cl->sku_code == '1104')||($af_cl->sku_code == '1122')
                                            ) {
                                            # code...
                                            echo '<p style="color:#1100ff;">กลุ่ม 4. ขา-กระดูก</p>';
                                            $G4+=$af_cl->sum_weight;
                                            $GU4+=$af_cl->sum_unit;
                                        }
                                        elseif (
                                            ($af_cl->sku_code == '1111')||($af_cl->sku_code == '1083')||($af_cl->sku_code == '1084')||
                                            ($af_cl->sku_code == '1085')
                                            ) {
                                            # code...
                                            echo '<p style="color:#1100ff;">กลุ่ม 6. ท่อน</p>';
                                            $G6+=$af_cl->sum_weight;
                                            $GU6+=$af_cl->sum_unit;
                                        }
                                        elseif (
                                            ($af_cl->sku_code == '1034')||($af_cl->sku_code == '1043')||($af_cl->sku_code == '1044')||
                                            ($af_cl->sku_code == '1051')||($af_cl->sku_code == '1062')||($af_cl->sku_code == '1065')||
                                            ($af_cl->sku_code == '1068')||($af_cl->sku_code == '1075')||($af_cl->sku_code == '1081')||
                                            ($af_cl->sku_code == '1082')||($af_cl->sku_code == '1093')||($af_cl->sku_code == '1096')||
                                            ($af_cl->sku_code == '1098')||($af_cl->sku_code == '1101')||($af_cl->sku_code == '1103')||

                                            ($af_cl->sku_code == '1104')||($af_cl->sku_code == '1105')||($af_cl->sku_code == '1106')||
                                            ($af_cl->sku_code == '1107')||($af_cl->sku_code == '1108')||($af_cl->sku_code == '1110')||
                                            ($af_cl->sku_code == '1112')||($af_cl->sku_code == '1113')||($af_cl->sku_code == '1114')||
                                            ($af_cl->sku_code == '1116')||($af_cl->sku_code == '1117')||($af_cl->sku_code == '1118')||
                                            ($af_cl->sku_code == '1119')||($af_cl->sku_code == '1120')||($af_cl->sku_code == '1121')||
                                            ($af_cl->sku_code == '1123')
                                            ) {
                                            # code...
                                            echo '<p style="color:#1100ff;">กลุ่ม 7. แปรรูป</p>';
                                            $G7+=$af_cl->sum_weight;
                                            $GU7+=$af_cl->sum_unit;
                                        }
                                        elseif (
                                            ($af_cl->sku_code == '1032')||($af_cl->sku_code == '1105')||($af_cl->sku_code == '1106')
                                        ) {
                                            # code...
                                            echo '<p style="color:#1100ff;">กลุ่ม 8. น้ำมัน</p>';
                                            $G8+=$af_cl->sum_weight;
                                            $GU8+=$af_cl->sum_unit;
                                        }
                                        elseif (
                                            ($af_cl->sku_code == '0001')||($af_cl->sku_code == '1105')||($af_cl->sku_code == '1106')
                                        ) {
                                            # code...
                                            echo '<p style="color:#1100ff;">กลุ่ม 9. หัวชุด</p>';
                                            $G9+=$af_cl->sum_weight;
                                            $GU9+=$af_cl->sum_unit;
                                        }
                                        elseif(
                                            ($af_cl->sku_code == '1102')
                                        )
                                        {
                                            echo '<p style="color:#bb17fc;">ซากยกตัว</p>'; 
                                           
                                            $sum_body_weight+=$af_cl->sum_weight;
                                            $sum_body_unit+=$af_cl->sum_unit;
                                            
                                        }
                                        elseif(
                                            ($af_cl->sku_code == '1001')||($af_cl->sku_code == '1037')||($af_cl->sku_code == '1038')||
                                            ($af_cl->sku_code == '1039')||($af_cl->sku_code == '1041')||($af_cl->sku_code == '1042')||
                                            ($af_cl->sku_code == '1070')

                                        ){
                                            # code...
                                            echo '<p style="color:#1100ff;">กลุ่ม 5. หัว</p>';
                                            $G5+=$af_cl->sum_weight;
                                            $GU5+=$af_cl->sum_unit;
                                        }

                                        else{
                                            # code...
                                            echo '<p style="color:#1100ff;">กลุ่ม 10. อื่น ๆ </p>';
                                            $G10+=$af_cl->sum_weight;
                                            $GU10+=$af_cl->sum_unit;
                                        }

                                    @endphp
                                </td>
                                <td class="text-center" style="padding: 0px;"></td>
                                @php
                                    $sum_cl_weight =  $sum_cl_weight +  $af_cl->sum_weight ;
                                    $sum_cl_unit   =  $sum_cl_unit + $af_cl->sum_unit ;
                                    
                                    $sum_body_unit_div = intdiv($sum_body_weight,70); 

                                @endphp
                                
                            </tr>
                        @endforeach
                        @foreach ($sp_data_list as $af_cl)  
                            <tr style="background-color:#cac5c0;height:32px;">
                                <td class="text-center" style="padding: 0px;"colspan="2">{{ $af_cl->sku_code }}</td>
                                <td class="text-center" style="padding: 0px;"colspan="2">{{ $af_cl->item_name }}</td>
                                <td class="text-center" style="padding: 0px;">{{ $af_cl->sum_unit }}</td>
                                <td class="text-center" style="padding: 0px;">{{ $af_cl->sum_weight }}</td>                       
                                <td class="text-center" style="padding: 0px;">{{ number_format( ($af_cl->sum_weight/$num_for_yeild)*100,2,'.','') }} %</td>
                                <td class="text-center" style="padding: 0px;">


                                    
                                
                                </td>
                                <td class="text-center" style="padding: 0px;">
                                    @php
                                    if(  $af_cl->sku_code = '1032' )
                                    {
                                        # code...
                                        echo '<p style="color:#1100ff;">กลุ่ม 10. อื่น ๆ</p>';
                                        $G10+=$af_cl->sum_weight;
                                        $GU10+=$af_cl->sum_unit;
                                    }

                                @endphp
                                
                                </td>
                                <td class="text-center" style="padding: 0px;"></td>
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
                            <td class="text-center" style="padding: 0px;" colspan="3"></td>
                            <td class="text-center" style="padding: 0px;" hidden>-</td>
                            <td class="text-center" style="padding: 0px;" hidden>-</td>
                        </tr>
                    {{-- end cutting /ov --}}

                {{-- of --}}
                    @php
                        // ! variable !
                        $sum_of_weight=0;
                        $sum_of_unit=0;
                    @endphp
                    <tr class="text-center" style="background-color:#c4cbff;height:32px;" >
                        <td width="48%" style=" padding: 0px;" colspan="10"><b>เครื่องในหลังแกะ</b></td>
                        <td width="48%" style=" padding: 0px;" hidden ></td>
                        <td width="48%" style=" padding: 0px;" hidden ></td>
                        <td width="48%" style=" padding: 0px;" hidden ></td>
                        <td width="48%" style=" padding: 0px;" hidden ></td>
                        <td width="48%" style=" padding: 0px;" hidden ></td>
                    </tr>
                    
                    <tr class="text-center" style="background-color:#dfe3ff;height:20px;" >
                        <td width="48%" style=" padding: 0px;" colspan="10">
                           
                                @php
                                    $order_of_show_ = explode(",",$order_of_show); 
                                    
                                    @endphp
                                    
                                    @foreach ( $order_of_show_ as $value)
                                    <a target="blank_" href="../debug/{{  $value }}">{{  $value }}</a>
                                    @endforeach
                    </td>
                    </tr>
                
                    <tr style="background-color:#c4cbff;height:32px;">
                        <td class="text-center" style="padding: 0px;"><b>รหัส Item</b></td>
                        <td class="text-center" style="padding: 0px;"><b>ชื่อ item</b></td>
                        <td class="text-center" style="padding: 0px;"><b>จำนวน(ชิ้น)</b></td>
                        <td class="text-center" style="padding: 0px;"><b>น้ำหนัก</b></td>
                        <td class="text-center" style="padding: 0px;"><b>เฉลี่ยต่อตัว</b></td>
                        <td class="text-center" style="padding: 0px;"><b>น้ำหนักต่อ {{ $sum_ov_unit }} ตัว</b></td>
                        <td class="text-center" style="padding: 0px;"><b>%</b></td>
                        <td class="text-center" style="padding: 0px;"><b>ประเภท</b></td>
                        <td class="text-center" style="padding: 0px;"><b>กลุ่ม</b></td>
                        <td class="text-center" style="padding: 0px;"><b>หมายเหตุ</b></td>
                    </tr>
                    @php
                        $sum_of_r=0;
                        $sum_of_w=0;
                    @endphp
                    @foreach ($offal_data_list as $af_of)  
                        <tr style="background-color:#dfe3ff;height:32px;">
                            <td class="text-center" style="padding: 0px;">{{ $af_of->sku_code }}</td>
                            <td class="text-center" style="padding: 0px;">{{ $af_of->item_name }}</td>
                            <td class="text-center" style="padding: 0px;">{{ $af_of->sum_unit }}</td>
                            <td class="text-center" style="padding: 0px;">{{ $af_of->sum_weight }}</td>                       
                            <td class="text-center" style="padding: 0px;">{{ number_format($af_of->sum_weight/$sum_r_unit,2,'.','') }}</td>                       
                            <td class="text-center" style="padding: 0px;">{{ number_format(($af_of->sum_weight/$sum_r_unit)*$sum_ov_unit,2,'.','') }}</td>                       
                            <td class="text-center" style="padding: 0px;">{{ number_format( ( (($af_of->sum_weight/$sum_r_unit)*$sum_ov_unit) / $num_for_yeild)*100,2,'.','') }} %</td>
                            <td class="text-center" style="padding: 0px;">
                                @php
                                //    echo  $offal_list->sku_code;
                                // -- for sumaty of -------

                                    if(
                                        ($af_of->sku_code=='1018')||($af_of->sku_code=='1028')||($af_of->sku_code=='1030')||($af_of->sku_code=='1018')||
                                        ($af_of->sku_code=='1020')||($af_of->sku_code=='1011')
                                    ) 
                                    {   
                                      
                                        echo '<p style="color:red;">เครื่องในแดง</p>';
                                        $GU3+=$af_of->sum_unit;
                                        $G3+=($af_of->sum_weight/$sum_r_unit)*$sum_ov_unit;
                                        $sum_of_r+=($af_of->sum_weight/$sum_r_unit)*$sum_ov_unit;
                                        
                                    }
                                    if(
                                        ($af_of->sku_code=='1019')||($af_of->sku_code=='1021')||
                                        ($af_of->sku_code=='1022')||($af_of->sku_code=='1023')||($af_of->sku_code=='1024')||
                                        ($af_of->sku_code=='1025')||($af_of->sku_code=='1026')||($af_of->sku_code=='1027')||
                                        ($af_of->sku_code=='1045')||($af_of->sku_code=='1046')||($af_of->sku_code=='1109')||
                                        ($af_of->sku_code=='1124')
                                    ) 
                                    {
                                      
                                        echo '<p style="color:#5900ff;">เครื่องในขาว</p>';
                                        $GU3+=$af_of->sum_unit;
                                        $G3+=($af_of->sum_weight/$sum_r_unit)*$sum_ov_unit;
                                        $sum_of_w+=($af_of->sum_weight/$sum_r_unit)*$sum_ov_unit;
                                        
                                    } 

                                
                                @endphp
                            </td>
                            <td class="text-center" style="padding: 0px;"><p style="color:#1100ff;">กลุ่ม 3. เครื่องในชาว+แดง</p></td>
                            <td class="text-center" style="padding: 0px;"></td>
                            @php
                                $sum_of_weight =  $sum_of_weight +  $af_of->sum_weight;
                                $sum_of_unit   =  $sum_of_unit + $af_of->sum_unit;
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
                        <td class="text-center" style="padding: 0px;" colspan="3" ></td>
                        <td hidden >-</td>
                        <td hidden >-</td>
                    </tr>
                {{-- of --}}


                    <tr class="text-center" style="background-color:#04f841;height:32px;" >
                        <td width="48%" style=" padding: 0px;" colspan="10"><b>ส่วนสรุป</b></td>
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
                        <td class="text-center" style="padding: 0px;" colspan="3" ><b>หมายเหตุ</b></td>
                        <td hidden >-</td>
                        <td hidden >-</td>
                    </tr>
            
                    <tr style="background-color:#b0f8c2;">
                        <td class="text-center" style="padding: 0px;" colspan="2">ผลการสรุปทั้งหมด</td>
                        <td class="text-center" style="padding: 0px;">{{ $sum_ov_unit }} </td>
                        <td class="text-center" style="padding: 0px;">{{ number_format( $num_for_yeild ,2,'.',',') }}</td>
                        <td class="text-center" style="padding: 0px;">{{ number_format(($sum_cl_weight+($sum_of_weight/$sum_r_unit*$sum_ov_unit)) ,2,'.',',') }}</td>
                        <td class="text-center" style="padding: 0px;">{{ number_format(($num_for_yeild - ($sum_cl_weight+($sum_of_weight/$sum_r_unit*$sum_ov_unit))),2,'.',',') }}</td>
                        <td class="text-center" style="padding: 0px;">{{ number_format( ($sum_cl_weight/$num_for_yeild)*100,2,'.','') + number_format( (($sum_of_weight/$sum_r_unit*$sum_ov_unit)/$num_for_yeild)*100,2,'.','') }} % <br></td>
                        <td class="text-center" style="padding: 0px;" colspan="3" >
                            <span style="color: red;"><b>   {{ number_format((100 - ( (($sum_cl_weight/$num_for_yeild)*100) +  ((($sum_of_weight/$sum_r_unit*$sum_ov_unit)/$num_for_yeild)*100))),2,'.',',') }} %Loss </b></span>
                        </td>
                        <td hidden >-</td>
                        <td hidden >-</td>  
                        {{-- {{ number_format($sum_of_weight/$sum_r_unit*$sum_ov_unit,2,'.','') }}</td>
                        {{ number_format( (($sum_of_weight/$sum_r_unit*$sum_ov_unit)/$num_for_yeild)*100,2,'.','') }} %</td> --}}

                    </tr>
            
                    
            </tbody>
                
            </table>

        </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-5 col-lg-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-header header-sm d-flex justify-content-between align-items-center">
                <h1 class="card-title">สรุปรายงานน้ำหนัก</h1>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="tb1" width="100%" border="1">  
                        <thead>
                            <tr class="text-center" style="background-color:#53eb0d;height:50px;">
                                <th class="text-center" style="padding: 0px;" colspan="16">สรุปรายงานการเชือด</th>
                            </tr>
                            <tr class="text-center" style="background-color:#53eb0d;height:50px;">
                                <th class="text-center" style="padding: 0px;" colspan="4">รายการ</th>
                                <th class="text-center" style="padding: 0px;" colspan="4">น้ำหนักรวมเชือด</th>
                                <th class="text-center" style="padding: 0px;" colspan="4">น้ำหนักซากยกตัว</th>
                                <th class="text-center" style="padding: 0px;" colspan="4">น้ำหนักสาขา</th>
                        
                               
                               
                                
                            </tr>
                        </thead>  
                        <tbody> 
                            {{-- 1.นน.ต่อตัวเชือด  --}}
                            <tr class="text-center" style="background-color:#f8f7a5;height:50px;" >
                                <th class="text-center" style="padding: 0px;" colspan="4">1.นน.ต่อตัว</th>

                                <th class="text-center" style="padding: 0px;">จำนวน</th>
                                <th class="text-center" style="padding: 0px;">น้ำหนัก</th>
                                <th class="text-center" style="padding: 0px;">เฉลี่ย</th>
                                <th class="text-center" style="padding: 0px;">หมายเหตุ</th>

                                <th class="text-center" style="padding: 0px;">จำนวน</th>
                                <th class="text-center" style="padding: 0px;">น้ำหนัก</th>
                                <th class="text-center" style="padding: 0px;">เฉลี่ย</th>
                                <th class="text-center" style="padding: 0px;">หมายเหตุ</th>

                                <th class="text-center" style="padding: 0px;">จำนวน</th>
                                <th class="text-center" style="padding: 0px;">น้ำหนัก</th>
                                <th class="text-center" style="padding: 0px;">เฉลี่ย</th>
                                <th class="text-center" style="padding: 0px;">หมายเหตุ</th>
                            </tr>
                            <tr class="text-center" style="background-color:#fcfbe1;height:32px;" >
                                <td class="text-center" style="padding: 0px;" colspan="4">(ตัว)</td>

                                {{-- น้ำหนักรวมทั่งหมด --}}
                                <td class="text-center" style="padding: 0px;">
                                    <span style="color: rgb(17, 0, 255);"><b> {{ $sum_ov_unit }} </b></span>
                                </td>
                                <td class="text-center" style="padding: 0px;">{{ number_format( $sum_ov_unit * ($sum_ov_weight_r/$sum_ov_unit_r),2,'.',',') }} </td>
                                <td class="text-center" style="padding: 0px;">{{ number_format( $sum_ov_weight_r/$sum_ov_unit_r ,2,'.',',') }}</td>
                                <td></td>
                                {{-- น้ำหนักยกตัว --}}
                                <td>{{ $sum_body_unit_div }}</td>
                                <td>{{ number_format($sum_ov_weight_r/$sum_ov_unit_r,2,'.',',') }} </td>
                                {{-- <td>{{ number_format($sum_body_weight,2,'.',',') }}</td> --}}
                                <td>{{ number_format($sum_body_unit_div *($sum_ov_weight_r/$sum_ov_unit_r),2,'.',',') }}</td>
                                <td>น้ำหนักรวม {{ $sum_body_weight }}</td>
                                {{-- น้ำหนักสาขา --}}
                                <td>{{ $sum_ov_unit - $sum_body_unit_div }}</td>
                                <td>{{ number_format( ($sum_ov_unit-$sum_body_unit_div) * ($sum_ov_weight_r/$sum_ov_unit_r),2,'.',',') }}</td>
                                <td>{{ number_format( ($sum_ov_unit-$sum_body_unit_div) * ($sum_ov_weight_r/$sum_ov_unit_r)/($sum_ov_unit - $sum_body_unit_div) ,2,'.',',') }}</td>
                                <td></td>


                            </tr>   
                            {{-- 2.นน.ซากหลังเชือด(ก่อนแช่) --}}
                            <tr class="text-center" style="background-color:#ec9ee2;height:50px;" >
                                <th class="text-center" style="padding: 0px;" colspan="4">2.นน.ซากหลังเชือด(ก่อนแช่)</th>

                                <th class="text-center" style="padding: 0px;">จำนวน</th>
                                <th class="text-center" style="padding: 0px;">น้ำหนัก</th>
                                <th class="text-center" style="padding: 0px;">เฉลี่ย</th>
                                <th></th>

                                <th class="text-center" style="padding: 0px;">จำนวน</th>
                                <th class="text-center" style="padding: 0px;">น้ำหนัก</th>
                                <th class="text-center" style="padding: 0px;">เฉลี่ย</th>
                                <th></th>

                                <th class="text-center" style="padding: 0px;">จำนวน</th>
                                <th class="text-center" style="padding: 0px;">น้ำหนัก</th>
                                <th class="text-center" style="padding: 0px;">เฉลี่ย</th>
                                <th></th>

                            </tr>
                            <tr class="text-center" style="background-color:#f3d4ef;height:32px;" >
                                <td class="text-center" style="padding: 0px;" colspan="4">ซาก (ตัว)</td>

                                <td class="text-center" style="padding: 0px;">{{ $sum_ov_unit }}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format(($sum_ov_unit*($ov_list->sum_weight/$sum_unit_r)),2,'.',',')}}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format((( $ov_list->sum_weight)/$sum_unit_r),2,'.',',')}}</td>
                                <td></td>

                                <td>{{ $sum_body_unit_div }}</td>
                                <td>{{ number_format(($ov_list->sum_weight/$sum_unit_r)*$sum_body_unit_div,2,'.',',') }}</td>
                                <td>{{ number_format(($ov_list->sum_weight/$sum_unit_r),2,'.',',') }}</td>
                                <td>น้ำหนักรวม {{ $sum_body_weight }}</td>

                                <td>{{ $sum_ov_unit - $sum_body_unit_div }}</td>
                                <td>{{ number_format((($sum_ov_unit -$sum_body_unit_div )*($ov_list->sum_weight/$sum_unit_r)),2,'.',',')}}</td>
                                <td>{{ number_format(($ov_list->sum_weight/$sum_unit_r),2,'.',',') }}</td>
                                <td></td>



                            </tr>  
                            <tr class="text-center" style="background-color:#f3d4ef;height:32px;" >
                                <td class="text-center" style="padding: 0px;" colspan="4">หัว</td>



                                <td class="text-center" style="padding: 0px;">{{ $sum_ov_unit }}</td>                                
                                <td class="text-center" style="padding: 0px;">{{  number_format( $sum_ov_unit*($sum_head/$sum_unit_r),2,'.',',')}}</td>
                                <td class="text-center" style="padding: 0px;">{{  number_format($sum_head/$sum_unit_r,2,'.',',')}}</td>
                                <td></td>

                                <td class="text-center" style="padding: 0px;">{{ $sum_body_unit_div }}</td>                                
                                <td class="text-center" style="padding: 0px;">{{  number_format( $sum_body_unit_div *($sum_head/$sum_unit_r),2,'.',',')}}</td>
                                <td class="text-center" style="padding: 0px;">{{  number_format($sum_head/$sum_unit_r,2,'.',',')}}</td>
                                <td></td>

                                <td class="text-center" style="padding: 0px;">{{ $sum_ov_unit - $sum_body_unit_div }}</td>                                
                                <td class="text-center" style="padding: 0px;">{{  number_format( ($sum_ov_unit -$sum_body_unit_div) *($sum_head/$sum_unit_r),2,'.',',')}}</td>
                                <td class="text-center" style="padding: 0px;">{{  number_format($sum_head/$sum_unit_r,2,'.',',')}}</td>
                                <td></td>


                            </tr>                               
                            <tr class="text-center" style="background-color:#f3d4ef;height:32px;" >
                                <td class="text-center" style="padding: 0px;" colspan="4">เครื่องในแดง</td>



                                <td class="text-center" style="padding: 0px;">{{ $sum_ov_unit }}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format($sum_ov_unit*($sum_red/$sum_unit_r),2,'.',',') }}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format($sum_red/$sum_unit_r,2,'.',',') }}</td>
                                <td></td>

                                <td class="text-center" style="padding: 0px;">{{ $sum_body_unit_div  }}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format($sum_body_unit_div*($sum_red/$sum_unit_r),2,'.',',') }}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format($sum_red/$sum_unit_r,2,'.',',') }}</td>
                                <td></td>

                                <td class="text-center" style="padding: 0px;">{{ $sum_ov_unit - $sum_body_unit_div  }}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format(($sum_ov_unit - $sum_body_unit_div)*($sum_red/$sum_unit_r),2,'.',',') }}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format($sum_red/$sum_unit_r,2,'.',',') }}</td>
                                <td></td>


                            </tr>   
                            <tr class="text-center" style="background-color:#f3d4ef;height:32px;" >
                                <td class="text-center" style="padding: 0px;" colspan="4">เครืองในขาว</td>


                                <td class="text-center" style="padding: 0px;">{{ $sum_ov_unit }}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format($sum_ov_unit*($sum_white/$sum_unit_r),2,'.',',')}}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format($sum_white/$sum_unit_r,2,'.',',')}}</td>
                                <td></td>

                                <td class="text-center" style="padding: 0px;">{{ $sum_body_unit_div  }}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format($sum_body_unit_div *($sum_white/$sum_unit_r),2,'.',',')}}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format($sum_white/$sum_unit_r,2,'.',',')}}</td>
                                <td></td>

                                <td class="text-center" style="padding: 0px;">{{ $sum_ov_unit- $sum_body_unit_div  }}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format(($sum_ov_unit - $sum_body_unit_div) *($sum_white/$sum_unit_r),2,'.',',')}}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format($sum_white/$sum_unit_r,2,'.',',')}}</td>
                                <td></td>


                            </tr> 
                            <tr class="text-center" style="background-color:#f3d4ef;height:50px;" >
                                <td class="text-center" style="padding: 0px;" colspan="4">รวม นน.ซากหลังเชือด (ก่อนแช่)</td>
                                @php
                                    $final_sum_ov = ($sum_ov_unit*($ov_list->sum_weight/$sum_unit_r))+($sum_ov_unit*($sum_head/$sum_unit_r))+
                                                    ($sum_ov_unit*($sum_red/$sum_unit_r))+($sum_ov_unit*($sum_white/$sum_unit_r));   

                                    $diff1 = ( $sum_ov_unit * ($sum_ov_weight_r/$sum_ov_unit_r))- $final_sum_ov;

                                    $final_sum_ov_body = (($ov_list->sum_weight/$sum_unit_r)*$sum_body_unit_div) +( $sum_body_unit_div *($sum_head/$sum_unit_r))+
                                    ($sum_body_unit_div*($sum_red/$sum_unit_r))+($sum_body_unit_div *($sum_white/$sum_unit_r));
                                    $diff1_body = ( $sum_body_unit_div * ($sum_ov_weight_r/$sum_ov_unit_r))- $final_sum_ov_body;

                                    $final_sum_ov_bb = (($sum_ov_unit -$sum_body_unit_div )*($ov_list->sum_weight/$sum_unit_r))+(($sum_ov_unit -$sum_body_unit_div) *($sum_head/$sum_unit_r))+
                                    (($sum_ov_unit - $sum_body_unit_div)*($sum_red/$sum_unit_r))+(($sum_ov_unit - $sum_body_unit_div) *($sum_white/$sum_unit_r));
                                    $diff1_bb = ( ( $sum_ov_unit -$sum_body_unit_div) * ($sum_ov_weight_r/$sum_ov_unit_r))- $final_sum_ov_bb;

                                @endphp 
                                <td class="text-center" style="padding: 0px;">{{  $sum_ov_unit }}</td>
                                <td class="text-center" style="padding: 0px;">{{  number_format($final_sum_ov,2,'.',',') }} </td>
                                <td class="text-center" style="padding: 0px;">{{  number_format($final_sum_ov/$sum_ov_unit,2,'.',',') }}</td>
                                <td></td>

                                <td class="text-center" style="padding: 0px;">{{ $sum_body_unit_div }}</td>
                                <td class="text-center" style="padding: 0px;">{{  number_format($final_sum_ov_body,2,'.',',') }} </td>
                                @if( $sum_body_unit_div > 0 )
                                    <td class="text-center" style="padding: 0px;">{{  number_format($final_sum_ov/$sum_body_unit_div,2,'.',',') }}</td>
                                @else
                                    <td class="text-center" style="padding: 0px;">0</td> 
                                @endif
                                <td></td>

                                <td class="text-center" style="padding: 0px;">{{  $sum_ov_unit }}</td>
                                <td class="text-center" style="padding: 0px;">{{  number_format($final_sum_ov_bb,2,'.',',') }} </td>
                                <td class="text-center" style="padding: 0px;">{{  number_format($final_sum_ov/$sum_ov_unit,2,'.',',') }}</td>
                                <td></td>

                            </tr>  
                            {{-- ผลการสรุป นน.ซากหลังเชือด (ก่อนแช่) 1-2  --}}
                            <tr class="text-center" style="background-color:#ec9ee2;height:50px;" >
                                <td class="text-center" style="padding: 0px;" colspan="4">ผลการสรุป นน.ซากหลังเชือด (ก่อนแช่) 1-2</td>

                                <td class="text-center" style="padding: 0px;">{{ number_format( $sum_ov_unit * ($sum_ov_weight_r/$sum_ov_unit_r),2,'.',',') }} </td>
                                <td class="text-center" style="padding: 0px;">{{ number_format($final_sum_ov,2,'.',',') }}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format($diff1,2,'.',',') }}</td>
                                <td class="text-center" style="padding: 0px;">
                                    <span style="color: red;">{{ number_format(($diff1/($sum_ov_unit * ($sum_r_weight/$sum_r_unit))*100),2,'.',',') }} %</span>
                                </td>

                                <td class="text-center" style="padding: 0px;">{{ number_format( $sum_body_unit_div * ($sum_ov_weight_r/$sum_ov_unit_r),2,'.',',') }} </td>
                                <td class="text-center" style="padding: 0px;">{{ number_format($final_sum_ov_body,2,'.',',') }}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format($diff1_body,2,'.',',') }}</td>
                                <td class="text-center" style="padding: 0px;">
                                    @if($sum_body_unit_div>0)
                                    <span style="color: red;">{{ number_format(($diff1_body/($sum_body_unit_div * ($sum_r_weight/$sum_r_unit))*100),2,'.',',') }} %</span>
                                    @else
                                     0
                                    @endif
                                </td>

                                <td class="text-center" style="padding: 0px;">{{ number_format( ($sum_ov_unit-$sum_body_unit_div) * ($sum_ov_weight_r/$sum_ov_unit_r),2,'.',',') }} </td>
                                <td class="text-center" style="padding: 0px;">{{ number_format($final_sum_ov_bb,2,'.',',') }}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format($diff1_bb,2,'.',',') }}</td>
                                <td class="text-center" style="padding: 0px;">
                                    <span style="color: red;">{{ number_format(($diff1_bb/(($sum_ov_unit-$sum_body_unit_div ) * ($sum_r_weight/$sum_r_unit))*100),2,'.',',') }} %</span>
                                </td>
                            </tr> 
                            
                            {{-- 3. นน.ซากก่อนแกะ   --}}
                            <tr class="text-center" style="background-color:#ecd75c;height:50px;" >
                                <th class="text-center" style="padding: 0px;" colspan="4">3. นน.ซากก่อนแกะ </th>
                                <th class="text-center" style="padding: 0px;">จำนวน</th>
                                <th class="text-center" style="padding: 0px;">น้ำหนัก</th>
                                <th class="text-center" style="padding: 0px;">เฉลี่ย</th>
                                <th></th>

                                <th class="text-center" style="padding: 0px;">จำนวน</th>
                                <th class="text-center" style="padding: 0px;">น้ำหนัก</th>
                                <th class="text-center" style="padding: 0px;">เฉลี่ย</th>
                                <th></th>

                                <th class="text-center" style="padding: 0px;">จำนวน</th>
                                <th class="text-center" style="padding: 0px;">น้ำหนัก</th>
                                <th class="text-center" style="padding: 0px;">เฉลี่ย</th>
                                <th></th>

                            </tr> 
                            <tr class="text-center" style="background-color:#f8f1c8;height:32px;" >
                                <td class="text-center" style="padding: 0px;" colspan="4">ซาก (ตัว)</td>

                                <td class="text-center" style="padding: 0px;">{{ $sum_ov_unit }}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format($sum_ov_unit*($sum_ov_weight/$sum_ov_unit),2,'.','') }}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format($sum_ov_weight/$sum_ov_unit,2,'.','') }}</td>
                                <td></td>

                                <td class="text-center" style="padding: 0px;">{{ $sum_body_unit_div }}</td>
                                @if($sum_body_unit_div > 0)
                                    <td class="text-center" style="padding: 0px;">{{ number_format($sum_body_unit_div * ($sum_ov_weight/$sum_ov_unit),2,'.','') }}</td>
                                   
                                @else
                                    <td class="text-center" style="padding: 0px;">0.00</td>
                                   
                                @endif
                                   <td class="text-center" style="padding: 0px;">{{ number_format($sum_ov_weight/$sum_ov_unit,2,'.','') }}</td>
                                    <td></td>

                                <td class="text-center" style="padding: 0px;">{{ $sum_ov_unit-$sum_body_unit_div }}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format(($sum_ov_unit-$sum_body_unit_div)*($sum_ov_weight/$sum_ov_unit),2,'.','') }}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format($sum_ov_weight/$sum_ov_unit,2,'.','') }}</td>
                                <td></td>

                                
                            </tr>  
                            <tr class="text-center" style="background-color:#f8f1c8;height:32px;" >
                                <td class="text-center" style="padding: 0px;" colspan="4">หัว</td>

                                <td class="text-center" style="padding: 0px;">{{ $sum_ov_unit }}</td>
                                <td class="text-center" style="padding: 0px;">{{  number_format( $sum_ov_unit*($sum_head/$sum_unit_r),2,'.',',')}}</td>
                                <td class="text-center" style="padding: 0px;">{{  number_format($sum_head/$sum_unit_r,2,'.',',')}}</td>
                                <td></td>
             
                                <td class="text-center" style="padding: 0px;">{{ $sum_body_unit_div }}</td>
                                <td class="text-center" style="padding: 0px;">{{  number_format( $sum_body_unit_div*($sum_head/$sum_unit_r),2,'.',',')}}</td>
                                <td class="text-center" style="padding: 0px;">{{  number_format($sum_head/$sum_unit_r,2,'.',',')}}</td>
                                <td></td>
             
                                <td class="text-center" style="padding: 0px;">{{ $sum_ov_unit-$sum_body_unit_div }}</td>
                                <td class="text-center" style="padding: 0px;">{{  number_format( ($sum_ov_unit-$sum_body_unit_div)*($sum_head/$sum_unit_r),2,'.',',')}}</td>
                                <td class="text-center" style="padding: 0px;">{{  number_format($sum_head/$sum_unit_r,2,'.',',')}}</td>
                                <td></td>
             
             
                            </tr>                               
                            <tr class="text-center" style="background-color:#f8f1c8;height:32px;" >
                                <td class="text-center" style="padding: 0px;" colspan="4">เครื่องในแดง</td>

                                <td class="text-center" style="padding: 0px;">{{ $sum_ov_unit }}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format($sum_ov_unit*($sum_red/$sum_unit_r),2,'.',',') }}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format($sum_red/$sum_unit_r,2,'.',',') }}</td>
                                <td></td>

                                <td class="text-center" style="padding: 0px;">{{ $sum_body_unit_div }}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format($sum_body_unit_div*($sum_red/$sum_unit_r),2,'.',',') }}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format($sum_red/$sum_unit_r,2,'.',',') }}</td>
                                <td></td>

                                <td class="text-center" style="padding: 0px;">{{ $sum_ov_unit -$sum_body_unit_div }}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format(($sum_ov_unit-$sum_body_unit_div)*($sum_red/$sum_unit_r),2,'.',',') }}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format($sum_red/$sum_unit_r,2,'.',',') }}</td>
                                <td></td>

                            </tr>   
                            <tr class="text-center" style="background-color:#f8f1c8;height:32px;" >
                                <td class="text-center" style="padding: 0px;" colspan="4">เครืองในขาว</td>

                                <td class="text-center" style="padding: 0px;">{{ $sum_ov_unit }}</td> 
                                <td class="text-center" style="padding: 0px;">{{ number_format($sum_ov_unit*($sum_white/$sum_unit_r),2,'.',',')}}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format($sum_white/$sum_unit_r,2,'.',',')}}</td>
                                <td></td>

                                <td class="text-center" style="padding: 0px;">{{ $sum_body_unit_div }}</td> 
                                <td class="text-center" style="padding: 0px;">{{ number_format($sum_body_unit_div *($sum_white/$sum_unit_r),2,'.',',')}}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format($sum_white/$sum_unit_r,2,'.',',')}}</td>
                                <td></td>

                                <td class="text-center" style="padding: 0px;">{{ $sum_ov_unit- $sum_body_unit_div }}</td> 
                                <td class="text-center" style="padding: 0px;">{{ number_format(($sum_ov_unit - $sum_body_unit_div)*($sum_white/$sum_unit_r),2,'.',',')}}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format($sum_white/$sum_unit_r,2,'.',',')}}</td>
                                <td></td>
                            </tr> 
                            <tr class="text-center" style="background-color:#b4c0f1;height:50px;" >
                                <td class="text-center" style="padding: 0px;" colspan="4">รวม นน.ซากก่อนแกะ (หลังแช่)</td>
                                @php
                                    $final_sum_ov2 = ($sum_ov_unit*($sum_ov_weight/$sum_ov_unit))+($sum_ov_unit*($sum_head/$sum_unit_r))+
                                                    ($sum_ov_unit*($sum_red/$sum_unit_r))+($sum_ov_unit*($sum_white/$sum_unit_r));   
                                    $diff2 =  $final_sum_ov  - $final_sum_ov2;

                                    $final_sum_ov2_body = ($sum_body_unit_div*($sum_ov_weight/$sum_ov_unit))+($sum_body_unit_div*($sum_head/$sum_unit_r))+
                                                    ($sum_body_unit_div*($sum_red/$sum_unit_r))+($sum_body_unit_div*($sum_white/$sum_unit_r));   
                                    $diff2_body =  $final_sum_ov_body  - $final_sum_ov2_body;
                                    

                                    $final_sum_ov2_bb = (($sum_ov_unit-$sum_body_unit_div )*($sum_ov_weight/$sum_ov_unit))+(($sum_ov_unit-$sum_body_unit_div)*($sum_head/$sum_unit_r))+
                                                    (($sum_ov_unit-$sum_body_unit_div)*($sum_red/$sum_unit_r))+(($sum_ov_unit-$sum_body_unit_div)*($sum_white/$sum_unit_r));   
                                    $diff2_bb =  $final_sum_ov_bb  - $final_sum_ov2_bb;

                                @endphp 
                                <td class="text-center" style="padding: 0px;">{{ $sum_ov_unit }}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format(($final_sum_ov2/$sum_ov_unit),2,'.',',') }}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format($final_sum_ov2,2,'.',',')   }}</td>
                                <td></td>

                                <td class="text-center" style="padding: 0px;">{{ $sum_body_unit_div }}</td>
                                @if($sum_body_unit_div > 0 )   
                                    <td class="text-center" style="padding: 0px;">{{ number_format(($final_sum_ov2_body/$sum_body_unit_div),2,'.',',') }}</td>
                                @else
                                    <td class="text-center" style="padding: 0px;">0</td>
                                @endif  
                                <td class="text-center" style="padding: 0px;">{{ number_format($final_sum_ov2_body,2,'.',',')   }}</td>
                                <td></td>

                                <td class="text-center" style="padding: 0px;">{{ $sum_ov_unit-$sum_body_unit_div }}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format(($final_sum_ov2_bb/($sum_ov_unit-$sum_body_unit_div)),2,'.',',') }}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format($final_sum_ov2_bb,2,'.',',')   }}</td>
                                <td></td>

                            </tr>  
                            {{-- ผลการสรุป นน.ก่อนแกะ (หลังแช่) 2-3 --}}
                            <tr class="text-center" style="background-color:#dddfe7;height:32px;" >
                                <td class="text-center" style="padding: 0px;" colspan="4">ผลการสรุป นน.ก่อนแกะ (หลังแช่) 2-3</td>

                                <td class="text-center" style="padding: 0px;">{{number_format($final_sum_ov,2,'.',',') }}</td>
                                <td class="text-center" style="padding: 0px;">{{number_format($final_sum_ov2,2,'.',',') }}</td>
                                <td class="text-center" style="padding: 0px;">{{number_format($diff2,2,'.',',')  }}</td>
                                <td class="text-center" style="padding: 0px;">
                                    <span style="color: red;">{{ number_format(($diff2/$final_sum_ov)*100,2,'.',',') }} %</span>
                                </td>
                                {{-- ฆ่ายกตัว --}}
                                <td class="text-center" style="padding: 0px;">{{number_format($final_sum_ov_body,2,'.',',') }}</td>
                                <td class="text-center" style="padding: 0px;">{{number_format($final_sum_ov2_body,2,'.',',') }}</td>
                                <td class="text-center" style="padding: 0px;">{{number_format($diff2_body,2,'.',',')  }}</td>
                                <td class="text-center" style="padding: 0px;">
                                    @if($final_sum_ov_body > 0)
                                        <span style="color: red;">{{ number_format(($diff2_body/$final_sum_ov_body)*100,2,'.',',') }} %</span>
                                    @else
                                    <span style="color: red;">0</span>
                                    @endif
                                </td>
                                {{-- หมูสาขา --}}
                                <td class="text-center" style="padding: 0px;">{{number_format($final_sum_ov_bb,2,'.',',') }}</td>
                                <td class="text-center" style="padding: 0px;">{{number_format($final_sum_ov2_bb,2,'.',',') }}</td>
                                <td class="text-center" style="padding: 0px;">{{number_format($diff2_bb,2,'.',',')  }}</td>
                                <td class="text-center" style="padding: 0px;">
                                    @if( $final_sum_ov_bb>0)
                                        <span style="color: red;">{{ number_format(($diff2_bb/$final_sum_ov_bb)*100,2,'.',',') }} %</span>
                                    @else
                                    <span style="color: red;">0</span>
                                    @endif
                                </td>
                            </tr> 
                        
                            {{-- 4. นน.ซากหลังแกะ   --}}
                            <tr class="text-center" style="background-color:#53f10a;height:50px;" >
                                <th class="text-center" style="padding: 0px;" colspan="4">4. นน.ซากหลังแกะ  </th>

                                <th class="text-center" style="padding: 0px;">จำนวน</th>
                                <th class="text-center" style="padding: 0px;">น้ำหนัก</th>
                                <th class="text-center" style="padding: 0px;">เฉลี่ย</th>
                                <th></th>

                                <th class="text-center" style="padding: 0px;">จำนวน</th>
                                <th class="text-center" style="padding: 0px;">น้ำหนัก</th>
                                <th class="text-center" style="padding: 0px;">เฉลี่ย</th>
                                <th></th>

                                <th class="text-center" style="padding: 0px;">จำนวน</th>
                                <th class="text-center" style="padding: 0px;">น้ำหนัก</th>
                                <th class="text-center" style="padding: 0px;">เฉลี่ย</th>
                                <th></th>
                            </tr>
                            <tr class="text-center" style="background-color:#bef1a7;height:32px;" >
                                <td class="text-center" style="padding: 0px;" colspan="4">ซาก(ตัว)</td>

                                <td class="text-center" style="padding: 0px;">{{ $sum_ov_unit }}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format($sum_cl_weight-$H_W,2,'.',',') }}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format(($sum_cl_weight-$H_W)/($sum_ov_unit),2,'.',',') }}</td>
                                <td></td>

                                <td class="text-center" style="padding: 0px;">{{ $sum_body_unit_div }}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format((($sum_cl_weight-$H_W)/($sum_ov_unit))*$sum_body_unit_div,2,'.',',') }}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format(($sum_cl_weight-$H_W)/($sum_ov_unit),2,'.',',') }}</td>
                                <td></td>

                                <td class="text-center" style="padding: 0px;">{{ $sum_ov_unit - $sum_body_unit_div}}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format((($sum_cl_weight-$H_W)/($sum_ov_unit)*($sum_ov_unit -$sum_body_unit_div)),2,'.',',') }}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format(($sum_cl_weight-$H_W)/($sum_ov_unit),2,'.',',') }}</td>
                                <td></td>

                            </tr>   
                            <tr class="text-center" style="background-color:#bef1a7;height:32px;" >
                                <td class="text-center" style="padding: 0px;" colspan="4"> หัว</td>

                                <td class="text-center" style="padding: 0px;">{{ $sum_ov_unit }}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format($H_W,2,'.',',') }}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format($H_W/$sum_ov_unit,2,'.',',') }}</td>
                                <td></td>

                                <td class="text-center" style="padding: 0px;">{{ $sum_body_unit_div }}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format(($H_W/$sum_ov_unit)*$sum_body_unit_div,2,'.',',') }}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format($H_W/$sum_ov_unit,2,'.',',') }}</td>
                                <td></td>

                                <td class="text-center" style="padding: 0px;">{{ $sum_ov_unit-$sum_body_unit_div }}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format(($H_W/$sum_ov_unit)*($sum_ov_unit-$sum_body_unit_div),2,'.',',') }}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format($H_W/$sum_ov_unit,2,'.',',') }}</td>
                                <td></td>
                            </tr>                                
                            <tr class="text-center" style="background-color:#bef1a7;height:32px;" >
                                <td class="text-center" style="padding: 0px;" colspan="4">เครื่องในแดง</td>

                                <td class="text-center" style="padding: 0px;">{{ $sum_ov_unit }}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format($sum_of_r,2,'.',',') }}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format($sum_of_r/$sum_ov_unit,2,'.',',') }}</td>
                                <td></td>

                                <td class="text-center" style="padding: 0px;">{{ $sum_body_unit_div }}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format(($sum_of_r/$sum_ov_unit)*$sum_body_unit_div,2,'.',',') }}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format($sum_of_r/$sum_ov_unit,2,'.',',') }}</td>
                                <td></td>

                                <td class="text-center" style="padding: 0px;">{{ $sum_ov_unit - $sum_body_unit_div }}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format(($sum_of_r/$sum_ov_unit)*($sum_ov_unit - $sum_body_unit_div),2,'.',',') }}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format($sum_of_r/$sum_ov_unit,2,'.',',') }}</td>
                                <td></td>
                            </tr>   
                            <tr class="text-center" style="background-color:#bef1a7;height:32px;" >
                                <td class="text-center" style="padding: 0px;" colspan="4">เครืองในขาว</td>

                                <td class="text-center" style="padding: 0px;">{{ $sum_ov_unit }}</td>
                                <td class="text-center" style="padding: 0px;">{{  number_format($sum_of_w,2,'.',',') }}</td>
                                <td class="text-center" style="padding: 0px;">{{  number_format($sum_of_w/$sum_ov_unit,2,'.',',') }}</td>
                                <td></td>

                                <td class="text-center" style="padding: 0px;">{{ $sum_body_unit_div }}</td>
                                <td class="text-center" style="padding: 0px;">{{  number_format(($sum_of_w/$sum_ov_unit)*$sum_body_unit_div,2,'.',',') }}</td>
                                <td class="text-center" style="padding: 0px;">{{  number_format($sum_of_w/$sum_ov_unit,2,'.',',') }}</td>
                                <td></td>

                                <td class="text-center" style="padding: 0px;">{{ $sum_ov_unit -$sum_body_unit_div }}</td>
                                <td class="text-center" style="padding: 0px;">{{  number_format(($sum_of_w/$sum_ov_unit)*($sum_ov_unit -$sum_body_unit_div),2,'.',',') }}</td>
                                <td class="text-center" style="padding: 0px;">{{  number_format($sum_of_w/$sum_ov_unit,2,'.',',') }}</td>
                                <td></td>
                            </tr> 
                            <tr class="text-center" style="background-color:#bef1a7;height:50px;" >
                                <td class="text-center" style="padding: 0px;" colspan="4">รวม นน.ซากหลังแกะ</td>

                                <td class="text-center" style="padding: 0px;">{{ $sum_ov_unit }}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format($sum_cl_weight+$sum_of_r+$sum_of_w,2,'.',',') }}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format((($sum_cl_weight+$sum_of_r+$sum_of_w)/$sum_ov_unit),2,'.',',') }}</td>
                                <td></td>

                                
                                <td class="text-center" style="padding: 0px;">{{ $sum_body_unit_div }}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format((($sum_cl_weight+$sum_of_r+$sum_of_w)/$sum_ov_unit)*$sum_body_unit_div,2,'.',',') }}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format((($sum_cl_weight+$sum_of_r+$sum_of_w)/$sum_ov_unit),2,'.',',') }}</td>
                                <td></td>

                                
                                <td class="text-center" style="padding: 0px;">{{ $sum_ov_unit -$sum_body_unit_div }}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format((($sum_cl_weight+$sum_of_r+$sum_of_w)/$sum_ov_unit)*($sum_ov_unit -$sum_body_unit_div),2,'.',',') }}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format((($sum_cl_weight+$sum_of_r+$sum_of_w)/$sum_ov_unit),2,'.',',') }}</td>
                                <td></td>

                            </tr>  
                            {{-- ผลการสรุป นน.ซากหลังแกะ (ก่อนแช่) 3-4  --}}
                            <tr class="text-center" style="background-color:#63f71e;height:50px;" >
                                <td class="text-center" style="padding: 0px;" colspan="4">ผลการสรุป นน.ซากหลังแกะ (ก่อนแช่) 3-4</td>

                                <td class="text-center" style="padding: 0px;">{{ number_format($final_sum_ov2,2,'.',',') }}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format($sum_cl_weight+$sum_of_r+$sum_of_w,2,'.',',') }}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format($final_sum_ov2-$sum_cl_weight,2,'.',',') }}</td>
                                <td class="text-center" style="padding: 0px;">
                                    <span style="color: red;">{{ number_format((($final_sum_ov2-($sum_cl_weight+$sum_of_r+$sum_of_w ))/$final_sum_ov2)*100,2,'.',',') }} %</span>
                                </td>

                                <td class="text-center" style="padding: 0px;">{{ number_format($final_sum_ov2_body,2,'.',',') }}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format($sum_body_weight,2,'.',',') }}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format($final_sum_ov2_body-$sum_body_weight,2,'.',',') }}</td>
                                <td class="text-center" style="padding: 0px;">
                                    @if($final_sum_ov2_body) 
                                        <span style="color: red;">{{ number_format((($final_sum_ov2_body-$sum_body_weight)/$final_sum_ov2_body)*100,2,'.',',') }} %</span>
                                    @else
                                    <span style="color: red;">0</span>
                                    @endif
                                </td>

                                <td class="text-center" style="padding: 0px;">{{ number_format($final_sum_ov2_bb,2,'.',',') }}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format(($sum_cl_weight+$sum_of_r+$sum_of_w)-$sum_body_weight,2,'.',',') }}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format($final_sum_ov2_bb-(($sum_cl_weight+$sum_of_r+$sum_of_w)-$sum_body_weight),2,'.',',') }}</td>
                                <td class="text-center" style="padding: 0px;">
                                    <span style="color: red;">{{ number_format((($final_sum_ov2_bb-(($sum_cl_weight+$sum_of_r+$sum_of_w)-$sum_body_weight ))/$final_sum_ov2_bb)*100,2,'.',',') }} %</span>
                                </td>
                            </tr> 
                    


                            {{-- -- สิ้นสุด ส่วนหาค่า เฉลี่ยน น้ำหนักหมู -- --}}
                        </tbody>  
                    </table>   
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-5 col-lg-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-header header-sm d-flex justify-content-between align-items-center">
                <h1 class="card-title text-center">สรุปรายงานตัดแต่งสุกร แยกกลุ่ม</h1>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="tb1" width="100%" border="1">  
                        <thead>
                            <tr class="text-center" style="background-color:#516fe6;height:32px;">
                                <th class="text-center" style="padding: 0px;" >กลุ่ม</th>
                                <th class="text-center" style="padding: 0px;" >รายการ</th>
                                <th class="text-center" style="padding: 0px;">จำนวน</th>
                                <th class="text-center" style="padding: 0px;">น้ำหนัก</th>
                                <th class="text-center" style="padding: 0px;">เฉลี่ย</th>
                            </tr>
                        </thead>  
                        <tbody> 
                            <tr class="text-center" style="background-color:#b4c0f1;height:32px;" >
                                <td class="text-center" style="padding: 0px;" >กลุ่ม 1</td>
                                <td class="text-center" style="padding: 0px;" >เนื้องแดง</td>
                                <td class="text-center" style="padding: 0px;">{{ $GU1 }}</td>
                                <td class="text-center" style="padding: 0px;">{{ $G1 }}</td>
                                @if($GU1>0)
                                <td class="text-center" style="padding: 0px;">{{ number_format(($G1/$GU1),2,'.',',') }}</td>
                                @else
                                <td class="text-center" style="padding: 0px;">0</td>
                                @endif
                            </tr> 
                            <tr class="text-center" style="background-color:#b4c0f1;height:32px;" >
                                <td class="text-center" style="padding: 0px;" >กลุ่ม 2</td>
                                <td class="text-center" style="padding: 0px;" >หนัง</td>
                                <td class="text-center" style="padding: 0px;">{{ $GU2 }}</td>
                                <td class="text-center" style="padding: 0px;">{{ $G2 }}</td>
                                @if($GU2>0)
                                <td class="text-center" style="padding: 0px;">{{ number_format(($G2/$GU2),2,'.',',') }}</td>
                                @else
                                <td class="text-center" style="padding: 0px;">0</td>
                                @endif
                            </tr> 
                            <tr class="text-center" style="background-color:#b4c0f1;height:32px;" >
                                <td class="text-center" style="padding: 0px;" >กลุ่ม 3</td>
                                <td class="text-center" style="padding: 0px;" >เครื่องในขาว-แดง</td>
                                <td class="text-center" style="padding: 0px;">{{ $GU3 }}</td>
                                <td class="text-center" style="padding: 0px;">{{ $G3 }}</td>
                                @if($GU3>0)
                                <td class="text-center" style="padding: 0px;">{{ number_format(($G3/$GU3),2,'.',',') }}</td>
                                @else
                                <td class="text-center" style="padding: 0px;">0</td>
                                @endif
                            </tr> 
                            <tr class="text-center" style="background-color:#b4c0f1;height:32px;" >
                                <td class="text-center" style="padding: 0px;" >กลุ่ม 4</td>
                                <td class="text-center" style="padding: 0px;" >ขา-กระดูก</td>
                                <td class="text-center" style="padding: 0px;">{{ $GU4 }}</td>
                                <td class="text-center" style="padding: 0px;">{{ $G4 }}</td>
                                @if($GU4>0)
                                <td class="text-center" style="padding: 0px;">{{ number_format(($G4/$GU4),2,'.',',') }}</td>
                                @else
                                <td class="text-center" style="padding: 0px;">0</td>
                                @endif
                            </tr> 
                            <tr class="text-center" style="background-color:#b4c0f1;height:32px;" >
                                <td class="text-center" style="padding: 0px;" >กลุ่ม 5</td>
                                <td class="text-center" style="padding: 0px;" >หัว</td>
                                <td class="text-center" style="padding: 0px;">{{ $GU5}}</td>
                                <td class="text-center" style="padding: 0px;">{{ $G5 }}</td>
                                @if($GU5>0)
                                <td class="text-center" style="padding: 0px;">{{ number_format(($G5/$GU5),2,'.',',') }}</td>
                                @else
                                <td class="text-center" style="padding: 0px;">0</td>
                                @endif
                            </tr> 
                            <tr class="text-center" style="background-color:#b4c0f1;height:32px;" >
                                <td class="text-center" style="padding: 0px;" >กลุ่ม 6</td>
                                <td class="text-center" style="padding: 0px;" >ท่อน</td>
                                <td class="text-center" style="padding: 0px;">{{ $GU6 }}</td>
                                <td class="text-center" style="padding: 0px;">{{ $G6 }}</td>
                                @if($GU6>0)
                                <td class="text-center" style="padding: 0px;">{{ number_format(($G6/$GU6),2,'.',',') }}</td>
                                @else
                                <td class="text-center" style="padding: 0px;">0</td>
                                @endif
                            </tr> 
                            <tr class="text-center" style="background-color:#b4c0f1;height:32px;" >
                                <td class="text-center" style="padding: 0px;" >กลุ่ม 7</td>
                                <td class="text-center" style="padding: 0px;" >แปรรูป</td>
                                <td class="text-center" style="padding: 0px;">{{ $GU7 }}</td>
                                <td class="text-center" style="padding: 0px;">{{ $G7 }}</td>
                                @if($GU7>0)
                                <td class="text-center" style="padding: 0px;">{{number_format(($G7/$GU7),2,'.',',') }}</td>
                                @else
                                <td class="text-center" style="padding: 0px;">0</td>
                                @endif
                            </tr> 
                            <tr class="text-center" style="background-color:#b4c0f1;height:32px;" >
                                <td class="text-center" style="padding: 0px;" >กลุ่ม 8</td>
                                <td class="text-center" style="padding: 0px;" >น้ำมัน</td>
                                <td class="text-center" style="padding: 0px;">{{ $GU8 }}</td>
                                <td class="text-center" style="padding: 0px;">{{ $G8 }}</td>
                                @if($GU8>0)
                                <td class="text-center" style="padding: 0px;">{{number_format(($G8/$GU8),2,'.',',') }}</td>
                                @else
                                <td class="text-center" style="padding: 0px;">0</td>
                                @endif
                            </tr> 
                            <tr class="text-center" style="background-color:#b4c0f1;height:32px;" >
                                <td class="text-center" style="padding: 0px;" >กลุ่ม 9</td>
                                <td class="text-center" style="padding: 0px;" >หัวชุด</td>
                                <td class="text-center" style="padding: 0px;">{{ $GU9 }}</td>
                                <td class="text-center" style="padding: 0px;">{{ $G9 }}</td>
                                @if($GU9>0)
                                <td class="text-center" style="padding: 0px;">{{number_format(($G9/$GU9),2,'.',',') }}</td>
                                @else
                                <td class="text-center" style="padding: 0px;">0</td>
                                @endif
                            </tr> 
                            <tr class="text-center" style="background-color:#b4c0f1;height:32px;" >
                                <td class="text-center" style="padding: 0px;" >กลุ่ม 10</td>
                                <td class="text-center" style="padding: 0px;" >อื่น ๆ</td>
                                <td class="text-center" style="padding: 0px;">{{ $GU10 }}</td>
                                <td class="text-center" style="padding: 0px;">{{ $G10 }}</td>
                                @if($GU10>0)
                                <td class="text-center" style="padding: 0px;">{{number_format(($G10/$GU10),2,'.',',') }}</td>
                                @else
                                <td class="text-center" style="padding: 0px;">0</td>
                                @endif
                            </tr> 
                            @php
                                $GG = $G1+$G2+$G3+$G4+$G5+$G6+$G7+$G8+$G9+$G10;

                            @endphp
                            <tr class="text-center" style="background-color:#849bf3;height:32px;" >
                                <th class="text-center" style="padding: 0px;" ></th>
                                <th class="text-center" style="padding: 0px;" >รวม</th> 
                                <th class="text-center" style="padding: 0px;"></th>
                                <th class="text-center" style="padding: 0px;">{{number_format( $GG,2,'.',',') }}</th>
                                <th class="text-center" style="padding: 0px;"></th>
                            </tr>   
                        </tbody>
                    </table>
                </div>
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