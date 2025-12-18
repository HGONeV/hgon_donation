<?php
defined('TYPO3') or die("Access denied.");

call_user_func(
    function (string $extKey) {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'Listing',
            'HGON Donation: Liste (Zeit & Geldspenden)'
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
            'SupportOptions',
            'HGON Donation: Zeige Spenden-Optionen'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'SupportOptionsLight',
            'HGON Donation: Zeige Spenden-Optionen (Mitglied & Geld)'
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
        // Add Flexform
        //=================================================================
        $extensionName = strtolower(\TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($extKey));

        $pluginName = strtolower('SupportOptions');
        $pluginSignature = $extensionName.'_'.$pluginName;
        $TCA['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout,select_key,pages';
        $TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:'.$extKey . '/Configuration/FlexForms/SupportOptions.xml');

        $pluginName = strtolower('SupportOptionsLight');
        $pluginSignature = $extensionName.'_'.$pluginName;
        $TCA['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout,select_key,pages';
        $TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:'.$extKey . '/Configuration/FlexForms/SupportOptionsLight.xml');

        $pluginName = strtolower('BankAccountSidebar');
        $pluginSignature = $extensionName.'_'.$pluginName;
        $TCA['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout,select_key,pages';
        $TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:'.$extKey . '/Configuration/FlexForms/BankAccountSidebar.xml');

        $pluginName = strtolower('Listing');
        $pluginSignature = $extensionName.'_'.$pluginName;
        $TCA['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout,select_key,pages';
        $TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:'.$extKey . '/Configuration/FlexForms/Listing.xml');



    },
    'hgon_donation'
);

