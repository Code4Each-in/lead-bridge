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
                                                <th>City</th>
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
                                                <td>{{ $user->city }}</td>
                                                <td>
                                                    @if($user->profile)
                                                        <img src="{{ asset('storage/' . $user->profile) }}" width="40" height="40" style="border-radius:50%;">
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                            <td>
                                                <!-- Edit -->
                                                <button class="btn btn-sm btn-info"
                                                    data-toggle="modal"
                                                    data-target="#editModal{{ $user->id }}">
                                                    <i class="mdi mdi-pencil-box" ></i>
                                                    Edit
                                                </button>

                                                <!-- Delete -->
                                                <a href="{{ route('users.delete', $user->id) }}"
                                                class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this user?')">
                                                    <i class="mdi mdi-delete" ></i> Delete
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
<!-- Create User Modal -->
<div class="modal fade" id="createModal">
    <div class="modal-dialog modal-lg">
        <form method="POST" class="forms-sample" action="{{ route('users.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="modal-content">
                <div class="modal-header">
                    <h5>Add User</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-6 form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Role</label>
                            <select name="role_id" class="form-control">
                                <option value="">Select Role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>City</label>
                            <input type="text" name="city" class="form-control">
                        </div>

                        <div class="col-md-6 form-group">
                            <label>State</label>
                            <input type="text" name="state" class="form-control">
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Zip</label>
                            <input type="text" name="zip" class="form-control">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Date of Birth</label>
                            <input type="date" name="date_of_birth" class="form-control">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Profile Image</label>
                            <input type="file" name="profile" class="form-control">
                        </div>
                        <div class="col-md-12 form-group">
                            <label>Address</label>
                            <textarea name="address" class="form-control"></textarea>
                        </div>

                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary">Save User</button>
                </div>
            </div>

        </form>
    </div>
</div>
<!-- Edit Modal -->
 @foreach($users as $user)
<div class="modal fade" id="editModal{{ $user->id }}">
    <div class="modal-dialog modal-lg">
        <form method="POST" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data">
            @csrf

            <div class="modal-content">
                <div class="modal-header">
                    <h5>Edit User</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-6 form-group">
                            <label>Name</label>
                            <input type="text" name="name" value="{{ $user->name }}" class="form-control" required>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Email</label>
                            <input type="email" name="email" value="{{ $user->email }}" class="form-control" required>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Password (leave blank to keep old)</label>
                            <input type="password" name="password" class="form-control">
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Role</label>
                            <select name="role_id" class="form-control">
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}"
                                        {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="1" {{ $user->status == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $user->status == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Date of Birth</label>
                            <input type="date" name="date_of_birth"
                                value="{{ $user->date_of_birth }}"
                                class="form-control">
                        </div>

                        <div class="col-md-6 form-group">
                            <label>City</label>
                            <input type="text" name="city" value="{{ $user->city }}" class="form-control">
                        </div>

                        <div class="col-md-6 form-group">
                            <label>State</label>
                            <input type="text" name="state" value="{{ $user->state }}" class="form-control">
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Zip</label>
                            <input type="text" name="zip" value="{{ $user->zip }}" class="form-control">
                        </div>

                        <div class="col-md-12 form-group">
                            <label>Address</label>
                            <textarea name="address" class="form-control">{{ $user->address }}</textarea>
                        </div>

                        <!-- Profile Image -->
                        <div class="col-md-6 form-group">
                            <label>Profile Image</label>
                            <input type="file" name="profile" class="form-control">
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-success">Update</button>
                </div>

            </div>
        </form>
    </div>
</div>
@endforeach
@endsection
