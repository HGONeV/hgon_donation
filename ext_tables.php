<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
	function($extKey)
	{
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'HGON.HgonDonation',
            'Listing',
            'HGON Donation: Liste (Zeit & Geldspenden)'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'HGON.HgonDonation',
            'Detail',
            'HGON Donation: Detailansicht'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'HGON.HgonDonation',
            'BankAccountSidebar',
            'HGON Donation: Bankdaten (Sidebar)'
        );

        /*
        // Reines Template-Plugin. Nicht im Backend anbieten.
		\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
			'HGON.HgonDonation',
			'Donate',
			'HGON Donation: Zeitspende (Ajax-Form)'
		);
        */

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'HGON.HgonDonation',
            'SupportOptions',
            'HGON Donation: Zeige Spenden-Optionen'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'HGON.HgonDonation',
            'SupportOptionsLight',
            'HGON Donation: Zeige Spenden-Optionen (Mitglied & Geld)'
        );

		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($extKey, 'Configuration/TypoScript', 'HGON Donation');

		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_hgondonation_domain_model_donationtype', 'EXT:hgon_donation/Resources/Private/Language/locallang_csh_tx_hgondonation_domain_model_donationtype.xlf');
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_hgondonation_domain_model_donationtype');

		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_hgondonation_domain_model_donationtypetime', 'EXT:hgon_donation/Resources/Private/Language/locallang_csh_tx_hgondonation_domain_model_donationtypetime.xlf');
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_hgondonation_domain_model_donationtypetime');

		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_hgondonation_domain_model_donationtypemoney', 'EXT:hgon_donation/Resources/Private/Language/locallang_csh_tx_hgondonation_domain_model_donationtypemoney.xlf');
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_hgondonation_domain_model_donationtypemoney');

		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_hgondonation_domain_model_donationplace', 'EXT:hgon_donation/Resources/Private/Language/locallang_csh_tx_hgondonation_domain_model_donationplace.xlf');
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_hgondonation_domain_model_donationplace');

	},
	$_EXTKEY
);

//=================================================================
// Add Flexform
//=================================================================
$extensionName = strtolower(\TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($_EXTKEY));

$pluginName = strtolower('SupportOptions');
$pluginSignature = $extensionName.'_'.$pluginName;
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout,select_key,pages';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:'.$_EXTKEY . '/Configuration/FlexForms/SupportOptions.xml');

$pluginName = strtolower('SupportOptionsLight');
$pluginSignature = $extensionName.'_'.$pluginName;
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout,select_key,pages';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:'.$_EXTKEY . '/Configuration/FlexForms/SupportOptionsLight.xml');
