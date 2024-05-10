<?php $__env->startSection('title', 'Subscription View'); ?>

<?php $__env->startSection('content'); ?>

<div class="main-container">
    <div class="container-fluid">
        
        <?php echo $__env->make("admin.elements.sidebar", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

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
                        <?php if($edit): ?>
                            <button type="button" class="btn btn-primary btn-sm" id="contractButton">Contract Edit</button>
                            <button type="button" class="btn btn-primary btn-sm" id="investmentDetailsButton">Investment Details Edit</button>
                            <button type="button" class="btn btn-primary btn-sm" id="investmentShareButton">Edit Investment Share</button>
                        <?php endif; ?>
                        
                        <a class="btn btn-secondary btn-sm" href="#" onclick="location.href = document.referrer; return false;" ><i class="fa fa-angle-double-left"></i> Back</a>
					</div>
                </div>
                
                <div class="row">
                    <div class="col-lg-12 card-margin">
                        <div class="card">
                            <div class="card-body">
                                
                                <?php if($edit): ?>
                                
                                <?php echo Form::open(['url' => 'changeStatus', 'files' => true, 'id' => 'changeStatusForm', 'data-parsley-validate' => 'data-parsley-validate', 'autocomplete'=>"off" ]); ?>

                                <?php echo csrf_field(); ?>
                                    <div class="row">
                                        <div class="col-md-5 col-sm-12 ml-0 mt-4">
                                            <div class="form-group mb-2">
                                                <input type="hidden" name="subscription_id" value="<?php echo e($subscription->id); ?>">
                                                <input type="hidden" name="send_mail" value="no" id="send_mail">
                                                <input type="hidden" name="send_fund_received_mail" value="no" id="send_fund_received_mail">
                                        
                                                <label for="exampleFormControlSelect1">Change Status*</label>
                                                <?php 
                                                    $statusOption = ['1'=> 'Pending','2'=> 'Pending Funding', '9' => 'Fund Received', '3'=> 'Active','4'=> 'Deactive','5'=> 'Rejected','6'=> 'Matured','8' => 'Payment Received']; ?>
    
                                                    <?php echo Form::select('status', $statusOption, $subscription->status, ['class' => 'form-control', 'id' => 'change_status', 'required']); ?>

                                            </div>
                                        </div>
                                        <div class="changeButton col-md-1 col-sm-12">
                                            
                                            <a href="javascript:void();" id="changeStatusButton" class="btn btn-primary">Change</a>
                                        </div>
    
                                    </div>
                                </form>
                                <?php endif; ?>

                                <div class="row pd-3 ml-3">
                                <?php if($subscription->manual_signed_doc_enable == 1){ ?>
                                    <a href="<?php echo e(asset('storage/'.$subscription->manual_signed_doc )); ?>" class="btn btn-base btn-rounded btn-fw mt-1 mr-1" target="_blank">Download Signed Application</a>
                                <?php }else{ ?>
                                    <a href="<?php echo e(url('signedPdf/'.$subscription->id )); ?>" class="btn btn-base btn-rounded btn-fw mt-1 mr-1" target="_blank">Download Signed Application</a>
                                <?php } ?>

                                <?php if($subscription->status == 2 || $subscription->status == 3 || $subscription->status == 4 || $subscription->status == 5 || $subscription->status == 6 || $subscription->status == 7 || $subscription->status == 8 || $subscription->status == 9): ?>

                                <a href="<?php echo e(url('bankPdf/'.$subscription->id )); ?>" class="btn btn-base btn-rounded btn-fw mt-1 mr-1" target="_blank">Download Bank Instructions</a>

                                <?php endif; ?>

                                <?php if($subscription->redemption_request ==1){ ?>
                                    <?php if($subscription->redemption_status ==0){ ?>

                                        <?php if($subscription->investment_class_type ==1){ ?>
                                            <button type="button" class="btn btn-info btn-rounded btn-fw mt-1 mr-1" id="redemptionButton" >Redemption Requested</button> 
                                        <?php }else if($subscription->investment_class_type ==2){ ?>
                                            <button type="button" class="btn btn-info btn-rounded btn-fw mt-1 mr-1" id="createQuarterlyRedemption" >Redemption Requested</button> 
                                        <?php } ?>

                                        

                                    <?php }else if($subscription->redemption_status ==1){ ?>
                                        <button type="button" class="btn btn-success btn-rounded btn-fw mt-1 mr-1">Redemption Form Approved</button> 
                                    <?php }else if($subscription->redemption_status ==2){ ?>
                                        <button type="button" class="btn btn-danger btn-rounded btn-fw mt-1 mr-1">Redemption Form Rejected</button> 
                                    <?php } ?>   
                                <?php } ?>

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

                                                        if(!empty($subscription->no_of_share)){
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

                                                            //echo  number_format(round($no_of_share, 4));

                                                            

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
                                                        <th>INDEX NO</th>
                                                        <th>AMOUNT(USD)</th>
                                                        <th>INVESTMENT CLASS</th>
                                                        <th>INVESTMENT TYPE</th>
                                                        <th>STATUS</th>
                                                        <th>DOWNLOAD SIGNED APPLICATION FORM</th>
                                                        <th>DOWNLOAD BANK INSTRUCTIONS</th>
                                                        <th>DOWNLOAD BANK SLIP</th>
                                                        <th>CREATED ON</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                    <?php if($subscriptions_history->count() > 0): ?>

                                                    <?php $__currentLoopData = $subscriptions_history; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subscriptionData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td class="font-weight-bold">
                                                                <?php 
                                                                    if (!empty($subscriptionData->investment_name)) {
                                                                        
                                                                        if (($subscriptionData->status == 3) || ($subscriptionData->status == 6)) {
                                                                            $investment_no = $subscriptionData->investment_name;
                                                                        } else {
                                                                            $investment_no = $subscriptionData->investment_name.$subscriptionData->investment_no;
                                                                        }
                                                                    }else{
                                                                        $investment_no = $subscriptionData->investment_no;
                                                                    }

                                                                    echo link_to(url('/subscriptionView/'.$subscriptionData->id), $title = '#'.$subscriptionData->id, $attributes = [], $secure = null);
                                                                ?>
                                                            </td>

                                                            <td>$ <?php echo e($subscriptionData->amount); ?></td>
                                                            <td>
                                                                <?php if(!empty($subscriptionData->investment_class_type)): ?>

                                                                    <?php if($subscriptionData->investment_class_type == 1): ?>
                                                                        <span class="badge badge-soft-info mt-2 mr-2">
                                                                            <?php echo e($subscriptionData->InvestmentClassAs['name']); ?>

                                                                        </span>
                                                                    <?php else: ?>
                                                                        <span class="badge badge-soft-primary mt-2 mr-2">
                                                                            <?php echo e($subscriptionData->InvestmentClassAs['name']); ?>

                                                                        </span>
                                                                    <?php endif; ?>
                                                                    
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

                                                            <td>
                                                                <?php if($subscriptionData->manual_signed_doc_enable !== 1){ ?>
                                                                    <a class="btn btn-secondary btn-sm" target="_blank" href="<?php echo e(asset('storage/'.$subscriptionData->manual_signed_doc )); ?>"><i class="fa fa-download"></i> Download</a>
                                                                <?php }else{ ?>

                                                                    <a class="btn btn-secondary btn-sm" target="_blank" href="<?php echo e(url('signedPdf/'.$subscriptionData->id )); ?>"><i class="fa fa-download"></i> Download</a>
                                                                <?php } ?>
                                                            </td>

                                                            <?php if(($subscriptionData->status == 1) || ($subscriptionData->status == 2)): ?>
                                                                <td>
                                                                    <a class="btn btn-secondary btn-sm" target="_blank" href="<?php echo e(url('bankPdf/'.$subscriptionData->id )); ?>"><i class="fa fa-download"></i> Download</a>
                                                                </td>
                                                            <?php else: ?> 
                                                                <td></td>
                                                            <?php endif; ?>

                                                            <?php if(($subscriptionData->status == 2) || ($subscriptionData->status == 8) || ($subscriptionData->status == 9)): ?>
                                                                <td>
                                                                    <?php 
                                                                        if(!empty($subscriptionData['SsDocumentAs'])):
                                                                            $documents = getDocument($subscriptionData['SsDocumentAs']);
                                                                            foreach ($documents as $document):
                                                                    ?>
                                                                        <?php if($document['sub_type'] == 71){ ?>

                                                                            <a class="btn btn-secondary btn-sm" href="<?php echo e(asset('storage/'.$document['file'])); ?>" download=""><i class="fa fa-download"></i>Download</a>

                                                                            <?php if($subscriptionData['bank_doc_request'] == 1){ ?>
                                                                            
                                                                            <button type="button" class="btn btn-primary btn-sm" id="confirmBankSlip" style="cursor:pointer;" get-ss-id="<?php echo e($document['id']); ?>">Confirm Bank Slip</button>

                                                                            <?php } ?>
                                                                        <?php } ?>
                                                                    <?php 
                                                                        endforeach;
                                                                    endif; ?>
                                                                </td>
                                                            <?php else: ?>
                                                                <td></td>
                                                            <?php endif; ?>

                                                            <td>
                                                                <?php echo e(date('d-M-y', strtotime($subscriptionData->created_at))); ?>

                                                            </td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    
                                                    <?php else: ?>
                                                        <tr><td colspan=9 align="center">No Records Available..</td></tr>
                                                    <?php endif; ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php endif; ?>

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
                            
                            <?php if($subscription->is_joint_account == 2): ?>

                            <div class="col-md-6">
                                <h4 class="card_title title_bNone">Joint Account Details</h4>
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

                            <div class="row col-md-12">
                                <div class="col-md-6">
                                    <h4 class="card_title mt-2">Bank Details</h4>
                                </div>

                                <div class="col-md-6 text-right">
                                    <a type="button" href="javascript:void(0);" id="changeBankButton" class="btn btn-primary btn-sm" style="float: right"> Change Bank Details</a>
                                
                                <?php if($subscription->changebank_request == 1): ?>
                                
                                    <a type="button" href="<?php echo e(asset('storage/'.$subscription->changebank_file)); ?>" class="btn btn-primary btn-sm mr-2" download style="float: right"> Download</a>
                                    
                                <?php endif; ?>

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
                            <div class="row col-md-12">
                                <div class="col-md-6">
                                    <h4 class="card_title title_bNone">Manual Signed Application</h4>
                                </div>
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-sm btn-primary" id="updateSignDocumentButton">
                                        Upload
                                    </button>
                                </div>
                            </div>

                            <div class="row col-md-12 mt-3">
                                <div class="col-md-6">
                                    <h4 class="card_title title_bNone"> Manual Bank Slip Document Upload</h4>
                                </div>
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-sm btn-primary" id="uploadBankSlipButton">
                                        Upload
                                    </button>
                                </div>
                            </div>
                            <!-- manual end -->

                            <div class="row col-md-12 mt-3">
                                <div class="col-md-6">
                                    <h4 class="card_title title_bNone">Documents </h4>
                                </div>
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
                                                	            <td>
                                                	                <?php if($document['sub_type'] == 71){ ?>
                                                                    <?php if($subscription['bank_doc_request'] == 1){ ?>
            
                                                                        <button type="button" class="btn btn-primary btn-sm" id="confirmBankSlip" style="cursor:pointer;" get-ss-id="<?php echo e($document['id']); ?>">Confirm Bank Slip</button>
                
                                                                    <?php }else{ ?>
                                                                        <button type="button" class="btn btn-primary btn-sm updateDocumentButton" style="cursor:pointer;" get-ss-id="<?php echo e($document['id']); ?>">Re-upload</button>
                
                                                                    <?php } ?>
                
                                                                    <?php }else{ ?>
                                                                        <button type="button" class="btn btn-primary btn-sm updateDocumentButton" style="cursor:pointer;" get-ss-id="<?php echo e($document['id']); ?>">Re-upload</button>
                
                                                                    <?php } ?>
                                                	            </td>
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
                                                            <a href="<?php echo e(asset('storage/'.$subscription->individual_pep_doc )); ?>" class="" download="">Download </a>
                                                        </td>
                                                        <td>
                                                            <a href="<?php echo e(asset('storage/'.$subscription->individual_pep_doc )); ?>" class="" target="_blank">Open </a>
                                                        </td>
                                                        <td>
                                                            <button type="button" attr-doc_type="1" class="btn btn-primary btn-sm updateAdditionalSubsDocumentButton" style="cursor:pointer;" get-subs-id="<?php echo e($subscription->id); ?>">Re-upload</button>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th>“SOURCE OF FUNDS/WEALTH” Letter</th>
                                                        <td>
                                                            <a href="<?php echo e(asset('storage/'.$subscription->individual_source_fund_doc )); ?>" class="" download="">Download </a>
                                                        </td>
                                                        <td>
                                                            <a href="<?php echo e(asset('storage/'.$subscription->individual_source_fund_doc )); ?>" class="" target="_blank">Open </a>
                                                        </td>
                                                        <td>
                                                            <button type="button" attr-doc_type="2" class="btn btn-primary btn-sm updateAdditionalSubsDocumentButton" style="cursor:pointer;" get-subs-id="<?php echo e($subscription->id); ?>">Re-upload</button>
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
                                                            <a href="<?php echo e(asset('storage/'.$subscription->individual_pep_doc )); ?>" class="" download="">Download </a>
                                                        </td>

                                                        <td>
                                                            <a href="<?php echo e(asset('storage/'.$subscription->individual_pep_doc )); ?>" class="" target="_blank">Open </a>
                                                        </td>
                                                        <td>
                                                            <button type="button" attr-doc_type="1" class="btn btn-primary btn-sm updateAdditionalSubsDocumentButton" style="cursor:pointer;" get-subs-id="<?php echo e($subscription->id); ?>">Re-upload</button>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th>Principal “SOURCE OF FUNDS/WEALTH” Letter</th>
                                                        <td>
                                                            <a href="<?php echo e(asset('storage/'.$subscription->individual_source_fund_doc )); ?>" class="" download="">Download </a>
                                                        </td>
                                                        <td>
                                                            <a href="<?php echo e(asset('storage/'.$subscription->individual_source_fund_doc )); ?>" class="" target="_blank">Open </a>
                                                        </td>
                                                        <td>
                                                            <button type="button" attr-doc_type="2" class="btn btn-primary btn-sm updateAdditionalSubsDocumentButton" style="cursor:pointer;" get-subs-id="<?php echo e($subscription->id); ?>">Re-upload</button>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th>Joint “PEP” Letter</th>
                                                        <td>
                                                            <a href="<?php echo e(asset('storage/'.$subscription->ja_pep_doc )); ?>" class="" download="">Download </a>
                                                        </td>
                                                        <td>
                                                            <a href="<?php echo e(asset('storage/'.$subscription->ja_pep_doc )); ?>" class="" target="_blank">Open </a>
                                                        </td>
                                                        <td>
                                                            <button type="button" attr-doc_type="3" class="btn btn-primary btn-sm updateAdditionalSubsDocumentButton" style="cursor:pointer;" get-subs-id="<?php echo e($subscription->id); ?>">Re-upload</button>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th>Joint “SOURCE OF FUNDS/WEALTH” Letter</th>
                                                        <td>
                                                            <a href="<?php echo e(asset('storage/'.$subscription->ja_source_fund_doc )); ?>" class="" download="">Download </a>
                                                        </td>
                                                        <td>
                                                            <a href="<?php echo e(asset('storage/'.$subscription->ja_source_fund_doc )); ?>" class="" target="_blank">Open </a>
                                                        </td>
                                                        <td>
                                                            <button type="button" attr-doc_type="4" class="btn btn-primary btn-sm updateAdditionalSubsDocumentButton" style="cursor:pointer;" get-subs-id="<?php echo e($subscription->id); ?>">Re-upload</button>
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

            <?php echo $__env->make('admin.elements.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        </div>
    </div>
</div>


<div class="modal fade" id="editCIModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Contract Information</h4>
                <button type="button" class="close" data-dismiss="modal"></button>
            </div>
            <form action="#" id="form-editCI" data-parsley-validate method="post" autocomplete="off">
                <div class="modal-body">
                    <div class="row">

                    <?php if($subscription->is_first): ?>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-3 col-form-label">Investment ID</label>
                                <div class="col-7 contract-info-invest">
                                    <input type="text" class="form-control" id="investment_name" name="investment_name" placeholder="Ex:JIKISD2012" value="<?php echo e($subscription->investment_name); ?>">
                                </div>
                        
                            </div>
                        </div>
                    <?php endif; ?>
                        
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-3 col-form-label">Commencement Date * </label>
                                <div class="col-9 contract-select">
                                    <input type="text" class="form-control datepicker" id="commencement_date" name="commencement_date" value="<?php echo e($subscription->commencement_date); ?>" required>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button value="save" type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Contract Information Add Model-->


<div class="modal fade" id="investmentDetailsModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Update Investment Details</h4>
                <button type="button" class="close" data-dismiss="modal"></button>
            </div>
            <form action="#" id="investmentDetailsForm" data-parsley-validate method="post" autocomplete="off">
                <div class="modal-body">
                    <div class="row">
                        <div class="row col-md-12">
                            <div class="form-group  col-md-12">
                                <label for="ip">Amount (USD).</label>
                                <input type="text" name="amount" class="form-control" required="required" id="initial-investment" value="<?php echo e($subscription->amount); ?>"/>
                            </div>
                        </div>

                       
                        <div class="row col-md-12">
                            <div class="form-group  col-md-12">
                                <label for="ip">Subscription Fees (SC)(%)</label>
                                <input type="text" name="service_charge" class="form-control" required="required" id="service-charge" value="<?php echo e($subscription->service_charge ? $subscription->service_charge : config('settings.subcription_fee')); ?>"/>
                            </div> 
                        </div>
                        
                        <div class="row col-md-12">
                            <div class="form-group  col-md-12">
                                <label for="ip">Bank Charge</label>
                                <input type="text" name="bank_charge" class="form-control" id="bank-charge" value="<?php echo e($subscription->bank_charge); ?>"/>
                            </div>     
                        </div>

                        <div class="row col-md-12">
                            <div class="form-group  col-md-12">
                                <label for="ip">No of Shares</label>
                                <input type="text" name="no_of_share" class="form-control" id="no_of_share" value="<?php echo e($subscription->no_of_share); ?>"/>
                            </div>     
                        </div>

                        <div class="row col-md-12">
                            <div class="form-group  col-md-12">
                                <label for="ip">Current Value</label>
                                <input type="text" name="current_value" class="form-control" id="current_value" value="<?php echo e($subscription->current_value); ?>"/>
                            </div>     
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button value="save" type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Investment Details Edit Model-->



<div class="modal fade" id="investmentShareModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Update Investment Share Details</h4>
                <button type="button" class="close" data-dismiss="modal"></button>
            </div>
            <form action="#" id="investmentShareDetailsForm" data-parsley-validate method="post" autocomplete="off">
                <div class="modal-body">
                    <div class="row">
                        <div class="row col-md-12">
                            <div class="form-group  col-md-12">
                                <label for="ip">Initial Investment Amount (USD).</label>
                                <input type="text" name="amount" class="form-control" required="required" id="initial-investment" value="<?php echo e($subscription->amount); ?>"/>
                            </div>
                        </div>

                        <?php

                            $totalSumOfInitial = \App\Subscription::where('user_id', $subscription->user_id)->where('investment_class_type', $subscription->investment_class_type)->where('is_first', 1)->sum('amount');

                            $totalSumOfAdditional = \App\Subscription::where('user_id', $subscription->user_id)->where('investment_class_type', $subscription->investment_class_type)->where('is_first', 0)->sum('amount');


                            $current_investment_value = $totalSumOfInitial + $totalSumOfAdditional;

                            $latestCLassANavPrice = \App\Price::where('class_type', $subscription->investment_class_type)->where('active',1)->first();

                        ?>

                        <div class="row col-md-12">
                            <div class="form-group  col-md-12">
                                <label for="ip">NAV per Share (USD) </label>
                                <input type="text" name="nav_share" class="form-control" required="required" id="nav_share" value="<?php echo e($latestCLassANavPrice->latest_price); ?>"/>
                            </div>     
                        </div>

                        <div class="row col-md-12">
                            <div class="form-group  col-md-12">
                                <label for="ip">Total Additional Investment Value</label>
                                <input type="text" name="additional_investment_value" class="form-control" id="additional_investment_value" value="<?php echo e($totalSumOfAdditional); ?>"/>
                            </div>     
                        </div>

                        <div class="row col-md-12">
                            <div class="form-group  col-md-12">
                                <label for="ip">Current Investment Value</label>
                                <input type="text" name="current_investment_value" required="required" class="form-control" id="current_investment_value" value="<?php echo e($current_investment_value); ?>"/>
                            </div>     
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button value="save" type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- End Investment Share Details Edit Model-->


<div class="modal fade" id="updateSignDocumentModel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="icofont-close-line"></i></button>
            <div class="modal-header">
                <h5 class="modal-title">Upload Signed Application</h5>
            </div>

            <form action="#"id='updateSignDocumentForm' class='form-horizontal' type='file' data-parsley-validate>
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" name="id" id="<?php echo e($subscription->id); ?>">

                    <div class="col-md-12 mb-3">
                        <label>Document</label> 
                        <input type="file" class="updateSignDocument" attr-sub_type="11" data-height="300" data-max-file-size="5M" data-allowed-file-extensions="pdf png jpg" data-show-remove="false" required/>
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



<div class="modal fade" id="uploadBankSlipDocumentModel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="icofont-close-line"></i></button>
            <div class="modal-header">
                <h5 class="modal-title">Upload Bank Slip Document</h5>
            </div>

            <form action="#"id='uploadBankSlipDocumentForm' class='form-horizontal' type='file' data-parsley-validate>
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" name="id" id="<?php echo e($subscription->id); ?>">

                    <div class="col-md-12 mb-3">
                        <label>Document</label> 
                        <input type="file" class="uploadBankSlipDocument" attr-sub_type="71" data-height="300" data-max-file-size="5M" data-allowed-file-extensions="pdf png jpg" data-show-remove="false" required/>
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


<div class="modal fade" id="updateDocumentModel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="icofont-close-line"></i></button>
            <div class="modal-header">
                <h5 class="modal-title">Upload Document</h5>
            </div>

            <form action="#"id='updateDocumentForm' class='form-horizontal' type='file' data-parsley-validate>
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" name="id" id="ss_upload_document_id">

                    <div class="col-md-12 mb-3">
                        <label>Document</label> 
                        <input type="file" class="updateDocument" attr-sub_type="11" data-height="300" data-max-file-size="5M" data-allowed-file-extensions="pdf png jpg" data-show-remove="false" required/>
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


<div class="modal fade" id="updateAdditionalSubsDocumentModel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="icofont-close-line"></i></button>
            <div class="modal-header">
                <h5 class="modal-title">Upload Document</h5>
            </div>

            <form action="#"id='updateAdditionalSubsDocumentForm' class='form-horizontal' type='file' data-parsley-validate>
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" name="id" id="additional_subs_upload_document_id">

                    <div class="col-md-12 mb-3">
                        <label>Document</label> 
                        <input type="file" class="updateAdditionalSubsDocument" data-height="300" data-max-file-size="5M" data-allowed-file-extensions="pdf png jpg" data-show-remove="false" required/>
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

<div class="modal fade" id="redemptionModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="icofont-close-line"></i></button>
            <div class="modal-header">
                <h5 class="modal-title">Redemption form</h5>
            </div>

            <?php echo Form::model($subscription, array('route' => 'flashmsgs.store', 'method'=>'POST', 'files' => true, 'id' => 'formRedemption', 'data-parsley-validate' => 'data-parsley-validate', 'autocomplete'=>"off" )); ?>


                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="sub_id" value="<?php echo e($subscription->id); ?>">
                        <input type="hidden" name="sub_class_type" value="<?php echo e($subscription->investment_class_type); ?>">
                        <div class="col-md-12 mb-3">
                            
                            <a href="<?php echo e(asset('storage/'.$subscription->redemption_file)); ?>"  download class="btn btn-base btn-rounded btn-fw mt-1 mr-1">Investor Redemption Form Download </a>
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label>Select Status</label>
                            <?php $redumption_option = [1=> 'Approved', 2=> 'Reject']; ?>
                            <?php echo Form::select('redemption_status', $redumption_option, $subscription->redemption_status, ['class' => 'form-control', 'id' => 'redemption-status', 'required']); ?>

                        </div>

                        <div class="col-md-12 mb-3" id="reasons_div">
                            <label>Enter Redemption Amount</label>
                            <?php echo Form::text('redemption_amount', $round_current_value, ['class' => 'form-control', 'id' => 'redemption_amount', 'required', 'data-parsley-type'=>"digits", "data-parsley-max"=> $current_value]); ?>

                        </div>

                        <div class="col-md-12 mb-3">
                            <label>Enter reasons</label>
                            <?php echo Form::textarea('redemption_msg', $subscription->redemption_msg, ['class' => 'form-control', 'id' => 'redemption_msg', 'required']); ?>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="actions">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> 
                        <button type="submit" class="btn btn-primary">Confirm</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>



<div class="modal fade" id="bankDetailsModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Update Bank Details</h4>
                <button type="button" class="close" data-dismiss="modal"></button>
            </div>
            <form action="#" id="bankDetailsForm" data-parsley-validate method="post" autocomplete="off">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="phone">Bank Name</label>
                                <input type="text" class="form-control" id="bank_name" name="bank_name" placeholder="Bank Name" data-parsley-group="block1" value="<?php echo e($subscription->bank_name); ?>" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="ip">Bank Address</label>
                                <input type="text" class="form-control" id="bank_address" name="bank_address" placeholder="Bank Address" data-parsley-group="block1" value="<?php echo e($subscription->bank_address); ?>" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="phone">Account Name</label>
                                <input type="text" class="form-control" id="account_name" name="account_name" placeholder="Account Name" data-parsley-group="block1" value="<?php echo e($subscription->account_name); ?>" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="ip">Account Number</label>
                                <input type="text" class="form-control" id="account_number" name="account_number" placeholder="Account Number" data-parsley-group="block1" data-parsley-type="digits" value="<?php echo e($subscription->account_number); ?>" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="phone">Swift Code</label>
                                <input type="text" class="form-control" id="swift_address" name="swift_address" placeholder="Swift Address" data-parsley-group="block1" value="<?php echo e($subscription->swift_address); ?>" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="ip">Bank IBAN#</label>
                                <input type="text" class="form-control" id="bank_inan" name="bank_inan" placeholder="Bank IBAN" data-parsley-group="block1" value="<?php echo e($subscription->bank_inan); ?>">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="ip">Reference</label>
                                <input type="text" class="form-control" id="reference" name="reference" placeholder="Reference" data-parsley-group="block1" value="<?php echo e($subscription->reference); ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button value="save" type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Change Bank Details Edit Model-->

<?php $__env->stopSection(); ?>




<?php $__env->startSection('scripts'); ?>
    <script>
        $(document).on("click","#confirmBankSlip",function() {
    
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Confirm bank slip!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.value) {
                        
                        axios.post(SITE_URL+'bankSlipConfirmEmail', {
                            id: "<?php echo e($subscription->id); ?>",
                        }).then(function (response) {
                            setTimeout(location.reload.bind(location), 1500);
                        });
                    }
                });
                   
            
        });   

        $(document).on("click","#changeStatusButton",function() {
            
            var bank_doc_request = "<?php echo e($subscription->bank_doc_request); ?>";

            if ( $(this).parsley().isValid() ) {
                    
                if($("#change_status").val() == 2){
    
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Please confirm the change of status!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes'
                    }).then((result) => {
                        if (result.value) {
                            
                            $('#send_mail').val("send");
                            $('#changeStatusForm').submit();
                        }
                    });

                }else if($("#change_status").val() == 9){

                    if (bank_doc_request == 1) {

                        Swal.fire({
                            title: 'Bank Slip Confirmation?',
                            text: "Please confirm the bank slip first!",
                            icon: 'warning'
                        });

                    } else {

                        Swal.fire({
                            title: 'Are you sure?',
                            text: "Please confirm to send the mail for fund receving!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes'
                        }).then((result) => {
                            if (result.value) {
                                
                                $('#send_fund_received_mail').val("send");
                                $('#changeStatusForm').submit();
                            }
                        });
                    }
                    
                }else{
                   
                   $('#send_mail').val("no");
                   $('#send_fund_received_mail').val("no");
                   $('#changeStatusForm').submit();
                }
                    
            }
        });   

        $(document).on("click","#contractButton",function() {
            $('#editCIModel').modal('show');
        });
    
        $('#form-editCI').submit(function(e) {
            e.preventDefault();

            if ( $(this).parsley().isValid() ) {
                
                preloader_init();

                var csrfToken = "<?php echo e(csrf_token()); ?>";
                
                const form = document.getElementById('form-editCI');
                let formData = new FormData(form);
    
                formData.set('id', "<?php echo e($subscription->id); ?>");
    
                axios.post(SITE_URL+'contractUpdate',formData,{
                        headers: {
                            'Content-Type': 'multipart/form-data',
                            'X-CSRF-Token': csrfToken}}
                ).then(function(response){
                    
                    preloader_off();
                    var item =response.data.data;
    
                    if(item != "null"){
                        
                        Swal.fire('Great Job !','Contract Information create successfully!','success');
    
                        $('#editCIModel').modal('hide');
                        setTimeout(location.reload.bind(location), 1500);
                    }else{

                        preloader_off();
                        Swal.fire('Sorry !','Contract Information edit faild!','error');
                    } 
                })
                .catch(function(){

                    preloader_off();
                    Swal.fire('Sorry !','Contract Information edit faild!','error');
                });
            }
        });


        $(document).on("click","#investmentDetailsButton",function() {
            $('#investmentDetailsModel').modal('show');
        });
    
        $('#investmentDetailsForm').submit(function(e) {
            e.preventDefault();

            if ( $(this).parsley().isValid() ) {
                
                preloader_init();
                var csrfToken = "<?php echo e(csrf_token()); ?>";
                
                const form = document.getElementById('investmentDetailsForm');
                let formData = new FormData(form);
    
                formData.set('id', "<?php echo e($subscription->id); ?>");
    
                axios.post(SITE_URL+'investmentDetailsUpdate',formData,{
                        headers: {
                            'Content-Type': 'multipart/form-data',
                            'X-CSRF-Token': csrfToken}}
                ).then(function(response){
                    
                    preloader_off();
                    var item =response.data.data;
    
                    if(item != "null"){
                        
                        preloader_off();
                        Swal.fire('Great Job !','Investment Details update successfully!','success');
    
                        $('#investmentDetailsModel').modal('hide');
                        setTimeout(location.reload.bind(location), 1500);
                    }else{

                        preloader_off();
                        Swal.fire('Sorry !','Investment Details update faild!','error');
                    } 
                })
                .catch(function(){

                    preloader_off();
                    Swal.fire('Sorry !','Investment Details update faild!','error');
                });
            }
        });


        $(document).on("click","#investmentShareButton",function() {
            $('#investmentShareModel').modal('show');
        });

        $('#investmentShareDetailsForm').submit(function(e) {
            e.preventDefault();

            if ( $(this).parsley().isValid() ) {

                preloader_init();
                var csrfToken = "<?php echo e(csrf_token()); ?>";
                
                const form = document.getElementById('investmentShareDetailsForm');
                let formData = new FormData(form);
    
                formData.set('id', "<?php echo e($subscription->id); ?>");
                formData.set('user_id', "<?php echo e($subscription->user_id); ?>");
                formData.set('investment_class_id', "<?php echo e($subscription->investment_class_type); ?>");

                axios.post(SITE_URL+'investmentShareDetailsUpdate',formData,{
                        headers: {
                            'Content-Type': 'multipart/form-data',
                            'X-CSRF-Token': csrfToken}}
                ).then(function(response){
                    
                    preloader_off();
                    var item =response.data.data;
    
                    if(item == "success"){
                        
                        preloader_off();
                        Swal.fire('Great Job !','Investment Share Details update successfully!','success');
    
                        $('#investmentDetailsModel').modal('hide');
                        setTimeout(location.reload.bind(location), 1500);

                    }else if(item == "error"){

                        preloader_off();
                        Swal.fire('Sorry !','The selected investment status is not active or not an Initial investment','error');

                    }else{

                        preloader_off();
                        Swal.fire('Sorry !','Investment Share Details update faild!','error');
                    } 
                })
                .catch(function(){

                    preloader_off();
                    Swal.fire('Sorry !','Investment Share Details update faild!','error');
                });
            }
        });

        $(document).on("click","#changeBankButton",function() {

            $('#bankDetailsModel').modal('show');
        });

        $('#bankDetailsForm').submit(function(e) {
            e.preventDefault();

            if ( $(this).parsley().isValid() ) {
                
                preloader_init();
                var csrfToken = "<?php echo e(csrf_token()); ?>";
                
                const form = document.getElementById('bankDetailsForm');
                let formData = new FormData(form);
    
                formData.set('id', "<?php echo e($subscription->id); ?>");
    
                axios.post(SITE_URL+'bankDetailsUpdate',formData,{
                        headers: {
                            'Content-Type': 'multipart/form-data',
                            'X-CSRF-Token': csrfToken}}
                ).then(function(response){
                    
                    preloader_off();
                    var item =response.data.data;
    
                    if(item != "null"){
                        
                        Swal.fire('Great Job !','Change Bank Details update successfully!','success');
    
                        $('#bankDetailsModel').modal('hide');
                        setTimeout(location.reload.bind(location), 1500);
                    }else{

                        preloader_off();
                        Swal.fire('Sorry !','Change Bank Details update faild!','error');
                    } 
                })
                .catch(function(){

                    preloader_off();
                    Swal.fire('Sorry !','Change Bank Details update faild!','error');
                });
            }
        });


        $(document).ready(function(){

            $('#updateSignDocumentButton').click(function(e){
                $('#updateSignDocumentForm')[0].reset();
                $('#updateSignDocumentModel').modal('show');
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
                    fd.append('id', "<?php echo e($subscription->id); ?>");
    
                    axios.post(SITE_URL+'manualSignedDocumentUpload',fd,{
                        headers: {
                            'Content-Type': 'multipart/form-data',
                            'X-CSRF-Token': csrfToken}}
                    ).then(function(response){

                        preloader_off();
                        Swal.fire('Great Job !','Manual Signed Application uploaded successfully!','success'); 
    
                        $('#updateSignDocumentModel').modal('hide');
                        setTimeout(location.reload.bind(location), 1500);  
    
                    })
                    .catch(function(){
                        preloader_off();
                        //Swal.fire('Sorry !','Contract Information edit faild!','error');
                    });
                }
            });


            /***********************/

            // Upload Manual Bank slip

            $('#uploadBankSlipButton').click(function(e){
                $('#uploadBankSlipDocumentForm')[0].reset();
                $('#uploadBankSlipDocumentModel').modal('show');
            });

            var drEvent = $('.uploadBankSlipDocument').dropify();

            drEvent.on('dropify.beforeClear', function(event, element){
                console.log(element);
                return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
            });

            drEvent.on('dropify.afterClear', function(event, element){
                
                alert('File deleted');
            });

            $('.uploadBankSlipDocument').change(function() {
                
                if ($(this).get(0).files.length) {

                    preloader_init();

                    var csrfToken = "<?php echo e(csrf_token()); ?>";
                    var fd = new FormData();
                    var file = $(this)[0].files[0];
    
                    fd.append('file', file);
                    fd.append('id', "<?php echo e($subscription->id); ?>");
    
                    axios.post(SITE_URL+'manualBankSlipDocumentUpload',fd,{
                        headers: {
                            'Content-Type': 'multipart/form-data',
                            'X-CSRF-Token': csrfToken}}
                    ).then(function(response){

                        preloader_off();

                        var item =response.data.data;
                        if (item == "success") {
                            Swal.fire('Great Job !','Bank slip document uploaded successfully!','success'); 
    
                            $('#uploadBankSlipDocumentModel').modal('hide');
                            setTimeout(location.reload.bind(location), 1500); 
                        }
                    })
                    .catch(function(){
                        preloader_off();
                        //Swal.fire('Sorry !','Contract Information edit faild!','error');
                    });
                }
            });

            /***********************/

            $('.updateDocumentButton').click(function(e){
                $('#updateDocumentForm')[0].reset();
                $('#updateDocumentModel').modal('show');

                var source_id = $(this).attr("get-ss-id");
                $("#ss_upload_document_id").val(source_id);
            });

            var drEvent = $('.updateDocument').dropify();

            drEvent.on('dropify.beforeClear', function(event, element){
                console.log(element);
                return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
            });

            drEvent.on('dropify.afterClear', function(event, element){
                
                alert('File deleted');
            });

            $('.updateDocument').change(function() {
                
                if ($(this).get(0).files.length) {

                    preloader_init();

                    var csrfToken = "<?php echo e(csrf_token()); ?>";
                    var fd = new FormData();
                    var file = $(this)[0].files[0];
                    fd.append('file', file);
                    fd.append('id', $("#ss_upload_document_id").val());
                    
                    axios.post(SITE_URL+'documentUpload',fd,{
                        headers: {
                            'Content-Type': 'multipart/form-data',
                            'X-CSRF-Token': csrfToken}}
                    ).then(function(response){

                        preloader_off();
                        Swal.fire('Great Job !','Document uploaded successfully!','success');   
    
                        $('#updateDocumentModel').modal('hide');
                        setTimeout(location.reload.bind(location), 1500);               
                    })
                    .catch(function(){

                        preloader_off();
                        //Swal.fire('Sorry !','Contract Information edit faild!','error');
                    });
                }
            });

            /***********************/

            //re-upload additional support documents
            $('.updateAdditionalSubsDocumentButton').click(function(e){
                $('#updateAdditionalSubsDocumentForm ')[0].reset();
                $('#updateAdditionalSubsDocumentModel').modal('show');

                var source_id = $(this).attr("attr-doc_type");
                $("#additional_subs_upload_document_id").val(source_id);
            });

            var drEvent = $('.updateAdditionalSubsDocument').dropify();

            drEvent.on('dropify.beforeClear', function(event, element){
                console.log(element);
                return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
            });

            drEvent.on('dropify.afterClear', function(event, element){
                
                alert('File deleted');
            });

            $('.updateAdditionalSubsDocument').change(function() {
                
                if ($(this).get(0).files.length) {

                    preloader_init();

                    var csrfToken = "<?php echo e(csrf_token()); ?>";
                    var fd = new FormData();
                    var file = $(this)[0].files[0];
                    fd.append('file', file);
                    fd.append('subs_id', "<?php echo e($subscription->id); ?>");
                    fd.append('upload_document_id', $("#additional_subs_upload_document_id").val());

                    axios.post(SITE_URL+'additionalSupportdocumentUpload',fd,{
                        headers: {
                            'Content-Type': 'multipart/form-data',
                            'X-CSRF-Token': csrfToken}}
                    ).then(function(response){

                        preloader_off();
                        Swal.fire('Great Job !','Document uploaded successfully!','success');   
    
                        $('#updateAdditionalSubsDocumentModel').modal('hide');
                        setTimeout(location.reload.bind(location), 1500);               
                    })
                    .catch(function(){

                        preloader_off();
                        //Swal.fire('Sorry !','Contract Information edit faild!','error');
                    });
                }
            });

        });

        $(document).on("click","#reinvestmentGenerate",function() {
            
            var sub_id = "<?php echo e($subscription->id); ?>";
            
            Swal.fire({
                title: "Are you sure?",
                text: "Please Enter Investment ID:",
                input: 'text',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                inputValidator: (value) => {
                    if (!value) {
                        return 'Please enter investment ID ex:OALIOC'
                    }
                }
            }).then((result) => {
                if (result.value) {
                    
                    preloader_init();
                    
                    var invest_id = result.value;
                    var invest_no = invest_id.toUpperCase(); 
                    axios.get(SITE_URL+'autoGenerateInvestment?sub_id='+sub_id+"&investment_id="+invest_no).then(function (response) {
                        
                        preloader_off();
                        Swal.fire('Great Job !','The investment cloned successfully!','success');
                        setTimeout(location.reload.bind(location), 3500);
                    })
                    .catch(function (error) {
                        preloader_off();
                        
                        Swal.fire('Sorry!','Data retrieve problam, please try after some time !!!','error');
                    }); 
                }
            });
        });  

        $('#redemptionButton').click(function(e){
            $('#formRedemption')[0].reset();
            $('#redemptionModal').modal('show');
            
        });
        
        $('#redemption-status').change(function(){
            if($(this).val() == 1){
                $('#reasons_div').show();
                $("#redemption_amount").attr("required", "required");
            }else{
                $('#reasons_div').hide();
                $("#redemption_amount").removeAttr("required");
                
            }
        });
        
       
        
        $('#formRedemption').submit(function(e) {

            e.preventDefault();

            if ( $(this).parsley().isValid() ) {
                
                preloader_init();
                var csrfToken = "<?php echo e(csrf_token()); ?>";

                const form = document.getElementById('formRedemption');
                let formData = new FormData(form);

                $('#redemptionModal').modal('hide');
                
                axios.post(SITE_URL+'redemptionUpdate',formData,{
                        headers: {
                            'Content-Type': 'multipart/form-data',
                            'X-CSRF-Token': csrfToken}}
                ).then(function(response){

                    preloader_off();
                    var item =response.data;

                    if(item.data === "success"){

                        preloader_off();
                        Swal.fire('Great Job !','Redemption form status change successfully, and email sent!','success');

                        $('#formRedemption')[0].reset();
                        $('#redemptionModal').modal('hide');

                        setTimeout(location.reload.bind(location), 3500);
                    }else{

                        preloader_off();
                        $('#redemptionModal').modal('hide');
                        Swal.fire('Sorry !','Redemption Form status change faild!','error');
                    } 
                })
                .catch(function(){

                    preloader_off();
                    $('#redemptionModal').modal('hide');
                    Swal.fire('Sorry !','Redemption Form status change faild!','error');
                });
            }
        });
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
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/olympus-asset.com/public_html/resources/views/admin/subscriptionView.blade.php ENDPATH**/ ?>