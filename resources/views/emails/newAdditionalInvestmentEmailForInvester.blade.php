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
                                	
<p>Thank you for your additional investment application.</p>

<p>The reviewing process of your application will be less than 5 working days</p>

<p>Please do not hesitate to contact us should you need any further clarification.</p>
<br>

{!! config('settings.mail_signature') !!}

@endcomponent