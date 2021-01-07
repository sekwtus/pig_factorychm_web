@extends('layouts.master')
@section('style')
<style>
 
</style>
    
@endsection
@section('main')
<div class="col-md-12 grid-margin stretch-card">
        
    <div class="card">     
      <div class="card-body">
        <h4>ใบรับสุกรมีชีวิตรถบรรทุก</h4><br>
        {{-- <p class="card-description"> ใบรับสุกรมีชีวิตรถบรรทุก </p> --}}
        <div class="form-group row">
          <div class="col">
            <label>ชื่อลูกค้า /Group</label>
            <div id="name">
              <input class="form-control" type="text" placeholder="กรอก ชื่อ-นามสกุล"> 
            </div>
          </div>
          <div class="col">
            <label>ทะเบียนรถ</label>
            <div id="bloodhound">
              <input class="form-control" type="text" placeholder="ทะเบียนรถ"> 
            </div>
          </div>
          <div class="col">
            <label>สพส1.</label>
            <div id="bloodhound">
              <input class="form-control" type="text" placeholder="สพส1."> 
            </div>
          </div>
        </div>
        <div class="form-group row">
            <div class="col">
              <label>จำนวน</label>
              <div id="name">
                <input class="form-control" type="text" placeholder="จำนวน/ตัว"> 
              </div>
            </div>
            <div class="col">
              <label>น้ำหนักรวม</label>
              <div id="bloodhound">
                <input class="form-control" type="text" placeholder="น้ำหนักรวม/กก."> 
              </div>
            </div>
            <div class="col">
              <label>ร.4</label>
              <div id="bloodhound">
                <input class="form-control" type="text" placeholder="ร.4"> 
              </div>
            </div>
          </div>
          <div class="form-group row">
            <div class="col">
              <label>บิลเลขที่</label>
              <div id="name">
                <input class="form-control" type="text" placeholder="บิลเลขที่"> 
              </div>
            </div>
            <div class="col">
              <label>น้ำหนักรถ</label>
              <div id="bloodhound">
                <input class="form-control" type="text" placeholder="น้ำหนักรถ/กก."> 
              </div>
            </div>
            <div class="col">
              <label>Lot.</label>
              <div id="bloodhound">
                <input class="form-control" type="text" placeholder="Lot."> 
              </div>
            </div>
          </div>
      </div>
      <div class="card-body">
        <h4>หมายเหตุ</h4><br>
        {{-- <p class="card-description"> ใบรับสุกรมีชีวิตรถบรรทุก </p> --}}
        <div class="form-group row">
          <div class="col">
            <label>เวลาถึง</label>
            <div id="name">
              <input class="form-control" type="text" placeholder="เวลาถึง"> 
            </div>
          </div>
          <div class="col">
            <label>พนักงานขับรถ</label>
            <div id="bloodhound">
              <input class="form-control" type="text" placeholder="พนักงานขับรถ"> 
            </div>
          </div>
          <div class="col">
            <label>ผู้ตรวจสอบ</label>
            <div id="bloodhound">
              <input class="form-control" type="text" placeholder="ผู้ตรวจสอบ"> 
            </div>
          </div>
          <div class="col">
            <label>ผู้อนุมัติ</label>
            <div id="name">
              <input class="form-control" type="text" placeholder="ผู้อนุมัติ"> 
            </div>
          </div>
        </div>
        <div class="form-group row">
            <div class="col">
              <label>เวลาออก</label>
              <div id="name">
                <input class="form-control" type="text" placeholder="เวลาออก"> 
              </div>
            </div>
            <div class="col">
              <label>วันที่</label>
              <div id="bloodhound">
                <input class="form-control" type="text" placeholder="วันที่"> 
              </div>
            </div>
            <div class="col">
              <label>วันที่</label>
              <div id="bloodhound">
                <input class="form-control" type="text" placeholder="วันที่/ตำแหน่ง เจ้าหน้าที่รับสุกร"> 
              </div>
            </div>
            <div class="col">
                <label>วันที่</label>
                <div id="name">
                  <input class="form-control" type="text" placeholder="วันที่/ตำแหน่ง หัวหน้าผลิตเชือดชำแหละ"> 
                </div>
              </div>
          </div>
          <div class="d-flex justify-content-center">
          <button type="submit" class="btn btn-success mr-2">เพิ่ม</button>
          <button class="btn btn-light">ย้อนกลับ</button>
        </div>
      </div>
    </div>
  </div>     
@endsection

@section('script')
<script>
function isNumberKey(evt)
			{
				var charCode = (evt.which) ? evt.which : evt.keyCode;
				if (charCode != 46 && charCode > 31 
				&& (charCode < 48 || charCode > 57))
				return false;
				return true;
			}  
			
</script>			
    
@endsection