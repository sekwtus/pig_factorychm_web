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
                    <h4>ร้านค้า</h4>
                </div>
                <div class="col-8 text-right">
                    <a class="btn btn-success btn-fw" data-toggle="modal" data-target="#ADDSHOP">
                        <i class="mdi mdi-plus"></i>เพิ่มร้านค้า
                    </a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-bordered nowrap" width="100%" id="table_shop">
                    <thead class="text-center">
                        <tr>
                            <th style="padding: 0px;">ลำดับ</th>
                            <th style="padding: 0px;">รหัสร้านค้า</th>
                            <th style="padding: 0px;">ชื่อร้านค้า</th>
                            <th style="padding: 0px;">รายละเอียด</th>
                            <th style="padding: 0px;">สถานะ</th>
                            <th style="text-align:center; padding: 0px;"> ดำเนินการ </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- ADDข้อมูล --}}
{{ Form::open(['method' => 'post' , 'url' => 'setting_shop/save', 'files' => true]) }}
<div class="modal fade" id="ADDSHOP" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="padding: 10px;">
                <label class="modal-title" id="myModalLabel"><b>
                        เพิ่มร้านค้า</b></label>
            </div>
            <div class="modal-body" style="padding: 10px;">
                <div class="panel-body">
                    <div class="form-body">
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group has-error">
                                    <label class="control-label">
                                        รหัสร้านค้า
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="ti-user"></i></div>
                                        <input class="form-control" placeholder="รหัสร้านค้า" required id="shop_code"
                                            name="shop_code" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group has-error">
                                    <label class="control-label">ชื่อร้านค้า</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="ti-home"></i></div>
                                        <input class="form-control" placeholder="ชื่อร้านค้า" required id="shop_name"
                                            name="shop_name" type="text">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">
                                        รายละเอียดร้านค้า
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="ti-mobile"></i></div>
                                        <textarea class="form-control" placeholder="รายละเอียดร้านค้า" required
                                            id="shop_description" name="shop_description" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group has-error">
                                    <label class="control-label">
                                        สถานะร้านค้า
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-layout-grid2-alt"></i>
                                        </span>
                                        <select class="form-control" id="status" name="status" required
                                            data-error="กรุณาเลือกสถานะร้านค้า">
                                            <option disabled selected> เลือกสถานะร้านค้า </option>

                                            <option value="A">ใช้งาน</option>
                                            <option value="D">ไม่ใช้งาน</option>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-md-6">
                                        <div class="form-group has-error">
                                            <label class="control-label">
                                                แผนกผู้ใช้
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="ti-layout-grid2-alt"></i>
                                                </span>
                                                <select class="form-control" id="type_branch" name="type_branch" required data-error="เลือกแผนกผู้ใช้">
                                                        <option value="" selected>เลือกแผนกผู้ใช้</option>
                                                    @foreach ($branch as $branch_)
                                                        <option value="{{ $branch_->id }}">{{ $branch_->branch_name }}
                            </option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                </div> --}}
            </div>
            {{-- <div class="row">
                                    <div class="col-md-12">
                                        <h4 class="card-title d-flex">อัพโหลดรูปภาพ
                                        </h4>
                                        <input type="file" class="dropify" />
                                        {{ Form::file('image') }}
        </div>
    </div> --}}
</div>
</div>
</div>
<div class="modal-footer">
    <button type="submit" class="btn btn-success" id="" value="">ยืนยัน</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
</div>
</div>
</div>
</div>
{{ Form::close() }}

{{-- EDITข้อมูล --}}
{{ Form::open(['method' => 'post' , 'url' => 'setting_shop/edit', 'files' => true]) }}
<div class="modal fade" id="EDIT" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="edit_body">

        </div>
    </div>
</div>
{{ Form::close() }}

{{-- DELETEข้อมูล --}}
{{ Form::open(['method' => 'post' , 'url' => 'setting_shop/delete', 'files' => true]) }}
<div class="modal fade" id="DELETE" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="delete_body">

        </div>
    </div>
</div>
{{ Form::close() }}

@endsection

@section('script')
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="{{ asset('https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js') }}"></script>

<!-- DataTable -->
<script>
    var table = $('#table_shop').DataTable({
        // lengthMenu: [[20, 50, 100, -1], [20, 50, 100, "All"]],
        "scrollX": false,
        orderCellsTop: true,
        fixedHeader: true,
        // processing: true,
        // serverSide: true,
        ajax: "{{ url('/setting/show_shop') }}",
        columns: [
            { data: 'id', name: 'id' },
            { data: 'shop_code', name: 'shop_code' },
            { data: 'shop_name', name: 'shop_name' },
            { data: 'shop_description', name: 'shop_description' },
            { data: 'status', name: 'status' },

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
                "className": "text-center",
            },
            {
                "targets": 3,
                "className": "text-center",
            },
            {
                "targets": 4, render(data, type, row) {
                    if (data == "A") {
                        return '<label class="text-success">ใช้งาน</label>';
                    } else {
                        return '<label class="text-danger">ยกเลิกใช้งาน</label>';
                    }
                },
                "className": "text-center",
            },
            {
                "targets": 5, render(data, type, row) {

                    var id = "'" + row['id'] + "'";
                    var shop_code = "'" + row['shop_code'] + "'";
                    var shop_name = "'" + row['shop_name'] + "'";
                    var shop_description = "'" + row['shop_description'] + "'";
                    var status = "'" + row['status'] + "'";

                    return '<button style="padding: 7px;" type="button" class="btn btn-warning"  data-toggle="modal" data-target="#EDIT" \
                        onclick="edit_user('+ id + ',' + shop_code + ',' + shop_name + ',' + shop_description + ',' + status + ')" \
                            href="{{ url("shop/scale/1") }}"><i class="mdi mdi-pencil"></i></button>\
                            \
                            <button style="padding: 7px;" type="button" class="btn btn-danger"  data-toggle="modal" data-target="#DELETE" \
                        onclick="delete_user('+ id + ',' + shop_code + ',' + shop_name + ')" \
                            href="{{ url("shop/scale/1") }}"><i class="mdi mdi-delete"></i></button>\
                            ';

                },
                "className": "text-center",
            },
        ],
        "order": [],
    });

    table.on('order.dt search.dt', function () {
        table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();

</script>

<!-- Edit form-->
<script>
    function edit_user(id, shop_code, shop_name, shop_description, status) {
        $('#edit_body').html('<div class="modal-header" style="padding: 10px;">\
                          <label class="modal-title" id="myModalLabel"><b>\
                              แก้ไขข้อมูลร้านค้า</b></label>\
                                  </div>\
                                  <div class="modal-body" style="padding: 10px;" >\
                                  <div class="panel-body">\
                                  <div class="form-body">\
                                      <br>\
                                      <div class="row">\
                                          <div class="col-md-6">\
                                              <div class="form-group has-error">\
                                                  <label class="control-label">\
                                                      รหัสร้านค้า\
                                                  </label>\
                                                  <div class="input-group">\
                                                      <div class="input-group-addon"><i class="ti-user"></i></div>\
                                                      <input class="form-control" placeholder="รหัสร้านค้า" required id="shop_code" name="shop_code" type="text" value="'+ shop_code + '">\
                                                  </div>\
                                              </div>\
                                          </div>\
                                          <div class="col-md-6">\
                                              <div class="form-group">\
                                                  <label class="control-label">\
                                                      ชื่อร้านค้า\
                                                  </label>\
                                                  <div class="input-group">\
                                                      <div class="input-group-addon"><i class="ti-mobile"></i></div>\
                                                      <input class="form-control" placeholder="ชื่อ-สกุล" id="shop_name" name="shop_name" type="text" value="'+ shop_name + '" required>\
                                                  </div>\
                                              </div>\
                                          </div>\
                                      </div>\
                                        <div class="row">\
                                          <div class="col-md-12">\
                                              <div class="form-group">\
                                                  <label class="control-label">\
                                                      เบอร์โทร\
                                                  </label>\
                                                  <div class="input-group">\
                                                      <div class="input-group-addon"><i class="ti-mobile"></i></div>\
                                                      <textarea class="form-control" placeholder="รายละเอียดร้านค้า" id="shop_description" name="shop_description" type="text" required rows="3">'+ shop_description + '</textarea>\
                                                  </div>\
                                              </div>\
                                          </div>\
                                        </div>\
                                        <div class="row">\
                                          <div class="col-md-6">\
                                              <div class="form-group has-error">\
                                                  <label class="control-label">\
                                                      สถานะร้านค้า\
                                                  </label>\
                                                  <div class="input-group">\
                                                      <span class="input-group-addon">\
                                                          <i class="ti-layout-grid2-alt"></i>\
                                                      </span>\
                                                      <select class="form-control" id="status" name="status" required data-error="กรุณาเลือกสถานะร้านค้า">\
                                                        <option disabled selected> เลือกสถานะร้านค้า </option>\
                                                        <option value="A">ใช้งาน</option>\
                                                        <option value="D">ยกเลิกใช้งาน</option>\
                                                      </select>\
                                                  </div>\
                                              </div>\
                                          </div>\
                                      </div>\
                                  </div>\
                              </div>\
                          </div>\
                      <div class="modal-footer">\
                          <button type="submit" class="btn btn-success" id="" name="id" value="'+ id + '" >ยืนยัน</button>\
                          <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>\
                      </div>');
    }
</script>

<!-- Delete form -->
<script>
    function delete_user(id, shop_code, shop_name) {
        $('#delete_body').html('<div class="modal-header" style="padding: 10px;">\
                          <label class="modal-title" id="deleteModalLabel"><b>\
                              ลบข้อมูลร้านค้า</b></label>\
                                  </div>\
                                  <div class="modal-body" style="padding: 10px;" >\
                                  <div class="panel-body">\
                                  <div class="form-body">\
                                      <br>\
                                      <div class="row">\
                                          <div class="col-md-12">\
                                              <div class="form-group has-error">\
                                                  <label class="control-label">\
                                                      <h4>คุณต้องการลบร้านค้านี้หรือไม่ ?</h4>\
                                                  </label>\
                                              </div>\
                                          </div>\
                                    </div>\
                                    <div class="row">\
                                          <div class="col-md-6">\
                                              <div class="form-group has-error">\
                                                  <label class="control-label">\
                                                      รหัสร้านค้า : "'+ shop_code + '"\
                                                  </label>\
                                              </div>\
                                          </div>\
                                          <div class="col-md-6">\
                                              <div class="form-group">\
                                                  <label class="control-label">\
                                                      ชื่อร้านค้า : "'+ shop_name + '"\
                                                  </label>\
                                              </div>\
                                          </div>\
                                      </div>\
                      <div class="modal-footer">\
                          <button type="submit" class="btn btn-danger" id="" name="id" value="'+ id + '" >ยืนยัน</button>\
                          <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>\
                      </div>');
    }
</script>

@endsection