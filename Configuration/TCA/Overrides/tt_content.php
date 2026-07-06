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

        // ProjectList is intentionally kept dormant until the project overview concept is approved.
        /*
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'ProjectList',
            'HGON Donation: Spendenprojekte Liste'
        );
        */

        // ProjectDetail is intentionally kept dormant until the project overview concept is approved.
        /*
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'ProjectDetail',
            'HGON Donation: Spendenprojekt Detail'
        );
        */

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'ProjectHeader',
            'HGON Donation: Spendenprojekt Header'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'ProjectSidebar',
            'HGON Donation: Spendenprojekt Sidebar'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'ProjectButton',
            'HGON Donation: Spendenprojekt Button'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'ProjectTeaser',
            'HGON Donation: Spendenprojekt Teaser'
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

        $addFlexForm(
            $extensionName . '_projectbutton',
            'FILE:EXT:hgon_donation/Configuration/FlexForms/Project.xml'
        );

        $addFlexForm(
            $extensionName . '_projectteaser',
            'FILE:EXT:hgon_donation/Configuration/FlexForms/Project.xml'
        );

    },
    'hgon_donation'
);
