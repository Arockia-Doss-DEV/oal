@extends('layouts.app')

@section('title', 'Landing')

@section('content')

	<div class="main-container">
		<div class="container-fluid page-body-wrapper full-page-wrapper">
			<div class="user-auth-v3 h-100">
				<div class="row no-gutters">
					<div class="col-lg-12 auth-header">
						<div class="logo-container thanks-logo d-flex justify-content-center">
							<a class="brand-logo" href="#">
								<img src="{{ asset('logo.png') }}" alt="OAL Dashboard" title="OAL Dashboard"/>
							</a>
						</div>
					</div>
				</div>
				<div class="row no-gutters pl-5">
					<div class="col-lg-6">
						<div class="user-auth-content login thanks-padding">
							<h3 class="auth-title thank-auth-title">Thanks for subscribing</h3>
							<label class="mb-2" > We have sent you an email for your reference. In addition, please be aware that additional supporting documents may be necessary to complete the application successfully.</label>

							<label class="mb-2"> Rest assured, we will provide an update on the application status within five working days.</label>

							<div class="mt-2 mb-4 d-flex justify-content-center thanks-logout">
								<a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
	                                 document.getElementById('logout-form').submit();">
				                    <button type="submit" class="btn btn-lg btn-base btn-rounded">Logout</button>
				                </a>

				                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
				                    @csrf
				                </form>
			                </div>
						</div>
					</div>
					
					<div class="col-lg-6 d-none d-md-block">
						<div class="auth-right-section login"></div>
					</div>

				</div>
			</div>
		</div>
	</div>
@endsection
