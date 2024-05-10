@component('mail::message')
    
<h1>Reset 2FA Google Authenticator:</h1>
   
You can reset the code from this link:
<a href="{{ route('reset.twofa.get', $data->token) }}">Reset 2FA</a>

{!! config('settings.mail_signature') !!}

@endcomponent