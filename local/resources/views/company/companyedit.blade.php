@extends('layouts.master')
@section('main')
<div class="col-lg-12 grid-margin">
    <div class="card">
      <div class="card-body">
        <h4>ใบสั่งแผน Sale Order สุกรขุน</h4><br>
        <div class="row">
          <div class="col-4"></div>
          <div class="col-4 text-right" >
            {{-- <a class="btn btn-success btn-fw" href="#">เอกสาร</a>&nbsp;&nbsp;&nbsp;&nbsp; --}}
            {{-- <a class="btn btn-success btn-fw" href="{{url('bill-add')}}">เพิ่มใบสั่ง</a> --}}
            <button type="button" class="btn btn-success btn-fw" data-toggle="modal" data-target="#addbill">เพิ่มใบสั่ง
                    <i class="mdi mdi-plus"></i></button>
          </div>


          {{-- {!! Form::model($car, ['action' => 'Billcontroller@test']) !!}

    <div class="form-group">
      {!! Form::label('make', 'Make') !!}
      {!! Form::text('make', '', ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
      {!! Form::label('model', 'Model') !!}
      {!! Form::text('model', '', ['class' => 'form-control']) !!}
    </div>

    <button class="btn btn-success" type="submit">Add the Car!</button>

  {!! Form::close() !!} --}}


          {{ Form::open(['method' => 'post','url' => '/bill/insertbill', 'class' => 'cmxform', 'id' => 'signupForm'])}}
          <div class="modal fade" id="addbill" tabindex="-1" role="dialog" aria-labelledby="addbill" aria-hidden="true">
            <div class="modal-dialog" style="max-width:720px"  role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title" id="addbill">ใบรับสุกรมีชีวิตรถบรรทุก</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                
                
                <div class="modal-body pb-0">
                    
                            <div class="form-group row">
                              <div class="col">
                                <label>ชื่อลูกค้า /Group</label>
                                <div id="name">
                                  <input  name="name" class="form-control" type="text" placeholder="กรอก ชื่อ-นามสกุล"> 
                                </div>
                              </div>
                              <div class="col">
                                <label>ทะเบียนรถ</label>
                                <div id="car">
                                  <input  name="car" class="form-control" type="text" placeholder="ทะเบียนรถ"> 
                                </div>
                              </div>
                            </div>
                            <div class="form-group row">
                                <div class="col">
                                  <label>สพส1.</label>
                                  <div id="IDP">
                                    <input  name="IDP" class="form-control" type="text" placeholder="สพส1."> 
                                  </div>
                                </div>
                                <div class="col">
                                  <label>จำนวน</label>
                                  <div id="count">
                                    <input  name="count" class="form-control" type="text" placeholder="จำนวน/ตัว"> 
                                  </div>
                                </div>
                               
                              </div>
                              <div class="form-group row">
                                <div class="col">
                                  <label>น้ำหนักรวม</label>
                                  <div id="totalweigth">
                                    <input  name="totalweigth" class="form-control" type="text" placeholder="น้ำหนักรวม/กก."> 
                                  </div>
                                </div>
                                <div class="col">
                                  <label>ร.4</label>
                                  <div id="R4">
                                    <input  name="R4" class="form-control" type="text" placeholder="ร.4"> 
                                  </div>
                                </div>
                              </div>  
                              <div class="form-group row">
                                  <div class="col">
                                      <label>บิลเลขที่</label>
                                      <div id="billno">
                                        <input  name="billno" class="form-control" type="text" placeholder="บิลเลขที่"> 
                                      </div>
                                    </div>
                              <div class="col">
                                <label>น้ำหนักรถ</label>
                                  <div id="carweigth">
                                    <input  name="carweigth" class="form-control" type="text" placeholder="น้ำหนักรถ/กก."> 
                                  </div>
                              </div>
                              </div>
                              <div class="form-group row">
                              <div class="col-6">
                                <label>Lot.</label>
                                  <div id="lot">
                                    <input  name="lot" class="form-control" type="text" placeholder="Lot."> 
                                  </div>
                              </div>
                              </div>
                      
                </div>
                <div class="modal-footer">
                        <button type="submit" class="btn btn-success mr-2">เพิ่ม</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
                </div>
           
            
              </div>
            </div>
          </div>
          {{ Form::close() }}
          <div class="col-4 text-right" >
            <input type="search" class="form-control"   placeholder="search" aria-controls="order-listing" >
          </div>
        </div><br>
        
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>ลำดับ</th>
                <th>ลูกค้า/Group</th>
                <th>ทะเบียนรถ</th>
                <th>สพส1.</th>
                <th>จำนวน</th>
                <th>น้ำหนักรวม</th>
                <th>ร.4</th>
                <th>บิลเลขที่</th>
                <th>น้ำหนักรถ</th>
                <th>Lot.</th>
              </tr>
            </thead>
            <tbody>
                @php $count =1;@endphp
                @foreach ($listbill as $billshow)
                <tr>
                    <td style="width:5%" >{{ $count++ }}</td>
                    
                    {{-- <td style="width:5%">{{ $billshow->ID }}</td> --}}
                    <td style="width:5%">{{ $billshow->Name }}</td>
                    <td style="width:5%">{{ $billshow->Licensepale }}</td>
                    <td style="width:5%">{{ $billshow->IDP }}</td>
                    <td style="width:5%">{{ $billshow->count }}</td>
                    <td style="width:5%">{{ $billshow->totalweigth }}</td>
                    <td style="width:5%">{{ $billshow->factory }}</td>
                    <td style="width:5%">{{ $billshow->billNo }}</td>
                    <td style="width:5%">{{ $billshow->carweigth }}</td>
                    <td style="width:5%">{{ $billshow->Lot }}</td>
                </tr>
                @endforeach
                {{-- @for($i=0;$i<=12;$i++)
                <tr>
                    <td class="py-1">
                      <img src="assets/images/faces-clipart/pic-1.png" alt="image" /> </td>
                    <td> Herman Beck </td>
                    <td>
                      <div class="progress">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </td>
                    <td> $ 77.99 </td>
                    <td> May 15, 2015 </td>
                </tr>
                @endfor --}}
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
        
          
        
@endsection


