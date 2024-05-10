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
                                
<p>Kindly be informed that Zetland has received your fund, USD <?php echo e($data->investment_amount); ?>.  After the fund valuation is completed, Mauri Experta, the fund administrator, will email the new Contract Note to you.  
</p>

<p>Please do not hesitate to contact us if you have any inquiries.</p>

<?php echo config('settings.mail_signature'); ?>


<?php if (isset($__componentOriginal2dab26517731ed1416679a121374450d5cff5e0d)): ?>
<?php $component = $__componentOriginal2dab26517731ed1416679a121374450d5cff5e0d; ?>
<?php unset($__componentOriginal2dab26517731ed1416679a121374450d5cff5e0d); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?><?php /**PATH /var/www/html/olympus-asset.com/public_html/resources/views/emails/fundReceivedMail.blade.php ENDPATH**/ ?>