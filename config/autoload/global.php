<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return [
    'uploads' => [
        'images' => [
            'path' => './public/uploads/images/',
            'presets' => [
                // to do set resolution
                'medium' => ['x' => 600,'y' => 480, 'crop' => true],
                'preview' => ['x' => 200,'y' => 160,  'crop' => true],
                'small' => ['x' => 100,'y' => 80, 'crop' => true],
            ],
        ],
        'product' => [
            'path' => './public/uploads/product/',
            'presets' => [
                // to do set resolution
                'medium' => ['x' => 600,'y' => 480, 'crop' => true],
                'preview' => ['x' => 200,'y' => 160,  'crop' => true],
                'small' => ['x' => 100,'y' => 80, 'crop' => true],
            ],
        ],
        'category' => [
            'path' => './public/uploads/category/',
            'presets' => [
                // to do set resolution
                'preview' => ['x' => 283,'y' => 148, 'crop' => true],
            ],
        ],
        'our-work' => [
            'path' => './public/uploads/our-work/',
            'presets' => [
                // to do set resolution
                'medium' => ['x' => 600,'y' => 321, 'crop' => true],
                'preview' => ['x' => 200,'y' => 160,  'crop' => true],
                'small' => ['x' => 100,'y' => 80, 'crop' => true],
            ],
        ],
    ],
];
