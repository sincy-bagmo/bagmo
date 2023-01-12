@component('mail::message')
    Hi Admin,

    {{ $data['message'] }}

    Thanks,
    {{ config('app.name') }}
@endcomponent
