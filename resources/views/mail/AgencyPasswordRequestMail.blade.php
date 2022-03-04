@component('mail::message')
# Hello {{$agent->name}}

<section>
    <p>
        You have requested to reset your password, kindly click on the button below to reset your password.
    </p>
</section>

@component('mail::button', ['url' => "https://agency.respondergh.com/reset-password?token={$passwordReset->token}"])
    Reset Password
@endcomponent

<section>
<p>
    or you may copy and paste the link below in your browser to reset your password
</p>

<a href="https://agency.respondergh.com/reset-password?token={{$passwordReset->token}}" target="_blank">https://agency.respondergh.com/reset-password?token={{$passwordReset->token}}</a>
</section>

<section>
    <p> Please ignore this mail if you didn't perform this operation.</p>
</section>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
