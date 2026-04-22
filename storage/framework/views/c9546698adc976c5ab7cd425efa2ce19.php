<?php $__env->startSection('content'); ?>


<table width="100%" cellpadding="0" cellspacing="0">
<tr>
    <td align="center" style="background:#0d2c6c;padding:28px;">

        
        <div style="display:inline-block;margin:0 auto 14px;">
            <?php if(isset($lead) && $lead): ?>
                <?php $status = strtolower($lead->status ?? ''); ?>
                <?php if($status === 'completed'): ?>
                    <span style="background:rgba(255,255,255,0.15);color:#ffffff;font-size:11px;font-weight:600;padding:5px 14px;border-radius:20px;letter-spacing:0.05em;text-transform:uppercase;">Completed</span>
                <?php elseif($status === 'lost'): ?>
                    <span style="background:rgba(255,255,255,0.15);color:#ffffff;font-size:11px;font-weight:600;padding:5px 14px;border-radius:20px;letter-spacing:0.05em;text-transform:uppercase;">Lost</span>
                <?php else: ?>
                    <span style="background:rgba(255,255,255,0.15);color:#ffffff;font-size:11px;font-weight:600;padding:5px 14px;border-radius:20px;letter-spacing:0.05em;text-transform:uppercase;">Lead Update</span>
                <?php endif; ?>
            <?php else: ?>
                <span style="background:rgba(255,255,255,0.15);color:#ffffff;font-size:11px;font-weight:600;padding:5px 14px;border-radius:20px;letter-spacing:0.05em;text-transform:uppercase;">Bulk Assign</span>
            <?php endif; ?>
        </div>

        <p style="color:#ffffff;font-size:17px;font-weight:600;margin:0 0 4px;"><?php echo e($title); ?></p>
        <p style="color:rgba(255,255,255,0.6);font-size:13px;margin:0;"><?php echo e($messageText); ?></p>
    </td>
</tr>
</table>


<table width="100%" cellpadding="0" cellspacing="0">
<tr>
    <td style="padding:28px;">

       
        <?php if(isset($count) && $count): ?>
        <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:20px;">
        <tr>
            <td align="center">
                <table cellpadding="0" cellspacing="0" style="background:#e8edf7;border-radius:8px;">
                <tr>
                    <td style="padding:14px 32px;text-align:center;">
                        <p style="font-size:11px;font-weight:600;color:#6b7280;text-transform:uppercase;letter-spacing:0.06em;margin:0 0 4px;">Total Leads Assigned</p>
                        <p style="font-size:28px;font-weight:700;color:#0d2c6c;margin:0;"><?php echo e($count); ?></p>
                    </td>
                </tr>
                </table>
            </td>
        </tr>
        </table>
        <?php endif; ?>

        
        <?php if(isset($lead) && $lead): ?>
        <p style="font-size:11px;font-weight:600;color:#9ca3af;text-transform:uppercase;letter-spacing:0.06em;margin:0 0 10px;">Lead details</p>

        <table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #f3f4f6;border-radius:8px;overflow:hidden;margin-bottom:24px;">
            <tr>
                <td style="padding:11px 14px;background:#fafafa;border-bottom:1px solid #f3f4f6;">
                    <table width="100%" cellpadding="0" cellspacing="0"><tr>
                        <td style="font-size:12px;color:#9ca3af;">Name</td>
                        <td align="right" style="font-size:13px;color:#111827;font-weight:600;"><?php echo e($lead->name); ?></td>
                    </tr></table>
                </td>
            </tr>
            <tr>
                <td style="padding:11px 14px;background:#fafafa;border-bottom:1px solid #f3f4f6;">
                    <table width="100%" cellpadding="0" cellspacing="0"><tr>
                        <td style="font-size:12px;color:#9ca3af;">Email</td>
                        <td align="right" style="font-size:13px;color:#111827;font-weight:500;"><?php echo e($lead->email); ?></td>
                    </tr></table>
                </td>
            </tr>
            <tr>
                <td style="padding:11px 14px;background:#fafafa;border-bottom:1px solid #f3f4f6;">
                    <table width="100%" cellpadding="0" cellspacing="0"><tr>
                        <td style="font-size:12px;color:#9ca3af;">Phone</td>
                        <td align="right" style="font-size:13px;color:#111827;font-weight:500;"><?php echo e($lead->phone); ?></td>
                    </tr></table>
                </td>
            </tr>
            <tr>
                <td style="padding:11px 14px;background:#fafafa;">
                    <table width="100%" cellpadding="0" cellspacing="0"><tr>
                        <td style="font-size:12px;color:#9ca3af;">Status</td>
                        <td align="right">
                            <span style="font-size:11px;font-weight:600;background:#e8edf7;color:#0d2c6c;padding:3px 10px;border-radius:20px;">
                                <?php echo e(ucfirst($lead->status ?? 'N/A')); ?>

                            </span>
                        </td>
                    </tr></table>
                </td>
            </tr>
        </table>
        <?php endif; ?>

        
        <?php if(isset($lead) && $lead): ?>
        <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <a href="<?php echo e(url('/leads/' . $lead->id)); ?>"
                   style="display:inline-block;background:#0d2c6c;color:#ffffff;text-decoration:none;padding:12px 32px;border-radius:8px;font-size:14px;font-weight:600;">
                    View Lead &rarr;
                </a>
            </td>
        </tr>
        </table>
        <?php else: ?>
        <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <a href="<?php echo e(url('/leads')); ?>"
                   style="display:inline-block;background:#0d2c6c;color:#ffffff;text-decoration:none;padding:12px 32px;border-radius:8px;font-size:14px;font-weight:600;">
                    View All Leads &rarr;
                </a>
            </td>
        </tr>
        </table>
        <?php endif; ?>

    </td>
</tr>
</table>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('emails.layout_email', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\lead-bridge\resources\views/emails/lead-status.blade.php ENDPATH**/ ?>