@component('mail::message')
# Congrats {{$user?->name}}

<p>
    You are one click away to finish setting up your account.<br>
    Kindly click on the button below to verify your account. <br>
</p>

@component('mail::button', ['url' => ''])
Verify Account
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
