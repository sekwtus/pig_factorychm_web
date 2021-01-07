<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>บริษัทมงคลแอนด์ซันส์ฟาร์มจำกัด</title>
  <link rel="stylesheet" href="{{ asset('assets/vendor/iconfonts/mdi/css/materialdesignicons.min.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/iconfonts/puse-icons-feather/feather.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/css/vendor.bundle.base.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/css/vendor.bundle.addons.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/css/shared/style.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/css/demo_2/style.css')}}">
  <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png')}}" /> 

  <style>
    .navbar.horizontal-layout .nav-top .navbar-brand-wrapper .navbar-brand img{
      width: 50px;
      height: 50px;
    }
    .navbar.horizontal-layout .nav-top .navbar-menu-wrapper {
      
      width: 200px;
      
    }
    .navbar.horizontal-layout .nav-top .navbar-brand-wrapper{
      width:500px
      /* padding-top:1ch */
    }
    
  </style>
@yield('style')
</head>

<body>
  <div class="container-scroller">
    {{-- logo --}}
    <nav class="navbar horizontal-layout col-lg-12 col-12 p-0">
      <div class="container d-flex flex-row nav-top " >
        <div class="text-center navbar-brand-wrapper d-flex align-items-top">
          <a class="navbar-brand brand-logo" href="{{url('/')}}">
            <img src="{{ asset('assets/images/logo2.png')}}" alt="logo" /> </a>
             <h4 style="padding-top:12pt; padding-left:15pt">บริษัทมงคลแอนด์ซันส์ฟาร์มจำกัด</h4> </div>

        <div class="navbar-menu-wrapper d-flex align-items-center">
          <form action="form-action" class="d-none d-sm-block">
            <div class="input-group search-box">
              <i class="mdi mdi mdi-close search-close"></i>
            </div>
          </form>
          <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown d-none d-xl-inline-block">
              <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">สวัสดี {{ Auth::user }}()->name}}
                <img class="img-xs rounded-circle ml-3" src="{{ asset('assets/images/faces/face1.jpg')}}" alt="Profile image"> </a>
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
                <a class="dropdown-item mt-2" href="{{url('#')}}"> Profile </a>
                <a class="dropdown-item" href="{{url('/logout')}}"> Sign Out </a>
              </div>
            </li>
          </ul>
          <button class="navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
          </button>
        </div>
      </div>

      {{-- Navbar --}}
      <div class="nav-bottom">
        <div class="container">
          <ul class="nav page-navigation">
            <li class="nav-item">
            <a href="{{url('/')}}" class="nav-link">
                <i class="link-icon mdi mdi-home"></i>
                <span class="menu-title">หน้าเเรก</span>
            </a>
            </li>
            <li class="nav-item">
            <a href="{{url('/salepig')}}" class="nav-link">
                <i class="link-icon mdi mdi-home"></i>
                <span class="menu-title">Sale Order สุกรขุน</span>
            </a>
            </li>
            <li class="nav-item">
              <a href="{{url('/saleslice')}}" class="nav-link">
                <i class="link-icon mdi mdi-store"></i>
                <span class="menu-title ">Sale Order เชือดชำเเหละ</span>
               
              </a>
              
            </li>
            <li class="nav-item">
              <a href="{{url('/service')}}" class="nav-link">
                <i class="link-icon mdi mdi-factory"></i>
                <span class="menu-title ">บริการ</span>
                
              </a>
            
            </li>
     
        </div>
      </div>
    </nav>

    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <div class="main-panel container">
        <div class="content-wrapper">
         <div class="row mt-5">
          @yield('main')
         </div>
        </div>
        <footer class="footer">
          @yield('footer')
        </footer>
      </div>
    </div>
  </div>
  <script src="{{ asset('assets/vendor/js/vendor.bundle.base.js')}}"></script>
  <script src="{{ asset('assets/vendor/js/vendor.bundle.addons.js')}}"></script>
  <script src="{{ asset('assets/js/shared/off-canvas.js')}}"></script>
  <script src="{{ asset('assets/js/shared/hoverable-collapse.js')}}"></script>
  <script src="{{ asset('assets/js/shared/misc.js')}}"></script>
  <script src="{{ asset('assets/js/shared/settings.js')}}"></script>
  <script src="{{ asset('assets/js/shared/todolist.js')}}"></script>
  <script src="{{ asset('assets/js/shared/widgets.js')}}"></script>
  <script src="{{ asset('assets/js/demo_2/dashboard.js')}}"></script>
  <script src="{{ asset('assets/js/demo_2/script.js')}}"></script>

  @yield('script')

  {{-- <script src="{{ asset('assets/js/shared/form-validation.js')}}"></script>
  <script src="{{ asset('assets/js/shared/bt-maxLength.js')}}"></script> --}}
</body>

</html>