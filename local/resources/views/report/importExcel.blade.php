@extends('layouts.master')
@section('style')
<style>

</style>
@endsection
@section('main')

<div class="container">
    <div class="card bg-light">
        <div class="card-header">
            <div class="col-lg-12">
                <h2 style="color:;margin-bottom: 0px;height: 0px;">รายงานตรวจสอบการรับและส่งสินค้า ระหว่างโรงงาน-หน้าร้าน</h2>
            </div>
        </div>
        <div class="card-body">
            {{-- {{ Form::open(['method' => 'post' , 'url' => '/importExcelCompare' , 'enctype' => 'multipart/form-data']) }}
                @csrf
                <div class="row">

                    <a href="./assets/excel/ตัวอย่างไฟล์ร้านค้า.xlsx" target='__blank' >
                        <button type="button" class="btn btn-outline-primary btn-fw" style="margin-left: 15px;">
                        <i class="fa fa-file-excel-o"></i>ตัวอย่างไฟล์ร้านค้า
                        </button>
                    </a>

                </div>
                <br>
            {{ Form::close() }} --}}

            <table class="table table-striped table-bordered nowrap" width="100%" id="report_shop">
                <thead class="text-center">
                    <tr>
                    <th style="padding: 0px;" class="text-center">No.</th>
                    <th style="padding: 0px;" class="text-center">เลขที่บิล</th>
                    <th style="padding: 0px;" class="text-center">ร้านค้า</th>
                    <th style="padding: 0px;" class="text-center" hidden></th>
                    <th style="padding: 0px;" class="text-center">ประจำวันที่ (เดือน/วัน/ปี)</th>
                    <th style="padding: 0px;" class="text-center">ดำเนินการ</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 0; $i < 2; $i++)
                        @foreach ($report_factory[$i] as $report)
                            <tr>
                                <td style="padding: 0px;" class="text-center"></td>
                                <td style="padding: 0px;" class="text-center">{{ $report->order_number }}</td>
                                <td style="padding: 0px;" class="text-center">{{ $report->shop_name }}</td>
                                <td style="padding: 0px;" class="text-center" hidden><div >{{  substr($report->date ,6,4).substr($report->date ,0,2).substr($report->date ,3,2) }}</div></td>
                                <td style="padding: 0px;" class="text-center"> {{  substr($report->date ,3,2).'/'.substr($report->date ,0,2).'/'.substr($report->date ,6,4) }} 
                                    </td>
                                <td style="padding: 0px;" class="text-center">
                                    {{-- <a class="btn btn-info" data-toggle="modal" data-target="#importFileShop" >นำเข้าไฟล์ร้านค้า</a> --}}
                                    <a class="btn btn-success" target="_blank" href="{{url('/report_transport/'.$report->order_number)}}">ข้อมูลใบส่งของ</a> &nbsp;
                                    <a class="btn btn-warning" target="_blank" href="{{url('/checkOrderResultImportcompare/'.$report->order_number)}}">ข้อมูลเปรียบเทียบ</a>
                                    {{-- <button  style="padding: 7px;" type="button" class="btn btn-danger"
                                        onclick="deleteRecord('{{ $report->order_number }}')">
                                    <i class="fa fa-trash"></i>ลบข้อมูลร้านค้า</button> --}}
                                </td>
                            </tr>
                        @endforeach
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('script')

{{-- เลือกหมูจาก Stock --}}
    <div class="modal fade" id="importFileShop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="padding: 20px;">
                {{ Form::open(['method' => 'post' , 'url' => '/importExcelCompareShop' , 'enctype' => 'multipart/form-data']) }}
                {{-- <form action="{{ route('importExcelCompare') }}" method="POST" enctype="multipart/form-data"> --}}
                    @csrf
                    <div class="row">
                            <input type="file" name="file" class="form-control col-7"/> 
                            <button class="btn btn-info" style="margin-left: 50px;">นำเข้าไฟล์ร้านค้า</button> 
                    </div>
                    <br>
                {{-- </form> --}}
                {{ Form::close() }}
            </div>
        </div>
    </div>

<script>
    function deleteRecord(order_number){
        if(confirm('ต้องการลบ : '+order_number+' ?')){
            $.ajax({
                type: 'GET',
                url: '{{ url('delete_importCompare') }}',
                data: {order_number:order_number},
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
        var table = $('#report_shop').DataTable({
            lengthMenu: [[30, -1], [30, "All"]],
            "scrollX": false,
            orderCellsTop: true,
            fixedHeader: true,
            rowReorder: true,
            dom: 'lBfrtip',
            "order": [[ 3, "desc" ]],
            buttons: [
                'excel',
                //  'pdf', 'print'
            ],
            // processing: true,
            // serverSide: true,
        });
        table.on( 'order.dt search.dt', function () {
            table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();
</script>

@endsection