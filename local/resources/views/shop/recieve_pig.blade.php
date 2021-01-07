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
@endsection
@section('main')
              <div class="col-lg-12 grid-margin">
                <div class="card">
                  <div class="card-body">

                      <div class="row">
                        <div class="col-4"><h4>รับชิ้นส่วนสุกร</h4></div>
                        <div class="col-8 text-right">
                            <a class="btn btn-success btn-fw" data-toggle="modal" data-target="#ADD" >เพิ่มใบรับสินค้า
                            <i class="mdi mdi-plus"></i></a>
                        </div>
                      </div>
                        <div class="table-responsive">
                                <table class="table table-striped table-bordered nowrap" width="100%" id="shopTable">
                                  <thead class="text-center">
                                    <tr>
                                      <th style="padding: 0px;">เลขที่</th>
                                      <th style="padding: 0px;">เวลาเข้า</th>
                                      <th style="padding: 0px;">รอบที่</th>
                                      <th style="padding: 0px;">น้ำหนักรวม</th>
                                      <th style="padding: 0px;">สถานะ</th>
                                      <th style="text-align:center; padding: 0px;"> ดำเนินการ </th>
                                    </tr>
                                  </thead>
                                  <tbody class="text-center">

                                    <tr>
                                      <td style="padding: 0px;">1</td>
                                      <td style="padding: 0px;">8/6/2019</td>
                                      <td style="padding: 0px;">1</td>
                                      <td style="padding: 0px;">10</td>
                                      <td style="padding: 0px;"><span class="badge badge-success">success</span></td>
                                      <td style="padding: 0px;">
                                          <a style="padding: 7px;" class="btn btn-warning" href="{{ url('shop/scale/1') }}"><i class="mdi mdi-pencil"></i></a>
                                          <button style="padding: 7px;" type="button" class="btn btn-danger" data-toggle="modal" data-target="#DELETE" >
                                          <i class="mdi mdi-delete"></i></button></td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 0px;">2</td>
                                        <td style="padding: 0px;">8/6/2019</td>
                                        <td style="padding: 0px;">2</td>
                                        <td style="padding: 0px;">12</td>
                                        <td style="padding: 0px;"><span class="badge badge-primary">processing</span></td>
                                        <td style="padding: 0px;">
                                            <a style="padding: 7px;" class="btn btn-warning" href="#"><i class="mdi mdi-pencil"></i></a>
                                            <button style="padding: 7px;" type="button" class="btn btn-danger" data-toggle="modal" data-target="#DELETE" >
                                            <i class="mdi mdi-delete"></i></button></td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 0px;">3</td>
                                        <td style="padding: 0px;">9/6/2019</td>
                                        <td style="padding: 0px;">1</td>
                                        <td style="padding: 0px;">51</td>
                                        <td style="padding: 0px;"><span class="badge badge-secondary">wait</span></td>
                                        <td style="padding: 0px;">
                                            <a style="padding: 7px;" class="btn btn-warning" href="#"><i class="mdi mdi-pencil"></i></a>
                                            <button style="padding: 7px;" type="button" class="btn btn-danger" data-toggle="modal" data-target="#DELETE" >
                                            <i class="mdi mdi-delete"></i></button></td>
                                    </tr>

                                  </tbody>
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
                                                  <h4 class="modal-title" id="myModalLabel">ลบใบสั่งแผนการผลิต</h4>
                                          </div>
                                          <div class="modal-body">
                                                  <h5 >ยืนยันการลบ ใบสั่งแผนเลขที่product_no</h5>
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
                    <label class="modal-title" id="myModalLabel"><b>เพิ่มใบรับสินค้า</b></label>
                </div>
                <div class="modal-body" style="padding: 10px;">
                <div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label >เลขที่ใบรับสินค้า : </label>
                        </div>
                        <div class="col-sm-3">
                            <input class="form-control" id="orderNo" type="text" required>
                        </div>

                        <div class="col-sm-3">
                            <label >ประจำวันที่ : </label>
                        </div>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="orderDate">
                        </div>
                    </div>

                    <label >รอบที่</label><input type="text" class="form-control" id="orderTerm">
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
<script>
    (function ($) {
    'use strict';
    $(function () {
        $('#shopTable').DataTable({
        "aLengthMenu": [
            [5, 10, 15, -1],
            [5, 10, 15, "All"]
        ],
        "iDisplayLength": 10,
        "language": {
            search: ""
        }
        });
        $('#shopTable').each(function () {
        var datatable = $(this);
        // SEARCH - Add the placeholder for Search and Turn this into in-line form control
        var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
        search_input.attr('placeholder', 'Search');
        search_input.removeClass('form-control-sm');
        // LENGTH - Inline-Form control
        var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
        length_sel.removeClass('form-control-sm');
        });
    });
    })(jQuery);
</script>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="{{ asset('https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js') }}"></script>
{{--  <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"></script>  --}}

{{--  <script>
    function modalRecievePig() {
        $("#DELETE2").modal().("show");
    }
</script>  --}}

<script>
    $("#comfirmAdd").on('click', function() {
        var orderNo = $('#orderNo').val();
        var orderDate = $('#orderDate').val();
        var orderTerm = $('#orderTerm').val();

        $.ajax({
            type: 'GET',
            url: '{{ url('add_order') }}',
            data: {orderNo:orderNo,orderDate:orderDate,orderTerm:orderTerm},
            success: function (msg) {
                alert(msg);
                location.reload();
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert("Status: " + textStatus); alert("Error: " + errorThrown);
            }
        });
    });
</script>
@endsection


