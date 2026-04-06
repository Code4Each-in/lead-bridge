@extends('layout')
@section('title', 'Profile')
@section('subtitle', 'Profile')
@section('content')
<div class="row">
        <div class="col-md-4 grid-margin">

            {{-- Profile Card --}}
            <div class="card p-0 overflow-hidden profile-left-card">

                {{-- Cover gradient banner --}}
                <div class="profile-cover"></div>

                {{-- Avatar overlapping cover --}}
                <div class="text-center profile-avatar-wrap">
                        <img
                            src="{{ auth()->user()->profile
                                    ? asset('storage/' . auth()->user()->profile)
                                    : asset('assets/images/default-profile.png') }}"
                            class="profile-avatar rounded-circle"
                            alt="{{ auth()->user()->name }}">
                    </div>

                {{-- Name / Email / Role badge --}}
                <div class="text-center px-4 pb-2 profile-name-section">
                    <h5 class="mb-0 fw-bold">{{ auth()->user()->name }}</h5>
                    <p class="text-muted small mb-2">{{ auth()->user()->email }}</p>
                    @if(auth()->user()->role)
                        <span class="badge bg-gradient-primary px-3 py-1">
                            {{ auth()->user()->role->name }}
                        </span>
                    @endif
                </div>

                {{-- Stats Row --}}
                <div class="profile-stats d-flex border-top text-center">
                    <div class="flex-fill py-3 border-end">
                        <h6 class="mb-0 fw-bold">10</h6>
                        <small class="text-muted">Lead</small>
                    </div>
                    <div class="flex-fill py-3 border-end">
                        <h6 class="mb-0 fw-bold">{{ auth()->user()->city ?? '—' }}</h6>
                        <small class="text-muted">City</small>
                    </div>
                    <div class="flex-fill py-3">
                        <h6 class="mb-0 fw-bold">4</h6>
                        <small class="text-muted">Team Member</small>
                    </div>
                </div>
            </div>

            {{-- Team Members Card --}}
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

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="mdi mdi-check-circle me-1"></i> {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Name / Email --}}
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="profile-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name"
                                       class="form-control profile-input @error('name') is-invalid @enderror"
                                       value="{{ old('name', auth()->user()->name) }}"
                                       placeholder="Full Name">
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="profile-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" name="email"
                                       class="form-control profile-input @error('email') is-invalid @enderror"
                                       value="{{ old('email', auth()->user()->email) }}"
                                       placeholder="Email">
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        {{-- Date of Birth / Role (read-only) --}}
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="profile-label">Date of Birth <span class="text-danger">*</span></label>
                                <input type="date" name="date_of_birth"
                                       class="form-control profile-input @error('date_of_birth') is-invalid @enderror"
                                       value="{{ old('date_of_birth', auth()->user()->date_of_birth ? \Carbon\Carbon::parse(auth()->user()->date_of_birth)->format('Y-m-d') : '') }}">
                                @error('date_of_birth')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="profile-label">Role</label>
                                <input type="text" class="form-control profile-input"
                                       value="{{ auth()->user()->role->name ?? 'N/A' }}" readonly>
                            </div>
                        </div>

                        {{-- Address --}}
                        <div class="mb-3">
                            <label class="profile-label">Address <span class="text-danger">*</span></label>
                            <textarea name="address" rows="3"
                                      class="form-control profile-input @error('address') is-invalid @enderror"
                                      placeholder="Street address">{{ old('address', auth()->user()->address) }}</textarea>
                            @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- City / State / ZIP --}}
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="profile-label">City <span class="text-danger">*</span></label>
                                <input type="text" name="city"
                                       class="form-control profile-input @error('city') is-invalid @enderror"
                                       value="{{ old('city', auth()->user()->city) }}"
                                       placeholder="City">
                                @error('city')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label class="profile-label">State <span class="text-danger">*</span></label>
                                <input type="text" name="state"
                                       class="form-control profile-input @error('state') is-invalid @enderror"
                                       value="{{ old('state', auth()->user()->state) }}"
                                       placeholder="State">
                                @error('state')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label class="profile-label">ZIP Code <span class="text-danger">*</span></label>
                                <input type="text" name="zip"
                                       class="form-control profile-input @error('zip') is-invalid @enderror"
                                       value="{{ old('zip', auth()->user()->zip) }}"
                                       placeholder="ZIP Code">
                                @error('zip')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        {{-- Profile Photo — styled like Users modal --}}
                        <div class="mb-4">
                            <label class="profile-label">Profile Photo</label>

                            {{-- Current photo preview row --}}
                            @if(auth()->user()->profile)
                                <div class="mb-2 d-flex align-items-center gap-2">
                                    <img src="{{ asset('storage/' . auth()->user()->profile) }}"
                                         class="rounded-circle current-thumb"
                                         alt="Current photo">
                                </div>
                            @endif

                            <div class="input-group">
                                {{-- Hidden real file input --}}
                                <input type="file"
                                       id="profilePhotoInput"
                                       name="profile"
                                       accept="image/jpg,image/jpeg,image/png"
                                       style="display: none;">

                                {{-- Display-only text box showing chosen filename --}}
                                <input type="text"
                                       id="profilePhotoName"
                                       class="form-control profile-input @error('profile') is-invalid @enderror"
                                       placeholder="Upload Image"
                                       readonly>

                                {{-- Trigger button --}}
                                <span class="input-group-append">
                                    <button class="btn btn-primary file-upload-browse" type="button"
                                            onclick="document.getElementById('profilePhotoInput').click();">
                                        Upload
                                    </button>
                                </span>

                                @error('profile')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="text-muted mt-1 d-block">JPG, JPEG or PNG · Max 2MB</small>
                        </div>

                        {{-- Submit --}}
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

@endsection
