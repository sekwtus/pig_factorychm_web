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

    <div class="row">
        <div class="col-12 px-0">
            <table id="tbl-3" class="tbl " width="100%" border="1">
                <thead>
                    <tr class="bg-secondary text-center" ><th colspan="11" style=" padding: 0px;"><h3> รายงานการแปรสภาพ
                        <span style="color:red;">
                            {{-- {{ $shop_name2 }} {{ $shop_name =='' ? '' : '('.$shop_name.')' }} --}}
                        ประจำวันที่ {{ $date == '' ? '' : substr($date,0,2).'/'.substr($date,2,2).'/'.substr($date,4,4) }} </span> &nbsp;
                    </h3></th>
                    </tr>
                    <tr class="bg-secondary text-center">
                        <th width="50%" style=" padding: 0px;" colspan="5">ก่อนแปรสภาพ</th>
                        <th width="40%" style=" padding: 0px;" colspan="4">หลังแปรสภาพ</th>
                        <th width="10%" style=" padding: 0px;" colspan="2">ผลต่าง (dift)</th>
                    </tr>
                    <tr>
                        <th class="text-center" style="padding: 0px;">Order ผลิต</th>
                        <th class="text-center" style="padding: 0px;">รหัส item </th>
                        <th class="text-center" style="padding: 0px;">ชื่อ item </th>
                        <th class="text-center" style="padding: 0px;">น้ำหนัก</th>
                        <th class="text-center" style="padding: 0px;">จำนวน</th>
                        {{-- <th class="text-center" style="padding: 0px;">% Yiled จาก นน.ขุน</th> --}}
                        <th class="text-center" style="padding: 0px;">รหัส item </th>
                        <th class="text-center" style="padding: 0px;">ชื่อ item </th>
                        <th class="text-center" style="padding: 0px;">น้ำหนัก</th>
                        <th class="text-center" style="padding: 0px;">จำนวน</th>
                        <th class="text-center" style="padding: 0px;background-color:#ffbeba;">น้ำหนัก</th>
                        <th class="text-center" style="padding: 0px;background-color:#ffbeba;">จำนวน</th>
                    </tr>
                </thead>
                <tbody>

                    @php
                        $sum_all_weight_be = 0;
                        $sum_all_unit_be = 0;
                        $sum_all_weight_af = 0;
                        $sum_all_unit_af = 0;
                        $sum_all_weight_dift = 0;
                        $sum_all_unit_dift = 0;
                        
                        $tmp_department = $order_number[0]->department;
                        
                        $sum_branch_weight_be = 0;
                        $sum_branch_unit_be = 0;
                        $sum_branch_weight_af = 0;
                        $sum_branch_unit_af = 0;
                        $sum_branch_weight_dift = 0;
                        $sum_branch_unit_dift = 0;
                    @endphp

                    @foreach ($order_number as $key1 => $order_)
                        @php
                            $row_num = 0;
                        @endphp

                        @foreach ($row_span as $row_)
                            @php
                                if ($row_->lot_number == $order_->id_ref_order &&  $row_->sum_row > $row_num ) {
                                    $row_num = $row_->sum_row;
                                }
                            @endphp
                        @endforeach

                        @php
                            for ($i=0; $i < $all_row; $i++) { 
                                $arrData[$i][0] = '-';
                                $arrData[$i][1] = '-';
                                $arrData[$i][2] = '-';
                                $arrData[$i][3] = '-';
                                $arrData[$i][4] = '-';
                                $arrData[$i][5] = '-';
                                $arrData[$i][6] = '-';
                                $arrData[$i][7] = '-';
                            }
                            $j = 0;
                            foreach ($data_transform_before as $key => $_before) {
                                if ($_before->lot_number == $order_->id_ref_order) {
                                    $arrData[$j][0] = $_before->sku_code;
                                    $arrData[$j][1] = $_before->item_name;
                                    $arrData[$j][2] = $_before->sku_weight;
                                    $arrData[$j][3] = $_before->sku_amount;
                                    $j++;
                                }
                            }

                            $k = 0;
                            foreach ($data_transform_after as $key => $_after) {
                                if ($_after->lot_number == $order_->id_ref_order) {
                                    $arrData[$k][4] = $_after->sku_code;
                                    $arrData[$k][5] = $_after->item_name;
                                    $arrData[$k][6] = $_after->sku_weight;
                                    $arrData[$k][7] = $_after->sku_amount;
                                    $k++;
                                }
                            }
                            $sum_weight_be = 0;
                            $sum_unit_be = 0;
                            $sum_weight_af = 0;
                            $sum_unit_af = 0;
                        @endphp

                        @if ($row_num == 0)
                            <tr hidden>
                        @else
                            <tr>
                        @endif
                                <td class="text-center" style="padding: 0px;" rowspan="{{ $row_num+1 }}">{{ $order_->id_ref_order }}</td>
                                    <td class="text-center" style="padding: 0px;"hidden></td>
                                        <td class="text-center" style="padding: 0px;"hidden></td>
                                    <td class="text-center" style="padding: 0px;"hidden></td>
                                    <td class="text-center" style="padding: 0px;"hidden></td>
                                    <td class="text-center" style="padding: 0px;"hidden></td>
                                    <td class="text-center" style="padding: 0px;"hidden></td>
                                    <td class="text-center" style="padding: 0px;"hidden></td>
                                    <td class="text-center" style="padding: 0px;"hidden></td>
                                    <td class="text-center" style="padding: 0px;"hidden></td>
                                <td class="text-center" style="padding: 0px;"hidden></td>
                            </tr>

                            @for ($i = 0; $i < $row_num; $i++)
                                <tr>
                                    <td class="text-center" style="padding: 0px;" hidden></td>
                                    <td class="text-center" style="padding: 0px;">{{ $arrData[$i][0] }}</td>
                                    <td class="text-center" style="padding: 0px;">{{ $arrData[$i][1] }}</td>
                                    <td class="text-center" style="padding: 0px;">{{ $arrData[$i][2] }}</td>
                                    <td class="text-center" style="padding: 0px;">{{ $arrData[$i][3] }}</td>

                                    <td class="text-center" style="padding: 0px;">{{ $arrData[$i][4] }}</td>
                                    <td class="text-center" style="padding: 0px;">{{ $arrData[$i][5] }}</td>
                                    <td class="text-center" style="padding: 0px;">{{ $arrData[$i][6] }}</td>
                                    <td class="text-center" style="padding: 0px;">{{ $arrData[$i][7] }}</td>
                                    <td class="text-center" style="padding: 0px; background-color:#808080;"> </td>
                                    <td class="text-center" style="padding: 0px; background-color:#808080;"> </td>
                                </tr>
                                @php
                                    $sum_weight_be = $sum_weight_be + floatval ($arrData[$i][2]);
                                    $sum_unit_be = $sum_unit_be + floatval ($arrData[$i][3]);
                                    $sum_weight_af = $sum_weight_af + floatval ($arrData[$i][6]);
                                    $sum_unit_af = $sum_unit_af + floatval ($arrData[$i][7]);
                                @endphp
                            @endfor

                            @if ($row_num == 0)
                                <tr style=" background-color:#ffbeba;" hidden>
                            @else
                                <tr style=" background-color:#ffe7e6;">
                            @endif
                                <td class="text-center" style="padding: 0px;" hidden></td>

                                <td class="text-center" style="padding: 0px;"></td>
                                <td class="text-center" style="padding: 0px;"></td>
                                <td class="text-center" style="padding: 0px;"></td>
                                <td class="text-center" style="padding: 0px;">{{ $sum_weight_be }}</td>
                                <td class="text-center" style="padding: 0px;">{{ $sum_unit_be }}</td>
                                <td class="text-center" style="padding: 0px;"></td>
                                <td class="text-center" style="padding: 0px;"></td>
                                <td class="text-center" style="padding: 0px;">{{ $sum_weight_af }}</td>
                                <td class="text-center" style="padding: 0px;">{{ $sum_unit_af }}</td>
                                <td class="text-center" style="padding: 0px;">{{ number_format($sum_weight_be - $sum_weight_af,2,'.','') }}</td>
                                <td class="text-center" style="padding: 0px;">{{ $sum_unit_be - $sum_unit_af  }}</td>
                            @php
                                $sum_all_weight_be = $sum_all_weight_be + $sum_weight_be;
                                $sum_all_unit_be = $sum_all_unit_be + $sum_unit_be;
                                $sum_all_weight_af = $sum_all_weight_af + $sum_weight_af;
                                $sum_all_unit_af = $sum_all_unit_af + $sum_unit_af;
                                $sum_all_weight_dift = $sum_all_weight_dift + number_format($sum_weight_be - $sum_weight_af,2,'.','');
                                $sum_all_unit_dift = $sum_all_unit_dift + ($sum_unit_be - $sum_unit_af);

                                $sum_branch_weight_be = $sum_branch_weight_be + $sum_weight_be;
                                $sum_branch_unit_be = $sum_branch_unit_be + $sum_unit_be;
                                $sum_branch_weight_af = $sum_branch_weight_af + $sum_weight_af;
                                $sum_branch_unit_af = $sum_branch_unit_af  + $sum_unit_af;
                                $sum_branch_weight_dift = $sum_branch_weight_dift + number_format($sum_weight_be - $sum_weight_af,2,'.','');
                                $sum_branch_unit_dift = $sum_branch_unit_dift + ($sum_unit_be - $sum_unit_af);
                            @endphp
                            </tr>
                        @if ( !empty($order_number[$key1+1]) )
                            @if ( $order_number[$key1+1]->department != $tmp_department || empty($order_number[$key1+1]->department))
                                <tr class="text-center" style="padding: 0px; background-color:#b7dbff;">
                                    <td class="text-center" style="padding: 0px;" colspan="3"><b> รวม สาขา {{ $order_number[$key1]->location_scale }}</b></td>
                                    <td class="text-center" style="padding: 0px;" >{{ $sum_branch_weight_be }}</td>
                                    <td class="text-center" style="padding: 0px;" >{{ $sum_branch_unit_be }}</td>
                                    <td class="text-center" style="padding: 0px;" ></td>
                                    <td class="text-center" style="padding: 0px;" ></td>
                                    <td class="text-center" style="padding: 0px;" >{{ $sum_branch_weight_af }}</td>
                                    <td class="text-center" style="padding: 0px;" >{{ $sum_branch_unit_af }}</td>
                                    <td class="text-center" style="padding: 0px;" >{{ $sum_branch_weight_dift }}</td>
                                    <td class="text-center" style="padding: 0px;" >{{ $sum_branch_unit_dift }}</td>
                                    <td class="text-center" style="padding: 0px;" hidden ></td>
                                    <td class="text-center" style="padding: 0px;" hidden ></td>
                                    @php
                                        $tmp_department = ( $order_number[$key1+1]->department == '' ? '' :$order_number[$key1+1]->department );
                                        $sum_branch_weight_be = 0;
                                        $sum_branch_unit_be = 0;
                                        $sum_branch_weight_af = 0;
                                        $sum_branch_unit_af = 0;
                                        $sum_branch_weight_dift = 0;
                                        $sum_branch_unit_dift = 0;
                                    @endphp
                                </tr>
                            @endif
                        @else
                            <tr class="text-center" style="padding: 0px; background-color:#b7dbff;">
                                <td class="text-center" style="padding: 0px;" colspan="3"><b> รวม สาขา {{ $order_number[$key1]->location_scale }} </b></td>
                                <td class="text-center" style="padding: 0px;" >{{ $sum_branch_weight_be }}</td>
                                <td class="text-center" style="padding: 0px;" >{{ $sum_branch_unit_be }}</td>
                                <td class="text-center" style="padding: 0px;" ></td>
                                <td class="text-center" style="padding: 0px;" ></td>
                                <td class="text-center" style="padding: 0px;" >{{ $sum_branch_weight_af }}</td>
                                <td class="text-center" style="padding: 0px;" >{{ $sum_branch_unit_af }}</td>
                                <td class="text-center" style="padding: 0px;" >{{ $sum_branch_weight_dift }}</td>
                                <td class="text-center" style="padding: 0px;" >{{ $sum_branch_unit_dift }}</td>
                                <td class="text-center" style="padding: 0px;" hidden ></td>
                                <td class="text-center" style="padding: 0px;" hidden ></td>
                            </tr>
                        @endif

                    @endforeach

                    <tr style=" background-color:#ff453c;">
                        <td class="text-center" style="padding: 0px;" hidden></td>

                        <td class="text-center" style="padding: 0px;" colspan="3"><b> รวมทั้งหมด</b></td>
                        <td class="text-center" style="padding: 0px;" hidden></td>
                        <td class="text-center" style="padding: 0px;" hidden></td>
                        <td class="text-center" style="padding: 0px;">{{ $sum_all_weight_be }}</td>
                        <td class="text-center" style="padding: 0px;">{{ $sum_all_unit_be }}</td>
                        <td class="text-center" style="padding: 0px;"></td>
                        <td class="text-center" style="padding: 0px;"></td>
                        <td class="text-center" style="padding: 0px;">{{ $sum_all_weight_af }}</td>
                        <td class="text-center" style="padding: 0px;">{{ $sum_all_unit_af }}</td>
                        <td class="text-center" style="padding: 0px;">{{ $sum_all_weight_dift }}</td>
                        <td class="text-center" style="padding: 0px;">{{ $sum_all_unit_dift }}</td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>

</div>
</div>
</div>


@endsection

@section('script')
{{-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script> --}}
<script src="{{ asset('https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js') }}"></script>
<script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js') }}"></script>
<script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js') }}"></script>

    <script>
            var table = $('#tbl-3').DataTable({
                lengthMenu: [[200, -1], [200, "All"]],
                "scrollX": false,
                orderCellsTop: true,
                fixedHeader: true,
                rowReorder: true,
                dom: 'lBfrtip',
                buttons: [
                    // 'excel',
                    {
                        extend: 'excel',
                    },
                    //  'pdf', 'print'
                ],
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


<script type="text/javascript">
    function save_weight(order_number){
        var weight_ = $("#weight_").val();
        
        $('#edit_weight').modal('hide');
        
        $.ajax({
            type: 'GET',
            dataType: 'JSON',
            url: '{{ url('compare/edit_weight_recieve') }}',
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


