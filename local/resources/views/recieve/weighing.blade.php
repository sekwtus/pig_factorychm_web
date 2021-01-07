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
    .decrease {
        background-color: #ff8080 !important;
    }
</style>

<link rel="stylesheet" href="{{ url('https://cdn.datatables.net/1.10.18/css/dataTables.semanticui.min.css') }}" type="text/css" />
{{-- <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" /> --}}
<link rel="stylesheet" href="{{ asset('assets/css/daterangepicker.css')}}">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" />

@endsection
@section('main')
              <div class="col-lg-12 grid-margin">
                <div class="card">
                  <div class="card-body">

                        <div class="table-responsive">
                            <div class="row">
                                <div class="col-lg-4"><h2 style="color:red;margin-bottom: 0px;height: 0px;">รายงานการชั่งน้ำหนัก (ร้านค้า)
                                </h2><br><h4 style="color:red;margin-bottom: 0px;height: 0px;padding-top: 20px;">ชั่งเข้า / ชั่งออก / แปรสภาพ  
                                    <button class="btn btn-success" style="margin-left: 250px;" data-toggle="modal" data-target="#ADDING" ><i class="mdi mdi-plus"></i></button>
                                </h4>   
                                </div>
                                <div class="col-lg-2"><h6>ค้นหาช่วงวันที่ชั่งน้ำหนัก : </h6></div>
                                <div class="col-lg-2"><h6>เลข Order : </h6></div>
                                <div class="col-lg-2"><h6>สถานที่ชั่ง : </h6></div>
                                <div class="col-lg-2"><h6>ค้นหารหัส item : </h6></div>
                                {{-- <div class="col-lg-2"><h6>ค้นหาสถานที่เก็บ : </h6></div> --}}
                            </div>
                            <div class="row"> <div class="col-lg-4"></div>
                                <div class="col-lg-2"><input class="form-control input-daterange-datepicker" type="text" id="daterange" name="daterange" style="padding: 0px; height: 30px;"/></div>
                                <div class="col-lg-2"><input type="text" class="form-control" name="order_number" id="order_number"style="padding: 0px; height: 30px;" /></div>
                                <div class="col-lg-2"><input type="text" class="form-control" name="scale_number" id="scale_number"style="padding: 0px; height: 30px;"/></div>
                                <div class="col-lg-2"><input type="text" class="form-control" name="itemcode" id="itemcode"style="padding: 0px; height: 30px;" /></div>
                                {{-- <div class="col-lg-2"><input type="text" class="form-control" name="storage" id="storage"style="padding: 0px; height: 30px;" /></div> --}}
                            </div>
                            <br>

                                <table class="table table-striped table-bordered nowrap" width="100%" id="recievetable">
                                  <thead class="text-center">
                                    <tr>
                                        <th style="padding: 0px;">No.</th>
                                        <th style="padding: 0px;">เลขที่บิล</th>
                                        <th style="padding: 0px;">สาขา</th>
                                        <th style="padding: 0px;">รหัส Item</th>
                                        <th style="padding: 0px;">ชื่อ Item</th>
                                        <th style="padding: 0px;">ประเภทการชั่ง</th>
                                        <th style="padding: 0px;">สถานที่ชั่ง</th>
                                        <th style="padding: 0px;">ส่วนที่ชั่ง</th>
                                        <th style="padding: 0px;">จำนวน(ถุง)</th>
                                        <th style="padding: 0px;">น้ำหนัก</th>
                                        <th style="padding: 0px;">ชื่อผู้ชั่ง</th>
                                        {{-- <th style="padding: 0px;">ราคา/หน่วย</th> --}}
                                        <th style="padding: 0px;">วันที่ชั่ง</th>
                                        <th style="padding: 0px;">เวลา</th>
                                        <th style="text-align:center; padding: 0px;"> ดำเนินการ </th>
                                    </tr>
                                  </thead>
                                </table>
                        </div>
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
    <div class="modal fade" id="ADDING" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                @if (Auth::user()->id_type == 1 || Auth::user()->id_type == 5)

                {{ Form::open(['method' => 'post' , 'url' => '/wg_sku_weigth_add']) }}
                <div class="forms-sample form-control" style="height: auto;padding-right: 20px;">
                    <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;">เพิ่มรายการน้ำหนัก</div>
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-md-6 pr-md-0">
                            <label for="orderDate">เลข Order</label>
                            <input class="form-control form-control-sm" placeholder="R20199999-99999" id="order_number" type="text" name="order_number" required>
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
                        <div class="col-md-6 pr-md-0">
                            <label for="sku_code">รหัส Item</label>
                            <input class="form-control form-control-sm" placeholder="0000" id="sku_code" type="text" name="sku_code" required>
                        </div>
                        <div class="col-md-6 pr-md-0">
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
                            <label for="sku_weight">น้ำหนัก</label>
                            <input class="form-control form-control-sm" placeholder="0.0" id="sku_weight" type="text" name="sku_weight" required>
                        </div>
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
                            <input class="form-control form-control-sm" placeholder="วว/ดด/ปปปป" id="weighing_date" type="text" name="weighing_date" required>
                        </div>
                        <div class="col-md-3 pr-md-0">
                            <label for="time">เวลา</label>
                            <input class="form-control form-control-sm" name="time" type="time" >
                        </div>
                    </div>
                    <div class="text-center" style="padding-top: 10px;">
                        <button type="submit" class="btn btn-success mr-2" id="comfirmAdd" value="comfirmAdd">ยืนยัน</button>
                    </div>
                </div>
                {{ Form::close() }}

                @else
                ไม่มีสิทธิ์ดำเนินการ
                @endif
            </div>
        </div>
    </div>

    {{-- edit --}}
    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                @if (Auth::user()->id_type == 1 || Auth::user()->id_type == 5)

                {{ Form::open(['method' => 'post' , 'url' => '/wg_sku_weigth_edit']) }}
                <div id="editModal"></div>
                {{ Form::close() }}
                
                @else
                ไม่มีสิทธิ์ดำเนินการ
                @endif
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
            $('#order_number').on('keyup change', function () {
                    table.column(1).search($(this).val()).draw();
            });
            $('#scale_number').on('keyup change', function () {
                    table.column(2).search($(this).val()).draw();
            });
            $('#itemcode').on('keyup change', function () {
                    table.column(3).search($(this).val()).draw();
            });

            var table = $('#recievetable').DataTable({
                "createdRow": function( row, data, dataIndex){
                    if(data.note ==  '1'){
                        $(row).addClass('decrease');
                    }
                },
                lengthMenu: [[20, 50, 100, -1], [20, 50, 100, "All"]],
                dom: 'lBfrtip',
                buttons: [
                    'excel',
                    //  'pdf', 'print'
                ],
                "scrollX": false,
                orderCellsTop: true,
                fixedHeader: true,
                processing: true,
                // serverSide: true,
                ajax: '{{ url('/weighing/sku_weight_data') }}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'lot_number', name: 'lot_number' },
                    { data: 'scale_number', name: 'scale_number' },//สาขา
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
                            if (data == null && row['item1_name'] != null) {
                                return row['item1_name'] + ',' + row['item2_name'];
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
                    // {
                    //     "targets": 8
                    // },
                    {
                        "targets": 11, render(data,type,row){
                            // 2019-09-11 10:50:12
                            var data = data.substring(8,10) +'/'+ data.substring(5,7) +'/'+ data.substring(0,4);
                            return data;
                        },
                        "className": "text-center",
                    },
                    {
                        "targets": 12, render(data,type,row){
                            // 2019-09-11 10:50:12
                            var data = data.substring(11,16);
                            return data + ' น.';
                        },
                        "className": "text-center",
                    },
                    {
                        "targets": 13,render(data,type,row){
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
                                    <i class="fa fa-trash"></i></button>\
                                    ';
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

            $.fn.dataTable.ext.search.push(
                function( settings, data, dataIndex ) {
                    var iStartDateCol = 11;

                    var daterange = $('#daterange').val();
                    var dateMin=daterange.substring(6,10) + daterange.substring(3,5)+ daterange.substring(0,2);
                    var dateMax=daterange.substring(19,23) + daterange.substring(16,18)+ daterange.substring(13,15);
                    var colDate=data[iStartDateCol].substring(6,12) + data[iStartDateCol].substring(3,5) + data[iStartDateCol].substring(0,2);
                    // console.log(colDate);
                    var areaSale=parseInt($('#areaSale').val());

                    var min = parseInt( dateMin );
                    var max = parseInt( dateMax );
                    var Date_data = parseFloat( colDate ) || 0;

                    if ( ( isNaN( min ) && isNaN( max ) ) ||
                        ( isNaN( min ) && Date_data <= max ) ||
                        ( min <= Date_data   && isNaN( max ) ) ||
                        ( min <= Date_data   && Date_data <= max )
                        )
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

{{-- deleteRecord --}}
<script>
    function deleteRecord(id,order_number,sku_weight){
        var x = '{{ Auth::user()->id_type }}';
        if (x == 1 || x == 5){
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
        else{
            alert('ไม่มีสิทธิ์ดำเนินการ');
        }

    }
</script>

{{-- edit --}}
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
                                    <input class="form-control form-control-sm" value="'+sku_weight+'" id="sku_weight" type="text" name="sku_weight" required>\
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
                                    <input class="form-control form-control-sm" value="'+weighing_date+'" id="weighing_date2" type="text" name="weighing_date2" required>\
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

    }
</script>

{{-- daterange --}}
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
    $('#daterange').daterangepicker({
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-danger',
        cancelClass: 'btn-inverse',
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
                    $('#weighing_date').val(chosen_date.format('DD/MM/YYYY'));
            }
    );
    $('#weighing_date').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY'));
    });
</script>


@endsection


