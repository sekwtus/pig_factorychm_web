@section('content')
<link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.addons.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/shared/style.css') }}">

<div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
          <div class="content-wrapper auth p-0 theme-two">
            <div class="row d-flex align-items-stretch">
             
                <div class="col-md-5 banner-section d-none d-md-flex align-items-stretch justify-content-center"  style="padding:20px; background-color: white;">
                    <div class="slide-content bg-1"></div>
                </div>


                <div class="col-12 col-md-7 h-100 bg-light">
                <div class="auto-form-wrapper d-flex align-items-center justify-content-center flex-column">
                  <div class="nav-get-started">
                    <p>Don't have an account?</p>
                    <a class="btn get-started-btn" href="register" style="color:blue">ลงทะเบียน (สมัครสมาชิก)</a>
                  </div>


                  {{-- <form method="POST" action="{{ route('login') }}">
                    @csr
                    
                    <div class="row">
                        <div class="col-12 text-center">
                        <img alt="logo Pic" src="{{asset('images/'.$config_barcode[0]->image_logo)}}" style="width:85%;height:px;">
                      </div>
                    </div> 

                    <hr>

                    <div class="form-group">
                      <label class="label">ชื่อผู้ใช้งาน (Username)</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="mdi mdi-account-outline"></i>
                          </span>
                        </div>

                        <input type="text" id="username" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" placeholder="ชื่อผู้ใช้งาน" required autofocus>
                        @if ($errors->has('username'))
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('username') }}</strong>
                          </span>
                        @endif
                      </div>
                    </div>



    
                    <div class="form-group">
                      <label class="label">รหัสผ่าน (Password)</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="mdi mdi-lock-outline"></i>
                          </span>
                        </div>

                        <input type="password" name="password" id="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="*******" required>
                        @if ($errors->has('password'))
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                          </span>
                        @endif
                      </div>
                    </div>

                    <div class="form-group text-center ">
                      <button class="btn btn-lg btn-primary submit-btn">
                        <i class="fa fa-lg fa-sign-in-alt"></i> เข้าสู่ระบบ
                      </button>

                      <button type="reset" class="btn btn-lg btn-danger" style="background-image: linear-gradient(120deg, #ff0000, #ff5623, #f1a93e);">
                        <i class="fa fa-lg fa-broom"></i> ล้าง
                      </button> --}}

                    {{-- </div>
                  </form> --}}

                  <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row">
                          <div class="col-12 text-center">
                          <img alt="logo Pic" src="assets/images/auth/logomain.png" style="width:60%;height:px;">
                        </div>
                      </div> 
                      <hr>
                     

                        {{-- username --}}
                        <div class="form-group row">
                            <label for="username" class="col-md-4 col-form-label text-md-right">{{ __('username') }}</label>
                            {{-- ส่งค่า username --}}
                            
                            <div class="col-md-6">
                                <input id="username"  class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        {{-- Password --}}
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            {{-- ส่งค่า Password --}}
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- remember --}}
                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>


                        {{-- Login Button --}}
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                {{-- Forgot Password  BT--}}
                                {{-- @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif --}}
                            </div>
                        </div>
                    </form>
    
                  <div class="wrapper mt-2 text-gray">
                    <p class="footer-text">Copyright © 2018 PC Dental Lab.Power by DCore System Integrator.</p>
                  </div>
                  
                </div>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
      </div>
{{--     
      <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
      <script src="{{ asset('assets/vendors/js/vendor.bundle.addons.js') }}"></script>

      --}}




    