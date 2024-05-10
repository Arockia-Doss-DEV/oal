<?php $__env->startSection('title', 'Fund Received'); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid page-body-wrapper">

    <?php echo $__env->make("admin.elements.sidebar", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-lg-12 card-margin">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-10">
                                    <h4 class="card_title">Fund Received Investment</h4>
                                </div>
                            </div>

                            

                            <form method="get" class="needs-validation mt-3" action="<?php echo e(url('/fundReceived')); ?>">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label>Search By Investment ID, Name, Amount </label>
                                        <div class="input-group mb-3">
                                            <input type="text" name="q" placeholder="Search" class="form-control search-input" value="" autocomplete="off"/>
                                            <div class="input-group-append">
                                                <button type="submit" id="searchSubmitId" class="btn btn-soft-info"> 
                                                    <i data-feather="search"></i> 
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Class Type</label>
                                        <div class="input-group mb-3">
                                            <select id="class_type" class="form-control select2" name="class_type">
                                                <option value="">Select class ...</option>
                                                <option value="0">All</option>
                                                <?php $__currentLoopData = $investmentClasses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($class->id); ?>"><?php echo e($class->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <label>Investment Type</label>
                                        <div class="input-group mb-3">
                                            <select id="investment_type" class="form-control select2" name="investment_type">
                                                <option value="">Select investment type ...</option>
                                                <option value="3">All</option>
                                                <option value="1">Initial</option>
                                                <option value="0">Additional</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-2">
                                        <label></label>
                                        <div class="input-group mt-2">
                                            <div class="input-group-append">
                                                <button type="submit" id="searchSubmitId" class="btn btn-soft-primary"> 
                                                    <i data-feather="search"></i> 
                                                </button>
                                            </div>
                                            <input type="hidden" name="clear" class="form-control search-input" value="" autocomplete="off"/>
                                            <div class="input-group-append">
                                                <button type="submit" id="searchSubmitId" class="btn btn-soft-danger"> 
                                                    <i data-feather="x"></i> 
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div class="table-responsive mt-2">
                                <table id="example" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>INVESTMENT ID</th>
                                            <th>AMOUNT</th>
                                            <th>COMMENCEMENT DATE</th>
                                            <th>SUBMISSION DATE</th>
                                            <th>INVESTMENT CLASS</th>
                                            <th>INVESTMENT TYPE</th>
                                            <th>STATUS</th>
                                            <th>ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php if($subscriptions->count() > 0): ?>
                                        
                                        <?php $__currentLoopData = $subscriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subscription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        

                                        <tr>
                                            <td class="font-weight-bold">

                                                    <?php 
                                                        if (!empty($subscription->investment_name)) {
                                                            
                                                            if (($subscription->status == 3) || ($subscription->status == 6)) {
                                                                $investment_no = $subscription->investment_name;
                                                            } else {
                                                                $investment_no = $subscription->investment_name.$subscription->investment_no;
                                                            }
                                                        }else{
                                                            $investment_no = $subscription->investment_no;
                                                        }
                                   
                                                    ?>

                                                #<?php echo e($investment_no); ?> 
                                            </td>
                                            <td><?php echo e($subscription->amount); ?></td>

                                            <td>
                                                <?php
                                                    if(!empty($subscription->commencement_date)){
                                                        
                                                        echo date('d M, Y', strtotime($subscription->commencement_date));
                                                    }else{
                                                        echo "-";
                                                    } 
                                                ?>
                                            </td>

                                            <td>
                                                <?php
                                                    if(!empty($subscription->created_at)){
                                                        
                                                        echo date('d M, Y', strtotime($subscription->created_at));
                                                    }else{
                                                        echo "-";
                                                    } 
                                                ?>
                                            </td>

                                            <td>
                                                <?php if(!empty($subscription->investment_class_type)): ?>
                                                    <?php if($subscription->investment_class_type == 1): ?>
                                                        <span class="badge badge-success mt-2 mr-2 text-white">
                                                            <?php echo e($subscription->InvestmentClassAs['name']); ?>

                                                        </span>
                                                    <?php else: ?>
                                                        <span class="badge badge-info mt-2 mr-2">
                                                            <?php echo e($subscription->InvestmentClassAs['name']); ?>

                                                        </span>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <span class="badge badge-danger mt-2 mr-2">Not Updated</span>
                                                <?php endif; ?>
                                            </td>

                                            <td>
                                                <?php if($subscription->is_first == 0): ?>
                                                    <span class="badge badge-success mt-2 mr-2 text-white">ADDITIONAL</span>
                                                <?php else: ?>
                                                    <span class="badge badge-info mt-2 mr-2">INITIAL</span>
                                                <?php endif; ?>
                                            </td>

                                            <td>

                                                <?php
                                                    if($subscription->status == 1){
                                                        echo '<span class="badge badge-soft-info mt-2 mr-2"> Pending</span>';
                                                    }else if($subscription->status == 2){
                                                        echo '<span class="badge badge-soft-primary mt-2 mr-2"> Pending Funding</span>';
                                                    }else if($subscription->status == 3){
                                                        echo '<span class="badge badge-soft-success mt-2 mr-2"> Active</span>';
                                                    }else if($subscription->status == 4){
                                                        echo '<span class="badge badge-soft-danger mt-2 mr-2"> Deactive</span>';
                                                    }else if($subscription->status == 5){
                                                        echo '<span class="badge badge-soft-danger mt-2 mr-2"> Rejected</span>';
                                                    }else if($subscription->status == 6){
                                                        echo '<span class="badge badge-soft-info mt-2 mr-2"> Matured</span>';
                                                    }else if($subscription->status == 7){
                                                        echo '<span class="badge badge-soft-danger mt-2 mr-2"> Re-Investmented</span>';
                                                    }else if($subscription->status == 8){
                                                        echo '<span class="badge badge-soft-info mt-2 mr-2"> Payment Received</span>';
                                                    }else if($subscription->status == 9){
                                                        echo '<span class="badge badge-soft-info mt-2 mr-2"> Fund Received</span>';
                                                    }else{
                                                        echo '<span class="badge badge-soft-info mt-2 mr-2"> Draft</span>';
                                                    }
                                                ?>


                                                
                                                
                                            </td>

                                            

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

                                    <?php else: ?>

                                      <tr><td colspan=8 align="center">No Records Available..</td></tr>
                                    <?php endif; ?>

                                    </tbody>
                                </table>
                            </div>
                            
                            <br>
                            <?php echo $subscriptions->links('pagination::bootstrap-4'); ?> 
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php echo $__env->make('admin.elements.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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






<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/olympus-asset.com/public_html/resources/views/admin/fundReceived.blade.php ENDPATH**/ ?>