@extends('layouts.master')
@section('style')
<style type="text/css">
    .input{
            height: 50%;
            background-color: aqua;
    }
    th,td{
        padding: 0px;
    }
    .bodyzoom{
    zoom: 0.9;
}
</style>

<link rel="stylesheet" href="{{ url('https://cdn.datatables.net/1.10.18/css/dataTables.semanticui.min.css') }}" type="text/css" />
{{-- <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" /> --}}
<link rel="stylesheet" href="{{ asset('assets/css/daterangepicker.css')}}">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" />

@endsection
@section('main')
              <div class="col-lg-12 grid-margin bodyzoom">
                <div class="card">
                  <div class="card-body">
                    <h2 class="text-center" style="margin-bottom: 0px;height: 0px;">รายงานการแปรสภาพ</h2><br><br>
                        <div class="row">
                            <div class="col-12 px-0">
                                <div class="table-responsive">
                                    @php $sum_weight_factory = 0;
                                            $sum_unit_factory = 0; 
                                            $sum_yiled_factory =0;
                                            $count = 1;
                                    @endphp 
                                    {{-- ตัวแปร น้ำหนักรวม ยีลรวม --}}
                                    <table class="table table-striped table-bordered nowrap table-hover" width="100%" id="reportTransform">
                                    <thead class="text-center">
                                        <tr>
                                            <th style="padding: 0px; background-color:#f2b0b7;" colspan="4">ก่อนแปสภาพ</th>
                                            <th style="padding: 0px; background-color:#a8c0c8;" colspan="4">หลังแปรสภาพ</th>
                                        </tr>
                                        <tr>
                                            <th style="padding: 0px;">No.</th>
                                            <th style="padding: 0px;">รหัส item</th>
                                            <th style="padding: 0px;">ชื่อ item</th>
                                            <th style="padding: 0px;">น้ำหนัก(กก.)</th>
                                            <th style="padding: 0px;">รหัส item</th>
                                            <th style="padding: 0px;">ชื่อ item</th>
                                            <th style="padding: 0px;">น้ำหนัก(กก.)</th>
                                            <th style="padding: 0px;">ส่วนต่างน้ำหนัก</th>
                                        </tr>
                                    </thead>
                                    @php
                                        $sum_before = 0;
                                        $sum_after = 0;
                                        $row = 1;
                                    @endphp
                                    <tbody>
                                        
                                        @for ($i = 0; $i < count($data_transform[0]); $i++)
                                        <tr>
                                            <td class="text-center" style="padding: 0px;">{{ $row++ }}</td>
                                            <td class="text-center" style="padding: 0px;">{{ $data_transform[0][$i]->sku_code }}</td>
                                            <td class="text-center" style="padding: 0px;">{{ $data_transform[0][$i]->item_name }}</td>
                                            <td class="text-center" style="padding: 0px;">{{ $data_transform[0][$i]->sku_weight }}
                                                @php
                                                    $sum_before = $sum_before + $data_transform[0][$i]->sku_weight;
                                                @endphp
                                            </td>
                                            <td class="text-center" style="padding: 0px;">{{ ( empty($data_transform[1][$i]->sku_code) ? '' : $data_transform[1][$i]->sku_code) }}</td>
                                            <td class="text-center" style="padding: 0px;">{{ ( empty($data_transform[1][$i]->item_name) ? '' : $data_transform[1][$i]->item_name) }}</td>
                                            <td class="text-center" style="padding: 0px;">{{ ( empty($data_transform[1][$i]->sku_weight) ? '' : $data_transform[1][$i]->sku_weight) }}
                                                @php
                                                    $sum_after = $sum_after + (empty($data_transform[1][$i]->sku_weight) ? 0 : $data_transform[1][$i]->sku_weight);
                                                @endphp
                                            </td>

                                            <td class="text-center" style="padding: 0px;">{{ $data_transform[0][$i]->sku_weight - ( empty($data_transform[1][$i]->sku_weight) ? 0 : $data_transform[1][$i]->sku_weight) }}</td>
                                        </tr>
                                        @endfor
                                        
                                        <tr>
                                            <td class="text-center" style="padding: 0px;"><b>น้ำหนักรวม</b></td>
                                            <td class="text-center" style="padding: 0px;"></td>
                                            <td class="text-center" style="padding: 0px;"></td>
                                            <td class="text-center" style="padding: 0px;"><b>{{ $sum_before }}</b></td>
                                            <td class="text-center" style="padding: 0px;"></td>
                                            <td class="text-center" style="padding: 0px;"></td>
                                            <td class="text-center" style="padding: 0px;"><b>{{ $sum_after }}</b></td>
                                            <td class="text-center" style="padding: 0px;"><b>{{ $sum_before - $sum_after }}</b></td>
                                        </tr>
                                        
                                    </tbody>
                                    </table>
                                    
                                </div>
                            </div>
                        </div>
                      </div>
                   </div>
                </div>


@endsection

@section('script')
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="{{ asset('https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js') }}"></script>
<script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js') }}"></script>
<script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js') }}"></script>

<script>
    var table1 = $('#reportTransform').DataTable({
        destroy: true,
        dom: 'Bfrtip',
        buttons: [
            'excel'
        ],
        lengthMenu: [[20, 50, 100, -1], [20, 50, 100, "All"]],
        "scrollX": false,
        orderCellsTop: true,
        fixedHeader: true,
        rowReorder: true,
        // processing: true,
        // serverSide: true,
        "order": [],
    });
</script>

{{-- daterange --}}
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
$('#daterange').daterangepicker({
    buttonClasses: ['btn', 'btn-sm'],
    applyClass: 'btn-danger',
    cancelClass: 'btn-inverse',
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
</script>


@endsection


