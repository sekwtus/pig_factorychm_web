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
                    <h4>พนักงาน</h4>
                </div>
                <div class="col-8 text-right">
                    <a href="{{url('setting/shop')}}">
                        <button type="button" class="btn btn-secondary btn-fw">
                            <i class="menu-icon icon-logout"></i>กลับไปก่อนหน้า</button>
                    </a>&emsp;
                    <button class="btn btn-sm btn-outline btn-success" type="button" data-toggle="modal"
                        data-target="#add_crew"><i class="fa fa-plus" aria-hidden="true"></i>เพิ่มพนักงาน</button>
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
                            <th style="padding: 0px;">ชื่อพนักงาน</th>
                            <th style="padding: 0px;">รูปภาพ</th>
                            <th style="padding: 0px;">สถานะพนักงาน</th>
                            <th style="padding: 0px;">ดำเนินการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $count = 1 ?>
                        @foreach ($crew as $cr)
                        <tr>
                            <td align="center">{{ $count }}</td>
                            <td align="left">{{ $cr->names }}</td>
                            <td align="center"><img src="{{asset('/assets/images/'.$cr->image_string.'')}}"></td>
                            @if($cr->status == "A")
                            <td align="center" style="color: green;">ใช้งาน</td>
                            @else
                            <td align="center" style="color: red;">ยกเลิก</td>
                            @endif
                            <td align="center">
                                <button class="btn btn-sm btn-outline btn-warning" data-toggle="modal"
                                    data-target="#UPDATE_SHOP_CREW{{$cr->id}}"><i class="fa fa-edit"
                                        aria-hidden="true">&ensp;</i>
                                </button>
                                <button class="btn btn-sm btn-outline btn-danger" data-toggle="modal"
                                    data-target="#DELETE_SHOP_CREW{{$cr->id}}"><i class="fa fa-times"
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


<!-- Modal add crew -->
{{ Form::open(['method' => 'post' , 'url' => 'setting/shop_crew/add']) }}
@csrf
<div class="modal fade" id="add_crew" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header ">
                <h4 class="modal-title">เพิ่ม พนักงาน</h4>
                <button type="button" class="btn btn-icons btn-rounded btn-closed" title="close" data-dismiss="modal"><i
                        class="mdi mdi-close"></i>
                </button>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>position_id:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="position_id" placeholder="position_id" class="form-control"
                                        value="29">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>department_id:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="department_id" placeholder="department_id" class="form-control"
                                        value="20">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>users_code:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="users_code" placeholder="users_code" class="form-control"
                                        value="user">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>title:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="title" placeholder="title" class="form-control"
                                        value="title">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>users_pass:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="users_pass" class="form-control" placeholder="ชื่อร้านค้า"
                                        value="5b59239c8fc5dfb274f27ff49694f585">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>names:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="names" class="form-control" placeholder="ชื่อร้านค้า"
                                    value="names">                                
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>address:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="address" class="form-control" placeholder="ชื่อร้านค้า"
                                        value="address">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>telephone:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="telephone" class="form-control" placeholder="ชื่อร้านค้า"
                                    value="telephone">                                
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>email:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="email" class="form-control" placeholder="ชื่อร้านค้า"
                                        value="email">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>remark:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="remark" class="form-control" placeholder="ชื่อร้านค้า"
                                    value="remark">                                
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>sex:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="sex" class="form-control" placeholder="ชื่อร้านค้า"
                                        value="sex">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>image_string:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="image_string" class="form-control" placeholder="ชื่อร้านค้า"
                                    value="image_string">                                
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>users_login:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="users_login" class="form-control" placeholder="ชื่อร้านค้า"
                                        value="users_login">
                                </div>
                            </div>
                        </div>
                        
                    </div>

                    @foreach($crew as $cr)
                    {{ Form::hidden('shop_id', $cr->shop_id, ['class' => 'form-control','shop_id' => 'shop_id']) }}
                    @endforeach
                    {{ Form::hidden('role', '2', ['class' => 'form-control','role' => 'role']) }}
                    {{ Form::hidden('status', 'A', ['class' => 'form-control','status' => 'status']) }}
                    {{ Form::hidden('created_by', 1, ['class' => 'form-control','created_by' => 'created_by']) }}
                    {{ Form::hidden('modified_by', 1, ['class' => 'form-control','modified_by' => 'modified_by']) }}

                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">เพิ่มพนักงาน</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}

<!-- Modal edit crew -->
@foreach($user as $cr)
{{ Form::open(['method' => 'put' , 'url' => 'setting/shop_crew/update']) }}
@csrf
<div class="modal fade" id="UPDATE_SHOP_CREW{{$cr->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header ">
                <h4 class="modal-title">เพิ่ม พนักงาน</h4>
                <button type="button" class="btn btn-icons btn-rounded btn-closed" title="close" data-dismiss="modal"><i
                        class="mdi mdi-close"></i>
                </button>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>position_id:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="position_id" placeholder="position_id" class="form-control"
                                        value="{{$cr->position_id}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>department_id:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="department_id" placeholder="department_id" class="form-control"
                                        value="{{$cr->department_id}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>users_code:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="users_code" placeholder="users_code" class="form-control"
                                        value="{{$cr->users_code}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>title:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="title" placeholder="title" class="form-control"
                                        value="{{$cr->title}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>users_pass:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="users_pass" class="form-control" placeholder="ชื่อร้านค้า"
                                        value="{{$cr->users_pass}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>names:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="names" class="form-control" placeholder="ชื่อร้านค้า"
                                    value="{{$cr->names}}">                                
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>address:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="address" class="form-control" placeholder="ชื่อร้านค้า"
                                        value="{{$cr->address}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>telephone:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="telephone" class="form-control" placeholder="ชื่อร้านค้า"
                                    value="{{$cr->telephone}}">                                
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>email:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="email" class="form-control" placeholder="ชื่อร้านค้า"
                                        value="{{$cr->email}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>remark:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="remark" class="form-control" placeholder="ชื่อร้านค้า"
                                    value="{{$cr->remark}}">                                
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>sex:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="sex" class="form-control" placeholder="ชื่อร้านค้า"
                                        value="{{$cr->sex}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>image_string:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="image_string" class="form-control" placeholder="ชื่อร้านค้า"
                                    value="{{$cr->image_string}}">                                
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>users_login:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="users_login" class="form-control" placeholder="ชื่อร้านค้า"
                                        value="{{$cr->users_login}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>users_login:</strong></label>
                                <div class="col-sm-8">
                                    <select class="js-example-basic-single" style="width:100%" name="status">
                                        @if($cr->status == "A")
                                        <option disabled>เลือกสถานะพนักงาน</option>
                                        <option selected value="A">เปิดใช้งาน</option>
                                        <option value="B">ยกเลิก</option>
                                        @else
                                        <option disabled>เลือกสถานะพนักงาน</option>
                                        <option value="A">เปิดใช้งาน</option>
                                        <option selected value="B">ยกเลิก</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                    </div>

                    {{ Form::hidden('id', $cr->id, ['class' => 'form-control','id' => 'id']) }}

                    {{ Form::hidden('role', '2', ['class' => 'form-control','role' => 'role']) }}
                    {{ Form::hidden('status', 'A', ['class' => 'form-control','status' => 'status']) }}
                    {{ Form::hidden('created_by', 1, ['class' => 'form-control','created_by' => 'created_by']) }}
                    {{ Form::hidden('modified_by', 1, ['class' => 'form-control','modified_by' => 'modified_by']) }}

                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">แก้ไขพนักงาน</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}
@endforeach

<!-- Modal delete crew -->
@foreach($user as $cr)
{{ Form::open(['method' => 'delete' , 'url' => 'setting/shop_crew/delete']) }}
@csrf
<div class="modal fade" id="DELETE_SHOP_CREW{{$cr->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header ">
                <h4 class="modal-title">เพิ่ม พนักงาน</h4>
                <button type="button" class="btn btn-icons btn-rounded btn-closed" title="close" data-dismiss="modal"><i
                        class="mdi mdi-close"></i>
                </button>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>position_id:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="position_id" placeholder="position_id" class="form-control"
                                        value="{{$cr->position_id}}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>department_id:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="department_id" placeholder="department_id" class="form-control"
                                        value="{{$cr->department_id}}" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>users_code:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="users_code" placeholder="users_code" class="form-control"
                                        value="{{$cr->users_code}}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>title:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="title" placeholder="title" class="form-control"
                                        value="{{$cr->title}}" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>users_pass:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="users_pass" class="form-control" placeholder="ชื่อร้านค้า"
                                        value="{{$cr->users_pass}}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>names:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="names" class="form-control" placeholder="ชื่อร้านค้า"
                                    value="{{$cr->names}}" disabled>                                
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>address:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="address" class="form-control" placeholder="ชื่อร้านค้า"
                                        value="{{$cr->address}}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>telephone:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="telephone" class="form-control" placeholder="ชื่อร้านค้า"
                                    value="{{$cr->telephone}}" disabled>                                
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>email:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="email" class="form-control" placeholder="ชื่อร้านค้า"
                                        value="{{$cr->email}}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>remark:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="remark" class="form-control" placeholder="ชื่อร้านค้า"
                                    value="{{$cr->remark}}" disabled>                                
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>sex:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="sex" class="form-control" placeholder="ชื่อร้านค้า"
                                        value="{{$cr->sex}}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>image_string:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="image_string" class="form-control" placeholder="ชื่อร้านค้า"
                                    value="{{$cr->image_string}}" disabled>                                
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>users_login:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="users_login" class="form-control" placeholder="ชื่อร้านค้า"
                                        value="{{$cr->users_login}}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>users_login:</strong></label>
                                <div class="col-sm-8">
                                    <select class="js-example-basic-single" style="width:100%" name="status" disabled>
                                        @if($cr->status == "A")
                                        <option disabled>เลือกสถานะพนักงาน</option>
                                        <option selected value="A">เปิดใช้งาน</option>
                                        <option value="B">ยกเลิก</option>
                                        @else
                                        <option disabled>เลือกสถานะพนักงาน</option>
                                        <option value="A">เปิดใช้งาน</option>
                                        <option selected value="B">ยกเลิก</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                    </div>

                    {{ Form::hidden('id', $cr->id, ['class' => 'form-control','id' => 'id']) }}

                    {{ Form::hidden('role', '2', ['class' => 'form-control','role' => 'role']) }}
                    {{ Form::hidden('status', 'A', ['class' => 'form-control','status' => 'status']) }}
                    {{ Form::hidden('created_by', 1, ['class' => 'form-control','created_by' => 'created_by']) }}
                    {{ Form::hidden('modified_by', 1, ['class' => 'form-control','modified_by' => 'modified_by']) }}

                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger">ลบพนักงาน</button>
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