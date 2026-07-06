<?php

declare(strict_types=1);

use HGON\HgonDonation\Domain\Model\Project;
use Mediadreams\MdNewsAuthor\Domain\Model\NewsAuthor;

return [
    Project::class => [
        'tableName' => 'tx_hgondonation_domain_model_project',
        'properties' => [
            'contactPerson' => [
                'fieldName' => 'contact_person',
            ],
        ],
    ],
    NewsAuthor::class => [
        'tableName' => 'tx_mdnewsauthor_domain_model_newsauthor',
    ],
];
