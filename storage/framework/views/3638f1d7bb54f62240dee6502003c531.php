<?php $__env->startSection('content'); ?>

<h2 style="color:#0d2c6c;">Welcome to <?php echo e(config('app.name')); ?> 🎉</h2>

<h2>Welcome <?php echo e($user->name); ?></h2>

<p><strong>Email:</strong> <?php echo e($user->email); ?></p>

<p><strong>Role:</strong> <?php echo e($user->role->name ?? 'User'); ?></p>

<p><strong>Password:</strong> <?php echo e($password); ?></p>

<p><strong>Agency:</strong> <?php echo e($user->agency->agency_name ?? 'N/A'); ?></p>

<p><strong>City:</strong> <?php echo e($user->city ?? 'N/A'); ?></p>

<hr>

<a href="<?php echo e($loginUrl); ?>"
   style="padding:10px 15px;background:#0d2c6c;color:#fff;text-decoration:none;">
   Login Now
</a>

<p>Thanks,<br><strong><?php echo e(config('app.name')); ?> Team</strong></p>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('emails.layout_email', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\lead-bridge\resources\views/emails/user_created.blade.php ENDPATH**/ ?>