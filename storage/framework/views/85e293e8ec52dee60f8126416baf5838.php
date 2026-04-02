<?php $__env->startSection('title', 'Profile'); ?>
<?php $__env->startSection('subtitle', 'Profile'); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
        <div class="col-md-4 grid-margin">

            
            <div class="card p-0 overflow-hidden profile-left-card">

                
                <div class="profile-cover"></div>

                
                <div class="text-center profile-avatar-wrap">
                    <?php if(auth()->user()->profile): ?>
                        <img src="<?php echo e(asset('storage/' . auth()->user()->profile)); ?>"
                             class="profile-avatar rounded-circle"
                             alt="<?php echo e(auth()->user()->name); ?>">
                    <?php else: ?>
                        <div class="profile-avatar-initials rounded-circle bg-gradient-primary text-white d-flex align-items-center justify-content-center mx-auto">
                            <span>
                                <?php echo e(strtoupper(substr(auth()->user()->name, 0, 1))); ?><?php echo e(strtoupper(substr(strrchr(auth()->user()->name, ' ') ?: ' x', 1, 1))); ?>

                            </span>
                        </div>
                    <?php endif; ?>
                </div>

                
                <div class="text-center px-4 pb-2 profile-name-section">
                    <h5 class="mb-0 fw-bold"><?php echo e(auth()->user()->name); ?></h5>
                    <p class="text-muted small mb-2"><?php echo e(auth()->user()->email); ?></p>
                    <?php if(auth()->user()->role): ?>
                        <span class="badge bg-gradient-primary px-3 py-1">
                            <?php echo e(auth()->user()->role->name); ?>

                        </span>
                    <?php endif; ?>
                </div>

                
                <div class="profile-stats d-flex border-top text-center">
                    <div class="flex-fill py-3 border-end">
                        <h6 class="mb-0 fw-bold">10</h6>
                        <small class="text-muted">Lead</small>
                    </div>
                    <div class="flex-fill py-3 border-end">
                        <h6 class="mb-0 fw-bold"><?php echo e(auth()->user()->city ?? '—'); ?></h6>
                        <small class="text-muted">City</small>
                    </div>
                    <div class="flex-fill py-3">
                        <h6 class="mb-0 fw-bold">4</h6>
                        <small class="text-muted">Team Member</small>
                    </div>
                </div>
            </div>

            
            <div class="card mt-4">
                <div class="card-body">
                    <h6 class="card-title fw-bold mb-3">Team Members</h6>

                    <!-- User 1 -->
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar me-3">
                            <img src="https://randomuser.me/api/portraits/women/44.jpg"
                                class="rounded-circle team-avatar"
                                alt="User">
                        </div>

                        <div class="flex-grow-1 ml-3">
                            <h6 class="mb-0 small fw-semibold">Test user</h6>
                            <small class="text-muted">user</small>
                        </div>

                        <a href="#"
                        class="team-msg-btn d-flex align-items-center justify-content-center rounded-circle">
                            <i class="mdi mdi-email-outline"></i>
                        </a>
                    </div>

                    <!-- User 2 -->
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar me-3">
                            <img src="https://randomuser.me/api/portraits/women/68.jpg"
                                class="rounded-circle team-avatar"
                                alt="User">
                        </div>

                        <div class="flex-grow-1 ml-3">
                            <h6 class="mb-0 small fw-semibold">User</h6>
                            <small class="text-muted">Mis user</small>
                        </div>

                        <a href="#"
                        class="team-msg-btn d-flex align-items-center justify-content-center rounded-circle">
                            <i class="mdi mdi-email-outline"></i>
                        </a>
                    </div>

                </div>
            </div>

        </div>

        <!-- edit profile -->
        <div class="col-md-8 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-4">Edit Profile</h5>

                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="mdi mdi-check-circle me-1"></i> <?php echo e(session('success')); ?>

                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?php echo e(route('profile.update')); ?>" enctype="multipart/form-data">
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

                        
                        <div class="text-end">
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
.profile-left-card { border-radius: 12px; }

.profile-cover {
    height: 140px;
    background: linear-gradient(230deg, #759bff, #843cf6);
}

.profile-avatar-wrap { margin-top: -50px; margin-bottom: 8px; position: relative; z-index: 2; }
.profile-avatar {
    width: 90px; height: 90px; object-fit: cover;
    border: 4px solid #fff;
    box-shadow: 0 4px 14px rgba(0,0,0,0.15);
}
.profile-avatar-initials {
    width: 90px; height: 90px;
    font-size: 1.6rem; font-weight: 700;
    border: 4px solid #fff;
    box-shadow: 0 4px 14px rgba(0,0,0,0.15);
}

.profile-name-section { padding-bottom: 10px; }

.profile-stats h6 { color: #343a40; font-size: 0.9rem; }
.profile-stats small { font-size: 0.75rem; }

.avatar {
    width: 40px;
    height: 40px;
    flex-shrink: 0;
}

.team-avatar {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.team-msg-btn {
    width: 32px;
    height: 32px;
    background: #f1f1f1;
    color: #555;
    text-decoration: none;
}
.team-initials { width: 42px; height: 42px; font-size: 0.8rem; font-weight: 600; flex-shrink: 0; }

.team-msg-btn {
    width: 34px; height: 34px;
    border: 2px solid #4b49ac; color: #4b49ac;
    background: #fff; font-size: 1rem;
    transition: all 0.2s; text-decoration: none; flex-shrink: 0;
}
.team-msg-btn:hover { background: #4b49ac; color: #fff; }

.current-thumb { width: 48px; height: 48px; object-fit: cover; flex-shrink: 0; }

.profile-label {
    display: block; font-size: 0.78rem;
    color: #9a9a9a; font-weight: 500;
    margin-bottom: 5px; letter-spacing: 0.03em;
}

.profile-input {
    background-color: #f9f9f6;
    border: 1px solid #e8e8e0;
    border-radius: 8px; color: #444;
    font-size: 0.875rem; padding: 9px 12px;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.profile-input:focus {
    background-color: #fff;
    border-color: #4b49ac;
    box-shadow: 0 0 0 3px rgba(75,73,172,0.12);
    outline: none;
}
.profile-input[readonly] { background-color: #f0f0f0; cursor: not-allowed; }
.profile-input::placeholder { color: #c5c5bc; }
textarea.profile-input { resize: vertical; }

/* Make input-group file upload blend with profile-input styling */
.input-group .profile-input {
    border-top-right-radius: 0 !important;
    border-bottom-right-radius: 0 !important;
}
.input-group-append .btn {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
}

.btn-update-profile {
    background: rgb(75, 73, 172); color: #fff;
    border: none; border-radius: 50px;
    font-size: 0.875rem; font-weight: 600;
    padding: 10px 36px; letter-spacing: 0.02em;
    transition: background 0.2s, transform 0.15s;
}
.btn-update-profile:hover { background: #3a3897; color: #fff; transform: translateY(-1px); }
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