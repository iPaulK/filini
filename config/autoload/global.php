<?php
use Zend\Cache\Storage\Adapter\Filesystem;
use Zend\Session\Storage\SessionArrayStorage;
use Zend\Session\Validator\RemoteAddr;
use Zend\Session\Validator\HttpUserAgent;

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
    // Session configuration.
    'session_config' => [
        'cookie_lifetime' => 60*60*1, // Session cookie will expire in 1 hour.
        'gc_maxlifetime' => 60*60*24*30, // How long to store session data on server (for 1 month).        
    ],
    // Session manager configuration.
    'session_manager' => [
        // Session validators (used for security).
        'validators' => [
            RemoteAddr::class,
            HttpUserAgent::class,
        ]
    ],
    // Session storage configuration.
    'session_storage' => [
        'type' => SessionArrayStorage::class
    ],
    // Cache config
    'caches' => [
        'FilesystemCache' => [
            'adapter' => [
                'name'    => Filesystem::class,
                'options' => [
                    // Store cached data in this directory.
                    'cache_dir' => './data/cache',
                    // Store cached data for 1 hour.
                    'ttl' => 60*60*1 
                ],
            ],
            'plugins' => [
                [
                    'name' => 'serializer',
                    'options' => [
                    ],
                ],
            ],
        ],
    ],
    // Uploads config
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
                '245x160' => ['x' => 245,'y' => 160,  'crop' => true],
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
