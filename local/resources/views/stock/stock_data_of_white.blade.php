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
    
</style>

<link rel="stylesheet" href="{{ url('https://cdn.datatables.net/1.10.18/css/dataTables.semanticui.min.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/css/daterangepicker.css')}}">

@endsection
@section('main')
              <div class="col-lg-12 grid-margin">
                <div class="card">
                  <div class="card-body">

                        <div class="row">
                            <div class="col-lg-7"><h2 style="color:red;">รายงานคลังสินค้าประจำวัน  #{{ $stock_name }}
                                <button type="button" class="btn btn-success" title="ปรับ Stock"  data-toggle="modal" data-target="#edit" href="#">
                                <i class="fa fa-plus"></i></button></h2></div><br>
                        </div>
                        <div class="row"> <div class="col-lg-4"></div>
                        </div>
                        <hr>

                        <div class="row">

                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
                                <div class="card card-statistics">
                                <div class="card-body">
                                    <div class="clearfix">
                                    <div class="float-left">
                                        <i class="fa fa-cubes text-info icon-lg"></i>
                                    </div>
                                    <div class="float-right">
                                        <p class="mb-0 text-right">คงเหลือ (ถุง)</p>
                                        <div class="fluid-container">
                                        <h3 class="font-weight-medium text-right mb-0">
                                            @foreach ($sum_storage as $_storage)
                                                @if ($_storage->type_of_storage == 'เครื่องในขาว')
                                                       {{ $_storage->current_unit }}
                                                @endif
                                            @endforeach
                                        </h3>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                                    
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
                                <div class="card card-statistics">
                                <div class="card-body">
                                    <div class="clearfix">
                                    <div class="float-left">
                                        <i class="fa fa-download text-success icon-lg"></i>
                                    </div>
                                    <div class="float-right">
                                        <p class="mb-0 text-right">ยอดรับเข้าวันนี้ (ถุง)</p>
                                        <div class="fluid-container">
                                        <h3 class="font-weight-medium text-right mb-0">{{ ( empty($unit_today[0]->sum_unit_add) ? 0 : $unit_today[0]->sum_unit_add) +( empty($order_send[0]->sum_unit_add) ? 0 : $order_send[0]->sum_unit_add)  }}</h3>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
                                <div class="card card-statistics">
                                <div class="card-body">
                                    <div class="clearfix">
                                    <div class="float-left">
                                        <i class="fa fa-flash text-danger icon-lg"></i>
                                    </div>
                                    <div class="float-right">
                                        <p class="mb-0 text-right">ยอดที่ Order วันนี้</p>
                                        <div class="fluid-container">
                                        <h3 class="font-weight-medium text-right mb-0"></h3>
                                        {{-- <h3 class="font-weight-medium text-right mb-0">{{ ( empty($order_process[0]->sum_processing) ? 0 : $order_process[0]->sum_processing) }}</h3> --}}
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
                                <div class="card card-statistics">
                                <div class="card-body">
                                    <div class="clearfix">
                                    <div class="float-left">
                                        <i class="fa fa-upload text-warning icon-lg"></i>
                                    </div>
                                    <div class="float-right">
                                        <p class="mb-0 text-right">ยอดจ่ายออกวันนี้</p>
                                        <div class="fluid-container">
                                        {{-- <h3 class="font-weight-medium text-right mb-0">{{ ( empty($unit_release[0]->sum_release) ? 0 : $unit_release[0]->sum_release) }}</h3> --}}
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                </div>
                            </div>

                        </div>
                        
                        <br>
                        <div>
                            <div class="row">
                                <div class="col-lg-3">
                                    <h4 style="color:red;margin-bottom: 0px;height: 0px;">รายงานเคลื่อนไหวหมู (Stock) </h4>
                                </div>
                                <div class="col-lg-2"><h6>ค้นหาช่วงวัน : </h6></div>
                                <div class="col-lg-3"></div>
                                <div class="col-lg-2"><h6>เลขที Bill: </h6></div>
                                <div class="col-lg-2"><h6>ฟาร์ม : </h6></div>
                            </div>
    
    
                            <div class="row"> <div class="col-lg-3"></div>
                                <div class="col-lg-2"><input class="form-control input-daterange-datepicker" type="text" id="daterangeFilter" name="daterangeFilter" style="padding: 0px; height: 30px;"/></div>
                                <button type="button" id="filter" class="btn btn-success" onclick="search_receive()" ><i class="fa fa-search"></i>ค้นหา</button>
                                <div class="col-lg-2"></div>
    
                                <div class="col-lg-2"><input type="text" class="form-control" name="bill_number" id="bill_number"style="padding: 0px; height: 30px;" /></div>
                                <div class="col-lg-2"><input type="text" class="form-control" name="farm_name" id="farm_name"style="padding: 0px; height: 30px;"/></div>
                            </div><br>
    
                            <div class="table">
                                <table class="table table-striped table-bordered" width="100%" id="stockOrder">
                                    <thead class="text-center">
                                    <tr>
                                        <th style="padding: 0px; border: 1px solid #ccc;" colspan="3">รับเข้า</th>
                                        <th style="padding: 0px; border: 1px solid #ccc;" colspan="2">ซากด่วน</th>
                                        <th style="padding: 0px; border: 1px solid #ccc;" colspan="3">แปรสภาพ</th>
                                        <th style="padding: 0px; border: 1px solid #ccc;" colspan="2">หัวหมู</th>
                                    </tr>
                                    <tr>
                                        <th style="padding: 0px; border: 1px solid #ccc;" colspan="2">เลขที่บิล</th>
                                        <th style="padding: 0px; border: 1px solid #ccc;">รายการ</th>
                                        <th style="padding: 0px; border: 1px solid #ccc;">ตัว</th>
                                        <th style="padding: 0px; border: 1px solid #ccc;">Kg.</th>
                                        <th style="padding: 0px; border: 1px solid #ccc;">ขาว Kg.</th>
                                        <th style="padding: 0px; border: 1px solid #ccc;">แดง Kg.</th>
                                        <th style="padding: 0px; border: 1px solid #ccc;">สะดือ Kg.</th>
                                        <th style="padding: 0px; border: 1px solid #ccc;">จำนวนหัว</th>
                                        <th style="padding: 0px; border: 1px solid #ccc;">Kg.</th>
                                    </tr>
                                    </thead>
                                    <tbody id="rowStockOrder" class=text-center>
                                    </tbody>
                                </table>
                            </div>
                            <br><hr><br>

                            <div class="table">
                                <table class="table table-striped table-bordered" width="100%" id="stockOrder">
                                    <thead class="text-center">
                                    <tr>
                                        <th style="padding: 0px; border: 1px solid #ccc;" colspan="3">แปรสภาพ</th>
                                        <th style="padding: 0px; border: 1px solid #ccc;" colspan="1" rowspan="2" width="10%"></th>
                                        <th style="padding: 0px; border: 1px solid #ccc;" colspan="1" rowspan="2">น้ำหนักที่ได้ (Kg.)</th>
                                        <th style="padding: 0px; border: 1px solid #ccc;" colspan="2" rowspan="2" width="10%"></th>
                                    </tr>
                                    <tr>
                                        <th style="padding: 0px; border: 1px solid #ccc;" colspan="2">เลขที่บิล</th>
                                        <th style="padding: 0px; border: 1px solid #ccc;">รายการ</th>
                                    </tr>
                                    </thead>
                                    <tbody id="rowStockOrder2" class=text-center>
                                    </tbody>
                                </table>
                            </div>
                            <br><hr><br>

                            <div class="table">
                                <table class="table table-striped table-bordered" width="100%" id="stockOrder">
                                    <thead class="text-center">
                                    <tr>
                                        <th style="padding: 0px; border: 1px solid #ccc;" colspan="3">จ่ายออก</th>
                                        <th style="padding: 0px; border: 1px solid #ccc;" colspan="2">ซากด่วน</th>
                                        <th style="padding: 0px; border: 1px solid #ccc;" colspan="1" rowspan="2">น้ำหนักที่ได้ (Kg.)</th>
                                        <th style="padding: 0px; border: 1px solid #ccc;" colspan="1" rowspan="2" width="10%"></th>
                                        <th style="padding: 0px; border: 1px solid #ccc;" colspan="2">หัวหมู</th>
                                    </tr>
                                    <tr>
                                        <th style="padding: 0px; border: 1px solid #ccc;" colspan="2">เลขที่บิล</th>
                                        <th style="padding: 0px; border: 1px solid #ccc;">รายการ</th>
                                        <th style="padding: 0px; border: 1px solid #ccc;">ตัว</th>
                                        <th style="padding: 0px; border: 1px solid #ccc;">Kg.</th>
                                        <th style="padding: 0px; border: 1px solid #ccc;">จำนวน</th>
                                        <th style="padding: 0px; border: 1px solid #ccc;">Kg.</th>
                                    </tr>
                                    </thead>
                                    <tbody id="rowStockOrder3" class=text-center>
                                    </tbody>
                                </table>
                            </div>

                      </div>
                   </div>
                </div>

                {{-- ปรับStock --}}
                {{ Form::open(['method' => 'post' , 'url' => '/stock_data/add/'.$stock_name]) }}
                    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="forms-sample form-control" style="height: auto;padding-right: 20px;">
                                        <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;">ปรับ Stock</div>
                                        <div class="row" style="margin-bottom: 10px;">
                                            <div class="col-md-3 pr-md-0">
                                                <label for="bill_number">Bill / Order</label>
                                                <input type="text" class="form-control form-control-sm" name="bill_number" placeholder="0000" required> 
                                            </div>
                                            <div class="col-md-3 pr-md-0">
                                                <label for="ref_source">ชื่อฟาร์ม</label>
                                                <input type="text" class="form-control form-control-sm" name="ref_source" placeholder="0000" required> 
                                            </div>
                                            <div class="col-md-3 pr-md-0">
                                                <label for="round">รอบที่</label>
                                                <input type="number" class="form-control form-control-sm" name="round" value="1" required> 
                                            </div>
                                            <div class="col-md-3 pr-md-0">
                                                <label for="item_code">รหัส Item</label>
                                                <input type="text" class="form-control form-control-sm" name="item_code" placeholder="0000" required> 
                                            </div>
                                        </div>
                                        <div class="row" style="margin-bottom: 10px;">
                                            <div class="col-md-3 pr-md-0">
                                                <label for="total_unit">จำนวนที่รับ</label>
                                                <input type="number" class="form-control form-control-sm" name="total_unit" placeholder="จำนวน" required> 
                                            </div>
                                            <div class="col-md-6 pr-md-0">
                                                <label for="id_storage">ที่จัดเก็บ (stock)</label>
                                                <select class="form-control form-control-sm " id="id_storage" name="id_storage" style=" height: 30px; " required>
                                                    @foreach ($sum_storage as $store)
                                                        @if ($store->type_of_storage == $stock_name)
                                                            <option value="{{ $store->id_storage }}">{{ $store->name_storage }} - {{ $store->description }}</option>
                                                        @endif
                                                    @endforeach
                                                </select> 
                                            </div>
                                            <div class="col-md-3 pr-md-0">
                                                <label for="date_recieve">ประจำวันที่</label>
                                                <input class="form-control form-control-sm" placeholder="วว/ดด/ปปปป" id="daterange" type="text" name="date_recieve" required>
                                            </div>
                                        </div>
                                      
                                        <div class="row" style="margin-bottom: 10px;">
                                            <div class="col-md-12 pr-md-0">
                                                <label for="note">หมายเหตุ</label>
                                                <textarea class="form-control form-control-sm" name="note" rows="3" placeholder="หมายเหตุ"></textarea> 
                                            </div>
                                        </div>
                
                                        <div class="text-center" style="padding-top: 10px;">
                                            <button type="submit" class="btn btn-success mr-2" id="comfirmAdd" name="stock_name" value="comfirmAdd">ยืนยัน</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                {{ Form::close() }}

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
    $(document).ready(function(){
        dataStockOrder($("#daterangeFilter").val());
        stockReceive($("#daterangeReceive").val());
        stockHistorySend($("#daterangeOrderSend").val());
        stockBalance($("#daterangeStockBalance").val());
    });

    function search_receive(){
        stockReceive($("#daterangeReceive").val());
    }
    function search_Order_send(){
        stockHistorySend($("#daterangeOrderSend").val());
    }
    function search_StockBalance(){
        stockBalance($("#daterangeStockBalance").val());
    }
    function search_receive(){
        var table = $('#stockOrder').DataTable();
        table.destroy();//ลบdatatableเก่าทิ้ง
        dataStockOrder($("#daterangeFilter").val()); //get value ใหม่ แล้วสร้างdatatableใหม่
    }
    
</script>

<script>
    function dataStockOrder(daterangeFilter){

        $.ajax({
            type: 'GET',
            dataType: 'JSON',
            url: '{{ url('stock_of_white_receive') }}',
            data: {daterangeFilter:daterangeFilter},
            beforeSend: function(){
                $('.ajax-loader').css("visibility", "visible");
            },
            success: function (data) {
                console.log(data);
                var row = '';

                row = row + '<tr>\
                                <td>1</td>\
                                <td>6869/</td>\
                                <td>รับเข้า</td>\
                                <td>-</td>\
                                <td>-</td>\
                                <td>1012.18</td>\
                                <td>675.64</td>\
                                <td>2.02</td>\
                                <td>167</td>\
                                <td>-</td>\
                            </tr>';

                row = row + '<tr style="background-color:#ff8080;">\
                                <td colspan="3">รวมรับเข้า</td>\
                                <td>2</td>\
                                <td>193.00</td>\
                                <td colspan="3">1753.30</td>\
                                <td>174</td>\
                                <td>174 Kg.</td>\
                            </tr>';


                $('#rowStockOrder').html(row);
                // $('#balance_without_today').html('<b>'+(balance-sum_receive_unit)+'</b>');
                stockOrder();
                $('#count_pig_summary').val( (parseFloat(balance)+sum_receive_unit-(sum_receive_unit2_real+sum_receive_unit3_real)) );
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


        /////////////////////////////////////////////////////table 2
        $.ajax({
            type: 'GET',
            dataType: 'JSON',
            url: '{{ url('stock_of_white_receive') }}',
            data: {daterangeFilter:daterangeFilter},
            beforeSend: function(){
                $('.ajax-loader').css("visibility", "visible");
            },
            success: function (data) {
                console.log(data);
                var row = '';

                row = row + '<tr>\
                                <td>1</td>\
                                <td>6869/</td>\
                                <td>อ่อม</td>\
                                <td></td>\
                                <td>17.06</td>\
                                <td colspan="2"></td>\
                            </tr>';

                row = row + '<tr style="background-color:#ff8080;">\
                                <td colspan="3">รวมแปรสภาพ</td>\
                                <td></td>\
                                <td>1503.17</td>\
                                <td colspan="2">เฉลี่ย</td>\
                            </tr>';
                
                row = row + '<tr style="background-color:#ff8080;">\
                                <td colspan="3">น้ำหนักหาย</td>\
                                <td></td>\
                                <td>186.7</td>\
                                <td>10.65</td>\
                                <td>%</td>\
                            </tr>';

                row = row + '<tr>\
                                <td><b>หมายเหตุ</td>\
                                <td colspan="6">นน.เรื่องในที่น้อยลง อาจเกิดจากน้ำย่อยภายในใส้กลางที่ล้างออกก่อส่งร้าน</td>\
                            </tr>';


                $('#rowStockOrder2').html(row);
                // $('#balance_without_today').html('<b>'+(balance-sum_receive_unit)+'</b>');
                stockOrder();
                $('#count_pig_summary').val( (parseFloat(balance)+sum_receive_unit-(sum_receive_unit2_real+sum_receive_unit3_real)) );
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

        ///////////////////////////////////// table 3

        $.ajax({
            type: 'GET',
            dataType: 'JSON',
            url: '{{ url('stock_of_white_receive') }}',
            data: {daterangeFilter:daterangeFilter},
            beforeSend: function(){
                $('.ajax-loader').css("visibility", "visible");
            },
            success: function (data) {
                console.log(data);
                var row = '';

                row = row + '<tr>\
                                <td>1</td>\
                                <td>689/</td>\
                                <td>จ่ายออกสาขา</td>\
                                <td>-</td>\
                                <td>-</td>\
                                <td>149.04</td>\
                                <td></td>\
                                <td>-</td>\
                                <td>-</td>\
                            </tr>';

                row = row + '<tr style="background-color:#ff8080;">\
                                <td colspan="3">รวมจ่ายออก</td>\
                                <td>2</td>\
                                <td>181.20</td>\
                                <td>1419.04</td>\
                                <td></td>\
                                <td>174</td>\
                                <td>kk</td>\
                            </tr>';
                            
                row = row + '<tr style="background-color:#ff8080;">\
                                <td colspan="3">คงเหลือ</td>\
                                <td>0</td>\
                                <td>11.80</td>\
                                <td>0.00</td>\
                                <td></td>\
                                <td>0</td>\
                                <td>kk</td>\
                            </tr>';

                row = row + '<tr>\
                                <td><b>หมายเหตุ</td>\
                                <td colspan="8">นน.ซากด่วนที่หายไปเกิดจากเลือดระหว่างกระบวนการเชือด</td>\
                            </tr>';

                $('#rowStockOrder3').html(row);
                // $('#balance_without_today').html('<b>'+(balance-sum_receive_unit)+'</b>');
                stockOrder();
                $('#count_pig_summary').val( (parseFloat(balance)+sum_receive_unit-(sum_receive_unit2_real+sum_receive_unit3_real)) );
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
                orderCellsTop: true,
                fixedHeader: true,
                rowReorder: true,
                processing: true,
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
        // table.on( 'order.dt search.dt', function () {
        //     table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
        //         cell.innerHTML = i+1;
        //     } );
        // } ).draw();

    }

</script>


{{-- <script>
    function stockHistorySend(orderFilter){


        $('#order_number').on('keyup change', function () {
                table.column(1).search($(this).val()).draw();
        });
        $('#type_req').on('keyup change', function () {
                table.column(3).search($(this).val()).draw();
        });
   
       var table = $('#stockHistorySend').DataTable({
               destroy: true,
               lengthMenu: [[20, 50, 100, -1], [20, 50, 100, "All"]],
               "scrollX": false,
               orderCellsTop: true,
               fixedHeader: true,
               rowReorder: true,
               processing: true,
               // serverSide: true,
               dom: 'lBfrtip',
               buttons: [
                   'excel',
                   //  'pdf', 'print'
               ],
               ajax: {
                   url: '{{ url('stock_pp1_send') }}',
                   data: {orderFilter:orderFilter},
               },
               columns: [

                   { data: 'id', name: 'id' },
                   { data: 'order_number', name: 'order_number' },
                   { data: 'id_user_customer', name: 'id_user_customer' },
                   { data: 'order_type', name: 'order_type' },
                   { data: 'round', name: 'round' },
                   { data: 'total_pig', name: 'total_pig' },
                   { data: 'count_amount', name: 'count_amount' },
                   { data: 'date', name: 'date' },
                   { data: 'note', name: 'note' },
                   { data: 'id', name: 'id' },
               ],
               columnDefs: [
                   {
                       "targets": 0,
                       "className": "text-center",
                   },
                   {
                       "targets": 1,
                       "className": "text-center",
                   },
                   {
                       "targets": 2,
                       "className": "text-center",
                   },
                   {
                       "targets": 3,
                       "className": "text-center",
                   },
                   {
                       "targets": 4,
                       "className": "text-center",
                   },
                   {
                       "targets": 5,
                       "className": "text-center",
                   },
                   {
                       "targets": 6,
                       "className": "text-center",
                   },
                   {
                       "targets": 7,
                       "className": "text-center",
                   },
                   {
                       "targets": 8,
                       "className": "text-center",
                   },
                   {
                       "targets": 9,render(data,type,row){
                           return '<button>แก้ไข</button>'
                       },
                       "className": "text-center",
                   },
               ],
               "order": [],
           });
    
       table.on( 'order.dt search.dt', function () {
           table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
               cell.innerHTML = i+1;
           } );
       } ).draw();

   }
</script> --}}

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

    $('#daterangeFilter').daterangepicker({
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
    // function dif(){
    //     sum_pic = $('#count_pig_summary').val();
    //     sum_pic_real = $('#count_pig_summary_real').val();

    //     if(sum_pic != sum_pic_real){
    //         $('#note').show();
    //     }
    // }
    
</script>



@endsection


