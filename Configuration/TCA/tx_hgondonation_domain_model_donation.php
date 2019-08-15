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
		'requestUpdate' => 'type',
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
		'searchFields' => 'type,title,short_description,description,image,link,donation_type_time,donation_type_money, time_range_start, time_range_end, tx_rkwproject_project',
		'iconfile' => 'EXT:hgon_donation/Resources/Public/Icons/tx_hgondonation_domain_model_donation.gif'
	],
	'interface' => [
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, type, title, short_description, description, image, link, donation_type_time, donation_type_money, time_range_start, time_range_end, tx_rkwproject_project',
	],
	'types' => [
		'1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, type, time_range_start, time_range_end, title, short_description, description, image, link, donation_type_time, donation_type_money, tx_rkwproject_project, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
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
				'items' => [
					['LLL:EXT:hgon_donation/Resources/Private/Language/locallang_db.xlf:tx_hgondonation_domain_model_donation.type.select', 0],
					['LLL:EXT:hgon_donation/Resources/Private/Language/locallang_db.xlf:tx_hgondonation_domain_model_donation.type.time', 1],
					['LLL:EXT:hgon_donation/Resources/Private/Language/locallang_db.xlf:tx_hgondonation_domain_model_donation.type.money', 2],
					['LLL:EXT:hgon_donation/Resources/Private/Language/locallang_db.xlf:tx_hgondonation_domain_model_donation.type.link', 3],
				],
			]
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
			'displayCond' => 'FIELD:type:>:0',
		],
		'link' => [
			'exclude' => true,
			'label' => 'LLL:EXT:hgon_donation/Resources/Private/Language/locallang_db.xlf:tx_hgondonation_domain_model_donation.link',
			'config' => [
				'type' => 'input',
				'size' => '50',
				'max' => '1024',
				'eval' => 'trim, required',
				'wizards' => [
					'link' => [
						'type' => 'popup',
						'title' => 'LLL:EXT:cms/locallang_ttc.xlf:header_link_formlabel',
						'icon' => 'link_popup.gif',
						'module' => [
							'name' => 'wizard_element_browser',
							'urlParameters' => [
								'mode' => 'wizard'
							]
						],
						'JSopenParams' => 'height=300,width=500,status=0,menubar=0,scrollbars=1'
					]
				],
				'softref' => 'typolink'
			],
			'displayCond' => 'FIELD:type:=:3',
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
        'time_range_end' => [
            'exclude' => true,
            'label' => 'LLL:EXT:hgon_donation/Resources/Private/Language/locallang_db.xlf:tx_hgondonation_domain_model_donation.time_range_end',
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
        ],
	],
];
