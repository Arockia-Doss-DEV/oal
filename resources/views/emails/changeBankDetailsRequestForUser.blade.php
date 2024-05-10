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

{{-- <p>The following investment {{ $data->investment_no }} has applied to change their bank account details.</p> --}}

<p>We have received your request to change your bank details in the system. We shall update your bank details accordingly within a week.</p>

<br>
<p>Please get in touch with us if you do not request the change.</p>

{!! config('settings.mail_signature') !!}

@endcomponent