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
</style>
<link rel="stylesheet" href="{{ url('https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ url('https://cdn.datatables.net/1.10.18/css/dataTables.semanticui.min.css') }}" type="text/css" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection
@section('main')

@if(session()->has('message'))
    <div class="alert alert-danger">
        {{ session()->get('message') }}
    </div>
@endif

<div class="ajax-loader" style="height: 1200px;">
    <img src="{{ asset('assets/images/pig_fly.gif')}}" alt="" style="margin-left: 0px;top: 3%;width: 350px; left:37%;" class="img-responsive"  />
</div>

<div class="row ">
    <div class="col-lg-4 grid-margin">
        <div class="card">
            <div class="card-body">
                {{ Form::open(['method' => 'post' , 'url' => '/order/save_pig_number']) }}
                    <div class="forms-sample form-control" style="height: auto;padding-right: 20px;">
                        <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;">ใบสั่งจำนวนสุกรให้สาขา</div>
                        <div class="row" style="margin-bottom: 10px;">
                            <div class="col-md-12 pr-md-0">
                                <label for="orderDate">ร้านสั่ง Order วันที่</label>
                                <input class="form-control form-control-sm" placeholder="วว/ดด/ปปปป" id="datepicker1" type="text" name="datepicker1" value="">
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
                        <div class="row" style="margin-bottom: 10px;">
                            @foreach ($shop_list as $shop_)
                            <div class="col-md-8 pr-md-0">
                                <label for="shop">สาขา</label>
                                <input type="text" class="form-control form-control-sm" id="shop" placeholder="" name="shop[]" value="{{ $shop_->shop_code }}" hidden>
                                <input type="text" class="form-control form-control-sm" id="shops" placeholder="" value="{{ $shop_->shop_name  }}" readonly>
                            </div>
                            <div class="col-md-4 pr-md-0">
                                <label for="number_of_pig">จำนวน(ตัว)</label>
                                <input type="number" class="form-control form-control-sm" id="number_of_pig" name="number_of_pig[]" placeholder="จำนวน" value="0"> 
                            </div>
                            @endforeach
                        </div>
                        <div class="text-center" style="padding-top: 10px;">
                            <button type="submit" class="btn btn-success mr-2 loader">ยืนยัน</button>
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

    <div class="col-lg-8 grid-margin">
        <div class="card">
            <div class="card-body ">
                {{-- <div class="row">
                    <div class="col-3"><h4>รายการใบ Order</h4></div>
                    <h4 class="col-2">สั่งวันที่ : </h4>
                    <input class="form-control form-control-sm col-2 input-daterange-datepicker" type="text" id="dateFilterReceive" name="dateFilterReceive"/>
                </div> --}}
                    <table class="table table-striped table-bordered nowrap table-hover table-responsive" width="100%" id="orderTable">
                        <thead class="text-center">
                            <tr>
                            <th style="padding: 2px; font-size: 0.7rem;" hidden></th>
                            <th style="padding: 2px; font-size: 0.7rem;" >วันที่สั่ง</th>
                            @foreach ($shop_list as $list)
                                <th style="padding: 2px; font-size: 0.7rem; width:8%;" >{{ $list->shop_description }}</th>
                            @endforeach
                            <th style="padding: 2px; font-size: 0.7rem;" >รวม</th>
                            <th style="padding: 2px; font-size: 0.7rem;" >วันที่ส่ง</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($group_list_number_of_pig as $date_group) @php $sum = 0;  @endphp
                                <tr>
                                    <td style="padding: 0px;" class="text-center" hidden><div >{{  substr($date_group->date_order ,6,4).substr($date_group->date_order ,3,2).substr($date_group->date_order ,0,2) }}</div></td>
                                    <td  style="padding: 0px; font-size: 0.7rem;" class="text-center "> {{ $date_group->date_order }} </td>
                                    @foreach ($shop_list as $shop) @php $check_ = 0;  @endphp
                                        @foreach ($list_number_of_pig as $list_number)
                                            @if ($shop->shop_code ==  $list_number->shop_code && $date_group->date_order == $list_number->date_order )
                                                <td  style="padding: 0px; font-size: 0.7rem;" class="text-center "> {{ $list_number->number }}</td>
                                                @php $sum = $sum  + $list_number->number;  $check_ = 1;  @endphp
                                            @endif
                                        @endforeach
                                        @if ($check_ == 0)
                                            <td  style="padding: 0px; font-size: 0.7rem;" class="text-center "> 0 </td>
                                        @endif
                                    @endforeach
                                    <td  style="padding: 0px; font-size: 0.7rem;" class="text-center "> {{ $sum }} </td>
                                    <td  style="padding: 0px; font-size: 0.7rem;" class="text-center "> {{ $date_group->date_transport }} </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
        </div>
    </div>
</div>

{{-- edit order --}}
{{ Form::open(['method' => 'post' , 'url' => 'order/edit']) }}
            <div class="modal fade" id="EDIT" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content" id="data_edit">

                    </div>
                </div>
            </div>
{{ Form::close() }}


{{-- <button id="x" name="x" class="x" onclick="showx()">  xx</button> --}}
@endsection

@section('script')
<script src="{{ asset('https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js') }}"></script>

{{-- datatables --}}
<script>
        var table = $('#orderTable').DataTable({
            "scrollX": false,
            orderCellsTop: true,
            fixedHeader: true,
            // dom: 'Bfrtip',
            // buttons: [
            //     'print'
            // ],
            // processing: true,
            // serverSide: true,
            "order": [[ 0, "desc" ]],
        });

        $.fn.dataTable.ext.search.push(
            function( settings, data, dataIndex ) {

                // console.log(settings.nTable.id);
                if ( settings.nTable.id !== 'orderTable' ) {
                    return true;
                }

                var iStartDateCol = 8;

                var daterange = $('#dateFilterReceive').val();
                var dateMin=daterange.substring(6,10) + daterange.substring(3,5)+ daterange.substring(0,2);
                var colDate=data[iStartDateCol].substring(6,12) + data[iStartDateCol].substring(3,5) + data[iStartDateCol].substring(0,2);

                var min = parseInt( dateMin );
                var Date_data = parseFloat( colDate ) || 0;

                if ( ( isNaN( min ) ) || ( min == Date_data) )
                {
                    return true;
                }
                return false;
            }
        );

        $(document).ready(function() {
            $('#dateFilterReceive').change( function() {
                table.draw();
            } );
        } );
   
</script>

{{-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script> --}}
<script src="{{ asset('https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js') }}"></script>

{{-- datepicker --}}
{{-- <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script> --}}
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
    $('#datepicker,#daterange2,#datepicker22').daterangepicker({
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
    $('#dateFilterReceive').daterangepicker({
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

    $('#datepicker1').change(function(){
    var currentDate =$('#datepicker1').val();
    var futureMonth = moment(currentDate,'DD/MM/YYYY').add(1, 'days').format("DD/MM/YYYY");

        $('#datepicker2').val( moment(currentDate,'DD/MM/YYYY').add(1, 'days').format("DD/MM/YYYY") );
        $('#datepicker3').val( moment(currentDate,'DD/MM/YYYY').add(2, 'days').format("DD/MM/YYYY") );
        $('#datepicker4').val( moment(currentDate,'DD/MM/YYYY').add(3, 'days').format("DD/MM/YYYY") );
        $('#datepicker5').val( moment(currentDate,'DD/MM/YYYY').add(4, 'days').format("DD/MM/YYYY") );

    });

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


<script>
    function setMarker(customer){
        // alert(customer.value);
        $.ajax({
                type: 'GET',
                url: '{{ url('getMarkerCustomer') }}',
                data: {customer:customer.value},
                success: function (data) {
                    $('#marker').val(data[0].marker);
                    $('#customer_id').val(data[0].id);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("Status: " + textStatus); alert("Error: " + errorThrown);
                }
            });
    }

    function customerDll(type_req){

        $.ajax({
            type: 'GET',
            url: '{{ url('getCustomer') }}',
            data: {},
            success: function (data) {
                var str ='<option value=""></option>';
                data.forEach(element => {
                    if (type_req.value == 3) {
                        if (element.type == 'สาขา') {
                        str = str + '<option value="'+element.customer_name+'">'+element.customer_name+'</option>';
                        }
                        $('#status').prop( "disabled", false );
                    }else if (type_req.value == 2) {
                        if (element.type == 'ลูกค้าซาก') {
                        str = str + '<option value="'+element.customer_name+'">'+element.customer_name+'</option>';
                        }
                        $('#status').prop( "disabled", true );
                    }
                    else{
                        if (element.type != 'สาขา' && element.type != 'ลูกค้าซาก') {
                        str = str + '<option value="'+element.customer_name+'">'+element.customer_name+'</option>';
                        }
                        $('#status').prop( "disabled", true );
                    }
                });
                $('#customer').html(str);
                // console.log(type_req.value);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert("Status: " + textStatus); alert("Error: " + errorThrown);
            }
        });


    }
</script>



<script>
$(".loader").on('click', function(event){
    $('.ajax-loader').css("visibility", "visible");
});
</script>

@endsection


