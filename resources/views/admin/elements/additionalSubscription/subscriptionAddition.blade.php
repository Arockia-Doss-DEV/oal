<div class="row mt-2">

	<div class="col-lg-12">
		<span class="text-danger">Reminder: Please ensure that you have an initial investment before you can proceed to apply for an additional investment in that particular class.</span>
	</div>

	<div class="col-lg-4 col-md-6 col-sm-12 mt-3">
		<div class="form-group">
			<label for="exampleFormControlSelect1">Investment Class *</label>

			{!! Form::select('investment_class_type', $investmentClasses, $edit ? $subscription->investment_class_type : old('investment_class_type'), ['placeholder' => 'Please select class ...', 'class' => 'form-control', 'id' => 'investment_class_type_id', 'data-parsley-group'=>"block1", 'required' => 'required']) !!}
		</div>
	</div>

	@if ($userData->role_id == 3)
		
		<div class="col-lg-2 col-md-6 col-sm-12 mt-3">
			<div class="form-group">
				<label for="exampleFormControlSelect1">Salutation</label>
				<?php 
					{{-- {{ (old() ? old('field_name', false) : $model->field_name ?? false) ? 'checked' : '' }} --}}

					$salutationOption = ['Mr.'=> 'Mr','Mrs.'=> 'Mrs','Ms.'=> 'Ms','Dr.'=> 'Dr','Prof.'=> 'Prof','Assoc. Prof.'=> 'Assoc. Prof','Dato.'=> 'Dato',"Dato'."=> "Dato","Dato Sri."=>"Dato Sri","Dato' Sri."=>"Dato' Sri","Datin."=>"Datin","Datuk."=>"Datuk","Datuk Seri."=>"Datuk Seri","Datuk Sri."=>"Datuk Sri","Haji."=>"Haji","Hajjah."=>"Hajjah","Puteri."=>"Puteri","Puan Sri."=>"Puan Sri","Raja."=>"Raja","Tan Sri."=>"Tan Sri","Tengku."=>"Tengku","Tun."=>"Tun","Tun Poh."=>"Tun Poh", 'Tunku.'=>'Tunku']; ?>
				{!! Form::select('salutation', $salutationOption, $edit ? $subscription->salutation : $userData->salutation,
	                ['class' => 'form-control', 'id' => 'salutation', 'data-parsley-group'=>"block1", 'required']) !!}
			</div>
		</div>

	@endif

	<div class="col-lg-6 col-md-8 col-sm-12 mt-3">
		<div class="form-group">
			<label for="date">Name (as per NRIC/Passport) *</label>
			<input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ $edit ? $subscription->name : $userData->name }}" data-parsley-group="block1" required>
		</div>
	</div>
	
	<div class="col-lg-12 col-md-6 col-sm-12">
		<div class="form-group">
			<label for="time">Address Line 1</label>
			<input type="text" class="form-control" id="address_line1" name="address_line1"  placeholder="Address Line1" value="{{ $edit ? $subscription->address_line1 : $userData->address_line1 }}" data-parsley-group="block1" required>
		</div>
	</div>
	<div class="col-lg-12 col-md-6 col-sm-12">
		<div class="form-group">
			<label for="time">Address Line 2</label>
			<input type="text" class="form-control" id="address_line2" name="address_line2" placeholder="Address Line2" value="{{ $edit ? $subscription->address_line2 : $userData->address_line2 }}" data-parsley-group="block1">
		</div>
	</div>

	<div class="col-lg-6 col-md-6 col-sm-12">
		<div class="form-group">
			<label for="datetime">City</label>
			<input type="text" class="form-control" id="city" name="city"  placeholder="City" value="{{ $edit ? $subscription->city : $userData->city }}" data-parsley-group="block1" required>
		</div>
	</div>
	<div class="col-lg-6 col-md-6 col-sm-12">
		<div class="form-group">
			<label for="exampleFormControlSelect1">Country</label>
			{!! Form::select('country', $countries, $edit ? $subscription->country : $userData->country, ['class' => 'form-control', 'id'=>'country_id', 'required', 'data-parsley-group'=>"block1"]) !!}
		</div>
	</div>
	<div class="col-lg-6 col-md-6 col-sm-12">
		<div class="form-group">
			<label for="credit-card">Post Code</label>
			<input type="text" class="form-control" id="post_code" name="post_code" data-parsley-group="block1" placeholder="Post Code" value="{{ $edit ? $subscription->post_code : $userData->post_code }}" required>
		</div>
	</div>
	<div class="col-lg-6 col-md-6 col-sm-12">
		<div class="form-group">
			<label for="exampleFormControlSelect1">State</label>
			<select class="form-control" name="state" id="state_id" data-parsley-group="block1" required>
                <option value="">--</option>
            </select>
		</div>
	</div>
	<div style="height: 1px ;border: 0.2px dashed #d9d9d9;width: 100%;margin: 15px auto;"></div>
	<div class="row col-md-12 sec2-form mt-3">
		<div class="col-lg-12 col-md-6 col-sm-12">
			<div class="form-group">
				<label for="license-plate">Subscription Amount </label>
				<input type="number" step="10000" class="form-control" id="amount" name="amount" placeholder="Subscription Amount" data-parsley-group="block1" data-parsley-type="digits" value="{{ $edit ? $subscription->amount : old('amount') }}" required , data-parsley-min="{{ config('settings.additional_amount') }}" data-parsley-error-message="The minimum additional investment amount is {{ config('settings.additional_amount') }} or the investment amount value in multiplication of USD 10,000" data-parsley-errors-container="#initial_investment_error">
				
				<div id="initial_investment_error"></div>
			</div>
		</div>
	</div>

	<div style="height: 1px ;border: 0.2px dashed #d9d9d9;width: 100%;margin: 15px auto;"></div>
	<h4 class="pl-2 pt-2">SUBSCRIBER DETAILS</h4>
	<div class="row sec2-form mt-3">
		<div class="col-lg-12 col-md-6 col-sm-12">
			<div class="form-group">
				<label for="exampleFormControlSelect1">Subscriber Type</label>
				<?php 
				    $subscriber_typeOption = ['1'=> 'Individual','2'=> 'Private Fund','3'=> 'Trust','4'=> 'Fund','5'=> 'Regulated financial services business or public listed company','6'=> 'Financial services institution or bank investing pooled funds i.e. CIS / Pension Funds']; 
				    
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
			        <input type="text" readonly class="form-control" id="subscriber_type" name="subscriber_type" data-parsley-group="block1" value="{{ $subscriber_type_value }}">
				<?php }else{ ?>
				    {!! Form::select('subscriber_type', $subscriber_typeOption, $edit ? $subscription->subscriber_type : old('subscriber_type'), ['placeholder' => 'Please Select', 'class' => 'form-control', 'id' => 'subscriber_type', 'data-parsley-group'=>"block1", 'required']) !!}
				<?php } ?>
			</div>
		</div>
	</div>

	<div style="height: 1px ;border: 0.2px dashed #d9d9d9;width: 100%;margin: 15px auto;"></div>
	<div class="col-lg-12 col-md-6 col-sm-6">
		<div class="form-group">
			<label for="exampleFormControlSelect1">Is this a Joint Account</label>

			{{-- <?php $jointOption = ['1'=> 'No','2'=> 'Yes']; ?>
			{!! Form::select('is_joint_account', $jointOption, $edit ? $subscription->is_joint_account : old('is_joint_account'), ['class' => 'form-control', 'id' => 'is_joint_account', 'data-parsley-group'=>"block1", 'required', 'onchange'=>"jointApplicant()", 'data-parsley-group'=>"block1", 'required'=>"required"]) !!} --}}

			<input type="hidden" name="is_joint_account" value="{{ $edit ? $subscription->is_joint_account : old('is_joint_account') }}">

			<?php $jointOption = ['1'=> 'No','2'=> 'Yes']; ?>
			@if (empty($subscription->is_joint_account))
				{!! Form::select('is_joint_account', $jointOption, $edit ? $subscription->is_joint_account : old('is_joint_account'), ['class' => 'form-control', 'id' => 'is_joint_account', 'data-parsley-group'=>"block1", 'required', 'onchange'=>"jointApplicant()", 'data-parsley-group'=>"block1", 'required'=>"required"]) !!}
			@else
				{!! Form::select('is_joint_account', $jointOption, $edit ? $subscription->is_joint_account : old('is_joint_account'), ['class' => 'form-control', 'id' => 'is_joint_account', 'data-parsley-group'=>"block1", 'required', 'onchange'=>"jointApplicant()", 'data-parsley-group'=>"block1", 'required'=>"required", 'disabled']) !!}
			@endif
            
		</div>
	</div>

	<h4 class="pl-2 pt-2">BANK DETAILS</h4>
	<div class="row sec2-form mt-3">
		<div class="col-lg-12 col-md-6 col-sm-12">
			<div class="form-group">
				<label for="phone">Bank Name</label>
				<input type="text" class="form-control" id="bank_name" name="bank_name" placeholder="Bank Name" data-parsley-group="block1" value="{{$edit ? $subscription->bank_name : old('bank_name') }}" required readonly>
			</div>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-12">
			<div class="form-group">
				<label for="ip">Bank Address</label>
				<input type="text" class="form-control" id="bank_address" name="bank_address" placeholder="Bank Address" data-parsley-group="block1" value="{{$edit ? $subscription->bank_address : old('bank_address') }}" required readonly>
			</div>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-12">
			<div class="form-group">
				<label for="phone">Account Name</label>
				<input type="text" class="form-control" id="account_name" name="account_name" placeholder="Account Name" data-parsley-group="block1" value="{{$edit ? $subscription->account_name : old('account_name') }}" required readonly>
			</div>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-12">
			<div class="form-group">
				<label for="ip">Account Number</label>
				<input type="text" class="form-control" id="account_number" name="account_number" placeholder="Account Number" data-parsley-group="block1" data-parsley-type="digits" value="{{$edit ? $subscription->account_number : old('account_number') }}" required readonly>
			</div>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-12">
			<div class="form-group">
				<label for="phone">Swift Code</label>
				<input type="text" class="form-control" id="swift_address" name="swift_address" placeholder="Swift Address" data-parsley-group="block1" value="{{$edit ? $subscription->swift_address : old('swift_address') }}" required readonly>
			</div>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-12">
			<div class="form-group">
				<label for="ip">Bank IBAN#</label>
				<input type="text" class="form-control" id="bank_inan" name="bank_inan" placeholder="Bank IBAN" data-parsley-group="block1" value="{{$edit ? $subscription->bank_inan : old('bank_inan') }}" readonly>
			</div>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-12">
			<div class="form-group">
				<label for="ip">Reference</label>
				<input type="text" class="form-control" id="reference" name="reference" placeholder="Reference" data-parsley-group="block1" value="{{$edit ? $subscription->reference : old('reference') }}" readonly>
			</div>
		</div>
		
	</div>
	<div class="row mt-2 pl-3 joint-applicant-blocks" id="joint-applicants">
		<div class="row col-md-12">
			<div class="col-lg-12 col-md-8 col-sm-12">
				<div class="form-group">
					<label for="date">Joint Applicant Name</label>
					<input type="text" class="form-control" id="ja_name" name="ja_name" placeholder="Name" data-parsley-group="block1" value="{{$edit ? $subscription->ja_name : old('ja_name') }}">
				</div>
			</div>
			<div class="col-lg-12 col-md-6 col-sm-12">
				<div class="form-group">
					<label for="time">Address Line 1</label>
					<input type="text" class="form-control" id="ja_address_line1" name="ja_address_line1" placeholder="Address Line1" data-parsley-group="block1" value="{{$edit ? $subscription->ja_address_line1 : old('ja_address_line1') }}">
				</div>
			</div>
			<div class="col-lg-12 col-md-6 col-sm-12">
				<div class="form-group">
					<label for="time">Address Line 2</label>
					<input type="text" class="form-control" id="ja_address_line2" name="ja_address_line2" placeholder="Address Line2" data-parsley-group="block1" value="{{$edit ? $subscription->ja_address_line2 : old('ja_address_line2') }}">
				</div>
			</div>

			<div class="col-lg-6 col-md-6 col-sm-12">
				<div class="form-group">
					<label for="datetime">City</label>
					<input type="text" class="form-control" id="ja_city" name="ja_city"  placeholder="City" data-parsley-group="block1" value="{{$edit ? $subscription->ja_city : old('ja_city') }}">
				</div>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-12">
				<div class="form-group">
					<label for="exampleFormControlSelect1">Country</label>
					{!! Form::select('ja_country', $countries, $edit ? $subscription->ja_country : $userData->ja_country, ['class' => 'form-control', 'id'=>'ja_country_id', 'data-parsley-group'=>"block1"]) !!}
				</div>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-12">
				<div class="form-group">
					<label for="credit-card">Post Code</label>
					<input type="text" class="form-control" id="ja_post_code" name="ja_post_code" placeholder="Post Code" data-parsley-group="block1" data-parsley-type="digits" value="{{$edit ? $subscription->ja_post_code : old('ja_post_code') }}">
				</div>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-12">
				<div class="form-group">
					<label for="exampleFormControlSelect1">State</label>
					<select class="form-control" name="ja_state" id="ja_state_id" data-parsley-group="block1">
		                <option value="">--</option>
		            </select>
				</div>
			</div>


		</div>
	</div>
</div>