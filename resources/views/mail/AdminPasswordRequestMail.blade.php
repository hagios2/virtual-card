{{--@component('mail::message')--}}
<h5>Hello {{$admin->name}}</h5>

<section>
    <p>
        You have requested to reset your password, kindly click on the link below to reset your password.
    </p>
</section>

{{--@component('mail::button', ['url' => env('PASSWORD_RESET_URL')."?token={$passwordReset->token}"])--}}
{{--    Reset Password--}}
{{--@endcomponent--}}

<section>
    <p>
        or you may copy and paste the link below in your browser to reset your password
    </p>

    <a href="{{env('PASSWORD_RESET_URL')."?token={$passwordReset->token}"}}" target="_blank">{{env('PASSWORD_RESET_URL')."?token={$passwordReset->token}"}}</a>
</section>

<section>
    <p> Please ignore this mail if you didn't perform this operation.</p>
</section>

Thanks,<br>
{{ config('app.name') }}
{{--@endcomponent--}}
