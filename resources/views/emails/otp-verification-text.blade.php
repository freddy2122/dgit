{{ __('site.registration.email_greeting') }}

{{ __('site.registration.email_body') }}

{{ $plainCode }}

{{ __('site.registration.email_expires') }}

@if (! empty($draft->nie))
{{ __('site.registration.email_reference') }}: {{ $draft->nie }}
@endif
