<!DOCTYPE html>
<html lang="en">
<head>
@include('includes.css')
</head>
<body>
 <div class="container-scroller">
     @include('includes.header')

    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_settings-panel.html -->
      <!-- <div class="theme-setting-wrapper">
        <div id="settings-trigger"><i class="ti-settings"></i></div>
        <div id="theme-settings" class="settings-panel">
          <i class="settings-close ti-close"></i>
          <p class="settings-heading">SIDEBAR SKINS</p>
          <div class="sidebar-bg-options selected" id="sidebar-light-theme"><div class="img-ss rounded-circle bg-light border mr-3"></div>Light</div>
          <div class="sidebar-bg-options" id="sidebar-dark-theme"><div class="img-ss rounded-circle bg-dark border mr-3"></div>Dark</div>
          <p class="settings-heading mt-2">HEADER SKINS</p>
          <div class="color-tiles mx-0 px-4">
            <div class="tiles success"></div>
            <div class="tiles warning"></div>
            <div class="tiles danger"></div>
            <div class="tiles info"></div>
            <div class="tiles dark"></div>
            <div class="tiles default"></div>
          </div>
        </div>
      </div> -->

      @include('includes.rightsidebar')
      @include('includes.sidebar')
      <div class="main-panel">
        <div class="content-wrapper">
          @yield('content')
        </div>
        </div>
    </div>
</div>
    @include('includes.jss')
    <script type="text/javascript">
    $(document).ready(function() {});
    </script>
    @yield('js_scripts')
    <script>
    $(document).ready(function () {
        $('.select2-basic').select2({
            width: '100%'
        });
    });


</script>
@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Success!',
    text: @json(session('success')),
    timer: 2500,
    showConfirmButton: false,
    background: '#ffffff',
    color: '#2c3e50',
    iconColor: '#28a745',
    customClass: {
        popup: 'swal-rounded'
    }
});
</script>
@endif
@if(session('error'))
<script>
Swal.fire({
    icon: 'error',
    title: 'Access Denied',
    text: @json(session('error')),
    confirmButtonText: 'Okay',
    confirmButtonColor: '#e74c3c',
    background: '#fff',
    color: '#2c3e50',
    iconColor: '#e74c3c',
    customClass: {
        popup: 'swal-rounded'
    }
});
</script>
@endif
</body>

</html>
