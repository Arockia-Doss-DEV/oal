@extends('layouts.app')

@section('title', 'Create Additional Subscription')

@section('content')
<script src="{{ asset('common/js/jSignature.min.js') }}"></script>

<div class="main-container">
    <div class="container-fluid">
        
        @include("admin.elements.sidebar")

        <div class="main-panel">
            <!-- content-wrapper Starts -->
            <div class="content-wrapper">
                <!-- design1 -->
                <div class="col-lg-12 card-margin">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-10">
                                </div>
                                <div class="col-md-2">
                                    <a class="btn btn-secondary" href="#" onclick="location.href = document.referrer; return false;" style="float: right"><i class="fa fa-angle-double-left"></i> Back</a>
                                </div>
                            </div>
                            <br>

                            <div class="row">
                                <div class="col-lg-12 col-md-12 ">
                                    <div class="card card-margin">
                                        <div class="card-header signup-card-header">
                                            <h5 class="card-title">ADDITIONAL SUBSCRIPTION </h5>                                 
                                        </div>

                                        <div class="card-body">
                                            {!! Form::open(['url' => '/subscriptionSave', 'files' => true, 'id' => 'additionalSubscriptionForm', 'data-parsley-validate' => 'data-parsley-validate', "data-parsley-trigger"=>"keyup", 'autocomplete'=>"off" ]) !!}

                                                @if(!empty($isAdditional))
                                                    {!! Form::hidden('is_additional', $isAdditional) !!}
                                                @endif

                                                @if(!empty($userData))
                                                    {!! Form::hidden('user_id', $userData['id']) !!}
                                                @endif

                                               {{--  additional subscription --}}

                                                <div>
                                                    <h3>SUBSCRIBER DETAILS</h3>
                                                    <section>
                                                        <h4>SUBSCRIBER DETAILS</h4>
                                                        <div class="row">
                                                            @include("admin.elements.additionalSubscription.subscriptionAddition")
                                                        </div>
                                                    </section>

                                                    <h3>DOCUMENTS</h3>
                                                    <section>
                                                        <h4>CERTIFIED SUPPORTING DOCUMENTS</h4>
                                                        @include("admin.elements.additionalSubscription.document")
                                                    </section>
                                                    
                                                    {{-- <h3>ADDITIONAL DETAILS</h3>
                                                    <section>
                                                        <h4>LEAD CONTACT DETAILS</h4>
                                                        @include("investor.elements.additionalSubscription.additional")
                                                    </section> --}}

                                                    {{-- <h3>DOCUMENTS</h3>
                                                    <section>
                                                        <h4>CHECKLIST FOR SUBSCRIBERS</h4>
                                                        @include("investor.elements.additionalSubscription.document")
                                                    </section> --}}

                                                </div>

                                                    {{-- <div class="row mt-4">
                                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                                            <div class="form-group">
                                                                <label for="exampleFormControlSelect1">Investment Class *</label>

                                                                {!! Form::select('investment_class_type', $investmentClasses, $edit ? $subscription->investment_class_type : old('investment_class_type'), ['placeholder' => 'Please select class ...', 'class' => 'form-control', 'id' => 'investment_class_type_id', 'data-parsley-group'=>"block1", 'required' => 'required']) !!}
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2 col-md-6 col-sm-12">
                                                            <div class="form-group">
                                                                <label for="exampleFormControlSelect1">Salutation</label>
                                                                <?php 

                                                                    $salutationOption = ['Mr.'=> 'Mr','Mrs.'=> 'Mrs','Ms.'=> 'Ms','Dr.'=> 'Dr','Prof.'=> 'Prof','Assoc. Prof.'=> 'Assoc. Prof','Dato.'=> 'Dato',"Dato'."=> "Dato","Dato Sri."=>"Dato Sri","Dato' Sri."=>"Dato' Sri","Datin."=>"Datin","Datuk."=>"Datuk","Datuk Seri."=>"Datuk Seri","Datuk Sri."=>"Datuk Sri","Haji."=>"Haji","Hajjah."=>"Hajjah","Puteri."=>"Puteri","Puan Sri."=>"Puan Sri","Raja."=>"Raja","Tan Sri."=>"Tan Sri","Tengku."=>"Tengku","Tun."=>"Tun","Tun Poh."=>"Tun Poh", 'Tunku.'=>'Tunku']; ?>
                                                                {!! Form::select('salutation', $salutationOption, $edit ? $subscription->salutation : $userData->salutation,
                                                                    ['class' => 'form-control', 'id' => 'salutation', 'data-parsley-group'=>"block1", 'required']) !!}
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-8 col-sm-12">
                                                            <div class="form-group">
                                                                <label for="date">Name</label>
                                                                <input type="text" class="form-control" id="name" name="name"   placeholder="Name" value="{{ $edit ? $subscription->name : $userData->name }}" data-parsley-group="block1" required>
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
                                                                <input type="text" class="form-control" id="address_line2" name="address_line2" placeholder="Address Line2" value="{{ $edit ? $subscription->address_line2 : $userData->address_line2 }}" data-parsley-group="block1" required>
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
                                                                    <input type="text" class="form-control" id="amount" name="amount" placeholder="Subscription Amount" data-parsley-group="block1" data-parsley-type="digits" required , data-parsley-min="{{ config('settings.additional_amount') }}" data-parsley-error-message="Minimum additional investment amount is {{ config('settings.additional_amount') }}" data-parsley-errors-container="#initial_investment_error" onchange="saveAdditionalSubscriptiontoDraft()">
                                                                    
                                                                    <div id="initial_investment_error"></div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div style="height: 1px ;border: 0.2px dashed #d9d9d9;width: 100%;margin: 15px auto;"></div>
                                                        <h4 class="pl-2 pt-2">BANK DETAILS</h4>
                                                        <div class="row sec2-form mt-3">
                                                            <div class="col-lg-12 col-md-6 col-sm-12">
                                                                <div class="form-group">
                                                                    <label for="phone">Bank Name</label>
                                                                    <input type="text" class="form-control" id="bank_name" name="bank_name" placeholder="Bank Name" data-parsley-group="block1" value="{{$edit ? $subscription->bank_name : old('bank_name') }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                                <div class="form-group">
                                                                    <label for="ip">Bank Address</label>
                                                                    <input type="text" class="form-control" id="bank_address" name="bank_address" placeholder="Bank Address" data-parsley-group="block1" value="{{$edit ? $subscription->bank_address : old('bank_address') }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                                <div class="form-group">
                                                                    <label for="phone">Account Name</label>
                                                                    <input type="text" class="form-control" id="account_name" name="account_name" placeholder="Account Name" data-parsley-group="block1" value="{{$edit ? $subscription->account_name : old('account_name') }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                                <div class="form-group">
                                                                    <label for="ip">Account Number</label>
                                                                    <input type="text" class="form-control" id="account_number" name="account_number" placeholder="Account Number" data-parsley-group="block1" data-parsley-type="digits" value="{{$edit ? $subscription->account_number : old('account_number') }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                                <div class="form-group">
                                                                    <label for="phone">Swift Address</label>
                                                                    <input type="text" class="form-control" id="swift_address" name="swift_address" placeholder="Swift Address" data-parsley-group="block1" value="{{$edit ? $subscription->swift_address : old('swift_address') }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                                <div class="form-group">
                                                                    <label for="ip">Bank IBAN#</label>
                                                                    <input type="text" class="form-control" id="bank_inan" name="bank_inan" placeholder="Bank IBAN" data-parsley-group="block1" value="{{$edit ? $subscription->bank_inan : old('bank_inan') }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                                <div class="form-group">
                                                                    <label for="ip">Reference</label>
                                                                    <input type="text" class="form-control" id="reference" name="reference" placeholder="Reference" data-parsley-group="block1" value="{{$edit ? $subscription->reference : old('reference') }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div style="height: 1px ;border: 0.2px dashed #d9d9d9;width: 100%;margin: 15px auto;"></div>
                                                    <div class="col-lg-12">
                                                        <span class="text-danger">Please click to download the application form. After downloading, Kindly sign and upload using the below upload option.</span>
                                                        <br>

                                                        <div class="class_a_signedPdfDownload_div">
                                                            <a href="{{ url('/investor/signedPdfDownload') }}" target="_blank" download class="btn btn-primary btn-wide btn-sm">Click to review and download your application form</a>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-lg-12"><br>

                                                        <div class="form-group manual_signed_doc_a">
                                                            <label>Upload Signed Application *</label>
                                                            <input type="file" class="manual_signed_doc" name="file" required/>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12 text-right">
                                                        <button type="reset" class="btn btn-secondary mt-1 mr-1"> Reset </button>
                                                        <button type="button" class="btn btn-primary mt-1 mr-1 text-white saveAdditionalSubscription"> Submit </button>
                                                    </div>
                                                </div> --}}

                                            {{ Form::close() }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            @include('admin.elements.footer')
        </div>
    </div>
</div>
@endsection

@include('admin.elements.additionalSubscriptionScript')