<?php

return [
    /** Langue par défaut pour les URLs sans préfixe (/ → /fr/sede ou /es/sede). */
    'default_locale' => env('PORTAL_DEFAULT_LOCALE', 'fr'),

    /** Données démo auto (véhicules, paiements fictifs). Désactivé par défaut. */
    'demo_data' => (bool) env('PORTAL_DEMO_DATA', false),

    /** Envoyer un e-mail à chaque notification portail. */
    'notify_by_email' => (bool) env('PORTAL_NOTIFY_EMAIL', true),
];
