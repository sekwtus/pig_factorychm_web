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
                    <div class="row">
                        <div class="col-md-12 pr-md-0 text-center"><b>ใบแจ้งหนี้</b></div>
                        <br><br>
                    </div>
                    <div class="row">
                        <div class="col-md-9 pr-md-0">
                            <div class="row">
                                <div class="col-md-2 pr-md-0">รหัสลูกค้า</div><div class="col-md-2 pr-md-0 text-left">{{$detail_ivs[0]->customer_id}}</div>
                                <div class="col-md-1 pr-md-0">ชื่อ</div><div class="col-md-7 pr-md-0 text-left">{{$detail_ivs[0]->customer_name}}</div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 pr-md-0">ขอเรียนว่าท่านได้ซื้อสินค้า ไปตามรายการต่อไปนี้</div>
                            </div>
                        </div>
                        <div class="col-md-3 pr-md-0">
                            <div class="row">
                                <div class="col-md-2 pr-md-0 text-left">วันที่</div>
                                <div class="col-md-10 pr-md-0 text-right">{{$detail_ivs[0]->date }}</div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 pr-md-0">เลขที่ใบแจ้งหนี้</div>
                                <div class="col-md-8 pr-md-0 text-right">{{$detail_ivs[0]->ivs_id}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 pr-md-0">
                            <table class="" width="100%" id="orderTable">
                                <thead class="text-center">
                                    <tr>
                                        <th style="padding: 0px; font-size: 0.7rem;">เลขที่บิล</th>
                                        <th style="padding: 0px; font-size: 0.7rem;">วันที่</th>
                                        <th style="padding: 0px; font-size: 0.7rem;">กำหนดชำระ</th>
                                        <th style="padding: 0px; font-size: 0.7rem;">จำนวนเงิน</th>
                                        <th style="padding: 0px; font-size: 0.7rem;">คืนสินค้า</th>
                                        <th style="padding: 0px; font-size: 0.7rem;">ค้างชำระ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $sub_total = 0;
                                        $return_product = 0;
                                        $overdue = 0;
                                    @endphp
                                    @foreach ($ivs_list as $ivs_lise_out)
                                        <tr>
                                            <td class="text-center">{{$ivs_lise_out->ivm_id}}</td>
                                            <td class="text-center">{{$ivs_lise_out->date_bill}}</td>
                                            <td class="text-center">{{$ivs_lise_out->date_payment}}</td>
                                            <td class="text-center">{{$ivs_lise_out->sub_total}}</td>
                                            <td class="text-center">{{$ivs_lise_out->return_product}}</td>
                                            <td class="text-center">{{$ivs_lise_out->overdue}}</td>
                                        </tr>
                                        @php
                                            $sub_total = $sub_total+$ivs_lise_out->sub_total;
                                            $return_product = $return_product+$ivs_lise_out->return_product;
                                            $overdue = $overdue+$ivs_lise_out->overdue;
                                        @endphp
                                    @endforeach
                                        <tr style="border: 1px solid black">
                                            <td class="text-center">รวม &nbsp;&nbsp;&nbsp;&nbsp;{{ count($ivs_list) }}&nbsp;ใบ</td>
                                            <td class="text-center"></td>
                                            <td class="text-center"></td>
                                            <td class="text-center">{{$sub_total}}</td>
                                            <td class="text-center">{{$return_product}}</td>
                                            <td class="text-center">{{$overdue}}</td>
                                        </tr>
                                </tbody>
                            </table>
                            <div id="thai">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 pr-md-0 text-left" style="height: 200px;">
                            <div style="position:absolute; bottom:0;">หมายเหตุ กำหนดชำระเงินในวันที่</div>
                        </div>
                        <div class="col-md-6 pr-md-0 text-center">
                            <div class="row" style="height: 150px;">
                                <div  style="position:absolute; bottom:150px;">ขอแสดงความนับถือ</div>
                            </div>
                            <div class="row" style="height: 150px;">
                                <div  style="position:absolute; bottom:0;">เจ้าหน้าที่บัญชีและการเงิน</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
            add();
            print();
        });
    
        function add(){
        var thaibath = ArabicNumberToText(1000000);
        $('#thai').append('('+thaibath+')');
    }
    </script>
</body>
</html>
