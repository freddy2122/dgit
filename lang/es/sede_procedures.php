<?php

/**
 * Listados de trámites por página hub.
 * path = ruta local; official = ruta adicional del catálogo Sede.
 */
return [
    'es_vehiculos' => [
        [
            'group' => 'Trámites generales',
            'items' => [
                ['title' => 'Transferencia o cambio de titularidad de un vehículo', 'official' => 'es/asistentes/asistente-transferencias'],
                ['title' => 'Entrega de un vehículo a un compraventa', 'official' => 'es/.galleries/enlaces/enlaces_sedeclave/WEB_RELW-FENTG.html'],
                ['title' => 'Notificación de venta de un vehículo', 'official' => 'es/.galleries/enlaces/enlaces_sedeclave/WEB_RELW-NOTV.html'],
                ['title' => 'Altas, bajas y rehabilitaciones de vehículos', 'official' => 'es/asistentes/asistente-bajas-vehiculos'],
                ['title' => 'Matriculaciones de vehículos', 'official' => 'es/asistentes/asistente-de-matriculacion'],
                ['title' => 'Duplicado del Permiso de Circulación', 'path' => 'es/vehiculos/duplicado-y-renovacion-de-documentacion/duplicado-del-permiso-de-circulacion'],
                ['title' => 'Duplicado de la Ficha Técnica Electrónica (eITV)', 'path' => 'es/vehiculos/duplicado-y-renovacion-de-documentacion/duplicado-de-la-ficha-tecnica'],
                ['title' => 'Informe de un vehículo', 'path' => 'es/vehiculos/informacion-de-vehiculos/informe-de-un-vehiculo'],
                ['title' => 'Consulta del distintivo ambiental', 'path' => 'es/vehiculos/informacion-de-vehiculos/distintivo-ambiental'],
                ['title' => 'Aviso de llamada a revisión de un vehículo', 'path' => 'es/vehiculos/informacion-de-vehiculos/llamadas-a-revision-de-un-vehiculo'],
                ['title' => 'Renovación del permiso de circulación', 'path' => 'es/vehiculos/informacion-de-vehiculos/renovacion-del-permiso-de-circulacion'],
                ['title' => 'Cambio en características no reflejadas en el permiso de circulación', 'path' => 'es/vehiculos/informacion-de-vehiculos/cambio-caracteristicas-no-pc'],
                ['title' => 'Cambio de domicilio fiscal de vehículos', 'path' => 'es/servicios-sede/cambio-de-direccion'],
                ['title' => 'Comunicación del conductor habitual', 'official' => 'es/.galleries/enlaces/enlaces_sedeclave/Alta-del-conductor-habitual.html'],
            ],
        ],
    ],

    'es_permisos-de-conducir' => [
        [
            'group' => 'Trámites generales',
            'items' => [
                ['title' => 'Informe de datos de conductor', 'path' => 'es/permisos-de-conducir/informe-de-conductor'],
                ['title' => 'Trámites sobre los puntos de tu permiso', 'path' => 'es/permisos-de-conducir/permiso-por-puntos'],
                ['title' => 'Obtención, renovación y duplicados de permisos', 'path' => 'es/permisos-de-conducir/obtencion-y-gestion-de-permisos'],
                ['title' => 'Permiso internacional', 'path' => 'es/permisos-de-conducir/permiso-de-conduccion-internacional'],
                ['title' => 'Permisos para mercancías peligrosas (ADR)', 'path' => 'es/permisos-de-conducir/mercancias-peligrosas'],
                ['title' => 'Canjes de permisos de conducir', 'path' => 'es/permisos-de-conducir/canjes-de-permisos'],
                ['title' => 'Estado de la tramitación del permiso', 'path' => 'es/permisos-de-conducir/obtencion-y-gestion-de-permisos/estado-de-la-tramitacion-del-permiso'],
                ['title' => 'Cambio de dirección para notificaciones', 'path' => 'es/permisos-de-conducir/direccion-para-notificaciones'],
                ['title' => 'Exámenes y pruebas de aptitud', 'path' => 'es/permisos-de-conducir/examenes-y-pruebas'],
            ],
        ],
    ],

    'es_multas' => [
        [
            'group' => 'Trámites generales',
            'items' => [
                ['title' => 'Identificación del infractor y pago de multas', 'path' => 'es/multas'],
                ['title' => 'Presentación de alegaciones y recursos', 'path' => 'es/multas'],
                ['title' => 'Consulta de sanciones y puntos', 'path' => 'es/permisos-de-conducir/consulta-de-puntos'],
            ],
        ],
    ],
];
