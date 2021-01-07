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
                {{ Form::open(['method' => 'post' , 'url' => '/create_order_ov/create_order']) }}
                    <div class="forms-sample form-control" style="height: auto;padding-right: 20px;">
                    <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;">สร้างรายการเบิกซากจาก Overnight</div>
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-md-5 pr-md-0">
                            <label for="type_req">ประเภท</label>
                            <select class="form-control form-control-sm" id="type_req" onchange="customerDll(this);" name="type_req" style=" height: 30px; " required>
                                    <option></option>
                                    <option value="3">หมูสาขา</option>
                                    <option value="2">หมูลูกค้า</option>
                            </select>
                        </div>
                        <div class="col-md-4 pr-md-0">
                            <label for="orderDate">วันที่เบิกซาก</label>
                            <input class="form-control form-control-sm" placeholder="วว/ดด/ปปปป" id="dateOV" type="text" name="dateOV" value="" required>
                        </div>
                        <div class="col-md-3 pr-md-0">
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
                        <div class="col-md-6 pr-md-0">
                            <label for="customer">ลูกค้า/สาขา</label>
                            <select class="form-control form-control-sm" onchange="setMarker(this)" id="customer" name="customer" style=" height: 30px; " >
                                <option></option>
                                
                            </select>
                        </div>
                        <div class="col-md-3 pr-md-0">
                            <label for="marker">อักษรย่อ</label>
                            <input type="text" class="form-control form-control-sm" id="marker" name="marker" placeholder="อักษรย่อ" required> 
                            <input type="text" class="form-control form-control-sm" id="customer_id" name="customer_id" hidden> 
                        </div>

                        <div class="col-md-3 pr-md-0">
                            <label for="provider">ผู้จัดทำ</label>
                            <input type="text" class="form-control form-control-sm" id="provider" name="provider" placeholder="ผู้จัดทำ" required>
                        </div>
                    </div>
                    
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-md-9 pr-md-0">
                            <label for="order_ref">จาก Order เชือด</label>
                            <select class="form-control form-control-sm" id="order_ref[]" name="order_ref[]" style=" height: 30px; " onchange="check_stock_bk(this)">
                                <option></option>
                                @foreach ($order_ref as $order_)
                                    {{-- @if ($order_->side_of_pig > 0)
                                        @if ( strtotime('-5 day') >  strtotime($order_->date) )
                                            <option value="{{ $order_->order_number }}" disabled>{{ $order_->order_number }} | เหลือ {{ $order_->side_of_pig }} ตัว {{ $order_->date }}</option> 
                                        @else
                                            <option value="{{ $order_->order_number }}" >{{ $order_->order_number }} | เหลือ {{ $order_->side_of_pig }} ตัว {{ $order_->date }}</option> 
                                        @endif
                                    @else
                                        <option value="{{ $order_->order_number }}" disabled>{{ $order_->order_number }} | เหลือ {{ $order_->side_of_pig }} ตัว {{ $order_->date }}</option>
                                    @endif --}}
                                    
                                    <option value="{{ $order_->order_number }}">{{ $order_->order_number }} | เหลือ {{ $order_->side_of_pig }} ตัว </option> 
                                @endforeach
                            </select>
                            {{-- {{  date('d/m/Y', strtotime('-5 day'))  }} --}}
                        </div>
                        <div class="col-md-3 pr-md-0">
                            <label for="amount">จำนวน(ตัว)</label>
                            <input type="number" class="form-control form-control-sm" id="amount[]" name="amount[]" placeholder="จำนวน" required> 
                        </div>

                        <span id="mySpan"></span>

                    </div>
                    <div class="row text-left">
                        <div class="col-md-12 pr-md-0" >
                            <input name="btnButton" disabled class="btn btn-primary mr-2" id="btnButton" type="button" value="+" onClick="add(1);">
                            <input name="nButton" disabled class="btn btn-danger mr-2" id="nButton" type="button" value="-" onClick="JavaScript:dd();">
                        </div> 
                    </div> 

                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-md-12 pr-md-0">
                            <label for="note">หมายเหตุ</label>
                            <textarea class="form-control form-control-sm" id="note" name="note" rows="3" placeholder="หมายเหตุ"></textarea> 
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
                        <button type="submit" class="btn btn-success mr-2 loader">ยืนยัน</button>
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
                    <div class="col-5"><h4>รายการเบิกซากจาก Overnight</h4>
                    </div>
                    <h4 class="col-2">ประจำวันที่ : </h4>
                    <input class="form-control form-control-sm col-2 input-daterange-datepicker" type="text" id="dateFilterOffal" name="dateFilterOffal"/>
                </div>
                    <table class="table table-striped table-bordered nowrap table-hover table-responsive" width="100%" id="orderTable">
                        <thead class="text-center">
                            <tr>
                            <th style="padding: 0px; font-size: 0.7rem;">Order ใช้ชั่งนน.</th>
                            <th style="padding: 0px; font-size: 0.7rem;">เลขที่ Order</th>
                            <th style="padding: 0px; font-size: 0.7rem;">Order การเชือด</th>
                            <th style="padding: 0px; font-size: 0.7rem;">สาขา</th>
                            <th style="padding: 0px; font-size: 0.7rem;">รอบที่</th>
                            <th style="padding: 0px; font-size: 0.7rem;">ตัวย่อ</th>
                            <th style="padding: 0px; font-size: 0.7rem;">จำนวน(ตัว)</th>
                            <th style="padding: 0px; font-size: 0.7rem;">ประเภท</th>
                            <th style="padding: 0px; font-size: 0.7rem;">วันที่เบิกซาก</th>
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
{{ Form::open(['method' => 'post' , 'url' => 'order_ov/edit']) }}
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
            ajax: '{{ url('create_order_ov/get_ajax') }}',
            columns: [
                { data: 'order_group', name: 'order_group' },
                { data: 'order_number', name: 'order_number' },
                { data: 'order_ref', name: 'order_ref' },
                { data: 'id_user_customer', name: 'id_user_customer' },
                { data: 'round', name: 'round' },
                { data: 'marker', name: 'marker' },
                { data: 'total_pig', name: 'total_pig' },
                { data: 'order_type', name: 'order_type' },
                { data: 'date', name: 'date' },
                { data: 'note', name: 'note' },
                { data: 'id', name: 'id' },
            ],
            columnDefs: [
            {
                "targets": 0,
                    "className": "text-center",
                    render(data,type,row){
                        return '<a target="blank_" href="summary_weighing_offal/'+data+'">'+data+'</a>';
                    }
            },
            {
                "targets": 1,
                "className": "text-center",
            },
            {
                "targets": 2,
                    "className": "text-center",
                    render(data,type,row){
                        return '<a target="blank_" href="summary_weighing_receive/'+data+'">'+data+'</a>';
                    }
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
                    var order_ref = row['order_ref'];
                    var order_group = row['order_group'];
                    

                    return '<button style="padding: 7px;" type="button" class="btn btn-warning" title="แก้ไข"\
                    onclick="editModal('+sign+order_group+sign+','+sign+id_user_customer+sign+','+sign+marker+sign+',\
                    '+sign+total_pig+sign+','+sign+weight_range+sign+','+sign+date+sign+','+sign+note+sign+','+sign+type_request+sign+','+sign+order_type+sign+','+sign+round+sign+','+sign+order_ref+sign+')" >\
                            <i class="mdi mdi-pencil"></i></button>\
                            <button style="padding: 7px;" type="button" onclick="deleteOrder('+sign+order_group+sign+')" class="btn btn-danger" data-toggle="modal" data-target="#DELETE" >\
                            <i class="mdi mdi-delete"></i></button></td>';
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

                var iStartDateCol = 8;

                var daterange = $('#dateFilterOffal').val();
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
            $('#dateFilterOffal').change( function() {
                table.draw();
            } );
        } );


</script>

{{-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script> --}}
<script src="{{ asset('https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js') }}"></script>

<script>
    function deleteOrder(order_group){
        if(confirm('ลบทุก Order ในกลุ่ม : '+order_group+' ยืนยันการลบหรือไม่ ?')){
            $.ajax({
                type: 'GET',
                url: '{{ url('delete_order_ov') }}',
                data: {order_group:order_group},
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
  function editModal(order_group,id_user_customer,marker,total_pig,weight_range,date,note,type_request,order_type,round,order_ref){
        $("#EDIT").modal();
        var get_type_order = '';
        var get_status = '';
            $.ajax({
                type: 'GET',
                url: '{{ url('ajax_type_order') }}',
                data: {},
                success: function (data) {
                    data.forEach(element => {
                        if (order_type == element.order_type) {
                            get_type_order = get_type_order + '<option selected value="'+element.id+'">'+element.order_type+'</option>';
                            
                        }
                        // else {
                        //     get_type_order = get_type_order + '<option value="'+element.id+'">'+element.order_type+'</option>';
                        // }
                    });
                    

                    if (note == '' || note == null || note == 'null') {
                        note = '';
                    }

                    var str = '<div class="forms-sample form-control" style="height: auto;padding-right: 20px;">\
                            <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;">แก้ไข Order <b style="color:black;">'+order_group+'</b></div>\
                            <div class="row" style="margin-bottom: 10px;">\
                                <div class="col-md-4 pr-md-0">\
                                    <label for="customer">ลูกค้า/สาขา</label>\
                                    <input readonly type="text" class="form-control form-control-sm" name="customer" id="customer" placeholder="ลูกค้า" value="'+id_user_customer+'" required>\
                                </div>\
                                <div class="col-md-4 pr-md-0">\
                                    <label for="marker">อักษรย่อ</label>\
                                    <input readonly type="text" class="form-control form-control-sm"  name="marker" id="marker" placeholder="อักษรย่อ" value="'+marker+'" required> \
                                </div>\
                                <div class="col-md-4 pr-md-0">\
                                    <label for="amount" >จำนวน(ตัว)</label>\
                                    <input type="number" readonly class="form-control form-control-sm" name="amount" id="amount" placeholder="จำนวน" value="'+total_pig+'" > </div>\
                            </div>\
                            <div class="row" style="margin-bottom: 10px;">\
                                <div class="col-md-6 pr-md-0">\
                                    <label for="orderDate">วันที่เบิกซาก</label>\
                                    <input class="form-control form-control-sm" placeholder="วว/ดด/ปปปป" type="text" id="datepicker2" name="dateOV" value="'+date+'" required></div>\
                                <div class="col-md-6 pr-md-0">\
                                    <label for="round">รอบที่</label>\
                                    <input type="text" class="form-control form-control-sm" name="round" id="round" value="'+(round == `null` ? '' : round)+'" > \
                                </div>\
                            </div>\
                            <span style="color:red;">*หากต้องการเปลี่ยน (Order เชือด) หรือเปลี่ยนจำนวนตัวให้ลบ OV เพื่อเคลียร์ข้อมูลแล้วสร้างใหม่ </span>\
                            <div class="text-center" style="padding-top: 10px;">\
                                <button type="submit" name="order_group" value="'+order_group+'" class="btn btn-success mr-2 " onclick="loader2()">ยืนยัน</button>\
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
    $('#dateOV').daterangepicker({
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

    function customerDll(type_req){
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
                    }else if (type_req.value == 2) {
                        if (element.type == 'ลูกค้าซาก') {
                            str = str + '<option value="'+element.customer_name+'">'+element.customer_name+'</option>';
                        }
                        $('#status').prop( "disabled", true );
                    }
                    else{
                        if (element.type != 'สาขา' && element.type != 'ลูกค้าซาก') {
                            str = str + '<option value="'+element.customer_name+'">'+element.customer_name+'</option>';
                        }
                        $('#status').prop( "disabled", true );
                    }
                });
                $('#customer').html(str);
                if (type_req.value == 3) {
                    $('#btnButton').prop('disabled',false);
                    $('#nButton').prop('disabled',false);
                }else{
                    $('#btnButton').prop('disabled',true);
                    $('#nButton').prop('disabled',true);

                    var len = $('div[name="start_[]"]').length;
                    for (let index = 0; index < len; index++) {
                        
                        var mySpan = document.getElementById('mySpan');
                        var deleteEle = document.getElementById('appen[]');
                        mySpan.removeChild(deleteEle);
                    }
                }
                
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert("Status: " + textStatus); alert("Error: " + errorThrown);
            }
        });
    }

    function check_stock(order_ref){
        var option_row = '';
        var option_append = '';
        if ($('#amount').val() == null || $('#amount').val() == '') {
            alert('กรุณากำหนดจำนวนตัว');
        } else {
            $.ajax({
                    type: 'GET',
                    url: '{{ url('check_stock_overnight') }}',
                    data: {},
                    success: function (data) {

                    data.forEach(element => {
                        if (order_ref.value != element.order_number) {
                            option_row = option_row + '<option value="'+element.order_number+'">'+element.order_number+' | เหลือ '+element.side_of_pig+' ตัว</option>';
                        }
                    });

                    data.forEach(element => {
                        if (order_ref.value == element.order_number && element.side_of_pig < $('#amount').val() ) {
                            alert('จำนวนซีกไม่พอ กรุณาแบ่งสร้าง 2 Order');
                            $('#amount').val(0);
                        } 
                    });


                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        alert("Status: " + textStatus); alert("Error: " + errorThrown);
                    }
            });
        }
    }
</script>

<script>
    $(".loader").on('click', function(event){
        if ($('#type_req').val() && $('#amount').val() && $('#marker').val() && $('#provider').val() ) {
            $('.ajax-loader').css("visibility", "visible");
        } 
    });    
    function loader2(){
        $("#EDIT").modal('hide');
        $('.ajax-loader').css("visibility", "visible");
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
    function add($i){
        var s =$i++;
            
        $("#mySpan").append('<div class="row" style="margin:0px;" name="start_[]" id="appen[]">\
                        <div class="col-md-9 pr-md-0">\
                            <label for="order_ref">จาก Order เชือด</label>\
                            <select class="form-control form-control-sm" id="order_ref[]" name="order_ref[]" style=" height: 30px; " onchange="check_stock_bk(this)">\
                                <option></option>\
                                @foreach ($order_ref as $order_)\
                                    <option value="{{ $order_->order_number }}">{{ $order_->order_number }} | เหลือ {{ $order_->side_of_pig }} ตัว</option> \
                                @endforeach\
                            </select>\
                        </div>\
                        <div class="col-md-3 pr-md-0">\
                            <label for="amount">จำนวน(ตัว)</label>\
                            <input type="number" class="form-control form-control-sm" id="amount[]" name="amount[]" placeholder="จำนวน" required>\
                        </div>\
                    </div>');
    }

    function dd(){
        var mySpan = document.getElementById('mySpan');
        var deleteEle = document.getElementById('appen[]');
            mySpan.removeChild(deleteEle);
    }
</script>

@endsection


