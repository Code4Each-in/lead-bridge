@extends('layout')
@section('title', 'Dashboard')
@section('subtitle', 'Dashboard')
@section('content')

<div class="content-wrapper">
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
                                    <th>Status</th>
                                    <th>Address</th>
                                    <th>Profile</th>
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
                                        @if($user->status)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ collect([
                                            $user->address,
                                            $user->city,
                                            $user->state,
                                            $user->zip
                                        ])->filter()->implode(', ') }}
                                    </td>
                                    <td>
                                        @if($user->profile)
                                            <img src="{{ asset('storage/' . $user->profile) }}" width="40" height="40" style="border-radius:50%;">
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-info"
                                            data-toggle="modal"
                                            data-target="#editModal{{ $user->id }}">
                                            <i class="mdi mdi-pencil-box"></i> Edit
                                        </button>
                                        <a href="{{ route('users.delete', $user->id) }}"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this user?')">
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
</div>

<!-- ==================== Create User Modal ==================== -->
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
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Name" >
                    </div>

                    <div class="form-group">
                        <label>Email address</label>
                        <input type="email" name="email" class="form-control" placeholder="Email" >
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Password" >
                    </div>

                    <div class="form-group">
                        <label>Role</label>
                        <select name="role_id" class="form-control">
                            <option value="">Select Role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Date of Birth</label>
                        <input type="date" name="date_of_birth" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>City</label>
                        <input type="text" name="city" class="form-control" placeholder="Location">
                    </div>

                    <div class="form-group">
                        <label>State</label>
                        <input type="text" name="state" class="form-control" placeholder="State">
                    </div>

                    <div class="form-group">
                        <label>Zip</label>
                        <input type="text" name="zip" class="form-control" placeholder="Zip">
                    </div>

                    <div class="form-group">
                        <label>File upload</label>
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
                        <label>Address</label>
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
                        <label>Name</label>
                        <input type="text" name="name" value="{{ $user->name }}" class="form-control" placeholder="Name" >
                    </div>

                    <div class="form-group">
                        <label>Email address</label>
                        <input type="email" name="email" value="{{ $user->email }}" class="form-control" placeholder="Email" >
                    </div>

                    <div class="form-group">
                        <label>Password <small class="text-muted">(leave blank to keep old)</small></label>
                        <input type="password" name="password" class="form-control" placeholder="Password">
                    </div>

                    <div class="form-group">
                        <label>Role</label>
                        <select name="role_id" class="form-control">
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="1" {{ $user->status == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ $user->status == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Date of Birth</label>
                        <input type="date" name="date_of_birth" value="{{ $user->date_of_birth }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>City</label>
                        <input type="text" name="city" value="{{ $user->city }}" class="form-control" placeholder="Location">
                    </div>

                    <div class="form-group">
                        <label>State</label>
                        <input type="text" name="state" value="{{ $user->state }}" class="form-control" placeholder="State">
                    </div>

                    <div class="form-group">
                        <label>Zip</label>
                        <input type="text" name="zip" value="{{ $user->zip }}" class="form-control" placeholder="Zip">
                    </div>

                    <div class="form-group">
                        <label>File upload</label>
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
                        <label>Textarea</label>
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
// File input display
document.addEventListener('change', function(e) {
    if (e.target.type === 'file') {
        let id = e.target.id.replace('profileInput', 'fileName');
        let fileInput = document.getElementById(id);
        if (fileInput && e.target.files.length > 0) {
            fileInput.value = e.target.files[0].name;
        }
    }
});

//  CREATE MODAL VALIDATION
document.getElementById('createUserForm').addEventListener('submit', function(e) {
    const requiredFields = [
        { name: 'name',     label: 'Name' },
        { name: 'email',    label: 'Email' },
        { name: 'password', label: 'Password' },
        { name: 'role_id',  label: 'Role' },
        { name: 'status',   label: 'Status' },
        { name: 'date_of_birth', label: 'Date of Birth' },
        { name: 'city',     label: 'City' },
        { name: 'state',    label: 'State' },
        { name: 'zip',      label: 'Zip' },
        { name: 'address',  label: 'Address' },
    ];

    let valid = true;

    // Clear previous errors
    this.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    this.querySelectorAll('.invalid-feedback').forEach(el => el.remove());

    requiredFields.forEach(field => {
        const el = this.querySelector(`[name="${field.name}"]`);
        if (el && !el.value.trim()) {
            el.classList.add('is-invalid');
            const msg = document.createElement('div');
            msg.className = 'invalid-feedback';
            msg.textContent = `${field.label} is required.`;
            el.parentNode.appendChild(msg);
            valid = false;
        }
    });

    if (!valid) {
        e.preventDefault();
        e.stopPropagation();
    }
});

//  EDIT MODAL VALIDATION
document.querySelectorAll('.editUserForm').forEach(function(form) {
    form.addEventListener('submit', function(e) {
        const requiredFields = [
            { name: 'name',     label: 'Name' },
            { name: 'email',    label: 'Email' },
            { name: 'role_id',  label: 'Role' },
            { name: 'status',   label: 'Status' },
            { name: 'date_of_birth', label: 'Date of Birth' },
            { name: 'city',     label: 'City' },
            { name: 'state',    label: 'State' },
            { name: 'zip',      label: 'Zip' },
            { name: 'address',  label: 'Address' },
        ];


        let valid = true;

        // Clear previous errors
        this.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        this.querySelectorAll('.invalid-feedback').forEach(el => el.remove());

        requiredFields.forEach(field => {
            const el = this.querySelector(`[name="${field.name}"]`);
            if (el && !el.value.trim()) {
                el.classList.add('is-invalid');
                const msg = document.createElement('div');
                msg.className = 'invalid-feedback';
                msg.textContent = `${field.label} is required.`;
                el.parentNode.appendChild(msg);
                valid = false;
            }
        });

        if (!valid) {
            e.preventDefault();
            e.stopPropagation();
        }
    });
});

// Clear errors when modal is closed/reopened
document.querySelectorAll('.modal').forEach(function(modal) {
    modal.addEventListener('hidden.bs.modal', function() {
        this.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        this.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
    });
});

</script>

@endsection
