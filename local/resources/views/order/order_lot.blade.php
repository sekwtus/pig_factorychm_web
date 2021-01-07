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
              <div class="col-lg-12 grid-margin">
                <div class="card">
                  <div class="card-body">

                        <div class="table-responsive">
                            <div class="row">
                                <div class="col-lg-4"><h2 style="color:red;margin-bottom: 0px;height: 0px;">รายงาน หมายเลขการผลิต</h2></div>
                                <div class="col-lg-2"><h6>ค้นหาช่วงวันที่จัดส่ง : </h6></div>
                                {{-- <div class="col-lg-2"><h6>ค้นหารหัส item : </h6></div>
                                <div class="col-lg-2"><h6>ค้นหาชื่อ item : </h6></div>
                                <div class="col-lg-2"><h6>ค้นหาประเภทการชั่ง : </h6></div> --}}
                            </div>
                            <div class="row"> <div class="col-lg-4"></div>
                                <div class="col-lg-2"><input class="form-control input-daterange-datepicker" type="text" id="daterange" name="daterange" style="padding: 0px; height: 30px;"/></div>
                                {{-- <div class="col-lg-2"><input type="text" class="form-control" name="itemcode" id="itemcode"style="padding: 0px; height: 30px;" /></div>
                                <div class="col-lg-2"><input type="text" class="form-control" name="itemname" id="itemname"style="padding: 0px; height: 30px;" /></div>
                                <div class="col-lg-2"><input type="text" class="form-control" name="scale_type" id="scale_type"style="padding: 0px; height: 30px;"/></div> --}}
                            </div>
                            <br>

                                <table class="table table-striped table-bordered nowrap" width="100%" id="recievetable">
                                  <thead class="text-center">
                                    <tr>
                                      <th style="padding: 0px;">No.</th>
                                      {{-- <th style="padding: 0px;">เลขที่ LOT</th> --}}
                                      <th style="padding: 0px;">เลขที่ ORDER</th>
                                      <th style="padding: 0px;">ลูกค้า / สาขา</th>
                                      <th style="padding: 0px;">ประเภท</th>
                                      <th style="padding: 0px;">จำนวนสุกร</th>
                                      <th style="padding: 0px;">รอบที่</th>
                                      <th style="padding: 0px;">วันที่จัดส่ง</th>
                                      <th style="padding: 0px;">สถานะ</th>
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
            // $('#itemcode').on('keyup change', function () {
            //         table.column(3).search($(this).val()).draw();
            // });
            // $('#itemname').on('keyup change', function () {
            //         table.column(4).search($(this).val()).draw();
            // });
            // $('#scale_type').on('keyup change', function () {
            //         table.column(5).search($(this).val()).draw();
            // });
            // $('#storage').on('keyup change', function () {
            //         table.column(6).search($(this).val()).draw();
            // });

            var table = $('#recievetable').DataTable({
                lengthMenu: [[20, 50, 100, -1], [20, 50, 100, "All"]],
                dom: 'lBfrtip',
                buttons: [
                    'excel',
                    //  'pdf', 'print'
                ],
                "scrollX": false,
                orderCellsTop: true,
                fixedHeader: true,
                // processing: true,
                // serverSide: true,
                ajax: '{{ url('/selectLot') }}',
                columns: [
                    { data: 'id', name: 'id' },
                    // { data: 'lot_number', name: 'lot_number' },
                    { data: 'id_ref_order', name: 'id_ref_order' },
                    { data: 'id_user_customer', name: 'id_user_customer' },
                    { data: 'order_type', name: 'order_type' },
                    { data: 'order_plan_amount', name: 'order_plan_amount' },
                    { data: 'round', name: 'round' },
                    { data: 'start_date_process', name: 'start_date_process' },
                    { data: 'lot_status', name: 'lot_status' },
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
                // {
                //     "targets": 7,render(data,type,row){
                //         if (data == null || data == '' ) {
                //             return '-';
                //         } else {
                //             return data;
                //         }
                //     },
                //     "className": "text-center",
                // },
                {
                    "targets": 7,render(data,type,row){
                        var id = row['id_ref_order'];
                        return '<a href="../summary_weighing/'+id+'" target="_blank"><button style="padding: 5px;" type="button" id="btn_action" class="btn btn-success">\
                        <i class="fa fa-eye" style="font-size: 25px;margin-right: 0px;"></i><label id="number"></label></button></a>\
                        <a href="../checkOrderResult/'+id+'" target="_blank"><button style="padding: 5px;" type="button" id="btn_action" class="btn btn-info">\
                        <i class="fa fa-file-text-o" style="font-size: 25px;margin-right: 0px;"></i><label id="number">&nbsp;น้ำหนัก ก่อนส่ง-หลังส่ง</label></button></a>';
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
                    var iStartDateCol = 6;

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
    </script>


@endsection


