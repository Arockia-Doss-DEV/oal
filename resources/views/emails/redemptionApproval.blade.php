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
    
<p>The following investor {{ $data->name }} , {{ $data->investment_no }} has been approval for redemption.</p>

<p>{{ $data->msg }}</p>

{!! config('settings.mail_signature') !!}

@endcomponent