<?php

return [
    /** Mode gestoría : examen déjà réussi, paiements WhatsApp, dossiers créés par l’équipe. */
    'enabled' => (bool) env('GESTORIA_MODE', true),

    /** Numéro WhatsApp international sans + (ex. 34612345678). */
    'whatsapp_number' => env('GESTORIA_WHATSAPP', '34600000000'),

    /** Le citoyen ne démarre pas seul un trámite depuis la Sede (réservé à l’admin). */
    'client_can_start_tramite' => (bool) env('GESTORIA_CLIENT_START', true),

    /** Examen considéré comme déjà validé à l’ouverture du dossier. */
    'exam_prevalidated' => true,
];
