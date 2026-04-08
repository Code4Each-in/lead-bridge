<?php $__env->startSection('title', 'Profile'); ?>
<?php $__env->startSection('subtitle', 'Profile'); ?>
<?php $__env->startSection('content'); ?>
<div class="row d-flex justify-content-center">

    <!-- Left Profile Card -->
    <div class="col-md-12 grid-margin d-flex">
        <div class="card profile-left-card w-100 d-flex flex-column p-0 overflow-hidden">
            
            <div class="profile-cover"></div>

            
            <div class="text-center profile-avatar-wrap">
                <img
                    src="<?php echo e(auth()->user()->profile
                        ? asset('storage/' . auth()->user()->profile)
                        : asset('assets/images/default-profile.png')); ?>"
                    class="profile-avatar rounded-circle"
                    alt="<?php echo e(auth()->user()->name); ?>">
            </div>

            
            <div class="text-center px-4 pb-3 profile-name-section">
                <h5 class="mb-0 fw-bold"><?php echo e(auth()->user()->name); ?></h5>
                <p class="text-muted small mb-2"><?php echo e(auth()->user()->email); ?></p>
                <?php if(auth()->user()->role): ?>
                    <span class="badge bg-gradient-primary px-3 py-1">
                        <?php echo e(auth()->user()->role->name); ?>

                    </span>
                <?php endif; ?>
            </div>

            
            <div class="profile-stats d-flex border-top text-center mt-auto">

                <div class="flex-fill py-3 border-end">
                    <h6 class="mb-0 fw-bold"><?php echo e($leadCount); ?></h6>
                    <small class="text-muted">Lead</small>
                </div>

                <div class="flex-fill py-3 border-end">
                    <h6 class="mb-0 fw-bold"><?php echo e(auth()->user()->city ?? '—'); ?></h6>
                    <small class="text-muted">City</small>
                </div>

                <div class="flex-fill py-3">
                    <h6 class="mb-0 fw-bold"><?php echo e($teamCount); ?></h6>
                    <small class="text-muted">Team Member</small>
                </div>

            </div>
        </div>
    </div>

    <!-- Right Edit Profile Card -->
    <div class="col-md-12 grid-margin d-flex">
        <div class="card w-100 h-100">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title fw-bold mb-4">Edit Profile</h5>

                <?php if(session('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="mdi mdi-check-circle me-1"></i> <?php echo e(session('success')); ?>

                    </div>
                <?php endif; ?>

                <form method="POST" action="<?php echo e(route('profile.update')); ?>" enctype="multipart/form-data" class="flex-grow-1 d-flex flex-column">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="profile-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name"
                                class="form-control profile-input <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                value="<?php echo e(old('name', auth()->user()->name)); ?>"
                                placeholder="Full Name">
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-md-6">
                            <label class="profile-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email"
                                class="form-control profile-input <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                value="<?php echo e(old('email', auth()->user()->email)); ?>"
                                placeholder="Email">
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="profile-label">Date of Birth <span class="text-danger">*</span></label>
                            <input type="date" name="date_of_birth"
                                class="form-control profile-input <?php $__errorArgs = ['date_of_birth'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                value="<?php echo e(old('date_of_birth', auth()->user()->date_of_birth ? \Carbon\Carbon::parse(auth()->user()->date_of_birth)->format('Y-m-d') : '')); ?>">
                            <?php $__errorArgs = ['date_of_birth'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-md-6">
                            <label class="profile-label">Role</label>
                            <input type="text" class="form-control profile-input"
                                value="<?php echo e(auth()->user()->role->name ?? 'N/A'); ?>" readonly>
                        </div>
                    </div>

                    
                    <div class="mb-3">
                        <label class="profile-label">Address <span class="text-danger">*</span></label>
                        <textarea name="address" rows="3"
                            class="form-control profile-input <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            placeholder="Street address"><?php echo e(old('address', auth()->user()->address)); ?></textarea>
                        <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="profile-label">City <span class="text-danger">*</span></label>
                            <input type="text" name="city"
                                class="form-control profile-input <?php $__errorArgs = ['city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                value="<?php echo e(old('city', auth()->user()->city)); ?>"
                                placeholder="City">
                            <?php $__errorArgs = ['city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-md-4">
                            <label class="profile-label">State <span class="text-danger">*</span></label>
                            <input type="text" name="state"
                                class="form-control profile-input <?php $__errorArgs = ['state'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                value="<?php echo e(old('state', auth()->user()->state)); ?>"
                                placeholder="State">
                            <?php $__errorArgs = ['state'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-md-4">
                            <label class="profile-label">ZIP Code <span class="text-danger">*</span></label>
                            <input type="text" name="zip"
                                class="form-control profile-input <?php $__errorArgs = ['zip'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                value="<?php echo e(old('zip', auth()->user()->zip)); ?>"
                                placeholder="ZIP Code">
                            <?php $__errorArgs = ['zip'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    
                    <div class="mb-4">
                        <label class="profile-label">Profile Photo</label>

                        
                        <?php if(auth()->user()->profile): ?>
                            <div class="mb-2 d-flex align-items-center gap-2">
                                <img src="<?php echo e(asset('storage/' . auth()->user()->profile)); ?>"
                                    class="rounded-circle current-thumb"
                                    alt="Current photo">
                            </div>
                        <?php endif; ?>

                        <div class="input-group">
                            
                            <input type="file"
                                id="profilePhotoInput"
                                name="profile"
                                accept="image/jpg,image/jpeg,image/png"
                                style="display: none;">

                            
                            <input type="text"
                                id="profilePhotoName"
                                class="form-control profile-input <?php $__errorArgs = ['profile'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                placeholder="Upload Image"
                                readonly>

                            
                            <span class="input-group-append">
                                <button class="btn btn-primary file-upload-browse" type="button"
                                        onclick="document.getElementById('profilePhotoInput').click();">
                                    Upload
                                </button>
                            </span>

                            <?php $__errorArgs = ['profile'];
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

                    
                    <div class="text-end mt-auto">
                        <button type="submit" class="btn btn-update-profile px-5">
                            Update Profile
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

</div>

<style>
/* Card styling */
.card {
    border-radius: 14px;
    border: none;
    box-shadow: 0 6px 18px rgba(0,0,0,0.06);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    background: #fff;
}
.card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 28px rgba(0,0,0,0.08);
}

/* Profile left card */
.profile-left-card {
    display: flex;
    flex-direction: column;
    height: 100%;
}

/* Cover */
.profile-cover {
    height: 180px;
    background: linear-gradient(135deg, #6a8dff, #7b3ff2);
}
.profile-avatar-wrap::after {
    content: '';
    position: absolute;
    width: 100px;
    height: 100px;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    border-radius: 50%;
    background: rgba(0,0,0,0.05);
    z-index: 1;
}
/* Avatar */
.profile-avatar-wrap {
    margin-top: -55px;
    margin-bottom: 15px;
    position: relative;
    z-index: 2;
}

.profile-avatar {
    width: 95px;
    height: 95px;
    object-fit: cover;
    border-radius: 50%;
    border: 5px solid #fff;
    box-shadow: 0 6px 16px rgba(0,0,0,0.15);
}

/* Name section */
.profile-name-section h5 {
    font-size: 1.2rem;
    margin-bottom: 4px;
}

.profile-name-section p {
    font-size: 0.85rem;
    color: #666;
    margin-bottom: 8px;
}

.badge.bg-gradient-primary {
    background: linear-gradient(135deg, #4b49ac, #6a67ce);
    color: #fff;
    font-weight: 600;
    padding: 0.25rem 1rem;
    border-radius: 20px;
}

/* Stats */
.profile-stats {
    background: #f4f4f9;
    margin-top: auto;
    padding-top: 1rem;
    display: flex;
    justify-content: space-between;
    border-top: 1px solid #ddd;
}

.profile-stats h6 {
    font-size: 1rem;
    font-weight: 700;
    color: #4b49ac;
}

.profile-stats small {
    font-size: 0.75rem;
    color: #999;
}

/* Inputs */
.profile-input {
    background-color: #fbfbf9;
    border: 1px solid #e6e6e0;
    border-radius: 10px;
    font-size: 0.85rem;
    padding: 10px 12px;
}

.profile-input:focus {
    background-color: #fff;
    border-color: #6a67ce;
    box-shadow: 0 0 0 3px rgba(106,103,206,0.15);
}

/* Labels */
.profile-label {
    font-size: 0.75rem;
    color: #8c8c8c;
    margin-bottom: 4px;
}

/* Button */
.btn-update-profile {
    background: linear-gradient(135deg, #4b49ac, #6a67ce);
    color: #fff;
    border-radius: 30px;
    font-weight: 600;
    padding: 10px 40px;
}

.btn-update-profile:hover {
    background: linear-gradient(135deg, #3a3897, #5a57c7);
}

/* File upload button */
.file-upload-browse {
    background: #4b49ac;
    color: #fff;
    border-radius: 0 10px 10px 0;
}

/* Image preview */
.current-thumb {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    border: 2px solid #eee;
}
.card-body > form > .row,
.card-body > form > .mb-3 {
    background: #fafafa;
    padding: 15px;
    border-radius: 12px;
    margin-bottom: 15px;
}
#profilePhotoName {
    background: #fff;
    border-right: none;
}
.file-upload-browse {
    border-radius: 0 12px 12px 0;
}
.btn-update-profile,
.file-upload-browse {
    background: linear-gradient(135deg, #4b49ac, #6a67ce);
    transition: all 0.3s ease;
}
.btn-update-profile:hover,
.file-upload-browse:hover {
    background: linear-gradient(135deg, #3a3897, #5a57c7);
    transform: translateY(-2px);
}
.profile-name-section h5 { font-size: 1.4rem; }
.profile-name-section p { font-size: 0.9rem; color: #777; }
.profile-label { font-weight: 600; color: #666; }
.card { padding: 1.2rem; }
.profile-left-card { padding-bottom: 20px; }
.card-body { gap: 1rem; display: flex; flex-direction: column; }
</style>

<script>
// Show chosen filename in the text box
document.getElementById('profilePhotoInput').addEventListener('change', function () {
    const nameBox = document.getElementById('profilePhotoName');
    nameBox.value = this.files.length > 0 ? this.files[0].name : '';
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\lead-bridge\resources\views/profile/index.blade.php ENDPATH**/ ?>