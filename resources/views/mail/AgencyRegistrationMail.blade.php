@component('mail::message')
# Hello {{$agency?->name}}

<p>
    You have been added to CHERT WORKSPACE.<br>
    Kindly use the credentials below to login. <br>
    Email: <b>{{$agency?->email}} </b> <br>
    Password: <b> {{ $password }} </b>
</p>

@component('mail::button', ['url' => ''])
Login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
