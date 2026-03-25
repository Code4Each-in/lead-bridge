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
                        <h4 class="card-title">Roles</h4>

                        <button class="btn btn-primary" data-toggle="modal" data-target="#createModal">
                            Add Role
                        </button>
                    </div>

                    <!-- Success Message -->
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <!-- Table -->
                    <div class="table-responsive">
                        <table id="rolesTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Role Name</th>
                                    <th>Created At</th>
                                    <th width="200">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($roles as $role)
                                <tr>
                                    <td>{{ $role->name }}</td>
                                    <td>{{ $role->created_at->format('d-m-Y h:i A') }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-info"
                                            data-toggle="modal"
                                            data-target="#editModal{{ $role->id }}">
                                           <i class="mdi mdi-pencil-box" ></i>  Edit
                                        </button>

                                        <a href="{{ route('roles.delete', $role->id) }}"
                                           class="btn btn-sm btn-danger"
                                           onclick="return confirm('Are you sure you want to delete this role?')">
                                           <i class="mdi mdi-delete" ></i> Delete
                                        </a>
                                    </td>
                                </tr>

                                
                                <!-- Edit Modal -->
                                <div class="modal fade" id="editModal{{ $role->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <form method="POST" action="{{ route('roles.update', $role->id) }}">
                                            @csrf

                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5>Edit Role</h5>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>

                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>Role Name</label>
                                                        <input type="text" name="name" class="form-control"
                                                            value="{{ $role->name }}" required>
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
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>


<!--  Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('roles.store') }}">
            @csrf

            <div class="modal-content">
                <div class="modal-header">
                    <h5>Add Role</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Role Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter role name" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary">Save</button>
                </div>
            </div>

        </form>
    </div>
</div>

@endsection
