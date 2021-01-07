@extends('layouts.master')
@section('style')
<style type="text/css">
    .input {
        height: 50%;
        background-color: aqua;
    }

    th,
    td {
        padding: 0px;
    }

    .bodyzoom {
        zoom: 0.9;
    }
</style>

<link rel="stylesheet" href="{{ url('https://cdn.datatables.net/1.10.18/css/dataTables.semanticui.min.css') }}"
    type="text/css" />
{{-- <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" /> --}}
<link rel="stylesheet" href="{{ asset('assets/css/daterangepicker.css')}}">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" />

@endsection
@section('main')
<div class="col-lg-12 grid-margin bodyzoom">
    <div class="card">
        <div class="card-body">
            
            {{ Form::open(['method' => 'post' , 'url' => 'create_order_transfer/confirm_order']) }}
            <div class="row">
                <div class="col-9">
                    @foreach($order_pt as $out_order)
                        <h3 class="text-center">
                            รายงานการโอน <span style="color:red;">{{$out_order->order_number}}</span> ประจำวันที่ {{$out_order->date}} <br>
                            จาก {{$out_order->id_user_customer_from}}                             
                            <i class="fa fa-arrow-right" style="font-size: 25px;margin-right: 0px;padding-left: 20px;padding-top: 20px;padding-right: 20px;"></i>
                            {{$out_order->id_user_customer_to}} <br> หมายเหตุ :   {{$out_order->note}}  
                        </h3>
                        @php
                            $order_date = $out_order->date;
                            $customer_from = $out_order->id_user_customer_from;
                            $customer_to = $out_order->id_user_customer_to;
                        @endphp
                        <input hidden name="id" value="{{$out_order->id}}"/>
                        <input hidden name="date" value="{{$out_order->date}}"/>
                        <input hidden name="order_number" value="{{$out_order->order_number}}"/>
                        <input hidden name="customer_from" value="{{$out_order->id_user_customer_from}}"/>
                        <input hidden name="customer_to" value="{{$out_order->id_user_customer_to}}"/>
                        <input hidden name="type_req" value="{{$out_order->type_request}}"/>
                        <input hidden name="marker" value="{{$out_order->marker}}"/>
                    @endforeach
                
                </div>
                @if (Auth::user()->id_type == 1 || Auth::user()->id_type == 16 )
                    <div class="col-2 text-right">
                        {{-- <a class="btn btn-primary col-8" target="_blank" href="../report_transfer_print/{{ $order_pt[0]->order_number }}" style="margin-bottom: 10px;">
                            <i class="fa fa-print">พิมพ์</i>
                        </a> --}}
                        <button type="submit" class="btn btn-success col-5 text-left" name="status_btn" value="2">
                            <i class="fa fa-check">อนุมัติ</i>
                        </button>
                        <button type="submit" class="btn btn-danger col-5" name="status_btn" value="3" style="padding-left: 8px;"> 
                            <i class="fa fa-check">ไม่อนุมัติ</i>
                        </button><br>
                    </div>
                @elseif($order_pt[0]->status == 1 && (Auth::user()->id_type == 1 || Auth::user()->id_type == 16))
                    <div class="col-2 text-right">
                        <a class="btn btn-success col-12"  onclick="send_line('{{$out_order->order_number}}')"  style="margin-bottom: 10px;">
                            <i class="fa fa-print">ส่งการขออนุมัติ</i>
                        </a>
                    </div>
                @endif
                <div class="col-1 text-right">
                    <a class="btn btn-primary col-12" target="_blank" href="../report_transfer_print/{{ $order_pt[0]->order_number }}" style="margin-bottom: 10px;">
                        <i class="fa fa-print">พิมพ์</i>
                    </a>
                </div>
            </div>
            {{ Form::close() }}
        
            <div class="row">
                <div class="col-12 px-0">

                    <table id="table" class="tbl " width="100%" border="1">
                        <thead>

                            {{-- <tr class="text-center">
                                <th width="40%" style=" padding: 0px;" colspan="9">รายงานการโอน <span style="color:red;">{{$out_order->order_number}}</span> ประจำวันที่ {{$out_order->date}} <br>
                                    จาก {{$out_order->id_user_customer_from}}                             
                                    <i class="fa fa-arrow-right" style="font-size: 25px;margin-right: 0px;padding-left: 20px;padding-top: 20px;padding-right: 20px;"></i>
                                    {{$out_order->id_user_customer_to}} <br> หมายเหตุ :   {{$out_order->note}}  
                                </th> 
                                <th hidden></th>
                                <th hidden></th>  
                                <th hidden></th>  
                                <th hidden></th>  
                                <th hidden></th>  
                                <th hidden></th>  
                                <th hidden></th>  
                                <th hidden></th>    
                                
                            </tr >
                            <tr class="text-center" >
                                <th width="40%" style=" padding: 0px;" colspan="3">รายการa</th>
                                <th width="20%" style=" padding: 0px;" colspan="2">ต้นทางd</th>
                                <th width="20" style=" padding: 0px;"  colspan="2">ปลายทาง</th>
                                <th width="20%" style=" padding: 0px;background-color:#ffbeba;" colspan="2">ผลต่าง (dift)</th>
                                <th hidden></th>
                                <th hidden></th>  
                                <th hidden></th>  
                                <th hidden></th>  
                                <th hidden></th>  
                                
                            </tr> --}}

                            <tr>
                                <td class="text-center" style="padding: 0px;">วันที่</td>
                                <td class="text-center" style="padding: 0px;">ต้นทาง</td>
                                <td class="text-center" style="padding: 0px;">ปลายทาง</td>
                                <td class="text-center" style="padding: 0px;">ลำดับ</td>
                                <td class="text-center" style="padding: 0px;">รหัส item </td>
                                <td class="text-center" style="padding: 0px;">ชื่อ item </td>
                                <td class="text-center" style="padding: 0px;">น้ำหนัก</td>
                                <td class="text-center" style="padding: 0px;">จำนวน</td>
                            
                                <td class="text-center" style="padding: 0px;">น้ำหนัก</td>
                                <td class="text-center" style="padding: 0px;">จำนวน</td>
                                <td class="text-center" style="padding: 0px;background-color:#ffbeba;" >น้ำหนัก</td>
                                <td class="text-center" style="padding: 0px;background-color:#ffbeba;" >จำนวน</td>
                            
                            </tr>
                        </thead>

                        @php
                            foreach ($data_main as $key => $main) {
                                $arrData[$key][0] = $main->item_code;
                                $arrData[$key][1] = $main->item_name;
                                $arrData[$key][2] = 0;
                                $arrData[$key][3] = 0;
                                $arrData[$key][4] = 0;
                                $arrData[$key][5] = 0;
                                $arrData[$key][6] = 0;
                                $arrData[$key][7] = 0;
                            }

                            foreach ($data_main as $m => $main) {
                                foreach ($data_before as $b => $before) {
                                    if ($before->item_code == $main->item_code) {
                                        $arrData[$m][3] = $before->sku_weight;
                                        $arrData[$m][4] = $before->sku_amount;
                                    }
                                } 
                            }

                            foreach ($data_main as $m => $main) {
                                foreach ($data_after as $b => $after) {
                                    if ($after->item_code == $main->item_code) {
                                        $arrData[$m][5] = $after->sku_weight;
                                        $arrData[$m][6] = $after->sku_amount;
                                    }
                                } 
                            }
                        @endphp
                        <tbody>
                            @php $count = 1; @endphp                          
                            @for ($i = 0; $i < count($data_main); $i++)
                                <tr>
                                    <td align="center">{{ $count }}</td>
                                    <td align="center">{{ $order_date }}</td>
                                    <td align="center">{{ $customer_from }}</td>
                                    <td align="center">{{ $customer_to }}</td>
                                    <td align="center">{{ $arrData[$i][0] }}</td>
                                    <td align="center">{{ $arrData[$i][1] }}</td>
                                    {{-- @if ($customer_code != '')
                                        @if ($customer_code[0]->id == $order_pt[0]->id_user_sender )
                                            <td align="center">{{ $arrData[$i][3] }}</td>
                                            <td align="center">{{ $arrData[$i][4] }}</td>
                                            <td align="center">{{ $arrData[$i][5] }}</td>
                                            <td align="center">{{ $arrData[$i][6] }}</td>
                                        @else
                                            @if ($arrData[$i][5] != 0 && $arrData[$i][6] != 0 )
                                                <td align="center">{{ $arrData[$i][3] }}</td>
                                                <td align="center">{{ $arrData[$i][4] }}</td>
                                                <td align="center">{{ $arrData[$i][5] }}</td>
                                                <td align="center">{{ $arrData[$i][6] }}</td>
                                            @else
                                                <td>-</td>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>-</td>
                                            @endif
                                        @endif
                                    @else
                                        <td align="center">{{ $arrData[$i][3] }}</td>
                                        <td align="center">{{ $arrData[$i][4] }}</td>
                                        <td align="center">{{ $arrData[$i][5] }}</td>
                                        <td align="center">{{ $arrData[$i][6] }}</td>
                                    @endif --}}
                                    <td align="center">{{ $arrData[$i][3] }}</td>
                                    <td align="center">{{ $arrData[$i][4] }}</td>
                                    <td align="center">{{ $arrData[$i][5] }}</td>
                                    <td align="center">{{ $arrData[$i][6] }}</td>
                                    <td align="center">{{ number_format($arrData[$i][3] - $arrData[$i][5],2) }}</td>
                                    <td align="center">{{ number_format($arrData[$i][4] - $arrData[$i][6],2) }}</td>
                                </tr>
                                @php $count=$count+1; @endphp 
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>

            <hr>



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
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js') }}"></script>
<script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js') }}"></script>
<script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js') }}"></script>

<script>
  var table = $('#table').DataTable({
        lengthMenu: [[50, -1], [50, "All"]],
        "scrollX": false,
        orderCellsTop: true,
        fixedHeader: true,
        rowReorder: true,
        dom: 'lBfrtip',
        buttons: [
            //'excel',
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
<script>
    function send_line(order_){
        $.ajax({
        url: '{{ asset('send_line') }}/'+order_,
        xhrFields: {
            withCredentials: true
        },
        success: function(response) {
            alert(response);
            // return response;        
        },
        error: function() {
            alert('ไม่สามารถส่งข้อมูลได้');
        }
        });
    }
</script>

@endsection