<?php $__env->startSection('title', 'Subscription View'); ?>

<?php $__env->startSection('content'); ?>

<div class="main-container">
    <div class="container-fluid">
        
        <?php echo $__env->make("investor.elements.sidebar", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <div class="main-panel">
            <!-- content-wrapper Starts -->
            <div class="content-wrapper">
                <!-- design1 -->
                
                <div class="page-header-container">
                    <div class="page-header-main">
                        <div class="page-title">Investment Details</div>
                        <div class="header-breadcrumb">
                            <a href="#"><i data-feather="airplay"></i> Show</a>
                        </div>
                    </div>
                    <div class="page-header-action">
                        <a class="btn btn-secondary" href="#" onclick="location.href = document.referrer; return false;" ><i class="fa fa-angle-double-left"></i> Back</a>
					</div>
                </div>
                
                <div class="row">
                    <div class="col-lg-12 card-margin">
                    <div class="card">
                        <div class="card-body">
                            
                            <div class="row pd-3 ml-3 mt-3">
                                <?php if($subscription->manual_signed_doc_enable == 1){ ?>
                                    <a href="<?php echo e(asset('storage/'.$subscription->manual_signed_doc )); ?>" class="btn btn-base btn-rounded btn-fw mt-1 mr-1" target="_blank">Download Signed Application</a>
                                <?php }else{ ?>
                                    <a href="<?php echo e(url('/investor/signedPdf/'.$subscription->id )); ?>" class="btn btn-base btn-rounded btn-fw mt-1 mr-1" target="_blank">Download Signed Application</a>
                                <?php } ?>

                                <?php if($subscription->status == 2 || $subscription->status == 3 || $subscription->status == 4 || $subscription->status == 5 || $subscription->status == 6 || $subscription->status == 7 || $subscription->status == 8 || $subscription->status == 9): ?>
                                <a href="<?php echo e(url('investor/bankPdf/'.$subscription->id )); ?>" class="btn btn-base btn-rounded btn-fw mt-1 mr-1" target="_blank">Download Bank Instructions</a>
                                <?php endif; ?>

                                <?php
                                if($subscription->status == 3){ 
                                    if($subscription->redemption_request == 1){ 
                                        if($subscription->redemption_status == 0){
                                            echo '<button class="btn btn-info btn-rounded btn-fw mt-1 mr-1"> Redemption Request Sent</button>';
                                        }else if($subscription->redemption_status == 1){

                                            //echo '<button class="btn btn-info btn-rounded btn-fw mt-1 mr-1"> Redemption Request Approved</button>';

                                            echo '<button class="btn btn-warning btn-rounded btn-fw mt-1 mr-1" id="redemptionButton"> Redemption Request</button>';

                                        }else if($subscription->redemption_status == 2){
                                            echo '<button class="btn btn-info btn-rounded btn-fw mt-1 mr-1"> Redemption Request Reject</button>';

                                            echo '<button class="btn btn-warning btn-rounded btn-fw mt-1 mr-1" id="redemptionButton"> Redemption Request</button>';
                                        }
                                    }else{ ?>
                                        <button type="button" class="btn btn-warning mt-1 mr-1" id="redemptionButton">Redemption Request</button>

                                <?php }} ?>
                            </div>

                            <div class="row mt-3 mb-2 ml-2 show-border">
                                <div class="row col-md-12 show-first-sec">

                                    <div class="col-sm-12 col-md-6 p-1">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 mt-1">
                                                <span class="">Investment Class Type </span>
                                                
                                            </div>
                                            <div class="col-md-6 col-sm-6 mt-1">
                                                
                                                <?php if(!empty($subscription->investment_class_type)): ?>
                                                    <?php if($subscription->investment_class_type == 1): ?>
                                                        : <span class="badge badge-success text-white">
                                                            <?php echo e($subscription->InvestmentClassAs['name']); ?>

                                                        </span>
                                                    <?php else: ?>
                                                        : <span class="badge badge-info">
                                                            <?php echo e($subscription->InvestmentClassAs['name']); ?>

                                                        </span>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    : <span class="badge badge-danger">Not Updated</span>
                                                <?php endif; ?>

                                            </div>

                                            <div class="col-md-6 col-sm-6 mt-2">
                                               <span class="">Investment Number</span>
                                                
                                            </div>
                                            <div class="col-md-6 col-sm-6 mt-2">
                                                
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

                                                : <?php echo e($investment_no); ?>


                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-sm-12 col-md-6 p-1">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 mt-1">
                                                <span class="">Status </span>
                                                
                                            </div>
                                            <div class="col-md-6 col-sm-6 mt-1">
                                                
                                                <?php
                                                    if($subscription->status == 1){
                                                        echo ': <span class="badge badge-soft-info"> Pending</span>';
                                                    }else if($subscription->status == 2){
                                                        echo ': <span class="badge badge-soft-primary"> Pending Funding</span>';
                                                    }else if($subscription->status == 3){
                                                        echo ': <span class="badge badge-soft-success"> Active</span>';
                                                    }else if($subscription->status == 4){
                                                        echo ': <span class="badge badge-soft-danger"> Deactive</span>';
                                                    }else if($subscription->status == 5){
                                                        echo ': <span class="badge badge-soft-danger"> Rejected</span>';
                                                    }else if($subscription->status == 6){
                                                        echo ': <span class="badge badge-soft-success"> Matured</span>';
                                                    }else if($subscription->status == 7){
                                                        echo ': <span class="badge badge-soft-danger"> Re-Investmented</span>';
                                                    }else if($subscription->status == 8){
                                                        echo ': <span class="badge badge-soft-info"> Payment Received</span>';
                                                    }else if($subscription->status == 9){
                                                        echo ': <span class="badge badge-soft-info"> Fund Received</span>';
                                                    }else{
                                                        echo ': <span class="badge badge-soft-info"> Draft</span>';
                                                    }
                                                ?>

                                            </div>

                                            <div class="col-md-6 col-sm-6 mt-2">
                                               <span class="">Initial Investment Amount (USD)</span>
                                                
                                            </div>
                                            <div class="col-md-6 col-sm-6 mt-2">
                                                : <?php echo e(number_format($subscription->amount, 2)); ?>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-6 p-1">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 mt-1">
                                                <span class="">Name</span>
                                                
                                            </div>
                                            <div class="col-md-6 col-sm-6 mt-1">
                                                : <?php echo e($subscription['UserAs']['name']); ?>

                                            </div>

                                            <div class="col-md-6 col-sm-6 mt-2">
                                               <span class="">Email</span>
                                                
                                            </div>
                                            <div class="col-md-6 col-sm-6 mt-2">
                                                : <?php echo e($subscription['UserAs']['email']); ?>

                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-sm-12 col-md-6 p-1">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 mt-1">
                                                <span class="">*Number of Shares Held</span>
                                                
                                            </div>
                                            <div class="col-md-6 col-sm-6 mt-1">
                                                
                                                : <?php 
                                                        $latest_price = $price->latest_price;
                                                        $current_value = $subscription->no_of_share * $latest_price;

                                                        if($subscription->no_of_share){
                                                            $round_current_value = number_format($subscription->no_of_share * $latest_price, 2);
                                                        }else{
                                                            $round_current_value = 0;
                                                        }

                                                        
                                                    ?>
                                                    <?php
                                                        if($subscription->no_of_share){

                                                            $no_of_share =$subscription->no_of_share;

                                                            //$no_of_share = floatvalue($subscription->no_of_share);
                                                            //echo number_format($no_of_share, 4);

                                                            //echo round($no_of_share, 4);

                                                            //echo $no_of_share;
                                                            echo number_format($no_of_share, 4);

                                                        }else{
                                                            echo "0.00";
                                                        }
                                                    ?>
                                            </div>

                                            <div class="col-md-6 col-sm-6 mt-2">
                                               <span class="">Net Asset Value per Share (USD)</span>
                                                
                                            </div>
                                            <div class="col-md-6 col-sm-6 mt-2">
                                                
                                                : <?php
                                                        if($latest_price){
                                                            echo number_format((float)$latest_price, 4, '.', '');
                                                           // echo number_format($latest_price, 4);
                                                        }else{
                                                            echo "0.00";
                                                        }
                                                    ?>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-6 p-1">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 mt-1">
                                                <span class="">Mobile No</span>
                                                
                                            </div>
                                            <div class="col-md-6 col-sm-6 mt-1">
                                                : +<?php echo e($subscription['UserAs']['mobile_prefix']); ?> - <?php echo e($subscription['UserAs']['mobile_no']); ?>

                                            </div>

                                            <div class="col-md-6 col-sm-6 mt-2">
                                               <span class="">Commencement Date</span>
                                                
                                            </div>
                                            <div class="col-md-6 col-sm-6 mt-2">
                                                : <?php echo e($subscription->commencement_date ? date('d-M-y', strtotime($subscription->commencement_date))  : ''); ?>

                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-sm-12 col-md-6 p-1">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 mt-1">
                                                <span class="">*Value of Shareholding (USD)</span>
                                                
                                            </div>
                                            
                                            <div class="col-md-6 col-sm-6 mt-1">
                                                : <?php
                                                    $latest_price = $price->latest_price;
                                                    $current_value = $subscription->no_of_share * $latest_price;

                                                    if(!empty($current_value)){
                                                        $current_value = floatvalue($current_value);
                                                        echo number_format($current_value, 2);
                                                    }else{
                                                        echo "0.00";
                                                    }
                                                ?>
                                            </div>

                                            <div class="col-md-6 col-sm-6 mt-2">
                                               <span class="">Total Redemption Value (USD)</span>
                                                
                                            </div>

                                            <div class="col-md-6 col-sm-6 mt-2">
                                                <?php if($subscription['PayoutAs']->count() > 0): ?>
                                                    : <?php 

                                                        $total_payout = $subscription['PayoutAs']->sum('redemption_amount');
                                                        $total_payout = floatvalue($total_payout);
                                                        echo number_format($total_payout, 2);
                                                    ?>
                                                <?php else: ?>
                                                    : <?php
                                                        echo "0.00";
                                                    ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <span class="mt-4 mb-2 ml-2 text-primary">*The statement’s values issued by the fund administrator takes precedence over CRM's values in the event of rounding discrepancies.</span>
                                </div>
                            </div>

                            

                            <?php if(!empty($subscriptions_history)): ?>

                            <div class="col-md-6">
                                <h4 class="card_title title_bNone">Additional Subscription History </h4> 
                            </div>
                            
                            <div class="row mb-2 ml-2 show-border">
                                <div class="row col-md-12 show-first-sec">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>AMOUNT (USD)</th>
                                                        <th>COMMENCEMENT DATE</th>
                                                        <th>NAV (USD)</th>
                                                        <th>INVESTMENT CLASS</th>
                                                        <th>INVESTMENT TYPE</th>
                                                        <th>STATUS</th>
                                                        <th>CREATED ON</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php if($subscriptions_history->count() > 0): ?>

                                                    <?php $__currentLoopData = $subscriptions_history; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subscriptionData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td>$ <?php echo e($subscriptionData->amount); ?></td>
                                                            <td><?php echo e($subscriptionData->commencement_date ? date('d-M-y', strtotime($subscriptionData->commencement_date))  : ''); ?></td>
                                                            <td>$ <?php echo e($subscriptionData->latest_price); ?></td>
                                                            <td>
                                                                <?php if(!empty($subscriptionData->investment_class_type)): ?>
                                                                    <span class="badge badge-soft-info mt-2 mr-2">
                                                                        <?php echo e($subscriptionData->InvestmentClassAs['name']); ?>

                                                                    </span>
                                                                <?php else: ?>
                                                                    <span class="badge badge-soft-danger mt-2 mr-2">Not Updated</span>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td>
                                                                <?php if($subscriptionData->is_first == 0): ?>
                                                                    <span class="badge badge-secondary mt-2 mr-2">Additional</span>
                                                                <?php else: ?>
                                                                    <span class="badge badge-dark mt-2 mr-2">Initial</span>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                    if($subscriptionData->status == 1){
                                                                        echo '<span class="badge badge-soft-warning"> Pending</span>';
                                                                    }else if($subscriptionData->status == 2){
                                                                        echo '<span class="badge badge-soft-primary"> Pending Funding</span>';
                                                                    }else if($subscriptionData->status == 3){
                                                                        echo '<span class="badge badge-soft-success">Active</span>';
                                                                    }else if($subscriptionData->status == 4){
                                                                        echo '<span class="badge badge-soft-danger">Deactive</span>';
                                                                    }else if($subscriptionData->status == 5){
                                                                        echo '<span class="badge badge-soft-danger"> Rejected</span>';
                                                                    }else if($subscriptionData->status == 6){
                                                                        echo '<span class="badge badge-soft-info"> Matured</span>';
                                                                    }else if($subscriptionData->status == 7){
                                                                        echo '<span class="badge badge-soft-success"> Reinvestment</span>';
                                                                    }else if($subscriptionData->status == 8){
                                                                        echo '<span class="badge badge-soft-info"> Payment Received</span>';
                                                                    }else if($subscriptionData->status == 9){
                                                                        echo '<span class="badge badge-soft-info"> Fund Received</span>';
                                                                    }else{
                                                                        echo '<span class="badge badge-soft-info"> Draft</span>';
                                                                    }
                                                                ?>
                                                            </td>
                                                            <td><?php echo e(date('d-M-y', strtotime($subscriptionData->created_at))); ?></td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    
                                                    <?php else: ?>
                                                        <tr><td colspan=7 align="center">No Records Available..</td></tr>
                                                    <?php endif; ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php endif; ?>
                            
                            <!--  -->
                            <div class="col-md-6">
                                <h4 class="card_title title_bNone">Address</h4> 
                            </div>
                            
                            <div class="row mt-3 mb-2 ml-2 show-border">
                                <div class="row col-md-12 show-first-sec">

                                    <div class="col-sm-12 col-md-6 p-1">
                                        <div class="row">

                                            <div class="col-md-4 col-sm-6 mt-1">
                                                <span class="">Country</span>
                                                
                                            </div>
                                            <div class="col-md-8 col-sm-6 mt-1">
                                                : <?php echo e($subscription['SubscriptionCountryAs']['name']); ?>

                                            </div>

                                            <div class="col-md-4 col-sm-6 mt-1">
                                               <span class="">State</span>
                                                
                                            </div>
                                            <div class="col-md-8 col-sm-6 mt-1">
                                                : <?php echo e($subscription['SubscriptionStateAs']['name']); ?>

                                            </div>

                                            
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-6 p-1">
                                        <div class="row">
                                            <div class="col-md-4 col-sm-6 mt-1">
                                               <span class="">City</span>
                                                
                                            </div>
                                            <div class="col-md-8 col-sm-6 mt-1">
                                                : <?php echo e($subscription->city); ?>

                                            </div>

                                            <div class="col-md-4 col-sm-6 mt-1">
                                                <span class="">Post Code</span>
                                                
                                            </div>
                                            <div class="col-md-8 col-sm-6 mt-1">
                                                : <?php echo e($subscription->post_code); ?>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-6 p-1">
                                        <div class="row">
                                            <div class="col-md-4 col-sm-6 mt-1">
                                                <span class="">Address Line 1 </span>
                                                
                                            </div>
                                            <div class="col-md-8 col-sm-6 mt-1">
                                                : <?php echo e($subscription->address_line1); ?>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-6 p-1">
                                        <div class="row">
                                            <div class="col-md-4 col-sm-6 mt-1">
                                                <span class="">Address Line 2 </span>
                                                
                                            </div>
                                            <div class="col-md-8 col-sm-6 mt-1">
                                                : <?php echo e($subscription->address_line2); ?>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            

                            <!--  -->

                            <?php if($subscription->is_joint_account == 2): ?>

                            <!--  -->
                            <div class="col-md-6">
                                <h4 class="card_title">Joint Account Details</h4>
                            </div>
                            
                            <div class="row mt-3 mb-2 ml-2 show-border">
                                <div class="row col-md-12 show-first-sec">

                                    <div class="col-sm-12 col-md-6 p-1">
                                        <div class="row">
                                            <div class="col-md-4 col-sm-6 mt-1">
                                                <span class="">Name</span>
                                                
                                            </div>
                                            <div class="col-md-8 col-sm-6 mt-1">
                                                : <?php echo e($subscription->ja_name); ?>

                                            </div>

                                            <div class="col-md-4 col-sm-6 mt-1">
                                               <span class="">City</span>
                                                
                                            </div>
                                            <div class="col-md-8 col-sm-6 mt-1">
                                                : <?php echo e($subscription->ja_city); ?>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-6 p-1">
                                        <div class="row">
                                            <div class="col-md-4 col-sm-6 mt-1">
                                                <span class="">Address</span>
                                                
                                            </div>
                                            <div class="col-md-8 col-sm-6 mt-1">
                                                : <?php echo e($subscription->ja_address_line1); ?>, <?php echo e($subscription->ja_address_line2); ?>

                                            </div>

                                            <div class="col-md-4 col-sm-6 mt-1">
                                                <span class="">Post Code</span>
                                                
                                            </div>
                                            <div class="col-md-8 col-sm-6 mt-1">
                                                : <?php echo e($subscription->ja_post_code); ?>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-6 p-1">
                                        <div class="row">

                                            <div class="col-md-4 col-sm-6 mt-1">
                                               <span class="">State</span>
                                                
                                            </div>
                                            <div class="col-md-8 col-sm-6 mt-1">
                                                : <?php echo e($subscription['SubscriptionJaStateAs']['name']); ?>

                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-6 p-1">
                                        <div class="row">

                                            <div class="col-md-4 col-sm-6 mt-1">
                                                <span class="">Country</span>
                                                
                                            </div>
                                            <div class="col-md-8 col-sm-6 mt-1">
                                                : <?php echo e($subscription['SubscriptionJaCountryAs']['name']); ?>

                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>

                            

                            <?php endif; ?>

                            

                            <?php if($subscription['PayoutAs']->count() > 0): ?>
                            <!--  -->
                            <div class="col-md-6">
                                <h4 class="card_title title_bNone">Redemption </h4> 
                            </div>
                            
                            <div class="row mb-2 ml-2 show-border">
                                <div class="row col-md-12 show-first-sec">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>PAYOUT DATE</th>
                                                        <th>AMOUNT(USD)</th>
                                                        <th>REFERENCE</th>
                                                        <th>FILE</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php if($subscription['PayoutAs']->count() > 0): ?>
                                                        <?php $__currentLoopData = $subscription['PayoutAs']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payout): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                <td><?php echo e(date('d-M-y', strtotime($payout->created_at))); ?></td>
                                                                <td>$ <?php echo e($payout->redemption_amount); ?></td>
                                                                <td><?php echo e($payout->redemption_msg); ?></td> 
                                                                <td>
                                                                    <a href="<?php echo e(asset('storage/'.$payout->redemption_file)); ?>"  download class="btn btn-base btn-rounded btn-fw mt-1 mr-1"> Download </a>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php else: ?>
                                                        <tr><td colspan=4 align="center">No Records Available..</td></tr>
                                                    <?php endif; ?>
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <?php endif; ?>

                            <!--  -->

                            <div class="row col-md-12">
                                <div class="col-md-6">
                                    <h4 class="card_title mt-2">Bank Details</h4>
                                </div>
                                
                                <div class="col-md-6 text-right">

                                <?php if($subscription->changebank_request == 1){ ?>

                                    <a type="button" href="javascript:void(0);" class="btn btn-primary btn-sm mr-2"> Change Bank Details</a>
                                
                                
                                    <a type="button" href="<?php echo e(asset('storage/'.$subscription->changebank_file)); ?>" class="btn btn-primary btn-sm mr-2" download> Download</a>
                                    
                                <?php }else{ ?>
                                    
                                    <a type="button" href="javascript:void(0);" class="btn btn-primary btn-sm mr-2" id="changeBankButton"> Change Bank Details</a>

                                <?php } ?> 

                                </div>
                            </div>

                            <div class="row mt-3 mb-2 ml-2 show-border">
                                <div class="row col-md-12 show-first-sec">

                                    <div class="col-sm-12 col-md-6 p-1">
                                        <div class="row">
                                            <div class="col-md-4 col-sm-6 mt-1">
                                                <span class="">Bank Name  </span>
                                            </div>
                                            <div class="col-md-8 col-sm-6 mt-1">
                                                : <?php echo e($subscription->bank_name); ?> 
                                            </div>

                                            <div class="col-md-4 col-sm-6 mt-2">
                                               <span class="">Account Number</span>
                                                
                                            </div>
                                            <div class="col-md-8 col-sm-6 mt-2">
                                                : <?php echo e($subscription->account_number); ?>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-6 p-1">
                                        <div class="row">

                                            <div class="col-md-4 col-sm-6 mt-2">
                                               <span class="">Account Name</span>
                                            </div>
                                            <div class="col-md-8 col-sm-6 mt-2">
                                                : <?php echo e($subscription->account_name); ?>

                                            </div>

                                            <div class="col-md-4 col-sm-6 mt-1">
                                                <span class="">Swift Code </span>
                                            </div>
                                            <div class="col-md-8 col-sm-6 mt-1">
                                                : <?php echo e($subscription->swift_address); ?>

                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-6 p-1">
                                        <div class="row">

                                            <?php if(!empty ($subscription->bank_inan)): ?>
                                            <div class="col-md-4 col-sm-6 mt-1">
                                                <span class="">Bank IBAN# </span>
                                            </div>
                                            <div class="col-md-8 col-sm-6 mt-1">
                                                : <?php echo e($subscription->bank_inan); ?>

                                            </div>
                                            <?php endif; ?>

                                            <?php if(!empty ($subscription->reference)): ?>
                                            <div class="col-md-4 col-sm-6 mt-2">
                                               <span class="">Reference</span>
                                            </div>
                                            <div class="col-md-8 col-sm-6 mt-2">
                                                : <?php echo e($subscription->reference); ?>

                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-6 p-1">
                                        <div class="row">
                                            <div class="col-md-4 col-sm-6 mt-1">
                                                <span class="">Account Address </span>
                                            </div>
                                            <div class="col-md-8 col-sm-6 mt-1">
                                                : <?php echo e($subscription->bank_address); ?>

                                            </div>

                                            <div class="col-md-4 col-sm-6 mt-2">
                                               <span class=""></span>
                                            </div>
                                            <div class="col-md-8 col-sm-6 mt-2">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            
                                
                            <div class="col-md-6">
                                <h4 class="card_title title_bNone">Lead Contact Details</h4>
                            </div>
                            
                            <div class="row mt-3 mb-2 ml-2 show-border">
                                <div class="row col-md-12 show-first-sec">

                                    <div class="col-sm-12 col-md-6 p-1">
                                        <div class="row">
                                            <div class="col-md-4 col-sm-6 mt-1">
                                                <span class="">Name </span>
                                            </div>
                                            <div class="col-md-8 col-sm-6 mt-1">
                                                : <?php echo e($subscription->lc_name); ?>

                                            </div>

                                            <div class="col-md-4 col-sm-6 mt-2">
                                               <span class="">Mobile No</span>
                                            </div>
                                            <div class="col-md-8 col-sm-6 mt-2">
                                                : +<?php echo e($subscription->lc_phone_prefix); ?><?php echo e($subscription->lc_phone_number); ?>

                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-sm-12 col-md-6 p-1">
                                        <div class="row">
                                            <div class="col-md-4 col-sm-6 mt-1">
                                                <span class="">Email </span>
                                            </div>
                                            <div class="col-md-8 col-sm-6 mt-1">
                                                : <?php echo e($subscription->lc_email); ?>

                                            </div>

                                            <div class="col-md-4 col-sm-6 mt-2">
                                               <span class="">Facsimile</span>
                                            </div>

                                            <?php if(!empty ($subscription->lc_facsimile)): ?>
                                            <div class="col-md-8 col-sm-6 mt-2">
                                                : <?php echo e($subscription->lc_facsimile); ?>

                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            

                            
                            
                            

                            <!-- manual end -->
                            <div class="col-md-6">
                                <h4 class="card_title">Documents </h4>
                            </div>

                            <div class="row mt-3 mb-2 ml-2 show-border">
                                <div class="row col-md-12 show-first-sec">
                                    <div class="table-responsive table-space-sm">
                                        <table class="table table-borderless">
                                    	    <thead>
                                    	        
                                    	        <?php 
                                                    if(!empty($subscription['SsDocumentAs'])):
                                                        $documents = getDocument($subscription['SsDocumentAs']);
                                                        foreach ($documents as $document):
                                                ?>
                                                            <tr>
                                                	            <th><?php echo e($document['name']); ?></th>
                                                	            <td><a href="<?php echo e(asset('storage/'.$document['file'])); ?>" download="">Download</a></td>
                                                	            <td><a href="<?php echo e(asset('storage/'.$document['file'])); ?>" target="_blank" >Open</a></td>
                                                	        </tr>
                                                <?php 
                                                    endforeach;
                                                endif; ?>   
                                    
                                    	    </thead>
                                    	 </table>
                                    </div>
                                </div>
                            </div>
                        

                            <?php if((!empty($subscription->individual_pep_doc) && ($subscription->individual_source_fund_doc)) || (!empty($subscription->ja_pep_doc) && ($subscription->ja_source_fund_doc))): ?>

                            <div class="row col-md-12 mt-3">
                                <div class="col-md-6">
                                    <h4 class="card_title title_bNone">Additional Signed Documents </h4>
                                </div>
                            </div>

                            <?php endif; ?>

                            <?php if($subscription->is_joint_account ==1): ?>

                                <?php if((!empty($subscription->individual_pep_doc) && ($subscription->individual_source_fund_doc))): ?>

                                <div class="row mt-1 mb-2 ml-2 show-border">
                                    <div class="row col-md-12 show-first-sec">
                                        <div class="table-responsive table-space-sm">
                                            <table class="table table-borderless">
                                                <thead>
                                                    
                                                    <tr>
                                                        <th>“PEP” Letter</th>
                                                        <td>
                                                            <a href="<?php echo e(asset('storage/'.$subscription->individual_pep_doc )); ?>" class="" target="_blank">Download </a>
                                                        </td>

                                                        <th>“SOURCE OF FUNDS/WEALTH” Letter</th>
                                                        <td>
                                                            <a href="<?php echo e(asset('storage/'.$subscription->individual_source_fund_doc )); ?>" class="" target="_blank">Download </a>
                                                        </td>
                                                    </tr>

                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <?php endif; ?>

                            <?php endif; ?>

                            <?php if($subscription->is_joint_account ==2): ?>

                                <?php if((!empty($subscription->ja_pep_doc) && ($subscription->ja_source_fund_doc)) || (!empty($subscription->individual_pep_doc) && ($subscription->individual_source_fund_doc))): ?>

                                <div class="row mt-1 mb-2 ml-2 show-border">
                                    <div class="row col-md-12 show-first-sec">
                                        <div class="table-responsive table-space-sm">
                                            <table class="table table-borderless">
                                                <thead>

                                                    <tr>
                                                        <th>Principal “PEP” Letter</th>
                                                        <td>
                                                            <a href="<?php echo e(asset('storage/'.$subscription->individual_pep_doc )); ?>" class="" target="_blank">Download </a>
                                                        </td>

                                                        <th>Principal “SOURCE OF FUNDS/WEALTH” Letter</th>
                                                        <td>
                                                            <a href="<?php echo e(asset('storage/'.$subscription->individual_source_fund_doc )); ?>" class="" target="_blank">Download </a>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th>Joint “PEP” Letter</th>
                                                        <td>
                                                            <a href="<?php echo e(asset('storage/'.$subscription->ja_pep_doc )); ?>" class="" target="_blank">Download </a>
                                                        </td>

                                                        <th>Joint “SOURCE OF FUNDS/WEALTH” Letter</th>
                                                        <td>
                                                            <a href="<?php echo e(asset('storage/'.$subscription->ja_source_fund_doc )); ?>" class="" target="_blank">Download </a>
                                                        </td>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <?php endif; ?>

                            <?php endif; ?>

                            <div class="row col-md-12 mt-3">
                                <div class="col-md-6">
                                    <h4 class="card_title title_bNone">Additional Supporting Documents</h4>
                                </div>
                            </div>

                            <div class="row mt-1 mb-2 ml-2 show-border">
                                <div class="row col-md-12 show-first-sec">
                                    <div class="table-responsive table-space-sm">
                                        <table class="table table-borderless">
                                            <thead>

                                                <?php if(!empty($subscription['SsDocumentAs'])): ?>
                                                    <?php $__currentLoopData = $subscription['SsDocumentAs']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $SsDocument): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if($SsDocument['sub_type'] == 66): ?>
                                                            <tr>
                                                                <th>Principal Holder's Supporting Docs</th>
                                                                <td><a href="<?php echo e(asset('storage/'.$SsDocument->file)); ?>" download="">Download</a></td>
                                                                <td><a href="<?php echo e(asset('storage/'.$SsDocument->file)); ?>" target="_blank" >Open</a></td>
                                                            </tr>
                                                        <?php elseif($SsDocument['sub_type'] == 68): ?>
                                                            <tr>    
                                                                <th>Joint Holder's Supporting Docs</th>
                                                                <td><a href="<?php echo e(asset('storage/'.$SsDocument->file)); ?>" download="">Download</a></td>
                                                                <td><a href="<?php echo e(asset('storage/'.$SsDocument->file)); ?>" target="_blank" >Open</a></td>
                                                            </tr>
                                                        <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                <?php endif; ?>

                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>

                           
                        </div>
                    </div>
                </div>
                </div>
            </div>
            <?php echo $__env->make('investor.elements.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
</div>




<div class="modal fade" id="redemptionModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="icofont-close-line"></i></button>
            <div class="modal-header">
                <h5 class="modal-title">Redemption form</h5>
            </div>

            <?php echo Form::open(['url' => '/investor/redemptionUpload', 'files' => true, 'id' => 'formRedemption', 'data-parsley-validate' => 'data-parsley-validate', 'autocomplete'=>"off" ]); ?>


            <div class="modal-body">
                
                <div class="row">
                    <div class="col-md-12 mb-3">
                        
                        

                        <a href="<?php echo e(url('/investor/redemptionPdfDownload', $subscription->id)); ?>" target="_blank" download class="btn btn-success btn-wide btn-sm text-white">Click to download redemption form</a>
                    </div>
                    
                    <div class="col-md-12 mb-3">
                        <span class="text-danger">Please fill and upload redemption form for processing </span>
                    </div>
                    
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label>Document</label> 
                                <input type="file" class="updateSignDocument" attr-sub_type="11" data-height="300" data-max-file-size="5M" data-allowed-file-extensions="pdf png jpg docx" data-show-remove="false" required/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="actions">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> 
                </div>
            </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="changeBankModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="icofont-close-line"></i></button>
            <div class="modal-header">
                <h5 class="modal-title">Change Bank Details Form</h5>
            </div>

            <?php echo Form::open(['url' => '/investor/changeBankDetailsUpload', 'files' => true, 'id' => 'formchangeBank', 'data-parsley-validate' => 'data-parsley-validate', 'autocomplete'=>"off" ]); ?>


            <div class="modal-body">
                
                <div class="row">
                    <div class="col-md-12 mb-3">

                        

                        <a href="<?php echo e(url('/investor/bankingDetailsPdfDownload', $subscription->id)); ?>" target="_blank" download class="btn btn-success btn-wide btn-sm text-white">Click to download bank details update form</a>

                    </div>
                    
                    <div class="col-md-12 mb-3">
                        <span class="text-danger">Please fill and upload bank details form for processing </span>
                    </div>
                    
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label>Document</label> 
                                <input type="file" class="updateSignBankDocument" attr-sub_type="11" data-height="300" data-max-file-size="5M" data-allowed-file-extensions="pdf png jpg" data-show-remove="false" required/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="actions">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> 
                </div>
            </div>
            </form>
        </div>
    </div>
</div>


<?php $__env->stopSection(); ?>




<?php $__env->startSection('scripts'); ?>
    <script> 

        $('#redemptionButton').click(function(e){
            $('#formRedemption')[0].reset();
            $('#redemptionModal').modal('show');        
        });

        var drEvent = $('.updateSignDocument').dropify();

        drEvent.on('dropify.beforeClear', function(event, element){
            console.log(element);
            return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
        });

        drEvent.on('dropify.afterClear', function(event, element){
            
            alert('File deleted');
        });

        $('.updateSignDocument').change(function() {
            
            if ($(this).get(0).files.length) {

                preloader_init();

                var csrfToken = "<?php echo e(csrf_token()); ?>";
                var fd = new FormData();
                var file = $(this)[0].files[0];
    
                fd.append('file', file);
                fd.append('sub_att_id', <?php echo e($subscription->id); ?>);
    
                axios.post(SITE_URL+'investor/redemptionUpload',fd,{
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        'X-CSRF-Token': csrfToken}}
                ).then(function(response){

                    preloader_off();

                    Swal.fire('Great Job !','You have uploaded redemption form successfully, OAL team will verify the Redemption Form!','success');
    
                    $('#redemptionModal').modal('hide');
                    setTimeout(location.reload.bind(location), 1500);  
    
                })
                .catch(function(){

                    preloader_off();
                    
                    $('#redemptionModal').modal('hide');
                    Swal.fire('Sorry !','Redemption Form upload faild!','error');
                });
            }
        });
        /***********************/

        $('#changeBankButton').click(function(e){
            $('#formchangeBank')[0].reset();
            $('#changeBankModal').modal('show');        
        });

        var drEvent = $('.updateSignBankDocument').dropify();

        drEvent.on('dropify.beforeClear', function(event, element){
            console.log(element);
            return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
        });

        drEvent.on('dropify.afterClear', function(event, element){
            
            alert('File deleted');
        });

        $('.updateSignBankDocument').change(function() {
            
            if ($(this).get(0).files.length) {

                preloader_init();

                var csrfToken = "<?php echo e(csrf_token()); ?>";
                var fd = new FormData();
                var file = $(this)[0].files[0];
    
                fd.append('file', file);
                fd.append('sub_att_id', <?php echo e($subscription->id); ?>);
    
                axios.post(SITE_URL+'investor/changeBankDetailsUpload',fd,{
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        'X-CSRF-Token': csrfToken}}
                ).then(function(response){

                    preloader_off();
                    Swal.fire('Great Job !','You have uploaded bank details form successfully, OAL team will verify the bank details form!','success');
    
                    $('#changeBankModal').modal('hide');
                    setTimeout(location.reload.bind(location), 1500);  
    
                })
                .catch(function(){

                    preloader_off();
                    $('#changeBankModal').modal('hide');
                    Swal.fire('Sorry !','Bank details form upload faild!','error');
                });
            }
        });
        /***********************/
    </script>
<?php $__env->stopSection(); ?>

<?php 
    
    function floatvalue($val){
            $val = str_replace(",",".",$val);
            $val = preg_replace('/\.(?=.*\.)/', '', $val);
            return floatval($val);
    }
    
    function getDocument($ssDocumentAs){

        $output = [];
        foreach ($ssDocumentAs as $document) {
                                            
            $id = $document['id'];
            $main_type = $document['main_type'];
            $sub_type = $document['sub_type'];
            $file = $document['file'];
            $name = $document['remarks'];

            
            if($main_type == 1){
                ///********5*******///
                if($sub_type == 11){

                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file"=> $file, "name"=> $name];
                }else if($sub_type == 12){
                    
                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file"=> $file, "name" => $name];
                }else if($sub_type == 13){

                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file"=> $file, "name" => $name];
                }else if($sub_type == 14){

                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
                }else if($sub_type == 15){

                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
                }else if($sub_type == 16){

                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
                } else if($sub_type == 71){

                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
                }else if($sub_type == 72){

                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
                }else if($sub_type == 73){

                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
                }else if($sub_type == 74){

                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
                }
                
            }else if($main_type == 2){
                ///*******6********///
                if($sub_type == 21){

                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
                }else if($sub_type == 22){

                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
                }else if($sub_type == 23){

                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
                }else if($sub_type == 24){

                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
                }else if($sub_type == 25){

                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
                }else if($sub_type == 26){

                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
                }
                
            }else if($main_type == 3){
                ///*******5********///
                if($sub_type == 31){

                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
                }else if($sub_type == 32){

                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
                }else if($sub_type == 33){

                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
                }else if($sub_type == 34){

                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
                }else if($sub_type == 35){

                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
                }
               
            }else if($main_type == 4){
                ///*******5********///
                if($sub_type == 41){

                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
                }else if($sub_type == 42){

                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
                }else if($sub_type == 43){

                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
                }else if($sub_type == 44){

                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
                }else if($sub_type == 45){

                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
                }
            }else if($main_type == 5){
                ///*******5********///
                if($sub_type == 51){

                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
                }else if($sub_type == 52){

                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
                }else if($sub_type == 53){

                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
                }else if($sub_type == 54){

                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
                }else if($sub_type == 55){

                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
                }
            }else if($main_type == 6){
                //*******3********///
                if($sub_type == 61){

                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
                }else if($sub_type == 62){

                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
                }else if($sub_type == 63){

                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
                }
            }else if($main_type == 7){
                //*******3********///
                if($sub_type == 71){

                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
                }
            }
        }// For Loop
        return $output;
    }//End Function
?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/olympus-asset.com/public_html/resources/views/investor/subscriptionView.blade.php ENDPATH**/ ?>