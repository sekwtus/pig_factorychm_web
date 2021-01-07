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
              <div class="col-lg-12 grid-margin">
                <div class="card">
                  <div class="card-body">

                      <div class="row">
                        <div class="col-4"><h4>ตั้งค่าข้อมูลประเภทธุรกิจของลูกค้า</h4></div>
                         <div class="col-8 text-right">
                            <a class="btn btn-success btn-fw" data-toggle="modal" data-target="#ADD" >
                                <i class="mdi mdi-plus"></i>เพิ่มรายการประเภทธุรกิจ
                           </a>
                        </div>
                      </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered nowrap" width="100%" id="recieveTable">
                                <thead class="text-center">
                                <tr>
                                    <th style="padding: 0px;">เลขที่</th>
                                    <th style="padding: 0px;">หมวดหมู่</th>
                                    <th style="padding: 0px;">ประเภทธุรกิจ</th>
                                    <th style="text-align:center; padding: 0px;"> ดำเนินการ </th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                      </div>
                   </div>
                </div>

    {{-- ADDข้อมูล --}}
    <div class="modal fade" id="ADD" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="padding: 10px;">
                    <label class="modal-title" id="myModalLabel"><b>
                        เพิ่มรายการประเภทธุรกิจ</b></label>
                </div>
                <div class="modal-body" style="padding: 10px;">

                        <div class="form-group row">
                            <label for="customer" class="col-sm-6 col-form-label">เลือกหมวดหมู่</label>
                            <label class="col-sm-6 col-form-label" for="orderNo">หรือ เพิ่มหมวดหมู่ใหม่</label>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                              <select class="form-control" id="type" name="type" >
                                    <option value="">เลือกหมวดหมู่</option>
                                  @foreach ($type_of_business as $type)
                                    <option value="{{ $type->type }}">{{ $type->type }}</option>
                                  @endforeach
                              </select>
                            </div>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="new_type" name="new_type" placeholder="หมวดหมู่ใหม่">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="business">ประเภทธุรกิจ</label>
                            <input type="text" class="form-control" id="business" >
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="comfirmAdd" value="comfirmAdd" >ยืนยัน</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
                </div>
            </div>
        </div>
    </div>

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
            var table = $('#recieveTable').DataTable({
                // lengthMenu: [[20, 50, 100, -1], [20, 50, 100, "All"]],
                "scrollX": false,
                orderCellsTop: true,
                fixedHeader: true,
                // processing: true,
                // serverSide: true,
                ajax: '{{ url('/setting/customer_business/get_ajax') }}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'type', name: 'type' },
                    { data: 'business', name: 'business' },
                ],
                columnDefs: [
                {
                    "targets": 0,
                },
                {
                    "targets": 1,
                },
                {
                    "targets": 2,
                },
                {
                    "targets": 3,render(){
                        return '<button disabled style="padding: 7px;" type="button" class="btn btn-warning" href="{{ url("shop/scale/1") }}">\
                                    <i class="mdi mdi-pencil"></i></button>\
                                <button disabled style="padding: 7px;" type="button" class="btn btn-danger" data-toggle="modal" data-target="#DELETE" >\
                                    <i class="mdi mdi-delete"></i></button></td>';
                    }
                },
                ],
                "order": [],
            });
    </script>

@endsection


