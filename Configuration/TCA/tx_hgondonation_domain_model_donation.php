<?php
return [
	'ctrl' => [
		'title'	=> 'LLL:EXT:hgon_donation/Resources/Private/Language/locallang_db.xlf:tx_hgondonation_domain_model_donation',
		'label' => 'title',
		'label_alt' => 'short_description',
		'label_alt_force' => true,
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'versioningWS' => true,
		'sortby' => 'sorting',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => [
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		],
		'searchFields' => 'type,title,short_description,description,image,link,time_range_start, time_range_end, tx_rkwproject_project, time_requirement, donation_place',
		'iconfile' => 'EXT:hgon_donation/Resources/Public/Icons/tx_hgondonation_domain_model_donation.gif'
	],
	'types' => [
		'1' => ['showitem' => 'sys_language_uid, l10n_diffsource, hidden, type, time_range_start, time_range_end, title, short_description, description, time_requirement, donation_place, image, link, tx_rkwproject_project, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
	],
	'columns' => [
		'sys_language_uid' => [
			'exclude' => true,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'special' => 'languages',
				'items' => [
					[
						'LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages',
						-1,
						'flags-multiple'
					]
				],
				'default' => 0,
			],
		],
		'l10n_parent' => [
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => [
					['', 0],
				],
				'foreign_table' => 'tx_hgondonation_domain_model_donation',
				'foreign_table_where' => 'AND tx_hgondonation_domain_model_donation.pid=###CURRENT_PID### AND tx_hgondonation_domain_model_donation.sys_language_uid IN (-1,0)',
			],
		],
		'l10n_diffsource' => [
			'config' => [
				'type' => 'passthrough',
			],
		],
		't3ver_label' => [
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			],
		],
		'hidden' => [
			'exclude' => true,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
			'config' => [
				'type' => 'check',
				'items' => [
					'1' => [
						'0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
					]
				],
			],
		],
		'starttime' => [
			'exclude' => true,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 13,
                'eval' => 'datetime',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
		],
		'endtime' => [
			'exclude' => true,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 13,
                'eval' => 'datetime',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
		],
		'type' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:hgon_donation/Resources/Private/Language/locallang_db.xlf:tx_hgondonation_domain_model_donation.type',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'size' => 1,
				'eval' => 'int, required',
				'minitems' => 0,
				'maxitems' => 1,
                'default' => 0,
				'items' => [
					['LLL:EXT:hgon_donation/Resources/Private/Language/locallang_db.xlf:tx_hgondonation_domain_model_donation.type.select', 0],
					['LLL:EXT:hgon_donation/Resources/Private/Language/locallang_db.xlf:tx_hgondonation_domain_model_donation.type.time', 1],
					['LLL:EXT:hgon_donation/Resources/Private/Language/locallang_db.xlf:tx_hgondonation_domain_model_donation.type.money', 2],
					//['LLL:EXT:hgon_donation/Resources/Private/Language/locallang_db.xlf:tx_hgondonation_domain_model_donation.type.link', 3],
				],
			],
            'onChange' => 'reload'
		],
		'title' => [
			'exclude' => true,
			'label' => 'LLL:EXT:hgon_donation/Resources/Private/Language/locallang_db.xlf:tx_hgondonation_domain_model_donation.title',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim, required'
			],
			'displayCond' => 'FIELD:type:>:0',
		],
		'short_description' => [
			'exclude' => true,
			'label' => 'LLL:EXT:hgon_donation/Resources/Private/Language/locallang_db.xlf:tx_hgondonation_domain_model_donation.short_description',
			'config' => [
				'type' => 'text',
				'cols' => 40,
				'rows' => 5,
				'eval' => 'trim'
			],
			'displayCond' => 'FIELD:type:>:0',
		],
		'description' => [
			'exclude' => true,
			'label' => 'LLL:EXT:hgon_donation/Resources/Private/Language/locallang_db.xlf:tx_hgondonation_domain_model_donation.description',
			'config' => [
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim, required',
				'enableRichtext' => true,
			],
			'displayCond' => 'FIELD:type:>:0',
		],
		'image' => [
			'exclude' => true,
			'label' => 'LLL:EXT:hgon_donation/Resources/Private/Language/locallang_db.xlf:tx_hgondonation_domain_model_donation.image',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'image',
                array(
                    'minitems' => 0,
                    'maxitems' => 1,
                    'overrideChildTca' => [
                        'types' => [
                            \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                                'showitem' => '
                    --palette--;LLL:EXT:lang/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                    --palette--;;filePalette'
                            ],
                        ],
                    ],
                ),
                'jpg, jpeg, png, gif'
            ),
			'displayCond' => 'FIELD:type:>:0',
		],
        'link' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_donation/Resources/Private/Language/locallang_db.xlf:tx_hgondonation_domain_model_donation.link',
            'displayCond' => 'FIELD:type:=:3',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputLink',
                'size' => 50,
                'max' => 1024,
                'eval' => 'trim,required',
                'softref' => 'typolink',
                'fieldControl' => [
                    'linkPopup' => [
                        'options' => [
                            'title' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:header_link_formlabel',
                        ],
                    ],
                ],
            ],
        ],
		'donation_type_time' => [
			'exclude' => true,
			'label' => 'LLL:EXT:hgon_donation/Resources/Private/Language/locallang_db.xlf:tx_hgondonation_domain_model_donation.donation_type_time',
			'config' => [
				'type' => 'inline',
				'foreign_table' => 'tx_hgondonation_domain_model_donationtypetime',
				'foreign_field' => 'donation_type',
				'minitems' => 1,
				'maxitems' => 1,
				'appearance' => [
					'collapseAll' => 0,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				],
			],
			'displayCond' => 'FIELD:type:=:1',
		],
		'donation_type_money' => [
			'exclude' => true,
			'label' => 'LLL:EXT:hgon_donation/Resources/Private/Language/locallang_db.xlf:tx_hgondonation_domain_model_donation.donation_type_money',
			'config' => [
				'type' => 'inline',
				'foreign_table' => 'tx_hgondonation_domain_model_donationtypemoney',
				'foreign_field' => 'donation_type',
				'minitems' => 1,
				'maxitems' => 1,
				'appearance' => [
					'collapseAll' => 0,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				],
			],
			'displayCond' => 'FIELD:type:=:2',
		],
        'typolink' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:hgon_donation/Resources/Private/Language/locallang_db.xlf:tx_hgondonation_domain_model_donation.typolink',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputLink',
            ],
        ],
        'pages' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_donation/Resources/Private/Language/locallang_db.xlf:tx_hgondonation_domain_model_donation.pages',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'pages',
                'minitems' => 0,
                'maxitems' => 1,
                'readOnly' => 1,
            ],
        ],
        'time_range_start' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_donation/Resources/Private/Language/locallang_db.xlf:tx_hgondonation_domain_model_donation.time_range_start',
            'displayCond' => 'FIELD:type:=:1',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 13,
                'eval' => 'datetime',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],
        'time_range_end' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_donation/Resources/Private/Language/locallang_db.xlf:tx_hgondonation_domain_model_donation.time_range_end',
            'displayCond' => 'FIELD:type:=:1',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 13,
                'eval' => 'datetime',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],
        'tx_rkwproject_project' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_donation/Resources/Private/Language/locallang_db.xlf:tx_hgondonation_domain_model_donation.tx_rkwproject_project',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_rkwprojects_domain_model_projects',
                'foreign_table_where' => 'AND ((\'###PAGE_TSCONFIG_IDLIST###\' <> \'0\' AND FIND_IN_SET(tx_rkwprojects_domain_model_projects.pid,\'###PAGE_TSCONFIG_IDLIST###\')) OR (\'###PAGE_TSCONFIG_IDLIST###\' = \'0\')) AND tx_rkwprojects_domain_model_projects.sys_language_uid = ###REC_FIELD_sys_language_uid### ORDER BY tx_rkwprojects_domain_model_projects.short_name ASC',
                'maxitems'      => 1,
                'minitems'      => 1,
                'size'          => 5,
            ],
            'displayCond' => 'FIELD:type:>:0',
        ],
        'time_requirement' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_donation/Resources/Private/Language/locallang_db.xlf:tx_hgondonation_domain_model_donation.time_requirement',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
            'displayCond' => 'FIELD:type:=:1',
        ],
        'donation_place' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_donation/Resources/Private/Language/locallang_db.xlf:tx_hgondonation_domain_model_donation.donation_place',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_hgondonation_domain_model_donationplace',
                'minitems' => 0,
                'maxitems' => 9999,
                'appearance' => [
                    'collapseAll' => 0,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1
                ],
            ],
            'displayCond' => 'FIELD:type:=:1',
        ],
	],
];
