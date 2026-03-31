@extends('layout')
@section('title', 'Leads')
@section('subtitle', 'Leads')
@section('content')
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

</style>

@php
    $isAdminOrSuper = in_array(strtolower($authUser->role->name), ['super admin', 'admin']);
@endphp

<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="card">
            <div class="card-body">

                <div class="d-flex justify-content-between mb-3">
                    <h4 class="card-title">Leads</h4>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#createModal">
                        Add Lead
                    </button>
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
                            @foreach($leads as $lead)
                            <tr>
                                <td>{{ $lead->name }}</td>
                                <td>{{ $lead->company }}</td>
                                <td>{{ $lead->agency->agency_name ?? '-' }}</td>
                                <td>
                                    @forelse($lead->users as $user)
                                        <span class="badge badge-light border" style="font-size:12px; padding:4px 8px; margin:1px 2px; display:inline-block;">
                                            {{ $user->name }}
                                        </span>
                                    @empty
                                        <span class="text-muted">-</span>
                                    @endforelse
                                </td>
                                <td>
                                    @php
                                        $badgeClass = match($lead->status) {
                                            'New'         => 'badge-primary',
                                            'In Progress' => 'badge-warning',
                                            'Closed'      => 'badge-success',
                                            default       => 'badge-secondary',
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">{{ $lead->status }}</span>
                                </td>
                                <td>{{ $lead->source }}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary edit-lead-btn"
                                            data-toggle="modal"
                                            data-target="#editModal{{ $lead->id }}">
                                        <i class="mdi mdi-pencil-box"></i> Edit
                                    </button>
                                    <a href="{{ route('leads.delete', $lead->id) }}"
                                       class="btn btn-sm btn-danger btn-delete">
                                        <i class="mdi mdi-trash-can"></i> Delete
                                    </a>
                                </td>
                            </tr>
                            @endforeach
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
        <form id="createLeadForm" enctype="multipart/form-data">
            @csrf
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
                        {{-- Status: full-width for user role, 4-col for admin --}}
                        <div class="col-md-{{ $isAdminOrSuper ? '4' : '12' }}">
                            <div class="form-group">
                                <label class="required-label">Status</label>
                                <select name="status" class="form-control">
                                    <option value="New">New</option>
                                    <option value="In Progress">In Progress</option>
                                    <option value="Closed">Closed</option>
                                </select>
                            </div>
                        </div>

                        @if($isAdminOrSuper)
                            {{-- Agency (admin/super admin only) --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="required-label">Agency</label>
                                    <select name="agency_id"
                                            id="create_agency_select"
                                            class="form-control agency-select">
                                        <option value="">--Select Agency--</option>
                                        @foreach($agencies as $agency)
                                            <option value="{{ $agency->id }}">{{ $agency->agency_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Assign User (populated by agency change) --}}
                            <div class="col-md-4">
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
                        @else
                            {{-- Hidden agency for user role (auto-filled server-side) --}}
                            {{-- No agency input shown; agency_id injected in controller --}}

                            {{-- Assign User: pre-loaded with same-agency users --}}
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="required-label">Assign User</label>
                                    <select name="assigned_user_id[]"
                                            id="create_user_select"
                                            class="form-control user-select"
                                            multiple>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
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
@foreach($leads as $lead)
<div class="modal fade" id="editModal{{ $lead->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form class="editLeadForm"
              data-id="{{ $lead->id }}"
              data-url="{{ route('leads.update', $lead->id) }}"
              enctype="multipart/form-data">
            @csrf
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
                                <input type="text" name="name" value="{{ $lead->name }}" class="form-control" placeholder="Full Name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="required-label">Phone</label>
                                <input type="text" name="phone" value="{{ $lead->phone }}" class="form-control" placeholder="Phone">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="required-label">Email</label>
                                <input type="email" name="email" value="{{ $lead->email }}" class="form-control" placeholder="Email">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="required-label">Company</label>
                                <input type="text" name="company" value="{{ $lead->company }}" class="form-control" placeholder="Company">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="required-label">City</label>
                                <input type="text" name="city" value="{{ $lead->city }}" class="form-control" placeholder="City">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="required-label">Source</label>
                                <input type="text" name="source" value="{{ $lead->source }}" class="form-control" placeholder="Source">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-{{ $isAdminOrSuper ? '4' : '12' }}">
                            <div class="form-group">
                                <label class="required-label">Status</label>
                                <select name="status" class="form-control">
                                    <option value="New"         {{ $lead->status == 'New'         ? 'selected' : '' }}>New</option>
                                    <option value="In Progress" {{ $lead->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="Closed"      {{ $lead->status == 'Closed'      ? 'selected' : '' }}>Closed</option>
                                </select>
                            </div>
                        </div>

                        @if($isAdminOrSuper)
                            {{-- Agency (admin/super admin only) --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="required-label">Agency</label>
                                    <select name="agency_id"
                                            class="form-control agency-select"
                                            data-user-target="edit_user_{{ $lead->id }}"
                                            data-selected-users="{{ json_encode($lead->users->pluck('id')->toArray()) }}">
                                        <option value="">-- Select Agency --</option>
                                        @foreach($agencies as $agency)
                                            <option value="{{ $agency->id }}"
                                                    {{ $lead->agency_id == $agency->id ? 'selected' : '' }}>
                                                {{ $agency->agency_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Assigned users (admin/super admin) --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="required-label">Assign User</label>
                                    @php $selectedUserIds = $lead->users->pluck('id')->toArray(); @endphp
                                    <select name="assigned_user_id[]"
                                            id="edit_user_{{ $lead->id }}"
                                            class="form-control user-select"
                                            multiple>
                                        @foreach($users->where('agency_id', $lead->agency_id) as $user)
                                            <option value="{{ $user->id }}"
                                                    {{ in_array($user->id, $selectedUserIds) ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @else
                            {{-- User role: show same-agency users, pre-select existing --}}
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="required-label">Assign User</label>
                                    @php $selectedUserIds = $lead->users->pluck('id')->toArray(); @endphp
                                    <select name="assigned_user_id[]"
                                            id="edit_user_{{ $lead->id }}"
                                            class="form-control user-select"
                                            multiple>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}"
                                                    {{ in_array($user->id, $selectedUserIds) ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label class="required-label">Notes</label>
                        <textarea name="notes" class="form-control" rows="3" placeholder="Notes">{{ $lead->notes }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Document</label>
                        @if($lead->documents)
                            <div class="mb-1">
                                <small class="text-muted">
                                    Current: <a href="{{ asset('storage/' . $lead->documents) }}" target="_blank">View File</a>
                                </small>
                            </div>
                        @endif
                        <div class="input-group">
                            <input type="file" id="documentInput_{{ $lead->id }}" name="documents" style="display: none;">
                            <input type="text" class="form-control file-upload-info"
                                id="documentName_{{ $lead->id }}"
                                placeholder="Upload Document" readonly>
                            <span class="input-group-append">
                                <button class="file-upload-browse btn btn-primary" type="button"
                                    onclick="document.getElementById('documentInput_{{ $lead->id }}').click();">
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
@endforeach

<script>

const ALL_USERS = {!! json_encode($users->map(function($u) {
    return ['id' => $u->id, 'name' => $u->name, 'agency_id' => $u->agency_id];
})) !!};

const IS_ADMIN_OR_SUPER = {{ $isAdminOrSuper ? 'true' : 'false' }};
</script>

<script>
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

    $('#createLeadForm').on('submit', function (e) {
        e.preventDefault();

        const $form = $(this);
        const $btn  = $('#createSubmitBtn');
        clearErrors($form);

        $btn.prop('disabled', true).text('Saving…');

        $.ajax({
            url        : '{{ route("leads.store") }}',
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

@endsection
