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

<div class="ajax-loader">
    <img src="{{ asset('assets/images/pig_fly.gif')}}" alt="" style="margin-left: 0px;top: 3%;width: 350px; left:37%;" class="img-responsive"  />
</div>

<div class="row ">
    <div class="col-lg-6 grid-margin">
        <div class="card">
            <div class="card-body " style="padding: 10px;">
                <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;padding-bottom: 0px;padding-top: 5px;">
                    <div class="row">
                        <h3 class="col-6" style="height: 25px;margin-bottom: 0px;padding-bottom: 35px; color:black;" id="switch_button" ><b>Order ในระบบ</b></h3>
                        <h4 class="col-3">ประจำวันที่ : </h4>
                        <input class="form-control form-control-sm col-2 input-daterange-datepicker" type="text" id="daterange" name="daterange" style="padding: 5px; height: 30px;"/>
                    </div>
                </div>
                <table class="table table-striped table-bordered nowrap table-hover table-responsive"  width="100%" id="orderTable">
                    <thead class="text-center">
                        <tr>
                        <th style="padding: 0px;max-width:12%; font-size: 0.7rem;">Order</th>
                        <th style="padding: 0px;max-width:12%; font-size: 0.7rem;">ลูกค้า</th>
                        <th style="padding: 0px;max-width:12%; font-size: 0.7rem;">รอบที่</th>
                        <th style="padding: 0px;max-width:12%; font-size: 0.7rem;">รหัสย่อ</th>
                        <th style="padding: 0px;max-width:12%; font-size: 0.7rem;">แผนผลิต</th>
                        <th style="padding: 0px;max-width:10%; font-size: 0.7rem;">จำนวน</th>
                        <th style="padding: 0px;max-width:10%; font-size: 0.7rem;">ช่วง นน.</th>
                        {{-- <th style="padding: 0px;max-width:12%; font-size: 0.7rem;">สถานะ</th> --}}
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
                        <h3 class="col-6" style="height: 25px;margin-bottom: 0px;padding-bottom: 35px; color:black;" id="switch_button" ><b>Order ที่ดำเนินการ</b></h3>
                        <h4 class="col-3">ประจำวันที่ : </h4>
                        <input class="form-control form-control-sm col-2 input-daterange-datepicker" type="text" id="daterangeLot" name="daterangeLot" style="padding: 5px; height: 30px;"/>
                    </div>
                </div>
                <table class="table table-striped table-bordered nowrap table-hover table-responsive" width="100%" id="orderTableLot">
                    <thead class="text-center">
                        <tr>
                        <th style="padding: 0px;max-width:12%; font-size: 0.7rem;">Order</th>
                        {{-- <th style="padding: 0px;max-width:12%; font-size: 0.7rem;">process No.</th> --}}
                        <th style="padding: 0px;max-width:12%; font-size: 0.7rem;">ลูกค้า</th>
                        <th style="padding: 0px;max-width:12%; font-size: 0.7rem;">รอบที่</th>
                        <th style="padding: 0px;max-width:12%; font-size: 0.7rem;">รหัสย่อ</th>
                        <th style="padding: 0px;max-width:12%; font-size: 0.7rem;">แผนผลิต</th>
                        <th style="padding: 0px;max-width:10%; font-size: 0.7rem;">จำนวน</th>
                        <th style="padding: 0px;max-width:10%; font-size: 0.7rem;">ช่วง นน.</th>
                        {{-- <th style="padding: 0px;max-width:12%; font-size: 0.7rem;">สถานะ</th> --}}
                        <th style="padding: 0px;max-width:12%; font-size: 0.7rem;">หมายเหตุ</th>
                        <th style="text-align:center; padding: 0px;max-width:20%; font-size: 0.7rem;"> ดำเนินการ </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- เลือกหมูจาก Stock --}}
{{-- {{ Form::open(['method' => 'post' , 'url' => '/stock_data/add/'.$stock_name]) }} --}}
    <div class="modal fade" id="select_stock" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="forms-sample form-control" style="height: auto;padding-right: 20px;">
                        <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;">ปรับ Stock</div>
                        <div class="row" style="margin-bottom: 10px;">
                            <div class="col-md-3 pr-md-0">
                                <label for="bill_number">Bill / Order</label>
                                <input type="text" class="form-control form-control-sm" name="bill_number" placeholder="0000" required> 
                            </div>
                            <div class="col-md-3 pr-md-0">
                                <label for="ref_source">ชื่อฟาร์ม</label>
                                <input type="text" class="form-control form-control-sm" name="ref_source" placeholder="0000" required> 
                            </div>
                            <div class="col-md-3 pr-md-0">
                                <label for="round">รอบที่</label>
                                <input type="number" class="form-control form-control-sm" name="round" value="1" required> 
                            </div>
                            <div class="col-md-3 pr-md-0">
                                <label for="item_code">รหัส Item</label>
                                <input type="text" class="form-control form-control-sm" name="item_code" placeholder="0000" required> 
                            </div>
                        </div>
                        <div class="row" style="margin-bottom: 10px;">
                            <div class="col-md-3 pr-md-0">
                                <label for="total_unit">จำนวนที่รับ</label>
                                <input type="number" class="form-control form-control-sm" name="total_unit" placeholder="จำนวน" required> 
                            </div>
                            <div class="col-md-6 pr-md-0">
                                <label for="id_storage">ที่จัดเก็บ (stock)</label>
                                <select class="form-control form-control-sm " id="id_storage" name="id_storage" style=" height: 30px; " required>
                                    <option value=""></option>
                                    {{-- @foreach ($storage as $store)
                                        <option value="{{ $store->id_storage }}">{{ $store->name_storage }} - {{ $store->description }}</option> 
                                    @endforeach --}}
                                </select> 
                            </div>
                            <div class="col-md-3 pr-md-0">
                                <label for="date_recieve">ประจำวันที่</label>
                                <input class="form-control form-control-sm" placeholder="วว/ดด/ปปปป" id="daterange" type="text" name="date_recieve" required>
                            </div>
                        </div>
                        
                        <div class="row" style="margin-bottom: 10px;">
                            <div class="col-md-12 pr-md-0">
                                <label for="note">หมายเหตุ</label>
                                <textarea class="form-control form-control-sm" name="note" rows="3" placeholder="หมายเหตุ"></textarea> 
                            </div>
                        </div>

                        <div class="text-center" style="padding-top: 10px;">
                            <button type="submit" class="btn btn-success mr-2" id="comfirmAdd" value="comfirmAdd">ยืนยัน</button>
                        </div>
                    </div>
                </div>
            </div>
    </div>
{{-- {{ Form::close() }} --}}


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
                    url: '{{ url('order/get_ajax/today') }}',
                    data: {department:department},
                },
            columns: [
                { data: 'order_number', name: 'order_number' },
                { data: 'id_user_customer', name: 'id_user_customer' },
                { data: 'round', name: 'round' },
                { data: 'marker', name: 'marker' },
                { data: 'date', name: 'date' },
                { data: 'total_pig', name: 'total_pig' },
                { data: 'weight_range', name: 'weight_range' },
                // { data: 'status', name: 'status' },
                { data: 'note', name: 'note' },
                { data: 'id', name: 'id' },
            ],
            columnDefs: [
            {
                "targets": 0,
                "className": "text-center",render(data,type,row){
                    return '<a target="blank_" href="../../summary_weighing_receive/'+data+'">'+data+'</a>';
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
            // {
            //     "targets": 7,
            //     "className": "text-center",
            // },
            {
                "targets": 7,
                "className": "text-center",
            },
            {
                "targets": 8,render(data,type,row){
                    var sign = "'";
                    var order_number = row['order_number'];
                    var total_pig = row['total_pig'];
                    var marker = row['marker'];
                    
                    // if ( $('#daterange').val() == row['date'] ) {
                        return '<button style="padding: 5px;" type="button" id="btn_action'+order_number+'" class="btn btn-success "\
                        onclick="setOrder('+sign+order_number+sign+','+sign+total_pig+sign+','+sign+marker+sign+')"><i class="fa fa-arrow-right" style="font-size: 25px;margin-right: 0px;"></i>\
                        <label id="number'+order_number+'"></label></button>';
                    // } else {
                    //     return '<button disabled style="padding: 5px;" type="button" id="btn_action'+order_number+'" class="btn btn-success ">\
                    //     <i class="fa fa-arrow-right" style="font-size: 25px;margin-right: 0px;"></i>\
                    //     <label id="number'+order_number+'"></label></button>';
                    // }
                   
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

                var iStartDateCol = 4;

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
        var department = '{{ $id }}';
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
                    url: '{{ url('order/get_ajax_inLot') }}',
                    data: {department:department},
                },
            columns: [
                { data: 'id_ref_order', name: 'id_ref_order' },
                // { data: 'process_number', name: 'process_number' },
                { data: 'id_user_customer', name: 'id_user_customer' },
                { data: 'round', name: 'round' },
                { data: 'marker', name: 'marker' },
                { data: 'date_picker', name: 'date_picker' },
                { data: 'total_pig', name: 'total_pig' },
                { data: 'weight_range', name: 'weight_range' },
                // { data: 'status', name: 'status' },
                { data: 'note', name: 'note' },
            ],
            columnDefs: [
                {
                    "targets": 0,
                    "className": "text-center",render(data,type,row){
                        return '<a target="blank_" href="../../summary_weighing_receive/'+data+'">'+data+'</a>';
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
                // {
                //     "targets": 8,
                //     "className": "text-center",
                // },
                {
                    "targets": 8,render(data,type,row){
                        var sign = "'";
                        var order_number = row['order_number'];
                        var total_pig = row['total_pig'];
                        return '<button style="padding: 5px;" type="button" id="btn_action'+order_number+'" class="btn btn-danger "\
                        onclick="ResetOrder('+sign+order_number+sign+','+sign+total_pig+sign+')"><i class="fa fa-arrow-left" style="font-size: 25px;margin-right: 0px;"></i>\
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

    function create_lot(){
        var getRecord = $.ajax({
            type: 'GET',
            beforeSend: function(){
                $('.ajax-loader').css("visibility", "visible");
            },
            url: '{{ url('new_lot/create_lot') }}',
            data: {},
            success: function (data) {
                $('#create_lot').html(data);
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
    
    // lock create lot if exist
    $(document).ready(function(){
        var lot = $('#create_lot').html();
        if (lot != 'กรุณาสร้าง LOT') {
            $('#btnCreate_lot').prop("disabled",true);
        }
    })

    function setOrder(order_number,total_pig,marker){
        var id = '{{ $id }}';
            $('#orderTable,tbody').on('click', 'tr',function(){
                var source = table.row(this);
                source.remove().draw();
            });

            $.ajax({
                type: 'GET',
                beforeSend: function(){
                    $('.ajax-loader').css("visibility", "visible");
                },
                url: '{{ url('addOrder_to_lot') }}',
                data: {order_number:order_number,total_pig:total_pig,id:id,marker},
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
    };

    function ResetOrder(order_number,total_pig){
        
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
                url: '{{ url('deleteOrder_from_lot') }}',
                data: {order_number:order_number},
                success: function (data) {
                    // console.log(data);
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


