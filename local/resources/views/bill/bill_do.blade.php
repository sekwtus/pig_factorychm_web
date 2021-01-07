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
                {{ Form::open(['method' => 'post' , 'url' => '/create_bill']) }}
                    <div class="forms-sample form-control" style="height: auto;padding-right: 20px;">
                    <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;">สร้างใบส่งของ</div>
                    <div class="row" style="margin-bottom: 10px;">
                        {{-- <div class="col-md-4 pr-md-0">
                            <label for="orderDate">เลขบิล</label>
                            <input class="form-control form-control-sm"  id="bill_number" type="text" name="bill_number" value="" required>
                        </div> --}}
                        <div class="col-md-4 pr-md-0">
                            <label for="orderDate">วันที่</label>
                            <input class="form-control form-control-sm" placeholder="วว/ดด/ปปปป" id="dateTransport" type="text" name="date" value="" required readonly>
                        </div> 
                        <div class="col-md-4 pr-md-0">
                            <label for="orderDate">กำหนดชำระ</label>
                            <input class="form-control form-control-sm" placeholder="วว/ดด/ปปปป" id="date_payment" type="text" name="date_payment" value="" required readonly>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-md-6 pr-md-0">
                            <label><b>ลูกค้า</b></label>
                            <select class="form-control form-control-sm js-example-basic-single" name="customer" id="" onchange="get_order(this.value)" style="border-color: #ff6258;">
                                <option value=""></option> 
                                @foreach ($customer as $customer)
                                    <option value="{{$customer->id}}">{{$customer->customer_name}}</option> 
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-md-6 pr-md-0">
                            <label><b>เลข Order</b></label>
                            <select class="form-control form-control-sm" name="order[]" id="order">
                                {{-- @foreach ($oder as $oder_out)
                                   <option value="{{$oder_out->order_number}}">{{$oder_out->order_number}}</option> 
                                @endforeach --}}
                            </select>
                        </div>
                    </div>
                    <span id="addrow"></span>
                    <br>
                    {{-- <div class="row" style="margin-bottom: 10px;">
                        <div class="col-md-2 pr-md-0">
                            <a class="btn btn-primary" style="margin-bottom: 10px;" onclick="addrow(1)">
                                <i class="mdi mdi-plus"></i>
                            </a>
                        </div>
                        <div class="col-md-3 pr-md-0">
                            <a class="btn btn-danger text-left" style="margin-bottom: 10px;" onClick="JavaScript:dd();">
                                <i class="mdi mdi-window-minimize"></i>
                            </a>
                        </div>
                    </div> --}}

                    <div class="row" style="padding-top: 10px;">
                        <div class="col-md-12 pr-md-0 text-center">
                            <button type="submit" class="btn btn-success mr-2" >ยืนยัน</button>
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
            </div>
        </div>
    </div>

    <div class="col-lg-7 grid-margin">
        <div class="card">
            <div class="card-body ">
                <div class="row">
                    <div class="col-4"><h4>รายการใบส่งของ</h4></div>
                    <h4 class="col-2">ประจำวันที่ : </h4>
                    <input class="form-control form-control-sm col-2 input-daterange-datepicker" type="text" id="dateFilterCutting" name="dateFilterCutting"/>
                </div>
                    <table class="table" width="100%" id="orderTable">
                        <thead class="text-center">
                            <tr>
                                <th style="padding: 0px; font-size: 0.7rem;">เลขที่ใบส่งของ</th>
                                <th style="padding: 0px; font-size: 0.7rem;">เลขสินค้า</th>
                                <th style="padding: 0px; font-size: 0.7rem;">รหัสลูกค้า</th>
                                <th style="padding: 0px; font-size: 0.7rem;">ชื่อลูกค้า</th>
                                <th style="padding: 0px; font-size: 0.7rem;">วันที่</th>
                                <th style="padding: 0px; font-size: 0.7rem;">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
        </div>
    </div>
</div>

{{-- edit order --}}
 {{ Form::open(['method' => 'post' , 'url' => 'bill_pay']) }}
            <div class="modal fade" id="pay" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content" id="detail_pay">
                            
                    </div>
                </div>
            </div>
{{ Form::close() }}

{{--<div class="modal fade" id="Alert" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
</div> --}}

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
            "scrollX": true,
            orderCellsTop: true,
            fixedHeader: true,
            // dom: 'Bfrtip',
            // buttons: [
            //     'print'
            // ],
            // processing: true,
            // serverSide: true,
            ajax: '{{ url('get_ajax_bill') }}',
            columns: [
                { data: 'ivm_id', name: 'ivm_id' },
                { data: 'ref', name: 'ref' },
                { data: 'customer_id', name: 'customer_id' },
                { data: 'customer_name', name: 'customer_name' },
                { data: 'date_bill', name: 'date_bill' },
                { data: 'ivm_id', name: 'ivm_id' }
            ],
            columnDefs: [
            {
                "targets": 0,
                "className": "text-center",
                // render(data,type,row){
                //     return '<a target="blank_" href="{{ url('bill_detail') }}/'+data+'">'+data+'</a>';
                // }
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
                    "className": "text-center",render(data,type,row){
                        // return row["pig_life"];
                        r = ''
                        s = "'";
                        // r = r+'<a class="btn btn-success" style="margin-bottom: 10px;" title="พิมพ์บิลรวม" onclick="goto_print('+s+data+s+',0,1)" >\
                        //                                     <i class="mdi mdi-printer"></i>\
                        //                                 </a> ';
                        if(row["type"] == 'p'){
                            r = r+'<a class="btn btn-primary" style="margin-bottom: 10px;" title="พิมพ์ใบส่งสินค้าหมูเป็น" onclick="goto_print('+s+data+s+',1,'+s+'p'+s+')" >\
                                                            <i class="mdi mdi-printer"></i>\
                                                        </a> ';
                        }
                        // if(row["c"] == 1){
                        //     r = r+'<a class="btn btn-secondary" style="margin-bottom: 10px;" onclick="goto_print('+s+data+s+',2,1)" title="พิมพ์บิลค่าซาก">\
                        //                                     <i class="mdi mdi-printer"></i>\
                        //                                 </a> ';
                        // }
                        if(row["type"] == 's'){
                            // r = r+'<a class="btn btn-warning" style="margin-bottom: 10px;" onclick="goto_print('+s+data+s+',3,1)" title="พิมพ์ใบส่งสินค้าค่าเชือด">\
                            //                                 <i class="mdi mdi-printer"></i>\
                            //                             </a> ';
                            r = r+'<a class="btn btn-warning" style="margin-bottom: 10px;" onclick="goto_print('+s+data+s+',1,'+s+'s'+s+')" title="พิมพ์ใบส่งสินค้าค่าเชือด">\
                                                            <i class="mdi mdi-printer"></i>\
                                                        </a> ';
                        }
                        if(row["type"] == 't'){
                            // r = r+'<a class="btn btn-info" style="margin-bottom: 10px;" onclick="goto_print('+s+data+s+',4,1)" title="พิมพ์ใบส่งสินค้าตัดแต่ง">\
                            //                                 <i class="mdi mdi-printer"></i>\
                            //                             </a>';
                            r = r+'<a class="btn btn-info" style="margin-bottom: 10px;" onclick="goto_print('+s+data+s+',1,'+s+'t'+s+')" title="พิมพ์ใบส่งสินค้าตัดแต่ง">\
                                                            <i class="mdi mdi-printer"></i>\
                                                        </a>';
                        }
                        
                        return r ;
                }
            },
            ],
            "order": [],
        });

        // $.fn.dataTable.ext.search.push(
        //     function( settings, data, dataIndex ) {

        //         // console.log(settings.nTable.id);
        //         if ( settings.nTable.id !== 'orderTable' ) {
        //             return true;
        //         }

        //         var iStartDateCol = 6;

        //         var daterange = $('#dateFilterCutting').val();
        //         var dateMin=daterange.substring(6,10) + daterange.substring(3,5)+ daterange.substring(0,2);
        //         var colDate=data[iStartDateCol].substring(6,12) + data[iStartDateCol].substring(3,5) + data[iStartDateCol].substring(0,2);
        //         console.log(colDate);
        //         var min = parseInt( dateMin );
        //         var Date_data = parseFloat( colDate ) || 0;

        //         if ( ( isNaN( min ) ) || ( min == Date_data) )
        //         {
        //             return true;
        //         }
        //         return false;
        //     }
        // );

        // $(document).ready(function() {
        //     $('#dateFilterCutting').change( function() {
        //         table.draw();
        //     } );
        // } );

</script>


{{-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script> --}}
<script src="{{ asset('https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js') }}"></script>



{{-- datepicker --}}
{{-- <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script> --}}
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="{{ asset('assets/js/shared/select2.js')}}"></script>
{{-- <link rel="stylesheet" href="{{ asset('assets/js/shared/select2.js')}}"> --}}
<script>
    $('#dateCutting').daterangepicker({
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
    $('#dateFilterCutting').daterangepicker({
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
    $('#date_payment').daterangepicker({
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
                // console.log(type_req.value);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert("Status: " + textStatus); alert("Error: " + errorThrown);
            }
        });
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

<script>
    function loader2(){
        $("#EDIT").modal('hide');
        $('.ajax-loader').css("visibility", "visible");
    }
</script>

<script language="javascript" type="text/javascript">
    function addrow($i){
        var s =$i++;
        $('#addrow').append('<div class="col-md-6 pr-md-0" id="appen[]">\
                            <label><b>เลข Order</b></label>\
                            <select class="form-control form-control-sm" name="order[]" id="">\
                                @foreach ($oder as $oder_out)\
                                   <option value="{{$oder_out->order_number}}">{{$oder_out->order_number}}</option> \
                                @endforeach\
                            </select>\
                        </div>');
    }

    function dd(){
        var mySpan = document.getElementById('addrow');
        var deleteEle = document.getElementById('appen[]');
            mySpan.removeChild(deleteEle);
    }

    function goto_print(id,type,bill){
        // alert(bill);
        // var r = confirm("ถ้ากดพิมพ์แล้วไม่สามารถแก้ไข้ได ต้องการพิมพ์หรือไม่!");
        // if(r == true){
            if(type == 0){
                window.open("{{ url('bill_detail') }}/"+id+"/"+bill, '_blank');
            }
            if(type == 1){
                window.open("{{ url('bill_detail_p') }}/"+id+"/"+bill, '_blank');
            }
            if(type == 2){
                window.open("{{ url('bill_detail_c') }}/"+id+"/"+bill, '_blank');
            }
            if(type == 3){
                window.open("{{ url('bill_detail_s') }}/"+id+"/"+bill, '_blank');
            }
            if(type == 4){
                window.open("{{ url('bill_detail_t') }}/"+id+"/"+bill, '_blank');
            }
        // }
    }

    function get_order(id){
        // alert(id);
        // $("#order").append('<option value=1>My option</option><option value=1>My option2</option>');
        // $("#order").append('<option value=1>My option2</option>');
        date = $("#dateTransport").val();
        $('#order option').remove();
        if (id != '' ) {   
            $.ajax({
                type: 'GET',
                beforeSend: function(){
                    $('.ajax-loader').css("visibility", "visible");
                },
                url: '{{ url('get_order_bill') }}',
                data: {id:id,date:date},
                success: function (data) {
                    option = "";
                    data.forEach(element => {
                        option = option + '<option value="'+element.order_number+'">'+element.order_number+'</option> ';
                    });
                    $("#order").append(option);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("Status: " + textStatus); alert("Error: " + errorThrown);
                },
                complete: function(){
                    $('.ajax-loader').css("visibility", "hidden");
                }
            });
        }
    }

    function pay_(ivm,total,pay){
        row = "";
        row = row+'<div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;">จ่ายเงิน '+ivm+'</div>\
                            <div class="row text-center">\
                                <div class="col-md-12 ">จำนวนเงินทั้งหมด : '+total+' บาท</div>\
                                <div class="col-md-12 ">จำนวนเงินที่ชำระไปแล้ว : '+pay+' บาท</div>\
                                <div class="col-md-12 ">จำนวนเงินที่ค้างชำระ : '+(total-pay)+' บาท</div>\
                                <div class="col-md-4 "><label for="orderDate">จ่าย</label></div>\
                                <br>\
                                <div class="col-md-4 ">\
                                    <input class="form-control form-control-sm" type="number" name="pay" value="0" required >\
                                    <input class="form-control form-control-sm" type="text" name="ivm" value="'+ivm+'" hidden >\
                                </div>\
                                <div class="col-md-4 ">บาท</div>\
                                <div class="col-md-12 "><button class="btn btn-primary" style="margin-bottom: 10px;"type="submit" >ยืนยัน</button></div>\
                            </div> ';

        $('#detail_pay').html(row);
    }

    function goto_print_r(id){
        // var r = confirm("ถ้ากดพิมพ์แล้วไม่สามารถแก้ไข้ได ต้องการพิมพ์หรือไม่!");
        // if(r == true){
            window.open("{{ url('bill_detail_sum_p') }}/"+id, '_blank');
            // alert(id);
        // }
    }

    function delect(ivm){
        r = confirm("ต้องการลบ : "+ivm+" หรือไม่?");
        if(r == true){
            $.ajax({
                type: 'GET',
                beforeSend: function(){
                    $('.ajax-loader').css("visibility", "visible");
                },
                url: '{{ url('bill_cancel') }}',
                data: {ivm:ivm},
                success: function (data) {
                    alert(data);
                    location.reload();
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("Status: " + textStatus); alert("Error: " + errorThrown);
                },
                complete: function(){
                    $('.ajax-loader').css("visibility", "hidden");
                }
            });
        }
    }

</script>


@endsection


