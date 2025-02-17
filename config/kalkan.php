<?php

return [
    'ncanode' => [
        'host' => env('NCANODE_HOST', 'http://naneds.ayu.edu.kz:14579'),
    ],
    'links' => [
        'prefix' => 'mobileSign:',
        'mobile' => 'https://mgovsign.page.link/?link=%s&isi=1476128386&ibi=kz.egov.mobile&apn=kz.mobile.mgov',
        'business' => 'https://egovbusiness.page.link/?link=%s&isi=1597880144&ibi=kz.mobile.mgov.business&apn=kz.mobile.mgov.business',
    ],
    'actions' => [
        'store-document' => 'store-document',
        'store-request' => 'store-request',
        'generate-qr-code' => 'generate-qr-code',
        'generate-cross-link' => 'generate-cross-link',
        'generate-service-link' => 'generate-service-link',
        'prepare-content' => 'prepare-content',
        'process-content' => 'process-content',
        'check-document' => 'check-document',
        'check-request' => 'check-request',
    ],
    'options' => [
        'description' => 'Test',
        'organisation' => [
            'nameRu' => 'АО "ТЕСТ"',
            'nameKz' => '"ТЕСТ" ЖК',
            'nameEn' => 'OP "TEST"',
            'bin' => '123456789012',
        ],
        'ttl' => 180,
    ],
];
