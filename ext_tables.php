<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
	function($extKey)
	{


		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_hgondonation_domain_model_donationtype', 'EXT:hgon_donation/Resources/Private/Language/locallang_csh_tx_hgondonation_domain_model_donationtype.xlf');
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_hgondonation_domain_model_donationtype');

		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_hgondonation_domain_model_donationtypetime', 'EXT:hgon_donation/Resources/Private/Language/locallang_csh_tx_hgondonation_domain_model_donationtypetime.xlf');
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_hgondonation_domain_model_donationtypetime');

		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_hgondonation_domain_model_donationtypemoney', 'EXT:hgon_donation/Resources/Private/Language/locallang_csh_tx_hgondonation_domain_model_donationtypemoney.xlf');
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_hgondonation_domain_model_donationtypemoney');

		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_hgondonation_domain_model_donationplace', 'EXT:hgon_donation/Resources/Private/Language/locallang_csh_tx_hgondonation_domain_model_donationplace.xlf');
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_hgondonation_domain_model_donationplace');

	},
    'hgon_donation'
);

