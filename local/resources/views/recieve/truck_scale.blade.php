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
                        <div class="col-4"><h4>ชั่งน้ำหนักรถ</h4></div>
                         <div class="col-8 text-right">
                            <a class="btn btn-success btn-fw" data-toggle="modal" data-target="#ADD" >
                                <i class="mdi mdi-plus"></i>เพิ่มรายการรับสุกร-รถบรรทุก
                           </a>
                        </div>
                      </div>
                        <div class="table-responsive">
                                <table class="table table-striped table-bordered nowrap" width="100%" id="recieveTable">
                                  <thead class="text-center">
                                    <tr>
                                      <th style="padding: 0px;">เลขที่</th>
                                      <th style="padding: 0px;">ลูกค้า</th>
                                      <th style="padding: 0px;">เวลาเข้า</th>
                                      <th style="padding: 0px;">รอบที่</th>
                                      <th style="padding: 0px;">จำนวนสุกร</th>
                                      <th style="padding: 0px;">น้ำหนักรถ + สุกร</th>
                                      <th style="padding: 0px;">น้ำหนักรถ</th>
                                      <th style="padding: 0px;">น้ำหนักสุกร</th>
                                      <th style="text-align:center; padding: 0px;"> ดำเนินการ </th>
                                    </tr>
                                  </thead>
                                </table>
                        </div>
                      </div>
                   </div>
                </div>

                {{-- ลบข้อมูล --}}
                {{ Form::open(['method' => 'post' , 'url' => '/product/delete/']) }}
                           <div class="modal fade" id="DELETE" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                                  <h4 class="modal-title" id="myModalLabel">ลบรายการรับสุกร-รถบรรทุก</h4>
                                          </div>
                                          <div class="modal-body">
                                                  <h5 >ยืนยันการลบ รายการรับสุกร-รถบรรทุก</h5>
                                          </div>
                                          <div class="modal-footer">
                                              <button type="submit" class="btn btn-danger" id="delete" name="delete" value="delete">ลบ</button>
                                              <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
                                          </div>
                                      </div>
                                  </div>
                           </div>
                {{ Form::close() }}

    {{-- ADDข้อมูล --}}
    <div class="modal fade" id="ADD" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="padding: 10px;">
                    <label class="modal-title" id="myModalLabel"><b>
                        เพิ่มรายการรับสุกร-รถบรรทุก</b></label>
                </div>
                <div class="modal-body" style="padding: 10px;">
                      <div class="form-group">
                        <label for="orderNo">เลขที่ใบ Order</label>
                        <input type="text" class="form-control" id="orderNo" placeholder="เลขที่ใบ Order"> </div>


                        <div class="form-group row">
                            <label for="customer" class="col-sm-2 col-form-label">ลูกค้า</label>
                            <div class="col-sm-10">
                              <select class="form-control" id="customer">
                                <option value="">เลือกลูกค้า</option>
                                <option value="1">สมชายขายหมู</option>
                                <option value="2">สมหญิงค้าหมู</option>
                              </select>
                            </div>
                          </div>

                      <div class="form-group">
                        <label for="recieve_time">เวลาเข้า</label>
                        <input type="email" class="form-control" id="recieve_time" placeholder="{{ now() }}" value="{{ now() }}" readonly></div>
                      <div class="form-group">
                        <label for="round">รอบที่</label>
                        <input type="number" class="form-control" id="round" placeholder="รอบที่"> </div>
                      <div class="form-group">
                        <label for="pig_number">จำนวนสุกร</label>
                        <input type="number" class="form-control" id="pig_number" placeholder="จำนวนสุกร"> </div>

                      <div class="form-group">
                        <label for="note">หมายเหตุ</label>
                        <textarea class="form-control" id="note" placeholder="หมายเหตุ" rows="2"></textarea>
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
        var orderNo = $('#orderNo').val();
        var customer = $('#customer').val();
        var orderDate = $('#recieve_time').val();
        var orderTerm = $('#round').val();
        var pig_number = $('#pig_number').val();
        var note = $('#note').val();

        $.ajax({
            type: 'GET',
            url: '{{ url('/add_order') }}',
            data: {orderNo:orderNo,customer:customer,orderDate:orderDate,
                    orderTerm:orderTerm,pig_number:pig_number,note:note},
            success: function (msg) {
                // alert(msg);
                location.reload();
            }
        });
        $('#close').click();

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
                ajax: '{{ url('/data_recieve') }}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'customer_id', name: 'customer_id' },
                    { data: 'recieve_time', name: 'recieve_time' },
                    { data: 'round', name: 'round' },
                    { data: 'pig_number', name: 'pig_number' },
                    { data: 'product_name', name: 'product_name' },
                    { data: 'truck_pig_scale', name: 'truck_pig_scale' },
                ],
                columnDefs: [
                {
                    "targets": 0,
                },
                {
                    "targets": 1,render(data,type,row){
                        // var date = new Date(row['StartDate']).toJSON().slice(0,10);
                        // var dateMin = date.substring(8,10) +'/'+ date.substring(5,7) +'/'+ date.substring(0,4);
                        return 'สมชาย';
                    }
                },
                {
                    "targets": 2,
                },
                {
                    "targets": 3,
                },
                {
                    "targets": 4,
                    // "className": "text-center",
                },
                {
                    "targets": 5,render(data,type,row){
                        return 'กิโลกรัม';
                    }
                },
                {
                    "targets": 6,render(data,type,row){
                        return 'กิโลกรัม';
                    }
                },
                {
                    "targets": 7,render(data,type,row){
                        return 'กิโลกรัม';
                    }
                },
                {
                    "targets": 8,render(){
                        return '<button disabled style="padding: 7px;" type="button" class="btn btn-success" href="#">\
                                    <i class="mdi mdi-printer"></i></button>\
                                <button disabled style="padding: 7px;" type="button" class="btn btn-warning" href="{{ url("shop/scale/1") }}">\
                                    <i class="mdi mdi-pencil"></i></button>\
                                <button  style="padding: 7px;" type="button" class="btn btn-danger" data-toggle="modal" data-target="#DELETE" >\
                                    <i class="mdi mdi-delete"></i></button></td>';
                    }
                },
                ],
                "order": [],
            });
    </script>

@endsection


