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
label{
    padding-top: 3px;
    padding-right: 5px;
}
</style>

<style>
        /* The container */
        .cont {
          display: block;
          position: relative;
          padding-left: 28px;
          padding-right: 15px;
          padding-top: 5px;
          margin-bottom: 12px;
          cursor: pointer;
          font-size: 12px;
          -webkit-user-select: none;
          -moz-user-select: none;
          -ms-user-select: none;
          user-select: none;
        }

        /* Hide the browser's default radio button */
        .cont input {
          position: absolute;
          opacity: 0;
          cursor: pointer;
        }

        /* Create a custom radio button */
        .checkmark {
          position: absolute;
          top: 0;
          left: 0;
          height: 25px;
          width: 25px;
          background-color: #eee;
          border-radius: 50%;
        }

        /* On mouse-over, add a grey background color */
        .cont:hover input ~ .checkmark {
          background-color: #ccc;
        }

        /* When the radio button is checked, add a blue background */
        .cont input:checked ~ .checkmark {
          background-color: #2196F3;
        }

        /* Create the indicator (the dot/circle - hidden when not checked) */
        .checkmark:after {
          content: "";
          position: absolute;
          display: none;
        }

        /* Show the indicator (dot/circle) when checked */
        .cont input:checked ~ .checkmark:after {
          display: block;
        }

        /* Style the indicator (dot/circle) */
        .cont .checkmark:after {
             top: 9px;
            left: 9px;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: white;
        }
</style>

@endsection
@section('main')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="container-fluid page-body-wrapper">
    <div class="main-panel container">
        <div class="col-lg-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <div class="form-sample form-control" style="height: auto;padding-right: 24px;">
                      <div class="alert alert-fill-danger text-center" role="alert"> รับหมู </div>
                      {{ Form::open(['method' => 'post' , 'url' => '/stock_data/add/'.$stock_name]) }}
                              
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
                    {{ Form::close() }}

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')

<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="{{ asset('https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js') }}"></script>

<script>
    function demo() {
        $('.datepicker').datepicker({
                format: 'dd/mm/yyyy',
                todayBtn: true,
                language: 'th',             //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
                thaiyear: true              //Set เป็นปี พ.ศ.
            }).datepicker("setDate", "0");
    }
</script>
@endsection
