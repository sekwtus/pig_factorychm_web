@extends('layouts.master')
@section('style')
<style type="text/css">
    .input{
            height: 50%;
            background-color: aqua;
    }
    th,td{
        padding: 0px;
    }
    .bodyzoom{
    zoom: 0.9;
}
</style>

<link rel="stylesheet" href="{{ url('https://cdn.datatables.net/1.10.18/css/dataTables.semanticui.min.css') }}" type="text/css" />
{{-- <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" /> --}}
<link rel="stylesheet" href="{{ asset('assets/css/daterangepicker.css')}}">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" />

@endsection
@section('main')
              <div class="col-lg-12 grid-margin bodyzoom">
                <div class="card">
                  <div class="card-body">
                    {{-- <h2 class="text-center" style="margin-bottom: 0px;height: 0px;">รายงานตรวจสอบน้ำหนักชิ้นส่วนสุกรในกระบวนการผลิต <span style="color:red;">
                         สาขา {{ $select_order_result[0]->shop_name=='' ? '' : $select_order_result[0]->shop_name }}</span></h2><br><br> --}}
                         
                        <div class="row">
                            <div class="col-2">
                                <a class="btn btn-primary" target="_blank" href="../summary_weighing_receive/{{ $order_recieve }}" >
                                    หมูขุน/ซีก  {{ $order_recieve }}
                                </a>
                            </div>
                            <div class="col-8 text-left">
                                @foreach ($select_cutting_number as $btnCL)
                                    @if ($btnCL->order_cutting_number != null)
                                    <a class="btn " style="background-color:#ffffaa; border-color:#7d7d00;" target="_blank" href="../summary_weighing_cutting/{{ $btnCL->order_cutting_number }}" >
                                        ชิ้นส่วน {{ $btnCL->order_cutting_number }}
                                    </a>
                                    @endif
                                @endforeach
                            </div>
                            <div class="col-2 text-right">
                                <a class="btn btn-success" target="_blank" href="../report_transport_pdf/pdf_make/{{ $select_cutting_number[0]->order_number }}"  style="margin-bottom: 10px;">
                                    <i class="fa fa-print">พิมพ์</i>
                                </a>
                                <a class="btn btn-success" data-toggle="modal" id="adder" data-target="#adding" style="margin-bottom: 10px;" >
                                    <i class="mdi mdi-plus"></i>
                                </a><br>
                            </div>

                            <div class="col-2 ">
                            </div>
                            <div class="col-8 text-left">
                                @foreach ($select_cutting_number as $btnOF)
                                    @if ($btnOF->order_offal_number != null)
                                    <a class="btn " style="background-color:#ccffe6;  border-color:#00a653;" target="_blank" href="../summary_weighing_offal/{{  $btnOF->order_offal_number }}" >
                                        เครื่องใน  {{ $btnOF->order_offal_number }}
                                    </a>
                                    @endif
                                @endforeach
                            </div>
                            <div class="col-2 text-right">
                                <a class="btn btn-danger" id="ended" onclick="ended_order('{{ $select_cutting_number[0]->order_number }}')" style="margin-bottom: 10px;" >
                                    <i class="mdi mdi-stop">จบการทำงาน</i>
                                </a>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 px-0">
                            {{ Form::open(['method' => 'post' , 'url' => '/report_transport/check']) }}   
                                <table id="tbl-3" class="tbl table-hover" width="100%" border="1">
                                    <thead>
                                        <tr class="bg-secondary text-center"  ><th colspan="19" style=" padding: 0px;"><h4> รายงานตรวจสอบน้ำหนักชิ้นส่วนสุกรในกระบวนการผลิต
                                            <span style="color:red;">{{ $select_cutting_number[0]->id_user_customer =='' ? '' : $select_cutting_number[0]->id_user_customer }}</span>
                                            วันที่ <span style="color:red;">{{ $select_cutting_number[0]->date_transport == '' ? '' : substr($select_cutting_number[0]->date_transport,0,2).'/'.substr($select_cutting_number[0]->date_transport,3,2).'/'.substr($select_cutting_number[0]->date_transport,6,4) }} </span>
                                            เลขที่บิล <span style="color:red;">{{ $select_cutting_number[0]->order_number }}
                                                <input type="text" hidden name="tr_number" value="{{ $select_cutting_number[0]->order_number }}">
                                            </span> </h4></th>
                                            <th colspan="3">ทะเบียนรถ .......</th>
                                            <th colspan="2">อุณหภูมิรถ .......</th>
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
                                            {{-- <th class="text-center" style="padding: 0px;">ตรวจสอบ</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>

                                    {{-- ตัดแต่ง --}}
                                    @php 
                                        $sum_weight = 0;
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
                                                                <td class="text-center" style="padding: 0px; width: 50px;"><a href="#"  data-toggle="modal" data-target="#edit" id="x{{ $in_order->id }}" onclick="editRecord('{{ $in_order->id }}')" >{{ $in_order->sku_weight }}</a></td>
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
                                                {{-- <td class="text-center" style="padding: 0px; width: 40px;" rowspan="{{ $span }}">
                                                    @foreach ($report_transport_check as $transport_check)
                                                        @if ($transport_check->item_code == $result->item_code)
                                                            <input type="number" hidden id="code_check[]" name="code_check[]" value="{{ $result->item_code }}" style=" padding: 0px; width: 45px; height: auto;">
                                                            <input type="number" id="unit_check[]" name="unit_check[]" value="{{ $transport_check->check_unit }}" style=" padding: 0px; width: 45px; height: auto;">
                                                        @endif
                                                    @endforeach
                                                </td> --}}
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
                                                        <td class="text-center" style="padding: 0px; width: 50px;"><a href="#" data-toggle="modal" data-target="#edit" onclick="editRecord('{{ $in_order->id }}')" > {{ $in_order->sku_weight }} </a></td>
                                                        @php $i = $i-1; @endphp
                                                    @endif
                                                        
                                                @endforeach
                                                @for ($j= 0; $j < $i+1; $j++)
                                                    <td class="text-center" style="padding: 0px; width: 50px;"></td>  
                                                @endfor
                                            <td hidden class="text-center" style="padding: 0px;"></td>
                                            <td hidden class="text-center" style="padding: 0px;"></td>
                                            {{-- <td hidden class="text-center" style="padding: 0px;"></td> --}}
                                        </tr>
                                        @endfor
                                    @endforeach
                                    {{-- รวมตัดแต่ง --}}
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
                                        <td class="text-center" style="padding: 0px;" ></td>
                                        
                                        <td class="text-center" style="padding: 0px;" ><b>{{ $sum_weight }}</b></td>
                                        <td class="text-center" style="padding: 0px;" ><b>{{ $sum_unit }}</b></td>
                                        {{-- <td class="text-center" style="padding: 0px;" ><b></b></td> --}}
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
                                                                <td class="text-center" style="padding: 0px; width: 50px;"><a href="#"  data-toggle="modal" data-target="#edit" onclick="editRecord('{{ $in_order->id }}')" >{{ $in_order->sku_weight }}</a></td>
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
                                                {{-- <td class="text-center" style="padding: 0px; width: 40px;" rowspan="{{ $span }}">
                                                    @foreach ($report_transport_check as $transport_check)
                                                        @if ($transport_check->item_code == $result->item_code)
                                                            <input type="number" hidden id="code_check[]" name="code_check[]" value="{{ $result->item_code }}" style=" padding: 0px; width: 45px; height: auto;">
                                                            <input type="number" id="unit_check[]" name="unit_check[]" value="{{ $transport_check->check_unit }}" style=" padding: 0px; width: 45px; height: auto;">
                                                        @endif
                                                    @endforeach
                                                </td> --}}
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
                                                        <td class="text-center" style="padding: 0px; width: 50px;"><a href="#" data-toggle="modal" data-target="#edit" onclick="editRecord('{{ $in_order->id }}')" > {{ $in_order->sku_weight }} </a></td>
                                                        @php $i = $i-1; @endphp
                                                    @endif
                                                        
                                                @endforeach
                                                @for ($j= 0; $j < $i+1; $j++)
                                                    <td class="text-center" style="padding: 0px; width: 50px;"></td>  
                                                @endfor
                                            <td hidden class="text-center" style="padding: 0px;"></td>
                                            <td hidden class="text-center" style="padding: 0px;"></td>
                                            {{-- <td hidden class="text-center" style="padding: 0px;"></td> --}}
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
                                        {{-- <td class="text-center" style="padding: 0px;" ></td> --}}
                                    </tr>

                                        @php
                                            $sum_weight_tf = 0;
                                            $sum_unit_tf =0; 
                                        @endphp

                                        {{-- สรุปรวมทั้งหมด --}}
                                        <tr style="background-color:#ff847d;">
                                            <td class="text-center" style="padding: 0px; height: 40px;" ></td>
                                            <td class="text-center" style="padding: 0px;" ><b>รวมทั้งหมด </b></td>

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
                                            {{-- <td class="text-center" style="padding: 0px;" ><b></b></td> --}}
                                        </tr>
                        
                                        <tr>
                                            <td class="text-center"></td>
                                            <td class="text-center" colspan="4">น้ำหนักชิ้นส่วนรวมทั้งหมด  {{ $sum_weight + $sum_weight_offal }} KG <br> จำนวนตะกร้าที่ใช้ {{ $sum_unit + $sum_unit_offal}} ใบ </td>
                                            <td class="text-center"></td>
                                            <td class="text-center" colspan="5">สรุปจำนวนถุงเทียบกับรายงาน</td>
                                            <td class="text-center"></td>
                                            <td class="text-center" colspan="5">สรุปจำนวนที่นับได้ก่อนออกจากโรงงานเทียบกับโหลด</td>
                                            <td class="text-center"></td>
                                            <td class="text-center" colspan="5">สรุปจำนวนที่นับเมื่อถึงร้านเทียบกับก่อนออกจากโรงงาน</td>
                                            <td class="text-center"></td>
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
                                            {{-- <td class="text-center" hidden></td> --}}
                                        </tr>
                                        <tr>
                                            <td class="text-center"></td>
                                            <td class="text-center" colspan="4">...............................&nbsp;&nbsp;&nbsp;&nbsp;..................................</td>
                                            <td class="text-center"></td>
                                            <td class="text-center" colspan="5">........................................</td>
                                            <td class="text-center"></td>
                                            <td class="text-center" colspan="5">........................................</td>
                                            <td class="text-center"></td>
                                            <td class="text-center" colspan="5">........................................</td>
                                            <td class="text-center"></td>
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
                                            {{-- <td class="text-center" hidden></td> --}}
                                        </tr>
                                        <tr>
                                            <td class="text-center"></td>
                                            <td class="text-center" colspan="4">ผู้รายงาน&nbsp;&nbsp;&nbsp;&nbsp;ผู้ตรวจสอบ</td>
                                            <td class="text-center"></td>
                                            <td class="text-center" colspan="5">หัวหน้าส่วนโหลดสินค้า</td>
                                            <td class="text-center"></td>
                                            <td class="text-center" colspan="5">พนักงานขนส่ง</td>
                                            <td class="text-center"></td>
                                            <td class="text-center" colspan="5">หน./รอง หน.ร้าน</td>
                                            <td class="text-center"></td>
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
                                            {{-- <td class="text-center" hidden></td> --}}
                                        </tr>
                                      
                                    </tbody>
                                </table>
                                
                            {{-- @include('transport.transfer') --}}

                                <div class="text-center" style="padding-top: 10px;">
                                    <button type="submit" class="btn btn-success mr-2" id="comfirmAdd" name="stock_name" value="comfirmAdd">ยืนยัน</button>
                                </div>
                            {{ Form::close() }}
                                </div>
                        </div>
                    </div>
                   </div>
                </div>

    {{-- edit --}}
    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                {{ Form::open(['method' => 'post' , 'url' => '/wg_sku_weigth_edit']) }}
                <div id="editModal"></div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

    {{-- ADDข้อมูล --}}
    <div class="modal fade" id="adding" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                {{ Form::open(['method' => 'post' , 'url' => '/wg_sku_weigth_add_multiple']) }}
                <div class="forms-sample form-control" style="height: auto;padding-right: 20px;">
                    <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;">เพิ่มรายการน้ำหนัก</div>
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-md-6 pr-md-0">
                            <label for="orderDate">เลข Order</label>
                            <select class="form-control form-control-sm" id="order_number1" name="order_number" style=" height: 30px; " onchange="selectStation()" required>
                                <option ></option>
                                    @foreach ($select_cutting_number as $btnOF)
                                        @if ($btnOF->order_offal_number != null)
                                        <option value="{{  $btnOF->order_offal_number }}">{{  $btnOF->order_offal_number }}</option>
                                        @endif
                                    @endforeach
                                    @foreach ($select_cutting_number as $btnCL)
                                        @if ($btnCL->order_cutting_number != null)
                                        <option value="{{ $btnCL->order_cutting_number }}">{{ $btnCL->order_cutting_number }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                        <div class="col-md-6 pr-md-0">
                            <label for="scale_number">สถานที่ชั่ง</label>
                            <select class="form-control form-control-sm" id="scale_number" name="scale_number" style=" height: 30px; " required>

                            </select>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 10px;">
                        {{-- <div class="col-md-6 pr-md-0">
                            <label for="sku_code">รหัส Item</label>
                            <input class="form-control form-control-sm" placeholder="0000" id="sku_code" type="text" name="sku_code" required>
                        </div> --}}
                        <div class="col-md-3 pr-md-0">
                            <label for="weighing_place">สาขา รับ/โอน/คืน</label>
                            <select class="form-control form-control-sm" id="weighing_place" name="weighing_place" style=" height: 30px; " required>
                                <option value=""></option>
                                @foreach ($wg_scale_shop as $scale_shop)
                                    <option value="{{ $scale_shop->scale_number }}">{{ $scale_shop->scale_number }}</option> 
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 pr-md-0">
                            <label for="sku_id">ส่วนที่ชั่ง</label>
                            <select class="form-control form-control-sm" id="sku_id" name="sku_id" style=" height: 30px; " required>
                                <option value=""></option>
                                @foreach ($wg_sku as $sku)
                                    <option value="{{ $sku->id_wg_sku }}">{{ $sku->sku_name }}</option> 
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 pr-md-0">
                            <label for="sku_amount">จำนวนถุง</label>
                            <input class="form-control form-control-sm" placeholder="0" id="sku_amount" type="number" name="sku_amount" required>
                        </div>
                        <div class="col-md-3 pr-md-0">
                            <label for="weighing_type">ประเภทการชั่ง</label>
                            <select class="form-control form-control-sm" id="weighing_type" name="weighing_type" style=" height: 30px; " required>
                                <option value=""></option>
                                @foreach ($wg_weight_type as $weight_type)
                                    <option value="{{ $weight_type->id_wg_type }}">{{ $weight_type->wg_type_name }}</option> 
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 10px;">
                        {{-- <div class="col-md-3 pr-md-0">
                            <label for="weighing_place">สาขา รับ/โอน/คืน</label>
                            <select class="form-control form-control-sm" id="weighing_place" name="weighing_place" style=" height: 30px; " required>
                                <option value=""></option>
                                @foreach ($wg_scale_shop as $scale_shop)
                                    <option value="{{ $scale_shop->scale_number }}">{{ $scale_shop->scale_number }}</option> 
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 pr-md-0">
                            <label for="sku_id">ส่วนที่ชั่ง</label>
                            <select class="form-control form-control-sm" id="sku_id" name="sku_id" style=" height: 30px; " required>
                                <option value=""></option>
                                @foreach ($wg_sku as $sku)
                                    <option value="{{ $sku->id_wg_sku }}">{{ $sku->sku_name }}</option> 
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 pr-md-0">
                            <label for="sku_amount">จำนวนถุง</label>
                            <input class="form-control form-control-sm" placeholder="0" id="sku_amount" type="number" name="sku_amount" required>
                        </div> --}}
                        {{-- <div class="col-md-3 pr-md-0">
                            <label for="sku_weight">น้ำหนัก</label>
                            <input class="form-control form-control-sm" placeholder="0.0" id="sku_weight" type="text" name="sku_weight" required>
                        </div> --}}
                    </div>
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-md-3 pr-md-0">
                            <label for="storage_name">สถานที่จัดเก็บ</label>
                            <select class="form-control form-control-sm" id="storage_name" name="storage_name" style=" height: 30px; " required>
                                <option value=""></option>
                                @foreach ($wg_storage as $storage)
                                    <option value="{{ $storage->name_storage }}">{{ $storage->name_storage }}</option> 
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 pr-md-0">
                            <label for="user_name">ชื่อผู้่ชั่ง</label>
                            <input class="form-control form-control-sm" placeholder="๊USER" id="user_name" type="text" name="user_name" required>
                        </div>
                        <div class="col-md-3 pr-md-0">
                            <label for="weighing_date">วันที่ชั่ง</label>
                            <input class="form-control form-control-sm" placeholder="วว/ดด/ปปปป" id="weighing_date" type="text" name="weighing_date" required>
                        </div>
                        <div class="col-md-3 pr-md-0">
                            <label for="time">เวลา</label>
                            <input class="form-control form-control-sm" name="time" type="time" >
                        </div>
                    </div>

                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-md-6 pr-md-0">
                            <label for="sku_code">รหัส Item</label>
                            <input class="form-control form-control-sm" placeholder="0000" id="sku_code" type="text" name="sku_code[]" required>
                        </div>
                        <div class="col-md-6 pr-md-0" >
                            <label for="sku_weight">น้ำหนัก</label>
                            <input class="form-control form-control-sm" placeholder="0.0" id="sku_weight" type="text" name="sku_weight[]" required>
                        </div>
                    </div>

                    <span id="mySpan"></span>

                    
                    <div class="row text-left">
                        <div class="col-md-12 pr-md-0" >
                            <input name="btnButton" class="btn btn-primary mr-2" id="btnButton" type="button" value="+" onClick="add(1);">
                            <input name="nButton" class="btn btn-danger mr-2" id="nButton" type="button" value="-" onClick="JavaScript:dd();">
                        </div> 
                    </div> 
               

                    <div class="text-center" style="padding-top: 10px;">
                        <button type="submit" class="btn btn-success mr-2" id="comfirmAdd" value="comfirmAdd">ยืนยัน</button>
                    </div>
                </div>
                {{ Form::close() }}
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
        var table = $('#tbl-3').DataTable({
            lengthMenu: [[200, -1], [200, "All"]],
            "scrollX": false,
            orderCellsTop: true,
            fixedHeader: true,
            rowReorder: true,
            "ordering": false,
            dom: 'lBfrtip',
            buttons: [
                // 'excel',
                {
                    extend: 'excel',
                    messageTop: "รายงานตรวจสอบน้ำหนักชิ้นส่วนสุกรในกระบวนการผลิต {{ $select_cutting_number[0]->id_user_customer =='' ? '' : $select_cutting_number[0]->id_user_customer }}\
                    วันที่ {{ $select_cutting_number[0]->date_transport == '' ? '' : substr($select_cutting_number[0]->date_transport,3,2).'/'.substr($select_cutting_number[0]->date_transport,0,2).'/'.substr($select_cutting_number[0]->date_transport,6,4) }}\
                    เลขที่บิล{{ $select_cutting_number[0]->order_number }}"
                },
                // 'print'
            ],
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

        $('#weighing_date').daterangepicker({
            buttonClasses: ['btn', 'btn-sm'],
            applyClass: 'btn-danger',
            autoUpdateInput: false,
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
                },function (chosen_date) {
                        $('#weighing_date').val(chosen_date.format('DD/MM/YYYY'));
            }
        );
        $('#weighing_date').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY'));
        });
</script>

<script>
    function editRecord(id){

        $.ajax({
            type: 'GET',
            url: '{{ url('get_weighing_data') }}',
            data: {id:id},
            success: function (data) {
                var order_number = data[0].lot_number;
                var location_scale = data[0].location_scale;
                var scale_number = data[0].scale_number;
                var sku_code = data[0].sku_code;
                var wg_type_name = data[0].wg_type_name;
                var id_wg_type = data[0].weighing_type;
                var weighing_place = data[0].weighing_place;
                var id_wg_sku = data[0].sku_id;
                var sku_type = data[0].sku_name;
                var sku_amount = data[0].sku_amount;
                var sku_weight = data[0].sku_weight;
                var storage_name = data[0].storage_name;
                var user_name = data[0].user_name;
                var weighing_date = data[0].weighing_date;
                var time = data[0].time;

                str = '<div class="forms-sample form-control" style="height: auto;padding-right: 20px;">\
                            <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;">แก้ไขรายการน้ำหนัก</div>\
                            <div class="row" style="margin-bottom: 10px;">\
                                <div class="col-md-6 pr-md-0">\
                                    <label for="orderDate">เลข Order</label>\
                                    <input class="form-control form-control-sm" value="'+order_number+'" id="order_number" type="text" name="order_number" required>\
                                </div>\
                                <div class="col-md-6 pr-md-0">\
                                    <label for="scale_number">สถานที่ชั่ง</label>\
                                    <select class="form-control form-control-sm" id="scale_number" name="scale_number" style=" height: 30px; " required>\
                                            <option value="'+scale_number+'">'+scale_number+' - '+location_scale+'</option>';
                
                if (order_number.substr(0,2) == 'OF') {
                    str = str + '@foreach ($wg_scale as $scale)\
                            @if( $scale->department == 4 || $scale->department == 5 || $scale->department == 6 )\
                                <option value="{{ $scale->scale_number }}">{{ $scale->scale_number }} - {{ $scale->location_scale }}</option>\
                            @endif\
                        @endforeach';
                } else {
                    str = str + '@foreach ($wg_scale as $scale)\
                            @if( $scale->department == 8 || $scale->department == 9  )\
                                <option value="{{ $scale->scale_number }}">{{ $scale->scale_number }} - {{ $scale->location_scale }}</option>\
                            @endif\
                        @endforeach';
                }  

            $('#editModal').html(str + '</select>\
                                </div>\
                            </div>\
                            <div class="row" style="margin-bottom: 10px;">\
                                <div class="col-md-6 pr-md-0">\
                                    <label for="sku_code">รหัส Item</label>\
                                    <input class="form-control form-control-sm" value="'+sku_code+'" id="sku_code" type="text" name="sku_code" required>\
                                </div>\
                                <div class="col-md-6 pr-md-0">\
                                    <label for="weighing_type">ประเภทการชั่ง</label>\
                                    <select class="form-control form-control-sm" id="weighing_type"  name="weighing_type" style=" height: 30px; " required>\
                                        <option value="'+id_wg_type+'">'+wg_type_name+'</option>\
                                        @foreach ($wg_weight_type as $weight_type)\
                                            <option value="{{ $weight_type->id_wg_type }}">{{ $weight_type->wg_type_name }}</option>\
                                        @endforeach\
                                    </select>\
                                </div>\
                            </div>\
                            <div class="row" style="margin-bottom: 10px;">\
                                <div class="col-md-3 pr-md-0">\
                                    <label for="weighing_place">สาขา รับ/โอน/คืน</label>\
                                    <select class="form-control form-control-sm" id="weighing_place" name="weighing_place" style=" height: 30px; " required>\
                                        <option value="'+weighing_place+'">'+weighing_place+'</option>\
                                        @foreach ($wg_scale_shop as $scale_shop)\
                                            <option value="{{ $scale_shop->scale_number }}">{{ $scale_shop->scale_number }}</option>\
                                        @endforeach\
                                    </select>\
                                </div>\
                                <div class="col-md-3 pr-md-0">\
                                    <label for="sku_id">ส่วนที่ชั่ง</label>\
                                    <select class="form-control form-control-sm" id="sku_id" name="sku_id" style=" height: 30px; " required>\
                                        <option value="'+id_wg_sku+'">'+sku_type+'</option>\
                                        @foreach ($wg_sku as $sku)\
                                            <option value="{{ $sku->id_wg_sku }}">{{ $sku->sku_name }}</option> \
                                        @endforeach\
                                    </select>\
                                </div>\
                                <div class="col-md-3 pr-md-0">\
                                    <label for="sku_amount">จำนวนถุง</label>\
                                    <input class="form-control form-control-sm" value="'+sku_amount+'" id="sku_amount" type="number" name="sku_amount" required>\
                                </div>\
                                <div class="col-md-3 pr-md-0">\
                                    <label for="sku_weight">น้ำหนัก</label>\
                                    <input class="form-control form-control-sm" value="'+sku_weight+'" id="sku_weight" type="text" name="sku_weight" required>\
                                </div>\
                            </div>\
                            <div class="row" style="margin-bottom: 10px;">\
                                <div class="col-md-3 pr-md-0">\
                                    <label for="storage_name">สถานที่จัดเก็บ</label>\
                                    <select class="form-control form-control-sm" id="storage_name" name="storage_name" style=" height: 30px; " required>\
                                        <option value="'+storage_name+'">'+storage_name+'</option>\
                                        @foreach ($wg_storage as $storage)\
                                            <option value="{{ $storage->name_storage }}">{{ $storage->name_storage }}</option>\
                                        @endforeach\
                                    </select>\
                                </div>\
                                <div class="col-md-3 pr-md-0">\
                                    <label for="user_name">ชื่อผู้่ชั่ง</label>\
                                    <input class="form-control form-control-sm" value="'+user_name+'" id="user_name" type="text" name="user_name" readonly required>\
                                </div>\
                                <div class="col-md-3 pr-md-0">\
                                    <label for="weighing_date">วันที่ชั่ง</label>\
                                    <input class="form-control form-control-sm" value="'+weighing_date+'" id="weighing_date2" type="text" name="weighing_date2" required>\
                                </div>\
                                <div class="col-md-3 pr-md-0">\
                                    <label for="time">เวลา</label>\
                                    <input class="form-control form-control-sm" name="time" value="'+time+'" type="time" >\
                                </div>\
                            </div>\
                            <div class="text-center" style="padding-top: 10px;">\
                            <button  id="deletebtn" style="padding: 7px;" type="button" class="btn btn-danger"\
                            onclick="deleteRecord('+id+')">\<i class="fa fa-trash"></i></button>\
                                <button type="submit" class="btn btn-success mr-2" id="comfirmAdd2" name="comfirmAdd" value="'+id+'">ยืนยัน</button>\
                            </div>\
                        </div>');
                        
                $('#weighing_date2').daterangepicker({
                    buttonClasses: ['btn', 'btn-sm'],
                    applyClass: 'btn-danger',
                    autoUpdateInput: false,
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
                        },function (chosen_date) {
                                $('#weighing_date2').val(chosen_date.format('DD/MM/YYYY'));
                        }
                );
                $('#weighing_date2').on('apply.daterangepicker', function(ev, picker) {
                    $(this).val(picker.startDate.format('DD/MM/YYYY'));
                });

                if('{{ $select_cutting_number[0]->ended_order }}' == 1){
                    $('#comfirmAdd2').prop('disabled', true);
                    $('#deletebtn').prop('disabled', true);
                }

            },

            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert("Status: " + textStatus); alert("Error: " + errorThrown);
            }
        });

    }
</script>

{{-- transfer --}}
<script>
    var table = $('#transfer_out').DataTable({
        lengthMenu: [[200, -1], [200, "All"]],
        "scrollX": false,
        orderCellsTop: true,
        fixedHeader: true,
        rowReorder: true,
        "ordering": false,
        dom: 'lBfrtip',
        buttons: [
            // 'excel',
            {
                extend: 'excel',
                messageTop: "รายงานตรวจสอบน้ำหนักชิ้นส่วนสุกรในกระบวนการผลิต {{ $select_cutting_number[0]->id_user_customer =='' ? '' : $select_cutting_number[0]->id_user_customer }}\
                วันที่ {{ $select_cutting_number[0]->date_transport == '' ? '' : substr($select_cutting_number[0]->date_transport,3,2).'/'.substr($select_cutting_number[0]->date_transport,0,2).'/'.substr($select_cutting_number[0]->date_transport,6,4) }}\
                เลขที่บิล{{ $select_cutting_number[0]->order_number }} ทะเบียนรถ ....... อุณหภูมิรถ ......."
            },
            // 'print'
        ],
        // processing: true,
        // serverSide: true,
        "order": [],
    });
</script>

<script>
    function deleteRecord(id){

        if(confirm('ยืนยันการลบ ?')){
            
            $.ajax({
                type: 'GET',
                url: '{{ url('delete_weighing_data') }}',
                data: {id:id},
                success: function (msg) {
                    // alert(msg);
                    $('#edit').modal('toggle');
                    $('#x'+id).html('');
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("Status: " + textStatus); alert("Error: " + errorThrown);
                }
            });
            
        }
    }

    function ended_order(order){
        if(confirm('หากจบการทำงานจะไม่สามารถแก้ไขได้อีก ยืนยันจบการทำงาน '+order+' หรือไม่? : ')){
            $.ajax({
                type: 'GET',
                url: '{{ url('ended_tr_order') }}',
                data: {order:order},
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


<script language="javascript" type="text/javascript">


    function add($i){
    var s =$i++;
    // var mySpan = document.getElementById('mySpan');
    // var myElement1 = document.createElement('input');
    //     myElement1.setAttribute('type', 'text');
    //     myElement1.setAttribute('id',"txt1[]");
    //     myElement1.setAttribute('value',s);
    //     mySpan.appendChild(myElement1);
        // mySpan.appendChild(document.createElement('br'));
        
        $("#mySpan").append('<div class="row" style="margin-bottom: 10px;" id="appen[]">\
                        <div class="col-md-6 pr-md-0">\
                            <label for="sku_code">รหัส Item</label>\
                            <input class="form-control form-control-sm" placeholder="0000" id="sku_code" type="text" name="sku_code[]" required>\
                        </div>\
                        <div class="col-md-6 pr-md-0" >\
                            <label for="sku_weight">น้ำหนัก</label>\
                            <input class="form-control form-control-sm" placeholder="0.0" id="sku_weight" type="text" name="sku_weight[]" required>\
                            </div>\
                        </div>');
        }
        
        function dd(){
        var mySpan = document.getElementById('mySpan');
        var deleteEle = document.getElementById('appen[]');
            mySpan.removeChild(deleteEle);
        }

        function selectStation(){
            console.log($('#order_number1').val().substr(0,2));
            if (  $('#order_number1').val().substr(0,2) == 'OF') {
                var str = '<option value=""></option>\
                @foreach ($wg_scale as $scale)\
                    @if( $scale->department == 4 || $scale->department == 5 || $scale->department == 6 )\
                    <option value="{{ $scale->scale_number }}">{{ $scale->scale_number }} - {{ $scale->location_scale }}</option>\
                    @endif\
                @endforeach';
            } else {
                var str = '<option value=""></option>\
                @foreach ($wg_scale as $scale)\
                    @if( $scale->department == 8 || $scale->department == 9)\
                    <option value="{{ $scale->scale_number }}">{{ $scale->scale_number }} - {{ $scale->location_scale }}</option>\
                    @endif\
                @endforeach';
            }
            $('#scale_number').html(str);
            console.log(str);
            console.log($('#order_number1').val().substr(0,2));
            
        }

        $( document ).ready(function() {
            if('{{ $select_cutting_number[0]->ended_order }}' == 1){
                $('#adder').addClass('disabled');
                $('#ended').addClass('disabled');
                $('#comfirmAdd').prop('disabled', true);
                $('#deleteRecord').prop('disabled', true);
            }
        });
    
</script>



@endsection


