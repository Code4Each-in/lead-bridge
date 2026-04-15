<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo e($subject ?? config('app.name')); ?></title>
</head>

<body style="margin:0; padding:0; background:#f6f8fb; font-family:Arial;">

<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td align="center">

<!-- CARD -->
<table width="600" style="background:#ffffff; margin:20px auto; border-radius:12px; overflow:hidden;">

    <!-- HEADER -->
    <tr>
        <td style="background:#0d2c6c; padding:25px; text-align:center;">
            <img src="<?php echo e(asset('images/leadbridge_logo.svg')); ?>" height="45">
        </td>
    </tr>

    <!-- BODY -->
    <tr>
        <td style="padding:30px;">
            <?php echo $__env->yieldContent('content'); ?>
        </td>
    </tr>

    <!-- FOOTER -->
    <tr>
        <td style="background:#f1f3f6; padding:15px; text-align:center; font-size:12px; color:#666;">
            © <?php echo e(date('Y')); ?> <?php echo e(config('app.name')); ?> — All rights reserved.
        </td>
    </tr>

</table>

</td>
</tr>
</table>

</body>
</html>             
<?php /**PATH C:\xampp\htdocs\lead-bridge\resources\views/emails/layout_email.blade.php ENDPATH**/ ?>