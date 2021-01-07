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
            /* height: 30px; */
            font-weight: normal;
            font-size: 10pt;
        }
        td {
            /* border-left: 0px solid black; */
            border: 0px solid black;
            font-size: 10pt;
        }
    
    </style>
</head>
<body>
    <div class="container-fluid page-body-wrapper">
        <div class="main-panel container">
          <div class="content-wrapper">
                <div class="row">
                    <div class="col-lg-12 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <div class="row" >
                                    <div class="col-md-4 pr-md-0">
                                        <div class="row">
                                            บริษัท มงคลแอนด์ซันส์ฟาร์ม จำกัด
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
                                            <div class="col-md-6 pr-md-0"></div><div class="col-md-6 pr-md-0"><h4>ใบแจ้งหนี้</h4></div>
                                        </div>
                                        {{-- <div class="row">
                                            <div class="col-md-12 pr-md-0"><b>เลขที่</b><br>No</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 pr-md-0"><b>วันที่</b><br>Date</div>
                                        </div> --}}
                                    </div> 
                                </div>
                                <div class="row">
                                        <div class="col-md-8" style="border: 1px solid black;">
                                            <div class="row">
                                                <div class="col-md-4">นามผู้ชื้อ<br>Customer's Name</div><div class="col-md-8">{{$iv_mail[0]->customer_name}}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">ที่อยู่<br>Address</div><div class="col-md-8">{{$iv_mail[0]->customer_address}}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4"></div><div class="col-md-8">โทร. </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4" style="border: 1px solid black;">
                                            <div class="row">
                                                <div class="col-md-6">เลขที่บิล<br>No</div><div class="col-md-6">{{$iv_mail[0]->bill_id}}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">วันที่<br>Date</div><div class="col-md-6">{{$iv_mail[0]->date}}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">รหัสลูกค้า<br>Customer Code</div><div class="col-md-6">{{$iv_mail[0]->customer_code}}</div>
                                            </div>
                                        </div>
                                </div>
                                <div class="row mt-1">
                                    <table class="" width="100%" id="orderTable">
                                        <thead class="text-center">
                                            <tr>
                                                <th style="padding: 0px;">ลำดับ</th>
                                                <th style="padding: 0px;">เลขที่เอกสาร</th>
                                                <th style="padding: 0px;">วันที่เอกสาร</th>
                                                <th style="padding: 0px;">ประเภทเอกสาร</th>
                                                <th style="padding: 0px;">วันที่ครบกำหนด</th>
                                                <th style="padding: 0px;">จำนวนเงินตาม<br>ใบส่งของ/ใบแจ้งหนี้</th>
                                                <th style="padding: 0px">จำนวนเงินวางบิล</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $l = 1;
                                            @endphp
                                           @foreach ($rc_ilst as $item)
                                           <tr class="text-center">
                                                <td style="padding: 0px;">{{$l++}}</td>
                                                <td style="padding: 0px;">{{$item->rcl_id}}</td>
                                                <td style="padding: 0px;">{{$item->date}}</td>
                                                <td style="padding: 0px;">{{$item->detail}}</td>
                                                <td style="padding: 0px;">{{$item->date_pay}}</td>
                                                <td class="text-right" style="padding: 0px;">{{number_format($item->price, 2)}}</td>
                                                <td class="text-right" style="padding: 0px;">{{number_format($item->price, 2)}}</td>
                                            </tr>
                                           @endforeach
                                           @for ($i = 0; $i <10-$l; $i++)
                                            <tr>
                                                <td colspan="7" style="padding: 0px;">&nbsp;&nbsp; </td>
                                            </tr>
                                           @endfor
                                        </tbody>
                                    </table>
                                </div>
                               
                                <input type="text" id="price" value="{{$iv_mail[0]->total_price}}" height="" hidden>
                                <div class="row">
                                    <div class="col-md-8" style="border-style: solid; border-width: 1px">
                                        <div class="row">
                                            <div class="col-md-12">&nbsp;</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">&nbsp;</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 text-center" id="thai_brat"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-2" style="border-style: solid; border-width: 1px">
                                        <div class="row">
                                            <div class="col-md-12">รวมเงิน</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">ภาษีมูลค่าเพิ่ม 0%</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">ยอดเงินสุทธิ</div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-right" style="border-style: solid; border-width: 1px">
                                        <div class="row ">
                                            <div class="col-md-12">{{number_format($iv_mail[0]->total_price,2)}}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12"><b>&nbsp;</b></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">{{number_format($iv_mail[0]->total_price,2)}}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8" style="border-style: solid; border-width: 1px">
                                        <div class="row text-center">
                                            {{-- <div class="col-md-1"><input type="checkbox" name="" id=""></div> --}}
                                            <div class="col-md-11" style="font-size: 10pt;">ในนามบริษัท</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12"> &nbsp;</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 text-center">............................................</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 text-center" style="font-size: 10pt;">ผู้วางบิล</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 text-center" style="font-size: 10pt;">วันที่ ........................................................</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4" style="border-style: solid; border-width: 1px">
                                        <div class="row">
                                            <div class="col-md-12" style="font-size: 8pt;">&nbsp;</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12"> &nbsp;</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 text-center">............................................</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 text-center" style="font-size: 10pt;">ผู้รับวางบิล</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 text-center" style="font-size: 10pt;">วันที่ ........................................................</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
          </div>
        </div>
    </div>
{{-- {{ Form::open(['method' => 'post' , 'url' => '/bill_add_item/p']) }}
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
{{ Form::close() }} --}}

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
        // print();
    });

    function thai_brat(){
    var b = $('#price').val();
    var thaibath = ArabicNumberToText(b);
    $('#thai_brat').append("("+thaibath+")");
}
</script>
</body>
</html>



