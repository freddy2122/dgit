<?php

namespace App\Services;

use App\Mail\PortalNotificationMail;
use App\Models\PortalNotification;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PortalNotificationService
{
    /** @param  array<string, mixed>  $params */
    public function notify(User $user, string $titleKey, string $bodyKey, array $params = []): void
    {
        $previous = App::getLocale();
        App::setLocale(portal_locale());

        $title = __($titleKey, $params);
        $body = __($bodyKey, $params);
        $outboundMessage = portal_whatsapp_outbound_message($user, $title, $body);
        $clientWhatsappUrl = client_whatsapp_url($user, $outboundMessage);
        $gestoriaReplyUrl = gestoria_whatsapp_client_reply_url($title, $body);

        PortalNotification::query()->create([
            'user_id' => $user->id,
            'title' => $titleKey,
            'body' => $bodyKey,
            'body_params' => $params,
            'notified_at' => now(),
            'is_read' => false,
        ]);

        App::setLocale($previous);

        if ($clientWhatsappUrl && (request()->routeIs('admin.*') || request()->is('admin/*'))) {
            session()->flash('admin_whatsapp_to_client', $clientWhatsappUrl);
            session()->flash('admin_whatsapp_preview', $outboundMessage);
        }

        if (config('portal.notify_by_email', true) && $user->email) {
            try {
                $mailLocale = portal_default_locale();
                $previousMailLocale = App::getLocale();
                App::setLocale($mailLocale);

                Mail::to($user->email)->send(new PortalNotificationMail(
                    $user,
                    $title,
                    $body,
                    $gestoriaReplyUrl,
                ));

                App::setLocale($previousMailLocale);
            } catch (\Throwable $e) {
                Log::warning('Portal notification email failed: '.$e->getMessage());
            }
        }
    }
}
