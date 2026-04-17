<?php
defined('TYPO3') or die("Access denied.");

call_user_func(
    function (string $extKey) {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'Listing',
            'HGON Donation: Liste (Geldspenden)'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'Detail',
            'HGON Donation: Detailansicht'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'BankAccountSidebar',
            'HGON Donation: Bankdaten (Sidebar)'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'Header',
            'HGON Donation: Header'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'Sidebar',
            'HGON Donation: Sidebar'
        );

        //=================================================================
        // Add Flexform (CType)
        //=================================================================
        $extensionName = strtolower(\TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($extKey));
        $addFlexForm = static function (string $pluginSignature, string $flexFormFile): void {
            \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
                $pluginSignature,
                $flexFormFile,
                $pluginSignature
            );
            \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
                'tt_content',
                'pi_flexform',
                $pluginSignature,
                'after:header'
            );
        };

        $pluginName = strtolower('BankAccountSidebar');
        $pluginSignature = $extensionName.'_'.$pluginName;
        $addFlexForm($pluginSignature, 'FILE:EXT:'.$extKey . '/Configuration/FlexForms/BankAccountSidebar.xml');

        $pluginName = strtolower('Listing');
        $pluginSignature = $extensionName.'_'.$pluginName;
        $addFlexForm($pluginSignature, 'FILE:EXT:'.$extKey . '/Configuration/FlexForms/Listing.xml');



    },
    'hgon_donation'
);
