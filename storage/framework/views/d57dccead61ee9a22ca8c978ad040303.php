<?php $__env->startSection('title', 'Leads'); ?>
<?php $__env->startSection('subtitle', 'Leads'); ?>
<?php $__env->startSection('content'); ?>
<style>
    .custom-card {
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    border: none;
}

.custom-header {
    background: #0d2c6c;
    color: #fff;
    font-weight: 600;
    border-radius: 12px 12px 0 0;
    padding: 12px 16px;
}

/* LEFT DETAILS */
.detail-row {
    display: flex;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid #eee;
    font-size: 14px;
}

.detail-row:last-child {
    border-bottom: none;
}

.detail-row i {
    width: 30px;
    color: #0d2c6c;
}

.label {
    font-weight: 600;
    margin-right: 8px;
    min-width: 120px;
}

/* RIGHT USERS */
.user-row {
    display: flex;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid #eee;
}

.user-row:last-child {
    border-bottom: none;
}

.user-row img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    margin-right: 10px;
}
.status-container {
    position: relative;
    display: inline-block;
}

.status-badge {
    padding: 5px 14px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    color: #0d2c6c;
    cursor: pointer;
}

/* Dropdown */
.status-dropdown {
    position: absolute;
    top: 32px;
    left: 0;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    min-width: 150px;
    overflow: hidden;
    z-index: 100;
}

.status-option {
    padding: 10px;
    cursor: pointer;
}

.status-option:hover {
    background: #f2f2f2;
}

/* COLORS */
.status-not { background: #6c757d; }
.status-progress { background: #f0ad4e; color:#000; }
.status-hold { background: #5bc0de; }
.status-lost { background: #d9534f; }
.status-complete { background: #5cb85c; }
</style>
<div class="row">
 <div class="col-md-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="container-fluid">
                    <div class="row">

                        <!-- LEFT: Details -->
                        <div class="col-md-8 mb-4">
                            <div class="card custom-card h-100">

                                <!-- Header -->
                                <div class="card-header custom-header">
                                    <i class="mdi mdi-chart-bar menu-icon icon-head me-2"></i>
                                    <?php echo e($lead->name ?? 'Lead Name'); ?>

                                </div>

                                <!-- Body -->
                                <div class="card-body">

                                    <div class="detail-row">
                                        <i class="mdi mdi-account"></i>
                                        <span class="label">Agency:</span>
                                        <span><?php echo e($lead->agency->agency_name ?? '-'); ?></span>
                                    </div>

                                    <div class="detail-row">
                                        <i class="mdi mdi-account-multiple"></i>
                                        <span class="label">Assigned To:</span>
                                        <span><?php echo e($lead->users->pluck('name')->join(', ') ?: '---'); ?></span>
                                    </div>

                                    <div class="detail-row">
                                        <i class="mdi mdi-office-building"></i>
                                        <span class="label">Company:</span>
                                        <span><?php echo e($lead->company ?? '---'); ?></span>
                                    </div>

                                    <div class="detail-row">
                                        <i class="mdi mdi-source-branch"></i>
                                        <span class="label">Source:</span>
                                        <span><?php echo e($lead->source ?? '---'); ?></span>
                                    </div>

                                    <div class="detail-row">
                                        <i class="mdi mdi-calendar-check"></i>
                                        <span class="label">Start date:</span>
                                        <span>----</span>
                                    </div>

                                    <div class="detail-row">
                                        <i class="mdi mdi-calendar-clock"></i>
                                        <span class="label">End date:</span>
                                        <span>----</span>
                                    </div>
                                    <div class="detail-row">
                                        <i class="mdi mdi-file-excel"></i>
                                        <span class="label">Notes:</span>
                                        <span><?php echo e($lead->notes ?? '---'); ?></span>
                                    </div>
                                     <div class="detail-row">
                                         <i class="mdi mdi-file-document"></i>
                                        <span class="label">Document:</span>
                                        <span><?php echo e($lead->documents ?? '---'); ?></span>
                                    </div>
                                    <div class="detail-row">
                                         <i class="mdi mdi-information-outline"></i>
                                        <span class="label">Status:</span>

                                        <div class="status-container" data-lead-id="<?php echo e($lead->id); ?>">

                                            <!-- Badge -->
                                            <span class="status-badge">
                                                <?php echo e($lead->status ?? 'Not Started'); ?> ▼
                                            </span>

                                            <!-- Dropdown -->
                                            <div class="status-dropdown d-none">
                                                <?php
                                                    $statuses = ['Not Started', 'In Progress', 'Hold', 'Lost', 'Complete'];
                                                ?>

                                                <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="status-option" data-value="<?php echo e($status); ?>">
                                                        <?php echo e($status); ?>

                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- RIGHT: Users -->
                        <div class="col-md-4 mb-4">
                            <div class="card custom-card h-100">

                                <div class="card-header custom-header">
                                    <i class="fa-solid fa-users me-2"></i>
                                    Lead Overview
                                </div>

                                <div class="card-body">

                                    <!-- Created By -->
                                    <?php if($lead->creator): ?>
                                        <div class="user-row mb-2">
                                            <img src="<?php echo e($lead->creator->profile
                                                ? asset('storage/' . $lead->creator->profile)
                                                : asset('assets/images/default-profile.png')); ?>"
                                                class="rounded-circle" width="40" height="40">
                                            <span class="ms-2"><?php echo e($lead->creator->name); ?> <span class="badge bg-primary">Created Lead</span></span>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Assigned To -->
                                    <?php $__currentLoopData = $lead->users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="user-row mb-2">
                                            <img src="<?php echo e($user->profile
                                                ? asset('storage/' . $user->profile)
                                                : asset('assets/images/default-profile.png')); ?>"
                                                class="rounded-circle" width="40" height="40">
                                            <span class="ms-2"><?php echo e($user->name); ?> <span class="badge bg-success">Assigned Lead</span></span>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    <!-- QA Users -->
                                    <?php $__currentLoopData = $lead->qaUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $qa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="user-row mb-2">
                                            <img src="<?php echo e($qa->profile
                                                ? asset('storage/' . $qa->profile)
                                                : asset('assets/images/default-profile.png')); ?>"
                                                class="rounded-circle" width="40" height="40">
                                            <span class="ms-2"><?php echo e($qa->name); ?> <span class="badge bg-warning text-dark">QA Lead</span></span>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.querySelectorAll('.status-container').forEach(container => {
    const badge = container.querySelector('.status-badge');
    const dropdown = container.querySelector('.status-dropdown');
    const leadId = container.dataset.leadId;

    function setColor(status) {
        badge.classList.remove(
            'status-not','status-progress','status-hold','status-lost','status-complete'
        );

        switch(status){
            case 'Not Started': badge.classList.add('status-not'); break;
            case 'In Progress': badge.classList.add('status-progress'); break;
            case 'Hold': badge.classList.add('status-hold'); break;
            case 'Lost': badge.classList.add('status-lost'); break;
            case 'Complete': badge.classList.add('status-complete'); break;
        }
    }

    // Initial color
    setColor(badge.innerText.replace(' ▼',''));

    // Toggle dropdown
    badge.addEventListener('click', () => {
        dropdown.classList.toggle('d-none');
    });

    // Click option
    dropdown.querySelectorAll('.status-option').forEach(option => {
        option.addEventListener('click', () => {
            const status = option.dataset.value;

            // UI update
            badge.innerText = status + ' ▼';
            setColor(status);
            dropdown.classList.add('d-none');

            // AJAX
            fetch(`/leads/${leadId}/status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                },
                body: JSON.stringify({ status })
            })
            .then(res => res.json())
            .then(data => {
                Swal.fire({
                    icon: 'success',
                    title: 'Updated',
                    text: data.success,
                    timer: 1500,
                    showConfirmButton: false
                });
            })
            .catch(() => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Update failed'
                });
            });
        });
    });
});

// Close when clicking outside
document.addEventListener('click', function(e){
    document.querySelectorAll('.status-dropdown').forEach(drop => {
        if (!drop.closest('.status-container').contains(e.target)) {
            drop.classList.add('d-none');
        }
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\lead-bridge\resources\views/leads/show.blade.php ENDPATH**/ ?>