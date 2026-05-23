Bonjour {{ $userName }},

{{ $title }}

{{ $body }}

Consultez votre espace : {{ $dashboardUrl }}

@if (! empty($whatsappReplyUrl))
{{ __('portal.whatsapp.email_button') }} : {{ $whatsappReplyUrl }}
@endif

— Portail permis de conduire
