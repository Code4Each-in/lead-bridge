<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
.navbar-menu-wrapper {
    justify-content: center !important;
}

.navbar-menu-wrapper .navbar-nav.mr-lg-2 {
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
}


/* Keep profile on the right */
.navbar-nav-right {
    margin-left: auto !important;
}
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
</style>
<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">

  <!-- Logo -->
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo mr-5" href="#">
            <img src="<?php echo e($currentAgency && $currentAgency->logo
                ? asset($currentAgency->logo)
                : asset('assets/images/leadbridge_logo.svg')); ?>"
                class="mr-2" alt="logo"/>
        </a>
        <a class="navbar-brand brand-logo-mini" href="#">
            <img src="<?php echo e($currentAgency && $currentAgency->logo
                ? asset($currentAgency->logo)
                : asset('assets/images/logo-mini.svg')); ?>"
                alt="logo"/>
        </a>
    </div>

  <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">

    <!-- Navbar toggler -->
    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
      <span class="icon-menu"></span>
    </button>

    <!-- Search -->
    <?php if(optional(auth()->user()->role)->name == 'Super Admin'): ?>
    <ul class="navbar-nav mr-lg-2">
      <li class="nav-item nav-search d-none d-lg-block">
        <div class="input-group">

                <div class="nav-item mr-3 d-flex align-items-center">
                    <select id="agency-select" class="form-control select2" multiple style="width: 250px;">
                    <?php $__currentLoopData = $agencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($agency->id); ?>"
                            <?php echo e(in_array($agency->id, session('agency_ids', [])) ? 'selected' : ''); ?>>
                            <?php echo e($agency->agency_name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

        </div>
      </li>
    </ul>
    <?php endif; ?>

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
          <img src="<?php echo e(auth()->user()->profile
                                ? asset('storage/' . auth()->user()->profile)
                                : asset('assets/images/default-profile.png')); ?>" alt="profile"/>
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
          <a class="dropdown-item" href="<?php echo e(route('profile.index')); ?>">
            <i class="ti-user text-primary"></i> Profile
          </a>
          <a class="dropdown-item" href="<?php echo e(route('logout')); ?>">
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
            url: "<?php echo e(route('set.agency')); ?>",
            type: "POST",
            data: {
                agency_ids: agencyIds,
                _token: "<?php echo e(csrf_token()); ?>"
            },
            success: function () {
                location.reload();
            }
        });
    });
});
</script>
<?php /**PATH C:\xampp\htdocs\lead-bridge\resources\views/includes/header.blade.php ENDPATH**/ ?>