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

<h3>Dear {{ $data->salutation }} {{$data->name }},<h3>

<p>We are pleased to inform you that your subscription has commenced this month. The fund administrator (FA) emailed you the subscription confirmation note (Contract Note) in a separate email.</p>

<p>Please refer to the Contract Note or login to the CRM for more details.</p>
 
{{-- <p>We are pleased to inform you that your wire transfer or bank in fund has been received. </p>
<p>Kindly be informed that your investment shall commence on the 1st day of next month and shall continue in effect for a period of two years from the date of commencement.</p> --}}
    
<p>Please do not hesitate to contact us if you have any inquiries.</p>


{!! config('settings.mail_signature') !!}


@endcomponent