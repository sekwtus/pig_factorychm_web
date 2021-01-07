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
                <div class="ajax-loader">
                    <img src="{{ asset('assets/images/pig_fly.gif')}}" alt="" style="margin-left: 0px;top: 3%;width: 350px; left:37%;" class="img-responsive"  />
                </div>

                <div class="card">
                    <div class="card-body">
                        {{ Form::open(['method' => 'post' , 'url' => '/shop/average_percent_save']) }}
                            <div class="forms-sample form-control" style="height: auto;padding-right: 20px;">
                                <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;">น้ำหนักที่ขายได้ของร้านต่อวัน ประจำวันที่ </div>
                                    <div class="row" style="margin-bottom: 10px;">
                                        {{-- <div class="col-md-3 pr-md-0">
                                            <label for="shop_name">สาขา</label>
                                            <select name="shop_code" class="form-control form-control-sm" id="shop_code" style=" height: 32px;">
                                                @foreach ($shop_list as $shop)
                                                    <option value="{{ $shop->shop_code }}">{{ $shop->shop_name }}</option>
                                                @endforeach
                                            </select>
                                        </div> --}}
                                        <div class="col-3">
                                        </div>
                                        <div class="col-6">

                                            <div class="col-md-12 pr-md-0">
                                                <div class="row">
                                                    <div class="col-md-11 pr-md-0">
                                                        <label for="orderDate">ร้านสั่ง Order วันที่</label>
                                                        <input class="form-control form-control-sm" placeholder="วว/ดด/ปปปป" id="datepicker1" type="text" onchange="GoToDate();" name="datepicker1" value="">
                                                    </div>
                                                    <div class="col-md-1 pr-md-0" style=" padding-top: 20px; ">
                                                        <button type="button" class="btn btn-icons btn-rounded btn-outline-success" onclick="GoToDate();" style="height: 32px; width: 34px; ">
                                                            <i class="fa fa-refresh"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 pr-md-0">
                                                <label for="orderDate">ชั่งหมู วันที่</label>
                                                <input class="form-control form-control-sm" placeholder="วว/ดด/ปปปป" id="datepicker2" type="text" name="datepicker2" value="" readonly>
                                            </div>
                                            <div class="col-md-12 pr-md-0">
                                                <label for="orderDate">เข้าเชือด วันที่</label>
                                                <input class="form-control form-control-sm" placeholder="วว/ดด/ปปปป" id="datepicker3" type="text" name="datepicker3" value="" readonly>
                                            </div>
                                            <div class="col-md-12 pr-md-0">
                                                <label for="orderDate">โรงงานตัดแต่ง วันที่</label>
                                                <input class="form-control form-control-sm" placeholder="วว/ดด/ปปปป" id="datepicker4" type="text" name="datepicker4" value="" readonly>
                                            </div>
                                            <div class="col-md-12 pr-md-0">
                                                <label for="orderDate">ส่งสินค้าเข้าร้าน วันที่</label>
                                                <input class="form-control form-control-sm" placeholder="วว/ดด/ปปปป" id="datepicker5" type="text" name="datepicker5" value="" readonly>
                                            </div>
                                        </div>
                                        {{-- <div class="col-md-3 pr-md-0">
                                            <label for="orderDate">เปอร์เซ็นวันที่</label>
                                            <input class="form-control form-control-sm" placeholder="วว/ดด/ปปปป" id="datepicker1" type="text" name="datepicker1" value="" readonly>
                                        </div> --}}
                                    </div>

                                    {{-- <div class="row" style="margin-bottom: 10px;">
                                            <div class="table-responsiwve " style="padding: 15px; ">
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
                                                        <td width="15%" style="padding: 0px; height: 20px;" class="text-center">
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
                                    </div> --}}

                                    <br><br>

                                    <div class="table-responsive">
                                        <table  class="tbl table-hover " width="100%" border="1" id="report_shop">
                                            <thead class="text-center ">
                                            <tr style="background-color:#7dbeff" >
                                                <th style="padding: 0px;" colspan="2">ชิ้นส่วน</th>
                                                <th style="padding: 0px;" colspan="{{ count($shop_list) }}">เปอร์เซ็นชิ้นส่วนที่กระจายแต่ละร้าน</th>
                                                <th style="padding: 0px;" rowspan="2">น้ำหนักรวม</th>
                                            </tr>
                                            <tr style="background-color:#7dbeff" >
                                                <th style="padding: 0px;">รหัส</th>
                                                <th style="padding: 0px;">รายการ</th>

                                                @foreach ($shop_list as $shop)
                                                    <th style="padding: 0px; ">{{ $shop->marker }}</th>
                                                @endforeach
                                                
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($shop_base_percent as $percent)
                                                @php $sum_p = 0; @endphp
                                                <tr>
                                                    <td style="padding: 0px; height: 20px;" class="text-center">{{ $percent->item_code }}</td>
                                                    <td style="padding: 0px; height: 20px;" class="text-center">{{ $percent->item_name }}</td>
                                                    @foreach ($shop_list as $shop) @php $shop_code = $shop->shop_code; @endphp
                                                        <td style="padding: 0px;" class="text-center">
                                                            <input type="text" style=" border-width: 0px; padding: 0px; width: 40px; " name="percent[{{ $shop_code }}][{{ $percent->item_code2 }}]" class="text-center" value="{{ $percent->$shop_code }}" />%</td>
                                                        @php $sum_p = $sum_p + $percent->$shop_code @endphp
                                                    @endforeach
                                                    <td style="padding: 0px; height: 20px; " class="text-center">{{ $sum_p }}%</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div class="text-center" style="padding-top: 10px;">
                                            <button type="submit" class="btn btn-success mr-2">ยืนยัน</button>
                                        </div>
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

        $('#datepicker1').change(function(){
        var currentDate =$('#datepicker1').val();
        var futureMonth = moment(currentDate,'DD/MM/YYYY').add(1, 'days').format("DD/MM/YYYY");
            $('#datepicker2').val( moment(currentDate,'DD/MM/YYYY').add(1, 'days').format("DD/MM/YYYY") );
            $('#datepicker3').val( moment(currentDate,'DD/MM/YYYY').add(2, 'days').format("DD/MM/YYYY") );
            $('#datepicker4').val( moment(currentDate,'DD/MM/YYYY').add(3, 'days').format("DD/MM/YYYY") );
            $('#datepicker5').val( moment(currentDate,'DD/MM/YYYY').add(4, 'days').format("DD/MM/YYYY") );
        });

        $('#datepicker1').daterangepicker({
            startDate: moment('{{ $date_format_shop }}','DD/MM/YYYY'),
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

<script>
    function GoToDate(){
        $('.ajax-loader').css("visibility", "visible");
        var date = $('#datepicker1').val();
        var re_date = date.substr(0,2)+date.substr(3,2)+date.substr(6,4);
        window.location.href='/pig_factorychm_web/shop/average_percent/'+re_date;
    }
</script>

@endsection


