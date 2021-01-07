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
                                            <th style="padding: 0px; background-color:#f2b0b7;" colspan="22">สุกรลูกค้า (ส่งแบบซาก)</th>
                                        </tr>
                                        <tr>
                                            <th style="padding: 0px; " rowspan="2" >ลำดับ</th>
                                            <th style="padding: 0px;" rowspan="2" >เลขที่ Order</th>
                                            <th style="padding: 0px;" rowspan="2" >ลูกค้า</th>
                                            <th style="padding: 0px;" rowspan="2" >จำนวนตัว</th>
                                            <th style="padding: 0px;" rowspan="2" >นำหนัก</th>
                                            <th style="padding: 0px;" rowspan="2" >นน.ซากAB(ก่อนแช่)</th>
                                            <th style="padding: 0px;" rowspan="2" >เฉลี่ย</th>
                                            <th style="padding: 0px;" colspan="2" >หัว </th>
                                            <th style="padding: 0px;" rowspan="2" >เฉลี่ย</th>
                                            <th style="padding: 0px;" colspan="2">เครื่องในขาว</th>
                                            <th style="padding: 0px;" rowspan="2" >เฉลี่ย</th>
                                            <th style="padding: 0px;" colspan="2" >เครื่องในแดง</th>
                                            <th style="padding: 0px;" rowspan="2" >เฉลี่ย</th>
                                            <th style="padding: 0px;" rowspan="2" >รวมซากก่อน</th>
                                            <th style="padding: 0px;" colspan="2" >นน.ซากAB(หลังแช่)</th>
                                            <th style="padding: 0px;" rowspan="2" >เฉลี่ย</th>
                                            <th style="padding: 0px;" rowspan="2" >เชือดหาย</th>
                                            <th style="padding: 0px;" rowspan="2" >น้ำหนักหาย กก./ตัว</th>
                                        </tr>
                                        <tr>
                                            <th class="text-center" style="padding: 0px;">จำนวน</th>
                                            <th class="text-center" style="padding: 0px;">น้ำหนัก</th>
                                            <th class="text-center" style="padding: 0px;">จำนวน</th>
                                            <th class="text-center" style="padding: 0px;">น้ำหนัก</th>
                                            <th class="text-center" style="padding: 0px;">จำนวน</th>
                                            <th class="text-center" style="padding: 0px;">น้ำหนัก</th>
                                            <th class="text-center" style="padding: 0px;">จำนวน</th>
                                            <th class="text-center" style="padding: 0px;">น้ำหนัก</th>

                                        </tr>
                                    </thead>
                                    @php
                                        $count = 1;
                                    @endphp
                                    <tbody>
                                        
                                        @for ($i = 0; $i < $order_count; $i++)
                                        <tr>
                                            <td class="text-center" style="padding: 0px;">{{ $count++ }}</td>
                                            <td class="text-center" style="padding: 0px;">{{ $order_cus[$i][0] }}</td>
                                            <td class="text-center" style="padding: 0px;">{{ $order_cus[$i][1] }}</td>
                                            <td class="text-center" style="padding: 0px;">{{ number_format($order_cus[$i][2],0) }}</td>
                                            <td class="text-center" style="padding: 0px;">{{ number_format($order_cus[$i][3],0) }}</td>
                                            <td class="text-center" style="padding: 0px;">
                                                <a data-toggle="modal" data-target="#edit_weight" href="#" 
                                                onclick="edit_weight_side('{{ $order_cus[$i][0] }}','{{ number_format($order_cus[$i][4],2) }}')">
                                                {{ number_format($order_cus[$i][4],2) }}</a>
                                            </td>
                                            <td class="text-center" style="padding: 0px;">{{ number_format($order_cus[$i][5],2) }}</td>        
                                            <td class="text-center" style="padding: 0px;">{{ number_format($order_cus[$i][6],0) }}</td> 
                                            <td class="text-center" style="padding: 0px;">{{ number_format($order_cus[$i][7],2) }}</td>
                                            <td class="text-center" style="padding: 0px;">{{ number_format($order_cus[$i][8],2) }}</td>
                                            <td class="text-center" style="padding: 0px;">{{ number_format($order_cus[$i][9],0) }}</td>
                                            <td class="text-center" style="padding: 0px;">{{ number_format($order_cus[$i][10],2) }}</td>
                                            <td class="text-center" style="padding: 0px;">{{ number_format($order_cus[$i][11],2) }}</td>
                                            <td class="text-center" style="padding: 0px;">{{ number_format($order_cus[$i][12],0) }}</td>
                                            <td class="text-center" style="padding: 0px;">{{ number_format($order_cus[$i][13],2) }}</td>
                                            <td class="text-center" style="padding: 0px;">{{ number_format($order_cus[$i][14],2) }}</td>
                                            <td class="text-center" style="padding: 0px;">{{ $order_cus[$i][15] }}</td>
                                            <td class="text-center" style="padding: 0px;">{{ number_format($order_cus[$i][16],0) }}</td>
                                            <td class="text-center" style="padding: 0px;">{{ number_format($order_cus[$i][17],2) }}</td>
                                            <td class="text-center" style="padding: 0px;">{{ number_format($order_cus[$i][18],2) }}</td>
                                            <td class="text-center" style="padding: 0px;">{{ number_format($order_cus[$i][19],2) }}</td>
                                            <td class="text-center" style="padding: 0px;">{{ number_format($order_cus[$i][20],2) }}</td>
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


                <div class="modal fade" id="edit_weight" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="forms-sample form-control" style="height: auto;padding-right: 20px;" id="data_weight">
                               
                            </div>
                        </div>
                    </div>
                </div>

@endsection

@section('script')
{{-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script> --}}
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
<script>
    function edit_weight_side(order_number,weight){
        var sign = "'";
        $('#data_weight').html('<div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;">นน.ซากAB(ก่อนแช่). '+order_number+'</div\
            <div class="row" style="margin-bottom: 10px;">\
                <div class="col-md-12 pr-md-0">\
                    <input type="text" class="form-control form-control-sm" id="weight_" name="weight_"  value="'+weight+'" required>\
                </div>\
            </div>\
            <div class="text-center" style="padding-top: 10px;">\
                <button type="submit" class="btn btn-success mr-2" id="comfirmAdd" onclick="save_weight('+sign+order_number+sign+')" name="order_number" value="'+order_number+'">ยืนยัน</button>\
            </div>');
    }

   
</script>

<script type="text/javascript">
    function save_weight(order_number){
        var weight_ = $("#weight_").val();
        
        $('#edit_weight').modal('hide');
        
        $.ajax({
            type: 'GET',
            dataType: 'JSON',
            url: '{{ url('order_customer/edit_weight_side') }}',
            data: {order_number:order_number,weight_:weight_},
            beforeSend: function(){
                $('.ajax-loader').css("visibility", "visible");
            },
            success: function (msg) {
                if (msg === 0) {
                    alert('แก้ไขสำเร็จ');
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert("Status: " + textStatus); alert("Error: " + errorThrown);
            },
            complete: function(){
                location.reload();
            },
        });
    }
</script>


@endsection


