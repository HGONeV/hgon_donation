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
                \HGON\HgonDonation\Controller\DonationController::class => 'newMoney, createMoney'
            ],
            // non-cacheable actions
            [
                \HGON\HgonDonation\Controller\DonationController::class => 'newMoney, createMoney'
            ],
            \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            $extKey,
            'BankAccountSidebar',
            [
                \HGON\HgonDonation\Controller\DonationController::class => 'bankAccountSidebar'
            ],
            [],
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
