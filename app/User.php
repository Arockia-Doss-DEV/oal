<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Setting;
use App\Notification;

class User extends Authenticatable 
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role_id', 'model_type', 'salutation', 'email_verified_at', 
        'address_line1', 'address_line2', 'city', 'country', 'post_code', 'state', 'gender', 'photo', 
        'bday', 'mobile_prefix', 'mobile_no', 'status', 'active', 'email_verified', 'setdefault', 'last_login', 'ip_address', 
        '2fa_status', '2fa_key'
    ]; 

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts(){

        return $this->hasMany('App\Newsletter', 'user_id');
    }

    public function countryAs(){
        return $this->belongsTo('App\Country', 'country');
    }

    public function stateAs(){
        return $this->belongsTo('App\State', 'state');
    }

    public function subscriptions()
    {
        return $this->hasMany('App\Subscription');
    }

    public function updateInvestmentNo(){

        Setting::find(1)->increment('investment_no');
        return;
    }

    public function updateInvestmentNoDraft(){

        Setting::find(1)->increment('investment_draft_no');
        return;
    }

    public function updateDraftReferenceId(){
        return Setting::find(1)->increment('draft_refrence_id');
    }

    public function sendOtp($to, $msg){

        if(config('settings.sms_sent') == 1){

            $appi = "http://cloudsms.trio-mobile.com/index.php/api/bulk_mt?api_key=56804054b0e75b4e202c6f6308ff578b731d6b561f1b8733041e434c23383739&action=send&to={{number}}&msg={{message}}&sender_id=CLOUDSMS&content_type=1&mode=shortcode&campaign=OAL";

            // $appi = "http://cloudsms.trio-mobile.com/index.php/api/bulk_mt?api_key=1c79d240ce224a842f04369e010c5aef80f3a59634148b37e5c5734e699fd2df&action=send&to={{number}}&msg={{message}}&sender_id=CLOUDSMS&content_type=1&mode=shortcode&campaign=TEST CAMPAIGN";

            $sendtext = urlencode("$msg");

            $appi = str_replace("{{number}}",$to,$appi);
            $appi = str_replace("{{message}}",$sendtext, $appi);
            $result = file_get_contents($appi);
            return;
        }else{
            return;
        }
    }

    public function notificationSave($sender_user_id, $receiver_user_id, $link, $message){
        
        $requestData2 = [];
        $requestData2['sender_user_id'] = $sender_user_id;
        $requestData2['receiver_user_id'] = $receiver_user_id;
        $requestData2['link'] = $link;
        $requestData2['message'] = $message;

        Notification::create($requestData2);
        

    }
    
}
