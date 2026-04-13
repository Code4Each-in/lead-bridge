<?php $__env->startSection('title', 'Leads'); ?>
<?php $__env->startSection('subtitle', 'Leads'); ?>
<?php $__env->startSection('content'); ?>
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
                                    <?php echo e($lead->name ?? 'Lead Name'); ?>

                                </div>

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
                                        <span><?php echo e($lead->start_date ?? '---'); ?></span>
                                    </div>

                                    <div class="detail-row">
                                        <i class="mdi mdi-calendar-clock"></i>
                                        <span class="label">End date:</span>
                                        <span><?php echo e($lead->end_date ?? '---'); ?></span>
                                    </div>

                                    <div class="detail-row">
                                        <i class="mdi mdi-file-excel"></i>
                                        <span class="label">Notes:</span>
                                        <span style="color:#6b7280; font-size:13px;"><?php echo e($lead->notes ?? '---'); ?></span>
                                    </div>

                                    <div class="detail-item">
                                        <i class="mdi mdi-file-document"></i>
                                        <span class="label">Documents:</span>
                                        <span style="margin-left: 8px;">
                                        <?php
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
                                        ?>

                                        <?php if(empty($documents)): ?>
                                            <span style="color:#9ca3af; font-size:13px;">No documents uploaded</span>
                                        <?php else: ?>
                                            <?php $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                    $ext  = pathinfo(trim($doc), PATHINFO_EXTENSION);
                                                    $icon = $icons[strtolower($ext)] ?? 'mdi mdi-file';
                                                ?>
                                                <button class="btn btn-outline-primary btn-sm mb-1"
                                                    title="<?php echo e(trim($doc)); ?>"
                                                    onclick="window.open('<?php echo e(asset('storage/' . trim($doc))); ?>', '_blank')">
                                                    <i class="<?php echo e($icon); ?>"></i>
                                                </button>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                        </span>
                                    </div>

                                    <div class="detail-row">
                                        <i class="mdi mdi-information-outline"></i>
                                        <span class="label">Status:</span>

                                        <div class="status-container" data-lead-id="<?php echo e($lead->id); ?>">
                                            <span class="status-badge">
                                                <?php echo e($lead->status ?? 'Not Started'); ?> ▼
                                            </span>

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

                        <!-- RIGHT: Users — redesigned -->
                        <div class="col-md-4 mb-4">
                            <div class="card custom-card h-100">

                                <div class="card-header custom-header">
                                    <i class="fa-solid fa-users me-2 icon-head"></i>
                                    Lead Overview
                                </div>

                                <div class="card-body px-3 py-2">

                                    <!-- Created By -->
                                    <?php if($lead->creator): ?>
                                        <?php
                                            $words    = explode(' ', trim($lead->creator->name));
                                            $initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
                                        ?>
                                        <div class="rp-section">Created by</div>
                                        <div class="user-row">
                                            <div class="rp-avatar av-blue">
                                                <?php echo e($initials); ?>

                                                <?php if($lead->creator->profile): ?>
                                                    <img src="<?php echo e(asset('storage/' . $lead->creator->profile)); ?>" alt="<?php echo e($lead->creator->name); ?>">
                                                <?php endif; ?>
                                            </div>
                                            <div class="rp-info">
                                                <span class="rp-name"><?php echo e($lead->creator->name); ?></span>
                                                <span class="rp-badge rpb-blue">Created Lead</span>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Assigned To -->
                                    <?php if($lead->users->count()): ?>
                                        <div class="rp-section">Assigned to</div>
                                        <?php $__currentLoopData = $lead->users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $words    = explode(' ', trim($user->name));
                                                $initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
                                            ?>
                                            <div class="user-row">
                                                <div class="rp-avatar av-green">
                                                    <?php echo e($initials); ?>

                                                    <?php if($user->profile): ?>
                                                        <img src="<?php echo e(asset('storage/' . $user->profile)); ?>" alt="<?php echo e($user->name); ?>">
                                                    <?php endif; ?>
                                                </div>
                                                <div class="rp-info">
                                                    <span class="rp-name"><?php echo e($user->name); ?></span>
                                                    <span class="rp-badge rpb-green">Assigned Lead</span>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>

                                    <!-- QA Users -->
                                    <?php if($lead->qaUsers->count()): ?>
                                        <div class="rp-section">Quality Assurance</div>
                                        <?php $__currentLoopData = $lead->qaUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $qa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $words    = explode(' ', trim($qa->name));
                                                $initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
                                            ?>
                                            <div class="user-row">
                                                <div class="rp-avatar av-amber">
                                                    <?php echo e($initials); ?>

                                                    <?php if($qa->profile): ?>
                                                        <img src="<?php echo e(asset('storage/' . $qa->profile)); ?>" alt="<?php echo e($qa->name); ?>">
                                                    <?php endif; ?>
                                                </div>
                                                <div class="rp-info">
                                                    <span class="rp-name"><?php echo e($qa->name); ?></span>
                                                    <span class="rp-badge rpb-amber">QA Lead</span>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>

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
                                <?php $__currentLoopData = $activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <div class="mb-3 p-3 border rounded d-flex justify-content-between">

                                        <!-- LEFT CONTENT -->
                                        <div>

                                            
                                                <?php if($activity['type'] === 'note'): ?>

                                                <strong><?php echo e($activity['data']->user->name); ?></strong>

                                                <small class="text-muted">
                                                    <?php echo e($activity['data']->created_at->diffForHumans()); ?>

                                                </small>

                                                <p class="mb-2"
                                                id="view-<?php echo e($activity['data']->id); ?>"
                                                data-content="<?php echo \Illuminate\Support\Js::from($activity['data']->content)->toHtml() ?>">
                                                    <?php echo $activity['data']->content; ?>

                                                </p>

                                                
                                                    <?php if($activity['data']->documents->count()): ?>

                                                        <div class="mt-2">
                                                            <?php $__currentLoopData = $activity['data']->documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                                <i class="mdi mdi-file-document me-1 text-primary"></i>

                                                                <a href="<?php echo e(Storage::url($doc->file)); ?>" target="_blank">
                                                                    <?php echo e($doc->file_name); ?>

                                                                </a>

                                                                <small class="text-muted">
                                                                    (<?php echo e(number_format($doc->file_size / 1024, 1)); ?> KB)
                                                                </small>

                                                                <br>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </div>
                                                    <?php endif; ?>

                                                <?php endif; ?>

                                            
                                            <?php if($activity['type'] === 'document'): ?>

                                                <i class="mdi mdi-file-document me-1 text-primary"></i>
                                                <a href="<?php echo e(Storage::url($activity['data']->file)); ?>" target="_blank">
                                                    <?php echo e($activity['data']->file_name); ?>

                                                </a>

                                                <small class="text-muted">
                                                    (<?php echo e(number_format($activity['data']->file_size / 1024, 1)); ?> KB)
                                                </small>

                                            <?php endif; ?>

                                        </div>

                                        <!-- ACTIONS -->
                                        <div>

                                            
                                            <?php if($activity['type'] === 'note'): ?>
                                                <?php if($activity['data']->user_id == auth()->id()): ?>

                                                <button type="button"
                                                        class="btn btn-link text-primary p-0"
                                                        onclick="editNote(<?php echo e($activity['data']->id); ?>, <?php echo \Illuminate\Support\Js::from($activity['data']->content)->toHtml() ?>)">
                                                    <i class="mdi mdi-pencil"></i>
                                                </button>

                                                <?php endif; ?>
                                            <?php endif; ?>

                                            
                                                <?php if($activity['type'] === 'document'): ?>
                                                    <?php if(strtolower(auth()->user()->role->name) === 'super admin'): ?>

                                                        <form id="delete-form-<?php echo e($activity['data']->id); ?>"
                                                            method="POST"
                                                            action="<?php echo e(route('documents.destroy', $activity['data']->id)); ?>"
                                                            style="display:none;">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('DELETE'); ?>
                                                        </form>

                                                        <button type="button"
                                                                class="btn btn-link text-danger p-0"
                                                                onclick="confirmDelete(<?php echo e($activity['data']->id); ?>)"
                                                                title="Delete Document">

                                                            <i class="mdi mdi-delete"></i>

                                                        </button>
                                                    <?php endif; ?>

                                                <?php endif; ?>

                                        </div>

                                    </div>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <hr>

                                <!-- COMMENT FORM -->
                                <form id="comment-form" method="POST"
                                    action="<?php echo e(route('notes.store')); ?>"
                                    enctype="multipart/form-data">

                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="lead_id" value="<?php echo e($lead->id); ?>">

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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\lead-bridge\resources\views/leads/show.blade.php ENDPATH**/ ?>