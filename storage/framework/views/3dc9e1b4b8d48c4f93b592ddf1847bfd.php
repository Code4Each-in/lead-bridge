<!DOCTYPE html>
<html lang="en">
<head>
<?php echo $__env->make('includes.css', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</head>
<body>
 <div class="container-scroller">
     <?php echo $__env->make('includes.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="container-fluid page-body-wrapper">
      <?php echo $__env->make('includes.rightsidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
      <?php echo $__env->make('includes.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
      <div class="main-panel">
        <div class="content-wrapper">
          <?php echo $__env->yieldContent('content'); ?>
        </div>
        </div>
    </div>
</div>
    <?php echo $__env->make('includes.jss', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <script type="text/javascript">
    $(document).ready(function() {});
    </script>
    <?php echo $__env->yieldContent('js_scripts'); ?>
    <script>
    $(document).ready(function () {
        $('.select2-basic').select2({
            width: '100%'
        });
    });


</script>
<?php if(session('success')): ?>
<script>
Swal.fire({
    icon: 'success',
    title: 'Success!',
    text: <?php echo json_encode(session('success'), 15, 512) ?>,
    timer: 2500,
    showConfirmButton: false,
    background: '#ffffff',
    color: '#2c3e50',
    iconColor: '#28a745',
    customClass: {
        popup: 'swal-rounded'
    }
});
</script>
<?php endif; ?>
<?php if(session('error')): ?>
<script>
Swal.fire({
    icon: 'error',
    title: 'Access Denied',
    text: <?php echo json_encode(session('error'), 15, 512) ?>,
    confirmButtonText: 'Okay',
    confirmButtonColor: '#e74c3c',
    background: '#fff',
    color: '#2c3e50',
    iconColor: '#e74c3c',
    customClass: {
        popup: 'swal-rounded'
    }
});
</script>
<?php endif; ?>
</body>

</html>
<?php /**PATH C:\xampp\htdocs\lead-bridge\resources\views/layout.blade.php ENDPATH**/ ?>