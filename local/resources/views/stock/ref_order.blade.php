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

                    <div>
                        <div class="row">
                            <div class="col-lg-3">
                                <h4 style="color:red;margin-bottom: 0px;height: 0px;">reference </h4>
                            </div>
                            <div class="col-lg-2"><h6>ค้นหาช่วงวัน : </h6></div>
                            <div class="col-lg-3"></div>
                            {{-- <div class="col-lg-2"><h6>เลขที Bill: </h6></div>
                            <div class="col-lg-2"><h6>ฟาร์ม : </h6></div> --}}
                        </div>


                        <div class="row"> <div class="col-lg-3"></div>
                            <div class="col-lg-2"><input class="form-control input-daterange-datepicker" type="text" id="daterangeFilter" name="daterangeFilter" style="padding: 0px; height: 30px;"/></div>
                            <button type="button" id="filter" class="btn btn-success" onclick="search_receive()" ><i class="fa fa-search"></i>ค้นหา</button>
                            <div class="col-lg-2"></div>

                            {{-- <div class="col-lg-2"><input type="text" class="form-control" name="bill_number" id="bill_number"style="padding: 0px; height: 30px;" /></div>
                            <div class="col-lg-2"><input type="text" class="form-control" name="farm_name" id="farm_name"style="padding: 0px; height: 30px;"/></div> --}}
                        </div><br>

                        <div class="table-responsive">
                            <div class="outer">
                                <table class="table table-striped table-bordered nowrap table-hover" width="100%" id="stockOrder">
                                    <thead class="text-center">
                                        <tr>
                                            <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #ff8080; top:35.2px;">order TR.</th>
                                            <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #ff8080; top:35.2px;">order CL.</th>
                                            <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #ff8080; top:35.2px;">order OF</th>
                                            <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #ff8080; top:35.2px;">order OV</th>
                                            <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #ff8080; top:35.2px;">order R</th>
                                            <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #ff8080; top:35.2px;">วันที่สร้าง</th>
                                            <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #ff8080; top:35.2px;">วันจัดส่ง</th>
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
        dataStockOrder($("#daterangeFilter").val());
        // stockHistorySend($("#daterangeOrderSend").val());
    });

    function search_receive(){
        var table = $('#stockOrder').DataTable();
        table.destroy();//ลบdatatableเก่าทิ้ง
        dataStockOrder($("#daterangeFilter").val()); //get value ใหม่ แล้วสร้างdatatableใหม่
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
            url: '{{ url('get_ref_order') }}',
            data: {daterangeFilter:daterangeFilter},
            beforeSend: function(){
                $('.ajax-loader').css("visibility", "visible");
            },
            success: function (data) {
               
                    console.log(data);
                    var row = '';

                data[0].forEach(element => {
                    row = row + '<tr>\
                                    <td>'+element.tr+'</td>\
                                    <td>'+element.cl+'</td>\
                                    <td>'+element.of+'</td>\
                                    <td>'+element.ov+'</td>\
                                    <td>'+element.R+'</td>\
                                    <td>'+element.created_at+'</td>\
                                    <td>'+element.date_transport+'</td>\
                                </tr>';
 
                });

                $('#rowStockOrder').html(row);
                // $('#balance_without_today').html('<b>'+(balance-sum_receive_unit)+'</b>');
                stockOrder();
                // $('#count_pig_summary').val( (parseFloat(balance)+sum_receive_unit-(sum_receive_unit2_real+sum_receive_unit3_real)) );
                // $('#count_weight_summary').val( (parseFloat(balance_weight)+sum_receive_weight)-(sum_receive_weight2+sum_receive_weight3) );
                // $('#date_summary').val( date_ );

                
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
    //     var table = $('#example').DataTable( {
    //     responsive: true
    // } );
 
    // new $.fn.dataTable.FixedHeader( table );
// } );
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


