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
</style>
<link rel="stylesheet" href="{{ url('https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css') }}"
    type="text/css" />
<link rel="stylesheet" href="{{ url('https://cdn.datatables.net/1.10.18/css/dataTables.semanticui.min.css') }}"
    type="text/css" />

@endsection
@section('main')


@if ($errors->any())
<br>
<div class="alert alert-danger text-center" style="background-color:#;">
    @foreach ($errors->all() as $error)
    {{ $error }}
    @endforeach
</div>
@endif

<div class="col-lg-12 grid-margin">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    @foreach($shop as $sh)
                    <h4>รายการขายจากร้าน {{$sh->shop_name}}</h4>
                    @endforeach
                </div>
                <div class="col-8 text-right">
                    <a href="{{url('setting_receipt')}}">
                        <button type="button" class="btn btn-secondary btn-fw">
                            <i class="menu-icon icon-logout"></i>กลับไปก่อนหน้า</button>
                    </a>&emsp;
                    {{-- <button class="btn btn-sm btn-outline btn-success" type="button" data-toggle="modal"
                        data-target="#add_crew"><i class="fa fa-plus" aria-hidden="true"></i>เพิ่มพนักงาน</button>
                </div> --}}
                </div>
                <br><br>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered nowrap" width="100%" id="table_receipt">
                        <thead class="text-center">
                            <tr>
                                <th style="padding: 0px;">ลำดับ</th>
                                <th style="padding: 0px;">ชื่อสินค้า</th>
                                <th style="padding: 0px;">รูปภาพ</th>
                                <th style="padding: 0px;">ปริมาณ</th>
                                <th style="padding: 0px;">ราคา</th>
                                <th style="padding: 0px;">ราคารวม</th>
                                
                                {{-- <th style="text-align:center; padding: 0px;"> ดำเนินการ </th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count = 1 ?>
                            @foreach ($receipt as $rc)
                            <tr>
                                <td align="center">{{ $count }}</td>
                                <td align="left">{{ $rc->product_name }}</td>
                                <td align="center"><img
                                    src="{{asset('/assets/images/product_images/'.$rc->picture.'')}}"></td>
                                <td align="center">{{ $rc->qty }} {{$rc->unit}}</td>
                                <td align="center">{{ $rc->price }} บาท</td>
                                <td align="center">{{ $rc->amount }} บาท</td>
                                
                                {{-- <td align="center">
                                    <button class="btn btn-sm btn-outline btn-primary" type="button" data-toggle="modal"
                                        data-target="#DETAIL_RECEIPT{{$rc->id}}"><i class="fa fa-search"
                                    aria-hidden="true">&ensp;รายละเอียด</i></button>
                                <button class="btn btn-sm btn-outline btn-warning" type="button" data-toggle="modal"
                                    data-target="#UPDATE_RECEIPT{{$rc->id}}"><i class="fa fa-edit"
                                        aria-hidden="true">&ensp;</i></button>
                                <button class="btn btn-sm btn-outline btn-danger" data-toggle="modal"
                                    data-target="#DELETE_RECEIPT{{$rc->id}}"><i class="fa fa-times"
                                        aria-hidden="true">&ensp;</i></button>
                                </td> --}}
                            </tr>
                            <?php $count=$count+1 ?>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    @endsection

    @section('script')
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="{{ asset('https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js') }}"></script>

    <!-- DataTable -->
    <script>
        $(document).ready(function () {
            $('#table_receipt').DataTable();
        });
    </script>

    @endsection