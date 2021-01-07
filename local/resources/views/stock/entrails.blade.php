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

  .increase {
    background-color: #a6ffa6 !important;
  }

  .decrease {
    background-color: #ff8080 !important;
  }

  .table-hover tbody tr:hover {
    background-color: #ff625869;
  }

  .outer {
    overflow-y: auto;
    height: 650px;
  }

  .outer table {
    width: 100%;
    /* table-layout: fixed;  */
    /* border : 1px solid black; */
    border-spacing: 1px;
  }

  .outer table th {
    top: 0;
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
    <img src="{{ asset('assets/images/pig_fly.gif')}}" alt="" style="margin-left: 0px;top: 3%;width: 350px; left:37%;" class="img-responsive" />
  </div>
  <div class="card">
    <div class="card-body">

      <div class="row">
        <div class="col-lg-8">
          <h2 style="color:red;">รายงานคลังสินค้าประจำวัน #{{ $stock_name }}
            <button type="button" class="btn btn-success" title="ปรับ Stock" data-toggle="modal" data-target="#edit" href="#">
              <i class="fa fa-plus"></i></button></h2>
        </div><br>
      </div>
      <div class="row">
        <div class="col-lg-4"></div>
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
                  <p class="mb-0 text-right">ซากอุ่น (ป๊อป)</p>
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
          <div class="col-lg-2">
            <h6>ค้นหาช่วงวัน : </h6>
          </div>
          <div class="col-lg-3"></div>
          <div class="col-lg-2">
            <h6>เลขที Bill: </h6>
          </div>
          <div class="col-lg-2">
            <h6>ฟาร์ม : </h6>
          </div>
        </div>


        <div class="row">
          <div class="col-lg-3"></div>
          <div class="col-lg-2"><input class="form-control input-daterange-datepicker" type="text" id="daterangeFilter" name="daterangeFilter"
              style="padding: 0px; height: 30px;" /></div>
          <button type="button" id="filter" class="btn btn-success" onclick="search_receive()"><i class="fa fa-search"></i>ค้นหา</button>
          <div class="col-lg-2"></div>

          <div class="col-lg-2"><input type="text" class="form-control" name="bill_number" id="bill_number" style="padding: 0px; height: 30px;" /></div>
          <div class="col-lg-2"><input type="text" class="form-control" name="farm_name" id="farm_name" style="padding: 0px; height: 30px;" /></div>
        </div><br>

        <div class="table">
          <div class="outer">
            <table class="table table-striped table-bordered nowrap table-hover" width="100%" id="stockOrder">
              <thead class="text-center">
                <tr>
                  <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #ff8080;" colspan="4">รายยการ</th>
                  <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #ff8080;" rowspan="2">รหัสสินค้า</th>
                  <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #ff8080;" rowspan="2">รายยการสินค้า</th>
                  <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #ff8080;" rowspan="2">ที่จัดเก็บ</th>
                  <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #ff8080;" rowspan="2">หน่วยนับ</th>
                  <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #ff8080;" colspan="2" rowspan="1">ยกมา</th>
                  <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #ff8080;" colspan="2" rowspan="1">เข้า</th>
                  <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #ff8080;" colspan="2" rowspan="1">ออก</th>
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
                  <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #ff8080; top:35.2px;">จำนวน</th>
                  <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #ff8080; top:35.2px;">น้ำหนัก(Kg.)</th>
                  <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #ff8080; top:35.2px;">จำนวน</th>
                  <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #ff8080; top:35.2px;">น้ำหนัก(Kg.)</th>
                  <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #ff8080; top:35.2px;">จำนวน</th>
                  <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #ff8080; top:35.2px;">น้ำหนัก(Kg.)</th>
                </tr>
              </thead>
              <tbody id="rowStockOrder" class=text-center>
              </tbody>
            </table>
          </div>
        </div>
        <br>


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

  {{ Form::open(['method' => 'post' , 'url' => '/stock_data/pigpen_summary']) }}
  <div class="modal fade" id="check" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="forms-sample form-control" style="height: auto;padding-right: 20px;">
          <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;">ตรวจสอบยอดประจำวัน</div>
          <div class="row" style="margin-bottom: 10px;" id="note">
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
              <label for="count_pig_summary">จำนวนเครื่องใน</label>
              <input type="text" class="form-control form-control-sm" name="count_pig_summary" id="count_pig_summary" placeholder="0000" readonly>
            </div>
            <div class="col-md-4 pr-md-0">
              <label for="count_pig_summary">จำนวนเครื่องในที่นับจริง</label>
              <input type="number" class="form-control form-control-sm" name="count_pig_summary_real" id="count_pig_summary_real" placeholder="0000" required onchange="dif()">
            </div>
          </div>
          <div class="row" style="margin-bottom: 10px;">
            <div class="col-md-12 pr-md-0" id="note_2">
              {{-- <textarea id="w3mission" rows="4" cols="50" class="form-control form-control-sm" name="note" id="note"  placeholder=""></textarea> --}}
              {{-- <input type="text" class="form-control form-control-sm" name="note" id="note"  placeholder="" >  --}}
            </div>
          </div>
          <div class="text-center" style="padding-top: 10px;">
            <input type="text" class="form-control form-control-sm" name="id_storage" value="103" hidden>
            <button type="submit" class="btn btn-success mr-2" id="comfirmAdd" name="stock_name" value="comfirmAdd">กระทบยอด</button>
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
    $(document).ready(function () {
      dataStockOrder($("#daterangeFilter").val());
      stockReceive($("#daterangeReceive").val());
      stockHistorySend($("#daterangeOrderSend").val());
      stockBalance($("#daterangeStockBalance").val());
    });

    function search_receive() {
      stockReceive($("#daterangeReceive").val());
    }
    function search_Order_send() {
      stockHistorySend($("#daterangeOrderSend").val());
    }
    function search_StockBalance() {
      stockBalance($("#daterangeStockBalance").val());
    }
    function search_receive() {
      var table = $('#stockOrder').DataTable();
      table.destroy();//ลบdatatableเก่าทิ้ง
      dataStockOrder($("#daterangeFilter").val()); //get value ใหม่ แล้วสร้างdatatableใหม่
    }

  </script>

  <script>
    function dataStockOrder(daterangeFilter) {

      $.ajax({
        type: 'GET',
        dataType: 'JSON',
        url: `{{ url('stock_of_entrails') }}`,
        data: { daterangeFilter: daterangeFilter },
        beforeSend: function () {
          $('.ajax-loader').css("visibility", "visible");
        },
        success: function (data) {
          
          var statistics = {
                bob: {
                  whiteOffal: {
                    receive_amount: 0,
                    receive_quantity: 0,
                    export_amount: 0,
                    export_quantity: 0,
                  },
                  redOffal: {
                    receive_amount: 0,
                    receive_quantity: 0,
                    export_amount: 0,
                    export_quantity: 0,
                  },
                  head: {
                    receive_amount: 0,
                    receive_quantity: 0,
                    export_amount: 0,
                    export_quantity: 0,
                  }
                },
                branch:  {
                  whiteOffal: {
                    receive_amount: 0,
                    receive_quantity: 0,
                    export_amount: 0,
                    export_quantity: 0,
                  },
                  redOffal: {
                    receive_amount: 0,
                    receive_quantity: 0,
                    export_amount: 0,
                    export_quantity: 0,
                  },
                  head: {
                    receive_amount: 0,
                    receive_quantity: 0,
                    export_amount: 0,
                    export_quantity: 0,
                  }
                },
                customer:{
                  whiteOffal: {
                    receive_amount: 0,
                    receive_quantity: 0,
                    export_amount: 0,
                    export_quantity: 0,
                  },
                  redOffal: {
                    receive_amount: 0,
                    receive_quantity: 0,
                    export_amount: 0,
                    export_quantity: 0,
                  },
                  head: {
                    receive_amount: 0,
                    receive_quantity: 0,
                    export_amount: 0,
                    export_quantity: 0,
                  }
                },
                all: {
                  whiteOffal: {
                    receive_amount: 0,
                    receive_quantity: 0,
                    export_amount: 0,
                    export_quantity: 0,
                  },
                  redOffal: {
                    receive_amount: 0,
                    receive_quantity: 0,
                    export_amount: 0,
                    export_quantity: 0,
                  },
                  head: {
                    receive_amount: 0,
                    receive_quantity: 0,
                    export_amount: 0,
                    export_quantity: 0,
                  }
                }
            }

          var row = '';
          var balance = (data[2].length == 0 ? 0 : data[2][0].balance);
          var balance_weight = (data[2].length == 0 ? 0 : data[2][0].weight_summary);
          var count_row = 1;

          var sum_in = 0;
          var sum_in_weight = 0;
          var sum_out = 0;
          var sum_out_weight = 0;

          var sum_in_ = 0;
          var sum_in_weight_ = 0;
          var sum_out_ = 0;

          var sum_out_weight_ = 0;
          var sum_out_t = 0;
          var sum_out_weight_t = 0;
          var sum_out_t_ = 0;
          var sum_out_weight_t_ = 0;

          var sum_out_weight_a = 0;
          var sum_out_ta = 0;
          var sum_out_weight_ta = 0;
          var sum_out_t_a = 0;
          var sum_out_weight_t_a = 0;


          var date_ = '';
          var oder = '';

          row = row + '<tr style="background-color:#dffdff;">\
                                    <td></td>\
                                    <td><b>ยอดยกมา</td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td class="text-right" id="balance_without_today">'+ balance + '</td>\
                                    <td class="text-right" id="balance_without_today">'+ balance_weight + '</td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                </tr>';
          data[0].forEach(element => {
            if(element.lot_number[0] === 'P' && element.id_user_customer === 'พี่บ๊อบ') {
              if(element.item_code === '5005') {
                  statistics.bob.whiteOffal.receive_amount += element.count_amount;
                  statistics.bob.whiteOffal.receive_quantity += element.sum_weight;
              } else if (element.item_code  === '6001') {
                  statistics.bob.redOffal.receive_amount += element.count_amount;
                  statistics.bob.redOffal.receive_quantity += element.sum_weight;
              } else if (element.item_code  === '6002') {
                  statistics.bob.head.receive_amount += element.count_amount;
                  statistics.bob.head.receive_quantity += element.sum_weight;
              }
            }
          
            if(element.lot_number[0] === 'R') {
              if(element.item_code === '5005') {
                  statistics.branch.whiteOffal.receive_amount += element.count_amount;
                  statistics.branch.whiteOffal.receive_quantity += element.sum_weight;
              } else if (element.item_code  === '6001') {
                  statistics.branch.redOffal.receive_amount += element.count_amount;
                  statistics.branch.redOffal.receive_quantity += element.sum_weight;
              } else if (element.item_code  === '6002') {
                  statistics.branch.head.receive_amount += element.count_amount;
                statistics.branch.head.receive_quantity += element.sum_weight;
              }
            } else if(element.type_request === '2' && element.id_user_customer !== 'พี่บ๊อบ') {
              if(element.item_code === '5005') {
                  statistics.customer.whiteOffal.receive_amount += element.count_amount;
                  statistics.customer.whiteOffal.receive_quantity += element.sum_weight;
              } else if (element.item_code  === '6001') {
                  statistics.customer.redOffal.receive_amount += element.count_amount;
                statistics.customer.redOffal.receive_quantity += element.sum_weight;
              }else if (element.item_code  === '6002') {
                statistics.customer.head.receive_amount += element.count_amount;
                statistics.customer.head.receive_quantity += element.sum_weight;
              }
            }



            row = row + '<tr>\
                                        <td>'+ count_row + '</td>';

            if (oder != element.lot_number) {
              oder = element.lot_number;
              row = row + '<td>' + element.wg_type_name + '</td>\
                                            <td class="text-left"><a target="blank_" href="../summary_weighing_receive/'+ element.lot_number + '">' + element.lot_number + '</a></td>\
                                            <td class="text-right">'+ (element.id_user_customer == null || element.id_user_customer == '' || element.id_user_customer == 'null' ? '' : element.id_user_customer) + '</td>';
            } else {
              row = row + '<td></td><td></td><td></td>';
            }
            row = row + '<td>' + element.item_code + '</td>\
                                    <td>'+ element.item_name + '</td>\
                                    <td>'+ element.storage_name + '</td>\
                                    <td>'+ element.unit + '</td>\
                                    <td></td>\
                                    <td></td>\
                                    <td class="text-right">'+ (element.count_amount == null || element.count_amount == '' || element.count_amount == 'null' ? '-' : element.count_amount) + '</td>\
                                    <td class="text-right">'+ ((parseFloat(element.sum_weight)).toFixed(4) == null || (parseFloat(element.sum_weight)).toFixed(4) == '' || (parseFloat(element.sum_weight)).toFixed(4) == 'null' || (parseFloat(element.sum_weight)).toFixed(4) == 0 || (parseFloat(element.sum_weight)).toFixed(4) == 'NaN' ? '-' : (parseFloat(element.sum_weight)).toFixed(4)) + '</td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td>'+ (element.note == null || element.note == '' || element.note == 'null' ? '' : element.note) + '</td>\
                                </tr>';
            count_row++;
            sum_in = sum_in + element.count_amount;
            sum_in_weight = sum_in_weight + element.sum_weight;
          });


          data[1].forEach(element => {
            if(element.lot_number[0] === 'O' && element.id_user_customer === 'พี่บ๊อบ') {
              if(element.item_code === '5001' || element.item_code === '5003' || element.item_code === '5004' || element.item_code === '5005' || element.item_code === '5006' || element.item_code === '5007' || element.item_code === '5008' ||element.item_code  === '1109') {
                  statistics.bob.whiteOffal.export_amount += element.count_amount;
                  statistics.bob.whiteOffal.export_quantity += element.sum_weight;
              } else if (element.item_code  === '6001' || element.item_code  === '5002' || element.item_code  === '1020') {
                  statistics.bob.redOffal.export_amount += element.count_amount;
                  statistics.bob.redOffal.export_quantity += element.sum_weight;
              }else if (element.item_code  === '6002') {
                  statistics.bob.head.export_amount += element.count_amount;
                  statistics.bob.head.export_quantity += element.sum_weight;
              }
            }
          
            if(element.lot_number[0] === 'O' && element.id_user_customer.includes('สาขา')) {
              console.log(element.item_code)
              if(element.item_code === '5001' || element.item_code === '5003' || element.item_code === '5004' || element.item_code === '5005' || element.item_code === '5006' || element.item_code === '5007' || element.item_code === '5008' ||element.item_code  === '1109') {
                statistics.branch.whiteOffal.export_amount += element.count_amount;
                statistics.branch.whiteOffal.export_quantity += element.sum_weight;
              } else if (element.item_code  === '6001' || element.item_code  === '5002' || element.item_code  === '1020') {
                statistics.branch.redOffal.export_amount += element.count_amount;
                statistics.branch.redOffal.export_quantity += element.sum_weight;
              }else if (element.item_code  === '6002') {
                statistics.branch.head.export_amount += element.count_amount;
                statistics.branch.head.export_quantity += element.sum_weight;
              }
            } else if(element.lot_number[0] === 'O' && element.id_user_customer !== 'พี่บ๊อบ') {
              if(element.item_code === '5001' || element.item_code === '5003' || element.item_code === '5004' || element.item_code === '5005' || element.item_code === '5006' || element.item_code === '5007' || element.item_code === '5008' ||element.item_code  === '1109') {
                  statistics.customer.whiteOffal.export_amount += element.count_amount;
                  statistics.customer.whiteOffal.export_quantity += element.sum_weight;
              } else if (element.item_code  === '6001' || element.item_code  === '5002' || element.item_code  === '1020') {
                  statistics.customer.redOffal.export_amount += element.count_amount;
                statistics.customer.redOffal.export_quantity += element.sum_weight;
              }else if (element.item_code  === '6002') {
                statistics.customer.head.export_amount += element.count_amount;
                statistics.customer.head.export_quantity += element.sum_weight;
              }
            }
            
            if (oder != element.lot_number) {
              oder = element.lot_number;
              if (sum_out_ != 0 && sum_out_weight_ != 0) {
                row = row + '<tr style="background-color:#dffdff;">\
                                        <td></td>\
                                        <td></td>\
                                        <td></td>\
                                        <td></td>\
                                        <td></td>\
                                        <td></td>\
                                        <td><b>รวม</td>\
                                        <td></td>\
                                        <td></td>\
                                        <td></td>\
                                        <td></td>\
                                        <td></td>\
                                        <td class="text-right">'+ sum_out_ + '</td>\
                                        <td class="text-right">'+ sum_out_weight_.toFixed(4) + '</td>\
                                        <td></td>\
                                        <td></td>\
                                        <td></td>\
                                     </tr>';
                sum_out_ = 0;
                sum_out_weight_ = 0;
              }

              row = row + '<tr>\
                                        <td>'+ count_row + '</td>\
                                        <td>'+ element.wg_type_name + '</td>\
                                        <td class="text-left"><a target="blank_" href="../summary_weighing_receive/'+ element.lot_number + '">' + element.lot_number + '</a></td>\
                                        <td class="text-right">'+ (element.id_user_customer == null || element.id_user_customer == '' || element.id_user_customer == 'null' ? '' : element.id_user_customer) + '</td>';
            }
            else {
              row = row + '<tr>\
                                        <td>'+ count_row + '</td>\
                                        <td></td><td></td><td></td>';
            }

            row = row + '   <td>' + (element.sku_code == null || element.sku_code == '' || element.sku_code == 'null' ? '' : element.sku_code) + '</td>\
                                        <td>'+ (element.item_name == null || element.item_name == '' || element.item_name == 'null' ? '' : element.item_name) + '</td>\
                                        <td>'+ (element.storage_name == null || element.storage_name == '' || element.storage_name == 'null' ? '' : element.storage_name) + '</td>\
                                        <td>'+ (element.unit == null || element.unit == '' || element.unit == 'null' ? '-' : element.unit) + '</td>\
                                        <td></td>\
                                        <td></td>\
                                        <td></td>\
                                        <td></td>\
                                        <td class="text-right">'+ (element.count_amount == null || element.count_amount == '' || element.count_amount == 'null' ? '' : element.count_amount) + '</td>\
                                        <td class="text-right">'+ (element.sum_weight == null || element.sum_weight == '' || element.sum_weight == 'null' ? '' : (element.sum_weight).toFixed(4)) + '</td>\
                                        <td></td>\
                                        <td></td>\
                                        <td></td>\
                                     </tr>';
            count_row++;
            sum_out = sum_out + element.count_amount;
            sum_out_weight = sum_out_weight + element.sum_weight;

            sum_out_ = sum_out_ + element.count_amount;
            sum_out_weight_ = sum_out_weight_ + element.sum_weight;


          });

                
          row = row + '<tr style="background-color:#dffdff;">\
                                        <td></td>\
                                        <td></td>\
                                        <td></td>\
                                        <td></td>\
                                        <td></td>\
                                        <td></td>\
                                        <td><b>รวม</td>\
                                        <td></td>\
                                        <td></td>\
                                        <td></td>\
                                        <td></td>\
                                        <td></td>\
                                        <td class="text-right">'+ sum_out_ + '</td>\
                                        <td class="text-right">'+ sum_out_weight_.toFixed(4) + '</td>\
                                        <td></td>\
                                        <td></td>\
                                        <td></td>\
                                     </tr>';
          oder = '';
          data[4].forEach(element => {
            if(element.lot_number[0] === 'O' && element.id_user_customer === 'พี่บ๊อบ') {
              if(element.item_code === '5005') {
                  statistics.bob.whiteOffal.export_amount += element.count_amount;
                  statistics.bob.whiteOffal.export_quantity += element.sum_weight;
              } else if (element.item_code  === '6001') {
                  statistics.bob.redOffal.export_amount += element.count_amount;
                  statistics.bob.redOffal.export_quantity += element.sum_weight;
              }else if (element.item_code  === '6002') {
                  statistics.bob.head.export_amount += element.count_amount;
                  statistics.bob.head.export_quantity += element.sum_weight;
              }
            }
          
            if(element.lot_number[0] === 'O' && element.id_user_customer.includes('สาขา')) {
              if(element.item_code === '5005') {
                statistics.branch.whiteOffal.export_amount += element.count_amount;
                statistics.branch.whiteOffal.export_quantity += element.sum_weight;
              } else if (element.item_code  === '6001') {
                statistics.branch.redOffal.export_amount += element.count_amount;
                statistics.branch.redOffal.export_quantity += element.sum_weight;
              }else if (element.item_code  === '6002') {
                statistics.branch.head.export_amount += element.count_amount;
                statistics.branch.head.export_quantity += element.sum_weight;
              }
            } else if(element.lot_number[0] === 'O' && element.id_user_customer !== 'พี่บ๊อบ') {
              if(element.item_code === '5005') {
                  statistics.customer.whiteOffal.export_amount += element.count_amount;
                statistics.customer.whiteOffal.export_quantity += element.sum_weight;
                
              } else if (element.item_code  === '6001') {
                  statistics.customer.redOffal.export_amount += element.count_amount;
                statistics.customer.redOffal.export_quantity += element.sum_weight;
                
              }else if (element.item_code  === '6002') {
                statistics.customer.head.export_amount += element.count_amount;
                statistics.customer.head.export_quantity += element.sum_weight;
              }
            }
            if (oder != element.lot_number) {
              oder = element.lot_number;
              if (sum_out_t != 0 && sum_out_weight_t != 0) {
                row = row + '<tr style="background-color:#dffdff;">\
                                        <td></td>\
                                        <td></td>\
                                        <td></td>\
                                        <td></td>\
                                        <td></td>\
                                        <td></td>\
                                        <td><b>รวม</td>\
                                        <td></td>\
                                        <td></td>\
                                        <td></td>\
                                        <td></td>\
                                        <td></td>\
                                        <td class="text-right">'+ sum_out_t_ + '</td>\
                                        <td class="text-right">'+ sum_out_weight_t_.toFixed(4) + '</td>\
                                        <td></td>\
                                        <td></td>\
                                        <td></td>\
                                     </tr>';
                sum_out_t_ = 0;
                sum_out_weight_t_ = 0;
              }

              row = row + '<tr>\
                                        <td>'+ count_row + '</td>\
                                        <td>'+ element.wg_type_name + '</td>\
                                        <td class="text-left"><a target="blank_" href="../summary_weighing_receive/'+ element.lot_number + '">' + element.lot_number + '</a></td>\
                                        <td class="text-right">'+ (element.id_user_customer == null || element.id_user_customer == '' || element.id_user_customer == 'null' ? '' : element.id_user_customer) + '</td>';
            }
            else {
              row = row + '<tr>\
                                        <td>'+ count_row + '</td>\
                                        <td></td><td></td><td></td>';
            }
            row = row + '<td>' + element.item_code + '</td>\
                                    <td>'+ element.item_name + '</td>\
                                    <td>'+ element.storage_name + '</td>\
                                    <td>'+ element.unit + '</td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td class="text-right">'+ (element.count_amount == null || element.count_amount == '' || element.count_amount == 'null' ? '-' : element.count_amount) + '</td>\
                                    <td class="text-right">'+ ((parseFloat(element.sum_weight)).toFixed(4) == null || (parseFloat(element.sum_weight)).toFixed(4) == '' || (parseFloat(element.sum_weight)).toFixed(4) == 'null' || (parseFloat(element.sum_weight)).toFixed(4) == 0 || (parseFloat(element.sum_weight)).toFixed(4) == 'NaN' ? '-' : (parseFloat(element.sum_weight)).toFixed(4)) + '</td>\
                                    <td></td>\
                                    <td></td>\
                                    <td>'+ (element.note == null || element.note == '' || element.note == 'null' ? '' : element.note) + '</td>\
                                </tr>';
            count_row++;
            sum_out_t = sum_out_t + element.count_amount;
            sum_out_weight_t = sum_out_weight_t + element.sum_weight;
            sum_out_t_ = sum_out_t_ + element.count_amount;
            sum_out_weight_t_ = sum_out_weight_t_ + element.sum_weight;
          });
          row = row + '<tr style="background-color:#dffdff;">\
                                        <td></td>\
                                        <td></td>\
                                        <td></td>\
                                        <td></td>\
                                        <td></td>\
                                        <td></td>\
                                        <td><b>รวม</td>\
                                        <td></td>\
                                        <td></td>\
                                        <td></td>\
                                        <td></td>\
                                        <td></td>\
                                        <td class="text-right">'+ sum_out_t_ + '</td>\
                                        <td class="text-right">'+ sum_out_weight_t_.toFixed(4) + '</td>\
                                        <td></td>\
                                        <td></td>\
                                        <td></td>\
                                     </tr>';
          oder = '';
          data[5].forEach(element => {
            if(element.lot_number[0] === 'O' && element.id_user_customer === 'พี่บ๊อบ') {
              if(element.item_code === '5005') {
                  statistics.bob.whiteOffal.export_amount += element.count_amount;
                  statistics.bob.whiteOffal.export_quantity += element.sum_weight;
              } else if (element.item_code  === '6001') {
                  statistics.bob.redOffal.export_amount += element.count_amount;
                  statistics.bob.redOffal.export_quantity += element.sum_weight;
              }else if (element.item_code  === '6002') {
                  statistics.bob.head.export_amount += element.count_amount;
                  statistics.bob.head.export_quantity += element.sum_weight;
              }
            }
          
            if(element.lot_number[0] === 'O' && element.id_user_customer.includes('สาขา')) {
              if(element.item_code === '5005') {
                statistics.branch.whiteOffal.export_amount += element.count_amount;
                statistics.branch.whiteOffal.export_quantity += element.sum_weight;
              } else if (element.item_code  === '6001') {
                statistics.branch.redOffal.export_amount += element.count_amount;
                statistics.branch.redOffal.export_quantity += element.sum_weight;
              }else if (element.item_code  === '6002') {
                statistics.branch.head.export_amount += element.count_amount;
                statistics.branch.head.export_quantity += element.sum_weight;
              }
            } else if(element.lot_number[0] === 'O' && element.id_user_customer !== 'พี่บ๊อบ') {
              if(element.item_code === '5005') {
                  statistics.customer.whiteOffal.export_amount += element.count_amount;
                statistics.customer.whiteOffal.export_quantity += element.sum_weight;
                
              } else if (element.item_code  === '6001') {
                  statistics.customer.redOffal.export_amount += element.count_amount;
                statistics.customer.redOffal.export_quantity += element.sum_weight;
                
              }else if (element.item_code  === '6002') {
                statistics.customer.head.export_amount += element.count_amount;
                statistics.customer.head.export_quantity += element.sum_weight;
              }
            }
            if (oder != element.lot_number) {
              oder = element.lot_number;
              if (sum_out_ta != 0 && sum_out_weight_ta != 0) {
                row = row + '<tr style="background-color:#dffdff;">\
                                        <td></td>\
                                        <td></td>\
                                        <td></td>\
                                        <td></td>\
                                        <td></td>\
                                        <td></td>\
                                        <td><b>รวม</td>\
                                        <td></td>\
                                        <td></td>\
                                        <td></td>\
                                        <td></td>\
                                        <td></td>\
                                        <td class="text-right">'+ sum_out_t_a + '</td>\
                                        <td class="text-right">'+ sum_out_weight_t_a.toFixed(4) + '</td>\
                                        <td></td>\
                                        <td></td>\
                                        <td></td>\
                                     </tr>';
                sum_out_t_a = 0;
                sum_out_weight_t_a = 0;
              }

              row = row + '<tr>\
                                        <td>'+ count_row + '</td>\
                                        <td>'+ element.wg_type_name + '</td>\
                                        <td class="text-left"><a target="blank_" href="../summary_weighing_receive/'+ element.lot_number + '">' + element.lot_number + '</a></td>\
                                        <td class="text-right">'+ (element.id_user_customer == null || element.id_user_customer == '' || element.id_user_customer == 'null' ? '' : element.id_user_customer) + '</td>';
            }
            else {
              row = row + '<tr>\
                                        <td>'+ count_row + '</td>\
                                        <td></td><td></td><td></td>';
            }
            row = row + '<td>' + element.item_code + '</td>\
                                    <td>'+ element.item_name + '</td>\
                                    <td>'+ element.storage_name + '</td>\
                                    <td>'+ element.unit + '</td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td class="text-right">'+ (element.count_amount == null || element.count_amount == '' || element.count_amount == 'null' ? '-' : element.count_amount) + '</td>\
                                    <td class="text-right">'+ ((parseFloat(element.sum_weight)).toFixed(4) == null || (parseFloat(element.sum_weight)).toFixed(4) == '' || (parseFloat(element.sum_weight)).toFixed(4) == 'null' || (parseFloat(element.sum_weight)).toFixed(4) == 0 || (parseFloat(element.sum_weight)).toFixed(4) == 'NaN' ? '-' : (parseFloat(element.sum_weight)).toFixed(4)) + '</td>\
                                    <td></td>\
                                    <td></td>\
                                    <td>'+ (element.note == null || element.note == '' || element.note == 'null' ? '' : element.note) + '</td>\
                                </tr>';
            count_row++;
            sum_out_ta = sum_out_t + element.count_amount;
            sum_out_weight_ta = sum_out_weight_t + element.sum_weight;
            sum_out_t_a = sum_out_t_a + element.count_amount;
            sum_out_weight_t_a = sum_out_weight_t_a + element.sum_weight;
          });

          row = row + '<tr style="background-color:#dffdff;">\
                                        <td></td>\
                                        <td></td>\
                                        <td></td>\
                                        <td></td>\
                                        <td></td>\
                                        <td></td>\
                                        <td><b>รวม</td>\
                                        <td></td>\
                                        <td></td>\
                                        <td></td>\
                                        <td></td>\
                                        <td></td>\
                                        <td class="text-right">'+ sum_out_t_a + '</td>\
                                        <td class="text-right">'+ sum_out_weight_t_a.toFixed(4) + '</td>\
                                        <td></td>\
                                        <td></td>\
                                        <td></td>\
                                     </tr>';
          oder = '';

          row = row + '<tr style="background-color:#ff8080;">\
                                    <td></td>\
                                    <td><b>สรุป</td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td class="text-right" id="balance_without_today">'+ balance + '</td>\
                                    <td class="text-right" id="balance_without_today">'+ balance_weight + '</td>\
                                    <td class="text-right">'+ sum_in + '</td>\
                                    <td class="text-right">'+ sum_in_weight.toFixed(4) + '</td>\
                                    <td class="text-right">'+ sum_out + sum_out_t + sum_out_ta + '</td>\
                                    <td class="text-right">'+ (sum_out_weight + sum_out_weight_t + sum_out_weight_ta).toFixed(4) + '</td>\
                                    <td class="text-right">'+ (parseFloat(balance) + sum_in - (sum_out + sum_out_t + sum_out_weight_ta)) + '</td>\
                                    <td class="text-right">'+ ((parseFloat(balance_weight) + sum_in_weight) - (sum_out_weight + sum_out_weight_t + sum_out_weight_ta)).toFixed(4) + '</td>\
                                    <td></td>\
                                </tr>';
          //<td><a href="#" data-toggle="modal" data-target="#check" ><button class="btn btn-primary">ตรวจสอบ</button></a></td>\

          //                 data[3].forEach(element => {
          // row = row +  '<tr style="background-color:#ff8080;">\
          //                     <td></td>\
          //                     <td><b></td>\
          //                     <td></td>\
          //                     <td></td>\
          //                     <td></td>\
          //                     <td></td>\
          //                     <td></td>\
          //                     <td></td>\
          //                     <td></td>\
          //                     <td></td>\
          //                     <td></td>\
          //                     <td></td>\
          //                     <td>ยอดนับจริง</td>\
          //                     <td>'+(element.count_unit_real == null || element.count_unit_real == '' || element.count_unit_real == 'null' ? '':element.count_unit_real)+'</td>\
          //                     <td></td>\
          //                     <td>'+(element.description == null || element.description == '' || element.description == 'null' ? '':element.description)+'</td>\
          //                 </tr>';
          // });

                statistics.all.whiteOffal.receive_amount = statistics.branch.whiteOffal.receive_amount + statistics.customer.whiteOffal.receive_amount;
                statistics.all.whiteOffal.receive_quantity = statistics.branch.whiteOffal.receive_quantity + statistics.customer.whiteOffal.receive_quantity;
                statistics.all.whiteOffal.export_amount = statistics.branch.whiteOffal.export_amount + statistics.customer.whiteOffal.export_amount;
                statistics.all.whiteOffal.export_quantity = statistics.branch.whiteOffal.export_quantity + statistics.customer.whiteOffal.export_quantity;

                statistics.all.redOffal.export_amount = statistics.branch.redOffal.export_amount + statistics.customer.redOffal.export_amount;
                statistics.all.redOffal.export_quantity = statistics.branch.redOffal.export_quantity + statistics.customer.redOffal.export_quantity;
                statistics.all.redOffal.receive_amount = statistics.branch.redOffal.receive_amount + statistics.customer.redOffal.receive_amount;
                statistics.all.redOffal.receive_quantity = statistics.branch.redOffal.receive_quantity + statistics.customer.redOffal.receive_quantity;

                statistics.all.head.receive_amount = statistics.branch.head.receive_amount + statistics.customer.head.receive_amount;
                statistics.all.head.receive_quantity = statistics.branch.head.receive_quantity + statistics.customer.head.receive_quantity;
                statistics.all.head.export_amount = statistics.branch.head.export_amount + statistics.customer.head.export_amount;
                statistics.all.head.export_quantity = statistics.branch.head.export_quantity + statistics.customer.head.export_quantity;
                
              $('#table-carcass-statistics tbody').empty();
              $('#table-branch-statistics tbody').empty();
              $('#table-customer-statistics tbody').empty();
              $('#table-all-statistics tbody').empty();
              
              $('#carcass').text(statistics.bob.whiteOffal.receive_amount + statistics.bob.redOffal.receive_amount + statistics.bob.head.receive_amount);
              $('#table-carcass-statistics tbody').append(`
              <tr>
                <td>เครื่องในขาว</td>
                <td>${statistics.bob.whiteOffal.receive_amount}</td>
                <td>${statistics.bob.whiteOffal.receive_quantity.toFixed(2)}</td>
                <td>${statistics.bob.whiteOffal.export_amount}</td>
                <td>${statistics.bob.whiteOffal.export_quantity.toFixed(2)}</td>
              </tr>
              <tr>
                <td>เครื่องในแดง</td>
                <td>${statistics.bob.redOffal.receive_amount}</td>
                <td>${statistics.bob.redOffal.receive_quantity.toFixed(2)}</td>
                <td>${statistics.bob.redOffal.export_amount}</td>
                <td>${statistics.bob.redOffal.export_quantity.toFixed(2)}</td>
              </tr>
              <tr>
                <td>หัว</td>
                <td>${statistics.bob.head.receive_amount}</td>
                <td>${statistics.bob.head.receive_quantity.toFixed(2)}</td>
                <td>${statistics.bob.head.export_amount}</td>
                <td>${statistics.bob.head.export_quantity.toFixed(2)}</td>
              </tr>
              `)

              $('#branch').text(statistics.branch.whiteOffal.receive_amount + statistics.branch.redOffal.receive_amount + statistics.branch.head.receive_amount);
              $('#table-branch-statistics tbody').append(`
              <tr>
                <td>เครื่องในขาว</td>
                <td>${statistics.branch.whiteOffal.receive_amount}</td>
                <td>${statistics.branch.whiteOffal.receive_quantity.toFixed(2)}</td>
                <td>${statistics.branch.whiteOffal.export_amount}</td>
                <td>${statistics.branch.whiteOffal.export_quantity.toFixed(2)}</td>
              </tr>
              <tr>
                <td>เครื่องในแดง</td>
                <td>${statistics.branch.redOffal.receive_amount}</td>
                <td>${statistics.branch.redOffal.receive_quantity.toFixed(2)}</td>
                <td>${statistics.branch.redOffal.export_amount}</td>
                <td>${statistics.branch.redOffal.export_quantity.toFixed(2)}</td>
              </tr>
              <tr>
                <td>หัว</td>
                <td>${statistics.branch.head.receive_amount}</td>
                <td>${statistics.branch.head.receive_quantity.toFixed(2)}</td>
                <td>${statistics.branch.head.export_amount}</td>
                <td>${statistics.branch.head.export_quantity.toFixed(2)}</td>
              </tr>
              `)

              $('#customer').text(statistics.customer.whiteOffal.receive_amount + statistics.customer.redOffal.receive_amount + statistics.customer.head.receive_amount);
              $('#table-customer-statistics tbody').append(`
              <tr>
                <td>เครื่องในขาว</td>
                <td>${statistics.customer.whiteOffal.receive_amount}</td>
                <td>${statistics.customer.whiteOffal.receive_quantity.toFixed(2)}</td>
                <td>${statistics.customer.whiteOffal.export_amount}</td>
                <td>${statistics.customer.whiteOffal.export_quantity.toFixed(2)}</td>
              </tr>
              <tr>
                <td>เครื่องในแดง</td>
                <td>${statistics.customer.redOffal.receive_amount}</td>
                <td>${statistics.customer.redOffal.receive_quantity.toFixed(2)}</td>
                <td>${statistics.customer.redOffal.export_amount}</td>
                <td>${statistics.customer.redOffal.export_quantity.toFixed(2)}</td>
              </tr>
              <tr>
                <td>หัว</td>
                <td>${statistics.customer.head.receive_amount}</td>
                <td>${statistics.customer.head.receive_quantity.toFixed(2)}</td>
                <td>${statistics.customer.head.export_amount}</td>
                <td>${statistics.customer.head.export_quantity.toFixed(2)}</td>
              </tr>
              `)

              $('#all').text(statistics.all.whiteOffal.receive_amount + statistics.all.redOffal.receive_amount + statistics.all.head.receive_amount);
              $('#table-all-statistics tbody').append(`
              <tr>
                <td>เครื่องในขาว</td>
                <td>${statistics.all.whiteOffal.receive_amount}</td>
                <td>${statistics.all.whiteOffal.receive_quantity.toFixed(2)}</td>
                <td>${statistics.all.whiteOffal.export_amount}</td>
                <td>${statistics.all.whiteOffal.export_quantity.toFixed(2)}</td>
              </tr>
              <tr>
                <td>เครื่องในแดง</td>
                <td>${statistics.all.redOffal.receive_amount}</td>
                <td>${statistics.all.redOffal.receive_quantity.toFixed(2)}</td>
                <td>${statistics.all.redOffal.export_amount}</td>
                <td>${statistics.all.redOffal.export_quantity.toFixed(2)}</td>
              </tr>
              <tr>
                <td>หัว</td>
                <td>${statistics.all.head.receive_amount}</td>
                <td>${statistics.all.head.receive_quantity.toFixed(2)}</td>
                <td>${statistics.all.head.export_amount}</td>
                <td>${statistics.all.head.export_quantity.toFixed(2)}</td>
              </tr>
              `)

          $('#rowStockOrder').html(row);
          // $('#balance_without_today').html('<b>'+(balance-sum_receive_unit)+'</b>');
          stockOrder();
          $('#count_pig_summary').val((parseFloat(balance) + sum_in - (sum_out)));
          $('#date_summary').val(date_);


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
              daysOfWeek: [
                "อา.",
                "จ.",
                "อ.",
                "พ.",
                "พฤ.",
                "ศ.",
                "ส."
              ],
              monthNames: [
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
              firstDay: 0
            }
          });




        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
          alert("Status: " + textStatus); alert("Error: " + errorThrown);
        },
        complete: function () {
          $('.ajax-loader').css("visibility", "hidden");
        }
      });

    }
  </script>


  <script>
    function stockOrder() {

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
            messageTop: " รายงานเคลื่อนไหวหมู (Stock) วันที่ " + $('#daterangeFilter').val() + " ",
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
    function stockHistorySend(orderFilter) {


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
          url: `{{ url('stock_pp1_send') }}`,
          data: { orderFilter: orderFilter },
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
            "targets": 9, render(data, type, row) {
              return '<button>แก้ไข</button>'
            },
            "className": "text-center",
          },
        ],
        "order": [],
      });

      table.on('order.dt search.dt', function () {
        table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
          cell.innerHTML = i + 1;
        });
      }).draw();

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
        daysOfWeek: [
          "อา.",
          "จ.",
          "อ.",
          "พ.",
          "พฤ.",
          "ศ.",
          "ส."
        ],
        monthNames: [
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
        firstDay: 0
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
        daysOfWeek: [
          "อา.",
          "จ.",
          "อ.",
          "พ.",
          "พฤ.",
          "ศ.",
          "ส."
        ],
        monthNames: [
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
        firstDay: 0
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
        daysOfWeek: [
          "อา.",
          "จ.",
          "อ.",
          "พ.",
          "พฤ.",
          "ศ.",
          "ส."
        ],
        monthNames: [
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
        firstDay: 0
      }
    });

  </script>

  <script>
    function edit_price(order_number, price) {
      var sign = "'";
      $('#edit_price_data').html('<div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;">ราคา/กก.   ' + order_number + '</div\
                                    <div class="row" style="margin-bottom: 10px;">\
                                        <div class="col-md-12 pr-md-0">\
                                            <input type="text" class="form-control form-control-sm" id="price" name="price"  value="'+ price + '" required>\
                                        </div>\
                                    </div>\
                                    <div class="text-center" style="padding-top: 10px;">\
                                        <button type="submit" class="btn btn-success mr-2" id="comfirmAdd" onclick="save_price('+ sign + order_number + sign + ')" name="order_number" value="' + order_number + '">ยืนยัน</button>\
                                    </div>');
    }


  </script>

  <script type="text/javascript">
    function save_price(order_number) {
      var price = $("#price").val();

      $('#edit_price').modal('hide');

      $.ajax({
        type: 'GET',
        dataType: 'JSON',
        url: `{{ url('stock_data/edit_price') }`,
        data: { order_number: order_number, price: price },
        beforeSend: function () {
          $('.ajax-loader').css("visibility", "visible");
        },
        success: function (msg) {
          if (msg === 0) {
            alert('แก้ไขสำเร็จ');
          }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
          alert("Status: " + textStatus); alert("Error: " + errorThrown);
        },
        complete: function () {
          search_receive()
        },
      });
    }
  </script>

  <script>
    var c = 0;
    function dif() {
      // alert("123");
      sum_pic = $('#count_pig_summary').val();
      sum_pic_real = $('#count_pig_summary_real').val();
      r = '<label for="count_pig_summary" id="note" >สาเหตุ</label><textarea id="w3mission" rows="4" cols="50" class="form-control form-control-sm" name="note" id="note"  placeholder="" required></textarea>';
      if (sum_pic != sum_pic_real) {
        if (c == 0) {
          c = 1;
          $('#note_2').append(r);
        }
      }

    }
  </script>



  @endsection