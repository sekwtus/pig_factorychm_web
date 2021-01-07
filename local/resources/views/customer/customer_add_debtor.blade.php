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
            {{ Form::open(['method' => 'post' , 'url' => '/customer/add/save']) }}
            <div class="card">
                <div class="card-body">
                    <div class="form-sample form-control" style="height: auto;padding-right: 24px;">
                        <div class="alert alert-fill-danger text-center" role="alert"> แบบฟอร์มสมัครสมาชิก </div>
                        <div class="row py-1 ">
                            <div class="col-sm-3 col-md-3 pr-md-0">
                                <div class="row" style="padding-left: 10px;">
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
                                        <input type="radio" value="นางสาว" class="custom-control-input" id="pnoun3" name="pnoun">
                                        <label class="custom-control-label" for="pnoun3">นางสาว</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3 col-md-3 pr-md-0">ชื่อ-นามสกุล
                                <input class="form-control form-control-sm" placeholder="ชื่อ-นามสกุล" name="customer_name" type="text" >
                            </div>
                            <div class="col-sm-2 col-md-2 pr-md-0">ชื่อเล่น
                                <input class="form-control form-control-sm" placeholder="ชื่อเล่น" name="customer_nickname" type="text" >
                            </div>
                            <div class="col-sm-2 col-md-2 pr-md-0">ตัวย่อลูกค้า(<span style="color:red;">ห้ามซ้ำกัน</span>)
                                <input class="form-control form-control-sm" placeholder="ตัวย่อลูกค้า" name="marker" type="text" >
                            </div>
                            <div class="col-sm-2 col-md-2 pr-md-0">รหัสลูกค้า(<span style="color:red;">ห้ามซ้ำกัน</span>)
                                <input class="form-control form-control-sm" placeholder="รหัสลูกค้า" name="customer_code" type="text" >
                            </div>
                        </div>

                        <div class="row py-1">
                            <div class="col-md-4 pr-md-0">ชื่อร้านค้า
                                <input class="form-control form-control-sm" placeholder="ชื่อร้านค้า" name="customer_shop_name" type="text" >
                            </div>
                            <div class="col-md-2 pr-md-0">เวลา<span style="color:red;">เปิด</span>ของร้าน
                                <input class="form-control form-control-sm" name="customer_shop_open" type="time" >
                            </div>
                            <div class="col-md-2 pr-md-0">เวลา<span style="color:red;">ปิด</span>ของร้าน
                                <input class="form-control form-control-sm" name="customer_shop_close" type="time" >
                            </div>
                            <div class="col-md-4 pr-md-0">วันหยุดร้าน
                                <input class="form-control form-control-sm" placeholder="จันทร์-อาทิตย์" name="customer_shop_day_close" type="text" >
                            </div>
                        </div>

                        <div class="row py-1">
                            <div class="col-md-2 pr-md-0">เวลาสะดวกรับสินค้า
                                <input class="form-control form-control-sm" name="customer_shop_time_recieve_product" type="time" >
                            </div>
                            <div class="col-md-4 pr-md-0">วัน/เดือน/ปี
                                <input class="form-control form-control-sm" placeholder="วว/ดด/ปปปป" name="datepick" type="text" data-provide="datepicker" data-date-language="th-th">
                            </div>
                            <div class="col-md-3 pr-md-0">หมายเลขบัตรประชาชน
                                <input class="form-control form-control-sm" placeholder="หมายเลขบัตรประชาชน" name="id_card_number1" type="text" pattern="\d*" maxlength="13" >
                            </div>
                            <div class="col-md-3 pr-md-0">ประเภทลูกค้า
                                {{-- <label for="customer">ลูกค้า/สาขา</label> --}}
                                <select class="form-control form-control-sm" id="customer_type" name="customer_type" style=" height: 30px; " required>
                                    @foreach ($customer_type as $cus_type)
                                        <option value="{{ $cus_type->type }}">{{ $cus_type->type }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
<hr>
                        <div class="row py-1">
                            <div class="col-md-4 pr-md-0">บ้านเลขที่
                                <input class="form-control form-control-sm" placeholder="บ้านเลขที่" name="address" type="text" >
                            </div>
                            <div class="col-md-2 pr-md-0">หมู่บ้าน
                                <input class="form-control form-control-sm" placeholder="หมู่บ้าน" name="address_M" type="text" >
                            </div>
                            <div class="col-md-2 pr-md-0">หมู่ที่
                                <input class="form-control form-control-sm" placeholder="หมู่ที่" name="address_Mnumber" type="text" >
                            </div>
                            <div class="col-md-4 pr-md-0">ซอย
                                <input class="form-control form-control-sm" placeholder="ซอย" name="address_lane" type="text" >
                            </div>
                        </div>

                        <div class="row py-1">
                            <div class="col-md-4 pr-md-0">ถนน
                                <input class="form-control form-control-sm" placeholder="ถนน" name="address_road" type="text" >
                            </div>
                            <div class="col-md-2 pr-md-0">แขวง/ตำบล
                                <input class="form-control form-control-sm" placeholder="แขวง/ตำบล" name="address_district" type="text" >
                            </div>
                            <div class="col-md-2 pr-md-0">เขต/อำเภอ
                                <input class="form-control form-control-sm" placeholder="เขต/อำเภอ" name="address_city" type="text" >
                            </div>
                            <div class="col-md-4 pr-md-0">จังหวัด
                                <input class="form-control form-control-sm" placeholder="จังหวัด" name="province" type="text" >
                            </div>
                        </div>

                        <div class="row py-1">
                            <div class="col-md-2 pr-md-0">รหัสไปรษณีย์
                                <input class="form-control form-control-sm" maxlength="5" placeholder="รหัสไปรษณีย์" name="postcode" type="text" >
                            </div>
                            <div class="col-md-2 pr-md-0">เบอร์โทร
                                <input class="form-control form-control-sm" maxlength="10" placeholder="เบอร์โทร" name="phone_number" type="text" >
                            </div>
                            <div class="col-md-3 pr-md-0">Email
                                <input class="form-control form-control-sm" placeholder="Email" name="email" type="text" >
                            </div>
                            <div class="col-md-3 pr-md-0">Facebook
                                <input class="form-control form-control-sm" placeholder="Facebook" name="facebook" type="text" >
                            </div>
                            <div class="col-md-2 pr-md-0">Line
                                    <input class="form-control form-control-sm" placeholder="Line" name="line" type="text" >
                                </div>
                        </div>
<hr>
                        <div class="row py-1">
                            <div class="col-sm-12 col-md-12 pr-md-0">
                            <div class="row" style="padding-left: 10px;">ยอดซื้อสิ้นค้าโดยเฉลี่ยต่อวัน &nbsp;&nbsp;&nbsp;&nbsp;
                                @foreach ($purchase_amount as $key => $purchase)
                                    <div class="custom-control custom-radio">
                                        <input type="radio" value="{{ $purchase->id }}" class="custom-control-input" id="{{ $purchase->id }}" name="purchase">
                                        <label class="custom-control-label" for="{{ $purchase->id }}">{{ $purchase->range_money }}</label>
                                    </div>
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

                        {{-- <div class="row py-1">
                            <div class="col-md-5 pr-md-0">ทพ./ทญ.
                                <select class="form-control form-control-sm" id="doctor" name="doctor">
                                <option value="2106" selected="" hidden=""> ทพ.วิชัย&nbsp;ศิริเสรีวรรณ&nbsp;</option>
                                                                <option value="3029"> ทพ.กิตติ&nbsp;นันทาภรณ์ศักดิ์&nbsp;</option>
                                                                <option value="3032"> ทพ.ชวลิต&nbsp;อยู่ยืน&nbsp;</option>
                                                                <option value="3033"> ทพ.ณัฐพล&nbsp;เชิดชูจิต&nbsp;</option>
                                                                <option value="2722"> ทญ.นันทมาส&nbsp;โพธิ์วรสุนทร&nbsp;</option>
                                                                <option value="3035"> ทญ.ประทุม&nbsp;</option>
                                                                <option value="3036"> ทพ.พีระยง&nbsp;ธีระกาญจน์&nbsp;</option>
                                                                <option value="3030"> ทพ.ยืนยง&nbsp;ธีระกาญจน์&nbsp;</option>
                                                                <option value="2106"> ทพ.วิชัย&nbsp;ศิริเสรีวรรณ&nbsp;</option>
                                                                <option value="3039"> ทญ.ศศิภา&nbsp;วีระวรรณ&nbsp;</option>
                                                                <option value="3040"> ทญ.อรอุษา&nbsp;</option>
                                                                <option value="73"> ทญ.อรอุษา&nbsp;จันทร์ประภาพ&nbsp;</option>
                                                                <option value="1631"> ทพ.เหรียญณรงค์&nbsp;จูฬาวิเศษกุล&nbsp;</option>
                                                            </select>

                            </div>
                            <div class="col-sm-6 col-md-3 pr-md-0">เบอร์โทร
                            <input class="form-control form-control-sm" placeholder="เบอร์โทร" name="phone_doctor" type="number" >
                            </div>
                            <div class="col-sm-6 col-md-4">LINE
                            <input class="form-control form-control-sm" placeholder="LINE" name="line_doctor" type="text" >
                            </div>
                        </div> --}}

                        <div class="alert alert-fill-danger text-center" role="alert"> ประเภทธุรกิจ </div>
                        <div class="row py-1">
                            {{-- run business type --}}
                                @php
                                    $set_topic = 'topic';
                                @endphp

                                @foreach ($customer_business as $key => $business)

                                    @if ($business->type != $set_topic)
                                        @php $set_topic = $business->type; @endphp
                                        <div class="col-sm-4 col-md-4 pr-md-0 text-center"><b class="font-weight-bold">{{ $set_topic }}</b>
                                    @endif

                                        <div class="custom-control custom-radio col-12 text-left">
                                            <input type="radio" value="{{ $business->id }}" class="custom-control-input" id="b{{ $business->id }}" name="business_type">
                                            <label class="custom-control-label" for="b{{ $business->id }}">{{ $business->business }}</label>
                                        </div>

                                    @if ( !empty($customer_business[$key+1]->type) && $customer_business[$key+1]->type  != $set_topic)
                                        </div>
                                    @endif
                                @endforeach
                                {{--end run business type --}}
                        </div>
                        </div>
                    </div>
                    <br>
                    <div class="text-center">
                        <button type="button" class="btn btn-default" >Close</button>
                        <button type="submit" class="btn btn-success" id="btnSave" >Save changes</button>
                    </div>
                </div>
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
