<?php $__env->startSection('title', 'Investor View'); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid page-body-wrapper">

    <?php echo $__env->make("admin.elements.sidebar", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="main-panel">
        <div class="content-wrapper">

            <div class="page-header-container">
                <div class="page-header-main">
                    <div class="page-title">Investor Details & Subscriptions</div>
                    <div class="header-breadcrumb">
                        <a href="#"><i data-feather="airplay"></i> Show</a>
                    </div>
                </div>
                <div class="page-header-action">
                     
                    



                    




                    

                    

                    




                                        
                    <button type="button" class="btn btn-primary mt-1 mr-1 text-white" onclick="location.href = '<?php echo e(route('createNewInvestorSubscription', ['classId' => @$check_investment_class->investment_class_type, 'userId' => @$user->id, 'isInitial' => 1])); ?>';">Create Subscription</button> 

                    <button type="button" class="btn btn-primary mt-1 mr-1 text-white" onclick="location.href = '<?php echo e(route('createInvestorAdditionalSubscription', ['classId' => @$check_investment_class->investment_class_type, 'userId' => @$user->id, 'isAdditional' => 1])); ?>';"> Create Additional Investment </button> 
                        
                    


                    <a class="btn btn-secondary btn-sm" href="#" onclick="location.href = document.referrer; return false;" ><i class="fa fa-angle-double-left"></i> Back</a>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 card-margin">
                    <div class="card">
                        <div class="card-body">

                            

                            <div class="col-md-6">
                                <h4 class="card_title title_bNone">Investor Details</h4>
                            </div>

                            <div class="row mb-2 ml-2 show-border">
                                <div class="row col-md-12 show-first-sec">

                                    <div class="col-sm-12 col-md-6 p-1">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 mt-1">
                                                <span class="">Name </span>
                                            </div>

                                            <div class="col-md-6 col-sm-6 mt-1">
                                                : <?php echo e($user->role_id == 3 ? $user->salutation : ''); ?> <?php echo e($user->name); ?>

                                            </div>

                                            <div class="col-md-6 col-sm-6 mt-1">
                                                <span class="">Email </span>
                                            </div>

                                            <div class="col-md-6 col-sm-6 mt-1">
                                                : <?php echo e($user->email); ?>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-6 p-1">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 mt-1">
                                                <span class="">Mobile No </span>
                                            </div>

                                            <div class="col-md-6 col-sm-6 mt-1">
                                                : +<?php echo e($user->mobile_prefix); ?> <?php echo e($user->mobile_no); ?>

                                            </div>

                                            <div class="col-md-6 col-sm-6 mt-1">
                                                <span class="">Country </span>
                                            </div>

                                            <div class="col-md-6 col-sm-6 mt-1">
                                                : <?php echo e($user['countryAs']['name']); ?>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-6">
                                <h4 class="card_title title_bNone">Address</h4>
                            </div>

                            <div class="row mb-2 ml-2 show-border">
                                <div class="row col-md-12 show-first-sec">

                                    <div class="col-sm-12 col-md-6 p-1">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 mt-1">
                                                <span class="">Country </span>
                                            </div>

                                            <div class="col-md-6 col-sm-6 mt-1">
                                                : <?php echo e($user['countryAs']['name']); ?>

                                            </div>

                                            <div class="col-md-6 col-sm-6 mt-1">
                                                <span class="">City </span>
                                            </div>

                                            <div class="col-md-6 col-sm-6 mt-1">
                                                : <?php echo e($user->city); ?>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-6 p-1">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 mt-1">
                                                <span class="">State </span>
                                            </div>

                                            <div class="col-md-6 col-sm-6 mt-1">
                                                : <?php echo e($user['stateAs']['name']); ?>

                                            </div>

                                            <div class="col-md-6 col-sm-6 mt-1">
                                                <span class="">Post Code </span>
                                            </div>

                                            <div class="col-md-6 col-sm-6 mt-1">
                                                : <?php echo e($user->post_code); ?>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-6 p-1">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 mt-0">
                                                <span class="">Address Line 1 </span>
                                            </div>

                                            <div class="col-md-6 col-sm-6 mt-0">
                                                : <?php echo e($user->address_line1); ?>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-6 p-1">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 mt-0">
                                                <span class="">Address Line 2 </span>
                                            </div>

                                            <div class="col-md-6 col-sm-6 mt-0">
                                                : <?php echo e($user->address_line2); ?>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            

                            
                            <div class="col-md-6">
                                <h4 class="card_title title_bNone">Subscriptions</h4>
                            </div>
                            <form method="get" class="needs-validation mt-3" action="<?php echo e(route('users.show', $user->id)); ?>">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label>Search By Investment No </label>
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
                                            <th>INITIAL AMOUNT</th>
                                            <th>COMMENCEMENT DATE</th>
                                            <th>TOTAL VALUE OF ADDITIONAL INVESTMENT</th>
                                            <th>VALUE OF SHAREHOLDING</th>
                                            <th>INVESTMENT CLASS</th>
                                            <th>INVESTMENT TYPE</th>
                                            <th>STATUS</th>
                                            <th>ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php if($subscriptions->count() > 0): ?>
                                        
                                        <?php $__currentLoopData = $subscriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subscription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        
                                        <?php if(($subscription->is_first == 1) || ($subscription->status == 0) || ($subscription->status != 3)): ?>
                                           
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

                                            <?php
                                                $totalSumOfAdditional = \App\Subscription::where('user_id', $subscription->user_id)->where('investment_class_type', $subscription->investment_class_type)->where('is_first', 0)->where('status', 3)->sum('amount');
                                            ?>

                                            <?php if($subscription->is_first): ?>
                                                <td><?php echo e($totalSumOfAdditional); ?></td>
                                            <?php else: ?> 
                                                <td>N/A</td>
                                            <?php endif; ?>

                                            <td>
                                                <?php
                                                    $latestCLassANavPrice = \App\Price::where('class_type', $subscription->investment_class_type)->where('active',1)->first();

                                                    $latest_price = $latestCLassANavPrice->latest_price;
                                                    $current_value = $subscription->no_of_share * $latest_price;

                                                    $current_value = $current_value - $subscription['PayoutAs']->sum('redemption_amount');

                                                    if(!empty($current_value)){
                                                        $current_value = floatvalue($current_value);
                                                        echo number_format($current_value, 2);
                                                    }else{
                                                        echo "0.00";
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
                                                    <span class="badge badge-secondary mt-2 mr-2">ADDITIONAL</span>
                                                <?php else: ?>
                                                    <span class="badge badge-dark mt-2 mr-2">INITIAL</span>
                                                <?php endif; ?>
                                            </td>

                                            <td> 

                                                <?php
                                                    if($subscription->status == 0){
                                                        echo '<span class="badge badge-soft-danger mt-2 mr-2">Draft</span>';
                                                    }else if($subscription->status == 1){
                                                        echo '<span class="badge badge-soft-danger mt-2 mr-2">Pending</span>';
                                                    }else if($subscription->status == 2){
                                                        echo '<span class="badge badge-soft-danger mt-2 mr-2">Pending Funding</span>';
                                                    }else if($subscription->status == 3){
                                                        echo '<span class="badge badge-soft-success mt-2 mr-2">Active</span>';
                                                    }else if($subscription->status == 4){
                                                        echo '<span class="badge badge-soft-danger mt-2 mr-2">Deactive</span>';
                                                    }else if($subscription->status == 5){
                                                        echo '<span class="badge badge-soft-danger mt-2 mr-2">Rejected</span>';
                                                    }else if($subscription->status == 6){
                                                        echo '<span class="badge badge-soft-info mt-2 mr-2">Matured</span>';
                                                    }else if($subscription->status == 7){
                                                        echo '<span class="badge badge-soft-info mt-2 mr-2">Reinvestment</span>';
                                                    }else if($subscription->status == 8){
                                                        echo '<span class="badge badge-soft-info"> Payment Received</span>';
                                                    }else if($subscription->status == 9){
                                                        echo '<span class="badge badge-soft-info"> Fund Received</span>';
                                                    }else{
                                                        echo '<span class="badge badge-soft-info"> Draft</span>';
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

                                        <?php endif; ?>

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    <?php else: ?>

                                      <tr><td colspan=9 align="center">No Records Available..</td></tr>
                                    <?php endif; ?>

                                    </tbody>
                                </table>
                            </div>
                            
                            <br>

                            
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php echo $__env->make('admin.elements.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php 
    
    function floatvalue($val){
            $val = str_replace(",",".",$val);
            $val = preg_replace('/\.(?=.*\.)/', '', $val);
            return floatval($val);
    }
?>

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



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/olympus-asset.com/public_html/resources/views/admin/users/show.blade.php ENDPATH**/ ?>