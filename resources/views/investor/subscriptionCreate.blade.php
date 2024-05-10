@extends('layouts.app')

@section('title', 'Subscription')

@section('styles')

<script src="{{ asset('common/js/jSignature.min.js') }}"></script>

<link rel="stylesheet" type="text/css" href="{{ asset('assets/fileinput/plugins/css/fileinput.css') }}">
<script src="{{ asset('assets/fileinput/plugins/js/fileinput.min.js') }}"></script>
<script src="{{ asset('assets/fileinput/plugins/themes/fa4/theme.js') }}"></script>

<style>
	#radioValue1{
		display: none;
	}
	#radioValue2{
		display: none;
	}
	#joint-applicants{
		display: none;
	}
	#individual{
		display: none;
	}
	#fund{
		display: none;
	}
	#trust{
		display: none;
	}
	#private-fund{
		display: none;
	}
	#regular-finance{
		display: none;
	}
	#investment-finance{
		display: none;
	}
	#e-sign{
		display: none;
	}
	.wizard > .content {
        padding: 14px;
    }
    .sec2-form {
        width: 107%;
    }
    .main-panel.panel-defalt {
        position: inherit;
    }
</style>

@stop

@section('content')

	<div class="main-container">
		<div class="container-fluid page-body-wrapper">
			<div class="main-panel signup-main-panel panel-defalt">
				<div class="content-wrapper signup-content-wrapper">
				    
					<div class="row justify-content-center pd-2 mb-4">
						<div class="d-flex justify-content-center">
							<div class="d-flex justify-content-center">
								<div  class="d-flex justify-content-center ">
									<a class="brand-logo1" href="{{ url('/investor/dashboard') }}">
										<img src="{{ asset('logo.png') }}" alt="OAL Dashboard" title="OAL Dashboard"/>
									</a>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-12 col-md-12 ">
							<div class="card card-margin">
								<div class="card-header signup-card-header">
									<h5 class="card-title"> SUBSCRIPTION FORM </h5>									
								</div>
								<div class="card-body">
									 {!! Form::open(['url' => '/investor/subscriptionSave', 'files' => true, 'id' => 'subscriptionform', 'data-parsley-validate' => 'data-parsley-validate', "data-parsley-trigger"=>"keyup", 'autocomplete'=>"off" ]) !!}

									 	<input type="hidden" name="subscriptionId" id="subscriptionId">

										<div>
											<h3>SUBSCRIBER DETAILS</h3>
											<section>
												<h4>SUBSCRIBER DETAILS</h4>
												
												@include("investor.elements.newSubscription.subscription")
												
											</section>

											<h3>ADDITIONAL DETAILS</h3>
											<section>
												<h4>LEAD CONTACT DETAILS</h4>

												@include("investor.elements.newSubscription.additional")
											</section>

											<h3>DOCUMENTS</h3>
											<section>
												<h4>CERTIFIED SUPPORTING DOCUMENTS</h4>
												@include("investor.elements.newSubscription.document")
											</section>

										</div>
									{{ Form::close() }}
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

@include('investor.elements.subscriptionScript')