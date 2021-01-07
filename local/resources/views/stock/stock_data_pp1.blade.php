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

                        <div class="row">
                            <div class="col-lg-6"><h2 style="color:red;">รายงานคลังสินค้าประจำวัน  #{{ $stock_name }}
                            @if ( Auth::user()->id_type == 4 )
                                
                            @else
                                <button type="button" class="btn btn-success" title="ปรับ Stock"  data-toggle="modal" data-target="#edit" href="#">
                                <i class="fa fa-plus"></i></button>
                                <button type="button" class="btn btn-danger" title="หักออก"  data-toggle="modal" data-target="#deduct" href="#">
                                    <i class="fa fa-minus"></i></button>
                                </h2>
                            @endif
                             </div><br>   
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
                                        <p class="mb-0 text-right">คงเหลือ</p>
                                        <div class="fluid-container">
                                        <h3 class="font-weight-medium text-right mb-0">
                                            @foreach ($sum_storage as $_storage)
                                                {{-- @if ($_storage->type_of_storage == $stock_name) --}}
                                                {{ $_storage->current_unit }}
                                                <input type="text" hidden id="balance" value="{{ $_storage->current_unit }}">
                                                {{-- @endif --}}
                                            @endforeach</h3>
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
                                        <p class="mb-0 text-right">ยอดรับเข้าวันนี้</p>
                                        <div class="fluid-container">
                                        <h3 class="font-weight-medium text-right mb-0">{{ ( empty($unit_today[0]->total_unit) ? 0 : $unit_today[0]->total_unit) }}</h3>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
                                <div class="card card-statistics">
                                <div class="card-body">
                                    <div claFss="clearfix">
                                    <div class="float-left">
                                        <i class="fa fa-flash text-danger icon-lg"></i>
                                    </div>
                                    <div class="float-right">
                                        <p class="mb-0 text-right">ยอดที่ Order วันนี้</p>
                                        <div class="fluid-container">
                                        <h3 class="font-weight-medium text-right mb-0"></h3>
                                        <h3 class="font-weight-medium text-right mb-0">{{ ( empty($order_process[0]->sum_processing) ? 0 : $order_process[0]->sum_processing) }}</h3>
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
                                        <h3 class="font-weight-medium text-right mb-0">{{ ( empty($unit_release[0]->sum_release) ? 0 : $unit_release[0]->sum_release) }}</h3>
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

                        <div class="table-responsive">
                            <div class="outer">
                                <table class="table table-striped table-bordered nowrap table-hover" width="100%" id="stockOrder">
                                    <thead class="text-center">
                                        <tr>
                                            <th style="padding: 0px; border: 1px solid #ccc; position: sticky; background-color: #ff8080;" rowspan="2">วันที่</th>
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
                    </div>

                                <hr>
                                    
                                {{-- <div class="row">
                                    <div class="col-lg-3">
                                        <h4 style="color:red;margin-bottom: 0px;height: 0px;">รายการจ่ายออก</h4>
                                    </div>
                                    <div class="col-lg-2"><h6>ค้นหาช่วงวัน : </h6></div>
                                    <div class="col-lg-3"></div>
                                    <div class="col-lg-2"><h6>เลขที Order: </h6></div>
                                    <div class="col-lg-2"><h6>ประเภท : </h6></div>
                                </div>
        
        
                                <div class="row"> <div class="col-lg-3"></div>
                                    <div class="col-lg-2"><input class="form-control input-daterange-datepicker" type="text" id="daterangeOrderSend" name="daterangeOrderSend" style="padding: 0px; height: 30px;"/></div>
                                    <button type="button" id="filter" class="btn btn-success" onclick="search_Order_send()" ><i class="fa fa-search"></i>ค้นหา</button>
                                    <div class="col-lg-2"></div>
        
                                    <div class="col-lg-2"><input type="text" class="form-control" name="order_number" id="order_number"style="padding: 0px; height: 30px;" /></div>
                                    <div class="col-lg-2"><input type="text" class="form-control" name="type_req" id="type_req"style="padding: 0px; height: 30px;"/></div>
                                </div><br>

                                <table class="table table-striped table-bordered nowrap " width="100%" id="stockHistorySend">
                                    <thead class="text-center ">
                                    <tr>
                                            <th style="padding: 0px;">No.</th>
                                            <th style="padding: 0px;">เลขที่ Order</th>
                                            <th style="padding: 0px;">ลูกค้า/สาขา</th>
                                            <th style="padding: 0px;">ประเภท</th>
                                            <th style="padding: 0px;">รอบที่</th>
                                            <th style="padding: 0px;">จำนวนที่ Order</th>
                                            <th style="padding: 0px;">จำนวนที่ชั่งออก</th>
                                            <th style="padding: 0px;">วันที่จ่ายออก</th>
                                            <th style="padding: 0px;">หมายเหตุ</th>
                                            <th style="padding: 0px;">ดำเนินการ</th>
                                    </tr>
                                    </thead>
                                </table> --}}
                                
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
                                            <div class="col-md-3 pr-md-0 " >
                                                <label for="bill_number">Bill / Order</label>
                                                <input type="text" class="form-control form-control-sm" name="bill_number" placeholder="0000" required > 
                                            </div>
                                            <div class="col-md-3 pr-md-0">
                                                <label for="ref_source">ชื่อฟาร์ม</label>
                                                <input type="text" class="form-control form-control-sm" name="ref_source" placeholder="ชื่อฟาร์ม" required> 
                                            </div>
                                            <div class="col-md-3 pr-md-0">
                                                <label for="type_request">ประเภท</label>
                                                <select class="form-control form-control-sm " id="type_request" name="type_request" style=" height: 30px; " required>
                                                    @foreach ($product as $product_)
                                                        <option value="{{ $product_->id }}">{{ $product_->product_name }}</option>   
                                                    @endforeach
                                                </select> 
                                            </div>
                                            <div class="col-md-3 pr-md-0">
                                                <label for="total_unit">จำนวนที่รับ</label>
                                                <input type="number" class="form-control form-control-sm" name="total_unit" placeholder="ตัว" required> 
                                            </div>
                                        </div>
                                        <div class="row" style="margin-bottom: 10px;">
                                            <div class="col-md-3 pr-md-0">
                                                <label for="total_weight">น้ำหนักรวม</label>
                                                <input type="number" class="form-control form-control-sm" name="total_weight" placeholder="กิโลกรัม" required> 
                                            </div>
                                            <div class="col-md-3 pr-md-0">
                                                <label for="total_price">จำนวนเงิน</label>
                                                <input type="number" class="form-control form-control-sm" name="total_price" placeholder="จำนวน" required> 
                                            </div>
                                            <div class="col-md-3 pr-md-0">
                                                <label for="id_storage">ที่จัดเก็บ (stock)</label>
                                                <select class="form-control form-control-sm " id="id_storage" name="id_storage" style=" height: 30px; " required>
                                                    @foreach ($storage as $store)
                                                        <option value="{{ $store->id }}">{{ $store->shop_code }} - {{ $store->shop_name }}</option>
                                                    @endforeach
                                                </select> 
                                            </div>
                                            <div class="col-md-3 pr-md-0">
                                                <label for="date_recieve">ประจำวันที่</label>
                                                <input class="form-control form-control-sm" placeholder="วว/ดด/ปปปป" id="daterange" type="text" name="date_recieve" required>
                                            </div>
                                        </div>
                                      
                                        <div class="row" style="margin-bottom: 10px;">
                                            <div class="col-md-3 pr-md-0">
                                                <label for="unit_price">ราคา/กก.</label>
                                                <input type="number" class="form-control form-control-sm" name="unit_price" placeholder="ราคา/กก." required> 
                                            </div>
                                            <div class="col-md-9 pr-md-0">
                                                <label for="note">หมายเหตุ</label>
                                                <textarea class="form-control form-control-sm" name="note" rows="3" placeholder="หมายเหตุ"></textarea> 
                                            </div>
                                        </div>
                                        <div class="row" style="margin-bottom: 10px;">
                                            <div class="col-md-6 pr-md-0">
                                                <label for="receiver">ผู้รับของ</label>
                                                <input type="text" class="form-control form-control-sm" name="receiver" > 
                                            </div>
                                            <div class="col-md-6 pr-md-0">
                                                <label for="sender">ผู้จ่ายของ</label>
                                                <input type="text" class="form-control form-control-sm" name="sender" > 
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

                {{ Form::open(['method' => 'post' , 'url' => '/stock_data/editr_row/'.$stock_name]) }}
                <div class="modal fade" id="edit_row" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="forms-sample form-control" style="height: auto;padding-right: 20px;">
                                    <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;">ปรับ Stock</div>
                                    <div class="row" style="margin-bottom: 10px;">
                                        <div class="col-md-3 pr-md-0">
                                            <label for="bill_number">Bill / Order</label>
                                            <input type="text" class="form-control form-control-sm" name="bill_number_r" id="bill_number_r" placeholder="0000" readonly> 
                                        </div>
                                        <div class="col-md-3 pr-md-0">
                                            <label for="ref_source">ชื่อฟาร์ม</label>
                                            <input type="text" class="form-control form-control-sm" name="ref_source" id="ref_source_r" placeholder="0000" required> 
                                        </div>
                                        <div class="col-md-3 pr-md-0">
                                            <label for="type_request">ประเภท</label>
                                            <select class="form-control form-control-sm " id="type_request" name="type_request" id="type_request_r" style=" height: 30px; " required>
                                                @foreach ($product as $product_)
                                                    <option value="{{ $product_->id }}">{{ $product_->product_name }}</option>   
                                                @endforeach
                                            </select> 
                                        </div>
                                        <div class="col-md-3 pr-md-0">
                                            <label for="total_unit">จำนวนที่รับ</label>
                                            <input type="number" class="form-control form-control-sm" name="total_unit" id="total_unit_r" placeholder="ตัว" required> 
                                        </div>
                                    </div>
                                    <div class="row" style="margin-bottom: 10px;">
                                        <div class="col-md-3 pr-md-0">
                                            <label for="total_weight">น้ำหนักรวม</label>
                                            <input type="number" class="form-control form-control-sm" name="total_weight" id="total_weight_r" placeholder="กิโลกรัม" required> 
                                        </div>
                                        <div class="col-md-3 pr-md-0">
                                            <label for="total_price">จำนวนเงิน</label>
                                            <input type="number" class="form-control form-control-sm" name="total_price" id="total_price_r" placeholder="จำนวน" required> 
                                        </div>
                                        <div class="col-md-3 pr-md-0">
                                            <label for="id_storage">ที่จัดเก็บ (stock)</label>
                                            <select class="form-control form-control-sm " id="id_storage" name="id_storage" id="id_storage_r" style=" height: 30px; " required>
                                                @foreach ($storage as $store)
                                                    <option value="{{ $store->id }}">{{ $store->shop_code }} - {{ $store->shop_name }}</option>
                                                @endforeach
                                            </select> 
                                        </div>
                                        <div class="col-md-3 pr-md-0">
                                            <label for="date_recieve">ประจำวันที่</label>
                                            <input class="form-control form-control-sm" placeholder="วว/ดด/ปปปป"  type="text" name="date_recieve" id="date_recieve_r" required>
                                        </div>
                                    </div>
                                  
                                    <div class="row" style="margin-bottom: 10px;">
                                        <div class="col-md-3 pr-md-0">
                                            <label for="unit_price">ราคา/กก.</label>
                                            <input type="number" class="form-control form-control-sm" name="unit_price" id="unit_price_r" placeholder="ราคา/กก." required> 
                                        </div>
                                        <div class="col-md-9 pr-md-0">
                                            <label for="note">หมายเหตุ</label>
                                            <textarea class="form-control form-control-sm" name="note" id="note_r" rows="3" placeholder="หมายเหตุ"></textarea> 
                                        </div>
                                    </div>
                                    <div class="row" style="margin-bottom: 10px;">
                                        <div class="col-md-6 pr-md-0">
                                            <label for="receiver">ผู้รับของ</label>
                                            <input type="text" class="form-control form-control-sm" name="receiver" id="receiver_r" > 
                                        </div>
                                        <div class="col-md-6 pr-md-0">
                                            <label for="sender">ผู้จ่ายของ</label>
                                            <input type="text" class="form-control form-control-sm" name="sender" id="sender_r" > 
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
                                            <input type="number" class="form-control form-control-sm" name="count_pig_summary_real" id="count_pig_summary_real" placeholder="0000" required  > 
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
                                        <input type="text" class="form-control form-control-sm" name="id_storage" value="101" hidden>
                                        <button type="submit" class="btn btn-success mr-2" id="comfirmAdd" name="stock_name" value="comfirmAdd">กระทบยอด</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            {{ Form::close() }}

            {{-- ////////////////////////////////////////////////////////////////////////หักออก ///// --}}
            {{ Form::open(['method' => 'post' , 'url' => '/stock_data/add/'.$stock_name]) }}
                    <div class="modal fade" id="deduct" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="forms-sample form-control" style="height: auto;padding-right: 20px;">
                                        <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;">ปรับ Stock หักออก</div>
                                        <div class="row" style="margin-bottom: 10px;">
                                            <div class="col-md-3 pr-md-0 " >
                                                <label for="bill_number">Bill / Order</label>
                                                <input type="text" class="form-control form-control-sm" name="bill_number" placeholder="0000" required > 
                                            </div>
                                            <div class="col-md-3 pr-md-0">
                                                <label for="ref_source">ชื่อฟาร์ม</label>
                                                <input type="text" class="form-control form-control-sm" name="ref_source" placeholder="0000" required> 
                                            </div>
                                            <div class="col-md-3 pr-md-0">
                                                <label for="type_request">ประเภท</label>
                                                <select class="form-control form-control-sm " id="type_request" name="type_request" style=" height: 30px; " required>
                                                    @foreach ($product as $product_)
                                                        @if ($product_->id == 19)
                                                           <option value="{{ $product_->id }}">{{ $product_->product_name }}</option>   
                                                        @endif
                                                    @endforeach
                                                </select> 
                                            </div>
                                            <div class="col-md-3 pr-md-0">
                                                <label for="total_unit">จำนวนที่รับ</label>
                                                <input type="number" class="form-control form-control-sm" name="total_unit" placeholder="ตัว" required> 
                                            </div>
                                        </div>
                                        <div class="row" style="margin-bottom: 10px;">
                                            <div class="col-md-3 pr-md-0">
                                                <label for="total_weight">น้ำหนักรวม</label>
                                                <input type="number" class="form-control form-control-sm" name="total_weight" placeholder="กิโลกรัม" required> 
                                            </div>
                                            <div class="col-md-3 pr-md-0">
                                                <label for="total_price">จำนวนเงิน</label>
                                                <input type="number" class="form-control form-control-sm" name="total_price" placeholder="จำนวน" required> 
                                            </div>
                                            <div class="col-md-3 pr-md-0">
                                                <label for="id_storage">ที่จัดเก็บ (stock)</label>
                                                <select class="form-control form-control-sm " id="id_storage" name="id_storage" style=" height: 30px; " required>
                                                    @foreach ($storage as $store)
                                                        <option value="{{ $store->id }}">{{ $store->shop_code }} - {{ $store->shop_name }}</option>
                                                    @endforeach
                                                </select> 
                                            </div>
                                            <div class="col-md-3 pr-md-0">
                                                <label for="date_recieve">ประจำวันที่</label>
                                                <input class="form-control form-control-sm" placeholder="วว/ดด/ปปปป" id="daterange" type="text" name="date_recieve" required>
                                            </div>
                                        </div>
                                      
                                        <div class="row" style="margin-bottom: 10px;">
                                            <div class="col-md-3 pr-md-0">
                                                <label for="unit_price">ราคา/กก.</label>
                                                <input type="number" class="form-control form-control-sm" name="unit_price" placeholder="ราคา/กก." required> 
                                            </div>
                                            <div class="col-md-9 pr-md-0">
                                                <label for="note">หมายเหตุ</label>
                                                <textarea class="form-control form-control-sm" name="note" rows="3" placeholder="หมายเหตุ"></textarea> 
                                            </div>
                                        </div>
                                        <div class="row" style="margin-bottom: 10px;">
                                            <div class="col-md-6 pr-md-0">
                                                <label for="receiver">ผู้รับของ</label>
                                                <input type="text" class="form-control form-control-sm" name="receiver" > 
                                            </div>
                                            <div class="col-md-6 pr-md-0">
                                                <label for="sender">ผู้จ่ายของ</label>
                                                <input type="text" class="form-control form-control-sm" name="sender" > 
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
                                    <td></td>\
                                    <td></td>\
                                    <td><b>ยอดยกมา</td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td class="text-right" id="balance_without_today">'+balance+'</td>\
                                    <td class="text-right" id="balance_without_today">'+balance_weight+'</td>\
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
                                    <td class="text-left">'+element.date_recieve+'</td>\
                                    <td>'+count_row+'</td>\
                                    <td>รับเข้า</td>\
                                    <td class="text-left">'+element.bill_number+'</td>\
                                    <td class="text-right">'+element.ref_source+'</td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td>'+element.item_code+'</td>\
                                    <td></td>\
                                    <td></td>\
                                    <td class="text-right">'+element.total_unit+'</td>\
                                    <td class="text-right">'+element.total_weight+'</td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td>\
                                        <button style="padding: 7px;" type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit_row"\
                                            onclick="edit_row_('+element.id+')">\
                                            <i class="mdi mdi-pencil"></i></button>\
                                        <button  style="padding: 7px;" type="button" class="btn btn-danger"\
                                            onclick="deleteRecord('+element.id+')">\
                                            <i class="fa fa-trash"></i></button>\
                                    </td>\
                                </tr>';
                                count_row++;
                    sum_receive_unit=sum_receive_unit+element.total_unit;
                    sum_receive_weight=sum_receive_weight+element.total_weight;
                });
 
                // row = row +  '<tr style="background-color:#dffdff;">\
                //                 <td></td>\
                //                 <td><b>รวมรับเข้า</td>\
                //                 <td></td>\
                //                 <td></td>\
                //                 <td><b>'+sum_receive_unit+'</td>\
                //                 <td></td>\
                //                 <td></td>\
                //                 <td></td>\
                //                 <td></td>\
                //                 <td></td>\
                //                 <td></td>\
                //                 <td></td>\
                //             </tr>';
                // // row = row +  '<tr style="background-color:#a0d4fa;">\
                // //                     <td></td>\
                // //                     <td></td>\
                // //                     <td><b></td>\
                // //                     <td></td>\
                // //                     <td></td>\
                // //                     <td><b>จ่ายออก</td>\
                // //                     <td></td>\
                // //                     <td></td>\
                // //                     <td></td>\
                // //                     <td></td>\
                // //                     <td></td>\
                // //                 </tr>';
                //         count_row = 1; 

                data[1].forEach(element => {
                    row = row + '<tr>\
                        <td class="text-left">'+element.date+'</td>\
                                    <td>'+count_row+'</td>\
                                    <td>จ่ายออกสาขา</td>\
                                    <td class="text-left"><a target="blank_" href="../summary_weighing_receive/'+element.order_number+'">'+element.order_number+'</a></td>\
                                    <td class="text-right">'+element.id_user_customer+'</td>\
                                    <td></td>\
                                    <td>'+element.order_type+'</td>\
                                    <td></td>\
                                    <td>ตัว</td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td class="text-right">'+(element.count_amount == null || element.count_amount == '' || element.count_amount == 'null' ? '':element.count_amount)+'</td>\
                                    <td class="text-right">'+(element.sum_weight == null || element.sum_weight == '' || element.sum_weight == 'null' ? '':element.sum_weight)+'</td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                </tr>';
                                count_row++;
                    sum_receive_unit2=sum_receive_unit2+element.total_pig;
                    sum_receive_weight2=sum_receive_weight2+parseFloat(element.sum_weight == null || element.sum_weight == '' || element.sum_weight == 'null' ? '0':element.sum_weight);
                    count_amount2=count_amount2+element.count_amount;
                    sum_receive_unit2_real = sum_receive_unit2_real+element.count_amount;
                });
                data[4].forEach(element => {
                    row = row + '<tr>\
                                    <td class="text-left">'+element.date_recieve+'</td>\
                                    <td>'+(count_row++)+'</td>\
                                    <td>จ่ายออกสาขา(หมูตาย)</td>\
                                    <td class="text-left"><a target="blank_" href="../summary_weighing_receive/'+element.bill_number+'">'+element.bill_number+'</a></td>\
                                    <td class="text-right">'+element.ref_source+'</td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td>ตัว</td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td class="text-right">'+(element.total_unit == null || element.total_unit == '' || element.total_unit == 'null' ? '':element.total_unit)+'</td>\
                                    <td class="text-right">'+(element.total_weight == null || element.total_weight == '' || element.total_weight == 'null' ? '':element.total_weight)+'</td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                </tr>';
                                sum_receive_unit2_real = sum_receive_unit2_real+element.total_unit;
                                sum_receive_weight2=sum_receive_weight2+parseFloat(element.total_weight == null || element.total_weight == '' || element.total_weight == 'null' ? '0':element.total_weight);
            
                });
                // row = row +  '<tr style="background-color:#a0d4fa;">\
                //                     <td></td>\
                //                     <td><b>รวมเคลื่อนไหวภายใน</td>\
                //                     <td></td>\
                //                     <td><b>'+sum_receive_unit2+'</td>\
                //                     <td><b>'+sum_receive_unit2_real+'</td>\
                //                     <td></td>\
                //                     <td></td>\
                //                     <td></td>\
                //                     <td></td>\
                //                     <td></td>\
                //                     <td></td>\
                //                 </tr>';
                //  count_row = 1;
                data[2].forEach(element => {
                    row = row + '<tr>\
                                    <td class="text-left">'+element.date+'</td>\
                                    <td>'+count_row+'</td>\
                                    <td>จ่ายออก</td>\
                                    <td class="text-left"><a target="blank_" href="../summary_weighing_receive/'+element.order_number+'">'+element.order_number+'</a></td>\
                                    <td class="text-right">'+element.id_user_customer+'</td>\
                                    <td></td>\
                                    <td>'+element.order_type+'</td>\
                                    <td></td>\
                                    <td>ตัว</td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td class="text-right">'+(element.count_amount == null || element.count_amount == '' || element.count_amount == 'null' ? '':element.count_amount)+'</td>\
                                    <td class="text-right">'+(element.sum_weight == null || element.sum_weight == '' || element.sum_weight == 'null' ? '':element.sum_weight)+'</td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                </tr>';
                                count_row++;
                    sum_receive_unit3=sum_receive_unit3+element.total_pig;
                    sum_receive_unit3_real=sum_receive_unit3_real+element.count_amount;
                    sum_receive_weight3 = sum_receive_weight3+parseFloat(element.sum_weight == null || element.sum_weight == '' || element.sum_weight == 'null' ? '0':element.sum_weight);
                    count_amount3 = count_amount3+element.count_amount;
                    date_ = element.date;
                });
                row = row +  '<tr style="background-color:#ff8080;">\
                                    <td></td>\
                                    <td></td>\
                                    <td><b>สรุป</td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td id="balance_without_today">'+balance+'</td>\
                                    <td class="text-right">'+balance_weight+'</td>\
                                    <td class="text-right">'+sum_receive_unit+'</td>\
                                    <td class="text-right">'+sum_receive_weight+'</td>\
                                    <td class="text-right">'+((sum_receive_unit2_real+sum_receive_unit3_real))+'</td>\
                                    <td class="text-right">'+(sum_receive_weight3+sum_receive_weight2)+'</td>\
                                    <td class="text-right">'+(parseFloat(balance)+sum_receive_unit-(sum_receive_unit2_real+sum_receive_unit3_real))+'</td>\
                                    <td class="text-right">'+((parseFloat(balance_weight)+sum_receive_weight)-(sum_receive_weight2+sum_receive_weight3))+'</td>\
                                    <td><a href="#" data-toggle="modal" data-target="#check" ><button class="btn btn-primary">ตรวจสอบ</button></a></td>\
                                </tr>';
                
                data[5].forEach(element => {
                     row = row +  '<tr style="background-color:#ff8080;">\
                                    <td></td>\
                                    <td></td>\
                                    <td><b></td>\
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
                                    <td class="text-right">'+(element.count_unit_real == null || element.count_unit_real == '' || element.count_unit_real == 'null' ? '':element.count_unit_real)+'</td>\
                                    <td class="text-right">'+(element.weight_summary == null || element.weight_summary == '' || element.weight_summary == 'null' ? '':element.weight_summary)+'</td>\
                                    <td class="text-left" style="width: 150px; white-space: normal;">'+(element.description == null || element.description == '' || element.description == 'null' ? '':element.description)+'</td>\
                                </tr>';
                });
                // row = row +  '<tr style="background-color:#ff8080;">\
                //                 <td></td>\
                //                 <td><b>ยอกรับเข้าทั้งหมด</td>\
                //                 <td></td>\
                //                 <td></td>\
                //                 <td><b>'+(sum_receive_unit+balance)+'</td>\
                //                 <td></td>\
                //                 <td></td>\
                //                 <td></td>\
                //                 <td></td>\
                //                 <td></td>\
                //                 <td></td>\
                //                 <td></td>\
                //             </tr>';

                // row = row +  '<tr style="background-color:#ff8080;">\
                //                     <td></td>\
                //                     <td><b>ยอดจ่ายออกทั้งหมด</td>\
                //                     <td></td>\
                //                     <td></td>\
                //                     <td><b>'+((sum_receive_unit2_real+sum_receive_unit3_real))+'</td>\
                //                     <td></td>\
                //                     <td></td>\
                //                     <td></td>\
                //                     <td></td>\
                //                     <td></td>\
                //                     <td></td>\
                //                 </tr>';

                // row = row +  '<tr style="background-color:#ff8080;">\
                //                     <td></td>\
                //                     <td><b>คงเหลือ</td>\
                //                     <td></td>\
                //                     <td></td>\
                //                     <td><b>'+((parseFloat(balance)+sum_receive_unit)-(sum_receive_unit2_real+sum_receive_unit3_real))+'</td>\
                //                     <td></td>\
                //                     <td></td>\
                //                     <td></td>\
                //                     <td></td>\
                //                     <td></td>\
                //                     <td><a href="#" data-toggle="modal" data-target="#check" ><button class="btn btn-primary">ตรวจสอบ</button></a></td>\
                //                 </tr>';
                // console.log(row);
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


