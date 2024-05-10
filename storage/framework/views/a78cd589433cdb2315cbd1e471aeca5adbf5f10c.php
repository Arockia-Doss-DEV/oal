<?php
	$default_passport = "/admin/images/sample_image/passport.jpg";
	$default_bank = "/admin/images/sample_image/bank-ref.jpg";
	$default_cv = "/admin/images/sample_image/cv.jpg";
?>

<div class="row mt-4">
	<div class="col-lg-12 col-md-12 col-sm-12">
		<div class="form-group">
			<label for="status">Subscriber Status *</label>
			<?php 
			    $subscriber_typeOption = ['1'=> 'Individual','2'=> 'Private Fund','3'=> 'Trust','4'=> 'Fund','5'=> 'Regulated financial services business or public listed company','6'=> 'Financial services institution or bank investing pooled funds i.e. CIS / Pension
				Funds']; 
				
				if($edit){
			        if($subscription->subscriber_type == 1){
			            $subscriber_type_value = "Individual";
			        }else if($subscription->subscriber_type == 2){
			            $subscriber_type_value = "Private Fund";
			        }else if($subscription->subscriber_type == 3){
			            $subscriber_type_value = "Trust";
			        }else if($subscription->subscriber_type == 4){
			            $subscriber_type_value = "Fund";
			        }else if($subscription->subscriber_type == 5){
			            $subscriber_type_value = "Regulated financial services business or public listed company";
			        }else if($subscription->subscriber_type == 6){
			            $subscriber_type_value = "Financial services institution or bank investing pooled funds i.e. CIS / Pension Funds";
			        }else{
			            $subscriber_type_value = "";
			        }
			    }else{
			        $subscriber_type_value = "";
			    }    
			?>
			
			<?php if($additional){ ?>
			    <input type="hidden" id="subscriber_type" name="subscriber_type" data-parsley-group="block3" value="<?php echo e($edit ? $subscription->subscriber_type : old('subscriber_type')); ?>">
		        <input type="text" readonly class="form-control" id="subscriber_type" name="subscriber_type" data-parsley-group="block3" value="<?php echo e($subscriber_type_value); ?>">
			<?php }else{ ?>
			    <?php echo Form::select('subscriber_type', $subscriber_typeOption, $edit ? $subscription->subscriber_type : old('subscriber_type'), ['class' => 'form-control', 'id' => 'subscriber_type', 'data-parsley-group'=>"block3", 'required', 'onchange'=>"changeSubscriberType()", 'placeholder' => 'Please Select' ]); ?>

			<?php } ?>
				
		</div>
	</div>

	<!-- Individual Fund = 1 (5)-->
	<div class="row mt-2 pl-3 status-individual" id="individual">

		<div class="col-lg-12">
			<span class="text-danger">Reminder: All supporting documents must be certified as true copies by recognised professional practitioners.We may require additional documents or information to complete the Know Your Client(KYC) process.</span>

			

			

		</div><br>

		<div class="row col-md-12 col-sm-12 col-10">
			<div class=" col-md-6 col-sm-8 col-10">
				<div class="form-group">
					<label for="ip">Certified Passport / ID Copies </label>
					<div class="col-lg-9 col-md-6 col-sm-12 col-12 pl-0">
						<input type="file" class="dropify" id="subtype11" data-parsley-group="block3" attr-sub-type="11" attr-remarks="Certified Passport / ID Copies" data-height="300" data-default-file="<?php echo e(asset($default_passport)); ?>" data-max-file-size="5M" data-allowed-file-extensions="pdf png jpg" data-parsley-errors-container="#subtype11-errors" data-remove-required="0"/>
					</div>
                    <div id="subtype11-errors"></div>
				</div>
			</div>
			<div class=" col-md-6 col-sm-8 col-10">
				<div class="form-group">
					<label for="ip">Professional/Bank Reference</label>
					<div class="col-lg-9 col-md-6 col-sm-12 col-12 pl-0">
						<input type="file" class="dropify" id="subtype12" data-parsley-group="block3" attr-sub-type="12" attr-remarks="Professional/Bank Reference" data-height="300" data-default-file="<?php echo e(asset($default_bank)); ?>" data-max-file-size="5M" data-allowed-file-extensions="pdf png jpg" data-parsley-errors-container="#subtype12-errors" data-remove-required="0"/>
					</div>
                    <div id="subtype12-errors"></div>
				</div>
				<div class="col-lg-12 pl-0">
	                <div class="note-full"><span class="note">Note: </span> Click to download bank document <a href="<?php echo e(asset('admin/images/docs/bank-reference-template-v2.pdf')); ?>" target="_blank">Download </a></div>
	            </div><br>
			</div>
			<div class=" col-md-6 col-sm-8 col-10">
				<div class="form-group">
					<label for="ip">Curriculum Vitae </label>
					<div class="col-lg-9 col-md-6 col-sm-12 col-12 pl-0">
						<input type="file" class="dropify" id="subtype13" data-parsley-group="block3" attr-sub-type="13" attr-remarks="Curriculum Vitae" data-height="300" data-default-file="<?php echo e(asset($default_cv)); ?>" data-max-file-size="5M" data-allowed-file-extensions="pdf png jpg" data-parsley-errors-container="#subtype13-errors" data-remove-required="0"/>
					</div>
					<div id="subtype13-errors"></div>
				</div>
			</div>
			<div class=" col-md-6 col-sm-8 col-10">
				<div class="form-group">
					<label for="ip">Address Proof</label>
					<div class="col-lg-9 col-md-6 col-sm-12 col-12 pl-0">
						<input type="file" class="dropify" id="subtype14" data-parsley-group="block3" attr-sub-type="14" attr-remarks="Address Proof" data-height="300" data-default-file="<?php echo e(asset($default_bank)); ?>" data-max-file-size="5M" data-allowed-file-extensions="pdf png jpg" data-parsley-errors-container="#subtype14-errors" data-remove-required="0"/>
					</div>
					<div id="subtype14-errors"></div>
				</div>
			</div>

			<div class="col-md-6 principal-holder-source-fund">
				<div class="form-group">
					<label for="ip">Principal Holder's Proof Of Source Of Funds And Wealth
					</label>
					<div class="col-lg-9 col-md-6 col-sm-12 p-1">
						<input type="file" class="dropify" id="subtype15" data-parsley-group="block3" attr-sub-type="15" attr-remarks="Principal Proof Of Source Of Funds And Wealth" data-height="300" data-default-file="<?php echo e(asset($default_bank)); ?>" data-max-file-size="5M" data-allowed-file-extensions="pdf png jpg" data-parsley-errors-container="#subtype15-errors" data-remove-required="0"/>
					</div>
					<div id="subtype15-errors"></div>
				</div>
			</div>

		</div>	
	</div>


	
	<div class="row mt-1 pl-3 status-individual joint-holder-source-fund" id="individual">

		<div class="col-lg-12">
			<label>Joint Account’s Certified Documents: </label>
		</div>

		<div class="row col-md-12 col-sm-12 col-10">
			<div class=" col-md-6 col-sm-8 col-10 mt-2">
				<div class="form-group">
					<label for="ip">Certified Passport / ID Copies </label>
					<div class="col-lg-9 col-md-6 col-sm-12">
						<input type="file" class="dropify" id="subtype71" attr-sub-type="71" attr-remarks="Joint Account’s Certified Passport / ID Copies" data-height="300" data-default-file="<?php echo e(asset($default_passport)); ?>" data-max-file-size="5M" data-allowed-file-extensions="pdf png jpg" data-parsley-errors-container="#subtype71-errors" data-remove-required="0"/>
					</div>
	                <div id="subtype71-errors"></div>
				</div>
			</div>
			<div class=" col-md-6 col-sm-8 col-10">
				<div class="form-group">
					<label for="ip">Professional/Bank Reference</label>
					<div class="col-lg-9 col-md-6 col-sm-12">
						<input type="file" class="dropify" id="subtype72" attr-sub-type="72" attr-remarks="Joint Account’s Professional/Bank Reference" data-height="300" data-default-file="<?php echo e(asset($default_bank)); ?>" data-max-file-size="5M" data-allowed-file-extensions="pdf png jpg" data-parsley-errors-container="#subtype72-errors" data-remove-required="0"/>
					</div>
	                <div id="subtype72-errors"></div>
				</div>
				<div class="col-lg-12 pl-0">
	                <div class="note-full"><span class="note">Note: </span> Click to download bank document <a href="<?php echo e(asset('admin/images/docs/bank-reference-template-v2.pdf')); ?>" target="_blank">Download </a></div>
	            </div><br>
			</div>
			<div class=" col-md-6 col-sm-8 col-10">
				<div class="form-group">
					<label for="ip">Curriculum Vitae </label>
					<div class="col-lg-9 col-md-6 col-sm-12">
						<input type="file" class="dropify" id="subtype73" attr-sub-type="73" attr-remarks="Joint Account’s Curriculum Vitae" data-height="300" data-default-file="<?php echo e(asset($default_cv)); ?>" data-max-file-size="5M" data-allowed-file-extensions="pdf png jpg" data-parsley-errors-container="#subtype73-errors" data-remove-required="0"/>
					</div>
					<div id="subtype73-errors"></div>
				</div>
			</div>
			<div class=" col-md-6 col-sm-8 col-10">
				<div class="form-group">
					<label for="ip">Address Proof</label>
					<div class="col-lg-9 col-md-6 col-sm-12">
						<input type="file" class="dropify" id="subtype74" attr-sub-type="74" attr-remarks="Joint Account’s Address Proof" data-height="300" data-default-file="<?php echo e(asset($default_bank)); ?>" data-max-file-size="5M" data-allowed-file-extensions="pdf png jpg" data-parsley-errors-container="#subtype74-errors" data-remove-required="0"/>
					</div>
					<div id="subtype74-errors"></div>
				</div>
			</div>

			<div class="col-md-6 col-sm-8 col-10">
				<div class="form-group">
					<label for="ip">Joint Holder's Proof Of Source Of Funds And Wealth
					</label>
					<div class="col-lg-9 col-md-6 col-sm-12 p-1">
						<input type="file" class="dropify" id="subtype16" attr-sub-type="16" attr-remarks="Joint Account’s Joint Proof Of Source Of Funds And Wealth" data-height="300" data-default-file="<?php echo e(asset($default_bank)); ?>" data-max-file-size="5M" data-allowed-file-extensions="pdf png jpg" data-parsley-errors-container="#subtype16-errors" data-remove-required="0"/>
					</div>
					<div id="subtype16-errors"></div>
				</div>
			</div>
		</div>
	</div>


	<!-- Private Fund = 2 (6)-->
	<div class="row mt-4 pl-3 status-private" id="private-fund">
		<div class="row col-md-12 col-sm-12 col-10">
			<div class=" col-md-6 col-sm-8 col-10">
				<div class="form-group">
					<label for="ip">Certified Copy Of Certificate Of Incorporation  </label>
					<div class="col-lg-9 col-md-6 col-sm-12 col-12 pl-0">
						<input type="file" class="dropify" id="subtype21" data-parsley-group="block3" attr-sub-type="21" attr-remarks="Certified Copy Of Certificate Of Incorporation" data-height="300" data-default-file="<?php echo e(asset($default_bank)); ?>" data-max-file-size="5M" data-allowed-file-extensions="pdf png jpg" data-parsley-errors-container="#subtype21-errors" data-remove-required="0"/>
					</div>
					<div id="subtype21-errors"></div>
				</div>
			</div>
			<div class=" col-md-6 col-sm-8 col-10">
				<div class="form-group">
					<label for="ip">Certificate of Good Standing or Audited Accounts
					</label>
					<div class="col-lg-9 col-md-6 col-sm-12 col-12 pl-0">
						<input type="file" class="dropify" id="subtype22" data-parsley-group="block3" attr-sub-type="22" attr-remarks="Certificate of Good Standing or Audited Accounts"  data-height="300" data-default-file="<?php echo e(asset($default_bank)); ?>" data-max-file-size="5M" data-allowed-file-extensions="pdf png jpg" data-parsley-errors-container="#subtype22-errors" data-remove-required="0"/>
					</div>
					<div id="subtype22-errors"></div>
				</div>
			</div>

			<div class=" col-md-6 col-sm-8 col-10">
				<div class="form-group">
					<label for="ip">Details of registered office and place of business </label>
					<div class="col-lg-9 col-md-6 col-sm-12 col-12 pl-0">
						<input type="file" class="dropify" id="subtype23" data-parsley-group="block3" attr-sub-type="23" attr-remarks="Details of registered office and place of business" data-height="300" data-default-file="<?php echo e(asset($default_bank)); ?>" data-max-file-size="5M" data-allowed-file-extensions="pdf png jpg" data-parsley-errors-container="#subtype23-errors" data-remove-required="0"/>
					</div>
					<div id="subtype23-errors"></div>
				</div>
			</div>
			<div class=" col-md-6 col-sm-8 col-10">
				<div class="form-group">
					<label for="ip"> List of Directors 
					</label>
					<div class="col-lg-9 col-md-6 col-sm-12 col-12 pl-0">
						<input type="file" class="dropify" id="subtype24" data-parsley-group="block3" attr-sub-type="24" attr-remarks="List of Directors"  data-height="300" data-default-file="<?php echo e(asset($default_bank)); ?>" data-max-file-size="5M" data-allowed-file-extensions="pdf png jpg" data-parsley-errors-container="#subtype24-errors" data-remove-required="0"/>
					</div>
					<div id="subtype24-errors"></div>
				</div>
			</div>
			<div class=" col-md-6 col-sm-8 col-10">
				<div class="form-group">
					<label for="ip">List of Authorised Signatories 
					</label>
					<div class="col-lg-9 col-md-6 col-sm-12 col-12 pl-0">
						<input type="file" class="dropify" id="subtype25" data-parsley-group="block3" attr-sub-type="25" attr-remarks="List of Authorised Signatories" data-height="300" data-default-file="<?php echo e(asset($default_bank)); ?>" data-max-file-size="5M" data-allowed-file-extensions="pdf png jpg" data-parsley-errors-container="#subtype25-errors" data-remove-required="0"/>
					</div>
					<div id="subtype25-errors"></div>
				</div>
			</div>
			<div class=" col-md-6 col-sm-8 col-10">
				<div class="form-group">
					<label for="ip"> Documents on 2 Directors, Signatories, Beneficial Owners
					</label>
					<div class="col-lg-9 col-md-6 col-sm-12 col-12 pl-0">
						<input type="file" class="dropify" id="subtype26" data-parsley-group="block3" attr-sub-type="26" attr-remarks="Documents on 2 Directors, Signatories, Beneficial Owners" data-height="300" data-default-file="<?php echo e(asset($default_bank)); ?>" data-max-file-size="5M" data-allowed-file-extensions="pdf png jpg" data-parsley-errors-container="#subtype26-errors" data-remove-required="0"/>
					</div>
					<div id="subtype26-errors"></div>
				</div>
			</div>

		</div>	
	</div>

	<!-- Trust = 3(5)-->
	<div class="row mt-4 pl-3 status-trust" id="trust">
		<div class="row col-md-12 col-sm-12 col-10">
			<div class=" col-md-6 col-sm-8 col-10">
				<div class="form-group">
					<label for="ip">Certified of the trust deed or pertinent extract thereof </label>
					<div class="col-lg-9 col-md-6 col-sm-12 col-12 pl-0">
						<input type="file" class="dropify" id="subtype31" data-parsley-group="block3" attr-sub-type="31" attr-remarks="Certified of the trust deed or pertinent extract thereof"  data-height="300" data-default-file="<?php echo e(asset($default_bank)); ?>" data-max-file-size="5M" data-allowed-file-extensions="pdf png jpg" data-parsley-errors-container="#subtype31-errors" data-remove-required="0"/>
					</div>
					<div id="subtype31-errors"></div>
				</div>
			</div>
			<div class=" col-md-6 col-sm-8 col-10">
				<div class="form-group">
					<label for="ip">Certified  of the registration of the trust where applicable.
					</label>
					<div class="col-lg-9 col-md-6 col-sm-12 col-12 pl-0">
						<input type="file" class="dropify" id="subtype32" data-parsley-group="block3" attr-sub-type="32" attr-remarks="Certified  of the registration of the trust where applicable"  data-height="300" data-default-file="<?php echo e(asset($default_bank)); ?>" data-max-file-size="5M" data-allowed-file-extensions="pdf png jpg" data-parsley-errors-container="#subtype32-errors" data-remove-required="0"/>
					</div>
					<div id="subtype32-errors"></div>
				</div>
			</div>

			<div class=" col-md-6 col-sm-8 col-10">
				<div class="form-group">
					<label for="ip">Details of registered office and place of business of the trustee. </label>
					<div class="col-lg-9 col-md-6 col-sm-12 col-12 pl-0">
						<input type="file" class="dropify" id="subtype33" data-parsley-group="block3" attr-sub-type="33" attr-remarks="Details of registered office and place of business of the trustee"  data-height="300" data-default-file="<?php echo e(asset($default_bank)); ?>" data-max-file-size="5M" data-allowed-file-extensions="pdf png jpg" data-parsley-errors-container="#subtype33-errors" data-remove-required="0"/>
					</div>
					<div id="subtype33-errors"></div>
				</div>
			</div>
			<div class=" col-md-6 col-sm-8 col-10">
				<div class="form-group">
					<label for="ip"> List and signature card of all authorized signatories.
					</label>
					<div class="col-lg-9 col-md-6 col-sm-12 col-12 pl-0">
						<input type="file" class="dropify" id="subtype34" data-parsley-group="block3" attr-sub-type="34" attr-remarks="List and signature card of all authorized signatories"  data-height="300" data-default-file="<?php echo e(asset($default_bank)); ?>" data-max-file-size="5M" data-allowed-file-extensions="pdf png jpg" data-parsley-errors-container="#subtype34-errors" data-remove-required="0"/>
					</div>
					<div id="subtype34-errors"></div>
				</div>
			</div>
			<div class=" col-md-6 col-sm-8 col-10">
				<div class="form-group">
					<label for="ip">Due diligence documents of trustees, beneficiaries, settler, protector
					</label>
					<div class="col-lg-9 col-md-6 col-sm-12 col-12 pl-0">
						<input type="file" class="dropify" id="subtype35" data-parsley-group="block3" attr-sub-type="35" attr-remarks="Due diligence documents of trustees, beneficiaries, settler, protector"  data-height="300" data-default-file="<?php echo e(asset($default_bank)); ?>" data-max-file-size="5M" data-allowed-file-extensions="pdf png jpg" data-parsley-errors-container="#subtype35-errors" data-remove-required="0"/>
					</div>
					<div id="subtype35-errors"></div>
				</div>
			</div>


		</div>	
	</div>

	<!-- fund = 4(5)-->
	<div class="row mt-4 pl-3 status-fund" id="fund">
		<div class="row col-md-12 col-sm-12 col-10">
			<div class=" col-md-6 col-sm-8 col-10">
				<div class="form-group">
					<label for="ip">Certified copy of the registration of the partnership, deed or pertinent extract
					thereof, where applicable. </label>
					<div class="col-lg-9 col-md-6 col-sm-12 col-12 pl-0">
						<input type="file" class="dropify"  id="subtype41" attr-sub-type="41" attr-remarks="Certified copy of the registration of the partnership, deed or pertinent extract
					thereof, where applicable." data-height="300" data-parsley-group="block3" data-default-file="<?php echo e(asset($default_bank)); ?>" data-max-file-size="5M" data-allowed-file-extensions="pdf png jpg" data-parsley-errors-container="#subtype41-errors" data-remove-required="0"/>
					</div>
					<div id="subtype41-errors"></div>
				</div>
			</div>
			<div class=" col-md-6 col-sm-8 col-10">
				<div class="form-group">
					<label for="ip">Due diligence documents of
						principals, being significant partners (i.e. holdings more than 20%). 
					</label>
					<div class="col-lg-9 col-md-6 col-sm-12 col-12 pl-0">
						<input type="file" class="dropify" id="subtype42" attr-sub-type="42" attr-remarks="Due diligence documents of
						principals, being significant partners" data-parsley-group="block3" data-height="300" data-default-file="<?php echo e(asset($default_bank)); ?>" data-max-file-size="5M" data-allowed-file-extensions="pdf png jpg" data-parsley-errors-container="#subtype42-errors" data-remove-required="0"/>
					</div>
					<div id="subtype42-errors"></div>
				</div>
			</div>

			<div class=" col-md-6 col-sm-8 col-10">
				<div class="form-group">
					<label for="ip">Details of registered office and place of business of the partnership.</label>
					<div class="col-lg-9 col-md-6 col-sm-12 col-12 pl-0">
						<input type="file" class="dropify" id="subtype43" data-parsley-group="block3" attr-sub-type="43" attr-remarks="Details of registered office and place of business of the partnership"  data-height="300" data-default-file="<?php echo e(asset($default_bank)); ?>" data-max-file-size="5M" data-allowed-file-extensions="pdf png jpg" data-parsley-errors-container="#subtype43-errors" data-remove-required="0"/>
					</div>
					<div id="subtype43-errors"></div>
				</div>
			</div>
			<div class=" col-md-6 col-sm-8 col-10">
				<div class="form-group">
					<label for="ip"> List and signature card of all authorized signatories.
					</label>
					<div class="col-lg-9 col-md-6 col-sm-12 col-12 pl-0">
						<input type="file" class="dropify" id="subtype44" data-parsley-group="block3" attr-sub-type="44" attr-remarks="List and signature card of all authorized signatories"  data-height="300" data-default-file="<?php echo e(asset($default_bank)); ?>" data-max-file-size="5M" data-allowed-file-extensions="pdf png jpg" data-parsley-errors-container="#subtype44-errors" data-remove-required="0"/>
					</div>
					<div id="subtype44-errors"></div>
				</div>
			</div>
			<div class=" col-md-6 col-sm-8 col-10">
				<div class="form-group">
					<label for="ip">Copy of latest reports and accounts.
					</label>
					<div class="col-lg-9 col-md-6 col-sm-12 col-12 pl-0">
						<input type="file" class="dropify" id="subtype45" data-parsley-group="block3" attr-sub-type="45" attr-remarks="Copy of latest reports and accounts"  data-height="300" data-default-file="<?php echo e(asset($default_bank)); ?>" data-max-file-size="5M" data-allowed-file-extensions="pdf png jpg" data-parsley-errors-container="#subtype45-errors" data-remove-required="0"/>
					</div>
					<div id="subtype45-errors"></div>
				</div>
			</div>
		</div>	
	</div>

	<!-- regular finance = 5(5)-->
	<div class="row mt-4 pl-3 status-regular" id="regular-finance">
		<div class="row col-md-12 col-sm-12 col-10">
			<div class=" col-md-6 col-sm-8 col-10">
				<div class="form-group">
					<label for="ip">Certificate of incorporation  </label>
					<div class="col-lg-9 col-md-6 col-sm-12 col-12 pl-0">
						<input type="file" class="dropify" id="subtype51" data-parsley-group="block3" attr-sub-type="51" attr-remarks="Certificate of incorporation"  data-height="300" data-default-file="<?php echo e(asset($default_bank)); ?>" data-max-file-size="5M" data-allowed-file-extensions="pdf png jpg" data-parsley-errors-container="#subtype51-errors" data-remove-required="0"/>
					</div>
					<div id="subtype51-errors"></div>
				</div>
			</div>
			<div class=" col-md-6 col-sm-8 col-10">
				<div class="form-group">
					<label for="ip">License certificate 
					</label>
					<div class="col-lg-9 col-md-6 col-sm-12 col-12 pl-0">
						<input type="file" class="dropify" id="subtype52" data-parsley-group="block3" attr-sub-type="52" attr-remarks="License certificate" data-height="300" data-default-file="<?php echo e(asset($default_bank)); ?>" data-max-file-size="5M" data-allowed-file-extensions="pdf png jpg" data-parsley-errors-container="#subtype52-errors" data-remove-required="0"/>
					</div>
					<div id="subtype52-errors"></div>
				</div>
			</div>

			<div class=" col-md-6 col-sm-8 col-10">
				<div class="form-group">
					<label for="ip">Copy of Annual Report Accounts/ M&A for a new company</label>
					<div class="col-lg-9 col-md-6 col-sm-12 col-12 pl-0">
						<input type="file" class="dropify" id="subtype53" data-parsley-group="block3" attr-sub-type="53" attr-remarks="Copy of Annual Report Accounts/ M&A for a new company"  data-height="300" data-default-file="<?php echo e(asset($default_bank)); ?>" data-max-file-size="5M" data-allowed-file-extensions="pdf png jpg" data-parsley-errors-container="#subtype53-errors" data-remove-required="0"/>
					</div>
					<div id="subtype53-errors"></div>
				</div>
			</div>
			<div class=" col-md-6 col-sm-8 col-10">
				<div class="form-group">
					<label for="ip"> Fund Mandate showing list of Authorised Signatories 
					</label>
					<div class="col-lg-9 col-md-6 col-sm-12 col-12 pl-0">
						<input type="file" class="dropify" id="subtype54" data-parsley-group="block3" attr-sub-type="54" attr-remarks="Fund Mandate showing list of Authorised Signatories" data-height="300" data-default-file="<?php echo e(asset($default_bank)); ?>" data-max-file-size="5M" data-allowed-file-extensions="pdf png jpg" data-parsley-errors-container="#subtype54-errors" data-remove-required="0"/>
					</div>
					<div id="subtype54-errors"></div>
				</div>
			</div>
			<div class=" col-md-6 col-sm-8 col-10">
				<div class="form-group">
					<label for="ip">Copy of latest reports and accounts.
					</label>
					<div class="col-lg-9 col-md-6 col-sm-12 col-12 pl-0">
						<input type="file" class="dropify" id="subtype55" data-parsley-group="block3" attr-sub-type="55" attr-remarks="Copy of latest reports and accounts"  data-height="300" data-default-file="<?php echo e(asset($default_bank)); ?>" data-max-file-size="5M" data-allowed-file-extensions="pdf png jpg" data-parsley-errors-container="#subtype55-errors" data-remove-required="0"/>
					</div>
					<div id="subtype55-errors"></div>
				</div>
			</div>
		</div>	
	</div>

	<!-- investment finance = 6(3)-->
	<div class="row mt-4 pl-3 status-investment" id="investment-finance">
		<div class="row col-md-12 col-sm-12 col-10">
			<div class=" col-md-6 col-sm-8 col-10">
				<div class="form-group">
					<label for="ip">Evidence of existence of institution i.e. brochure  </label>
					<div class="col-lg-9 col-md-6 col-sm-12 col-12 pl-0">
						<input type="file" class="dropify" id="subtype61" data-parsley-group="block3" attr-sub-type="61" attr-remarks="Evidence of existence of institution" data-height="300" data-default-file="<?php echo e(asset($default_bank)); ?>" data-max-file-size="5M" data-allowed-file-extensions="pdf png jpg" data-parsley-errors-container="#subtype61-errors" data-remove-required="0"/>
					</div>
					<div id="subtype61-errors"></div>
				</div>
			</div>
			<div class=" col-md-6 col-sm-8 col-10">
				<div class="form-group">
					<label for="ip">Mandate / Board Resolution by Directors
					</label>
					<div class="col-lg-9 col-md-6 col-sm-12 col-12 pl-0">
						<input type="file" class="dropify" id="subtype62" data-parsley-group="block3" attr-sub-type="62" attr-remarks="Mandate / Board Resolution by Directors"  data-height="300" data-default-file="<?php echo e(asset($default_bank)); ?>" data-max-file-size="5M" data-allowed-file-extensions="pdf png jpg" data-parsley-errors-container="#subtype62-errors" data-remove-required="0"/>
					</div>
					<div id="subtype62-errors"></div>
				</div>
			</div>
			<div class=" col-md-6 col-sm-8 col-10">
				<div class="form-group">
					<label for="ip">List of Authorised Signatories</label>
					<div class="col-lg-9 col-md-6 col-sm-12 col-12 pl-0">
						<input type="file" class="dropify" id="subtype63" data-parsley-group="block3" attr-sub-type="63" attr-remarks="List of Authorised Signatories" data-height="300" data-default-file="<?php echo e(asset($default_bank)); ?>" data-max-file-size="5M" data-allowed-file-extensions="pdf png jpg" data-parsley-errors-container="#subtype63-errors" data-remove-required="0"/>
					</div>
					<div id="subtype63-errors"></div>
				</div>
			</div>
		</div>	
	</div>
	


	<div class="col-lg-12 PrincipalDocsListDiv">
		<h5 class="pl-0 pt-2 principle-header">Optional: Additional Supporting Documents: </h5>
	</div>

	<div class="row sec2-form mt-3 PrincipalDocsListDiv">
		<div class="col-sm-12 col-md-6">
			<h6 class="pl-0 pt-2 principle-group-header">Please upload the following documents for principal holder: </h6>
			<div class="form-group Principal-Source-Wealth-Docs-List">
			</div>
		</div>
	</div>

	<div class="col-lg-12 PrincipalJointDocsListDiv">
		<h5 class="pl-0 pt-2 principle-header">Optional: Additional Supporting Documents: </h5>
	</div>

	<div class="row sec2-form mt-3 PrincipalJointDocsListDiv">
		<div class="col-sm-12 col-md-6">
			<h6 class="pl-0 pt-2 principle-group-header">Please upload the following documents for principal holder:</h6>
			<div class="form-group Principal-Group-Source-Wealth-Docs-List">
			</div>
		</div>
		
		<div class="col-sm-12 col-md-6">
			<h6 class="pl-0 pt-2 joint-group-header">Please upload the following documents for joint holder: </h6>
			<div class="form-group Joint-Group-Source-Wealth-Docs-List">
			</div>
		</div>
	</div>


	<div class="row sec2-form mt-3 PrincipalSourceWealthDropifyDiv">
		<div class="col-sm-12 col-md-6">
			<div class="form-group">
				<label for="ip">Upload Principal Holder Support Documents </label>
				<div class="col-lg-9 col-md-6 col-sm-12 col-12 pl-0">
					<input type="file" class="sw-supporting-docs" name="sw_support_docs" id="subtype66" data-parsley-group="block3" attr-sub-type="66" attr-remarks="Certified Copy Of Certificate Of Incorporation" data-height="300" data-default-file="" data-max-file-size="5M" data-allowed-file-extensions="pdf png jpg" data-parsley-errors-container="#subtype66-errors" data-remove-required="0" multiple />
				</div>
				<div id="subtype66-errors"></div>
			</div>
		</div>
	</div>

	<div class="row sec2-form mt-3 PricipalJointSourceWealthGroupDropifyDiv">
		<div class="col-sm-12 col-md-6">
			<div class="form-group">
				<label for="ip">Upload Principal Holder Support Documents </label>
				<div class="col-lg-9 col-md-6 col-sm-12 col-12 pl-0">
					<input type="file" class="sw-supporting-docs" name="sw_support_docs" id="subtype66" data-parsley-group="block3" attr-sub-type="66" attr-remarks="Certified Copy Of Certificate Of Incorporation" data-height="300" data-default-file="" data-max-file-size="5M" data-allowed-file-extensions="pdf png jpg" data-parsley-errors-container="#subtype66-errors" data-remove-required="0" multiple />
				</div>
				<div id="subtype66-errors"></div>
			</div>
		</div>

		<div class="col-sm-12 col-md-6">
			<div class="form-group">
				<label for="ip">Upload Joint Holder Support Documents </label>
				<div class="col-lg-9 col-md-6 pl-0">
					<input type="file" class="sw-supporting-docs" name="sw_support_docs" id="subtype68" data-parsley-group="block3" attr-sub-type="68" attr-remarks="Certified Copy Of Certificate Of Incorporation" data-height="300" data-default-file="" data-max-file-size="5M" data-allowed-file-extensions="pdf png jpg" data-parsley-errors-container="#subtype68-errors" data-remove-required="0" multiple />
				</div>
				<div id="subtype68-errors"></div>
			</div>
		</div>
	</div>

	<div style="height: 1px ;border: 0.2px dashed #d9d9d9;width: 100%;margin: 15px auto;"></div>

    

 	<div class="col-lg-12">
        
        
        <h5 class="pl-0 pt-2 text-danger">Please download, sign and upload the application form </h5>
        <br>

        <div class="signedPdfDownload_div">
        	<button class="btn btn-primary btn-wide btn-sm download_signed_applications">Click to download your application form</button>
    	</div>
    </div>
    

    <div class="col-lg-12 mt-4">
    	<h5 class="pl-0 pt-2 text-success">Please upload your signed copy accordingly in the following section</h5>
    </div>
    
    <div class="col-lg-12">
    	<div class="form-group manual_signed_doc_a">
			<label>Upload Signed Application *</label>
            <input type="file" class="manual_signed_doc" name="file" required/>
		</div>
	</div>

	<div class="col-lg-12">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group manual_signed_pep_doc">
					<label>Upload principal holder politically exposed person status form (PEP) *</label>
		            <input type="file" class="manual_signed_pep_docs" name="individual_pep_file" required/>
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group manual_signed_fund_doc">
					<label>Upload principal holder declaration of source of funds/wealth form *</label>
		            <input type="file" class="manual_signed_fund_docs" name="individual_fw_file" required/>
				</div>
			</div>
		</div>
	</div>

	

	<div class="col-lg-12 joint-account-holder-docs-upload" id="joint_account_holder_docs_upload">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group manual_signed_joint_pep_doc">
					<label>Upload joint holder politically exposed person status form (PEP) *</label>
		            <input type="file" class="manual_signed_joint_pep_docs" name="joint_pep_file"/>
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group manual_signed_joint_fund_doc">
					<label>Upload joint holder declaration of source of funds/wealth form *</label>
		            <input type="file" class="manual_signed_joint_fund_docs" name="joint_fw_file"/>
				</div>
			</div>
		</div>
	</div>

	

	<div class="col-lg-12">
		<div class="form-group">
			
			<div class="mt-2 string-check string-check-bordered-base">
				<input type="checkbox" name="subscription_acknowledge_status" id="subscription_acknowledge_status" value="1" data-parsley-group="block3" required>

				<label class="string-check-label" for="formRadioInput021">
					<span class="ml-0"> By subscribing, I acknowledge that I have read, understood, and agree to comply with the content and terms and conditions of the fund's private placement memorandum and the respective supplementary memorandum.</span>
				</label>
			</div>
		</div>
	</div>

</div><?php /**PATH /var/www/html/olympus-asset.com/public_html/resources/views/investor/elements/newSubscription/document.blade.php ENDPATH**/ ?>