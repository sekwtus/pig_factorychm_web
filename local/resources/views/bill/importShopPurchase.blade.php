@extends('layouts.master')
@section('style')
<style>

</style>
@endsection
@section('main')

<div class="container">
    <div class="card bg-light">
        <div class="card-header">
            <div class="col-lg-12"><h2 style="margin-bottom: 0px;height: 0px;">นำเข้าไฟล์ Excel ข้อมูลการซื้อของสาขา จาก Form ที่กำหนด</h2></div><br>
        </div>
        <div class="card-body">

                {{ Form::open(['method' => 'post' , 'url' => '/importExcelPurchase' , 'enctype' => 'multipart/form-data']) }}
                @csrf
                <div class="row">
                    <input type="file" name="file" class="form-control col-5"/> 
                    <button class="btn btn-success" style="margin-left: 50px;">นำเข้าไฟล์ รายงานการซื้อ</button>

                    <a href="./assets/excel/ตัวอย่างไฟล์ข้อมูลดิบซื้อ.xlsx" target='__blank' >
                        <button type="button" class="btn btn-outline-primary btn-fw" style="margin-left: 15px;">
                        <i class="fa fa-file-excel-o"></i>ตัวอย่างไฟล์รายงานการขาย
                        </button>
                    </a>

                </div>
                <br>
                {{ Form::close() }}
<hr>
            <table class="table table-striped table-bordered nowrap" width="100%" id="report_shop">
                <thead class="text-center">
                    <tr>
                    <th style="padding: 0px;" class="text-center">No.</th>
                    <th style="padding: 0px;" class="text-center">ร้านค้า</th>
                    <th style="padding: 0px;" class="text-center">ช่วงวันที่ (เดือน/วัน/ปี)</th>
                    <th style="padding: 0px;" class="text-center">ดำเนินการ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($report_purchase_today as $today)
                        <tr>
                            <td style="padding: 0px;" class="text-center"></td>
                            <td style="padding: 0px;" class="text-center">{{ $today->shop_name }}</td>
                            <td style="padding: 0px;" class="text-center">{{ $today->date_source }} - {{ $today->date_destination }} </td>
                            <td style="padding: 0px;" class="text-center"><a class="btn btn-warning" href="{{url('/report_purchase/'.$today->id)}}">ข้อมูล</a>
                                <button  style="padding: 7px;" type="button" class="btn btn-danger"
                                onclick="deleteRecord('{{ $today->shop_name }}','{{ $today->date_source }}','{{ $today->date_destination }}')">
                                <i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('script')

<script>
        var table = $('#report_shop').DataTable({
            lengthMenu: [[200, -1], [200, "All"]],
            "scrollX": false,
            orderCellsTop: true,
            fixedHeader: true,
            rowReorder: true,
            dom: 'lBfrtip',
            buttons: [
                'excel',
                //  'pdf', 'print'
            ],
            // processing: true,
            // serverSide: true,
            "order": [],
        });
        table.on( 'order.dt search.dt', function () {
            table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();
</script>

<script>
    function deleteRecord(shop_name,date_source,date_destination){
        if(confirm('ต้องการลบ : '+shop_name+' วันที่ '+date_source+' - '+date_destination+' ?')){
            $.ajax({
                type: 'GET',
                url: '{{ url('delete_report_purchase') }}',
                data: {shop_name:shop_name,date_source:date_source,date_destination:date_destination},
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

@endsection