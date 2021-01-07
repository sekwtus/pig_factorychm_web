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
                {{ Form::open(['method' => 'post' , 'url' => '/order_transport/save']) }}
                    <div class="forms-sample form-control" style="height: auto;padding-right: 20px;">
                    <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;">สร้างรายการจัดส่ง</div>
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-md-4 pr-md-0">
                            <label for="type_req">ประเภท</label>
                            <select class="form-control form-control-sm" id="type_req" onchange="customerDll(this);" name="type_req" style=" height: 30px; " required>
                                    <option></option>
                                    <option value="3">หมูสาขา</option>
                                    <option value="2">หมูลูกค้า</option>
                            </select>
                        </div>
                        <div class="col-md-4 pr-md-0">
                            <label for="orderDate">วันที่จัดส่ง</label>
                            <input class="form-control form-control-sm" placeholder="วว/ดด/ปปปป" id="dateTransport" type="text" name="dateTransport" value="" required>
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
<hr>
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-md-6 pr-md-0">
                            <label for="cutting_order">Order ตัดแต่ง</label>
                            <select class="form-control form-control-sm" id="cutting_order" type="text" name="cutting_order[]" style=" height: 30px; " >
                                <option></option>
                                @foreach ($order_cutting_ref as $cutting_ref)
                                    <option value="{{ $cutting_ref->order_number }}">{{ $cutting_ref->order_number }} | {{ $cutting_ref->id_user_customer }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 pr-md-0" >
                            <label for="offal_order">Order เครื่องใน</label>
                            <select class="form-control form-control-sm" id="offal_order" type="text" name="offal_order[]" style=" height: 30px; " >
                                <option></option>
                                @foreach ($order_offal_ref as $offal_ref)
                                    <option value="{{ $offal_ref->order_number }}">{{ $offal_ref->order_number }} | {{ $offal_ref->id_user_customer }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <span id="mySpan"></span>
                    
                    <div class="row text-left">
                        <div class="col-md-12 pr-md-0" >
                            <input name="btnButton" class="btn btn-primary mr-2" id="btnButton" type="button" value="+" onClick="add(1);">
                            <input name="nButton" class="btn btn-danger mr-2" id="nButton" type="button" value="-" onClick="JavaScript:dd();">
                        </div> 
                    </div> 
<hr>
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-md-5 pr-md-0">
                            <label for="provider">ผู้จัดทำ</label>
                            <input type="text" class="form-control form-control-sm" id="provider" name="provider" placeholder="ผู้จัดทำ" required>
                        </div>
                        <div class="col-md-7 pr-md-0">
                            <label for="note">หมายเหตุ</label>
                            <textarea class="form-control form-control-sm" id="note" name="note" rows="3" placeholder="หมายเหตุ"></textarea> 
                        </div>
                    </div>

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
            <div class="card-body "  style="padding: 10px;">
                <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;padding-bottom: 0px;padding-top: 5px;">
                    <div class="row">
                        <h3 class="col-6" style="height: 25px;margin-bottom: 0px;padding-bottom: 35px; color:black;" id="switch_button" ><b>Order จัดส่ง</b></h3>
                        <h4 class="col-3">ประจำวันที่ : </h4>
                        <input class="form-control form-control-sm col-2 input-daterange-datepicker" type="text" id="daterangeLot" name="daterangeLot" style="padding: 5px; height: 30px;"/>
                    </div>
                </div>
                <table class="table table-striped table-bordered nowrap table-hover table-responsive"  width="100%" id="orderTableLot">
                    <thead class="text-center">
                        <tr>
                        <th style="padding: 0px;max-width:12%; font-size: 0.7rem;">เลขที่ Order จัดส่ง</th>
                        <th style="padding: 0px;max-width:12%; font-size: 0.7rem;">ลูกค้า</th>
                        <th style="padding: 0px;max-width:12%; font-size: 0.7rem;">รอบที่</th>
                        <th style="padding: 0px;max-width:12%; font-size: 0.7rem;">รหัสย่อ</th>
                        <th style="padding: 0px;max-width:12%; font-size: 0.7rem;">วันที่จัดส่ง</th>
                        <th style="padding: 0px;max-width:10%; font-size: 0.7rem;">Order ตัดแต่ง</th>
                        <th style="padding: 0px;max-width:10%; font-size: 0.7rem;">Order เครื่องใน</th>
                        <th style="padding: 0px;max-width:12%; font-size: 0.7rem;">หมายเหตุ</th>
                        <th style="text-align:center; padding: 0px;max-width:20%; font-size: 0.7rem;"> ดำเนินการ </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>>
</div>

{{-- edit order --}}
{{ Form::open(['method' => 'post' , 'url' => 'order/tr_edit']) }}
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
        var table2 = $('#orderTableLot').DataTable({
            destroy: true,
            dom: 'Bfrtip',
            buttons: [
                // 'print'
            ],
            lengthMenu: [[20, 50, 100, -1], [20, 50, 100, "All"]],
            "scrollX": false,
            orderCellsTop: true,
            fixedHeader: true,
            rowReorder: true,
            // processing: true,
            // serverSide: true,
            ajax: {
                    url: '{{ url('order_transport/get_ajax_inLot2') }}',
                    data: {},
                },
            columns: [
                { data: 'order_number', name: 'order_number' },
                { data: 'id_user_customer', name: 'id_user_customer' },
                { data: 'round', name: 'round' },
                { data: 'marker', name: 'marker' },
                { data: 'date_picker', name: 'date_picker' },
                { data: 'order_cutting_number', name: 'order_cutting_number' },
                { data: 'order_offal_number', name: 'order_offal_number' },
                { data: 'note', name: 'note' },
                { data: 'order_number', name: 'order_number' },
            ],
            columnDefs: [
                {
                    "targets": 0,
                    "className": "text-center",
                    render(data,type,row){
                        return '<a target="blank_" href="../summary_weighing/'+data+'">'+data+'</a>';
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
                },
                {
                    "targets": 8,render(data,type,row){
                        var sign = "'";
                        var order_number = row['order_number'];
                        var round = row['round'];
                        var date = row['date_picker'];
                        var note = row['note'];
                        var id_user_customer = row['id_user_customer'];
                        var marker = row['marker'];
                        
                        return '<a target="blank_" href="../report_transport/'+order_number+'"><button title="ใบส่งของ" style="padding: 7px;" type="button" id="btn_action'+order_number+'" class="btn btn-info ">\
                        <i class="fa fa-file" ></i></button></a>\
                        \
                        <button  style="padding: 7px;" type="button" class="btn btn-warning" title="แก้ไข"\
                        onclick="editModal('+sign+order_number+sign+','+sign+date+sign+','+sign+round+sign+','+sign+note+sign+','+sign+id_user_customer+sign+','+sign+marker+sign+')" >\
                        <i class="mdi mdi-pencil"></i></button>\
                        \
                        <button style="padding: 7px;" type="button" id="btn_action'+order_number+'" class="btn btn-danger "\
                        onclick="deleteOrder('+sign+order_number+sign+')"><i class="mdi mdi-delete "></i>\
                        <label id="number'+order_number+'"></label></button>';
                    },
                    "className": "text-center",
                },
            ],
            "order": [],
        });
        $.fn.dataTable.ext.search.push(
            function( settings, data, dataIndex ) {

                // console.log(settings.nTable.id);
                if ( settings.nTable.id !== 'orderTableLot' ) {
                    return true;
                }

                var iStartDateCol = 4;

                var daterange = $('#daterangeLot').val();
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
            $('#daterangeLot').change( function() {
                table2.draw();
            } );
        } );
</script>

<script>
    function deleteOrder(order_number){
        if(confirm('ต้องการลบการจัดส่ง : '+order_number+' ?')){
            $.ajax({
                type: 'GET',
                url: '{{ url('delete_order_tr') }}',
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
    function editModal(order_number,date,round,note,id_user_customer,marker){
        $("#EDIT").modal();

        var str = '<div class="forms-sample form-control" style="height: auto;padding-right: 20px;">\
                <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;">แก้ไข Order <b style="color:black;">'+order_number+'</b></div>\
                <div class="row" style="margin-bottom: 10px;">\
                    <div class="col-md-4 pr-md-0">\
                        <label for="id_user_customer">ลูกค้า / สาขา</label>\
                        <input readonly type="text" class="form-control form-control-sm" name="id_user_customer" id="id_user_customer" value="'+(id_user_customer == 'null' ? '' :id_user_customer )+'" required> \
                        <input hidden type="text" class="form-control form-control-sm" name="marker" id="marker" value="'+(marker == 'null' ? '' :marker )+'" required> \
                    </div>\
                    <div class="col-md-4 pr-md-0">\
                        <label for="dateTransport">ประจำวันที่</label>\
                        <input class="form-control form-control-sm" placeholder="วว/ดด/ปปปป" type="text" id="datepicker2" name="dateTransport" value="'+date+'" required></div>\
                    <div class="col-md-4 pr-md-0">\
                        <label for="round">รอบที่</label>\
                        <input type="text" class="form-control form-control-sm" name="round" id="round" value="'+(round == 'null' ? '' :round )+'" > \
                    </div>\
                </div>\
                <div class="row" style="margin-bottom: 10px;">\
                    <div class="col-md-12 pr-md-0">\
                        <label for="note">หมายเหตุ</label>\
                        <textarea class="form-control form-control-sm" name="note" id="note" rows="3" placeholder="หมายเหตุ" value="'+(note == 'null' ? '' :note )+'"></textarea> </div>\
                    </div>\
                    <span style="color:red;">*หากต้องการเปลี่ยน (Order ตัดแต่ง,Order เครื่องใน) ให้ลบTR เพื่อเคลียร์ข้อมูลแล้วสร้างใหม่ </span>\
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
            
    }
</script>

{{-- datepicker --}}
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
    $('#dateTransport').daterangepicker({
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

    $('#daterangeLot').daterangepicker({
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
                // console.log(type_req.value);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert("Status: " + textStatus); alert("Error: " + errorThrown);
            }
        });
    }
</script>

{{-- append --}}
<script language="javascript" type="text/javascript">
    function add($i){
    var s =$i++;        
        $("#mySpan").append('<div class="row" style="margin-bottom: 10px;" id="appen[]">\
                               <div class="col-md-6 pr-md-0">\
                                    <label for="cutting_order">Order ตัดแต่ง</label>\
                                    <select class="form-control form-control-sm" id="cutting_order" type="text" name="cutting_order[]" style=" height: 30px; " >\
                                        <option></option>\
                                        @foreach ($order_cutting_ref as $cutting_ref)\
                                            <option value="{{ $cutting_ref->order_number }}">{{ $cutting_ref->order_number }} | {{ $cutting_ref->id_user_customer }} </option>\
                                        @endforeach\
                                    </select>\
                                </div>\
                                <div class="col-md-6 pr-md-0" >\
                                    <label for="offal_order">Order เครื่องใน</label>\
                                    <select class="form-control form-control-sm" id="offal_order" type="text" name="offal_order[]" style=" height: 30px; " >\
                                        <option></option>\
                                        @foreach ($order_offal_ref as $offal_ref)\
                                            <option value="{{ $offal_ref->order_number }}">{{ $offal_ref->order_number }} | {{ $offal_ref->id_user_customer }} </option>\
                                        @endforeach\
                                    </select>\
                                </div>\
                            </div>');
        }
        
        function dd(){
        var mySpan = document.getElementById('mySpan');
        var deleteEle = document.getElementById('appen[]');
            mySpan.removeChild(deleteEle);
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
    $(".loader").on('click', function(event){
        if ($('#type_req').val() && $('#customer').val() && $('#marker').val() && $('#provider').val() ) {
            $('.ajax-loader').css("visibility", "visible");
        }
       
    });
</script>
@endsection


