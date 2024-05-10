<?php
	$default_passport = "/admin/images/sample_image/passport.jpg";
	$default_bank = "/admin/images/sample_image/bank-ref.jpg";
	$default_cv = "/admin/images/sample_image/cv.jpg";
?>

<div class="row mt-4">

	

	<!-- Individual Fund = 1 (5)-->

	


	<div class="row mt-1 pl-3 status-individual" id="individual">

		<div class="col-lg-12">
			<span class="text-danger">Reminder: All supporting documents must be certified as true copies by recognised professional practitioners.</span>
		</div>

		<div class="row col-md-12 col-sm-12 col-10 mt-2">
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

			<?php if($check_date >= 62): ?>
	
			<div class=" col-md-6 col-sm-8 col-10">
				<div class="form-group">
					<label for="ip">Address Proof</label>
					<div class="col-lg-12 col-md-6 pl-0">
						<input type="file" class="dropify" id="subtype14" data-parsley-group="block3" attr-sub-type="14" attr-remarks="Address Proof" data-height="300" data-default-file="<?php echo e(asset($default_bank)); ?>" data-max-file-size="5M" data-allowed-file-extensions="pdf png jpg" data-parsley-errors-container="#subtype14-errors" data-remove-required="0"/>
					</div>
					<div id="subtype14-errors"></div>
				</div>
			</div>

			<?php endif; ?>

		</div>	
	</div>

	<div style="height: 1px ;border: 0.2px dashed #d9d9d9;width: 100%;margin: 15px auto;"></div>
    <div class="col-lg-12">
        <span class="text-danger">Please click to download the application form. After downloading it, kindly sign and upload the application form using the upload button below.</span>
        <br>

        <div class="signedPdfDownload_div">
    		<a href="<?php echo e(url('/signedPdfDownload')); ?>" target="_blank" download class="btn btn-primary btn-wide btn-sm">Click and download your application form</a>
    	</div>
    </div>
    
    <div class="col-lg-12"><br>
    	<div class="form-group manual_signed_doc_a">
			<label>Upload Signed Application *</label>
            <input type="file" class="manual_signed_doc" name="file" required/>
		</div>
	</div>
</div><?php /**PATH /var/www/html/olympus-asset.com/public_html/resources/views/admin/elements/additionalSubscription/document.blade.php ENDPATH**/ ?>