@component('mail::message')
# Hello {{$user?->name}}

<p>
    You have been added to CHERT WORKSPACE.<br>
    Kindly use the credentials below to login. <br>
    Email: <b>{{$user?->email}} </b> <br>
    Password: <b> {{ $password }} </b> <br>
</p>

@component('mail::button', ['url' => 'https://admin.respondergh.com/login'])
    Login
@endcomponent
<p>
    or click on the link below to login <br>

    <a href="https://admin.respondergh.com/login" target="_blank">Login</a>
</p>

Thanks,<br>
{{ config('app.name') }}
@endcomponent


