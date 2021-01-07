<!DOCTYPE html>
<html lang="en">

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
  <link rel="stylesheet" href="{{ asset('assets/css/demo_2/style.css')}}">
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
<style type="text/css">
    .input{
            height: 50%;
            background-color: aqua;
    }
    th,td{
        padding: 0px;
    }
    .bodyzoom{
    /* zoom: 0.5; */
}
</style>

</head>

<body>

<div class="col-lg-12 grid-margin bodyzoom">
    <div class="card">
        <div class="card-body">

            {{ Form::open(['method' => 'post' , 'url' => 'create_order_transfer/confirm_order']) }}
            <div class="row">
                <div class="col-12">
                    @foreach($order_pt as $out_order)
                        <h3 class="text-center">
                            รายงานการโอน <span style="color:red;">{{$out_order->order_number}}</span> ประจำวันที่ {{$out_order->date}} <br>
                            จาก {{$out_order->id_user_customer_from}}                             
                            <i class="fa fa-arrow-right" style="font-size: 25px;margin-right: 0px;padding-left: 20px;padding-top: 20px;padding-right: 20px;"></i>
                            {{$out_order->id_user_customer_to}}
                        </h3>
                        <input hidden name="id" value="{{$out_order->id}}"/>
                        <input hidden name="date" value="{{$out_order->date}}"/>
                        <input hidden name="order_number" value="{{$out_order->order_number}}"/>
                        <input hidden name="customer_from" value="{{$out_order->id_user_customer_from}}"/>
                        <input hidden name="customer_to" value="{{$out_order->id_user_customer_to}}"/>
                        <input hidden name="type_req" value="{{$out_order->type_request}}"/>
                        <input hidden name="marker" value="{{$out_order->marker}}"/>
                    @endforeach
                </div>
            </div>
            {{ Form::close() }}
        
            <div class="row">
                <div class="col-12 px-0">

                    <table id="table" class="tbl " width="100%" border="1">
                        <thead>
                            <tr class="bg-secondary text-center">
                            </tr>
                            <tr class="bg-secondary text-center">
                                <th width="40%" style=" padding: 0px;" colspan="3">รายการ</th>
                                <th width="20%" style=" padding: 0px;" colspan="2">ต้นทาง</th>
                                <th width="20" style=" padding: 0px;" colspan="2">ปลายทาง</th>
                                <th width="20%" style=" padding: 0px;background-color:#ffbeba;" colspan="2">ผลต่าง (dift)</th>
                            </tr>
                            <tr>
                                <th class="text-center" style="padding: 0px;">ลำดับ</th>
                                <th class="text-center" style="padding: 0px;">รหัส item </th>
                                <th class="text-center" style="padding: 0px;">ชื่อ item </th>
                                <th class="text-center" style="padding: 0px;">น้ำหนัก</th>
                                <th class="text-center" style="padding: 0px;">จำนวน</th>
                                {{-- <th class="text-center" style="padding: 0px;">% Yiled จาก นน.ขุน</th> --}}
                                <th class="text-center" style="padding: 0px;">น้ำหนัก</th>
                                <th class="text-center" style="padding: 0px;">จำนวน</th>
                                <th class="text-center" style="padding: 0px;background-color:#ffbeba;" >น้ำหนัก</th>
                                <th class="text-center" style="padding: 0px;background-color:#ffbeba;" >จำนวน</th>
                                
                            </tr>
                        </thead>

                        @php
                            foreach ($data_main as $key => $main) {
                                $arrData[$key][0] = $main->item_code;
                                $arrData[$key][1] = $main->item_name;
                                $arrData[$key][2] = 0;
                                $arrData[$key][3] = 0;
                                $arrData[$key][4] = 0;
                                $arrData[$key][5] = 0;
                                $arrData[$key][6] = 0;
                                $arrData[$key][7] = 0;
                            }

                            foreach ($data_main as $m => $main) {
                                foreach ($data_before as $b => $before) {
                                    if ($before->item_code == $main->item_code) {
                                        $arrData[$m][3] = $before->sku_weight;
                                        $arrData[$m][4] = $before->sku_amount;
                                    }
                                } 
                            }

                            foreach ($data_main as $m => $main) {
                                foreach ($data_after as $b => $after) {
                                    if ($after->item_code == $main->item_code) {
                                        $arrData[$m][5] = $after->sku_weight;
                                        $arrData[$m][6] = $after->sku_amount;
                                    }
                                } 
                            }
                        @endphp
                        <tbody>
                            @php $count = 1; @endphp                          
                            @for ($i = 0; $i < count($data_main); $i++)
                                <tr>
                                    <td align="center">{{ $count }}</td>
                                    <td align="center">{{ $arrData[$i][0] }}</td>
                                    <td align="center">{{ $arrData[$i][1] }}</td>
                                    <td align="center">{{ $arrData[$i][3] }}</td>
                                    <td align="center">{{ $arrData[$i][4] }}</td>
                                    <td align="center">{{ $arrData[$i][5] }}</td>
                                    <td align="center">{{ $arrData[$i][6] }}</td>
                                    <td align="center">{{ number_format($arrData[$i][3] - $arrData[$i][5],2) }}</td>
                                    <td align="center">{{ number_format($arrData[$i][4] - $arrData[$i][6],2) }}</td>
                                </tr>
                                @php $count=$count+1; @endphp 
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>

            <hr>



        </div>
    </div>
</div>



<div class="modal fade" id="edit_weight" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="forms-sample form-control" style="height: auto;padding-right: 20px;" id="data_weight">

            </div>
        </div>
    </div>
</div>


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
  var table = $('#table').DataTable({
        lengthMenu: [[-1], ["All"]],
        "scrollX": false,
        orderCellsTop: true,
        fixedHeader: true,
        rowReorder: true,
        dom: 't',
        buttons: [
            // 'excel',
            {
                extend: 'excel',
            },
            //  'pdf', 'print'
        ],
        // processing: true,
        // serverSide: true,
        "order": [],
    });
</script>

<script>
  window.onload = function () {
      window.print();
  }
</script>


</body>
</html>