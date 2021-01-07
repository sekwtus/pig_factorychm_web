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
    <div class="col-lg-12 grid-margin">
        <div class="card">
            <div class="card-body ">
                <div class="row">
                    <div class="col-4"><h4>รายงานยอดขายประจำวัน</h4></div>
                    <h4 class="col-2">ประจำวันที่ : </h4>
                    <input class="form-control form-control-sm col-2 input-daterange-datepicker" type="text" id="dateFilterCutting" name="dateFilterCutting"/>
                </div>
                    <table class="table table-striped" width="100%" id="orderTable">
                        <thead class="text-center">
                            <tr>
                                <th style="padding: 0px; font-size: 0.7rem;">วันที่</th>
                                <th style="padding: 0px; font-size: 0.7rem;">ชื่อลูกค้า</th>
                                <th style="padding: 0px; font-size: 0.7rem;">ขายอื่นๆ</th>
                                <th style="padding: 0px; font-size: 0.7rem;">ยอดขาย</th>
                                <th style="padding: 0px; font-size: 0.7rem;">ลูกหนี้ยกมา</th>
                                <th style="padding: 0px; font-size: 0.7rem;">รับเงินสด</th>
                                <th style="padding: 0px; font-size: 0.7rem;">ยอดเงินโอน</th>
                                <th style="padding: 0px; font-size: 0.7rem;">คงค้าง</th>
                            </tr>
                        </thead>
                    </table>
                </div>
        </div>
    </div>
</div>
{{ Form::open(['method' => 'post' , 'url' => 'bill_pay']) }}
<div class="modal fade" id="pay" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="detail_pay">
                
        </div>
    </div>
</div>
{{ Form::close() }}
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
            ajax: '{{ url('get_receipt_fully') }}',
            columns: [
                { data: 'date', name: 'date' },
                { data: 'customer_name', name: 'customer_name' },
                { data: 'iv_id', name: 'iv_id' },
                { data: 'iv_id', name: 'iv_id' },
                { data: 'total_price', name: 'total_price' },
                { data: 'cash', name: 'cash' },
                { data: 'transfer', name: 'transfer' },
                { data: 'iv_id', name: 'iv_id' }
            ],
            columnDefs: [
            {
                "targets": 0,
                "className": "text-center",render(data,type,row){
                        if(data == null){
                            return 0;
                        }else{
                            return data;
                        }
                }
            },
            {
                "targets": 1,
                    "className": "text-center",render(data,type,row){
                        if(data == null){
                            return 0;
                        }else{
                            return data;
                        }
                }
            },
            {
                "targets": 2,
                    "className": "text-center",render(data,type,row){
                        if(data == null){
                            return 0;
                        }else{
                            return data;
                        }
                }
            },
            {
                "targets": 3,
                    "className": "text-center",render(data,type,row){
                        if(data == null){
                            return 0;
                        }else{
                            return data;
                        }
                }
            },
            {
                "targets": 4,
                    "className": "text-center",render(data,type,row){
                        if(data == null){
                            return 0;
                        }else{
                            return data;
                        }
                }
            },
            {
                "targets": 5,
                    "className": "text-center",render(data,type,row){
                        if(data == null){
                            return 0;
                        }else{
                            return data;
                        }
                }
            },
            {
                "targets": 6,
                    "className": "text-center",render(data,type,row){
                        if(data == null){
                            return 0;
                        }else{
                            return data;
                        }
                }
            },
            {
                "targets": 7,
                "className": "text-center",render(data,type,row){
                        return  parseFloat(row["total_price"]) - ( parseFloat(row["cash"]) + parseFloat(row["transfer"]) );
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

                var iStartDateCol = 0;

                var daterange = $('#dateFilterCutting').val();
                var dateMin=daterange.substring(6,10) + daterange.substring(3,5)+ daterange.substring(0,2);
                var colDate=data[iStartDateCol].substring(6,12) + data[iStartDateCol].substring(3,5) + data[iStartDateCol].substring(0,2);
                console.log(colDate);
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
            $('#dateFilterCutting').change( function() {
                table.draw();
            } );
        } );

</script>


{{-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script> --}}
<script src="{{ asset('https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js') }}"></script>



{{-- datepicker --}}
{{-- <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script> --}}
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
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
    var customer = '';
    function addrow($i){
        // alert(customer);
        var s = $i++;
        $('#addrow').append('<div class="col-md-6 pr-md-0" id="appen[]">\
                            <label><b>เลข Order</b></label>\
                            <select class="form-control form-control-sm" name="order[]" id="">\
                                @foreach ($order as $oder_out2)\
                                        <option value="{{$oder_out2->ivm_id}}">{{$oder_out2->ivm_id}}</option> \
                                @endforeach\
                            </select>\
                        </div>');
    }

    function dd(){
        var mySpan = document.getElementById('addrow');
        var deleteEle = document.getElementById('appen[]');
            mySpan.removeChild(deleteEle);
    }

    // function add_select($id_c){
    //     // alert($id);
    //     customer = $id_c ;
    //     row = '';
    //     $('#select').empty();
    //     row = "<div class='col-md-6 pr-md-0'>\
    //                         <label><b>เลข Order</b></label>\
    //                         <select class='form-control form-control-sm' name='order[]' >\
    //                             @foreach ($order as $oder_out)\
    //                                 @if ($oder_out->customer_id == "+customer+")\
    //                                     <option value='{{$oder_out->order_number}}'>{{$oder_out->order_number}}</option>\
    //                                 @endif\
    //                             @endforeach\
    //                         </select>\
    //                     </div>";
    //                     console.log(row);
    //     $('#select').html(row);
        
    // }

    function goto_print(id){
        var r = confirm("ถ้ากดพิมพ์แล้วไม่สามารถแก้ไข้ได ต้องการพิมพ์หรือไม่!");
        if(r == true){
            window.open("{{ url('bill_detail_sum_p') }}/"+id, '_blank');
            // alert(id);
        }
    }

    function pay_(ivm,total,pay){
        // alert(pay);
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

</script>
    

@endsection


