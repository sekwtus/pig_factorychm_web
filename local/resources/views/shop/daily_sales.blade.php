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
<link rel="stylesheet" href="{{ asset('assets/css/daterangepicker.css')}}">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" />

@endsection
@section('main')
            <div class="col-lg-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        {{ Form::open(['method' => 'post' , 'url' => '/shop/specail_order/request']) }}
                            <div class="forms-sample form-control" style="height: auto;padding-right: 20px;">
                                <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;">น้ำหนักที่ขายได้ของร้านต่อวัน ประจำวันที่ {{ $date_show }}</div>
                                    <div class="row" style="margin-bottom: 10px;">
                                        <div class="col-md-3 pr-md-0">
                                            <label for="shop_name">สาขา</label>
                                            <select name="shop_code" class="form-control form-control-sm" id="shop_code">
                                                @foreach ($shop_list as $shop)
                                                    <option value="{{ $shop->shop_code }}">{{ $shop->shop_name }}</option>
                                                @endforeach
                                            </select>
                                            {{-- <input type="text" class="form-control form-control-sm" id="shop_name" name="shop_name" placeholder="สาขา" value="{{ Auth::user()->branch_name }}" readonly>  --}}
                                        </div>
                                    </div>

                                    <div class="row" style="margin-bottom: 10px;">
                                            <div class="table-responsive " style="padding: 15px; ">
                                            <table  class="tbl table-hover " width="100%" border="1" id="report_shop">
                                                <thead class="text-center ">
                                                <tr style="background-color:#7dbeff" >
                                                    <th style="padding: 0px;" colspan="6">รายการสั่งเพิ่ม-ลด</th>
                                                </tr>
                                                <tr style="background-color:#7dbeff" >
                                                    <th style="padding: 0px;">รหัส item</th>
                                                    <th style="padding: 0px;">รายการ</th>
                                                    <th style="padding: 0px;">Yiled</th>
                                                    <th style="padding: 0px;">ลด</th>
                                                    <th style="padding: 0px;">เพิ่ม</th>
                                                    <th style="padding: 0px;">น้ำหนักขาย</th>
                                                </tr>
                                                </thead>
                                                <tbody class="text-center ">
                                                    @php
                                                        $item = ['เนื้อสันคอ','เนื้อหัวไหล่','สามชั้น','สันนอก','เนื้อสะโพก'];
                                                        $item_code = ['1002','1003','1005','1009','1012'];
                                                        $yield = ['3.51','7.02','8.82','3.51','12.92'];
                                                    @endphp
                                                    @for ($i = 0; $i < count($item); $i++) 
                                                    
                                                    <tr>
                                                        <td width="20%" style="padding: 0px; height: 20px;" class="text-center">{{ $item_code[$i] }}</td>
                                                        <td width="15%" style="padding: 0px; height: 20px;" class="text-center">{{ $item[$i] }}</td>
                                                        <td width="15%" style="padding: 0px; height: 20px;" class="text-center">{{ $yield[$i] }}</td>
                                                       
                                                        @if ($i == 0)
                                                        <td width="15%" style="padding: 0px; height: 20px;" class="text-center">
                                                            <input type="number" class="form-control form-control-sm" id="number_of_pig" name="number_of_pig_decrease[{{$i}}]" style="padding: 0px; width: auto; height: 27px;" onchange="decrease(this.val())" value="0" required> </td>
                                                        <td width="15%" style="padding: 0px; " class="text-center">
                                                            <input type="number" class="form-control form-control-sm" id="number_of_pig" name="number_of_pig_increase[{{$i}}]" style="padding: 0px; width: auto; height: 27px;" value="0" required> </td>
                                                        <td width="20%" style="padding: 0px; height: 20px;" class="text-center"></td>
                                                        @else
                                                        <td width="15%" style="padding: 0px; height: 20px;" class="text-center">
                                                            <input type="number" class="form-control form-control-sm" id="number_of_pig" name="number_of_pig_decrease[{{$i}}]" style="padding: 0px; width: auto; height: 27px;" readonly required> </td>
                                                        <td width="15%" style="padding: 0px; height: 20px;" class="text-center">
                                                            <input type="number" class="form-control form-control-sm" id="number_of_pig" name="number_of_pig_increase[{{$i}}]" style="padding: 0px; width: auto; height: 27px;" readonly required> </td>
                                                        <td width="20%" style="padding: 0px; height: 20px;" class="text-center"></td>
                                                        @endif
                                                            
                                                    </tr>
                                                    <tr style="background-color:#ffaeae">
                                                        <td width="20%" style="padding: 0px; height: 20px;" class="text-center"></td>
                                                        <td width="15%" style="padding: 0px; height: 20px;" class="text-center"></td>
                                                        <td width="15%" style="padding: 0px; height: 20px;" class="text-center"></td>
                                                        <td width="15%" style="padding: 0px; height: 20px;" class="text-center">0</td>
                                                        <td width="15%" style="padding: 0px; height: 20px;" class="text-center">0 </td>
                                                        <td width="20%" style="padding: 0px; height: 20px;" class="text-center">0</td>
                                                    </tr>
                                                    @endfor
                                                
                                                </tbody>
                                            </table>
                                            </div>
                                    </div>

                                    <br><br>

                                    <div class="table-responsive">
                                        <table  class="tbl table-hover " width="100%" border="1" id="report_shop">
                                            <thead class="text-center ">
                                            <tr style="background-color:#7dbeff" >
                                                <th style="padding: 0px;" colspan="2">ชิ้นส่วน</th>
                                                <th style="padding: 0px;" colspan="{{ count($shop_list) }}">น้ำหนักที่ขายได้ของร้านต่อวัน (กก.)</th>
                                                <th style="padding: 0px;" rowspan="2">น้ำหนักรวม</th>
                                            </tr>
                                            <tr style="background-color:#7dbeff" >
                                                <th style="padding: 0px;">รหัส</th>
                                                <th style="padding: 0px;">รายการ</th>

                                                @foreach ($shop_list as $shop)
                                                    <th style="padding: 0px;">{{ $shop->marker }}</th>
                                                @endforeach
                                                
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($item_list as $item)

                                                    {{-- น้ำหนักdefualt 0 --}}
                                                    @for ($i = 0; $i < count($shop_list); $i++)
                                                        @php
                                                            $check_exist_data2[$i] = 0;
                                                            $shops[$i] = $shop_list[$i]->shop_code;
                                                            $sum = 0;
                                                            $sum_percent = 0;
                                                        @endphp
                                                    @endfor
                                                    <tr>
                                                        <td style="padding: 0px; height: 20px;" class="text-center"> {{ $item->item_code }}</td>
                                                        <td style="padding: 0px; height: 20px;" class="text-center"> {{ $item->item_name }}</td>

                                                        {{-- เก็บค่าแทน0 --}}
                                                        @foreach ($weight_daily as $weight)
                                                            @if ($weight->item_code == $item->item_code)

                                                                @foreach ($shop_list as $key => $shop)
                                                                    @if ($weight->marker == $shop->marker)
                                                                        @php
                                                                            $check_exist_data2[$key] = $weight->weight_number;
                                                                        @endphp
                                                                    @endif
                                                                @endforeach

                                                            @endif 
                                                        @endforeach

                                                    
                                                        @for ($i = 0; $i < count($shop_list); $i++)
                                                        <td style="padding: 0px; height: 20px;" class="text-center"> {{ $check_exist_data2[$i] }}</td>
                                                            @php
                                                                $sum = $sum + $check_exist_data2[$i];
                                                            @endphp
                                                        @endfor
                                                        <td style="padding: 0px; height: 20px;" class="text-center"> {{ $sum }}</td>
                                                    </tr>

                                                    <tr style="background-color:#edfd80">
                                                        <td style="padding: 0px; height: 20px;" class="text-center"></td>
                                                        <td style="padding: 0px; height: 20px;" class="text-center"></td>
                                                        @for ($i = 0; $i < count($shop_list); $i++)
                                                            <td style="padding: 0px; height: 20px;" class="text-center"> {{ number_format( ($check_exist_data2[$i] == 0 ? 0 :($check_exist_data2[$i]*100)/$sum)  , 2, '.', '') }}</td>
                                                            @php
                                                                $sum_percent = $sum_percent + ($check_exist_data2[$i] == 0 ? 0 :($check_exist_data2[$i]*100)/$sum);
                                                            @endphp
                                                        @endfor
                                                        <td style="padding: 0px; height: 20px;" class="text-center">{{ $sum_percent }}</td>
                                                    </tr>

                                                @endforeach
                                            </tbody>
                                        </table>
                                        {{-- <div class="text-center" style="padding-top: 10px;">
                                            <button type="submit" class="btn btn-success mr-2">ยืนยัน</button>
                                        </div> --}}
                                    </div>

                            </div>
                        {{ Form::close() }}


 
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
        var table = $('#report_shop_unique').DataTable({
            lengthMenu: [[50, -1], [50, "All"]],
            "scrollX": false,
            orderCellsTop: true,
            fixedHeader: true,
            rowReorder: true,
            // processing: true,
            // serverSide: true,
            "order": [],
        });
        table.on( 'order.dt search.dt', function () {
            table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();
</script>


{{-- daterange --}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script>
   
    var date = new Date();
    
    $('#datepicker1').daterangepicker({
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-danger',
        cancelClass: 'btn-inverse',
        singleDatePicker: true,
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


