@extends('layouts.master')
@section('style')

<link rel="stylesheet" href="{{ url('https://cdn.datatables.net/1.10.18/css/dataTables.semanticui.min.css') }}" type="text/css" />
{{-- <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" /> --}}
<link rel="stylesheet" href="{{ asset('assets/css/daterangepicker.css')}}">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" />

@endsection

@section('main')

<div class="card bg-light">
    <div class="card-body"> 
        <table id="tbl-1" class="tbl " width="100%" border="1">
            <thead>
                <tr class=" text-center bg-secondary"  style="background-color:#93c9ff; height:46px;" >
                    <th width="60%" style=" padding: 0px;" colspan="6">รายงานเชือด order : {{ $order_rr_show }}
                      
                    </th>
                </tr>
                
                <tr style="background-color:#ffff93; height:32px;">
                    <td class="text-center" style="padding: 0px; "colspan="6" ><b> น้ำหนักก่อนเชือด [01,02] : {{ $order_rr_show }}</b></td>
                </tr>
                <tr style="background-color:#ffff93; height:32px;">
                    <th class="text-center" style="padding: 0px;">รหัส order</th>
                    <th class="text-center" style="padding: 0px;">ลูกค้า/สาขา</th>
                    <th class="text-center" style="padding: 0px;">จำนวน (ตัว)</th>
                    <th class="text-center" style="padding: 0px;">น้ำหนัก (กก.)</th>
                    <th class="text-center" style="padding: 0px;">เฉลี่ย (กก./ตัว)</th>
                    <th class="text-center" style="padding: 0px;">หมายเหตุ</th>
                </tr>
            </thead>
            <tbody>

                @php
                   $recieve_weight = 0; 
                   $sum_unit_r = 0;  
                   @endphp
                {{-- r --}}
                @foreach ($r_data_list as $r_list)
                <tr style="background-color:#ffffe6;">
                    <td class="text-center" style="padding: 0px;">
                    <a target="blank_" href="../yield_report_data_daily_all_order/{{ $r_list->lot_number }}">{{ $r_list->lot_number }}</a>
                    </td>
                    <td class="text-center" style="padding: 0px;">{{ $r_list->id_user_customer }}</td>
                    <td class="text-center" style="padding: 0px;">{{ $r_list->sum_unit }}</td>
                    <td class="text-center" style="padding: 0px;">{{ $r_list->sum_weight }}</td>
                    <td class="text-center" style="padding: 0px;">{{ number_format($r_list->sum_weight/$r_list->sum_unit,2,'.','') }}</td>
                    @php
                        $recieve_weight = $recieve_weight + $r_list->sum_weight ;       
                        $sum_unit_r = $sum_unit_r + $r_list->sum_unit;
                    @endphp
                    <td class="text-center" style="padding: 0px;"></td>
                </tr>   
                @endforeach
                <tr style="background-color:#ffff93;">
                    <td class="text-center" style="padding: 0px;" ><b> รวม</b></td>
                    <td class="text-center" style="padding: 0px;" ></td>
                    <td class="text-center" style="padding: 0px;" >{{ $recieve_weight }}</td>
                    <td class="text-center" style="padding: 0px;" >{{ $sum_unit_r }}</td>
                    <td class="text-center" style="padding: 0px;" >{{ number_format($recieve_weight/$sum_unit_r,2,'.','') }}</td>
                    <td class="text-center" style="padding: 0px;"></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection
@section('script')
<script src="{{ asset('https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js') }}"></script>
<script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js') }}"></script>
<script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js') }}"></script>

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
        var table = $('#tbl-1s').DataTable({
            lengthMenu: [[-1], ["All"]],
            "scrollX": false,
            orderCellsTop: true,
            fixedHeader: true,
            // rowReorder: true,
            dom: 'Brt',
            // "order": [[ 1, "desc" ]],
            buttons: [
                'excel',
                //  'pdf', 'print'
            ],
            // processing: true,
            // serverSide: true,
        });
        // table.on( 'order.dt search.dt', function () {
        //     table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
        //         cell.innerHTML = i+1;
        //     } );
        // } ).draw();
</script>

@endsection