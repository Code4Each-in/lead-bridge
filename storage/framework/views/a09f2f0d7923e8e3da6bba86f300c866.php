<?php $__env->startSection('content'); ?>

<p>Hello <?php echo e($user->name); ?>,</p>

<p>
    A new <b><?php echo e($type); ?></b> was added to Lead:
    <b>#<?php echo e($lead->id); ?></b>
</p>

<?php if(!empty($body)): ?>
<p>
    <?php echo e($body); ?>

</p>
<?php endif; ?>

<a href="<?php echo e(url('/leads/' . $lead->id)); ?>">
    👉 View Lead
</a>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('emails.layout_email', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\lead-bridge\resources\views/emails/lead_activity.blade.php ENDPATH**/ ?>