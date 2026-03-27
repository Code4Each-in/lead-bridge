@extends('layout')
@section('title', ' Users')
@section('subtitle', 'Users')
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
                        <h4 class="card-title">Users</h4>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#createModal">
                            Add User
                        </button>
                    </div>

                    <!-- Success -->
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <!-- Table -->
                    <div class="table-responsive">
                        <table id="usersTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Address</th>
                                    <th>Status</th>
                                    <th width="180">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->role->name ?? 'N/A' }}</td>
                                    <td>
                                        {{ collect([
                                            $user->address,
                                            $user->city,
                                            $user->state,
                                            $user->zip
                                        ])->filter()->implode(', ') }}
                                    </td>
                                    <td>
                                        <div class="custom-control custom-switch">
                                            <input
                                                type="checkbox"
                                                class="custom-control-input toggle-status"
                                                id="status_{{ $user->id }}"
                                                data-id="{{ $user->id }}"
                                                data-url="{{ route('users.toggleStatus', $user->id) }}"
                                                {{ $user->status ? 'checked' : '' }}
                                            >
                                            <label class="custom-control-label" for="status_{{ $user->id }}"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-info"
                                            data-toggle="modal"
                                            data-target="#editModal{{ $user->id }}">
                                            <i class="mdi mdi-pencil-box"></i> Edit
                                        </button>
                                        <a href="{{ route('users.delete', $user->id) }}"
                                            class="btn btn-sm btn-danger btn-delete"
                                            data-id="{{ $user->id }}">
                                            <i class="mdi mdi-delete"></i> Delete
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

<!-- Create User Modal -->
<div class="modal fade" id="createModal">
    <div class="modal-dialog modal-lg">
        <form  id="createUserForm" method="POST" class="forms-sample" action="{{ route('users.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Add User</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label class="required-label">Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Name" >
                    </div>

                    <div class="form-group">
                        <label class="required-label">Email address</label>
                        <input type="email" name="email" class="form-control" placeholder="Email" >
                    </div>

                    <div class="form-group">
                        <label class="required-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Password" >
                    </div>

                    <div class="form-group">
                        <label class="required-label">Role</label>
                        <select name="role_id" class="form-control">
                            <option value="">Select Role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="required-label">Status</label>
                        <select name="status" class="form-control">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="required-label">Date of Birth</label>
                        <input type="date" name="date_of_birth" class="form-control">
                    </div>

                    <div class="form-group">
                        <label class="required-label">City</label>
                        <input type="text" name="city" class="form-control" placeholder="Location">
                    </div>

                    <div class="form-group">
                        <label class="required-label">State</label>
                        <input type="text" name="state" class="form-control" placeholder="State">
                    </div>

                    <div class="form-group">
                        <label class="required-label">Zip</label>
                        <input type="text" name="zip" class="form-control" placeholder="Zip">
                    </div>

                    <div class="form-group">
                        <label>Profile</label>
                        <div class="input-group">
                            <input type="file" id="profileInput" name="profile" style="display: none;">
                            <input type="text" class="form-control file-upload-info" id="fileName" placeholder="Upload Image" readonly>
                            <span class="input-group-append">
                                <button class="file-upload-browse btn btn-primary" type="button"
                                    onclick="document.getElementById('profileInput').click();">
                                    Upload
                                </button>
                            </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="required-label">Address</label>
                        <textarea name="address" class="form-control" rows="4"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary">Save User</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!--Edit Modals  -->
@foreach($users as $user)
<div class="modal fade" id="editModal{{ $user->id }}">
    <div class="modal-dialog modal-lg">
        <form class="editUserForm" data-id="{{ $user->id }}" method="POST" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Edit User</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label class="required-label">Name</label>
                        <input type="text" name="name" value="{{ $user->name }}" class="form-control" placeholder="Name" >
                    </div>

                    <div class="form-group">
                        <label class="required-label">Email address</label>
                        <input type="email" name="email" value="{{ $user->email }}" class="form-control" placeholder="Email" >
                    </div>

                    <div class="form-group">
                        <label>Password <small class="text-muted">(leave blank to keep old)</small></label>
                        <input type="password" name="password" class="form-control" placeholder="Password">
                    </div>

                    <div class="form-group">
                        <label class="required-label">Role</label>
                        <select name="role_id" class="form-control">
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="required-label">Status</label>
                        <select name="status" class="form-control">
                            <option value="1" {{ $user->status == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ $user->status == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="required-label">Date of Birth</label>
                        <input type="date" name="date_of_birth" value="{{ $user->date_of_birth }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label class="required-label">City</label>
                        <input type="text" name="city" value="{{ $user->city }}" class="form-control" placeholder="Location">
                    </div>

                    <div class="form-group">
                        <label class="required-label">State</label>
                        <input type="text" name="state" value="{{ $user->state }}" class="form-control" placeholder="State">
                    </div>

                    <div class="form-group">
                        <label class="required-label">Zip</label>
                        <input type="text" name="zip" value="{{ $user->zip }}" class="form-control" placeholder="Zip">
                    </div>

                    <div class="form-group">
                        <label>Profile</label>
                        <div class="input-group">
                            <input type="file" id="profileInput_{{ $user->id }}" name="profile" style="display: none;">
                            <input type="text" class="form-control file-upload-info"
                                   id="fileName_{{ $user->id }}"
                                   placeholder="Upload Image" readonly>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-primary"
                                    onclick="document.getElementById('profileInput_{{ $user->id }}').click();">
                                    Upload
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="required-label">Address</label>
                        <textarea name="address" class="form-control" rows="4">{{ $user->address }}</textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-success">Update</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endforeach

<script>
function waitForJQuery(callback) {
    if (typeof $ !== 'undefined') {
        callback();
    } else {
        setTimeout(function () { waitForJQuery(callback); }, 50);
    }
}

waitForJQuery(function () {

    // File input display
    $(document).on('change', 'input[type="file"]', function () {
        let id = this.id.replace('profileInput', 'fileName');
        let fileInput = document.getElementById(id);
        if (fileInput && this.files.length > 0) {
            fileInput.value = this.files[0].name;
        }
    });

    // Clear errors
    function clearErrors(modal) {
        $(modal).find('.is-invalid').removeClass('is-invalid');
        $(modal).find('.invalid-feedback').remove();
    }

    // Show Laravel errors in modal
    function showErrors(modal, errors) {
        $.each(errors, function (field, messages) {
            const el = $(modal).find('[name="' + field + '"]');
            el.addClass('is-invalid');
            el.after('<div class="invalid-feedback">' + messages[0] + '</div>');
        });
    }

    // CREATE modal — clear on open
    $('#createModal').on('show.bs.modal', function () {
        clearErrors(this);
        $(this).find('input:not([type="hidden"])').val('');
        $(this).find('textarea').val('');
        $(this).find('select').prop('selectedIndex', 0);
        $(this).find('.file-upload-info').val('');
    });

    // EDIT modals — clear errors + store originals on open
    $('[id^="editModal"]').on('show.bs.modal', function () {
        clearErrors(this);
        $(this).find('input:not([type="hidden"]), textarea, select').each(function () {
            $(this).data('orig', $(this).val());
        });
    });

    // EDIT modals — restore if not submitted
    $('[id^="editModal"]').on('hide.bs.modal', function () {
        if (!$(this).data('submitted')) {
            $(this).find('input:not([type="hidden"]), textarea, select').each(function () {
                $(this).val($(this).data('orig') || '');
            });
            $(this).find('.file-upload-info').val('');
            clearErrors(this);
        }
        $(this).data('submitted', false);
    });

    // CREATE FORM AJAX SUBMIT
    $('#createUserForm').on('submit', function (e) {
        e.preventDefault();
        clearErrors(this);

        const form = this;
        const formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (res) {
                if (res.success) {
                    $('#createModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Created!',
                        text: res.success,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(function () {
                        location.reload();
                    });
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    showErrors(form, xhr.responseJSON.errors);
                }
            }
        });
    });

    // EDIT FORM AJAX SUBMIT
    $(document).on('submit', '.editUserForm', function (e) {
        e.preventDefault();
        const modal = $(this).closest('.modal');
        clearErrors(modal);

        const form = this;
        const formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (res) {
                if (res.success) {
                    modal.data('submitted', true);
                    modal.modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Updated!',
                        text: res.success,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(function () {
                        location.reload();
                    });
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    showErrors(form, xhr.responseJSON.errors);
                }
            }
        });
    });

    // DELETE WITH SWAL CONFIRMATION
    $(document).on('click', '.btn-delete', function (e) {
        e.preventDefault();
        const url = $(this).attr('href');

        Swal.fire({
            title: 'Are you sure?',
            text: 'This user will be permanently deleted!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then(function (result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function (res) {
                        if (res.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: res.success,
                                timer: 1500,
                                showConfirmButton: false
                            }).then(function () {
                                location.reload();
                            });
                        }
                    },
                    error: function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Something went wrong. Please try again.'
                        });
                    }
                });
            }
        });
    });
    // TOGGLE STATUS
    $(document).on('change', '.toggle-status', function () {
        const checkbox = $(this);
        const url = checkbox.data('url');

        $.ajax({
            url: url,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function (res) {
                Swal.fire({
                    icon: 'success',
                    title: res.status ? 'Activated!' : 'Deactivated!',
                    text: res.message,
                    timer: 1200,
                    showConfirmButton: false
                });
            },
            error: function () {
                checkbox.prop('checked', !checkbox.prop('checked'));
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Could not update status.'
                });
            }
        });
    });
});

</script>

@endsection
