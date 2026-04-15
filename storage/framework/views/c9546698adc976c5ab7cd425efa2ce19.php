<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Lead Update</title>
</head>
<body style="font-family: Arial; background:#f4f4f4; padding:20px;">

    <div style="background:#fff; padding:20px; border-radius:8px;">
        <h2><?php echo e($title); ?></h2>

        <p><?php echo e($messageText); ?></p>

        <hr>

        <p><strong>Lead Name:</strong> <?php echo e($lead->name); ?></p>
        <p><strong>Email:</strong> <?php echo e($lead->email); ?></p>
        <p><strong>Phone:</strong> <?php echo e($lead->phone); ?></p>

        <br>

        <p style="font-size:12px; color:#888;">
            you can view your lead here-
        </p>
        <a href="<?php echo e(url('/leads/'.$lead->id)); ?>"
        style="background:#007bff; color:#fff; padding:10px 15px; text-decoration:none; border-radius:5px;">
        View Lead
        </a>
    </div>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\lead-bridge\resources\views/emails/lead-status.blade.php ENDPATH**/ ?>