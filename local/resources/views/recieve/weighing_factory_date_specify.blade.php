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
<link rel="stylesheet" href="{{ url('https://cdn.datatables.net/1.10.18/css/dataTables.semanticui.min.css') }}" type="text/css" />
{{-- <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" /> --}}
<link rel="stylesheet" href="{{ asset('assets/css/daterangepicker.css')}}">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" />


@endsection
@section('main')

    <div class="ajax-loader" style="height: 800px;">
        <img src="{{ asset('assets/images/pig_fly.gif')}}" alt="" style="margin-left: 0px;top: 3%;width: 350px; left:37%;" class="img-responsive"  />
    </div>

    <div class="card">
        <div class="card-body" style="padding: 10px;">
            <div class="table-responsive">
                <div class="row" style="zoom: 0.8;">
                    <div class="col-lg-3"><h3 style="color:red;margin-bottom: 0px;height: 0px;">รายงานการชั่งน้ำหนัก (โรงงาน) &nbsp;&nbsp;</h3>
                    </div>
                    <div class="col-lg-2"><h6>ค้นหาวันที่ชั่งน้ำหนัก : </h6></div>
                    <div class="col-lg-2"><h6>เครื่องชั่ง : </h6></div>
                    <div class="col-lg-2"><h6>เลข Order : </h6></div>
                    <div class="col-lg-2"><h6>ค้นหารหัส item : </h6></div>
                </div>
                <div class="row" style="zoom: 0.8;"> <div class="col-lg-3"></div>
                    <div class="col-lg-2"><input required class="form-control input-daterange-datepicker" type="text" id="daterange" name="daterange" style="padding: 0px; height: 30px;"/></div>
                    <div class="col-lg-2">
                        <select class="form-control" id="scale_number" name="scale_number" style=" height: 30px; padding: 0px;">
                            <option value=""></option>
                            @foreach ($scale as $scale_number)
                                <option value="{{ $scale_number->scale_number }}">[{{ $scale_number->scale_number }}] : {{ $scale_number->location_scale }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2"><input type="text" class="form-control" name="order_number" id="order_number"style="padding: 0px; height: 30px;" placeholder="R200101-x,P020101-y" /></div>
                    <div class="col-lg-2"><input type="text" class="form-control" name="item_code" id="item_code"style="padding: 0px; height: 30px;" placeholder="1001,1002,1003" /></div>
                    <div class="col-lg-1"><input type="button" class="btn btn-success" value="ค้นหา" id="date_specify" onclick="date_specify()"></div>
                </div>
                <hr style="margin-bottom: 0px;">
                <div class="row" style="zoom: 0.8;padding-bottom: 5px;padding-top: 5px;">
                    <div class="col-lg-2"><a class="btn btn-success" data-toggle="modal" data-target="#adding" style="margin-bottom: 10px;" >
                        <i class="mdi mdi-plus"></i>
                    </a></div>
                    <div class="col-lg-3"><span style="color: red;">* SUM รวมทั้งหมดกด Show All</span> </div>
                    <div class="col-lg-2"><h6>ค้นหาประเภทการชั่ง : </h6>
                        <select class="form-control" id="weight_type_filter" name="weight_type_filter" style=" height: 30px; padding: 0px; border-color: #03A9F4;">
                            <option value=""></option>
                            @foreach ($wg_weight_type as $data_type)
                                <option value="{{ $data_type->wg_type_name }}">{{ $data_type->wg_type_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2"><h6>ค้นหาน้ำหนัก : </h6>
                        <input type="text" class="form-control" name="weight_filter" id="weight_filter" style=" height: 30px; padding: 0px; border-color: #03A9F4;">
                    </div>
                    <div class="col-lg-2"><h6>ค้นหาชื่อผู้ชั่ง : </h6>
                        <input type="text" class="form-control" name="user_filter" id="user_filter" style=" height: 30px; padding: 0px; border-color: #03A9F4;">
                    </div>
                </div>

                    <table class="table table-striped table-bordered nowrap" width="100%" id="recieveTable">
                        <thead class="text-center">
                        <tr>
                            <th style="padding: 0px;">No.</th>
                            <th style="padding: 0px;">เลข Lot</th>
                            <th style="padding: 0px;">Ref Order</th>
                            <th style="padding: 0px;">สถานที่</th>
                            <th style="padding: 0px;">รหัส Item</th>
                            <th style="padding: 0px;">ชื่อ Item</th>
                            <th style="padding: 0px;">ประเภทการชั่ง</th>
                            <th style="padding: 0px;">สาขา รับ/โอน/คืน</th>
                            <th style="padding: 0px;">ส่วนที่ชั่ง</th>
                            <th style="padding: 0px;" >จำนวน(ถุง)</th>
                            <th style="padding: 0px;" >น้ำหนัก</th>
                            <th style="padding: 0px;">ชื่อผู้ชั่ง</th>
                            <th style="padding: 0px;">วันที่ชั่ง</th>
                            <th style="padding: 0px;">เวลา</th>
                            <th style="text-align:center; padding: 0px;"> ดำเนินการ </th>
                        </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
            </div>
        </div>
    </div>

    {{-- ลบข้อมูล --}}
    {{ Form::open(['method' => 'post' , 'url' => '/product/delete/']) }}
                <div class="modal fade" id="DELETE" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel">ลบรายการรับสุกร-รถบรรทุก</h4>
                                </div>
                                <div class="modal-body">
                                        <h5 >ยืนยันการลบ รายการรับสุกร-รถบรรทุก</h5>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-danger" id="delete" name="delete" value="delete">ลบ</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
                                </div>
                            </div>
                        </div>
                </div>
    {{ Form::close() }}

    {{-- ADDข้อมูล --}}
    <div class="modal fade" id="adding" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                {{ Form::open(['method' => 'post' , 'url' => '/wg_sku_weigth_add_multiple']) }}
                <div class="forms-sample form-control" style="height: auto;padding-right: 20px;">
                    <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;">เพิ่มรายการน้ำหนัก</div>
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-md-6 pr-md-0">
                            <label for="orderDate">เลข Order</label>
                            <input class="form-control form-control-sm" id="order_number" type="text" name="order_number" required/>
                        </div>
                        <div class="col-md-6 pr-md-0">
                            <label for="scale_number">สถานที่ชั่ง</label>
                            <select class="form-control form-control-sm" id="scale_number" name="scale_number" style=" height: 30px; " required>
                                <option value=""></option>
                                @foreach ($wg_scale as $scale)
                                    <option value="{{ $scale->scale_number }}">{{ $scale->scale_number }} - {{ $scale->location_scale }}</option> 
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-md-3 pr-md-0">
                            <label for="weighing_place">สาขา รับ/โอน/คืน</label>
                            <select class="form-control form-control-sm" id="weighing_place" name="weighing_place" style=" height: 30px; " required>
                                <option value=""></option>
                                @foreach ($wg_scale_shop as $scale_shop)
                                    <option value="{{ $scale_shop->scale_number }}">{{ $scale_shop->scale_number }}</option> 
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 pr-md-0">
                            <label for="sku_id">ส่วนที่ชั่ง</label>
                            <select class="form-control form-control-sm" id="sku_id" name="sku_id" style=" height: 30px; " required>
                                <option value=""></option>
                                @foreach ($wg_sku as $sku)
                                    <option value="{{ $sku->id_wg_sku }}">{{ $sku->sku_name }}</option> 
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 pr-md-0">
                            <label for="sku_amount">จำนวนถุง</label>
                            <input class="form-control form-control-sm" placeholder="0" id="sku_amount" type="number" name="sku_amount" required>
                        </div>
                        <div class="col-md-3 pr-md-0">
                            <label for="weighing_type">ประเภทการชั่ง</label>
                            <select class="form-control form-control-sm" id="weighing_type" name="weighing_type" style=" height: 30px; " required>
                                <option value=""></option>
                                @foreach ($wg_weight_type as $weight_type)
                                    <option value="{{ $weight_type->id_wg_type }}">{{ $weight_type->wg_type_name }}</option> 
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 10px;">
                    </div>
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-md-3 pr-md-0">
                            <label for="storage_name">สถานที่จัดเก็บ</label>
                            <select class="form-control form-control-sm" id="storage_name" name="storage_name" style=" height: 30px; " required>
                                <option value=""></option>
                                @foreach ($wg_storage as $storage)
                                    <option value="{{ $storage->name_storage }}">{{ $storage->name_storage }}</option> 
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 pr-md-0">
                            <label for="user_name">ชื่อผู้่ชั่ง</label>
                            <input class="form-control form-control-sm" placeholder="๊USER" id="user_name" type="text" name="user_name" required>
                        </div>
                        <div class="col-md-3 pr-md-0">
                            <label for="weighing_date">วันที่ชั่ง</label>
                            <input class="form-control form-control-sm" placeholder="วว/ดด/ปปปป" readonly id="weighing_date" type="text" name="weighing_date" required>
                        </div>
                        <div class="col-md-3 pr-md-0">
                            <label for="time">เวลา</label>
                            <input class="form-control form-control-sm" name="time" type="time" >
                        </div>
                    </div>

                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-md-6 pr-md-0">
                            <label for="sku_code">รหัส Item</label>
                            <input class="form-control form-control-sm" placeholder="0000" id="sku_code" type="text" name="sku_code[]" required>
                        </div>
                        <div class="col-md-6 pr-md-0" >
                            <label for="sku_weight">น้ำหนัก</label>
                            <input class="form-control form-control-sm" placeholder="0.0" id="sku_weight" type="number"  step="0.01" min="0" max="99999" name="sku_weight[]" required>
                        </div>
                    </div>

                    <span id="mySpan"></span>

                    
                    <div class="row text-left">
                        <div class="col-md-12 pr-md-0" >
                            <input name="btnButton" class="btn btn-primary mr-2" id="btnButton" type="button" value="+" onClick="add(1);">
                            <input name="nButton" class="btn btn-danger mr-2" id="nButton" type="button" value="-" onClick="JavaScript:dd();">
                        </div> 
                    </div> 
                

                    <div class="text-center" style="padding-top: 10px;">
                        <button type="submit" class="btn btn-success mr-2" id="comfirmAdd" value="comfirmAdd">ยืนยัน</button>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

    {{-- edit --}}
    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                {{ Form::open(['method' => 'post' , 'url' => '/wg_sku_weigth_edit']) }}
                <div id="editModal"></div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

@endsection

@section('script')
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="{{ asset('https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js') }}"></script>
<script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js') }}"></script>
<script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js') }}"></script>


<script>
    $( document ).ready(function() {
        date_specify();
    });
   function date_specify(){
        var date_spec = $('#daterange').val();
        var scale_number = $('#scale_number').val();
        var order_number = $('#order_number').val();
        var item_code = $('#item_code').val();
        $('.ajax-loader').css("visibility", "visible");
        datatable(date_spec,scale_number,order_number,item_code);
    }
</script>

<script>
        // $('#itemcode').on('keyup change', function () {
        //         table.column(3).search($(this).val()).draw();
        // });
        // $('#itemname').on('keyup change', function () {
        //         table.column(4).search($(this).val()).draw();
        // });
        // $('#scale_type').on('keyup change', function () {
        //         table.column(5).search($(this).val()).draw();
        // });
  
    function datatable(date_spec,scale_number,order_number,item_code){

        $('#weight_type_filter').on('change', function () {
                table.column(5).search($(this).val()).draw();
        });
        $('#weight_filter').on('keyup change', function () {
                table.column(9).search($(this).val()).draw();
        });
        $('#user_filter').on('keyup change', function () {
                table.column(10).search($(this).val()).draw();
        });


        var table = $('#recieveTable').DataTable({
            destroy: true,

            "footerCallback": function ( row, data, start, end, display ) {
                var api = this.api(), data;
    
                // เปลี่ยนเป้นเลข เอาstrออก
                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                            i : 0;
                };
    
                // ค่าทุกหนา
                total = api
                    .column( 9 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
    
                // ค่าในหน้านี้
                pageTotal1 = api
                    .column( 9, { page: 'current'} )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                pageTotal2 = api
                    .column( 10, { page: 'current'} )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                // Update footer
                $( api.column( 9 ).footer() ).html(pageTotal1.toFixed(0) );
                $( api.column( 10 ).footer() ).html(pageTotal2.toFixed(2) );

            },

            // searching: false,
            lengthMenu: [[20, 50, 100, -1], [20, 50, 100, "All"]],
            dom: 'lBfrtip',
            buttons: [
                { extend: 'excel', footer: true },
                //  'pdf', 'print'
            ],
            "scrollX": false,
            orderCellsTop: true,
            fixedHeader: true,
            processing: true,
            // serverSide: true,
            ajax: {
                url: '{{ url('/weighing/sku_weight_data/factory/date_specify') }}',
                data: {date:date_spec,scale_number:scale_number,order_number:order_number,item_code:item_code},
                complete: function(){
                    $('.ajax-loader').css("visibility", "hidden");
                },
                error: function(){
                    $('.ajax-loader').css("visibility", "hidden");
                },
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'lot_number', name: 'lot_number' },
                { data: 'order_ref', name: 'order_ref' },
                { data: 'location_scale', name: 'location_scale' },
                { data: 'sku_code', name: 'sku_code' },
                { data: 'item_name', name: 'item_name' },
                { data: 'wg_type_name', name: 'wg_type_name' },
                { data: 'weighing_place', name: 'weighing_place' },
                { data: 'sku_type', name: 'sku_type' },
                { data: 'sku_amount', name: 'sku_amount' },
                { data: 'sku_weight', name: 'sku_weight' },
                { data: 'user_name', name: 'user_name' },
                // { data: 'price', name: 'price' },
                { data: 'weighing_date', name: 'weighing_date' },
                { data: 'weighing_date', name: 'weighing_date' },
                { data: 'id', name: 'id' },
            ],
            columnDefs: [
                {
                    "targets": 0,
                    "className": "text-center",
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                },
                {
                    "targets": 1,render(data,type,row){
                        if (data == null || data == '' ) {
                            return '-';
                        } else {
                            return data;
                        }
                    },
                    "className": "text-center",
                },
                {
                    "targets": 2,render(data,type,row){
                        if (data == null || data == '' ) {
                            return '-';
                        } else {
                            return data;
                        }
                    },
                    "className": "text-center",
                },
                

                {
                    "targets": 3,render(data,type,row){
                        if (data == null || data == '' ) {
                            return '-';
                        } else {
                            return data;
                        }
                    },
                    "className": "text-center",
                },
                {
                    "targets": 4,render(data,type,row){
                        if (data == null || data == '' ) {
                            return '-';
                        } else {
                            return data;
                        }
                    },
                    "className": "text-center",
                },
                {
                    "targets": 5,render(data,type,row){
                        if (data == null || data == '' ) {
                            return '-';
                        } else {
                            return data;
                        }
                    },
                    "className": "text-center",
                },
                {
                    "targets": 6,render(data,type,row){
                        if (data == null || data == '' ) {
                            return '-';
                        } else {
                            return data;
                        }
                    },
                    "className": "text-center",
                },
                {
                    "targets": 7,render(data,type,row){
                        if (data == null || data == '' ) {
                            return '-';
                        } else {
                            return data;
                        }
                    },
                    "className": "text-center",
                },
                {
                    "targets": 8,render(data,type,row){
                        if (data == null || data == '' ) {
                            return '-';
                        } else {
                            return data;
                        }
                    },
                    "className": "text-center",
                },
                {
                    "targets": 9,render(data,type,row){
                        if (data == null || data == '' ) {
                            return '-';
                        } else {
                            return data;
                        }
                    },
                    "className": "text-center",
                },
                {
                    "targets": 10,render(data,type,row){
                        if (data == null || data == '' ) {
                            return '-';
                        } else {
                            return data;
                        }
                    },
                    "className": "text-center",
                },
                {
                    "targets": 11,render(data,type,row){
                        if (data == null || data == '' ) {
                            return '-';
                        } else {
                            return data;
                        }
                    },
                    "className": "text-center",

                },
                {
                    "targets": 12, render(data,type,row){
                        // 2019-09-11 10:50:12
                        var data = data.substring(8,10) +'/'+ data.substring(5,7) +'/'+ data.substring(0,4);
                        return data;
                    },
                    "className": "text-center",
                },
                {
                    "targets": 13, render(data,type,row){
                        // 2019-09-11 10:50:12
                        var data = data.substring(11,22);
                        return data + ' น.';
                    },
                    "className": "text-center",
                },            
                {
                    "targets": 14,render(data,type,row){
                        var sign = "'";
                        var lot_number = row['lot_number'];
                        var location_scale = row['location_scale'];
                        var scale_number = row['scale_number'];
                        var sku_code = row['sku_code'];
                        var wg_type_name = row['wg_type_name'];
                        var id_wg_type = row['id_wg_type'];
                        var weighing_place = row['weighing_place'];
                        var id_wg_sku = row['id_wg_sku'];
                        var sku_type = row['sku_type'];
                        var sku_amount = row['sku_amount'];
                        var sku_weight = row['sku_weight'];
                        var storage_name = row['storage_name'];
                        var user_name = row['user_name'];
                        var weighing_date = row['weighing_date'].substring(8,10) +'/'+ row['weighing_date'].substring(5,7) +'/'+ row['weighing_date'].substring(0,4);
                        var time = row['weighing_date'].substring(11,16);
                        
                        return '<button style="padding: 7px;" type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit"\
                            onclick="editRecord('+sign+data+sign+','+sign+lot_number+sign+','+sign+location_scale+sign+','+sign+scale_number+sign+',\
                            '+sign+sku_code+sign+','+sign+wg_type_name+sign+','+sign+id_wg_type+sign+','+sign+weighing_place+sign+','+sign+id_wg_sku+sign+','+sign+sku_type+sign+',\
                            '+sign+sku_amount+sign+','+sign+sku_weight+sign+','+sign+storage_name+sign+','+sign+user_name+sign+','+sign+weighing_date+sign+','+sign+time+sign+')" ">\
                            <i class="mdi mdi-pencil"></i></button>\
                            <button  style="padding: 7px;" type="button" class="btn btn-danger"\
                            onclick="deleteRecord('+sign+data+sign+','+sign+lot_number+sign+','+sign+sku_weight+sign+')">\
                            <i class="fa fa-trash"></i></button>';
                    },
                    "className": "text-center",
                },
            ],
            "order": [],
        });

        table.on( 'order.dt search.dt', function () {
            table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();

    }
</script>

<script>
    function deleteRecord(id,order_number,sku_weight){
        if(confirm('ต้องการลบ : '+order_number+' น้ำหนัก '+sku_weight+' ?')){
            $.ajax({
                type: 'GET',
                url: '{{ url('delete_weighing_data') }}',
                data: {id:id},
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
    function editRecord(id,order_number,location_scale,scale_number,sku_code,wg_type_name,id_wg_type,weighing_place,id_wg_sku,sku_type,sku_amount,sku_weight,storage_name,user_name,weighing_date,time){

            $('#editModal').html('<div class="forms-sample form-control" style="height: auto;padding-right: 20px;">\
                            <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;">แก้ไขรายการน้ำหนัก</div>\
                            <div class="row" style="margin-bottom: 10px;">\
                                <div class="col-md-6 pr-md-0">\
                                    <label for="orderDate">เลข Order</label>\
                                    <input class="form-control form-control-sm" value="'+order_number+'" id="order_number" type="text" name="order_number" required>\
                                </div>\
                                <div class="col-md-6 pr-md-0">\
                                    <label for="scale_number">สถานที่ชั่ง</label>\
                                    <select class="form-control form-control-sm" id="scale_number" name="scale_number" style=" height: 30px; " required>\
                                            <option value="'+scale_number+'">'+scale_number+' - '+location_scale+'</option>\
                                        @foreach ($wg_scale as $scale)\
                                            <option  value="{{ $scale->scale_number }}">{{ $scale->scale_number }} - {{ $scale->location_scale }}</option>\
                                        @endforeach\
                                    </select>\
                                </div>\
                            </div>\
                            <div class="row" style="margin-bottom: 10px;">\
                                <div class="col-md-6 pr-md-0">\
                                    <label for="sku_code">รหัส Item</label>\
                                    <input class="form-control form-control-sm" value="'+sku_code+'" id="sku_code" type="text" name="sku_code" required>\
                                </div>\
                                <div class="col-md-6 pr-md-0">\
                                    <label for="weighing_type">ประเภทการชั่ง</label>\
                                    <select class="form-control form-control-sm" id="weighing_type" name="weighing_type" style=" height: 30px; " required>\
                                        <option value="'+id_wg_type+'">'+wg_type_name+'</option>\
                                        @foreach ($wg_weight_type as $weight_type)\
                                            <option value="{{ $weight_type->id_wg_type }}">{{ $weight_type->wg_type_name }}</option>\
                                        @endforeach\
                                    </select>\
                                </div>\
                            </div>\
                            <div class="row" style="margin-bottom: 10px;">\
                                <div class="col-md-3 pr-md-0">\
                                    <label for="weighing_place">สาขา รับ/โอน/คืน</label>\
                                    <select class="form-control form-control-sm" id="weighing_place" name="weighing_place" style=" height: 30px; " required>\
                                        <option value="'+weighing_place+'">'+weighing_place+'</option>\
                                        @foreach ($wg_scale_shop as $scale_shop)\
                                            <option value="{{ $scale_shop->scale_number }}">{{ $scale_shop->scale_number }}</option>\
                                        @endforeach\
                                    </select>\
                                </div>\
                                <div class="col-md-3 pr-md-0">\
                                    <label for="sku_id">ส่วนที่ชั่ง</label>\
                                    <select class="form-control form-control-sm" id="sku_id" name="sku_id" style=" height: 30px; " required>\
                                        <option value="'+id_wg_sku+'">'+sku_type+'</option>\
                                        @foreach ($wg_sku as $sku)\
                                            <option value="{{ $sku->id_wg_sku }}">{{ $sku->sku_name }}</option> \
                                        @endforeach\
                                    </select>\
                                </div>\
                                <div class="col-md-3 pr-md-0">\
                                    <label for="sku_amount">จำนวนถุง</label>\
                                    <input class="form-control form-control-sm" value="'+sku_amount+'" id="sku_amount" type="number" name="sku_amount" required>\
                                </div>\
                                <div class="col-md-3 pr-md-0">\
                                    <label for="sku_weight">น้ำหนัก</label>\
                                    <input class="form-control form-control-sm" value="'+sku_weight+'" id="sku_weight" type="number"  step="0.01" min="0" max="99999" name="sku_weight" required>\
                                </div>\
                            </div>\
                            <div class="row" style="margin-bottom: 10px;">\
                                <div class="col-md-3 pr-md-0">\
                                    <label for="storage_name">สถานที่จัดเก็บ</label>\
                                    <select class="form-control form-control-sm" id="storage_name" name="storage_name" style=" height: 30px; " required>\
                                        <option value="'+storage_name+'">'+storage_name+'</option>\
                                        @foreach ($wg_storage as $storage)\
                                            <option value="{{ $storage->name_storage }}">{{ $storage->name_storage }}</option>\
                                        @endforeach\
                                    </select>\
                                </div>\
                                <div class="col-md-3 pr-md-0">\
                                    <label for="user_name">ชื่อผู้่ชั่ง</label>\
                                    <input class="form-control form-control-sm" value="'+user_name+'" id="user_name" type="text" name="user_name" required>\
                                </div>\
                                <div class="col-md-3 pr-md-0">\
                                    <label for="weighing_date">วันที่ชั่ง</label>\
                                    <input class="form-control form-control-sm" value="'+weighing_date+'" id="weighing_date2" type="text" name="weighing_date2" readonly required>\
                                </div>\
                                <div class="col-md-3 pr-md-0">\
                                    <label for="time">เวลา</label>\
                                    <input class="form-control form-control-sm" name="time" value="'+time+'" type="time" >\
                                </div>\
                            </div>\
                            <div class="text-center" style="padding-top: 10px;">\
                                <button type="submit" class="btn btn-success mr-2" id="comfirmAdd" name="comfirmAdd" value="'+id+'">ยืนยัน</button>\
                            </div>\
                        </div>');

                        
                $('#weighing_date2').daterangepicker({
                    buttonClasses: ['btn', 'btn-sm'],
                    applyClass: 'btn-danger',
                    autoUpdateInput: false,
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
                        },function (chosen_date) {
                                $('#weighing_date2').val(chosen_date.format('DD/MM/YYYY'));
                        }
                );
                $('#weighing_date2').on('apply.daterangepicker', function(ev, picker) {
                    $(this).val(picker.startDate.format('DD/MM/YYYY'));
                });

            // $.ajax({
            //     type: 'GET',
            //     url: '{{ url('delete_weighing_data') }}',
            //     data: {id:id},
            //     success: function (msg) {
            //         alert(msg);
            //         location.reload();
            //     },
            //     error: function(XMLHttpRequest, textStatus, errorThrown) {
            //         alert("Status: " + textStatus); alert("Error: " + errorThrown);
            //     }
            // });
    }
</script>

{{-- daterange --}}
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script>
    $('#daterange').daterangepicker({
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

    $('#weighing_date').daterangepicker({
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

<script language="javascript" type="text/javascript">
    function add($i){
        var s =$i++;
        $("#mySpan").append('<div class="row" style="margin-bottom: 10px;" id="appen[]">\
                        <div class="col-md-6 pr-md-0">\
                            <label for="sku_code">รหัส Item</label>\
                            <input class="form-control form-control-sm" placeholder="0000" id="sku_code" type="text" name="sku_code[]" required>\
                        </div>\
                        <div class="col-md-6 pr-md-0" >\
                            <label for="sku_weight">น้ำหนัก</label>\
                            <input class="form-control form-control-sm" placeholder="0.0"  step="0.01" min="0" max="99999" id="sku_weight" type="number" name="sku_weight[]" required>\
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


