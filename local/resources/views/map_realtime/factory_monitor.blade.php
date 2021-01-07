@extends('layouts.master')
@section('style')
<!-- <style type="text/css">
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
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" /> -->

@endsection
@section('main')

<div class="row">
  <div class="col-12">
    <div class="row mt-5">
      <div class="col-12 grid-margin d-none d-lg-block">
        <div class="intro-banner">
          <div class="banner-image mr-5">
            <img src="assets/images/logo2.png" width="120px" height="auto" alt="banner image">
          </div>
          <div class="content-area">
            <h3 class="mb-0">แผนผังโรงงาน</h3>
            <!-- <p class="mb-0">Need anything more to know more? Feel free to contact us at any point.</p> -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>  

<div: class="row">
  <div class="col-md-1 col-lg-2 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">                   
        <h3>คอกหมูขุน</h3>      
        <div class="event border-bottom py-3">
          <p class="mb-2 font-weight-medium">KMK01</p>

         @foreach($scales_kmk01 as $value ) 
          <div class="d-flex align-items-center"> 
           <!-- date_format($date,"H:i:s"); -->
            <div class="badge badge-success">{{substr($value->scale_login_date,10)}}              
            </div>
            <small class="text-muted ml-2"> {{  $value->users_code}}   </small>
            <div class="image-grouped ml-auto">
              <!-- <img class="img-sm rounded-circle" src="assets/images/faces/face10.jpg" alt="profile image"> -->
              <img src="assets/images/faces/face10.jpg" alt="profile image">
              <!-- <img src="../../../assets/images/faces/face13.jpg" alt="profile image"> -->                        
              </div>                          
          </div>                     
            <p class="mb-2 font-weight-small">Order</p>
        @endforeach      
        </div>
      
        <div class="event border-bottom py-3">
          <p class="mb-2 font-weight-medium">KMK02</p>
          @foreach($scales_kmk02 as $value ) 
            <div class="d-flex align-items-center">
              <div class="badge badge-success">
                {{substr($value->scale_login_date,10)}}
              </div>
              <small class="text-muted ml-2"> 
                {{  $value->users_code}}   
              </small>
              <div class="image-grouped ml-auto">
                <!-- <img class="img-sm rounded-circle" src="assets/images/faces/face10.jpg" alt="profile image"> -->
                <img src="assets/images/faces/face10.jpg" alt="profile image">
                <!-- <img src="../../../assets/images/faces/face13.jpg" alt="profile image"> -->                        
              </div>                          
            </div>                     
            <p class="mb-2 font-weight-small">Order</p>
          @endforeach 
        </div>                          
      </div>
    </div>
  </div>

  <div class="col-md-1 col-lg-2 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">                   
        <h3>คอกเชือด</h3>                
        <div class="event border-bottom py-3">
          <p class="mb-2 font-weight-medium">KMK03</p>
          @foreach($scales_kmk03 as $value ) 
          <div class="d-flex align-items-center">
            <div class="badge badge-success">{{substr($value->scale_login_date,10)}}
            </div>
            <small class="text-muted ml-2"> {{  $value->users_code}}   </small>
            <div class="image-grouped ml-auto">
              <!-- <img class="img-sm rounded-circle" src="assets/images/faces/face10.jpg" alt="profile image"> -->
              <img src="assets/images/faces/face10.jpg" alt="profile image">
              <!-- <img src="../../../assets/images/faces/face13.jpg" alt="profile image"> -->                        
              </div>                          
          </div>                     
            <p class="mb-2 font-weight-small">Order</p>
          @endforeach 
        </div>
        <div class="event border-bottom py-3">
          <p class="mb-2 font-weight-medium">KMK04</p>
          @foreach($scales_kmk04 as $value ) 
          <div class="d-flex align-items-center">
            <div class="badge badge-success">{{substr($value->scale_login_date,10)}}
            </div>
            <small class="text-muted ml-2"> {{  $value->users_code}}   </small>
            <div class="image-grouped ml-auto">
              <!-- <img class="img-sm rounded-circle" src="assets/images/faces/face10.jpg" alt="profile image"> -->
              <img src="assets/images/faces/face10.jpg" alt="profile image">
              <!-- <img src="../../../assets/images/faces/face13.jpg" alt="profile image"> -->                        
              </div>
          </div>                     
            <p class="mb-2 font-weight-small">Order</p>
          @endforeach 
        </div>                    
      </div>
    </div>
  </div>

  <div class="col-md-1 col-lg-2 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">                   
        <h3>เครื่องใน</h3>                
        <div class="event border-bottom py-3">
          <p class="mb-2 font-weight-medium">KMK05</p>
          @foreach($scales_kmk05 as $value ) 
          <div class="d-flex align-items-center">
            <div class="badge badge-success">{{substr($value->scale_login_date,10)}}
            </div>
            <small class="text-muted ml-2"> {{  $value->users_code}}   </small>
            <div class="image-grouped ml-auto">
              <!-- <img class="img-sm rounded-circle" src="assets/images/faces/face10.jpg" alt="profile image"> -->
              <img src="assets/images/faces/face10.jpg" alt="profile image">
              <!-- <img src="../../../assets/images/faces/face13.jpg" alt="profile image"> -->                        
              </div>                          
          </div>                     
            <p class="mb-2 font-weight-small">Order</p>
          @endforeach 
        </div>
         <div class="event border-bottom py-3">
          <p class="mb-2 font-weight-medium">KMK06</p>
          @foreach($scales_kmk06 as $value ) 
          <div class="d-flex align-items-center">
            <div class="badge badge-success">{{substr($value->scale_login_date,10)}}
            </div>
            <small class="text-muted ml-2"> {{  $value->users_code}}   </small>
            <div class="image-grouped ml-auto">
              <!-- <img class="img-sm rounded-circle" src="assets/images/faces/face10.jpg" alt="profile image"> -->
              <img src="assets/images/faces/face10.jpg" alt="profile image">
              <!-- <img src="../../../assets/images/faces/face13.jpg" alt="profile image"> -->                        
              </div>                          
          </div>                     
            <p class="mb-2 font-weight-small">Order</p>
          @endforeach 
        </div>    
        <div class="event border-bottom py-3">
          <p class="mb-2 font-weight-medium">KMK07</p>
          @foreach($scales_kmk07 as $value ) 
          <div class="d-flex align-items-center">
            <div class="badge badge-success">{{substr($value->scale_login_date,10)}}
            </div>
            <small class="text-muted ml-2"> {{  $value->users_code}}   </small>
            <div class="image-grouped ml-auto">
              <!-- <img class="img-sm rounded-circle" src="assets/images/faces/face10.jpg" alt="profile image"> -->
              <img src="assets/images/faces/face10.jpg" alt="profile image">
              <!-- <img src="../../../assets/images/faces/face13.jpg" alt="profile image"> -->                        
              </div>                          
          </div>                     
            <p class="mb-2 font-weight-small">Order</p>
          @endforeach 
        </div>                                
      </div>
    </div>
  </div>

  <div class="col-md-1 col-lg-2 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">                   
        <h3>ตัดแต่ง</h3>                
        <div class="event border-bottom py-3">
          <p class="mb-2 font-weight-medium">KMK08</p>
          @foreach($scales_kmk08 as $value ) 
          <div class="d-flex align-items-center">
            <div class="badge badge-success">{{substr($value->scale_login_date,10)}}
            </div>
            <small class="text-muted ml-2"> {{  $value->users_code}}   </small>
            <div class="image-grouped ml-auto">
              <!-- <img class="img-sm rounded-circle" src="assets/images/faces/face10.jpg" alt="profile image"> -->
              <img src="assets/images/faces/face10.jpg" alt="profile image">
              <!-- <img src="../../../assets/images/faces/face13.jpg" alt="profile image"> -->                        
              </div>                          
          </div>                     
            <p class="mb-2 font-weight-small">Order</p>
          @endforeach 
        </div>
        <div class="event border-bottom py-3">
          <p class="mb-2 font-weight-medium">KMK09</p>
          @foreach($scales_kmk09 as $value ) 
          <div class="d-flex align-items-center">
            <div class="badge badge-success">{{substr($value->scale_login_date,10)}}
            </div>
            <small class="text-muted ml-2"> {{  $value->users_code}}   </small>
            <div class="image-grouped ml-auto">
              <!-- <img class="img-sm rounded-circle" src="assets/images/faces/face10.jpg" alt="profile image"> -->
              <img src="assets/images/faces/face10.jpg" alt="profile image">
              <!-- <img src="../../../assets/images/faces/face13.jpg" alt="profile image"> -->                        
              </div>                          
          </div>                     
            <p class="mb-2 font-weight-small">Order</p>
          @endforeach 
        </div>
        <div class="event border-bottom py-3">
          <p class="mb-2 font-weight-medium">KMK10</p>
          @foreach($scales_kmk10 as $value ) 
          <div class="d-flex align-items-center">
            <div class="badge badge-success">{{substr($value->scale_login_date,10)}}
            </div>
            <small class="text-muted ml-2"> {{  $value->users_code}}   </small>
            <div class="image-grouped ml-auto">
              <!-- <img class="img-sm rounded-circle" src="assets/images/faces/face10.jpg" alt="profile image"> -->
              <img src="assets/images/faces/face10.jpg" alt="profile image">
              <!-- <img src="../../../assets/images/faces/face13.jpg" alt="profile image"> -->                        
              </div>                          
          </div>                     
            <p class="mb-2 font-weight-small">Order</p>
          @endforeach 
        </div>                             
      </div>
    </div>
  </div>

  <div class="col-md-1 col-lg-2 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">                   
        <h3>Marinade</h3>                
        <div class="event border-bottom py-3">
          <p class="mb-2 font-weight-medium">KMK11</p>
          @foreach($scales_kmk11 as $value ) 
          <div class="d-flex align-items-center">
            <div class="badge badge-success">{{substr($value->scale_login_date,10)}}
            </div>
            <small class="text-muted ml-2"> {{  $value->users_code}}   </small>
            <div class="image-grouped ml-auto">
              <!-- <img class="img-sm rounded-circle" src="assets/images/faces/face10.jpg" alt="profile image"> -->
              <img src="assets/images/faces/face10.jpg" alt="profile image">
              <!-- <img src="../../../assets/images/faces/face13.jpg" alt="profile image"> -->                        
              </div>                          
          </div>                     
            <p class="mb-2 font-weight-small">Order</p>
          @endforeach 
        </div>        
      </div>
    </div>
  </div>

  <div class="col-md-1 col-lg-2 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">                   
        <h3>คอกเชือด</h3>                
        <div class="event border-bottom py-3">
          <p class="mb-2 font-weight-medium">KMK12</p>
          @foreach($scales_kmk12 as $value ) 
          <div class="d-flex align-items-center">
            <div class="badge badge-success">{{substr($value->scale_login_date,10)}}
            </div>
            <small class="text-muted ml-2"> {{  $value->users_code}}   </small>
            <div class="image-grouped ml-auto">
              <!-- <img class="img-sm rounded-circle" src="assets/images/faces/face10.jpg" alt="profile image"> -->
              <img src="assets/images/faces/face10.jpg" alt="profile image">
              <!-- <img src="../../../assets/images/faces/face13.jpg" alt="profile image"> -->                        
              </div>                          
          </div>                     
            <p class="mb-2 font-weight-small">Order</p>
          @endforeach 
        </div>
        <div class="event border-bottom py-3">
          <p class="mb-2 font-weight-medium">KMK13</p>
          @foreach($scales_kmk13 as $value ) 
          <div class="d-flex align-items-center">
            <div class="badge badge-success">{{substr($value->scale_login_date,10)}}
            </div>
            <small class="text-muted ml-2"> {{  $value->users_code}}   </small>
            <div class="image-grouped ml-auto">
              <!-- <img class="img-sm rounded-circle" src="assets/images/faces/face10.jpg" alt="profile image"> -->
              <img src="assets/images/faces/face10.jpg" alt="profile image">
              <!-- <img src="../../../assets/images/faces/face13.jpg" alt="profile image"> -->                        
              </div>                          
          </div>                     
            <p class="mb-2 font-weight-small">Order</p>
          @endforeach 
        </div>                            
      </div>
    </div>
  </div>

</>


<!-- <div class="row">
  
</div> -->
<!-- 
<div class="row">
  <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body pb-0" id="KMK01">
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body pb-0" id="KMK02"></div>
    </div>
  </div>
  <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body pb-0" id="KMK03"></div>
    </div>
  </div>
  <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body pb-0" id="KMK04">
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
    <div class="card card-statistics">
      <div class="card-body pb-0" id="KMK05"></div>
    </div>
  </div>
  <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
    <div class="card card-statistics">
      <div class="card-body pb-0" id="KMK06"></div>
    </div>
  </div>
  <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
    <div class="card card-statistics">
      <div class="card-body pb-0" id="KMK07"></div>
    </div>
  </div>
  <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
    <div class="card card-statistics">
      <div class="card-body pb-0" id="KMK08"></div>
    </div>
  </div>
  <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
    <div class="card card-statistics">
      <div class="card-body pb-0" id="KMK09"></div>
    </div>
  </div>
  <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
    <div class="card card-statistics">
      <div class="card-body pb-0" id="KMK10"></div>
    </div>
  </div>
  <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
    <div class="card card-statistics">
      <div class="card-body pb-0" id="KMK11"></div>
    </div>
  </div>
  <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
    <div class="card card-statistics">
      <div class="card-body pb-0" id="KMK12"></div>
    </div>
  </div>
</div> -->


<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <img src="assets/images/factory.png" width="100%" height="auto" alt="factory image"></div>
    </div>
  </div>
</div>

@endsection

@section('script')
<script>
  $(document).ready(function () {

    // $.ajax({
    //   url: `{{ url('ajax/scales') }}`,
    //   type: 'GET',
    //   success: function (data) {
    //     data.map(function (value, index) {
    //       let now = new Date(value.created_at);
    //       let date = `${('0' + now.getDate()).slice(-2)}/${('0' + (now.getMonth() + 1)).slice(-2)}/${now.getFullYear() + 543}`
    //       let time = `${('0' + now.getHours()).slice(-2)}:${('0' + now.getMinutes()).slice(-2)}`
    //       let isWorking = parseInt(value.min_diff) < 10 ? `<div class="badge badge-success">กำลังทำงาน</div>` : `<div class="badge badge-danger">เครื่องหยุดทำงาน</div>`

    //       $(`#${value.scale_number}`).append(`
    //        <div class="preview-image">
    //         <img class="img-sm rounded-circle" src="assets/images/faces/face10.jpg" alt="profile image"> 
    //       </div>
    //       <div class="content">
    //         <div class="d-flex align-items-center">
    //           <h6 class="product-name">${value.user_name}</h6>
    //           <small class="time ml-3 d-none d-sm-block">${date} ${time}</small>
    //           <div class="ml-auto text-primary">
    //             <h1>${value.scale_number}</h1>
    //           </div>
    //           <div class="ml-auto">
    //             ${isWorking}
    //           </div>
    //         </div>
    //         <div class="d-flex align-items-center">
    //           <p class="user-name">Order : </p>
    //           <p class="review-text d-block">${value.lot_number}</p>
    //         </div>
    //     </div>`)
    //     })
    //   },
    //   error: function (error) {
    //     console.log(error)
    //   }
    // })

  })
</script>
@endsection