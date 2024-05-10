<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PendingFundingMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $attach;
   
    public function __construct($data, $attach){
        $this->data = $data;
        $this->attach = $attach;
    }

    public function build(){
        $from_email = config('settings.from_email');
        $from_name = config('settings.from_name');

        if(!empty($this->attach)){

            return $this
                ->from($from_email, $from_name)
                ->subject("OAL Application: Pending Funding")
                ->attach($this->attach, [
                    'as' => 'Bank Instruction.pdf',
                    'mime' => 'application/pdf',
                ])
                ->markdown('emails.pendingFundingMail');
        }else{
            return $this
                ->from($from_email, $from_name)
                ->subject("OAL Application: Pending Funding")
                ->markdown('emails.pendingFundingMail');
        }

        // return $this
        //     ->from($from_email, $from_name)
        //     ->subject("OAL Application: Pending Funding")
        //     ->markdown('emails.pendingFundingMail');
    }
}
