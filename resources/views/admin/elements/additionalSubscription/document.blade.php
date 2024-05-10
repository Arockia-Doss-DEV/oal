<?php
	$default_passport = "/admin/images/sample_image/passport.jpg";
	$default_bank = "/admin/images/sample_image/bank-ref.jpg";
	$default_cv = "/admin/images/sample_image/cv.jpg";
?>

<div class="row mt-4">

	{{-- <div class="col-lg-12 col-md-12 col-sm-12">
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
			    <input type="hidden" id="subscriber_type" name="subscriber_type" data-parsley-group="block3" value="{{$edit ? $subscription->subscriber_type : old('subscriber_type') }}">
		        <input type="text" readonly class="form-control" id="subscriber_type2" name="subscriber_type2" data-parsley-group="block3" value="{{ $subscriber_type_value }}">
			<?php }else{ ?>
			    {!! Form::select('subscriber_type', $subscriber_typeOption, $edit ? $subscription->subscriber_type : old('subscriber_type'), ['class' => 'form-control', 'id' => 'subscriber_type', 'data-parsley-group'=>"block3", 'required', 'onchange'=>"changeSubscriberType()", 'placeholder' => 'Please Select' ]) !!}
			<?php } ?>
				
		</div>
	</div> --}}

	<!-- Individual Fund = 1 (5)-->

	{{-- <div class="row mt-4 pl-3">
		<div class="row col-md-12 col-sm-12 col-10">
			<div class=" col-md-6 col-sm-8 col-10">
				<div class="form-group">
					<label for="ip">Certified Passport / ID Copies </label>
					<div class="col-lg-9 col-md-6 col-sm-12 col-12 pl-0">
						<input type="file" class="dropify" id="subtype11" data-parsley-group="block3" attr-sub-type="11" attr-remarks="Certified Passport / ID Copies" data-height="300" data-default-file="{{ asset($default_passport) }}" data-max-file-size="5M" data-allowed-file-extensions="pdf png jpg" data-parsley-errors-container="#subtype11-errors" data-remove-required="0"/>
					</div>
                    <div id="subtype11-errors"></div>
				</div>
			</div>
			<div class=" col-md-6 col-sm-8 col-10">
				<div class="form-group">
					<label for="ip">Professional/Bank Reference</label>
					<div class="col-lg-9 col-md-6 col-sm-12 col-12 pl-0">
						<input type="file" class="dropify" id="subtype12" data-parsley-group="block3" attr-sub-type="12" attr-remarks="Professional/Bank Reference" data-height="300" data-default-file="{{ asset($default_bank) }}" data-max-file-size="5M" data-allowed-file-extensions="pdf png jpg" data-parsley-errors-container="#subtype12-errors" data-remove-required="0"/>
					</div>
                    <div id="subtype12-errors"></div>
				</div>
			</div>
			<div class=" col-md-6 col-sm-8 col-10">
				<div class="form-group">
					<label for="ip">Curriculum Vitae </label>
					<div class="col-lg-9 col-md-6 col-sm-12 col-12 pl-0">
						<input type="file" class="dropify" id="subtype13" data-parsley-group="block3" attr-sub-type="13" attr-remarks="Curriculum Vitae" data-height="300" data-default-file="{{ asset($default_cv) }}" data-max-file-size="5M" data-allowed-file-extensions="pdf png jpg" data-parsley-errors-container="#subtype13-errors" data-remove-required="0"/>
					</div>
					<div id="subtype13-errors"></div>
				</div>
			</div>
			<div class=" col-md-6 col-sm-8 col-10">
				<div class="form-group">
					<label for="ip">Address Proof</label>
					<div class="col-lg-9 col-md-6 col-sm-12 col-12 pl-0">
						<input type="file" class="dropify" id="subtype14" data-parsley-group="block3" attr-sub-type="14" attr-remarks="Address Proof" data-height="300" data-default-file="{{ asset($default_bank) }}" data-max-file-size="5M" data-allowed-file-extensions="pdf png jpg" data-parsley-errors-container="#subtype14-errors" data-remove-required="0"/>
					</div>
					<div id="subtype14-errors"></div>
				</div>
			</div>

		</div>	
	</div> --}}


	<div class="row mt-1 pl-3 status-individual" id="individual">

		<div class="col-lg-12">
			<span class="text-danger">Reminder: All supporting documents must be certified as true copies by recognised professional practitioners.</span>
		</div>

		<div class="row col-md-12 col-sm-12 col-10 mt-2">
			<div class=" col-md-6 col-sm-8 col-10">
				<div class="form-group">
					<label for="ip">Proof of Address (if the current POA is more than 3 months) </label>
					<div class="col-lg-9 col-md-6 col-sm-12 col-12 pl-0">
						<input type="file" class="dropify" id="subtype11" data-parsley-group="block3" attr-sub-type="11" attr-remarks="Proof of Address" data-height="300" data-default-file="{{ asset($default_passport) }}" data-max-file-size="5M" data-allowed-file-extensions="pdf png jpg" data-parsley-errors-container="#subtype11-errors" data-remove-required="0"/>
					</div>
                    <div id="subtype11-errors"></div>
				</div>
			</div>
			<div class=" col-md-6 col-sm-8 col-10">
				<div class="form-group">
					<label for="ip">Passport ( if the passport is expired)</label>
					<div class="col-lg-9 col-md-6 col-sm-12 col-12 pl-0">
						<input type="file" class="dropify" id="subtype12" data-parsley-group="block3" attr-sub-type="12" attr-remarks="Passport" data-height="300" data-default-file="{{ asset($default_bank) }}" data-max-file-size="5M" data-allowed-file-extensions="pdf png jpg" data-parsley-errors-container="#subtype12-errors" data-remove-required="0"/>
					</div>
                    <div id="subtype12-errors"></div>
				</div>
			</div>

			@if ($check_date >= 62)
	
			<div class=" col-md-6 col-sm-8 col-10">
				<div class="form-group">
					<label for="ip">Address Proof</label>
					<div class="col-lg-12 col-md-6 pl-0">
						<input type="file" class="dropify" id="subtype14" data-parsley-group="block3" attr-sub-type="14" attr-remarks="Address Proof" data-height="300" data-default-file="{{ asset($default_bank) }}" data-max-file-size="5M" data-allowed-file-extensions="pdf png jpg" data-parsley-errors-container="#subtype14-errors" data-remove-required="0"/>
					</div>
					<div id="subtype14-errors"></div>
				</div>
			</div>

			@endif

		</div>	
	</div>

	<div style="height: 1px ;border: 0.2px dashed #d9d9d9;width: 100%;margin: 15px auto;"></div>
    <div class="col-lg-12">
        <span class="text-danger">Please click to download the application form. After downloading it, kindly sign and upload the application form using the upload button below.</span>
        <br>

        <div class="signedPdfDownload_div">
    		<a href="{{ url('/signedPdfDownload') }}" target="_blank" download class="btn btn-primary btn-wide btn-sm">Click and download your application form</a>
    	</div>
    </div>
    
    <div class="col-lg-12"><br>
    	<div class="form-group manual_signed_doc_a">
			<label>Upload Signed Application *</label>
            <input type="file" class="manual_signed_doc" name="file" required/>
		</div>
	</div>
</div>