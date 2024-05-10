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
                                	
<p>Thank you for your additional investment application.</p>

<p>The reviewing process of your application will be less than 5 working days</p>

<p>Please do not hesitate to contact us should you need any further clarification.</p>
<br>

<?php echo config('settings.mail_signature'); ?>


<?php if (isset($__componentOriginal2dab26517731ed1416679a121374450d5cff5e0d)): ?>
<?php $component = $__componentOriginal2dab26517731ed1416679a121374450d5cff5e0d; ?>
<?php unset($__componentOriginal2dab26517731ed1416679a121374450d5cff5e0d); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?><?php /**PATH /var/www/html/olympus-asset.com/public_html/resources/views/emails/newAdditionalInvestmentEmailForInvester.blade.php ENDPATH**/ ?>