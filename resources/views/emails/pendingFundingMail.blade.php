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

<p>We are pleased to inform you that all documents are in order for the {{ $data->investment_class }} fund application.</p>

@if ($data->investment_type == 1)

<p>Kindly transfer your funds to Zetland's escrow account before the 10th of the last month of the current quarter if you wish to have your investment start after the upcoming valuation cycle.</p>

@elseif($data->investment_type == 2)
	
<p>Kindly transfer your funds to Zetland's escrow account before the next 10th of the month if you wish to have your investment start after the upcoming valuation cycle.</p>

@else

<p>Kindly transfer your funds to Zetland's escrow account before 14th Dec 2022. Zetland Consultants Pte Ltd is our appointed escrow agent.</p>

@endif

<p>We enclosed a copy of the bank instruction letter for your reference.</p>

<p>** Kindly upload the wire transfer slip to the CRM as proof of funding.</p>

<p>Here are the steps to guide you through the process:</p>
<p>i) Log in to the CRM portal.</p>
<p>ii) Select the “Upload Doc” option.</p> 
<p>iii) Upload the wire transfer slip using the designated Upload button.</p>
<p>iv) Finalize the process by clicking the “Submit” button. </p>

<p>Should you have any questions, please do not hesitate to contact us.</p>             

{!! config('settings.mail_signature') !!}

@endcomponent