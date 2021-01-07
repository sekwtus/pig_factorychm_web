@extends('layouts.master')
@section('style')

<link rel="stylesheet" href="{{ asset('/assets/css/datatables/jquery.dataTables.min.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ url('https://cdn.datatables.net/1.10.18/css/dataTables.semanticui.min.css') }}" type="text/css" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link rel="stylesheet" href="{{ asset('/assets/css/scrollbar.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ url('https://cdn.datatables.net/buttons/1.6.0/css/buttons.dataTables.min.css') }}" type="text/css" />


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
@if(session()->has('message'))
    <div class="alert alert-danger">
        {{ session()->get('message') }}
    </div>
@endif
<div class="ajax-loader">
    <img src="{{ asset('assets/images/pig_fly.gif')}}" alt="" style="margin-left: 0px;top: 3%;width: 350px; left:37%;" class="img-responsive"  />
</div>

<div class="row ">
    <div class="col-lg-6 grid-margin">
        <div class="card">
            <div class="card-body " style="padding: 10px;">
                <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;padding-bottom: 0px;padding-top: 5px;">
                    <div class="row">
                        <h3 class="col-6" style="height: 25px;margin-bottom: 0px;padding-bottom: 35px; color:black;" id="switch_button" ><b>Order ตัดแต่ง</b></h3>
                        <h4 class="col-3">ประจำวันที่ : </h4>
                        <input class="form-control form-control-sm col-2 input-daterange-datepicker" type="text" id="daterange" name="daterange" style="padding: 5px; height: 30px;"/>
                    </div>
                </div>
                <table class="table table-striped table-bordered nowrap table-hover table-responsive"  width="100%" id="orderTable">
                    <thead class="text-center">
                        <tr>
                        <th style="padding: 0px;max-width:12%; font-size: 0.7rem;">เลขที่ Order ตัดแต่ง</th>
                        <th style="padding: 0px;max-width:12%; font-size: 0.7rem;">ลูกค้า</th>
                        <th style="padding: 0px;max-width:12%; font-size: 0.7rem;">รอบที่</th>
                        <th style="padding: 0px;max-width:12%; font-size: 0.7rem;">รหัสย่อ</th>
                        <th style="padding: 0px;max-width:10%; font-size: 0.7rem;">จำนวน</th>
                        <th style="padding: 0px;max-width:12%; font-size: 0.7rem;">วันที่จัดส่ง</th>
                        <th style="padding: 0px;max-width:12%; font-size: 0.7rem;">สถานะ</th>
                        <th style="padding: 0px;max-width:12%; font-size: 0.7rem;">หมายเหตุ</th>
                        <th style="text-align:center; padding: 0px;max-width:20%; font-size: 0.7rem;"> ดำเนินการ </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
{{--  --------------------------------------------------------------------------------------------------------------------------------  --}}
    <div class="col-lg-6 grid-margin">
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
                        {{-- <th style="padding: 0px;max-width:12%; font-size: 0.7rem;">process No.</th> --}}
                        <th style="padding: 0px;max-width:12%; font-size: 0.7rem;">ลูกค้า</th>
                        <th style="padding: 0px;max-width:12%; font-size: 0.7rem;">รอบที่</th>
                        <th style="padding: 0px;max-width:12%; font-size: 0.7rem;">รหัสย่อ</th>
                        <th style="padding: 0px;max-width:12%; font-size: 0.7rem;">วันที่จัดส่ง</th>
                        <th style="padding: 0px;max-width:10%; font-size: 0.7rem;">จำนวน</th>
                        <th style="padding: 0px;max-width:10%; font-size: 0.7rem;">Order ตัดแต่ง</th>
                        <th style="padding: 0px;max-width:10%; font-size: 0.7rem;">Order เครื่องใน</th>
                        <th style="padding: 0px;max-width:12%; font-size: 0.7rem;">สถานะ</th>
                        <th style="padding: 0px;max-width:12%; font-size: 0.7rem;">หมายเหตุ</th>
                        <th style="text-align:center; padding: 0px;max-width:20%; font-size: 0.7rem;"> ดำเนินการ </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>


{{-- ปรับStock --}}
{{ Form::open(['method' => 'post' , 'url' => '/set_order_transport']) }}
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="width: 120%">
            <div class="forms-sample form-control" style="height: auto;padding-right: 20px;">
                <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;">เลือก Order เครื่องใน</div>
                    <div id="cutting_info">
                    </div>
                <hr>
                <table class="table table-striped table-bordered nowrap table-hover table-responsive" width="100%" id="tableOffal">
                    <thead class="text-center">
                        <tr>
                        <th style="padding: 0px; font-size: 0.7rem;">เลขที่ Order</th>
                        <th style="padding: 0px; font-size: 0.7rem;">สาขา</th>
                        <th style="padding: 0px; font-size: 0.7rem;">รอบที่</th>
                        <th style="padding: 0px; font-size: 0.7rem;">ตัวย่อ</th>
                        <th style="padding: 0px; font-size: 0.7rem;">จำนวน(ตัว)</th>
                        <th style="padding: 0px; font-size: 0.7rem;">ประเภท</th>
                        <th style="padding: 0px; font-size: 0.7rem;">วันที่ชั่งออก</th>
                        <th style="padding: 0px; font-size: 0.7rem;">หมายเหตุ</th>
                        <th style="text-align:center; padding: 0px; font-size: 0.7rem;"> ดำเนินการ </th>
                        </tr>
                    </thead>
                </table>
                <div class="text-center" style="padding-top: 10px;">
                    <button type="button" class="btn btn-danger mr-2" id="no_offal" onclick="not_send_offal()" name="no_offal" >ไม่ส่งเครื่องใน</button>
                    <button disabled type="submit" class="btn btn-success mr-2" id="comfirmAdd" name="stock_name" value="comfirmAdd">ยืนยัน</button>
                </div>
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}


@endsection

@section('script')

<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="{{ asset('https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js') }}"></script>

<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js') }}"></script>


<script>
    $(document).ready(function(){
            tableOrderLot();
    })
</script>

{{-- yajra datatables --}}
<script>
        var department = '{{ $id }}';
        var table = $('#orderTable').DataTable({
            lengthMenu: [[20, 50, 100, -1], [20, 50, 100, "All"]],
            "scrollX": false,
            orderCellsTop: true,
            fixedHeader: true,
            rowReorder: true,
            // processing: true,
            // serverSide: true,
            ajax: {
                    url: '{{ url('order_transport/get_ajax') }}',
                    data: {department:department},
                },
            columns: [
                { data: 'order_number', name: 'order_number' },
                { data: 'id_user_customer', name: 'id_user_customer' },
                { data: 'round', name: 'round' },
                { data: 'marker', name: 'marker' },
                { data: 'total_pig', name: 'total_pig' },
                { data: 'date_transport', name: 'date_transport' },
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
                "targets": 3,render(data,type,row){
                        if (data == '' || data == null) {
                            return '-';
                        }else{
                            return data;
                        }
                    },
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
                    var total_pig = row['total_pig'];
                    var date = row['date'];
                    var date_transport = row['date_transport'];

                        // return '<button style="padding: 5px;" type="button" id="btn_action'+order_number+'" class="btn btn-success \
                        // onclick="setOrder('+sign+order_number+sign+','+sign+total_pig+sign+')"><i class="fa fa-arrow-right" style="font-size: 25px;margin-right: 0px;"></i>\
                        // <label id="number'+order_number+'"></label></button>\
                        return '<button style="padding: 5px;" type="button" class="btn btn-success" title="ปรับ Stock" onclick="sendOrdertoToggle('+sign+order_number+sign+','+sign+date+sign+','+sign+date_transport+sign+')" data-toggle="modal" data-target="#edit" href="#">\
                                <i class="fa fa-arrow-right" style="font-size: 25px;margin-right: 0px;"></i></button>';
                   
                },
                "className": "text-center",
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

                var iStartDateCol = 5;

                var daterange = $('#daterange').val();
                var dateMin=daterange.substring(6,10) + daterange.substring(3,5)+ daterange.substring(0,2);
                var colDate=data[iStartDateCol].substring(6,12) + data[iStartDateCol].substring(3,5) + data[iStartDateCol].substring(0,2);

                var min = parseInt( dateMin );
                var Date_data = parseFloat( colDate ) || 0;

                if ( ( isNaN( min ) ) ||( min == Date_data) )
                {
                    return true;
                }
                return false;
            }
        );

        $(document).ready(function() {
            $('#daterange').change( function() {
                table.draw();
            } );
        } );

</script>

<script>
    function tableOrderLot(){
        var table2 = $('#orderTableLot').DataTable({
            destroy: true,
            dom: 'Bfrtip',
            buttons: [
                'print'
            ],
            lengthMenu: [[20, 50, 100, -1], [20, 50, 100, "All"]],
            "scrollX": false,
            orderCellsTop: true,
            fixedHeader: true,
            rowReorder: true,
            // processing: true,
            // serverSide: true,
            ajax: {
                    url: '{{ url('order_transport/get_ajax_inLot') }}',
                    data: {},
                },
            columns: [
                { data: 'order_number', name: 'order_number' },
                // { data: 'process_number', name: 'process_number' },
                { data: 'id_user_customer', name: 'id_user_customer' },
                { data: 'round', name: 'round' },
                { data: 'marker', name: 'marker' },
                { data: 'date_picker', name: 'date_picker' },
                { data: 'total_pig', name: 'total_pig' },
                { data: 'order_cutting_number', name: 'order_cutting_number' },
                { data: 'order_offal_number', name: 'order_offal_number' },
                { data: 'status', name: 'status' },
                { data: 'note', name: 'note' },
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
                // {
                //     "targets": 4,render(data,type,row){
                //         if (data == '' || data == null) {
                //             return '-';
                //         }else{
                //             return data;
                //         }
                //     },
                //     "className": "text-center",
                // },
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
                        var order_cutting_number = row['order_cutting_number'];
                        var order_offal_number = row['order_offal_number'];

                        return '<a target="blank_" href="../report_transport/'+order_number+'"><button title="ใบส่งของ" style="padding: 5px;" type="button" id="btn_action'+order_number+'" class="btn btn-info ">\
                        <i class="fa fa-file" style="font-size: 25px;margin-right: 0px;"></i></button></a>\
                        <button style="padding: 5px;" type="button" id="btn_action'+order_number+'" class="btn btn-danger "\
                        onclick="ResetOrder('+sign+order_number+sign+','+sign+order_cutting_number+sign+','+sign+order_offal_number+sign+')"><i class="fa fa-arrow-left" style="font-size: 25px;margin-right: 0px;"></i>\
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

    }
</script>

<script>
    var table3 = $('#tableOffal').DataTable({
        "scrollX": false,
        orderCellsTop: true,
        fixedHeader: true,
        dom: 'rtip',
        // buttons: [
        //     'print'
        // ],
        // processing: true,
        // serverSide: true,
        ajax: '{{ url('create_order_offal/ajaxOrderOffal') }}',
        columns: [
            { data: 'order_number', name: 'order_number' },
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

                return '<button style="padding: 7px;" type="button" onclick="CreateTransportOrder('+sign+order_number+sign+')"\
                 class="btn btn-primary" >เลือก</button>';
            }
        },
        ],
        "order": [],
    });

</script>


{{-- setOrder --}}
<script>

    // lock create lot if exist
    $(document).ready(function(){
        var lot = $('#create_lot').html();
        if (lot != 'กรุณาสร้าง LOT') {
            $('#btnCreate_lot').prop("disabled",true);
        }
    })

    function setOrder(order_number,total_pig){
        // var lot = $('#create_lot').html();
        var id = '{{ $id }}';
        // console.log(lot);
        // if (lot == 'กรุณาสร้าง LOT') {
        //     alert('กรุณาสร้าง LOT');
        // }
        // else {
            $('#orderTable,tbody').on('click', 'tr',function(){
                var source = table.row(this);
                //    table2.row.add(source.data()).draw();
                source.remove().draw();
            });

            $.ajax({
                type: 'GET',
                beforeSend: function(){
                    $('.ajax-loader').css("visibility", "visible");
                },
                url: '{{ url('addOrder_to_lot') }}',
                data: {order_number:order_number,total_pig:total_pig,id:id},
                success: function (data) {
                    console.log(data);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("Status: " + textStatus); alert("Error: " + errorThrown);
                },
                complete: function(){
                    $('.ajax-loader').css("visibility", "hidden");
                    tableOrderLot();
                }
            });
        // }
    };

    function ResetOrder(order_number,order_cutting_number,order_offal_number){
        if (confirm('ยืนยันการยกเลิก'+order_number)) {
            $('#orderTableLot,tbody').on('click', 'tr',function(){
                var source = table.row(this);
                //    table2.row.add(source.data()).draw();
                source.remove().draw();
            });
            
            $.ajax({
                type: 'GET',
                beforeSend: function(){
                    $('.ajax-loader').css("visibility", "visible");
                },
                url: '{{ url('order_transport/delete_transportOrder_from_lot') }}',
                data: {order_number:order_number,order_cutting_number:order_cutting_number,order_offal_number:order_offal_number},
                success: function (data) {
                    console.log(data);
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


    function sendOrdertoToggle(order_number,date,date_transport){
      $('#cutting_info').html('<div class="row">\
                                    <div class="col-md-5 pr-md-0">\
                                        <label for="order_cutting_number">เลขที่ Order ตัดแต่ง</label>\
                                        <input type="text" class="form-control form-control-sm" id="order_cutting_number" name="order_cutting_number" value="'+order_number+'" readonly>\
                                    </div>\
                                    <div class="col-md-5 pr-md-0">\
                                        <label for="order_cutting_date">วันที่ตัดแต่ง</label>\
                                        <input type="text" class="form-control form-control-sm" id="order_cutting_date" name="order_cutting_date" value="'+date+'" readonly>\
                                    </div>\
                                    <div class="col-md-5 pr-md-0">\
                                        <label for="dateTransport">วันจัดส่ง</label>\
                                        <input type="text" class="form-control form-control-sm" type="text" id="date_transport" name="date_transport" value="'+date_transport+'" readonly/>\
                                    </div>\
                                    <div id="selectedOffal"></div>\
                                </div>');
    $("#comfirmAdd").prop('disabled', true);                      
    }
    function CreateTransportOrder(order_number){
        $('#selectedOffal').html('<div class="col-md-12 pr-md-0">\
                                    <label for="order_offal_number">order เครื่องใน</label>\
                                    <input type="text" class="form-control form-control-sm" type="text" id="order_offal_number" name="order_offal_number" value="'+order_number+'" readonly style="padding-right: 40px;"/>\
                                </div>');
        $("#comfirmAdd").prop('disabled', false);
    }

    function not_send_offal(){
        $('#selectedOffal').html('<div class="col-md-12 pr-md-0">\
                                    <label for="order_offal_number">order เครื่องใน</label>\
                                    <input type="text" class="form-control form-control-sm" type="text" id="order_offal_number" name="order_offal_number" value="-" readonly style="padding-right: 40px;"/>\
        </div>');
        $("#comfirmAdd").prop('disabled', false);
    }

</script>


{{-- datepicker --}}
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
{{-- datepicker --}}
<script>
    $('#daterange,#daterangeLot').daterangepicker({
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

    $('#daterange,#daterangeLot').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY'));
    });

</script>

<script>
function start_lot(lot_number){
    if ($('#btn_start_lot').hasClass( "btn-warning" )) {
        alert('เริ่มผลิต lot : ' + lot_number);
        $('#btn_start_lot').removeClass("btn-warning");
        $('#btn_start_lot').addClass("btn-success");
    }else  if ($('#btn_start_lot').hasClass( "btn-success" )) {
        alert('ผลิต lot : ' + lot_number);
        $('#btn_start_lot').removeClass("btn-success");
        $('#btn_start_lot').addClass("btn-warning");
    }
}
</script>

@endsection


