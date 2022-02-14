@component('mail::message')
# Hello {{$agent?->name}}

<p>
    You have been added to E-Services as an/a {{$admin->getRoleNames()[0]}} to {{$admin->agency->agency_name}}<br>
    Kindly use the credentials below to login. <br>
    Email: <b>{{$agent?->email}} </b> <br>
    Password: <b> {{ $password }} </b>
</p>

@component('mail::button', ['url' => ''])
Login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
