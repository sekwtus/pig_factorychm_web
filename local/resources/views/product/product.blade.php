@extends('layouts.master')
@section('style')
<style>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css/">
</style>
@endsection
@section('main')
              <div class="col-lg-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h4>แผนผลิตโรงงานเชือดชำแหละ</h4>
                      <div class="row">
                        <div class="col-12 text-right">
                        &nbsp;&nbsp;&nbsp;&nbsp;
                            <a class="btn btn-success btn-fw" href="{{url('/product_add_main')}}">เพิ่มแผนการผลิต
                            <i class="mdi mdi-plus"></i></a>
                        </div>
                      </div><br>

                        <div class="table-responsive">
                                <table class="table table-striped" width="100%" id="example">
                                  <thead class="text-center">
                                    <tr>
                                      <th>เลขที่</th>
                                      <th>เวลาเข้า</th>

                                      <!-- <th width="10%"> ลำดับ </th>
                                      <th width="10%"> เวลาเข้า </th>
                                      <th width="30%"> ลูกค้า/Group </th>
                                      <th width="5%"> จำนวนตัว </th>
                                      <th width="15%"> ประเภทการผ่าซาก </th>
                                      <th width="15%"> หมายเหตุ </th> -->

                                      <th style="text-align:center;"> เอกสาร </th>
                                      <th style="text-align:center;"> ดำเนินการ </th>
                                    </tr>
                                  </thead>
                                  <tbody class="text-center">
                                    @foreach($product as $out_product)
                                    <tr>
                                      <td>{{ $out_product->product_no }}</td>
                                      <td> {{ $out_product->date }} </td>

                                      <td> <a class="btn btn-success btn-fw" href="{{url('/product/report')}}">เอกสาร</a></td>

                                      <td>
                                          <a class="btn btn-info" href="{{url('/product_view_order/'.$out_product->product_no)}}"><i class="mdi mdi-eye"></i>เรียกดู</a>
                                          <a class="btn btn-warning" href="{{url('/product/edit/'.$out_product->product_no)}}"><i class="mdi mdi-wrench"></i>แก้ไข</a>
                                          <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#DELETE{{ $out_product->product_no }}" >
                                          <i class="mdi mdi-delete"></i>ลบ</button></td>
                                    </tr>
                                    @endforeach
                                  </tbody>
                                </table>
                        </div>
                      </div>
                   </div>
                </div>

                {{-- ลบข้อมูล --}}
                @foreach($product as $out_product)
                {{ Form::open(['method' => 'post' , 'url' => '/product/delete/'.$out_product->product_no]) }}
                           <div class="modal fade" id="DELETE{{ $out_product->product_no }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                                  <h4 class="modal-title" id="myModalLabel">ลบใบสั่งแผนการผลิต</h4>
                                          </div>
                                          <div class="modal-body">
                                                  <h5 >ยืนยันการลบ ใบสั่งแผนเลขที่ {{ $out_product->product_no }}</h5>
                                          </div>
                                          <div class="modal-footer">
                                              <button type="submit" class="btn btn-danger" id="delete" name="delete" value="delete">ลบ</button>
                                              <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
                                          </div>
                                      </div>
                                  </div>
                           </div>
                {{ Form::close() }}
                @endforeach
@endsection

@section('script')
<script>
    (function ($) {
    'use strict';
    $(function () {
        $('#example').DataTable({
        "aLengthMenu": [
            [5, 10, 15, -1],
            [5, 10, 15, "All"]
        ],
        "iDisplayLength": 10,
        "language": {
            search: ""
        }
        });
        $('#example').each(function () {
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
<script>https://code.jquery.com/jquery-3.3.1.js</script>
<script>https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js</script>

@endsection


