@extends('layout')
@section('title', 'Leads')
@section('subtitle', 'Leads')
@section('content')
<style>
    .required-label::after {
        content: ' *';
        color: red;
    }
</style>

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
                                    <button class="btn btn-sm btn-info edit-lead-btn"
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

<!-- create modal -->
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
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="required-label">Status</label>
                                <select name="status" class="form-control">
                                    <option value="New">New</option>
                                    <option value="In Progress">In Progress</option>
                                    <option value="Closed">Closed</option>
                                </select>
                            </div>
                        </div>

                        {{-- Agency (drives user dropdown) --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="required-label">Agency</label>
                                <select name="agency_id"
                                        id="create_agency_select"
                                        class="form-control agency-select">
                                    <option value="">-- Select Agency --</option>
                                    @foreach($agencies as $agency)
                                        <option value="{{ $agency->id }}">{{ $agency->agency_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Assigned user (single, populated by agency) --}}
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
                    </div>

                    <div class="form-group">
                        <label class="required-label">Notes</label>
                        <textarea name="notes" class="form-control" rows="3" placeholder="Notes"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Document</label>
                        <input type="file" name="documents" class="form-control-file">
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

<!-- edit modal -->
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
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="required-label">Status</label>
                                <select name="status" class="form-control">
                                    <option value="New"         {{ $lead->status == 'New'         ? 'selected' : '' }}>New</option>
                                    <option value="In Progress" {{ $lead->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="Closed"      {{ $lead->status == 'Closed'      ? 'selected' : '' }}>Closed</option>
                                </select>
                            </div>
                        </div>

                        {{-- Agency (drives user dropdown) --}}
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

                        {{-- Assigned users (multiple, pre-filled from pivot) --}}
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
                        <input type="file" name="documents" class="form-control-file">
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
</script>

<script>
(function waitForJQ() {
    if (typeof $ === 'undefined') { setTimeout(waitForJQ, 50); return; }


    function initSelect2($el, parentModal = null) {
        if ($el.hasClass('select2-hidden-accessible')) {
            $el.select2('destroy');
        }

        $el.select2({
            width: '100%',
            dropdownParent: parentModal ? parentModal : $(document.body),
            placeholder: 'Select users...',
            allowClear: true
        });
    }


    function populateUsers(targetId, agencyId, selectedIds) {
        const $sel = $('#' + targetId);
        // Normalise to array of strings for easy comparison
        const selected = (selectedIds || []).map(String);

        $sel.empty();

        if (!agencyId) {
            $sel.prop('disabled', true);
        } else {
            const filtered = ALL_USERS.filter(u => String(u.agency_id) === String(agencyId));

            if (filtered.length) {
                filtered.forEach(function (u) {
                    const isSelected = selected.includes(String(u.id)) ? 'selected' : '';
                    $sel.append(`<option value="${u.id}" ${isSelected}>${u.name}</option>`);
                });
                $sel.prop('disabled', false);
            } else {
                $sel.append('<option value="" disabled>No users in this agency</option>');
                $sel.prop('disabled', true);
            }
        }

        // Re-init Select2 after DOM update
        initSelect2($sel);
    }

    $(document).on('change', '.agency-select', function () {
        const agencyId = $(this).val();

        if ($(this).attr('id') === 'create_agency_select') {
            populateUsers('create_user_select', agencyId, []);
        } else {
            const targetId    = $(this).data('user-target');
            // data-selected-users is a JSON array e.g. [1,3]
            const selectedIds = $(this).data('selected-users') || [];
            populateUsers(targetId, agencyId, selectedIds);
        }
    });


    $('#createModal').on('show.bs.modal', function () {
        const $form = $(this).find('#createLeadForm');
        $form[0].reset();

        // Reset Select2 (IMPORTANT)
        $('#create_agency_select').val('').trigger('change');

        $('#create_user_select')
            .empty()
            .append('<option value="">-- Select Agency First --</option>')
            .val(null)
            .trigger('change')
            .prop('disabled', true);

        // Clear validation
        $form.find('.is-invalid').removeClass('is-invalid');
        $form.find('.invalid-feedback').remove();
    });

    $('.modal').on('show.bs.modal', function () {
        const $modal = $(this);

        // Skip create modal (already handled)
        if ($modal.attr('id') === 'createModal') return;

        const $form = $modal.find('.editLeadForm');

        if ($form.length) {

            // Clear old validation
            $form.find('.is-invalid').removeClass('is-invalid');
            $form.find('.invalid-feedback').remove();

            // Re-trigger Select2 values properly
            $modal.find('.agency-select').each(function () {
                $(this).trigger('change');
            });

            $modal.find('.user-select').each(function () {
                const selected = $(this).val();
                $(this).val(selected).trigger('change');
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
            // Handle array fields like "assigned_user_id.0" → "assigned_user_id"
            const baseName = field.split('.')[0];
            const $input   = $form.find('[name="' + baseName + '"], [name="' + baseName + '[]"]').first();

            if ($input.length) {
                $input.addClass('is-invalid');
                // For Select2, mark the hidden original select too
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

})();
</script>

@endsection
