@component('mail::message')

<?php
    $salutation = '';

    if ( $data->salutation == "Mr." ) {
        $salutation = "Sir";
    } elseif ( $data->salutation == "Mrs." ) {
        $salutation = "Madam";
    } else {
        $salutation = $data->salutation;
    }
?>

<h3>Dear {{ $data->salutation }} {{ $data->name }},<h3>
                                
<p>Kindly be informed that Zetland has received your fund, USD {{ $data->investment_amount }}.  After the fund valuation is completed, Mauri Experta, the fund administrator, will email the new Contract Note to you.  
</p>

<p>Please do not hesitate to contact us if you have any inquiries.</p>

{!! config('settings.mail_signature') !!}

@endcomponent