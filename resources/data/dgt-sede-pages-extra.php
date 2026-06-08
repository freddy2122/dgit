<?php

/** Pages Sede secondaires du portail local. */
return [
    'es/permisos-de-conducir/informe-de-conductor' => [
        'path' => 'es/permisos-de-conducir/informe-de-conductor',
        'title' => 'Informe de datos de conductor',
        'title_fr' => 'Rapport sur les données du conducteur',
    ],
    'es/permisos-de-conducir/permiso-por-puntos' => [
        'path' => 'es/permisos-de-conducir/permiso-por-puntos',
        'title' => 'Trámites sobre los puntos de tu permiso',
        'title_fr' => 'Démarches liées aux points du permis',
        'children' => [
            ['path' => 'es/permisos-de-conducir/consulta-de-puntos', 'label' => 'Consulta de puntos', 'label_fr' => 'Consultation des points'],
        ],
    ],
    'es/permisos-de-conducir/mercancias-peligrosas' => [
        'path' => 'es/permisos-de-conducir/mercancias-peligrosas',
        'title' => 'Permisos para mercancías peligrosas (ADR)',
        'title_fr' => 'Permis ADR — marchandises dangereuses',
    ],
    'es/permisos-de-conducir/examenes-y-pruebas' => [
        'path' => 'es/permisos-de-conducir/examenes-y-pruebas',
        'title' => 'Exámenes y pruebas de aptitud',
        'title_fr' => 'Examens et épreuves d’aptitude',
    ],
    'es/vehiculos/informacion-de-vehiculos' => [
        'path' => 'es/vehiculos/informacion-de-vehiculos',
        'title' => 'Información y consulta de vehículos',
        'title_fr' => 'Information et consultation véhicules',
        'children' => [
            ['path' => 'es/vehiculos/informacion-de-vehiculos/informe-de-un-vehiculo', 'label' => 'Informe de un vehículo', 'label_fr' => 'Rapport sur un véhicule'],
            ['path' => 'es/vehiculos/informacion-de-vehiculos/distintivo-ambiental', 'label' => 'Distintivo ambiental', 'label_fr' => 'Vignette environnementale'],
            ['path' => 'es/vehiculos/informacion-de-vehiculos/llamadas-a-revision-de-un-vehiculo', 'label' => 'Llamada a revisión', 'label_fr' => 'Convocation à révision'],
            ['path' => 'es/vehiculos/informacion-de-vehiculos/renovacion-del-permiso-de-circulacion', 'label' => 'Renovación permiso de circulación', 'label_fr' => 'Renouvellement permis de circulation'],
            ['path' => 'es/vehiculos/informacion-de-vehiculos/cambio-caracteristicas-no-pc', 'label' => 'Cambio de características', 'label_fr' => 'Changement de caractéristiques'],
        ],
    ],
    'es/vehiculos/informacion-de-vehiculos/distintivo-ambiental' => [
        'path' => 'es/vehiculos/informacion-de-vehiculos/distintivo-ambiental',
        'title' => 'Consulta del distintivo ambiental',
        'title_fr' => 'Consultation du distintivo ambiental',
    ],
    'es/vehiculos/informacion-de-vehiculos/llamadas-a-revision-de-un-vehiculo' => [
        'path' => 'es/vehiculos/informacion-de-vehiculos/llamadas-a-revision-de-un-vehiculo',
        'title' => 'Aviso de llamada a revisión de un vehículo',
        'title_fr' => 'Avis de convocation à révision',
    ],
    'es/vehiculos/informacion-de-vehiculos/renovacion-del-permiso-de-circulacion' => [
        'path' => 'es/vehiculos/informacion-de-vehiculos/renovacion-del-permiso-de-circulacion',
        'title' => 'Renovación del permiso de circulación',
        'title_fr' => 'Renouvellement du permis de circulation',
    ],
    'es/vehiculos/informacion-de-vehiculos/cambio-caracteristicas-no-pc' => [
        'path' => 'es/vehiculos/informacion-de-vehiculos/cambio-caracteristicas-no-pc',
        'title' => 'Cambio en características no reflejadas en el permiso de circulación',
        'title_fr' => 'Modification de caractéristiques non portées sur le permis',
    ],
    'es/vehiculos/duplicado-y-renovacion-de-documentacion' => [
        'path' => 'es/vehiculos/duplicado-y-renovacion-de-documentacion',
        'title' => 'Duplicado y renovación de documentación',
        'title_fr' => 'Duplicata et renouvellement de documents',
        'children' => [
            ['path' => 'es/vehiculos/duplicado-y-renovacion-de-documentacion/duplicado-del-permiso-de-circulacion', 'label' => 'Duplicado permiso de circulación', 'label_fr' => 'Duplicata permis de circulation'],
            ['path' => 'es/vehiculos/duplicado-y-renovacion-de-documentacion/duplicado-de-la-ficha-tecnica', 'label' => 'Duplicado ficha técnica (eITV)', 'label_fr' => 'Duplicata fiche technique (eITV)'],
        ],
    ],
    'es/vehiculos/duplicado-y-renovacion-de-documentacion/duplicado-del-permiso-de-circulacion' => [
        'path' => 'es/vehiculos/duplicado-y-renovacion-de-documentacion/duplicado-del-permiso-de-circulacion',
        'title' => 'Duplicado del Permiso de Circulación',
        'title_fr' => 'Duplicata du permis de circulation',
    ],
    'es/vehiculos/duplicado-y-renovacion-de-documentacion/duplicado-de-la-ficha-tecnica' => [
        'path' => 'es/vehiculos/duplicado-y-renovacion-de-documentacion/duplicado-de-la-ficha-tecnica',
        'title' => 'Duplicado de la Ficha Técnica Electrónica (eITV)',
        'title_fr' => 'Duplicata de la fiche technique électronique (eITV)',
    ],
    'es/servicios-sede/cambio-de-direccion' => [
        'path' => 'es/servicios-sede/cambio-de-direccion',
        'title' => 'Cambio de domicilio fiscal de vehículos',
        'title_fr' => 'Changement de domicile fiscal du véhicule',
    ],
    'es/otros-tramites' => [
        'path' => 'es/otros-tramites',
        'title' => 'Otros trámites',
        'title_fr' => 'Autres démarches',
        'children' => [
            ['path' => 'es/otros-tramites/pago-de-tasas', 'label' => 'Pago de tasas', 'label_fr' => 'Paiement des taxes'],
            ['path' => 'es/otros-tramites/cita-previa', 'label' => 'Cita previa', 'label_fr' => 'Rendez-vous'],
            ['path' => 'es/otros-tramites/verificacion-de-documentos', 'label' => 'Verificación de documentos', 'label_fr' => 'Vérification de documents'],
        ],
    ],
];
