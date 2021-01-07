@extends('layouts.master')
@section('style')
<style type="text/css">
    .input{
            height: 50%;
            background-color: aqua;
    }
    th{
        padding: 0px;
        font-size: 10px;
    }    
    td{
        padding: 0px;
        font-size: 14px;
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
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.1.6/css/fixedHeader.dataTables.min.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" />


@endsection
@section('main')

<div class="ajax-loader">
    <img src="{{ asset('assets/images/pig_fly.gif')}}" alt="" style="margin-left: 0px;top: 33%;width: 350px; left:37%;" class="img-responsive"  />
</div>


            <div class="col-lg-12 grid-margin">
                <div class="card">
                    <div class="card-body" style=" padding: 0px; ">
                        {{ Form::open(['method' => 'post' ,'id' => 'save_form2' , 'url' => '/shop/receive_sp_order_2_fill/'.$date]) }}
                            <div class="forms-sample form-control" style="height: auto;padding: 0px;">

                                <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;">ใบสั่งสินค้า </div>

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
                                                    <input class="form-control form-control-sm" placeholder="" id="" type="text" name="number_of_pig" value="{{ $sum_number_of_pig }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="row">
                                            <div class="col-4 text-right">
                                                <a class="btn btn-success" target="_blank"  href="../receive_sp_order_2_print/{{ $date }}"  style="margin-bottom: 10px;">
                                                    <i class="fa fa-print">พิมพ์รายงานสำหรับเครื่องใน</i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4 text-right">
                                                <a class="btn btn-success" target="_blank"  href="../receive_sp_order_2_print_all/{{ $date }}"  style="margin-bottom: 10px;">
                                                    <i class="fa fa-print">พิมพ์รายงานทั้งหมด</i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div><br>

                                <div class="outer">
                                    <table  class="tbl table-hover" width="100%" border="1" id="report_shop">

                                        <thead class="text-center ">

                                            {{-- <tr style="background-color:#ffd5bf;" >
                                                <td style="padding: 0px; background-color:#ffd5bf; height: 60px;" width="10%;" colspan="2">สินค้า</td>
                                                <td style="padding: 0px; background-color:#ffd5bf;" width="22%;" colspan="5"></td>
                                                <td style="padding: 0px; background-color:#ffd5bf;" width="24%;" colspan="{{ count($shop_list) }}">Order สาขา</td>
                                                <td style="padding: 0px; background-color:#ffd5bf;" width="37%;" colspan="{{ count($shop_list) }}">ชิ้นส่วนสาขา</td>
                                                <td style="padding: 0px; background-color:#ffd5bf;" width="7%;" colspan="2"></td>
                                            </tr> --}}

                                            <tr>
                                                <th style="padding: 0px; background-color:#ffd5bf;" width="3%;">รหัส</th>
                                                <th style="padding: 0px; background-color:#ffd5bf;" width="7%;">รายการ</th>
                                                <th style="padding: 0px; background-color:#ffd5bf;" width="4%;">Yiled/ตัว (กก.)</th>
                                                <th style="padding: 0px; background-color:#ffd5bf;" width="4%;">Yiled ทั้งหมด (กก.)</th>
                                                <th style="padding: 0px; background-color:#ffd5bf;" width="4%;">Yiled/ชิ้น (กก.)</th>
                                                <th style="padding: 0px; background-color:#ffd5bf;" width="6%;">น้ำหนักรวมคงเหลือ (กก.)</th>
                                                <th style="padding: 0px; background-color:#ffd5bf;" width="4%;">จำนวนคงเหลือ </th>
                                                @foreach ($shop_list as $shop)
                                                    <th style="padding: 0px;background-color:#2d96ff;" width="{{ 25/count($shop_list) }}%;">{{ $shop->marker }}</th>
                                                @endforeach
                                                @foreach ($shop_list as $shop)
                                                    <th style="padding: 0px;background-color:#9bcdff;" width="{{ 36/count($shop_list) }}%;">{{ $shop->marker }}</th>
                                                @endforeach
                                                <th style="padding: 0px; background-color:#ffd5bf;" width="7%;" colspan="2">จำนวน</th>
                                            </tr>

                                        </thead>

                                        <tbody>
                                        {{-- group1 --}}
                                            @include('factory.group1')
                                        {{-- group1 --}}

                                        {{-- group3 --}}
                                            @include('factory.group3')
                                        {{-- group3 --}}

                                        {{-- group2 --}}
                                            @include('factory.group2')
                                        {{-- group2 --}}

                                        {{-- group4 --}}
                                            @include('factory.group4')
                                        {{-- group4 --}}
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        {{ Form::close() }}

                        <div class="text-center" style="padding-top: 10px;">
                            <button type="submit" onclick="DisabledPercent()" class="btn btn-success mr-2">ยืนยัน</button>
                        </div>
 
                    </div>
                </div>
            </div>

@endsection

@section('script')
{{-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script> --}}
{{-- <script src="{{ asset('https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js') }}"></script> --}}
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js') }}"></script>
<script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js') }}"></script>
<script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('https://code.jquery.com/jquery-3.3.1.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/fixedheader/3.1.6/js/dataTables.fixedHeader.min.js') }}"></script>
<script src="{{ asset('assets/js/shared/alerts.js') }}"></script>
<script src="{{ asset('assets/js/shared/avgrund.js') }}"></script>



<script>

$(document).ready(function() {
    $('#example').DataTable( {
        fixedHeader: true,
        dom: 't',
    } );
} );

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

    
</script>

<script>
    function DisabledPercent(){
        
        $('[id^="setpercent"]').prop('disabled', true);
        showSwal('success-message');
        $('.ajax-loader').css({"visibility":"visible" ,"height":" 1000px"});
        $('#save_form2').submit();
        
    }

</script>
    


@endsection


