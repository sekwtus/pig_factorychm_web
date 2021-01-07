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
              <div class="col-lg-12 grid-margin">
                <div class="card">
                  <div class="card-body">

                      <div class="row">
                            <div class="col-4"><h4>แผนผลิตทั้งหมด</h4></div>
                        {{-- <input class="form-control form-control-sm" placeholder="วว/ดด/ปปปป" id="plan_recieve" name="plan_recieve" type="text" > --}}

                      </div>
                        <div class="table-responsive">
                                <table class="table table-striped table-bordered nowrap table-hover" width="100%" id="recieveTable">
                                  <thead class="text-center">
                                    <tr>
                                      <th style="padding: 0px; font-size: 0.7rem;">ลำดับ</th>
                                      <th style="padding: 0px; font-size: 0.7rem;">เลขที่ Order</th>
                                      <th style="padding: 0px; font-size: 0.7rem;">ลูกค้า</th>
                                      <th style="padding: 0px; font-size: 0.7rem;">รอบ</th>
                                      {{-- <th style="padding: 0px; font-size: 0.7rem;">ตัวย่อ</th> --}}
                                      <th style="padding: 0px; font-size: 0.7rem;">จำนวน</th>
                                      <th style="padding: 0px; font-size: 0.7rem;">ช่วงน้ำหนัก</th>
                                      <th style="padding: 0px; font-size: 0.7rem;">ประเภท</th>
                                      <th style="padding: 0px; font-size: 0.7rem;">รับสุกร</th>
                                      <th style="padding: 0px; font-size: 0.7rem;">เชือด</th>
                                      <th style="padding: 0px; font-size: 0.7rem;">เปิดซาก</th>
                                      <th style="padding: 0px; font-size: 0.7rem;">เครื่องใน</th>
                                      {{-- <th style="padding: 0px; font-size: 0.7rem;">ออกจาก OV.</th>
                                      <th style="padding: 0px; font-size: 0.7rem;">ตัดแต่ง</th>
                                      <th style="padding: 0px; font-size: 0.7rem;">จัดส่ง</th> --}}   
                                      <th style="padding: 0px; font-size: 0.7rem;">หมายเหตุ</th>
                                      <th style="text-align:center; padding: 0px; font-size: 0.7rem;"> ดำเนินการ </th>
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
                <div class="modal fade" id="PLAN" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content" >
                            <div class="modal-header" style="padding:5px;">
                                <div class="card"style="width: 100%;">
                                    <div class="card-body"style="padding: 0px;">
                                        <form action="#" id="submit">
                                            <div class="forms-sample form-control" style="height: auto;padding-right: 20px;">
                                            <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;">ใบสั่งแผน Order </div>
                                            <div class="row" style="margin-bottom: 10px;">
                                                <div class="col-md-6 pr-md-0">
                                                    <label for="order_number">เลขที่ order</label>
                                                    <input class="form-control form-control-sm" type="text" name="order_number" id="order_number" readonly></div>
                                                <div class="col-md-6 pr-md-0">
                                                    <label for="note">หมายเหตุ</label>
                                                    <input class="form-control form-control-sm" type="text" name="note" id="note" /></div>
                                            </div>
                                            <div class="row" style="margin-bottom: 10px;">
                                                <div class="col-md-6 pr-md-0">
                                                    <label for="plan_recieve">รับสุกร</label>
                                                    <input class="form-control form-control-sm" placeholder="วว/ดด/ปปปป" type="text" id="plan_recieve">
                                                </div>
                                                <div class="col-md-6 pr-md-0">
                                                    <label for="plan_slice">เชือด</label>
                                                    <input class="form-control form-control-sm" placeholder="วว/ดด/ปปปป" type="text" id="plan_slice" ></div>
                                            </div>
                                            <div class="row" style="margin-bottom: 10px;">
                                                <div class="col-md-6 pr-md-0">
                                                    <label for="plan_carcade">เปิดซาก</label>
                                                    <input class="form-control form-control-sm" placeholder="วว/ดด/ปปปป" type="text" id="plan_carcade" ></div>
                                                <div class="col-md-6 pr-md-0">
                                                    <label for="plan_offal">เครื่องใน</label>
                                                    <input class="form-control form-control-sm" placeholder="วว/ดด/ปปปป" type="text" id="plan_offal" ></div>
                                            </div>
                                            <div class="row" style="margin-bottom: 10px;" hidden>
                                                <div class="col-md-6 pr-md-0">
                                                    <label for="plan_overnight">ออกจาก OV.</label>
                                                    <input class="form-control form-control-sm" placeholder="วว/ดด/ปปปป" type="text" id="plan_overnight" ></div>
                                                <div class="col-md-6 pr-md-0">
                                                    <label for="plan_trim">ตัดแต่ง</label>
                                                    <input class="form-control form-control-sm" placeholder="วว/ดด/ปปปป" type="text" id="plan_trim" ></div>
                                            </div>
                                            <div class="row" style="margin-bottom: 10px;">
                                                <div class="col-md-6 pr-md-0" hidden>
                                                    <label for="plan_sending">จัดส่ง</label>
                                                    <input class="form-control form-control-sm" placeholder="วว/ดด/ปปปป" type="text" id="plan_sending" ></div>
                                                <div class="col-md-12 pr-md-0 text-center" style="padding-top: 15px; padding-left: 35px;">
                                                    <button type="submit" class="btn btn-success" onclick="save_plan()" id="comfirmAdd" value="comfirmAdd" >ยืนยัน</button>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button></div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


@endsection

@section('script')
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="{{ asset('https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js') }}"></script>

{{-- datatable --}}
    <script>
            var table = $('#recieveTable').DataTable({
                // lengthMenu: [[20, 50, 100, -1], [20, 50, 100, "All"]],
                "scrollX": false,
                orderCellsTop: true,
                fixedHeader: true,
                // processing: true,
                // serverSide: true,
                ajax: '{{ url('/order/plan/getajax') }}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'order_number', name: 'order_number' },
                    { data: 'id_user_customer', name: 'id_user_customer' },
                    { data: 'round', name: 'round' },
                    // { data: 'marker', name: 'marker' },
                    { data: 'total_pig', name: 'total_pig' },
                    { data: 'weight_range', name: 'weight_range' },
                    { data: 'order_type', name: 'order_type' },
                    { data: 'plan_recieve', name: 'plan_recieve' },
                    { data: 'plan_slice', name: 'plan_slice' },
                    { data: 'plan_carcade', name: 'plan_carcade' },
                    { data: 'plan_offal', name: 'plan_offal' },
                    // { data: 'plan_overnight', name: 'plan_overnight' },
                    // { data: 'plan_trim', name: 'plan_trim' },
                    // { data: 'plan_sending', name: 'plan_sending' },
                    { data: 'note', name: 'note' },
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
                    "targets": 8,
                    "className": "text-center",
                },
                {
                    "targets": 9,
                    "className": "text-center",
                },
                {
                    "targets": 10,
                    "className": "text-center",
                },
                {
                    "targets": 11,
                    "className": "text-center",
                },
                // {
                //     "targets": 12,
                //     "className": "text-center",
                // },
                // {
                //     "targets": 12,
                //     "className": "text-center",
                // },
                // {
                //     "targets": 13,
                //     "className": "text-center",
                // }, 
                // {
                //     "targets": 14,
                //     "className": "text-center",
                // },
                {
                    "targets": 12,render(data,type,row){
                    var id = row['id'];
                    var customer = row['customer'];
                    var order_number = row['order_number'];
                    var total_pig = row['total_pig'];
                    var weight_range = row['weight_range'];
                    var note = row['note'];
                    var sign = "'";

                        return '<button style="padding: 7px;" type="button" class="btn btn-success"  data-toggle="modal" data-target="#PLAN"\
                               onclick="order_plan('+sign+order_number+sign+','+sign+note+sign+')" href="#">\
                                <i class="fa fa-calendar"></i>แผนผลิต</button>';
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
            
    </script>


{{-- modal save plan --}}
<script>

    function order_plan(order_number,note) {

        $.ajax({
            type: 'GET',
            url: '{{ url('getPlan') }}',
            data: {order_number:order_number},
            success: function (data) {
                console.log(data[0].plan_recieve);
                $('#order_number').val(order_number);
                $('#plan_recieve').val(data[0].plan_recieve);
                $('#plan_slice').val(data[0].plan_slice);
                $('#plan_carcade').val(data[0].plan_carcade);
                $('#plan_offal').val(data[0].plan_offal);
                $('#plan_overnight').val(data[0].plan_overnight);
                $('#plan_trim').val(data[0].plan_trim);
                $('#plan_sending').val(data[0].plan_sending);

                if (note != 'null' && note != '' && note != null ) {
                    $('#note').val(note);            
                }
                
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert("Status: " + textStatus); alert("Error: " + errorThrown);
            }
        });

    }
    
    function save_plan(){

        var order_number = $('#order_number').val();
        var note = $('#note').val();
        var plan_recieve = $('#plan_recieve').val();
        var plan_slice = $('#plan_slice').val();
        var plan_carcade = $('#plan_carcade').val();
        var plan_offal = $('#plan_offal').val();
        var plan_overnight = $('#plan_overnight').val();
        var plan_trim = $('#plan_trim').val();
        var plan_sending = $('#plan_sending').val();

        $.ajax({
            type: 'GET',
            url: '{{ url('order/save_plan') }}',
            data: {order_number:order_number,plan_recieve:plan_recieve,plan_slice:plan_slice,plan_carcade:plan_carcade,
                plan_offal:plan_offal,plan_overnight:plan_overnight,plan_trim:plan_trim,
                plan_sending:plan_sending,note:note},
            success: function (msg) {
                alert(msg);
                location.reload();
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert("Status: " + textStatus); alert("Error: " + errorThrown);
            }
        });
    }
</script>

{{-- datepicker --}}
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
    $('#plan_recieve').daterangepicker({
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
            $('#plan_recieve').val(chosen_date.format('DD/MM/YYYY'));
        }
        );
        $('#plan_recieve').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY'));
    });
    $('#plan_slice,#plan_carcade,#plan_offal').daterangepicker({
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
            $('#plan_slice,#plan_carcade,#plan_offal').val(chosen_date.format('DD/MM/YYYY'));
        }
        );
        $('#plan_slice,#plan_carcade,#plan_offal').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY'));
    });

    $('#plan_trim,#plan_overnight').daterangepicker({
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
            $('#plan_trim,#plan_overnight').val(chosen_date.format('DD/MM/YYYY'));
        }
        );
        $('#plan_trim,#plan_overnight').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY'));
    });
    $('#plan_sending').daterangepicker({
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
            $('#plan_sending').val(chosen_date.format('DD/MM/YYYY'));
        }
        );
        $('#plan_sending').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY'));
    });
</script>
@endsection


