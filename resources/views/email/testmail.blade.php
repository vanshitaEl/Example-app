<x-mail::message>


# Hello {{$message}}  Thank you for Registration

<x-mail::button :url="$url['actionLink']">
Verify your Email
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
