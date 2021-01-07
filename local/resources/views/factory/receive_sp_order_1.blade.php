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
        text-align: center;
    }    
    td{
        padding: 0px;
        font-size: 13px;
        text-align: center;
    }
    .bodyzoom{
        zoom: 0.9;
    }

    .outer{
    overflow-y: auto;
    height:550px;
    }

    .outer table{
        width: 100%;
        table-layout: fixed; 
        border : 1px solid black;
        border-spacing: 1px;
    }

    .outer table th {
        top:0;
        border : 1px solid black;
        position: sticky;
    }
</style>

<link rel="stylesheet" href="{{ url('https://cdn.datatables.net/1.10.18/css/dataTables.semanticui.min.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/css/daterangepicker.css')}}">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" />

@endsection
@section('main')

<div class="ajax-loader">
    <img src="{{ asset('assets/images/pig_fly.gif')}}" alt="" style="margin-left: 0px;top: 33%;width: 350px; left:37%;" class="img-responsive"  />
</div>

            <div class="col-lg-12 grid-margin bodyzoom">
                <div class="card">
                    <div class="card-body" style=" padding: 0px; ">
                        {{ Form::open(['method' => 'post' , 'url' => '/shop/sp_summary_weight' , 'id' => 'form_save']) }}
                            <div class="forms-sample form-control" style="height: auto;padding: 0px;">
                                <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;">สั่ง Order พิเศษ</div>
                                
                                <div class="row">
                                    <div class="col-3">
                                    </div>
                                    <div class="col-6">
                                        <div class="col-md-12 pr-md-0">
                                            <div class="form-group row" style=" margin-bottom: 2px; ">
                                                <label class="col-sm-3 col-form-label">ร้านสั่ง Order วันที่</label>
                                                <div class="col-sm-9">
                                                    <input class="form-control form-control-sm" placeholder="วว/ดด/ปปปป" id="datepicker1" type="text" name="datepicker1" value="" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 pr-md-0">
                                            <div class="form-group row" style=" margin-bottom: 2px; ">
                                                <label class="col-sm-3 col-form-label">ชั่งหมู วันที่</label>
                                                <div class="col-sm-9">
                                                    <input class="form-control form-control-sm" placeholder="วว/ดด/ปปปป" id="datepicker2" type="text" name="datepicker2" value="" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 pr-md-0">
                                            <div class="form-group row" style=" margin-bottom: 2px; ">
                                                <label class="col-sm-3 col-form-label">เข้าเชือด วันที่</label>
                                                <div class="col-sm-9">
                                                    <input class="form-control form-control-sm" placeholder="วว/ดด/ปปปป" id="datepicker3" type="text" name="datepicker3" value="" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 pr-md-0">
                                            <div class="form-group row" style=" margin-bottom: 2px; ">
                                                <label class="col-sm-3 col-form-label">โรงงานตัดแต่ง วันที่</label>
                                                <div class="col-sm-9">
                                                    <input class="form-control form-control-sm" placeholder="วว/ดด/ปปปป" id="datepicker4" type="text" name="datepicker4" value="" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 pr-md-0">
                                            <div class="form-group row" style=" margin-bottom: 2px; ">
                                                <label class="col-sm-3 col-form-label">ส่งสินค้าเข้าร้าน วันที่</label>
                                                <div class="col-sm-9">
                                                    <input class="form-control form-control-sm" placeholder="วว/ดด/ปปปป" id="datepicker5" type="text" name="datepicker5" value="" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-12 pr-md-0">
                                            <div class="form-group row" style=" margin-bottom: 2px; ">
                                                <label class="col-sm-3 col-form-label">จำนวนตัว</label>
                                                <div class="col-sm-9">
                                                    <input class="form-control form-control-sm" placeholder="" id="" type="text" name="" value="{{ $request_detail[0]->sum_number_of_pig }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="row">
                                            <div class="col-4 text-right">
                                                <a class="btn btn-success" target="_blank"  href="../receive_sp_order_1_print/{{ $date }}"  style="margin-bottom: 10px;">
                                                    <i class="fa fa-print">พิมพ์รายงานสำหรับเครื่องใน</i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4 text-right">
                                                <a class="btn btn-success" target="_blank"  href="../receive_sp_order_1_print_all/{{ $date }}"  style="margin-bottom: 10px;">
                                                    <i class="fa fa-print">พิมพ์รายงานทั้งหมด</i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div><br>

                                    {{-- <div class="row text-center" style="margin-bottom: 10px;">
                                        <div class="col-md-3 pr-md-0 text-center">
                                            <label for="orderDate">จำนวน (ตัว)</label>
                                            <input class="form-control form-control-sm" placeholder="" id="" type="text" name="" value="{{ $request_detail[0]->sum_number_of_pig }}" required>
                                        </div>
                                    </div> --}}

                                    <div class="outer">
                                        <table  class="tbl table-hover" width="100%" border="1" id="report_shop">
                                            <thead class="text-center ">
                                            <tr style="background-color:#7dbeff" >
                                                <th style="padding: 0px; background-color:#7dbeff" width="2%" rowspan="3">ท่อน</th>
                                                <th style="padding: 0px; background-color:#7dbeff" width="3%" rowspan="3">รหัส</th>
                                                <th style="padding: 0px; background-color:#7dbeff" width="3%" rowspan="3">รายการ</th>
                                                <th style="padding: 0px; background-color:#7dbeff" width="3%" rowspan="3">Yiledชิ้นส่วน /ท่อน (กก.)</th>

                                                @foreach ($shop_list as $shop)
                                                    <th style="padding: 0px; background-color:#7dbeff" colspan="0" width="{{ 50/count($shop_list) }}%;" >{{ $shop->shop_description }} </th>
                                                @endforeach

                                                <th style="padding: 0px; background-color:#7dbeff" width="5%" rowspan="3">น้ำหนักรวม (กก.)</th>
                                                <th style="padding: 0px; background-color:#7dbeff" width="5%" rowspan="3">Yiled/ตัว (กก.)</th>
                                                <th style="padding: 0px; background-color:#7dbeff" width="5%" rowspan="3">Yiled ทั้งหมด (กก.)</th>
                                                <th style="padding: 0px; background-color:#7dbeff" width="5%" rowspan="3">น้ำหนักรวมคงเหลือ (กก.)</th>
                                            </tr>

                                            </thead>
                                            <tbody>
                                                @php
                                                    $group_list = 0;
                                                @endphp
                                                
                                                @foreach ($report_order as $key => $list_item)
                                                <tr >
                                                    @if ( $group_list != $list_item->group)
                                                        @foreach ($count_group as $count_groups)
                                                            @if ($list_item->group == $count_groups->group)
                                                                <tr style="background-color:#edfd80;">
                                                                    <td colspan="4" rowspan="2">{{ $count_groups->group_name }}</td>
                                                                    @foreach ($shop_list as $shop)
                                                                        <td colspan="0"> {{ $shop->marker }} </td>
                                                                    @endforeach
                                                                    <td colspan="0">รวม</td>
                                                                    <td colspan="3"></td>
                                                                </tr>
                                                                <tr style="background-color:#edfd80;">
                                                                    {{-- เช็คสาขาที่มีข้อมูลrequestมา --}}
                                                                    @for ($i = 0; $i < count($shop_list); $i++)
                                                                        @php
                                                                            $check_exist_data[$i] = 0;
                                                                            $shops[$i] = $shop_list[$i]->shop_code;
                                                                        @endphp
                                                                    @endfor
                                                                    @php
                                                                        $sum_req_branch = 0;
                                                                    @endphp
                                                                
                                                                    @foreach ($order_sp_request as $sp_request)
                                                                        @if ($list_item->group == $sp_request->order_special_id)

                                                                            @foreach ($shop_list as $key => $shop)
                                                                                @if ($sp_request->shop_code == $shop->shop_code)
                                                                                    @php
                                                                                        $check_exist_data[$key] = $sp_request->number_of_item;
                                                                                    @endphp
                                                                                    {{-- <th colspan="0">จำนวน <input type="text" style="width: 24px;" value="{{ $sp_request->number_of_item }}"/>{{ $sp_request->shop_code }}ท่อน</th>
                                                                                @else
                                                                                    <th colspan="0">จำนวน <input type="text" style="width: 24px;" value="0"/>ท่อน</th> --}}
                                                                                @endif  
                                                                            @endforeach 
  
                                                                        @endif
                                                                    @endforeach
                                                                    @for ($i = 0; $i < count($shop_list); $i++)
                                                                        <td colspan="0"> จำนวน 
                                                                            {{-- <input type="text" class="form-control center" style="width: 20px;padding: 0px;border-width: 0px;height: 20px;" readonly value="{{ $check_exist_data[$i] }}" /> --}}
                                                                            <b style="font-size:13px;">{{ $check_exist_data[$i] }}</b>
                                                                            {{ $count_groups->unit }}</td>
                                                                        @php
                                                                            $sum_req_branch =  $sum_req_branch + $check_exist_data[$i];
                                                                        @endphp
                                                                    @endfor
                                                                    <td colspan="0">{{ $sum_req_branch }}</td>
                                                                    <td colspan="3"></td>
                                                                </tr>
                                                                <td style="padding: 0px;" class="text-center" rowspan="{{ $count_groups->count_group }}">{{ $list_item->group }}</td>
                                                            @endif
                                                        @endforeach
                                                        @php
                                                            $group_list = $list_item->group;
                                                        @endphp 
                                                    @endif
                                                    <td style="padding: 0px; height: 20px;">{{ $list_item->item_code }}</td>
                                                    <td style="padding: 0px;" >{{ $list_item->item_name }}</td>
                                                    <td style="padding: 0px;" >{{ $list_item->base_yeild }}</td>
                                                    
                                                    @for ($i = 0; $i < count($shop_list); $i++)
                                                        @php
                                                            $check_exist_data2[$i] = 0;
                                                            $shops2[$i] = $shop_list[$i]->shop_code;
                                                        @endphp
                                                    @endfor
                                                    @php
                                                        $sum_req_branch2 = 0.0;
                                                    @endphp

                                                    {{-- เก็บค่าน้ำหนักyeilld*จำนวนที่ร้านสั่ง --}}
                                                    @foreach ($order_sp_request as $sp_request)
                                                    @if ($list_item->group == $sp_request->order_special_id)

                                                        @foreach ($shop_list as $key => $shop)
                                                            @if ($sp_request->shop_code == $shop->shop_code)
                                                                @php
                                                                $check_exist_data2[$key] = floatval($sp_request->number_of_item);
                                                                @endphp
                                                            @endif
                                                        @endforeach

                                                    @endif
                                                    @endforeach 

                                                    @for ($i = 0; $i < count($shop_list); $i++)
                                                        <td style="padding: 0px;" >{{ floatval($check_exist_data2[$i])*floatval($list_item->base_yeild) }}</td>
                                                        @php
                                                            $sum_req_branch2 =  $sum_req_branch2 + floatval($check_exist_data2[$i])*floatval($list_item->base_yeild);
                                                        @endphp
                                                    @endfor

                                                    <td style="padding: 0px;">{{ $sum_req_branch2  }}</td>
                                                @if ($list_item->yeild_per_one != 0 )

                                                    <td style="padding: 0px;">{{ number_format( $list_item->yeild_per_one , 2, '.', '') }}</td>
                                                    <td style="padding: 0px;">{{ number_format( $list_item->yeild_per_one*floatval($request_detail[0]->sum_number_of_pig) , 2, '.', '') }}</td>
                                                    @foreach ($final_weight as $final_weights)
                                                        @if ($list_item->item_code2 == $final_weights->item_code2)
                                                            <td style="padding: 0px;  background-color:#80ff80; ">

                                                                <input type="text" name="weight_total[]" value="{{ number_format( ( $list_item->yeild_per_one*floatval($request_detail[0]->sum_number_of_pig) ) - 
                                                                    ( $final_weights->sum_number_of_item)  , 3, '.', '')}}" hidden/>
                                                                <input type="text" name="item_code[]" value="{{ $list_item->item_code }}" hidden/>
                                                                <input type="text" name="item_code2[]" value="{{ $list_item->item_code2 }}" hidden/>
                                                                <input type="text" name="item_name[]" value="{{ $list_item->item_name }}" hidden/>

                                                                {{ number_format( 
                                                                    ( $list_item->yeild_per_one*floatval($request_detail[0]->sum_number_of_pig) ) - 
                                                                ( $final_weights->sum_number_of_item )  , 3, '.', '')}}
                                                            </td>
                                                        @endif
                                                    @endforeach

                                                @else
                                                    <td style="padding: 0px; background-color:#464646;" ></td>   
                                                    <td style="padding: 0px; background-color:#464646;"></td>
                                                    <td style="padding: 0px; background-color:#464646;"></td>
                                                @endif
                                                </tr>
                                                @endforeach
                                        

                                            </tbody>
                                        </table>
                                    </div>

                            </div>
                        {{ Form::close() }}

                        <div class="text-center" style="padding-top: 10px;">
                            <button type="submit" class="btn btn-success mr-2" onclick="check_date()">บันทึกน้ำหนัก</button>
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
<script src="{{ asset('assets/js/shared/alerts.js') }}"></script>
<script src="{{ asset('assets/js/shared/avgrund.js') }}"></script>

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
        $('#datepicker5').val( moment(currentDate,'DD/MM/YYYY').add(4, 'days').format("DD/MM/YYYY") );

    });

    $('#datepicker1').daterangepicker({
        startDate: moment('{{ $date_format }}','DD/MM/YYYY'),
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

    function check_date(){
        showSwal('success-message');
        $('.ajax-loader').css({"visibility":"visible" ,"height":" 800px"});
        $('#form_save').submit();
    }

</script>




@endsection


