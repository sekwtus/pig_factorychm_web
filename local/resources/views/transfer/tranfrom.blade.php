@extends('layouts.master')
@section('style')
<style type="text/css">
    .input {
        height: 50%;
        background-color: aqua;
    }

    th,
    td {
        padding: 0px;
    }
</style>
<link rel="stylesheet" href="{{ url('https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css') }}"
    type="text/css" />
<link rel="stylesheet" href="{{ url('https://cdn.datatables.net/1.10.18/css/dataTables.semanticui.min.css') }}"
    type="text/css" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection
@section('main')

@if(session()->has('message'))
<div class="alert alert-danger">
    {{ session()->get('message') }}
</div>
@endif

<div class="row ">
    <div class="col-lg-5 grid-margin">
        <div class="card">
            <div class="card-body">
                {{ Form::open(['method' => 'post' , 'url' => '/create_order_tranfrom/create_order']) }}
                <div class="forms-sample form-control" style="height: auto;padding-right: 20px;">
                    <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;">สร้างรายการ
                        ใบแปรสภาพสินค้า</div>
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-md-6 pr-md-0">
                            <label for="type_req">ประเภท</label>
                            <select class="form-control form-control-sm" id="type_req" name="type_req"
                                style=" height: 30px; " onchange="customerDll(this);" required>
                                <option value="3">หมูสาขา</option>
                            </select>
                        </div>
                        <div class="col-md-6 pr-md-0">
                            <label for="orderDate">วันที่ชั่งแปรสภาพ</label>
                            <input class="form-control form-control-sm" placeholder="วว/ดด/ปปปป" id="dateOffal"
                                type="text" name="dateOffal" value="" required>
                        </div>
                    </div>

                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-md-5 pr-md-0">
                            <label for="customer">สาขา ที่แปรสภาพ</label>
                            <select class="form-control form-control-sm" onchange="setMarkerA(this)" id="customer_from"
                                name="customer_from" style=" height: 30px; " required>
                                @if (Auth::user()->id_type == 6)
                                    @foreach ($my_shop as $shop)
                                        <option value="{{ $shop->customer_name }}">{{ $shop->customer_name }}</option>
                                    @endforeach
                                @else
                                    <option></option>
                                    @foreach ($customer as $cust)
                                        <option value="{{ $cust->customer_name }}">{{ $cust->customer_name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            {{-- <input type="radio" class="form-control form-control-sm" id="customer" placeholder="เชือด" required> --}}
                        </div>

                        {{-- <div class="col-md-2 pr-md-0">
                            <i class="fa fa-arrow-right" style="font-size: 25px;margin-right: 0px;padding-left: 20px;padding-top: 20px;padding-right: 20px;"></i>
                        </div> --}}

                        {{-- <div class="col-md-5 pr-md-0">
                            <label for="customer">สาขา ปลายทาง</label>
                            <select class="form-control form-control-sm" onchange="setMarkerB(this)" id="customer_to"
                                name="customer_to" style=" height: 30px; " required>
                                <option></option>
                                @foreach ($customer as $cust)
                                <option value="{{ $cust->customer_name }}">{{ $cust->customer_name }}</option>
                                @endforeach
                            </select>
                        </div> --}}
                        <div class="col-md-5 pr-md-0">
                            <label for="markerA">อักษรย่อ</label>
                            @if (Auth::user()->id_type == 6 )
                                @foreach ($my_shop as $shop)
                                    <input type="text" class="form-control form-control-sm" id="markerA" name="markerA" readonly placeholder="อักษรย่อ" required value="{{ $shop->marker }}">
                                    <input type="text" class="form-control form-control-sm" id="customerA" name="customerA" hidden value="{{ $shop->id }}">
                                @endforeach
                            @else
                                    <input type="text" class="form-control form-control-sm" id="markerA" name="markerA" readonly  placeholder="อักษรย่อ" required>
                                    <input type="text" class="form-control form-control-sm" id="customerA" name="customerA" hidden>
                            @endif
                        </div>
                        
                        {{-- <div class="col-md-2 pr-md-0">
                            <i class="fa fa-arrow-right" style="font-size: 25px;margin-right: 0px;padding-left: 20px;padding-top: 20px;padding-right: 20px;"></i>
                        </div> --}}

                        {{-- <div class="col-md-5 pr-md-0">
                            <label for="markerB">อักษรย่อ</label>
                            <input type="text" class="form-control form-control-sm" id="markerB" name="markerB" readonly placeholder="อักษรย่อ" required>
                            <input type="text" class="form-control form-control-sm" id="customerB" name="customerB" hidden>
                        </div> --}}
                    </div>

                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-md-6 pr-md-0">
                            <label for="provider">ผู้จัดทำ</label>
                            <input type="text" class="form-control form-control-sm" id="provider" name="provider"
                                placeholder="ผู้จัดทำ" required>
                        </div>
                        <div class="col-md-6 pr-md-0">
                            <label for="round">รอบ</label>
                            <select class="form-control form-control-sm" id="round" name="round" style=" height: 30px; ">
                                <option></option>
                                <option value="A">A</option> 
                                <option value="B">B</option> 
                                <option value="C">C</option> 
                                <option value="D">D</option> 
                                <option value="E">E</option> 
                                <option value="F">F</option> 
                                <option value="G">G</option> 
                                <option value="H">H</option> 
                                <option value="I">I</option> 
                                <option value="J">J</option> 
                                <option value="K">K</option> 
                                <option value="L">L</option> 
                                <option value="M">M</option> 
                                <option value="N">N</option> 
                                <option value="O">O</option> 
                                <option value="P">P</option> 
                                <option value="Q">Q</option> 
                                <option value="R">R</option> 
                                <option value="S">S</option> 
                                <option value="T">T</option> 
                                <option value="U">U</option> 
                                <option value="V">V</option> 
                                <option value="W">W</option> 
                                <option value="X">X</option> 
                                <option value="Y">Y</option> 
                                <option value="Z">Z</option> 
                            </select>
                        </div>
                    </div>

                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-md-12 pr-md-0">
                            <label for="note">หมายเหตุ</label>
                            <textarea class="form-control form-control-sm" id="note" name="note" rows="3"
                                placeholder="หมายเหตุ"></textarea>
                        </div>
                    </div>


                <div class="text-center" style="padding-top: 10px;">
                    <button type="submit" class="btn btn-success mr-2">ยืนยัน</button>
                </div>

            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

<div class="col-lg-7 grid-margin">
    <div class="card">
        <div class="card-body ">
            <div class="row">
                <div class="col-5">
                    <h4>รายการ ใบแปรสภาพสินค้า</h4>
                </div>
                <h4 class="col-2">ประจำวันที่ : </h4>
                <input class="form-control form-control-sm col-2 input-daterange-datepicker" type="text"
                    id="dateFilterOffal" name="dateFilterOffal" />
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-bordered nowrap table-hover" width="100%" id="orderTable">
                    <thead class="text-center">
                        <tr>
                            <th style="padding: 0px; font-size: 0.7rem;">เลขที่ Order</th>
                            <th style="padding: 0px; font-size: 0.7rem;">สาขา</th>
                            {{-- <th style="padding: 0px; font-size: 0.7rem;">สาขา ปลายทาง</th> --}}
                            <th style="padding: 0px; font-size: 0.7rem;">ประเภท</th>
                            <th style="padding: 0px; font-size: 0.7rem;">วันที่ชั่งออก</th>
                            <th style="padding: 0px; font-size: 0.7rem;">สถานะ</th>
                            <th style="padding: 0px; font-size: 0.7rem;">หมายเหตุ</th>
                            <th style="text-align:center; padding: 0px; font-size: 0.7rem;"> ดำเนินการ </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<input type="text" class="form-control form-control-sm" value="{{Auth::user()->id_type}}" id="customer_type" name="customer_type" hidden>


{{-- edit order --}}
{{ Form::open(['method' => 'post' , 'url' => 'order/edit']) }}
<div class="modal fade" id="EDIT" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="data_edit">

        </div>
    </div>
</div>
{{ Form::close() }}


{{-- <button id="x" name="x" class="x" onclick="showx()">  xx</button> --}}
@endsection

@section('script')
<script src="{{ asset('https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js') }}"></script>

{{-- datatables --}}
<script>
    var table = $('#orderTable').DataTable({
        "scrollX": false,
        orderCellsTop: true,
        fixedHeader: true,
        // dom: 'Bfrtip',
        // buttons: [
        //     'print'
        // ],
        // processing: true,
        // serverSide: true,
        ajax: '{{ url('create_order_tranfrom/get_ajax') }}',
        columns: [
        { data: 'order_number', name: 'order_number' },
        { data: 'id_user_customer_from', name: 'id_user_customer_from' },
        // { data: 'id_user_customer_to', name: 'id_user_customer_to' },
        { data: 'order_type', name: 'order_type' },
        { data: 'date', name: 'date' },
        { data: 'status', name: 'status' },
        { data: 'note', name: 'note' },
        { data: 'id', name: 'id' },
        ],
            columnDefs: [
            {
                "targets": 0,
                "className": "text-center", render(data, type, row) {
                    $d = row["date"].substring(0, 2) + row["date"].substring(3, 5) + row["date"].substring(6, 10);
                    return '<a target="blank_" href="../transform/transform_compare/' + $d +'/'+ row["customer_code"] + '">' + data + '</a>';
                    // transform/transform_compare/12062020/MK01
                }
            },
            {
                "targets": 1,
                "className": "text-center",
            },
            // {
            //     "targets": 2,
            //     "className": "text-center",
            // },
            {
                "targets": 2,
                "className": "text-center",
            },
            {
                "targets": 3,
                "className": "text-center",
            },
            {
                "targets": 4,render(data, type, row) {
                    switch (data) {
                        case `1`:
                            return '<div class="badge badge-warning">รออนุมัติ</div>';break;
                        case `2`:
                            return '<div class="badge badge-success">อนุมัติแล้ว</div>';break;
                        case `3`:
                            return '<div class="badge badge-danger">ไม่อนุมัติ</div>';break;
                    }
                },
                "className": "text-center",
            },
            {
                "targets": 5,
                "className": "text-center",
            },
            {
                "targets": 6, render(data, type, row) {
                    var sign = "'";
                    var order_number = row['order_number'];
                    var id_user_customer = row['id_user_customer_from'];
                    var marker = row['marker'];
                    var total_pig = row['total_pig'];
                    var weight_range = row['weight_range'];
                    var date = row['date'];
                    var note = row['note'];
                    var type_request = row['type_request'];
                    var order_type = row['order_type'];
                    var round = row['round'];
                    var customer_type = $('#customer_type').val();
                    $d = row["date"].substring(0, 2) + row["date"].substring(3, 5) + row["date"].substring(6, 10);
                    var s = "'";

                    if(customer_type == 1 || customer_type == 15){
                        if(row['status'] == '1'){
                            return '<a><button class="btn btn-sm btn-outline btn-success" type="button" onclick="approve('+s+row["order_number"]+s+')" >\
                                <i class="fa fa-check" aria-hidden="true">อนุมัติ</i></button></a>\
                                \
                                <a><button class="btn btn-sm btn-outline btn-danger" type="button" onclick="no_approve('+s+row["order_number"]+s+')" >\
                                <i class="fa fa-close" aria-hidden="true">ไม่อนุมัติ</i></button></a>\
                                \
                                <button class="btn btn-sm btn-outline btn-danger" type="button" onclick="deleteOrder('+sign+order_number+sign+')" ><i class="fa fa-trash" aria-hidden="true"></i></button>';
                        }else{
                            return '<a href="../transform/transform_compare/' + $d +'/'+ row["customer_code"] + '" target="_blank"><button class="btn btn-sm btn-outline btn-success" type="button" >\
                                <i class="fa fa-edit" aria-hidden="true">ตวจสอบ</i></button></a>\
                                \
                                <button class="btn btn-sm btn-outline btn-danger" type="button" onclick="deleteOrder('+sign+order_number+sign+')" ><i class="fa fa-trash" aria-hidden="true"></i></button>';
                        }
                    }else{
                        if(row['status'] == '1'){
                            return '<a ><button class="btn btn-sm btn-outline btn-success" type="button" onclick="send_line('+s+row["order_number"]+s+')" >\
                                <i class="fa fa-commenting" aria-hidden="true"> ส่งคำขอ</i></button></a>\
                                \
                                <button class="btn btn-sm btn-outline btn-danger" type="button" onclick="deleteOrder('+sign+order_number+sign+')" ><i class="fa fa-trash" aria-hidden="true"></i></button>';
                        }else{
                            return '<a href="../transform/transform_compare/' + $d +'/'+ row["customer_code"] + '" target="_blank"><button class="btn btn-sm btn-outline btn-success" type="button" >\
                                <i class="fa fa-edit" aria-hidden="true">ตวจสอบ</i></button></a>\
                                \
                                <button class="btn btn-sm btn-outline btn-danger" type="button" onclick="deleteOrder('+sign+order_number+sign+')" ><i class="fa fa-trash" aria-hidden="true"></i></button>';
                        }
                    }
                    
                }
            },
        ],
        "order": [],
        });

    $.fn.dataTable.ext.search.push(
        function (settings, data, dataIndex) {

            // console.log(settings.nTable.id);
            if (settings.nTable.id !== 'orderTable') {
                return true;
            }

            var iStartDateCol = 3;

            var daterange = $('#dateFilterOffal').val();
            var dateMin = daterange.substring(6, 10) + daterange.substring(3, 5) + daterange.substring(0, 2);
            var colDate = data[iStartDateCol].substring(6, 12) + data[iStartDateCol].substring(3, 5) + data[iStartDateCol].substring(0, 2);

            var min = parseInt(dateMin);
            var Date_data = parseFloat(colDate) || 0;

            if ((isNaN(min)) || (min == Date_data)) {
                return true;
            }
            return false;
        }
    );

    $(document).ready(function () {
        $('#dateFilterOffal').change(function () {
            table.draw();
        });
    });


</script>


{{-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script> --}}
<script src="{{ asset('https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js') }}"></script>

<!-- ลบ order -->
<script>
    function deleteOrder(order_number) {
        if (confirm('ต้องการลบ Order : ' + order_number + ' ?')) {
            $.ajax({
                type: 'get',
                url: '{{ url('create_order_transfrom/delete') }}',
                data: { order_number: order_number },
                success: function (msg) {
                    alert(msg);
                    location.reload();
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert("Status: " + textStatus); alert("Error: " + errorThrown);
                }
            });
        }
    }
</script>

<!-- แก้ไข order -->
<script>
    function editModal(order_number, id_user_customer, marker, total_pig, weight_range, date, note, type_request, order_type, round) {
        $("#EDIT").modal();
        var get_type_order = '';
        $.ajax({
            type: 'GET',
            url: '{{ url('ajax_type_order') }}',
            data: {},
            success: function (data) {
                data.forEach(element => {
                    if (order_type == element.order_type) {
                        get_type_order = get_type_order + '<option selected value="' + element.id + '">' + element.order_type + '</option>';

                    } else {
                        get_type_order = get_type_order + '<option value="' + element.id + '">' + element.order_type + '</option>';
                    }
                });

                if (note == '' || note == null || note == 'null') {
                    note = '';
                }

                var str = '<div class="forms-sample form-control" style="height: 400px;padding-right: 20px;">\
                            <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;">แก้ไข Order <b style="color:black;">'+ order_number + '</b></div>\
                            <div class="row" style="margin-bottom: 10px;">\
                                <div class="col-md-6 pr-md-0">\
                                    <label for="type_req">ประเภท</label>\
                                        <select class="form-control form-control-sm" id="type_req" name="type_req" style=" height: 30px; " required>\
                                            '+ get_type_order + '\
                                    </select>\
                                </div>\
                                <div class="col-md-6 pr-md-0">\
                                    <label for="orderDate">ประจำวันที่</label>\
                                    <input class="form-control form-control-sm" placeholder="วว/ดด/ปปปป" type="text" id="datepicker2" name="datepicker" value="'+ date + '" required></div>\
                            </div>\
                            <div class="row" style="margin-bottom: 10px;">\
                                <div class="col-md-6 pr-md-0">\
                                    <label for="customer">ลูกค้า/สาขา</label>\
                                    <input readonly type="text" class="form-control form-control-sm" name="customer" id="customer" placeholder="ลูกค้า" value="'+ id_user_customer + '" required>\
                                </div>\
                                <div class="col-md-3 pr-md-0">\
                                    <label for="marker">อักษรย่อ</label>\
                                    <input readonly type="text" class="form-control form-control-sm"  name="marker" id="marker" placeholder="อักษรย่อ" value="'+ marker + '" required> \
                                </div>\
                                <div class="col-md-3 pr-md-0">\
                                    <label for="round">รอบที่</label>\
                                    <input type="number" class="form-control form-control-sm" name="round" id="round" value="'+ round + '" required> \
                                </div>\
                            </div>\
                            <div class="row" style="margin-bottom: 10px;">\
                                <div class="col-md-6 pr-md-0">\
                                    <label for="amount">จำนวน(ตัว)</label>\
                                    <input type="number" class="form-control form-control-sm" name="amount" id="amount" placeholder="จำนวน" value="'+ total_pig + '" required> </div>\
                                <div class="col-md-6 pr-md-0">\
                                    <label for="weight_range">ช่วงน้ำหนัก</label>\
                                    <input type="text" class="form-control form-control-sm" name="weight_range" id="weight_range" placeholder="ช่วงน้ำหนัก" value="'+ weight_range + '" required> </div>\
                            </div>\
                            <div class="row" style="margin-bottom: 10px;">\
                                <div class="col-md-12 pr-md-0">\
                                    <label for="note">หมายเหตุ</label>\
                                    <input class="form-control form-control-sm" name="note" id="note" rows="3" placeholder="หมายเหตุ" value="'+ note + '"></input> </div>\
                                </div>\
                                <div class="text-center" style="padding-top: 10px;">\
                                    <button type="submit" name="order_number" value="'+ order_number + '" class="btn btn-success mr-2">ยืนยัน</button>\
                                </div>\
                    </div>';
                $("#data_edit").html(str);
                $('#datepicker2').daterangepicker({
                    buttonClasses: ['btn', 'btn-sm'],
                    applyClass: 'btn-danger',
                    cancelClass: 'btn-inverse',
                    singleDatePicker: true,
                    todayBtn: true,
                    language: 'th',
                    thaiyear: true,
                    locale: {
                        format: 'DD/MM/YYYY',
                        daysOfWeek: [
                            "อา.",
                            "จ.",
                            "อ.",
                            "พ.",
                            "พฤ.",
                            "ศ.",
                            "ส."
                        ],
                        monthNames: [
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
                        firstDay: 0
                    }
                });

            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert("Status: " + textStatus); alert("Error: " + errorThrown);
            }
        });

    }
</script>


{{-- datepicker --}}
{{-- <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script> --}}
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
    $('#dateOffal').daterangepicker({
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-danger',
        cancelClass: 'btn-inverse',
        singleDatePicker: true,
        todayBtn: true,
        language: 'th',
        thaiyear: true,
        locale: {
            format: 'DD/MM/YYYY',
            daysOfWeek: [
                "อา.",
                "จ.",
                "อ.",
                "พ.",
                "พฤ.",
                "ศ.",
                "ส."
            ],
            monthNames: [
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
            firstDay: 0
        }
    });

    $('#dateTransport').daterangepicker({
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-danger',
        cancelClass: 'btn-inverse',
        singleDatePicker: true,
        todayBtn: true,
        minDate: 1,
        language: 'th',
        thaiyear: true,
        locale: {
            format: 'DD/MM/YYYY',
            daysOfWeek: [
                "อา.",
                "จ.",
                "อ.",
                "พ.",
                "พฤ.",
                "ศ.",
                "ส."
            ],
            monthNames: [
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
            firstDay: 0
        }
    });

    $('#dateFilterOffal').daterangepicker({
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-danger',
        cancelClass: 'btn-inverse',
        singleDatePicker: true,
        todayBtn: true,
        minDate: 1,
        language: 'th',
        thaiyear: true,
        locale: {
            format: 'DD/MM/YYYY',
            daysOfWeek: [
                "อา.",
                "จ.",
                "อ.",
                "พ.",
                "พฤ.",
                "ศ.",
                "ส."
            ],
            monthNames: [
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
            firstDay: 0
        }
    });

</script>

<script>
    function setMarkerA(customer_from) {
        // alert(customer.value);
        $.ajax({
            type: 'GET',
            url: '{{ url('getMarkerCustomerFrom') }}',
            data: { customer_from: customer_from.value },
            success: function (data) {
                $('#markerA').val(data[0].marker);
                $('#customerA').val(data[0].id);
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert("Status: " + textStatus); alert("Error: " + errorThrown);
            }
        });
        console.log(customer_from.value);
    }
    function setMarkerB(customer_to) {
        // alert(customer.value);
        $.ajax({
            type: 'GET',
            url: '{{ url('getMarkerCustomerTo') }}',
            data: { customer_to: customer_to.value },
            success: function (data) {
                $('#markerB').val(data[0].marker);
                $('#customerB').val(data[0].id);
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert("Status: " + textStatus); alert("Error: " + errorThrown);
            }
        });
    }

    function customerDll(type_req) {
        $.ajax({
            type: 'GET',
            url: '{{ url('getCustomer') }}',
            data: {},
            success: function (data) {
                var str = '<option value=""></option>';
                data.forEach(element => {
                    if (type_req.value == 3) {
                        if (element.type == 'สาขา') {
                            str = str + '<option value="' + element.customer_name + '">' + element.customer_name + '</option>';
                        }
                        $('#status').prop("disabled", false);
                    } else if (type_req.value == 2) {
                        if (element.type == 'ลูกค้าซาก') {
                            str = str + '<option value="' + element.customer_name + '">' + element.customer_name + '</option>';
                        }
                        $('#status').prop("disabled", true);
                    }
                    else {
                        if (element.type != 'สาขา' && element.type != 'ลูกค้าซาก') {
                            str = str + '<option value="' + element.customer_name + '">' + element.customer_name + '</option>';
                        }
                        $('#status').prop("disabled", true);
                    }
                });
                $('#customer').html(str);
                // console.log(type_req.value);
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert("Status: " + textStatus); alert("Error: " + errorThrown);
            }
        });
    }
</script>>
<script>
    function send_line(order_){
        $.ajax({
        url: '{{ asset('send_line_tranfrom') }}/'+order_,
        xhrFields: {
            withCredentials: true
        },
        success: function(response) {
            alert(response);
            // return response;        
        },
        error: function() {
            alert('ไม่สามารถส่งข้อมูลได้');
        }
        });
    }

    function approve(order){
        r = confirm('อนุมัติ การแปรสภาพ order : '+order+' หรือไม ?');
        if(r == true){
            $.ajax({
                url: '{{ asset('approve_tranfrom') }}/'+order,
                xhrFields: {
                    withCredentials: true
                },
                success: function(response) {
                    alert(response);
                    location.reload(true);
                    // return response;        
                },
                error: function() {
                    alert('อนุมัติไม่สำเร็จ');
                }
            });
        }else{

        }
    }
    function no_approve(order){
        r = confirm('อนุมัติ การแปรสภาพ order : '+order+' หรือไม ?');
        if(r == true){
            $.ajax({
                url: '{{ asset('no_approve_tranfrom') }}/'+order,
                xhrFields: {
                    withCredentials: true
                },
                success: function(response) {
                    alert(response);
                    location.reload(true);
                    // return response;        
                },
                error: function() {
                    alert('ไม่อนุมัติไม่สำเร็จ');
                }
            });
        }else{

        }
    }

</script>

@endsection