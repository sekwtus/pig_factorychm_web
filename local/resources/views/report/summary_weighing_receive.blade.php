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
    div.dataTables_wrapper div.dataTables_filter input {
    margin-left: 0.5em;
    display: inline-block;
    width: 140px;
    }
}
</style>

<link rel="stylesheet" href="{{ url('https://cdn.datatables.net/1.10.18/css/dataTables.semanticui.min.css') }}" type="text/css" />
{{-- <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" /> --}}
<link rel="stylesheet" href="{{ asset('assets/css/daterangepicker.css')}}">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" />

@endsection
@section('main')
              <div class="col-lg-12 grid-margin">
                <div class="card">
                  <div class="card-body">

                        <div class="table-responsive">
                            <h3 style="color:black;margin-bottom: 0px;height: 0px;" class="text-center">รายงานการชั่งน้ำหนัก : {{ $order_number }} ({{$count[0]->count_pig}})</h3><br><br>
                            <div class="row">
                                <div class="col-4">
                                    <div class="row">
                                        <div class="col-2">
                                            <a class="btn btn-success" data-toggle="modal" data-target="#adding" style="margin-bottom: 10px;color:white">
                                                <i class="mdi mdi-plus"></i>
                                            </a>
                                        </div>
                                        <div class="col-10">
                                            <h4 class="text-center" style="color:blue;margin-bottom: 0px;height: 0px;">รับสุกร
                                                @php
                                                    if (!empty($select_in_R[0]->weighing_date)) {
                                                        echo (substr($select_in_R[0]->weighing_date,8,2).'/'.substr($select_in_R[0]->weighing_date,5,2).'/'.substr($select_in_R[0]->weighing_date,0,4) );
                                                    }
                                                @endphp 
                                            </h4>
                                        </div>
                                    </div>
                                    <table class="tbl table-hover " width="100%" border="1" id="orderRecieveTable">
                                        <thead class="text-center">
                                            <tr style="background-color:#7dbeff">
                                            <th style="padding: 0px;">No.</th>
                                            <th style="padding: 0px;">จุดชั่ง</th>
                                            <th style="padding: 0px;">Item</th>
                                            <th style="padding: 0px;">นน.</th>
                                            <th style="padding: 0px;">จำนวน</th>
                                            <th style="padding: 0px;">เวลาชั่ง</th>
                                            <th style="padding: 0px;">สถานะ</th>
                                            <th style="padding: 0px;">action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $count=1;
                                                $sum_weight=0;
                                                $sum_unit=0;
                                            @endphp
                                            @if (!empty($select_in_R))
                                                @foreach ($select_in_R as $in_R)
                                                @if ($in_R->note == '1')
                                                  <tr style="color:red;">  
                                                @else
                                                    <tr>
                                                @endif
                                                    <td class="text-center" style="padding: 0px;">{{ $count++ }}</td>
                                                    <td class="text-center" style="padding: 0px;">{{ $in_R->scale_number }}</td>
                                                    <td class="text-center" style="padding: 0px;">ตัว</td>
                                                    <td class="text-center" style="padding: 0px;">{{ $in_R->sku_weight }}
                                                        @php
                                                            $sum_weight = $sum_weight +$in_R->sku_weight;
                                                        @endphp
                                                    </td>
                                                    <td class="text-center" style="padding: 0px;">{{ $in_R->sku_amount }}
                                                        @php
                                                            $sum_unit = $sum_unit +$in_R->sku_amount;
                                                        @endphp
                                                        </td>
                                                    <td class="text-center" style="padding: 0px;">{{ substr($in_R->weighing_date,11,8) }}</td>
                                                    @if ($in_R->note == 'M' )
                                                        <td class="text-center" style="padding: 0px;">{{ $in_R->note }}</td>
                                                    @else 
                                                        @if ( $in_R->note == '1')
                                                            <td class="text-center" style="padding: 0px;">ชั่งผิด</td>
                                                        @else 
                                                            <td class="text-center" style="padding: 0px;">A</td>
                                                        @endif
                                                        
                                                    @endif
                                                    <td class="text-center" style="padding: 0px;">  <button  style="padding: 7px;" type="button" class="btn btn-danger"
                                                        onclick="deleteRecord('{{ $in_R->sku_weight }}',{{ $in_R->id }})">
                                                        <i class="fa fa-trash"></i></button>
                                                    </td>
                                                    

                                                </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                        <tfoot>
                                            <tr style="background-color:#ff8080">
                                                <th class="text-center" style="padding: 0px;"></th>
                                                <th class="text-center" style="padding: 0px;"></th>
                                                <th class="text-center" style="padding: 0px;">รวม</th>
                                                <th class="text-center" style="padding: 0px;">{{ number_format($sum_weight, 0, '.', ',' ) }}</th>
                                                <th class="text-center" style="padding: 0px;">{{ $sum_unit  }}</th>
                                                <th class="text-center" style="padding: 0px;" ></td>
                                                <th class="text-center" style="padding: 0px;" ></td>
                                                {{-- @if (Auth::user()->id_type == 1 ) --}}
                                                    <th class="text-center" style="padding: 0px;" ></td>
                                                {{-- @endif --}}

                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                <div class="col-4">
                                    <h4 class="text-center" style="color:blue;margin-bottom: 0px;height: 0px;">ชั่งก่อนช็อต
                                        @php
                                            if (!empty($select_in_K[0]->weighing_date)) {
                                                echo (substr($select_in_K[0]->weighing_date,8,2).'/'.substr($select_in_K[0]->weighing_date,5,2).'/'.substr($select_in_K[0]->weighing_date,0,4) );
                                            }
                                        @endphp 
                                    </h4><br><br>
                                    
                                    <table class="tbl table-hover " width="100%" border="1" id="orderBeforeOVTable">
                                        <thead class="text-center">
                                            <tr style="background-color:#7dbeff">
                                            <th style="padding: 0px;">No.</th>
                                            <th style="padding: 0px;">จุดชั่ง</th>
                                            <th style="padding: 0px;">Item</th>
                                            <th style="padding: 0px;">นน.</th>
                                            <th style="padding: 0px;">จำนวน</th>
                                            <th style="padding: 0px;">เวลาชั่ง</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $count=1;
                                                $sum_weight=0;
                                                $sum_unit=0;
                                            @endphp
                                            @if (!empty($select_in_K))
                                                @foreach ($select_in_K as $in_K)
                                                <tr>
                                                    <td class="text-center" style="padding: 0px;">{{ $count++ }}</td>
                                                    <td class="text-center" style="padding: 0px;">{{ $in_K->scale_number }}</td>
                                                    <td class="text-center" style="padding: 0px;">{{ $in_K->item_name }}</td>
                                                    <td class="text-center" style="padding: 0px;">{{ $in_K->sku_weight }}
                                                        @php
                                                            $sum_weight = $sum_weight +$in_K->sku_weight;
                                                        @endphp
                                                    </td>
                                                    <td class="text-center" style="padding: 0px;">{{ $in_K->sku_amount }}
                                                        @php
                                                            $sum_unit = $sum_unit +$in_K->sku_amount;
                                                        @endphp
                                                        </td>
                                                    <td class="text-center" style="padding: 0px;">{{ substr($in_K->weighing_date,11,8) }}</td>
                                                </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                        <tfoot>
                                            <tr  style="background-color:#ff8080">
                                                <th class="text-center" style="padding: 0px;"></th>
                                                <th class="text-center" style="padding: 0px;"></th>
                                                <th class="text-center" style="padding: 0px;">รวม</th>
                                                <th class="text-center" style="padding: 0px;">{{ number_format($sum_weight) }}</th>
                                                <th class="text-center" style="padding: 0px;">{{ $sum_unit  }}</th>
                                                <th class="text-center" style="padding: 0px;" ></td>
    
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                <div class="col-4">
                                    <h4 class="text-center" style="color:blue;margin-bottom: 0px;height: 0px;">ชั่งซีกก่อนเข้า Overnight  
                                    @php
                                        if (!empty($select_in_before_ov[0]->weighing_date)) {
                                            echo (substr($select_in_before_ov[0]->weighing_date,8,2).'/'.substr($select_in_before_ov[0]->weighing_date,5,2).'/'.substr($select_in_before_ov[0]->weighing_date,0,4) );
                                        }
                                    @endphp
                                    </h4><br><br>
                                    <table class="tbl table-hover " width="100%" border="1" id="orderAfterOVTable">
                                        <thead class="text-center">
                                            <tr style="background-color:#7dbeff">
                                            <th style="padding: 0px;">No11.</th>
                                            <th style="padding: 0px;">จุดชั่ง</th>
                                            <th style="padding: 0px;">Item</th>
                                            <th style="padding: 0px;">นน.</th>
                                            <th style="padding: 0px;">จำนวน</th>
                                            <th style="padding: 0px;">เวลาชั่ง</th>
                                            <th style="padding: 0px;">action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $count=1;
                                                $sum_weight=0;
                                                $sum_unit=0;
                                            @endphp
                                            @if (!empty($select_in_before_ov))
                                                @foreach ($select_in_before_ov as $in_K2)
                                                <tr>
                                                    <td class="text-center" style="padding: 0px;">{{ $count++ }}</td>
                                                    <td class="text-center" style="padding: 0px;">{{ $in_K2->scale_number }}</td>
                                                    <td class="text-center" style="padding: 0px;">ซีก</td>
                                                    <td class="text-center" style="padding: 0px;">{{ $in_K2->sku_weight }}
                                                        @php
                                                            $sum_weight = $sum_weight +$in_K2->sku_weight;
                                                        @endphp
                                                    </td>
                                                    <td class="text-center" style="padding: 0px;">{{ $in_K2->sku_amount }}
                                                        @php
                                                            $sum_unit = $sum_unit +$in_K2->sku_amount;
                                                        @endphp
                                                    </td>
                                                    <td class="text-center" style="padding: 0px;">{{ substr($in_K2->weighing_date,11,8) }}</td>
                                                    <td class="text-center" style="padding: 0px;"><button style="padding: 7px;" type="button" class="btn btn-danger" onclick="deleteRecord('{{ $in_K2->sku_weight }}',{{ $in_K2->id }})">
                                                        <i class="fa fa-trash"></i></button></td>
                                                </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                        <tfoot>
                                            <tr style="background-color:#ff8080">
                                                <th class="text-center" style="padding: 0px;"></th>
                                                <th class="text-center" style="padding: 0px;"></th>
                                                <th class="text-center" style="padding: 0px;">รวม</th>
                                                <th class="text-center" style="padding: 0px;">{{ number_format($sum_weight) }}</th>
                                                <th class="text-center" style="padding: 0px;">{{ $sum_unit  }}</th>
                                                <th class="text-center" style="padding: 0px;" ></td>
                                                <th class="text-center" style="padding: 0px;" ></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>


                                <div class="col-6" style="padding-top: 50px;">
                                    <h4 class="text-center" style="color:blue;margin-bottom: 0px;height: 0px;">ชั่งเข้าเครื่องในขาว
                                        @php
                                            if (!empty($select_in_W_receive[0]->weighing_date)) {
                                                echo (substr($select_in_W_receive[0]->weighing_date,8,2).'/'.substr($select_in_W_receive[0]->weighing_date,5,2).'/'.substr($select_in_W_receive[0]->weighing_date,0,4) );
                                            }
                                        @endphp
                                    </h4><br><br>
                                    <table class="tbl table-hover " width="100%" border="1" id="orderOffalTable">
                                        <thead class="text-center">
                                            <tr style="background-color:#7dbeff">
                                            <th style="padding: 0px;">No.</th>
                                            <th style="padding: 0px;">จุดชั่ง</th>
                                            <th style="padding: 0px;">Item</th>
                                            <th style="padding: 0px;">นน.</th>
                                            <th style="padding: 0px;">จำนวน</th>
                                            <th style="padding: 0px;">เวลาชั่ง</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $count=1;
                                                $sum_weight=0;
                                                $sum_unit=0;
                                            @endphp
                                            @if (!empty($select_in_W_receive))
                                                @foreach ($select_in_W_receive as $in_OF)
                                                <tr>
                                                    <td class="text-center" style="padding: 0px;">{{ $count++ }}</td>
                                                    <td class="text-center" style="padding: 0px;">{{ $in_OF->scale_number }}</td>
                                                    <td class="text-center" style="padding: 0px;">{{ $in_OF->sku_code }}</td>
                                                    <td class="text-center" style="padding: 0px;">{{ number_format($in_OF->sku_weight, 2, '.', '') }}
                                                        @php
                                                            $sum_weight = $sum_weight +$in_OF->sku_weight;
                                                        @endphp
                                                    </td>
                                                    <td class="text-center" style="padding: 0px;">{{ (empty($in_OF->sku_amount) ? 0 : $in_OF->sku_amount) }}
                                                        @php
                                                            $sum_unit = $sum_unit + (empty($in_OF->sku_amount) ? 0 : $in_OF->sku_amount);
                                                        @endphp
                                                        </td>
                                                    <td class="text-center" style="padding: 0px;">{{ substr($in_OF->weighing_date,11,8) }}</td>
                                                </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                        <tfoot>
                                            <tr  style="background-color:#ff8080">
                                                <th class="text-center" style="padding: 0px;"></th>
                                                <th class="text-center" style="padding: 0px;"></th>
                                                <th class="text-center" style="padding: 0px;">รวม</th>
                                                <th class="text-center" style="padding: 0px;">{{ number_format($sum_weight) }}</th>
                                                <th class="text-center" style="padding: 0px;">{{ $sum_unit  }}</th>
                                                <th class="text-center" style="padding: 0px;"></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                <div class="col-6" style="padding-top: 50px;">
                                    <h4 class="text-center" style="color:blue;margin-bottom: 0px;height: 0px;">ชั่งเข้าเครื่องในแดง
                                    @php
                                        if (!empty($select_in_R_receive[0]->weighing_date)) {
                                            echo (substr($select_in_R_receive[0]->weighing_date,8,2).'/'.substr($select_in_R_receive[0]->weighing_date,5,2).'/'.substr($select_in_R_receive[0]->weighing_date,0,4) );
                                        }
                                    @endphp</h4><br><br>
                                    <table class="tbl table-hover " width="100%" border="1" id="orderCutTable">
                                        <thead class="text-center">
                                            <tr style="background-color:#7dbeff">
                                            <th style="padding: 0px;">No.</th>
                                            <th style="padding: 0px;">จุดชั่ง</th>
                                            <th style="padding: 0px;">Item</th>
                                            <th style="padding: 0px;">นน.</th>
                                            <th style="padding: 0px;">จำนวน</th>
                                            <th style="padding: 0px;">เวลาชั่ง</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $count=1;
                                                $sum_weight=0;
                                                $sum_unit=0;
                                            @endphp
                                            @if (!empty($select_in_R_receive))
                                                @foreach ($select_in_R_receive as $in_SH)
                                                <tr>
                                                    <td class="text-center" style="padding: 0px;">{{ $count++ }}</td>
                                                    <td class="text-center" style="padding: 0px;">{{ $in_SH->scale_number }}</td>
                                                    <td class="text-center" style="padding: 0px;">{{ $in_SH->sku_code }}</td>
                                                    <td class="text-center" style="padding: 0px;">{{ number_format($in_SH->sku_weight, 2, '.', '') }}
                                                        @php
                                                            $sum_weight = $sum_weight + $in_SH->sku_weight;
                                                        @endphp
                                                    </td>
                                                    <td class="text-center" style="padding: 0px;">{{ $in_SH->sku_amount }}
                                                        @php

                                                            $sum_unit = $sum_unit + ( $in_SH->sku_amount == null ? 0 : $in_SH->sku_amount );
                                                        @endphp
                                                        </td>
                                                    <td class="text-center" style="padding: 0px;">{{ substr($in_SH->weighing_date,11,8) }}</td>
                                                </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                        <tfoot>
                                            <tr  style="background-color:#ff8080">
                                                <th class="text-center" style="padding: 0px;"></th>
                                                <th class="text-center" style="padding: 0px;"></th>
                                                <th class="text-center" style="padding: 0px;">รวม</th>
                                                <th class="text-center" style="padding: 0px;">{{ number_format($sum_weight) }}</th>
                                                <th class="text-center" style="padding: 0px;">{{ $sum_unit  }}</th>
                                                <th class="text-center" style="padding: 0px;"></th>

                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                            </div>
                        </div>
                      </div>
                   </div>
                </div>

                {{-- ////////////////////// เพิ่มหมู กรณีขึ้นชั่งไม่ได้ --}}
                <div class="modal fade" id="adding" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            {{ Form::open(['method' => 'post' , 'url' => '/wg_sku_weigth_add_multiple']) }}
                            <div class="forms-sample form-control" style="height: auto;padding-right: 20px;">
                                <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;">เพิ่มรายการน้ำหนัก</div>
                                <div class="row" style="margin-bottom: 10px;">
                                    <div class="col-md-6 pr-md-0">
                                        <label for="orderDate">เลข Order</label>
                                        <input class="form-control form-control-sm" placeholder="R20199999-99999" id="order_number" type="text" name="order_number" value="{{ $order_number }}" readonly>
                                        {{-- <select class="form-control form-control-sm" id="order_number" name="order_number" style=" height: 30px; " required>
                                            <option value="{{ $select_cutting_number[0]->order_cutting_number }}">{{ $select_cutting_number[0]->order_cutting_number }}</option>
                                            <option value="{{ $select_cutting_number[0]->order_offal_number }}">{{ $select_cutting_number[0]->order_offal_number }}</option>
                                        </select> --}}
                                    </div>
                                    <div class="col-md-6 pr-md-0">
                                        <label for="scale_number">สถานที่ชั่ง</label>
                                        <select class="form-control form-control-sm" id="scale_number" name="scale_number" style=" height: 30px; " required>
                                            <option value=""></option>
                                            @foreach ($wg_scale as $scale)
                                                <option value="{{ $scale->scale_number }}">{{ $scale->scale_number }} - {{ $scale->location_scale }}</option> 
                                            @endforeach
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
                                        <label for="sku_amount">จำนวน</label>
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
                                        <select class="form-control form-control-sm" id="storage_name" name="storage_name" style=" height: 30px; " >
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
                                        <input class="form-control form-control-sm" placeholder="วว/ดด/ปปปป" id="weighing_date" type="text" name="weighing_date" required readonly>
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

            var table1 = $('#orderRecieveTable').DataTable({
                lengthMenu: [[20, 50, 100, -1], [20, 50, 100, "All"]],
                dom: 'Blfrtp',
                buttons: [
                    { extend: 'excelHtml5', footer: true },
                //  'pdf', 'print'
            ],
            });

        
            var table2 = $('#orderBeforeOVTable').DataTable({
                lengthMenu: [[20, 50, 100, -1], [20, 50, 100, "All"]],
                dom: 'Blfrtp',
                buttons: [
                    { extend: 'excelHtml5', footer: true },
                //  'pdf', 'print'
            ],
            });
            var table3 = $('#orderAfterOVTable').DataTable({
                lengthMenu: [[20, 50, 100, -1], [20, 50, 100, "All"]],
                dom: 'Blfrtp',
                buttons: [
                    { extend: 'excelHtml5', footer: true },
                //  'pdf', 'print'
            ],
            });



            var table4 = $('#orderOffalTable').DataTable({
                lengthMenu: [[20, 50, 100, -1], [20, 50, 100, "All"]],
                dom: 'Blfrtp',
                buttons: [
                    { extend: 'excelHtml5', footer: true },
                //  'pdf', 'print'
            ],
            });
            var table5 = $('#orderCutTable').DataTable({
                lengthMenu: [[20, 50, 100, -1], [20, 50, 100, "All"]],
                dom: 'Blfrtp',
                buttons: [
                    { extend: 'excelHtml5', footer: true },
                //  'pdf', 'print'
            ],
            });



            table1.on( 'order.dt search.dt', function () {
                table1.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
            } ).draw();

            table2.on( 'order.dt search.dt', function () {
                table2.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            } ).draw();

            table3.on( 'order.dt search.dt', function () {
                table3.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            } ).draw();
            
            

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
    
    </script>

<script>
    function deleteRecord(sku_weight,id){
        if(confirm('ต้องการลบน้ำหนัก '+sku_weight+' ?')){
            $.ajax({
                type: 'GET',
                url: '{{ url('delete_weighing_data') }}',
                data: {id:id},
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
    $('#weighing_date').daterangepicker({
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


@endsection


