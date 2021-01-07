<!DOCTYPE html>
<html>
<head>
      <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{csrf_token()}}">
  <title>บริษัทมงคลแอนด์ซันส์ฟาร์มจำกัด</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="{{ asset('assets/vendor/iconfonts/mdi/css/materialdesignicons.min.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/iconfonts/puse-icons-feather/feather.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/css/vendor.bundle.base.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/css/vendor.bundle.addons.css')}}">

  <link rel="stylesheet" href="{{ asset('assets/vendor/iconfonts/font-awesome/css/font-awesome.min.css')}}" />
  <link rel="stylesheet" href="{{ asset('assets/css/shared/style.css')}}">
  <!-- endinject -->
  <!-- Layout styles -->
  <link href="https://fonts.googleapis.com/css2?family=Prompt&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/css/demo_2/style.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/css/demo_1/style.css')}}">
  <!-- End Layout styles -->
  <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png')}}" />

  {{-- datatables --}}
  <link rel="stylesheet" href="{{ asset('/assets/css/datatables/jquery.dataTables.min.css') }}" type="text/css" />
  <style>
    .navbar.horizontal-layout .nav-top .navbar-brand-wrapper .navbar-brand img{
      width: 100px;
      height: 100px;
    }
    select.form-control {
      height: 43.5px;
    }

  </style>

<style>
    .ajax-loader {
    visibility: hidden;
    background-color: rgba(255,255,255,0.7);
    position: absolute;
    z-index: +100 !important;
    width: 100%;
    height:100%;
    }

    .ajax-loader img {
    position: relative;
    top:50%;
    left:40%;
    }

</style>
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
            /* border-left: 0px solid black; */
            border: 0px solid black;
        }
    
    </style>
</head>
<body>
<div class="row ">
    <div class="col-lg-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="row" >
                    <div class="col-md-4 pr-md-0">
                        <div class="row">
                            <h3><b>บริษัท มงคลแอนด์ซันส์ฟาร์ม จำกัด</b></h3>
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
                            <div class="col-md-12 pr-md-0 text-right"><h3>ใบแจ้งหนี้<br>INVOICE</h3></div>
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
                                $total = 0;
                                $sum_w = 0;
                                $sum_u = 0;
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
                                    $total = $total+($iv_list_out->amount);
                                    $sum_w = $sum_w + $iv_list_out->weight_total;
                                    $sum_u = $sum_u + $iv_list_out->quantity;
                                @endphp
                            @endforeach
                            
                            <tr>
                                <td class="text-center"></td>
                                <td class="text-center"><a class="btn btn-light" style="margin-bottom: 10px;" title="เพิ่มข้อมูล" data-toggle="modal" data-target="#add">
                                    <i class="fa fa-plus"></i>
                                </a></td>
                                <td><b>รวม</b></td>
                                <td class="text-right"><b>{{$sum_w}} Kg.</b></td>
                                <td class="text-right"><b>{{ $sum_u}} ตัว</b></td>
                                <td class="text-right"></td>
                                <td class="text-right"></td>
                            </tr>
                            <tr><td colspan="7">&nbsp;</td></tr>
                            {{-- @for ($l = 0; $l < (30-$i); $l++)
                                <tr>
                                    <td></td>
                                    <td> &nbsp;&nbsp;</td>
                                    <td></td>
                                    <td class="text-right"></td>
                                    <td class="text-right"></td>
                                    <td class="text-right"></td>
                                </tr>
                            @endfor --}}
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
{{ Form::open(['method' => 'post' , 'url' => '/bill_add_item/s']) }}
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="forms-sample form-control" style="height: auto;padding-right: 20px;">
                <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;">ตรวจสอบยอดประจำวัน</div>
                <div class="row" style="margin-bottom: 10px;">
                    <div class="col-md-3 pr-md-0">
                        <label for="date_summary">รหัสสินค้า</label>
                        <input type="text" class="form-control form-control-sm" name="code_item" id="code_item" placeholder="รหัสสินค้า">
                        <input type="text" class="form-control form-control-sm" name="id_ivl" id="id_ivm" value="{{$iv_mail[0]->ivm_id}}" hidden> 
                    </div>
                    <div class="col-md-6 pr-md-0">
                        <label for="date_summary">รายละเอียดสินค้า</label>
                        <input type="text" class="form-control form-control-sm" name="detall_item" id="detall_item" placeholder="รายละเอียดสินค้า"> 
                    </div>
                </div>
                <div class="row" style="margin-bottom: 10px;">
                    <div class="col-md-3 pr-md-0">
                        <label for="date_summary">น้ำหนัก</label>
                        <input type="number" class="form-control form-control-sm" name="widht" id="widht" placeholder="น้ำหนัก" step="0.01"> 
                    </div>
                    <div class="col-md-3 pr-md-0">
                        <label for="date_summary">จำนวน</label>
                        <input type="number" class="form-control form-control-sm" name="unit" id="unit" placeholder="จำนวน"> 
                    </div>
                    <div class="col-md-3 pr-md-0">
                        <label for="date_summary">ราคา/หน่วย</label>
                        <input type="number" class="form-control form-control-sm" name="price" id="price" placeholder="ราคา/หน่วย"> 
                        <input type="number" class="form-control form-control-sm" name="bill"  value="1" hidden> 
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
<script src="{{ asset('assets/vendor/js/vendor.bundle.base.js')}}"></script>
<script src="{{ asset('assets/vendor/js/vendor.bundle.addons.js')}}"></script>

<script src="{{ asset('assets/js/demo_2/dashboard.js')}}"></script>
<script src="{{ asset('assets/js/demo_2/script.js')}}"></script>

<script src="{{ asset('assets/js/shared/off-canvas.js')}}"></script>
<script src="{{ asset('assets/js/shared/hoverable-collapse.js')}}"></script>
<script src="{{ asset('assets/js/shared/misc.js')}}"></script>
<script src="{{ asset('assets/js/shared/settings.js')}}"></script>
<script src="{{ asset('assets/js/shared/todolist.js')}}"></script>
<script src="{{ asset('assets/js/shared/widgets.js')}}"></script>
<script src="{{ asset('assets/js/shared/form-validation.js')}}"></script>
<script src="{{ asset('assets/js/shared/bt-maxLength.js')}}"></script>
<script src="{{ asset('assets/js/shared/formpickers.js')}}"></script>
{{--  <script src="{{ asset('assets/js/shared/form-addons.js')}}"></script>  --}}
<script src="{{ asset('assets/js/shared/x-editable.js')}}"></script>
<script src="{{ asset('assets/js/shared/dropify.js')}}"></script>
<script src="{{ asset('assets/js/shared/dropzone.js')}}"></script>
<script src="{{ asset('assets/js/shared/jquery-file-upload.js')}}"></script>
<script src="{{ asset('assets/js/shared/form-repeater.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.29.2/sweetalert2.all.js"></script>
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
</body>
</html>



