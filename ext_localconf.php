<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
	function($extKey)
	{
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'HGON.HgonDonation',
            'Listing',
            [
                'Donation' => 'list'
                //'Donation' => 'list, show, new, create, edit, update, delete'
            ],
            // non-cacheable actions
            [
                'Donation' => 'list'
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



        // Hook for Geodata and reservation cleanup on copy
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][$extKey] = 'HGON\\HgonDonation\\Hooks\\TceMainHooks';

        // add to InstallTool options (otherwise the ajax calls will not work)
        $GLOBALS['TYPO3_CONF_VARS']['FE']['cacheHash']['excludedParameters'][] = 'tx_hgondonation_donate[action]';
        $GLOBALS['TYPO3_CONF_VARS']['FE']['cacheHash']['excludedParameters'][] = 'tx_hgondonation_donate[controller]';
        $GLOBALS['TYPO3_CONF_VARS']['FE']['cacheHash']['excludedParameters'][] = 'tx_hgondonation_donate[donationTypeTime]';

        $GLOBALS['TYPO3_CONF_VARS']['FE']['cacheHash']['excludedParameters'][] = 'tx_hgondonation_listing[action]';
        $GLOBALS['TYPO3_CONF_VARS']['FE']['cacheHash']['excludedParameters'][] = 'tx_hgondonation_listing[controller]';
        $GLOBALS['TYPO3_CONF_VARS']['FE']['cacheHash']['excludedParameters'][] = 'tx_hgondonation_listing[filter][type]';
        $GLOBALS['TYPO3_CONF_VARS']['FE']['cacheHash']['excludedParameters'][] = 'tx_hgondonation_listing[filter][time]';
	},
	$_EXTKEY
);
