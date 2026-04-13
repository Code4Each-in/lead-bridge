@extends('layout')
@section('title', 'Leads')
@section('subtitle', 'Leads')
@section('content')
<style>
    .custom-card {
        border-radius: 14px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        border: 0.5px solid #e5e7eb;
        background: #fff;
    }

    .custom-header {
        background: #0d2c6c;
        color: #fff;
        font-weight: 500;
        font-size: 15px;
        border-radius: 14px 14px 0 0;
        padding: 14px 20px;
        display: flex;
        align-items: center;
        gap: 8px;
        letter-spacing: .01em;
    }

    .icon-head {
        opacity: .75;
        font-size: 16px;
    }


    .detail-row {
        display: flex;
        align-items: flex-start;
        padding: 11px 0;
        border-bottom: 0.5px solid #f0f2f5;
        font-size: 13.5px;
    }

    .detail-row:last-child {
        border-bottom: none;
    }

    .detail-row i {
        width: 28px;
        color: #0d2c6c;
        font-size: 16px;
        flex-shrink: 0;
        margin-top: 1px;
    }

    .label {
        font-weight: 500;
        font-size: 12.5px;
        color: #6b7280;
        min-width: 115px;
        margin-right: 0;
        padding-top: 1px;
    }

    .detail-item {
        display: flex;
        align-items: flex-start;
        padding: 11px 0;
        border-bottom: 0.5px solid #f0f2f5;
        font-size: 13.5px;
    }

    .detail-item i {
        width: 28px;
        color: #0d2c6c;
        font-size: 16px;
        flex-shrink: 0;
        margin-top: 1px;
    }

    .btn-outline-primary.btn-sm {
        font-size: 12px;
        padding: 3px 10px;
        border-radius: 6px;
        border-width: 0.5px;
    }

    .status-container {
        position: relative;
        display: inline-block;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 13px;
        border-radius: 20px;
        font-size: 12.5px;
        font-weight: 500;
        cursor: pointer;
        user-select: none;
        transition: opacity .15s;
        color: #0d2c6c;
    }

    .status-badge:hover { opacity: .82; }

    .status-dropdown {
        position: absolute;
        top: calc(100% + 6px);
        left: 0;
        background: #fff;
        border-radius: 10px;
        border: 0.5px solid #d1d5db;
        box-shadow: 0 6px 20px rgba(0,0,0,.10);
        min-width: 156px;
        overflow: hidden;
        z-index: 200;
    }

    .status-option {
        padding: 9px 14px;
        cursor: pointer;
        font-size: 13px;
        color: #111827;
        transition: background .1s;
    }

    .status-option:hover { background: #f9fafb; }

    .status-not      { background: #f1f5f9; color: #475569; }
    .status-progress { background: #fef3c7; color: #92400e; }
    .status-hold     { background: #e0f2fe; color: #075985; }
    .status-lost     { background: #fee2e2; color: #991b1b; }
    .status-complete { background: #dcfce7; color: #166534; }

    .rp-section {
        font-size: 10.5px;
        font-weight: 600;
        letter-spacing: .07em;
        text-transform: uppercase;
        color: #9ca3af;
        padding: 14px 0 8px;
        border-bottom: 0.5px solid #f0f2f5;
        margin-bottom: 2px;
    }

    /* User row */
    .user-row {
        display: flex;
        align-items: center;
        padding: 10px 0;
        border-bottom: 0.5px solid #f0f2f5;
        gap: 12px;
    }

    .user-row:last-child {
        border-bottom: none;
    }

    /* Initials avatar */
    .rp-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: 600;
        flex-shrink: 0;
        letter-spacing: .02em;
        /* fallback if image fails */
        background: #e0e7ff;
        color: #3730a3;
        overflow: hidden;
        position: relative;
    }

    .rp-avatar img {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        object-fit: cover;
        position: absolute;
        inset: 0;
    }

    /* avatar colour variants */
    .av-blue   { background: #dbeafe; color: #1d4ed8; }
    .av-green  { background: #dcfce7; color: #15803d; }
    .av-amber  { background: #fef3c7; color: #b45309; }

    /* User info */
    .rp-info {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .rp-name {
        font-size: 13.5px;
        font-weight: 500;
        color: #111827;
        line-height: 1;
    }

    /* Role badge */
    .rp-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 11px;
        font-weight: 500;
        padding: 3px 9px;
        border-radius: 20px;
        width: fit-content;
        line-height: 1;
    }

    .rp-badge::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .rpb-blue {
        background: #eff6ff;
        color: #1d4ed8;
    }
    .rpb-blue::before  { background: #3b82f6; }

    .rpb-green {
        background: #f0fdf4;
        color: #15803d;
    }
    .rpb-green::before { background: #22c55e; }

    .rpb-amber {
        background: #fffbeb;
        color: #b45309;
    }
    .rpb-amber::before { background: #f59e0b; }
</style>
<!-- Quill CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="container-fluid">
                    <div class="row">

                        <!-- LEFT: Details -->
                        <div class="col-md-8 mb-4">
                            <div class="card custom-card h-100">

                                <div class="card-header custom-header">
                                    <i class="mdi mdi-chart-bar menu-icon icon-head me-2"></i>
                                    {{ $lead->name ?? 'Lead Name' }}
                                </div>

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
                                        <span style="color:#6b7280; font-size:13px;">{{ $lead->notes ?? '---' }}</span>
                                    </div>

                                    <div class="detail-item">
                                        <i class="mdi mdi-file-document"></i>
                                        <span class="label">Documents:</span>
                                        <span style="margin-left: 8px;">
                                        @php
                                            $documents = $lead->documents ? explode(',', $lead->documents) : [];
                                            $icons = [
                                                'pdf'  => 'mdi mdi-file-pdf',
                                                'doc'  => 'mdi mdi-file-word',
                                                'docx' => 'mdi mdi-file-word',
                                                'xls'  => 'mdi mdi-file-excel',
                                                'xlsx' => 'mdi mdi-file-excel',
                                                'jpg'  => 'mdi mdi-file-image',
                                                'jpeg' => 'mdi mdi-file-image',
                                                'png'  => 'mdi mdi-file-image'
                                            ];
                                        @endphp

                                        @if (empty($documents))
                                            <span style="color:#9ca3af; font-size:13px;">No documents uploaded</span>
                                        @else
                                            @foreach ($documents as $doc)
                                                @php
                                                    $ext  = pathinfo(trim($doc), PATHINFO_EXTENSION);
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
                                            <span class="status-badge">
                                                {{ $lead->status ?? 'Not Started' }} ▼
                                            </span>

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

                        <!-- RIGHT: Users — redesigned -->
                        <div class="col-md-4 mb-4">
                            <div class="card custom-card h-100">

                                <div class="card-header custom-header">
                                    <i class="fa-solid fa-users me-2 icon-head"></i>
                                    Lead Overview
                                </div>

                                <div class="card-body px-3 py-2">

                                    <!-- Created By -->
                                    @if($lead->creator)
                                        @php
                                            $words    = explode(' ', trim($lead->creator->name));
                                            $initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
                                        @endphp
                                        <div class="rp-section">Created by</div>
                                        <div class="user-row">
                                            <div class="rp-avatar av-blue">
                                                {{ $initials }}
                                                @if($lead->creator->profile)
                                                    <img src="{{ asset('storage/' . $lead->creator->profile) }}" alt="{{ $lead->creator->name }}">
                                                @endif
                                            </div>
                                            <div class="rp-info">
                                                <span class="rp-name">{{ $lead->creator->name }}</span>
                                                <span class="rp-badge rpb-blue">Created Lead</span>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Assigned To -->
                                    @if($lead->users->count())
                                        <div class="rp-section">Assigned to</div>
                                        @foreach($lead->users as $user)
                                            @php
                                                $words    = explode(' ', trim($user->name));
                                                $initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
                                            @endphp
                                            <div class="user-row">
                                                <div class="rp-avatar av-green">
                                                    {{ $initials }}
                                                    @if($user->profile)
                                                        <img src="{{ asset('storage/' . $user->profile) }}" alt="{{ $user->name }}">
                                                    @endif
                                                </div>
                                                <div class="rp-info">
                                                    <span class="rp-name">{{ $user->name }}</span>
                                                    <span class="rp-badge rpb-green">Assigned Lead</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif

                                    <!-- QA Users -->
                                    @if($lead->qaUsers->count())
                                        <div class="rp-section">Quality Assurance</div>
                                        @foreach($lead->qaUsers as $qa)
                                            @php
                                                $words    = explode(' ', trim($qa->name));
                                                $initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
                                            @endphp
                                            <div class="user-row">
                                                <div class="rp-avatar av-amber">
                                                    {{ $initials }}
                                                    @if($qa->profile)
                                                        <img src="{{ asset('storage/' . $qa->profile) }}" alt="{{ $qa->name }}">
                                                    @endif
                                                </div>
                                                <div class="rp-info">
                                                    <span class="rp-name">{{ $qa->name }}</span>
                                                    <span class="rp-badge rpb-amber">QA Lead</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif

                                </div>
                            </div>
                        </div>

                    </div>
                        <div class="col-md-12">

                            <!-- HEADER -->
                            <div class="card-header custom-header">
                                <i class="mdi mdi-chart-bar menu-icon icon-head me-2"></i>
                                Notes and Documents
                            </div>

                            <div class="card-body">

                                <h5 class="mb-3">Activity</h5>

                                <!-- TIMELINE -->
                                @foreach($activities as $activity)

                                    <div class="mb-3 p-3 border rounded d-flex justify-content-between">

                                        <!-- LEFT CONTENT -->
                                        <div>

                                            {{-- NOTE --}}
                                                @if($activity['type'] === 'note')

                                                <strong>{{ $activity['data']->user->name }}</strong>

                                                <small class="text-muted">
                                                    {{ $activity['data']->created_at->diffForHumans() }}
                                                </small>

                                                <p class="mb-2"
                                                id="view-{{ $activity['data']->id }}"
                                                data-content="@js($activity['data']->content)">
                                                    {!! $activity['data']->content !!}
                                                </p>

                                                {{-- DOCUMENTS UNDER NOTE --}}
                                                    @if($activity['data']->documents->count())

                                                        <div class="mt-2">
                                                            @foreach($activity['data']->documents as $doc)

                                                                <i class="mdi mdi-file-document me-1 text-primary"></i>

                                                                <a href="{{ Storage::url($doc->file) }}" target="_blank">
                                                                    {{ $doc->file_name }}
                                                                </a>

                                                                <small class="text-muted">
                                                                    ({{ number_format($doc->file_size / 1024, 1) }} KB)
                                                                </small>

                                                                <br>
                                                            @endforeach
                                                        </div>
                                                    @endif

                                                @endif

                                            {{-- DOCUMENT --}}
                                            @if($activity['type'] === 'document')

                                                <i class="mdi mdi-file-document me-1 text-primary"></i>
                                                <a href="{{ Storage::url($activity['data']->file) }}" target="_blank">
                                                    {{ $activity['data']->file_name }}
                                                </a>

                                                <small class="text-muted">
                                                    ({{ number_format($activity['data']->file_size / 1024, 1) }} KB)
                                                </small>

                                            @endif

                                        </div>

                                        <!-- ACTIONS -->
                                        <div>

                                            {{-- EDIT NOTE --}}
                                            @if($activity['type'] === 'note')
                                                @if($activity['data']->user_id == auth()->id())

                                                <button type="button"
                                                        class="btn btn-link text-primary p-0"
                                                        onclick="editNote({{ $activity['data']->id }}, @js($activity['data']->content))">
                                                    <i class="mdi mdi-pencil"></i>
                                                </button>

                                                @endif
                                            @endif

                                            {{-- DELETE DOCUMENT --}}
                                                @if($activity['type'] === 'document')
                                                    @if(strtolower(auth()->user()->role->name) === 'super admin')

                                                        <form id="delete-form-{{ $activity['data']->id }}"
                                                            method="POST"
                                                            action="{{ route('documents.destroy', $activity['data']->id) }}"
                                                            style="display:none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>

                                                        <button type="button"
                                                                class="btn btn-link text-danger p-0"
                                                                onclick="confirmDelete({{ $activity['data']->id }})"
                                                                title="Delete Document">

                                                            <i class="mdi mdi-delete"></i>

                                                        </button>
                                                    @endif

                                                @endif

                                        </div>

                                    </div>

                                @endforeach

                                <hr>

                                <!-- COMMENT FORM -->
                                <form id="comment-form" method="POST"
                                    action="{{ route('notes.store') }}"
                                    enctype="multipart/form-data">

                                    @csrf
                                    <input type="hidden" name="lead_id" value="{{ $lead->id }}">

                                    <div id="create-editor" style="height:150px; background:#fff;"></div>
                                    <input type="hidden" name="content" id="create-content">
                                    <input type="hidden" id="edit-note-id" value="">
                                    <input type="file"
                                        name="files[]"
                                        multiple
                                        class="form-control mb-2">

                                    <button class="btn btn-primary">
                                        Sent
                                    </button>

                                </form>

                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Quill JS -->
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
let editors = {};

document.addEventListener("DOMContentLoaded", function () {

    // CREATE editor (ONLY ONCE)
    editors['create'] = new Quill('#create-editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ font: [] }, { size: [] }],                 // font & size
                ['bold', 'italic', 'underline', 'strike'],    // formatting
                [{ color: [] }, { background: [] }],          // text color
                [{ script: 'sub' }, { script: 'super' }],     // sub/superscript
                [{ header: 1 }, { header: 2 }, 'blockquote', 'code-block'],

                [{ list: 'ordered' }, { list: 'bullet' }],
                [{ indent: '-1' }, { indent: '+1' }],
                [{ align: [] }],

                ['link', 'image', 'video'],                   // media
                ['clean']                                     // remove formatting
            ]
        }
    });

    editors['create'].on('text-change', function () {
        document.getElementById('create-content').value =
            editors['create'].root.innerHTML;
    });

});
// EDIT editors
function initEditor(id) {

    const container = document.getElementById('editor-' + id);

    if (editors[id]) return;

    editors[id] = new Quill(container, {
        theme: 'snow',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline'],
                [{ list: 'ordered' }, { list: 'bullet' }],
                ['link'],
                ['clean']
            ]
        }
    });
}

function editNote(id, content) {

    const quill = editors['create'];

    quill.setContents([]);
    quill.clipboard.dangerouslyPasteHTML(content);

    document.getElementById('edit-note-id').value = id;

    document.getElementById('create-content').value = content;

    document.querySelector('#comment-form button').innerText = 'Update';

    document.getElementById('create-editor').scrollIntoView({
        behavior: 'smooth'
    });
}
function cancelEdit(id) {

    const view = document.getElementById('view-' + id);
    const form = document.getElementById('edit-form-' + id);

    view.classList.remove('d-none');
    form.classList.add('d-none');
}
function confirmDelete(id) {
    Swal.fire({
        title: "Are you sure?",
        text: "This document will be deleted permanently!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}
document.getElementById('comment-form').addEventListener('submit', function(e) {

    const editId = document.getElementById('edit-note-id').value;

    document.getElementById('create-content').value =
        editors['create'].root.innerHTML;

    if (editId) {

        this.action = `/notes/${editId}`;
        this.method = 'POST';

        // remove old _method if exists
        let old = this.querySelector('input[name="_method"]');
        if (old) old.remove();

        let methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'PUT';
        this.appendChild(methodInput);
    }
});
function resetEditor() {
    editors['create'].setContents([]);
    document.getElementById('edit-note-id').value = '';
    document.querySelector('#comment-form button').innerText = 'Comment';
}

    document.querySelectorAll('.status-container').forEach(container => {
    const badge    = container.querySelector('.status-badge');
    const dropdown = container.querySelector('.status-dropdown');
    const leadId   = container.dataset.leadId;

    function setColor(status) {
        badge.classList.remove(
            'status-not','status-progress','status-hold','status-lost','status-complete'
        );
        switch(status){
            case 'Not Started': badge.classList.add('status-not');      break;
            case 'In Progress': badge.classList.add('status-progress'); break;
            case 'Hold':        badge.classList.add('status-hold');     break;
            case 'Lost':        badge.classList.add('status-lost');     break;
            case 'Complete':    badge.classList.add('status-complete'); break;
        }
    }

    setColor(badge.innerText.replace(' ▼','').trim());

    badge.addEventListener('click', () => {
        dropdown.classList.toggle('d-none');
    });

    dropdown.querySelectorAll('.status-option').forEach(option => {
        option.addEventListener('click', () => {
            const status = option.dataset.value;
            badge.innerText = status + ' ▼';
            setColor(status);
            dropdown.classList.add('d-none');

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
                Swal.fire({ icon: 'error', title: 'Error', text: 'Update failed' });
            });
        });
    });
});

document.addEventListener('click', function(e){
    document.querySelectorAll('.status-dropdown').forEach(drop => {
        if (!drop.closest('.status-container').contains(e.target)) {
            drop.classList.add('d-none');
        }
    });
});
</script>
@endsection
