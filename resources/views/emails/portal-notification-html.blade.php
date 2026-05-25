<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
</head>
<body style="font-family: system-ui, -apple-system, sans-serif; line-height: 1.5; color: #1f2937; max-width: 560px; margin: 0 auto; padding: 24px;">
    <p>{{ __('portal.whatsapp.outbound_greeting', ['name' => $userName]) }}</p>
    <p><strong>{{ $title }}</strong></p>
    <p style="white-space: pre-wrap;">{{ $body }}</p>
    <p><a href="{{ $dashboardUrl }}" style="color: #004481;">{{ $dashboardUrl }}</a></p>
    <p style="margin-top: 32px; font-size: 12px; color: #6b7280;">— Portail permis de conduire</p>
</body>
</html>
