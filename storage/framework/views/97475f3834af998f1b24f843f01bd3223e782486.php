<?php $__env->startComponent('mail::message'); ?>
    
<h1>Reset 2FA Google Authenticator:</h1>
   
You can reset the code from this link:
<a href="<?php echo e(route('reset.twofa.get', $data->token)); ?>">Reset 2FA</a>

<?php echo config('settings.mail_signature'); ?>


<?php if (isset($__componentOriginal2dab26517731ed1416679a121374450d5cff5e0d)): ?>
<?php $component = $__componentOriginal2dab26517731ed1416679a121374450d5cff5e0d; ?>
<?php unset($__componentOriginal2dab26517731ed1416679a121374450d5cff5e0d); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?><?php /**PATH /var/www/html/olympus-asset.com/public_html/resources/views/emails/forget2FaPassword.blade.php ENDPATH**/ ?>