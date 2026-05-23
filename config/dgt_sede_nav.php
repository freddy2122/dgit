<?php

/**
 * Menu Sede / services (liens internes uniquement).
 */
return [
    [
        'label' => 'Sede Electrónica',
        'label_fr' => 'Sede Electrónica',
        'path' => 'es',
        'children' => [
            ['label' => 'Acceso', 'label_fr' => 'Connexion (Acceso)', 'path' => 'es/acceso'],
            ['label' => 'Registro Cl@ve', 'label_fr' => 'Inscription Cl@ve', 'path' => 'es/acceso/clave/plataforma'],
            ['label' => 'Permiso de conducción', 'label_fr' => 'Permis de conduire', 'path' => 'es/permisos-de-conducir'],
            ['label' => 'Vehículos', 'label_fr' => 'Véhicules', 'path' => 'es/vehiculos'],
            ['label' => 'Multas', 'label_fr' => 'Amendes', 'path' => 'es/multas'],
            ['label' => 'Otros trámites', 'label_fr' => 'Autres démarches', 'path' => 'es/otros-tramites'],
        ],
    ],
    [
        'label' => 'Permisos — trámites',
        'label_fr' => 'Permis — démarches',
        'path' => 'es/permisos-de-conducir',
        'children' => [
            ['label' => 'Informe de conductor', 'label_fr' => 'Rapport conducteur', 'path' => 'es/permisos-de-conducir/informe-de-conductor'],
            ['label' => 'Puntos del permiso', 'label_fr' => 'Points du permis', 'path' => 'es/permisos-de-conducir/permiso-por-puntos'],
            ['label' => 'Obtención y gestión', 'label_fr' => 'Obtention et gestion', 'path' => 'es/permisos-de-conducir/obtencion-y-gestion-de-permisos'],
            ['label' => 'Renovación', 'label_fr' => 'Renouvellement', 'path' => 'es/permisos-de-conducir/obtencion-y-gestion-de-permisos/renovacion-de-permiso-proximo-a-caducar'],
            ['label' => 'Duplicado', 'label_fr' => 'Duplicata', 'path' => 'es/permisos-de-conducir/obtencion-y-gestion-de-permisos/duplicado-de-permisos'],
            ['label' => 'Canje', 'label_fr' => 'Canje', 'path' => 'es/permisos-de-conducir/canjes-de-permisos'],
            ['label' => 'Permiso internacional', 'label_fr' => 'Permis international', 'path' => 'es/permisos-de-conducir/permiso-de-conduccion-internacional'],
            ['label' => 'Estado tramitación', 'label_fr' => 'Suivi dossier', 'path' => 'es/permisos-de-conducir/obtencion-y-gestion-de-permisos/estado-de-la-tramitacion-del-permiso'],
            ['label' => 'Exámenes', 'label_fr' => 'Examens', 'path' => 'es/permisos-de-conducir/examenes-y-pruebas'],
            ['label' => 'Dirección notificaciones', 'label_fr' => 'Adresse notifications', 'path' => 'es/permisos-de-conducir/direccion-para-notificaciones'],
        ],
    ],
    [
        'label' => 'Vehículos',
        'label_fr' => 'Véhicules',
        'path' => 'es/vehiculos',
        'children' => [
            ['label' => 'Información vehículos', 'label_fr' => 'Infos véhicule', 'path' => 'es/vehiculos/informacion-de-vehiculos'],
            ['label' => 'Informe vehículo', 'label_fr' => 'Rapport véhicule', 'path' => 'es/vehiculos/informacion-de-vehiculos/informe-de-un-vehiculo'],
            ['label' => 'Distintivo ambiental', 'label_fr' => 'Vignette environnementale', 'path' => 'es/vehiculos/informacion-de-vehiculos/distintivo-ambiental'],
            ['label' => 'Duplicado documentación', 'label_fr' => 'Duplicata documents', 'path' => 'es/vehiculos/duplicado-y-renovacion-de-documentacion'],
        ],
    ],
    [
        'label' => 'MiDGT',
        'label_fr' => 'MiDGT',
        'path' => 'midgt',
        'children' => [
            ['label' => 'Acceso miDGT', 'label_fr' => 'Accès miDGT', 'path' => 'midgt'],
        ],
    ],
];
