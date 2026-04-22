<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
.navbar-menu-wrapper {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
}


.navbar-menu-wrapper  {
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
}
.navbar-nav.mr-lg-2 {
    position: static !important;
    transform: none !important;
}
#agency-select {
    width: 100% !important;
    max-width: 250px;
}

/* Keep profile on the right */
.navbar-nav-right {
    margin-left: auto !important;
}
/* Bell button */
.count-indicator {
  position: relative;
  width: 42px;
  height: 42px;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0;
  background: #fff;
  border: 1px solid #e0e0e0;
  border-radius: 10px;
}

/* Badge — key fix */
.count-indicator .count {
  position: absolute;
  top: -6px;
  right: -6px;
  min-width: 18px;
  height: 18px;
  padding: 0 5px;
  border-radius: 9px;
  font-size: 10px;
  font-weight: 700;
  line-height: 18px;
  text-align: center;
  border: 2px solid #f0f2f5;
}

/* Dropdown panel */
.navbar-dropdown.preview-list {
  width: 320px;
  border-radius: 14px;
  border: 1px solid #e8e8e8;
  padding: 0;
  overflow: hidden;
}

/* Unread row highlight */
.preview-item.unread {
  background: #f0f7ff;
  border-left: 3px solid #1976d2;
}

.preview-item {
  display: flex;
  align-items: flex-start;
  gap: 11px;
  padding: 12px 16px;
  border-bottom: 1px solid #f5f5f5;
}

.preview-item:hover { background: #fafafa; }

/* Icon circle */
.notif-icon-wrap {
  width: 36px;
  height: 36px;
  border-radius: 50%;
  background: #e3f2fd;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.preview-subject { font-size: 13px; font-weight: 600; color: #1a1a1a; }
.small-text      { font-size: 12px; color: #777; line-height: 1.4; }
.select2-container--default .select2-selection--multiple {
    height: 44px !important;
    max-height: 44px !important;
    overflow: hidden !important;
    display: flex !important;
    align-items: center !important;
    flex-wrap: nowrap !important;
    padding: 3px 36px 3px 10px !important;
    gap: 4px !important;
    border: 1.5px solid #e2e5f0 !important;
    border-radius: 10px !important;
    background: #f7f8fc !important;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.select2-container--default .select2-selection--multiple {
    height: 45px !important;
    padding: 4px 8px;
    border-radius: 4px;
}

/* Focus / open state */
.select2-container--default.select2-container--focus .select2-selection--multiple,
.select2-container--default.select2-container--open .select2-selection--multiple {
    border-color: #3f3cbb !important;
    box-shadow: 0 0 0 3px rgba(63, 60, 187, 0.10) !important;
    background: #ffffff !important;
    outline: none !important;
}

/* ── Selected chips ── */
.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background: linear-gradient(135deg, #3f3cbb, #5553d4) !important;
    border: none !important;
    border-radius: 6px !important;
    color: #fff !important;
    font-size: 12px !important;
    font-weight: 500 !important;
    padding: 3px 8px 3px 20px !important;
    margin: 0 !important;
    white-space: nowrap !important;
    flex-shrink: 0 !important;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice__display {
    font-size: 12px !important;
    color: #ffffff !important;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
    color: rgba(255, 255, 255, 0.70) !important;
    font-size: 13px !important;
    padding: 0 4px !important;
    background: transparent !important;
    border: none !important;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
    color: #ffffff !important;
    background: transparent !important;
}

/* ── Clear all (×) button ── */
.select2-container--default .select2-selection--multiple .select2-selection__clear {
    margin-top: 0 !important;
    color: #b0b5c8 !important;
    font-size: 16px !important;
    position: absolute !important;
    right: 10px !important;
    top: 50% !important;
    transform: translateY(-50%) !important;
}

.select2-container--default .select2-selection--multiple .select2-selection__clear:hover {
    color: #3f3cbb !important;
}

/* ── Inline search field (collapses when chips present) ── */
.select2-container--default .select2-search--inline {
    flex-shrink: 0 !important;
    min-width: 0 !important;
}

.select2-container--default .select2-search--inline .select2-search__field {
    font-size: 13.5px !important;
    color: #6b7280 !important;
    margin: 6px !important;
    padding: 2px 0 !important;
    min-width: 0 !important;
    max-width: 120px !important;
}

/* ── Disabled state ── */
.select2-container--default.select2-container--disabled .select2-selection--multiple {
    background-color: #ffffff !important;
    border: 1px solid #ced4da !important;
    cursor: not-allowed !important;
    box-shadow: none !important;
}

/* ── Dropdown panel ── */
.select2-dropdown {
    border: 1.5px solid #e2e5f0 !important;
    border-radius: 12px !important;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12) !important;
    overflow: hidden !important;
    margin-top: 4px !important;
}

/* Search inside dropdown */
.select2-search--dropdown {
    padding: 8px !important;
}

.select2-search--dropdown .select2-search__field {
    border: 1.5px solid #e2e5f0 !important;
    border-radius: 8px !important;
    padding: 7px 12px !important;
    font-size: 13px !important;
    outline: none !important;
}

.select2-search--dropdown .select2-search__field:focus {
    border-color: #3f3cbb !important;
    box-shadow: 0 0 0 2px rgba(63, 60, 187, 0.10) !important;
}

/* Options list */
.select2-results__options {
    padding: 4px !important;
}

.select2-results__option {
    font-size: 13.5px !important;
    padding: 9px 12px !important;
    border-radius: 8px !important;
    color: #3a3d52 !important;
    transition: background 0.15s !important;
}

.select2-results__option--highlighted {
    background: #f0efff !important;
    color: #3f3cbb !important;
}

.select2-results__option[aria-selected="true"] {
    background: #ebe9ff !important;
    color: #3f3cbb !important;
    font-weight: 600 !important;
}
.nav-profile .nav-link:hover {
    background: rgba(0,0,0,0.05);
    border-radius: 8px;
}
@media (max-width: 576px) {

    .navbar {
        flex-wrap: wrap;
        padding: 5px 10px;
    }

    .navbar-brand-wrapper {
        width: 100%;
        justify-content: space-between;
    }

    /* Stack search below */
    .navbar-nav.mr-lg-2 {
        width: 100%;
        margin-top: 8px;
    }

    #agency-select {
        width: 100% !important;
        max-width: 100%;
    }

    /* Reduce icon size */
    .count-indicator {
        width: 36px;
        height: 36px;
    }

    /* Hide username text (keep avatar) */
    .nav-profile .ml-2 {
        display: none;
    }

    /* Dropdown width fix */
    .navbar-dropdown.preview-list {
        width: 100%;
        right: 0;
        left: 0;
    }
}

/* ========== SMALL DEVICES (≤768px) ========== */
@media (max-width: 768px) {

    .navbar-nav.mr-lg-2 {
        width: 100%;
        justify-content: center;
    }

    .navbar-nav-right {
        margin-left: auto;
    }

    .navbar-dropdown.preview-list {
        width: 280px;
    }
}

/* ========== TABLETS (768px - 1024px) ========== */
@media (min-width: 768px) and (max-width: 1024px) {

    #agency-select {
        max-width: 200px;
    }

    .navbar-dropdown.preview-list {
        width: 300px;
    }
}

/* ========== LARGE SCREENS (≥1024px) ========== */
@media (min-width: 1024px) {

    .navbar-menu-wrapper {
        justify-content: center;
    }

    .navbar-nav.mr-lg-2 {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
    }
}
</style>
<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">

    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">

        {{-- Large logo / name --}}
        <a class="navbar-brand brand-logo mr-5" href="#">

            @if(auth()->check() && auth()->user()->agency_id)

                @php
                    $agency = $currentAgency ?? null;
                @endphp

                @if($agency && $agency->logo)
                    <img src="{{ asset($agency->logo) }}" class="mr-2" alt="logo"/>
                @else
                    <span class="navbar-brand-text">
                        {{ $agency->agency_name ?? 'Agency' }}
                    </span>
                @endif

            @else
                <img src="{{ asset('assets/images/leadbridge_logo.svg') }}" class="mr-2" alt="logo"/>
            @endif

        </a>

        {{-- Mini logo --}}
        <a class="navbar-brand brand-logo-mini" href="#">

            @if(auth()->check() && auth()->user()->agency_id && $currentAgency && $currentAgency->logo)
                <img src="{{ asset($currentAgency->logo) }}" alt="logo"/>
            @else
                <img src="{{ asset('assets/images/logo-mini.svg') }}" alt="logo"/>
            @endif

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
            <a class="nav-link count-indicator dropdown-toggle position-relative"
            id="notificationDropdown"
            href="#"
            data-toggle="dropdown">

                <i class="icon-bell mx-0"></i>

                <span class="count badge badge-danger position-absolute">
                    {{ $unreadCount ?? 0 }}
                </span>
            </a>

            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                aria-labelledby="notificationDropdown">

                <p class="mb-0 font-weight-normal float-left dropdown-header">
                    Notifications
                </p>

                @forelse($notifications as $notification)

                    <a class="dropdown-item preview-item" href="#">

                        <div class="preview-item-content">
                            <h6 class="preview-subject font-weight-normal">
                                {{ $notification->data['title'] ?? '' }}
                            </h6>

                            <p class="font-weight-light small-text mb-0 text-muted">
                                {{ $notification->data['message'] ?? '' }}
                            </p>
                        </div>

                    </a>

                @empty
                    <a class="dropdown-item text-center">
                        No notifications
                    </a>
                @endforelse

            </div>
        </li>
        <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" data-toggle="dropdown" id="profileDropdown">

                <img src="{{ auth()->user()->profile
                        ? asset(auth()->user()->profile)
                        : asset('assets/images/default-profile.png') }}"
                    alt="profile"
                    class="rounded-circle"
                    width="35"
                    height="35">

                <div class="ml-2 text-left">
                    <div class="font-weight-bold text-dark" style="line-height: 1;">
                        {{ auth()->user()->name }}
                    </div>
                    <small class="text-muted">
                        {{ auth()->user()->role->name }}
                    </small>
                </div>

            </a>

            <div class="dropdown-menu dropdown-menu-right navbar-dropdown shadow-sm"
                aria-labelledby="profileDropdown">

                <a class="dropdown-item" href="{{ route('profile.index') }}">
                    <i class="ti-user text-primary mr-2"></i> Profile
                </a>
                <div class="dropdown-divider"></div>
               @if( strtolower(auth()->user()->role->name) == 'admin')

                    <a class="dropdown-item" href="{{ route('agency.show') }}">
                        <i class="ti-briefcase text-primary mr-2"></i> Agency
                    </a>
                @endif
                <div class="dropdown-divider"></div>

                <a class="dropdown-item text-danger" href="{{ route('logout') }}">
                    <i class="ti-power-off mr-2"></i> Logout
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
