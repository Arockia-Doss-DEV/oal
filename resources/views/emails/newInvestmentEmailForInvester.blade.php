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
                                	
<p>Thank you for your application.</p>

<p>We’re currently in the process of reviewing your application, the review process may take up to 5 business days. Our personnel will be in contact with you once the application has been approved.</p>

{{-- <p>We are pleased to inform you that your subscription has commenced this month. The fund administrator (FA) emailed you the subscription confirmation note (Contract Note) in a separate email.</p>

<p>Please refer to the Contract Note or login to the CRM for more details.</p> --}}

<br>
<p>Please do not hesitate to contact us if you have any inquiries.</p>
<br>

{!! config('settings.mail_signature') !!}

@endcomponent