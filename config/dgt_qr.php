<?php

return [
    /** Durée de validité du QR (comme miDGT : quelques minutes). */
    'ttl_seconds' => (int) env('DGT_QR_TTL_SECONDS', 180),

    /** Renouvellement automatique côté client (secondes avant expiration). */
    'refresh_before_seconds' => (int) env('DGT_QR_REFRESH_BEFORE', 15),

    /** Préfixe affiché du token (ex. TOKEN-ABC123). */
    'token_prefix' => 'TOKEN',

    /** Si true, chaque scan invalide le jeton (usage unique). */
    'single_use' => (bool) env('DGT_QR_SINGLE_USE', false),
];
