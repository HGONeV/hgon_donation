<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
	function($extKey)
	{
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'HGON.HgonDonation',
            'Listing',
            [
                'Donation' => 'list, newMoney, createMoney, executeSepa'
            ],
            // non-cacheable actions
            [
                'Donation' => 'list, newMoney, createMoney, executeSepa'
            ]
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'HGON.HgonDonation',
            'Detail',
            [
                'Donation' => 'show, new, create'
                //'Donation' => 'list, show, new, create, edit, update, delete'
            ],
            // non-cacheable actions
            [
                'Donation' => 'show, new, create'
            ]
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'HGON.HgonDonation',
            'BankAccountSidebar',
            [
                'Donation' => 'bankAccountSidebar'
            ],
            // non-cacheable actions
            [
                'Donation' => ''
            ]
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'HGON.HgonDonation',
            'DonationProject',
            [
                'Donation' => 'donationProject'
            ],
            // non-cacheable actions
            [
                'Donation' => 'donationProject'
            ]
        );

		\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
			'HGON.HgonDonation',
			'Donate',
			[
				'Standard' => 'listDonationTime, newDonationTime, createDonationTime'
				//'Donation' => 'list, show, new, create, edit, update, delete'
			],
			// non-cacheable actions
			[
				'Standard' => 'listDonationTime, newDonationTime, createDonationTime'
			]
		);

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'HGON.HgonDonation',
            'SupportOptions',
            [
                'Standard' => 'supportOptions'
            ],
            // non-cacheable actions
            [
                'Standard' => 'supportOptions'
            ]
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'HGON.HgonDonation',
            'SupportOptionsLight',
            [
                'Standard' => 'supportOptionsLight'
            ],
            // non-cacheable actions
            [
                'Standard' => 'supportOptionsLight'
            ]
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'HGON.HgonDonation',
            'BecomeMemberForm',
            [
                'Form' => 'becomeMember'
            ],
            // non-cacheable actions
            [
                'Form' => 'becomeMember'
            ]
        );



        // Hook for Geodata and reservation cleanup on copy
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][$extKey] = 'HGON\\HgonDonation\\Hooks\\TceMainHooks';

        // caching
        if( !is_array($GLOBALS['TYPO3_CONF_VARS'] ['SYS']['caching']['cacheConfigurations'][$extKey] ) ) {
            $GLOBALS['TYPO3_CONF_VARS'] ['SYS']['caching']['cacheConfigurations'][$extKey] = array();
        }
        if( !isset($GLOBALS['TYPO3_CONF_VARS'] ['SYS']['caching']['cacheConfigurations'][$extKey]['frontend'] ) ) {
            $GLOBALS['TYPO3_CONF_VARS'] ['SYS']['caching']['cacheConfigurations'][$extKey]['frontend'] = 'TYPO3\\CMS\\Core\\Cache\\Frontend\\VariableFrontend';
        }
        if( !isset($GLOBALS['TYPO3_CONF_VARS'] ['SYS']['caching']['cacheConfigurations'][$extKey]['options'] ) ) {
            $GLOBALS['TYPO3_CONF_VARS'] ['SYS']['caching']['cacheConfigurations'][$extKey]['options'] = array('defaultLifetime' => 3600);
        }
        if( !isset($GLOBALS['TYPO3_CONF_VARS'] ['SYS']['caching']['cacheConfigurations'][$extKey]['groups'] ) ) {
            $GLOBALS['TYPO3_CONF_VARS'] ['SYS']['caching']['cacheConfigurations'][$extKey]['groups'] = array('pages');
        }
	},
	$_EXTKEY
);
