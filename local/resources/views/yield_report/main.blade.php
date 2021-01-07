@extends('layouts.master')
@section('style')
<style>

</style>
@endsection
@section('main')

<div class="container">
    <div class="card bg-light">
        <div class="card-header">
            {{-- <div class="col-lg-12"><h2 style="color:;margin-bottom: 0px;height: 0px;">นำเข้าไฟล์ Excel รายงานตรวจสอบน้ำหนักชิ้นส่วนสุกรในกระบวนการผลิต <br> จาก Form ที่กำหนด</h2></div><br> --}}
        </div>

        ** รายงานรวม
        <hr>
        <div class="card-body">
            <table class="table table-striped table-bordered nowrap" width="100%" id="report_shop">
                <thead class="text-center">
                    <tr>
                    <th style="padding: 0px;" class="text-center">No.</th>
                    <th style="padding: 0px;" class="text-center" hidden ></th>
                    <th style="padding: 0px;" class="text-center">order</th>
                    <th style="padding: 0px;" class="text-center">ลูกค้า/สาขา</th>
                    <th style="padding: 0px;" class="text-center">ประจำวันที่ (เดือน/วัน/ปี)</th>
                    <th style="padding: 0px;" class="text-center">น้ำหนักโรงงานชั่งเข้า -> ตัดแต่ง</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ov_list as $ov)
                        <tr>
                            <td style="padding: 0px;" class="text-center"></td>
                            <td style="padding: 0px;" class="text-center" hidden><div  >{{  substr($ov->date ,6,4).substr($ov->date ,3,2).substr($ov->date ,0,2) }}</div></td>
                            <td style="padding: 0px;" class="text-center"> {{ $ov->order_number }} </td>
                            <td style="padding: 0px;" class="text-center"> {{ $ov->id_user_customer }} </td>
                            <td style="padding: 0px;" class="text-center"> {{ $ov->date }} </td>
                            <td style="padding: 0px;" class="text-center">
                                <a class="btn btn-success" target="_blank" href="{{ url('/yield_report_data/data/'.$ov->order_number ) }}">รายงาน</a>
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
            "order": [[ 1, "desc" ]],
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