@component('mail::message')
    Hi {{ $userDetails->first_name }},

    Hey, you are invited to join as {{ $userTypeName }} in CSSD Family,
    Please use the below link to rest the password and access the site.

@component('mail::button', ['url' => $url])
    Join Team
@endcomponent

    Thanks,
    {{ config('app.name') }}
@endcomponent
