

<?php $__env->startSection('title', 'Reset 2FA'); ?>

<?php $__env->startSection('content'); ?>

	<div class="main-container">
		<div class="container-fluid page-body-wrapper full-page-wrapper">
			<div class="user-auth-v3 h-100">
				<div class="row no-gutters">
					<div class="col-lg-12 auth-header">
						<div class="logo-container thanks-logo d-flex justify-content-center">
							<a class="brand-logo" href="#">
								<img src="<?php echo e(asset('logo.png')); ?>" alt="OAL Dashboard" title="OAL Dashboard"/>
							</a>
						</div>
					</div>
				</div>
				<div class="row no-gutters pl-5">

					<div class="col-lg-6">
						<div class="user-auth-content">
							<h3 class="auth-title thank-auth-title">Reset 2FA Step Verification</h3>
						</div>

						<?php echo Form::open(['url' => '/reset/twofa', 'files' => true, 'id' => 'enable2FADataForm', 'data-parsley-validate' => 'data-parsley-validate', "data-parsley-trigger"=>"keyup", 'autocomplete'=>"off" ]); ?>

                        <?php echo csrf_field(); ?>

						<div class="row">
							<div class="col-md-12 mb-3">
								<div class="col-xl-12 col-lg-12">
									<div class="kt-portlet kt-portlet--height-fluid">
										<div class="kt-portlet__body">
											<div class="kt-widget kt-widget--general-1">
												<div class="kt-media kt-media--lg kt-media--circle">
													<img src="<?php echo e(asset('/admin/images/sample_image/googleauthenticator.jpg')); ?>" alt="image" style="max-width: 213px; height: 135px;">
												</div>

												<div class="kt-widget__wrapper">
													<div class="kt-widget__label">
														<a href="#" class="kt-widget__title">
															1. Get the App
														</a>
														<span class="kt-widget__desc">
															Download Google Authenticator in your mobile. It`s available for iPhone and Android
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
												<div class="kt-media kt-media--lg">
													<img src="<?php echo e($qr_image); ?>" alt="image" style="max-width: 213px; height: 135px;">
												</div>

												<div class="kt-widget__wrapper">
													<div class="kt-widget__label">
														<a href="#" class="kt-widget__title">
															2. Scan this QR Code
														</a>
														<span class="kt-widget__desc">
															<p>To Generate the verification code, open Google authenticator</p>
															<p>Tap the "+" icon in the buttom-right of the app. Scan the image to the left, using your phone camera.</p>

															<p>If you can not scan the code, the following secret key in your app to generate verification code : <b><?php echo e($google2fa_secret); ?></b></p>
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
													<img src="<?php echo e(asset('/admin/images/sample_image/otp.png')); ?>" alt="image" style="max-width: 135px; height: 100px;">
												</div>

												<div class="kt-widget__wrapper">
													<div class="kt-widget__label">
														<a href="#" class="kt-widget__title">
															3. Enter Verification Code
														</a>
														<span class="kt-widget__desc">
															Enter the 6-digit verification code generated by the app.
														</span>
														<div class="col-lg-6">
															<div class="form-group">
																<input type="hidden" name="token" id="token" value="<?php echo e($token); ?>">
																<input type="hidden" name="userEmail" id="userEmail" value="<?php echo e($userEmail); ?>">
																<input type="hidden" name="secretcode" id="secretcode" value="<?php echo e($google2fa_secret); ?>">
																<div class="input text required"><input type="text" name="code" class="form-control" required="required" data-parsley-type="digits" maxlength="6" pattern="\d{6}" id="code"></div>
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
							<a href="<?php echo e(url('/login')); ?>" class="btn btn-secondary">Close</a>
							<button type="submit" class="btn btn-primary">Verify Code</button>
						</div>

						</form>

					</div>

					
					<div class="col-lg-6 d-none d-md-block">
						<div class="auth-right-section login"></div>
					</div>

				</div>



			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/olympus-asset.com/public_html/resources/views/auth/forgetTwofaLink.blade.php ENDPATH**/ ?>