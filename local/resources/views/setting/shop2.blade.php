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
                    <h4>รายการร้านค้า</h4>
                </div>
                <div class="col-8 text-right">
                    <button class="btn btn-sm btn-outline btn-success" type="button" data-toggle="modal"
                        data-target="#add_shop"><i class="fa fa-plus" aria-hidden="true"></i>เพิ่มร้านค้า</button>
                </div>
            </div>
            <br>
            @if(Session::has('message_success'))
            <div class="alert alert-success" role="alert"> {{Session::get('message_success')}}</div>
            @endif
            <br>
            <div class="table-responsive">
                <table class="table table-bordered nowrap" width="100%" id="table_shop">
                    <thead class="text-center">
                        <tr>
                            <th style="padding: 0px;">ลำดับ</th>
                            <th style="padding: 0px;">ชื่อร้านค้า</th>
                            <th style="padding: 0px;">สถานะร้านค้า</th>
                            <th style="text-align:center; padding: 0px;"> จัดการร้านค้า </th>
                            <th style="padding: 0px;">รายการสินค้า</th>
                            <th style="text-align:center; padding: 0px;"> จัดการสินค้า </th>
                            <th style="padding: 0px;">รายการพนักงาน</th>
                            <th style="text-align:center; padding: 0px;"> จัดการพนักงาน </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $count = 1 ?>
                        @foreach ($shop as $sh)
                        <tr>
                            <td align="center">{{ $count }}</td>
                            <td align="center">{{ $sh->shop_name }}</td>
                            @if($sh->status == "A")
                            <td align="center" style="color: green;">ใช้งาน</td>
                            @else
                            <td align="center" style="color: red;">ยกเลิก</td>
                            @endif
                            <td align="center">
                                <button class="btn btn-sm btn-outline btn-primary" type="button" data-toggle="modal"
                                    data-target="#DETAIL_SHOP{{$sh->id}}"><i class="fa fa-search"
                                        aria-hidden="true">&ensp;</i></button>
                                <button class="btn btn-sm btn-outline btn-warning" type="button" data-toggle="modal"
                                    data-target="#UPDATE_SHOP{{$sh->id}}"><i class="fa fa-edit"
                                        aria-hidden="true">&ensp;</i></button>
                                <button class="btn btn-sm btn-outline btn-danger" data-toggle="modal"
                                    data-target="#DELETE_SHOP{{$sh->id}}"><i class="fa fa-times"
                                        aria-hidden="true">&ensp;</i></button>
                            </td>
                            <td align="center">{{ $sh->CountProduct }} รายการ</td>
                            @if($sh->status == "A")
                            <td align="center">
                                <a href="{{url('setting/shop_product/'.$sh->id.'/detail')}}">
                                    <button class="btn btn-sm btn-outline btn-primary" type="button"><i
                                            class="fa fa-share-square-o" aria-hidden="true">&ensp;จัดการรายละเอียด</i></button>
                                </a>
                            </td>
                            @else
                            <td align="center">
                                <a href="#">
                                    <button class="btn btn-sm btn-outline btn-primary" type="button" disabled><i
                                            class="fa fa-share-square-o" aria-hidden="true" >&ensp;จัดการรายละเอียด</i></button>
                                </a>
                            </td>
                            @endif
                            @if($sh->CountCrew > 0)
                            <td align="center">มีพนักงาน {{ $sh->CountCrew }} คน</td>
                            @else
                            <td align="center" style="color: red;">ไม่มีพนักงาน</td>
                            @endif
                            @if($sh->status == "A")
                            <td align="center">
                                <a href="{{url('setting/shop_crew/'.$sh->id.'/detail')}}">
                                    <button class="btn btn-sm btn-outline btn-primary" type="button" dis><i
                                            class="fa fa-share-square-o" aria-hidden="true">&ensp;จัดการรายละเอียด</i></button>
                                </a>
                            </td>
                            @else
                            <td align="center">
                                <a href="{{url('setting/shop_crew/'.$sh->id.'/detail')}}">
                                    <button class="btn btn-sm btn-outline btn-primary" type="button" disabled><i
                                            class="fa fa-share-square-o" aria-hidden="true">&ensp;จัดการรายละเอียด</i></button>
                                </a>
                            </td>
                            @endif
                        </tr>
                        <?php $count=$count+1 ?>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal add shop -->
{{ Form::open(['method' => 'post' , 'url' => 'setting/shop/add']) }}
@csrf
<div class="modal fade" id="add_shop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header ">
                <h4 class="modal-title">เพิ่ม ร้านค้า</h4>
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
                                        <select class="js-example-basic-single" style="width:100%" name="shop_type_id">
                                            <option value="" selected disabled>เลือกประเภทร้านค้า</option>
                                            @foreach($shop_type as $type)
                                            <option value="{{$type->id}}">{{$type->shop_type_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>ประเภทการชำระเงิน ทดสอบ:</strong></label>
                                <div class="col-sm-8">
                                    <select class="js-example-basic-single" style="width:100%" name="payment_type_id">
                                        <option value="" selected disabled>เลือกประเภทการขำระเงิน</option>
                                        @foreach($shop_type as $type)
                                        <option value="{{$type->id}}">{{$type->shop_type_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>รหัสร้านค้า:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="shop_code" placeholder="รหัสร้านค้า" class="form-control"
                                        value="MK01">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>marker:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="marker" placeholder="marker" class="form-control"
                                        value="S">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>ชื่อร้านค้า:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="shop_name" class="form-control" placeholder="ชื่อร้านค้า"
                                        value="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>รายละเอียดร้านค้า:</strong></label>
                                <div class="col-sm-8">
                                    <textarea type="text" name="shop_description" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{ Form::hidden('status', 'A', ['class' => 'form-control','status' => 'status']) }}
                    {{ Form::hidden('created_by', 1, ['class' => 'form-control','created_by' => 'created_by']) }}
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

<!-- Modal update shop -->
@foreach ($shop as $sh)
{{ Form::open(['method' => 'put' , 'url' => 'setting/shop/update']) }}
@csrf
<div class="modal fade" id="UPDATE_SHOP{{$sh->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header ">
                <h4 class="modal-title">แก้ไข ร้านค้า</h4>
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
                                        <select class="js-example-basic-single" style="width:100%" name="shop_type_id">
                                            <option value="" selected disabled>เลือกประเภทร้านค้า</option>
                                            @foreach($shop_type as $type)
                                            <option value="{{$type->id}}">{{$type->shop_type_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>ประเภทการชำระเงิน ทดสอบ:</strong></label>
                                <div class="col-sm-8">
                                    <select class="js-example-basic-single" style="width:100%" name="payment_type_id">
                                        <option value="" selected disabled>เลือกประเภทการขำระเงิน</option>
                                        @foreach($shop_type as $type)
                                        <option value="{{$type->id}}">{{$type->shop_type_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>รหัสร้านค้า:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="shop_code" placeholder="รหัสร้านค้า" class="form-control"
                                        value="{{$sh->shop_code}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>marker:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="marker" placeholder="marker" class="form-control"
                                        value="{{$sh->marker}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>ชื่อร้านค้า:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="shop_name" class="form-control" placeholder="ชื่อร้านค้า"
                                        value="{{$sh->shop_name}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>รายละเอียดร้านค้า:</strong></label>
                                <div class="col-sm-8">
                                    <textarea type="text" name="shop_description" class="form-control">{{$sh->shop_description}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>สถานะร้านค้า:</strong></label>
                                <div class="col-sm-8">
                                    <select class="js-example-basic-single" style="width:100%" name="status">
                                        @if($sh->status == "A")
                                        <option disabled>เลือกสถานะร้านค้า</option>
                                        <option selected value="A">เปิดใช้งาน</option>
                                        <option value="B">ยกเลิก</option>
                                        @else
                                        <option disabled>เลือกสถานะร้านค้า</option>
                                        <option value="A">เปิดใช้งาน</option>
                                        <option selected value="B">ยกเลิก</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{ Form::hidden('id', $sh->id, ['class' => 'form-control','id' => 'id']) }}
                    {{ Form::hidden('created_by', 1, ['class' => 'form-control','created_by' => 'created_by']) }}
                    {{ Form::hidden('modified_by', 1, ['class' => 'form-control','modified_by' => 'modified_by']) }}

                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">แก้ไขรายละเอียดร้านค้า</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}
@endforeach

<!-- Modal delete shop -->
@foreach ($shop as $sh)
{{ Form::open(['method' => 'delete' , 'url' => 'setting/shop/delete']) }}
@csrf
<div class="modal fade" id="DELETE_SHOP{{$sh->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header ">
                <h4 class="modal-title">ลบ ร้านค้า</h4>
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
                                        <select class="js-example-basic-single" style="width:100%" name="shop_type_id"
                                            disabled>
                                            <option value="{{$type->id}}" selected disabled>{{$type->shop_type_name}}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>ประเภทการชำระเงิน ทดสอบ:</strong></label>
                                <div class="col-sm-8">
                                    <select class="js-example-basic-single" style="width:100%" name="payment_type_id"
                                        disabled>
                                        <option value="{{$type->id}}" selected disabled>{{$type->shop_type_name}}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>รหัสร้านค้า:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="shop_code" placeholder="รหัสร้านค้า" class="form-control"
                                        value="{{$sh->shop_code}}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>marker:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="marker" placeholder="marker" class="form-control"
                                        value="{{$sh->marker}}" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>ชื่อร้านค้า:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="shop_name" class="form-control" placeholder="ชื่อร้านค้า"
                                        value="{{$sh->shop_name}}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>รายละเอียดร้านค้า:</strong></label>
                                <div class="col-sm-8">
                                    <textarea type="text" name="shop_description" class="form-control"
                                        disabled>{{$sh->shop_description}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>สถานะร้านค้า:</strong></label>
                                <div class="col-sm-8">
                                    <select class="js-example-basic-single" style="width:100%" name="status" disabled>
                                        @if($sh->status == "A")
                                        <option disabled>เลือกสถานะร้านค้า</option>
                                        <option selected value="A">เปิดใช้งาน</option>
                                        <option value="B">ยกเลิก</option>
                                        @else
                                        <option disabled>เลือกสถานะร้านค้า</option>
                                        <option value="A">เปิดใช้งาน</option>
                                        <option selected value="B">ยกเลิก</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{ Form::hidden('id', $sh->id, ['class' => 'form-control','id' => 'id']) }}
                    {{ Form::hidden('created_by', 1, ['class' => 'form-control','created_by' => 'created_by']) }}
                    {{ Form::hidden('modified_by', 1, ['class' => 'form-control','modified_by' => 'modified_by']) }}

                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger">ลบรายละเอียดร้านค้า</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}
@endforeach

<!-- Modal detail shop -->
@foreach ($shop as $sh)
{{ Form::open(['method' => 'post' , 'url' => 'setting/shop/detail']) }}
@csrf
<div class="modal fade" id="DETAIL_SHOP{{$sh->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header ">
                <h4 class="modal-title">ดู ร้านค้า</h4>
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
                                        <select class="js-example-basic-single" style="width:100%" name="shop_type_id"
                                            disabled>
                                            <option value="{{$type->id}}" selected disabled>{{$type->shop_type_name}}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>ประเภทการชำระเงิน ทดสอบ:</strong></label>
                                <div class="col-sm-8">
                                    <select class="js-example-basic-single" style="width:100%" name="payment_type_id"
                                        disabled>
                                        <option value="{{$type->id}}" selected disabled>{{$type->shop_type_name}}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>รหัสร้านค้า:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="shop_code" placeholder="รหัสร้านค้า" class="form-control"
                                        value="{{$sh->shop_code}}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>marker:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="marker" placeholder="marker" class="form-control"
                                        value="{{$sh->marker}}" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>ชื่อร้านค้า:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="shop_name" class="form-control" placeholder="ชื่อร้านค้า"
                                        value="{{$sh->shop_name}}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>รายละเอียดร้านค้า:</strong></label>
                                <div class="col-sm-8">
                                    <textarea type="text" name="shop_description" class="form-control"
                                        disabled>{{$sh->shop_description}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>สถานะร้านค้า:</strong></label>
                                <div class="col-sm-8">
                                    <select class="js-example-basic-single" style="width:100%" name="status" disabled>
                                        @if($sh->status == "A")
                                        <option disabled>เลือกสถานะร้านค้า</option>
                                        <option selected value="A">เปิดใช้งาน</option>
                                        <option value="B">ยกเลิก</option>
                                        @else
                                        <option disabled>เลือกสถานะร้านค้า</option>
                                        <option value="A">เปิดใช้งาน</option>
                                        <option selected value="B">ยกเลิก</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{ Form::hidden('created_by', 1, ['class' => 'form-control','created_by' => 'created_by']) }}
                    {{ Form::hidden('modified_by', 1, ['class' => 'form-control','modified_by' => 'modified_by']) }}

                </div>
            </div>
            <div class="modal-footer">
                {{-- <button type="submit" class="btn btn-success">แก้ไขรายละเอียดร้านค้า</button> --}}
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
        $('#table_shop').DataTable();
    });
</script>

<script>
    (function ($) {
        'use strict';

        if ($(".js-example-basic-single").length) {
            $(".js-example-basic-single").select2();
        }
        if ($(".js-example-basic-multiple").length) {
            $(".js-example-basic-multiple").select2();
        }
    })(jQuery);
</script>

@endsection