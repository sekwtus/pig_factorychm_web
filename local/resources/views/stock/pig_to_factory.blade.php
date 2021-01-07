

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
</style>
<link rel="stylesheet" href="{{ url('https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ url('https://cdn.datatables.net/1.10.18/css/dataTables.semanticui.min.css') }}" type="text/css" />
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
         
                <form class="form-inline repeater">
                    <div class="forms-sample form-control" style="height: auto;padding-right: 20px;">
                        <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;padding-bottom: 0px;">
                            <div class="row">
                                <h4 class="col-6" style="height: 25px;margin-bottom: 0px;padding-bottom: 35px; color:black;" id="switch_button"><b>ใบรับสุกรเข้าโรงงาน</b></h4>
                                <h4 class="col-2">ประจำวันที่ : </h4>
                                <input class="form-control form-control-sm col-2 input-daterange-datepicker" type="text" id="datepicker" name="datepicker" style="padding: 5px; height: 30px;">
                            </div>
                        </div>

                        <div data-repeater-list="group-a">
                            <div data-repeater-item class="d-flex mb-2">
                            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                <div class="row" style="margin-bottom: 10px;">
                                    <div class="col-md-1 pr-md-0">
                                        <label class=" col-md-4" for="type_req">No.</label>
                                        <input class="form-control form-control-sm col-md-12" id="detail" type="text" name="detail" value="1" readonly required />  
                                    </div>
                                    <div class="col-md-2 pr-md-0">
                                        <label class=" col-md-4" for="type_req">รายการ</label>
                                        <input class="form-control form-control-sm col-md-12" placeholder="รายการ" id="detail" type="text" name="detail" value="" required>  
                                    </div>
                                    <div class="col-md-2 pr-md-0">
                                        <label class=" col-md-6" for="customer">ลูกค้า/สาขา</label>
                                        <select class="form-control form-control-sm  col-md-12" id="customer" name="customer" style=" height: 30px; " required>
                                            <option></option>
                                            @foreach ($customer as $cust)
                                                <option value="{{ $cust->customer_name }}">{{ $cust->customer_name }}</option> 
                                            @endforeach
                                        </select> 
                                    </div>
                                    <div class="col-md-1 pr-md-0">
                                        <label class=" col-md-10" for="amount">จำนวน(ตัว)</label>
                                        <input type="number" class="form-control form-control-sm col-md-12" id="amount" placeholder="จำนวน" required> 
                                    </div>
                                    <div class="col-md-3 pr-md-0">
                                        <label  class=" col-md-6" for="customer">ที่จัดเก็บ (stock)</label>
                                        <select class="form-control form-control-sm col-md-12" id="customer" name="customer" style=" height: 30px; " required>
                                            <option></option>
                                            @foreach ($storage as $store)
                                                <option value="{{ $store->id_storage }}">{{ $store->name_storage }} - ( {{ $store->description }} )</option> 
                                            @endforeach
                                        </select> 
                                    </div>
                                    <div class="col-md-2 pr-md-0">
                                        <label class=" col-md-4" for="type_req">หมายเหตุ</label>
                                        <input class="form-control form-control-sm col-md-12" placeholder="หมายเหตุ" id="note" type="text" name="note" value="" required>  
                                    </div>
                                    <div class="col-md-1 pr-md-0">
                                        <label class=" col-md-4" for="type_req">&nbsp;</label>
                                        <button data-repeater-delete type="button" class="btn btn-danger btn-sm icon-btn ml-2">
                                            <i class="mdi mdi-delete"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-8"></div>
                            <button data-repeater-create type="button" class="btn btn-info btn-sm icon-btn ml-2 mb-2">
                                <i class="mdi mdi-plus"></i>
                            </button>
                            <label class=" col-md-1" for="amount"> จำนวนรวม</label>
                            <input type="number" class="form-control form-control-sm col-md-1" id="amount" placeholder="จำนวน" readonly> 
                            
                            <button type="submit" class="btn btn-success icon-btn ml-2 mb-2">ยืนยัน</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<div class="row ">
    <div class="col-lg-12 grid-margin">
        <div class="card">
            <div class="card-body ">
                <div class="row">
                    <div class="col-4"><h4>รายการใบ Order</h4></div>
                </div>
                    <table class="table table-striped table-bordered nowrap table-hover table-responsive" width="100%" id="orderTable">
                        <thead class="text-center">
                            <tr>
                            <th style="padding: 0px; font-size: 0.7rem;">เลขที่ Order</th>
                            <th style="padding: 0px; font-size: 0.7rem;">ลูกค้า</th>
                            <th style="padding: 0px; font-size: 0.7rem;">รอบที่</th>
                            <th style="padding: 0px; font-size: 0.7rem;">ตัวย่อ</th>
                            <th style="padding: 0px; font-size: 0.7rem;">จำนวน(ตัว)</th>
                            <th style="padding: 0px; font-size: 0.7rem;">ช่วงน้ำหน้ก</th>
                            <th style="padding: 0px; font-size: 0.7rem;">ประเภท</th>
                            <th style="padding: 0px; font-size: 0.7rem;">ประจำวันที่</th>
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
            ajax: '{{ url('order/get_ajax') }}',
            columns: [
                { data: 'order_number', name: 'order_number' },
                { data: 'id_user_customer', name: 'id_user_customer' },
                { data: 'round', name: 'round' },
                { data: 'marker', name: 'marker' },
                { data: 'total_pig', name: 'total_pig' },
                { data: 'weight_range', name: 'weight_range' },
                { data: 'order_type', name: 'order_type' },
                { data: 'date', name: 'date' },
                { data: 'status', name: 'status' },
                { data: 'note', name: 'note' },
                { data: 'id', name: 'id' },
            ],
            columnDefs: [
            {
                "targets": 0,
                    "className": "text-center",
            },
            {
                "targets": 1,
                    "className": "text-center",
            },
            {
                "targets": 2,
                    "className": "text-center",
            },
            {
                "targets": 3,
                    "className": "text-center",
            },
            {
                "targets": 4,
                    "className": "text-center",
            },
            {
                "targets": 5,
                    "className": "text-center",
            },
            {
                "targets": 6,
                    "className": "text-center",
            },
            {
                "targets": 7,
                    "className": "text-center",
            },
            {
                "targets": 8,
                    "className": "text-center",
            },
            {
                "targets": 9,
                    "className": "text-center",
            },
            {
                "targets": 10,render(data,type,row){
                    var sign = "'";
                    var order_number = row['order_number'];
                    var id_user_customer = row['id_user_customer'];
                    var marker = row['marker'];
                    var total_pig = row['total_pig'];
                    var weight_range = row['weight_range'];
                    var date = row['date'];
                    var note = row['note'];
                    var type_request = row['type_request'];
                    var order_type = row['order_type'];
                    var round = row['round'];
                    

                    return '<button style="padding: 7px;" type="button" class="btn btn-warning" title="แก้ไข"\
                    onclick="editModal('+sign+order_number+sign+','+sign+id_user_customer+sign+','+sign+marker+sign+',\
                    '+sign+total_pig+sign+','+sign+weight_range+sign+','+sign+date+sign+','+sign+note+sign+','+sign+type_request+sign+','+sign+order_type+sign+','+sign+round+sign+')" >\
                            <i class="mdi mdi-pencil"></i></button>\
                            <button style="padding: 7px;" type="button" onclick="deleteOrder('+sign+order_number+sign+')" class="btn btn-danger" data-toggle="modal" data-target="#DELETE" >\
                            <i class="mdi mdi-delete"></i></button></td>';
                }
            },
            ],
            "order": [],
        });
</script>


{{-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script> --}}
<script src="{{ asset('https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js') }}"></script>

{{-- save Order --}}
<script>
    $("#submit").submit(function() {
        var orderNo = $('#orderNo').val();
        var datepicker = $('#datepicker').val();
        var amount = $('#amount').val();
        var weight_range = $('#weight_range').val();
        var note = $('#note').val();
        var customer = $('#customer').val();
        var provider = $('#provider').val();
        var sender = $('#sender').val();
        var recieve = $('#recieve').val();
        var type_req = $('#type_req').val();
        var marker = $('#marker').val();
        var round = $('#round').val();
        var customer_id = $('#customer_id').val();
        
        
        if (orderNo != '' && datepicker != '' && amount != '' && weight_range != '' && customer != '' && provider != '') {   
            $.ajax({
                type: 'GET',
                url: '{{ url('create_order') }}',
                data: {orderNo:orderNo,datepicker:datepicker,amount:amount,
                    weight_range:weight_range,note:note,customer:customer,
                    sender:sender,recieve:recieve,type_req:type_req,marker:marker,
                    round:round,customer_id:customer_id},
                success: function (msg) {
                    alert(msg);
                    console.log(msg);
                    location.reload();
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("Status: " + textStatus); alert("Error: " + errorThrown);
                }
            });
        }
    });
</script>

<script>
    function deleteOrder(order_number){
        if(confirm('ต้องการ Order : '+order_number+' ?')){
            $.ajax({
                type: 'GET',
                url: '{{ url('delete_order') }}',
                data: {order_number:order_number},
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
    function editModal(order_number,id_user_customer,marker,total_pig,weight_range,date,note,type_request,order_type,round){
        $("#EDIT").modal();
        var get_type_order = '';
            $.ajax({
                type: 'GET',
                url: '{{ url('ajax_type_order') }}',
                data: {},
                success: function (data) {
                    data.forEach(element => {
                        if (order_type == element.order_type) {
                            get_type_order = get_type_order + '<option selected value="'+element.id+'">'+element.order_type+'</option>';
                            
                        } else {
                            get_type_order = get_type_order + '<option value="'+element.id+'">'+element.order_type+'</option>';
                        }
                    });

                    if (note == '' || note == null || note == 'null') {
                        note = '';
                    }

                    var str = '<div class="forms-sample form-control" style="height: auto;padding-right: 20px;">\
                            <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;">แก้ไข Order <b style="color:black;">'+order_number+'</b></div>\
                            <div class="row" style="margin-bottom: 10px;">\
                                <div class="col-md-6 pr-md-0">\
                                    <label for="type_req">ประเภท</label>\
                                        <select class="form-control form-control-sm" id="type_req" name="type_req" style=" height: 30px; " required>\
                                            '+get_type_order+'\
                                    </select>\
                                </div>\
                                <div class="col-md-6 pr-md-0">\
                                    <label for="orderDate">ประจำวันที่</label>\
                                    <input class="form-control form-control-sm" placeholder="วว/ดด/ปปปป" type="text" id="datepicker2" name="datepicker" value="'+date+'" required></div>\
                            </div>\
                            <div class="row" style="margin-bottom: 10px;">\
                                <div class="col-md-6 pr-md-0">\
                                    <label for="customer">ลูกค้า/สาขา</label>\
                                    <input readonly type="text" class="form-control form-control-sm" name="customer" id="customer" placeholder="ลูกค้า" value="'+id_user_customer+'" required>\
                                </div>\
                                <div class="col-md-3 pr-md-0">\
                                    <label for="marker">อักษรย่อ</label>\
                                    <input readonly type="text" class="form-control form-control-sm"  name="marker" id="marker" placeholder="อักษรย่อ" value="'+marker+'" required> \
                                </div>\
                                <div class="col-md-3 pr-md-0">\
                                    <label for="round">รอบที่</label>\
                                    <input type="number" class="form-control form-control-sm" name="round" id="round" value="'+round+'" required> \
                                </div>\
                            </div>\
                            <div class="row" style="margin-bottom: 10px;">\
                                <div class="col-md-6 pr-md-0">\
                                    <label for="amount">จำนวน(ตัว)</label>\
                                    <input type="number" class="form-control form-control-sm" name="amount" id="amount" placeholder="จำนวน" value="'+total_pig+'" required> </div>\
                                <div class="col-md-6 pr-md-0">\
                                    <label for="weight_range">ช่วงน้ำหนัก</label>\
                                    <input type="text" class="form-control form-control-sm" name="weight_range" id="weight_range" placeholder="ช่วงน้ำหนัก" value="'+weight_range+'" required> </div>\
                            </div>\
                            <div class="row" style="margin-bottom: 10px;">\
                                <div class="col-md-12 pr-md-0">\
                                    <label for="note">หมายเหตุ</label>\
                                    <input class="form-control form-control-sm" name="note" id="note" rows="3" placeholder="หมายเหตุ" value="'+note+'"></input> </div>\
                                </div>\
                                <div class="text-center" style="padding-top: 10px;">\
                                    <button type="submit" name="order_number" value="'+order_number+'" class="btn btn-success mr-2">ยืนยัน</button>\
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

                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
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
    $('#datepicker,#daterange2,#datepicker22').daterangepicker({
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


