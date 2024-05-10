<?php $__env->startComponent('mail::message'); ?>

<?php
    $salutation = '';

    if ( $data->salutation == "Mr." ) {
        $salutation = "Sir";
    } elseif ( $data->salutation == "Mrs." ) {
        $salutation = "Madam";
    } else {
        $salutation = $data->salutation;
    }
?>

<h3>Dear <?php echo e($data->salutation); ?> <?php echo e($data->name); ?>,<h3>



<p>We have received your request to change your bank details in the system. We shall update your bank details accordingly within a week.</p>

<br>
<p>Please get in touch with us if you do not request the change.</p>

<?php echo config('settings.mail_signature'); ?>


<?php if (isset($__componentOriginal2dab26517731ed1416679a121374450d5cff5e0d)): ?>
<?php $component = $__componentOriginal2dab26517731ed1416679a121374450d5cff5e0d; ?>
<?php unset($__componentOriginal2dab26517731ed1416679a121374450d5cff5e0d); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?><?php /**PATH /var/www/html/olympus-asset.com/public_html/resources/views/emails/changeBankDetailsRequestForUser.blade.php ENDPATH**/ ?>