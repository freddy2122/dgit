<?php

/**
 * Contenu éditorial Sede Electrónica DGT (français).
 */
$content = [
    'es' => [
        'role' => 'Sede Electrónica de la Direction générale de la circulation (DGT).',
        'intro' => [
            'La Sede Electrónica est le canal officiel pour effectuer vos démarches DGT en ligne, avec la même validité qu’en bureau lorsque la procédure le permet.',
        ],
        'body' => [
            'Vous pouvez y gérer permis de conduire, véhicules, amendes, taxes, rendez-vous et suivi de dossiers. La plupart des démarches exigent une identification Cl@ve, certificat électronique ou DNIe.',
            'Avec un compte sur ce portail de démonstration, accédez aussi à miDGT pour le permis numérique, les points, notifications et paiements simulés.',
        ],
        'requirements' => [
            'Connexion internet et navigateur à jour.',
            'Identification : Cl@ve, certificat électronique qualifié ou DNIe.',
            'Pour un dossier : NIE/DNI et données du demandeur.',
        ],
        'functions' => [
            'Demande et renouvellement de permis',
            'Duplicata et échange de permis',
            'Rapport et gestion de véhicules',
            'Consultation et paiement d’amendes',
            'Paiement des taxes et justificatifs',
            'Rendez-vous en bureau DGT',
            'Vérification de documents émis',
        ],
    ],

    'es_acceso' => [
        'role' => 'Point d’identification pour accéder aux démarches Sede.',
        'intro' => [
            'Avant tout trámite, vous devez prouver votre identité via un des systèmes d’identification électronique reconnus par l’administration espagnole.',
        ],
        'body' => [
            'Choisissez Cl@ve si vous avez identifiant et mot de passe ou l’app Cl@ve Móvil. Utilisez un certificat électronique qualifié installé sur votre poste. Avec DNIe/NIE, utilisez lecteur de cartes et code PIN.',
        ],
        'requirements' => [
            'Cl@ve permanente, Cl@ve Móvil, certificat FNMT/Camerfirma ou autre qualifié, ou DNIe avec lecteur.',
        ],
    ],

    'es_acceso_clave' => [
        'role' => 'Système d’identification Cl@ve du gouvernement d’Espagne.',
        'intro' => ['Cl@ve unifie l’accès aux services DGT et autres administrations.'],
        'body' => [
            'Inscrivez-vous sur la plateforme Cl@ve, connectez-vous si vous êtes déjà enregistré, ou utilisez Cl@ve Móvil depuis l’écran d’identification.',
        ],
        'functions' => ['Inscription Cl@ve', 'Connexion identifiant/mot de passe', 'Cl@ve Móvil', 'Certificat électronique'],
    ],

    'es_permisos-de-conducir' => [
        'role' => 'Permis de conduire — Sede Electrónica DGT.',
        'intro' => [
            'Choisissez un service : obtention, renouvellement, points, échange, permis international, examens et changement d’adresse.',
        ],
        'body' => [
            'Informations par démarche. Pièces et taxes spécifiques ; vérifiez si la procédure est 100 % en ligne ou nécessite un rendez-vous.',
        ],
        'functions' => [
            'Obtention et gestion',
            'Renouvellement',
            'Duplicata',
            'Échange permis étranger',
            'Permis international',
            'Consultation des points',
            'État de la demande',
            'Changement d’adresse',
        ],
    ],

    'es_permisos-de-conducir_obtencion-y-gestion-de-permisos' => [
        'role' => 'Procédures de création, modification et suivi du permis.',
        'intro' => ['Regroupe demande de permis, examens, transfert de dossier et suivi.'],
        'body' => [
            'Pour un premier permis : examen théorique et pratique en centre agréé. Renouvellement et duplicata ont des rubriques dédiées.',
        ],
        'steps' => [
            'Vérifier âge et documents.',
            'S’inscrire en auto-école ou présenter les examens.',
            'Payer les taxes sur la Sede.',
            'Suivre le dossier jusqu’à émission.',
        ],
        'functions' => ['Demande de permis', 'Inscription examens', 'Transfert de dossier', 'Modification des données'],
    ],

    'es_permisos-de-conducir_obtencion-y-gestion-de-permisos_renovacion-de-permiso-proximo-a-caducar' => [
        'role' => 'Renouvellement du permis avant ou après expiration.',
        'intro' => ['Le permis a une date de validité indiquée sur le document.'],
        'body' => [
            'Renouvellement en ligne si vous remplissez les conditions (âge, groupe, certificat médical si requis). Après longue expiration, examens ou formation peuvent être exigés.',
        ],
        'steps' => [
            'Vérifier la date de fin de validité.',
            'Certificat médical si obligatoire.',
            'Payer la taxe de renouvellement.',
            'Confirmer et suivre l’émission.',
        ],
        'requirements' => [
            'Cl@ve, certificat ou DNIe.',
            'Photo et signature selon modalité.',
            'Certificat médical si applicable.',
            'Taxe 2.1 ou autre selon la réglementation.',
        ],
        'functions' => ['Renouvellement anticipé', 'Renouvellement en grâce', 'Suivi du dossier'],
    ],

    'es_permisos-de-conducir_obtencion-y-gestion-de-permisos_duplicado-de-permisos' => [
        'role' => 'Émission d’un duplicata du permis.',
        'intro' => ['En cas de vol, perte ou détérioration du permis.'],
        'body' => [
            'Vol ou perte : déclaration ou plainte possible. Le duplicata reprend les mêmes catégories et dates au registre DGT.',
        ],
        'requirements' => ['Identification électronique', 'Déclaration si vol/perte', 'Taxe de duplicata'],
        'functions' => ['Duplicata détérioration', 'Duplicata perte/vol'],
    ],

    'es_permisos-de-conducir_canjes-de-permisos' => [
        'role' => 'Échange de permis étrangers.',
        'intro' => ['Obtenir un permis espagnol équivalent selon conventions bilatérales ou européennes.'],
        'body' => ['Tous les pays ne permettent pas l’échange direct ; parfois examens ou cours obligatoires.'],
        'functions' => ['Échange permis UE', 'Échange pays tiers avec convention'],
    ],

    'es_permisos-de-conducir_canjes-de-permisos_canjes-de-permisos-extranjeros' => [
        'role' => 'Échange d’un permis délivré à l’étranger.',
        'intro' => ['Pour résidents en Espagne titulaires d’un permis étranger.'],
        'body' => [
            'Fournir permis ou certificat du pays, traduction assermentée si besoin, preuve de résidence. La DGT décide échange direct ou examens.',
        ],
        'requirements' => ['Permis étranger valide', 'Résidence', 'Photo et taxe'],
    ],

    'es_permisos-de-conducir_obtencion-y-gestion-de-permisos_estado-de-la-tramitacion-del-permiso' => [
        'role' => 'Consultation de l’état de vos demandes de permis.',
        'intro' => ['Suivre obtention, renouvellement ou duplicata : en attente, validé, refusé, émis.'],
        'body' => ['NIE/DNI et numéro de dossier. Sur ce portail : consultation par code de vérification.'],
        'functions' => ['En attente', 'En cours', 'Résolu', 'Émis'],
    ],

    'es_permisos-de-conducir_direccion-para-notificaciones' => [
        'role' => 'Mise à jour de l’adresse postale et électronique.',
        'intro' => ['La DGT envoie notifications et mises en demeure à l’adresse enregistrée.'],
        'body' => ['Indiquez domicile en Espagne ou canal de notification électronique.'],
        'requirements' => ['Cl@ve ou certificat', 'Adresse complète et code postal'],
    ],

    'es_permisos-de-conducir_consulta-de-puntos' => [
        'role' => 'Consultation du solde de points.',
        'intro' => ['Solde initial ; infractions graves retranchent des points.'],
        'body' => ['Historique des sanctions et cours de sensibilisation. Compte miDGT : détail dans l’espace personnel.'],
        'functions' => ['Solde', 'Historique', 'Récupération de points'],
    ],

    'es_permisos-de-conducir_permiso-de-conduccion-internacional' => [
        'role' => 'Demande de permis international de conduite.',
        'intro' => ['Document complémentaire exigé dans certains pays avec le permis national.'],
        'steps' => [
            'Vérifiez que votre permis espagnol est valide.',
            'Identifiez-vous avec Cl@ve, certificat ou DNIe sur ce portail ou sur la Sede officielle.',
            'Payez la taxe et retirez le permis international selon les modalités indiquées.',
        ],
        'functions' => [
            'Consultation des exigences et pays concernés',
            'Demande avec identification électronique',
            'Paiement des taxes',
            'Suivi du dossier',
        ],
        'body' => ['Permis espagnol en cours de validité, taxe et délai d’émission limité.'],
        'requirements' => ['Permis espagnol valide', 'Taxe', 'Identification électronique'],
    ],

    'es_vehiculos' => [
        'role' => 'Véhicules — Sede Electrónica DGT.',
        'intro' => [
            'Démarches liées à vos véhicules : immatriculation, transferts, notification de vente, radiations et réhabilitations.',
        ],
        'body' => [
            'Duplicata de documents, vignette environnementale, rapports véhicule, domicile fiscal et conducteur habituel. Les liens « Sede officielle » ouvrent sede.dgt.gob.es.',
        ],
        'functions' => ['Rapport véhicule', 'Transferts', 'Immatriculation et radiations', 'Charges'],
    ],

    'es_vehiculos_informacion-de-vehiculos_informe-de-un-vehiculo' => [
        'role' => 'Rapport véhicule par plaque ou numéro de châssis.',
        'intro' => ['Données techniques, titularité, historique contrôle technique.'],
        'body' => ['Utile avant achat d’occasion. Ici : rapport simulé après identification.'],
        'requirements' => ['Plaque ou VIN', 'Identification', 'Taxe rapport'],
        'functions' => ['Données véhicule', 'ITV', 'Anciens titulaires', 'Leasing/renting'],
    ],

    'es_multas' => [
        'role' => 'Consultation et gestion des amendes routières.',
        'intro' => ['Amendes DGT : montant, dossier, points, délai de paiement minoré.'],
        'body' => ['Paiement avec réduction, recours, historique. Identification requise pour vos sanctions.'],
        'functions' => ['Amendes en attente', 'Paiement', 'Recours', 'Justificatif'],
    ],

    'es_otros-tramites_pago-de-tasas' => [
        'role' => 'Paiement des taxes DGT.',
        'intro' => ['Taxes obligatoires pour permis, transferts, rapports, etc.'],
        'body' => ['Choisissez le modèle, payez en ligne, conservez le justificatif PDF avec code de vérification.'],
        'functions' => ['Taxes en attente', 'Paiement', 'Justificatif'],
    ],

    'es_otros-tramites_cita-previa' => [
        'role' => 'Prise de rendez-vous en bureau DGT.',
        'intro' => ['Certaines démarches exigent une présence physique.'],
        'body' => ['Province, bureau, type de service, créneau. Confirmation par e-mail/SMS.'],
        'steps' => [
            'Choisir bureau et service.',
            'Date et heure.',
            'Confirmer la référence.',
            'Se présenter avec pièces du trámite.',
        ],
        'functions' => ['RDV permis', 'RDV véhicules', 'Autres RDV'],
    ],

    'es_otros-tramites_verificacion-de-documentos' => [
        'role' => 'Vérification d’authenticité des documents DGT.',
        'intro' => ['Tiers : vérification par code sécurisé sur le document.'],
        'body' => ['Saisie du code sans être titulaire. Validité et non-révocation.'],
        'functions' => ['Validation code', 'État', 'Date d’émission'],
    ],

    'midgt' => [
        'role' => 'Espace personnel conducteur DGT.',
        'intro' => ['Permis numérique, véhicules, notifications, amendes et RDV centralisés.'],
        'body' => [
            'Connectez-vous au portail de démo ou aux moyens officiels en production. Tableau de bord : permis mobile, points, paiements simulés.',
        ],
        'functions' => [
            'Permis numérique',
            'Notifications',
            'Mes véhicules',
            'Amendes et paiements',
            'Rendez-vous',
            'Profil',
        ],
    ],
];

return array_replace($content, require __DIR__.'/sede_content_extra.php');
