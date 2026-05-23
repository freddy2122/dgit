<?php

/**
 * Catalogue des taxes DGT (gestoría) — montants indicatifs, modifiables à l’attribution.
 */
return [
    'presets' => [
        'obtencion_b' => [
            'label' => 'Taxe obtention permis B (examen)',
            'amount' => 28.87,
            'reference_prefix' => 'OBT',
        ],
        'renovacion' => [
            'label' => 'Taxe renouvellement permis de conduire',
            'amount' => 23.50,
            'reference_prefix' => 'REN',
        ],
        'duplicado' => [
            'label' => 'Taxe duplicata permis',
            'amount' => 20.50,
            'reference_prefix' => 'DUP',
        ],
        'canje' => [
            'label' => 'Taxe échange permis étranger',
            'amount' => 28.87,
            'reference_prefix' => 'CAN',
        ],
        'internacional' => [
            'label' => 'Taxe permis international',
            'amount' => 10.00,
            'reference_prefix' => 'INT',
        ],
        'certificado_aptitud' => [
            'label' => 'Certificat médical / aptitude',
            'amount' => 15.00,
            'reference_prefix' => 'APT',
        ],
        'examen_teorico' => [
            'label' => 'Taxe examen théorique',
            'amount' => 23.00,
            'reference_prefix' => 'TEO',
        ],
        'ampliacion' => [
            'label' => 'Taxe extension de catégorie',
            'amount' => 28.87,
            'reference_prefix' => 'AMP',
        ],
        'informe_vehiculo' => [
            'label' => 'Taxe informe / rapport véhicule',
            'amount' => 9.05,
            'reference_prefix' => 'VEH',
        ],
        'tasa_administrativa' => [
            'label' => 'Taxe administrative générale',
            'amount' => 12.00,
            'reference_prefix' => 'ADM',
        ],
    ],
];
