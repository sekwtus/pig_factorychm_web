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
    .increase {
        background-color: #a6ffa6 !important;
    }
    .decrease {
        background-color: #ff8080 !important;
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
                            <div class="col-lg-8">
                                <h2 style="color:red;margin-bottom: 0px;height: 0px;">ข้อมูลการขายรวมสาขา ประจำวันที่ 
                                @if (strlen($shop_sales_report[0]->date_today) > 10) 
                                    {{ $shop_sales_report[0]->date_today }}
                                @else
                                {{ $shop_sales_report[0]->date_today =='' ? '' : substr($shop_sales_report[0]->date_today,3,2).'/'.substr($shop_sales_report[0]->date_today,0,2).'/'.substr($shop_sales_report[0]->date_today,6,4) }}
                                @endif
                            </h2></div><br>
                        </div>
                        <div class="row"> <div class="col-lg-4"></div></div>
                        <br>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered nowrap " width="100%" id="report_shop">
                                    <thead class="text-center ">
                                    <tr>
                                        <th style="padding: 0px;">No.</th>
                                        <th style="padding: 0px;">รหัสสินค้า</th>
                                        <th style="padding: 0px;">ชื่อสินค้า</th>
                                        <th style="padding: 0px;">หน่วยนับ</th>
                                        <th style="padding: 0px;">จำนวน</th>
                                        <th style="padding: 0px;">ราคา</th>
                                        <th style="padding: 0px;">เป็นเงิน</th>
                                        <th style="padding: 0px;">%</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        {{-- หมู กิโลกรัม--}}
                                        @php
                                            $total_weight_number=0;
                                            $total_unit_number=0;
                                            $all_item_price=0;
                                            $part_item_price=0; // หมูขายชิ้น
                                            $all_pig_price=0;
                                            $total_percent=0;
                                        @endphp
                                        @foreach ($shop_sales_report as $report) 
                                            @if ($report->sku_group == "สินค้า(หมู)" && $report->unit == 'กิโลกรัม')
                                                <tr>
                                                    <td style="padding: 0px;" class="text-center"></td>
                                                    <td style="padding: 0px;" class="text-center">{{ $report->item_code }}</td>
                                                    <td style="padding: 0px;" class="text-center">{{ $report->item_name }}</td>
                                                    <td style="padding: 0px;" class="text-center">{{ $report->unit }}</td>
                                                    <td style="padding: 0px;" class="text-center">{{ $report->weight_number }} 
                                                        @php 
                                                        if ($report->unit == 'กิโลกรัม') {
                                                            $total_weight_number = $total_weight_number + floatval($report->weight_number);
                                                        } else {
                                                            $total_unit_number = $total_unit_number + floatval($report->weight_number);
                                                        }
                                                        @endphp
                                                    </td>
                                                    <td style="padding: 0px;" class="text-center">{{ number_format($report->price_unit, 0, '.', '') }}</td>
                                                    <td style="padding: 0px;" class="text-center">{{ $report->total_price }} 
                                                        @php 
                                                            $all_item_price = $all_item_price + $report->total_price;
                                                            if ($report->unit == 'กิโลกรัม') {
                                                                $all_pig_price = $all_pig_price + $report->total_price;
                                                            }
                                                        @endphp
                                                    </td>

                                                    <td style="padding: 0px;" class="text-center">{{ number_format(($report->weight_number*100)/floatval($sum_weight_number), 2, '.', '') }}%
                                                    @php
                                                        $total_percent = $total_percent + ($report->weight_number*100)/floatval($sum_weight_number);
                                                    @endphp</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        <tr style="background-color:#aef9ff;">
                                            <td style="padding: 0px;" class="text-center" >รวม</td>
                                            <td style="padding: 0px;" class="text-center" >รวมขายสุกร</td>
                                            <td style="padding: 0px;" class="text-center" ></td>
                                            <td style="padding: 0px;" class="text-center" ></td>
                                            <td style="padding: 0px;" class="text-center" >{{ $total_weight_number }} กก.</td>
                                            <td style="padding: 0px;" class="text-center" >{{ number_format($all_pig_price/$total_weight_number, 2, '.', '') }}/กก.</td>
                                            <td style="padding: 0px;" class="text-center" >{{ $all_item_price }} </td>
                                            <td style="padding: 0px;" class="text-center">{{ number_format($total_percent, 2, '.', '') }}%</td>
                                        </tr>

                                        {{-- หมู ชิ้น --}}
                                        @foreach ($shop_sales_report as $report) 
                                            @if ($report->sku_group == "สินค้า(หมู)" && $report->unit == 'ชิ้น')
                                                <tr>
                                                    <td style="padding: 0px;" class="text-center"></td>
                                                    <td style="padding: 0px;" class="text-center">{{ $report->item_code }}</td>
                                                    <td style="padding: 0px;" class="text-center">{{ $report->item_name }}</td>
                                                    <td style="padding: 0px;" class="text-center">{{ $report->unit }}</td>
                                                    <td style="padding: 0px;" class="text-center">{{ $report->weight_number }} 
                                                        @php 
                                                        if ($report->unit == 'กิโลกรัม') {
                                                            $total_weight_number = $total_weight_number + floatval($report->weight_number);
                                                        } else {
                                                            $total_unit_number = $total_unit_number + floatval($report->weight_number);
                                                        }
                                                        @endphp
                                                    </td>
                                                    <td style="padding: 0px;" class="text-center">{{ number_format($report->price_unit, 0, '.', '') }}</td>
                                                    <td style="padding: 0px;" class="text-center">{{ $report->total_price }} 
                                                        @php 
                                                            $all_item_price = $all_item_price + $report->total_price;
                                                            $part_item_price = $part_item_price + $report->total_price;
                                                            if ($report->unit == 'กิโลกรัม') {
                                                                $all_pig_price = $all_pig_price + $report->total_price;
                                                            }
                                                        @endphp
                                                    </td>

                                                    <td style="padding: 0px;" class="text-center">{{ number_format(($report->weight_number*100)/floatval($sum_weight_number), 2, '.', '') }}%
                                                    @php
                                                        $total_percent = $total_percent + ($report->weight_number*100)/floatval($sum_weight_number);
                                                    @endphp</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        <tr style="background-color:#aef9ff;">
                                            <td style="padding: 0px;" class="text-center" >รวม</td>
                                            <td style="padding: 0px;" class="text-center" >รวมขายสุกร</td>
                                            <td style="padding: 0px;" class="text-center" ></td>
                                            <td style="padding: 0px;" class="text-center" ></td>
                                            <td style="padding: 0px;" class="text-center" >{{ $total_unit_number }} ชิ้น</td>
                                            <td style="padding: 0px;" class="text-center" >{{ ( $total_unit_number == 0 ? 0 : number_format(($all_item_price-$all_pig_price)/$total_unit_number, 2, '.', '') ) }}/ชิ้น</td>
                                            <td style="padding: 0px;" class="text-center" >{{ $part_item_price }} </td>
                                            <td style="padding: 0px;" class="text-center">{{ number_format($total_percent, 2, '.', '') }}%</td>
                                        </tr>

                                        {{-- น้ำจิ้ม --}}
                                        @php
                                            $total_weight_number2=0;
                                            $total_unit_number2=0;
                                            $all_item_price2=0;
                                            $total_percent2=0;
                                        @endphp
                                        @foreach ($shop_sales_report as $report2) 
                                            @if ($report2->sku_group == "สินค้า(ทั่วไป)" && $report2->sku_name == "น้ำจิ้ม")
                                            <tr>
                                                    <td style="padding: 0px;" class="text-center"></td>
                                                    <td style="padding: 0px;" class="text-center">{{ $report2->item_code }}</td>
                                                    <td style="padding: 0px;" class="text-center">{{ $report2->item_name }}</td>
                                                    <td style="padding: 0px;" class="text-center">{{ $report2->unit }}</td>
                                                    <td style="padding: 0px;" class="text-center">{{ $report2->weight_number }}
                                                            @php 
                                                            if ($report2->unit == 'กิโลกรัม') {
                                                                $total_weight_number2 = $total_weight_number2 + floatval($report2->weight_number);
                                                            } else {
                                                                $total_unit_number2 = $total_unit_number2 + floatval($report2->weight_number);
                                                            }
                                                            @endphp
                                                    </td>
                                                    <td style="padding: 0px;" class="text-center">{{ $report2->price_unit }} </td>
                                                    <td style="padding: 0px;" class="text-center">{{ $report2->total_price }} @php $all_item_price2 = $all_item_price2 + $report2->total_price @endphp</td>
                                                    <td style="padding: 0px;" class="text-center">
                                                        {{-- {{ number_format(($report2->weight_number*100)/floatval(1), 2, '.', '') }}%
                                                    @php
                                                        $total_percent2 = $total_percent2 + ($report2->weight_number*100)/floatval(1);
                                                    @endphp --}}
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        <tr style="background-color:#aef9ff;">
                                            <td style="padding: 0px;" class="text-center" >รวม</td>
                                            <td style="padding: 0px;" class="text-center" >รวมขายน้ำจิ้ม</td>
                                            <td style="padding: 0px;" class="text-center" ></td>
                                            <td style="padding: 0px;" class="text-center" ></td>
                                            <td style="padding: 0px;" class="text-center" >{{ $total_unit_number2 }} ชิ้น</td>
                                            <td style="padding: 0px;" class="text-center" ></td>
                                            <td style="padding: 0px;" class="text-center" >{{ $all_item_price2 }} </td>
                                            <td style="padding: 0px;" class="text-center">
                                                {{-- {{ number_format($total_percent2, 2, '.', '') }}% --}}
                                            </td>
                                        </tr>

                                        {{-- อื่นๆ --}}
                                        @php
                                        $total_weight_number3=0;
                                        $total_unit_number3=0;
                                        $all_item_price3=0;
                                        $total_percent3=0;
                                        @endphp
                                        @foreach ($shop_sales_report as $report3) 
                                            @if ($report3->sku_group == "สินค้า(ทั่วไป)" && $report3->sku_name == "โชห่วย")
                                            <tr>
                                                    <td style="padding: 0px;" class="text-center"></td>
                                                    <td style="padding: 0px;" class="text-center">{{ $report3->item_code }}</td>
                                                    <td style="padding: 0px;" class="text-center">{{ $report3->item_name }}</td>
                                                    <td style="padding: 0px;" class="text-center">{{ $report3->unit }}</td>
                                                    <td style="padding: 0px;" class="text-center">{{ $report3->weight_number }} 
                                                            @php 
                                                            if ($report3->unit == 'กิโลกรัม') {
                                                                $total_weight_number3 = $total_weight_number3 + floatval($report3->weight_number);
                                                            } else {
                                                                $total_unit_number3 = $total_unit_number3 + floatval($report3->weight_number);
                                                            }
                                                            @endphp
                                                    </td>
                                                    <td style="padding: 0px;" class="text-center">{{ $report3->price_unit }}</td>
                                                    <td style="padding: 0px;" class="text-center">{{ $report3->total_price }} @php $all_item_price3 = $all_item_price3 + $report3->total_price @endphp</td>
                                                    <td style="padding: 0px;" class="text-center">
                                                        {{-- {{ number_format(($report3->weight_number*100)/floatval(1), 2, '.', '') }}%
                                                    @php
                                                        $total_percent3 = $total_percent3 + ($report3->weight_number*100)/floatval(1);
                                                    @endphp --}}
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        <tr style="background-color:#aef9ff;">
                                            <td style="padding: 0px;" class="text-center" >รวม</td>
                                            <td style="padding: 0px;" class="text-center" >รวมขายโชห่วย</td>
                                            <td style="padding: 0px;" class="text-center" ></td>
                                            <td style="padding: 0px;" class="text-center" ></td>
                                            <td style="padding: 0px;" class="text-center" >{{ $total_unit_number3 }} ชิ้น</td>
                                            <td style="padding: 0px;" class="text-center" ></td>
                                            <td style="padding: 0px;" class="text-center" >{{ $all_item_price3 }} </td>
                                            <td style="padding: 0px;" class="text-center">
                                                {{-- {{ number_format($total_percent3, 2, '.', '') }}% --}}
                                            </td>
                                        </tr>
                                        <tr style="background-color:#0dedff;">
                                            <td style="padding: 0px;" class="text-center" >รวม</td>
                                            <td style="padding: 0px;" class="text-center" >รวมทั้งหมด</td>
                                            <td style="padding: 0px;" class="text-center" ></td>
                                            <td style="padding: 0px;" class="text-center" ></td>
                                            <td style="padding: 0px;" class="text-center" >{{ $total_weight_number + $total_weight_number2 + $total_weight_number3 }} กก. | 
                                                                                            {{ $total_unit_number + $total_unit_number2 + $total_unit_number3 }} ชิ้น</td></td>
                                            <td style="padding: 0px;" class="text-center" ></td>
                                            <td style="padding: 0px;" class="text-center" >{{ $all_item_price + $all_item_price2 + $all_item_price3 }} </td>
                                            <td style="padding: 0px;" class="text-center">
                                                {{-- {{ number_format($total_percent3, 2, '.', '') }}% --}}
                                            </td>
                                        </tr>
                                        <tr>
                                                <td style="padding: 0px;" class="text-center"></td>
                                                <td style="padding: 0px;" class="text-center"><b>สรุปรายการขายหมู</b></td>
                                                <td style="padding: 0px;" class="text-center"><b>รายการ</b></td>
                                                <td style="padding: 0px;" class="text-center"><b>น้ำหนัก,จำนวน</b></td>
                                                <td style="padding: 0px;" class="text-center"></td>
                                                <td style="padding: 0px;" class="text-center"></td>
                                                <td style="padding: 0px;" class="text-center"><b>เป็นเงิน</b></td>
                                                <td style="padding: 0px;" class="text-center"><b>%</b></td>
                                        </tr>
                                        {{-- สรุปรายการขายหมู --}}
                                        @php
                                        $total_weight_number4=0;
                                        $total_unit_number4 =0;
                                        $all_item_price4=0;
                                        $total_percent4=0;
                                        @endphp
                                        @foreach ($summary_report_shop as $report4) 
                                            <tr >
                                                <td style="padding: 0px;" class="text-center"></td>
                                                <td style="padding: 0px;" class="text-center"></td>
                                                <td style="padding: 0px;" class="text-center">{{ $report4->sku_name }}</td>
                                                <td style="padding: 0px;" class="text-center">{{ $report4->sum_weight_number }}
                                                        @php 
                                                        if ($report4->unit == 'กิโลกรัม') {
                                                            $total_weight_number4 = $total_weight_number4 + floatval($report4->sum_weight_number);
                                                        } else {
                                                            $total_unit_number4 = $total_unit_number4 + floatval($report4->sum_weight_number);
                                                        }
                                                        @endphp
                                                    </td>
                                                <td style="padding: 0px;" class="text-center"></td>
                                                <td style="padding: 0px;" class="text-center"></td>
                                                <td style="padding: 0px;" class="text-center">{{ $report4->sum_total_price }} @php $all_item_price4 = $all_item_price4 + $report4->sum_total_price @endphp</td>
                                                <td style="padding: 0px;" class="text-center">
                                                    {{ number_format(($report4->sum_weight_number*100)/floatval($sum_weight_number), 2, '.', '') }}%
                                                @php
                                                    $total_percent4 = $total_percent4 + ($report4->sum_weight_number*100)/floatval($sum_weight_number);
                                                @endphp
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr style="background-color:#fd7174;">
                                            <th style="padding: 0px;" class="text-center"></th>
                                            <th style="padding: 0px;" class="text-center">รวม</th>
                                            <th style="padding: 0px;" class="text-center"></th>
                                            <th style="padding: 0px;" class="text-center">{{ number_format($total_weight_number4, 2, '.', '') }} กก. | {{ $total_unit_number4 }} ชิ้น</th>
                                            <th style="padding: 0px;" class="text-center" >{{ $total_weight_number }} กก. | {{ $total_unit_number }} ชิ้น</th>
                                            <th style="padding: 0px;" class="text-center" >{{ number_format($all_pig_price/$total_weight_number, 2, '.', '') }}/กก. | {{ ( $total_unit_number == 0 ? 0 : number_format(($all_item_price-$all_pig_price)/$total_unit_number, 2, '.', '') ) }}/ชิ้น</th>
                                            <th style="padding: 0px;" class="text-center">{{ number_format($all_item_price4, 2, '.', '') }} </th>
                                            <th style="padding: 0px;" class="text-center">{{ number_format($total_percent4, 2, '.', '') }}%</th>
                                        </tr>
                                    </tbody>
                                        
                                </table>
                                <hr>
                                <div class="col-lg-4"><h2 style="color:red;margin-bottom: 0px;height: 0px;">ข้อมูลการขายแยกสาขา</h2></div><br><br><br>
                                <table class="table table-striped table-bordered nowrap" width="100%" id="report_shop_unique">
                                    <thead class="text-center">
                                        <tr>
                                        <th style="padding: 0px;" class="text-center">No.</th>
                                        <th style="padding: 0px;" class="text-center">ร้านค้า</th>
                                        <th style="padding: 0px;" class="text-center">ประจำวันที่</th>
                                        <th style="padding: 0px;" class="text-center">ดำเนินการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($find_shop as $today)
                                            <tr>
                                                <td style="padding: 0px;" class="text-center"></td>
                                                <td style="padding: 0px;" class="text-center">{{ $today->shop_name }}</td>
                                                <td style="padding: 0px;" class="text-center">         
                                                    @if (strlen($today->date_today) > 10) 
                                                        {{ $today->date_today }}
                                                    @else
                                                    {{  substr($today->date_today ,3,2).'/'.substr($today->date_today ,0,2).'/'.substr($today->date_today ,6,4) }}
                                                    @endif
                                                </td>
                                                <td style="padding: 0px;" class="text-center"><a class="btn btn-warning" target="blank_" href="{{url('/report_shop_level2/'.$today->shop_name.'/'.$id )}}">ตรวจสอบ</a>
                                                    <button  style="padding: 7px;" type="button" class="btn btn-danger"
                                                    onclick="deleteRecord('{{ $today->shop_name }}','{{ $today->date_today }}')">
                                                    <i class="fa fa-trash"></i></button>
                                                </td>
                                            </tr>
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
        var table = $('#report_shop').DataTable({
            lengthMenu: [[200, -1], [200, "All"]],
            "scrollX": false,
            orderCellsTop: true,
            fixedHeader: true,
            rowReorder: true,
            dom: 'lBfrtip',
            buttons: [
                {
                extend: 'excel',
                messageTop: "ข้อมูลการขายรวมสาขา\
                    ประจำวันที่ {{ $shop_sales_report[0]->date_today =='' ? '' : substr($shop_sales_report[0]->date_today,3,2).'/'.substr($shop_sales_report[0]->date_today,0,2).'/'.substr($shop_sales_report[0]->date_today,6,4)  }}"
                },
            ],
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

<script>
    function deleteRecord(shop_name,date_today){
        if(confirm('ต้องการลบ : '+shop_name+' วันที่ '+date_today+' ?')){
            $.ajax({
                type: 'GET',
                url: '{{ url('delete_import') }}',
                data: {shop_name:shop_name,date_today:date_today},
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

{{-- daterange --}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script>
    $('#daterange').daterangepicker({
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


