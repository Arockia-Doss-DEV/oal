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

<p>We are pleased to inform you that your subscription has commenced this month. The fund administrator (FA) emailed you the subscription confirmation note (Contract Note) in a separate email.</p>

<p>Please refer to the Contract Note or login to the CRM for more details.</p>
 

    
<p>Please do not hesitate to contact us if you have any inquiries.</p>


<?php echo config('settings.mail_signature'); ?>



<?php if (isset($__componentOriginal2dab26517731ed1416679a121374450d5cff5e0d)): ?>
<?php $component = $__componentOriginal2dab26517731ed1416679a121374450d5cff5e0d; ?>
<?php unset($__componentOriginal2dab26517731ed1416679a121374450d5cff5e0d); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?><?php /**PATH /var/www/html/olympus-asset.com/public_html/resources/views/emails/activeInvestmentMail.blade.php ENDPATH**/ ?>