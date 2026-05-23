<?php

/**
 * Trámites permis — types, tarifs et chemins Sede (mode gestoría).
 */
return [
    'min_pass_score' => 70,

    'types' => [
        'obtencion' => [
            'fee' => 94.50,
            'requires_exam' => false,
            'requires_medical' => false,
            'label_es' => 'Obtención de permiso',
            'label_fr' => 'Obtention du permis',
        ],
        'renovacion' => [
            'fee' => 28.50,
            'requires_exam' => false,
            'requires_medical' => true,
            'label_es' => 'Renovación de permiso',
            'label_fr' => 'Renouvellement du permis',
        ],
        'duplicado' => [
            'fee' => 20.70,
            'requires_exam' => false,
            'requires_medical' => false,
            'label_es' => 'Duplicado de permiso',
            'label_fr' => 'Duplicata de permis',
        ],
        'canje' => [
            'fee' => 52.00,
            'requires_exam' => false,
            'requires_medical' => false,
            'label_es' => 'Canje de permiso',
            'label_fr' => 'Échange de permis',
        ],
        'direccion' => [
            'fee' => 8.60,
            'requires_exam' => false,
            'requires_medical' => false,
            'label_es' => 'Cambio de dirección',
            'label_fr' => 'Changement d’adresse',
        ],
        'internacional' => [
            'fee' => 12.00,
            'requires_exam' => false,
            'requires_medical' => false,
            'label_es' => 'Permiso internacional',
            'label_fr' => 'Permis international',
        ],
    ],

    'paths' => [
        'es/permisos-de-conducir/obtencion-y-gestion-de-permisos' => 'obtencion',
        'es/permisos-de-conducir/obtencion-y-gestion-de-permisos/renovacion-de-permiso-proximo-a-caducar' => 'renovacion',
        'es/permisos-de-conducir/obtencion-y-gestion-de-permisos/duplicado-de-permisos' => 'duplicado',
        'es/permisos-de-conducir/canjes-de-permisos' => 'canje',
        'es/permisos-de-conducir/canjes-de-permisos/canjes-de-permisos-extranjeros' => 'canje',
        'es/permisos-de-conducir/direccion-para-notificaciones' => 'direccion',
        'es/permisos-de-conducir/permiso-de-conduccion-internacional' => 'internacional',
    ],
];
