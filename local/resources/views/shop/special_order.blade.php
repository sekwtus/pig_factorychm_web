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
<link rel="stylesheet" href="{{ asset('assets/css/daterangepicker.css')}}">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" />

@endsection
@section('main')
            <div class="col-lg-12 grid-margin">
                <div class="ajax-loader">
                    <img src="{{ asset('assets/images/pig_fly.gif')}}" alt="" style="margin-left: 0px;top: 3%;width: 350px; left:37%;" class="img-responsive"  />
                </div>

                <div class="card">
                    <div class="card-body">
                        {{ Form::open(['method' => 'post' , 'url' => '/shop/specail_order/request' , 'id' => 'form_save']) }}
                            <div class="forms-sample form-control" style="height: auto;padding-right: 20px;">
                                <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;">สั่ง Order พิเศษ</div>
                                
                                <div class="row">
                                    <div class="col-6">
                                        <div class="col-md-12 pr-md-0">
                                            <label for="shop_name">สาขา</label>
                                            <input type="text" class="form-control form-control-sm" id="shop_name" name="shop_name" placeholder="สาขา" value="{{ $branch_name }}" readonly> 
                                        </div>
                                        <div class="col-md-12 pr-md-0">
                                            <label for="number_of_pig">จำนวนตัว</label>
                                            <input type="number" class="form-control form-control-sm" id="number_of_pig" name="number_of_pig" value="{{ ( empty($list_number_of_pig[0]->number ) ? '' : $list_number_of_pig[0]->number) }}" placeholder="จำนวนตัว" readonly> 
                                        </div>
                                        <div class="col-md-12 pr-md-0">
                                            <label for="requester">ผู้สั่ง Order</label>
                                            <input type="text" class="form-control form-control-sm" id="requester" name="requester" value="{{ ( empty($data_request[0]->requester_name) ? '': $data_request[0]->requester_name) }}" placeholder="ผู้สั่ง Order" required> 
                                        </div>
                                        
                                    </div>
                                    <div class="col-6">
                                        <div class="col-md-12 pr-md-0">
                                            <label for="orderDate">ร้านสั่ง Order วันที่</label>
                                            <input class="form-control form-control-sm" placeholder="วว/ดด/ปปปป" id="datepicker1" type="text" name="datepicker1" value="" onchange="GoToDate()" >
                                        </div>
                                        <div class="col-md-12 pr-md-0">
                                            <label for="orderDate">ชั่งหมู วันที่</label>
                                            <input class="form-control form-control-sm" placeholder="วว/ดด/ปปปป" id="datepicker2" type="text" name="datepicker2" value="" readonly>
                                        </div>
                                        <div class="col-md-12 pr-md-0">
                                            <label for="orderDate">เข้าเชือด วันที่</label>
                                            <input class="form-control form-control-sm" placeholder="วว/ดด/ปปปป" id="datepicker3" type="text" name="datepicker3" value="" readonly>
                                        </div>
                                        <div class="col-md-12 pr-md-0">
                                            <label for="orderDate">โรงงานตัดแต่ง วันที่</label>
                                            <input class="form-control form-control-sm" placeholder="วว/ดด/ปปปป" id="datepicker4" type="text" name="datepicker4" value="" readonly>
                                        </div>
                                        <div class="col-md-12 pr-md-0">
                                            <label for="orderDate">ส่งสินค้าเข้าร้าน วันที่</label>
                                            <input class="form-control form-control-sm" placeholder="วว/ดด/ปปปป" id="datepicker5" type="text" name="datepicker5" value="" readonly>
                                        </div>
                                    </div>
                                </div><br>

                                    <div class="table-responsive">
                                        <table  class="tbl table-hover " width="100%" border="1" id="report_shop">
                                            <thead class="text-center ">
                                            <tr style="background-color:#7dbeff;height: 25px;" >
                                                <th style="padding: 0px;">รหัสสินค้า</th>
                                                <th style="padding: 0px;">รายการ</th>
                                                <th style="padding: 0px; width: 250px;">กำหนด</th>
                                                <th style="padding: 0px;">จำนวน</th>
                                                <th style="padding: 0px;">หน่วย</th>
                                                <th style="padding: 0px;">หมายเหตุ</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @php $de = 0; @endphp
                                                @foreach ($list_special as $list_sp)
                                                    <tr>
                                                        <td style="padding: 0px;" >
                                                            <input class="form-control form-control-sm" id="" type="text" name="item_code[]" value="{{ $list_sp->item_code }}" readonly>
                                                            <input class="form-control form-control-sm" id="" type="text" name="sp_id[]" value="{{ $list_sp->id }}" hidden> </td>
                                                        <td style="padding: 0px;" ><input class="form-control form-control-sm" id="" type="text" name="item_name[]" value="{{ $list_sp->item_name }}" readonly>  </td>
                                                        <td style="padding: 0px;" ><input class="form-control form-control-sm" placeholder="" id="" type="text" name="item_special[]" value="{{ $list_sp->item_special }}" readonly>  </td>
                                                        @php
                                                            if( !empty($data_request) ){
                                                                foreach ($data_request as $key => $value_data_request) {
                                                                    if ($value_data_request->order_special_id == $list_sp->id) {
                                                                        if (Auth::user()->id_type == 6) {
                                                                            echo '<td style="padding: 0px;" ><input class="form-control form-control-sm" id="" type="number" name="number_of_item[]" value="'.$value_data_request->number_of_item.'" disabled> </td>';
                                                                        } else {
                                                                            echo '<td style="padding: 0px;" ><input class="form-control form-control-sm" id="" type="number" name="number_of_item[]" value="'.$value_data_request->number_of_item.'"></td>';
                                                                        }
                                                                    }
                                                                }
                                                            }else {
                                                                echo '<td style="padding: 0px;" ><input class="form-control form-control-sm" id="" type="number" name="number_of_item[]" value=""> </td>';
                                                            }
                                                        @endphp
                                                        <td style="padding: 0px;" ><input class="form-control form-control-sm" id="" type="text" name="unit[]" value="{{ $list_sp->unit }}" readonly> </td>
                                                        
                                                        @if ($list_sp->photo != null)
                                                            <td style="padding: 0px;" rowspan="5"><img src="{{ asset('assets/images/'.$list_sp->photo)}}" > </td> 
                                                            <td style="padding: 0px;" ><input class="form-control form-control-sm" placeholder="หมายเหตุ" id="" type="text" name="note[]" value="" hidden> </td>

                                                        @elseif($list_sp->item_code != '1036')
                                                            @php
                                                                if( !empty($data_request) ){
                                                                    foreach ($data_request as $key => $value_data_request) {
                                                                        if ($value_data_request->order_special_id == $list_sp->id) {
                                                                            if (Auth::user()->id_type == 6) {
                                                                                echo '<td style="padding: 0px;" ><input class="form-control form-control-sm" placeholder="หมายเหตุ" id="" type="text" name="note[]" value="'.$value_data_request->note.'" disabled> </td>';
                                                                            } else {
                                                                                echo '<td style="padding: 0px;" ><input class="form-control form-control-sm" placeholder="หมายเหตุ" id="" type="text" name="note[]" value="'.$value_data_request->note.'" > </td>';
                                                                            }
                                                                        }
                                                                    }
                                                                }else {
                                                                    echo '<td style="padding: 0px;" ><input class="form-control form-control-sm" placeholder="หมายเหตุ" id="" type="text" name="note[]" value="'. $list_sp->note .'"> </td>';
                                                                }
                                                            @endphp
                                                        @elseif($list_sp->item_code == '1036')
                                                            <td style="padding: 0px;" ><input class="form-control form-control-sm" placeholder="หมายเหตุ" id="" type="text" name="note[]" value="" hidden> </td>
                                                        @endif 
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                            </div>
                        {{ Form::close() }}

                        <div class="text-center" style="padding-top: 10px;">
                            <div class="wrapper text-center">
                                <button class="btn btn-outline-success" onclick="check_date()">ยืนยัน</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

@endsection

@section('script')
{{-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script> --}}
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
        // minDate:moment(new Date).add(-2, 'days'),
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

    function GoToDate(){
        $('.ajax-loader').css("visibility", "visible");
        var date = $('#datepicker1').val();
        var re_date = date.substr(0,2)+date.substr(3,2)+date.substr(6,4);
        if ('{{ auth::user()->id_type }}' == 1) {
            window.location.href='/pig_factorychm_web/shop/special_order_admin/'+re_date+'/'+'{{ $branch_name }}';
            
        } else {
            window.location.href='/pig_factorychm_web/shop/special_order/'+re_date;
        }
    }

    function check_date(){
        var currentDate =$('#datepicker1').val();
        if (moment(currentDate,'DD/MM/YYYY').format("YYYYMMDD") < moment(new Date).add(-2, 'days').format("YYYYMMDD")) {
            alert('ไม่สามารถแก้ไขข้อมูลก่อนวันที่ ' +moment(new Date).add(-2, 'days').format('DD/MM/YYYY') );
        } else {
            showSwal('success-message');
            $('.ajax-loader').css({"visibility":"visible" ,"height":" 2300px"});
            $('#form_save').submit();
        }
    }
</script>


@endsection


