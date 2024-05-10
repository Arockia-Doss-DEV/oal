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

<p>We are pleased to inform you that all documents are in order for the <?php echo e($data->investment_class); ?> fund application.</p>

<?php if($data->investment_type == 1): ?>

<p>Kindly transfer your funds to Zetland's escrow account before the 10th of the last month of the current quarter if you wish to have your investment start after the upcoming valuation cycle.</p>

<?php elseif($data->investment_type == 2): ?>
	
<p>Kindly transfer your funds to Zetland's escrow account before the next 10th of the month if you wish to have your investment start after the upcoming valuation cycle.</p>

<?php else: ?>

<p>Kindly transfer your funds to Zetland's escrow account before 14th Dec 2022. Zetland Consultants Pte Ltd is our appointed escrow agent.</p>

<?php endif; ?>

<p>We enclosed a copy of the bank instruction letter for your reference.</p>

<p>** Kindly upload the wire transfer slip to the CRM as proof of funding.</p>

<p>Here are the steps to guide you through the process:</p>
<p>i) Log in to the CRM portal.</p>
<p>ii) Select the “Upload Doc” option.</p> 
<p>iii) Upload the wire transfer slip using the designated Upload button.</p>
<p>iv) Finalize the process by clicking the “Submit” button. </p>

<p>Should you have any questions, please do not hesitate to contact us.</p>             

<?php echo config('settings.mail_signature'); ?>


<?php if (isset($__componentOriginal2dab26517731ed1416679a121374450d5cff5e0d)): ?>
<?php $component = $__componentOriginal2dab26517731ed1416679a121374450d5cff5e0d; ?>
<?php unset($__componentOriginal2dab26517731ed1416679a121374450d5cff5e0d); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?><?php /**PATH /var/www/html/olympus-asset.com/public_html/resources/views/emails/pendingFundingMail.blade.php ENDPATH**/ ?>