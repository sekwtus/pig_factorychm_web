@extends('layouts.master')
@section('style')
<style type="text/css">
    .input{
            height: 50%;
            background-color: aqua;
    }
    th{
        padding: 0px;
        font-size: 12px;
    }    
    td{
        padding: 0px;
        font-size: 14px;
    }
    .bodyzoom{
    zoom: 0.9;
}
</style>

<link rel="stylesheet" href="{{ url('https://cdn.datatables.net/1.10.18/css/dataTables.semanticui.min.css') }}" type="text/css" />
{{-- <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" /> --}}
<link rel="stylesheet" href="{{ asset('assets/css/daterangepicker.css')}}">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/tabletools/2.2.4/css/dataTables.tableTools.min.css" />

@endsection
@section('main')
              <div class="col-lg-12 grid-margin bodyzoom">
                <div class="card">
                  <div class="card-body">
                    <h2 class="text-center" style="margin-bottom: 0px;height: 0px;">รายงานสต๊อกเคลื่อนไหวโรงเชือด ประจำวันที่ {{ $date }}</h2><br><br>
                        <div class="row">
                            <div class="col-12 px-0">
                                <div class="table-responsive">
                                    @php $sum_weight_factory = 0;
                                            $sum_unit_factory = 0; 
                                            $sum_yiled_factory =0;
                                            $count = 1;
                                    @endphp 
                                    {{-- ตัวแปร น้ำหนักรวม ยีลรวม --}}
                                    <table class="tbl table-hover" width="100%" id="report_stock_factory_daaily" border="1">
                                    <thead class="text-center">
                                        <tr>
                                            <th style="padding: 0px; background-color:#75e2e8;" colspan="25">สุกรสาขา (ตัดแต่ง)</th>
                                        </tr>
                                        <tr>
                                            <th style="padding: 0px;" rowspan="2" >ลำดับ</th>
                                            <th style="padding: 0px;" rowspan="2" >Order รับหมู</th>
                                            <th style="padding: 0px;" rowspan="2" >Order เชือด</th>
                                            <th style="padding: 0px;" rowspan="2" >สาขา</th>
                                            <th style="padding: 0px;" rowspan="2" >จำนวนตัว</th>
                                            <th style="padding: 0px;" rowspan="2" >น้ำหนักขุน</th>
                                            <th style="padding: 0px;" rowspan="2" >นน.ซากAB(ก่อนแช่)</th>
                                            <th style="padding: 0px;" rowspan="2" >เฉลี่ย</th>
                                            <th style="padding: 0px;" colspan="4" >หัว </th>
                                            <th style="padding: 0px;" colspan="4" >เครื่องในขาว</th>
                                            <th style="padding: 0px;" colspan="4" >เครื่องในแดง</th>
                                            <th style="padding: 0px;" rowspan="2" >มันปรุง</th>
                                            <th style="padding: 0px;" rowspan="2" >ของเสีย</th>
                                            <th style="padding: 0px;" rowspan="2" >น้ำหนักรวม</th>
                                            <th style="padding: 0px;" rowspan="2" >เฉลี่ย</th>
                                            <th style="padding: 0px;" rowspan="2" >น้ำหนักหาย กก./ตัว</th>
                                        </tr>
                                        <tr>
                                            <th class="text-center" style="padding: 0px;">จำนวน</th>
                                            <th class="text-center" style="padding: 0px;">ชั่งเข้า</th>
                                            <th class="text-center" style="padding: 0px;">ชั่งออก</th>
                                            <th class="text-center" style="padding: 0px;">dift</th>

                                            <th class="text-center" style="padding: 0px;">จำนวน</th>
                                            <th class="text-center" style="padding: 0px;">ชั่งเข้า</th>
                                            <th class="text-center" style="padding: 0px;">ชั่งออก</th>
                                            <th class="text-center" style="padding: 0px;">dift</th>

                                            <th class="text-center" style="padding: 0px;">จำนวน</th>
                                            <th class="text-center" style="padding: 0px;">ชั่งเข้า</th>
                                            <th class="text-center" style="padding: 0px;">ชั่งออก</th>
                                            <th class="text-center" style="padding: 0px;">dift</th>

                                        </tr>
                                    </thead>
                                    @php
                                        $count = 1;
                                    @endphp
                                    <tbody>
                                        
                                        @for ($i = 0; $i < $order_count; $i++)
                                        <tr>
                                            <td class="text-center" style="padding: 0px;">{{ $count++ }}</td>
                                            <td class="text-center" style="padding: 0px;">{{ $order_cus[0][20] }}</td>
                                            <td class="text-center" style="padding: 0px;">{{ $order_cus[$i][0] }}</td>
                                            <td class="text-center" style="padding: 0px;">{{ $order_cus[$i][1] }}</td>
                                            <td class="text-center" style="padding: 0px;">{{ number_format($order_cus[$i][2],0) }}</td>

                                            @if ($i == 0)
                                                <td class="text-center" style="padding: 0px;" rowspan="{{ $order_count }}">{{ number_format($order_cus[$i][3],0) }}</td>   
                                                <td class="text-center" style="padding: 0px;" rowspan="{{ $order_count }}">{{ number_format($order_cus[$i][4],2) }}</td>
                                                <td class="text-center" style="padding: 0px;" rowspan="{{ $order_count }}">{{ number_format($order_cus[$i][5],2) }}</td>  
                                            @else
                                                <td class="text-center" style="padding: 0px;" hidden></td>
                                                <td class="text-center" style="padding: 0px;" hidden></td>
                                                <td class="text-center" style="padding: 0px;" hidden></td>
                                            @endif
      
                                            <td class="text-center" style="padding: 0px;">{{ number_format($order_cus[$i][6],0) }}</td> 
                                            <td class="text-center" style="padding: 0px;">{{ number_format($order_cus[$i][7],2) }}</td>
                                            <td class="text-center" style="padding: 0px;">{{ number_format($order_cus[$i][8],2) }}</td>
                                            <td class="text-center" style="padding: 0px;">{{ number_format($order_cus[$i][7],2)-number_format($order_cus[$i][8],2) }}</td>
                                            <td class="text-center" style="padding: 0px;">{{ number_format($order_cus[$i][9],0) }}</td>
                                            <td class="text-center" style="padding: 0px;">{{ number_format($order_cus[$i][10],2) }}</td>
                                            <td class="text-center" style="padding: 0px;">{{ number_format($order_cus[$i][11],2) }}</td>
                                            <td class="text-center" style="padding: 0px;">{{ number_format($order_cus[$i][10],2)-number_format($order_cus[$i][11],2) }}</td>
                                            <td class="text-center" style="padding: 0px;">{{ number_format($order_cus[$i][12],0) }}</td>
                                            <td class="text-center" style="padding: 0px;">{{ number_format($order_cus[$i][13],2) }}</td>
                                            <td class="text-center" style="padding: 0px;">{{ number_format($order_cus[$i][14],2) }}</td>
                                            <td class="text-center" style="padding: 0px;">{{ number_format($order_cus[$i][13],2)-number_format($order_cus[$i][14],2) }}</td>
                                            <td class="text-center" style="padding: 0px;">{{ $order_cus[$i][15] }}</td>
                                            <td class="text-center" style="padding: 0px;">{{ $order_cus[$i][16] }}</td>

                                            @if ($i == 0)
                                                <td class="text-center" style="padding: 0px;" rowspan="{{ $order_count }}">{{ number_format($order_cus[$i][17],2) }}</td> 
                                                <td class="text-center" style="padding: 0px;" rowspan="{{ $order_count }}">{{ number_format($order_cus[$i][18],2) }}</td>
                                                <td class="text-center" style="padding: 0px;" rowspan="{{ $order_count }}">{{ number_format($order_cus[$i][19],2) }}</td>
                                            @else
                                                <td class="text-center" style="padding: 0px;" hidden></td>
                                                <td class="text-center" style="padding: 0px;" hidden></td>
                                                <td class="text-center" style="padding: 0px;" hidden></td>
                                            @endif
                                        </tr>
                                        @endfor

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
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js') }}"></script>
<script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js') }}"></script>
<script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js') }}"></script>


{{-- <script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js') }}"></script>   --}}
<script src="{{ asset('assets/js/datatables/tableTools.js')}}"></script>

<script src="{{ asset('assets/js/datatables/dataTables.buttons.js')}}"></script>
<script src="{{ asset('assets/js/datatables/buttons.html5.js')}}"></script>
<script src="{{ asset('assets/js/datatables/buttons.print.js')}}"></script>


<script>
    var table1 = $('#report_stock_factory_daaily').DataTable({
        destroy: true,
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: "thead th:not(.noExport)",
                    rows: function (indx, rowData, domElement) {
                        return $(domElement).css("display") != "none";
                    }
                },
                customize: function (xlsx) {
                    var sheet = xlsx.xl.worksheets['sheet1.xml'];
 
                    $('row c[r^="C"]', sheet).attr('s', '2');
                }
 
            },
        ],
        lengthMenu: [[20, 50, 100, -1], [20, 50, 100, "All"]],
        "scrollX": false,
        orderCellsTop: true,
        fixedHeader: true,
        rowReorder: true,
        // processing: true,
        // serverSide: true,
        "order": [],
        "ordering": false,
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


