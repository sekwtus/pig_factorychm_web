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
    .increase {
        background-color: #a6ffa6 !important;
    }
    .decrease {
        background-color: #ff8080 !important;
    }
    .table-hover tbody tr:hover {
        background-color: #ff625869;
    }
    .outer{
    overflow-y: auto;
    height:550px;
    }

    .outer table{
        width: 100%;
        /* table-layout: fixed;  */
        /* border : 1px solid black; */
        border-spacing: 1px;
    }

    .outer table th {
        top:0;
        /* border : 1px solid black; */
        position: sticky;
    }
    
</style>

<link rel="stylesheet" href="{{ url('https://cdn.datatables.net/1.10.18/css/dataTables.semanticui.min.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/css/daterangepicker.css')}}">

@endsection
@section('main')
  <div class="col-lg-12 grid-margin">

        <div class="ajax-loader">
            <img src="{{ asset('assets/images/pig_fly.gif')}}" alt="" style="margin-left: 0px;top: 3%;width: 350px; left:37%;" class="img-responsive"  />
        </div>

      <div class="card">
          <div class="card-body">
            <h1 align="center" >รายงาน รับสุกร / Line เชือด</h1>

                {{-- <div class="table-responsive">
                  <table  class="table table-bordered" border="1" width="100%">
                    <thead>
                      <tr bgcolor= "#f6f6ee" >
                        <th class="text-center" rowspan="2" style="padding-bottom: 0px;" >ขั้นตอนการทำงาน </th>
                        <th rowspan="2" class="text-center" style="padding-bottom: 0px;" >หมายเลขใบงาน/Bill </th>
                        <th rowspan="2" class="text-center" style="padding-bottom: 0px;" >รหัสสินค้า</th>
                        <th rowspan="2" class="text-center" style="padding-bottom: 0px;" >รายการสินค้า</th>
                        <th rowspan="2" class="text-center" style="padding-bottom: 0px;" >ที่จัดเก็บ</th>
                        <th rowspan="2" class="text-center" style="padding-bottom: 0px;" >หน่วยนับ</th>
                        <th colspan="2" class="text-center" style="padding-bottom: 0px;" >ยกมา</th>
                        <th rowspan="2" class="text-center" style="padding-bottom: 0px;" >เฉลี่ย</th>
                        <th colspan="2" class="text-center" style="padding-bottom: 0px;" >เข้า</th>
                        <th rowspan="2" class="text-center" style="padding-bottom: 0px;" >เฉลี่ย</th>
                        <th colspan="2" class="text-center" style="padding-bottom: 0px;" >ออก</th>
                        <th rowspan="2" class="text-center" style="padding-bottom: 0px;" >เฉลี่ย</th>
                        <th colspan="2" class="text-center" style="padding-bottom: 0px;" >ผลต่าง</th>
                        <th rowspan="2" class="text-center" style="padding-bottom: 0px;" >% สูญเสีย</th>
                      </tr>
                      <tr bgcolor = "#f6f6ee" >
                        <th class="text-center" style="padding-bottom: 0px;" >จำนวน</th>
                        <th class="text-center" style="padding-bottom: 0px;" >น้ำหนัก(Kg.)</th>
                        <th class="text-center" style="padding-bottom: 0px;" >จำนวน</th>
                        <th class="text-center" style="padding-bottom: 0px;" >น้ำหนัก(Kg.)</th>
                        <th class="text-center" style="padding-bottom: 0px;" >จำนวน</th>
                        <th class="text-center" style="padding-bottom: 0px;" >น้ำหนัก(Kg.)</th>
                        <th class="text-center" style="padding-bottom: 0px;" >จำนวน</th>
                        <th class="text-center" style="padding-bottom: 0px;" >น้ำหนัก(Kg.)</th>
                      </tr>
                    </thead>
                    <tbody>

                      @php
                          // ! variable !
                          $sum_r_weight=0;
                          $sum_r_unit=0;
                          $avg_r_weight=0;
                          $pig_use_all = 0;
                          $avg_weight = 0;
                      @endphp

                      @foreach ($balance as $bal)
                        <tr>
                          <td><b>คอกสุกร</b></td>
                          <td>ยอดยกมา</td>
                          <td></td>
                          <td></td>
                          <td>{{ $bal->name_storage }}</td>
                          <td>ตัว</td>
                          <td>{{ number_format($bal->balance,0,'.',',') }}</td>
                          <td>{{ number_format($bal->weight_summary,2,'.',',') }}</td>
                          <td class="text-center" style="padding: 0px;">{{ number_format( $bal->weight_summary / $bal->balance ,2,'.','') }}</td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                        </tr>
                      @endforeach

                      @foreach ($stock_recieve as $st_rec)
                        <tr>
                          <td><b>คอกสุกร</b></td>
                          <td>{{ $st_rec->bill_number }}</td>
                          <td></td>
                          <td>{{ $st_rec->ref_source }}</td>
                          <td>{{ $st_rec->shop_name }}</td>
                          <td>ตัว</td>
                          <td>{{ number_format($st_rec->total_unit,0,'.',',') }}</td>
                          <td>{{ number_format($st_rec->total_weight,2,'.',',') }}</td>
                          <td class="text-center" style="padding: 0px;">{{ number_format( $st_rec->total_weight / $st_rec->total_unit ,2,'.','') }}</td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                        </tr>
                      @endforeach

                      @foreach ($r_data_list as $r_list)
                        <tr>
                          <td rowspan="2" ><b>คอกสุกร</b></td>
                          <td rowspan="2">
                            <a target="_blank" href="../summary_weighing_receive/{{ $r_list->lot_number }}">{{ $r_list->lot_number }}</a>
                          </td>
                          <td>{{ $r_list->marker }}</td>
                          <td>{{ $r_list->id_user_customer }}</td>
                          <td>{{ $r_list->name_storage }}</td>
                          <td>ตัว</td>

                          @if ($r_list->weighing_date != $date_format)
                                @php
                                    $sum_r_weight =  $sum_r_weight +  $r_list->sum_weight ;
                                    $sum_r_unit   =  $sum_r_unit +    $r_list->sum_unit   ;
                                    $pig_use_all  =  $r_list->pig_use1+$r_list->pig_use2+$r_list->pig_use3+$r_list->pig_use4+$r_list->pig_use5;  
                                @endphp
                            <td class="text-center" style="padding: 0px;">{{ $r_list->sum_unit - $pig_use_all }}</td>
                            <td class="text-center" style="padding: 0px;">{{ number_format($r_list->sum_weight,2,'.',',') }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                          @else
                            <td></td>
                            <td></td>
                            <td></td>
                            @php
                                    $sum_r_weight =  $sum_r_weight +  $r_list->sum_weight ;
                                    $sum_r_unit   =  $sum_r_unit +    $r_list->sum_unit   ;
                                    $pig_use_all  =  $r_list->pig_use1+$r_list->pig_use2+$r_list->pig_use3+$r_list->pig_use4+$r_list->pig_use5;  
                                @endphp
                            <td class="text-center" style="padding: 0px;">{{ $r_list->sum_unit - $pig_use_all }}</td>
                            <td class="text-center" style="padding: 0px;">{{ number_format($r_list->sum_weight,2,'.',',') }}</td>
                            <td class="text-center" style="padding: 0px;">{{ number_format($r_list->sum_weight/$r_list->sum_unit,2,'.','') }}</td>
                          @endif

                            @php
                                $avg_weight = number_format($r_list->sum_weight/$r_list->sum_unit,2,'.','');
                            @endphp

                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                        </tr>

                        <tr>
                          <td hidden><b>คอกสุกร</b></td>
                          <td hidden>
                            <a target="_blank" href="../summary_weighing_receive/{{ $r_list->lot_number }}">{{ $r_list->lot_number }}</a>
                          </td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td class="text-center" style="padding: 0px;">{{ $r_list->pig_use }}</td>
                          <td class="text-center" style="padding: 0px;">{{ number_format($r_list->pig_use * $avg_weight,2,'.','') }}</td>
                          <td class="text-center" style="padding: 0px;">{{ number_format($avg_weight,2,'.',',') }}</td>
                          <td class="text-center" style="padding: 0px;">{{ ($r_list->sum_unit - $pig_use_all) - $r_list->pig_use }}</td>
                          <td></td>
                          <td></td>
                        </tr>

                      @endforeach
                    
                  </tbody></table>
                </div> --}}

            <div>
                <div class="table-responsive">
                    <div class="outer">
                        <table class="table table-striped table-bordered nowrap table-hover" width="100%" id="stockOrder">
                            <thead class="text-center">
                                <tr>
                                    <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #D0D0D0;" rowspan="2">ขั้นตอนการทำงาน</th>
                                    <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #D0D0D0;" colspan="2">รายการ</th>
                                    <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #D0D0D0;" rowspan="2">รหัสสินค้า</th>
                                    <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #D0D0D0;" rowspan="2">รายการสินค้า</th>
                                    <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #D0D0D0;" rowspan="2">ที่จัดเก็บ</th>
                                    <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #D0D0D0;" rowspan="2">หน่วยนับ</th>
                                    <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #D0D0D0;" colspan="3" rowspan="1">ยกมา</th>
                                    <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #D0D0D0;" colspan="3" rowspan="1">เข้า</th>
                                    <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #D0D0D0;" colspan="3" rowspan="1">ออก</th>
                                    <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #D0D0D0;" colspan="3" rowspan="1">ผลต่าง</th>
                                    <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #D0D0D0;" rowspan="2">% สูญเสีย</th>
                                </tr>
                                <tr>
                                    <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #D0D0D0; top:35.2px;">หมายเลขใบงาน/Bill</th>
                                    <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #D0D0D0; top:35.2px;">ลูกค้า</th>
                                    <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #D0D0D0; top:35.2px;">จำนวน</th>
                                    <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #D0D0D0; top:35.2px;">น้ำหนัก(Kg.)</th>
                                    <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #D0D0D0; top:35.2px;">เฉลี่ย</th>
                                    <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #D0D0D0; top:35.2px;">จำนวน</th>
                                    <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #D0D0D0; top:35.2px;">น้ำหนัก(Kg.)</th>
                                    <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #D0D0D0; top:35.2px;">เฉลี่ย</th>
                                    <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #D0D0D0; top:35.2px;">จำนวน</th>
                                    <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #D0D0D0; top:35.2px;">น้ำหนัก(Kg.)</th>
                                    <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #D0D0D0; top:35.2px;">เฉลี่ย</th>
                                    <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #D0D0D0; top:35.2px;">จำนวน</th>
                                    <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #D0D0D0; top:35.2px;">น้ำหนัก(Kg.)</th>
                                    <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #D0D0D0; top:35.2px;">เฉลี่ย</th>
                                  </tr>
                            </thead>
                            <tbody id="rowStockOrder" class=text-center>
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
{{-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script> --}}
<script src="{{ asset('https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js') }}"></script>
<script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js') }}"></script>
<script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js') }}"></script>
{{-- <script src="{{ asset('https://cdn.datatables.net/fixedheader/3.1.6/js/dataTables.fixedHeader.min.js') }}"></script> --}}




<script>
    $(document).ready(function(){
        var date_format = '{{ $date_format }} - {{ $date_format }}';
        dataStockOrder(date_format);
        // stockHistorySend($("#daterangeOrderSend").val());
    });

    function search_receive(){
        var table = $('#stockOrder').DataTable();
        table.destroy();//ลบdatatableเก่าทิ้ง
        dataStockOrder('11/07/2020 - 11/07/2020'); //get value ใหม่ แล้วสร้างdatatableใหม่
    }
    // function search_Order_send(){
    //     stockHistorySend($("#daterangeOrderSend").val());
    // }

    
</script>

<script>
  
    function dataStockOrder(daterangeFilter){
        $.ajax({
            type: 'GET',
            dataType: 'JSON',
            url: '{{ url('stock_pp1_receive') }}',
            data: {daterangeFilter:daterangeFilter},
            beforeSend: function(){
                $('.ajax-loader').css("visibility", "visible");
            },
            success: function (data) {
                
                var balance = (data[3].length == 0 ? 0 : data[3][0].balance);
                var row = '';
                var count_row = 1;
                var sign = "'";

                var balance_weight = 0;
                var balance_weight = (data[3].length == 0 ? 0 : data[3][0].weight_summary);

                var sum_receive_unit = 0;
                var sum_receive_weight = 0;

                var sum_receive_unit2 = 0;
                var sum_receive_unit2_real = 0;
                var sum_receive_weight2 = 0;
                var count_amount2 = 0;

                var sum_receive_unit3 = 0;
                var sum_receive_unit3_real = 0;
                var sum_receive_weight3 = 0;
                var count_amount3 = 0;
                var date_ = '';
                    console.log(data);
                row = row +  '<tr style="background-color:#dffdff;">\
                                    <td><b>ยอดยกมา</td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td class="text-center" id="balance_without_today">'+balance+'</td>\
                                    <td class="text-center" id="balance_without_today">'+balance_weight+'</td>\
                                    <td class="text-center" id="balance_without_today">'+(balance_weight / balance).toFixed(2)+'</td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                </tr>';

                data[0].forEach(element => {
                    var sign = "'";
                    var created_at = (element.created_at).substr(0,10);
                    row = row + '<tr>\
                                    <td>คอกสุกร</td>\
                                    <td class="text-left">'+element.bill_number+'</td>\
                                    <td class="text-center">'+element.ref_source+'</td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td>'+element.item_code+'</td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td class="text-center">'+element.total_unit+'</td>\
                                    <td class="text-center">'+element.total_weight+'</td>\
                                    <td>'+(element.total_weight / element.total_unit).toFixed(2)+'</td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                </tr>';
                    sum_receive_unit=sum_receive_unit+element.total_unit;
                    sum_receive_weight=sum_receive_weight+element.total_weight;
                });

                data[1].forEach(element => {
                    row = row + '<tr>\
                        <td>เชือด</td>\
                                    <td class="text-left"><a target="blank_" href="../summary_weighing_receive/'+element.order_number+'">'+element.order_number+'</a></td>\
                                    <td class="text-center">'+element.id_user_customer+'</td>\
                                    <td></td>\
                                    <td>'+element.order_type+'</td>\
                                    <td></td>\
                                    <td>ตัว</td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td class="text-center">'+(element.count_amount == null || element.count_amount == '' || element.count_amount == 'null' ? '':element.count_amount)+'</td>\
                                    <td class="text-center">'+(element.sum_weight == null || element.sum_weight == '' || element.sum_weight == 'null' ? '':element.sum_weight)+'</td>\
                                    <td class="text-center">'+( (element.sum_weight == null || element.sum_weight == '' || element.sum_weight == 'null' ? '':element.sum_weight) / (element.count_amount == null || element.count_amount == '' || element.count_amount == 'null' ? '':element.count_amount) ).toFixed(2)+'</td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                </tr>';
                    sum_receive_unit2=sum_receive_unit2+element.total_pig;
                    sum_receive_weight2=sum_receive_weight2+parseFloat(element.sum_weight == null || element.sum_weight == '' || element.sum_weight == 'null' ? '0':element.sum_weight);
                    count_amount2=count_amount2+element.count_amount;
                    sum_receive_unit2_real = sum_receive_unit2_real+element.count_amount;
                });
                data[4].forEach(element => {
                    row = row + '<tr>\
                                    <td>คอกสุกร</td>\
                                    <td class="text-left"><a target="blank_" href="../summary_weighing_receive/'+element.bill_number+'">'+element.bill_number+'</a></td>\
                                    <td class="text-center">'+element.ref_source+'</td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td>ตัว</td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td class="text-center">'+(element.total_unit == null || element.total_unit == '' || element.total_unit == 'null' ? '':element.total_unit)+'</td>\
                                    <td class="text-center">'+(element.total_weight == null || element.total_weight == '' || element.total_weight == 'null' ? '':element.total_weight)+'</td>\
                                    <td class="text-center">'+( (element.total_weight == null || element.total_weight == '' || element.total_weight == 'null' ? '':element.total_weight) / (element.total_weight == null || element.total_weight == '' || element.total_weight == 'null' ? '':element.total_weight) ).toFixed(2)+'</td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                </tr>';
                                sum_receive_unit2_real = sum_receive_unit2_real+element.total_unit;
                                sum_receive_weight2=sum_receive_weight2+parseFloat(element.total_weight == null || element.total_weight == '' || element.total_weight == 'null' ? '0':element.total_weight);
            
                });
                data[2].forEach(element => {
                    row = row + '<tr>\
                                    <td>เชือด</td>\
                                    <td class="text-left"><a target="blank_" href="../summary_weighing_receive/'+element.order_number+'">'+element.order_number+'</a></td>\
                                    <td class="text-center">'+element.id_user_customer+'</td>\
                                    <td></td>\
                                    <td>'+element.order_type+'</td>\
                                    <td></td>\
                                    <td>ตัว</td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td class="text-center">'+(element.count_amount == null || element.count_amount == '' || element.count_amount == 'null' ? '':element.count_amount)+'</td>\
                                    <td class="text-center">'+(element.sum_weight == null || element.sum_weight == '' || element.sum_weight == 'null' ? '':element.sum_weight)+'</td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                </tr>';
                    sum_receive_unit3=sum_receive_unit3+element.total_pig;
                    sum_receive_unit3_real=sum_receive_unit3_real+element.count_amount;
                    sum_receive_weight3 = sum_receive_weight3+parseFloat(element.sum_weight == null || element.sum_weight == '' || element.sum_weight == 'null' ? '0':element.sum_weight);
                    count_amount3 = count_amount3+element.count_amount;
                    date_ = element.date;
                });
                row = row +  '<tr style="background-color:#D0D0D0;">\
                                    <td><b>สรุป</td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td id="balance_without_today">'+balance+'</td>\
                                    <td class="text-center">'+balance_weight+'</td>\
                                    <td></td>\
                                    <td class="text-center">'+sum_receive_unit+'</td>\
                                    <td class="text-center">'+sum_receive_weight+'</td>\
                                    <td></td>\
                                    <td class="text-center">'+((sum_receive_unit2_real+sum_receive_unit3_real))+'</td>\
                                    <td class="text-center">'+(sum_receive_weight3+sum_receive_weight2)+'</td>\
                                    <td></td>\
                                    <td class="text-center">'+(parseFloat(balance)+sum_receive_unit-(sum_receive_unit2_real+sum_receive_unit3_real))+'</td>\
                                    <td class="text-center">'+((parseFloat(balance_weight)+sum_receive_weight)-(sum_receive_weight2+sum_receive_weight3))+'</td>\
                                    <td></td>\
                                    <td></td>\
                                </tr>';
                
                data[5].forEach(element => {
                     row = row +  '<tr style="background-color:#D0D0D0;">\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td>ยอดนับจริง</td>\
                                    <td class="text-center">'+(element.count_unit_real == null || element.count_unit_real == '' || element.count_unit_real == 'null' ? '':element.count_unit_real)+'</td>\
                                    <td class="text-center">'+(element.weight_summary == null || element.weight_summary == '' || element.weight_summary == 'null' ? '':element.weight_summary)+'</td>\
                                    <td></td>\
                                    <td></td>\
                                </tr>';
                });
                $('#rowStockOrder').html(row);
                // $('#balance_without_today').html('<b>'+(balance-sum_receive_unit)+'</b>');
                stockOrder();
                $('#count_pig_summary').val( (parseFloat(balance)+sum_receive_unit-(sum_receive_unit2_real+sum_receive_unit3_real)) );
                $('#count_weight_summary').val( (parseFloat(balance_weight)+sum_receive_weight)-(sum_receive_weight2+sum_receive_weight3) );
                $('#date_summary').val( date_ );


            $('#date_summary').daterangepicker({
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
                
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert("Status: " + textStatus); alert("Error: " + errorThrown);
            },
            complete: function(){
                $('.ajax-loader').css("visibility", "hidden");
            }
        });
    }
</script>


<script>
     function stockOrder(){
         
        $('#bill_number').on('keyup change', function () {
                table.column(1).search($(this).val()).draw();
        });
        $('#farm_name').on('keyup change', function () {
                table.column(2).search($(this).val()).draw();
        });
        var table = $('#stockOrder').DataTable({
                destroy: true,
                lengthMenu: [[50, 100, 200, -1], [50, 100, 200, "All"]],
                "scrollX": false,
                // orderCellsTop: true,
                fixedHeader: true,
                rowReorder: true,
                processing: true,
                // responsive: true,
                // serverSide: true,
                dom: 'lBfrtip',
                buttons: [
                    {
                    extend: 'excel',
                    messageTop: " รายงานเคลื่อนไหวหมู (Stock) วันที่ "+$('#daterangeFilter').val()+" ",
                    //  'pdf', 'print'
                    },
                ],
                "order": [],
            });
            // new $.fn.dataTable.FixedHeader( table );
            // new $.fn.dataTable.FixedHeader( table, {
            //     // options
            // } )
        // table.on( 'order.dt search.dt', function () {
        //     table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
        //         cell.innerHTML = i+1;
        //     } );
        // } ).draw();

    }

</script>

{{-- daterange --}}
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script>
    $('#daterange').daterangepicker({
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

    $('#daterangeFilterX').daterangepicker({
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
    
    $('#daterangeOrderSend').daterangepicker({
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
    function edit_price(order_number,price){
        var sign = "'";
        $('#edit_price_data').html('<div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;">ราคา/กก.   '+order_number+'</div\
                                    <div class="row" style="margin-bottom: 10px;">\
                                        <div class="col-md-12 pr-md-0">\
                                            <input type="text" class="form-control form-control-sm" id="price" name="price"  value="'+price+'" required>\
                                        </div>\
                                    </div>\
                                    <div class="text-center" style="padding-top: 10px;">\
                                        <button type="submit" class="btn btn-success mr-2" id="comfirmAdd" onclick="save_price('+sign+order_number+sign+')" name="order_number" value="'+order_number+'">ยืนยัน</button>\
                                    </div>');
    }

    
</script>

<script type="text/javascript">
    function save_price(order_number){
        var price = $("#price").val();
        
        $('#edit_price').modal('hide');
        
        $.ajax({
            type: 'GET',
            dataType: 'JSON',
            url: '{{ url('stock_data/edit_price') }}',
            data: {order_number:order_number,price:price},
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
                search_receive()
            },
        });
    }
</script>

<script>
    var c = 0;
    function dif(){
        // alert("123");
        sum_pic = $('#count_pig_summary').val();
        sum_pic_real = $('#count_pig_summary_real').val();
        weight_pic = $('#count_weight_summary').val();
        weight_pic_real = $('#count_wegiht_summary_real').val();
        r = '<label for="count_pig_summary" id="note" >สาเหตุ</label><textarea id="w3mission" rows="4" cols="50" class="form-control form-control-sm" name="note" id="note"  placeholder="" required></textarea>';
        if((sum_pic != sum_pic_real) || (weight_pic != weight_pic_real) ){
            if(c == 0){
                c = 1;
                $('#note_2').append(r);
            }
        }
        // if(weight_pic != weight_pic_real){
        //     if(c == 0){
        //         c = 1;
        //         $('#note_2').append(r);
        //     }
        // }
        
    }
</script>
<script>
    function edit_row_(id_){ 
        $.ajax({
            type: 'GET',
            dataType: 'JSON',
            url: '{{ url('stock_data/edit_row') }}',
            data: {id:id_},
            // beforeSend: function(){
            //     $('.ajax-loader').css("visibility", "visible");
            // },
            success: function (msg) {
               console.log(msg[0]);
               $('#bill_number_r').val(msg[0].bill_number);
               $('#ref_source_r').val(msg[0].ref_source);
               $('#total_unit_r').val(msg[0].total_unit);
               $('#total_weight_r').val(msg[0].total_weight);
               $('#total_price_r').val(msg[0].total_price);
               $('#unit_price_r').val(msg[0].unit_price);
               $('#total_price_r').val(msg[0].total_price);
               $('#note_r').val(msg[0].note);
               $('#receiver_r').val(msg[0].receiver);
               $('#sender_r').val(msg[0].sender);
               $('#date_recieve_r').val(msg[0].date_recieve);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert("Status: " + textStatus); alert("Error: " + errorThrown);
            },
        });
       
    }
</script>
<script>
    function deleteRecord(id_){ 
        // alert(id_);
        if (confirm("ต้องการลบหรือไม่ ?")) {
            $.ajax({
                    type: 'GET',
                    dataType: 'JSON',
                    url: '{{ url('stock_data/del_row') }}',
                    data: {id:id_},
                    // beforeSend: function(){
                    //     $('.ajax-loader').css("visibility", "visible");
                    // },
                    success: function (data) {
                        console.log(data.msg);
                        alert(data.msg);
                        location.reload();
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        alert("Status: " + textStatus); alert("Error: " + errorThrown);
                    },
                });
       
            }
       
    }
</script>

@endsection


