@extends('layouts.master')
@section('style')
<style>

</style>
@endsection
@section('main')

<div class="col-lg-12 grid-margin">
    <div class="card bg-light">
        <div class="card-header">
            <div class="col-lg-12"><h2 style="color:;margin-bottom: 0px;height: 0px;">รายการสั่ง Order พิเศษ</h2></div><br>
        </div>
        <div class="card-body table-responsive">

            <table class="table table-striped table-bordered nowrap" width="100%" id="report_shop">
                <thead class="text-center">
                    <tr>
                    <th style="padding: 0px;" class="text-center">No.</th>
                    <th style="padding: 0px;" class="text-center" hidden></th>
                    <th style="padding: 0px;" class="text-center">จัดส่ง วันที่</th>
                    @foreach ($shop_list as $shop)
                        <th style="padding: 0px;" class="text-center">{{ $shop->shop_description }}</th>
                    @endforeach
                    </tr>
                </thead>
                <tbody>
                    
                    @for ($i = 0; $i < 30; $i++)
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
                            <td style="padding: 0px;" class="text-center">{{ $date_format_shop }}</td>
                            @foreach ($shop_list as $shop2) @php $check_exist=0; @endphp
                                @foreach ($data_request as $request)
                                    @if ($request->date_request == $date_request_shop &&  $request->shop_code == $shop2->shop_code)
                                        <td style="padding: 0px;" class="text-center"><a class="btn btn-success" style="padding: 5px;" target="_blank" href="{{ url('/shop/special_order_admin/'.$date_format_link.'/'.$shop2->shop_code ) }}">{{ $shop2->shop_code }}</a></td>
                                        @php $check_exist++; @endphp
                                    @endif
                                @endforeach
                                @if ($check_exist == 0 )
                                    <td style="padding: 0px;" class="text-center"><a class="btn btn-secondary" style="padding: 5px;" target="_blank" href="{{ url('/shop/special_order_admin/'.$date_format_link.'/'.$shop2->shop_code ) }}">{{ $shop2->shop_code }}</a></td>
                                @endif
                            @endforeach
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