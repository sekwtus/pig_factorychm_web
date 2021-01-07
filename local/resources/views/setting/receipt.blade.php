@extends('layouts.master')
@section('style')
<style type="text/css">
    .input {
        height: 50%;
        background-color: aqua;
    }

    th,
    td {
        padding: 0px;
    }
</style>
<link rel="stylesheet" href="{{ url('https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css') }}"
    type="text/css" />
<link rel="stylesheet" href="{{ url('https://cdn.datatables.net/1.10.18/css/dataTables.semanticui.min.css') }}"
    type="text/css" />

@endsection
@section('main')


@if ($errors->any())
<br>
<div class="alert alert-danger text-center" style="background-color:#;">
    @foreach ($errors->all() as $error)
    {{ $error }}
    @endforeach
</div>
@endif

<div class="col-lg-12 grid-margin">
    <div class="card">
        <div class="card-body">

            <div class="row">
                <div class="col-4">
                    <h4>รายการขาย</h4>
                </div>
                {{-- <div class="col-8 text-right">
                    <a class="btn btn-success btn-fw" data-toggle="modal" data-target="#ADDSHOP">
                        <i class="mdi mdi-plus"></i>เพิ่มร้านค้า
                    </a>
                </div> --}}
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-bordered nowrap" width="100%" id="table_receipt">
                    <thead class="text-center">
                        <tr>
                            <th style="padding: 0px;">ลำดับ</th>
                            <th style="padding: 0px;">ชื่อร้านค้า</th>
                            <th style="padding: 0px;">ราคาสินค้ารวม</th>
                            <th style="padding: 0px;">เลขที่ใบเสร็จ</th>
                            <th style="padding: 0px;">จำนวนสินค้าในใบเสร็จ</th>
                            <th style="padding: 0px;">วันออกใบเสร็จ</th>
                            <th style="padding: 0px;">วิธีการชำระเงิน</th>
                            <th style="text-align:center; padding: 0px;"> ดำเนินการ </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>


@endsection

@section('script')
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="{{ asset('https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js') }}"></script>

<!-- DataTable -->

<script>
    var t = $('#table_receipt').DataTable({
        language: { "emptyTable": "ไม่มีรายการ" },
        processing: true,
        serverSide: true,
        sortable: true,
        searchable: true,
        ajax: '{{ url('/setting_receipt_data') }}',
        columns: [
                // {data: 'DT_RowIndex', orderable: false, searchable: false},
                {defaultContent: ""},
                {data: 'shop_name', name: 'shop_name' },
                {data: 'sum_value', name: 'sum_value' },
                {data: 'receipt_no', name: 'receipt_no' },
                {data: 'CountReceipt', name: 'CountReceipt' },
                {data: 'receipt_date', name: 'receipt_date' },
                {defaultContent: ""},
                {defaultContent: ""},
                // {data: 'sum_value', name: 'sum_value' }
        ], columnDefs: [
            {
                "targets": 0,
                "className": "text-center",
                "orderable": false,
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                "targets": 1,
                "className": "text-center"
            },
            {
                "targets": 2,
                "className": "text-center",
                render: function(data, type, row) {
                    return ''+row.sum_value+'&nbsp;บาท'
                }
            },
            {
                "targets": 3,
                "className": "text-center",
                // render: function(data, type, row) {
                //     return '<a href="../factory/pending_form_detail/'+row.hazardous_waste_request_id+'"><button class="btn btn-sm btn-outline btn-primary" type="button"><i class="fa fa-book" aria-hidden="true"></i></button></a>'
                // }
            },
            {
                "targets": 4,
                "className": "text-center"
            },
            {
                "targets": 5,
                "className": "text-center"
            },
            {
                "targets": 6,
                "className": "text-center",
                render: function(data, type, row) {
                    return 'ชำระด้วยเงินสด หรือ เงินเชื่อ'
                }
            },
            {
                "targets": 7,
                "className": "text-center",
                render: function(data, type, row) {
                    var s = "'";
                    return '<a href="setting/receipt/'+row["id"]+'/detail")}}"><button class="btn btn-sm btn-outline btn-primary" type="button"><i class="fa fa-share-square-o" aria-hidden="true">&ensp;ดูรายละเอียด</i></button></a>'
                    }
            },
            // {
            //     "targets": 6,
            //     "className": "text-center"
            //     // render: function(data, type, row) {
            //     //     var s = "'";
            //     //     return '<button class="btn btn-primary" onclick="editDoctor('+row["id"]+','+s+row["name"]+s+','+s+row["path_file"]+s+','+s+row["email"]+s+','+s+row["Line_doctor"]+s+','+s+row["file_category_name"]+s+','+s+row["file_category_id"]+s+');"\
            //     //     style="padding:5px;">&nbsp;&nbsp;&nbsp;ดูใบคำขอ&nbsp;&nbsp;&nbsp;</button>'
            //     //     }
            // },
            // {
            //     "targets": 7,
            //     "className": "text-center",
            //     render: function(data, type, row) {
            //         return '\
            //             <a href="../factory/pending_form_edit/'+row.hazardous_waste_request_id+'">\
            //                 <button class="btn btn-sm btn-outline btn-warning" type="submit">\
            //                     <i class="fa fa-edit" aria-hidden="true"></i>\
            //                 </button>\
            //             </a>\
            //             <button class="btn btn-sm btn-outline btn-danger" type="button" onclick="DelConfirm('+row.hazardous_waste_request_id+')">\
            //                 <i class="fa fa-trash" aria-hidden="true"></i>\
            //             </button>'
            //     }
            // }
        ],"order": [[ 1, 'asc' ]]
    });
    t.on( 'order.dt search.dt', function () {
        t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
</script>

@endsection