@extends('layouts.master')
@section('style')

<link rel="stylesheet" href="{{ asset('/assets/css/datatables/jquery.dataTables.min.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ url('https://cdn.datatables.net/1.10.18/css/dataTables.semanticui.min.css') }}" type="text/css" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link rel="stylesheet" href="{{ asset('/assets/css/scrollbar.css') }}" type="text/css" />

<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
<style>
        .switch {
          position: relative;
          display: inline-block;
          width: 60px;
          height: 34px;
        }
        
        .switch input { 
          opacity: 0;
          width: 0;
          height: 0;
        }
        
        .slider {
          position: absolute;
          cursor: pointer;
          top: 0;
          left: 0;
          right: 0;
          bottom: 0;
          background-color: #ccc;
          -webkit-transition: .4s;
          transition: .4s;
        }
        
        .slider:before {
          position: absolute;
          content: "";
          height: 26px;
          width: 26px;
          left: 4px;
          bottom: 4px;
          background-color: white;
          -webkit-transition: .4s;
          transition: .4s;
        }
        
        input:checked + .slider {
          background-color: #2196F3;
        }
        
        input:focus + .slider {
          box-shadow: 0 0 1px #2196F3;
        }
        
        input:checked + .slider:before {
          -webkit-transform: translateX(26px);
          -ms-transform: translateX(26px);
          transform: translateX(26px);
        }
        
        /* Rounded sliders */
        .slider.round {
          border-radius: 34px;
        }
        
        .slider.round:before {
          border-radius: 50%;
        }
</style>  
{{-- toggle switch --}}
@endsection
@section('main')

<div class="row ">
    <div class="col-lg-6 grid-margin">
    <div class="card">
    <div class="card-body ">
            <div class="row">
                <div class="col-6"><h4>รายงานแผนการทำงานประจำวันที่</h4></div>
                <input class="form-control form-control-sm col-4 input-daterange-datepicker" type="text" id="daterange" name="daterange" style="padding: 0px; height: 30px;"/>
            </div>
            <div class="row">
                <div class="col-6"><h4>แผนก</h4></div>
                <select class="form-control form-control-sm col-4" id="department" name="department" style=" height: 30px; ">
                    @foreach ($department as $dpmt)
                        <option value="{{ $dpmt->id }}">{{ $dpmt->description }}</option>
                    @endforeach
                </select>
            </div>
                <hr>

                <table class="table table-striped table-bordered nowrap" width="100%" id="orderTable">
                <thead class="text-center">
                    <tr>
                    <th style="padding: 0px;max-width:12%;">เลขที่ Order</th>
                    <th style="padding: 0px;max-width:12%;">ลูกค้า</th>
                    <th style="padding: 0px;max-width:12%;">เวลาเข้า</th>
                    <th style="padding: 0px;max-width:10%;">จำนวนสุกร</th>
                    <th style="padding: 0px;max-width:10%;">ช่วงน้ำหน้ก</th>
                    <th style="padding: 0px;max-width:12%;">สถานะ</th>
                    <th style="padding: 0px;max-width:12%;">หมายเหตุ</th>
                    <th style="text-align:center; padding: 0px;max-width:20%;"> ดำเนินการ </th>
                    </tr>
                </thead>
                </table>
    </div>
    </div>
    </div>
{{--  --------------------------------------------------------------------------------------------------------------------------------  --}}
    <div class="col-lg-6 grid-margin">
    <div class="card">
    <div class="card-body ">
        
            <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;">
                <h3 style="height: 25px;margin-bottom: 0px;padding-bottom: 35px;" id="switch_button" >ข้อมูลรายการ Order &nbsp;&nbsp;&nbsp;&nbsp;
                </h3>
               
            </div>
            <div id="show_order_detail"></div>
            <div id="show_order_tabel"></div>
    </div>
    </div>
    </div>
</div>

@endsection

@section('script')

{{-- yajra datatables --}}
<script>
    
        var table = $('#orderTable').DataTable({
            lengthMenu: [[20, 50, 100, -1], [20, 50, 100, "All"]],
            "scrollX": false,
            orderCellsTop: true,
            fixedHeader: true,
            rowReorder: true,
            // processing: true,
            // serverSide: true,
            ajax: '{{ url('order/get_ajax') }}',
            columns: [
                { data: 'order_number', name: 'order_number' },
                { data: 'id_user_customer', name: 'id_user_customer' },
                { data: 'date', name: 'date' },
                { data: 'total_pig', name: 'total_pig' },
                { data: 'weight_range', name: 'weight_range' },
                { data: 'status', name: 'status' },
                { data: 'note', name: 'note' },
                { data: 'id', name: 'id' },
            ],
            columnDefs: [
            {
                "targets": 0,
                // ,render(data,type,row){   //checkbox
                //     var sign = "'";
                //     return ' <div class="form-check form-check-flat">\
                //                 <label class="form-check-label">\
                //                 <input type="checkbox" class="form-check-input" onclick="reOrder('+sign+data+sign+')" value"'+data+'""> '+data+' <i class="input-helper"></i></label>\
                //             </div>';
                // },
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
                "targets": 7,render(data,type,row){
                    var sign = "'";
                    var order_number = row['order_number'];
                    var total_pig = row['total_pig'];
                    return '<button style="padding: 7px;" type="button" id="btn_action'+order_number+'" class="btn btn-success "\
                    onclick="startOrder('+sign+order_number+sign+','+sign+total_pig+sign+')"><i class="fa fa-hand-o-up"></i> ข้อมูลรายการ Order</button>';
                }
            },
            ],
            "order": [],
        });

</script>

<script>
  function startOrder(order_number,total_pig){
        var getRecord = $.ajax({
            type: 'GET',
            url: '{{ url('lot/get_ajax') }}',
            data: {order_number:order_number,total_pig:total_pig},
            success: function (data) {

                $('button').removeClass('btn-danger');
                $('#btn_action'+order_number).addClass('btn-danger');
                
                var sign = "'";
                var checked = "";
                var lot_number = data[0].lot_number;
                if (lot_number != null && lot_number != "") {
                    checked = "checked";
                }else{
                    lot_number = "---";
                }
                $('#switch_button').html('ข้อมูลรายการ Order &nbsp;&nbsp;&nbsp;&nbsp;\
                    <label class="switch">\
                        <input type="checkbox" '+checked+' onclick="toggle_stop_start('+sign+order_number+sign+','+sign+total_pig+sign+')">\
                        <span class="slider round"></span>\
                    </label>');
                
                $('#show_order_detail').html('<div class="forms-sample" style="padding-right: 20px;">\
                        <div class="row" style="margin-bottom: 10px;">\
                            <div class="col-md-4 pr-md-0">\
                                <label for="orderNo">เลขที่ order : <b>'+data[0].order_number+'</b></label></div>\
                            <div class="col-md-4 pr-md-0">\
                                <label for="orderDate">order วันที่ : <b>'+data[0].date+'</b></label></div>\
                            <div class="col-md-4 pr-md-0">\
                                <label for="amount">จำนวน : <b>'+data[0].total_pig+'</b></label></div>\
                        </div>\
                        <div class="row" style="margin-bottom: 10px;">\
                            <div class="col-md-4 pr-md-0">\
                                <label for="weight_range">ช่วงน้ำหนัก : <b>'+data[0].weight_range+'</b></label></div>\
                            <div class="col-md-4 pr-md-0">\
                                <label for="type_req">ประเภท :  <b>'+data[0].type_request+'</b></label></div>\
                            <div class="col-md-4 pr-md-0">\
                                <label for="note">หมายเหตุ : <b>'+data[0].note+'</b></label></div>\
                        </div>\
                    </div><hr>');

                
                var table = $.ajax({
                    type: 'GET',
                    url: '{{ url('weighing/get_ajax') }}',
                    data: {lot_number:lot_number},
                    success: function (data) {
                        var record = '';
                        for (let index = 0; index < data.length; index++) {
                                record = record + '<tr><td>'+(index+1)+'</td>\
                                <td>'+data[index].sku_code+'</td>\
                                <td>'+data[index].sku_weight+'</td>\
                                <td>'+data[index].sku_unit+'</td>\
                                <td>'+data[index].weighing_place+'</td>\
                                <td>'+data[index].scale_number+'</td>\</tr>'
                        }
                        
                        $('#show_order_tabel').html('<div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;">\
                        <h3 style="height: 25px;margin-bottom: 0px;padding-bottom: 35px;"> \
                        <button type="button" onclick="startOrder('+sign+order_number+sign+','+sign+total_pig+sign+')" style="margin-right: 25px;" class="btn btn-icons btn-rounded btn-success">\
                        <i style="color:black;" class="fa fa-refresh"></i></button>รายการน้ำหนัก Lot : \
                        <label style="color:black;"><b id="show_lot">'+lot_number+'</b></h3></label></div>\
                        <div class="scrollbar scrollbar-danger">\
                            <div class="force-overflow">\
                                <table class="table table-striped table-bordered nowrap" width="100%" id="order_info">\
                                        <thead class="text-center">\
                                        <tr>\
                                            <th style="padding: 0px;">No.</th>\
                                            <th style="padding: 0px;">order อ้างอิง</th>\
                                            <th style="padding: 0px;">เลข Lot</th>\
                                            <th style="padding: 0px;">จำนวน</th>\
                                            <th style="padding: 0px;">วันที่สร้าง Lot</th>\
                                            <th style="padding: 0px;">สถานะ</th>\
                                        </tr>\
                                        </thead>\
                                        <tbody>'+record+'</tbody>\
                                    </table>\
                        </div></div>');
                    },
                }); 

                //    setInterval( function () {
                //         table.ajax.reload();
                //    }, 5000 );  



            },
        });
    };

    function getWeighingData(lot_number){
        var record = $.ajax({
                type: 'GET',
                dataType: 'JSON',
                url: '{{ url('weighing/get_ajax') }}',
                data: {lot_number:lot_number},
                success: function (data) {
                  
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("Status: " + textStatus); alert("Error: " + errorThrown);
                }
            });
        return record;
    }

    function toggle_stop_start(order_number,total_pig){
        var getRecord = $.ajax({
                type: 'GET',
                url: '{{ url('start_stop/create_lot') }}',
                data: {order_number:order_number,total_pig:total_pig},
                success: function (data) {
                    $('#show_lot').html(data[0].LOT_NUMBER);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("Status: " + textStatus); alert("Error: " + errorThrown);
                }
            });
    }

    $(document).ready(function(){
            var id_ref_order = "{{ $id_ref_order }}";
            var order_plan_amount = "{{ $order_plan_amount }}";
            startOrder(id_ref_order,order_plan_amount);
    });

    // var table = $('#order_info').DataTable();

    // setInterval( function () {
    //     table.ajax.reload();
    // }, 5000 );

</script>

<script>
    $("#submit").on('click', function() {
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
        
        
        if (orderNo != '' && datepicker != '' && amount != '' && weight_range != '' && customer != '' && provider != '') {   
            $.ajax({
                type: 'GET',
                url: '{{ url('create_order') }}',
                data: {orderNo:orderNo,datepicker:datepicker,amount:amount,
                    weight_range:weight_range,note:note,customer:customer,
                    sender:sender,recieve:recieve,type_req:type_req},
                success: function (msg) {
                    alert(msg);
                    location.reload();
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("Status: " + textStatus); alert("Error: " + errorThrown);
                }
            });
        }
    });
</script>


{{-- datepicker --}}
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
    $('#daterange,#daterange2').daterangepicker({
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


