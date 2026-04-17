<?php

defined('TYPO3') or die("Access denied.");

use TYPO3\CMS\Core\Cache\Frontend\VariableFrontend;

call_user_func(
	function($extKey)
	{
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            $extKey,
            'Listing',
            [
                \HGON\HgonDonation\Controller\DonationController::class => 'list, newMoney, createMoney'
            ],
            // non-cacheable actions
            [
                \HGON\HgonDonation\Controller\DonationController::class => 'list, newMoney, createMoney'
            ],
            \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            $extKey,
            'Detail',
            [
                \HGON\HgonDonation\Controller\DonationController::class => 'show'
            ],
            // non-cacheable actions
            [
                \HGON\HgonDonation\Controller\DonationController::class => 'show'
            ],
            \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            $extKey,
            'BankAccountSidebar',
            [
                \HGON\HgonDonation\Controller\DonationController::class => 'bankAccountSidebar'
            ],
            // non-cacheable actions
            [
                \HGON\HgonDonation\Controller\DonationController::class => ''
            ],
            \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            $extKey,
            'Header',
            [
                \HGON\HgonDonation\Controller\DonationController::class => 'header'
            ],
            // non-cacheable actions
            [
                \HGON\HgonDonation\Controller\DonationController::class => 'header'
            ],
            \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            $extKey,
            'Sidebar',
            [
                \HGON\HgonDonation\Controller\DonationController::class => 'sidebar'
            ],
            // non-cacheable actions
            [
                \HGON\HgonDonation\Controller\DonationController::class => 'sidebar'
            ],
            \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
        );

        /*
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            $extKey,
            'BecomeMemberForm',
            [
                'Form' => 'becomeMember'
            ],
            // non-cacheable actions
            [
                'Form' => 'becomeMember'
            ],
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
        );
        */



        // Hook for Geodata and reservation cleanup on copy
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][\TYPO3\CMS\Core\DataHandling\DataHandler::class]['processDatamapClass'][] = \HGON\HgonDonation\Hooks\TceMainHooks::class;

        // caching
        $cacheConfigurations =& $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'];
        if (!isset($cacheConfigurations[$extKey]) || !is_array($cacheConfigurations[$extKey])) {
            $cacheConfigurations[$extKey] = [];
        }
        $cacheConfigurations[$extKey]['frontend'] ??= VariableFrontend::class;
        $cacheConfigurations[$extKey]['options'] ??= ['defaultLifetime' => 3600];
        $cacheConfigurations[$extKey]['groups'] ??= ['pages'];

	},
	'hgon_donation'
);
