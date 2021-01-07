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
                <tr class=" text-center bg-secondary" style="background-color:#93c9ff; height:45px;" >
                    <th width="60%" style=" padding: 0px;" colspan="6">รายงานน้ำหนักการผลิต order : {{ $order_r }}</th>
                </tr>
                <tr class="text-center" style="background-color:#ffff93;height:32px;">
                    <th width="60%" style=" padding: 0px;" colspan="6"> น้ำหนักก่อนเชือด : {{ $order_r }}</th>
                </tr>
                <tr style="background-color:#ffff93;height:32px;">
                    <th class="text-center" style="padding: 0px;">รหัส order</th>
                    <th class="text-center" style="padding: 0px;">ลูกค้า/สาขา</th>
                    <th class="text-center" style="padding: 0px;">น้ำหนัก (กก.)</th>
                    <th class="text-center" style="padding: 0px;">จำนวน (ตัว)</th>
                    <th class="text-center" style="padding: 0px;">เฉลี่ย (กก./ตัว)</th>
                </tr>
            </thead>
            <tbody>
                
                @foreach ($r_data_list as $r_list)
                <tr style="background-color:#ffffe6;">
                    <td class="text-center" style="padding: 0px;">{{ $r_list->lot_number }}</td>
                    <td class="text-center" style="padding: 0px;">{{ $r_list->id_user_customer }}</td>
                    <td class="text-center" style="padding: 0px;">{{ $r_list->sum_weight }}</td>
                    <td class="text-center" style="padding: 0px;">{{ $r_list->sum_unit }}</td>
                    <td class="text-center" style="padding: 0px;">{{ number_format($r_list->sum_weight/$r_list->sum_unit,2,'.','') }}</td>
                </tr>
                    
                @endforeach

            {{-- of --}}
                <tr style="background-color:#8cffc6;height:32px;">
                    <td class="text-center" style="padding: 0px;"colspan="6" ><b> น้ำหนักเครื่องในหลังเชือด order : {{ $order_r }}</b></td>
                    <td class="text-center" style="padding: 0px;" hidden></td>
                    <td class="text-center" style="padding: 0px;" hidden></td>
                    <td class="text-center" style="padding: 0px;" hidden></td>
                    <td class="text-center" style="padding: 0px;" hidden></td>
                </tr>

                <tr style="background-color:#8cffc6;height:32px;">
                    <th class="text-center" style="padding: 0px;">รหัส item</th>
                    <th class="text-center" style="padding: 0px;">ชื่อ item</th>
                    <th class="text-center" style="padding: 0px;">น้ำหนัก (กก.)</th>
                    <th class="text-center" style="padding: 0px;">จำนวน (ชิ้น)</th>
                    <th class="text-center" style="padding: 0px;">เฉลี่ย</th>
                </tr>
                @php    $sum_percent_of =0;
                $sum_weight_of = 0;
                $sum_unit_of = 0;  @endphp
                @foreach ($offal_data_list as $offal_list)
                <tr style="background-color:#d9ffec;">
                    <td class="text-center" style="padding: 0px;">{{ $offal_list->sku_code }}</td>
                    <td class="text-center" style="padding: 0px;">{{ $offal_list->item_name }}</td>
                    <td class="text-center" style="padding: 0px;">{{ $offal_list->sum_weight }}</td>
                    <td class="text-center" style="padding: 0px;">{{ $offal_list->sum_unit }}</td>
                    <td class="text-center" style="padding: 0px;">{{ number_format( ($offal_list->sum_weight*100)/$r_list->sum_weight,2,'.','') }} %</td>
                    @php $sum_percent_of = $sum_percent_of + number_format( ($offal_list->sum_weight*100)/$r_list->sum_weight,2,'.',''); 
                        $sum_weight_of = $sum_weight_of + $offal_list->sum_weight;
                        $sum_unit_of = $sum_unit_of + $offal_list->sum_unit;
                    @endphp
                </tr>
                @endforeach
                <tr style="background-color:#8cffc6;">
                    <td class="text-center" style="padding: 0px;" ><b> รวม</b></td>
                    <td class="text-center" style="padding: 0px;" ></td>
                    <td class="text-center" style="padding: 0px;" >{{ $sum_weight_of }}</td>
                    <td class="text-center" style="padding: 0px;" >{{ $sum_unit_of }}</td>
                    <td class="text-center" style="padding: 0px;" >{{ $sum_percent_of }}</td>
                </tr>
            {{-- end of --}}
    
            {{-- ov12 --}}
                <tr style="background-color:#ffcaff;height:32px;">
                    <td class="text-center" style="padding: 0px;"colspan="6" ><b> น้ำหนักหลังตัดแต่ง : {{ $order_ov }}</b></td>
                    <td class="text-center" style="padding: 0px;" hidden></td>
                    <td class="text-center" style="padding: 0px;" hidden></td>
                    <td class="text-center" style="padding: 0px;" hidden></td>
                    <td class="text-center" style="padding: 0px;" hidden></td>
                </tr>
                <tr style="background-color:#ffcaff;height:32px;">
                    <th class="text-center" style="padding: 0px;">รหัส item</th>
                    <th class="text-center" style="padding: 0px;">ชื่อ item</th>
                    <th class="text-center" style="padding: 0px;">น้ำหนัก (กก.)</th>
                    <th class="text-center" style="padding: 0px;">จำนวน (ชิ้น)</th>
                    <th class="text-center" style="padding: 0px;">เฉลี่ย</th>
                </tr>
                @php    $sum_percent =0;
                        $sum_weight = 0;
                        $sum_unit = 0;  @endphp
                @foreach ($ov_data_list as $ov_list)
                <tr style="background-color:#fff2ff;">
                    <td class="text-center" style="padding: 0px;">{{ $ov_list->sku_code }}</td>
                    <td class="text-center" style="padding: 0px;">{{ $ov_list->item_name }}</td>
                    <td class="text-center" style="padding: 0px;">{{ $ov_list->sum_weight }}</td>
                    <td class="text-center" style="padding: 0px;">{{ $ov_list->sum_unit }}</td>
                    <td class="text-center" style="padding: 0px;">{{ number_format( ($ov_list->sum_weight*100)/$r_data_list[0]->sum_weight,2,'.','') }} %</td>
                    @php $sum_percent = $sum_percent + number_format( ($ov_list->sum_weight*100)/$r_data_list[0]->sum_weight,2,'.','');
                            $sum_weight = $sum_weight + $ov_list->sum_weight;
                            $sum_unit = $sum_unit + $ov_list->sum_unit;
                    @endphp
                </tr>
                @endforeach
                <tr style="background-color:#ffcaff;">
                    <td class="text-center" style="padding: 0px;" ><b> รวม</b></td>
                    <td class="text-center" style="padding: 0px;" ></td>
                    <td class="text-center" style="padding: 0px;" >{{ $sum_weight }}</td>
                    <td class="text-center" style="padding: 0px;" >{{ $sum_unit }}</td>
                    <td class="text-center" style="padding: 0px;" >{{ $sum_percent }}</td>
                </tr>
            {{-- end ov12 --}}
                
                <tr style="background-color:#ff8c8c;">
                    <th class="text-center" style="padding: 0px;"></th>
                    <th class="text-center" style="padding: 0px;">รวม</th>
                    <th class="text-center" style="padding: 0px;">{{ $sum_weight + $sum_weight_of    }}</th>
                    <th class="text-center" style="padding: 0px;">{{ $sum_unit +$sum_unit_of  }}</th>
                    <th class="text-center" style="padding: 0px;">{{ $sum_percent +  $sum_percent_of }} %</th>
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