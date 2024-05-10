<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use App\Subscription;
use App\Price;

class Subscription extends Model
{
	protected $table = 'subscriptions';

    protected $fillable = [
        'user_id', 'draft_refrence_id', 'reference_no', 'investment_name', 'investment_no', 'investment_class_type', 'investment_class', 'commencement_date', 'maturity_date', 'salutation', 'name', 'address_line1', 'address_line2', 'city', 'country', 'post_code', 'state', 'amount', 'actual_price', 'actual_no_of_share', 'latest_price', 'no_of_share', 'current_value', 'cheque_no', 'remittance_bank', 'service_charge', 'bank_charge', 'bank_name', 'bank_address', 'account_name', 'account_number', 'swift_address', 'bank_inan', 'reference', 'peb_declaration_status', 'peb_declaration_other', 'origin_fund_wealth', 'origin_fund_wealth_other', 'source_of_wealth', 'source_of_wealth_other', 'source_of_wealth_funds_comes', 'source_of_wealth_funds_comes_other', 'ja_peb_declaration_status', 'ja_peb_declaration_other', 'ja_origin_fund_wealth', 'ja_origin_fund_wealth_other', 'ja_source_of_wealth', 'ja_source_of_wealth_other', 'ja_source_of_wealth_funds_comes', 'ja_source_of_wealth_funds_comes_other', 'is_joint_account', 'ja_name', 'ja_address_line1', 'ja_address_line2', 'ja_city', 'ja_country', 'ja_post_code', 'ja_state', 'lc_name', 'lc_email', 'lc_phone_prefix', 'lc_phone_number', 'lc_facsimile', 'legal_status', 'legal_status_other', 'jurisdiction_under', 'ownership_status', 'os_name', 'os_address_line1', 'os_address_line2', 'os_city', 'os_country', 'os_post_code', 'os_state', 'subscriber_type', 'signature1', 'signature2', 'is_first', 'status', 'draft_delete', 'reinvestment_request', 'reinvestment_status', 'reinvestment_parant_id', 'reinvestment_child_id', 'redemption_request', 'redemption_status', 'redemption_msg', 'redemption_file', 'manual_signed_doc_enable', 'manual_signed_doc', 'individual_pep_doc', 'individual_source_fund_doc', 'ja_pep_doc', 'ja_source_fund_doc', 'bank_doc_request', 'bank_doc_request_hidden', 'changebank_file', 'changebank_request', 'changebank_status', 'changebank_msg', 'bank_instruction_date', 'subscription_acknowledge_status'
    ];

    public function UserAs(){
        return $this->belongsTo('App\User', 'user_id');
    }

    public function SsDocumentAs(){
        return $this->hasMany('App\SsDocument', 'subscription_id');
    }

    public function PayoutAs(){
        return $this->hasMany('App\Payout', 'subscription_id');
    }

    public function SubscriptionCountryAs(){
        return $this->belongsTo('App\Country', 'country');
    }

    public function SubscriptionStateAs(){
        return $this->belongsTo('App\State', 'state');
    }

    public function SubscriptionJaCountryAs(){
        return $this->belongsTo('App\Country', 'ja_country');
    }

    public function SubscriptionJaStateAs(){
        return $this->belongsTo('App\State', 'ja_state');
    }

    public function SubscriptionLcPhonePrefixAs(){
        return $this->belongsTo('App\Country', 'lc_phone_prefix');
    }


    public function SubscriptionOsCountryAs(){
        return $this->belongsTo('App\Country', 'os_country');
    }

    public function SubscriptionOsStateAs(){
        return $this->belongsTo('App\State', 'os_state');
    }

    public function InvestmentClassAs(){
        return $this->belongsTo('App\InvestmentClass', 'investment_class_type');
    }

    public function scopeMergeAmount($query, $user_id = NULL, $amount = NULL)
    {

        $subscriptionData = Subscription::where('user_id', $user_id)
                                ->where('is_first', '=', 1)
                                ->whereIn('status', [1, 2, 3, 6, 7])
                                ->orderBy('created_at', 'desc')->first();

        return $query->where('shop_id',$shop_id)->with('products', 'products.images', 'products.prices', 'products.variants', 'products.variants.images', 'products.variants.prices','images');
    }

    public function mergeInvestmentAmount($user_id = NULL, $investment_class = NULL, $amount = NULL){
        
        // merge investment amount
        $subscriptionData = Subscription::where('user_id', $user_id)
            ->where('is_first', 1)
            ->where('investment_class_type', $investment_class)
            ->where('status', 3)
            ->orderBy('created_at', 'desc')->first();

        $price = Price::where('active', 1)->where('class_type', $investment_class)->first();
        $latest_price = $price->latest_price;

        if (!empty($subscriptionData->current_value)) {
            $totalAmount = $subscriptionData->current_value;
        } else {
            $totalAmount = $subscriptionData->amount;
        }

        $totalInvestmentAmount = $totalAmount+$amount;

        $subscriptionData = Subscription::where('id', $subscriptionData->id)->where('user_id', $user_id)->first();
        $no_of_share = $totalInvestmentAmount/$latest_price;
        $current_value = $no_of_share * $latest_price;

        $subscriptionData->bank_doc_request = 0;

        // $subscriptionData->actual_price = $latest_price;
        // $subscriptionData->actual_no_of_share = $no_of_share;

        $subscriptionData->latest_price = $latest_price;
        $subscriptionData->no_of_share = $no_of_share;
        $subscriptionData->current_value = $current_value;

        $subscriptionData->save();
    }

    public function mergeRedemptionInvestmentAmount($user_id = NULL, $investment_class = NULL, $amount = NULL) {
        //
    }

    public function mergeInvestmentAmount2($user_id = NULL, $investment_class = NULL, $amount = NULL){
        
        // merge investment amount
        $subscriptionData = Subscription::where('user_id', $user_id)
            ->where('is_first', '=', 1)
            ->where('investment_class_type', '=', $investment_class)
            ->whereIn('status', [1, 2, 3, 6, 7])
            ->orderBy('created_at', 'desc')->first();

        $subscriptionData->amount += $amount;
        $subscription = $subscriptionData->save();

        //update investment share value
        $price = Price::where('id', 1)->first();
        // $subscription = Subscription::where('id', $subscription->id)->first();
        if ($subscriptionData) {
            $latest_price = $price->latest_price;
            $no_of_share = $subscriptionData->amount/$latest_price;
            $current_value = $no_of_share * $latest_price;
            
            $subscriptionData->bank_doc_request = 0;
            $subscriptionData->actual_price = $latest_price;
            $subscriptionData->actual_no_of_share = $no_of_share;
            $subscriptionData->latest_price = $latest_price;
            $subscriptionData->no_of_share = $no_of_share;
            $subscriptionData->current_value = $current_value;
            // $subscription->status = $request->input('status');
            $subscriptionData->save();
        }

        // $subscriptionData->update(["title" => "Updated title"]);

        // $notiData = [];
        // $notiData['sender_user_id'] = $sender_user_id;
        // $notiData['receiver_user_id'] = $receiver_user_id;
        // $notiData['link'] = $link;
        // $notiData['message'] = $message;

        // Notification::create($notiData);
    }
}