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

{{-- <p>The following Investment  {{ $data->investment_no }} has applied for redemption.</p> --}}

<p>Thank you for your redemption request.</p>

<br>

<p>Please be reminded that the fund administrator (FA) requires 10 business days’ notice before the upcoming Redemption Dealing Day to process your redemption request.  If the FA is not given the appropriate notice, redemption will normally take place on the next following Redemption Dealing Day.</p>

<br>

<p>The FA reserves the right to refuse to process a redemption request if any client identification or anti-money laundering compliance requirements remain outstanding.</p>

<br>

<p>Kindly contact us should you have any inquiries.</p>


{!! config('settings.mail_signature') !!}

@endcomponent