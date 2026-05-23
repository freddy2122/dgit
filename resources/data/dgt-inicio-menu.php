<?php

/**
 * Source unique du menu d’accueil (chemins type dgt.es + libellés ES / FR).
 * Référence humaine : resources/menu/dgt-inicio.source.md (aligné sur inicio-0.md).
 */
return [
    [
        'label' => 'Nuestros servicios',
        'label_fr' => 'Nos services',
        'url' => 'nuestros-servicios',
        'children' => [
            [
                'label' => 'Conoce todos los trámites',
                'label_fr' => 'Renseignez-vous sur toutes les procédures',
                'url' => 'es',
            ],
            [
                'label' => 'Multas y sanciones',
                'label_fr' => 'Amendes et sanctions',
                'url' => 'es/multas',
                'children' => [
                    ['label' => 'Pago de multas', 'label_fr' => 'Paiement des amendes', 'url' => 'es/multas'],
                    ['label' => 'Consulta de puntos', 'label_fr' => 'Consultation des points', 'url' => 'es/permisos-de-conducir/consulta-de-puntos'],
                    ['label' => 'Sanciones e infracciones', 'label_fr' => 'Infractions et sanctions', 'url' => 'es/multas'],
                ],
            ],
            [
                'label' => 'Permisos de conducir',
                'label_fr' => 'Permis de conduire',
                'url' => 'es/permisos-de-conducir',
                'children' => [
                    [
                        'label' => 'Obtención y gestión de permisos',
                        'label_fr' => 'Obtention et gestion des permis',
                        'url' => 'es/permisos-de-conducir/obtencion-y-gestion-de-permisos',
                    ],
                    [
                        'label' => 'Consulta y justificante de puntos',
                        'label_fr' => 'Consultation des points',
                        'url' => 'es/permisos-de-conducir/consulta-de-puntos',
                    ],
                    [
                        'label' => 'Renovación de permiso',
                        'label_fr' => 'Renouvellement du permis',
                        'url' => 'es/permisos-de-conducir/obtencion-y-gestion-de-permisos/renovacion-de-permiso-proximo-a-caducar',
                    ],
                    [
                        'label' => 'Duplicado de permisos',
                        'label_fr' => 'Duplicata du permis',
                        'url' => 'es/permisos-de-conducir/obtencion-y-gestion-de-permisos/duplicado-de-permisos',
                    ],
                    [
                        'label' => 'Canjes de permisos',
                        'label_fr' => 'Canje (échange de permis)',
                        'url' => 'es/permisos-de-conducir/canjes-de-permisos',
                        'children' => [
                            [
                                'label' => 'Canjes de permisos extranjeros',
                                'label_fr' => 'Canje permis étranger',
                                'url' => 'es/permisos-de-conducir/canjes-de-permisos/canjes-de-permisos-extranjeros',
                            ],
                        ],
                    ],
                    [
                        'label' => 'Permiso de conducción internacional',
                        'label_fr' => 'Permis international',
                        'url' => 'es/permisos-de-conducir/permiso-de-conduccion-internacional',
                    ],
                    [
                        'label' => 'Obtener un nuevo permiso de conducir',
                        'label_fr' => 'Obtenir un nouveau permis de conduire',
                        'url' => 'es/permisos-de-conducir/obtencion-y-gestion-de-permisos',
                        'children' => [
                            ['label' => 'Requisitos y presentación a examen', 'label_fr' => 'Exigences et examen', 'url' => 'es/permisos-de-conducir/obtencion-y-gestion-de-permisos'],
                            ['label' => 'Elegir autoescuela', 'label_fr' => 'Choisir une auto-école', 'url' => 'es/permisos-de-conducir/obtencion-y-gestion-de-permisos'],
                            ['label' => 'Consulta tu nota de examen', 'label_fr' => 'Note d’examen', 'url' => 'es/permisos-de-conducir/obtencion-y-gestion-de-permisos'],
                            ['label' => 'Traslado de expediente', 'label_fr' => 'Transfert de dossier', 'url' => 'es/permisos-de-conducir/obtencion-y-gestion-de-permisos'],
                            ['label' => 'Estado de tramitación de tu permiso', 'label_fr' => 'État de votre demande', 'url' => 'es/permisos-de-conducir/obtencion-y-gestion-de-permisos/estado-de-la-tramitacion-del-permiso'],
                        ],
                    ],
                    [
                        'label' => 'Dirección para notificaciones',
                        'label_fr' => 'Changement d’adresse',
                        'url' => 'es/permisos-de-conducir/direccion-para-notificaciones',
                    ],
                ],
            ],
            [
                'label' => 'Vehículos',
                'label_fr' => 'Véhicules',
                'url' => 'es/vehiculos',
                'children' => [
                    ['label' => 'Gestión de vehículos', 'label_fr' => 'Gestion des véhicules', 'url' => 'es/vehiculos'],
                    ['label' => 'Informe de un vehículo', 'label_fr' => 'Rapport sur un véhicule', 'url' => 'es/vehiculos/informacion-de-vehiculos/informe-de-un-vehiculo'],
                    ['label' => 'Pago de tasas', 'label_fr' => 'Paiement des taxes', 'url' => 'es/otros-tramites/pago-de-tasas'],
                ],
            ],
            [
                'label' => 'Autorizaciones, obras y usos excepcionales de la vía',
                'label_fr' => 'Autorisations, travaux et usages exceptionnels de la route',
                'url' => 'nuestros-servicios/autorizaciones-obras-y-usos-excepcionales-de-la-via',
            ],
            ['label' => 'Para colaboradores, empresas y profesionales', 'label_fr' => 'Pour les collaborateurs, les entreprises et les professionnels', 'url' => 'nuestros-servicios/para-colaboradores-y-empresas'],
            ['label' => 'Para ayuntamientos y otras administraciones', 'label_fr' => 'Pour les municipalités et autres administrations', 'url' => 'nuestros-servicios/para-ayuntamientos-y-otras-administraciones'],
            ['label' => 'Atención a víctimas de siniestros', 'label_fr' => 'Assistance aux victimes d’accidents', 'url' => 'nuestros-servicios/atencion-a-victimas-de-siniestros'],
            ['label' => 'Centro de documentación', 'label_fr' => 'Centre de documentation', 'url' => 'nuestros-servicios/centro-de-documentacion'],
        ],
    ],
    [
        'label' => 'Muévete con seguridad',
        'label_fr' => 'Déplacez-vous avec confiance',
        'url' => 'muevete-con-seguridad',
        'children' => [
            ['label' => 'Vías más seguras', 'label_fr' => 'Routes plus sûres', 'url' => 'muevete-con-seguridad/vias-mas-seguras'],
            [
                'label' => 'Tecnología e innovación en carretera',
                'label_fr' => 'Technologie et innovation routière',
                'url' => 'muevete-con-seguridad/tecnologia-e-innovacion-en-carretera',
                'children' => [
                    ['label' => 'DGT 3.0', 'url' => 'muevete-con-seguridad/tecnologia-e-innovacion-en-carretera/dgt-3-0'],
                    ['label' => 'Sistemas Inteligentes de Transporte (ITS)', 'url' => 'muevete-con-seguridad/tecnologia-e-innovacion-en-carretera/sistemas-inteligentes-de-transporte-its'],
                    ['label' => 'Dispositivos de preseñalización V16', 'url' => 'muevete-con-seguridad/tecnologia-e-innovacion-en-carretera/dispositivos-de-presenalizacion-v16'],
                ],
            ],
            ['label' => 'Vehículos seguros', 'url' => 'muevete-con-seguridad/vehiculos-seguros'],
            ['label' => 'Sistemas avanzados de ayuda a la conducción (ADAS)', 'url' => 'muevete-con-seguridad/sistemas-avanzados-de-ayuda-a-la-conduccion-adas'],
            ['label' => 'Evita conductas de riesgo', 'url' => 'muevete-con-seguridad/evita-conductas-de-riesgo'],
            ['label' => 'Viaja seguro', 'url' => 'muevete-con-seguridad/viaja-seguro'],
            ['label' => 'Consejos para conductores', 'url' => 'muevete-con-seguridad/consejos-para-conductores'],
            ['label' => 'Qué hacer ante un accidente de tráfico', 'url' => 'muevete-con-seguridad/que-hacer-ante-un-accidente-de-trafico'],
            ['label' => 'Conoce las normas de Tráfico', 'url' => 'muevete-con-seguridad/conoce-las-normas-de-trafico'],
            ['label' => 'Seguridad vial laboral', 'url' => 'muevete-con-seguridad/seguridad-vial-laboral'],
        ],
    ],
    [
        'label' => 'Estado del tráfico',
        'label_fr' => 'Conditions de circulation',
        'url' => 'conoce-el-estado-del-trafico',
        'children' => [
            ['label' => 'Información e incidencias de tráfico', 'url' => 'conoce-el-estado-del-trafico/informacion-e-incidencias-de-trafico'],
            ['label' => 'Cámaras de tráfico', 'url' => 'conoce-el-estado-del-trafico/camaras-de-trafico'],
            ['label' => 'Carriles BUS-VAO', 'url' => 'conoce-el-estado-del-trafico/carriles-bus-vao'],
            ['label' => 'Recomendaciones de tráfico', 'url' => 'conoce-el-estado-del-trafico/recomendaciones-de-trafico'],
            ['label' => 'Restricciones a la circulación', 'url' => 'conoce-el-estado-del-trafico/restricciones-a-la-circulacion'],
            ['label' => 'Vigilancia y control', 'url' => 'conoce-el-estado-del-trafico/vigilancia-y-control'],
            ['label' => 'Rutas de interés', 'url' => 'conoce-el-estado-del-trafico/rutas-de-interes'],
            ['label' => 'El tráfico en Europa', 'url' => 'conoce-el-estado-del-trafico/el-trafico-en-europa'],
        ],
    ],
    [
        'label' => 'Conoce la DGT',
        'label_fr' => 'Découvrez la DGT',
        'url' => 'conoce-la-dgt',
        'children' => [
            [
                'label' => 'Quiénes somos',
                'label_fr' => 'Qui sommes-nous',
                'url' => 'conoce-la-dgt/quienes-somos',
                'children' => [
                    ['label' => 'Nuestros valores', 'label_fr' => 'Nos valeurs', 'url' => 'conoce-la-dgt/quienes-somos/nuestros-valores'],
                    ['label' => 'Estructura y funciones', 'label_fr' => 'Structure et fonctions', 'url' => 'conoce-la-dgt/quienes-somos/estructura'],
                    ['label' => 'Historia', 'label_fr' => 'Histoire', 'url' => 'conoce-la-dgt/quienes-somos/historia'],
                ],
            ],
            ['label' => 'Dónde estamos', 'url' => 'conoce-la-dgt/donde-estamos'],
            ['label' => 'Qué hacemos', 'url' => 'conoce-la-dgt/que-hacemos'],
            ['label' => 'Con quién trabajamos', 'url' => 'conoce-la-dgt/con-quien-trabajamos'],
        ],
    ],
    [
        'label' => 'Comunicación',
        'label_fr' => 'Communication',
        'url' => 'comunicacion',
        'children' => [
            ['label' => 'Notas de prensa', 'url' => 'comunicacion/notas-de-prensa'],
            ['label' => 'Información de interés', 'url' => 'comunicacion/informacion-de-interes'],
            ['label' => 'Eventos', 'url' => 'comunicacion/eventos'],
            ['label' => 'Campañas', 'url' => 'comunicacion/campanas'],
            ['label' => 'Encuentros digitales', 'url' => 'comunicacion/encuentros-digitales'],
            ['label' => 'Boletín radiofónico', 'url' => 'comunicacion/boletin-radiofonico'],
            ['label' => 'Revista Tráfico y Seguridad Vial', 'url' => 'comunicacion/revista-trafico-y-seguridad-vial'],
            ['label' => 'DGT en redes sociales', 'url' => 'comunicacion/dgt-en-redes-sociales'],
        ],
    ],
];
