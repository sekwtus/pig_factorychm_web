
@extends('layouts.master')

@section('main')
<div class="col-lg-12 grid-margin">
  <div class="card">
    <div class="card-body">

      <div class="row mb-3">
        <div class="col-6">
          <h4>ใบรับสุกรมีชีวิตรถบรรทุก</h4>
        </div>
      </div>

      

            <div class="row">
              <div class="col-12">
                  {{ Form::open(['method' => 'post','url' => '/truck_edit', 'class' => 'cmxform', 'id' => 'AddForm'])}}
                  @foreach ($listpig as $truck)
                  
                  <div class="form-group">
                      <label for="exampleInputEmail1">เลขที่</label>
                      <input type="text" class="form-control" onkeypress="return isNumberKey(event)" id="#" placeholder="กรอก เลขที่" name="get_no" value="{{$truck->get_no}}" readonly> </div>
                  
                      <div  class="form-group">
                        <label for="exampleInputEmail1">ชื่อลูกค้า /Group</label>
                      <input type="text" class="form-control" id="#" placeholder="กรอก ชื่อ-นามสกุล" name="customer_name" value="{{$truck->customer_name}}"> </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">ชื่อคนขับรถ</label>
                        <input type="text" class="form-control" id="#" placeholder="กรอก ชื่อ-นามสกุล" name="driver_name" value="{{$truck->driver_name}}"> </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">ทะเบียนรถ</label>
                        <input type="text" class="form-control" id="#" placeholder="กรอก ทะเบียนรถ" name="number_plate" value="{{$truck->number_plate}}"> </div>  
                      <div class="form-group">
                        <label for="exampleInputEmail1">รหัสบิล</label>
                        <input type="text" class="form-control" id="#" placeholder="กรอก รหัสบิล" name="bill_id" onkeypress="return isNumberKey(event)" value="{{$truck->bill_id}}"> </div>    

                      <div class="form-group">
                        <label for="exampleInputPassword1">จำนวนตัว</label>
                        <input type="text" class="form-control" id="#" name="amount" onkeypress="return isNumberKey(event)" placeholder="กรอก จำนวน" value="{{$truck->amount}}"> </div>
                      
                      <div class="form-group">
                        <label for="exampleInputPassword1">น้ำหนัก</label>
                        <input type="text" class="form-control" id="#" placeholder="กรอก น้ำหนักรถรวม" maxlength="6" name="weight" value="{{$truck->weight}}"></div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">รหัส Lot.</label>
                        <input type="text" class="form-control" id="lot" name="lot_id" onkeypress="return isNumberKey(event)" placeholder="กรอก รหัส" value="{{$truck->lot_id}}"> </div>  
                      
                        <div class="form-group">
                        <label for="exampleInputPassword1">หมายเหตุ</label>
                        <input type="text" class="form-control" id="lot" name="note"  placeholder="กรอก หมายเหตุ" value="{{$truck->note}}"> </div>  
                      
                      <button type="submit" class="btn btn-success mr-2">เพิ่ม</button>
                      <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
                        
                    @endforeach
                    {{ Form::close() }}
              </div>
            </div>
            

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
 
@endsection

              



