<?php
	$default_passport = "/admin/images/sample_image/passport.jpg";
	$default_bank = "/admin/images/sample_image/bank-ref.jpg";
	$default_cv = "/admin/images/sample_image/cv.jpg";
?>

<div class="row mt-1 pl-3 status-individual" id="individual">

	<div class="col-lg-12">
		<span class="text-danger">Reminder: All supporting documents must be certified as true copies by recognised professional practitioners.</span>
	</div>

	<div class="row col-md-12 col-sm-12 col-10 mt-3">
		<div class=" col-md-6 col-sm-8 col-10">
			<div class="form-group">
				<label for="ip">Proof of Address (if the current POA is more than 3 months) </label>
				<div class="col-lg-9 col-md-6 col-sm-12 col-12 pl-0">
					<input type="file" class="dropify" id="subtype11" data-parsley-group="block3" attr-sub-type="11" attr-remarks="Proof of Address" data-height="300" data-default-file="<?php echo e(asset($default_passport)); ?>" data-max-file-size="5M" data-allowed-file-extensions="pdf png jpg" data-parsley-errors-container="#subtype11-errors" data-remove-required="0"/>
				</div>
                <div id="subtype11-errors"></div>
			</div>
		</div>
		<div class=" col-md-6 col-sm-8 col-10">
			<div class="form-group">
				<label for="ip">Passport ( if the passport is expired)</label>
				<div class="col-lg-9 col-md-6 col-sm-12 col-12 pl-0">
					<input type="file" class="dropify" id="subtype12" data-parsley-group="block3" attr-sub-type="12" attr-remarks="Passport" data-height="300" data-default-file="<?php echo e(asset($default_bank)); ?>" data-max-file-size="5M" data-allowed-file-extensions="pdf png jpg" data-parsley-errors-container="#subtype12-errors" data-remove-required="0"/>
				</div>
                <div id="subtype12-errors"></div>
			</div>
		</div>




		



	</div>
</div>

	

	<!-- Individual Fund = 1 (5)-->

	

	<div style="height: 1px ;border: 0.2px dashed #d9d9d9;width: 100%;margin: 15px auto;"></div>
    <div class="col-lg-12">
        <span class="text-danger">Please click to download the application form. After downloading it, kindly sign and upload the application form using the upload button below.</span>
        <br>

        <div class="signedPdfDownload_div mt-3">
    		<a href="<?php echo e(url('/investor/signedPdfDownload')); ?>" target="_blank" download class="btn btn-primary btn-wide btn-sm">Click and download your application form</a>
    	</div>
    </div>
    
    <div class="col-lg-12"><br>
    	<div class="form-group manual_signed_doc_a">
			<label>Upload Signed Application *</label>
            <input type="file" class="manual_signed_doc" name="file" required/>
		</div>
	</div>

	<div class="col-lg-12">
		<div class="form-group">
			
			<div class="mt-2 string-check string-check-bordered-base">
				<input type="checkbox" name="subscription_acknowledge_status" id="subscription_acknowledge_status" value="1" data-parsley-group="block3" required>

				<label class="string-check-label" for="formRadioInput021">
					<span class="ml-2">By subscribing, you acknowledge that you have read, understood, and agree to the content and terms and conditions of the fund's private placement memorandum and the respective supplementary memorandum.</span>
				</label>
			</div>
		</div>
	</div>
	
</div><?php /**PATH /var/www/html/olympus-asset.com/public_html/resources/views/investor/elements/additionalSubscription/document.blade.php ENDPATH**/ ?>