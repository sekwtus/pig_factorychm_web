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
                                @php
                                   $arr_fac = array('KMK01','KMK02','KMK03','KMK04','KMK05','KMK06','KMK07','KMK08','KMK09','KMK10','KMK11','KMK12');
                                   $arr_shop = array('MK01','MK02','MK03','MK04','MK05','MK06','MK07','MK08','MK09','MK10','MK11','MK12');
                                @endphp
                                @for ($i = 0; $i < count($arr_fac); $i++)
                                    <div class="col-3" style="padding-top: 50px;">
                                        <h4 class="text-center" style="color:blue;margin-bottom: 0px;height: 0px;">{{ $arr_fac[$i] }}</h4><br><br>
                                        <table class="tbl table-hover " width="100%" border="1" id="order{{ $i }}">
                                            <thead class="text-center">
                                                <tr style="background-color:#7dbeff">
                                                    <th style="padding: 0px;">Item code</th>
                                                    <th style="padding: 0px;">นน.</th>
                                                    <th style="padding: 0px;">จำนวน</th>
                                                    <th style="padding: 0px;">ประเภท</th>
                                                    <th style="padding: 0px;">เวลาชั่ง</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $sum_weight=0;
                                                    $sum_unit=0;
                                                @endphp
                                                @if (!empty($data))
                                                    @foreach ($data as $data_)
                                                    @if ($data_->scale_number == $arr_fac[$i] )
                                                        <tr>
                                                            <td class="text-center" style="padding: 0px;">{{ $data_->sku_code }}</td>
                                                            <td class="text-center" style="padding: 0px;">{{ number_format($data_->sku_weight, 2, '.', '') }}
                                                                @php
                                                                    $sum_weight = $sum_weight +$data_->sku_weight;
                                                                @endphp
                                                            </td>
                                                            <td class="text-center" style="padding: 0px;">{{ $data_->sku_amount }}
                                                                @php
                                                                    $sum_unit = $sum_unit +$data_->sku_amount;
                                                                @endphp
                                                            </td>
                                                            <td class="text-center" style="padding: 0px;">{{ $data_->weighing_type }}</td>
                                                            <td class="text-center" style="padding: 0px;">{{ substr($data_->weighing_date,11,8) }}</td>
                                                        </tr>
                                                    @endif
                                                    @endforeach
                                                @endif
                                            </tbody>
                                            <tfoot>
                                                <tr style="background-color:#7dbeff">
                                                    <th class="text-center" style="padding: 0px;">รวม</th>
                                                    <th class="text-center" style="padding: 0px;">{{ number_format($sum_weight) }}</th>
                                                    <th class="text-center" style="padding: 0px;">{{ number_format($sum_unit)  }}</th>
                                                    <th class="text-center" style="padding: 0px;" ></td>
                                                    <th class="text-center" style="padding: 0px;" ></td>
                                                </tr>
                                            </tfoot>
                                            
                                        </table>
                                    </div>
                                @endfor

                                @for ($i = 0; $i < count($arr_shop); $i++)
                                    <div class="col-3" style="padding-top: 50px;">
                                        <h4 class="text-center" style="color:blue;margin-bottom: 0px;height: 0px;">{{ $arr_shop[$i] }}</h4><br><br>
                                        <table class="tbl table-hover " width="100%" border="1" id="orders{{ $i }}">
                                            <thead class="text-center">
                                                <tr style="background-color:#ff7575">
                                                <th style="padding: 0px;">Item code</th>
                                                <th style="padding: 0px;">นน.</th>
                                                <th style="padding: 0px;">จำนวน</th>
                                                <th style="padding: 0px;">ประเภท</th>
                                                <th style="padding: 0px;">เวลาชั่ง</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $sum_weight=0;
                                                    $sum_unit=0;
                                                @endphp
                                                @if (!empty($data))
                                                    @foreach ($data as $data_)
                                                    @if ($data_->scale_number == $arr_shop[$i] )
                                                        <tr>
                                                            <td class="text-center" style="padding: 0px;">{{ $data_->sku_code }}</td>
                                                            <td class="text-center" style="padding: 0px;">{{ number_format($data_->sku_weight, 2, '.', '') }}
                                                                @php
                                                                    $sum_weight = $sum_weight +$data_->sku_weight;
                                                                @endphp
                                                            </td>
                                                            <td class="text-center" style="padding: 0px;">{{ $data_->sku_amount }}
                                                                @php
                                                                    $sum_unit = $sum_unit +$data_->sku_amount;
                                                                @endphp
                                                            </td>
                                                            <td class="text-center" style="padding: 0px;">{{ $data_->weighing_type }}</td>
                                                            <td class="text-center" style="padding: 0px;">{{ substr($data_->weighing_date,11,8) }}</td>
                                                        </tr>
                                                    @endif
                                                    @endforeach
                                                @endif
                                            </tbody>
                                            <tfoot>
                                                <tr style="background-color:#ff7575">
                                                    <th class="text-center" style="padding: 0px;">รวม</th>
                                                    <th class="text-center" style="padding: 0px;">{{ number_format($sum_weight) }}</th>
                                                    <th class="text-center" style="padding: 0px;">{{ number_format($sum_unit)  }}</th>
                                                    <th class="text-center" style="padding: 0px;" ></td>
                                                    <th class="text-center" style="padding: 0px;" ></td>
                                                </tr>
                                            </tfoot>
                                            
                                        </table>
                                    </div>
                                @endfor

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
       for (let i = 0; i < 12; i++) {
           var table = $('#order'+i).DataTable({
                lengthMenu: [[20, 100, -1], [20, 100, "All"]],
                dom: 'lBfrtp',
                buttons: [
                    // { extend: 'excelHtml5', footer: true },
                //  'pdf', 'print'
            ],
            });
       }

       for (let i = 0; i < 12; i++) {
           var table = $('#orders'+i).DataTable({
                lengthMenu: [[20, 100, -1], [20, 100, "All"]],
                dom: 'lBfrtp',
                buttons: [
                    // { extend: 'excelHtml5', footer: true },
                //  'pdf', 'print'
            ],
            });
       }

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


