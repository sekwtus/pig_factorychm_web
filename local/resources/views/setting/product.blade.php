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
                    <h4>สินค้า</h4>
                </div>
                <div class="col-8 text-right">
                    <a class="btn btn-success btn-fw" data-toggle="modal" data-target="#ADDPRODUCT">
                        <i class="mdi mdi-plus"></i>เพิ่มร้านค้า
                    </a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-bordered nowrap" width="100%" id="table_product">
                    <thead class="text-center">
                        <tr>
                            <th style="padding: 0px;">ลำดับ</th>
                            <th style="padding: 0px;">รหัสสินค้า</th>
                            <th style="padding: 0px;">ชื่อสินค้า</th>
                            <th style="padding: 0px;">ประเภท</th>
                            <th style="padding: 0px;">ราคา</th>
                            <th style="padding: 0px;">จำนวน(หน่วย)</th>
                            <th style="padding: 0px;">รูปภาพ</th>
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
{{ Form::open(['method' => 'post' , 'url' => 'setting_product/save', 'files' => true]) }}
<div class="modal fade" id="ADDPRODUCT" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 60%;">
        <div class="modal-content">
            <div class="modal-header" style="padding: 10px;">
                <label class="modal-title" id="myModalLabel"><b>
                        เพิ่มสินค้า</b></label>
            </div>
            <div class="modal-body" style="padding: 10px;">
                <div class="panel-body">
                    <div class="form-body">
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group has-error">
                                    <label class="control-label">
                                        รหัสสินค้า
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="ti-user"></i></div>
                                        <input class="form-control" placeholder="รหัสสินค้า" required id="product_code"
                                            name="product_code" type="number"
                                            onKeyPress="if(this.value.length==4) return false;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group has-error">
                                    <label class="control-label">ชื่อสินค้า</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="ti-home"></i></div>
                                        <input class="form-control" placeholder="ชื่อสินค้า" required id="product_name"
                                            name="product_name" type="text">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group has-error">
                                    <label class="control-label">
                                        ประเภท
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="ti-user"></i></div>
                                        <select class="form-control" id="product_type_id" name="product_type_id"
                                            required data-error="กรุณาเลือกประเภทสินค้า">
                                            <option disabled selected> เลือกประเภทสินค้า </option>

                                            @foreach ($product_type as $type_)
                                            <option value="{{ $type_->product_type_id }}">{{ $type_->product_type_name }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group has-error">
                                    <label class="control-label">cost</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="ti-home"></i></div>
                                        <input class="form-control" placeholder="cost" required id="cost" name="cost"
                                            type="number" min="0" max="999999">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group has-error">
                                    <label class="control-label">
                                        ราคา
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="ti-user"></i></div>
                                        <input class="form-control" placeholder="ราคา" required id="price" name="price"
                                            type="number" min="0" max="999999">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group has-error">
                                    <label class="control-label">recognize</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="ti-home"></i></div>
                                        <input class="form-control" placeholder="recognize" required id="recognize"
                                            name="recognize" type="number" min="0" max="999999">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group has-error">
                                    <label class="control-label">
                                        จำนวน(หน่วย)
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="ti-user"></i></div>
                                        <input class="form-control" placeholder="จำนวน(หน่วย)" required id="unit"
                                            name="unit" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group has-error">
                                    <label class="control-label">
                                        สถานะสินค้า
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-layout-grid2-alt"></i>
                                        </span>
                                        <select class="form-control" id="status" name="status" required
                                            data-error="กรุณาเลือกสถานะร้านค้า">
                                            <option disabled selected> เลือกสถานะสินค้า </option>

                                            <option value="A">ใช้งาน</option>
                                            <option value="D">ไม่ใช้งาน</option>

                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">
                                        รูปภาพ
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="ti-mobile"></i></div>
                                        <input class="form-control" id="picture" name="picture" type="file">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group has-error">
                                    <label class="control-label">หมายเหตุ</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="ti-home"></i></div>
                                        <textarea class="form-control" placeholder="หมายเหตุ" required id="note"
                                            name="note" type="text" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">

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
{{ Form::open(['method' => 'post' , 'url' => 'setting_product/edit', 'files' => true]) }}
<div class="modal fade" id="EDIT" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 60%;">
        <div class="modal-content" id="edit_body">

        </div>
    </div>
</div>
{{ Form::close() }}

{{-- DELETEข้อมูล --}}
{{ Form::open(['method' => 'post' , 'url' => 'setting_product/delete', 'files' => true]) }}
<div class="modal fade" id="DELETE" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 60%;">
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
    var table = $('#table_product').DataTable({
        // lengthMenu: [[20, 50, 100, -1], [20, 50, 100, "All"]],
        "scrollX": false,
        orderCellsTop: true,
        fixedHeader: true,
        // processing: true,
        // serverSide: true,
        ajax: "{{ url('/setting/show_product') }}",
        columns: [
            { data: 'id', name: 'id' },
            { data: 'product_code', name: 'product_code' },
            { data: 'product_name', name: 'product_name' },
            { data: 'product_type_name', name: 'product_type_name' },
            { data: 'price', name: 'price' },
            { data: 'unit', name: 'unit' },
            { data: 'picture', name: 'picture' },
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
                "targets": 4,
                "className": "text-center",
            },
            {
                "targets": 5,
                "className": "text-center",
            },
            {
                "targets": 6,
                "className": "text-center",
                "render": function (data, type, row) {
                    if (data) {
                        return '<img src="' + data + '" />';
                    } else {
                        return '<label class="text-primary">ไม่เจอรูปภาพ</label>';
                    }
                },
            },
            {
                "targets": 7, render(data, type, row) {
                    if (data == "A") {
                        return '<label class="text-success">ใช้งาน</label>';
                    } else {
                        return '<label class="text-danger">ยกเลิกใช้งาน</label>';
                    }
                },
                "className": "text-center",
            },
            {
                "targets": 8, render(data, type, row) {

                    var id = "'" + row['id'] + "'";
                    var product_code = "'" + row['product_code'] + "'";
                    var product_name = "'" + row['product_name'] + "'";
                    var product_type_id = "'" + row['product_name'] + "'";
                    var cost = "'" + row['cost'] + "'";
                    var price = "'" + row['price'] + "'";
                    var recognize = "'" + row['recognize'] + "'";
                    var unit = "'" + row['unit'] + "'";
                    var note = "'" + row['note'] + "'";
                    var picture = "'" + row['picture'] + "'";
                    var status = "'" + row['status'] + "'";

                    return '<button style="padding: 7px;" type="button" class="btn btn-warning"  data-toggle="modal" data-target="#EDIT" \
                        onclick="edit_product('+ id + ',' + product_code + ',' + product_name + ',' + product_type_id + ',' + cost + ',' + price + ',' + recognize + ',' + unit + ',' + note + ',' + picture + ',' + status + ')" \
                            href="{{ url("shop/scale/1") }}"><i class="mdi mdi-pencil"></i></button>\
                            \
                            <button style="padding: 7px;" type="button" class="btn btn-danger"  data-toggle="modal" data-target="#DELETE" \
                        onclick="delete_product('+ id + ',' + product_code + ',' + product_name + ')" \
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
    function edit_product(id, product_code, product_name, product_type_id, cost, price, recognize, unit, note, picture, status) {
        $('#edit_body').html('\
        <div class="modal-header" style="padding: 10px;">\
            <label class="modal-title" id="myModalLabel"><b>\
                แก้ไขข้อมูลสินค้าค้า</b></label>\
            </div>\
            <div class="modal-body" style="padding: 10px;">\
                <div class="panel-body">\
                    <div class="form-body">\
                        <br>\
                        <div class="row">\
                            <div class="col-md-6">\
                                <div class="form-group has-error">\
                                    <label class="control-label">\
                                        รหัสสินค้า\
                                    </label>\
                                    <div class="input-group">\
                                        <div class="input-group-addon"><i class="ti-user"></i></div>\
                                        <input class="form-control" placeholder="รหัสสินค้า" required id="product_code"\
                                            name="product_code" type="number"\
                                            onKeyPress="if(this.value.length==4) return false;" value="'+product_code+'">\
                                    </div>\
                                </div>\
                            </div>\
                            <div class="col-md-6">\
                                <div class="form-group has-error">\
                                    <label class="control-label">ชื่อสินค้า</label>\
                                    <div class="input-group">\
                                        <div class="input-group-addon"><i class="ti-home"></i></div>\
                                        <input class="form-control" placeholder="ชื่อสินค้า" required id="product_name"\
                                            name="product_name" type="text" value="'+product_name+'">\
                                    </div>\
                                </div>\
                            </div>\
                        </div>\
                        <div class="row">\
                            <div class="col-md-6">\
                                <div class="form-group has-error">\
                                    <label class="control-label">\
                                        ประเภท\
                                    </label>\
                                    <div class="input-group">\
                                        <div class="input-group-addon"><i class="ti-user"></i></div>\
                                        <select class="form-control" id="product_type_id" name="product_type_id"\
                                            required data-error="กรุณาเลือกประเภทสินค้า">\
                                            <option disabled selected> เลือกประเภทสินค้า </option>\
                                            @foreach ($product_type as $type_)\
                                            <option value="{{ $type_->product_type_id }}">{{ $type_->product_type_name }}</option>\
                                            @endforeach\
                                        </select>\
                                    </div>\
                                </div>\
                            </div>\
                            <div class="col-md-6">\
                                <div class="form-group has-error">\
                                    <label class="control-label">cost</label>\
                                    <div class="input-group">\
                                        <div class="input-group-addon"><i class="ti-home"></i></div>\
                                        <input class="form-control" placeholder="cost" required id="cost" name="cost"\
                                            type="number" min="0" max="999999" value="'+cost+'">\
                                    </div>\
                                </div>\
                            </div>\
                        </div>\
                        <div class="row">\
                            <div class="col-md-6">\
                                <div class="form-group has-error">\
                                    <label class="control-label">\
                                        ราคา\
                                    </label>\
                                    <div class="input-group">\
                                        <div class="input-group-addon"><i class="ti-user"></i></div>\
                                        <input class="form-control" placeholder="ราคา" required id="price" name="price"\
                                            type="number" min="0" max="999999" value="'+price+'">\
                                    </div>\
                                </div>\
                            </div>\
                            <div class="col-md-6">\
                                <div class="form-group has-error">\
                                    <label class="control-label">recognize</label>\
                                    <div class="input-group">\
                                        <div class="input-group-addon"><i class="ti-home"></i></div>\
                                        <input class="form-control" placeholder="recognize" required id="recognize"\
                                            name="recognize" type="number" min="0" max="999999" value="'+recognize+'">\
                                    </div>\
                                </div>\
                            </div>\
                        </div>\
                        <div class="row">\
                            <div class="col-md-6">\
                                <div class="form-group has-error">\
                                    <label class="control-label">\
                                        จำนวน(หน่วย)\
                                    </label>\
                                    <div class="input-group">\
                                        <div class="input-group-addon"><i class="ti-user"></i></div>\
                                        <input class="form-control" placeholder="จำนวน(หน่วย)" required id="unit"\
                                            name="unit" type="text" value="'+unit+'">\
                                    </div>\
                                </div>\
                            </div>\
                            <div class="col-md-6">\
                                <div class="form-group has-error">\
                                    <label class="control-label">\
                                        สถานะสินค้า\
                                    </label>\
                                    <div class="input-group">\
                                        <span class="input-group-addon">\
                                            <i class="ti-layout-grid2-alt"></i>\
                                        </span>\
                                        <select class="form-control" id="status" name="status" required\
                                            data-error="กรุณาเลือกสถานะร้านค้า">\
                                            <option disabled selected> เลือกสถานะสินค้า </option>\
                                            <option value="A">ใช้งาน</option>\
                                            <option value="D">ไม่ใช้งาน</option>\
                                        </select>\
                                    </div>\
                                </div>\
                            </div>\
                        </div>\
                        <div class="row">\
                            <div class="col-md-12">\
                                <div class="form-group">\
                                    <label class="control-label">\
                                        รูปภาพ\
                                    </label>\
                                    <div class="input-group">\
                                        <div class="input-group-addon"><i class="ti-mobile"></i></div>\
                                        <input class="form-control" id="picture" name="picture" type="file">\
                                    </div>\
                                </div>\
                            </div>\
                        </div>\
                        <div class="row">\
                            <div class="col-md-12">\
                                <div class="form-group has-error">\
                                    <label class="control-label">หมายเหตุ</label>\
                                    <div class="input-group">\
                                        <div class="input-group-addon"><i class="ti-home"></i></div>\
                                        <textarea class="form-control" placeholder="หมายเหตุ" required id="note"\
                                            name="note" type="text" rows="3">'+note+'</textarea>\
                                    </div>\
                                </div>\
                            </div>\
                        </div>\
                    </div>\
                </div>\
            </div>\
            <div class="modal-footer">\
                <button type="submit" class="btn btn-success" id="" name="id" value="'+id+ '" >ยืนยัน</button>\
                <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>\
            </div>');
    }
</script>

<!-- Delete form -->
<script>
    function delete_product(id, product_code, product_name) {
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
                                                      รหัสสินค้า : "'+ product_code + '"\
                                                  </label>\
                                              </div>\
                                          </div>\
                                          <div class="col-md-6">\
                                              <div class="form-group">\
                                                  <label class="control-label">\
                                                      ชื่อสินค้า : "'+ product_name + '"\
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