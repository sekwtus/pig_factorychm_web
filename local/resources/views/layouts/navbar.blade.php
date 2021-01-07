
<div class="container d-flex flex-row nav-top">
  <div class="text-center navbar-brand-wrapper d-flex align-items-top">
    <a class="navbar-brand brand-logo" href="{{url('/')}}">
      <img src="{{ asset('assets/images/logo2.png')}}"style=" width: 60px; height: 55px;"> 
    </a>
    <a class="navbar-brand brand-logo-mini" href="{{url('/')}}">
      <img src="{{ asset('assets/images/logo2.png')}}" > 
    </a>
  </div>
  
  <div class="navbar-menu-wrapper d-flex align-items-center">
    {{-- บริษัทมงคลแอนด์ซันส์ฟาร์มจำกัด --}}
    <div class="text-dark d-sm-block">
        บริษัท มงคลแอนด์ซันส์ฟาร์ม จำกัด
    </div>

    <ul class="navbar-nav navbar-nav-left header-links d-none d-md-flex pl-0" style="margin-left: 100px;">
      <li class="nav-item">
        <a class="nav-link" style="font-size: 1em;">
          <i class="mdi mdi-calendar-clock"></i>
          <span id="diffTime"></span>
        </a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
      
      {{-- <li class="nav-item dropdown ml-4">
        <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
          <i class="mdi mdi-bell-outline"></i>
          <span class="count bg-danger">4</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0" aria-labelledby="notificationDropdown">
          <a class="dropdown-item py-3 border-bottom">
            <p class="mb-0 font-weight-medium float-left">You have 4 new notifications </p>
            <span class="badge badge-pill badge-primary float-right">View all</span>
          </a>
          <a class="dropdown-item preview-item py-3">
            <div class="preview-thumbnail">
              <i class="mdi mdi-alert m-auto text-primary"></i>
            </div>
            <div class="preview-item-content">
              <h6 class="preview-subject font-weight-normal text-dark mb-1">Application Error</h6>
              <p class="font-weight-light small-text mb-0"> Just now </p>
            </div>
          </a>
          <a class="dropdown-item preview-item py-3">
            <div class="preview-thumbnail">
              <i class="mdi mdi-settings m-auto text-primary"></i>
            </div>
            <div class="preview-item-content">
              <h6 class="preview-subject font-weight-normal text-dark mb-1">Settings</h6>
              <p class="font-weight-light small-text mb-0"> Private message </p>
            </div>
          </a>
          <a class="dropdown-item preview-item py-3">
            <div class="preview-thumbnail">
              <i class="mdi mdi-airballoon m-auto text-primary"></i>
            </div>
            <div class="preview-item-content">
              <h6 class="preview-subject font-weight-normal text-dark mb-1">New user registration</h6>
              <p class="font-weight-light small-text mb-0"> 2 days ago </p>
            </div>
          </a>
        </div>
      </li> --}}

      <li class="nav-item dropdown d-none d-xl-inline-block">
        <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
          {{ Auth::user()->fname }}
          <img class="img-xs rounded-circle ml-3" src="{{ asset('assets/images/faces/face1.jpg')}}"> 
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
          <a class="dropdown-item p-0">
            <div class="d-flex border-bottom">
              <div class="py-3 px-4 d-flex align-items-center justify-content-center">
                <i class="mdi mdi-bookmark-plus-outline mr-0 text-gray"></i>
              </div>
              <div class="py-3 px-4 d-flex align-items-center justify-content-center border-left border-right">
                <i class="mdi mdi-account-outline mr-0 text-gray"></i>
              </div>
              <div class="py-3 px-4 d-flex align-items-center justify-content-center">
                <i class="mdi mdi-alarm-check mr-0 text-gray"></i>
              </div>
            </div>
          </a>
          <a class="dropdown-item mt-2" data-toggle="modal" data-target="#ADD" onclick="update_profile({{ Auth::user()->id }})">ข้อมูลส่วนตัว</a>
          <a class="dropdown-item" href="{{url('/logout')}}">ออกจากระบบ</a>
        </div>
      </li>
    </ul>
    
    <button class="navbar-toggler align-self-center" type="button" data-toggle="minimize">
      <span class="mdi mdi-menu"></span>
    </button>
  </div>
</div>

    {{-- ADDข้อมูล --}}
    {{ Form::open(['method' => 'post' , 'url' => 'setting_user/update_profile', 'files' => true]) }}
        <div class="modal fade" id="ADD" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" id="profile">
               
            </div>
        </div>
    {{ Form::close() }}

<script>
  var timeNow = new Date("2018-04-05 23:59:59");


  var strDate =  timeNow.getDate();
  var strMouth =  timeNow.getMonth()+1;
  var strYear = timeNow.getFullYear();
  var strHours = timeNow.getHours();
  var strMinutes= timeNow.getMinutes();
  var strSec  = timeNow.getSeconds();
// document.getElementById("TimeNow").innerHTML = strDate + "/" + strMouth + "/" + strYear + " " + strHours + ":" + strMinutes + ":" + strSec;

  window.onload = function()
  {
    var hou = 2;
    var sec = 60;

    setInterval(function(){

    var _timeNow = new Date();

      var _strMouth =   _timeNow.getMonth()+1;
      var _strYear = _timeNow.getFullYear();
      var _strDate = _timeNow.getDate();
      var _strHours = _timeNow.getHours();
      var _strMinutes= _timeNow.getMinutes();
      var _strSec  = _timeNow.getSeconds();



    document.getElementById("diffTime").innerHTML = _strDate + "/" + _strMouth + "/" + _strYear + " " + _strHours + ":" + _strMinutes + ":" + _strSec;

    },1000);
  }
</script>

<script>
function update_profile(id){
  $.ajax({
              type: 'GET',
              url: '{{ url('/setting/get_profile') }}',
              data: {id:id},
              success: function (profile) {
                  console.log(profile);
                  var readonly = "'readonly'";
                  $("#profile").html('<div class="modal-content">\
                    <div class="modal-header" style="padding: 10px;">\
                        <label class="modal-title" id="myModalLabel"><b>\
                            แก้ไขข้อมูลส่วนตัว</b></label>\
                    </div>\
                    <div class="modal-body" style="padding: 10px;">\
                            <div class="panel-body">\
                                <div class="form-body">\
                                    <br>\
                                    <div class="row">\
                                        <div class="col-md-6">\
                                            <div class="form-group has-error">\
                                                <label class="control-label">\
                                                    ชื่อผู้ใช้\
                                                </label>\
                                                <div class="input-group">\
                                                    <div class="input-group-addon"><i class="ti-user"></i></div>\
                                                    <input class="form-control" placeholder="username" id="name" required name="name" type="text" value="'+profile[0].name+'">\
                                                </div>\
                                            </div>\
                                        </div>\
                                        <div class="col-md-6">\
                                            <div class="form-group has-error">\
                                                <label class="control-label">รหัสผ่าน</label>\
                                                <div class="input-group">\
                                                    <div class="input-group-addon"><i class="ti-home"></i></div>\
                                                    <input class="form-control" placeholder="รหัสผ่าน" required name="password"  type="password"  autocomplete="false" readonly onfocus="this.removeAttribute('+readonly+');" value="'+(profile[0].real_password == 'null' || profile[0].real_password == null || profile[0].real_password == '' ? '' : profile[0].real_password)+'" >\
                                                </div>\
                                            </div>\
                                        </div>\
                                    </div>\
                                    <div class="row">\
                                        <div class="col-md-6">\
                                            <div class="form-group">\
                                                <label class="control-label">\
                                                    ชื่อ-สกุล\
                                                </label>\
                                                <div class="input-group">\
                                                    <div class="input-group-addon"><i class="ti-mobile"></i></div>\
                                                    <input class="form-control" placeholder="ชื่อ-สกุล" id="fname" name="fname" type="text" value="'+profile[0].fname+'" required>\
                                                </div>\
                                            </div>\
                                        </div>\
                                        <div class="col-md-6">\
                                            <div class="form-group">\
                                                <label class="control-label">\
                                                    เบอร์โทร\
                                                </label>\
                                                <div class="input-group">\
                                                    <div class="input-group-addon"><i class="ti-mobile"></i></div>\
                                                    <input class="form-control" placeholder="เบอร์โทร" id="tel" name="tel" type="text" value="'+(profile[0].phone_number == 'null' || profile[0].phone_number == null || profile[0].phone_number == '' ? '' : profile[0].phone_number)+'" required>\
                                                </div>\
                                            </div>\
                                        </div>\
                                    </div>\
                                </div>\
                            </div>\
                    </div>\
                    <div class="modal-footer">\
                        <button type="submit" class="btn btn-success" id="" name="id" value="'+id+'" >ยืนยัน</button>\
                        <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>\
                    </div>\
                </div>');
              }
          });
}
</script>