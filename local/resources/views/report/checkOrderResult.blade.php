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
                    <h2 class="text-center" style="margin-bottom: 0px;height: 0px;">รายงานตรวจสอบน้ำหนักชิ้นส่วนสุกรในกระบวนการผลิต</h2><br><br>
                        <div class="row">
                                <div class="col-12 px-0">
                                <table id="tbl-1" class="tbl" width="100%" border="1">
                                    <tbody>
                                        <tr class="bg-secondary text-center">
                                            <th width="100%">ข้อมูลทั่วไป</th>
                                        </tr>
                                        <tr>
                                            <td id="td-detail" valign="top">
                                            @foreach ($total_weight_in_order as $order_)
                                                <div class="row py-1">
                                                    <div class="col-md-6 col-lg-3 pr-lg-0">
                                                    ORDER : <b>{{ $order_->lot_number }}</b>
                                                    </div>
                                                    <div class="col-md-6 col-lg-2 pr-lg-0">
                                                    สาขา : <b>{{ $order_->id_user_customer }}</b>
                                                    </div>
                                                    <div class="col-md-6 col-lg-2 pr-lg-0">
                                                    วันที่ Order : <b>{{ $order_->date }}</b>
                                                    </div>
                                                    <div class="col-md-6 col-lg-3 pr-lg-0 ">
                                                    วันที่จัดส่ง : <b style="color:red;">{{ $order_->plan_sending }}</b>
                                                    </div>
                                                    <div class="col-md-6 col-lg-2 pr-lg-0">
                                                    จำนวนที Order : <b>{{ $order_->total_pig }} </b>ตัว
                                                    </div>
                                                </div>
                                                <div class="row py-1">
                                                    @php
                                                        $total_ = 0;
                                                    @endphp
                                                    <div class="col-md-6 col-lg-3 pr-lg-0">
                                                        ช่วงน้ำหนัก : <b>{{ $order_->weight_range }}</b> กิโลกรัม
                                                    </div>
                                                    <div class="col-md-6 col-lg-3 pr-lg-0">
                                                        จำนวนที่ชั่ง : <b>{{ $order_->count_weight }}</b> ตัว
                                                    </div>
                                                    <div class="col-md-6 col-lg-3 pr-lg-0">
                                                    <b>น้ำหนักขุนรวม : 
                                                        {{ $order_->sum_weight }}
                                                        @php
                                                            $total_ = $order_->sum_weight;
                                                        @endphp
                                                    </b> กิโลกรัม
                                                    </div>
                                                    <div class="col-md-6 col-lg-3 pr-lg-0">เฉลี่ยน้ำหนัก <b> 
                                                        @if ($order_->total_pig != 0)
                                                        {{  number_format((float)(($order_->sum_weight/$order_->total_pig)), 2, '.', '') }}
                                                        @endif
                                                    </b> กิโลกรัม/ตัว</div>
                                                </div>
                                             @endforeach
                                            </td>
                                        </tr>
                                        <br>
                                  </tbody>
                                </table>

                                <table id="tbl-3" class="tbl" width="100%" border="1">
                                    <tbody>
                                        <tr class="bg-secondary text-center">
                                            <th width="25%">น้ำหนักชิ้นส่วน (โรงงาน)</th>
                                            <th width="25%">น้ำหนักชิ้นส่วน (ร้านค้า)</th>
                                            <th width="34%">ผลต่าง (dift)</th>
                                        </tr>
                                        <tr>
                                            <td id="td-conclusion-tooth" valign="top">
                                                <div class="table-responsive">
                                                    @php $sum_weight_factory = 0;
                                                         $sum_unit_factory = 0; 
                                                         $sum_yiled_factory =0;
                                                         $count = 1;
                                                    @endphp 
                                                    {{-- ตัวแปร น้ำหนักรวม ยีลรวม --}}
                                                    <table class="table table-striped table-bordered nowrap table-hover" width="100%" id="Orderfactory">
                                                    <thead class="text-center">
                                                        <tr>
                                                        <th style="padding: 0px;">No.</th>
                                                        <th style="padding: 0px;">รหัส item </th>
                                                        <th style="padding: 0px;">ชื่อ item </th>
                                                        <th style="padding: 0px;">น้ำหนัก(กก.)</th>
                                                        <th style="padding: 0px;">จำนวน(ถุง)</th>
                                                        <th style="padding: 0px;">%Yiled จาก นน.ขุน</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($select_order_result as $result)
                                                        <tr>
                                                            <td class="text-center" style="padding: 0px;">{{ $count++ }}</td>
                                                            <td class="text-center" style="padding: 0px;">{{ $result->item_code }}</td>
                                                            <td class="text-center" style="padding: 0px;">{{ $result->item_name }}</td>
                                                            <td class="text-center" style="padding: 0px;">{{ empty($result->sum_weight) ? 0 : $result->sum_weight }}
                                                                @php
                                                                    $sum_weight_factory = $sum_weight_factory + $result->sum_weight;
                                                                @endphp
                                                            </td>
                                                            <td class="text-center" style="padding: 0px;">{{ empty($result->sum_unit) ? 0 : $result->sum_unit }}
                                                                @php
                                                                    $sum_unit_factory = $sum_unit_factory + $result->sum_unit;
                                                                @endphp
                                                            </td>
                                                            <td class="text-center" style="padding: 0px;"> {{ number_format((float)(($result->sum_weight/$total_)*100), 2, '.', '') }}%
                                                                @php
                                                                    $sum_yiled_factory = $sum_yiled_factory + number_format((float)(($result->sum_weight/$total_)*100), 2, '.', '');
                                                                @endphp
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                        <tr style="background-color:#f99d1b57;"><td class="text-center" style="padding: 0px;" colspan="6"><b>แปรรูป</b></td></tr>
                                                        @foreach ($select_order_result_transform as $result)
                                                        <tr>
                                                            <td class="text-center" style="padding: 0px;">{{ $count++ }}</td>
                                                            <td class="text-center" style="padding: 0px;">{{ $result->item_code }}</td>
                                                            <td class="text-center" style="padding: 0px;">{{ $result->item_name }}</td>
                                                            <td class="text-center" style="padding: 0px;">{{ empty($result->sum_weight) ? 0 : $result->sum_weight }}
                                                                @php
                                                                    $sum_weight_factory = $sum_weight_factory + $result->sum_weight;
                                                                @endphp
                                                            </td>
                                                            <td class="text-center" style="padding: 0px;">{{ empty($result->sum_unit) ? 0 : $result->sum_unit }}
                                                                @php
                                                                    $sum_unit_factory = $sum_unit_factory + $result->sum_unit;
                                                                @endphp
                                                            </td>
                                                            <td class="text-center" style="padding: 0px;"> {{ number_format((float)(($result->sum_weight/$total_)*100), 2, '.', '') }}%
                                                                @php
                                                                    $sum_yiled_factory = $sum_yiled_factory + number_format((float)(($result->sum_weight/$total_)*100), 2, '.', '');
                                                                @endphp
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                    </table>
                                                    <table class="table table-striped table-bordered nowrap table-hover" width="100%" id="">
                                                        <tbody>
                                                            <tr style="background-color:#ffbeba;">
                                                                <td class="text-center" style="padding: 0px;" rowspan="2"> น้ำหนักรวม <b>{{ $sum_weight_factory }}</b> กิโลกรัม</td>
                                                                <td class="text-center" style="padding: 0px;" rowspan="2"><b>{{ $sum_unit_factory }}</b> ถุง</td>
                                                                <td class="text-center" style="padding: 0px;" rowspan="2">%Yiled จาก นน.ขุน <b>{{ number_format((float)$sum_yiled_factory, 2, '.', '') }}%</b></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </td>
                                               
                                            <td id="td-conclusion-tooth" valign="top">
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-bordered nowrap table-hover" width="100%" id="OrderShop">
                                                    <thead class="text-center">
                                                        <tr>
                                                        <th style="padding: 0px;">No.</th>
                                                        <th style="padding: 0px;">รหัส item </th>
                                                        <th style="padding: 0px;">ชื่อ item </th>
                                                        <th style="padding: 0px;">น้ำหนัก(กก.)</th>
                                                        <th style="padding: 0px;">จำนวน(ถุง)</th>
                                                        <th style="padding: 0px;">%Yiled จาก นน.แกะ</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php $sum_weight_shop = 0;
                                                            $sum_unit_shop = 0; 
                                                            $sum_yiled_shop =0;
                                                            $count = 1;
                                                            $sum_weight_factory != 0 ? $sum_weight_factory = $sum_weight_factory : $sum_weight_factory = 1;
                                                        @endphp 
                                                        @foreach ($select_shop_result as $result)
                                                        <tr>
                                                            <td class="text-center" style="padding: 0px;">{{ $count++ }}</td>
                                                            <td class="text-center" style="padding: 0px;">{{ $result->item_code }}</td>
                                                            <td class="text-center" style="padding: 0px;">{{ $result->item_name }}</td>
                                                            <td class="text-center" style="padding: 0px;">{{ empty($result->sum_weight) ? 0 : $result->sum_weight }}
                                                                @php
                                                                    $sum_weight_shop = $sum_weight_shop + $result->sum_weight;
                                                                @endphp
                                                            </td>
                                                            <td class="text-center" style="padding: 0px;">{{ empty($result->sum_unit) ? 0 : $result->sum_unit }}
                                                                @php
                                                                    $sum_unit_shop = $sum_unit_shop + $result->sum_unit;
                                                                @endphp
                                                            </td>
                                                            <td class="text-center" style="padding: 0px;">{{ number_format((float)(($result->sum_weight/$sum_weight_factory)*100), 2, '.', '') }}%
                                                                @php
                                                                    $sum_yiled_shop = $sum_yiled_shop + number_format((float)(($result->sum_weight/$sum_weight_factory)*100), 2, '.', '');
                                                                @endphp
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                        <tr style="background-color:#f99d1b57;"><td class="text-center" style="padding: 0px;" colspan="6"><b>แปรรูป</b></td></tr>
                                                        @foreach ($select_shop_result_transform as $result)
                                                        <tr>
                                                            <td class="text-center" style="padding: 0px;">{{ $count++ }}</td>
                                                            <td class="text-center" style="padding: 0px;">{{ $result->item_code }}</td>
                                                            <td class="text-center" style="padding: 0px;">{{ $result->item_name }}</td>
                                                            <td class="text-center" style="padding: 0px;">{{ empty($result->sum_weight) ? 0 : $result->sum_weight }}
                                                                @php
                                                                    $sum_weight_shop = $sum_weight_shop + $result->sum_weight;
                                                                @endphp
                                                            </td>
                                                            <td class="text-center" style="padding: 0px;">{{ empty($result->sum_unit) ? 0 : $result->sum_unit }}
                                                                @php
                                                                    $sum_unit_shop = $sum_unit_shop + $result->sum_unit;
                                                                @endphp
                                                            </td>
                                                            <td class="text-center" style="padding: 0px;">{{ number_format((float)(($result->sum_weight/$sum_weight_factory)*100), 2, '.', '') }}%
                                                                @php
                                                                    $sum_yiled_shop = $sum_yiled_shop + number_format((float)(($result->sum_weight/$sum_weight_factory)*100), 2, '.', '');
                                                                @endphp
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                    </table>
                                                    <table class="table table-striped table-bordered nowrap table-hover" width="100%" id="">
                                                        <tbody>
                                                            <tr style="background-color:#ffbeba;">
                                                                <td class="text-center" style="padding: 0px;" rowspan="2"> น้ำหนักรวม <b>
                                                                    {{ $sum_weight_shop }}
                                                                </td>
                                                                <td class="text-center" style="padding: 0px;" rowspan="2"><b>{{ $sum_unit_shop }}</b> ถุง</td>
                                                                <td class="text-center" style="padding: 0px;" rowspan="2">%Yiled จาก นน.แกะ <b>{{ number_format((float)$sum_yiled_shop, 2, '.', '') }}%</b></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </td>

                                            <td id="td-conclusion-tooth" valign="top">
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-bordered nowrap table-hover" width="100%" id="OrderDift">
                                                        <thead class="text-center">
                                                            <tr>
                                                            <th style="padding: 0px;">No.</th>
                                                            <th style="padding: 0px;">ชื่อ item </th>
                                                            <th style="padding: 0px;">น้ำหนัก</th>
                                                            <th style="padding: 0px;">จำนวนถุง</th>
                                                            <th style="padding: 0px;">% สูญเสีย (Loss)</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php $sum_weight_dift = 0;
                                                                $sum_unit_dift = 0; 
                                                                $sum_yiled_dift =0;
                                                                $count = 1;
                                                            @endphp 
                                                            @foreach ($select_order_result as $result)
                                                                @foreach ($select_shop_result as $result2)
                                                                    @if ($result->item_name == $result2->item_name )
                                                                        <tr>
                                                                            <td class="text-center" style="padding: 0px;">{{ $count++ }}</td>
                                                                            <td class="text-center" style="padding: 0px;">{{ $result->item_name }}</td>
                                                                            <td class="text-center" style="padding: 0px;">{{ number_format( (float)($result2->sum_weight)-($result->sum_weight), 2, '.', '') }}
                                                                                @php
                                                                                    $sum_weight_dift = $sum_weight_dift + number_format( (float)($result2->sum_weight)-($result->sum_weight), 2, '.', '');
                                                                                @endphp
                                                                            </td>
                                                                            <td class="text-center" style="padding: 0px;">{{ $result2->sum_unit - $result->sum_unit }}
                                                                                @php
                                                                                    $sum_unit_dift = $sum_unit_dift + ($result2->sum_unit - $result->sum_unit);
                                                                                @endphp
                                                                            </td>
                                                                            <td class="text-center" style="padding: 0px;">{{ number_format((float)( ( (($result2->sum_weight)-($result->sum_weight))*100 /$sum_weight_factory) ), 2, '.', '') }}%
                                                                                @php
                                                                                    $sum_yiled_dift = $sum_yiled_dift + number_format((float)( ( (($result2->sum_weight)-($result->sum_weight))*100 /$sum_weight_factory) ), 2, '.', '');
                                                                                @endphp
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                @endforeach
                                                            @endforeach
                                                            <tr style="background-color:#f99d1b57;"><td class="text-center" style="padding: 0px;" colspan="6"><b>แปรรูป</b></td></tr>
                                                            @foreach ($select_order_result_transform as $result)
                                                            @foreach ($select_shop_result_transform as $result2)
                                                                @if ($result->item_name == $result2->item_name )
                                                                    <tr>
                                                                        <td class="text-center" style="padding: 0px;">{{ $count++ }}</td>
                                                                        <td class="text-center" style="padding: 0px;">{{ $result->item_name }}</td>
                                                                        <td class="text-center" style="padding: 0px;">{{ number_format( (float)($result2->sum_weight)-($result->sum_weight), 2, '.', '') }}
                                                                            @php
                                                                                $sum_weight_dift = $sum_weight_dift + number_format( (float)($result2->sum_weight)-($result->sum_weight), 2, '.', '');
                                                                            @endphp
                                                                        </td>
                                                                        <td class="text-center" style="padding: 0px;">{{ $result2->sum_unit - $result->sum_unit }}
                                                                            @php
                                                                                $sum_unit_dift = $sum_unit_dift + ($result2->sum_unit - $result->sum_unit);
                                                                            @endphp
                                                                        </td>
                                                                        <td class="text-center" style="padding: 0px;">{{ number_format((float)( ( (($result2->sum_weight)-($result->sum_weight))*100 /$sum_weight_factory) ), 2, '.', '') }}%
                                                                            @php
                                                                                $sum_yiled_dift = $sum_yiled_dift + number_format((float)( ( (($result2->sum_weight)-($result->sum_weight))*100 /$sum_weight_factory) ), 2, '.', '');
                                                                            @endphp
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            @endforeach
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                    <table class="table table-striped table-bordered nowrap table-hover" width="100%" id="">
                                                        <tbody>
                                                            <tr style="background-color:red;">
                                                                <td class="text-center" style="padding: 0px;" rowspan="2"> น้ำหนักรวม <b>
                                                                    {{ $sum_weight_dift }}
                                                                </td>
                                                                <td class="text-center" style="padding: 0px;" rowspan="2">%Yiled จาก นน.แกะ <b>{{ number_format((float)$sum_yiled_dift, 2, '.', '') }}%</b></td>
                                                                <td class="text-center" style="padding: 0px;" rowspan="2"><b>{{ $sum_unit_dift }}</b> ถุง</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </td>

                                        </tr>
                                    </tbody>
                                </table>
                                </div>
                              </div>

                      <hr>
                        

                    
                      </div>
                   </div>
                </div>

                {{-- ลบข้อมูล --}}
                {{ Form::open(['method' => 'post' , 'url' => '/product/delete/']) }}
                           <div class="modal fade" id="DELETE" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                                  <h4 class="modal-title" id="myModalLabel">ลบรายการรับสุกร-รถบรรทุก</h4>
                                          </div>
                                          <div class="modal-body">
                                                  <h5 >ยืนยันการลบ รายการรับสุกร-รถบรรทุก</h5>
                                          </div>
                                          <div class="modal-footer">
                                              <button type="submit" class="btn btn-danger" id="delete" name="delete" value="delete">ลบ</button>
                                              <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
                                          </div>
                                      </div>
                                  </div>
                           </div>
                {{ Form::close() }}

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

            // var table1 = $('#Orderfactory').DataTable({
            //     lengthMenu: [[, 50, 100, -1], [20, 50, 100, "All"]],
            //     dom: 'rtp',
            // });
            // var table2 = $('#OrderShop').DataTable({
            //     lengthMenu: [[20, 50, 100, -1], [20, 50, 100, "All"]],
            //     dom: 'rtp',
            // });
            // var table2 = $('#OrderDift').DataTable({
            //     lengthMenu: [[20, 50, 100, -1], [20, 50, 100, "All"]],
            //     dom: 'rtp',
            // });
            

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


