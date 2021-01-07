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
                    <h4>รายการสินค้า {{$sh->shop_name}}</h4>
                    @endforeach
                </div>
                <div class="col-8 text-right">
                    <a href="{{url('setting/shop')}}">
                        <button type="button" class="btn btn-secondary btn-fw">
                            <i class="menu-icon icon-logout"></i>กลับไปก่อนหน้า</button>
                    </a>&emsp;
                    <button class="btn btn-sm btn-outline btn-success" type="button" data-toggle="modal"
                        data-target="#add_shop"><i class="fa fa-plus" aria-hidden="true"></i>เพิ่มสินค้า</button>
                </div>
            </div>
            <br>
            @if(Session::has('message_success'))
            <div class="alert alert-success" role="alert"> {{Session::get('message_success')}}</div>
            @endif
            <br>
            <div class="table-responsive">
                <table class="table table-bordered nowrap" width="100%" id="table_shop_product">
                    <thead class="text-center">
                        <tr>
                            <th style="padding: 0px;">ลำดับ</th>
                            <th style="padding: 0px;">ชื่อสินค้า</th>
                            <th style="padding: 0px;">ปริมาณ</th>
                            <th style="padding: 0px;">น้ำหนัก</th>
                            <th style="padding: 0px;">ราคา</th>
                            <th style="padding: 0px;">รวม</th>
                            <th style="padding: 0px;">ดำเนินการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $count = 1 ?>
                        @foreach ($product as $pr)
                        <tr>
                            <td align="center">{{ $count }}</td>
                            <td align="left">{{ $pr->product_name }}</td>
                            <td align="center" style="color: green;">{{ $pr->qty }}</td>
                            <td align="center" style="color: red;">{{ $pr->weight }}</td>
                            <td align="center">{{ $pr->price }} บาท /{{ $pr->unit}}</td>
                            <td align="center">ทดสอบ</td>
                            <td align="center">
                                <button class="btn btn-sm btn-outline btn-warning" data-toggle="modal"
                                    data-target="#UPDATE_SHOP_PRODUCT{{$pr->product_id}}"><i class="fa fa-edit"
                                        aria-hidden="true">&ensp;</i>
                                </button>
                                <button class="btn btn-sm btn-outline btn-danger" data-toggle="modal"
                                    data-target="#DELETE_SHOP_PRODUCT{{$pr->product_id}}"><i class="fa fa-times"
                                        aria-hidden="true">&ensp;</i>
                                </button>
                            </td>
                        </tr>
                        <?php $count=$count+1 ?>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<!-- Modal update product => qty -->
@foreach ($product as $pr)
{{ Form::open(['method' => 'put' , 'url' => 'setting/shop_product/update']) }}
@csrf
<div class="modal fade" id="UPDATE_SHOP_PRODUCT{{$pr->product_id}}" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header ">
                <h4 class="modal-title">แก้ไข ปริมาณสินค้า {{$pr->product_name}}</h4>
                <button type="button" class="btn btn-icons btn-rounded btn-closed" title="close" data-dismiss="modal"><i
                        class="mdi mdi-close"></i>
                </button>
            </div>
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>ปริมาณ เดิม:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" placeholder="ปริมาณ" class="form-control" value="{{$pr->qty}}"
                                        disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>ปริมาณ ใหม่:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="qty" placeholder="" class="form-control" value="">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{ Form::hidden('product_id', $pr->product_id, ['class' => 'form-control','product_id' => 'product_id']) }}

                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">แก้ไขปริมาณสินค้า</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}
@endforeach

<!-- Modal add product -->
{{ Form::open(['method' => 'post' , 'url' => 'setting/shop_product/add']) }}
@csrf
<div class="modal fade" id="add_shop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header ">
                <h4 class="modal-title">เพิ่ม สินค้า</h4>
                <button type="button" class="btn btn-icons btn-rounded btn-closed" title="close" data-dismiss="modal"><i
                        class="mdi mdi-close"></i>
                </button>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>ประเภทร้านค้า:</strong></label>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <select class="js-example-basic-single" style="width:100%" name="product_id">
                                            <option value="" selected disabled>เลือกสินค้า</option>
                                            @foreach($list_product as $list)
                                            <option value="{{$list->id}}">{{$list->product_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>ปริมาณ:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="qty" placeholder="ปริมาณ" class="form-control" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>น้ำหนัก:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="weight" placeholder="น้ำหนัก" class="form-control"
                                        value="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>page:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="page" placeholder="page" class="form-control" value="0">
                                </div>
                            </div>
                        </div>
                    </div>
                    @foreach($shop as $sh)
                    {{ Form::hidden('shop_id', $sh->id, ['class' => 'form-control','shop_id' => 'shop_id']) }}
                    @endforeach
                    {{ Form::hidden('status', 'A', ['class' => 'form-control','status' => 'status']) }}
                    {{ Form::hidden('user_created', 1, ['class' => 'form-control','created_by' => 'created_by']) }}
                    {{ Form::hidden('modified_by', 1, ['class' => 'form-control','modified_by' => 'modified_by']) }}


                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">เพิ่มร้านค้า</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}


<!-- Modal delete product -->
@foreach ($product as $pr)
{{ Form::open(['method' => 'delete' , 'url' => 'setting/shop_product/delete']) }}
@csrf
<div class="modal fade" id="DELETE_SHOP_PRODUCT{{$pr->product_id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header ">
                <h4 class="modal-title">เพิ่ม สินค้า</h4>
                <button type="button" class="btn btn-icons btn-rounded btn-closed" title="close" data-dismiss="modal"><i
                        class="mdi mdi-close"></i>
                </button>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>ประเภทสินค้า:</strong></label>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <select class="js-example-basic-single" style="width:100%" name="product_id" disabled>
                                            <option value="" selected disabled>เลือกสินค้า</option>
                                            @foreach($list_product as $list)
                                            <option value="{{$list->id}}">{{$list->product_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>ปริมาณ:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="qty" placeholder="ปริมาณ" class="form-control" value="{{$pr->qty}}" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>น้ำหนัก:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="weight" placeholder="น้ำหนัก" class="form-control"
                                        value="{{$pr->weight}}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>page:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="page" placeholder="page" class="form-control" value="{{$pr->page}}" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{ Form::hidden('product_id', $pr->product_id, ['class' => 'form-control','product_id' => 'product_id']) }}

                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger">ลบสินค้า</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}
@endforeach



@endsection

@section('script')
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="{{ asset('https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js') }}"></script>

<!-- DataTable -->
<script>
    $(document).ready(function () {
        $('#table_shop_product').DataTable();
    });
</script>

@endsection