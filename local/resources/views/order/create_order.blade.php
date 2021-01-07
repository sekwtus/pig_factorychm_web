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

<div class="ajax-loader" style="height: 800px;">
    <img src="{{ asset('assets/images/pig_fly.gif')}}" alt="" style="margin-left: 0px;top: 3%;width: 350px; left:37%;" class="img-responsive"  />
</div>

<div class="row ">
    <div class="col-lg-5 grid-margin">
        <div class="card">
            <div class="card-body">
                <form action="#" id="submit">
                    <div class="forms-sample form-control" style="height: 620px;padding-right: 20px;">
                    <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;">ใบสั่งแผน Order </div>
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-md-4 pr-md-0">
                            <label for="type_req">ประเภท</label>
                            <select class="form-control form-control-sm" id="type_req" name="type_req" onchange="customerDll(this,this.value);" style=" height: 30px; " required>
                                @foreach ($type_order as $type)
                                    <option value="{{ $type->id }}">{{ $type->order_type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 pr-md-0">
                            <label for="type_req">ประเภทหมู</label>
                            <select class="form-control form-control-sm" id="type_pig" name="type_pig"  style=" height: 30px; " required>
                                @foreach ($standard_pricr_list_group as $item)
                                <option value="{{ $item->id }}">{{ $item->price_list }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 pr-md-0">
                            <label for="type_req">บริการ</label>
                            <select class="form-control form-control-sm" id="type_order_bill" name="type_order_bill"  style=" height: 30px; " required>
                                @foreach ($type_order_bill as $type)
                                    <option value="{{ $type->id }}">{{ $type->type_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-md-6 pr-md-0">
                            <label for="orderDate">วันที่รับสุกร</label>
                            <input class="form-control form-control-sm" placeholder="วว/ดด/ปปปป" id="datepicker" type="text" name="datepicker" value="" required>
                        </div>
                        <div class="col-md-6 pr-md-0">
                            <label for="stock">stock</label>
                            <select class="form-control form-control-sm" id="stock" name="stock" style=" height: 30px; " required>
                                @foreach ($stock as $stock_)
                                    <option value="{{ $stock_->id_storage }}">{{ $stock_->name_storage }} - {{ $stock_->description }} [{{ $stock_->current_unit }}]</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-md-5 pr-md-0">
                            <label for="customer">ลูกค้า/สาขา</label>
                            <select class="form-control form-control-sm  js-example-basic-single" onchange="setMarker(this)" id="customer" name="customer" style=" height: 30px; " required>
                                <option></option>
                                @foreach ($customer as $cust)
                                    @if ($cust->type != 'สาขา' && $cust->type != 'ลูกค้าซาก')
                                        <option value="{{ $cust->customer_name }}">{{ $cust->customer_name }}</option> 
                                    @endif    
                                @endforeach
                            </select>
                            {{-- <input type="radio" class="form-control form-control-sm" id="customer" placeholder="เชือด" required> --}}
                        </div>
                        <div class="col-md-3 pr-md-0">
                            <label for="marker">อักษรย่อ</label>
                            <input type="text" class="form-control form-control-sm" id="marker" placeholder="อักษรย่อ" required> 
                            <input type="text" class="form-control form-control-sm" id="customer_id" hidden> 
                        </div>
                        <div class="col-md-4 pr-md-0">
                            <label for="status">สถานะ</label>
                            <select class="form-control form-control-sm" id="status" name="status" style=" height: 30px; " disabled>
                                <option></option>
                                <option value="E">เชือดแกะ [E]</option> 
                                <option value="K">เชือดเก็บ [K]</option> 
                            </select>
                            {{-- <input type="number" class="form-control form-control-sm" id="round" placeholder="รอบที่" value="1" required>  --}}
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-md-3 pr-md-0">
                            <label for="round">รอบที่</label>
                            <input type="text" class="form-control form-control-sm" id="round" placeholder="รอบที่" > 

                            {{-- <select class="form-control form-control-sm" id="round" name="round" style=" height: 30px; ">
                                <option></option>
                                <option value="A">A</option> 
                                <option value="B">B</option> 
                                <option value="C">C</option> 
                                <option value="D">D</option> 
                                <option value="E">E</option> 
                            </select> --}}
                        </div>
                        <div class="col-md-3 pr-md-0">
                            <label for="amount">จำนวน(ตัว)</label>
                            <input type="number" class="form-control form-control-sm" id="amount" placeholder="จำนวน" required> </div>
                        <div class="col-md-6 pr-md-0">
                            <label for="weight_range">ช่วงน้ำหนัก</label>
                            {{-- <input type="text" class="form-control form-control-sm" id="weight_range" placeholder="ช่วงน้ำหนัก" required> </div> --}}
                            <select class="form-control form-control-sm" id="weight_range" style=" height: 30px; " required>
                                @foreach ($standard_weight as $item)
                                    <option value="{{$item->standard_period}}">{{$item->standard_period}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-md-12 pr-md-0">
                            <label for="note">หมายเหตุ</label>
                            <textarea class="form-control form-control-sm" id="note" rows="3" placeholder="หมายเหตุ"></textarea> </div>
                        </div>

                    <div class="row "style="margin-bottom: 10px;">
                        <div class="col-md-6 pr-md-0">
                            <label for="provider">ผู้จัดทำ</label>
                            <input type="text" class="form-control form-control-sm" id="provider" placeholder="ผู้จัดทำ" required>
                        </div>
                    </div>

                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-md-6 pr-md-0">
                            <label for="sender">ผู้ส่ง</label>
                            <input type="text" class="form-control form-control-sm" id="sender" placeholder="ผู้ส่ง">
                        </div>

                        <div class="col-md-6 pr-md-0">
                            <label for="recieve">ผู้รับ</label>
                            <input type="text" class="form-control form-control-sm" id="recieve" placeholder="ผู้รับ">
                        </div>
                    </div>

                        <div class="text-center" style="padding-top: 10px;">
                            <button type="submit" class="btn btn-success mr-2">ยืนยัน</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-7 grid-margin">
        <div class="card">
            <div class="card-body ">
                <div class="row">
                    <div class="col-3"><h4>รายการใบ Order (แสดงข้อมูล 30 วันย้อนหลัง)</h4></div>
                    <h4 class="col-2">ประจำวันที่ : </h4>
                    <input class="form-control form-control-sm col-2 input-daterange-datepicker" type="text" id="dateFilterReceive" name="dateFilterReceive"/>
                </div>
                    <table class="table table-striped table-bordered nowrap table-hover table-responsive" width="100%" id="orderTable">
                        <thead class="text-center">
                            <tr>
                                <th style="padding: 0px; font-size: 0.7rem;">เลขที่ Order</th>
                                <th style="padding: 0px; font-size: 0.7rem;">ลูกค้า</th>
                                <th style="padding: 0px; font-size: 0.7rem;">บริการ</th>
                                <th style="padding: 0px; font-size: 0.7rem;">รอบที่</th>
                                <th style="padding: 0px; font-size: 0.7rem;">ตัวย่อ</th>
                                <th style="padding: 0px; font-size: 0.7rem;">จำนวน(ตัว)</th>
                                <th style="padding: 0px; font-size: 0.7rem;">จากคอก</th>
                                <th style="padding: 0px; font-size: 0.7rem;">ช่วงน้ำหน้ก</th>
                                <th style="padding: 0px; font-size: 0.7rem;">ประเภท</th>
                                <th style="padding: 0px; font-size: 0.7rem;">วันผลิต</th>
                                <th style="padding: 0px; font-size: 0.7rem;">เลขที่ ใบส่งของ</th>
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

<div class="modal fade" id="Alert" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="swal-icon swal-icon--warning">
                <span class="swal-icon--warning__body">
                  <span class="swal-icon--warning__dot"></span>
                </span>
            </div>
            <h4 class="text-center"> เลข Order ซ้ำ กรุณาเปลี่ยนวันที่หรือเปลี่ยนรอบ</h4>
        </div>
    </div>
</div>

{{-- <button id="x" name="x" class="x" onclick="showx()">  xx</button> --}}
@endsection

@section('script')
<script src="{{ asset('https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/js/shared/select2.js')}}"></script>
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
                { data: 'type_name', name: 'type_name' },
                { data: 'round', name: 'round' },
                { data: 'marker', name: 'marker' },
                { data: 'total_pig', name: 'total_pig' },
                { data: 'name_storage', name: 'name_storage' },
                { data: 'weight_range', name: 'weight_range' },
                { data: 'order_type', name: 'order_type' },
                { data: 'date', name: 'date' },
                { data: 'do_number', name: 'do_number' },
                { data: 'id', name: 'id' },
            ],
            columnDefs: [
            {
                "targets": 0,
                "className": "text-center",render(data,type,row){

                   return '<a target="blank_" href="../summary_weighing_receive/'+data+'">'+data+'</a>';
                      
                }
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
                    render(data,type,row){
                        if (data != null && data != '') {
                            return data + ' ' + row['description'];
                        } else {
                            return '-';
                        }
                    },
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
                "targets": 10,
                    "className": "text-right",render(data,type,row){
                    var sign = "'";
                    var order_number = row['order_number']; 
                    var customer_id = row['customer_id'];
                    if(( row["status_bill"] == null ) || (row["status_bill"] == "0")){
                        return '<div><button style="padding: 7px;" type="button" onclick="waybill('+sign+order_number+sign+','+sign+customer_id+sign+')" class="btn btn-success" title="ใบส่งของ">\
                                <i class="mdi mdi-printer"></i></button></div>';
                    }else{
                    return '<div><a target="blank_" href="../bill_detail_p_order/'+order_number+'">พิมพ์บิล</a>\
                            <button style="padding: 7px;" type="button" onclick="deleteOrder_Bill('+sign+order_number+sign+')" class="btn btn-dark" data-toggle="modal" data-target="#DELETE" >\
                            <i class="mdi mdi-delete"></i></button></div>';
                    }
                }
            },
            {
                "targets": 11,render(data,type,row){
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
                    var type_name = row['type_name'];
                    var customer_id = row['customer_id'];


                        return '<div class="text-reight"><button style="padding: 7px;" type="button" class="btn btn-warning" title="แก้ไข"\
                        onclick="editModal('+sign+order_number+sign+','+sign+id_user_customer+sign+','+sign+marker+sign+',\
                        '+sign+total_pig+sign+','+sign+weight_range+sign+','+sign+date+sign+','+sign+note+sign+','+sign+type_request+sign+','+sign+order_type+sign+','+sign+round+sign+','+sign+type_name+sign+')" >\
                        <i class="mdi mdi-pencil"></i></button>\
                        <button style="padding: 7px;" type="button" onclick="deleteOrder('+sign+order_number+sign+')" class="btn btn-danger" data-toggle="modal" data-target="#DELETE" >\
                        <i class="mdi mdi-delete"></i></button></div>';
                    
                    
                }
            },
            ],
            "order": [],
        });

        $.fn.dataTable.ext.search.push(
            function( settings, data, dataIndex ) {

                // console.log(settings.nTable.id);
                if ( settings.nTable.id !== 'orderTable' ) {
                    return true;
                }

                var iStartDateCol = 9;

                var daterange = $('#dateFilterReceive').val();
                var dateMin=daterange.substring(6,10) + daterange.substring(3,5)+ daterange.substring(0,2);
                var colDate=data[iStartDateCol].substring(6,12) + data[iStartDateCol].substring(3,5) + data[iStartDateCol].substring(0,2);

                var min = parseInt( dateMin );
                var Date_data = parseFloat( colDate ) || 0;

                if ( ( isNaN( min ) ) || ( min == Date_data) )
                {
                    return true;
                }
                return false;
            }
        );

        $(document).ready(function() {
            $('#dateFilterReceive').change( function() {
                table.draw();
            } );
        } );
   
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
        var stock = $('#stock').val();
        var status = $('#status').val();
        var type_order_bill = $('#type_order_bill').val();
        var type_pig = $('#type_pig').val();
        // var type_req_1 = 0;
        // if($('#vehicle1').prop("checked") == true ){
        //     var type_req_1 = $('#vehicle1').val();
        // }
        // var type_req_2 = 0;
        // if($('#vehicle2').prop("checked") == true ){
        //     var type_req_2 = $('#vehicle2').val();
        // }
        // var type_req_3 = 0;
        // if($('#vehicle3').prop("checked") == true ){
        //     var type_req_3 = $('#vehicle3').val();
        // }
        
        
        if (orderNo != '' && datepicker != '' && amount != '' && weight_range != '' && customer != '' && provider != '') {   
            $.ajax({
                type: 'GET',
                beforeSend: function(){
                    $('.ajax-loader').css("visibility", "visible");
                },
                url: '{{ url('create_order') }}',
                data: {orderNo:orderNo,datepicker:datepicker,amount:amount,
                    weight_range:weight_range,note:note,customer:customer,
                    sender:sender,recieve:recieve,type_req:type_req,marker:marker,
                    round:round,customer_id:customer_id,type_order_bill:type_order_bill,type_pig:type_pig,stock,status},
                success: function (msg) {
                    if (msg == '1') {
                        $("#Alert").modal();
                    } else {
                        alert(msg);
                        console.log(msg);
                        location.reload();
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("Status: " + textStatus); alert("Error: " + errorThrown);
                },
                complete: function(){
                    $('.ajax-loader').css("visibility", "hidden");
                }
            });
        }
    });
</script>

<script>
    function deleteOrder(order_number){
        if(confirm('ต้องการลบ Order : '+order_number+' ?')){
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
    function deleteOrder_Bill(order_number){
        if(confirm('ต้องการลบ Bill  : '+order_number+' ?')){
            $.ajax({
                type: 'GET',
                url: '{{ url('delete_order_bill') }}',
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
    function editModal(order_number,id_user_customer,marker,total_pig,weight_range,date,note,type_request,order_type,round,type_name){
        $("#EDIT").modal();
        var get_type_order = '';
        var get_type_bill = '';
            $.ajax({
                type: 'GET',
                url: '{{ url('ajax_type_order') }}',
                data: {},
                success: function (data) {console.log(data);
                    data[0].forEach(element => {
                        if (order_type == element.order_type) {
                            get_type_order = get_type_order + '<option selected value="'+element.id+'">'+element.order_type+'</option>';
                            
                        } 
                        // else {
                        //     get_type_order = get_type_order + '<option value="'+element.id+'">'+element.order_type+'</option>';
                        // }
                    });
                    data[1].forEach(element => {
                        if(element.type_name == type_name){
                            get_type_bill = get_type_bill + '<option selected value="'+element.id+'"  >'+element.type_name+'</option>';
                        }else{
                            get_type_bill = get_type_bill + '<option  value="'+element.id+'">'+element.type_name+'</option>';
                        }
                        
                    });
                    if (note == '' || note == null || note == 'null') {
                        note = '';
                    }
                    if (round == '' || round == null || round == 'null') {
                        round = '';
                    }

                    var str = '<div class="forms-sample form-control" style="height: 450px;padding-right: 20px;">\
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
                                    <label for="type_req">ประเภทบริการ</label>\
                                        <select class="form-control form-control-sm" id="type_bill" name="type_bill" style=" height: 30px; " required>\
                                            '+get_type_bill+'\
                                    </select>\
                                </div>\
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
                                    <select class="form-control form-control-sm" id="round" name="round" style=" height: 30px; ">\
                                        <option value="'+round+'">'+round+'</option>\
                                        <option value=""></option>\
                                        <option value="A">A</option>\
                                        <option value="B">B</option>\
                                        <option value="C">C</option>\
                                        <option value="D">D</option>\
                                        <option value="E">E</option>\
                                    </select>\
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
                                    <button type="submit" name="order_number" value="'+order_number+'" class="btn btn-success mr-2" onclick="loader2()">ยืนยัน</button>\
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
    $('#dateFilterReceive').daterangepicker({
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
    function setMarker(customer){
        // alert(customer.value);
        $.ajax({
                type: 'GET',
                url: '{{ url('getMarkerCustomer') }}',
                data: {customer:customer.value},
                success: function (data) {
                    $('#marker').val(data[0].marker);
                    $('#customer_id').val(data[0].id);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("Status: " + textStatus); alert("Error: " + errorThrown);
                }
            });
    }

    function customerDll(type_req,value){

        $.ajax({
            type: 'GET',
            url: '{{ url('getCustomer') }}',
            data: {},
            success: function (data) {
               
                var str ='<option value=""></option>';
                data.forEach(element => {
                    if (type_req.value == 3) {
                        if (element.type == 'สาขา') {
                        str = str + '<option value="'+element.customer_name+'">'+element.customer_name+'</option>';
                        }
                        $('#status').prop( "disabled", false );
                        $('#vehicle1').prop('checked', true);
                        $('#vehicle2').prop('checked', true);
                    }else if (type_req.value == 2) {
                        if (element.type == 'ลูกค้าซาก') {
                        str = str + '<option value="'+element.customer_name+'">'+element.customer_name+'</option>';
                        }
                        $('#status').prop( "disabled", true );
                        $('#vehicle1').prop('checked', false);
                        $('#vehicle2').prop('checked', false);
                    }
                    else{
                        if (element.type != 'สาขา' && element.type != 'ลูกค้าซาก') {
                        str = str + '<option value="'+element.customer_name+'">'+element.customer_name+'</option>';
                        }
                        $('#status').prop( "disabled", true );
                        $('#vehicle1').prop('checked', false);
                        $('#vehicle2').prop('checked', false);
                    }
                });
                $('#customer').html(str);
                // console.log(type_req.value);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert("Status: " + textStatus); alert("Error: " + errorThrown);
            }
        }); console.log(value)

    }
</script>

<script>
    var msg = '{{Session::get('alert')}}';
    var exist = '{{Session::has('alert')}}';
    if(exist){
        $("#Alert").modal();
    }
</script>
<script>
    function loader2(){
        $("#EDIT").modal('hide');
        $('.ajax-loader').css("visibility", "visible");
    }
</script>

<script>
    function deleteOrder(order_number){
        if(confirm('ต้องการพิมพ์ Order : '+order_number+' ?')){
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
    function waybill(order_number,id_user_customer){
         var date = $("#dateFilterReceive").val();
         var date_payment = $("#dateFilterReceive").val();
         var oeder = [order_number];
         var customer = id_user_customer;
        
         $.ajax({
                // async: false,
                type: 'GET',
                url: '{{ url('create_bill_order') }}',
                data: {date:date,date_payment:date_payment,order:oeder,customer:customer},
                // beforeSend: function(){
                //     $('.ajax-loader').css("visibility", "visible");
                // },
                success: function (data) {
                    // console.log(data);
                    // data.forEach(element => {
                        // window.open("{{ url('bill_detail_p') }}/"+element.id+"/"+element.type, '_blank');
                        window.open("{{ url('bill_detail_p_order') }}/"+data, '_blank').focus();
                        // window.opener.focus();
                        console.log(data);
                        // console.log("{{ url('bill_detail_p') }}/"+element.id+"/"+element.type);
                    // });
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("Status: " + textStatus); alert("Error: " + errorThrown);
                }
            });

    }
</script>

@endsection


