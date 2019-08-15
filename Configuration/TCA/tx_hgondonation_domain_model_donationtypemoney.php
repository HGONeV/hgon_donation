<?php
return [
	'ctrl' => [
		'hideTable' => 1,
		'title'	=> 'LLL:EXT:hgon_donation/Resources/Private/Language/locallang_db.xlf:tx_hgondonation_domain_model_donationtypemoney',
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
		'searchFields' => 'title,short_description,description,image,donation_goal,donation_amount_current,donator_count,frontend_user_to_inform',
		'iconfile' => 'EXT:hgon_donation/Resources/Public/Icons/tx_hgondonation_domain_model_donationtypemoney.gif'
	],
	'interface' => [
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, short_description, description, image, donation_goal, donation_amount_current, donator_count, frontend_user_to_inform',
	],
	'types' => [
		'1' => [
		    //'showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, short_description, description, image, donation_goal, donation_amount_current, donator_count, frontend_user_to_inform, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'
            'showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, image, donation_goal, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'
        ],
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
				'foreign_table' => 'tx_hgondonation_domain_model_donationtypemoney',
				'foreign_table_where' => 'AND tx_hgondonation_domain_model_donationtypemoney.pid=###CURRENT_PID### AND tx_hgondonation_domain_model_donationtypemoney.sys_language_uid IN (-1,0)',
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
			'label' => 'LLL:EXT:hgon_donation/Resources/Private/Language/locallang_db.xlf:tx_hgondonation_domain_model_donationtypemoney.title',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
		],
		'short_description' => [
			'exclude' => true,
			'label' => 'LLL:EXT:hgon_donation/Resources/Private/Language/locallang_db.xlf:tx_hgondonation_domain_model_donationtypemoney.short_description',
			'config' => [
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			]
		],
		'description' => [
			'exclude' => true,
			'label' => 'LLL:EXT:hgon_donation/Resources/Private/Language/locallang_db.xlf:tx_hgondonation_domain_model_donationtypemoney.description',
			'config' => [
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			]
		],
		'image' => [
			'exclude' => true,
			'label' => 'LLL:EXT:hgon_donation/Resources/Private/Language/locallang_db.xlf:tx_hgondonation_domain_model_donationtypemoney.image',
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
		'donation_goal' => [
			'exclude' => true,
			'label' => 'LLL:EXT:hgon_donation/Resources/Private/Language/locallang_db.xlf:tx_hgondonation_domain_model_donationtypemoney.donation_goal',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
		],
		'donation_amount_current' => [
			'exclude' => true,
			'label' => 'LLL:EXT:hgon_donation/Resources/Private/Language/locallang_db.xlf:tx_hgondonation_domain_model_donationtypemoney.donation_amount_current',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'readOnly' => true
			],
		],
		'donator_count' => [
			'exclude' => true,
			'label' => 'LLL:EXT:hgon_donation/Resources/Private/Language/locallang_db.xlf:tx_hgondonation_domain_model_donationtypemoney.donator_count',
			'config' => [
				'type' => 'input',
				'size' => 4,
				'eval' => 'int',
				'readOnly' => true
			]
		],
		'frontend_user_to_inform' => [
			'exclude' => true,
			'label' => 'LLL:EXT:hgon_donation/Resources/Private/Language/locallang_db.xlf:tx_hgondonation_domain_model_donationtypemoney.frontend_user_to_inform',
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

		'donation_type' => [
			'config' => [
				'type' => 'passthrough',
			],
		],
	],
];
