<div class="row mt-4">
	<div class="col-lg-12 col-md-6 col-sm-12">
		<div class="form-group">
			<label for="date">Name</label>
			<input type="text" class="form-control" id="lc_name" name="lc_name" placeholder="Name" data-parsley-group="block2" value="<?php echo e($edit ? $subscription->lc_name : old('lc_name')); ?>"  required>
		</div>
	</div>
	<div class="col-lg-12 col-md-6 col-sm-12">
		<div class="form-group">
			<label for="ip">Email</label>
			<input type="email" class="form-control" id="lc_email" name="lc_email" placeholder="Email" data-parsley-group="block2" value="<?php echo e($edit ? $subscription->lc_email : old('lc_email')); ?>" required>
		</div>
	</div>

	<div class="col-lg-2 col-md-2 col-sm-12">
		<div class="form-group">
			<label for="ip">Country Code</label>

			<select class="form-control" name="lc_phone_prefix" id="lc_phone_prefix" data-parsley-group="block2" required>
                <?php $__currentLoopData = $phone_prefix; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option <?php echo e(@$subscription->lc_phone_prefix == $data['code'] ? 'selected' : ''); ?> value="<?php echo e($data['code']); ?>"><?php echo e($data['country']); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>

			
		</div>
	</div>
	<div class="col-lg-5 col-md-5 col-sm-12">
		<div class="form-group">
			<label for="ip">Phone Number</label>
			<input type="text" class="form-control" id="lc_phone_number" name="lc_phone_number" placeholder="Phone Number" data-parsley-group="block2" data-parsley-type="digits" value="<?php echo e($edit ? $subscription->lc_phone_number : old('lc_phone_number')); ?>" required>
		</div>
	</div>
	
	<div class="col-lg-5 col-md-5 col-sm-12">
		<div class="form-group">
			<label for="ip">Facsimile</label>
			<input type="text" class="form-control" id="lc_facsimile" name="lc_facsimile" placeholder="Facsimile" data-parsley-group="block2" value="<?php echo e($edit ? $subscription->lc_facsimile : old('lc_facsimile')); ?>">
		</div>
	</div>
	<div style="height: 1px ;border: 0.2px dashed #d9d9d9;width: 100%;margin: 15px auto;"></div>
	<h4 class="pl-2 pt-2">SUBSCRIBER DETAILS</h4>
	<div class="row sec2-form mt-3">
		<div class="col-lg-12 col-md-6 col-sm-12">
			<div class="form-group">
				<label for="exampleFormControlSelect1">Legal Status Of  Subsciber</label>
				<?php 
				    $legal_statusOption = ['1'=> 'Individual','2'=> 'Company','3'=> 'General partnership','4'=> 'Limited partnership','5'=> 'Trust','6'=> 'Other']; 
				    if($edit){
				        if($subscription->legal_status == 1){
				            $legal_status_value = "Individual";
				        }else if($subscription->legal_status == 2){
				            $legal_status_value = "Company";
				        }else if($subscription->legal_status == 3){
				            $legal_status_value = "General partnership";
				        }else if($subscription->legal_status == 4){
				            $legal_status_value = "Limited partnership";
				        }else if($subscription->legal_status == 5){
				            $legal_status_value = "Trust";
				        }else{
				            $legal_status_value = "Other";
				        }
				    }else{
				        $legal_status_value = "";
				    }
				?>
				
				<?php if($additional){ ?>
				    <input type="hidden" id="legal_status" name="legal_status" data-parsley-group="block2" value="<?php echo e($edit ? $subscription->legal_status : old('legal_status')); ?>">
			        <input type="text" readonly class="form-control" id="legal_status2" name="legal_status2" data-parsley-group="block2" value="<?php echo e($legal_status_value); ?>">
			    <?php }else{ ?>
			        <?php echo Form::select('legal_status', $legal_statusOption, $edit ? $subscription->legal_status : old('legal_status'), ['class' => 'form-control', 'id' => 'legal_status', 'data-parsley-group'=>"block2", 'required', 'onchange'=>"changeLegal_status()"]); ?>

			    <?php } ?>
			</div>
		</div>
		<div class="col-lg-12 col-md-6 col-sm-12 legal_status_other_div">
			<div class="form-group">
				<label for="ip">If Other Please Specify</label>
				<input type="text" class="form-control" id="legal_status_other" name="legal_status_other" placeholder="Please Specify" data-parsley-group="block2" value="<?php echo e($edit ? $subscription->legal_status_other : old('legal_status_other')); ?>">
			</div>
		</div>
		<div class="col-lg-12">
			<div class="form-group">
				<label for="ip">If the Subscriber is not an individual, please specify the jurisdiction under whose laws
				it is incorporated, established, formed or organised</label>
				<input type="text" class="form-control" id="jurisdiction_under" name="jurisdiction_under" placeholder="Please Specify" data-parsley-group="block2" value="<?php echo e($edit ? $subscription->jurisdiction_under : old('jurisdiction_under')); ?>">
			</div>
		</div>
		<div class="col-lg-12">
            <?php 
                if(!empty($subscription->ownership_status)){
                    $edit_ownership_status = $subscription->ownership_status;
                }else{
                    $edit_ownership_status = 0;
                }
            ?>
			<div class="form-group">
				<label>Ownership Status </label>
				<div class=" mt-2 string-check string-check-bordered-base mb-2">
					<input type="radio"  name="ownership_status" data-parsley-errors-container="#ownershipStatus-errors" id="ownership_status1" value="1" <?php echo e($edit_ownership_status == '1' ? 'checked' : ''); ?> data-parsley-group="block2"  required>
					<label class="string-check-label" for="formRadioInput021">
						<span class="ml-2">The Subscriber represents and warrants that it will hold any interest in the Fund to which it may become entitled for itself beneficially and not as nominee, agent or trustee for
						another.</span>
					</label>
				</div>
				<div class="string-check string-check-bordered-base mb-2">

					<input type="radio"  name="ownership_status" data-parsley-errors-container="#ownershipStatus-errors" id="ownership_status2" value="2" <?php echo e($edit_ownership_status == '2' ? 'checked' : ''); ?> data-parsley-group="block2" required>
					<label class="string-check-label" for="formRadioInput022">
						<span class="ml-2">The Subscriber represents and warrants that it will hold any interest in the Fund to which it may become entitled as nominee or trustee for the following other person(s) or
							entity(ies), in which case: (i) the Subscriber is duly authorised to give the representations,
							warranties, acknowledgements and confirmations in this Subscription Agreement on behalf
							of each of the beneficiaries, and (ii) the Subscriber acknowledges and accepts that it (and
							not the beneficial owner(s)) will be treated as the holder of any interest(s) granted in
							respect of this Subscription Agreement and will be the Subscriber for all purposes under
							this Subscription Agreement and will be registered as a limited partner in the Fund under
							the Law. The Subscriber acknowledges and accepts, however, that it may still be required
							to provide the Fund with certain information in respect of the beneficial owner(s) in order
						that the Fund can satisfy any applicable anti-money laundering laws and regulations</span>
					</label>
				</div>
				<div class="string-check string-check-bordered-base mb-2">
					<input type="radio"   name="ownership_status" data-parsley-errors-container="#ownershipStatus-errors" id="ownership_status3" value="3" <?php echo e($edit_ownership_status == '3' ? 'checked' : ''); ?> data-parsley-group="block2" required>
					<label class="string-check-label" for="formRadioInput023">
						<span class="ml-2">The Subscriber represents and warrants that it is applying for an interest in the Fund as
							agent for the following other person(s) or entity(ies), in which case: (i) it is duly authorised
							to give the representations, warranties, acknowledgements and confirmations in this
							Subscription Agreement on behalf of each such person(s) or entity(ies), and (ii) it
							acknowledges and accepts that such person(s) or entity(ies) will be treated as the holder
							of any interest(s) granted in respect of this Subscription Agreement and will be the 
							13
							Subscriber for all purposes under this Subscription Agreement and will be registered as a
						limited partner in the Fund under the Law</span>
					</label>
				</div>
			</div>

			<div id="ownershipStatus-errors"></div>
		</div>
		<!--  -->
		<!-- radioValue1 -->
		<div class="row mt-4 sec2-form" id="ownership_status_details">
			<div class="row col-md-12">	
				<div class="col-lg-12 col-md-6 col-sm-12">
					<div class="form-group">
						<label for="date">Name</label>
						<input type="text" class="form-control" id="os_name" name="os_name" placeholder="Name" data-parsley-group="block2" value="<?php echo e($edit ? $subscription->os_name : old('os_name')); ?>">
					</div>
				</div>
				<div class="col-lg-12 col-md-6 col-sm-12">
					<div class="form-group">
						<label for="time">Address Line 1</label>
						<input type="text" class="form-control" id="os_address_line1" name="os_address_line1"  placeholder="Address Line1" data-parsley-group="block2" value="<?php echo e($edit ? $subscription->os_address_line1 : old('os_address_line1')); ?>">
					</div>
				</div>
				<div class="col-lg-12 col-md-6 col-sm-12">
					<div class="form-group">
						<label for="time">Address Line 2</label>
						<input type="text" class="form-control" id="os_address_line2" name="os_address_line2" placeholder="Address Line2" data-parsley-group="block2" value="<?php echo e($edit ? $subscription->os_address_line2 : old('os_address_line2')); ?>">
					</div>
				</div>

				<div class="col-lg-6 col-md-6 col-sm-12">
					<div class="form-group">
						<label for="datetime">City</label>
						<input type="text" class="form-control" id="os_city" name="os_city"  placeholder="City" data-parsley-group="block2" value="<?php echo e($edit ? $subscription->os_city : old('os_city')); ?>">
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-12">
					<div class="form-group">
						<label for="exampleFormControlSelect1">Country</label>
						<?php echo Form::select('os_country', $countries, $edit ? $subscription->os_country : old('os_country'), ['class' => 'form-control', 'id'=>'os_country_id', 'required', 'data-parsley-group'=>"block2"]); ?>

					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-12">
					<div class="form-group">
						<label for="credit-card">Post Code</label>
						<input type="text" class="form-control" id="os_post_code" name="os_post_code" placeholder="Post Code" data-parsley-group="block2" data-parsley-type="digits" value="<?php echo e($edit ? $subscription->os_post_code : old('os_post_code')); ?>">
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-12">
					<div class="form-group">
						<label for="exampleFormControlSelect1">State</label>
						<select class="form-control" name="os_state" id="os_state_id" data-parsley-group="block2">
			                <option value="">--</option>
			            </select>
					</div>
				</div>
			</div>	
		</div>
	</div>

	<div style="height: 1px ;border: 0.2px dashed #d9d9d9;width: 100%;margin: 15px auto;"></div>
	<h4 class="pl-2 pt-2 mb-3">DECLARATION OF POLITICALLY EXPOSED PERSON STATUS FORM </h4>

	<div class="single-account-holder" id="single-account-holder">
	
		<div class="col-md-6 ml-0">
			<label>For Principal Account Holder: </label>
		</div>
		<div class="col-lg-12 mb-0 string-check string-check-bordered-base">
			<label class="string-check-label ml-3" for="formRadioInput023">
	        <span class="">Please answer the questions/state the information requested below with regards to Politically Exposed Person (“PEP”). This is to enable the Company to comply with its obligations pursuant to the Financial Intelligence and Anti-Money Laundering Act 2002 relating to measures to combat money laundering and the financing of terrorism.</span></label>
	    </div>

	    <div class="col-lg-12 mb-0 string-check string-check-bordered-base">
			<label class="string-check-label ml-3" for="formRadioInput023">
	        <span class="">1. Do you currently hold or have you been entrusted in the past with a prominent public function (1), or are you an immediate family member (2), or close associate (3) of such a PEP?</span></label>
	    </div>

	    <?php 
            if(!empty($subscription->peb_declaration_status)){
                $edit_peb_declaration_status = $subscription->peb_declaration_status;
            }else{
                $edit_peb_declaration_status = 0;
            }
        ?>

	    <div class="col-lg-12">
			<div class="row col-md-12">
				<div class="col-sm-12 col-md-12">
		    		<div class="row">
						<div class="mt-2 string-check string-check-bordered-base mb-2 mr-3">
							<input type="radio" name="peb_declaration_status" id="peb_declaration_status" value="1" <?php echo e($edit_peb_declaration_status == '1' ? 'checked' : ''); ?> data-parsley-group="block2" data-parsley-errors-container="#pebDeclarationStatus-errors">

							<label class="string-check-label" for="peb-form">
								<span class="ml-2">No </span>
							</label>
						</div>

						<div class="mt-2 string-check string-check-bordered-base mb-2 mr-3">
							<input type="radio" name="peb_declaration_status" id="peb_declaration_status" value="2" <?php echo e($edit_peb_declaration_status == '2' ? 'checked' : ''); ?> data-parsley-group="block2" data-parsley-errors-container="#pebDeclarationStatus-errors">
							<label class="string-check-label" for="peb-form">
								<span class="ml-2">Yes - If yes, please specify (functions held, when and for how long, etc...) </span>
							</label>
						</div>
					</div>

				</div>

				<div id="pebDeclarationStatus-errors"></div>
			</div>
		</div>

		<div id="peb_declaration_other_status">
			
			<div class="col-lg-12">
		    	<label for="peb-form">Origin of the funds/ wealth</label>
		    </div>

		    <div class="col-lg-12 mb-0 string-check string-check-bordered-base">
				<label class="string-check-label ml-3" for="formRadioInput023">
		        <span class="">2. If you have answered yes to the question above, the origin of any current, and the expected origin of any future funds/ wealth, must be provided </span></label>
		    </div>

		    <?php
		        $ow_option = $edit ? explode(', ', $subscription->origin_fund_wealth) : '';
		    ?>

			<div class="col-lg-12">
				<div class="row col-md-12">
					<div class="col-sm-12 col-md-6 p-1">
						<div class="row">
							
			                <div class="col-md-6 col-sm-6 mt-1">
			                    <div class="mt-2 string-check string-check-bordered-base mb-2 mr-3">
									<input type="checkbox" name="origin_fund_wealth[]" class="origin_fund_wealth" value="Business operations" <?php echo e((is_array($ow_option) and in_array('Business operations', $ow_option)) ? 'checked' : ''); ?> id="origin_fund_wealth" data-parsley-group="block2" data-parsley-errors-container="#origin_wealthError" data-parsley-multiple="origin_fund_wealth">
									<label class="string-check-label" for="peb-form">
										<span class="ml-2">Business operations </span>
									</label>
								</div>
			                </div>

			                <div class="col-md-6 col-sm-6 mt-1">
			                   <div class="mt-2 string-check string-check-bordered-base mb-2 mr-3">
									<input type="checkbox" name="origin_fund_wealth[]" class="origin_fund_wealth" value="Returns on investments" <?php echo e((is_array($ow_option) and in_array('Returns on investments', $ow_option)) ? 'checked' : ''); ?> id="origin_fund_wealth" data-parsley-group="block2" data-parsley-errors-container="#origin_wealthError" data-parsley-multiple="origin_fund_wealth">
									<label class="string-check-label" for="peb-form">
										<span class="ml-2">Returns on investments </span>
									</label>
								</div>
			                </div>

			                <div class="col-md-6 col-sm-6">
			                    <div class="mt-2 string-check string-check-bordered-base mb-2 mr-3">
									<input type="checkbox" name="origin_fund_wealth[]" class="origin_fund_wealth" value="Loans" <?php echo e((is_array($ow_option) and in_array('Loans', $ow_option)) ? 'checked' : ''); ?> id="origin_fund_wealth" data-parsley-group="block2" data-parsley-errors-container="#origin_wealthError" data-parsley-multiple="origin_fund_wealth">
									<label class="string-check-label" for="peb-form">
										<span class="ml-2">Loans </span>
									</label>
								</div>
			                </div>
			                
			                <div class="col-md-6 col-sm-6">
			                   <div class="mt-2 string-check string-check-bordered-base mb-2 mr-3">
									<input type="checkbox" name="origin_fund_wealth[]" class="origin_fund_wealth" value="Salaries" <?php echo e((is_array($ow_option) and in_array('Salaries', $ow_option)) ? 'checked' : ''); ?> id="origin_fund_wealth" data-parsley-group="block2" data-parsley-errors-container="#origin_wealthError" data-parsley-multiple="origin_fund_wealth">
									<label class="string-check-label" for="peb-form">
										<span class="ml-2">Salaries </span>
									</label>
								</div>
			                </div>

			                <div class="col-md-6 col-sm-6">
			                    <div class="mt-2 string-check string-check-bordered-base mb-2 mr-3">
									<input type="checkbox" name="origin_fund_wealth[]" class="origin_fund_wealth" value="Inheritance" <?php echo e((is_array($ow_option) and in_array('Inheritance', $ow_option)) ? 'checked' : ''); ?> id="origin_fund_wealth" data-parsley-group="block2" data-parsley-errors-container="#origin_wealthError" data-parsley-multiple="origin_fund_wealth">
									<label class="string-check-label" for="peb-form">
										<span class="ml-2">Inheritance </span>
									</label>
								</div>
			                </div>
			                
			                <div class="col-md-6 col-sm-6">
			                   <div class="mt-2 string-check string-check-bordered-base mb-2 mr-3">
									<input type="checkbox" name="origin_fund_wealth[]" class="origin_fund_wealth" value="Other" <?php echo e((is_array($ow_option) and in_array('Other', $ow_option)) ? 'checked' : ''); ?> id="origin_fund_wealth" data-parsley-group="block2" data-parsley-errors-container="#origin_wealthError" data-parsley-multiple="origin_fund_wealth">
									<label class="string-check-label" for="peb-form">
										<span class="ml-2">Other Please specify? </span>
									</label>
								</div>
			                </div>

			                <span id="origin_wealthError"></span>
			            </div>

			            <div class="row col-lg-12 mt-3 individual origin_wealth_other" id="origin_wealth_other">
		                    <input type="text" name="origin_fund_wealth_other" id="origin_fund_wealth_other" class="form-control search-input" value="<?php echo e($edit ? $subscription->origin_fund_wealth_other : old('origin_fund_wealth_other')); ?>" data-parsley-group="block2" maxlength="50">
		                </div>

					</div>
				</div>
			</div>

		</div>

	    <h4 class="pl-2 pt-2 mb-3 mt-3">DECLARATION OF SOURCE OF FUNDS/WEALTH </h4>
	    <div class="col-md-6 ml-0">
			<label>I am pleased to confirm that I have built my wealth by: </label>
		</div>

	    <?php
	        $sw_option = $edit ? explode(', ', $subscription->source_of_wealth) : '';
	    ?>

	    <div class="col-lg-12">
			<div class="row col-md-12">
				<div class="col-sm-12 col-md-6 p-1">
					<div class="row">
						
						<?php $__currentLoopData = $userSourceWealthDocuments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userSourceWealth): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if($userSourceWealth->source_list_type == "check"): ?>
								<div class="col-md-6 col-sm-6 mt-1">
				                    <div class="mt-2 string-check string-check-bordered-base mb-2 mr-3">
										<input type="checkbox" name="source_of_wealth[]" class="source_of_wealth" value="<?php echo e($userSourceWealth->name); ?>" <?php echo e((is_array($sw_option) and in_array($userSourceWealth->name, $sw_option)) ? 'checked' : ''); ?> id="source_of_wealth" data-parsley-group="block2" data-parsley-errors-container="#source_of_wealthError" data-parsley-multiple="source_of_wealth">
										<label class="string-check-label" for="peb-form">
											<span class="ml-2"><?php echo e($userSourceWealth->name); ?> </span>
										</label>
									</div>
				                </div>
			                <?php endif; ?>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		                
		                <span id="source_of_wealthError"></span>
		            </div>

		            <div class="col-md-12 col-md-6 p-1 mt-3 individual source_of_wealth_other" id="individual_source_of_wealth_other">
						<div class="form-group">
							<label for="exampleFormControlSelect1">If Other Please Specify </label>
							<?php 
								$sourceWealthOtherOptions = \App\UserSourceWealth::with('UserSourceWealthDocuments')->where('source_list_type', 'list')->pluck('name', 'name'); 
							?>

							<?php echo Form::select('source_of_wealth_other', $sourceWealthOtherOptions, $edit ? @$subscription->source_of_wealth_other : @$subscription->source_of_wealth_other,
				                ['placeholder' => 'Please select if other ...', 'class' => 'form-control', 'id' => 'source_of_wealth_other', 'data-parsley-group'=>"block2"]); ?>

						</div>
					</div>

				</div>
			</div>
		</div>


		<div class="col-md-6 ml-0">
			<label>I further confirm that my source of funds come from: </label>
		</div>

	    <?php
	        $sw_option_funds_comes = $edit ? explode(', ', $subscription->source_of_wealth_funds_comes) : '';
	    ?>

	    <div class="col-lg-12">
			<div class="row col-md-12">
				<div class="col-sm-12 col-md-6 p-1">
					<div class="row">
						
						<?php $__currentLoopData = $userSourceWealthDocuments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userSourceWealth): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if($userSourceWealth->source_list_type == "check"): ?>
								<div class="col-md-6 col-sm-6 mt-1">
				                    <div class="mt-2 string-check string-check-bordered-base mb-2 mr-3">
										<input type="checkbox" name="source_of_wealth_funds_comes[]" class="source_of_wealth_funds_comes" value="<?php echo e($userSourceWealth->name); ?>" <?php echo e((is_array($sw_option_funds_comes) and in_array($userSourceWealth->name, $sw_option_funds_comes)) ? 'checked' : ''); ?> id="source_of_wealth_funds_comes" data-parsley-group="block2" data-parsley-errors-container="#source_of_wealth_fund_comesError" data-parsley-multiple="source_of_wealth_funds_comes">
										<label class="string-check-label" for="peb-form">
											<span class="ml-2"><?php echo e($userSourceWealth->name); ?> </span>
										</label>
									</div>
				                </div>
			                <?php endif; ?>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		                
		                <span id="source_of_wealth_fund_comesError"></span>
		            </div>

		            <div class="col-md-12 col-md-6 p-1 mt-3 individual source_of_wealth_funds_comes_other" id="individual_source_of_wealth_other_comes_other">
						<div class="form-group">
							<label for="exampleFormControlSelect1">If Other Please Specify </label>
							<?php 
								$sourceWealthOtherOptions = \App\UserSourceWealth::with('UserSourceWealthDocuments')->where('source_list_type', 'list')->pluck('name', 'name'); 
							?>

							<?php echo Form::select('source_of_wealth_funds_comes_other', $sourceWealthOtherOptions, $edit ? @$subscription->source_of_wealth_funds_comes_other : @$subscription->source_of_wealth_funds_comes_other,
				                ['placeholder' => 'Please select if other ...', 'class' => 'form-control', 'id' => 'source_of_wealth_funds_comes_other', 'data-parsley-group'=>"block2"]); ?>

						</div>
					</div>

				</div>
			</div>
		</div>

	</div>

	<div style="height: 1px ;border: 0.2px dashed #d9d9d9;width: 100%;margin: 15px auto;"></div>
	<div class="joint-account-holder" id="joint-account-holder">

		<div class="col-md-6 ml-0">
			<label>For Joint Account Holder: </label>
		</div>

		<div class="col-lg-12 mb-0 string-check string-check-bordered-base">
			<label class="string-check-label ml-3" for="formRadioInput023">
	        <span class="">Please answer the questions/state the information requested below with regards to Politically Exposed Person (“PEP”). This is to enable the Company to comply with its obligations pursuant to the Financial Intelligence and Anti-Money Laundering Act 2002 relating to measures to combat money laundering and the financing of terrorism. </span></label>
	    </div>

	    <div class="col-lg-12 mb-0 string-check string-check-bordered-base">
			<label class="string-check-label ml-3" for="formRadioInput023">
	        <span class="">1. Do you currently hold or have you been entrusted in the past with a prominent public function (1), or are you an immediate family member (2), or close associate (3) of such a PEP? </span></label>
	    </div>

	    <?php 
            if(!empty($subscription->ja_peb_declaration_status)){
                $edit_ja_peb_declaration_status = $subscription->ja_peb_declaration_status;
            }else{
                $edit_ja_peb_declaration_status = 0;
            }
        ?>

	    <div class="col-lg-12">
			<div class="row col-md-12">
				<div class="col-sm-12 col-md-12">
		    		<div class="row">
						<div class="mt-2 string-check string-check-bordered-base mb-2 mr-3">
							<input type="radio" name="ja_peb_declaration_status" id="ja_peb_declaration_status" value="1" <?php echo e($edit_ja_peb_declaration_status == '1' ? 'checked' : ''); ?> data-parsley-group="block2" data-parsley-errors-container="#jointPebDeclarationStatus-errors">

							<label class="string-check-label" for="peb-form">
								<span class="ml-2">No </span>
							</label>
						</div>

						<div class="mt-2 string-check string-check-bordered-base mb-2 mr-3">
							<input type="radio" name="ja_peb_declaration_status" id="ja_peb_declaration_status" value="2" <?php echo e($edit_ja_peb_declaration_status == '2' ? 'checked' : ''); ?> data-parsley-group="block2" data-parsley-errors-container="#jointPebDeclarationStatus-errors">
							<label class="string-check-label" for="peb-form">
								<span class="ml-2">Yes - If yes, please specify (functions held, when and for how long, etc...) </span>
							</label>
						</div>
					</div>

				</div>

				<div id="jointPebDeclarationStatus-errors"></div>
			</div>
		</div>

		<div class="ja_peb_declaration_other_status" id="ja_peb_declaration_other_status">
			<div class="col-lg-12">
		    	<label for="peb-form">Origin of the funds/ wealth</label>
		    </div>

		    <div class="col-lg-12 mb-0 string-check string-check-bordered-base">
				<label class="string-check-label ml-3" for="formRadioInput023">
		        <span class="">2. If you have answered yes to the question above, the origin of any current, and the expected origin of any future funds/ wealth, must be provided </span></label>
		    </div>

		    <?php
		        $ja_ow_option = $edit ? explode(', ', @$subscription->ja_origin_fund_wealth) : '';
		    ?>

			<div class="col-lg-12">
				<div class="row col-md-12">
					<div class="col-sm-12 col-md-6 p-1">
						<div class="row">
							
			                <div class="col-md-6 col-sm-6 mt-1">
			                    <div class="mt-2 string-check string-check-bordered-base mb-2 mr-3">
									<input type="checkbox" name="ja_origin_fund_wealth[]" class="ja_origin_fund_wealth" value="Business operations" <?php echo e((is_array($ja_ow_option) and in_array('Business operations', $ja_ow_option)) ? ' checked' : ''); ?> id="ja_origin_fund_wealth" data-parsley-group="block2" data-parsley-errors-container="#ja_origin_wealthError" data-parsley-multiple="ja_origin_fund_wealth">
									<label class="string-check-label" for="peb-form">
										<span class="ml-2">Business operations </span>
									</label>
								</div>
			                </div>

			                <div class="col-md-6 col-sm-6 mt-1">
			                   <div class="mt-2 string-check string-check-bordered-base mb-2 mr-3">
									<input type="checkbox" name="ja_origin_fund_wealth[]" class="ja_origin_fund_wealth" value="Returns on investments" <?php echo e((is_array($ja_ow_option) and in_array('Returns on investments', $ja_ow_option)) ? ' checked' : ''); ?> id="ja_origin_fund_wealth" data-parsley-group="block2" data-parsley-errors-container="#ja_origin_wealthError" data-parsley-multiple="ja_origin_fund_wealth">
									<label class="string-check-label" for="peb-form">
										<span class="ml-2">Returns on investments </span>
									</label>
								</div>
			                </div>

			                <div class="col-md-6 col-sm-6">
			                    <div class="mt-2 string-check string-check-bordered-base mb-2 mr-3">
									<input type="checkbox" name="ja_origin_fund_wealth[]" class="ja_origin_fund_wealth" value="Loans" <?php echo e((is_array($ja_ow_option) and in_array('Loans', $ja_ow_option)) ? ' checked' : ''); ?> id="ja_origin_fund_wealth" data-parsley-group="block2" data-parsley-errors-container="#ja_origin_wealthError" data-parsley-multiple="ja_origin_fund_wealth">
									<label class="string-check-label" for="peb-form">
										<span class="ml-2">Loans </span>
									</label>
								</div>
			                </div>
			                
			                <div class="col-md-6 col-sm-6">
			                   <div class="mt-2 string-check string-check-bordered-base mb-2 mr-3">
									<input type="checkbox" name="ja_origin_fund_wealth[]" class="ja_origin_fund_wealth" value="Salaries" <?php echo e((is_array($ja_ow_option) and in_array('Salaries', $ja_ow_option)) ? ' checked' : ''); ?> id="ja_origin_fund_wealth" data-parsley-group="block2" data-parsley-errors-container="#ja_origin_wealthError" data-parsley-multiple="ja_origin_fund_wealth">
									<label class="string-check-label" for="peb-form">
										<span class="ml-2">Salaries </span>
									</label>
								</div>
			                </div>

			                <div class="col-md-6 col-sm-6">
			                    <div class="mt-2 string-check string-check-bordered-base mb-2 mr-3">
									<input type="checkbox" name="ja_origin_fund_wealth[]" class="ja_origin_fund_wealth" value="Inheritance" <?php echo e((is_array($ja_ow_option) and in_array('Inheritance', $ja_ow_option)) ? ' checked' : ''); ?> id="ja_origin_fund_wealth" data-parsley-group="block2" data-parsley-errors-container="#ja_origin_wealthError" data-parsley-multiple="ja_origin_fund_wealth">
									<label class="string-check-label" for="peb-form">
										<span class="ml-2">Inheritance </span>
									</label>
								</div>
			                </div>
			                
			                <div class="col-md-6 col-sm-6">
			                   <div class="mt-2 string-check string-check-bordered-base mb-2 mr-3">
									<input type="checkbox" name="ja_origin_fund_wealth[]" class="ja_origin_fund_wealth" value="Other" <?php echo e((is_array($ja_ow_option) and in_array('Other', $ja_ow_option)) ? ' checked' : ''); ?> id="ja_origin_fund_wealth" data-parsley-group="block2" data-parsley-errors-container="#ja_origin_wealthError" data-parsley-multiple="ja_origin_fund_wealth">
									<label class="string-check-label" for="peb-form">
										<span class="ml-2">Other Please specify? </span>
									</label>
								</div>
			                </div>

			                <span id="ja_origin_wealthError"></span>
			            </div>

			            <div class="row col-lg-12 mt-3 joint ja_origin_wealth_other" id="ja_origin_wealth_other">
		                    <input type="text" name="ja_origin_fund_wealth_other" id="ja_origin_fund_wealth_other" class="form-control search-input" value="<?php echo e($edit ? $subscription->ja_origin_fund_wealth_other : old('ja_origin_fund_wealth_other')); ?>" data-parsley-group="block2" maxlength="50">
		                </div>

					</div>
				</div>
			</div>
		</div>

	    <h4 class="pl-2 pt-2 mb-3 mt-3">DECLARATION OF SOURCE OF FUNDS/WEALTH </h4>

	    <div class="col-md-6 ml-0">
			<label>I am pleased to confirm that I have built my wealth by: </label>
		</div>

	    <?php
	        $ja_sw_option = $edit ? explode(', ', @$subscription->ja_source_of_wealth) : '';
	    ?>

	    <div class="col-lg-12">
			<div class="row col-md-12">
				<div class="col-sm-12 col-md-6 p-1">
					<div class="row">

						<?php $__currentLoopData = $userSourceWealthDocuments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userSourceWealth): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if($userSourceWealth->source_list_type == "check"): ?>
				                <div class="col-md-6 col-sm-6 mt-1">
				                    <div class="mt-2 string-check string-check-bordered-base mb-2 mr-3">
										<input type="checkbox" name="ja_source_of_wealth[]" class="ja_source_of_wealth" value="<?php echo e($userSourceWealth->name); ?>" <?php echo e((is_array($ja_sw_option) and in_array($userSourceWealth->name, $ja_sw_option)) ? 'checked' : ''); ?> id="ja_source_of_wealth" data-parsley-group="block2" data-parsley-errors-container="#ja_source_of_wealthError" data-parsley-multiple="ja_source_of_wealth">
										<label class="string-check-label" for="peb-form">
											<span class="ml-2"><?php echo e($userSourceWealth->name); ?> </span>
										</label>
									</div>
				                </div>
			                <?php endif; ?>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

		                <span id="ja_source_of_wealthError"></span>
		            </div>

		            <div class="col-md-12 col-md-6 p-1 mt-3 joint ja_source_of_wealth_other" id="joint_source_of_wealth_other">
						<div class="form-group">
							<label for="exampleFormControlSelect1">If Other Please Specify </label>
							<?php 
								$jaSourceWealthOtherOptions = \App\UserSourceWealth::with('UserSourceWealthDocuments')->where('source_list_type', 'list')->pluck('name', 'name'); 	
							?>
							<?php echo Form::select('ja_source_of_wealth_other', $jaSourceWealthOtherOptions, $edit ? @$subscription->ja_source_of_wealth_other : @$subscription->ja_source_of_wealth_other,
				                ['placeholder' => 'Please select if other ...','class' => 'form-control', 'id' => 'ja_source_of_wealth_other', 'data-parsley-group'=>"block2"]); ?>

						</div>
					</div>

				</div>
			</div>
		</div>

	    <div class="col-md-6 ml-0">
			<label>I further confirm that my source of funds come from: </label>
		</div>

	    <?php
	        $ja_sw_option_funds_comes = $edit ? explode(', ', $subscription->ja_source_of_wealth_funds_comes) : '';
	    ?>

	    <div class="col-lg-12">
			<div class="row col-md-12">
				<div class="col-sm-12 col-md-6 p-1">
					<div class="row">
						
						<?php $__currentLoopData = $userSourceWealthDocuments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userSourceWealth): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if($userSourceWealth->source_list_type == "check"): ?>
								<div class="col-md-6 col-sm-6 mt-1">
				                    <div class="mt-2 string-check string-check-bordered-base mb-2 mr-3">
										<input type="checkbox" name="ja_source_of_wealth_funds_comes[]" class="ja_source_of_wealth_funds_comes" value="<?php echo e($userSourceWealth->name); ?>" <?php echo e((is_array($ja_sw_option_funds_comes) and in_array($userSourceWealth->name, $ja_sw_option_funds_comes)) ? 'checked' : ''); ?> id="ja_source_of_wealth_funds_comes" data-parsley-group="block2" data-parsley-errors-container="#jaSource_of_wealth_fund_comesError" data-parsley-multiple="ja_source_of_wealth_funds_comes">
										<label class="string-check-label" for="peb-form">
											<span class="ml-2"><?php echo e($userSourceWealth->name); ?> </span>
										</label>
									</div>
				                </div>
			                <?php endif; ?>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		                
		                <span id="jaSource_of_wealth_fund_comesError"></span>
		            </div>

		            <div class="col-md-12 col-md-6 p-1 mt-3 joint ja_source_of_wealth_funds_comes_other" id="joint_source_of_wealth_other_comes_other">
						<div class="form-group">
							<label for="exampleFormControlSelect1">If Other Please Specify </label>
							<?php 
								$sourceWealthOtherOptions = \App\UserSourceWealth::with('UserSourceWealthDocuments')->where('source_list_type', 'list')->pluck('name', 'name'); 
							?>

							<?php echo Form::select('ja_source_of_wealth_funds_comes_other', $sourceWealthOtherOptions, $edit ? @$subscription->ja_source_of_wealth_funds_comes_other : @$subscription->ja_source_of_wealth_funds_comes_other,
				                ['placeholder' => 'Please select if other ...', 'class' => 'form-control', 'id' => 'ja_source_of_wealth_funds_comes_other', 'data-parsley-group'=>"block2"]); ?>

						</div>
					</div>

				</div>
			</div>
		</div>


	</div>

</div><?php /**PATH /var/www/html/olympus-asset.com/public_html/resources/views/admin/elements/newSubscription/additional.blade.php ENDPATH**/ ?>