
@component('mail::message')
{{$name}}, Your account has been created.
Your password is {{$password}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
