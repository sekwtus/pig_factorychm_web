@extends('layouts.master')
@section('style')
<style type="text/css">
    .input{
            height: 50%;
            background-color: aqua;
    }
    th,td{
        padding: 0px;
    }
    
</style>
<link rel="stylesheet" href="{{ url('https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ url('https://cdn.datatables.net/1.10.18/css/dataTables.semanticui.min.css') }}" type="text/css" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection
@section('main')

@if(session()->has('message'))
    <div class="alert alert-danger">
        {{ session()->get('message') }}
    </div>
@endif

<div class="ajax-loader" style="height: 800px;">
    <img src="{{ asset('assets/images/pig_fly.gif')}}" alt="" style="margin-left: 0px;top: 3%;width: 350px; left:37%;" class="img-responsive"  />
</div>
<div class="row ">
    <div class="col-lg-12 grid-margin">
        <div class="card">
            <div class="card-body ">
                    <div class="forms-sample form-control" style="height: auto;padding-right: 20px;">
                        <div class="text-center alert alert-fill-primary" style="margin-bottom: 10px;"> 
                            <h4>ราคามาตรฐานกลาง</h4>
                        </div>
                        
                        <div class="row text-center ">
                            <div class="col-md-12 pr-md-0" style="border-radius: 1px" : 1px solid #fc040478;">
                                <label for="type_req"><h4>สุกรขุน ตามาตรฐาน กระทรวงพานิชน์ กิโลกรัมละ :&nbsp</h4></label>
                                <label for="type_req" id="standard_price_com" style="color: rgb(17, 0, 255);"><h2>{{$standard_price_com[0]->standard_price}}&nbsp</h2></label>
                                <label for="type_req"><h4>บาท</h4></label>
                                <a  data-toggle="modal" data-target="#edit_price_com"><i class="fa fa-pencil-square-o" style="font-size:24px;color:#b3b3b3"></i></a>
                            </div>
                        
                        </div>
                        <div class="row text-center ">
                            <div class="col-md-3 pr-md-0" >
                                <label for="type_req"><h4>สุกรขุน กิโลกรัมละ :&nbsp</h4></label>
                                <label for="type_req" id="standard_price_m" style="color: rgb(21, 160, 21);"><h2>{{$standard_price_m[0]->standard_price}}&nbsp</h2></label>
                                <label for="type_req"><h4>บาท</h4></label>
                                <a  data-toggle="modal" data-target="#edit_price"><i class="fa fa-pencil-square-o" style="font-size:24px;color:#b3b3b3"></i></a>
                            </div>

                            <div class="col-md-3 pr-md-0" >
                                <label for="type_req"><h4>สุกร 5 เล็บ กิโลกรัมละ :&nbsp</h4></label>
                                <label for="type_req" id="standard_price_5" style="color: red;"><h2>{{$standard_price_5[0]->standard_price}}&nbsp</h2></label>
                                <label for="type_req"><h4>บาท</h4></label>
                                <a  data-toggle="modal" data-target="#edit_price_5"><i class="fa fa-pencil-square-o" style="font-size:24px;color:#b3b3b3"></i></a>
                            </div>
                            <div class="col-md-3 pr-md-0" >
                                <label for="type_req"><h4>พ่อพันธุ์ กิโลกรัมละ :&nbsp</h4></label>
                                <label for="type_req" id="standard_price_f" style="color: red;"><h2>{{$standard_price_f[0]->standard_price}}&nbsp</h2></label>
                                <label for="type_req"><h4>บาท</h4></label>
                                <a  data-toggle="modal" data-target="#edit_price_f"><i class="fa fa-pencil-square-o" style="font-size:24px;color:#b3b3b3"></i></a>
                            </div>
                            <div class="col-md-3 pr-md-0" >
                                <label for="type_req"><h4>แม่พันธุ์ กิโลกรัมละ :&nbsp</h4></label>
                                <label for="type_req" id="standard_price_mt" style="color: red;"><h2>{{$standard_price_mt[0]->standard_price}}</h2></label>
                                <label for="type_req"><h4>บาท</h4></label>
                                <a  data-toggle="modal" data-target="#edit_price_mt"><i class="fa fa-pencil-square-o" style="font-size:24px;color:#b3b3b3"></i></a>
                            </div>
                        </div>
                        <div class="row text-center ">

                            <div class="col-md-3 pr-md-0">
                                <label for="type_req"><h4>สุกรไข่ กิโลกรัมละ :&nbsp</h4></label>
                                <label for="type_req" id="standard_price_e" style="color: red;"><h2>{{$standard_price_e[0]->standard_price}}&nbsp</h2></label>
                                <label for="type_req"><h4>บาท</h4></label>
                                <a  data-toggle="modal" data-target="#edit_price_e"><i class="fa fa-pencil-square-o" style="font-size:24px;color:#b3b3b3"></i></a>
                            </div>
                            <div class="col-md-3 pr-md-0" >
                                <label for="type_req"><h4>หมูซาก กิโลกรัมละ :&nbsp</h4></label>
                                <label for="type_req" id="standard_price_sc" style="color: red;"><h2>{{$standard_price_sc[0]->standard_price}}&nbsp</h2></label>
                                <label for="type_req"><h4>บาท</h4></label>
                                <a  data-toggle="modal" data-target="#edit_price_sc"><i class="fa fa-pencil-square-o" style="font-size:24px;color:#b3b3b3"></i></a>
                            </div>
                            <div class="col-md-3 pr-md-0" >
                                <label for="type_req"><h4>หมูตาย กิโลกรัมละ :&nbsp</h4></label>
                                <label for="type_req" id="standard_price_d" style="color: red;"><h2>{{$standard_price_d[0]->standard_price}}&nbsp</h2></label>
                                <label for="type_req"><h4>บาท</h4></label>
                                <a  data-toggle="modal" data-target="#edit_price_d"><i class="fa fa-pencil-square-o" style="font-size:24px;color:#b3b3b3"></i></a>
                            </div>
                            <div class="col-md-3 pr-md-0" >
                                <label for="type_req"><h4>ค่าบริการอื่น ๆ </h4></label>
                                <label for="type_req" id="standard_price_d" style="color: red;"><h2>0</h2></label>
                                <label for="type_req"><h4>บาท</h4></label>
                                <a  data-toggle="modal" data-target="#edit_price_d"><i class="fa fa-pencil-square-o" style="font-size:24px;color:#b3b3b3"></i></a>
                            </div>
                        </div>

                        <div class="row text-center">

                            <div class="col-md-3 pr-md-0">
                                <label for="type_req"><h4>ราคาบริการเชือด(ที่โรงงาน) :&nbsp</h4></label>
                                <label for="type_req" id="standard_price_s" style="color: rgb(252, 129, 14);"><h2>{{$standard_price_s[0]->standard_price}}&nbsp</h2></label>
                                <label for="type_req"><h4>บาท</h4></label>
                                <a  data-toggle="modal" data-target="#edit_price_s"><i class="fa fa-pencil-square-o" style="font-size:24px;color:#b3b3b3"></i></a>
                            </div>
                            <div class="col-md-3 pr-md-0">
                                <label for="type_req"><h4>ราคาบริการตัดแต่ง(ที่โรงงาน) :&nbsp</h4></label>
                                <label for="type_req" id="standard_price_t" style="color: rgb(252, 129, 14);"><h2>{{$standard_price_t[0]->standard_price}}&nbsp</h2></label>
                                <label for="type_req"><h4>บาท</h4></label>
                                <a  data-toggle="modal" data-target="#edit_price_t"><i class="fa fa-pencil-square-o" style="font-size:24px;color:#b3b3b3"></i></a>
                            </div>
                            <div class="col-md-3 pr-md-0">
                                <label for="type_req"><h4 >เชือด(ที่อื่น) :&nbsp</h4></label>
                                <label for="type_req" id="standard_price_sx" style="color:darkviolet"><h2>{{$standard_price_sx[0]->standard_price}}&nbsp</h2></label>
                                <label for="type_req"><h4>บาท</h4></label>
                                <a  data-toggle="modal" data-target="#edit_price_sx"><i class="fa fa-pencil-square-o" style="font-size:24px;color:#b3b3b3"></i></a>
                            </div>
                            <div class="col-md-3 pr-md-0">
                                <label for="type_req"><h4 >ค่าขนส่ง(กรณีเชื่อดที่อื่น)</h4></label>
                                <label for="type_req" id="standard_price_sxt" style="color: darkviolet;"><h2>{{$standard_price_sxt[0]->standard_price}}&nbsp</h2></label>
                                <label for="type_req"><h4>บาท</h4></label>
                                <a  data-toggle="modal" data-target="#edit_price_sxt"><i class="fa fa-pencil-square-o" style="font-size:24px;color:#b3b3b3"></i></a>
                            </div>
                        </div>
                        <hr>
                        <div class="col-md-12 pr-md-0">
                            <label for="type_req" style="color: red">หมายเหตุ : </label>
                            การคำนวนราคา หากราคาที่ตั่งขาย เกินจากราคากระทรวงพานิชน์ จะนำส่วนต่างมาคิดเป็นค่าหมู
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>

<div class="row ">
    <div class="col-lg-12 grid-margin">
        <div class="card">
            <div class="card-body" >
                <div class="forms-sample form-control" style="height:100%;padding-right: 20px;">
                    <div class=" text-center alert alert-fill-info " style="margin-bottom: 10px;"><h4> ตารางราคาช่วงน้ำหนัก </h4></div>
                    <div class="row">
                        <div id="js-grid-static" class="jsgrid" style="position: relative;height:auto; width: 100%;">
                            <div class="jsgrid-grid-header jsgrid-header-scrollbar">
                                <table class="jsgrid-table text-center">
                                    <tr>
                                        <th colspan="1">ประเภท</th>
                                        <th rowspan="2">สุกรขุน</th>
                                        <td rowspan="2">สุกร5เล็บ</th>
                                        <th rowspan="2">สุกรไข่</th>
                                        <th rowspan="2">พ่อพันธุ์</th>
                                        <th rowspan="2">แม่พันธ์</th>
                                        <th rowspan="2">หมูซาก</th>
                                        <th rowspan="2">หมูตาย</th>
                                    </tr>
                                    <tr>
                                        <th>ช่วง นน.</th>
                                        {{-- <th>ส่วนลด</th> --}}
                                        {{-- <th>สุกรขุน</th>
                                        <td>สุกร5เล็บ</th>
                                        <th>สุกรไข่</th>
                                        <th>พ่อพันธุ์</th>
                                        <th>แม่พันธ์</th>
                                        <th>หมูซาก</th>
                                        <th>หมูตาย</th> --}}
                                    </tr>
                                </table>
                            </div>
                            <div class="jsgrid-grid-body" style="height: 100%">
                                <table class="jsgrid-table text-center">
                                    @foreach ($weight as $item)
                                        <tr>
                                            <td>{{$item->standard_period}}</td>
                                            {{-- <td>{{$item->standard_price}}</td> --}}
                                            <td>{{$item->standard_price_m}}</td>
                                            <td>{{$item->standard_price_5}}</td>
                                            <td>{{$item->standard_price_e}}</td>
                                            <td>{{$item->standard_price_f}}</td>
                                            <td>{{$item->standard_price_mt}}</td>
                                            <td>{{$item->standard_price_sc}}</td>
                                            <td>{{$item->standard_price_d}}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row ">
    <div class="col-lg-12 grid-margin">
        <div class="card">
            <div class="card-body" >
                <div class="forms-sample form-control" style="height: auto;padding-right: 20px;">
                    <div class=" text-center alert alert-fill-success " style="margin-bottom: 10px;"> <h4>ตารางราคาของลูกค้า</h4> </div>
                    <div class="row">
                        {{-- <div id="js-grid-static" class="jsgrid" style="position: relative;height: 340px;width: 100%;">
                            <div class="jsgrid-grid-header jsgrid-header-scrollbar">
                                <table class="jsgrid-table text-center">
                                    <tr>
                                        <th>รหัส</th>
                                        <th>ชื่อ</th>
                                        <th>สุกรขุน</th>
                                        <td>สุกร5เล็บ</th>
                                        <th>สุกรไข่</th>
                                        <th>พ่อพันธุ์</th>
                                        <th>แม่พันธ์</th>
                                        <th>หมูซาก</th>
                                        <th>หมูตาย</th>
                                    </tr>
                                </table>
                            </div>
                            <div class="jsgrid-grid-body" style="height: 280px">
                                <table class="jsgrid-table text-center">
                                    @foreach ($customer as $item)
                                        <tr>
                                            <td>{{$item->customer_code}}</td>
                                            <td>{{$item->customer_name}}</td>
                                            <td>{{$item->fattening}} ({{$standard_price_m[0]->standard_price+$item->fattening}})</td>
                                            <td>{{$item->pig_5}} ({{$standard_price_5[0]->standard_price+$item->pig_5}})</td>
                                            <td>{{$item->pig_egg}} ({{$standard_price_e[0]->standard_price+$item->pig_egg}})</td>
                                            <td>{{$item->father}} ({{$standard_price_f[0]->standard_price+$item->father}})</td>
                                            <td>{{$item->mother}} ({{$standard_price_mt[0]->standard_price+$item->mother}})</td>
                                            <td>{{$item->carcass}} ({{$standard_price_sc[0]->standard_price+$item->carcass}})</td>
                                            <td>{{$item->dead_pig}} ({{$standard_price_d[0]->standard_price+$item->dead_pig}})</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div> --}}
                        <div class="col-12">
                            <table class="table table-striped table-bordered nowrap table-hover" width="100%" id="orderTable" >
                                <thead class="text-center">
                                    <tr>
                                        <th>รหัส</th>
                                        <th>ชื่อ</th>
                                        <th>สุกรขุน</th>
                                        <th>สุกร5เล็บ</th>
                                        <th>สุกรไข่</th>
                                        <th>พ่อพันธุ์</th>
                                        <th>แม่พันธ์</th>
                                        <th>หมูซาก</th>
                                        <th>หมูตาย</th>
                                        <th>เชื่อด</th>
                                        <th>ตัดแต่ง</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- <div class="row ">
    <div class="col-lg-6 grid-margin">
        <div class="card">
            <div class="card-body" >
                    <div style="border: 1px solid #fc040478; font-family: 'Prompt', sans-serif; font-size: 0.90rem; padding: 1.32rem .75rem; line-height: 14px; font-weight: 300;">    
                        <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;"> เพิ่มกลุ่มลูกค้า </div>
                        <div class="row">
                            <div class="col-md-2 pr-md-0 text-center">
                                <button class="btn btn-success mr-2" type="button" data-toggle="modal" data-target="#add_type" title="เพิ่มชื่อกลุ่มราคาหมู"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                        <hr>
                            {{ Form::open(['method' => 'post' , 'url' => 'add_standard_group']) }}
                            
                                <div class="row">
                                    <div class="col-md-4 pr-md-0 text-right">
                                        <label for="type_req" ><b>ชื่อกลุ่ม : </b></label>
                                    </div>
                                    <div class="col-md-4 pr-md-0">
                                        <input type="text" class="form-control form-control-sm" name="name_group" placeholder="ชื่อกลุ่ม" style="height: 25px" required>
                                    </div>
                                </div>
                                <br>
                                <div id="js-grid-static" class="jsgrid" style="position: relative;height: 340px;width: 100%;">
                                    <div class="jsgrid-grid-header jsgrid-header-scrollbar">
                                        <table class="jsgrid-table text-center">
                                            <tr>
                                                <th style="width:70%;">ประเภทกลุ่ม</th>
                                                <th style="width:30%;">ราคา</th>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="jsgrid-grid-body" style="height: 280px">
                                        <table class="jsgrid-table text-left">
                                            @php
                                                $i = 0;
                                            @endphp
                                            @foreach ($standard_price_list_group as $item)
                                                <tr >
                                                    <td style="width:70%;">
                                                        <input type="checkbox" id="list_group_{{$i}}" name="list_group[{{$i}}]" value="{{$item->id}}">
                                                        <label for="list_group_{{$i}}">{{$item->price_list}}</label>
                                                    </td>
                                                    <td style="width:30%;">
                                                        <input class="form-control form-control-sm" type="number" name="prict_list_group[{{$i}}]" placeholder="0" >
                                                    </td>
                                                </tr>
                                                @php
                                                    $i++;
                                                @endphp
                                            @endforeach
                                            <input type="text" name="max" value="{{$i-1}}" hidden>
                                        </table>
                                    </div>
                                </div>
                            <br>
                            <div class="roe">
                                <div class="col-md-12 pr-md-0 text-center">
                                    <button type="submit" class="btn btn-success mr-2">ยืนยัน</button>
                                </div>
                            </div>
                                
                            {{ Form::close() }}
                    </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 grid-margin">
        <div class="card">
            <div class="card-body ">
                <div style="border: 1px solid #fc040478; font-family: 'Prompt', sans-serif; font-size: 0.90rem; padding: 1.32rem .75rem; line-height: 14px; font-weight: 300;">
                        <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;"> ช่วงน้ำหนัก </div>
                        <div class="row">
                            <div class="col-md-2 pr-md-0 text-center">
                                <button class="btn btn-success mr-2" type="button" data-toggle="modal" data-target="#add_wieght" title="เพิ่มช่วงน้ำหนัก"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                        <br>
                        <div id="js-grid-static" class="jsgrid" style="position: relative;height: 446px;width: 100%;">
                            <div class="jsgrid-grid-header jsgrid-header-scrollbar">
                                <table class="jsgrid-table text-center">
                                    <tr>
                                        <th style="width:70%">ช่วงน้ำหนัก</th>
                                        <th style="width:30%;" colspan="2">เกณฑ์ราคา</th>
                                    </tr>
                                </table>
                            </div>
                            <div class="jsgrid-grid-body" style="height: 390px">
                                <table class="jsgrid-table text-center">
                                    @foreach ($standard_weight as $item)
                                    <tr>
                                        <td style="width:70%">{{$item->standard_period}}</td>
                                        <td style="width:15%">{{$item->standard_price}}</td>
                                        <td style="width:15%"><button class="btn btn-warning mr-2" title="แก้ไข"  type="button" data-toggle="modal" data-target="#edit_wieght" onclick="edit_wg({{$item->id}},'{{$item->standard_period}}',{{$item->standard_price}})"><i class="fa fa-pencil"></i></button></td>
                                    </tr>
                                @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div> --}}

{{-- <div class="row ">
    <div class="col-lg-12 grid-margin">
        <div class="card">
            <div class="card-body ">
                        <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;"> กลุ่มลูกค้า </div>
                        <table class="table table-striped table-bordered nowrap table-hover " width="100%" id="orderTable">
                            <thead class="text-center">
                                <tr>
                                    <th style="padding: 0px; font-size: 0.7rem;">No.</th>
                                    <th style="padding: 0px; font-size: 0.7rem;">ชื่อกลุ่ม</th>
                                    <th style="padding: 0px; font-size: 0.7rem;">ประเภทกลุ่ม</th>
                                    <th style="padding: 0px; font-size: 0.7rem;">ราคาที่ลด</th>
                                </tr>
                            </thead>
                        </table>
            </div>
        </div>
    </div>
</div> --}}

<div class="modal fade" id="add_wieght" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{ Form::open(['method' => 'post' , 'url' => 'add_standard_weight']) }}
            <div class="forms-sample form-control" style="height: auto;padding-right: 20px;" id="">
                <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;"> เพิ่มช่วงน้ำหนัก </div>
                <div id="add_wg">
                    <div class="row">
                        <div class="col-md-6 pr-md-0 text-center">
                            <label for="type_req">ช่างน้ำหนัก</label>
                        </div>
                        <div class="col-md-6 pr-md-0 text-center">
                            <label for="type_req">เกณฑ์ราคา</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-1 pr-md-0 text-center"></div>
                        <div class="col-md-4 pr-md-0 text-center">
                            <input type="text" class="form-control form-control-sm" name="standard_period[]" placeholder="00-00" required>
                        </div>
                        <div class="col-md-2 pr-md-0 text-center"></div>
                        <div class="col-md-4 pr-md-0 text-center">
                            <input type="number" class="form-control form-control-sm" name="standard_price[]" step="0.00" placeholder="0.00" required>
                        </div>
                        <div class="col-md-1 pr-md-0 text-center"></div>
                    </div><br>
                </div>
                <div>
                    <button class="btn btn-primary mr-2" onclick="add_wg()"><i class="fa fa-plus"></i></button>
                    <button class="btn btn-danger mr-2" onclick="dd()"><i class="fa fa-minus"></i></button>
                </div>
                <div class="col-md-12 pr-md-0 text-center">
                    <button class="btn btn-success mr-2" type="submit">ยืนยัน</i></button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

<div class="modal fade" id="edit_wieght" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{ Form::open(['method' => 'post' , 'url' => 'edit_standard_weight']) }}
            <div class="forms-sample form-control" style="height: auto;padding-right: 20px;" id="">
                <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;"> แก้ไขช่วงน้ำหนัก </div>
                <div id="edit_wg">

                </div>
                <div class="col-md-12 pr-md-0 text-center">
                    <button class="btn btn-success mr-2" type="submit">ยืนยัน</i></button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

<div class="modal fade" id="edit_price_sxt" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{ Form::open(['method' => 'post' , 'url' => 'edit_standard_price/sxt']) }}
            <div class="forms-sample form-control" style="height: auto;padding-right: 20px;" id="">
                <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;"> แก้ราคาค่าเดือนทาง กรณีเชื่อดที่อื่น </div>
                <div id="edit_pr">
                    <span id="appen2[]">
                        <div class="row">
                            <div class="col-md-4 pr-md-0 text-center"></div>
                            <div class="col-md-4 pr-md-0 text-center">
                                <label for="type_req">กิโลกรัมละ</label>
                            </div>
                            <div class="col-md-4 pr-md-0 text-center"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 pr-md-0 text-center"></div>
                            <div class="col-md-4 pr-md-0 text-center">
                                <input type="number" class="form-control form-control-sm" name="price" value="{{$standard_price_sxt[0]->standard_price}}" required>
                            </div>
                            <div class="col-md-4 pr-md-0 text-center"></div>
                        </div><br></span>
                </div>
                <div class="col-md-12 pr-md-0 text-center">
                    <button class="btn btn-success mr-2" type="submit">ยืนยัน</i></button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

<div class="modal fade" id="edit_price_sx" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{ Form::open(['method' => 'post' , 'url' => 'edit_standard_price/sx']) }}
            <div class="forms-sample form-control" style="height: auto;padding-right: 20px;" id="">
                <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;"> แก้ราคาเชื่อดที่อื่น  </div>
                <div id="edit_pr">
                    <span id="appen2[]">
                        <div class="row">
                            <div class="col-md-4 pr-md-0 text-center"></div>
                            <div class="col-md-4 pr-md-0 text-center">
                                <label for="type_req">กิโลกรัมละ</label>
                            </div>
                            <div class="col-md-4 pr-md-0 text-center"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 pr-md-0 text-center"></div>
                            <div class="col-md-4 pr-md-0 text-center">
                                <input type="number" class="form-control form-control-sm" name="price" value="{{$standard_price_sx[0]->standard_price}}" required>
                            </div>
                            <div class="col-md-4 pr-md-0 text-center"></div>
                        </div><br></span>
                </div>
                <div class="col-md-12 pr-md-0 text-center">
                    <button class="btn btn-success mr-2" type="submit">ยืนยัน</i></button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

<div class="modal fade" id="edit_price_com" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{ Form::open(['method' => 'post' , 'url' => 'edit_standard_price/com']) }}
            <div class="forms-sample form-control" style="height: auto;padding-right: 20px;" id="">
                <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;"> แก้ไขราคาสุกรขุน ตามมาตฐาน กระทรวงพานิชน์ </div>
                <div id="edit_pr">
                    <span id="appen2[]">
                        <div class="row">
                            <div class="col-md-4 pr-md-0 text-center"></div>
                            <div class="col-md-4 pr-md-0 text-center">
                                <label for="type_req">กิโลกรัมละ</label>
                            </div>
                            <div class="col-md-4 pr-md-0 text-center"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 pr-md-0 text-center"></div>
                            <div class="col-md-4 pr-md-0 text-center">
                                <input type="number" class="form-control form-control-sm" name="price" value="{{$standard_price_com[0]->standard_price}}" required>
                            </div>
                            <div class="col-md-4 pr-md-0 text-center"></div>
                        </div><br></span>
                </div>
                <div class="col-md-12 pr-md-0 text-center">
                    <button class="btn btn-success mr-2" type="submit">ยืนยัน</i></button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>


<div class="modal fade" id="edit_price" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{ Form::open(['method' => 'post' , 'url' => 'edit_standard_price/m']) }}
            <div class="forms-sample form-control" style="height: auto;padding-right: 20px;" id="">
                <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;"> แก้ไขราคาสุกรขุน </div>
                <div id="edit_pr">
                    <span id="appen2[]">
                        <div class="row">
                            <div class="col-md-4 pr-md-0 text-center"></div>
                            <div class="col-md-4 pr-md-0 text-center">
                                <label for="type_req">กิโลกรัมละ</label>
                            </div>
                            <div class="col-md-4 pr-md-0 text-center"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 pr-md-0 text-center"></div>
                            <div class="col-md-4 pr-md-0 text-center">
                                <input type="number" class="form-control form-control-sm" name="price" value="{{$standard_price_m[0]->standard_price}}" required>
                            </div>
                            <div class="col-md-4 pr-md-0 text-center"></div>
                        </div><br></span>
                </div>
                <div class="col-md-12 pr-md-0 text-center">
                    <button class="btn btn-success mr-2" type="submit">ยืนยัน</i></button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

<div class="modal fade" id="edit_price_sc" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{ Form::open(['method' => 'post' , 'url' => 'edit_standard_price/sc']) }}
            <div class="forms-sample form-control" style="height: auto;padding-right: 20px;" id="">
                <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;"> แก้ไขราคาซาก </div>
                <div id="edit_pr">
                    <span id="appen2[]">
                        <div class="row">
                            <div class="col-md-4 pr-md-0 text-center"></div>
                            <div class="col-md-4 pr-md-0 text-center">
                                <label for="type_req">กิโลกรัมละ</label>
                            </div>
                            <div class="col-md-4 pr-md-0 text-center"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 pr-md-0 text-center"></div>
                            <div class="col-md-4 pr-md-0 text-center">
                                <input type="number" class="form-control form-control-sm" name="price" value="{{$standard_price_sc[0]->standard_price}}" required>
                            </div>
                            <div class="col-md-4 pr-md-0 text-center"></div>
                        </div><br></span>
                </div>
                <div class="col-md-12 pr-md-0 text-center">
                    <button class="btn btn-success mr-2" type="submit">ยืนยัน</i></button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

<div class="modal fade" id="edit_price_d" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{ Form::open(['method' => 'post' , 'url' => 'edit_standard_price/d']) }}
            <div class="forms-sample form-control" style="height: auto;padding-right: 20px;" id="">
                <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;"> แก้ไขราคาหมูตาย </div>
                <div id="edit_pr">
                    <span id="appen2[]">
                        <div class="row">
                            <div class="col-md-4 pr-md-0 text-center"></div>
                            <div class="col-md-4 pr-md-0 text-center">
                                <label for="type_req">กิโลกรัมละ</label>
                            </div>
                            <div class="col-md-4 pr-md-0 text-center"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 pr-md-0 text-center"></div>
                            <div class="col-md-4 pr-md-0 text-center">
                                <input type="number" class="form-control form-control-sm" name="price" value="{{$standard_price_sc[0]->standard_price}}" required>
                            </div>
                            <div class="col-md-4 pr-md-0 text-center"></div>
                        </div><br></span>
                </div>
                <div class="col-md-12 pr-md-0 text-center">
                    <button class="btn btn-success mr-2" type="submit">ยืนยัน</i></button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

<div class="modal fade" id="edit_price_s" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{ Form::open(['method' => 'post' , 'url' => 'edit_standard_price/s']) }}
            <div class="forms-sample form-control" style="height: auto;padding-right: 20px;" id="">
                <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;"> แก้ไขราคาบริการเชือด</div>
                <div id="edit_pr">
                    <span id="appen2[]">
                        <div class="row">
                            <div class="col-md-4 pr-md-0 text-center"></div>
                            <div class="col-md-4 pr-md-0 text-center">
                                <label for="type_req">ราคาเชือด</label>
                            </div>
                            <div class="col-md-4 pr-md-0 text-center"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 pr-md-0 text-center"></div>
                            <div class="col-md-4 pr-md-0 text-center">
                                <input type="number" class="form-control form-control-sm" name="price" value="{{$standard_price_s[0]->standard_price}}" required>
                            </div>
                            <div class="col-md-4 pr-md-0 text-center"></div>
                        </div><br></span>
                </div>
                <div class="col-md-12 pr-md-0 text-center">
                    <button class="btn btn-success mr-2" type="submit">ยืนยัน</i></button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

<div class="modal fade" id="edit_price_t" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{ Form::open(['method' => 'post' , 'url' => 'edit_standard_price/t']) }}
            <div class="forms-sample form-control" style="height: auto;padding-right: 20px;" id="">
                <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;"> แก้ไขราคาบริการตัดแต่ง</div>
                <div id="edit_pr">
                    <span id="appen2[]">
                        <div class="row">
                            <div class="col-md-4 pr-md-0 text-center"></div>
                            <div class="col-md-4 pr-md-0 text-center">
                                <label for="type_req">ราคาตัดแต่ง</label>
                            </div>
                            <div class="col-md-4 pr-md-0 text-center"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 pr-md-0 text-center"></div>
                            <div class="col-md-4 pr-md-0 text-center">
                                <input type="number" class="form-control form-control-sm" name="price" value="{{$standard_price_t[0]->standard_price}}" required>
                            </div>
                            <div class="col-md-4 pr-md-0 text-center"></div>
                        </div><br></span>
                </div>
                <div class="col-md-12 pr-md-0 text-center">
                    <button class="btn btn-success mr-2" type="submit">ยืนยัน</i></button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

<div class="modal fade" id="edit_price_c" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{ Form::open(['method' => 'post' , 'url' => 'edit_standard_price/c']) }}
            <div class="forms-sample form-control" style="height: auto;padding-right: 20px;" id="">
                <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;"> แก้ไขราคาบริการตัดแต่ง</div>
                <div id="edit_pr">
                    <span id="appen2[]">
                        <div class="row">
                            <div class="col-md-4 pr-md-0 text-center"></div>
                            <div class="col-md-4 pr-md-0 text-center">
                                <label for="type_req">ราคาหมูซาก ที่จะบวกกับราคามาตรฐานกลาง</label>
                            </div>
                            <div class="col-md-4 pr-md-0 text-center"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 pr-md-0 text-center"></div>
                            <div class="col-md-4 pr-md-0 text-center">
                                <input type="number" class="form-control form-control-sm" name="price" value="{{$standard_price_c[0]->standard_price}}" required>
                            </div>
                            <div class="col-md-4 pr-md-0 text-center"></div>
                        </div><br></span>
                </div>
                <div class="col-md-12 pr-md-0 text-center">
                    <button class="btn btn-success mr-2" type="submit">ยืนยัน</i></button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

<div class="modal fade" id="edit_price_5" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{ Form::open(['method' => 'post' , 'url' => 'edit_standard_price/5']) }}
            <div class="forms-sample form-control" style="height: auto;padding-right: 20px;" id="">
                <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;"> แก้ไขราคาสุกร 5 เล็บ</div>
                <div id="edit_pr">
                    <span id="appen2[]">
                        <div class="row">
                            <div class="col-md-4 pr-md-0 text-center"></div>
                            <div class="col-md-4 pr-md-0 text-center">
                                <label for="type_req">ราคากิโลกรัมละ</label>
                            </div>
                            <div class="col-md-4 pr-md-0 text-center"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 pr-md-0 text-center"></div>
                            <div class="col-md-4 pr-md-0 text-center">
                                <input type="number" class="form-control form-control-sm" name="price" value="{{$standard_price_5[0]->standard_price}}" required>
                            </div>
                            <div class="col-md-4 pr-md-0 text-center"></div>
                        </div><br></span>
                </div>
                <div class="col-md-12 pr-md-0 text-center">
                    <button class="btn btn-success mr-2" type="submit">ยืนยัน</i></button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

<div class="modal fade" id="edit_price_e" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{ Form::open(['method' => 'post' , 'url' => 'edit_standard_price/e']) }}
            <div class="forms-sample form-control" style="height: auto;padding-right: 20px;" id="">
                <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;"> แก้ไขราคาสุกรไข่</div>
                <div id="edit_pr">
                    <span id="appen2[]">
                        <div class="row">
                            <div class="col-md-4 pr-md-0 text-center"></div>
                            <div class="col-md-4 pr-md-0 text-center">
                                <label for="type_req">ราคากิโลกรัมละ</label>
                            </div>
                            <div class="col-md-4 pr-md-0 text-center"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 pr-md-0 text-center"></div>
                            <div class="col-md-4 pr-md-0 text-center">
                                <input type="number" class="form-control form-control-sm" name="price" value="{{$standard_price_e[0]->standard_price}}" required>
                            </div>
                            <div class="col-md-4 pr-md-0 text-center"></div>
                        </div><br></span>
                </div>
                <div class="col-md-12 pr-md-0 text-center">
                    <button class="btn btn-success mr-2" type="submit">ยืนยัน</i></button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

<div class="modal fade" id="edit_price_f" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{ Form::open(['method' => 'post' , 'url' => 'edit_standard_price/f']) }}
            <div class="forms-sample form-control" style="height: auto;padding-right: 20px;" id="">
                <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;"> แก้ไขราคาพ่อพันธุ์</div>
                <div id="edit_pr">
                    <span id="appen2[]">
                        <div class="row">
                            <div class="col-md-4 pr-md-0 text-center"></div>
                            <div class="col-md-4 pr-md-0 text-center">
                                <label for="type_req">ราคากิโลกรัมละ</label>
                            </div>
                            <div class="col-md-4 pr-md-0 text-center"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 pr-md-0 text-center"></div>
                            <div class="col-md-4 pr-md-0 text-center">
                                <input type="number" class="form-control form-control-sm" name="price" value="{{$standard_price_f[0]->standard_price}}" required>
                            </div>
                            <div class="col-md-4 pr-md-0 text-center"></div>
                        </div><br></span>
                </div>
                <div class="col-md-12 pr-md-0 text-center">
                    <button class="btn btn-success mr-2" type="submit">ยืนยัน</i></button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

<div class="modal fade" id="edit_price_mt" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{ Form::open(['method' => 'post' , 'url' => 'edit_standard_price/mt']) }}
            <div class="forms-sample form-control" style="height: auto;padding-right: 20px;" id="">
                <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;"> แก้ไขราคาแม่พันธุ์</div>
                <div id="edit_pr">
                    <span id="appen2[]">
                        <div class="row">
                            <div class="col-md-4 pr-md-0 text-center"></div>
                            <div class="col-md-4 pr-md-0 text-center">
                                <label for="type_req">ราคากิโลกรัมละ</label>
                            </div>
                            <div class="col-md-4 pr-md-0 text-center"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 pr-md-0 text-center"></div>
                            <div class="col-md-4 pr-md-0 text-center">
                                <input type="number" class="form-control form-control-sm" name="price" value="{{$standard_price_mt[0]->standard_price}}" required>
                            </div>
                            <div class="col-md-4 pr-md-0 text-center"></div>
                        </div><br></span>
                </div>
                <div class="col-md-12 pr-md-0 text-center">
                    <button class="btn btn-success mr-2" type="submit">ยืนยัน</i></button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

<div class="modal fade" id="add_type" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{ Form::open(['method' => 'post' , 'url' => 'add_type']) }}
            <div class="forms-sample form-control" style="height: auto;padding-right: 20px;" id="">
                <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;"> เพิ่มชื่อกลุ่มราคาหมู </div>
                <div id="add_type">
                    <div id="add_type2">
                        <div class="row">
                            <div class="col-md-6 pr-md-0 text-center">
                                <label for="type_req">กลุ่มราคาหมู</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-1 pr-md-0 text-center"></div>
                            <div class="col-md-6 pr-md-0 text-center">
                                <input type="text" class="form-control form-control-sm" name="type[]" placeholder="กลุ่มราคาหมู" required>
                            </div>
                            {{-- <div class="col-md-2 pr-md-0 text-center"></div> --}}
                            <div class="col-md-5 pr-md-0 text-center"></div>
                        </div><br>
                    </div>
                    <div>
                        <button class="btn btn-primary mr-2" onclick="add_type()"><i class="fa fa-plus"></i></button>
                        <button class="btn btn-danger mr-2" onclick="dd_type()"><i class="fa fa-minus"></i></button>
                    </div>

                </div>
                <div class="col-md-12 pr-md-0 text-center">
                    <button class="btn btn-success mr-2" type="submit">ยืนยัน</i></button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>


@endsection

@section('script')
<script src="{{ asset('https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js') }}"></script>

{{-- datatables --}}
<script>
        var table = $('#orderTable').DataTable({
            "scrollX": false,
            "scrollY": false,
            "scrollCollapse": true,
            "paging":         true,
            orderCellsTop: true,
            fixedHeader: true,
            dom: 'lBfrtip',
            buttons: [
                    {
                    extend: 'excel',
                    //  'pdf', 'print'
                    },
            ],
            // processing: true,
            // serverSide: true,
            ajax: '{{ url('get_standard_group') }}',
            columns: [
                { data: 'customer_code', name: 'customer_code' },
                { data: 'customer_name', name: 'customer_name' },
                { data: 'fattening', name: 'fattening' },
                { data: 'pig_5', name: 'pig_5' },
                { data: 'pig_egg', name: 'pig_egg' },
                { data: 'father', name: 'father' },
                { data: 'mother', name: 'mother' },
                { data: 'carcass', name: 'carcass' },
                { data: 'dead_pig', name: 'dead_pig' },
                { data: 'slice', name: 'slice' },
                { data: 'trim', name: 'trim' }
            ],
            columnDefs: [
            {
                "targets": 0,
                "className": "text-center",
            },
            {
                "targets": 1,
                    "className": "text-center",
            },
            {
                "targets": 2,
                    "className": "text-center",render(data,type,row){
                        standard_price = $("#standard_price_m").text();
                        price = parseFloat(standard_price)+parseFloat(data);
                        return data+" ("+price+")" ;
                    }
            },
            {
                "targets": 3,
                    "className": "text-center",render(data,type,row){
                        standard_price = $("#standard_price_5").text();
                        price = parseFloat(standard_price)+parseFloat(data);
                        return data+" ("+price+")" ;
                    }
            },
            {
                "targets": 4,
                    "className": "text-center",render(data,type,row){
                        standard_price = $("#standard_price_e").text();
                        price = parseFloat(standard_price)+parseFloat(data);
                        return data+" ("+price+")" ;
                    }
            },
            {
                "targets": 5,
                    "className": "text-center",render(data,type,row){
                        standard_price = $("#standard_price_f").text();
                        price = parseFloat(standard_price)+parseFloat(data);
                        return data+" ("+price+")" ;
                    }
            },
            {
                "targets": 6,
                    "className": "text-center",render(data,type,row){
                        standard_price = $("#standard_price_mt").text();
                        price = parseFloat(standard_price)+parseFloat(data);
                        return data+" ("+price+")" ;
                    }
            },
            {
                "targets": 7,
                    "className": "text-center",render(data,type,row){
                        standard_price = $("#standard_price_sc").text();
                        price = parseFloat(standard_price)+parseFloat(data);
                        return data+" ("+price+")" ;
                    }
            },
            {
                "targets": 8,
                    "className": "text-center",render(data,type,row){
                        standard_price = $("#standard_price_d").text();
                        price = parseFloat(standard_price)+parseFloat(data);
                        return data+" ("+price+")" ;
                    }
            },
            {
                "targets": 9,
                    "className": "text-center",render(data,type,row){
                        standard_price = $("#standard_price_s").text();
                        price = parseFloat(standard_price)+parseFloat(data);
                        return data+" ("+price+")" ;
                    }
            },
            {
                "targets": 10,
                    "className": "text-center",render(data,type,row){
                        standard_price = $("#standard_price_t").text();
                        price = parseFloat(standard_price)+parseFloat(data);
                        return data+" ("+price+")" ;
                    }
            },
            ],
            "order": [],
        });

        $(document).ready(function() {
            // $('#dateFilterReceive').change( function() {
                table.draw();
            // } );
        } );
   
</script>

{{-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script> --}}
<script src="{{ asset('https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js') }}"></script>
<script>
    function deleteOrder(order_number){
        if(confirm('ต้องการลบ Order : '+order_number+' ?')){
            $.ajax({
                type: 'GET',
                url: '{{ url('delete_order') }}',
                data: {order_number:order_number},
                success: function (msg) {
                    alert(msg);
                    location.reload();
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("Status: " + textStatus); alert("Error: " + errorThrown);
                }
            });
        }
    }
</script>

<script>
    function editModal(order_number,id_user_customer,marker,total_pig,weight_range,date,note,type_request,order_type,round){
        $("#EDIT").modal();
        var get_type_order = '';
            $.ajax({
                type: 'GET',
                url: '{{ url('ajax_type_order') }}',
                data: {},
                success: function (data) {
                    data.forEach(element => {
                        if (order_type == element.order_type) {
                            get_type_order = get_type_order + '<option selected value="'+element.id+'">'+element.order_type+'</option>';
                            
                        } 
                        // else {
                        //     get_type_order = get_type_order + '<option value="'+element.id+'">'+element.order_type+'</option>';
                        // }
                    });
                    if (note == '' || note == null || note == 'null') {
                        note = '';
                    }
                    if (round == '' || round == null || round == 'null') {
                        round = '';
                    }

                    var str = '<div class="forms-sample form-control" style="height: 400px;padding-right: 20px;">\
                            <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;">แก้ไข Order <b style="color:black;">'+order_number+'</b></div>\
                            <div class="row" style="margin-bottom: 10px;">\
                                <div class="col-md-6 pr-md-0">\
                                    <label for="type_req">ประเภท</label>\
                                        <select class="form-control form-control-sm" id="type_req" name="type_req" style=" height: 30px; " required>\
                                            '+get_type_order+'\
                                    </select>\
                                </div>\
                                <div class="col-md-6 pr-md-0">\
                                    <label for="orderDate">ประจำวันที่</label>\
                                    <input class="form-control form-control-sm" placeholder="วว/ดด/ปปปป" type="text" id="datepicker2" name="datepicker" value="'+date+'" required></div>\
                            </div>\
                            <div class="row" style="margin-bottom: 10px;">\
                                <div class="col-md-6 pr-md-0">\
                                    <label for="customer">ลูกค้า/สาขา</label>\
                                    <input readonly type="text" class="form-control form-control-sm" name="customer" id="customer" placeholder="ลูกค้า" value="'+id_user_customer+'" required>\
                                </div>\
                                <div class="col-md-3 pr-md-0">\
                                    <label for="marker">อักษรย่อ</label>\
                                    <input readonly type="text" class="form-control form-control-sm"  name="marker" id="marker" placeholder="อักษรย่อ" value="'+marker+'" required> \
                                </div>\
                                <div class="col-md-3 pr-md-0">\
                                    <label for="round">รอบที่</label>\
                                    <select class="form-control form-control-sm" id="round" name="round" style=" height: 30px; ">\
                                        <option value="'+round+'">'+round+'</option>\
                                        <option value=""></option>\
                                        <option value="A">A</option>\
                                        <option value="B">B</option>\
                                        <option value="C">C</option>\
                                        <option value="D">D</option>\
                                        <option value="E">E</option>\
                                    </select>\
                                </div>\
                            </div>\
                            <div class="row" style="margin-bottom: 10px;">\
                                <div class="col-md-6 pr-md-0">\
                                    <label for="amount">จำนวน(ตัว)</label>\
                                    <input type="number" class="form-control form-control-sm" name="amount" id="amount" placeholder="จำนวน" value="'+total_pig+'" required> </div>\
                                <div class="col-md-6 pr-md-0">\
                                    <label for="weight_range">ช่วงน้ำหนัก</label>\
                                    <input type="text" class="form-control form-control-sm" name="weight_range" id="weight_range" placeholder="ช่วงน้ำหนัก" value="'+weight_range+'" required> </div>\
                            </div>\
                            <div class="row" style="margin-bottom: 10px;">\
                                <div class="col-md-12 pr-md-0">\
                                    <label for="note">หมายเหตุ</label>\
                                    <input class="form-control form-control-sm" name="note" id="note" rows="3" placeholder="หมายเหตุ" value="'+note+'"></input> </div>\
                                </div>\
                                <div class="text-center" style="padding-top: 10px;">\
                                    <button type="submit" name="order_number" value="'+order_number+'" class="btn btn-success mr-2" onclick="loader2()">ยืนยัน</button>\
                                </div>\
                    </div>';
                    $("#data_edit").html(str);
                    $('#datepicker2').daterangepicker({
                        buttonClasses: ['btn', 'btn-sm'],
                        applyClass: 'btn-danger',
                        cancelClass: 'btn-inverse',
                        singleDatePicker: true,
                        todayBtn: true,
                        language: 'th',
                        thaiyear: true,
                        locale: {
                            format: 'DD/MM/YYYY',
                            daysOfWeek : [
                                            "อา.",
                                            "จ.",
                                            "อ.",
                                            "พ.",
                                            "พฤ.",
                                            "ศ.",
                                            "ส."
                                        ],
                            monthNames : [
                                            "มกราคม",
                                            "กุมภาพันธ์",
                                            "มีนาคม",
                                            "เมษายน",
                                            "พฤษภาคม",
                                            "มิถุนายน",
                                            "กรกฎาคม",
                                            "สิงหาคม",
                                            "กันยายน",
                                            "ตุลาคม",
                                            "พฤศจิกายน",
                                            "ธันวาคม"
                                        ],
                            firstDay : 0
                        }
                    });

                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("Status: " + textStatus); alert("Error: " + errorThrown);
                }
            });
            
    }
</script>


{{-- datepicker --}}
{{-- <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script> --}}
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
    $('#datepicker,#daterange2,#datepicker22').daterangepicker({
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-danger',
        cancelClass: 'btn-inverse',
        singleDatePicker: true,
        todayBtn: true,
        language: 'th',
        thaiyear: true,
        locale: {
            format: 'DD/MM/YYYY',
            daysOfWeek : [
                            "อา.",
                            "จ.",
                            "อ.",
                            "พ.",
                            "พฤ.",
                            "ศ.",
                            "ส."
                        ],
            monthNames : [
                            "มกราคม",
                            "กุมภาพันธ์",
                            "มีนาคม",
                            "เมษายน",
                            "พฤษภาคม",
                            "มิถุนายน",
                            "กรกฎาคม",
                            "สิงหาคม",
                            "กันยายน",
                            "ตุลาคม",
                            "พฤศจิกายน",
                            "ธันวาคม"
                        ],
            firstDay : 0
        }
    });
    $('#dateFilterReceive').daterangepicker({
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-danger',
        cancelClass: 'btn-inverse',
        singleDatePicker: true,
        todayBtn: true,
        language: 'th',
        thaiyear: true,
        locale: {
            format: 'DD/MM/YYYY',
            daysOfWeek : [
                            "อา.",
                            "จ.",
                            "อ.",
                            "พ.",
                            "พฤ.",
                            "ศ.",
                            "ส."
                        ],
            monthNames : [
                            "มกราคม",
                            "กุมภาพันธ์",
                            "มีนาคม",
                            "เมษายน",
                            "พฤษภาคม",
                            "มิถุนายน",
                            "กรกฎาคม",
                            "สิงหาคม",
                            "กันยายน",
                            "ตุลาคม",
                            "พฤศจิกายน",
                            "ธันวาคม"
                        ],
            firstDay : 0
        }
    });  
</script>

<script>
    function setMarker(customer){
        // alert(customer.value);
        $.ajax({
                type: 'GET',
                url: '{{ url('getMarkerCustomer') }}',
                data: {customer:customer.value},
                success: function (data) {
                    $('#marker').val(data[0].marker);
                    $('#customer_id').val(data[0].id);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("Status: " + textStatus); alert("Error: " + errorThrown);
                }
            });
    }

    function customerDll(type_req){

        $.ajax({
            type: 'GET',
            url: '{{ url('getCustomer') }}',
            data: {},
            success: function (data) {
                var str ='<option value=""></option>';
                data.forEach(element => {
                    if (type_req.value == 3) {
                        if (element.type == 'สาขา') {
                        str = str + '<option value="'+element.customer_name+'">'+element.customer_name+'</option>';
                        }
                        $('#status').prop( "disabled", false );
                    }else if (type_req.value == 2) {
                        if (element.type == 'ลูกค้าซาก') {
                        str = str + '<option value="'+element.customer_name+'">'+element.customer_name+'</option>';
                        }
                        $('#status').prop( "disabled", true );
                    }
                    else{
                        if (element.type != 'สาขา' && element.type != 'ลูกค้าซาก') {
                        str = str + '<option value="'+element.customer_name+'">'+element.customer_name+'</option>';
                        }
                        $('#status').prop( "disabled", true );
                    }
                });
                $('#customer').html(str);
                // console.log(type_req.value);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert("Status: " + textStatus); alert("Error: " + errorThrown);
            }
        });


    }
</script>

<script>
    var msg = '{{Session::get('alert')}}';
    var exist = '{{Session::has('alert')}}';
    if(exist){
        $("#Alert").modal();
    }
</script>
<script>
    function loader2(){
        $("#EDIT").modal('hide');
        $('.ajax-loader').css("visibility", "visible");
    }
</script>
<script>
    function add_wg(){
        var row = '';
        row = row + '<span id="appen[]">\
                    <div class="row">\
                        <div class="col-md-6 pr-md-0 text-center">\
                            <label for="type_req">ช่างน้ำหนัก</label>\
                        </div>\
                        <div class="col-md-6 pr-md-0 text-center">\
                            <label for="type_req">เกณฑ์ราคา</label>\
                        </div>\
                    </div>\
                    <div class="row">\
                        <div class="col-md-1 pr-md-0 text-center"></div>\
                        <div class="col-md-4 pr-md-0 text-center">\
                            <input type="text" class="form-control form-control-sm" name="standard_period[]" placeholder="00-00" required>\
                        </div>\
                        <div class="col-md-2 pr-md-0 text-center"></div>\
                        <div class="col-md-4 pr-md-0 text-center">\
                            <input type="number" class="form-control form-control-sm" name="standard_price[]" step="0.00" placeholder="0.00" required>\
                        </div>\
                        <div class="col-md-1 pr-md-0 text-center"></div>\
                    </div><br></span>';
        
        $('#add_wg').append(row);
    }
    function dd(){
        var mySpan = document.getElementById('add_wg');
        var deleteEle = document.getElementById('appen[]');
            mySpan.removeChild(deleteEle);
    }

    function edit_wg(id,period,price){
        // $('#add_wg').empty();
        var row = '';
        row = row + '<div class="row">\
                        <div class="col-md-6 pr-md-0 text-center">\
                            <label for="type_req">ช่างน้ำหนัก</label>\
                        </div>\
                        <div class="col-md-6 pr-md-0 text-center">\
                            <label for="type_req">เกณฑ์ราคา</label>\
                        </div>\
                    </div>\
                    <div class="row">\
                        <div class="col-md-1 pr-md-0 text-center"></div>\
                        <div class="col-md-4 pr-md-0 text-center">\
                            <input type="text" class="form-control form-control-sm" name="standard_period" value="'+period+'" placeholder="00-00" required>\
                        </div>\
                        <div class="col-md-2 pr-md-0 text-center"></div>\
                        <div class="col-md-4 pr-md-0 text-center">\
                            <input type="number" class="form-control form-control-sm" name="standard_price" value="'+price+'" step="0.00" placeholder="0.00" required>\
                            <input type="number" class="form-control form-control-sm" name="id" value="'+id+'" hidden >\
                        </div>\
                        <div class="col-md-1 pr-md-0 text-center"></div>\
                    </div><br>';
        $('#edit_wg').append(row);
    }

    function add_type(){
        var row = '';
        row = row + '<span id="appen2[]">\
                    <div class="row">\
                        <div class="col-md-6 pr-md-0 text-center">\
                            <label for="type_req">ช่างน้ำหนัก</label>\
                        </div>\
                    </div>\
                    <div class="row">\
                        <div class="col-md-1 pr-md-0 text-center"></div>\
                        <div class="col-md-6 pr-md-0 text-center">\
                            <input type="text" class="form-control form-control-sm" name="type[]" placeholder="กลุ่มราคาหมู" required>\
                        </div>\
                        <div class="col-md-5 pr-md-0 text-center"></div>\
                    </div><br></span>';
        
        $('#add_type2').append(row);
    }
    function dd_type(){
        var mySpan = document.getElementById('add_type2');
        var deleteEle = document.getElementById('appen2[]');
            mySpan.removeChild(deleteEle);
    }

    // function editprice(price){
    //     alert(price);
    //     $('#edit_pr').empty();
    //     var row = '';
    //     row = row + '<span id="appen2[]">\
    //                 <div class="row">\
    //                     <div class="col-md-4 pr-md-0 text-center"></div>\
    //                     <div class="col-md-4 pr-md-0 text-center">\
    //                         <label for="type_req">กิโลกรัมละ</label>\
    //                     </div>\
    //                     <div class="col-md-4 pr-md-0 text-center"></div>\
    //                 </div>\
    //                 <div class="row">\
    //                     <div class="col-md-4 pr-md-0 text-center"></div>\
    //                     <div class="col-md-4 pr-md-0 text-center">\
    //                         <input type="number" class="form-control form-control-sm" name="price" value"'+price+'" required>\
    //                     </div>\
    //                     <div class="col-md-4 pr-md-0 text-center"></div>\
    //                 </div><br></span>';
    //     $('#edit_pr').append(row);
    }
</script>
@endsection


