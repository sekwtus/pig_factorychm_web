<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{csrf_token()}}">
  <title>บริษัทมงคลแอนด์ซันส์ฟาร์มจำกัด</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="{{ asset('assets/vendor/iconfonts/mdi/css/materialdesignicons.min.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/iconfonts/puse-icons-feather/feather.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/css/vendor.bundle.base.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/css/vendor.bundle.addons.css')}}">

  <link rel="stylesheet" href="{{ asset('assets/vendor/iconfonts/font-awesome/css/font-awesome.min.css')}}" />
  <link rel="stylesheet" href="{{ asset('assets/css/shared/style.css')}}">
  <!-- endinject -->
  <!-- Layout styles -->
  <link href="https://fonts.googleapis.com/css2?family=Prompt&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/css/demo_2/style.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/css/demo_1/style.css')}}">
  <!-- End Layout styles -->
  <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png')}}" />

  {{-- datatables --}}
  <link rel="stylesheet" href="{{ asset('/assets/css/datatables/jquery.dataTables.min.css') }}" type="text/css" />
  <style>
    .navbar.horizontal-layout .nav-top .navbar-brand-wrapper .navbar-brand img{
      width: 100px;
      height: 100px;
    }
    select.form-control {
      height: 43.5px;
    }

  </style>

<style>
    .ajax-loader {
    visibility: hidden;
    background-color: rgba(255,255,255,0.7);
    position: absolute;
    z-index: +100 !important;
    width: 100%;
    height:100%;
    }

    .ajax-loader img {
    position: relative;
    /* top:50%;
    left:40%; */
    }

</style>

@yield('style')
</head>

<body>
  <div class="container-scroller">
    <nav class="navbar horizontal-layout col-lg-12 col-12 p-0">
      @include('layouts.navbar')
      @include('layouts.menu_new')
    </nav>

    <div class="container-fluid ">
        <div class="">
    {{-- <div class="container-fluid page-body-wrapper">
      <div class="main-panel container"> --}}
        <div class="content-wrapper">
          {{-- <div class="row mt-5"> --}}
          @yield('main')
          {{-- </div> --}}
        </div>

        <footer class="footer">
          @include('layouts.footer')
        </footer>
      </div>
    </div>
  </div>
  
  <script src="{{ asset('assets/vendor/js/vendor.bundle.base.js')}}"></script>
  <script src="{{ asset('assets/vendor/js/vendor.bundle.addons.js')}}"></script>

  <script src="{{ asset('assets/js/demo_2/dashboard.js')}}"></script>
  <script src="{{ asset('assets/js/demo_2/script.js')}}"></script>

  <script src="{{ asset('assets/js/shared/off-canvas.js')}}"></script>
  <script src="{{ asset('assets/js/shared/hoverable-collapse.js')}}"></script>
  <script src="{{ asset('assets/js/shared/misc.js')}}"></script>
  <script src="{{ asset('assets/js/shared/settings.js')}}"></script>
  <script src="{{ asset('assets/js/shared/todolist.js')}}"></script>
  <script src="{{ asset('assets/js/shared/widgets.js')}}"></script>
  <script src="{{ asset('assets/js/shared/form-validation.js')}}"></script>
  <script src="{{ asset('assets/js/shared/bt-maxLength.js')}}"></script>
  <script src="{{ asset('assets/js/shared/formpickers.js')}}"></script>
  {{--  <script src="{{ asset('assets/js/shared/form-addons.js')}}"></script>  --}}
  <script src="{{ asset('assets/js/shared/x-editable.js')}}"></script>
  <script src="{{ asset('assets/js/shared/dropify.js')}}"></script>
  <script src="{{ asset('assets/js/shared/dropzone.js')}}"></script>
  <script src="{{ asset('assets/js/shared/jquery-file-upload.js')}}"></script>
  <script src="{{ asset('assets/js/shared/form-repeater.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.29.2/sweetalert2.all.js"></script>

  
<script>
  $( document ).ready(function() {
      $.ajax({
          type: 'GET',
          url: '{{ url('menu_permission') }}',
          data: {},
          success: function (data_menu) {
            data_menu[0].forEach(element => {
                $("#"+element.menu_main).removeAttr('hidden');
            });
            data_menu[1].forEach(element => {
                $("#"+element.menu_parent).removeAttr('hidden');
            });
            data_menu[2].forEach(element => {
                $("#"+element.menu_id).removeAttr('hidden');
                // $("#"+element.menu_id+'x').removeAttr('hidden');
            });
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) {
            console.log(1);
                  $.ajax({
                      type: 'GET',
                      url: '{{ url('menu_permission') }}',
                      data: {},
                      success: function (data_menu) {
                        data_menu[0].forEach(element => {
                            $("#"+element.menu_main).removeAttr('hidden');
                        });
                        data_menu[1].forEach(element => {
                            $("#"+element.menu_parent).removeAttr('hidden');
                        });
                        data_menu[2].forEach(element => {
                            $("#"+element.menu_id).removeAttr('hidden');
                        });
                      },
                      error: function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log(1);
                        load_menu();
                        // location.reload();
                      }
                  });
          }
      });
});
</script>


  @yield('script')
</body>
</html>
