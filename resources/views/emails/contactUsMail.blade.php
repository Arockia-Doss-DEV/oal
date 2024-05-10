@component('mail::message')

<center><h1>User Contact Information</h1></center>

<p>User Firstname - {{ $data->firstname }}</p>
<p>User Lastname - {{ $data->lastname }}</p>
<p>Phone Number - +{!! $data->mobile_prefix !!} {!! $data->mobile_no !!}</p>
<p>Email - {{ $data->user_email }}</p>
<p>Message - {!! $data->message !!}</p>

{{-- {!! config('settings.mail_signature') !!} --}}

@endcomponent