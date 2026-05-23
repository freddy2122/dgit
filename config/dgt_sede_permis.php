<?php

/**
 * Parcours permis (chemins internes Sede).
 */
return [
    'sede_portal_path' => 'es',
    'permis_hub_path' => 'es/permisos-de-conducir',
    'obtencion_gestion_path' => 'es/permisos-de-conducir/obtencion-y-gestion-de-permisos',

    'identification' => [
        'title' => 'Accès aux démarches en ligne',
        'intro' => 'Identifiez-vous avec l’un des moyens proposés sur ce site (pages internes).',
        'steps' => [
            [
                'label' => 'Sede Electrónica DGT',
                'description' => 'Accueil des trámites en ligne.',
                'path' => 'es',
            ],
            [
                'label' => 'Cl@ve — inscription',
                'description' => 'Créer un compte Cl@ve (recommandé).',
                'path' => 'es/acceso/clave/plataforma',
            ],
            [
                'label' => 'Certificat électronique',
                'description' => 'Connexion avec certificat installé.',
                'path' => 'es/acceso/certificado-electronico',
            ],
            [
                'label' => 'DNIe / NIE',
                'description' => 'Carte avec puce et lecteur.',
                'path' => 'es/acceso/dnie',
            ],
        ],
    ],

    'pages' => [
        'nouveau' => [
            'breadcrumb' => 'Nouveau permis',
            'title' => 'Obtención y gestión de permisos',
            'title_fr' => 'Faire un nouveau permis de conduire',
            'path' => 'es/permisos-de-conducir/obtencion-y-gestion-de-permisos',
            'intro' => [
                'Démarches pour titulaires déjà aptes : notre gestoría ouvre le dossier, vous réglez par WhatsApp et vous suivez l’avancement sur miDGT.',
            ],
            'steps' => [
                'Nous contacter avec pièce d’identité et documents.',
                'Examen déjà réussi : enregistrement de votre résultat.',
                'Paiement des taxes par WhatsApp.',
                'Suivi du dossier jusqu’à réception du permis.',
            ],
        ],
        'renouvellement' => [
            'breadcrumb' => 'Renouvellement',
            'title' => 'Renovación de permiso próximo a caducar',
            'title_fr' => 'Renouveler un permis (avant expiration)',
            'path' => 'es/permisos-de-conducir/obtencion-y-gestion-de-permisos/renovacion-de-permiso-proximo-a-caducar',
            'intro' => [
                'Renouvellement pour conducteurs déjà titulaires : visite médicale en centre agréé, puis notre équipe transmet le dossier à la DGT.',
            ],
            'steps' => [
                'Reconocimiento médico en centro autorizado (certificado).',
                'Envoi du certificat et des documents à la gestoría.',
                'Paiement de la tasa par WhatsApp.',
                'Permis provisoire numérique puis envoi du permis définitif.',
            ],
        ],
        'canje' => [
            'breadcrumb' => 'Canje / permis étranger',
            'title' => 'Canjes de permisos',
            'title_fr' => 'Changer ou échanger un permis (canje)',
            'path' => 'es/permisos-de-conducir/canjes-de-permisos',
            'intro' => [
                'Remplacer un permis étranger par un permis espagnol équivalent, selon les cas.',
            ],
            'related' => [
                [
                    'label' => 'Canje de permisos extranjeros',
                    'path' => 'es/permisos-de-conducir/canjes-de-permisos/canjes-de-permisos-extranjeros',
                ],
            ],
        ],
        'changement-adresse' => [
            'breadcrumb' => 'Changement d’adresse',
            'title' => 'Dirección para notificaciones',
            'title_fr' => 'Changer l’adresse pour les notifications',
            'path' => 'es/permisos-de-conducir/direccion-para-notificaciones',
            'intro' => [
                'Communiquer le changement d’adresse pour les notifications DGT.',
            ],
        ],
        'duplicata' => [
            'breadcrumb' => 'Duplicata',
            'title' => 'Duplicado de permisos',
            'title_fr' => 'Demander un duplicata du permis',
            'path' => 'es/permisos-de-conducir/obtencion-y-gestion-de-permisos/duplicado-de-permisos',
            'intro' => [
                'En cas de perte, vol ou détérioration du permis.',
            ],
        ],
        'suivi' => [
            'breadcrumb' => 'Suivi de dossier',
            'title' => 'Estado de la tramitación del permiso',
            'title_fr' => 'Suivre l’état d’une demande de permis',
            'path' => 'es/permisos-de-conducir/obtencion-y-gestion-de-permisos/estado-de-la-tramitacion-del-permiso',
            'intro' => [
                'Consultation de l’état d’une demande en cours.',
            ],
        ],
    ],
];
