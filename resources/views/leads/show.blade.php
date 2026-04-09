@extends('layout')
@section('title', 'Leads')
@section('subtitle', 'Leads')
@section('content')
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
                                    {{ $lead->name ?? 'Lead Name' }}
                                </div>

                                <!-- Body -->
                                <div class="card-body">

                                    <div class="detail-row">
                                        <i class="mdi mdi-account"></i>
                                        <span class="label">Agency:</span>
                                        <span>{{ $lead->agency->agency_name ?? '-' }}</span>
                                    </div>

                                    <div class="detail-row">
                                        <i class="mdi mdi-account-multiple"></i>
                                        <span class="label">Assigned To:</span>
                                        <span>{{ $lead->users->pluck('name')->join(', ') ?: '---' }}</span>
                                    </div>

                                    <div class="detail-row">
                                        <i class="mdi mdi-office-building"></i>
                                        <span class="label">Company:</span>
                                        <span>{{ $lead->company ?? '---' }}</span>
                                    </div>

                                    <div class="detail-row">
                                        <i class="mdi mdi-source-branch"></i>
                                        <span class="label">Source:</span>
                                        <span>{{ $lead->source ?? '---' }}</span>
                                    </div>

                                    <div class="detail-row">
                                        <i class="mdi mdi-calendar-check"></i>
                                        <span class="label">Start date:</span>
                                        <span>{{ $lead->start_date ?? '---' }}</span>
                                    </div>

                                    <div class="detail-row">
                                        <i class="mdi mdi-calendar-clock"></i>
                                        <span class="label">End date:</span>
                                        <span>{{ $lead->end_date ?? '---' }}</span>
                                    </div>
                                    <div class="detail-row">
                                        <i class="mdi mdi-file-excel"></i>
                                        <span class="label">Notes:</span>
                                        <span>{{ $lead->notes ?? '---' }}</span>
                                    </div>
                                    <div class="detail-item">
                                        <i class="mdi mdi-file-document"></i>  <span class="label">Documents:</span>
                                        <span style="margin-left: 40px;">
                                        @php
                                            $documents = $lead->documents ? explode(',', $lead->documents) : [];
                                            $icons = [
                                                'pdf' => 'mdi mdi-file-pdf',
                                                'doc' => 'mdi mdi-file-word',
                                                'docx' => 'mdi mdi-file-word',
                                                'xls' => 'mdi mdi-file-excel',
                                                'xlsx' => 'mdi mdi-file-excel',
                                                'jpg' => 'mdi mdi-file-image',
                                                'jpeg' => 'mdi mdi-file-image',
                                                'png' => 'mdi mdi-file-image'
                                            ];
                                        @endphp

                                        @if (empty($documents))
                                            <span>No documents uploaded</span>
                                        @else
                                            @foreach ($documents as $doc)
                                                @php
                                                    $ext = pathinfo(trim($doc), PATHINFO_EXTENSION);
                                                    $icon = $icons[strtolower($ext)] ?? 'mdi mdi-file';
                                                @endphp
                                                <button class="btn btn-outline-primary btn-sm mb-1"
                                                    title="{{ trim($doc) }}"
                                                    onclick="window.open('{{ asset('storage/' . trim($doc)) }}', '_blank')">
                                                    <i class="{{ $icon }}"></i>
                                                </button>
                                            @endforeach
                                        @endif
                                        </span>
                                    </div>
                                    <div class="detail-row">
                                         <i class="mdi mdi-information-outline"></i>
                                        <span class="label">Status:</span>

                                        <div class="status-container" data-lead-id="{{ $lead->id }}">

                                            <!-- Badge -->
                                            <span class="status-badge">
                                                {{ $lead->status ?? 'Not Started' }} ▼
                                            </span>

                                            <!-- Dropdown -->
                                            <div class="status-dropdown d-none">
                                                @php
                                                    $statuses = ['Not Started', 'In Progress', 'Hold', 'Lost', 'Complete'];
                                                @endphp

                                                @foreach($statuses as $status)
                                                    <div class="status-option" data-value="{{ $status }}">
                                                        {{ $status }}
                                                    </div>
                                                @endforeach
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
                                    @if($lead->creator)
                                        <div class="user-row mb-2">
                                            <img src="{{ $lead->creator->profile
                                                ? asset('storage/' . $lead->creator->profile)
                                                : asset('assets/images/default-profile.png') }}"
                                                class="rounded-circle" width="40" height="40">
                                            <span class="ms-2">{{ $lead->creator->name }} <span class="badge bg-primary">Created Lead</span></span>
                                        </div>
                                    @endif

                                    <!-- Assigned To -->
                                    @foreach($lead->users as $user)
                                        <div class="user-row mb-2">
                                            <img src="{{ $user->profile
                                                ? asset('storage/' . $user->profile)
                                                : asset('assets/images/default-profile.png') }}"
                                                class="rounded-circle" width="40" height="40">
                                            <span class="ms-2">{{ $user->name }} <span class="badge bg-success">Assigned Lead</span></span>
                                        </div>
                                    @endforeach

                                    <!-- QA Users -->
                                    @foreach($lead->qaUsers as $qa)
                                        <div class="user-row mb-2">
                                            <img src="{{ $qa->profile
                                                ? asset('storage/' . $qa->profile)
                                                : asset('assets/images/default-profile.png') }}"
                                                class="rounded-circle" width="40" height="40">
                                            <span class="ms-2">{{ $qa->name }} <span class="badge bg-warning text-dark">QA Lead</span></span>
                                        </div>
                                    @endforeach

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
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
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
@endsection
