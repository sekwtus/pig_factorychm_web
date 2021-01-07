@extends('layouts.master')
@section('style')
<style>
    table {
        border-collapse: collapse;
    }

    table, th {
    border: 1px solid black;
    }

    th {
        height: 30px;
        font-weight: bold;
    }
    td {
        border-left: 1px solid black;
    }

</style>
@endsection
@section('main')
<div class="row ">
    <div class="col-lg-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="row" >
                    <div class="col-md-4 pr-md-0">
                        <div class="row">
                            <h3><b>บจก.มงคลแอนด์ซันส์ฟาร์ม จำกัด</b></h3>
                        </div>
                        <div class="row">
                            88 หมู่ 8 ต.แม่แตง อ.แม่แตง <br>
                            จ.เชียงใหม่ 50150
                        </div>
                        <div class="row">
                            <div class="col-md-6 pr-md-0">โทร. 053-290094</div>
                            <div class="col-md-6 pr-md-0">แฟ็กซ์. 053-290094</div>
                        </div>
                        <div class="row">
                            เลขประจำตัวผู้เสียภาษีอากร 0505558009069
                        </div>
                    </div> 
                    <div class="col-md-4 pr-md-0">
                    </div> 
                    <div class="col-md-4 pr-md-0">
                        <div class="row">
                            <div class="col-md-12 pr-md-0 text-right"><h3>ใบเสร็จรับเงิน<br>Receipt</h3></div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 pr-md-0"><b>เลขที่</b><br>No</div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 pr-md-0"><b>วันที่</b><br>Date</div>
                        </div>
                    </div> 
                </div>
                <div class="row">
                        <div class="col-md-8" style="border: 1px solid black;">
                            <div class="row">
                                <div class="col-md-3"><b>นามผู้ชื้อ</b><br>Customer's Name</div><div class="col-md-9">{{$iv_mail[0]->customer_name}}</div>
                            </div>
                            <div class="row">
                                <div class="col-md-3"><b>ที่อยู่</b><br>Address</div><div class="col-md-9">{{$iv_mail[0]->customer_adress}}</div>
                            </div>
                            <div class="row">
                                <div class="col-md-3"></div><div class="col-md-9">โทร. {{$iv_mail[0]->customer_phone}}</div>
                            </div>
                        </div>

                        <div class="col-md-4" style="border: 1px solid black;">
                            <div class="row">
                                <div class="col-md-5"><b>เลขที่บิล</b><br>No</div><div class="col-md-7">{{$iv_mail[0]->ivm_id}}</div>
                            </div>
                            <div class="row">
                                <div class="col-md-5"><b>วันที่</b><br>Date</div><div class="col-md-7">{{$iv_mail[0]->date_bill}}</div>
                            </div>
                            <div class="row">
                                <div class="col-md-5"><b>รหัสลูกค้า</b><br>Customer's Code</div><div class="col-md-7">{{$iv_mail[0]->customer_id}}</div>
                            </div>
                        </div>
                </div><br>
                <div class="row">
                    <table class="" width="100%" id="orderTable">
                        <thead class="text-center">
                            <tr>
                                <th style="padding: 0px;">ลำดับ<br>No.</th>
                                <th style="padding: 0px;">รหัสสินค้า<br>Prod. Code</th>
                                <th style="padding: 0px;">รายละเอียดสินค้า<br>DESCRIPTION</th>
                                <th style="padding: 0px;">น้ำหนัก<br>WEIGHT</th>
                                <th style="padding: 0px;">จำนวน<br>QUANTITY</th>
                                <th style="padding: 0px;">ราคา/หน่วย<br>UNIT Price</th>
                                <th style="padding: 0px">จำนวนเงิน<br>AMOUNT</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                                $j = 1;
                                $total = 0;
                            @endphp
                            @foreach ($iv_list as $iv_list_out)
                                    <tr>
                                        <td class="text-center">{{$i++}}</td>
                                        <td class="text-center">{{$iv_list_out->ref}}</td>
                                        <td>{{$iv_list_out->detail}}</td>
                                        <td class="text-right">{{$iv_list_out->weight_total}}  Kg.</td>
                                        <td class="text-right">{{$iv_list_out->quantity}}  ตัว</td>
                                        <td class="text-right">{{ number_format($iv_list_out->prict_unit,2)}}</td>
                                        <td class="text-right">{{number_format($iv_list_out->amount,2)}}</td>
                                    </tr>
                                    @php
                                        $j++;
                                        $total = $total + $iv_list_out->amount;
                                    @endphp
                                
                                
                            @endforeach
                            @for ($l = 0; $l < (30-($i*$j)); $l++)
                                <tr>
                                    <td></td>
                                    <td> &nbsp;&nbsp;</td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-right"></td>
                                    <td class="text-right"></td>
                                    <td class="text-right"></td>
                                </tr>
                            @endfor
                                <tr style="border-top:1px solid black;">
                                    <td style="border-left: 0px solid black;"></td>
                                    <td style="border-left: 0px solid black;"></td>
                                    <td style="border-left: 0px solid black;"></td>
                                    <td style="border-left: 0px solid black;"></td>
                                    <td style="border-left: 0px solid black;"></td>
                                    <td><b>รวมเงิน</b></td>
                                    <td class="text-right"><b>{{number_format($total,2)}}</b></td>
                                </tr>
                                <tr>
                                    <td style="border-left: 0px solid black;"></td>
                                    <td style="border-left: 0px solid black;"></td>
                                    <td style="border-left: 0px solid black;"></td>
                                    <td style="border-left: 0px solid black;"></td>
                                    <td style="border-left: 0px solid black;"></td>
                                    <td><b>ภาษีมูลค่าเพิ่ม 0%</b></td>
                                    <td class="text-right"></td>
                                </tr>
                                <tr>
                                    <td style="border-left: 0px solid black;" colspan="5">
                                        <div class="col-md-12 text-left" id="thai_brat"></div>
                                    </td>
                                    <td><b>ยอดเงินสุทธิ</b></td>
                                    <td class="text-right"><b>{{number_format($total,2)}}</b></td>
                                </tr>
                                <input type="text" id="price" value="{{$total}}" height="" hidden>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-md-8" style="border: 1px solid black; border-top: 0px solid black;">
                        <div class="row">
                            <div class="col-md-12 text-left"><input type="checkbox" class="" name="" id="">เงินสด</div>
                        </div>
                        <div class="row">
                            <div class="col-md-7 text-left"><input type="checkbox" class="" name="" id="">เช็คธนาคาร</div>
                            <div class="col-md-5 text-left">สาขา</div>
                        </div>
                        <div class="row">
                            <div class="col-md-7 text-left">เช็คเลขที่</div>
                            <div class="col-md-5 text-left">ลงวันที่</div>
                        </div>
                        <div class="row">
                            <div class="col-md-7 text-left">ผู้รับเงิน</div>
                            <div class="col-md-5 text-left">วันที่</div>
                        </div>
                    </div>
                    <div class="col-md-4" style="border: 1px solid black; border-top: 0px solid black;">
                        <div class="row">
                            <div class="col-md-12 text-left">ในนาม บจก.เชียงใหม่กิจมงคล</div>
                        </div>
                       <div class="row">
                            <div class="col-md-12 text-left">ชื่อ</div>
                        </div>
                         <div class="row">
                            <div class="col-md-12 text-left">&nbsp;&nbsp;</div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12 text-center">ผู้มีอำนาจลงนาม</div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center">วันที่</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('/js/thaibath.js') }}" type="text/javascript" charset="utf-8"></script>
<script>
    $(document).ready(function(){
        thai_brat();
        print();
    });

    function thai_brat(){
    var b = $('#price').val();
    var thaibath = ArabicNumberToText(b);
    $('#thai_brat').append(thaibath);
}
</script>
@endsection


