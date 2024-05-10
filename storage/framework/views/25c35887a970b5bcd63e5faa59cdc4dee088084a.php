<?php $__env->startSection('title', 'Subscription Update'); ?>

<?php $__env->startSection('content'); ?>
<script src="<?php echo e(asset('common/js/jSignature.min.js')); ?>"></script>

<div class="main-container">
    <div class="container-fluid">
        
        <?php echo $__env->make("admin.elements.sidebar", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <div class="main-panel">
            <!-- content-wrapper Starts -->
            <div class="content-wrapper">
                <!-- design1 -->
                <div class="col-lg-12 card-margin">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-10">
                                </div>
                                <div class="col-md-2">
                                    <a class="btn btn-secondary" href="#" onclick="location.href = document.referrer; return false;" style="float: right"><i class="fa fa-angle-double-left"></i> Back</a>
                                </div>
                            </div>
                            <br>

                            <div class="row">
                                <div class="col-lg-12 col-md-12 ">
                                    <div class="card card-margin">
                                        <div class="card-header signup-card-header">
                                            <h5 class="card-title"> SUBSCRIPTION FORM UPDATE</h5>                                 
                                        </div>
                                        <div class="card-body">
                                             <?php echo Form::open(['url' => '/subscriptionEditSave', 'files' => true, 'id' => 'subscriptionform', 'data-parsley-validate' => 'data-parsley-validate', "data-parsley-trigger"=>"keyup", 'autocomplete'=>"off" ]); ?>

                                                
                                                <?php echo Form::hidden('subId', $subscription['id']); ?>

                                                <input type="hidden" name="subscriptionId" id="subscriptionId" value="<?php echo e($subscription['id']); ?>">
                                                
                                                <?php if(!empty($userData)): ?>
                                                    <input type="hidden" name="user_id" id="user_id" value="<?php echo e($userData['id']); ?>">
                                                <?php endif; ?>

                                                <div>
                                                    <h3>SUBSCRIBER DETAILS</h3>
                                                    <section>
                                                        <h4>SUBSCRIBER DETAILS</h4>
                                                        <div class="row">
                                                                <?php echo $__env->make("admin.elements.editSubscription.editSubscription", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                        </div>
                                                    </section>

                                                    <h3>ADDITIONAL DETAILS</h3>
                                                    <section>
                                                        <h4>LEAD CONTACT DETAILS</h4>

                                                        <?php echo $__env->make("admin.elements.editSubscription.editAdditional", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                    </section>

                                                    <h3>DOCUMENTS</h3>
                                                    <section>
                                                        

                                                        <h4>CERTIFIED SUPPORTING DOCUMENTS</h4>
                                                        <?php echo $__env->make("admin.elements.editSubscription.editDocument", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                    </section>

                                                </div>
                                            <?php echo e(Form::close()); ?>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <?php echo $__env->make('admin.elements.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.elements.editSubscriptionScript', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/olympus-asset.com/public_html/resources/views/admin/subscriptionEdit.blade.php ENDPATH**/ ?>