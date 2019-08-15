<?php
return [
	'ctrl' => [
        'hideTable' => 1,
		'title'	=> 'LLL:EXT:hgon_donation/Resources/Private/Language/locallang_db.xlf:tx_hgondonation_domain_model_donationtypetime',
		'label' => 'title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'versioningWS' => true,
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => [
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		],
		'searchFields' => 'title,short_description,description,type,time_requirement,recurring,image,contact_person,finished,helpers_feedback,helpers_image,donation_place,frontend_user,max_num_frontend_user',
		'iconfile' => 'EXT:hgon_donation/Resources/Public/Icons/tx_hgondonation_domain_model_donationtypetime.gif'
	],
	'interface' => [
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, short_description, description, type, time_requirement, recurring, image, contact_person, finished, helpers_feedback, helpers_image, donation_place, frontend_user, max_num_frontend_user',
	],
	'types' => [
	//	'1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, short_description, description, type, time_requirement, time_range_start, time_range_end, recurring, image, contact_person, finished, helpers_feedback, helpers_image, donation_place, frontend_user, max_num_frontend_user, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
        '1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, time_requirement, donation_place, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
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
			'exclude' => true,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => [
					['', 0],
				],
				'foreign_table' => 'tx_hgondonation_domain_model_donationtypetime',
				'foreign_table_where' => 'AND tx_hgondonation_domain_model_donationtypetime.pid=###CURRENT_PID### AND tx_hgondonation_domain_model_donationtypetime.sys_language_uid IN (-1,0)',
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
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
			'config' => [
				'type' => 'input',
				'size' => 13,
				'eval' => 'datetime',
				'default' => 0,
			]
		],
		'endtime' => [
			'exclude' => true,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
			'config' => [
				'type' => 'input',
				'size' => 13,
				'eval' => 'datetime',
				'default' => 0,
				'range' => [
					'upper' => mktime(0, 0, 0, 1, 1, 2038)
				]
			],
		],
		'title' => [
			'exclude' => true,
			'label' => 'LLL:EXT:hgon_donation/Resources/Private/Language/locallang_db.xlf:tx_hgondonation_domain_model_donationtypetime.title',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
		],
		'short_description' => [
			'exclude' => true,
			'label' => 'LLL:EXT:hgon_donation/Resources/Private/Language/locallang_db.xlf:tx_hgondonation_domain_model_donationtypetime.short_description',
			'config' => [
				'type' => 'text',
				'cols' => 40,
				'rows' => 5,
				'eval' => 'trim'
			]
		],
		'description' => [
			'exclude' => true,
			'label' => 'LLL:EXT:hgon_donation/Resources/Private/Language/locallang_db.xlf:tx_hgondonation_domain_model_donationtypetime.description',
			'config' => [
				'type' => 'text',
				'cols' => 40,
				'rows' => 10,
				'eval' => 'trim'
			]
		],
		'type' => [
			'exclude' => true,
			'label' => 'LLL:EXT:hgon_donation/Resources/Private/Language/locallang_db.xlf:tx_hgondonation_domain_model_donationtypetime.type',
			'config' => [
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			]
		],
		'time_requirement' => [
			'exclude' => true,
			'label' => 'LLL:EXT:hgon_donation/Resources/Private/Language/locallang_db.xlf:tx_hgondonation_domain_model_donationtypetime.time_requirement',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
		],
		'recurring' => [
			'exclude' => true,
			'label' => 'LLL:EXT:hgon_donation/Resources/Private/Language/locallang_db.xlf:tx_hgondonation_domain_model_donationtypetime.recurring',
			'config' => [
				'type' => 'check',
				'items' => [
					'1' => [
						'0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
					]
				],
				'default' => 0
			]
		],
		'image' => [
			'exclude' => true,
			'label' => 'LLL:EXT:hgon_donation/Resources/Private/Language/locallang_db.xlf:tx_hgondonation_domain_model_donationtypetime.image',
			'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
				'image',
				[
					'appearance' => [
						'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:images.addFileReference'
					],
					'foreign_types' => [
						'0' => [
							'showitem' => '
							--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
							--palette--;;filePalette'
						],
						\TYPO3\CMS\Core\Resource\File::FILETYPE_TEXT => [
							'showitem' => '
							--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
							--palette--;;filePalette'
						],
						\TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
							'showitem' => '
							--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
							--palette--;;filePalette'
						],
						\TYPO3\CMS\Core\Resource\File::FILETYPE_AUDIO => [
							'showitem' => '
							--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
							--palette--;;filePalette'
						],
						\TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => [
							'showitem' => '
							--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
							--palette--;;filePalette'
						],
						\TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => [
							'showitem' => '
							--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
							--palette--;;filePalette'
						]
					],
					'maxitems' => 1
				],
				$GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
			),
		],
		'contact_person' => [
			'exclude' => true,
			'label' => 'LLL:EXT:hgon_donation/Resources/Private/Language/locallang_db.xlf:tx_hgondonation_domain_model_donationtypetime.contact_person',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectMultipleSideBySide',
				'size' => 8,
				'foreign_table' => 'tx_rkwauthors_domain_model_authors',
				'foreign_sortby' => 'last_name',
				'minitems' => 1,
				'maxitems' => 9999,
				'appearance' => [
					'collapseAll' => 1,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				],
			],
		],
		'finished' => [
			'exclude' => true,
			'label' => 'LLL:EXT:hgon_donation/Resources/Private/Language/locallang_db.xlf:tx_hgondonation_domain_model_donationtypetime.finished',
			'config' => [
				'type' => 'check',
				'items' => [
					'1' => [
						'0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
					]
				],
				'default' => 0
			]
		],
		'helpers_feedback' => [
			'exclude' => true,
			'label' => 'LLL:EXT:hgon_donation/Resources/Private/Language/locallang_db.xlf:tx_hgondonation_domain_model_donationtypetime.helpers_feedback',
			'config' => [
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			]
		],
		'helpers_image' => [
			'exclude' => true,
			'label' => 'LLL:EXT:hgon_donation/Resources/Private/Language/locallang_db.xlf:tx_hgondonation_domain_model_donationtypetime.helpers_image',
			'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
				'helpers_image',
				[
					'appearance' => [
						'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:images.addFileReference'
					],
					'foreign_types' => [
						'0' => [
							'showitem' => '
							--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
							--palette--;;filePalette'
						],
						\TYPO3\CMS\Core\Resource\File::FILETYPE_TEXT => [
							'showitem' => '
							--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
							--palette--;;filePalette'
						],
						\TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
							'showitem' => '
							--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
							--palette--;;filePalette'
						],
						\TYPO3\CMS\Core\Resource\File::FILETYPE_AUDIO => [
							'showitem' => '
							--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
							--palette--;;filePalette'
						],
						\TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => [
							'showitem' => '
							--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
							--palette--;;filePalette'
						],
						\TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => [
							'showitem' => '
							--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
							--palette--;;filePalette'
						]
					],
					'maxitems' => 9999
				],
				$GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
			),
		],
		'donation_place' => [
			'exclude' => true,
			'label' => 'LLL:EXT:hgon_donation/Resources/Private/Language/locallang_db.xlf:tx_hgondonation_domain_model_donationtypetime.donation_place',
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
		],
		'frontend_user' => [
			'exclude' => true,
			'label' => 'LLL:EXT:hgon_donation/Resources/Private/Language/locallang_db.xlf:tx_hgondonation_domain_model_donationtypetime.frontend_user',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectMultipleSideBySide',
				'size' => 8,
				'foreign_table' => 'fe_users',
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
		],
		'max_num_frontend_user' => [
			'exclude' => true,
			'label' => 'LLL:EXT:hgon_donation/Resources/Private/Language/locallang_db.xlf:tx_hgondonation_domain_model_donationtypetime.max_num_frontend_user',
			'config' => [
				'type' => 'input',
				'size' => 10,
				'eval' => 'int, trim',
				'range' => [
					'lower' => 1,
					'upper' => 10,
				],
					'default' => 1,
					'slider' => [
					'step' => 1,
					'width' => 200,
				],
			]
		],
        'pages' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_donation/Resources/Private/Language/locallang_db.xlf:tx_hgondonation_domain_model_donationtypetime.pages',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputLink',
            ],
        ],

		'donation_type' => [
			'config' => [
				'type' => 'passthrough',
			],
		],
	],
];
