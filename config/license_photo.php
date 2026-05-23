<?php

/**
 * Photo permis de conduire — Espagne (DGT).
 * Format officiel : 26 mm × 32 mm (largeur × hauteur).
 */
return [
    'width_mm' => 26,
    'height_mm' => 32,

    /** Cible stockage (~12 px/mm, ratio 26:32). */
    'target_width' => 312,
    'target_height' => 384,

    /** Minimum à l’upload (~80 % de la cible). */
    'min_width' => 250,
    'min_height' => 308,

    'jpeg_quality' => 88,
];
