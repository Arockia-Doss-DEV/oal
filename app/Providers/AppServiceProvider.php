<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Setting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $setting = Setting::where('id',1)->first();

        config()->set('settings.initial_amount', $setting['initial_amount']);
        config()->set('settings.additional_amount', $setting['additional_amount']);
        config()->set('settings.maturity_duration', $setting['maturity_duration']);
        config()->set('settings.maturity_period', $setting['maturity_period']);
        config()->set('settings.investment_no', $setting['investment_no']);
        config()->set('settings.investment_draft_no', $setting['investment_draft_no']);
        config()->set('settings.draft_refrence_id', $setting['draft_refrence_id']);
        config()->set('settings.sms_sent', $setting['sms_sent']);
        config()->set('settings.email_sent', $setting['email_sent']);
        config()->set('settings.site_maintance', $setting['site_maintance']);
        config()->set('settings.mail_signature', $setting['mail_signature']);
        config()->set('settings.site_name', $setting['site_name']);
        config()->set('settings.company_address', $setting['company_address']);
        config()->set('settings.from_email', $setting['from_email']);
        config()->set('settings.from_name', "Olympus Asset Limited");
        config()->set('settings.subcription_fee', $setting['subcription_fee']);
        config()->set('settings.sales_charge', $setting['sales_charge']);
        config()->set('settings.contact_enquiry_email', $setting['contact_enquiry_email']);

        config()->set('settings.recipient_name', $setting['recipient_name']);
        config()->set('settings.recipient_address', $setting['recipient_address']);
        config()->set('settings.recipient_account_no', $setting['recipient_account_no']);
        config()->set('settings.recipient_contact_no', $setting['recipient_contact_no']);
        config()->set('settings.branch_code', $setting['branch_code']);
        
        config()->set('settings.beneficiary_bank', $setting['beneficiary_bank']);
        config()->set('settings.beneficiary_bank_address', $setting['beneficiary_bank_address']);
        config()->set('settings.beneficiary_swift_code', $setting['beneficiary_swift_code']);
        config()->set('settings.bank_code', $setting['bank_code']);
        config()->set('settings.subcription_fee_class_a', $setting['subcription_fee_class_a']);
        config()->set('settings.subcription_fee_class_b', $setting['subcription_fee_class_b']);
        config()->set('settings.single_escrow_charge_initial', $setting['single_escrow_charge_initial']);
        config()->set('settings.single_escrow_charge_additional', $setting['single_escrow_charge_additional']);
        config()->set('settings.joint_escrow_charge_initial', $setting['joint_escrow_charge_initial']);
        config()->set('settings.joint_escrow_charge_additional', $setting['joint_escrow_charge_additional']);

        //config('settings.from_email')
    }
}
