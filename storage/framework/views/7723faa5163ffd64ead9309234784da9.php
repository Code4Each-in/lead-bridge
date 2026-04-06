<?php $__env->startSection('title', 'Leads'); ?>
<?php $__env->startSection('subtitle', 'Leads'); ?>
<?php $__env->startSection('content'); ?>
<style>

    .required-label::after {
        content: ' *';
        color: red;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
    font-size: 13px !important;
    padding: 4px 4px !important;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
    padding: 5px !important;
    padding-left: 20px !important;

    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice__display {
        font-size: 12px !important;
    }
    .select2-container--default.select2-container--disabled .select2-selection--multiple {
        background-color: #ffffff !important;
        padding: 11px !important;
        border: 1px solid #ced4da   !important;
    }
    .select2-container--default .select2-search--inline .select2-search__field {
        font-size: 14px !important;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__clear{
        margin-top: 1px !important;
        color: #ced4da;
    }
    .lead-status-simple {
        padding: 4px 8px;
        font-size: 13px;
        border: 1px solid #ccc;
        border-radius: 4px;
        background: #fff;
        outline: none;
        cursor: pointer;
    }

    .lead-status-simple:focus {
        border-color: #999;
    }
</style>

<?php
    $isAdminOrSuper = in_array(strtolower($authUser->role->name), ['super admin']);
?>

<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="card">
            <div class="card-body">

                <div class="d-flex justify-content-between mb-3 align-items-center">
                    <h4 class="card-title mb-0">Leads</h4>

                    <div class="d-flex">
                        <button class="btn btn-primary mr-3" data-toggle="modal" data-target="#createModal">
                            Add Lead
                        </button>

                        <form id="uploadExcelForm" action="<?php echo e(route('import')); ?>" method="POST" enctype="multipart/form-data" class="mb-0 mr-3">
                            <?php echo csrf_field(); ?>
                            <input
                                type="file"
                                name="file"
                                accept=".xls,.xlsx"
                                style="display: none;"
                                id="excelFileInput"
                            >
                            <button type="button" class="btn btn-secondary" id="selectExcelBtn">Upload Excel</button>
                        </form>

                        <a href="<?php echo e(route('leads.template')); ?>" class="btn btn-info">Download Template</a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Company</th>
                                <th>Agency</th>
                                <th>Assigned To</th>
                                <th>Status</th>
                                <th>Source</th>
                                <th width="150">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $leads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lead): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($lead->name); ?></td>
                                <td><?php echo e($lead->company); ?></td>
                                <td><?php echo e($lead->agency->agency_name ?? '-'); ?></td>
                                <td>
                                    <?php $__empty_1 = true; $__currentLoopData = $lead->users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <span class="badge badge-light border" style="font-size:12px; padding:4px 8px; margin:1px 2px; display:inline-block;">
                                            <?php echo e($user->name); ?>

                                        </span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <select class="lead-status-simple" data-lead-id="<?php echo e($lead->id); ?>">
                                        <?php
                                            $statuses = ['Not Started', 'In Progress', 'Hold', 'Lost', 'Complete'];
                                        ?>
                                        <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($status); ?>" <?php echo e($lead->status == $status ? 'selected' : ''); ?>>
                                                <?php echo e($status); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </td>
                                <td><?php echo e($lead->source); ?></td>
                                <td>
                                    <button class="btn btn-sm btn-primary edit-lead-btn"
                                            data-toggle="modal"
                                            data-target="#editModal<?php echo e($lead->id); ?>">
                                        <i class="mdi mdi-pencil-box"></i> Edit
                                    </button>
                                    <a href="<?php echo e(route('leads.delete', $lead->id)); ?>"
                                       class="btn btn-sm btn-danger btn-delete">
                                        <i class="mdi mdi-trash-can"></i> Delete
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<!--  CREATE MODAL = -->
<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form id="createLeadForm"   method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Lead</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="required-label">Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Full Name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="required-label">Phone</label>
                                <input type="text" name="phone" class="form-control" placeholder="Phone">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="required-label">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Email">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="required-label">Company</label>
                                <input type="text" name="company" class="form-control" placeholder="Company">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="required-label">City</label>
                                <input type="text" name="city" class="form-control" placeholder="City">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="required-label">Source</label>
                                <input type="text" name="source" class="form-control" placeholder="Source">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <?php if($isAdminOrSuper): ?>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="required-label">Agency</label>
                                    <select name="agency_id"
                                            id="create_agency_select"
                                            class="form-control agency-select">
                                        <option value="">--Select Agency--</option>
                                        <?php $__currentLoopData = $agencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($agency->id); ?>"><?php echo e($agency->agency_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>

                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="required-label">Assign User</label>
                                    <select name="assigned_user_id[]"
                                            id="create_user_select"
                                            class="form-control user-select"
                                            multiple>
                                        <option value="">-- Select Agency First --</option>
                                    </select>
                                </div>
                            </div>
                        <?php else: ?>
                            
                            

                            
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="required-label">Assign User</label>
                                    <select name="assigned_user_id[]"
                                            id="create_user_select"
                                            class="form-control user-select"
                                            multiple>
                                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label class="required-label">Notes</label>
                        <textarea name="notes" class="form-control" rows="3" placeholder="Notes"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Document</label>
                        <div class="input-group">
                            <input type="file" id="documentInput_create" name="documents" style="display: none;">
                            <input type="text" class="form-control file-upload-info" id="documentName_create"
                                placeholder="Upload Document" readonly>
                            <span class="input-group-append">
                                <button class="file-upload-browse btn btn-primary" type="button"
                                    onclick="document.getElementById('documentInput_create').click();">
                                    Upload
                                </button>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="createSubmitBtn">Save Lead</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!--  EDIT MODALS = -->
<?php $__currentLoopData = $leads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lead): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="modal fade" id="editModal<?php echo e($lead->id); ?>" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form class="editLeadForm"
              data-id="<?php echo e($lead->id); ?>"
              data-url="<?php echo e(route('leads.update', $lead->id)); ?>"
              enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Lead</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="required-label">Name</label>
                                <input type="text" name="name" value="<?php echo e($lead->name); ?>" class="form-control" placeholder="Full Name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="required-label">Phone</label>
                                <input type="text" name="phone" value="<?php echo e($lead->phone); ?>" class="form-control" placeholder="Phone">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="required-label">Email</label>
                                <input type="email" name="email" value="<?php echo e($lead->email); ?>" class="form-control" placeholder="Email">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="required-label">Company</label>
                                <input type="text" name="company" value="<?php echo e($lead->company); ?>" class="form-control" placeholder="Company">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="required-label">City</label>
                                <input type="text" name="city" value="<?php echo e($lead->city); ?>" class="form-control" placeholder="City">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="required-label">Source</label>
                                <input type="text" name="source" value="<?php echo e($lead->source); ?>" class="form-control" placeholder="Source">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-<?php echo e($isAdminOrSuper ? '4' : '12'); ?>">
                            <div class="form-group">
                                <label class="required-label">Status</label>
                                    <select name="status" class="form-control">
                                        <?php
                                            $statuses = ['Not Started', 'In Progress', 'Hold', 'Lost', 'Complete'];
                                        ?>
                                        <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($status); ?>" <?php echo e($lead->status == $status ? 'selected' : ''); ?>>
                                                <?php echo e($status); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                            </div>
                        </div>

                        <?php if($isAdminOrSuper): ?>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="required-label">Agency</label>
                                    <select name="agency_id"
                                            class="form-control agency-select"
                                            data-user-target="edit_user_<?php echo e($lead->id); ?>"
                                            data-selected-users="<?php echo e(json_encode($lead->users->pluck('id')->toArray())); ?>">
                                        <option value="">-- Select Agency --</option>
                                        <?php $__currentLoopData = $agencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($agency->id); ?>"
                                                    <?php echo e($lead->agency_id == $agency->id ? 'selected' : ''); ?>>
                                                <?php echo e($agency->agency_name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>

                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="required-label">Assign User</label>
                                    <?php $selectedUserIds = $lead->users->pluck('id')->toArray(); ?>
                                    <select name="assigned_user_id[]"
                                            id="edit_user_<?php echo e($lead->id); ?>"
                                            class="form-control user-select"
                                            multiple>
                                        <?php $__currentLoopData = $users->where('agency_id', $lead->agency_id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($user->id); ?>"
                                                    <?php echo e(in_array($user->id, $selectedUserIds) ? 'selected' : ''); ?>>
                                                <?php echo e($user->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                        <?php else: ?>
                            
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="required-label">Assign User</label>
                                    <?php $selectedUserIds = $lead->users->pluck('id')->toArray(); ?>
                                    <select name="assigned_user_id[]"
                                            id="edit_user_<?php echo e($lead->id); ?>"
                                            class="form-control user-select"
                                            multiple>
                                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($user->id); ?>"
                                                    <?php echo e(in_array($user->id, $selectedUserIds) ? 'selected' : ''); ?>>
                                                <?php echo e($user->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label class="required-label">Notes</label>
                        <textarea name="notes" class="form-control" rows="3" placeholder="Notes"><?php echo e($lead->notes); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label>Document</label>
                        <?php if($lead->documents): ?>
                            <div class="mb-1">
                                <small class="text-muted">
                                    Current: <a href="<?php echo e(asset('storage/' . $lead->documents)); ?>" target="_blank">View File</a>
                                </small>
                            </div>
                        <?php endif; ?>
                        <div class="input-group">
                            <input type="file" id="documentInput_<?php echo e($lead->id); ?>" name="documents" style="display: none;">
                            <input type="text" class="form-control file-upload-info"
                                id="documentName_<?php echo e($lead->id); ?>"
                                placeholder="Upload Document" readonly>
                            <span class="input-group-append">
                                <button class="file-upload-browse btn btn-primary" type="button"
                                    onclick="document.getElementById('documentInput_<?php echo e($lead->id); ?>').click();">
                                    Upload
                                </button>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Update</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<script>

const ALL_USERS = <?php echo json_encode($users->map(function($u) {
    return ['id' => $u->id, 'name' => $u->name, 'agency_id' => $u->agency_id];
})); ?>;

const IS_ADMIN_OR_SUPER = <?php echo e($isAdminOrSuper ? 'true' : 'false'); ?>;
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('excelFileInput');
        const selectBtn = document.getElementById('selectExcelBtn');
        const form = document.getElementById('uploadExcelForm');

        // When the user clicks the button, open file select
        selectBtn.addEventListener('click', function() {
            fileInput.click();
        });

        // When a file is selected, auto-submit the form
        fileInput.addEventListener('change', function() {
            if (fileInput.files.length > 0) {
                form.submit();
            }
        });
    });
(function waitForJQ() {
    if (typeof $ === 'undefined') { setTimeout(waitForJQ, 50); return; }

    // Initialize Select2 on all user selects for user-role (no agency dependency)
    if (!IS_ADMIN_OR_SUPER) {
        $('#create_user_select').select2({
            width: '100%',
            dropdownParent: $('#createModal'),
            placeholder: 'Select users...',
            allowClear: true
        });

        $('.user-select').each(function () {
            const $sel    = $(this);
            const $modal  = $sel.closest('.modal');
            $sel.select2({
                width: '100%',
                dropdownParent: $modal.length ? $modal : $(document.body),
                placeholder: 'Select users...',
                allowClear: true
            });
        });
    }

    function populateUsers(targetId, agencyId, selectedIds) {
        const $sel    = $('#' + targetId);
        const selected = (selectedIds || []).map(String);

        if ($sel.hasClass('select2-hidden-accessible')) {
            $sel.select2('destroy');
        }

        $sel.empty();

        if (!agencyId) {
            $sel.append('<option value="">-- Please select an Agency first --</option>');
            $sel.prop('disabled', true);
            $sel.select2({
                width: '100%',
                placeholder: '-- Please select an Agency first --',
                allowClear: false
            });
            return;
        }

        const filtered = ALL_USERS.filter(u => String(u.agency_id) === String(agencyId));

        if (filtered.length) {
            $sel.append('<option value="">-- Select users --</option>');
            filtered.forEach(function (u) {
                const isSelected = selected.includes(String(u.id)) ? 'selected' : '';
                $sel.append(`<option value="${u.id}" ${isSelected}>${u.name}</option>`);
            });
            $sel.prop('disabled', false);
        } else {
            $sel.append('<option value="" disabled>No users in this agency</option>');
            $sel.prop('disabled', true);
        }

        const $parentModal = $sel.closest('.modal');

        $sel.select2({
            width: '100%',
            dropdownParent: $parentModal.length ? $parentModal : $(document.body),
            placeholder: '-- Select users --',
            allowClear: true
        });

        if (selected.length) {
            $sel.val(selected).trigger('change');
        }
    }
    document.querySelectorAll('.lead-status').forEach(function(select){
        function updateBadgeColor(el) {
            const status = el.value;
            let colorClass;
            switch(status){
                case 'Not Started': colorClass = 'badge-secondary'; break;
                case 'In Progress': colorClass = 'badge-warning'; break;
                case 'Hold':        colorClass = 'badge-info'; break;
                case 'Lost':        colorClass = 'badge-danger'; break;
                case 'Complete':    colorClass = 'badge-success'; break;
                default:            colorClass = 'badge-secondary';
            }
            el.className = 'form-control lead-status ' + colorClass;
        }

        updateBadgeColor(select);

        select.addEventListener('change', function(){
            updateBadgeColor(this);
            const leadId = this.dataset.leadId;
            const status = this.value;

            fetch(`/leads/${leadId}/status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                },
                body: JSON.stringify({status: status})
            })
            .then(res => res.json())
            .then(data => console.log(data.success))
            .catch(err => console.error(err));
        });
    });
    // Agency change handler (only fires for admin/super admin)
    $(document).on('change', '.agency-select', function () {
        const agencyId = $(this).val();

        if ($(this).attr('id') === 'create_agency_select') {
            populateUsers('create_user_select', agencyId, []);
        } else {
            const targetId    = $(this).data('user-target');
            const selectedIds = $(this).data('selected-users') || [];
            populateUsers(targetId, agencyId, selectedIds);
        }
    });

    // Create modal open
    $('#createModal').on('show.bs.modal', function () {
        const $form = $(this).find('#createLeadForm');
        $form[0].reset();

        if (IS_ADMIN_OR_SUPER) {
            $('#create_agency_select').val('').trigger('change');
            $('#create_user_select')
                .empty()
                .append('<option value="">-- Select Agency First --</option>')
                .val(null)
                .trigger('change')
                .prop('disabled', true);
        } else {
            // For user role, re-init Select2 and clear selection
            const $userSel = $('#create_user_select');
            if ($userSel.hasClass('select2-hidden-accessible')) {
                $userSel.select2('destroy');
            }
            $userSel.val(null).select2({
                width: '100%',
                dropdownParent: $(this),
                placeholder: 'Select users...',
                allowClear: true
            });
        }

        $form.find('.is-invalid').removeClass('is-invalid');
        $form.find('.invalid-feedback').remove();
    });

    // Edit modal open
    $('.modal').on('show.bs.modal', function () {
        const $modal = $(this);
        if ($modal.attr('id') === 'createModal') return;

        const $form = $modal.find('.editLeadForm');
        if (!$form.length) return;

        $form.find('.is-invalid').removeClass('is-invalid');
        $form.find('.invalid-feedback').remove();

        if (IS_ADMIN_OR_SUPER) {
            $modal.find('.agency-select').each(function () {
                $(this).trigger('change');
            });
            $modal.find('.user-select').each(function () {
                $(this).val($(this).val()).trigger('change');
            });
        }
    });

    $('.modal').on('shown.bs.modal', function () {
        $(this).find('.select2').css('width', '100%');
    });

    function clearErrors($form) {
        $form.find('.is-invalid').removeClass('is-invalid');
        $form.find('.invalid-feedback').remove();
    }

    function showErrors($form, errors) {
        $.each(errors, function (field, messages) {
            const baseName = field.split('.')[0];
            const $input   = $form.find('[name="' + baseName + '"], [name="' + baseName + '[]"]').first();
            if ($input.length) {
                $input.addClass('is-invalid');
                $input.closest('.form-group')
                      .append(`<div class="invalid-feedback d-block">${messages[0]}</div>`);
            }
        });
    }

    $(document).on('submit', '#createLeadForm', function(e) {
        e.preventDefault();

        const $form = $(this);
        const $btn  = $('#createSubmitBtn');
        clearErrors($form);

        $btn.prop('disabled', true).text('Saving…');

        $.ajax({
            url        : '<?php echo e(route("leads.store")); ?>',
            method     : 'POST',
            data       : new FormData($form[0]),
            processData: false,
            contentType: false,
            success: function (res) {
                if (res.success) {
                    $('#createModal').modal('hide');
                    Swal.fire({
                        icon : 'success',
                        title: 'Created!',
                        text : res.success,
                        timer: 1500,
                        showConfirmButton: false,
                    }).then(() => location.reload());
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    showErrors($form, xhr.responseJSON.errors);
                } else {
                    Swal.fire('Error', 'Something went wrong. Please try again.', 'error');
                }
            },
            complete: function () {
                $btn.prop('disabled', false).text('Save Lead');
            },
        });
    });

    $(document).on('submit', '.editLeadForm', function (e) {
        e.preventDefault();

        const $form  = $(this);
        const url    = $form.data('url');
        const $btn   = $form.find('[type="submit"]');
        clearErrors($form);

        $btn.prop('disabled', true).text('Updating…');

        $.ajax({
            url        : url,
            method     : 'POST',
            data       : new FormData($form[0]),
            processData: false,
            contentType: false,
            success: function (res) {
                if (res.success) {
                    $form.closest('.modal').modal('hide');
                    Swal.fire({
                        icon : 'success',
                        title: 'Updated!',
                        text : res.success,
                        timer: 1500,
                        showConfirmButton: false,
                    }).then(() => location.reload());
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    showErrors($form, xhr.responseJSON.errors);
                } else {
                    Swal.fire('Error', 'Something went wrong. Please try again.', 'error');
                }
            },
            complete: function () {
                $btn.prop('disabled', false).text('Update');
            },
        });
    });

    $(document).on('click', '.btn-delete', function (e) {
        e.preventDefault();
        const url = $(this).attr('href');

        Swal.fire({
            title             : 'Are you sure?',
            text              : 'This lead will be permanently deleted!',
            icon              : 'warning',
            showCancelButton  : true,
            confirmButtonColor: '#d33',
            cancelButtonColor : '#6c757d',
            confirmButtonText : 'Yes, delete it!',
        }).then(function (result) {
            if (result.isConfirmed) {
                $.ajax({
                    url    : url,
                    method : 'GET',
                    success: function (res) {
                        if (res.success) {
                            Swal.fire({
                                icon : 'success',
                                title: 'Deleted!',
                                text : res.success,
                                timer: 1500,
                                showConfirmButton: false,
                            }).then(() => location.reload());
                        }
                    },
                    error: function () {
                        Swal.fire('Error', 'Could not delete this lead.', 'error');
                    },
                });
            }
        });
    });

    $(document).on('change', 'input[type="file"]', function () {
        const id = this.id.replace('documentInput_', 'documentName_');
        const nameField = document.getElementById(id);
        if (nameField && this.files.length > 0) {
            nameField.value = this.files[0].name;
        }
    });

})();

</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let htmlContent = '';

    // 1️⃣ Laravel validation errors
    <?php if($errors->any()): ?>
        htmlContent += '<b>Validation Errors:</b><ul>';
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            htmlContent += `<li><?php echo e($error); ?></li>`;
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        htmlContent += '</ul><br>';
    <?php endif; ?>

    // 2️⃣ Session error
    <?php if(session('error')): ?>
        htmlContent += `<b>Error:</b> <?php echo e(session('error')); ?><br><br>`;
    <?php endif; ?>

    // 3️⃣ Success message + failed rows
    <?php if(session('success')): ?>
        htmlContent += `<b><?php echo e(session('success')); ?></b><br><br>`;
        const failedRows = <?php echo json_encode(session('failedRows', []), 512) ?>;
        if(failedRows.length > 0) {
            htmlContent += '<b>Failed Rows:</b><ul>';
            failedRows.forEach(function(fail) {
                htmlContent += `<li>Row ${fail.row_number || 'N/A'}: ${fail.reason || 'Unknown error'}</li>`;
            });
            htmlContent += '</ul>';
        }
    <?php endif; ?>

    // 4️⃣ Show Swal only if there is content
    if(htmlContent.length > 0) {
        Swal.fire({
            icon: htmlContent.includes('Validation Errors') || htmlContent.includes('Error') ? 'error' : 'success',
            title: 'Upload Result',
            html: htmlContent,
            width: 600
        });
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\lead-bridge\resources\views/leads/index.blade.php ENDPATH**/ ?>