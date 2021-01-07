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
{{-- <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" /> --}}
<link rel="stylesheet" href="{{ asset('assets/css/daterangepicker.css')}}">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" />

@endsection
@section('main')
              <div class="col-lg-12 grid-margin">
                <div class="card">
                  <div class="card-body">

                        <div class="table-responsive">
                            <h3 style="color:black;margin-bottom: 0px;height: 0px;"  class="text-center" > รายงานการชั่งน้ำหนัก : {{ $order_number }}</h3>
                            <div class="row">
                                <div class="col-6" style="padding-top: 50px;">
                                    <h4 class="text-center" style="color:blue;margin-bottom: 0px;height: 0px;">ชั่งซีกออกจาก Overnight
                                        @php
                                            if (!empty($select_in_after_ov[0]->weighing_date)) {
                                                echo (substr($select_in_after_ov[0]->weighing_date,8,2).'/'.substr($select_in_after_ov[0]->weighing_date,5,2).'/'.substr($select_in_after_ov[0]->weighing_date,0,4) );
                                            }
                                        @endphp
                                    </h4><br><br>
                                    <table class="tbl table-hover " width="100%" border="1" id="orderOffalW">
                                        <thead class="text-center">
                                            <tr style="background-color:#7dbeff">
                                            <th style="padding: 0px;">No.</th>
                                            <th style="padding: 0px;">จุดชั่ง</th>
                                            <th style="padding: 0px;">Item code</th>
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
                                            @if (!empty($select_in_after_ov))
                                                @foreach ($select_in_after_ov as $in_OF)
                                                <tr>
                                                    <td class="text-center" style="padding: 0px;">{{ $count++ }}</td>
                                                    <td class="text-center" style="padding: 0px;">{{ $in_OF->scale_number }}</td>
                                                    <td class="text-center" style="padding: 0px;">{{ $in_OF->sku_code }}</td>
                                                    <td class="text-center" style="padding: 0px;">{{ number_format($in_OF->sku_weight, 2, '.', '') }}
                                                        @php
                                                            $sum_weight = $sum_weight +$in_OF->sku_weight;
                                                        @endphp
                                                    </td>
                                                    <td class="text-center" style="padding: 0px;">{{ $in_OF->sku_amount }}
                                                        @php
                                                            $sum_unit = $sum_unit +$in_OF->sku_amount;
                                                        @endphp
                                                        </td>
                                                    <td class="text-center" style="padding: 0px;">{{ substr($in_OF->weighing_date,11,8) }}</td>
                                                </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                        <tfoot>
                                            <tr style="background-color:#ff8080">
                                                <th class="text-center" style="padding: 0px;"></th>
                                                <th class="text-center" style="padding: 0px;"></th>
                                                <th class="text-center" style="padding: 0px;"></th>
                                                <th class="text-center" style="padding: 0px;">รวม</th>
                                                <th class="text-center" style="padding: 0px;">{{ number_format($sum_weight) }}</th>
                                                <th class="text-center" style="padding: 0px;">{{ number_format($sum_unit)  }}</th>
    
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                <div class="col-6" style="padding-top: 50px;">
                                    <h4 class="text-center" style="color:blue;margin-bottom: 0px;height: 0px;">ชั่งออก ตัดแต่ง
                                    @php
                                        if (!empty($select_in_cutting[0]->weighing_date)) {
                                            echo (substr($select_in_cutting[0]->weighing_date,8,2).'/'.substr($select_in_cutting[0]->weighing_date,5,2).'/'.substr($select_in_cutting[0]->weighing_date,0,4) );
                                        }
                                    @endphp</h4><br><br>
                                    <table class="tbl table-hover" width="100%" border="1" id="orderOffalR">
                                        <thead class="text-center">
                                            <tr style="background-color:#7dbeff">
                                            <th style="padding: 0px;">No.</th>
                                            <th style="padding: 0px;">จุดชั่ง</th>
                                            <th style="padding: 0px;">Item code</th>
                                            <th style="padding: 0px;">Item name</th>
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
                                            @if (!empty($select_in_cutting))
                                                @foreach ($select_in_cutting as $in_SH)
                                                <tr>
                                                    <td class="text-center" style="padding: 0px;">{{ $count++ }}</td>
                                                    <td class="text-center" style="padding: 0px;">{{ $in_SH->scale_number }}</td>
                                                    <td class="text-center" style="padding: 0px;">{{ $in_SH->sku_code }}</td>
                                                    <td class="text-center" style="padding: 0px;">{{ $in_SH->item_name }}</td>
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
                                            <tr style="background-color:#ff8080">
                                                <th class="text-center" style="padding: 0px;"></th>
                                                <th class="text-center" style="padding: 0px;"></th>
                                                <th class="text-center" style="padding: 0px;"></th>
                                                <th class="text-center" style="padding: 0px;">รวม</th>
                                                <th class="text-center" style="padding: 0px;">{{ number_format($sum_weight) }}</th>
                                                <th class="text-center" style="padding: 0px;">{{ number_format($sum_unit)  }}</th>
                                                <th class="text-center" style="padding: 0px;" ></td>
    
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
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
            var table1 = $('#orderOffalW').DataTable({
                lengthMenu: [[50, 100, -1], [50, 100, "All"]],
                dom: 'Bfrtp',
                buttons: [
                    { extend: 'excelHtml5', footer: true },
                //  'pdf', 'print'
            ],
            });
            var table2 = $('#orderOffalR').DataTable({
                lengthMenu: [[50, 100, -1], [50, 100, "All"]],
                dom: 'Bfrtp',
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


@endsection


