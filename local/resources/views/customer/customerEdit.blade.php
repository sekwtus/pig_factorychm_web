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
            {{ Form::open(['method' => 'post' , 'url' => '/customer/edit/save']) }}
            <div class="card">
                @foreach($data_customer as $customer)
                <div class="card-body">
                    <div class="form-sample form-control" style="height: auto;padding-right: 24px;">
                        <div class="alert alert-fill-danger text-center" role="alert"> แบบฟอร์มสมัครสมาชิก </div>
                        <div class="row py-1 ">
                            <div class="col-sm-3 col-md-3 pr-md-0">
                                <div class="row" style="padding-left: 10px;">

                                    @if($customer->pnoun == 'นาย')
                                        <div class="custom-control custom-radio">
                                            <input type="radio" value="" class="custom-control-input" id="pnoun4" name="pnoun">
                                            <label class="custom-control-label" for="pnoun4">ไม่ระบุ</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" value="นาย" class="custom-control-input" id="pnoun1" name="pnoun" checked>
                                            <label class="custom-control-label" for="pnoun1">นาย</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" value="นาง" class="custom-control-input" id="pnoun2" name="pnoun">
                                            <label class="custom-control-label" for="pnoun2">นาง</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" value="นางสาว" class="custom-control-input" id="pnoun3" name="pnoun">
                                            <label class="custom-control-label" for="pnoun3">นางสาว</label>
                                        </div>
                                    @elseif($customer->pnoun == 'นาง')
                                        <div class="custom-control custom-radio">
                                            <input type="radio" value="" class="custom-control-input" id="pnoun4" name="pnoun">
                                            <label class="custom-control-label" for="pnoun4">ไม่ระบุ</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" value="นาย" class="custom-control-input" id="pnoun1" name="pnoun" >
                                            <label class="custom-control-label" for="pnoun1">นาย</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" value="นาง" class="custom-control-input" id="pnoun2" name="pnoun" checked>
                                            <label class="custom-control-label" for="pnoun2">นาง</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" value="นางสาว" class="custom-control-input" id="pnoun3" name="pnoun">
                                            <label class="custom-control-label" for="pnoun3">นางสาว</label>
                                        </div>
                                    @elseif($customer->pnoun == 'นางสาว')
                                        <div class="custom-control custom-radio">
                                            <input type="radio" value="" class="custom-control-input" id="pnoun4" name="pnoun">
                                            <label class="custom-control-label" for="pnoun4">ไม่ระบุ</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" value="นาย" class="custom-control-input" id="pnoun1" name="pnoun" >
                                            <label class="custom-control-label" for="pnoun1">นาย</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" value="นาง" class="custom-control-input" id="pnoun2" name="pnoun">
                                            <label class="custom-control-label" for="pnoun2">นาง</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" value="นางสาว" class="custom-control-input" id="pnoun3" name="pnoun" checked>
                                            <label class="custom-control-label" for="pnoun3">นางสาว</label>
                                        </div>
                                    @elseif($customer->pnoun == '' || $customer->pnoun == null )
                                        <div class="custom-control custom-radio">
                                            <input type="radio" value="" class="custom-control-input" id="pnoun4" name="pnoun" checked>
                                            <label class="custom-control-label" for="pnoun4">ไม่ระบุ</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" value="นาย" class="custom-control-input" id="pnoun1" name="pnoun" >
                                            <label class="custom-control-label" for="pnoun1">นาย</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" value="นาง" class="custom-control-input" id="pnoun2" name="pnoun">
                                            <label class="custom-control-label" for="pnoun2">นาง</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" value="นางสาว" class="custom-control-input" id="pnoun3" name="pnoun" >
                                            <label class="custom-control-label" for="pnoun3">นางสาว</label>
                                        </div>
                                    @endif


                                </div>
                            </div>
                                <div class="col-sm-3 col-md-3 pr-md-0">ชื่อ-นามสกุล
                                    <input class="form-control form-control-sm" placeholder="ชื่อ-นามสกุล" value="{{ $customer->customer_name }}" name="customer_name" type="text" >
                                </div>
                                <div class="col-sm-2 col-md-2 pr-md-0">ชื่อเล่น
                                    <input class="form-control form-control-sm" placeholder="ชื่อเล่น" value="{{ $customer->customer_nickname }}" name="customer_nickname" type="text" >
                                </div>
                                <div class="col-sm-2 col-md-2 pr-md-0">ตัวย่อลูกค้า(<span style="color:red;">ห้ามซ้ำกัน</span>)
                                    <input class="form-control form-control-sm" placeholder="ตัวย่อลูกค้า" value="{{ $customer->marker }}" name="marker" type="text" >
                                </div>
                                <div class="col-sm-2 col-md-2 pr-md-0">รหัสลูกค้า(<span style="color:red;">ห้ามซ้ำกัน</span>)
                                    <input class="form-control form-control-sm" placeholder="รหัสลูกค้า" value="{{ $customer->customer_code }}" name="customer_code" type="text" >
                                </div>
                        </div>
                        <div class="row py-1">
                            <div  class="col-sm-8 col-md-8 pr-md-0"></div>
                            <div class="col-sm-2 col-md-2 pr-md-0">ตัวย่อลูกค้าใหม่(<span style="color:red;">ห้ามซ้ำกัน</span>)
                                <input class="form-control form-control-sm" placeholder="ตัวย่อลูกค้า" value="{{ $customer->new_marker }}" name="new_marker" type="text" >
                            </div>
                            <div class="col-sm-2 col-md-2 pr-md-0">รหัสลูกค้า ใหม่(<span style="color:red;">ห้ามซ้ำกัน</span>)
                                <input class="form-control form-control-sm" placeholder="ตัวย่อลูกค้า" value="{{ $customer->new_customer_code }}" name="new_customer_code" type="text" >
                            </div>
                        </div>

                        <div class="row py-1">
                            <div class="col-md-4 pr-md-0">ชื่อร้านค้า
                                <input class="form-control form-control-sm" placeholder="ชื่อร้านค้า" value="{{ $customer->shop_name }}" name="customer_shop_name" type="text" >
                            </div>
                            <div class="col-md-2 pr-md-0">เวลา<span style="color:red;">เปิด</span>ของร้าน
                                <input class="form-control form-control-sm" value="{{ $customer->customer_shop_open }}" name="customer_shop_open" type="time" >
                            </div>
                            <div class="col-md-2 pr-md-0">เวลา<span style="color:red;">ปิด</span>ของร้าน
                                <input class="form-control form-control-sm" value="{{ $customer->customer_shop_close }}" name="customer_shop_close" type="time" >
                            </div>
                            <div class="col-md-4 pr-md-0">วันหยุดร้าน
                                <input class="form-control form-control-sm" placeholder="จันทร์-อาทิตย์" value="{{ $customer->customer_shop_day_close }}" name="customer_shop_day_close" type="text" >
                            </div>
                        </div>

                        <div class="row py-1">
                            <div class="col-md-2 pr-md-0">เวลาสะดวกรับสินค้า
                                <input class="form-control form-control-sm" value="{{ $customer->customer_shop_time_recieve_product }}" name="customer_shop_time_recieve_product" type="time" >
                            </div>
                            <div class="col-md-2 pr-md-0">วัน/เดือน/ปี
                                <input class="form-control form-control-sm"  value="{{ $customer->datepick }}" placeholder="วว/ดด/ปปปป" name="datepick" type="text" data-provide="datepicker" data-date-language="th-th">
                            </div>
                            <div class="col-md-3 pr-md-0">หมายเลขบัตรประชาชน
                                <input class="form-control form-control-sm" value="{{ $customer->id_card_number }}" placeholder="หมายเลขบัตรประชาชน" name="id_card_number1" type="text" pattern="\d*" maxlength="13" >
                            </div>
                            <div class="col-md-3 pr-md-0">ประเภทลูกค้า
                                {{-- <label for="customer">ลูกค้า/สาขา</label> --}}
                                <select class="form-control form-control-sm" id="customer_type" name="customer_type" style=" height: 30px; " required>
                                    <option value="{{ $customer->customer_type }}">{{ $customer->customer_type }}</option>
                                    @foreach ($customer_type as $cus_type)
                                        <option value="{{ $cus_type->type }}">{{ $cus_type->type }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 pr-md-0">กลุ่มลูกค้า
                                <select class="form-control form-control-sm" id="customer_group" name="customer_group" style=" height: 30px; " required>
                                    @foreach ($customer_group as $item)
                                        <option value="{{ $item->id }}">{{ $item->group_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                            <hr>
                        <div class="row py-1">
                            <div class="col-md-4 pr-md-0">บ้านเลขที่
                                <input class="form-control form-control-sm" placeholder="บ้านเลขที่" value="{{ $customer->address }}" name="address" type="text" >
                            </div>
                            <div class="col-md-2 pr-md-0">หมู่บ้าน
                                <input class="form-control form-control-sm" placeholder="หมู่บ้าน" value="{{ $customer->address_M }}" name="address_M" type="text" >
                            </div>
                            <div class="col-md-2 pr-md-0">หมู่ที่
                                <input class="form-control form-control-sm" placeholder="หมู่ที่" value="{{ $customer->address_Mnumber }}" name="address_Mnumber" type="text" >
                            </div>
                            <div class="col-md-4 pr-md-0">ซอย
                                <input class="form-control form-control-sm" placeholder="ซอย" value="{{ $customer->address_lane }}" name="address_lane" type="text" >
                            </div>
                        </div>

                        <div class="row py-1">
                            <div class="col-md-4 pr-md-0">ถนน
                                <input class="form-control form-control-sm" placeholder="ถนน" value="{{ $customer->address_road }}" name="address_road" type="text" >
                            </div>
                            <div class="col-md-2 pr-md-0">แขวง/ตำบล
                                <input class="form-control form-control-sm" placeholder="แขวง/ตำบล" value="{{ $customer->address_district }}" name="address_district" type="text" >
                            </div>
                            <div class="col-md-2 pr-md-0">เขต/อำเภอ
                                <input class="form-control form-control-sm" placeholder="เขต/อำเภอ" value="{{ $customer->address_city }}" name="address_city" type="text" >
                            </div>
                            <div class="col-md-4 pr-md-0">จังหวัด
                                <input class="form-control form-control-sm" placeholder="จังหวัด" name="province" value="{{ $customer->province }}" type="text" >
                            </div>
                        </div>

                        <div class="row py-1">
                            <di-v class="col-md-2 pr-md-0">รหัสไปรษณีย์
                                <input class="form-control form-control-sm" maxlength="5" placeholder="รหัสไปรษณีย์" name="postcode" value="{{ $customer->postcode }}" type="text" >
                            </di-v>
                            <div class="col-md-2 pr-md-0">เบอร์โทร
                                <input class="form-control form-control-sm" maxlength="10" placeholder="เบอร์โทร" name="phone_number" value="{{ $customer->phone_number }}" type="text" >
                            </div>
                            <div class="col-md-3 pr-md-0">Email
                                <input class="form-control form-control-sm" placeholder="Email" name="email" value="{{ $customer->email }}" type="text" >
                            </div>
                            <div class="col-md-3 pr-md-0">Facebook
                                <input class="form-control form-control-sm" placeholder="Facebook" name="facebook" value="{{ $customer->facebook }}" type="text" >
                            </div>
                            <div class="col-md-2 pr-md-0">Line
                                <input class="form-control form-control-sm" placeholder="Line" name="line" value="{{ $customer->line }}" type="text" >
                            </div>
                        </div>
                        <div class="row py-1">
                            <div class="col-md-2 pr-md-0">FAX No.
                                <input class="form-control form-control-sm"  placeholder="FAX" name="fax" value="{{ $customer->fax }}" type="text" >
                            </div>
                        </div>
<hr>
                        <div class="row py-1">
                            @if ($standard_price_customer != null)
                                @foreach ($standard_price_customer as $item)
                                    <div class="col-md-2 pr-md-0">สุกรขุน
                                        <input class="form-control form-control-sm" value="{{$item->fattening}}" name="fattening" type="number" >
                                    </div>
                                    <div class="col-md-2 pr-md-0">สุกร 5 เล็บ
                                        <input class="form-control form-control-sm" value="{{$item->pig_5}}" name="pig_5" type="number" >
                                    </div>
                                    <div class="col-md-2 pr-md-0">สุกรไข่
                                        <input class="form-control form-control-sm" value="{{$item->pig_egg}}" name="pig_egg" type="number" >
                                    </div>
                                    <div class="col-md-2 pr-md-0">พ่อพันธ์
                                        <input class="form-control form-control-sm" value="{{$item->father}}" name="father" type="number" >
                                    </div>
                                    <div class="col-md-2 pr-md-0">แม่พันธ์
                                        <input class="form-control form-control-sm" value="{{$item->mother}}" name="mother" type="number" >
                                    </div>
                                    <div class="col-md-2 pr-md-0">หมูซาก
                                        <input class="form-control form-control-sm" value="{{$item->carcass}}" name="carcass" type="number" >
                                    </div>
                                    <div class="col-md-2 pr-md-0">หมูตาย
                                        <input class="form-control form-control-sm" value="{{$item->dead_pig}}" name="dead_pig" type="number" >
                                    </div>
                                    <div class="col-md-2 pr-md-0">ค่าเชือด
                                        <input class="form-control form-control-sm" value="{{$item->slice}}" name="slice" type="number" >
                                    </div>
                                    <div class="col-md-2 pr-md-0">ค่าตัดแต่ง
                                        <input class="form-control form-control-sm" value="{{$item->trim}}" name="trim" type="number" >
                                    </div>
                                @endforeach 
                            @else
                                <div class="row py-1">
                                    <div class="col-md-2 pr-md-0">สุกรขุน
                                        <input class="form-control form-control-sm" value="0" name="fattening" type="number" >
                                    </div>
                                    <div class="col-md-2 pr-md-0">สุกร 5 เล็บ
                                        <input class="form-control form-control-sm" value="0" name="pig_5" type="number" >
                                    </div>
                                    <div class="col-md-2 pr-md-0">สุกรไข่
                                        <input class="form-control form-control-sm" value="0" name="pig_egg" type="number" >
                                    </div>
                                    <div class="col-md-2 pr-md-0">พ่อพันธ์
                                        <input class="form-control form-control-sm" value="0" name="father" type="number" >
                                    </div>
                                    <div class="col-md-2 pr-md-0">แม่พันธ์
                                        <input class="form-control form-control-sm" value="0" name="mother" type="number" >
                                    </div>
                                    <div class="col-md-2 pr-md-0">หมูซาก
                                        <input class="form-control form-control-sm" value="0" name="carcass" type="number" >
                                    </div>
                                    <div class="col-md-2 pr-md-0">หมูตาย
                                        <input class="form-control form-control-sm" value="0" name="dead_pig" type="number" >
                                    </div>
                                    <div class="col-md-2 pr-md-0">ค่าเชือด
                                        <input class="form-control form-control-sm" value="0" name="slice" type="number" >
                                    </div>
                                    <div class="col-md-2 pr-md-0">ค่าตัดแต่ง
                                        <input class="form-control form-control-sm" value="0" name="trim" type="number" >
                                    </div>
                                </div>
                            @endif
                               
                            
                        </div>
<hr>
                        <div class="row py-1">
                            <div class="col-sm-12 col-md-12 pr-md-0">
                            <div class="row" style="padding-left: 10px;">ยอดซื้อสิ้นค้าโดยเฉลี่ยต่อวัน &nbsp;&nbsp;&nbsp;&nbsp;
                                @foreach ($purchase_amount as $key => $purchase)
                                    @if ($customer->id_purchase_amount == $purchase->id )
                                        <div class="custom-control custom-radio">
                                            <input type="radio" value="{{ $purchase->id }}" class="custom-control-input" id="{{ $purchase->id }}" name="purchase" checked>
                                            <label class="custom-control-label" for="{{ $purchase->id }}">{{ $purchase->range_money }}</label>
                                        </div>
                                    @else
                                        <div class="custom-control custom-radio">
                                            <input type="radio" value="{{ $purchase->id }}" class="custom-control-input" id="{{ $purchase->id }}" name="purchase">
                                            <label class="custom-control-label" for="{{ $purchase->id }}">{{ $purchase->range_money }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            </div>
                        </div>

                        <div class="row py-1">
                            <div class="col-sm-12 col-md-12 pr-md-0">
                            <div class="row" style="padding-left: 10px;">ความถี่ในการซื้อต่อสัปดาห์ &nbsp;&nbsp;&nbsp;&nbsp;
                                <div class="custom-control custom-radio">
                                    <input type="radio" value="ทุกวัน" class="custom-control-input" id="purchase_week1" name="purchase_week">
                                    <label class="custom-control-label" for="purchase_week1">ทุกวัน</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" value="1-2 วัน" class="custom-control-input" id="purchase_week2" name="purchase_week">
                                    <label class="custom-control-label" for="purchase_week2">1-2 วัน</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" value="4-5 วัน" class="custom-control-input form-control" id="purchase_week3" name="purchase_week">
                                    <label class="custom-control-label" for="purchase_week3">4-5 วัน</label>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="row py-1">
                                <div class="col-md-2 pr-md-0"> อัตรา VAT [%]
                                    <input class="form-control form-control-sm" placeholder="0.00" name="vat" value="{{ $customer->vat }}" type="number" step="0.01">
                                </div>
                        </div>
                        <hr>

                        <div class="alert alert-fill-danger text-center" role="alert"> สถานที่จัดส่ง </div>
                            <div class="row py-1">
                                <div class="col-md-4 pr-md-0">บ้านเลขที่
                                    <input class="form-control form-control-sm" placeholder="บ้านเลขที่" name="address_send" value="{{ $customer->address_send }}" type="text" >
                                </div>
                                <div class="col-md-2 pr-md-0">หมู่บ้าน
                                    <input class="form-control form-control-sm" placeholder="หมู่บ้าน" name="address_M_send" value="{{ $customer->address_M_send }}" type="text" >
                                </div>
                                <div class="col-md-2 pr-md-0">หมู่ที่
                                    <input class="form-control form-control-sm" placeholder="หมู่ที่" name="address_Mnumber_send" value="{{ $customer->address_Mnumber_send }}" type="text" >
                                </div>
                                <div class="col-md-4 pr-md-0">ซอย
                                    <input class="form-control form-control-sm" placeholder="ซอย" name="address_lane_send" value="{{ $customer->address_lane_send }}" type="text" >
                                </div>
                            </div>

                            <div class="row py-1">
                                <div class="col-md-4 pr-md-0">ถนน
                                    <input class="form-control form-control-sm" placeholder="ถนน" name="address_road_send" value="{{ $customer->address_road_send }}" type="text" >
                                </div>
                                <div class="col-md-2 pr-md-0">แขวง/ตำบล
                                    <input class="form-control form-control-sm" placeholder="แขวง/ตำบล" name="address_district_send" value="{{ $customer->address_district_send }}" type="text" >
                                </div>
                                <div class="col-md-2 pr-md-0">เขต/อำเภอ
                                    <input class="form-control form-control-sm" placeholder="เขต/อำเภอ" name="address_city_send" value="{{ $customer->address_city_send }}" type="text" >
                                </div>
                                <div class="col-md-4 pr-md-0">จังหวัด
                                    <input class="form-control form-control-sm" placeholder="จังหวัด" name="province_send" value="{{ $customer->province_send }}" type="text" >
                                </div>
                            </div>

                            <div class="row py-1">
                                <div class="col-md-2 pr-md-0">รหัสไปรษณีย์
                                    <input class="form-control form-control-sm" maxlength="5" placeholder="รหัสไปรษณีย์" name="postcode_send" value="{{ $customer->postcode_send }}" type="text" >
                                </div>
                                <div class="col-md-2 pr-md-0">เบอร์โทร
                                    <input class="form-control form-control-sm" maxlength="10" placeholder="เบอร์โทร" name="phone_number_send" value="{{ $customer->phone_number_send }}" type="text" >
                                </div>
                                <div class="col-md-3 pr-md-0">Email
                                    <input class="form-control form-control-sm" placeholder="Email" name="email_send" value="{{ $customer->email_send }}" type="text" >
                                </div>
                                <div class="col-md-3 pr-md-0">Facebook
                                    <input class="form-control form-control-sm" placeholder="Facebook" name="facebook_send" value="{{ $customer->facebook_send }}" type="text" >
                                </div>
                                <div class="col-md-2 pr-md-0">Line
                                        <input class="form-control form-control-sm" placeholder="Line" name="line_send" value="{{ $customer->line_send }}" type="text" >
                                </div>
                            </div>
                            <div class="row py-1">
                                <div class="col-md-2 pr-md-0">FAX No.
                                    <input class="form-control form-control-sm"  placeholder="FAX" name="fax_send" value="{{ $customer->fax_send }}" type="text" >
                                </div>
                            </div>
                        </div>
                    </div><br>
                    <div class="text-center">
                        <button type="button" class="btn btn-default" >Close</button>
                        <button type="submit" class="btn btn-success" id="btnSave" name="id" value="{{ $customer->id }}" >Save changes</button>
                    </div>
                </div>
                
                @endforeach
            </div>
            {{ Form::close() }}
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
