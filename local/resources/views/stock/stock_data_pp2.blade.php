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
    height:650px;
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

                        <div class="row">
                            <div class="col-lg-6"><h2 style="color:red;">รายงานคลังสินค้าประจำวัน  #{{ $stock_name }}
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
                                    <p class="mb-0 text-right">ซากอุ่น (บ๊อบ)</p>
                                    <div class="fluid-container">
                                    <h3 class="font-weight-medium text-right mb-0" id="carcass">0</h3>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                  <table class="table" id="table-carcass-statistics">
                                    <thead>
                                      <tr align="center">
                                        <th></th>
                                        <th colspan="2">รับ</th>
                                        <th colspan="2">จ่าย</th>
                                      </tr>
                                      <tr>
                                        <th></th>
                                        <th>จำนวนตัว</th>
                                        <th>นน.</th>
                                        <th>จำนวนตัว</th>
                                        <th>นน.</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                  </table>
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
                                        <p class="mb-0 text-right">สาขา</p>
                                        <div class="fluid-container">
                                        <h3 class="font-weight-medium text-right mb-0" id="branch">0</h3>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                      <table class="table" id="table-branch-statistics">
                                        <thead>
                                          <tr align="center">
                                            <th></th>
                                            <th colspan="2">รับ</th>
                                            <th colspan="2">จ่าย</th>
                                          </tr>
                                          <tr>
                                            <th></th>
                                            <th>จำนวนตัว</th>
                                            <th>นน.</th>
                                            <th>จำนวนตัว</th>
                                            <th>นน.</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                      </table>
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
                                        <p class="mb-0 text-right">ลูกค้า</p>
                                        <div class="fluid-container">
                                        <h3 class="font-weight-medium text-right mb-0"></h3>
                                        <h3 class="font-weight-medium text-right mb-0" id="customer">0</h3>
                                        </div>
                                    </div>
                  
                                    <div class="table-responsive">
                                      <table class="table" id="table-customer-statistics">
                                        <thead>
                                          <tr align="center">
                                            <th></th>
                                            <th colspan="2">รับ</th>
                                            <th colspan="2">จ่าย</th>
                                          </tr>
                                          <tr>
                                            <th></th>
                                            <th>จำนวนตัว</th>
                                            <th>นน.</th>
                                            <th>จำนวนตัว</th>
                                            <th>นน.</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                      </table>
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
                                        <p class="mb-0 text-right">รวมทั้งหมด</p>
                                        <div class="fluid-container">
                                        <h3 class="font-weight-medium text-right mb-0" id="all">0</h3>
                                        </div>
                                    </div>
                  
                                    <div class="table-responsive">
                                      <table class="table" id="table-all-statistics">
                                        <thead>
                                          <tr align="center">
                                            <th></th>
                                            <th colspan="2">รับ</th>
                                            <th colspan="2">จ่าย</th>
                                          </tr>
                                          <tr>
                                            <th></th>
                                            <th>จำนวนตัว</th>
                                            <th>นน.</th>
                                            <th>จำนวนตัว</th>
                                            <th>นน.</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                      </table>
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
    
                            <div class="table-responsive">
                                <div class="outer">
                                    <table class="table table-striped table-bordered nowrap table-hover" width="100%" id="stockOrder">
                                        <thead class="text-center">
                                            <tr>
                                                <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #ff8080;" colspan="4">รายยการ</th>
                                                <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #ff8080;" rowspan="2">รหัสสินค้า</th>
                                                <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #ff8080;" rowspan="2">รายยการสินค้า</th>
                                                <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #ff8080;" rowspan="2">ที่จัดเก็บ</th>
                                                <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #ff8080;" rowspan="2">หน่วยนับ</th>
                                                <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #ff8080;" colspan="3" rowspan="1">ยกมา</th>
                                                <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #ff8080;" colspan="3" rowspan="1">เข้า</th>
                                                <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #ff8080;" colspan="3" rowspan="1">ออก</th>
                                                <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #ff8080;" colspan="2" rowspan="1">ผลต่าง</th>
                                                <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #ff8080;" rowspan="2">หมายเหตุ</th>
                                            </tr>
                                            <tr>
                                                <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #ff8080; top:35.2px;">No.</th>
                                                <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #ff8080; top:35.2px;">Action</th>
                                                <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #ff8080; top:35.2px;">หมายเลขใบงาน/Bill</th>
                                                <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #ff8080; top:35.2px;">ลูกค้า</th>
                                                <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #ff8080; top:35.2px;">จำนวน</th>
                                                <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #ff8080; top:35.2px;">น้ำหนัก(Kg.)</th>
                                                <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #ff8080; top:35.2px;">เฉลี่ย</th>
                                                <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #ff8080; top:35.2px;">จำนวน</th>
                                                <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #ff8080; top:35.2px;">น้ำหนัก(Kg.)</th>
                                                <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #ff8080; top:35.2px;">เฉลี่ย</th>
                                                <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #ff8080; top:35.2px;">จำนวน</th>
                                                <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #ff8080; top:35.2px;">น้ำหนัก(Kg.)</th>
                                                <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #ff8080; top:35.2px;">เฉลี่ย</th>
                                                <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #ff8080; top:35.2px;">จำนวน</th>
                                                <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #ff8080; top:35.2px;">น้ำหนัก(Kg.)</th>
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
    
                    
    
                    {{-- edite price --}}
                    {{-- {{ Form::open(['method' => 'post' , 'url' => '/stock_data/edit_price/']) }} --}}
                        <div class="modal fade" id="edit_price" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="forms-sample form-control" style="height: auto;padding-right: 20px;" id="edit_price_data">
                                           
                                        </div>
                                    </div>
                                </div>
                        </div>
                    {{-- {{ Form::close() }} --}}
    
                    {{ Form::open(['method' => 'post' , 'url' => '/stock_data/pigpen_summary']) }}
                    <div class="modal fade" id="check" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="forms-sample form-control" style="height: auto;padding-right: 20px;">
                                        <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;">ตรวจสอบยอดประจำวัน</div>
                                        <div class="row" style="margin-bottom: 10px;" id="note" >
                                            {{-- <div class="col-md-4 pr-md-0">
                                                <label for="count_pig_summary" id="note" >สาเหตุ</label>
                                                <input type="text" class="form-control form-control-sm" name="note" id="note"  placeholder="" > 
                                            </div> --}}
                                            <div class="col-md-4 pr-md-0">
                                                <label for="date_summary">ประจำวันที่</label>
                                                <input type="text" class="form-control form-control-sm" name="date_summary" id="date_summary" placeholder="0000"> 
                                            </div>
                                        </div>
                                        <div class="row" style="margin-bottom: 10px;">
                                            <div class="col-md-4 pr-md-0">
                                                <label for="count_pig_summary">จำนวนหมู</label>
                                                <input type="text" class="form-control form-control-sm" name="count_pig_summary" id="count_pig_summary" placeholder="0000" readonly> 
                                            </div>
                                            <div class="col-md-4 pr-md-0">
                                                <label for="count_pig_summary">จำนวนหมูที่นับจริง</label>
                                                <input type="number" class="form-control form-control-sm" name="count_pig_summary_real" id="count_pig_summary_real" placeholder="0000" required  onchange="dif()"> 
                                            </div>
                                        </div>
                                        <div class="row" style="margin-bottom: 10px;">
                                            <div class="col-md-4 pr-md-0">
                                                <label for="count_pig_summary">น้ำหนัก</label>
                                                <input type="text" class="form-control form-control-sm" name="count_weight_summary" id="count_weight_summary" placeholder="0000" readonly> 
                                            </div>
                                            <div class="col-md-4 pr-md-0">
                                                <label for="count_pig_summary">น้ำหนักที่นับจริง</label>
                                                <input type="number" class="form-control form-control-sm" name="count_wegiht_summary_real" id="count_wegiht_summary_real" placeholder="0000" required onchange="dif()"  > 
                                            </div>
                                        </div>
                                        <div class="row" style="margin-bottom: 10px;"  >
                                            <div class="col-md-12 pr-md-0" id="note_2">
                                                {{-- <textarea id="w3mission" rows="4" cols="50" class="form-control form-control-sm" name="note" id="note"  placeholder=""></textarea> --}}
                                                {{-- <input type="text" class="form-control form-control-sm" name="note" id="note"  placeholder="" >  --}}
                                            </div>
                                        </div>
                                        <div class="text-center" style="padding-top: 10px;">
                                            <input type="text" class="form-control form-control-sm" name="id_storage" value="102" hidden>
                                            <button type="submit" class="btn btn-success mr-2" id="comfirmAdd" name="stock_name" value="comfirmAdd">กระทบยอด</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                {{ Form::close() }}
    
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
                url: '{{ url('stock_pp2_receive') }}',
                data: {daterangeFilter:daterangeFilter},
                beforeSend: function(){
                    $('.ajax-loader').css("visibility", "visible");
                },
                success: function (data) {
                  var statistics = {
                ov: {
                    receive_amount: 0,
                    receive_quantity: 0,
                    export_amount: 0,
                    export_quantity: 0,
                },
                branch:  {
                    receive_amount: 0,
                    receive_quantity: 0,
                    export_amount: 0,
                    export_quantity: 0,
                },
                customer:  {
                    receive_amount: 0,
                    receive_quantity: 0,
                    export_amount: 0,
                    export_quantity: 0,
                },
                all: {
                    receive_amount: 0,
                    receive_quantity: 0,
                    export_amount: 0,
                    export_quantity: 0,
                }
              }


                    var row = '';
                    var count_row = 1;
                    var balance = (data[2].length == 0 ? 0 : data[2][0].count_unit_real);
                    var balance_weight = (data[2].length == 0 ? 0 : data[2][0].weight_summary);
                    if( isNaN(parseFloat(balance_weight)/parseFloat(balance)) ||  balance == 0){
                        var balance_avg = 0 ;                              
                    }else{
                        var balance_avg = ((parseFloat(balance_weight) / parseFloat(balance)).toFixed(2)) ;
                    }
                    // console.log(balance_avg);
                    var sum_total_pig_int = 0;
                    var sum_weight_int = 0;
                    var sum_total_pig_out = 0;
                    var sum_weight_out = 0;
                    // var date_ = data[0][0].date_picker;
                    var sum_total_pig_int_total = 0;
                    var sum_weight_int_total = 0;
                    var sum_total_pig_out_total = 0;
                    var sum_weight_out_total = 0;
                    console.log(data)

                    data[0].forEach(function(element) {
                          
                      if(element.lot_number[0] === 'P' && element.id_user_customer === 'พี่บ๊อบ') {
                          statistics.ov.receive_amount += element.count_amount;
                          statistics.ov.receive_quantity += element.sum_weight;
                          statistics.ov.export_amount += element.count_amount;
                          statistics.ov.export_quantity += element.sum_weight;
                      } else if(element.lot_number[0] === 'P'){
                          statistics.customer.receive_amount += element.count_amount;
                          statistics.customer.receive_quantity += element.sum_weight;
                          statistics.customer.export_amount += element.count_amount;
                          statistics.customer.export_quantity += element.sum_weight;
                      } else if(element.lot_number[0] === 'R') {
                          statistics.branch.receive_amount += element.count_amount;
                          statistics.branch.receive_quantity += element.sum_weight;
                          statistics.branch.export_amount += element.count_amount;
                          statistics.branch.export_quantity += element.sum_weight;
                      } 
                      
                      if(element.lot_number[0] === 'P' || element.lot_number[0] === 'R' || element.id_user_customer === 'พี่บ๊อบ')  {
                        statistics.all.receive_amount += element.count_amount;
                        statistics.all.receive_quantity += element.sum_weight;
                        statistics.all.export_amount += element.count_amount;
                        statistics.all.export_quantity += element.sum_weight;
                      }
                    })

                    $('#table-carcass-statistics tbody').empty();
                    $('#table-branch-statistics tbody').empty();
                    $('#table-customer-statistics tbody').empty();
                    $('#table-all-statistics tbody').empty();
                    
                     $('#carcass').text(statistics.ov.receive_amount);
                    $('#table-carcass-statistics tbody').append(`
                    <tr>
                      <td>ตัว</td>
                      <td>${statistics.ov.receive_amount}</td>
                      <td>${statistics.ov.receive_quantity.toFixed(2)}</td>
                      <td>${statistics.ov.export_amount}</td>
                      <td>${statistics.ov.export_quantity.toFixed(2)}</td>
                    </tr>
                    `)

                    $('#branch').text(statistics.branch.receive_amount);
                    $('#table-branch-statistics tbody').append(`
                    <tr>
                      <td>ตัว</td>
                      <td>${statistics.branch.receive_amount}</td>
                      <td>${statistics.branch.receive_quantity.toFixed(2)}</td>
                      <td>${statistics.branch.export_amount}</td>
                      <td>${statistics.branch.export_quantity.toFixed(2)}</td>
                    </tr>
                    `)

                    $('#customer').text(statistics.customer.receive_amount);
                    $('#table-customer-statistics tbody').append(`
                    <tr>
                      <td>ตัว</td>
                      <td>${statistics.customer.receive_amount}</td>
                      <td>${statistics.customer.receive_quantity.toFixed(2)}</td>
                      <td>${statistics.customer.export_amount}</td>
                      <td>${statistics.customer.export_quantity.toFixed(2)}</td>
                    </tr>
                    `)

                    $('#all').text(statistics.all.receive_amount);
                    $('#table-all-statistics tbody').append(`
                    <tr>
                      <td>ตัว</td>
                      <td>${statistics.all.receive_amount}</td>
                      <td>${statistics.all.receive_quantity.toFixed(2)}</td>
                      <td>${statistics.all.export_amount}</td>
                      <td>${statistics.all.export_quantity.toFixed(2)}</td>
                    </tr>
                    `)
                     
                    if( (data[0].length == 0) || (data[6][0] == "") ){
                      

                        row = row +  '<tr style="background-color:#dffdff;">\
                                                    <td></td>\
                                                    <td></td>\
                                                    <td></td>\
                                                    <td></td>\
                                                    <td></td>\
                                                    <td></td>\
                                                    <td></td>\
                                                    <td><b>ข้อมูลการชั่งยังไม่ครบ</td>\
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
                                                </tr>';
                    }
                    else{
                                    row = row +  '<tr style="background-color:#dffdff;">\
                                                    <td></td>\
                                                    <td><b>ยอดยกมา</td>\
                                                    <td></td>\
                                                    <td></td>\
                                                    <td></td>\
                                                    <td></td>\
                                                    <td></td>\
                                                    <td></td>\
                                                    <td class="text-right">'+balance+'</td>\
                                                    <td class="text-right">'+balance_weight+'</td>\
                                                    <td class="text-right">'+balance_avg+'</td>\
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
                                                
                                    data[6].forEach(element => { 
                                        row = row + '<tr>\
                                                        <td></td>\
                                                        <td>'+element.wg_type_name_in+'</td>\
                                                        <td class="text-left"><a target="blank_" href="../summary_weighing_receive/'+element.order_number+'">'+element.order_number+'</a></td>\
                                                        <td class="text-right">'+element.id_user_customer+'</td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td>ตัว</td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td class="text-right">'+(element.count_amount_in == null || element.count_amount_in == '' || element.count_amount_in == 'null' ? '':element.count_amount_in)+'</td>\
                                                        <td class="text-right">'+(element.sum_weight_in == null || element.sum_weight_in == '' || element.sum_weight_in == 'null' ? '':(element.sum_weight_in).toFixed(2))+'</td>\
                                                        <td>'+(parseFloat(element.sum_weight_in)/parseFloat(element.count_amount_in)).toFixed(2)+'</td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                    </tr>';
                                        row = row + '<tr>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
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
                                                        <td class="text-right">'+(element.count_amount_in == null || element.count_amount_in == '' || element.count_amount_in == 'null' ? '':element.count_amount_in)+'</td>\
                                                        <td class="text-right">'+(element.sum_weight_in == null || element.sum_weight_in == '' || element.sum_weight_in == 'null' ? '':(element.sum_weight_in).toFixed(2))+'</td>\
                                                        <td>'+(parseFloat(element.sum_weight_in)/parseFloat(element.count_amount_in)).toFixed(2)+'</td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                    </tr>';
                                                    sum_total_pig_int = sum_total_pig_int + element.count_amount_in;
                                                    sum_weight_int = sum_weight_int + parseFloat(element.sum_weight_in);
                                                    // date_ = element.date;
                                                    
                                    });
                                row = row + '<tr style="background-color:#dffdff;">\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td>รวม</td>\
                                                        <td></td>\
                                                        <td class="text-right">'+balance+'</td>\
                                                        <td class="text-right">'+balance_weight+'</td>\
                                                        <td class="text-right">'+balance_avg+'</td>\
                                                        <td class="text-right">'+(sum_total_pig_int == null || sum_total_pig_int == '' || sum_total_pig_int == 'null' ? '':sum_total_pig_int)+'</td>\
                                                        <td class="text-right">'+(sum_weight_int == null ||sum_weight_int == '' || sum_weight_int == 'null' ? '':(sum_weight_int).toFixed(2))+'</td>\
                                                        <td>'+(parseFloat(sum_weight_int)/parseFloat(sum_total_pig_int)).toFixed(2)+'</td>\
                                                        <td class="text-right">'+(sum_total_pig_int == null || sum_total_pig_int == '' || sum_total_pig_int == 'null' ? '': sum_total_pig_int )+'</td>\
                                                        <td class="text-right">'+(sum_weight_int == null || sum_weight_int == '' || sum_weight_int == 'null' ? '':(sum_weight_int).toFixed(2))+'</td>\
                                                        <td>'+(parseFloat(sum_weight_int)/parseFloat(sum_total_pig_int)).toFixed(2)+'</td>\
                                                        <td>'+(sum_total_pig_int-sum_total_pig_int).toFixed(2)+'</td>\
                                                        <td>'+(sum_weight_int-sum_weight_int).toFixed(2)+'</td>\
                                                        <td></td>\
                                                    </tr>';
                                //////////////////////////////////////////////////////////////////////////////////////////////    
                                    data[6].forEach(element => { 
                                        
                                        sum_total_pig_int = 0;
                                        sum_weight_int = 0;
                                        sum_total_pig_out = 0;
                                        sum_weight_out = 0;
                                        row = row + '<tr>\
                                                        <td>'+count_row+'</td>\
                                                        <td>'+element.wg_type_name_in+'</td>\
                                                        <td class="text-left"><a target="blank_" href="../summary_weighing_receive/'+element.order_number+'">'+element.order_number+'</a></td>\
                                                        <td class="text-right">'+element.id_user_customer+'</td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td>ตัว</td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td class="text-right">'+(element.count_amount_in == null || element.count_amount_in == '' || element.count_amount_in == 'null' ? '':element.count_amount_in)+'</td>\
                                                        <td class="text-right">'+(element.sum_weight_in == null || element.sum_weight_in == '' || element.sum_weight_in == 'null' ? '':(element.sum_weight_in).toFixed(2))+'</td>\
                                                        <td>'+(parseFloat(element.sum_weight_in)/parseFloat(element.count_amount_in)).toFixed(2)+'</td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                    </tr>';
                                        row = row + '<tr>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td>ซีก</td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td class="text-right">'+(element.count_amount_out == null || element.count_amount_out == '' || element.count_amount_out == 'null' ? '':element.count_amount_out)+'</td>\
                                                        <td class="text-right">'+(element.sum_weight_out == null || element.sum_weight_out == '' || element.sum_weight_out == 'null' ? '':(element.sum_weight_out).toFixed(2))+'</td>\
                                                        <td>'+(parseFloat(element.sum_weight_out)/parseFloat(element.count_amount_out)).toFixed(2)+'</td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                    </tr>';
                                        row = row + '<tr>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td>หัว</td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td class="text-right">'+(element.count_amount_h == null || element.count_amount_h == '' || element.count_amount_h == 'null' || element.count_amount_h == 'NaN' || element.count_amount_h == NaN ? '':element.count_amount_h)+'</td>\
                                                        <td class="text-right">'+(element.sum_weight_h == null || element.sum_weight_h == '' || element.sum_weight_h == 'null' || element.count_amount_h == 'NaN' || element.count_amount_h == NaN ? '':(element.sum_weight_h).toFixed(2))+'</td>\
                                                        <td>'+(parseFloat(element.sum_weight_h)/(parseFloat(element.count_amount_h)+1)).toFixed(2)+'</td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                    </tr>';
                                        row = row + '<tr>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td>เครื่องในขาว</td>\
                                                        <td></td>\
                                                        <td>พวง</td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td class="text-right"></td>\
                                                        <td class="text-right">'+(element.sum_weight_w == null || element.sum_weight_w == '' || element.sum_weight_w == 'null' ? '':(element.sum_weight_w).toFixed(2))+'</td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                    </tr>';
                                        row = row + '<tr>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td>เครื่องในแดง</td>\
                                                        <td></td>\
                                                        <td>พวง</td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td class="text-right"></td>\
                                                        <td class="text-right">'+(element.sum_weight_r == null || element.sum_weight_r == '' || element.sum_weight_r == 'null' ? '':(element.sum_weight_r).toFixed(2))+'</td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                    </tr>';
                                        if(element.count_amount_ws != null){
                                            row = row + '<tr>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td>ของเสีย</td>\
                                                        <td></td>\
                                                        <td>กิโลกรัม</td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td class="text-right"></td>\
                                                        <td class="text-right">'+(element.sum_weight_ws == null || element.sum_weight_ws == '' || element.sum_weight_ws == 'null' ? '':(element.sum_weight_ws).toFixed(2))+'</td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                    </tr>';
                                            
                                        }
                                        sum_total_pig_int = sum_total_pig_int+element.count_amount_in;
                                        sum_weight_int = sum_weight_int+parseFloat(element.sum_weight_in);
                                        sum_total_pig_out = sum_total_pig_out+element.count_amount_out+element.count_amount_h;

                                        sum_total_pig_int_total = sum_total_pig_int_total+element.count_amount_in;
                                        sum_weight_int_total = sum_weight_int_total+parseFloat(element.sum_weight_in);
                                        sum_total_pig_out_total = sum_total_pig_out_total+element.count_amount_out;

                                        if(element.count_amount_ws != null){
                                            sum_weight_out = sum_weight_out+parseFloat(element.sum_weight_out)+parseFloat(element.sum_weight_h)+parseFloat(element.sum_weight_r)+parseFloat(+element.sum_weight_w)+parseFloat(element.sum_weight_ws);
                                        sum_weight_out_total = sum_weight_out_total+parseFloat(element.sum_weight_out)+parseFloat(element.sum_weight_h)+parseFloat(element.sum_weight_r)+parseFloat(+element.sum_weight_w)+parseFloat(element.sum_weight_ws);
                                        }else{
                                            sum_weight_out = sum_weight_out+parseFloat(element.sum_weight_out)+parseFloat(element.sum_weight_h)+parseFloat(element.sum_weight_r);
                                        sum_weight_out_total = sum_weight_out_total+parseFloat(element.sum_weight_out)+parseFloat(element.sum_weight_h)+parseFloat(element.sum_weight_r);
                                        }
                                        

                                        row = row + '<tr style="background-color:#dffdff;">\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td>รวม</td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td></td>\
                                                        <td class="text-right">'+sum_total_pig_int+'</td>\
                                                        <td class="text-right">'+sum_weight_int.toFixed(2)+'</td>\
                                                        <td>'+(parseFloat(sum_weight_int)/parseFloat((sum_total_pig_int))).toFixed(2)+'</td>\
                                                        <td class="text-right">'+sum_total_pig_out+'</td>\
                                                        <td class="text-right">'+sum_weight_out.toFixed(2)+'</td>\
                                                        <td>'+(parseFloat(sum_weight_out)/parseFloat((sum_total_pig_out))).toFixed(2)+'</td>\
                                                        <td class="text-right"></td>\
                                                        <td class="text-right">'+(sum_weight_int-sum_weight_out).toFixed(2)+'</td>\
                                                        <td></td>\
                                                    </tr>';
                                        count_row++;
                                        
                                    });

                                    row = row + '<tr style="background-color:#ff8080;">\
                                                    <td></td>\
                                                    <td></td>\
                                                    <td></td>\
                                                    <td>รวมทั้งหมด</td>\
                                                    <td></td>\
                                                    <td></td>\
                                                    <td></td>\
                                                    <td>ตัว</td>\
                                                    <td></td>\
                                                    <td></td>\
                                                    <td></td>\
                                                    <td class="text-right">'+sum_total_pig_int_total+'</td>\
                                                    <td class="text-right">'+sum_weight_int_total.toFixed(2)+'</td>\
                                                    <td>'+(parseFloat(sum_weight_int_total)/parseFloat((sum_total_pig_int_total))).toFixed(2)+'</td>\
                                                    <td class="text-right">'+sum_total_pig_out_total/2+'</td>\
                                                    <td class="text-right">'+sum_weight_out_total.toFixed(2)+'</td>\
                                                    <td>'+(parseFloat(sum_weight_out_total)/parseFloat((sum_total_pig_out_total))).toFixed(2)+'</td>\
                                                    <td class="text-right">'+(sum_total_pig_int_total-(sum_total_pig_out_total/2))+'</td>\
                                                    <td class="text-right">'+(sum_weight_int_total-sum_weight_out_total).toFixed(2)+'</td>\
                                                    <td><a href="#" data-toggle="modal" data-target="#check" ><button class="btn btn-primary">ตรวจสอบ</button></a></td>\
                                                </tr>';
                                    // count_row++;
                    }
                    

                    $('#rowStockOrder').html(row);
                    // $('#balance_without_today').html('<b>'+(balance-sum_receive_unit)+'</b>');
                    stockOrder();
                    $('#count_pig_summary').val((sum_total_pig_int_total-(sum_total_pig_out_total/2)));
                    $('#count_weight_summary').val((sum_weight_int_total-sum_weight_out_total).toFixed(2) );
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

@endsection


