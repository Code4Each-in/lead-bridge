<?php $__env->startSection('title', 'Roles'); ?>
<?php $__env->startSection('subtitle', 'Roles'); ?>
<?php $__env->startSection('content'); ?>

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
                                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($role->name); ?></td>
                                    <td><?php echo e($role->created_at->format('d-m-Y h:i A')); ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-info"
                                            data-toggle="modal"
                                            data-target="#editModal<?php echo e($role->id); ?>">
                                            <i class="mdi mdi-pencil-box"></i> Edit
                                        </button>
                                        <a href="<?php echo e(route('roles.delete', $role->id)); ?>"
                                           class="btn btn-sm btn-danger btn-delete">
                                           <i class="mdi mdi-delete"></i> Delete
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

<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="createRoleForm" method="POST" action="<?php echo e(route('roles.store')); ?>">
            <?php echo csrf_field(); ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Add Role</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Role Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter role name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>


<!-- Edit Modals -->
<?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="modal fade" id="editModal<?php echo e($role->id); ?>" tabindex="-1">
    <div class="modal-dialog">
        <form class="editRoleForm" method="POST" action="<?php echo e(route('roles.update', $role->id)); ?>">
            <?php echo csrf_field(); ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Edit Role</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Role Name</label>
                        <input type="text" name="name" class="form-control" value="<?php echo e($role->name); ?>">
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
function waitForJQuery(callback) {
    if (typeof $ !== 'undefined') {
        callback();
    } else {
        setTimeout(function () { waitForJQuery(callback); }, 50);
    }
}

waitForJQuery(function () {

    // Clear errors helper
    function clearErrors(modal) {
        $(modal).find('.is-invalid').removeClass('is-invalid');
        $(modal).find('.invalid-feedback').remove();
    }

    // Show Laravel errors
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
    });

    // EDIT modals — clear errors + store originals on open
    $('[id^="editModal"]').on('show.bs.modal', function () {
        clearErrors(this);
        $(this).find('input').each(function () {
            $(this).data('orig', $(this).val());
        });
    });

    // EDIT modals — restore if not submitted
    $('[id^="editModal"]').on('hide.bs.modal', function () {
        if (!$(this).data('submitted')) {
            $(this).find('input').each(function () {
                $(this).val($(this).data('orig') || '');
            });
            clearErrors(this);
        }
        $(this).data('submitted', false);
    });

    // CREATE FORM SUBMIT
    $('#createRoleForm').on('submit', function (e) {
        e.preventDefault();
        const form = this;
        const formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (res) {
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
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    showErrors(form, xhr.responseJSON.errors);
                }
            }
        });
    });

    // EDIT FORM SUBMIT
    $(document).on('submit', '.editRoleForm', function (e) {
        e.preventDefault();
        const modal = $(this).closest('.modal');
        const form = this;

        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function (res) {
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
            text: 'This role will be permanently deleted!',
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
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: res.success,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(function () {
                            location.reload();
                        });
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

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\lead-bridge\resources\views/roles/index.blade.php ENDPATH**/ ?>