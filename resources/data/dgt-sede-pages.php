<?php

/**
 * Registre structurel des pages Sede (chemins, titres, vues, enfants).
 * Contenu textuel : lang/es|fr/sede_content.php via sede_page_field().
 */
$pages = [
    'es' => [
        'path' => 'es',
        'title' => 'Sede Electrónica DGT',
        'title_fr' => 'Sede Electrónica',
        'children' => [
            ['path' => 'es/acceso', 'label' => 'Acceso', 'label_fr' => 'Connexion (Acceso)'],
            ['path' => 'es/permisos-de-conducir', 'label' => 'Permisos de conducir', 'label_fr' => 'Permis de conduire'],
            ['path' => 'es/vehiculos', 'label' => 'Vehículos', 'label_fr' => 'Véhicules'],
            ['path' => 'es/multas', 'label' => 'Multas', 'label_fr' => 'Amendes et sanctions'],
            ['path' => 'es/otros-tramites/pago-de-tasas', 'label' => 'Pago de tasas', 'label_fr' => 'Paiement des taxes'],
            ['path' => 'es/otros-tramites/cita-previa', 'label' => 'Cita previa', 'label_fr' => 'Rendez-vous'],
            ['path' => 'es/otros-tramites/verificacion-de-documentos', 'label' => 'Verificación de documentos', 'label_fr' => 'Vérification de documents'],
            ['path' => 'midgt', 'label' => 'MiDGT', 'label_fr' => 'MiDGT'],
        ],
    ],
    'es/acceso' => [
        'path' => 'es/acceso',
        'title' => 'Acceso',
        'title_fr' => 'Connexion (Acceso)',
        'view' => 'acceso-index',
        'children' => [
            ['path' => 'es/acceso/clave', 'label' => 'Cl@ve', 'label_fr' => 'Cl@ve'],
            ['path' => 'es/acceso/certificado-electronico', 'label' => 'Certificado electrónico', 'label_fr' => 'Certificat électronique'],
            ['path' => 'es/acceso/dnie', 'label' => 'DNIe / NIE', 'label_fr' => 'DNIe / NIE'],
        ],
    ],
    'es/acceso/clave' => [
        'path' => 'es/acceso/clave',
        'title' => 'Cl@ve',
        'title_fr' => 'Cl@ve',
        'view' => 'acceso-clave',
        'children' => [
            ['path' => 'es/acceso/clave/plataforma', 'label' => 'Plataforma Cl@ve', 'label_fr' => 'Plateforme Cl@ve'],
            ['path' => 'es/acceso/clave/registrarse', 'label' => 'Registrarse en Cl@ve', 'label_fr' => 'Inscription Cl@ve'],
            ['path' => 'es/acceso/clave/conectar', 'label' => 'Acceder con Cl@ve', 'label_fr' => 'Connexion Cl@ve'],
        ],
    ],
    'es/acceso/clave/plataforma' => [
        'path' => 'es/acceso/clave/plataforma',
        'title' => 'Plataforma Cl@ve',
        'title_fr' => 'Plateforme Cl@ve',
        'view' => 'acceso-clave-plataforma',
    ],
    'es/acceso/clave/registrarse' => [
        'path' => 'es/acceso/clave/registrarse',
        'title' => 'Registrarse en Cl@ve',
        'title_fr' => 'Inscription Cl@ve',
        'view' => 'acceso-clave-registro',
    ],
    'es/acceso/clave/conectar' => [
        'path' => 'es/acceso/clave/conectar',
        'title' => 'Acceder con Cl@ve',
        'title_fr' => 'Connexion Cl@ve',
        'view' => 'acceso-clave-conectar',
    ],
    'es/acceso/certificado-electronico' => [
        'path' => 'es/acceso/certificado-electronico',
        'title' => 'Certificado electrónico',
        'title_fr' => 'Certificat électronique',
        'view' => 'acceso-certificado',
    ],
    'es/acceso/dnie' => [
        'path' => 'es/acceso/dnie',
        'title' => 'DNIe / NIE',
        'title_fr' => 'DNIe / NIE électronique',
        'view' => 'acceso-dnie',
    ],
    'es/permisos-de-conducir' => [
        'path' => 'es/permisos-de-conducir',
        'title' => 'Permisos de conducir',
        'title_fr' => 'Permis de conduire',
        'children' => [
            ['path' => 'es/permisos-de-conducir/informe-de-conductor', 'label' => 'Informe de conductor', 'label_fr' => 'Rapport conducteur'],
            ['path' => 'es/permisos-de-conducir/permiso-por-puntos', 'label' => 'Puntos del permiso', 'label_fr' => 'Points du permis'],
            ['path' => 'es/permisos-de-conducir/obtencion-y-gestion-de-permisos', 'label' => 'Obtención y gestión', 'label_fr' => 'Obtention et gestion'],
            ['path' => 'es/permisos-de-conducir/examenes-y-pruebas', 'label' => 'Exámenes y pruebas', 'label_fr' => 'Examens'],
            ['path' => 'es/permisos-de-conducir/obtencion-y-gestion-de-permisos/renovacion-de-permiso-proximo-a-caducar', 'label' => 'Renovación', 'label_fr' => 'Renouvellement'],
            ['path' => 'es/permisos-de-conducir/obtencion-y-gestion-de-permisos/duplicado-de-permisos', 'label' => 'Duplicado', 'label_fr' => 'Duplicata'],
            ['path' => 'es/permisos-de-conducir/canjes-de-permisos', 'label' => 'Canjes', 'label_fr' => 'Canje'],
            ['path' => 'es/permisos-de-conducir/obtencion-y-gestion-de-permisos/estado-de-la-tramitacion-del-permiso', 'label' => 'Estado de tramitación', 'label_fr' => 'Suivi de dossier'],
            ['path' => 'es/permisos-de-conducir/consulta-de-puntos', 'label' => 'Consulta de puntos', 'label_fr' => 'Consultation des points'],
            ['path' => 'es/permisos-de-conducir/permiso-de-conduccion-internacional', 'label' => 'Permiso internacional', 'label_fr' => 'Permis international'],
            ['path' => 'es/permisos-de-conducir/direccion-para-notificaciones', 'label' => 'Dirección para notificaciones', 'label_fr' => 'Changement d’adresse'],
        ],
    ],
    'es/permisos-de-conducir/obtencion-y-gestion-de-permisos' => [
        'path' => 'es/permisos-de-conducir/obtencion-y-gestion-de-permisos',
        'title' => 'Obtención y gestión de permisos',
        'title_fr' => 'Obtention et gestion des permis',
        'children' => [
            ['path' => 'es/permisos-de-conducir/obtencion-y-gestion-de-permisos/renovacion-de-permiso-proximo-a-caducar', 'label' => 'Renovación', 'label_fr' => 'Renouvellement'],
            ['path' => 'es/permisos-de-conducir/obtencion-y-gestion-de-permisos/duplicado-de-permisos', 'label' => 'Duplicado', 'label_fr' => 'Duplicata'],
            ['path' => 'es/permisos-de-conducir/obtencion-y-gestion-de-permisos/estado-de-la-tramitacion-del-permiso', 'label' => 'Estado de tramitación', 'label_fr' => 'État de la demande'],
        ],
    ],
    'es/permisos-de-conducir/obtencion-y-gestion-de-permisos/renovacion-de-permiso-proximo-a-caducar' => [
        'path' => 'es/permisos-de-conducir/obtencion-y-gestion-de-permisos/renovacion-de-permiso-proximo-a-caducar',
        'title' => 'Renovación de permiso próximo a caducar',
        'title_fr' => 'Renouvellement du permis',
    ],
    'es/permisos-de-conducir/obtencion-y-gestion-de-permisos/duplicado-de-permisos' => [
        'path' => 'es/permisos-de-conducir/obtencion-y-gestion-de-permisos/duplicado-de-permisos',
        'title' => 'Duplicado de permisos',
        'title_fr' => 'Duplicata du permis',
    ],
    'es/permisos-de-conducir/canjes-de-permisos' => [
        'path' => 'es/permisos-de-conducir/canjes-de-permisos',
        'title' => 'Canjes de permisos',
        'title_fr' => 'Canje (échange de permis)',
        'children' => [
            ['path' => 'es/permisos-de-conducir/canjes-de-permisos/canjes-de-permisos-extranjeros', 'label' => 'Canje permiso extranjero', 'label_fr' => 'Canje permis étranger'],
        ],
    ],
    'es/permisos-de-conducir/canjes-de-permisos/canjes-de-permisos-extranjeros' => [
        'path' => 'es/permisos-de-conducir/canjes-de-permisos/canjes-de-permisos-extranjeros',
        'title' => 'Canjes de permisos extranjeros',
        'title_fr' => 'Canje d’un permis étranger',
    ],
    'es/permisos-de-conducir/obtencion-y-gestion-de-permisos/estado-de-la-tramitacion-del-permiso' => [
        'path' => 'es/permisos-de-conducir/obtencion-y-gestion-de-permisos/estado-de-la-tramitacion-del-permiso',
        'title' => 'Estado de la tramitación del permiso',
        'title_fr' => 'Suivi de la demande',
    ],
    'es/permisos-de-conducir/direccion-para-notificaciones' => [
        'path' => 'es/permisos-de-conducir/direccion-para-notificaciones',
        'title' => 'Dirección para notificaciones',
        'title_fr' => 'Changement d’adresse',
    ],
    'es/permisos-de-conducir/consulta-de-puntos' => [
        'path' => 'es/permisos-de-conducir/consulta-de-puntos',
        'title' => 'Consulta de puntos',
        'title_fr' => 'Consultation des points',
    ],
    'es/permisos-de-conducir/permiso-de-conduccion-internacional' => [
        'path' => 'es/permisos-de-conducir/permiso-de-conduccion-internacional',
        'title' => 'Permiso de conducción internacional',
        'title_fr' => 'Permis international',
    ],
    'es/vehiculos' => [
        'path' => 'es/vehiculos',
        'title' => 'Vehículos',
        'title_fr' => 'Véhicules',
        'children' => [
            ['path' => 'es/vehiculos/informacion-de-vehiculos', 'label' => 'Información de vehículos', 'label_fr' => 'Information véhicules'],
            ['path' => 'es/vehiculos/duplicado-y-renovacion-de-documentacion', 'label' => 'Duplicado de documentación', 'label_fr' => 'Duplicata de documents'],
            ['path' => 'es/vehiculos/informacion-de-vehiculos/informe-de-un-vehiculo', 'label' => 'Informe de un vehículo', 'label_fr' => 'Rapport sur un véhicule'],
            ['path' => 'es/servicios-sede/cambio-de-direccion', 'label' => 'Cambio domicilio fiscal', 'label_fr' => 'Domicile fiscal'],
        ],
    ],
    'es/vehiculos/informacion-de-vehiculos/informe-de-un-vehiculo' => [
        'path' => 'es/vehiculos/informacion-de-vehiculos/informe-de-un-vehiculo',
        'title' => 'Informe de un vehículo',
        'title_fr' => 'Rapport sur un véhicule',
    ],
    'es/otros-tramites/pago-de-tasas' => [
        'path' => 'es/otros-tramites/pago-de-tasas',
        'title' => 'Pago de tasas',
        'title_fr' => 'Paiement des taxes',
    ],
    'es/otros-tramites/cita-previa' => [
        'path' => 'es/otros-tramites/cita-previa',
        'title' => 'Cita previa',
        'title_fr' => 'Rendez-vous (cita previa)',
    ],
    'es/otros-tramites/verificacion-de-documentos' => [
        'path' => 'es/otros-tramites/verificacion-de-documentos',
        'title' => 'Verificación de documentos',
        'title_fr' => 'Vérification de documents',
    ],
    'es/multas' => [
        'path' => 'es/multas',
        'title' => 'Multas',
        'title_fr' => 'Amendes et sanctions',
    ],
    'midgt' => [
        'path' => 'midgt',
        'title' => 'MiDGT',
        'title_fr' => 'MiDGT',
        'route' => 'midgt.index',
    ],
];

return array_replace($pages, require __DIR__.'/dgt-sede-pages-extra.php');
