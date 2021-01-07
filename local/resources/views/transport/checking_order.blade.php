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
{{--  --------------------------------------------------------------------------------------------------------------------------------  --}}
    <div class="col-lg-12 grid-margin">
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

                        return '<a target="blank_" href="report_transport/'+order_number+'"><button title="ใบส่งของ" style="padding: 5px;" type="button" id="btn_action'+order_number+'" class="btn btn-info ">\
                        <i class="fa fa-file" style="font-size: 25px;margin-right: 0px;"></i></button></a>\
                        \
                        <a target="blank_" href="checkOrderResult/'+order_number+'"><button title="รายงานน้ำหนัก"\
                        style="padding: 5px;" type="button" class="btn btn-primary ">รายงานน้ำหนัก</button></a>';

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

@endsection


