<h1>{{__('Email Verification Mail')}}</h1>

{{__('Please verify your email with bellow link:')}}
<a href="{{ route('verification-email', $data['token']) }}">{{__('Verify Email')}}</a>
