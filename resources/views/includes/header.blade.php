<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container--default .select2-selection--multiple {
    height: 44px !important;
     /* border: none !important; */
    }

</style>
<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">

  <!-- Logo -->
  <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
    <a class="navbar-brand brand-logo mr-5" href="#">
      <img src="{{ $currentAgency && $currentAgency->logo ? asset('storage/'.$currentAgency->logo) : asset('assets/images/logo.svg') }}"
           class="mr-2" alt="logo"/>
    </a>
    <a class="navbar-brand brand-logo-mini" href="#">
      <img src="{{ $currentAgency && $currentAgency->logo ? asset('storage/'.$currentAgency->logo) : asset('assets/images/logo-mini.svg') }}" alt="logo"/>
    </a>
  </div>

  <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">


    <!-- Navbar toggler -->
    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
      <span class="icon-menu"></span>
    </button>


    <!-- Search -->
    @if(optional(auth()->user()->role)->name == 'Super Admin')
    <ul class="navbar-nav mr-lg-2">
      <li class="nav-item nav-search d-none d-lg-block">
        <div class="input-group">
          <div class="input-group-prepend hover-cursor" id="navbar-search-icon">
            <span class="input-group-text" id="search"><i class="icon-search"></i></span>
          </div>
                <div class="nav-item mr-3 d-flex align-items-center">
                    <select id="agency-select" class="form-control select2" multiple style="width: 250px;">
                    @foreach($agencies as $agency)
                        <option value="{{ $agency->id }}"
                            {{ in_array($agency->id, session('agency_ids', [])) ? 'selected' : '' }}>
                            {{ $agency->agency_name }}
                        </option>
                    @endforeach
                    </select>
                </div>
                
        </div>
      </li>
    </ul>
    @endif

    <!-- Profile -->
    <ul class="navbar-nav navbar-nav-right">
                  <li class="nav-item dropdown">
            <!-- <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
              <i class="icon-bell mx-0"></i>
              <span class="count"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
              <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <div class="preview-icon bg-success">
                    <i class="ti-info-alt mx-0"></i>
                  </div>
                </div>
                <div class="preview-item-content">
                  <h6 class="preview-subject font-weight-normal">Application Error</h6>
                  <p class="font-weight-light small-text mb-0 text-muted">
                    Just now
                  </p>
                </div>
              </a>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <div class="preview-icon bg-warning">
                    <i class="ti-settings mx-0"></i>
                  </div>
                </div>
                <div class="preview-item-content">
                  <h6 class="preview-subject font-weight-normal">Settings</h6>
                  <p class="font-weight-light small-text mb-0 text-muted">
                    Private message
                  </p>
                </div>
              </a>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <div class="preview-icon bg-info">
                    <i class="ti-user mx-0"></i>
                  </div>
                </div>
                <div class="preview-item-content">
                  <h6 class="preview-subject font-weight-normal">New user registration</h6>
                  <p class="font-weight-light small-text mb-0 text-muted">
                    2 days ago
                  </p>
                </div>
              </a>
            </div> -->
          </li>
      <li class="nav-item nav-profile dropdown">
        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
          <img src="{{ asset('storage/' . auth()->user()->profile) }}" alt="profile"/>
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
          <a class="dropdown-item" href="{{ route('profile.index') }}">
            <i class="ti-user text-primary"></i> Profile
          </a>
          <a class="dropdown-item" href="{{ route('logout')}}">
            <i class="ti-power-off text-primary"></i> Logout
          </a>
        </div>
      </li>
        <!-- <li class="nav-item nav-settings d-none d-lg-flex">
            <a class="nav-link" href="#">
              <i class="icon-ellipsis"></i>
            </a>
          </li> -->
    </ul>

    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
      <span class="icon-menu"></span>
    </button>
  </div>
</nav>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    $('#agency-select').select2({
        placeholder: "Select Agency",
        allowClear: true,
        dropdownParent: $('body'),
        width: '850px'
    });

    $('#agency-select').on('change', function () {
        let agencyIds = $(this).val();
        $.ajax({
            url: "{{ route('set.agency') }}",
            type: "POST",
            data: {
                agency_ids: agencyIds,
                _token: "{{ csrf_token() }}"
            },
            success: function () {
                location.reload();
            }
        });
    });
});
</script>

<style>
/* Align Select2 vertically in navbar */
.select2-container--default .select2-selection--multiple {
    height: 38px;
    padding: 4px 8px;
    border-radius: 4px;
}
.select2-container--default .select2-selection--multiple .select2-selection__rendered {
    line-height: 28px;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice {
    margin-top: 2px;
}
</style>
