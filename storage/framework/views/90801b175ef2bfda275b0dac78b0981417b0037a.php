<?php $__env->startComponent('mail::message'); ?>

<center><h1>User Contact Information</h1></center>

<p>User Firstname - <?php echo e($data->firstname); ?></p>
<p>User Lastname - <?php echo e($data->lastname); ?></p>
<p>Phone Number - +<?php echo $data->mobile_prefix; ?> <?php echo $data->mobile_no; ?></p>
<p>Email - <?php echo e($data->user_email); ?></p>
<p>Message - <?php echo $data->message; ?></p>



<?php if (isset($__componentOriginal2dab26517731ed1416679a121374450d5cff5e0d)): ?>
<?php $component = $__componentOriginal2dab26517731ed1416679a121374450d5cff5e0d; ?>
<?php unset($__componentOriginal2dab26517731ed1416679a121374450d5cff5e0d); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?><?php /**PATH /var/www/html/olympus-asset.com/public_html/resources/views/emails/contactUsMail.blade.php ENDPATH**/ ?>