<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommonsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware' => ['revalidate']], function() {

    Route::get('/', 'HomesController@index');
    Route::post('/', 'HomesController@index')->name('home');
    Route::get('index.html', 'HomesController@index');
    Route::get('/who-we-are.html', 'HomesController@whoWeAre');
    Route::get('/corporate-values.html', 'HomesController@corporateValues');
    Route::get('/methdology.html', 'HomesController@methdology');
    Route::get('/newsletter.html', 'HomesController@newsletter');
    Route::get('/newsletter-details.html/{slug}', 'HomesController@newsletterDetails');
    Route::post('/disclaimer', 'HomesController@disclaimer')->name('disclaimer');
    Route::post('/contactUs', 'HomesController@contactUs')->name('contactUs');
    Route::get('/privacy-policy.html', 'HomesController@privacyPolicy')->name('privacyPolicy');
    Route::get('/private-placement-memorandum.html', 'HomesController@ppm')->name('ppm');

    Route::get('/findQuarter', 'InvestorController@findQuarter');

    Route::get('/storagelink', function(){
        \Artisan::call('storage:link');
        return "Se han vinculado las imágenes";
    });

    ///Common Function START
    Route::get('/selectBoxStateList', 'CommonsController@state');
    Route::post('/checkLoginCredentials', 'CommonsController@checkLoginCredentials');
    Route::post('/resendOtp', 'CommonsController@resendOtp');
    Route::post('/otpCheck', 'CommonsController@otpCheck');
    Route::post('/gaotpCheck', 'CommonsController@gaotpCheck');
    Route::post('/registerOtpCheck', 'CommonsController@registerOtpCheck');
    Route::get('/checkEmailExist', 'CommonsController@checkEmailExist');
    Route::get('/logout', 'Auth\LoginController@logout');

    //reset 2FA
    Route::post('/reset/twofa', 'CommonsController@reset2Fa');

    //forgot 2FA
    Route::post('/forgot/twofa', 'CommonsController@forgot2Fa');
    Route::get('reset-twofa/{token}', 'CommonsController@resetTwofa')->name('reset.twofa.get');

});


///Common Function END

Auth::routes();
Auth::routes(['verify' => true]);

//its Commen with loged user only
Route::group(['middleware' => ['auth', 'verified', 'revalidate']], function() {

    Route::get('/denied', 'CommonsController@denied');
    Route::get('/verify', 'CommonsController@verify');
    Route::get('/landing', 'CommonsController@landing');
    Route::get('/sessionCheckingLogin', 'CommonsController@sessionCheckingLogin');
    Route::get('/sessionRelogin', 'CommonsController@sessionRelogin');
    Route::post('/sessionLogout', 'CommonsController@sessionLogout');

    Route::post('/ssdocumentUpload', 'CommonsController@ssdocumentUpload');
    Route::post('/ssdocumentRemove', 'CommonsController@ssdocumentRemove');

    Route::post('/sSupportDocumentUpload', 'CommonsController@sSupportDocumentUpload');

    Route::get('/investor/subscriptionCreate', 'InvestorController@subscriptionInitialCreate');
    Route::post('/investor/subscriptionSave', 'InvestorController@subscriptionSave');
    Route::post('/investor/subscriptionSaveDraft', 'InvestorController@subscriptionSaveDraft');
    
    Route::get('/investor/signedPdfDownload', 'InvestorController@signedPdfDownload');
    // Route::get('/investor/signedPdfDownload/{id}', 'InvestorController@signedPdfDownload');

    Route::get('/investor/individual/pepPdfDownload', 'InvestorController@pepPdfDownload');
    Route::get('/investor/individual/fundPdfDownload', 'InvestorController@fundPdfDownload');

    Route::get('/investor/joint/pepPdfDownload', 'InvestorController@pepJointPdfDownload');
    Route::get('/investor/joint/fundPdfDownload', 'InvestorController@fundJointPdfDownload');

    Route::get('/investor/redemptionPdfDownload/{id}', 'InvestorController@redemptionPdfDownload');
    Route::get('/investor/bankingDetailsPdfDownload/{id}', 'InvestorController@bankingDetailsPdfDownload');

    Route::get('/user/subscription', 'InvestorController@getUserSubscription');
    Route::post('/investor/signedPdfApplicationsDownload', 'InvestorController@signedPdfApplicationsDownload');

    Route::post('/admin/signedPdfApplicationsDownload', 'AdminController@signedPdfApplicationsDownload');

});

Route::group(['middleware' => ['auth', 'verified', 'admin_check', 'set_view_variables', 'revalidate']], function() {

	//Admin
    Route::resource('roles','RoleController');
    Route::resource('users','UserController');
    Route::get('/deactive-invester', 'UserController@investerDeactive');
    Route::get('/userChangePassword/{id}', 'UserController@userChangePassword');
    Route::post('/userChangePasswordSave/{id}', 'UserController@userChangePasswordSave');
    Route::post('/disable2FaUser', 'UserController@disable2FaUser');
    Route::get('/enable2FaUser/{id}', 'UserController@enable2FaUser');
    Route::post('/enable2FaUserSave/{id}', 'UserController@enable2FaUserSave');
    Route::post('/deactiveuser', 'UserController@deactiveUser');
    Route::post('/activeuser', 'UserController@activeUser');
    
    Route::resource('permissions','PermissionController');
    Route::resource('flashmsgs','FlashmsgController');

    Route::get('/messages', 'MessageController@index');
    Route::get('/messages/create', 'MessageController@create');
    Route::post('/messages/setpTwo', 'MessageController@setpTwo');
    Route::post('/messages/confirm', 'MessageController@confirm');
    Route::get('/messages/show/{id}', 'MessageController@show');


    Route::get('/dashboard', 'AdminController@dashboard');
    Route::resource('prices','PriceController');
    Route::get('/price/edit', 'PriceController@editPrice')->name('EditPrice');

    Route::resource('newsletters','NewsletterController');

    Route::resource('trackrecords','TrackrecordController');


    //dashboard chart filter
    Route::post('/month/investment', 'AdminController@monthInvestment');
    Route::post('/month/additional/investment', 'AdminController@monthAdditionalInvestment');
    Route::post('/month/new/investment', 'AdminController@monthNewInvestment');

    //reports
    // Route::get('/reports', 'AdminController@reportIndex');
    // Route::post('/download/reports', 'AdminController@downloadReport');

    Route::get('/contract/reports', 'AdminController@reportIndex');
    Route::post('/reports/contractSummeryExcel', 'AdminController@downloadReport');
    
    /*Route::get('/trackrecords', 'TrackrecordController@index');
    Route::get('/trackrecords/create', 'TrackrecordController@create');
    Route::get('/trackrecords/show/{id}', 'TrackrecordController@show');
    Route::post('/trackrecordCreate', 'TrackrecordController@trackrecordCreate');
    Route::post('/trackrecordUpdate', 'TrackrecordController@trackrecordUpdate');
    Route::get('/trackrecords/delete/{id}', 'TrackrecordController@delete');
*/

    Route::get('/draft', 'AdminController@draft');
    Route::get('/pending', 'AdminController@pending');
    Route::get('/pendingFunding', 'AdminController@pendingFunding');
    Route::get('/fundReceived', 'AdminController@fundReceived');
    Route::get('/active', 'AdminController@active');
    Route::get('/deactive', 'AdminController@deactive');
    Route::get('/rejected', 'AdminController@rejected');

    Route::get('/matured', 'AdminController@matured');
    Route::get('/maturedRequest', 'AdminController@maturedRequest');

    Route::get('/reinvestment', 'AdminController@reinvestment');
    Route::get('/reinvestmentRequest', 'AdminController@reinvestmentRequest');

    Route::get('/subscriptionView/{id}', 'AdminController@subscriptionView');

    // Route::get('/subscriptionCreate/{id}', 'AdminController@subscriptionCreate');
    Route::get('/create/investor/subscription', 'AdminController@subscriptionCreate')->name('createNewInvestorSubscription');
    Route::get('/create/investor/subscriptionAdditionCreate', 'AdminController@subscriptionAdditionCreate')->name('createInvestorAdditionalSubscription');

    Route::get('/subscriptionEdit/{id}', 'AdminController@subscriptionEdit');
    Route::post('/subscriptionSave', 'AdminController@subscriptionSave');
    Route::post('/subscriptionSaveDraft', 'AdminController@subscriptionSaveDraft');
    Route::post('/subscriptionEditSave', 'AdminController@subscriptionEditSave');
    Route::post('/subscriptionEditSaveDraft', 'AdminController@subscriptionEditSaveDraft');

    Route::post('/changeStatus', 'AdminController@changeStatus');
    Route::post('/contractUpdate', 'AdminController@contractUpdate');
    Route::post('/investmentDetailsUpdate', 'AdminController@investmentDetailsUpdate');
    Route::post('/investmentShareDetailsUpdate', 'AdminController@investmentShareDetailsUpdate');
    Route::post('/manualSignedDocumentUpload', 'AdminController@manualSignedDocumentUpload');
    Route::post('/manualBankSlipDocumentUpload', 'AdminController@manualBankSlipDocumentUpload');
    Route::post('/documentUpload', 'AdminController@documentUpload');
    Route::post('/additionalSupportdocumentUpload', 'AdminController@additionalSupportdocumentUpload');
    Route::post('/bankSlipConfirmEmail', 'AdminController@bankSlipConfirmEmail');
    Route::post('/bankDetailsUpdate', 'AdminController@bankDetailsUpdate');
    Route::post('/deleteSubscription', 'AdminController@deleteSubscription');
    
    //Route::post('/investerActive', 'AdminController@investerActive');
    //Route::post('/investerDeactive', 'AdminController@investerDeactive');

    Route::get('/settings', 'AdminController@settings');
    Route::post('/changePassword', 'AdminController@changePassword');
    Route::post('/enable2Fa', 'AdminController@enable2Fa');
    Route::post('/disable2Fa', 'AdminController@disable2Fa');
    Route::post('/master', 'AdminController@masterSettings');


    //system adminstrators
    Route::get('/system/admins', 'AdminController@systemAdmins');
    Route::get('/create/admin', 'AdminController@createAdmin')->name('admin.create');
    Route::post('/admin/store', 'AdminController@storeAdmin')->name('admin.store');


    Route::get('/signedPdf/{id}', 'AdminController@signedPdf');
    Route::get('/bankPdf/{id}', 'AdminController@bankPdf');

    Route::get('/signedPdfDownload', 'AdminController@signedPdfDownload');

    Route::post('/redemptionUpdate', 'AdminController@redemptionUpdate');
    Route::get('/autoGenerateInvestment', 'AdminController@autoGenerateInvestment');

    Route::get('/setDefaultNotification', 'AdminController@setDefaultNotification');

    Route::post('/upload/image', 'AdminController@uploadImage')->name('ckeditor.image-upload');
    
});

Route::group(['middleware' => ['auth', 'verified','subcription_check', 'set_view_variables', 'revalidate']], function() {

    //Investor   
    Route::get('/investor/dashboard', 'InvestorController@dashboard');

    Route::post('/investor/redemptionUpload', 'InvestorController@redemptionUpload');
    Route::get('/investor/reinvestRequest/{id}', 'InvestorController@reinvestRequest');

    Route::get('/investor/uploadBankslip', 'InvestorController@uploadBankslip');
    Route::post('/investor/uploadBankslipSave', 'InvestorController@uploadBankslipSave');
    Route::post('/investor/changeBankDetailsUpload', 'InvestorController@changeBankDetailsUpload');
    
    Route::get('/investor/profile', 'InvestorController@profile');
    Route::get('/investor/subscriptions', 'InvestorController@subscriptions');

    Route::get('/investor/subscription/create', 'InvestorController@createNewSubscription')->name('createNewSubscription');

    Route::get('/investor/subscriptionView/{id}', 'InvestorController@subscriptionView');
    Route::get('/investor/subscriptionEdit/{id}', 'InvestorController@subscriptionEdit');
    Route::get('/investor/subscriptionEdit', 'InvestorController@subscriptionEdit')->name('investorSubscriptionEdit');
    Route::get('/investor/subscriptionAdditionCreate', 'InvestorController@subscriptionAdditionCreate')->name('createAdditionalSubscription');

    Route::post('/investor/subscriptionEditSave', 'InvestorController@subscriptionEditSave');
    Route::post('/investor/subscriptionEditSaveDraft', 'InvestorController@subscriptionEditSaveDraft');


    Route::get('/investor/newsletters', 'InvestorController@newsletters');
    Route::get('/investor/newsletterShow/{id}', 'InvestorController@newsletterShow');

    Route::get('/investor/messages', 'InvestorController@messages');
    Route::get('/investor/messagesShow/{id}', 'InvestorController@messagesShow');
    
    Route::get('/investor/flashmsgs', 'InvestorController@flashmsgs');
    Route::get('/investor/flashmsgView/{id}', 'InvestorController@flashmsgView');

    Route::get('/investor/settings', 'InvestorController@settings');

    Route::post('/investor/changePassword', 'InvestorController@changePassword');
    Route::post('/investor/enable2Fa', 'InvestorController@enable2Fa');
    Route::post('/investor/disable2Fa', 'InvestorController@disable2Fa');

    Route::get('/investor/signedPdf/{id}', 'InvestorController@signedPdf');
    Route::get('/investor/bankPdf/{id}', 'InvestorController@bankPdf');

});