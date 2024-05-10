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
    
<p>Your bank details change request has been approved & updated. Your investment ID is {{ $data->investment_no }}.

{!! config('settings.mail_signature') !!}

@endcomponent