<?php
defined('TYPO3') or die("Access denied.");

call_user_func(
    function (string $extKey) {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'Listing',
            'HGON Donation: Allgemeine Geldspende'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'BankAccountSidebar',
            'HGON Donation: Bankdaten'
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

        $addFlexForm(
            $extensionName . '_bankaccountsidebar',
            'FILE:EXT:hgon_donation/Configuration/FlexForms/BankAccountSidebar.xml'
        );

    },
    'hgon_donation'
);
