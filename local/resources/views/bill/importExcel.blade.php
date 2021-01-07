@extends('layouts.master')
@section('style')
<style>

</style>
@endsection
@section('main')

<div class="container">
    <div class="card bg-light">
        <div class="card-header">
            <div class="col-lg-12"><h2 style="color:;margin-bottom: 0px;height: 0px;">นำเข้าไฟล์ Excel ข้อมูลการขายของสาขา จาก Form ที่กำหนด</h2></div><br>
        </div>
        <div class="card-body">

                {{ Form::open(['method' => 'post' , 'url' => '/importReportSales' , 'enctype' => 'multipart/form-data']) }}
                @csrf
                <div class="row">
                    <input type="file" name="file" class="form-control col-5"/> 
                    <button class="btn btn-success" style="margin-left: 50px;">นำเข้าไฟล์ รายงานการขาย</button>

                    <a href="./assets/excel/ตัวอย่างไฟล์รายงานการขาย.xlsx" target='__blank' >
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
                    <th style="padding: 0px;" class="text-center" hidden></th>
                    <th style="padding: 0px;" class="text-center">ประจำวันที่ (เดือน/วัน/ปี)</th>
                    <th style="padding: 0px;" class="text-center">ดำเนินการ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($report_shop_today as $today)
                        <tr>
                            <td style="padding: 0px;" class="text-center"></td>
                            <td style="padding: 0px;" class="text-center">{{ $today->shop_name }}</td>
                            <td style="padding: 0px;" class="text-center" hidden><div >{{ substr($today->date_today ,6,4).substr($today->date_today ,0,2).substr($today->date_today ,3,2) }}</div></td>
                            <td style="padding: 0px;" class="text-center"> 
                                    @if (strlen($today->date_today) > 10) 
                                        {{ $today->date_today }}
                                    @else
                                    {{  substr($today->date_today ,3,2).'/'.substr($today->date_today ,0,2).'/'.substr($today->date_today ,6,4) }}
                                    @endif
                            </td>
                            <td style="padding: 0px;" class="text-center"><a class="btn btn-warning" href="{{url('/report_shop_level1/'.$today->id)}}">ข้อมูล</a></td>
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
            lengthMenu: [[30, -1], [30, "All"]],
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
            "order": [[ 2, "desc" ]],
        });
        table.on( 'order.dt search.dt', function () {
            table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();
</script>

@endsection