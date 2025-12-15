<?php
declare(strict_types = 1);

return [
    \HGON\HgonDonation\Domain\Model\Pages::class => [
        'tableName' => 'pages',
        'properties' => [
            'uid'         => ['fieldName' => 'uid'],
            'pid'         => ['fieldName' => 'pid'],
            'sorting'     => ['fieldName' => 'sorting'],
            'title'       => ['fieldName' => 'title'],
            'subtitle'    => ['fieldName' => 'subtitle'],
            'noSearch'    => ['fieldName' => 'no_search'],
            'crdate'      => ['fieldName' => 'crdate'],
            'tstamp'      => ['fieldName' => 'tstamp'],
            'hidden'      => ['fieldName' => 'hidden'],
            'deleted'     => ['fieldName' => 'deleted'],
            'lastUpdated' => ['fieldName' => 'lastUpdated'], // nur behalten, wenn Feld wirklich existiert
            // 'txRkwprojectsProject' => ['fieldName' => 'tx_rkwprojects_project_uid'],
        ],
    ],
];


