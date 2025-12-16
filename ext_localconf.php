<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
	function($extKey)
	{
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'HGON.HgonDonation',
            'Listing',
            [
                \HGON\HgonDonation\Controller\DonationController::class => 'list, newMoney, createMoney, executeSepa'
            ],
            // non-cacheable actions
            [
                \HGON\HgonDonation\Controller\DonationController::class => 'list, newMoney, createMoney, executeSepa'
            ]
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'HGON.HgonDonation',
            'Detail',
            [
                \HGON\HgonDonation\Controller\DonationController::class => 'show, new, create, perform'
            ],
            // non-cacheable actions
            [
                \HGON\HgonDonation\Controller\DonationController::class => 'show, new, create, perform'
            ]
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'HGON.HgonDonation',
            'BankAccountSidebar',
            [
                \HGON\HgonDonation\Controller\DonationController::class => 'bankAccountSidebar'
            ],
            // non-cacheable actions
            [
                \HGON\HgonDonation\Controller\DonationController::class => ''
            ]
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'HGON.HgonDonation',
            'DonationProject',
            [
                \HGON\HgonDonation\Controller\DonationController::class => 'donationProject'
            ],
            // non-cacheable actions
            [
                \HGON\HgonDonation\Controller\DonationController::class => 'donationProject'
            ]
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'HGON.HgonDonation',
            'Header',
            [
                \HGON\HgonDonation\Controller\DonationController::class => 'header'
            ],
            // non-cacheable actions
            [
                \HGON\HgonDonation\Controller\DonationController::class => 'header'
            ]
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'HGON.HgonDonation',
            'Sidebar',
            [
                \HGON\HgonDonation\Controller\DonationController::class => 'sidebar'
            ],
            // non-cacheable actions
            [
                \HGON\HgonDonation\Controller\DonationController::class => 'sidebar'
            ]
        );

		\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
			'HGON.HgonDonation',
			'Donate',
			[
                \HGON\HgonDonation\Controller\StandardController::class => 'listDonationTime, newDonationTime, createDonationTime'
			],
			// non-cacheable actions
			[
                \HGON\HgonDonation\Controller\StandardController::class => 'listDonationTime, newDonationTime, createDonationTime'
			]
		);

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'HGON.HgonDonation',
            'SupportOptions',
            [
                \HGON\HgonDonation\Controller\StandardController::class => 'supportOptions'
            ],
            // non-cacheable actions
            [
                \HGON\HgonDonation\Controller\StandardController::class => 'supportOptions'
            ]
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'HGON.HgonDonation',
            'SupportOptionsLight',
            [
                \HGON\HgonDonation\Controller\StandardController::class => 'supportOptionsLight'
            ],
            // non-cacheable actions
            [
                \HGON\HgonDonation\Controller\StandardController::class => 'supportOptionsLight'
            ]
        );

        /*
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
        */



        // Hook for Geodata and reservation cleanup on copy
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][$extKey] = \HGON\HgonDonation\Hooks\TceMainHooks::class;

        // caching
        if( !is_array($GLOBALS['TYPO3_CONF_VARS'] ['SYS']['caching']['cacheConfigurations'][$extKey] ) ) {
            $GLOBALS['TYPO3_CONF_VARS'] ['SYS']['caching']['cacheConfigurations'][$extKey] = array();
        }
        if( !isset($GLOBALS['TYPO3_CONF_VARS'] ['SYS']['caching']['cacheConfigurations'][$extKey]['frontend'] ) ) {
            $GLOBALS['TYPO3_CONF_VARS'] ['SYS']['caching']['cacheConfigurations'][$extKey]['frontend'] = \TYPO3\CMS\Core\Cache\Frontend\VariableFrontend::class;
        }
        if( !isset($GLOBALS['TYPO3_CONF_VARS'] ['SYS']['caching']['cacheConfigurations'][$extKey]['options'] ) ) {
            $GLOBALS['TYPO3_CONF_VARS'] ['SYS']['caching']['cacheConfigurations'][$extKey]['options'] = array('defaultLifetime' => 3600);
        }
        if( !isset($GLOBALS['TYPO3_CONF_VARS'] ['SYS']['caching']['cacheConfigurations'][$extKey]['groups'] ) ) {
            $GLOBALS['TYPO3_CONF_VARS'] ['SYS']['caching']['cacheConfigurations'][$extKey]['groups'] = array('pages');
        }
	},
	'hgon_donation'
);
