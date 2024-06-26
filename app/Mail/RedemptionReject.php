<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RedemptionReject extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
   
    public function __construct($data){
        $this->data = $data;   
    }

    public function build(){

            
            $from_email = config('settings.from_email');
            $from_name = config('settings.from_name');

            return $this
                ->from($from_email, $from_name)
                // ->subject("Investment Reject Mail")
                ->subject("OAL Application: Redemption Rejected")
                ->markdown('emails.redemptionReject');
 
    }
}
