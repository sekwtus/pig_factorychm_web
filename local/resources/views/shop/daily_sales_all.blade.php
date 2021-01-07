@extends('layouts.master')
@section('style')
<style>

</style>
@endsection
@section('main')

<div class="container">
    <div class="card bg-light">
        <div class="card-header">
            <div class="col-lg-12"><h2 style="color:;margin-bottom: 0px;height: 0px;">รายการสั่ง Order พิเศษ</h2></div><br>
        </div>
        <div class="card-body">

            <table class="table table-striped table-bordered nowrap" width="100%" id="report_shop">
                <thead class="text-center">
                    <tr>
                    <th style="padding: 0px;" class="text-center">No.</th>
                    <th style="padding: 0px;" class="text-center" hidden></th>
                    {{-- <th style="padding: 0px;" class="text-center">ร้านสั่ง Order วันที่</th> --}}
                    <th style="padding: 0px;" class="text-center">จัดส่ง วันที่</th>
                    <th style="padding: 0px;" class="text-center">ใบสั่งสินค้า 1</th>
                    <th style="padding: 0px;" class="text-center">ใบสั่งสินค้า 2</th>
                    <th style="padding: 0px;" class="text-center">ใบแกะ</th>
                    <th style="padding: 0px;" class="text-center">ใบคนงาน</th>
                    </tr>
                </thead>
                <tbody>
                    
                    @for ($i = 0; $i < 90; $i++)
                        @php
                        // ร้านสั่ง
                            $date_request = date('m/d/Y',strtotime(now() . "-".($i)." days"));
                            $date_request_shop = substr($date_request,3,2).'/'.substr($date_request,0,2).'/'.substr($date_request,6,4);

                        // วันตัดแต่ง ออกรายงาน
                            $yesterday = date('m/d/Y',strtotime(now() . "-".($i-4)." days"));
                            $date_format_shop  = substr($yesterday,3,2).'/'.substr($yesterday,0,2).'/'.substr($yesterday,6,4);

                            $date_format_link  = substr($date_request_shop,0,2).substr($date_request_shop,3,2).substr($date_request_shop,6,4);
                        @endphp
                        <tr>
                            <td style="padding: 0px;" class="text-center"></td>
                            <td style="padding: 0px;" class="text-center" hidden><div >{{ substr($yesterday ,6,4).substr($yesterday ,0,2).substr($yesterday ,3,2) }}</div></td>
                            {{-- <td style="padding: 0px;" class="text-center">{{ $date_request_shop }}</td> --}}
                            <td style="padding: 0px;" class="text-center">{{ $date_format_shop }}</td>
                            <td style="padding: 0px;" class="text-center"><a class="btn btn-primary" target="_blank" href="{{ url('/factory/receive_sp_order_1/'.$date_format_link ) }}">ใบสั่งสินค้า 1</a></td>
                            <td style="padding: 0px;" class="text-center"><a class="btn btn-success" target="_blank" href="{{ url('/factory/receive_sp_order_2/'.$date_format_link ) }}">ใบสั่งสินค้า 2</a></td>
                            <td style="padding: 0px;" class="text-center"><a class="btn btn-warning" target="_blank" href="{{ url('/factory/receive_sp_order_cutting/'.$date_format_link ) }}">ใบแกะ</a></td>
                            <td style="padding: 0px;" class="text-center"><a class="btn btn-info"    target="_blank" href="{{ url('/factory/receive_sp_order_employee/'.$date_format_link ) }}">ใบคนงาน</a></td>
                        </tr>
                    @endfor

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
            "order": [[ 1, "desc" ]],
        });
        table.on( 'order.dt search.dt', function () {
            table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();
</script>

@endsection