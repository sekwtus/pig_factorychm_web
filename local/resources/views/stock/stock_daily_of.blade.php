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
    height:1000px;
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
            <h1 align="center" >รายงาน เครื่องใน</h1>


            <div>
                <div class="table-responsive">
                    <div class="outer">
                        <table class="table table-striped table-bordered nowrap table-hover" width="100%" id="stockOrder">
                            <thead class="text-center">
                                <tr>
                                    <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #D0D0D0;" rowspan="2">ขั้นตอนการทำงาน</th>
                                    <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #D0D0D0;" colspan="2" width="20%">รายการ</th>
                                    <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #D0D0D0;" rowspan="2">รหัสสินค้า</th>
                                    <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #D0D0D0;" rowspan="2">รายการสินค้า</th>
                                    <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #D0D0D0;" rowspan="2">ที่จัดเก็บ</th>
                                    <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #D0D0D0;" rowspan="2">หน่วยนับ</th>
                                    <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #D0D0D0;" colspan="2" rowspan="1">ยกมา</th>
                                    <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #D0D0D0;" colspan="2" rowspan="1">เข้า</th>
                                    <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #D0D0D0;" colspan="2" rowspan="1">ออก</th>
                                    <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #D0D0D0;" colspan="2" rowspan="1">ผลต่าง</th>
                                    <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #D0D0D0;" rowspan="2">% สูญเสีย</th>
                                </tr>
                                <tr>
                                    <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #D0D0D0; top:35.2px;" width="10%">หมายเลขใบงาน/Bill</th>
                                    <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #D0D0D0; top:35.2px;">ลูกค้า</th>
                                    <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #D0D0D0; top:35.2px;">จำนวน</th>
                                    <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #D0D0D0; top:35.2px;">น้ำหนัก(Kg.)</th>
                                    <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #D0D0D0; top:35.2px;">จำนวน</th>
                                    <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #D0D0D0; top:35.2px;">น้ำหนัก(Kg.)</th>
                                    <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #D0D0D0; top:35.2px;">จำนวน</th>
                                    <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #D0D0D0; top:35.2px;">น้ำหนัก(Kg.)</th>
                                    <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #D0D0D0; top:35.2px;">จำนวน</th>
                                    <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #D0D0D0; top:35.2px;">น้ำหนัก(Kg.)</th>
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
            url: '{{ url('stock_data_of_summay') }}',
            data: {daterangeFilter:daterangeFilter},
            beforeSend: function(){
                $('.ajax-loader').css("visibility", "visible");
            },
            success: function (data) {
                
                console.log(data);
                var row = '';
                var cout_row = 0;
                var cout_row2 = 0;
                var str_order_R = '';
                var str_order_OF = '';

                data[1].forEach(element => {

                    str_order_R = str_order_R + element.order_ref + '<br>';
                });


                data[2].forEach(element => {
                    var sign = "'";
                    row = row + '<tr>';

                    if (cout_row == 0) {
                      row = row + '<td rowspan="'+data[2].length+'">เข้า เครื่องใน</td>\
                                 <td rowspan="'+data[2].length+'">'+str_order_R+'</td>';
                    } else {
                      row = row + '<td hidden></td> <td hidden></td>';
                    }

                    row = row + '<td></td>\
                                    <td class="text-center">'+element.sku_code+'</td>\
                                    <td class="text-center">'+element.item_name+'</td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td class="text-center"></td>';

                    if (cout_row == 0) {
                      row = row + '<td rowspan="'+data[2].length+'">'+data[3]+'</td>';
                    } else {
                      row = row + '<td hidden></td>';
                    }

                    row = row + '<td class="text-center">'+element.sum_weight.toFixed(2)+'</td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                </tr>';
                                cout_row = 1 ;
                    
                });

                
                data[4].forEach(element => {
                    str_order_OF = str_order_OF + element.order_number + '<br>';
                });

                data[5].forEach(element => {
                    if (cout_row2 == 0) {
                      row = row + '<td rowspan="'+data[5].length+'">ออก เครื่องใน</td>\
                                 <td rowspan="'+data[5].length+'">'+str_order_OF+'</td>';
                    } else {
                      row = row + '<td hidden></td> <td hidden></td>';
                    }

                    row = row + '<td></td>\
                                    <td class="text-center">'+element.sku_code+'</td>\
                                    <td class="text-center">'+element.item_name+'</td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td class="text-center"></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td class="text-center">'+element.sum_weight.toFixed(2)+'</td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                </tr>';
                                cout_row2 = 1 ;
                    
                });




                $('#rowStockOrder').html(row);
                // stockOrder();


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


