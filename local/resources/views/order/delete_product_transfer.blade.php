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
    <div class="col-lg-12 grid-margin">
        <div class="card">
            <div class="card-body">
                {{ Form::open(['method' => 'delete' , 'url' => 'create_order_transfer/delete']) }}
                @foreach($data as $data_out)
                <div class="forms-sample form-control" style="height: auto;padding-right: 20px;">
                    <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;">แก้ไขรายการ
                        ใบโอนสินค้า</div>
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-md-6 pr-md-0">
                            <label for="type_req">ประเภท</label>
                            <select class="form-control form-control-sm" id="type_req" name="type_req"
                                style=" height: 30px; " onchange="customerDll(this);" disabled>
                                @if($data_out->req_type == "3") 
                                <option value="{{$data_out->req_type}}" readonly disabled selected>หมูสาขา</option>
                                @endif
                                @if($data_out->req_type == "2") 
                                <option value="$data_out->req_type" readonly disabled selected>หมูลูกค้า</option>
                                @endif
                            </select>
                        </div>
                        <div class="col-md-6 pr-md-0">
                            <label for="orderDate">วันที่ชั่งออก</label>
                            <input class="form-control form-control-sm" placeholder="วว/ดด/ปปปป" id="dateOffal"
                                type="text" name="dateOffal" value="{{$data_out->date}}" disabled>
                        </div>
                        {{--
                      <div class="col-md-4 pr-md-0">
                                <label for="round">รอบ</label>
                                <!-- <input type="text" class="form-control form-control-sm" id="round" name="round" placeholder="รอบที่" value=""> -->
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
                        </div> --}}
                        {{-- <div class="col-md-4 pr-md-0">
                            <label for="stock">stock</label>
                            <select class="form-control form-control-sm" id="stock" name="stock" style=" height: 30px; " required>
                                @foreach ($stock as $stock_)
                                    <option value="{{ $stock_->id_storage }}">{{ $stock_->name_storage }} -
                        {{ $stock_->description }} [{{ $stock_->current_unit }}]</option>
                        @endforeach
                        </select>
                    </div> --}}
                </div>

                <div class="row" style="margin-bottom: 10px;">
                    <div class="col-md-4 pr-md-0">
                        <label for="customer">ลูกค้า/สาขา ต้นทาง</label>
                        <select class="form-control form-control-sm" onloadeddata="setMarkerA(this)" id="customer_from"
                            name="customer_from" style=" height: 30px; " disabled>
                            <option value="{{ $data_out->id_user_customer_from }}" selected disabled>{{ $data_out->id_user_customer_from }}</option>
                        </select>
                        {{-- <input type="radio" class="form-control form-control-sm" id="customer" placeholder="เชือด" required> --}}
                    </div>
                    <div class="col-md-2 pr-md-0">
                        <label for="markerA">อักษรย่อ</label>
                        <input type="text" class="form-control form-control-sm" id="markerA" name="markerA"
                            placeholder="อักษรย่อ" disabled required>
                        <input type="text" class="form-control form-control-sm" id="customerA" name="customerA" hidden>
                    </div>
                    <div class="col-md-4 pr-md-0">
                        <label for="customer">ลูกค้า/สาขา ปลายทาง</label>
                        <select class="form-control form-control-sm" onchange="setMarkerB(this)" id="customer_to"
                            name="customer_to" style=" height: 30px; " disabled>
                            <option value="{{ $data_out->id_user_customer_to }}" selected disabled>{{ $data_out->id_user_customer_to }}</option>
                            <option></option>
                            @foreach ($customer as $cust)
                            <option value="{{ $cust->customer_name }}">{{ $cust->customer_name }}</option>
                            @endforeach
                        </select>
                        {{-- <input type="radio" class="form-control form-control-sm" id="customer" placeholder="เชือด" required> --}}
                    </div>
                    <div class="col-md-2 pr-md-0">
                        <label for="markerB">อักษรย่อ</label>
                        <input type="text" class="form-control form-control-sm" id="markerB" name="markerB"
                            placeholder="อักษรย่อ" disabled>
                        <input type="text" class="form-control form-control-sm" id="customerB" name="customerB" hidden>
                    </div>

                    <!-- <div class="col-md-3 pr-md-0">
                            <label for="type_normal">สถานะ</label>
                            <select class="form-control form-control-sm" id="status" name="type_normal" style=" height: 30px; " disabled>
                                <option></option>
                                <option value="E">เชือดแกะ [E]</option> 
                                <option value="K">เชือดเก็บ [K]</option> 
                                <option value="">เหมา</option>
                            </select>
                            {{-- <input type="number" class="form-control form-control-sm" id="round" placeholder="รอบที่" value="1" required>  --}}
                        </div>

                        <div class="col-md-2 pr-md-0">
                            <label for="marker">อักษรย่อ</label>
                            <input type="text" class="form-control form-control-sm" id="marker" name="marker" placeholder="อักษรย่อ" required> 
                            <input type="text" class="form-control form-control-sm" id="customer_id" name="customer_id" hidden> 
                        </div>

                        <div class="col-md-2 pr-md-0">
                            <label for="amount">จำนวน(ตัว)</label>
                            <input type="number" class="form-control form-control-sm" id="amount" name="amount" placeholder="จำนวน" > 
                        </div> -->
                </div>

                <div class="row" style="margin-bottom: 10px;">

                    <div class="col-md-6 pr-md-0">
                        <label for="order_ref">จาก Order เชือด</label>
                        <select class="form-control form-control-sm" id="order_ref" name="order_ref"
                            style=" height: 30px; " disabled>
                            
                            
                            @foreach ($order_ref as $order_)
                            @if($order_->order_number == $data_out->order_ref)
                            <option value="{{ $data_out->order_ref}}" selected disabled>{{ $order_->order_number }} | เหลือ
                                {{ $order_->current_offal }} ตัว</option>
                            
                            <option></option>
                            @endif
                            <option value="{{ $order_->order_number }}">{{ $order_->order_number }} | เหลือ
                                {{ $order_->current_offal }} ตัว</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 pr-md-0">
                        <label for="provider">ผู้จัดทำ</label>
                        <input type="text" class="form-control form-control-sm" id="provider" name="provider"
                            placeholder="ผู้จัดทำ" value="{{ $data_out->id_user_provider }}" disabled>
                    </div>
                </div>

                <div class="row" style="margin-bottom: 10px;">
                    <div class="col-md-12 pr-md-0">
                        <label for="note">หมายเหตุ</label>
                        <textarea class="form-control form-control-sm" id="note" name="note" rows="3"
                            placeholder="หมายเหตุ" disabled>{{ $data_out->note}}</textarea>
                    </div>
                </div>

                {{-- <div class="row" style="margin-bottom: 10px;">
                        <div class="col-md-9 pr-md-0">
                            <label for="note">หมายเหตุ</label>
                            <textarea class="form-control form-control-sm" id="note" name="note" rows="3" placeholder="หมายเหตุ"></textarea> 
                        </div>
                        <div class="col-md-3 pr-md-0">
                            <label for="provider">ผู้จัดทำ</label>
                            <input type="text" class="form-control form-control-sm" id="provider" name="provider" placeholder="ผู้จัดทำ" required>
                        </div>
                    </div> --}}

                <div class="text-center" style="padding-top: 10px;">
                    <button type="submit" class="btn btn-danger mr-2">ลบข้อมูล</button>&emsp;
                    <a href="{{url('/order/product_transfer')}}">
                        <button class="btn btn-sm btn-outline btn-secondary" type="button" dis><i
                                class="fa fa-share-square-o" aria-hidden="true">&ensp;กลับไปก่อนหน้า</i></button>
                    </a>
                </div>

            </div>
            {{ Form::hidden('id', $data_out->id, ['class' => 'form-control','id' => 'id']) }}

            @endforeach
            {{ Form::close() }}
        </div>
    </div>
</div>



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

<!-- ลบ order -->
<script>
    function deleteOrder(order_number) {
        if (confirm('ต้องการลบ Order : ' + order_number + ' ?')) {
            $.ajax({
                type: 'GET',
                url: '{{ url('delete_order_offal') }}',
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
    window.onload = function (e){
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
</script>


@endsection