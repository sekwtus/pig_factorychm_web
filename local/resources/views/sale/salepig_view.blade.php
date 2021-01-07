
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

      <div class="row mb-3">
        <div class="col-6">
          <h4>ใบสั่งแผน Sale Order สุกรขุน</h4>
        </div>
        <div class="col-6 text-right">
          หมายเลข : {{$id}} 
          </a>
        </div>
      </div>

      <div class="row">
        <div class="col-12 table-responsive">
          <div id="order-listing_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">

            <div class="row">
              <div class="col-12">
                <table class="table table-striped dataTable- no-footer-" id = "example">
              
                    <thead class="text-center">
                      <tr>
                        {{-- <th>เลขที่</th>
                        <th>วันที่</th> --}}
                        <th>ชื่อลูกค้า</th>
                        <th>จำนวนตัว</th>
                        <th>ช่างน้ำหนัก(ก.ก.)</th>
                        <th>หมายเหตุ</th>
                        
                      </tr>
                    </thead>
                    <tbody class="text-center">
                      @foreach ($listpig as $data)
                        <tr>
                          
                          <td>{{ $data->customer_name }}</td>
                          <td>{{ $data->amount }}</td>
                          <td>{{ $data->weight_range }}</td>
                          <td>{{ $data->note }}</td>
                          
                        </tr>
                      @endforeach
                    </tbody>
                 
                </table>
              </div>
            </div>
          </div>
        </div>
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


