<?php $__env->startSection('title', 'Reinvestment Request'); ?>

<?php $__env->startSection('content'); ?>

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
                                    <h4 class="card_title">Reinvestment Request</h4>
                                </div>
                            </div>

                            <form method="get" class="needs-validation mt-3" action="<?php echo e(url("/reinvestment")); ?>">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <h6 class="panel-title text-semibold">Search By Investment No</h6>
                                        <input type="text" name="q" autocomplete="off" placeholder="Search ..." class="form-control" value="">
                                    </div>
                                    <div class="col-md-1 mb-3">
                                        <h6 class="panel-title text-semibold">&nbsp;</h6>
                                        <div class="submit">
                                            <input type="submit" id="searchSubmitId" class="btn btn-primary" value="Search">
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div class="single-table">
                                <div class="table-responsive datatable-primary">
                                    <table id="dataTable2" class="table table-hover progress-table ">
                                        <thead class="text-uppercase">
                                            <tr>
                                                <th>INVESTMENT ID</th>
                                                <th>AMOUNT</th>
                                                <th>COMMENCEMENT DATE</th>
                                                <th>SUBMISSION DATE</th>
                                                <th>STATUS</th>
                                                <th>ACTIONS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $subscriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subscription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($subscription->investment_name); ?></td>
                                                <td><?php echo e($subscription->amount); ?></td>
                                                <td><?php echo e($subscription->commencement_date ? date('d-M-y', strtotime($subscription->commencement_date))  : ''); ?></td>
                                                <td><?php echo e($subscription->created_at ? $subscription->created_at->format('d-M-Y')  : ''); ?></td>
                                                <td> <span class="badge badge-danger mt-2 mr-2">Active</span> </td>

                                                

                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-soft-primary shadow-none dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action
                                                        </button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('subscription-view')): ?>
                                                            <li class="dropdown-item"><a class="btn btn-success btn-sm mt-1 mr-1 text-white" href="<?php echo e(url('subscriptionView/'.$subscription->id)); ?>">Show</a>
                                                            </li>
                                                        <?php endif; ?>

                                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('subscription-edit')): ?>
                                                            <li class="dropdown-item"> <a class="btn btn-warning btn-sm mt-1 mr-1 text-white" href="<?php echo e(url('subscriptionEdit/'.$subscription->id)); ?>">Edit</a>
                                                            </li>
                                                        <?php endif; ?>

                                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('subscription-delete')): ?>
                                                            <li class="dropdown-item"><a class="deleteSubConfirmButton btn btn-danger btn-sm mt-1 mr-1 text-white" href="#" attr-subID="<?php echo e($subscription->id); ?>">Delete</a>
                                                            </li>
                                                        <?php endif; ?>
                                                        </ul>
                                                    </div>
                                                </td>
                                            
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>

                                <?php echo e($subscriptions->links()); ?>

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

<?php $__env->startSection('scripts'); ?>

<script type="text/javascript">
    $(document).on("click",".deleteSubConfirmButton",function() {
            
        const subs_id = $(this).attr('attr-subID');
        Swal.fire({
            title: 'Are you sure?',
            text: "Please confirm do you want to delete the subscription!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.value) {
                
                var csrfToken = "<?php echo e(csrf_token()); ?>";
                let formData = new FormData();
                formData.set('id', subs_id);
                axios.post(SITE_URL+'deleteSubscription',formData,{
                        headers: {
                            'Content-Type': 'multipart/form-data',
                            'X-CSRF-Token': csrfToken}}
                ).then(function (response) {
                    Swal.fire('Great Job !','You Successfully Deleted the Subscription.','success');
                    setTimeout(location.reload.bind(location), 1500);
                });
            }
        });
    });
</script>

<?php $__env->stopSection(); ?>







<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/olympus-asset.com/public_html/resources/views/admin/reinvestment_request.blade.php ENDPATH**/ ?>