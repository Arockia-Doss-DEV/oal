@component('mail::message')
	

<h3>Dear Admin,<h3>
   
<p>The {{ $data->name }} with Investment ID : {{ $data->investment_no }} placed a new additional investment.</p>
<p>Kindly process it.</p>

{!! config('settings.mail_signature') !!}

@endcomponent