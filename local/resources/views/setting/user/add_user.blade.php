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
                        <div class="col-4"><h4>ผู้ใช้งานระบบ</h4></div>
                         <div class="col-8 text-right">
                            <a class="btn btn-success btn-fw" data-toggle="modal" data-target="#ADDUSER" >
                                <i class="mdi mdi-plus"></i>เพิ่มผู้ใช้งาน
                           </a>
                        </div>
                      </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered nowrap" width="100%" id="table_user">
                                <thead class="text-center">
                                <tr>
                                    <th style="padding: 0px;">ลำดับ</th>
                                    <th style="padding: 0px;">username</th>
                                    <th style="padding: 0px;">ชื่อ</th>
                                    <th style="padding: 0px;">เบอร์โทร</th>
                                    <th style="padding: 0px;">ประเภทผู้ใช้</th>
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
    {{ Form::open(['method' => 'post' , 'url' => 'setting_user/save', 'files' => true]) }}
        <div class="modal fade" id="ADDUSER" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="padding: 10px;">
                        <label class="modal-title" id="myModalLabel"><b>
                            เพิ่มผู้ใช้งาน</b></label>
                    </div>
                    <div class="modal-body" style="padding: 10px;">
                            <div class="panel-body">                        
                                <div class="form-body">
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group has-error">
                                                <label class="control-label">
                                                    ชื่อผู้ใช้
                                                </label>
                                                <div class="input-group">
                                                    <div class="input-group-addon"><i class="ti-user"></i></div>
                                                    <input class="form-control" placeholder="username" id="name" required name="name" type="text">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group has-error">
                                                <label class="control-label">รหัสผ่าน</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon"><i class="ti-home"></i></div>
                                                    <input class="form-control" placeholder="รหัสผ่าน" required name="password"  type="password" autocomplete="false" readonly onfocus="this.removeAttribute('readonly');" >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    ชื่อ-สกุล
                                                </label>
                                                <div class="input-group">
                                                    <div class="input-group-addon"><i class="ti-mobile"></i></div>
                                                    <input class="form-control" placeholder="ชื่อ-สกุล" id="fname" name="fname" type="text" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    เบอร์โทร
                                                </label>
                                                <div class="input-group">
                                                    <div class="input-group-addon"><i class="ti-mobile"></i></div>
                                                    <input class="form-control" placeholder="เบอร์โทร" id="tel" name="tel" type="text" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group has-error">
                                                <label class="control-label">
                                                    ประเภทผู้ใช้
                                                </label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="ti-layout-grid2-alt"></i>
                                                    </span>
                                                    <select class="form-control" id="user_type_id" name="user_type_id" required data-error="กรุณาเลือกประเภทผู้ใช้">
                                                            <option value="" selected>เลือกประเภทผู้ใช้</option>
                                                        @foreach ($type_users as $type_)
                                                            <option value="{{ $type_->id }}">{{ $type_->description }}</option>
                                                        @endforeach
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
                                                            <option value="{{ $branch_->id }}">{{ $branch_->branch_name }}</option>
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
                        <button type="submit" class="btn btn-success" id="" value="" >ยืนยัน</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
                    </div>
                </div>
            </div>
        </div>
    {{ Form::close() }}

    {{--แก้ไขข้อมูล --}}
    {{ Form::open(['method' => 'post' , 'url' => 'setting_user/edit', 'files' => true]) }}
        <div class="modal fade" id="EDIT" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" id="edit_body">
                    
                </div>
            </div>
        </div>
    {{ Form::close() }}


@endsection

@section('script')
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="{{ asset('https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js') }}"></script>


    <script >
        $("#comfirmAdd").on('click', function() {
            $('#comfirmAdd').prop('disabled', true);
            var type = $('#type').val();
            var new_type = $('#new_type').val();
            var business = $('#business').val();

            $.ajax({
                type: 'GET',
                url: '{{ url('/setting/customer_business/save') }}',
                data: {type:type,new_type:new_type,business:business},
                success: function (msg) {
                    // alert(msg);
                    location.reload();
                }
            });
            $('#close').click();
        });
    </script>

    <script>
        $("#type").change(function () {
            if ($("#type").val() == '') {
                $("#new_type").prop('disabled', false);
            }else{
                $("#new_type").prop('disabled', true);
            }
        });
        $("#new_type").keyup(function () {
            if ($("#new_type").val() == '') {
                $("#type").prop('disabled', false);
            }else{
                $("#type").prop('disabled', true);
            }
        });
    </script>

<script>
    var table = $('#table_user').DataTable({
        // lengthMenu: [[20, 50, 100, -1], [20, 50, 100, "All"]],
        "scrollX": false,
        orderCellsTop: true,
        fixedHeader: true,
        // processing: true,
        // serverSide: true,
        ajax: '{{ url('/setting/show_users') }}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'fname', name: 'fname' },
            { data: 'phone_number', name: 'phone_number' },
            { data: 'description', name: 'description' },
            { data: 'active', name: 'active' },
            { data: 'id', name: 'id' },
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
            "targets": 5,render(data,type,row){
                if (data == 1) {
                    return '<label class="text-success">ใช้งาน</label>';
                }else{
                    return '<label class="text-danger">ยกเลิกใช้งาน</label>';
                }
            },
            "className": "text-center",
        },
        {
            "targets": 6,render(data,type,row){
                
                var id = "'"+row['id']+"'";
                var name = "'"+row['name']+"'";
                var fname = "'"+row['fname']+"'";
                var phone_number = "'"+row['phone_number']+"'";
                var id_type = "'"+row['id_type']+"'";
                var description = "'"+row['description']+"'";
                
                return '<button style="padding: 7px;" type="button" class="btn btn-warning"  data-toggle="modal" data-target="#EDIT" \
                        onclick="edit_user('+id+','+name+','+fname+','+phone_number+','+id_type+','+description+')" \
                            href="{{ url("shop/scale/1") }}"><i class="mdi mdi-pencil"></i></button>\
                        <button disabled style="padding: 7px;" type="button" class="btn btn-danger" data-toggle="modal" data-target="#DELETE" >\
                            <i class="mdi mdi-delete"></i></button></td>';
            },
            "className": "text-center",
        },
        ],
        "order": [],
    });
    
    table.on( 'order.dt search.dt', function () {
      table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
          cell.innerHTML = i+1;
      } );
    } ).draw();
  
  </script>

  <script>
  function edit_user(id,name,fname,phone_number,id_type,description){
        $('#edit_body').html('<div class="modal-header" style="padding: 10px;">\
                        <label class="modal-title" id="myModalLabel"><b>\
                            แก้ไขข้อมูลผู้ใช้งาน</b></label>\
                                </div>\
                                <div class="modal-body" style="padding: 10px;" >\
                                <div class="panel-body">\
                                <div class="form-body">\
                                    <br>\
                                    <div class="row">\
                                        <div class="col-md-6">\
                                            <div class="form-group has-error">\
                                                <label class="control-label">\
                                                    ชื่อผู้ใช้\
                                                </label>\
                                                <div class="input-group">\
                                                    <div class="input-group-addon"><i class="ti-user"></i></div>\
                                                    <input class="form-control" placeholder="username" id="name" required name="name" type="text" value="'+name+'">\
                                                </div>\
                                            </div>\
                                        </div>\
                                        <div class="col-md-6">\
                                            <div class="form-group">\
                                                <label class="control-label">\
                                                    ชื่อ-สกุล\
                                                </label>\
                                                <div class="input-group">\
                                                    <div class="input-group-addon"><i class="ti-mobile"></i></div>\
                                                    <input class="form-control" placeholder="ชื่อ-สกุล" id="fname" name="fname" type="text" value="'+fname+'" required>\
                                                </div>\
                                            </div>\
                                        </div>\
                                    </div>\
                                    <div class="row">\
                                        <div class="col-md-6">\
                                            <div class="form-group">\
                                                <label class="control-label">\
                                                    เบอร์โทร\
                                                </label>\
                                                <div class="input-group">\
                                                    <div class="input-group-addon"><i class="ti-mobile"></i></div>\
                                                    <input class="form-control" placeholder="เบอร์โทร" id="tel" name="tel" type="text" value="'+(phone_number == 'null' || phone_number == null || phone_number == '' ? '' : phone_number)+'" required>\
                                                </div>\
                                            </div>\
                                        </div>\
                                        <div class="col-md-6">\
                                            <div class="form-group has-error">\
                                                <label class="control-label">\
                                                    ประเภทผู้ใช้\
                                                </label>\
                                                <div class="input-group">\
                                                    <span class="input-group-addon">\
                                                        <i class="ti-layout-grid2-alt"></i>\
                                                    </span>\
                                                    <select class="form-control" id="user_type_id" name="user_type_id" required data-error="กรุณาเลือกประเภทผู้ใช้">\
                                                            <option value="'+id_type+'" selected>'+description+'</option>\
                                                        @foreach ($type_users as $type_)\
                                                            <option value="{{ $type_->id }}">{{ $type_->description }}</option>\
                                                        @endforeach\
                                                    </select>\
                                                </div>\
                                            </div>\
                                        </div>\
                                    </div>\
                                </div>\
                            </div>\
                        </div>\
                    <div class="modal-footer">\
                        <button type="submit" class="btn btn-success" id="" name="id" value="'+id+'" >ยืนยัน</button>\
                        <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>\
                    </div>');
  }
  </script>
@endsection


