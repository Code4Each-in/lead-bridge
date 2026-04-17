<?php $__env->startSection('title', 'Agency'); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-md-12">

        
        <div class="card border-0 shadow-sm mb-4 overflow-hidden">
            <div style="height:130px;background:linear-gradient(135deg,#6366f1,#8b5cf6,#a855f7);"></div>
            <div class="card-body text-center pb-0 position-relative">
                <div class="position-absolute top-0 start-50 translate-middle-x" style="margin-top:-40px;">
                    <?php if($agency->logo): ?>
                        <img src="<?php echo e(asset($agency->logo)); ?>" width="80" height="80"
                            class="rounded-circle border border-3 border-white object-fit-cover">
                    <?php else: ?>
                        <div class="rounded-circle border border-3 border-white bg-secondary d-flex align-items-center justify-content-center"
                            style="width:80px;height:80px;">
                            <i class="bi bi-building text-white fs-4"></i>
                        </div>
                    <?php endif; ?>
                </div>
                <div style="margin-top:48px;">
                    <h5 class="fw-500 mb-1"><?php echo e($agency->agency_name); ?></h5>
                    <p class="text-muted small mb-2"><?php echo e($agency->primary_email); ?></p>
                    <span class="badge rounded-pill text-white mb-3" style="background:#6366f1;">Admin</span>
                </div>
            </div>
            <div class="row text-center border-top g-0">
                <div class="col-4 py-3 border-end">
                    <div class="fs-5 fw-500 text-indigo">107</div>
                    <div class="text-muted small">Leads</div>
                </div>
                <div class="col-4 py-3 border-end">
                    <div class="fw-500 text-indigo"><?php echo e($agency->city); ?></div>
                    <div class="text-muted small">City</div>
                </div>
                <div class="col-4 py-3">
                    <div class="fs-5 fw-500 text-indigo">6</div>
                    <div class="text-muted small">Team members</div>
                </div>
            </div>
        </div>

        
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h6 class="fw-500 mb-4">Edit agency</h6>

                <form method="POST" action="<?php echo e(route('agency.detailUpdate')); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small text-muted mb-1">Agency name <span class="text-danger">*</span></label>
                            <input type="text" name="agency_name" class="form-control"
                                value="<?php echo e(old('agency_name', $agency->agency_name)); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted mb-1">Primary contact <span class="text-danger">*</span></label>
                            <input type="text" name="primary_contact_name" class="form-control"
                                value="<?php echo e(old('primary_contact_name', $agency->primary_contact_name)); ?>">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small text-muted mb-1">Email address <span class="text-danger">*</span></label>
                            <input type="email" name="primary_email" class="form-control"
                                value="<?php echo e(old('primary_email', $agency->primary_email)); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted mb-1">Phone</label>
                            <input type="text" name="phone" class="form-control"
                                value="<?php echo e(old('phone', $agency->phone)); ?>">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small text-muted mb-1">Address <span class="text-danger">*</span></label>
                        <input type="text" name="address" class="form-control"
                            value="<?php echo e(old('address', $agency->address)); ?>">
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-5">
                            <label class="form-label small text-muted mb-1">City <span class="text-danger">*</span></label>
                            <input type="text" name="city" class="form-control"
                                value="<?php echo e(old('city', $agency->city)); ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small text-muted mb-1">State <span class="text-danger">*</span></label>
                            <input type="text" name="state" class="form-control"
                                value="<?php echo e(old('state', $agency->state)); ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small text-muted mb-1">ZIP code <span class="text-danger">*</span></label>
                            <input type="text" name="zip" class="form-control"
                                value="<?php echo e(old('zip', $agency->zip)); ?>">
                        </div>
                    </div>

                    <hr class="my-4">

                    
                    <div class="mb-4">
                        <label class="profile-label">Agency Logo</label>

                        
                        <div class="mb-2 d-flex align-items-center gap-2">
                            <img id="logoPreview"
                                src="<?php echo e($agency->logo ? asset($agency->logo) : asset('assets/images/default-logo.png')); ?>"
                                class="rounded-circle current-thumb"
                                alt="Logo Preview"
                                style="width:56px;height:56px;object-fit:cover;">
                        </div>

                        <div class="input-group">
                            
                            <input type="file"
                                id="logoInput"
                                name="logo"
                                accept="image/jpg,image/jpeg,image/png"
                                style="display: none;">

                            
                            <input type="text"
                                id="logoName"
                                class="form-control profile-input <?php $__errorArgs = ['logo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                placeholder="Upload Logo"
                                readonly>

                            
                            <input type="hidden" name="pendingLogo" id="pendingLogo" value="<?php echo e(old('pendingLogo')); ?>">
                            <input type="hidden" name="pendingLogoName" id="pendingLogoName" value="<?php echo e(old('pendingLogoName')); ?>">

                            
                            <span class="input-group-append">
                                <button class="btn btn-primary" type="button"
                                    onclick="document.getElementById('logoInput').click();">
                                    Upload
                                </button>
                            </span>

                            <?php $__errorArgs = ['logo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <small class="text-muted mt-1 d-block">JPG, JPEG or PNG · Max 2MB</small>
                    </div>

                    <button type="submit" class="btn mt-4 text-white px-4"
                        style="background:#6366f1;border-color:#6366f1;">Update agency</button>

                </form>
            </div>
        </div>

    </div>
</div>

<script>
document.getElementById('logoInput').addEventListener('change', function (e) {
    const file = e.target.files[0];

    if (file) {
        // Show filename
        document.getElementById('logoName').value = file.name;

        // Preview image
        const reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById('logoPreview').src = e.target.result;

            // Store base64 (optional)
            document.getElementById('pendingLogo').value = e.target.result;
            document.getElementById('pendingLogoName').value = file.name;
        };
        reader.readAsDataURL(file);
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\lead-bridge\resources\views/agency/show.blade.php ENDPATH**/ ?>