<?php
namespace App\buildcommerce\Helpers;

class resize
{
    protected static $sizes = [
        'avatar' => [
            'dir' => 'uploads/avatars',
            'width' => 80,
            'height' => 80,
            'method' => 'resize',
            'watermark' => 'resize'
        ],
        'product' => [
            'dir' => 'uploads/products',
            'width' => '',
            'height' => '',
            'method' => '',
            'watermark' => ''
        ],
        'mainProduct' => [
            'dir' => 'uploads/products',
            'width' => '',
            'height' => '',
            'method' => '',
            'watermark' => ''
        ],
        'storeImage' => [
            'dir' => 'uploads/store_images',
            'width' => '',
            'height' => '',
            'method' => '',
            'watermark' => ''
        ]
    ];
}