{{ __('auth.reset_email_greeting', ['name' => $user->first_name ?: $user->name]) }}

{{ __('auth.reset_email_body') }}

{{ $plainCode }}

{{ __('auth.reset_email_expires', ['minutes' => $expiresInMinutes]) }}

{{ __('auth.reset_email_ignore') }}
