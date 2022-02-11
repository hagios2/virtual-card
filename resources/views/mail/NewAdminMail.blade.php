{{--@component('mail::message')--}}
<h5>Welcome {{ $admin?->name }}</h5>,

<p>
    You have been added to CHERT WORKSPACE.<br>
    Kindly use the credentials below to login. <br>
    Email: <b>{{$admin?->email}} </b> <br>
    Password: <b> {{ $password }} </b>
</p>

{{--@component('mail::button', ['url' => 'https://dev-cehrtworkspace.netlify.app/'])--}}
{{--    Login--}}
{{--@endcomponent--}}

<a href="https://dev-cehrtworkspace.netlify.app/">Login</a>

Thanks,<br>
{{ config('app.name') }}
{{--@endcomponent--}}
