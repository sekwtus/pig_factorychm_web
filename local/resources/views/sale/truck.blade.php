
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
          <h4>ใบรับสุกรมีชีวิตรถบรรทุก</h4>
        </div>
        <div class="col-6 text-right">
          <a href="{{url('/truck/add')}}" class="btn btn-success btn-lg" >
            เพิ่มใบรับ <i class="mdi mdi-plus"></i>
          </a>
        </div>
      </div>

      <div class="row">
        <div class="col-12 table-responsive">
          <div id="order-listing_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer" >

            

            <div class="row">
              <div class="col-12">
                <table class="table table-striped dataTable- no-footer-" id = "example">
                  {{-- @if(empty($check)) --}}
                    <thead class="text-center">
                      <tr>
                        <th>เลขที่</th>
                        <th>วันที่</th>
                        {{-- <th>ชื่อลูกค้า/Group</th>
                        <th>ชื่อคนขับรถ</th>
                        <th>Lot.</th>
                        <th>รหัสบิล</th>
                        <th>ทะเบียนรถ</th>
                        <th>จำนวนตัว</th>
                        <th>น้ำหนักรวม</th>
                        <th>หมายเหตุ</th> --}}
                        <th>เอกสาร</th>
                        <th>การดำเนินการ</th>
                      </tr>
                    </thead>
                    <tbody class="text-center">
                      @foreach ($listpig as $truck)
                        <tr>
                          <td>{{ $truck->get_no }} </td>
                          <td>{{ $truck->date }}</td>
                          {{--<td>{{ $truck->customer_name }}</td>
                           <td>{{ $truck->driver_name }}</td>
                          <td>{{ $truck->lot_id }}</td>
                          <td>{{ $truck->bill_id }}</td>
                          <td>{{ $truck->number_plate }}</td>
                          <td>{{ $truck->amount }}</td>
                          <td>{{ $truck->weight }}</td>
                          <td>{{ $truck->note }}</td> --}}
                          <td class="text-center">
                            <a class="btn btn-success btn-fw" href="#" >เอกสาร</a>
                          </td>
                          <td class="text-center">
                            <button class="btn btn-info "  data-toggle="modal"  type="button" data-target="#SHOW{{ $truck->id }}">
                              <i class="mdi mdi-eye"></i> เรียกดู
                            </button> 
                            </a>
                            <a class="btn btn-warning "  href="{{url('/truck/edit/'.$truck->get_no) }}">
                              <i class="mdi mdi-wrench"></i> แก้ไข
                            </a>
                            <button class="btn btn-danger "  data-toggle="modal"  type="button" data-target="#DELETE{{ $truck->id }}">
                              <i class="mdi mdi-delete"></i> ลบ
                            </button> 
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  {{-- @else
                    <tbody class="text-center">
                      <tr><td>ไม่มีข้อมูล</td></tr>
                    </tbody> 
                  @endif --}}
                </table>
              </div>
            </div>
            
          </div>
        </div>
      </div>
      @foreach($listpig as $truck)
      {{ Form::open(['method' => 'post' , 'url' => '/truck/delete/'.$truck->id]) }}
          <div class="modal fade" id="DELETE{{ $truck->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                      <div class="modal-content">
                          <div class="modal-header">
                                  <h4 class="modal-title" id="myModalLabel">ลบใบสั่งแผน Sale Order สุกรขุน</h4>
                          </div>
                          <div class="modal-body">
                                  <h5 >ยืนยันการลบ ใบสั่งแผนเลขที่ {{ $truck->get_no }}</h5>
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









            {{-- เพิ่มข้อมูล --}}
            {{-- <div class="modal fade" id="pigadd" tabindex="-1" role="dialog" aria-labelledby="pigadd" aria-hidden="true">
              <div class="modal-dialog" role="document" >
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title" id="pigadd">เพิ่มใบสั่งแผน Sale Order สุกรขุน</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    
                      {{ Form::open(['method' => 'post','url' => 'truck/truck_add', 'class' => 'cmxform', 'id' => 'signupForm'])}}
                      <div class="form-group">
                          <label for="exampleInputEmail1">เลขที่</label>
                          <input type="text" class="form-control" onkeypress="return isNumberKey(event)" id="id" placeholder="กรอก เลขที่" name="no"> </div>
                      

                              <div class="form-group">
                              <h4 class="card-title">วันที่่</h4> {{date('d/m/Y')}}
                              
                          </div>

                          <div class="form-group">
                            <label for="exampleInputEmail1">ชื่อลูกค้า /Group</label>
                            <input type="text" class="form-control" id="name" placeholder="กรอก ชื่อ-นามสกุล" name="cname"> </div>
                          <div class="form-group">
                            <label for="exampleInputEmail1">ชื่อคนขับรถ</label>
                            <input type="text" class="form-control" id="name" placeholder="กรอก ชื่อ-นามสกุล" name="dname"> </div>
                          <div class="form-group">
                            <label for="exampleInputEmail1">ทะเบียนรถ</label>
                            <input type="text" class="form-control" id="name" placeholder="กรอก ทะเบียนรถ" name="lp"> </div>  
                          <div class="form-group">
                            <label for="exampleInputEmail1">รหัสบิล</label>
                            <input type="text" class="form-control" id="name" placeholder="กรอก รหัสบิล" name="lb" onkeypress="return isNumberKey(event)"> </div>    

                          <div class="form-group">
                            <label for="exampleInputPassword1">จำนวนตัว</label>
                            <input type="text" class="form-control" id="num" name="num" onkeypress="return isNumberKey(event)" placeholder="กรอก จำนวน"> </div>
                          
                          <div class="form-group">
                            <label for="exampleInputPassword1">น้ำหนัก</label>
                            <input type="text" class="form-control" id="weight1" placeholder="กรอก น้ำหนักรถรวม" maxlength="6" name="weight"></div>
                          <div class="form-group">
                            <label for="exampleInputPassword1">รหัส Lot.</label>
                            <input type="text" class="form-control" id="lot" name="lot" onkeypress="return isNumberKey(event)" placeholder="กรอก รหัส"> </div>  
                          
                          <button type="submit" class="btn btn-success mr-2">เพิ่ม</button>
                          <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
                        
                        {{ Form::close() }}
                  </div>
                  
                </div>
              </div>
            </div> --}}

            {{-- แสดงข้อมูล --}}
             @foreach($listpig as $truck)
              <div class="modal fade" id="SHOW{{ $truck->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                    

                      <h4 class="modal-title " id="pigadd">เลขที่่ : {{ $truck->id }} </h4>&nbsp;&nbsp;&nbsp;
                      <h4 class="modal-title " id="pigadd">วันที่่ : {{ $truck->date }} </h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    
                    </div>
                    <div class="modal-body">
                        
                        ชื่อลูกค้า : {{ $truck->customer_name }}<br>
                        ชื่อคนขับรถ : {{ $truck->driver_name }}<br>
                        ทะเบียนรถ : {{ $truck->number_plate }}<br>
                        รหัสบิล : {{ $truck->bill_id }}<br>
                        จำนวนตัว : {{ $truck->amount }}<br>
                        น้ำหนักรวม : {{ $truck->weight }} <br>
                        รหัส Lot. : {{ $truck->lot_id }}<br>
                
                    </div>
                    
                  </div>
                </div>
              </div>
            @endforeach 
                {{-- แก้ไขข้อมูล --}}
                        {{-- @foreach($listpig as $truck)
                        {{ Form::open(['method' => 'post','url' => '/truck/edit/'.$truck->id, 'class' => 'cmxform'])}}
                        <div class="modal fade" id="EDIT{{ $truck->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h4 class="modal-title" id="pigadd">แก้ไขใบสั่งแผน Sale Order สุกรขุน </h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                    
                                    
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">เลขที่</label>
                                        <input type="text" class="form-control" onkeypress="return isNumberKey(event)" id="no" placeholder="กรอก เลขที่" name="no" value="{{ $truck->no }}"> </div>
                                    
          
                                            <div class="form-group">
                                            <h4 class="card-title">Date</h4>
                                          <div id="datepicker-popup" class="input-group date datepicker">
                                            <input type="text" class="form-control" name="date" value="{{ $truck->date }}">
                                            <span class="input-group-addon input-group-append border-left">
                                              <span class="mdi mdi-calendar input-group-text"></span>
                                            </span>
                                          </div>
                                        </div>
                                        
                                        <div class="form-group">
                                          <label for="exampleInputEmail1">ชื่อลูกค้า /Group</label>
                                          <input type="text" class="form-control" id="name" placeholder="กรอก ชื่อ-นามสกุล" name="name" value="{{ $truck->name }}"> </div>
          
                                        <div class="form-group">
                                          <label for="exampleInputPassword1">จำนวนตัว</label>
                                          <input type="text" class="form-control" id="num" name="num" onkeypress="return isNumberKey(event)" placeholder="กรอก จำนวน" value="{{ $truck->num }}"> </div>
                                        
                                        <div class="form-group">
                                          <label for="exampleInputPassword1">ช่วงน้ำหนัก</label>
                                          @php

                                          $w = explode('-', $truck->weight);
                                        
                                          @endphp
                                          
                                          <div class='row'>
                                          <div class="col-4"><input type="text" class="form-control" id="weight1" placeholder="กรอก ช่วงน้ำหนัก" maxlength="5" name="weight1" value ="{{($w[0])}}"> </div>
                                          <div class="col-1 text-center">-</div>
                                          <div class="col-4"><input type="text" class="form-control" id="weight2" placeholder="กรอก ช่วงน้ำหนัก" maxlength="5" name="weight2" value ="{{($w[1])}}"></div>
                                          </div>
                                        </div>  

                                        <div class="form-group">
                                          <label for="exampleInputPassword1">หมายเหตุ</label>
                                          <input type="text" class="form-control" id="note" placeholder="กรอก หมายเหตุ" name="note" value="{{ $truck->note1 }}"> </div>
                                        <button type="submit" class="btn btn-success mr-2">แก้ไข</button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button></div>
                                
                              </div>
                            </div>
                          </div>
                          {{ Form::close() }}
                          @endforeach --}}


                          {{-- ลบข้อมูล --}}
                        
                       
                        
              



