<?php


namespace App;


use Illuminate\Database\Eloquent\Model;


class Setting extends Model
{
	
	protected $table = 'settings';

    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
    protected $fillable = ['initial_amount', 'additional_amount', 'maturity_duration', 'maturity_period', 'investment_no', 'investment_draft_no', 'draft_refrence_id', 'sms_sent', 'email_sent', 'site_maintance', 'mail_signature', 'from_email', 'contact_enquiry_email', 'site_short_name', 'site_name', 'company_address', 'recipient_name', 'recipient_address', 'recipient_account_no', 'beneficiary_bank', 'beneficiary_bank_address', 'beneficiary_swift_code', 'bank_code', 'recipient_contact_no', 'branch_code', 'subcription_fee', 'subcription_fee_class_a', 'subcription_fee_class_b', 'sales_charge', 'single_escrow_charge_initial', 'single_escrow_charge_additional', 'joint_escrow_charge_initial', 'joint_escrow_charge_additional'
    ];
}