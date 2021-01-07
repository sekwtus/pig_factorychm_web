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
                    <h4>โปรโมชั่น</h4>
                </div>
                <div class="col-8 text-right">
                    <button class="btn btn-sm btn-outline btn-success" type="button" data-toggle="modal"
                        data-target="#add_promotion"><i class="fa fa-plus" aria-hidden="true"></i>เพิ่มโปรโมชั่น</button>
                </div>
            </div>
            <br>
            @if(Session::has('message_success'))
            <div class="alert alert-success" role="alert"> {{Session::get('message_success')}}</div>
            @endif
            <br>
            <div class="table-responsive">
                <table class="table table-striped table-bordered nowrap" width="100%" id="table_promotion">
                    <thead class="text-center">
                        <tr>
                            <th style="padding: 0px;">ลำดับ</th>
                            <th style="padding: 0px;">ชื่อโปรโมชั่น</th>
                            <th style="padding: 0px;">เงื่อนไขต้องซื้อมากกว่า (กิโลกรัม)</th>
                            <th style="padding: 0px;">ราคาปกติ</th>
                            <th style="padding: 0px;">ราคาหลังลดแล้ว</th>
                            <th style="padding: 0px;">วันสิ้นสุดโปรโมชั่น</th>
                            <th style="text-align:center; padding: 0px;"> ดำเนินการ </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $count = 1 ?>
                        @foreach ($promotion as $pr)

                        <?php
                            $date = date("d-m-Y", strtotime($pr->stop_date));
                        ?>

                        <tr>
                            <td align="center">{{ $count }}</td>
                            <td align="center">{{ $pr->promotion_name }}</td>
                            <td align="center">{{ $pr->max }} กิโลกรัม</td>
                            <td align="center">{{ $pr->standard_price }} / กิโลกรัม</td>
                            <td align="center">{{ $pr->total_price }} / กิโลกรัม</td>
                            @if($pr->remain > 0)
                            <td align="center" style="color: green;">{{ $date }} &ensp; เหลือเวลามากกว่า {{$pr->remain}}
                                วัน</td>
                            @else
                            <td align="center" style="color: red;">{{ $date }} &ensp; สิ้นสุดโปรโมชั่นแล้ว</td>

                            @endif
                            <td align="center">
                                <button class="btn btn-sm btn-outline btn-primary" type="button" data-toggle="modal"
                                    data-target="#DETAIL{{$pr->id}}"><i class="fa fa-search"
                                        aria-hidden="true">&ensp;</i></button>
                                <button class="btn btn-sm btn-outline btn-warning" type="button" data-toggle="modal"
                                    data-target="#EDIT{{$pr->id}}"><i class="fa fa-edit"
                                        aria-hidden="true">&ensp;</i></button>
                                <button class="btn btn-sm btn-outline btn-danger" data-toggle="modal"
                                    data-target="#DELETE{{$pr->id}}"><i class="fa fa-times"
                                        aria-hidden="true">&ensp;</i></button>
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

<!-- Modal add -->
{{ Form::open(['method' => 'post' , 'url' => 'setting_promotion/add']) }}
@csrf
<div class="modal fade" id="add_promotion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header ">
                <h4 class="modal-title">เพิ่ม โปรโมชั่น</h4>
                <button type="button" class="btn btn-icons btn-rounded btn-closed" title="close" data-dismiss="modal"><i
                        class="mdi mdi-close"></i></button>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label"><strong>ชื่อโปรโมชั่น:</strong></label>
                                <div class="col-sm-10">
                                    <textarea type="text" name="promotion_name" placeholder="ชื่อโปรโมชั่น"
                                        class="form-control"></textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>รหัสโปรโมชั่น:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="produce_code" placeholder="1038" class="form-control"
                                        value="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>โค้ดใหม่ ที่ลดราคาแล้ว:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="new_code" placeholder="9038" class="form-control" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>น้ำหนักต่ำสุด:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="min" placeholder="น้ำหนักต่ำสุด" class="form-control"
                                        value="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>น้ำหนักสูงสุด:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="max" placeholder="น้ำหนักสูงสุด" class="form-control"
                                        value="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>วันที่เริ่มโปรโมชั่น:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="start_date" class="form-control"
                                        placeholder="วันที่เริ่มโปรโมชั่น" value="2020-01-16 00:00:00">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>วันสิ้นสุดโปรโมชั่น:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="stop_date" class="form-control"
                                        placeholder="วันสิ้นสุดโปรโมชั่น" value="2020-01-16 00:00:00">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>ราคาปกติ:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="standard_price" class="form-control" placeholder="ราคาปกติ"
                                        value="0.00">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>ราคาที่ลด:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="discount_price" class="form-control"
                                        placeholder="ราคาที่ลด" value="0.00">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>กลุ่ม:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="group" placeholder="กลุ่ม" class="form-control" value="1">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">เพิ่มโปรโมชั่น</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}

<!-- Modal edit -->
@foreach ($promotion as $pr)
{{ Form::open(['method' => 'put' , 'url' => 'setting_promotion/update']) }}
@csrf
<div class="modal fade" id="EDIT{{$pr->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header ">
                <h4 class="modal-title">แก้ไข รายละเอียดโปรโมชั่น</h4>
                <button type="button" class="btn btn-icons btn-rounded btn-closed" title="close" data-dismiss="modal"><i
                        class="mdi mdi-close"></i></button>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label"><strong>ชื่อโปรโมชั่น:</strong></label>
                                <div class="col-sm-10">
                                    <textarea type="text" name="promotion_name"
                                        class="form-control">{{ $pr->promotion_name}}</textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>รหัสโปรโมชั่น:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="produce_code" class="form-control"
                                        value="{{ $pr->produce_code }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>โค้ดใหม่ ที่ลดราคาแล้ว:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="new_code" class="form-control" value="{{ $pr->new_code }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>น้ำหนักต่ำสุด:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="min" class="form-control" value="{{ $pr->min }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>น้ำหนักสูงสุด:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="max" class="form-control" value="{{ $pr->max }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>วันที่เริ่มโปรโมชั่น:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="start_date" class="form-control"
                                        value="{{ $pr->start_date }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>วันที่สิ้นสุดโปรโมชั่น:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="stop_date" class="form-control"
                                        value="{{ $pr->stop_date }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>ราคาปกติ:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="standard_price" class="form-control"
                                        value="{{ $pr->standard_price }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>ราคาที่ลด:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="discount_price" class="form-control"
                                        value="{{ $pr->discount_price }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>กลุ่ม:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="group" class="form-control" value="{{ $pr->group }}">
                                </div>
                            </div>
                        </div>

                    </div>
                    {{ Form::hidden('id', $pr->id, ['class' => 'form-control','id' => 'id']) }}
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">แก้ไข</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}
@endforeach

<!-- Modal detail -->
@foreach ($promotion as $pr)
{{ Form::open(['method' => 'post' , 'url' => '#']) }}
@csrf
<div class="modal fade" id="DETAIL{{$pr->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header ">
                <h4 class="modal-title">รายละเอียดทั้งหมดของโปรโมชั่น</h4>
                <button type="button" class="btn btn-icons btn-rounded btn-closed" title="close" data-dismiss="modal"><i
                        class="mdi mdi-close"></i></button>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label"><strong>ชื่อโปรโมชั่น:</strong></label>
                                <div class="col-sm-10">
                                    <textarea type="text" name="promotion_name"
                                        class="form-control" disabled>{{ $pr->promotion_name}}</textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>รหัสโปรโมชั่น:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="produce_code" class="form-control"
                                        value="{{ $pr->produce_code }}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>โค้ดใหม่ ที่ลดราคาแล้ว:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="new_code" class="form-control" value="{{ $pr->new_code }}" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>น้ำหนักต่ำสุด:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="min" class="form-control" value="{{ $pr->min }}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>น้ำหนักสูงสุด:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="max" class="form-control" value="{{ $pr->max }}" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>วันที่เริ่มโปรโมชั่น:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="start_date" class="form-control"
                                        value="{{ $pr->start_date }}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>วันที่สิ้นสุดโปรโมชั่น:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="stop_date" class="form-control"
                                        value="{{ $pr->stop_date }}" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>ราคาปกติ:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="standard_price" class="form-control"
                                        value="{{ $pr->standard_price }}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>ราคาที่ลด:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="discount_price" class="form-control"
                                        value="{{ $pr->discount_price }}" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>กลุ่ม:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="group" class="form-control" value="{{ $pr->group }}" disabled>
                                </div>
                            </div>
                        </div>

                    </div>
                    {{ Form::hidden('id', $pr->id, ['class' => 'form-control','id' => 'id']) }}
                </div>
            </div>
            <div class="modal-footer">
                {{-- <button type="submit" class="btn btn-success">แก้ไข</button> --}}
                <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}
@endforeach

<!-- Modal delete -->
@foreach ($promotion as $pr)
{{ Form::open(['method' => 'delete' , 'url' => 'setting_promotion/delete']) }}
@csrf
<div class="modal fade" id="DELETE{{$pr->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header ">
                <h4 class="modal-title">รายละเอียดทั้งหมดของโปรโมชั่น</h4>
                <button type="button" class="btn btn-icons btn-rounded btn-closed" title="close" data-dismiss="modal"><i
                        class="mdi mdi-close"></i></button>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label"><strong>ชื่อโปรโมชั่น:</strong></label>
                                <div class="col-sm-10">
                                    <textarea type="text" name="promotion_name"
                                        class="form-control" disabled>{{ $pr->promotion_name}}</textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>รหัสโปรโมชั่น:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="produce_code" class="form-control"
                                        value="{{ $pr->produce_code }}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>โค้ดใหม่ ที่ลดราคาแล้ว:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="new_code" class="form-control" value="{{ $pr->new_code }}" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>น้ำหนักต่ำสุด:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="min" class="form-control" value="{{ $pr->min }}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>น้ำหนักสูงสุด:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="max" class="form-control" value="{{ $pr->max }}" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>วันที่เริ่มโปรโมชั่น:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="start_date" class="form-control"
                                        value="{{ $pr->start_date }}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>วันที่สิ้นสุดโปรโมชั่น:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="stop_date" class="form-control"
                                        value="{{ $pr->stop_date }}" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>ราคาปกติ:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="standard_price" class="form-control"
                                        value="{{ $pr->standard_price }}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>ราคาที่ลด:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="discount_price" class="form-control"
                                        value="{{ $pr->discount_price }}" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><strong>กลุ่ม:</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" name="group" class="form-control" value="{{ $pr->group }}" disabled>
                                </div>
                            </div>
                        </div>

                    </div>
                    {{ Form::hidden('id', $pr->id, ['class' => 'form-control','id' => 'id']) }}
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger">ลบรายการ</button>
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
        $('#table_promotion').DataTable();
    });
</script>


@endsection