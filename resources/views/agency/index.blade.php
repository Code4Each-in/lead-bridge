@extends('layout')
@section('title', 'Agencies')
@section('subtitle', 'Agencies')
@section('content')

<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="card">
            <div class="card-body">

                <div class="d-flex justify-content-between mb-3">
                    <h4 class="card-title">Agencies</h4>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#createModal">
                        Add Agency
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Agency Name</th>
                                <th>Primary Contact</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th width="150">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($agencies as $agency)
                            <tr>
                                <td>{{ $agency->agency_name }}</td>
                                <td>{{ $agency->primary_contact }}</td>
                                <td>{{ $agency->phone }}</td>
                                <td>
                                    {{ $agency->address }}, {{ $agency->city }}, {{ $agency->state }} - {{ $agency->zip }}
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#editModal{{ $agency->id }}">
                                       <i class="mdi mdi-pencil-box"></i> Edit
                                    </button>
                                    <a href="{{ route('agencies.delete', $agency->id) }}" class="btn btn-sm btn-danger btn-delete">
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

<!-- CREATE MODAL -->
<div class="modal fade" id="createModal">
    <div class="modal-dialog">
        <form id="createAgencyForm" method="POST" action="{{ route('agencies.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Add Agency</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label class="required-label">Agency Name</label>
                        <input type="text" name="agency_name" class="form-control" placeholder="Agency Name" >
                    </div>

                    <div class="form-group">
                        <label class="required-label">Primary Contact</label>
                        <input type="text" name="primary_contact" class="form-control" placeholder="Primary Contact">
                    </div>
                    <div class="form-group">
                        <label class="required-label">Phone</label>
                        <input type="text" name="phone" class="form-control" placeholder="Phone">
                    </div>
                    <div class="form-group">
                        <label class="required-label">Address</label>
                        <textarea name="address" class="form-control" placeholder="Address"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="required-label">City</label>
                        <input type="text" name="city" class="form-control" placeholder="City">
                    </div>
                    <div class="form-group">
                        <label class="required-label">State</label>
                        <input type="text" name="state" class="form-control" placeholder="State">
                    </div>
                      <div class="form-group">
                        <label class="required-label">State</label>
                        <input type="text" name="state" class="form-control" placeholder="State">
                    </div>
                    <div class="form-group">
                        <label class="required-label">Zip</label>
                        <input type="text" name="zip" class="form-control" placeholder="Zip">
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

<!-- EDIT MODALS -->
@foreach($agencies as $agency)
<div class="modal fade" id="editModal{{ $agency->id }}">
    <div class="modal-dialog">
        <form class="editAgencyForm" method="POST" action="{{ route('agencies.update', $agency->id) }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Edit Agency</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label class="required-label">Agency Name</label>
                        <input type="text" name="agency_name" value="{{ $agency->agency_name }}" class="form-control" placeholder="Agency Name" >
                    </div>
                    <div class="form-group">
                        <label class="required-label">Primary Contact</label>
                        <input type="text" name="primary_contact" value="{{ $agency->primary_contact }}" class="form-control" placeholder="Primary Contact" >
                    </div>
                    <div class="form-group">
                        <label class="required-label">Phone</label>
                        <input type="text" name="phone" value="{{ $agency->phone }}" class="form-control" placeholder="Phone" >
                    </div>
                    <div class="form-group">
                        <label class="required-label">Address</label>
                        <textarea name="address" class="form-control">{{ $agency->address }}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="required-label">City</label>
                        <input type="text" name="city" value="{{ $agency->city }}" class="form-control" placeholder="City" >
                    </div>
                    <div class="form-group">
                        <label class="required-label">State</label>
                        <input type="text" name="state" value="{{ $agency->state }}" class="form-control" placeholder="State" >
                    </div>
                    <div class="form-group">
                        <label class="required-label">Zip</label>
                        <input type="text" name="zip" value="{{ $agency->zip }}" class="form-control" placeholder="Zip" >
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
    $('#createAgencyForm').on('submit', function (e) {
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
    $(document).on('submit', '.editAgencyForm', function (e) {
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

});

</script>

@endsection
