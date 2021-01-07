@extends('layouts.master')
@section('style')
<style> 
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css/">
</style>
@endsection
@section('main')  
                  <div class="col-12 grid-margin">
                    <div class="card">
                      <div class="card-body">
                        <h4>รายการที่ผลิต</h4>
                        <div class="table-responsive">
                                <table class="table table-striped" width="100%" id="example">
                                  <thead>
                                    <tr>
                                      <th>เวลาเข้า</th>
                                      <th>ชื่อลูกค้า/Group</th>
                                      <th>จำนวนตัว</th>
                                      <th>ประเภทการผ่าซาก</th>
                                      <th>หมายเหตุ</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    @foreach($product_list as $out_product_list)
                                    <tr> 
                                      <td>{{ $out_product_list->time_in }}</td>
                                      <td>{{ $out_product_list->customer_name }} </td>
                                      <td>{{ $out_product_list->amount }} </td>
                                      <td>{{ $out_product_list->product_type }}</td>
                                      <td>{{ $out_product_list->note }} </td>                                   
                                    </tr>  
                                    @endforeach
                                  </tbody>
                                </table>
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

@section('footer')
<!-- content-wrapper ends -->
<!-- partial:partials/_footer.html -->
  <div class="container clearfix">
    <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © 2018
      <a href="http://www.bootstrapdash.com/" target="_blank">Bootstrapdash</a>. All rights reserved.</span>
    <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with
      <i class="mdi mdi-heart text-danger"></i>
    </span>
  </div>

  
@endsection
<!-- partial -->