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



<p>Thank you for your redemption request.</p>

<br>

<p>Please be reminded that the fund administrator (FA) requires 10 business days’ notice before the upcoming Redemption Dealing Day to process your redemption request.  If the FA is not given the appropriate notice, redemption will normally take place on the next following Redemption Dealing Day.</p>

<br>

<p>The FA reserves the right to refuse to process a redemption request if any client identification or anti-money laundering compliance requirements remain outstanding.</p>

<br>

<p>Kindly contact us should you have any inquiries.</p>


<?php echo config('settings.mail_signature'); ?>


<?php if (isset($__componentOriginal2dab26517731ed1416679a121374450d5cff5e0d)): ?>
<?php $component = $__componentOriginal2dab26517731ed1416679a121374450d5cff5e0d; ?>
<?php unset($__componentOriginal2dab26517731ed1416679a121374450d5cff5e0d); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?><?php /**PATH /var/www/html/olympus-asset.com/public_html/resources/views/emails/redemptionRequestForUser.blade.php ENDPATH**/ ?>