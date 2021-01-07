
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
          <h4>ใบสั่งแผน Sale Order เชือดชำแหละ</h4>
        </div>
        <div class="col-6 text-right">
          <a href="{{url('/saleslice/add')}}" class="btn btn-success btn-lg" >
            เพิ่มใบสั่ง <i class="mdi mdi-plus"></i>
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
                        <th>เลขที่</th>
                        <th>วันที่</th>
                        <th>จำนวนตัวทั้งหมด</th>
                        
                        <th>เอกสาร</th>
                        <th>การดำเนินการ</th>
                      </tr>
                    </thead>
                    <tbody class="text-center">
                      @foreach ($listpig as $saleslice)
                        <tr>
                          <td> {{ $saleslice->sale_no }} </td>
                          <td>{{ $saleslice->date }}</td>
                          <td>{{ $saleslice->total }}</td>
                          <td class="text-center">
                            <a class="btn btn-success btn-fw" href="#" >เอกสาร</a>
                          </td>
                          <td class="text-center">
                            <a class="btn btn-info " href="{{ url('saleslice/view/'.$saleslice->sale_no) }}">
                              <i class="mdi mdi-eye"></i> เรียกดู
                            </a>
                            <a class="btn btn-warning "  href="{{url('/saleslice/edit/'.$saleslice->sale_no) }}">
                              <i class="mdi mdi-wrench"></i> แก้ไข
                            </a>
                            {{-- <a class="btn btn-warning" href="#" ><i class="mdi mdi-wrench"></i>แก้ไข</a>&nbsp;&nbsp; --}}
                            <button class="btn btn-danger "  data-toggle="modal"  type="button" data-target="#DELETE{{ $saleslice->sale_no }}">
                              <i class="mdi mdi-delete"></i> ลบ
                            </button> 
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  
                </table>
              </div>
            </div>
            
          </div>
        </div>
      </div>
  

      {{-- ลบข้อมูล --}}
      @foreach($listpig as $saleslice)
        {{ Form::open(['method' => 'post' , 'url' => '/saleslice/delete/'.$saleslice->sale_no]) }}
          <div class="modal fade" id="DELETE{{ $saleslice->sale_no }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel">ลบใบสั่งแผน Sale Order สุกรขุน</h4>
                        </div>
                        <div class="modal-body">
                                <h5 >ยืนยันการลบ ใบสั่งแผนเลขที่ {{ $saleslice->sale_no }}</h5>
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


    
    </div>
  </div>
</div>
@endsection


@section('script')
<script>
function isNumberKey(evt)
{
var charCode = (evt.which) ? evt.which : event.keyCode
if (charCode > 31 && (charCode < 48 || charCode > 57))
return false;
return true;
}

</script>
  <script src="{{ asset('assets/js/shared/form-validation.js')}}"></script>
  <script src="{{ asset('assets/js/shared/bt-maxLength.js')}}"></script>

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

