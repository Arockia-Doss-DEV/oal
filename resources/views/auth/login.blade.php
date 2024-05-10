@extends('layouts.app')

@section('title', 'Login')

@section('styles')

<style type="text/css">
    .hidden{
        display: none;
    }
</style>

@stop

@section('content')

<div class="login-container login-img" style="background-size: 100% 100%;">
		<div class="login-box animated fadeInDown">
			<div class="">
    			<a class="brand-logo" href="{{ url('/index.html') }}">

                    <img src="{{ asset('site/assets/img/oal_logo_2.png') }}" alt="OAL Dashboard" title="OAL Dashboard" class='login-log' />
                    
                    {{-- <img src="{{ asset('logo.png') }}" alt="OAL Dashboard" title="OAL Dashboard" class='login-log' /> --}}
                </a>
			</div>
			<div class="login-body" style="background-color: #FFF;">
				<div class="login-title"><strong>OLYMPUS ASSET LIMITED</strong> </div>
				<div class="row no-gutters">
                <div class="col-lg-12">
                    <div class="user-auth-content login">
                        <!--<h3 class="auth-title">OLYMPUS ASSET LIMITED</h3>-->
                        <div class="row no-gutters">
                            <div class="col-sm-12 col-lg-12">
                                <form action="{{ route('login') }}" id=
                                "loginForm" method="POST" data-parsley-validate='data-parsley-validate' autocomplete="off">
                                    @csrf


                                    <div class="tab-content" id="nav-tabContent11">
                                        <div class="tab-pane fade show active" id="loginTab" role="tabpanel" aria-labelledby="nav-task-tab1">
                                            <div class="form-group inner-addon">
                                                <label class="mb-2" for="exampleInputEmail1">Email</label>

                                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Your email@domain.com" data-parsley-group="group-1">
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group inner-addon mt-3 mb-5">
                                                <label class="mb-2" for="exampleInputPassword1">Password</label>
                                                <div class="input-group mb-3">
                                                    
                                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="* * * * * * * *" data-parsley-group="group-1" data-parsley-errors-container="#passwordErrorDiv" >

                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text show-password" onclick="showhide();"> <i class="fa fa-eye-slash"></i></span>
                                                    </div>
                                                </div>
                                                <div id="passwordErrorDiv"></div>
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                           <div class="mb-4">
                                                <button type="button" id="loginOTPButton" class="btn btn-lg btn-base btn-rounded">Login</button>
                                            </div>

                                        </div>

                                        <div class="tab-pane fade" id="gauthTab" role="tabpanel" aria-labelledby="nav-demo-tab1">
                                            <div class="form-group inner-addon">
                                                <label class="mb-2" for="exampleInputPassword1">Verify 2FA OTP</label>
                                                <input type="text" class="form-control @error('gotp') is-invalid @enderror" name="gotp" value="{{ old('gotp') }}" placeholder='2FA Authenticator OTP' id='users-gotp' required="required" data-parsley-type="digits" data-parsley-minlength="6" data-parsley-maxlength="6" data-parsley-group="group-3">
                                            </div>

                                            {{-- <div class="pass login">
                                                <a href="javascript:void(0);" class="" id="reset2FAOtp"> RESET 2FA</a>
                                            </div> --}}

                                            <div class="pass login">
                                                <a href="javascript:void(0);" class="" id="forgot2FAOtp"> Forgot 2FA</a>
                                            </div>

                                            <div class="mb-4">
                                                <button type="button" id="gverifyOTP" class="btn btn-lg btn-base btn-rounded">Verify</button>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="smsTab" role="tabpanel" aria-labelledby="nav-demo-tab1">
                                            <div class="form-group inner-addon">
                                                <label class="mb-2" for="exampleInputPassword1">Verify OTP</label>
                                                <input type="text" class="form-control @error('otp') is-invalid @enderror" name="otp" value="{{ old('otp') }}" placeholder='OTP' id='users-otp' required="required" data-parsley-type="digits" data-parsley-minlength="6" data-parsley-maxlength="6" data-parsley-group="group-2">
                                            </div>

                                            <div class="pass login">
                                                <a href="javascript:void(0);" class="" id="loginOTPLink"> REQUEST OTP</a>
                                            </div>

                                            <div class="mt-5 mb-4">
                                                <button type="button" id="verifyOTP" class="btn btn-lg btn-base btn-rounded">Verify</button>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="d-block forgot-btn text-center">
                                        <a href="{{ route('password.request') }}" class="text-dark text-capitalize">Forgot Password?</a>
                                        
                                        {{-- || <a href="{{ route('register') }}" class="text-dark text-capitalize"> Signup</a> --}}

                                        {{-- <a href="javascript:void(0);" class="text-dark text-capitalize" id="forgot2FAOtp">Forgot 2FA?</a>  --}}
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8 d-none d-md-block">
                    <div class="auth-right-section login"></div>
                </div>

               

            </div>
			</div>
		</div>

        <!-- 2FA Reset Message Modal -->
        <div class="modal fade" id="enable2FADataModel" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Reset 2FA Verification</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    {!! Form::open(['url' => '/reset/twofa', 'files' => true, 'id' => 'enable2FADataForm', 'data-parsley-validate' => 'data-parsley-validate', "data-parsley-trigger"=>"keyup", 'autocomplete'=>"off" ]) !!}
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-xl-12 col-lg-12">
                                <div class="kt-portlet kt-portlet--height-fluid">
                                    <div class="kt-portlet__body">
                                        <div class="kt-widget kt-widget--general-1">
                                            <div class="kt-media kt-media--lg">
                                                <img src="{{ $qr_image }}" alt="image" style="max-width: 213px; height: 118px;">
                                            </div>

                                            <div class="kt-widget__wrapper">
                                                <div class="kt-widget__label">
                                                    <a href="#" class="kt-widget__title">
                                                        Scan this QR Code
                                                    </a>
                                                    <span class="kt-widget__desc">
                                                        <p>To Generate the verification code, open Google authenticator</p>
                                                        <p>Tap the "+" icon in the buttom-right of the app. Scan the image to the left, using your phone camera.</p>

                                                        <p>If you can not scan the code, insert the following secret key in your google authenticator app to generate a verification code : <b>{{ $google2fa_secret }}</b></p>
                                                    </span>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-12 col-lg-12">
                                <div class="kt-portlet kt-portlet--height-fluid">
                                    <div class="kt-portlet__body">
                                        <div class="kt-widget kt-widget--general-1">
                                            <div class="kt-media kt-media--lg kt-media--circle">
                                                <img src="{{ asset('/admin/images/sample_image/otp.png') }}" alt="image" style="max-width: 135px; height: 79px;">
                                            </div>

                                            <div class="kt-widget__wrapper">
                                                <div class="kt-widget__label">
                                                    <a href="#" class="kt-widget__title">
                                                        Enter Verification Code *
                                                    </a>
                                                    <span class="kt-widget__desc">
                                                        Enter the 6-digit verification code generated by the app.
                                                    </span>
                                                    <div class="col-lg-6 p-0">
                                                        <div class="form-group">
                                                            <input type="hidden" name="userEmail" id="userEmail">
                                                            <input type="hidden" name="secretcode" id="secretcode" value="{{ $google2fa_secret }}">
                                                            <input type="text" name="code" class="form-control" required="required" data-parsley-type="digits" maxlength="6" pattern="\d{6}" id="code" data-parsley-group="block2">
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary modal-cancel"
                            data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-info">Verify Code</button>
                    </div>

                    {{ Form::close() }}
                </div>
            </div>
        </div>


        <!-- Frogot 2FA Message Modal -->
        <div class="modal fade" id="enable2ForgotFADataModel" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Reset 2FA Verification</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    {!! Form::open(['url' => '/forgot/twofa', 'files' => true, 'id' => 'enableForgot2FADataForm', 'data-parsley-validate' => 'data-parsley-validate', "data-parsley-trigger"=>"keyup", 'autocomplete'=>"off" ]) !!}
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-xl-12 col-lg-12">
                                <div class="kt-portlet kt-portlet--height-fluid">
                                    <div class="kt-portlet__body">
                                        <div class="kt-widget kt-widget--general-1">
                                            

                                            <div class="kt-widget__wrapper">
                                                <div class="kt-widget__label">
                                                    <a href="#" class="kt-widget__title">
                                                        Enter Your Registered Email *
                                                    </a>
                                                    <div class="col-lg-12 p-0">
                                                        <div class="form-group">
                                                            <input type="email" name="userEmail" class="form-control" required="required" data-parsley-type="email" id="userEmail">
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary modal-cancel"
                            data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-info">Submit</button>
                    </div>

                    {{ Form::close() }}
                </div>
            </div>
        </div>

<div>

    

@endsection

@section('scripts')
    <script type="text/javascript">

         function showhide() {
            var type = document.getElementById("password").getAttribute("type");
            if (type == "password"){
                document.getElementById("password").setAttribute("type", "text");
                $(".show-password").html('<i class="fa fa-eye"></i>');
            } else{
                document.getElementById("password").setAttribute("type", "password");
                $(".show-password").html('<i class="fa fa-eye-slash"></i>');

            }
        }

        $("#loginOTPButton").on('click', function(e) {
            if ($('#loginForm').parsley().validate({group: 'group-1'})) {

                var csrfToken = "{{ csrf_token() }}";

                const form = document.getElementById('loginForm');
                let formData = new FormData(form);

                var email = $("#email").val();
                var password = $("#password").val();
                
                formData.set('email', email);
                formData.set('password', password);

                axios.post(SITE_URL+'checkLoginCredentials',formData,{
                        headers: {
                            'Content-Type': 'multipart/form-data',
                            'X-CSRF-Token': csrfToken}}
                ).then(function(response){

                    var item = response.data;
                    if(item.error === 0){

                        if(item.gauth){
                            $('#loginTab').removeClass('show active');
                            $('#gauthTab').addClass('show active');

                        }else{
                            $('#loginTab').removeClass('show active');
                            $('#smsTab').addClass('show active');

                            Swal.fire('Dear User','OTP has been sent to your mobile number, please verify!','success');
                        }
                    }else{
                        Swal.fire('Sorry!',"Incorrect Username/Password...",'error');
                    } 
                })
                .catch(function(e){
                    Swal.fire('Sorry!',"We're facing some issue on sending SMS, please try again.",'error');
                    setTimeout(location.reload.bind(location), 300);
                });
            }
        });

        $('#loginOTPLink').on('click', function () {

            var csrfToken = "{{ csrf_token() }}";

            const form = document.getElementById('loginForm');
            let formData = new FormData(form);

            var email = $("#email").val();
            var password = $("#password").val();
            formData.set('email', email);
            formData.set('password', password);

            axios.post(SITE_URL+'resendOtp',formData,{
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        'X-CSRF-Token': csrfToken}}
            ).then(function(response){

                var item = response.data;
                if(item.error === 0){

                   $("#users-otp").val("");
                   Swal.fire('Dear User','OTP has been sent to your mobile number, please verify!','success');
                }else{
                    Swal.fire('Sorry!',"We're facing some issue on sending SMS, please try again.",'error');
                    setTimeout(location.reload.bind(location), 300);
                } 
            })
            .catch(function(e){
                Swal.fire('Sorry!',"We're facing some issue on sending SMS, please try again.",'error');
                setTimeout(location.reload.bind(location), 300);
            });
            
        });


        $('#verifyOTP').on('click', function () {
           if ($('#loginForm').parsley().validate({group: 'group-2'})) {
                
                $("#users-gotp").removeAttr("required");
                var csrfToken = "{{ csrf_token() }}";

                const form = document.getElementById('loginForm');
                let formData = new FormData(form);

                var email = $("#email").val();
                var otp = $("#users-otp").val();

                formData.set('email', email);
                formData.set('otp', otp);
                
                axios.post(SITE_URL+'otpCheck',formData,{
                        headers: {
                            'Content-Type': 'multipart/form-data',
                            'X-CSRF-Token': csrfToken}}
                ).then(function(response){

                    var item = response.data;
                    if(item.error === 0){
                        
                        $('#loginForm').submit();

                    }else{
                        Swal.fire('Sorry!',"OTP code incorrect, please try again.",'error');
                    }
                })
                .catch(function(){
                    Swal.fire('Sorry!',"OTP code incorrect, please try again.",'error');
                });
            }
        });

        $('#gverifyOTP').on('click', function () {
           if ($('#loginForm').parsley().validate({group: 'group-3'})) {
                
                $("#users-otp").removeAttr("required");
                var csrfToken = "{{ csrf_token() }}";

                const form = document.getElementById('loginForm');
                let formData = new FormData(form);

                var email = $("#email").val();
                var otp = $("#users-gotp").val();

                formData.set('email', email);
                formData.set('otp', otp);
                
                axios.post(SITE_URL+'gaotpCheck',formData,{
                        headers: {
                            'Content-Type': 'multipart/form-data',
                            'X-CSRF-Token': csrfToken}}
                ).then(function(response){

                    var item = response.data;
                    if(item.error === 0){
                        $('#loginForm').submit();
                    }else{
                        Swal.fire('Sorry!',"OTP code incorrect, please try again.",'error');
                    }
                })
                .catch(function(){
                    Swal.fire('Sorry!',"OTP code incorrect, please try again.",'error');
                });
            }
        });

        $(document).on("click","#reset2FAOtp",function(e) {
            e.preventDefault();
            $('#enable2FADataForm')[0].reset();
            $('#enable2FADataModel').modal('show');

            var email = $("#email").val();
            $('#userEmail').val(email);
        });

        $(document).on("click","#forgot2FAOtp",function(e) {
            e.preventDefault();
            $('#enableForgot2FADataForm')[0].reset();
            $('#enable2ForgotFADataModel').modal('show');

            var email = $("#email").val();
            $('#userEmail').val(email);
        });

        

    </script>
@stop